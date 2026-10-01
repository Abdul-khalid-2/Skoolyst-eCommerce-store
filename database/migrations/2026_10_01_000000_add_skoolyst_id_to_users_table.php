<?php
return [
    'up' => "ALTER TABLE store_users
        ADD COLUMN skoolyst_id BIGINT UNSIGNED DEFAULT NULL AFTER role,
        ADD UNIQUE KEY uq_users_skoolyst_id (skoolyst_id)",
    'down' => "ALTER TABLE store_users
        DROP INDEX uq_users_skoolyst_id,
        DROP COLUMN skoolyst_id",
];
