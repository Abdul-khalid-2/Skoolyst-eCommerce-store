-- Fixes databases that were briefly migrated with a shop_ prefix (an
-- earlier version of 0009, before the prefix was changed to store_) by
-- renaming those tables to their final store_ prefixed names. Fresh
-- installs never create shop_* tables (0001-0007 create store_* tables
-- directly), so this migration only matters for the one database that
-- ran the old shop_-prefixed 0009.

RENAME TABLE
  shop_users TO store_users,
  shop_store_categories TO store_store_categories,
  shop_stores TO store_stores,
  shop_product_categories TO store_product_categories,
  shop_products TO store_products,
  shop_store_images TO store_store_images,
  shop_product_images TO store_product_images;
