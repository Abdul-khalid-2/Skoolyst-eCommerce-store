<?php
/** Vars from Admin\OrderController::show(): $order, $items (each tagged with store_name/store_slug). */
$title = 'Order ' . $order['order_number'] . ' — Skoolyst Store Admin';
$active = 'orders';
$topbarTitle = 'Order ' . $order['order_number'];

$groups = [];
foreach ($items as $item) {
    $key = $item['store_name'] ?? 'Unknown store';
    $groups[$key]['items'][] = $item;
    $groups[$key]['subtotal'] = ($groups[$key]['subtotal'] ?? 0) + (float) $item['line_total'];
}

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="dash-panel mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Items (<?= count($items) ?> total, from <?= count($groups) ?> store<?= count($groups) === 1 ? '' : 's' ?>)</h6>
        <?= skoolyst_status_badge(ucfirst($order['status']), $order['status']) ?>
      </div>
      <?php foreach ($groups as $storeName => $group): ?>
      <div class="mb-3">
        <div class="small fw-semibold text-navy mb-1"><i class="fa-solid fa-store me-1"></i> <?= clean($storeName) ?> — <?= count($group['items']) ?> item<?= count($group['items']) === 1 ? '' : 's' ?></div>
        <?= skoolyst_table_open(['Product', 'Price', 'Qty', 'Line Total']) ?>
        <?php foreach ($group['items'] as $item): ?>
        <tr>
          <td class="small"><?= clean($item['product_name']) ?></td>
          <td class="small">Rs. <?= number_format((float) $item['price']) ?></td>
          <td class="small"><?= (int) $item['qty'] ?></td>
          <td class="small fw-semibold">Rs. <?= number_format((float) $item['line_total']) ?></td>
        </tr>
        <?php endforeach; ?>
        <?= skoolyst_table_close() ?>
        <div class="text-end small text-muted">Store subtotal: Rs. <?= number_format($group['subtotal']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="dash-panel mb-4">
      <h6 class="mb-3">Customer</h6>
      <div class="small fw-semibold"><?= clean($order['full_name']) ?></div>
      <div class="small text-muted"><?= clean($order['phone']) ?></div>
      <div class="small text-muted"><?= clean($order['email']) ?></div>
      <hr>
      <div class="small text-muted mb-1"><?= $order['delivery_method'] === 'pickup' ? 'Store Pickup' : 'Standard Delivery' ?></div>
      <?php if ($order['delivery_method'] !== 'pickup'): ?>
      <div class="small"><?= clean($order['address']) ?><?= $order['area'] ? ', ' . clean($order['area']) : '' ?>, <?= clean($order['city']) ?></div>
      <?php if ($order['postal_code']): ?><div class="small text-muted"><?= clean($order['postal_code']) ?></div><?php endif; ?>
      <?php endif; ?>
      <div class="small text-muted mt-2">Payment: <?= $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online Payment' ?></div>
      <div class="small text-muted">Placed: <?= clean(date('M j, Y g:i A', strtotime($order['created_at']))) ?></div>
    </div>

    <div class="dash-panel mb-4">
      <h6 class="mb-3">Order Summary</h6>
      <div class="d-flex justify-content-between small mb-1"><span class="text-muted">Subtotal</span><span>Rs. <?= number_format((float) $order['subtotal']) ?></span></div>
      <div class="d-flex justify-content-between small mb-1"><span class="text-muted">Delivery</span><span><?= (float) $order['delivery_fee'] == 0 ? 'Free' : 'Rs. ' . number_format((float) $order['delivery_fee']) ?></span></div>
      <hr>
      <div class="d-flex justify-content-between fw-bold"><span>Total</span><span>Rs. <?= number_format((float) $order['total']) ?></span></div>
    </div>

    <div class="dash-panel">
      <h6 class="mb-3">Update Status</h6>
      <form method="post" action="<?= url('admin/orders/' . $order['id'] . '/status') ?>" class="d-flex gap-2">
        <?= csrf_field() ?>
        <select class="form-select form-select-sm" name="status">
          <?php foreach (['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label): ?>
          <option value="<?= $value ?>" <?= $order['status'] === $value ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-sm btn-navy">Update</button>
      </form>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
