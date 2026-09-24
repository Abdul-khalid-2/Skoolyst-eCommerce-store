<?php
return [
    'up' => "ALTER TABLE store_users
        MODIFY COLUMN role ENUM('admin','store_admin','user') NOT NULL DEFAULT 'user'",
    'down' => "ALTER TABLE store_users
        MODIFY COLUMN role ENUM('admin','user') NOT NULL DEFAULT 'user'",
];
