<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Services\SkoolystAuthService;

// "Login with Skoolyst" SSO entry points — sits alongside the normal
// email/password login (AuthController), not a replacement for it.
class SkoolystAuthController extends Controller {
    private SkoolystAuthService $skoolyst;

    public function __construct() {
        $this->skoolyst = new SkoolystAuthService();
    }

    public function redirect(): never {
        Response::redirect($this->skoolyst->authorizeUrl());
    }

    public function callback(): never {
        if ((string) Request::input('error', '') !== '') {
            flash('error', 'Skoolyst login was cancelled.');
            Response::redirect(url('login'));
        }

        $state = (string) Request::input('state', '');
        if ($state === '' || !hash_equals($_SESSION['skoolyst_oauth_state'] ?? '', $state)) {
            flash('error', 'Login session expired. Please try again.');
            Response::redirect(url('login'));
        }
        unset($_SESSION['skoolyst_oauth_state']);

        $result = $this->skoolyst->login((string) Request::input('code', ''));

        if ($result['status'] === 'verify_required') {
            Response::redirect($this->skoolyst->verifyRequiredUrl());
        }

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
