<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Model;

class Category extends Model {
    protected static string $table = 'store_categories';

    public static function withStoreCounts(): array {
        $sql = 'SELECT sc.*, COUNT(s.id) AS store_count
                FROM store_categories sc
                LEFT JOIN stores s ON s.category_id = sc.id AND s.status = "active"
                GROUP BY sc.id
                ORDER BY sc.name ASC';
        return static::db()->query($sql)->fetchAll();
    }
}
