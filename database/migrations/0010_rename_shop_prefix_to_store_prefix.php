<?php
// Fixes databases that were briefly migrated with a shop_ prefix (an
// earlier version of 0009, before the prefix was changed to store_) by
// renaming those tables to their final store_ prefixed names. Fresh
// installs never create shop_* tables, so this migration only matters
// for the one database that ran the old shop_-prefixed 0009 — guarded
// here so it's a no-op everywhere else.
return [
    'up' => function (PDO $pdo) {
        $exists = $pdo->query("SHOW TABLES LIKE 'shop_users'")->fetchColumn();
        if (!$exists) {
            return;
        }
        $pdo->exec("RENAME TABLE
            shop_users TO store_users,
            shop_store_categories TO store_store_categories,
            shop_stores TO store_stores,
            shop_product_categories TO store_product_categories,
            shop_products TO store_products,
            shop_store_images TO store_store_images,
            shop_product_images TO store_product_images");
    },
    'down' => "RENAME TABLE
        store_users TO shop_users,
        store_store_categories TO shop_store_categories,
        store_stores TO shop_stores,
        store_product_categories TO shop_product_categories,
        store_products TO shop_products,
        store_store_images TO shop_store_images,
        store_product_images TO shop_product_images",
];
