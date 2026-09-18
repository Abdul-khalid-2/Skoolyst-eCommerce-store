<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Core\Validator;
use Skoolyst\Models\User;

// Central authentication business logic. Keep controllers thin.
class AuthService {
    /** @return array<string,string> errors (empty on success) */
    public function register(array $data): array {
        $errors = Validator::make($data, [
            'name' => 'required|max:120',
            'email' => 'required|email|max:160',
            'password' => 'required|min:8',
        ]);

        if (empty($errors) && User::findByEmail($data['email'] ?? '') !== null) {
            $errors['email'] = 'An account with this email already exists.';
        }
        if (empty($errors) && ($data['password'] ?? '') !== ($data['confirmPassword'] ?? '')) {
            $errors['confirmPassword'] = 'Passwords do not match.';
        }

        if ($errors) {
            return $errors;
        }

        User::insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'user',
        ]);

        return [];
    }

    /** @return array<string,string> errors (empty on success) */
    public function attempt(string $email, string $password): array {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return ['email' => 'Invalid email or password.'];
        }

        unset($user['password']);
        $_SESSION['user'] = $user;
        session_regenerate_id();

        return [];
    }

    public function logout(): void {
        unset($_SESSION['user']);
    }
}
