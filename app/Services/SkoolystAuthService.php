<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Models\User;

/**
 * "Login with Skoolyst" SSO client (OAuth2 Authorization Code flow).
 * skoolyst.com is the central identity provider for the Skoolyst family of
 * apps — this service builds the /oauth/authorize redirect, exchanges the
 * returned code for the user's identity, and finds-or-creates/links the
 * matching local account.
 *
 * Account linking never trusts an email match alone (that would let anyone
 * who registers an *unverified* email on skoolyst.com sign in as an
 * existing local user here) — see login() for the exact rules.
 */
class SkoolystAuthService {
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct() {
        $this->baseUrl = rtrim((string) config('skoolyst_auth.base_url'), '/');
        $this->clientId = (string) config('skoolyst_auth.client_id');
        $this->clientSecret = (string) config('skoolyst_auth.client_secret');
        $this->redirectUri = (string) config('skoolyst_auth.redirect_uri');
    }

    /** Builds the /oauth/authorize URL and stores a fresh CSRF state in the session. */
    public function authorizeUrl(): string {
        return $this->baseUrl . '/oauth/authorize?' . $this->authParams();
    }

    /**
     * Builds the /oauth/verify-required URL — used instead of a dead-end
     * error when an existing local account's email isn't verified yet on
     * skoolyst.com (see login()'s 'verify_required' status).
     */
    public function verifyRequiredUrl(): string {
        return $this->baseUrl . '/oauth/verify-required?' . $this->authParams();
    }

    /**
     * Exchanges the authorization code for the user's identity, then
     * applies the account-linking rules.
     * @return array{status: 'success'|'verify_required'|'error', message?: string}
     */
    public function login(string $code): array {
        $exchange = $this->exchangeCode($code);
        if ($exchange === null) {
            return ['status' => 'error', 'message' => 'Skoolyst login failed. Please try again.'];
        }

        $ssoUser = $exchange['user'];
        $skoolystId = (int) $ssoUser['id'];

        $local = User::findBySkoolystId($skoolystId);

        if (!$local) {
            $existing = User::findByEmail($ssoUser['email']);

            if ($existing && !empty($existing['skoolyst_id']) && (int) $existing['skoolyst_id'] !== $skoolystId) {
                return ['status' => 'error', 'message' => 'This email is already linked to a different Skoolyst account. Please sign in with your password instead.'];
            }

            if ($existing) {
                if (empty($ssoUser['email_verified'])) {
                    return ['status' => 'verify_required'];
                }
                // skoolyst.com vouches the user controls this email — safe to link.
                User::updateById((int) $existing['id'], ['skoolyst_id' => $skoolystId]);
                $local = User::find((int) $existing['id']);
            } else {
                // First-time SSO login: provision the same role a normal
                // self-signup gets (see AuthService::register).
                $id = User::insert([
                    'name' => $ssoUser['name'],
                    'email' => $ssoUser['email'],
                    'password' => password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT),
                    'role' => 'user',
                    'skoolyst_id' => $skoolystId,
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

    private function authParams(): string {
        $state = bin2hex(random_bytes(16));
        $_SESSION['skoolyst_oauth_state'] = $state;

        return http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
        ]);
    }

    /** @return array{user: array, access_token: string}|null */
    private function exchangeCode(string $code): ?array {
        $ch = curl_init($this->baseUrl . '/api/oauth/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
        ]);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $response = json_decode((string) $raw, true);

        if ($status !== 201 || empty($response['success'])) {
            error_log(sprintf('SkoolystAuthService: token exchange failed (HTTP %d): %s', $status, $curlError !== '' ? $curlError : (string) $raw));
            return null;
        }

        return $response['data'];
    }
}
