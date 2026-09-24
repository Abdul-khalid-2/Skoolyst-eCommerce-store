<?php
declare(strict_types=1);

/**
 * Minimal migration runner: applies pending .sql files from database/migrations
 * in filename order and records each one in a `migrations` table.
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
$files = glob($dir . '/*.sql');
sort($files);

$ran = 0;
foreach ($files as $file) {
    $name = basename($file);
    if (in_array($name, $applied, true)) {
        continue;
    }

    $sql = file_get_contents($file);
    $pdo->exec($sql);

    $stmt = $pdo->prepare('INSERT INTO store_migrations (migration) VALUES (:name)');
    $stmt->execute(['name' => $name]);

    echo "Migrated: {$name}\n";
    $ran++;
}

echo $ran === 0 ? "Nothing to migrate.\n" : "{$ran} migration(s) applied.\n";
