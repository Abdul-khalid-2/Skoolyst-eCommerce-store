<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class Product extends Model {
    protected static string $table = 'store_products';

    /**
     * Filtered, paginated product search. $filters may contain:
     * q, category_id, store_id, status.
     */
    public static function search(array $filters, int $page, int $perPage): array {
        [$where, $params] = self::buildWhere($filters);

        $countStmt = static::db()->prepare("SELECT COUNT(*) FROM store_products p {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = paginate_offset($page, $perPage);
        $sql = "SELECT p.*, s.name AS store_name, s.slug AS store_slug
                FROM store_products p
                JOIN store_stores s ON s.id = p.store_id
                {$where}
                ORDER BY p.id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = static::db()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return ['rows' => $stmt->fetchAll(), 'total' => $total];
    }

    public static function findActiveBySlug(string $slug): ?array {
        $stmt = static::db()->prepare(
            'SELECT p.*, s.name AS store_name, s.slug AS store_slug FROM store_products p
             JOIN store_stores s ON s.id = p.store_id
             WHERE p.slug = :slug AND p.status = "active" LIMIT 1'
        );
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public static function findActiveById(int $id): ?array {
        $stmt = static::db()->prepare(
            'SELECT p.*, s.name AS store_name, s.slug AS store_slug FROM store_products p
             JOIN store_stores s ON s.id = p.store_id
             WHERE p.id = :id AND p.status = "active" LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public static function byStore(int $storeId): array {
        $stmt = static::db()->prepare('SELECT * FROM store_products WHERE store_id = :store_id ORDER BY id DESC');
        $stmt->execute(['store_id' => $storeId]);
        return $stmt->fetchAll();
    }

    private static function buildWhere(array $filters): array {
        $conditions = [];
        $params = [];

        if (!empty($filters['q'])) {
            $conditions[] = 'p.name LIKE :q';
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['category_id'])) {
            $conditions[] = 'p.category_id = :category_id';
            $params['category_id'] = $filters['category_id'];
        }
        if (!empty($filters['store_id'])) {
            $conditions[] = 'p.store_id = :store_id';
            $params['store_id'] = $filters['store_id'];
        }
        if (!empty($filters['status'])) {
            $conditions[] = 'p.status = :status';
            $params['status'] = $filters['status'];
        } elseif (empty($filters['include_all_statuses'])) {
            $conditions[] = 'p.status = "active"';
        }

        $where = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';
        return [$where, $params];
    }
}
