<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Models\User;

/**
 * "Login with Google" — an independent Google OAuth2 client, separate from
 * (and not routed through) SkoolystAuthService. Each Skoolyst app manages
 * its own Google Cloud OAuth client directly with Google.
 *
 * Account linking never trusts an email match alone — see login() for the
 * exact rules (same shape as SkoolystAuthService, Google as the identity
 * source instead of skoolyst.com).
 */
class GoogleAuthService {
    private const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const USERINFO_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';

    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct() {
        $this->clientId = (string) config('google_auth.client_id');
        $this->clientSecret = (string) config('google_auth.client_secret');
        $this->redirectUri = (string) config('google_auth.redirect_uri');
    }

    /** Builds Google's consent-screen URL and stores a fresh CSRF state in the session. */
    public function authorizeUrl(): string {
        $state = bin2hex(random_bytes(16));
        $_SESSION['google_oauth_state'] = $state;

        $query = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return self::AUTH_URL . '?' . $query;
    }

    /**
     * Exchanges the authorization code for the user's Google profile, then
     * applies the account-linking rules.
     * @return array{status: 'success'|'error', message?: string}
     */
    public function login(string $code): array {
        $profile = $this->exchangeCode($code);
        if ($profile === null) {
            return ['status' => 'error', 'message' => 'Google login failed. Please try again.'];
        }

        $googleId = $profile['id'];
        $local = User::findByGoogleId($googleId);

        if (!$local) {
            $existing = User::findByEmail($profile['email']);

            if ($existing && !empty($existing['google_id']) && $existing['google_id'] !== $googleId) {
                return ['status' => 'error', 'message' => 'This email is already linked to a different Google account. Please sign in with your password instead.'];
            }

            if ($existing) {
                if (!$profile['email_verified']) {
                    return ['status' => 'error', 'message' => 'An account with this email already exists. Please sign in with your password instead.'];
                }
                // Google vouches the user controls this email — safe to link.
                User::updateById((int) $existing['id'], ['google_id' => $googleId]);
                $local = User::find((int) $existing['id']);
            } else {
                // First-time Google login: provision the same role a normal
                // self-signup gets (see AuthService::register).
                $id = User::insert([
                    'name' => $profile['name'],
                    'email' => $profile['email'],
                    'password' => password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT),
                    'role' => 'user',
                    'google_id' => $googleId,
                ]);
                $local = User::find($id);
                (new MailService())->sendWelcomeEmail($local['name'], $local['email']);
            }
        }

        unset($local['password']);
        $_SESSION['user'] = $local;
        session_regenerate_id();

        return ['status' => 'success'];
    }

    /** @return array{id: string, name: string, email: string, email_verified: bool}|null */
    private function exchangeCode(string $code): ?array {
        $ch = curl_init(self::TOKEN_URL);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'code' => $code,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'grant_type' => 'authorization_code',
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
        ]);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $tokenResponse = json_decode((string) $raw, true);

        if ($status !== 200 || empty($tokenResponse['access_token'])) {
            error_log(sprintf('GoogleAuthService: token exchange failed (HTTP %d): %s', $status, $curlError !== '' ? $curlError : (string) $raw));
            return null;
        }

        $ch = curl_init(self::USERINFO_URL);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $tokenResponse['access_token']],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
        ]);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $profile = json_decode((string) $raw, true);

        if ($status !== 200 || empty($profile['sub']) || empty($profile['email'])) {
            error_log('GoogleAuthService: userinfo fetch failed: ' . (string) $raw);
            return null;
        }

        return [
            'id' => (string) $profile['sub'],
            'name' => $profile['name'] ?? strstr($profile['email'], '@', true) ?: $profile['email'],
            'email' => strtolower(trim($profile['email'])),
            'email_verified' => (bool) ($profile['email_verified'] ?? false),
        ];
    }
}
