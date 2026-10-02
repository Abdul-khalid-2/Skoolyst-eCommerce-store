<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Services\GoogleAuthService;

// "Login with Google" — independent of AuthController's email/password
// login and of SkoolystAuthController's Skoolyst SSO; sits alongside both.
class GoogleAuthController extends Controller {
    private GoogleAuthService $google;

    public function __construct() {
        $this->google = new GoogleAuthService();
    }

    public function redirect(): never {
        Response::redirect($this->google->authorizeUrl());
    }

    public function callback(): never {
        if ((string) Request::input('error', '') !== '') {
            flash('error', 'Google login was cancelled.');
            Response::redirect(url('login'));
        }

        $state = (string) Request::input('state', '');
        if ($state === '' || !hash_equals($_SESSION['google_oauth_state'] ?? '', $state)) {
            flash('error', 'Login session expired. Please try again.');
            Response::redirect(url('login'));
        }
        unset($_SESSION['google_oauth_state']);

        $result = $this->google->login((string) Request::input('code', ''));

        if ($result['status'] === 'error') {
            flash('error', $result['message']);
            Response::redirect(url('login'));
        }

        Response::redirect(url(match (auth_role()) {
            'admin' => 'admin/dashboard',
            'store_admin' => 'store/dashboard',
            default => '',
        }));
    }
}
