<?php
/** Vars from ProductController::show(): $product. */
$title = clean($product['name']) . ' — Skoolyst Store';
$description = product_meta_description($product);
$active = 'products';

$img = $product['image'] ?: 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=800';

$productSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product['name'],
    'image' => [$img],
    'description' => $product['description'] ?: ($product['name'] . ' — available at ' . $product['store_name'] . ' on Skoolyst Store.'),
    'sku' => (string) $product['id'],
    'offers' => [
        '@type' => 'Offer',
        'url' => url('products/' . $product['slug']),
        'priceCurrency' => 'PKR',
        'price' => number_format((float) ($product['sale_price'] ?: $product['price']), 2, '.', ''),
        'availability' => $product['stock'] > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'seller' => [
            '@type' => 'Organization',
            'name' => $product['store_name'],
        ],
    ],
];

ob_start();
?>
<script type="application/ld+json"><?= json_encode($productSchema, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?></script>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('products') ?>">Products</a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= clean($product['name']) ?></li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="gallery-main"><img src="<?= clean($img) ?>" alt="<?= clean($product['name']) ?>"></div>
      </div>
      <div class="col-lg-6">
        <h1 class="mb-2"><?= clean($product['name']) ?></h1>
        <div class="d-flex align-items-baseline gap-3 mb-3">
          <?php if (!empty($product['sale_price'])): ?>
            <span class="product-price" style="font-size:2rem">Rs. <?= number_format((float) $product['sale_price']) ?></span>
            <span class="product-old-price">Rs. <?= number_format((float) $product['price']) ?></span>
          <?php else: ?>
            <span class="product-price" style="font-size:2rem">Rs. <?= number_format((float) $product['price']) ?></span>
          <?php endif; ?>
        </div>
        <?php if ($product['description']): ?><p class="text-muted mb-3"><?= clean($product['description']) ?></p><?php endif; ?>
        <div class="mb-4">
          <span class="small <?= $product['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
            <i class="bi bi-<?= $product['stock'] > 0 ? 'check-circle-fill' : 'x-circle-fill' ?>"></i>
            <?= $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
          </span>
        </div>
        <?php $isFav = is_favorited((int) $product['id']); ?>
        <div class="d-flex align-items-center gap-2 mb-4">
          <div class="quantity-selector">
            <button data-qty-btn="minus" aria-label="Decrease">−</button>
            <input type="text" value="1" data-qty aria-label="Quantity" readonly>
            <button data-qty-btn="plus" aria-label="Increase">+</button>
          </div>
          <button type="button" class="btn btn-navy flex-grow-1" data-add-cart data-id="<?= (int) $product['id'] ?>" <?= $product['stock'] > 0 ? '' : 'disabled' ?>>
            <i class="bi bi-cart-plus me-2"></i><?= $product['stock'] > 0 ? 'Add to Cart' : 'Out of Stock' ?>
          </button>
          <button type="button" class="btn btn-outline-navy favorite-toggle-btn-inline<?= $isFav ? ' active' : '' ?>" data-favorite-toggle data-id="<?= (int) $product['id'] ?>" aria-label="<?= $isFav ? 'Remove from favorites' : 'Add to favorites' ?>">
            <i class="bi bi-heart<?= $isFav ? '-fill' : '' ?>"></i>
          </button>
        </div>
        <div class="card">
          <div class="card-body d-flex align-items-center gap-3 flex-wrap">
            <div class="flex-grow-1">
              <h6 class="mb-0"><?= clean($product['store_name']) ?></h6>
              <div class="small text-muted">Sold by this store</div>
            </div>
            <a href="<?= url('stores/' . $product['store_slug']) ?>" class="btn btn-outline-navy btn-sm">View Store</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
