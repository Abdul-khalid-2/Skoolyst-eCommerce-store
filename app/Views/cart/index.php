<?php
/** Vars from CartController::index(): $items, $subtotal, $deliveryFee, $total. */
$title = 'Shopping Cart — Skoolyst Store';
$description = 'Your shopping cart on Skoolyst Store.';
$active = 'products';
$robots = 'noindex, follow';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <h1 class="mb-4">Shopping Cart</h1>
    <?php if (!$items): ?>
      <?= skoolyst_empty_state(
          'bi-bag-x',
          'Your cart is empty',
          "Looks like you haven't added any products yet. Browse our stores and find everything your student needs.",
          skoolyst_btn('Browse Products', ['variant' => 'navy', 'icon' => 'bi-bag', 'href' => url('products')])
      ) ?>
    <?php else: ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="d-flex flex-column gap-3">
          <?php foreach ($items as $item): ?>
          <div class="cart-item">
            <div class="cart-item-img"><img src="<?= clean(media_url($item['image'], 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=200')) ?>" alt="<?= clean($item['name']) ?>"></div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <a href="<?= url('products/' . $item['slug']) ?>" class="text-decoration-none"><h6 class="mb-0"><?= clean($item['name']) ?></h6></a>
                  <div class="small text-muted mt-1"><i class="bi bi-shop"></i> <?= clean($item['store_name'] ?: 'Store') ?></div>
                </div>
                <form method="post" action="<?= url('cart/remove/' . $item['product_id']) ?>">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm text-danger p-1" aria-label="Remove item"><i class="bi bi-trash"></i></button>
                </form>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
                <form method="post" action="<?= url('cart/update') ?>" class="d-flex align-items-center gap-2">
                  <?= csrf_field() ?>
                  <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                  <div class="quantity-selector">
                    <button type="button" data-qty-btn="minus" aria-label="Decrease">−</button>
                    <input type="text" name="qty" value="<?= $item['qty'] ?>" data-qty aria-label="Quantity" readonly>
                    <button type="button" data-qty-btn="plus" aria-label="Increase">+</button>
                  </div>
                  <button type="submit" class="btn btn-sm btn-outline-navy">Update</button>
                </form>
                <div class="text-end"><div class="fw-bold text-navy">Rs. <?= number_format($item['line_total']) ?></div>
                  <div class="small text-muted">Rs. <?= number_format($item['price']) ?> each</div></div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="mt-3"><a href="<?= url('products') ?>" class="btn btn-outline-navy"><i class="bi bi-arrow-left me-2"></i>Continue Shopping</a></div>
      </div>
      <div class="col-lg-4">
        <div class="order-summary sticky-top" style="top:80px">
          <h5 class="mb-3">Order Summary</h5>
          <div class="summary-row"><span class="text-muted">Subtotal (<?= array_sum(array_column($items, 'qty')) ?> items)</span><span class="fw-semibold">Rs. <?= number_format($subtotal) ?></span></div>
          <div class="summary-row"><span class="text-muted">Delivery</span><span class="fw-semibold"><?= $deliveryFee == 0 ? 'Free' : 'Rs. ' . number_format($deliveryFee) ?></span></div>
          <div class="summary-row summary-total"><span>Total</span><span>Rs. <?= number_format($total) ?></span></div>
          <?php if ($deliveryFee > 0): ?>
          <div class="small text-muted mt-2"><i class="bi bi-info-circle"></i> Add Rs. <?= number_format(3000 - $subtotal) ?> more for free delivery</div>
          <?php endif; ?>
          <a href="<?= url('checkout') ?>" class="btn btn-accent w-100 mt-3"><i class="bi bi-bag-check me-2"></i>Proceed to Checkout</a>
          <div class="small text-center text-muted mt-2"><i class="bi bi-cash-coin"></i> Cash on Delivery available — pay when your order arrives</div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
