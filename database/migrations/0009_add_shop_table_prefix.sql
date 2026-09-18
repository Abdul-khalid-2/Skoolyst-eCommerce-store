-- Renames tables created by migrations 0001-0007 (before the shop_ prefix
-- convention was introduced) to their prefixed names. On a fresh install,
-- migrations 0001-0007 already create the prefixed tables directly, so this
-- migration only matters for databases that were migrated before 0009 was
-- added. Written as a single RENAME TABLE statement (comma-separated) since
-- the migration runner executes each file as one PDO::exec() call.

RENAME TABLE
  users TO shop_users,
  store_categories TO shop_store_categories,
  stores TO shop_stores,
  product_categories TO shop_product_categories,
  products TO shop_products,
  store_images TO shop_store_images,
  product_images TO shop_product_images;
