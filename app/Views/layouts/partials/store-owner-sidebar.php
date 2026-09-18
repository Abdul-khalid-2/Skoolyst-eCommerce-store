<?php
/** Store-owner sidebar. Vars: $active (nav key): dashboard|store|products */
$active = $active ?? 'dashboard';
$link = static fn (string $key, string $icon, string $label, string $href) =>
    '<a class="nav-link' . ($active === $key ? ' active' : '') . '" href="' . clean($href) . '"><i class="fa-solid ' . $icon . '"></i> ' . clean($label) . '</a>';
?>
<aside class="dashboard-sidebar" id="dashSidebar">
  <div class="sidebar-brand">Skoolyst<span class="brand-accent">Store</span></div>
  <nav>
    <div class="nav-section-label">My Store</div>
    <?= $link('dashboard', 'fa-gauge-high', 'Dashboard', url('store/dashboard')) ?>
    <?= $link('store', 'fa-store', 'Store Details', url('store/edit')) ?>
    <?= $link('products', 'fa-box', 'Products', url('store/products')) ?>
    <div class="nav-section-label">Account</div>
    <a class="nav-link" href="<?= url('logout') ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
  </nav>
</aside>
<div class="sidebar-overlay"></div>
