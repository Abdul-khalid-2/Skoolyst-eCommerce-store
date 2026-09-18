CREATE TABLE IF NOT EXISTS store_order_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED DEFAULT NULL,
  store_id INT UNSIGNED DEFAULT NULL,
  product_name VARCHAR(180) NOT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  qty INT UNSIGNED NOT NULL DEFAULT 1,
  line_total DECIMAL(10,2) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_order_items_order (order_id),
  CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES store_orders(id) ON DELETE CASCADE,
  CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES store_products(id) ON DELETE SET NULL,
  CONSTRAINT fk_order_items_store FOREIGN KEY (store_id) REFERENCES store_stores(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
