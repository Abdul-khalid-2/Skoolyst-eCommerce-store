<?php
/** Vars from Admin\ProductController::index(): $result, $filters. */
$title = 'Manage Products — Skoolyst Store Admin';
$active = 'products';
$topbarTitle = 'Products';
$topbarActions = skoolyst_btn('Add Product', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'fa-solid fa-plus', 'href' => url('admin/products/create')]);

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<form method="get" action="<?= url('admin/products') ?>" class="d-flex gap-2 mb-4 flex-wrap">
  <div class="flex-grow-1" style="min-width:200px">
    <div class="input-group input-group-sm">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input type="text" name="q" class="form-control" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search products...">
    </div>
  </div>
  <select class="form-select form-select-sm" name="status" style="width:auto" onchange="this.form.submit()">
    <option value="">All Status</option>
    <?php foreach (['active' => 'Active', 'draft' => 'Draft', 'out_of_stock' => 'Out of Stock'] as $value => $label): ?>
    <option value="<?= $value ?>" <?= ($filters['status'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn btn-sm btn-outline-navy">Search</button>
</form>

<div class="dash-panel">
  <?= skoolyst_table_open(['Product', 'Store', 'Price', 'Stock', 'Status', 'Action']) ?>
  <?php foreach ($result['rows'] as $product): ?>
  <tr>
    <td>
      <div class="d-flex align-items-center gap-2">
        <div style="width:36px;height:36px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--skoolyst-surface-alt)">
          <?php if ($product['image']): ?><img src="<?= clean(media_url($product['image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php endif; ?>
        </div>
        <div class="fw-semibold small"><?= clean($product['name']) ?></div>
      </div>
    </td>
    <td class="small"><?= clean($product['store_name']) ?></td>
    <td>Rs. <?= number_format((float) $product['price']) ?></td>
    <td><?= (int) $product['stock'] ?></td>
    <td><?= skoolyst_status_badge(str_replace('_', ' ', ucfirst($product['status'])), $product['status']) ?></td>
    <td>
      <div class="d-flex gap-1">
        <form method="post" action="<?= url('admin/products/' . $product['id'] . '/delete') ?>" onsubmit="return confirm('Delete this product?');">
          <?= csrf_field() ?>
          <button type="submit" class="btn btn-sm btn-light-navy text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
        </form>
      </div>
    </td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php if (!$result['rows']): ?>
    <?= skoolyst_empty_state('bi-box-seam', 'No products found', 'Add a product to one of your stores to get started.', skoolyst_btn('Add Product', ['variant' => 'navy', 'href' => url('admin/products/create')])) ?>
  <?php endif; ?>
  <?php
  $queryWithoutPage = array_diff_key($_GET, ['page' => null]);
  $baseUrl = url('admin/products') . ($queryWithoutPage ? '?' . http_build_query($queryWithoutPage) : '');
  ?>
  <?= skoolyst_pagination($result['page'], $result['totalPages'], $baseUrl, 'Products pagination') ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
