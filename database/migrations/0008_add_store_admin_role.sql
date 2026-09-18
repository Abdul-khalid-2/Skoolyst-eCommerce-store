ALTER TABLE store_users
  MODIFY COLUMN role ENUM('admin','store_admin','user') NOT NULL DEFAULT 'user';
