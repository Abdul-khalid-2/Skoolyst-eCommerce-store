<?php
/**
 * Vars from StoreOwnerController::orderShow(): $order, $items.
 * $items only ever contains this store's own lines on the order — other
 * stores' items on the same customer order are never exposed here.
 */
$title = 'Order ' . $order['order_number'] . ' — Skoolyst Store';
$active = 'orders';
$topbarTitle = 'Order ' . $order['order_number'];

$storeSubtotal = array_sum(array_column($items, 'line_total'));

ob_start();
?>
<?= skoolyst_alert('This order may also contain items from other stores — you can only see and manage the items that belong to your store.', 'info') ?>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="dash-panel">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Your Items (<?= count($items) ?>)</h6>
        <?= skoolyst_status_badge(ucfirst($order['status']), $order['status']) ?>
      </div>
      <?= skoolyst_table_open(['Product', 'Price', 'Qty', 'Line Total']) ?>
      <?php foreach ($items as $item): ?>
      <tr>
        <td class="small"><?= clean($item['product_name']) ?></td>
        <td class="small">Rs. <?= number_format((float) $item['price']) ?></td>
        <td class="small"><?= (int) $item['qty'] ?></td>
        <td class="small fw-semibold">Rs. <?= number_format((float) $item['line_total']) ?></td>
      </tr>
      <?php endforeach; ?>
      <?= skoolyst_table_close() ?>
      <div class="text-end fw-bold mt-2">Your Subtotal: Rs. <?= number_format($storeSubtotal) ?></div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="dash-panel mb-4">
      <h6 class="mb-3">Customer</h6>
      <div class="small fw-semibold"><?= clean($order['full_name']) ?></div>
      <div class="small text-muted"><?= clean($order['phone']) ?></div>
      <hr>
      <div class="small text-muted mb-1"><?= $order['delivery_method'] === 'pickup' ? 'Store Pickup' : 'Standard Delivery' ?></div>
      <?php if ($order['delivery_method'] !== 'pickup'): ?>
      <div class="small"><?= clean($order['address']) ?><?= $order['area'] ? ', ' . clean($order['area']) : '' ?>, <?= clean($order['city']) ?></div>
      <?php endif; ?>
      <div class="small text-muted mt-2">Payment: <?= $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online Payment' ?></div>
      <div class="small text-muted">Placed: <?= clean(date('M j, Y g:i A', strtotime($order['created_at']))) ?></div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/store-owner.php';
