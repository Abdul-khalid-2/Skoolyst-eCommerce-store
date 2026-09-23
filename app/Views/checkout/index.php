<?php
/** Vars from CheckoutController::index()/store(): $items, $subtotal, $deliveryFee, $total, $old, $errors. */
$title = 'Checkout — Skoolyst Store';
$description = 'Checkout — Complete your order on Skoolyst Store.';
$active = 'products';
$robots = 'noindex, follow';
$old = $old ?? [];
$errors = $errors ?? [];
$val = static fn (string $key, string $default = '') => (string) ($old[$key] ?? $default);

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('cart') ?>">Cart</a></li>
  <li class="breadcrumb-item active" aria-current="page">Checkout</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <?= skoolyst_alert('Cash on Delivery is fully supported. Online Payment is recorded as your chosen method but no payment gateway is connected yet.', 'info') ?>
    <?php if (!empty($errors['cart'])): ?><?= skoolyst_alert($errors['cart'], 'danger', 'bi-exclamation-triangle-fill') ?><?php endif; ?>
    <h1 class="mb-4">Checkout</h1>
    <form method="post" action="<?= url('checkout') ?>" data-validate>
      <?= csrf_field() ?>
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-person-lines-fill text-navy me-1"></i> Customer Information</div>
            <div class="row g-3">
              <div class="col-md-6"><?= skoolyst_input(['name' => 'full_name', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'e.g. Ayesha Khan', 'value' => $val('full_name'), 'error' => $errors['full_name'] ?? null]) ?></div>
              <div class="col-md-6"><?= skoolyst_input(['type' => 'tel', 'name' => 'phone', 'label' => 'Phone', 'required' => true, 'placeholder' => 'e.g. 0300 1234567', 'value' => $val('phone'), 'error' => $errors['phone'] ?? null]) ?></div>
              <div class="col-12"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true, 'placeholder' => 'e.g. ayesha@example.com', 'value' => $val('email'), 'error' => $errors['email'] ?? null]) ?></div>
            </div>
          </div>

          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-geo-alt-fill text-navy me-1"></i> Delivery Address</div>
            <div class="row g-3">
              <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'address', 'label' => 'Address', 'required' => true, 'placeholder' => 'House #, Street, Area', 'value' => $val('address'), 'error' => $errors['address'] ?? null]) ?></div>
              <div class="col-md-4">
                <label class="form-label" for="city">City</label>
                <select class="form-select<?= isset($errors['city']) ? ' is-invalid' : '' ?>" id="city" name="city" required>
                  <option value="">Select City</option>
                  <?php foreach (['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Hyderabad', 'Faisalabad', 'Multan', 'Peshawar'] as $city): ?>
                  <option <?= $val('city') === $city ? 'selected' : '' ?>><?= clean($city) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4"><?= skoolyst_input(['name' => 'area', 'label' => 'Area', 'placeholder' => 'e.g. Gulberg', 'value' => $val('area')]) ?></div>
              <div class="col-md-4"><?= skoolyst_input(['name' => 'postal_code', 'label' => 'Postal Code', 'placeholder' => 'e.g. 75300', 'value' => $val('postal_code')]) ?></div>
            </div>
          </div>

          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-truck text-navy me-1"></i> Delivery Method</div>
            <div class="d-flex flex-column gap-2">
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="delivery_method" value="delivery" id="dmStandard" <?= $val('delivery_method', 'delivery') === 'delivery' ? 'checked' : '' ?>>
                <label class="form-check-label d-flex justify-content-between align-items-center w-100 ms-2" for="dmStandard">
                  <span><i class="bi bi-truck me-2"></i>Standard Delivery <span class="small text-muted d-block ms-4">3-5 business days</span></span>
                  <span class="fw-bold text-navy">Rs. 200 (free over Rs. 3,000)</span>
                </label>
              </div>
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="delivery_method" value="pickup" id="dmPickup" <?= $val('delivery_method') === 'pickup' ? 'checked' : '' ?>>
                <label class="form-check-label d-flex justify-content-between align-items-center w-100 ms-2" for="dmPickup">
                  <span><i class="bi bi-shop me-2"></i>Store Pickup <span class="small text-muted d-block ms-4">Pick up from store</span></span>
                  <span class="fw-bold text-success">Free</span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-credit-card-fill text-navy me-1"></i> Payment Method</div>
            <div class="d-flex flex-column gap-2">
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="payment_method" value="cod" id="pmCod" <?= $val('payment_method', 'cod') === 'cod' ? 'checked' : '' ?>>
                <label class="form-check-label d-flex align-items-center w-100 ms-2" for="pmCod">
                  <i class="bi bi-cash-coin me-2 fs-5 text-success"></i>
                  <span>Cash on Delivery <span class="small text-muted d-block">Pay when you receive your order</span></span>
                </label>
              </div>
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="payment_method" value="online" id="pmOnline" <?= $val('payment_method') === 'online' ? 'checked' : '' ?>>
                <label class="form-check-label d-flex align-items-center w-100 ms-2" for="pmOnline">
                  <i class="bi bi-credit-card me-2 fs-5 text-navy"></i>
                  <span>Online Payment <span class="small text-muted d-block">Pay with card or mobile wallet</span></span>
                </label>
              </div>
            </div>
            <div class="small text-muted mt-2"><i class="bi bi-info-circle text-navy"></i> We don't collect any card or wallet details at checkout — Cash on Delivery is paid directly to the courier or store.</div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="order-summary sticky-top" style="top:80px">
            <h5 class="mb-3">Order Summary</h5>
            <div class="d-flex flex-column gap-2 mb-3">
              <?php foreach ($items as $item): ?>
              <div class="d-flex gap-2 align-items-center">
                <div class="cart-item-img" style="width:48px;height:48px"><img src="<?= clean(media_url($item['image'], 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=100')) ?>" alt="<?= clean($item['name']) ?>"></div>
                <div class="flex-grow-1"><div class="small fw-semibold"><?= clean($item['name']) ?></div><div class="small text-muted">Qty: <?= $item['qty'] ?></div></div>
                <div class="small fw-bold">Rs. <?= number_format($item['line_total']) ?></div>
              </div>
              <?php endforeach; ?>
            </div>
            <hr>
            <div class="summary-row"><span class="text-muted">Subtotal (<?= array_sum(array_column($items, 'qty')) ?> items)</span><span class="fw-semibold">Rs. <?= number_format($subtotal) ?></span></div>
            <div class="summary-row"><span class="text-muted">Delivery</span><span class="fw-semibold"><?= $deliveryFee == 0 ? 'Free' : 'Rs. ' . number_format($deliveryFee) ?></span></div>
            <div class="summary-row summary-total"><span>Total</span><span>Rs. <?= number_format($total) ?></span></div>
            <?= skoolyst_btn('Place Order', ['variant' => 'accent', 'class' => 'w-100 mt-3', 'type' => 'submit', 'icon' => 'bi-bag-check-fill']) ?>
            <?= skoolyst_btn('Back to Cart', ['variant' => 'outline-navy', 'class' => 'w-100 mt-2', 'icon' => 'bi-arrow-left', 'href' => url('cart')]) ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
