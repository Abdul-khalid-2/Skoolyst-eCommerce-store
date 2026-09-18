<?php
$title = 'Dashboard Overview — Skoolyst Stores';
$active = 'overview';
$topbarTitle = 'Overview';

$salesChart = [
    ['label' => 'Mon', 'height' => 45, 'value' => 'Rs. 12K'], ['label' => 'Tue', 'height' => 60, 'value' => 'Rs. 18K'],
    ['label' => 'Wed', 'height' => 35, 'value' => 'Rs. 8K'], ['label' => 'Thu', 'height' => 75, 'value' => 'Rs. 22K'],
    ['label' => 'Fri', 'height' => 90, 'value' => 'Rs. 28K'], ['label' => 'Sat', 'height' => 55, 'value' => 'Rs. 15K'],
    ['label' => 'Sun', 'height' => 30, 'value' => 'Rs. 6K'],
];
$topProducts = [
    ['name' => 'School Uniform Set', 'sold' => 128, 'revenue' => 'Rs. 236K'],
    ['name' => 'Premium Backpack', 'sold' => 95, 'revenue' => 'Rs. 237K'],
    ['name' => 'Stationery Set', 'sold' => 84, 'revenue' => 'Rs. 63K'],
    ['name' => 'School Shoes', 'sold' => 62, 'revenue' => 'Rs. 136K'],
    ['name' => 'Geometry Box', 'sold' => 48, 'revenue' => 'Rs. 21K'],
];
$recentOrders = [
    ['id' => '#SK-1024', 'customer' => 'Ayesha Khan', 'date' => '10 Sep 2026', 'amount' => 'Rs. 4,350', 'status' => 'pending', 'label' => 'Pending'],
    ['id' => '#SK-1023', 'customer' => 'Mohammad Raza', 'date' => '10 Sep 2026', 'amount' => 'Rs. 2,500', 'status' => 'processing', 'label' => 'Processing'],
    ['id' => '#SK-1022', 'customer' => 'Fatima Ali', 'date' => '9 Sep 2026', 'amount' => 'Rs. 1,850', 'status' => 'shipped', 'label' => 'Shipped'],
    ['id' => '#SK-1021', 'customer' => 'Sana Iqbal', 'date' => '9 Sep 2026', 'amount' => 'Rs. 3,200', 'status' => 'delivered', 'label' => 'Delivered'],
    ['id' => '#SK-1020', 'customer' => 'Bilal Ahmed', 'date' => '8 Sep 2026', 'amount' => 'Rs. 750', 'status' => 'cancelled', 'label' => 'Cancelled'],
    ['id' => '#SK-1019', 'customer' => 'Zainab Malik', 'date' => '8 Sep 2026', 'amount' => 'Rs. 5,600', 'status' => 'delivered', 'label' => 'Delivered'],
];

ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h2 class="fs-4 mb-0">Good morning, Store Owner!</h2>
    <p class="text-muted small mb-0">Here's what's happening with your store today.</p>
  </div>
  <span class="badge status-active fs-6 px-3 py-2"><i class="bi bi-circle-fill" style="font-size:.5rem"></i> Store Active</span>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-box-seam', 'bg-navy-soft', 'Total Products', '128', '12% this month') ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-bag-check', 'bg-accent-soft', 'Total Orders', '1,847', '8% this month') ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-currency-rupee', 'bg-success-soft', 'Total Sales', 'Rs. 284K', '15% this month') ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-people', 'bg-teal-soft', 'Customers', '892', '5% this month') ?></div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="dash-panel">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="panel-title mb-0">Sales Overview</h5>
        <select class="form-select form-select-sm" style="width:auto"><option>Last 7 days</option><option>Last 30 days</option><option>Last 3 months</option></select>
      </div>
      <div class="chart-container">
        <?php foreach ($salesChart as $bar): ?>
        <div class="chart-bar-col"><div class="chart-bar" style="height:<?= $bar['height'] ?>%"><span class="bar-value"><?= clean($bar['value']) ?></span></div><div class="chart-bar-label"><?= clean($bar['label']) ?></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="dash-panel h-100">
      <h5 class="panel-title">Top Products</h5>
      <div class="d-flex flex-column gap-3">
        <?php foreach ($topProducts as $i => $p): ?>
        <div class="d-flex align-items-center gap-2">
          <div class="avatar-circle"><?= $i + 1 ?></div>
          <div class="flex-grow-1"><div class="small fw-semibold"><?= clean($p['name']) ?></div><div class="small text-muted"><?= $p['sold'] ?> sold</div></div>
          <div class="small fw-bold text-navy"><?= clean($p['revenue']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<div class="dash-panel">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="panel-title mb-0">Recent Orders</h5>
    <a href="<?= url('admin/orders') ?>" class="small fw-semibold">View all <i class="bi bi-arrow-right"></i></a>
  </div>
  <?= skoolyst_table_open(['Order ID', 'Customer', 'Date', 'Amount', 'Status', 'Action']) ?>
  <?php foreach ($recentOrders as $o): ?>
  <tr>
    <td><strong><?= clean($o['id']) ?></strong></td>
    <td><?= clean($o['customer']) ?></td>
    <td><?= clean($o['date']) ?></td>
    <td><?= clean($o['amount']) ?></td>
    <td><?= skoolyst_status_badge($o['label'], $o['status']) ?></td>
    <td><?= skoolyst_btn('View', ['variant' => 'light-navy', 'size' => 'sm', 'href' => url('admin/orders')]) ?></td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
