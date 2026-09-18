<?php
/**
 * Shared Skoolyst storefront navbar (dark brand header).
 * Vars: $active (nav key: home|stores|products, optional).
 */
$active = $active ?? '';
$navLink = static fn (string $key, string $label, string $href) =>
    '<a class="nav-link' . ($active === $key ? ' active' : '') . '" href="' . clean($href) . '">' . clean($label) . '</a>';
?>
<nav class="navbar navbar-expand-lg sk-header sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= url('') ?>">Skoolyst<span class="brand-accent">Stores</span></a>
    <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
      <i class="bi bi-list text-white fs-4"></i>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item"><?= $navLink('home', 'Home', url('')) ?></li>
        <li class="nav-item"><?= $navLink('stores', 'Stores', url('stores')) ?></li>
        <li class="nav-item"><?= $navLink('products', 'Products', url('products')) ?></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Categories</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= url('products?cat=uniforms') ?>">Uniforms</a></li>
            <li><a class="dropdown-item" href="<?= url('products?cat=shoes') ?>">Shoes</a></li>
            <li><a class="dropdown-item" href="<?= url('products?cat=bags') ?>">School Bags</a></li>
            <li><a class="dropdown-item" href="<?= url('products?cat=stationery') ?>">Stationery</a></li>
            <li><a class="dropdown-item" href="<?= url('products?cat=books') ?>">Books</a></li>
            <li><a class="dropdown-item" href="<?= url('products?cat=supplies') ?>">Educational Supplies</a></li>
            <li><a class="dropdown-item" href="<?= url('products?cat=accessories') ?>">Accessories</a></li>
          </ul>
        </li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="search-bar d-none d-lg-flex">
          <div class="input-group input-group-sm">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" placeholder="Search products, stores...">
          </div>
        </div>
        <a href="<?= url('cart') ?>" class="btn btn-search-icon position-relative px-2">
          <i class="bi bi-bag fs-5"></i>
          <span class="cart-count" style="display:none">0</span>
        </a>
        <a href="<?= url('login') ?>" class="btn btn-sm btn-outline-light">Login</a>
        <a href="<?= url('register') ?>" class="btn btn-sm btn-accent">Open a Store</a>
      </div>
    </div>
  </div>
  <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileNav">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title text-navy">Skoolyst<span class="text-accent">Stores</span></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" class="form-control" placeholder="Search products, stores...">
        </div>
      </div>
      <ul class="nav flex-column gap-1">
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('') ?>">Home</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('stores') ?>">Stores</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products') ?>">Products</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products?cat=uniforms') ?>">Uniforms</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products?cat=shoes') ?>">Shoes</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products?cat=bags') ?>">School Bags</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products?cat=stationery') ?>">Stationery</a></li>
        <li><a class="nav-link text-navy fw-semibold" href="<?= url('products?cat=books') ?>">Books</a></li>
      </ul>
      <hr>
      <div class="d-flex flex-column gap-2">
        <a href="<?= url('cart') ?>" class="btn btn-outline-navy"><i class="bi bi-bag me-1"></i> Cart</a>
        <a href="<?= url('login') ?>" class="btn btn-outline-navy">Login</a>
        <a href="<?= url('register') ?>" class="btn btn-accent">Open a Store</a>
      </div>
    </div>
  </div>
</nav>
