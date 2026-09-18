<?php
$title = 'Shopping Cart — Skoolyst Stores';
$description = 'Your shopping cart on Skoolyst Stores.';
$active = 'products';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <h1 class="mb-4">Shopping Cart</h1>
    <div id="cartContainer">
      <?= skoolyst_empty_state(
          'bi-bag-x',
          'Your cart is empty',
          "Looks like you haven't added any products yet. Browse our stores and find everything your student needs.",
          skoolyst_btn('Browse Products', ['variant' => 'navy', 'icon' => 'bi-bag', 'href' => url('products')])
      ) ?>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

// Cart contents live in the browser (localStorage) until a real cart backend
// exists — this client-side renderer replaces the SSR empty-state above
// whenever the cart is non-empty.
ob_start();
?>
window.renderCart = function() {
  var container = document.getElementById('cartContainer');
  var cart = window.getCart();
  if (!cart || cart.length === 0) { return; }
  var subtotal = 0;
  cart.forEach(function(item) { subtotal += item.price * item.qty; });
  var delivery = subtotal >= 3000 ? 0 : 200;
  var total = subtotal + delivery;
  var html = '<div class="row g-4"><div class="col-lg-8"><div class="d-flex flex-column gap-3" id="cartItems">';
  cart.forEach(function(item, i) {
    html += '' +
      '<div class="cart-item">' +
        '<div class="cart-item-img"><img src="' + (item.img || 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=200') + '" alt="' + item.name + '"></div>' +
        '<div class="flex-grow-1">' +
          '<div class="d-flex justify-content-between align-items-start">' +
            '<div><a href="<?= url('product') ?>" class="text-decoration-none"><h6 class="mb-0">' + item.name + '</h6></a>' +
              '<div class="small text-muted mt-1"><i class="bi bi-shop"></i> ' + (item.store || 'Store') + '</div></div>' +
            '<button class="btn btn-sm text-danger p-1" onclick="skRemoveFromCart(' + i + ')" aria-label="Remove item"><i class="bi bi-trash"></i></button>' +
          '</div>' +
          '<div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">' +
            '<div class="quantity-selector">' +
              '<button data-qty-btn="minus" onclick="skUpdateQty(' + i + ', -1)" aria-label="Decrease">−</button>' +
              '<input type="text" value="' + item.qty + '" data-qty aria-label="Quantity" readonly>' +
              '<button data-qty-btn="plus" onclick="skUpdateQty(' + i + ', 1)" aria-label="Increase">+</button>' +
            '</div>' +
            '<div class="text-end"><div class="fw-bold text-navy">Rs. ' + (item.price * item.qty).toLocaleString() + '</div>' +
              '<div class="small text-muted">Rs. ' + item.price.toLocaleString() + ' each</div></div>' +
          '</div>' +
        '</div>' +
      '</div>';
  });
  html += '</div><div class="mt-3"><a href="<?= url('products') ?>" class="btn btn-outline-navy"><i class="bi bi-arrow-left me-2"></i>Continue Shopping</a></div></div>' +
    '<div class="col-lg-4"><div class="order-summary sticky-top" style="top:80px">' +
      '<h5 class="mb-3">Order Summary</h5>' +
      '<div class="summary-row"><span class="text-muted">Subtotal (' + cart.reduce(function(s,i){return s+i.qty},0) + ' items)</span><span class="fw-semibold">Rs. ' + subtotal.toLocaleString() + '</span></div>' +
      '<div class="summary-row"><span class="text-muted">Delivery</span><span class="fw-semibold">' + (delivery === 0 ? 'Free' : 'Rs. ' + delivery.toLocaleString()) + '</span></div>' +
      '<div class="summary-row summary-total"><span>Total</span><span>Rs. ' + total.toLocaleString() + '</span></div>' +
      (delivery > 0 ? '<div class="small text-muted mt-2"><i class="bi bi-info-circle"></i> Add Rs. ' + (3000 - subtotal).toLocaleString() + ' more for free delivery</div>' : '') +
      '<a href="<?= url('checkout') ?>" class="btn btn-accent w-100 mt-3"><i class="bi bi-bag-check me-2"></i>Proceed to Checkout</a>' +
      '<div class="small text-center text-muted mt-2"><i class="bi bi-shield-check"></i> Secure checkout</div>' +
    '</div></div></div>';
  container.innerHTML = html;
};
document.addEventListener('DOMContentLoaded', window.renderCart);
<?php
$inlineScript = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
