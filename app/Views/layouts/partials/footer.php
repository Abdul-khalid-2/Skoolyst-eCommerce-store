<?php
/** Shared Skoolyst Store public footer. */
?>
<footer class="sk-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="footer-brand mb-2">Skoolyst<span class="brand-accent">Store</span></div>
        <p class="small">Pakistan's education store directory &mdash; connecting schools, parents and students with trusted uniform, shoe, stationery and book stores.</p>
      </div>
      <div class="col-6 col-lg-2">
        <h5>Directory</h5>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="<?= url('stores') ?>">Stores</a></li>
          <li><a href="<?= url('products') ?>">Products</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <h5>Account</h5>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="<?= url('login') ?>">Login</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h5>Contact</h5>
        <p class="small mb-1"><i class="bi bi-geo-alt me-1"></i> Karachi, Pakistan</p>
        <p class="small mb-1"><i class="bi bi-envelope me-1"></i> hello@skoolyst.pk</p>
      </div>
    </div>
    <div class="footer-bottom d-flex justify-content-between flex-wrap gap-2">
      <span>&copy; <?= date('Y') ?> Skoolyst Store. All rights reserved.</span>
    </div>
  </div>
</footer>
