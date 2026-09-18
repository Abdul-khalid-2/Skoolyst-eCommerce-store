<?php
declare(strict_types=1);

namespace Skoolyst\Core;

use PDO;

abstract class Model {
    protected static string $table = '';
    protected static string $primaryKey = 'id';

    protected static function db(): PDO {
        return Database::connection();
    }

    public static function find(int $id): ?array {
        $stmt = static::db()->prepare('SELECT * FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public static function findBySlug(string $slug): ?array {
        $stmt = static::db()->prepare('SELECT * FROM ' . static::$table . ' WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public static function all(string $orderBy = 'id DESC'): array {
        return static::db()->query('SELECT * FROM ' . static::$table . ' ORDER BY ' . $orderBy)->fetchAll();
    }

    public static function insert(array $data): int {
        $cols = array_keys($data);
        $sql = 'INSERT INTO ' . static::$table . ' (' . implode(', ', $cols) . ') VALUES ('
            . implode(', ', array_map(fn ($c) => ":{$c}", $cols)) . ')';
        static::db()->prepare($sql)->execute($data);
        return (int) static::db()->lastInsertId();
    }

    public static function updateById(int $id, array $data): bool {
        $sets = implode(', ', array_map(fn ($c) => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        $stmt = static::db()->prepare('UPDATE ' . static::$table . " SET {$sets} WHERE " . static::$primaryKey . ' = :id');
        return $stmt->execute($data);
    }

    public static function deleteById(int $id): bool {
        $stmt = static::db()->prepare('DELETE FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function count(string $where = '1', array $params = []): int {
        $stmt = static::db()->prepare('SELECT COUNT(*) FROM ' . static::$table . " WHERE {$where}");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public static function slugExists(string $slug, ?int $exceptId = null): bool {
        $sql = 'SELECT COUNT(*) FROM ' . static::$table . ' WHERE slug = :slug';
        $params = ['slug' => $slug];
        if ($exceptId !== null) {
            $sql .= ' AND ' . static::$primaryKey . ' != :id';
            $params['id'] = $exceptId;
        }
        $stmt = static::db()->prepare($sql);
        $stmt->execute($params);
        return ((int) $stmt->fetchColumn()) > 0;
    }
}
