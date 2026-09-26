<?php
return [
    'up' => "CREATE TABLE IF NOT EXISTS store_reviews (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        store_id INT UNSIGNED NOT NULL,
        user_id INT UNSIGNED DEFAULT NULL,
        rating TINYINT UNSIGNED NOT NULL,
        title VARCHAR(160) DEFAULT NULL,
        comment TEXT,
        status ENUM('active','pending','inactive') NOT NULL DEFAULT 'pending',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_reviews_store (store_id),
        KEY idx_reviews_user (user_id),
        KEY idx_reviews_status (status),
        CONSTRAINT fk_reviews_store FOREIGN KEY (store_id) REFERENCES store_stores(id) ON DELETE CASCADE,
        CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES store_users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    'down' => 'DROP TABLE IF EXISTS store_reviews',
];
