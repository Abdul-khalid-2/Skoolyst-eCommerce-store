<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class OrderItem extends Model {
    protected static string $table = 'store_order_items';

    public static function byOrderId(int $orderId): array {
        $stmt = static::db()->prepare('SELECT * FROM store_order_items WHERE order_id = :order_id ORDER BY id ASC');
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }
}
