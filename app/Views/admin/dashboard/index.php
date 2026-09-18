<?php
/** Vars from Admin\DashboardController::index(): $storeStats, $productStats. */
$title = 'Admin Dashboard — Skoolyst Store';
$active = 'dashboard';
$topbarTitle = 'Dashboard';

ob_start();
?>
<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('fa-solid fa-store', 'bg-navy-soft', 'Total Stores', (string) $storeStats['total']) ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('fa-solid fa-circle-check', 'bg-success-soft', 'Active Stores', (string) $storeStats['active']) ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('fa-solid fa-hourglass-half', 'bg-accent-soft', 'Pending Stores', (string) $storeStats['pending']) ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('fa-solid fa-box', 'bg-teal-soft', 'Total Products', (string) $productStats['total']) ?></div>
</div>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="dash-panel">
      <h5 class="panel-title">Quick Actions</h5>
      <div class="d-flex flex-column gap-2">
        <?= skoolyst_btn('Add Store', ['variant' => 'navy', 'href' => url('admin/stores/create'), 'icon' => 'fa-solid fa-plus']) ?>
        <?= skoolyst_btn('Add Product', ['variant' => 'outline-navy', 'href' => url('admin/products/create'), 'icon' => 'fa-solid fa-plus']) ?>
        <?= skoolyst_btn('Manage Categories', ['variant' => 'outline-navy', 'href' => url('admin/categories'), 'icon' => 'fa-solid fa-tags']) ?>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="dash-panel">
      <h5 class="panel-title">Store Status</h5>
      <div class="d-flex flex-column gap-2">
        <div class="d-flex justify-content-between"><span class="small text-muted">Active</span><span class="fw-semibold"><?= $storeStats['active'] ?></span></div>
        <div class="d-flex justify-content-between"><span class="small text-muted">Pending</span><span class="fw-semibold"><?= $storeStats['pending'] ?></span></div>
        <div class="d-flex justify-content-between"><span class="small text-muted">Inactive</span><span class="fw-semibold"><?= $storeStats['inactive'] ?></span></div>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
