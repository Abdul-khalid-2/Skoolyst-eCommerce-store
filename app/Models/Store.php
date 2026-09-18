<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class Store extends Model {
    protected static string $table = 'store_stores';

    public static function findByUserId(int $userId): ?array {
        $stmt = static::db()->prepare(
            'SELECT s.*, sc.name AS category_name FROM store_stores s
             LEFT JOIN store_store_categories sc ON sc.id = s.category_id
             WHERE s.user_id = :user_id LIMIT 1'
        );
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /**
     * Filtered, paginated store search. $filters may contain:
     * q (name search), city, category_id, store_type, verified_only.
     * Returns ['rows' => array, 'total' => int].
     */
    public static function search(array $filters, int $page, int $perPage): array {
        [$where, $params] = self::buildWhere($filters);

        $countStmt = static::db()->prepare("SELECT COUNT(*) FROM store_stores s {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = paginate_offset($page, $perPage);
        $sql = "SELECT s.*, sc.name AS category_name
                FROM store_stores s
                LEFT JOIN store_store_categories sc ON sc.id = s.category_id
                {$where}
                ORDER BY s.rating DESC, s.id DESC
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

    public static function featured(int $limit = 4): array {
        $stmt = static::db()->prepare(
            'SELECT * FROM store_stores WHERE status = "active" ORDER BY rating DESC, id DESC LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findActiveBySlug(string $slug): ?array {
        $stmt = static::db()->prepare(
            'SELECT s.*, sc.name AS category_name FROM store_stores s
             LEFT JOIN store_store_categories sc ON sc.id = s.category_id
             WHERE s.slug = :slug AND s.status = "active" LIMIT 1'
        );
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public static function countByStatus(string $status): int {
        return static::count('status = :status', ['status' => $status]);
    }

    private static function buildWhere(array $filters): array {
        $conditions = [];
        $params = [];

        if (!empty($filters['q'])) {
            $conditions[] = 's.name LIKE :q';
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['city'])) {
            $conditions[] = 's.city = :city';
            $params['city'] = $filters['city'];
        }
        if (!empty($filters['category_id'])) {
            $conditions[] = 's.category_id = :category_id';
            $params['category_id'] = $filters['category_id'];
        }
        if (!empty($filters['store_type'])) {
            $conditions[] = 's.store_type = :store_type';
            $params['store_type'] = $filters['store_type'];
        }
        if (!empty($filters['verified_only'])) {
            $conditions[] = 's.verified = 1';
        }
        if (!empty($filters['status'])) {
            $conditions[] = 's.status = :status';
            $params['status'] = $filters['status'];
        } elseif (empty($filters['include_all_statuses'])) {
            $conditions[] = 's.status = "active"';
        }

        $where = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';
        return [$where, $params];
    }
}
