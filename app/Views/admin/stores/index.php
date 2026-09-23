<?php
/** Vars from Admin\StoreController::index(): $result, $filters. */
$title = 'Manage Stores — Skoolyst Store Admin';
$active = 'stores';
$topbarTitle = 'Stores';
$topbarActions = skoolyst_btn('Add Store', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'fa-solid fa-plus', 'href' => url('admin/stores/create')]);

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<form method="get" action="<?= url('admin/stores') ?>" class="d-flex gap-2 mb-4 flex-wrap">
  <div class="flex-grow-1" style="min-width:200px">
    <div class="input-group input-group-sm">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input type="text" name="q" class="form-control" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search stores...">
    </div>
  </div>
  <select class="form-select form-select-sm" name="status" style="width:auto" onchange="this.form.submit()">
    <option value="">All Status</option>
    <?php foreach (['active' => 'Active', 'pending' => 'Pending', 'inactive' => 'Inactive'] as $value => $label): ?>
    <option value="<?= $value ?>" <?= ($filters['status'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn btn-sm btn-outline-navy">Search</button>
</form>

<div class="dash-panel">
  <?= skoolyst_table_open(['Store', 'City', 'Category', 'Type', 'Status', 'Action']) ?>
  <?php foreach ($result['rows'] as $store): ?>
  <tr>
    <td>
      <div class="d-flex align-items-center gap-2">
        <div style="width:36px;height:36px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--skoolyst-surface-alt)">
          <?php if ($store['logo']): ?><img src="<?= clean(media_url($store['logo'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php endif; ?>
        </div>
        <div>
          <div class="fw-semibold small"><?= clean($store['name']) ?></div>
          <div class="small text-muted"><?= $store['verified'] ? 'Verified' : 'Unverified' ?></div>
        </div>
      </div>
    </td>
    <td><?= clean($store['city'] ?? '—') ?></td>
    <td><?= clean($store['category_name'] ?? '—') ?></td>
    <td><?= clean(str_replace('_', ' ', ucfirst($store['store_type']))) ?></td>
    <td><?= skoolyst_status_badge(ucfirst($store['status']), $store['status']) ?></td>
    <td>
      <div class="d-flex gap-1">
        <a href="<?= url('admin/stores/' . $store['id']) ?>" class="btn btn-sm btn-light-navy" title="View"><i class="fa-solid fa-eye"></i></a>
        <a href="<?= url('admin/stores/' . $store['id'] . '/edit') ?>" class="btn btn-sm btn-light-navy" title="Edit"><i class="fa-solid fa-pen"></i></a>
        <?php if ($store['status'] !== 'active'): ?>
        <form method="post" action="<?= url('admin/stores/' . $store['id'] . '/status') ?>" class="d-inline">
          <?= csrf_field() ?><input type="hidden" name="status" value="active">
          <button type="submit" class="btn btn-sm btn-light-navy" title="Activate"><i class="fa-solid fa-check"></i></button>
        </form>
        <?php else: ?>
        <form method="post" action="<?= url('admin/stores/' . $store['id'] . '/status') ?>" class="d-inline">
          <?= csrf_field() ?><input type="hidden" name="status" value="inactive">
          <button type="submit" class="btn btn-sm btn-light-navy" title="Deactivate"><i class="fa-solid fa-ban"></i></button>
        </form>
        <?php endif; ?>
        <form method="post" action="<?= url('admin/stores/' . $store['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this store? This cannot be undone.');">
          <?= csrf_field() ?>
          <button type="submit" class="btn btn-sm btn-light-navy text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
        </form>
      </div>
    </td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php if (!$result['rows']): ?>
    <?= skoolyst_empty_state('bi-shop', 'No stores found', 'Add your first store listing to get started.', skoolyst_btn('Add Store', ['variant' => 'navy', 'href' => url('admin/stores/create')])) ?>
  <?php endif; ?>
  <?php
  $queryWithoutPage = array_diff_key($_GET, ['page' => null]);
  $baseUrl = url('admin/stores') . ($queryWithoutPage ? '?' . http_build_query($queryWithoutPage) : '');
  ?>
  <?= skoolyst_pagination($result['page'], $result['totalPages'], $baseUrl, 'Stores pagination') ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
