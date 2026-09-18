<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

// Shared user model. Authentication/user data should remain compatible across modules.
class User extends Model {
    protected static string $table = 'shop_users';

    public static function findByEmail(string $email): ?array {
        $stmt = static::db()->prepare('SELECT * FROM shop_users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }
}
