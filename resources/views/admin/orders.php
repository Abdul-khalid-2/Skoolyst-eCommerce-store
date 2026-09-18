<?php
$title = 'Orders — Skoolyst Stores Dashboard';
$active = 'orders';
$topbarTitle = 'Orders';

$orders = [
    ['id' => '#SK-1024', 'customer' => 'Ayesha Khan', 'items' => '3 items', 'amount' => 'Rs. 4,350', 'date' => '10 Sep 2026', 'status' => 'pending', 'label' => 'Pending'],
    ['id' => '#SK-1023', 'customer' => 'Mohammad Raza', 'items' => '1 item', 'amount' => 'Rs. 2,500', 'date' => '10 Sep 2026', 'status' => 'processing', 'label' => 'Processing'],
    ['id' => '#SK-1022', 'customer' => 'Fatima Ali', 'items' => '2 items', 'amount' => 'Rs. 1,850', 'date' => '9 Sep 2026', 'status' => 'shipped', 'label' => 'Shipped'],
    ['id' => '#SK-1021', 'customer' => 'Sana Iqbal', 'items' => '4 items', 'amount' => 'Rs. 3,200', 'date' => '9 Sep 2026', 'status' => 'delivered', 'label' => 'Delivered'],
    ['id' => '#SK-1020', 'customer' => 'Bilal Ahmed', 'items' => '1 item', 'amount' => 'Rs. 750', 'date' => '8 Sep 2026', 'status' => 'cancelled', 'label' => 'Cancelled'],
    ['id' => '#SK-1019', 'customer' => 'Zainab Malik', 'items' => '5 items', 'amount' => 'Rs. 5,600', 'date' => '8 Sep 2026', 'status' => 'delivered', 'label' => 'Delivered'],
    ['id' => '#SK-1018', 'customer' => 'Usman Tariq', 'items' => '2 items', 'amount' => 'Rs. 2,950', 'date' => '7 Sep 2026', 'status' => 'delivered', 'label' => 'Delivered'],
    ['id' => '#SK-1017', 'customer' => 'Hira Shah', 'items' => '3 items', 'amount' => 'Rs. 4,100', 'date' => '7 Sep 2026', 'status' => 'shipped', 'label' => 'Shipped'],
];

ob_start();
?>
<div class="d-flex gap-2 mb-4 flex-wrap">
  <div class="flex-grow-1" style="min-width:200px"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" class="form-control" placeholder="Search orders..."></div></div>
  <select class="form-select form-select-sm" style="width:auto"><option>All Status</option><option>Pending</option><option>Processing</option><option>Shipped</option><option>Delivered</option><option>Cancelled</option></select>
  <input type="date" class="form-control form-control-sm" style="width:auto">
</div>

<div class="dash-panel">
  <?= skoolyst_table_open(['Order ID', 'Customer', 'Items', 'Amount', 'Date', 'Status', 'Action']) ?>
  <?php foreach ($orders as $o): ?>
  <tr>
    <td><strong><?= clean($o['id']) ?></strong></td>
    <td><?= clean($o['customer']) ?></td>
    <td><?= clean($o['items']) ?></td>
    <td><?= clean($o['amount']) ?></td>
    <td><?= clean($o['date']) ?></td>
    <td><?= skoolyst_status_badge($o['label'], $o['status']) ?></td>
    <td><button class="btn btn-sm btn-light-navy" data-bs-toggle="modal" data-bs-target="#orderModal">View</button></td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?= skoolyst_pagination(1, 3, url('admin/orders'), 'Orders pagination') ?>
</div>

<?= skoolyst_modal_open('orderModal', 'Order #SK-1024', 'lg') ?>
<div class="row g-4">
  <div class="col-md-6">
    <h6 class="fw-bold text-navy mb-2">Customer Details</h6>
    <p class="small mb-1"><strong>Name:</strong> Ayesha Khan</p>
    <p class="small mb-1"><strong>Phone:</strong> 0300 1234567</p>
    <p class="small mb-1"><strong>Email:</strong> ayesha@example.com</p>
  </div>
  <div class="col-md-6">
    <h6 class="fw-bold text-navy mb-2">Delivery Address</h6>
    <p class="small mb-0">House 12, Street 5, Gulberg III, Lahore, 54600</p>
  </div>
</div>
<hr class="my-3">
<h6 class="fw-bold text-navy mb-2">Ordered Products</h6>
<div class="d-flex flex-column gap-2 mb-3">
  <div class="d-flex gap-2 align-items-center"><div style="width:40px;height:40px;border-radius:8px;overflow:hidden"><img src="https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=100" alt="" style="width:100%;height:100%;object-fit:cover"></div><div class="flex-grow-1"><div class="small fw-semibold">School Uniform Set</div><div class="small text-muted">Qty: 2</div></div><div class="small fw-bold">Rs. 3,700</div></div>
  <div class="d-flex gap-2 align-items-center"><div style="width:40px;height:40px;border-radius:8px;overflow:hidden"><img src="https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=100" alt="" style="width:100%;height:100%;object-fit:cover"></div><div class="flex-grow-1"><div class="small fw-semibold">Complete Stationery Set</div><div class="small text-muted">Qty: 1</div></div><div class="small fw-bold">Rs. 650</div></div>
</div>
<hr class="my-3">
<div class="row g-3">
  <div class="col-md-6"><h6 class="fw-bold text-navy mb-2">Payment</h6><p class="small mb-0"><i class="bi bi-cash-coin text-success me-1"></i> Cash on Delivery</p></div>
  <div class="col-md-6">
    <div class="d-flex justify-content-between"><span class="small text-muted">Subtotal</span><span class="small">Rs. 4,350</span></div>
    <div class="d-flex justify-content-between"><span class="small text-muted">Delivery</span><span class="small">Rs. 200</span></div>
    <div class="d-flex justify-content-between fw-bold text-navy mt-1"><span>Total</span><span>Rs. 4,550</span></div>
  </div>
</div>
<hr class="my-3">
<h6 class="fw-bold text-navy mb-2">Order Timeline</h6>
<div class="d-flex flex-column gap-2">
  <div class="d-flex gap-2 align-items-center"><div class="rounded-circle bg-success" style="width:12px;height:12px"></div><span class="small">Order placed — 10 Sep, 9:30 AM</span></div>
  <div class="d-flex gap-2 align-items-center"><div class="rounded-circle bg-info" style="width:12px;height:12px"></div><span class="small">Processing — 10 Sep, 10:15 AM</span></div>
  <div class="d-flex gap-2 align-items-center"><div class="rounded-circle bg-light border" style="width:12px;height:12px"></div><span class="small text-muted">Shipped — Pending</span></div>
  <div class="d-flex gap-2 align-items-center"><div class="rounded-circle bg-light border" style="width:12px;height:12px"></div><span class="small text-muted">Delivered — Pending</span></div>
</div>
<?= skoolyst_modal_footer(
    '<select class="form-select form-select-sm" style="width:auto"><option>Update Status: Pending</option><option>Processing</option><option>Shipped</option><option>Delivered</option><option>Cancelled</option></select>'
    . skoolyst_btn('Save', ['variant' => 'navy', 'size' => 'sm'])
) ?>
<?= skoolyst_modal_close() ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
