<?php
/** Vars from ProductController::show(): $product. */
$title = clean($product['name']) . ' — Skoolyst Store';
$description = 'Available at ' . $product['store_name'] . '. Rs. ' . number_format((float) $product['price']) . '.';
$active = 'products';

$img = $product['image'] ?: 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=800';

ob_start();
?>
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
