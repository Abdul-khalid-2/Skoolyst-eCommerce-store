<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Services\AuthService;

// Authentication UI/API entry points: login, logout, register, password flows.
class AuthController extends Controller {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function loginForm(): mixed {
        return $this->view('auth/login');
    }

    public function login(): mixed {
        csrf_verify_or_abort();

        $errors = $this->auth->attempt(
            (string) Request::input('email', ''),
            (string) Request::input('password', '')
        );

        if ($errors) {
            return $this->view('auth/login', ['errors' => $errors]);
        }

        Response::redirect(url('admin/dashboard'));
    }

    public function registerForm(): mixed {
        return $this->view('auth/register');
    }

    public function register(): mixed {
        csrf_verify_or_abort();

        $data = Request::all();
        $errors = $this->auth->register($data);

        if ($errors) {
            return $this->view('auth/register', ['errors' => $errors, 'old' => $data]);
        }

        flash('success', 'Account created. You can now log in.');
        Response::redirect(url('login'));
    }

    public function logout(): never {
        $this->auth->logout();
        Response::redirect(url('login'));
    }
}
