<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class OrderItem extends Model {
    protected static string $table = 'store_order_items';

    /** Every item on the order, tagged with which store it belongs to — used by the admin order view. */
    public static function byOrderId(int $orderId): array {
        $stmt = static::db()->prepare(
            'SELECT oi.*, s.name AS store_name, s.slug AS store_slug
             FROM store_order_items oi
             LEFT JOIN store_stores s ON s.id = oi.store_id
             WHERE oi.order_id = :order_id ORDER BY oi.id ASC'
        );
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    /** Only the items on this order that belong to $storeId — what a store owner is allowed to see. */
    public static function byOrderAndStore(int $orderId, int $storeId): array {
        $stmt = static::db()->prepare(
            'SELECT * FROM store_order_items WHERE order_id = :order_id AND store_id = :store_id ORDER BY id ASC'
        );
        $stmt->execute(['order_id' => $orderId, 'store_id' => $storeId]);
        return $stmt->fetchAll();
    }
}
