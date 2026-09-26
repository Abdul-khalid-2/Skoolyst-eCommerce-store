<?php
/** Vars from Admin\ReviewController::index(): $result, $filters. */
$title = 'Manage Reviews — Skoolyst Store Admin';
$active = 'reviews';
$topbarTitle = 'Reviews';

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<form method="get" action="<?= url('admin/reviews') ?>" class="d-flex gap-2 mb-4 flex-wrap">
  <select class="form-select form-select-sm" name="status" style="width:auto" onchange="this.form.submit()">
    <option value="">All Status</option>
    <?php foreach (['active' => 'Active', 'pending' => 'Pending', 'inactive' => 'Inactive'] as $value => $label): ?>
    <option value="<?= $value ?>" <?= ($filters['status'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn btn-sm btn-outline-navy">Filter</button>
</form>

<div class="dash-panel">
  <?= skoolyst_table_open(['Store', 'Reviewer', 'Rating', 'Review', 'Status', 'Action']) ?>
  <?php foreach ($result['rows'] as $review): ?>
  <tr>
    <td class="small"><?= clean($review['store_name']) ?></td>
    <td class="small"><?= clean($review['user_name'] ?? 'Guest') ?></td>
    <td><?= str_repeat('★', (int) $review['rating']) . str_repeat('☆', 5 - (int) $review['rating']) ?></td>
    <td class="small" style="max-width:320px">
      <?php if ($review['title']): ?><div class="fw-semibold"><?= clean($review['title']) ?></div><?php endif; ?>
      <div class="text-muted"><?= clean($review['comment'] ?? '') ?></div>
    </td>
    <td><?= skoolyst_status_badge(ucfirst($review['status']), $review['status']) ?></td>
    <td>
      <div class="d-flex gap-1">
        <?php if ($review['status'] !== 'active'): ?>
        <form method="post" action="<?= url('admin/reviews/' . $review['id'] . '/status') ?>" class="d-inline">
          <?= csrf_field() ?><input type="hidden" name="status" value="active">
          <button type="submit" class="btn btn-sm btn-light-navy" title="Approve"><i class="fa-solid fa-check"></i></button>
        </form>
        <?php endif; ?>
        <?php if ($review['status'] !== 'inactive'): ?>
        <form method="post" action="<?= url('admin/reviews/' . $review['id'] . '/status') ?>" class="d-inline">
          <?= csrf_field() ?><input type="hidden" name="status" value="inactive">
          <button type="submit" class="btn btn-sm btn-light-navy" title="Deactivate"><i class="fa-solid fa-ban"></i></button>
        </form>
        <?php endif; ?>
        <form method="post" action="<?= url('admin/reviews/' . $review['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this review? This cannot be undone.');">
          <?= csrf_field() ?>
          <button type="submit" class="btn btn-sm btn-light-navy text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
        </form>
      </div>
    </td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php if (!$result['rows']): ?>
    <?= skoolyst_empty_state('bi-chat-square-text', 'No reviews found', 'Customer store reviews will show up here once submitted.') ?>
  <?php endif; ?>
  <?php
  $queryWithoutPage = array_diff_key($_GET, ['page' => null]);
  $baseUrl = url('admin/reviews') . ($queryWithoutPage ? '?' . http_build_query($queryWithoutPage) : '');
  ?>
  <?= skoolyst_pagination($result['page'], $result['totalPages'], $baseUrl, 'Reviews pagination') ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
