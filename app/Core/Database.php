<?php
declare(strict_types=1);

namespace Skoolyst\Core;

use PDO;

class Database {
    private static ?PDO $connection = null;

    public static function connection(): PDO {
        if (!self::$connection) {
            $config = config('database');
            self::$connection = new PDO(
                'mysql:host=' . $config['host'] .
                ';port=' . $config['port'] .
                ';dbname=' . $config['database'] . ';charset=' . $config['charset'],
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
        return self::$connection;
    }
}
