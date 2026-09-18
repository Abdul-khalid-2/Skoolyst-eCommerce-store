<?php
/** Shared Skoolyst storefront footer. */
?>
<footer class="sk-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="footer-brand mb-2">Skoolyst<span class="brand-accent">Stores</span></div>
        <p class="small">Pakistan's education marketplace connecting schools, parents, students and school-related businesses.</p>
        <div class="d-flex gap-2 mt-3">
          <a href="#" class="btn btn-sm btn-outline-light" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h5>Marketplace</h5>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="<?= url('stores') ?>">Stores</a></li>
          <li><a href="<?= url('products') ?>">Products</a></li>
          <li><a href="<?= url('cart') ?>">Cart</a></li>
          <li><a href="<?= url('checkout') ?>">Checkout</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <h5>Account</h5>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="<?= url('login') ?>">Login</a></li>
          <li><a href="<?= url('register') ?>">Register</a></li>
          <li><a href="<?= url('admin/dashboard') ?>">Seller Dashboard</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h5>Contact</h5>
        <p class="small mb-1"><i class="bi bi-geo-alt me-1"></i> Karachi, Pakistan</p>
        <p class="small mb-1"><i class="bi bi-envelope me-1"></i> hello@skoolyst.pk</p>
        <p class="small mb-0"><i class="bi bi-telephone me-1"></i> +92 21 1234 5678</p>
      </div>
    </div>
    <div class="footer-bottom d-flex justify-content-between flex-wrap gap-2">
      <span>&copy; <?= date('Y') ?> Skoolyst Stores. All rights reserved.</span>
      <span>UI Prototype — Frontend Only</span>
    </div>
  </div>
</footer>
