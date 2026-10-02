<?php
return [
    'up' => "ALTER TABLE store_users
        ADD COLUMN google_id VARCHAR(64) DEFAULT NULL AFTER skoolyst_id,
        ADD UNIQUE KEY uq_users_google_id (google_id)",
    'down' => "ALTER TABLE store_users
        DROP INDEX uq_users_google_id,
        DROP COLUMN google_id",
];
