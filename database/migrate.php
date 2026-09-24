<?php
declare(strict_types=1);

/**
 * Minimal migration runner: applies pending .php files from database/migrations
 * (each returning ['up' => sql|callable, 'down' => sql|callable]) in filename
 * order and records each one in the `store_migrations` table. 'up'/'down' may
 * be a raw SQL string, or a callable(PDO $pdo) when the migration needs
 * conditional logic (e.g. checking whether a table already exists).
 * Usage: php database/migrate.php
 */
require dirname(__DIR__) . '/bootstrap/app.php';

use Skoolyst\Core\Database;

$pdo = Database::connection();

$pdo->exec("CREATE TABLE IF NOT EXISTS store_migrations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  migration VARCHAR(180) NOT NULL,
  applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_migrations_name (migration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$applied = $pdo->query('SELECT migration FROM store_migrations')->fetchAll(PDO::FETCH_COLUMN);

$dir = __DIR__ . '/migrations';
$files = glob($dir . '/*.php');
sort($files);

$ran = 0;
foreach ($files as $file) {
    $name = basename($file);
    if (in_array($name, $applied, true)) {
        continue;
    }

    $migration = require $file;
    $up = $migration['up'];
    is_callable($up) ? $up($pdo) : $pdo->exec($up);

    $stmt = $pdo->prepare('INSERT INTO store_migrations (migration) VALUES (:name)');
    $stmt->execute(['name' => $name]);

    echo "Migrated: {$name}\n";
    $ran++;
}

echo $ran === 0 ? "Nothing to migrate.\n" : "{$ran} migration(s) applied.\n";
