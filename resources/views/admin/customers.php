<?php
$title = 'Customers — Skoolyst Stores Dashboard';
$active = 'customers';
$topbarTitle = 'Customers';

$customers = [
    ['initials' => 'AK', 'name' => 'Ayesha Khan', 'city' => 'Karachi', 'email' => 'ayesha@example.com', 'phone' => '0300 1234567', 'orders' => 14, 'spent' => 'Rs. 28,450', 'last' => '10 Sep 2026', 'status' => 'active', 'label' => 'Active'],
    ['initials' => 'MR', 'name' => 'Mohammad Raza', 'city' => 'Lahore', 'email' => 'raza@example.com', 'phone' => '0321 7654321', 'orders' => 9, 'spent' => 'Rs. 19,200', 'last' => '10 Sep 2026', 'status' => 'active', 'label' => 'Active'],
    ['initials' => 'FA', 'name' => 'Fatima Ali', 'city' => 'Islamabad', 'email' => 'fatima@example.com', 'phone' => '0333 9876543', 'orders' => 7, 'spent' => 'Rs. 15,800', 'last' => '9 Sep 2026', 'status' => 'active', 'label' => 'Active'],
    ['initials' => 'SI', 'name' => 'Sana Iqbal', 'city' => 'Karachi', 'email' => 'sana@example.com', 'phone' => '0301 4567890', 'orders' => 5, 'spent' => 'Rs. 11,300', 'last' => '9 Sep 2026', 'status' => 'active', 'label' => 'Active'],
    ['initials' => 'BA', 'name' => 'Bilal Ahmed', 'city' => 'Hyderabad', 'email' => 'bilal@example.com', 'phone' => '0345 1112223', 'orders' => 3, 'spent' => 'Rs. 4,950', 'last' => '8 Sep 2026', 'status' => 'draft', 'label' => 'Inactive'],
    ['initials' => 'ZM', 'name' => 'Zainab Malik', 'city' => 'Multan', 'email' => 'zainab@example.com', 'phone' => '0302 3334445', 'orders' => 11, 'spent' => 'Rs. 22,600', 'last' => '8 Sep 2026', 'status' => 'active', 'label' => 'Active'],
    ['initials' => 'UT', 'name' => 'Usman Tariq', 'city' => 'Faisalabad', 'email' => 'usman@example.com', 'phone' => '0312 5556667', 'orders' => 6, 'spent' => 'Rs. 13,400', 'last' => '7 Sep 2026', 'status' => 'active', 'label' => 'Active'],
    ['initials' => 'HS', 'name' => 'Hira Shah', 'city' => 'Peshawar', 'email' => 'hira@example.com', 'phone' => '0334 7778889', 'orders' => 4, 'spent' => 'Rs. 8,900', 'last' => '7 Sep 2026', 'status' => 'active', 'label' => 'Active'],
];

ob_start();
?>
<div class="d-flex gap-2 mb-4 flex-wrap">
  <div class="flex-grow-1" style="min-width:200px"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" class="form-control" placeholder="Search customers..."></div></div>
  <select class="form-select form-select-sm" style="width:auto"><option>All Customers</option><option>Active</option><option>Inactive</option><option>VIP</option></select>
</div>

<div class="dash-panel">
  <?= skoolyst_table_open(['Customer', 'Email', 'Phone', 'Orders', 'Total Spent', 'Last Order', 'Status', 'Action']) ?>
  <?php foreach ($customers as $c): ?>
  <tr>
    <td><div class="d-flex align-items-center gap-2"><div class="avatar-circle"><?= clean($c['initials']) ?></div><div><div class="fw-semibold small"><?= clean($c['name']) ?></div><div class="small text-muted"><?= clean($c['city']) ?></div></div></div></td>
    <td class="small"><?= clean($c['email']) ?></td>
    <td class="small"><?= clean($c['phone']) ?></td>
    <td><span class="fw-semibold"><?= $c['orders'] ?></span></td>
    <td class="fw-bold text-navy"><?= clean($c['spent']) ?></td>
    <td class="small text-muted"><?= clean($c['last']) ?></td>
    <td><?= skoolyst_status_badge($c['label'], $c['status']) ?></td>
    <td><button class="btn btn-sm btn-light-navy" data-bs-toggle="modal" data-bs-target="#custModal">View</button></td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?= skoolyst_pagination(1, 3, url('admin/customers'), 'Customers pagination') ?>
</div>

<?= skoolyst_modal_open('custModal', 'Customer Details') ?>
<div class="d-flex align-items-center gap-3 mb-3"><div class="avatar-circle lg">AK</div><div><h6 class="mb-0">Ayesha Khan</h6><div class="small text-muted">Customer since Jan 2026</div></div></div>
<div class="row g-3">
  <div class="col-6"><div class="small text-muted">Email</div><div class="small fw-semibold">ayesha@example.com</div></div>
  <div class="col-6"><div class="small text-muted">Phone</div><div class="small fw-semibold">0300 1234567</div></div>
  <div class="col-6"><div class="small text-muted">City</div><div class="small fw-semibold">Karachi</div></div>
  <div class="col-6"><div class="small text-muted">Total Orders</div><div class="small fw-semibold">14</div></div>
  <div class="col-6"><div class="small text-muted">Total Spent</div><div class="small fw-semibold text-navy">Rs. 28,450</div></div>
  <div class="col-6"><div class="small text-muted">Last Order</div><div class="small fw-semibold">10 Sep 2026</div></div>
</div>
<hr class="my-3">
<h6 class="fw-bold text-navy mb-2">Recent Orders</h6>
<div class="d-flex flex-column gap-2">
  <div class="d-flex justify-content-between align-items-center"><span class="small">#SK-1024 — 10 Sep</span><span class="small fw-bold">Rs. 4,350</span><?= skoolyst_status_badge('Pending', 'pending') ?></div>
  <div class="d-flex justify-content-between align-items-center"><span class="small">#SK-1015 — 5 Sep</span><span class="small fw-bold">Rs. 2,100</span><?= skoolyst_status_badge('Delivered', 'delivered') ?></div>
  <div class="d-flex justify-content-between align-items-center"><span class="small">#SK-1008 — 28 Aug</span><span class="small fw-bold">Rs. 3,500</span><?= skoolyst_status_badge('Delivered', 'delivered') ?></div>
</div>
<?= skoolyst_modal_close() ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
