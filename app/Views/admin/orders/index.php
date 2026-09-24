<?php
/** Vars from Admin\OrderController::index(): $result, $filters. */
$title = 'Orders — Skoolyst Store Admin';
$active = 'orders';
$topbarTitle = 'Orders';

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<form method="get" action="<?= url('admin/orders') ?>" class="d-flex gap-2 mb-4 flex-wrap">
  <div class="flex-grow-1" style="min-width:200px">
    <div class="input-group input-group-sm">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input type="text" name="q" class="form-control" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search order #, name, phone...">
    </div>
  </div>
  <select class="form-select form-select-sm" name="status" style="width:auto" onchange="this.form.submit()">
    <option value="">All Status</option>
    <?php foreach (['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label): ?>
    <option value="<?= $value ?>" <?= ($filters['status'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn btn-sm btn-outline-navy">Search</button>
</form>

<div class="dash-panel">
  <?= skoolyst_table_open(['Order #', 'Customer', 'Items', 'Total', 'Status', 'Date', 'Action']) ?>
  <?php foreach ($result['rows'] as $order): ?>
  <tr>
    <td class="fw-semibold small"><?= clean($order['order_number']) ?></td>
    <td>
      <div class="small fw-semibold"><?= clean($order['full_name']) ?></div>
      <div class="small text-muted"><?= clean($order['phone']) ?></div>
    </td>
    <td><?= (int) $order['item_count'] ?></td>
    <td>Rs. <?= number_format((float) $order['total']) ?></td>
    <td><?= skoolyst_status_badge(ucfirst($order['status']), $order['status']) ?></td>
    <td class="small text-muted"><?= clean(date('M j, Y', strtotime($order['created_at']))) ?></td>
    <td><a href="<?= url('admin/orders/' . $order['id']) ?>" class="btn btn-sm btn-light-navy" title="View"><i class="fa-solid fa-eye"></i></a></td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php if (!$result['rows']): ?>
    <?= skoolyst_empty_state('bi-receipt', 'No orders yet', 'Orders placed by customers will appear here.') ?>
  <?php endif; ?>
  <?php
  $queryWithoutPage = array_diff_key($_GET, ['page' => null]);
  $baseUrl = url('admin/orders') . ($queryWithoutPage ? '?' . http_build_query($queryWithoutPage) : '');
  ?>
  <?= skoolyst_pagination($result['page'], $result['totalPages'], $baseUrl, 'Orders pagination') ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
