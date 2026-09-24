<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class Order extends Model {
    protected static string $table = 'store_orders';

    public static function findByOrderNumber(string $orderNumber): ?array {
        $stmt = static::db()->prepare('SELECT * FROM store_orders WHERE order_number = :order_number LIMIT 1');
        $stmt->execute(['order_number' => $orderNumber]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /** All orders, with a total item count, for the admin order list. */
    public static function paginateForAdmin(array $filters, int $page, int $perPage): array {
        $conditions = [];
        $params = [];

        if (!empty($filters['status'])) {
            $conditions[] = 'status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['q'])) {
            $conditions[] = '(order_number LIKE :q OR full_name LIKE :q OR phone LIKE :q)';
            $params['q'] = '%' . $filters['q'] . '%';
        }
        $where = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';

        $countStmt = static::db()->prepare("SELECT COUNT(*) FROM store_orders {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = paginate_offset($page, $perPage);
        $sql = "SELECT o.*, (SELECT COUNT(*) FROM store_order_items oi WHERE oi.order_id = o.id) AS item_count
                FROM store_orders o
                {$where}
                ORDER BY o.id DESC
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

    /**
     * Orders that contain at least one item belonging to $storeId, with the
     * item count and subtotal scoped to that store's own items only —
     * never the whole order, since other stores' items aren't this store's business.
     */
    public static function paginateForStore(int $storeId, array $filters, int $page, int $perPage): array {
        $conditions = ['oi.store_id = :store_id'];
        $params = ['store_id' => $storeId];

        if (!empty($filters['status'])) {
            $conditions[] = 'o.status = :status';
            $params['status'] = $filters['status'];
        }
        $where = 'WHERE ' . implode(' AND ', $conditions);

        $countStmt = static::db()->prepare(
            "SELECT COUNT(DISTINCT o.id) FROM store_orders o JOIN store_order_items oi ON oi.order_id = o.id {$where}"
        );
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = paginate_offset($page, $perPage);
        $sql = "SELECT o.id, o.order_number, o.full_name, o.phone, o.city, o.status, o.created_at,
                       COUNT(oi.id) AS item_count, SUM(oi.line_total) AS store_subtotal
                FROM store_orders o
                JOIN store_order_items oi ON oi.order_id = o.id
                {$where}
                GROUP BY o.id
                ORDER BY o.id DESC
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
}
