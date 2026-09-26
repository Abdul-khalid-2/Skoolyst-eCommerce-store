<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class Review extends Model {
    protected static string $table = 'store_reviews';

    /**
     * Filtered, paginated review search. $filters may contain:
     * store_id, status, include_all_statuses.
     */
    public static function search(array $filters, int $page, int $perPage): array {
        [$where, $params] = self::buildWhere($filters);

        $countStmt = static::db()->prepare("SELECT COUNT(*) FROM store_reviews r JOIN store_stores s ON s.id = r.store_id {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = paginate_offset($page, $perPage);
        $sql = "SELECT r.*, s.name AS store_name, u.name AS user_name
                FROM store_reviews r
                JOIN store_stores s ON s.id = r.store_id
                LEFT JOIN store_users u ON u.id = r.user_id
                {$where}
                ORDER BY r.id DESC
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

    /** Active (approved) reviews for a store's public page, newest first. */
    public static function activeByStore(int $storeId): array {
        $stmt = static::db()->prepare(
            "SELECT r.*, u.name AS user_name FROM store_reviews r
             LEFT JOIN store_users u ON u.id = r.user_id
             WHERE r.store_id = :store_id AND r.status = 'active'
             ORDER BY r.id DESC"
        );
        $stmt->execute(['store_id' => $storeId]);
        return $stmt->fetchAll();
    }

    private static function buildWhere(array $filters): array {
        $conditions = [];
        $params = [];

        if (!empty($filters['store_id'])) {
            $conditions[] = 'r.store_id = :store_id';
            $params['store_id'] = $filters['store_id'];
        }
        if (!empty($filters['status'])) {
            $conditions[] = 'r.status = :status';
            $params['status'] = $filters['status'];
        } elseif (empty($filters['include_all_statuses'])) {
            $conditions[] = "r.status = 'active'";
        }

        $where = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';
        return [$where, $params];
    }
}
