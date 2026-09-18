<?php
$title = 'Analytics — Skoolyst Stores Dashboard';
$active = 'analytics';
$topbarTitle = 'Analytics';
$topbarActions = '<select class="form-select form-select-sm" style="width:auto"><option>Last 30 days</option><option>Last 7 days</option><option>Last 3 months</option><option>Last year</option></select>';

$weekly = [['label' => 'W1', 'height' => 30, 'value' => '18K'], ['label' => 'W2', 'height' => 50, 'value' => '32K'], ['label' => 'W3', 'height' => 65, 'value' => '45K'], ['label' => 'W4', 'height' => 80, 'value' => '58K']];
$topByRevenue = [
    ['name' => 'School Uniform Set', 'sold' => 128, 'revenue' => 'Rs. 236K', 'share' => 83, 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=80'],
    ['name' => 'Premium Backpack', 'sold' => 95, 'revenue' => 'Rs. 237K', 'share' => 83, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=80'],
    ['name' => 'School Shoes', 'sold' => 62, 'revenue' => 'Rs. 136K', 'share' => 48, 'img' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=80'],
    ['name' => 'Stationery Set', 'sold' => 84, 'revenue' => 'Rs. 63K', 'share' => 22, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=80'],
    ['name' => 'Math Textbook', 'sold' => 48, 'revenue' => 'Rs. 21K', 'share' => 7, 'img' => 'https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg?auto=compress&cs=tinysrgb&w=80'],
];

ob_start();
?>
<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-currency-rupee', 'bg-success-soft', 'Revenue', 'Rs. 284K', '15%') ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-bag-check', 'bg-accent-soft', 'Orders', '1,847', '8%') ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-receipt', 'bg-navy-soft', 'Avg Order Value', 'Rs. 1,538', '5%') ?></div>
  <div class="col-6 col-xl-3"><?= skoolyst_stat_card('bi-people', 'bg-teal-soft', 'Customers', '892', '12%') ?></div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="dash-panel h-100">
      <h5 class="panel-title">Sales Over Time</h5>
      <div class="chart-container" style="height:200px">
        <?php foreach ($weekly as $bar): ?>
        <div class="chart-bar-col"><div class="chart-bar" style="height:<?= $bar['height'] ?>%"><span class="bar-value"><?= clean($bar['value']) ?></span></div><div class="chart-bar-label"><?= clean($bar['label']) ?></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="dash-panel h-100">
      <h5 class="panel-title">Order Status</h5>
      <div class="donut-chart" style="background:conic-gradient(var(--skoolyst-success) 0% 55%, var(--skoolyst-info) 55% 75%, var(--skoolyst-warning) 75% 88%, var(--skoolyst-danger) 88% 100%)">
        <div class="donut-center"><div class="donut-value">1,847</div><div class="donut-label">Total Orders</div></div>
      </div>
      <div class="d-flex flex-column gap-2 mt-3">
        <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;border-radius:3px;background:var(--skoolyst-success)"></div><span class="small flex-grow-1">Delivered</span><span class="small fw-semibold">1,015</span></div>
        <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;border-radius:3px;background:var(--skoolyst-info)"></div><span class="small flex-grow-1">Processing</span><span class="small fw-semibold">369</span></div>
        <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;border-radius:3px;background:var(--skoolyst-warning)"></div><span class="small flex-grow-1">Pending</span><span class="small fw-semibold">240</span></div>
        <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;border-radius:3px;background:var(--skoolyst-danger)"></div><span class="small flex-grow-1">Cancelled</span><span class="small fw-semibold">223</span></div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-7">
    <div class="dash-panel">
      <h5 class="panel-title">Top Products by Revenue</h5>
      <?= skoolyst_table_open(['Product', 'Units Sold', 'Revenue', 'Share']) ?>
      <?php foreach ($topByRevenue as $p): ?>
      <tr>
        <td><div class="d-flex align-items-center gap-2"><div style="width:32px;height:32px;border-radius:6px;overflow:hidden"><img src="<?= clean($p['img']) ?>" alt="" style="width:100%;height:100%;object-fit:cover"></div><span class="small fw-semibold"><?= clean($p['name']) ?></span></div></td>
        <td><?= $p['sold'] ?></td>
        <td class="fw-bold"><?= clean($p['revenue']) ?></td>
        <td><div class="d-flex align-items-center gap-2"><div style="width:60px;height:6px;background:var(--skoolyst-border);border-radius:3px;overflow:hidden"><div style="width:<?= $p['share'] ?>%;height:100%;background:var(--skoolyst-primary);border-radius:3px"></div></div><span class="small"><?= $p['share'] ?>%</span></div></td>
      </tr>
      <?php endforeach; ?>
      <?= skoolyst_table_close() ?>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="dash-panel h-100">
      <h5 class="panel-title">Revenue Summary</h5>
      <div class="d-flex flex-column gap-3">
        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background:var(--skoolyst-surface-alt)"><span class="small text-muted">Gross Revenue</span><span class="fw-bold text-navy">Rs. 284,000</span></div>
        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background:var(--skoolyst-surface-alt)"><span class="small text-muted">Cost of Goods</span><span class="fw-bold text-muted">−Rs. 168,000</span></div>
        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background:var(--skoolyst-surface-alt)"><span class="small text-muted">Delivery Costs</span><span class="fw-bold text-muted">−Rs. 12,000</span></div>
        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background:var(--skoolyst-surface-alt)"><span class="small text-muted">Platform Fees</span><span class="fw-bold text-muted">−Rs. 8,500</span></div>
        <hr class="my-1">
        <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background:var(--skoolyst-primary-soft)"><span class="fw-bold text-navy">Net Profit</span><span class="fw-bold fs-5 text-navy">Rs. 95,500</span></div>
        <div class="d-flex justify-content-between"><span class="small text-muted">Profit Margin</span><span class="small fw-bold text-success">33.6%</span></div>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
