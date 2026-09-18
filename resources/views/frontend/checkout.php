<?php
$title = 'Checkout — Skoolyst Stores';
$description = 'Checkout — Complete your order on Skoolyst Stores. Prototype UI only.';
$active = 'products';

$orderItems = [
    ['name' => 'Premium School Backpack', 'qty' => 1, 'total' => 2500, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'Complete Stationery Set', 'qty' => 2, 'total' => 1500, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'School Uniform Set', 'qty' => 1, 'total' => 1850, 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=100'],
];

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('cart') ?>">Cart</a></li>
  <li class="breadcrumb-item active" aria-current="page">Checkout</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <?= skoolyst_alert('This is a prototype checkout. No real orders will be placed and no payment will be processed.', 'info') ?>
    <h1 class="mb-4">Checkout</h1>
    <form method="post" action="<?= url('checkout') ?>" data-validate>
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-person-lines-fill text-navy me-1"></i> Customer Information</div>
            <div class="row g-3">
              <div class="col-md-6"><?= skoolyst_input(['name' => 'fullName', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'e.g. Ayesha Khan']) ?></div>
              <div class="col-md-6"><?= skoolyst_input(['type' => 'tel', 'name' => 'phone', 'label' => 'Phone', 'required' => true, 'placeholder' => 'e.g. 0300 1234567']) ?></div>
              <div class="col-12"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true, 'placeholder' => 'e.g. ayesha@example.com']) ?></div>
            </div>
          </div>

          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-geo-alt-fill text-navy me-1"></i> Delivery Address</div>
            <div class="row g-3">
              <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'address', 'label' => 'Address', 'required' => true, 'placeholder' => 'House #, Street, Area']) ?></div>
              <div class="col-md-4">
                <label class="form-label" for="city">City</label>
                <select class="form-select" id="city" name="city" required>
                  <option value="">Select City</option>
                  <?php foreach (['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Hyderabad', 'Faisalabad', 'Multan', 'Peshawar'] as $city): ?>
                  <option><?= clean($city) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4"><?= skoolyst_input(['name' => 'area', 'label' => 'Area', 'required' => true, 'placeholder' => 'e.g. Gulberg']) ?></div>
              <div class="col-md-4"><?= skoolyst_input(['name' => 'postal', 'label' => 'Postal Code', 'placeholder' => 'e.g. 75300']) ?></div>
            </div>
          </div>

          <div class="form-card">
            <div class="form-card-title"><i class="bi bi-truck text-navy me-1"></i> Delivery Method</div>
            <div class="d-flex flex-column gap-2">
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="deliveryMethod" id="dmStandard" checked>
                <label class="form-check-label d-flex justify-content-between align-items-center w-100 ms-2" for="dmStandard">
                  <span><i class="bi bi-truck me-2"></i>Standard Delivery <span class="small text-muted d-block ms-4">3-5 business days</span></span>
                  <span class="fw-bold text-navy">Rs. 200</span>
                </label>
              </div>
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="deliveryMethod" id="dmPickup">
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
                <input class="form-check-input" type="radio" name="paymentMethod" id="pmCod" checked>
                <label class="form-check-label d-flex align-items-center w-100 ms-2" for="pmCod">
                  <i class="bi bi-cash-coin me-2 fs-5 text-success"></i>
                  <span>Cash on Delivery <span class="small text-muted d-block">Pay when you receive your order</span></span>
                </label>
              </div>
              <div class="form-check border rounded p-3">
                <input class="form-check-input" type="radio" name="paymentMethod" id="pmOnline">
                <label class="form-check-label d-flex align-items-center w-100 ms-2" for="pmOnline">
                  <i class="bi bi-credit-card me-2 fs-5 text-navy"></i>
                  <span>Online Payment <span class="small text-muted d-block">Pay with card or mobile wallet</span></span>
                </label>
              </div>
            </div>
            <div class="small text-muted mt-2"><i class="bi bi-shield-check text-success"></i> Your payment information is secure and encrypted.</div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="order-summary sticky-top" style="top:80px">
            <h5 class="mb-3">Order Summary</h5>
            <div class="d-flex flex-column gap-2 mb-3">
              <?php foreach ($orderItems as $item): ?>
              <div class="d-flex gap-2 align-items-center">
                <div class="cart-item-img" style="width:48px;height:48px"><img src="<?= clean($item['img']) ?>" alt="<?= clean($item['name']) ?>"></div>
                <div class="flex-grow-1"><div class="small fw-semibold"><?= clean($item['name']) ?></div><div class="small text-muted">Qty: <?= $item['qty'] ?></div></div>
                <div class="small fw-bold">Rs. <?= number_format($item['total']) ?></div>
              </div>
              <?php endforeach; ?>
            </div>
            <hr>
            <div class="summary-row"><span class="text-muted">Subtotal (4 items)</span><span class="fw-semibold">Rs. 5,850</span></div>
            <div class="summary-row"><span class="text-muted">Delivery</span><span class="fw-semibold">Rs. 200</span></div>
            <div class="summary-row"><span class="text-muted">Discount</span><span class="fw-semibold text-success">−Rs. 0</span></div>
            <div class="summary-row summary-total"><span>Total</span><span>Rs. 6,050</span></div>
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
require __DIR__ . '/../layouts/frontend.php';
