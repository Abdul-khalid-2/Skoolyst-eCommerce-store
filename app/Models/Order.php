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
}
