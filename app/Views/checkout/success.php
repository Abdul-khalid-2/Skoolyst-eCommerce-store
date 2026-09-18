<?php
/** Vars from CheckoutController::success(): $order, $items. */
$title = 'Order Confirmed — Skoolyst Store';
$description = 'Your order has been placed successfully.';
$active = 'products';

ob_start();
?>
<section class="section-sm">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="text-center mb-4">
          <div class="mb-3"><i class="bi bi-check-circle-fill text-success" style="font-size:3.5rem"></i></div>
          <h1 class="mb-2">Order Placed Successfully!</h1>
          <p class="text-muted">Thank you, <?= clean($order['full_name']) ?>. Your order has been received.</p>
        </div>

        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <div class="small text-muted">Order Number</div>
                <div class="fw-bold text-navy fs-5"><?= clean($order['order_number']) ?></div>
              </div>
              <?= skoolyst_badge(ucfirst($order['status']), 'navy') ?>
            </div>
            <hr>
            <div class="d-flex flex-column gap-2 mb-3">
              <?php foreach ($items as $item): ?>
              <div class="d-flex justify-content-between">
                <span><?= clean($item['product_name']) ?> <span class="text-muted">× <?= (int) $item['qty'] ?></span></span>
                <span class="fw-semibold">Rs. <?= number_format((float) $item['line_total']) ?></span>
              </div>
              <?php endforeach; ?>
            </div>
            <hr>
            <div class="summary-row"><span class="text-muted">Subtotal</span><span>Rs. <?= number_format((float) $order['subtotal']) ?></span></div>
            <div class="summary-row"><span class="text-muted">Delivery</span><span><?= (float) $order['delivery_fee'] == 0 ? 'Free' : 'Rs. ' . number_format((float) $order['delivery_fee']) ?></span></div>
            <div class="summary-row summary-total"><span>Total</span><span>Rs. <?= number_format((float) $order['total']) ?></span></div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-body">
            <div class="form-card-title mb-2"><i class="bi bi-truck text-navy me-1"></i> Delivery Details</div>
            <div class="small text-muted mb-1"><?= $order['delivery_method'] === 'pickup' ? 'Store Pickup' : 'Standard Delivery' ?></div>
            <?php if ($order['delivery_method'] !== 'pickup'): ?>
            <div class="small"><?= clean($order['address']) ?>, <?= clean($order['area'] ?: '') ?> <?= clean($order['city']) ?></div>
            <?php endif; ?>
            <div class="small text-muted mt-2"><?= clean($order['phone']) ?> &middot; <?= clean($order['email']) ?></div>
            <div class="small text-muted mt-1">Payment: <?= $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online Payment' ?></div>
          </div>
        </div>

        <div class="text-center">
          <?= skoolyst_btn('Continue Shopping', ['variant' => 'accent', 'icon' => 'bi-bag', 'href' => url('products')]) ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
