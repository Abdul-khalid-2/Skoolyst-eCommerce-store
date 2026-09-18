<?php
/**
 * Shared Skoolyst Store public navbar.
 * Vars: $active (nav key: home|stores|products, optional).
 */
$active = $active ?? '';
$navLink = static fn (string $key, string $label, string $href) =>
    '<a class="nav-link' . ($active === $key ? ' active' : '') . '" href="' . clean($href) . '">' . clean($label) . '</a>';
?>
<nav class="navbar navbar-expand-lg sk-header sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= url('') ?>">Skoolyst<span class="brand-accent">Store</span></a>
    <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
      <i class="bi bi-list text-white fs-4"></i>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item"><?= $navLink('home', 'Home', url('')) ?></li>
        <li class="nav-item"><?= $navLink('stores', 'Stores', url('stores')) ?></li>
        <li class="nav-item"><?= $navLink('products', 'Products', url('products')) ?></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="search-bar d-none d-lg-flex">
          <form action="<?= url('stores') ?>" method="get" class="input-group input-group-sm">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="q" class="form-control" placeholder="Search stores...">
          </form>
        </div>
        <?php if (is_authenticated()): ?>
        <a href="<?= url('admin/dashboard') ?>" class="btn btn-sm btn-outline-light">Dashboard</a>
        <a href="<?= url('logout') ?>" class="btn btn-sm btn-accent">Logout</a>
        <?php else: ?>
        <a href="<?= url('login') ?>" class="btn btn-sm btn-outline-light">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileNav">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title text-navy">Skoolyst<span class="text-accent">Store</span></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-3">
        <form action="<?= url('stores') ?>" method="get" class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" name="q" class="form-control" placeholder="Search stores...">
        </form>
      </div>
      <ul class="nav flex-column gap-1">
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('') ?>">Home</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('stores') ?>">Stores</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products') ?>">Products</a></li>
      </ul>
      <hr>
      <div class="d-flex flex-column gap-2">
        <?php if (is_authenticated()): ?>
        <a href="<?= url('admin/dashboard') ?>" class="btn btn-outline-navy">Dashboard</a>
        <a href="<?= url('logout') ?>" class="btn btn-accent">Logout</a>
        <?php else: ?>
        <a href="<?= url('login') ?>" class="btn btn-outline-navy">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
