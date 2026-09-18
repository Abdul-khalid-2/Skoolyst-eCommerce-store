<?php
/**
 * Shared admin/seller dashboard sidebar.
 * Vars: $active (nav key, optional): overview|store-profile|products|add-product|orders|customers|analytics|settings
 */
$active = $active ?? 'overview';
$link = static fn (string $key, string $icon, string $label, string $href) =>
    '<a class="nav-link' . ($active === $key ? ' active' : '') . '" href="' . clean($href) . '"><i class="bi ' . $icon . '"></i> ' . clean($label) . '</a>';
?>
<aside class="dashboard-sidebar" id="dashSidebar">
  <div class="sidebar-brand">Skoolyst<span class="brand-accent">Stores</span></div>
  <nav>
    <div class="nav-section-label">Main</div>
    <?= $link('overview', 'bi-speedometer2', 'Overview', url('admin/dashboard')) ?>
    <?= $link('store-profile', 'bi-shop', 'Store Profile', url('admin/store-profile')) ?>
    <?= $link('products', 'bi-box-seam', 'Products', url('admin/products')) ?>
    <?= $link('add-product', 'bi-plus-circle', 'Add Product', url('admin/products/create')) ?>
    <div class="nav-section-label">Sales</div>
    <?= $link('orders', 'bi-bag-check', 'Orders', url('admin/orders')) ?>
    <?= $link('customers', 'bi-people', 'Customers', url('admin/customers')) ?>
    <?= $link('analytics', 'bi-graph-up', 'Analytics', url('admin/analytics')) ?>
    <div class="nav-section-label">Account</div>
    <?= $link('settings', 'bi-gear', 'Settings', url('admin/settings')) ?>
    <a class="nav-link" href="<?= url('login') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </nav>
</aside>
<div class="sidebar-overlay"></div>
