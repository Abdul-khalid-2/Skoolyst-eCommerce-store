<?php
// Renames tables created by migrations 0001-0007 (before the store_ prefix
// convention was introduced) to their prefixed names. On a fresh install,
// migrations 0001-0007 already create the prefixed tables directly, so this
// migration only matters for databases that were migrated before 0009 was
// added — guarded here so it's a no-op on a fresh install.
return [
    'up' => function (PDO $pdo) {
        $exists = $pdo->query("SHOW TABLES LIKE 'users'")->fetchColumn();
        if (!$exists) {
            return;
        }
        $pdo->exec("RENAME TABLE
            users TO store_users,
            store_categories TO store_store_categories,
            stores TO store_stores,
            product_categories TO store_product_categories,
            products TO store_products,
            store_images TO store_store_images,
            product_images TO store_product_images");
    },
    'down' => "RENAME TABLE
        store_users TO users,
        store_store_categories TO store_categories,
        store_stores TO stores,
        store_product_categories TO product_categories,
        store_products TO products,
        store_store_images TO store_images,
        store_product_images TO product_images",
];
