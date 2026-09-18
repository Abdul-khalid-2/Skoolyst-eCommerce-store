<?php
/** Vars from Admin\StoreController::show(): $store, $products. */
$title = clean($store['name']) . ' — Skoolyst Store Admin';
$active = 'stores';
$topbarTitle = $store['name'];
$topbarActions = skoolyst_btn('Edit', ['variant' => 'outline-navy', 'size' => 'sm', 'icon' => 'fa-solid fa-pen', 'href' => url('admin/stores/' . $store['id'] . '/edit')]);

ob_start();
?>
<div class="dash-panel mb-4">
  <div class="d-flex gap-3 align-items-center flex-wrap">
    <div style="width:64px;height:64px;border-radius:12px;overflow:hidden;background:var(--skoolyst-surface-alt);flex-shrink:0">
      <?php if ($store['logo']): ?><img src="<?= clean($store['logo']) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php endif; ?>
    </div>
    <div class="flex-grow-1">
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <h5 class="mb-0"><?= clean($store['name']) ?></h5>
        <?= skoolyst_status_badge(ucfirst($store['status']), $store['status']) ?>
        <?php if ($store['verified']): ?><?= skoolyst_badge('Verified', 'verified', 'bi-patch-check-fill') ?><?php endif; ?>
      </div>
      <div class="small text-muted mt-1"><?= clean($store['city'] ?? '—') ?> &middot; <?= clean(str_replace('_', ' ', ucfirst($store['store_type']))) ?></div>
    </div>
    <a href="<?= url('stores/' . $store['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-navy">View Public Page</a>
  </div>
  <hr>
  <div class="row g-3">
    <div class="col-md-6"><div class="small text-muted">Phone</div><div class="small fw-semibold"><?= clean($store['phone'] ?? '—') ?></div></div>
    <div class="col-md-6"><div class="small text-muted">Email</div><div class="small fw-semibold"><?= clean($store['email'] ?? '—') ?></div></div>
    <div class="col-12"><div class="small text-muted">Address</div><div class="small fw-semibold"><?= clean($store['address'] ?? '—') ?></div></div>
    <?php if ($store['description']): ?><div class="col-12"><div class="small text-muted">Description</div><div class="small"><?= clean($store['description']) ?></div></div><?php endif; ?>
  </div>
</div>

<div class="dash-panel">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="panel-title mb-0">Products (<?= count($products) ?>)</h5>
    <?= skoolyst_btn('Add Product', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'fa-solid fa-plus', 'href' => url('admin/products/create')]) ?>
  </div>
  <?php if (!$products): ?>
    <?= skoolyst_empty_state('bi-box-seam', 'No products yet', 'This store has no products listed.') ?>
  <?php else: ?>
  <?= skoolyst_table_open(['Product', 'Price', 'Stock', 'Status']) ?>
  <?php foreach ($products as $product): ?>
  <tr>
    <td><?= clean($product['name']) ?></td>
    <td>Rs. <?= number_format((float) $product['price']) ?></td>
    <td><?= (int) $product['stock'] ?></td>
    <td><?= skoolyst_status_badge(str_replace('_', ' ', ucfirst($product['status'])), $product['status']) ?></td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
