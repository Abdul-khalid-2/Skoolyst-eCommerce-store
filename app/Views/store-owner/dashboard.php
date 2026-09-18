<?php
/** Vars from StoreOwnerController::dashboard(): $store, $products. */
$title = 'My Store — Skoolyst Store';
$active = 'dashboard';
$topbarTitle = 'Dashboard';

$activeProducts = count(array_filter($products, static fn ($p) => $p['status'] === 'active'));

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<div class="dash-panel mb-4">
  <div class="d-flex gap-3 align-items-center flex-wrap">
    <div style="width:56px;height:56px;border-radius:12px;overflow:hidden;background:var(--skoolyst-surface-alt);flex-shrink:0">
      <?php if ($store['logo']): ?><img src="<?= clean($store['logo']) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php endif; ?>
    </div>
    <div class="flex-grow-1">
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <h5 class="mb-0"><?= clean($store['name']) ?></h5>
        <?= skoolyst_status_badge(ucfirst($store['status']), $store['status']) ?>
        <?php if ($store['verified']): ?><?= skoolyst_badge('Verified', 'verified', 'bi-patch-check-fill') ?><?php endif; ?>
      </div>
      <?php if ($store['status'] === 'pending'): ?>
        <div class="small text-muted mt-1">Your store is awaiting admin approval and isn't visible to shoppers yet.</div>
      <?php endif; ?>
    </div>
    <?= skoolyst_btn('Edit Store', ['variant' => 'outline-navy', 'size' => 'sm', 'href' => url('store/edit')]) ?>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-4"><?= skoolyst_stat_card('fa-solid fa-box', 'bg-navy-soft', 'Total Products', (string) count($products)) ?></div>
  <div class="col-6 col-md-4"><?= skoolyst_stat_card('fa-solid fa-circle-check', 'bg-success-soft', 'Active Products', (string) $activeProducts) ?></div>
</div>

<div class="dash-panel">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="panel-title mb-0">Recent Products</h5>
    <?= skoolyst_btn('Add Product', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'fa-solid fa-plus', 'href' => url('store/products/create')]) ?>
  </div>
  <?php if (!$products): ?>
    <?= skoolyst_empty_state('bi-box-seam', 'No products yet', 'Add your first product to start listing.', skoolyst_btn('Add Product', ['variant' => 'navy', 'href' => url('store/products/create')])) ?>
  <?php else: ?>
  <?= skoolyst_table_open(['Product', 'Price', 'Stock', 'Status']) ?>
  <?php foreach (array_slice($products, 0, 5) as $product): ?>
  <tr>
    <td><?= clean($product['name']) ?></td>
    <td>Rs. <?= number_format((float) $product['price']) ?></td>
    <td><?= (int) $product['stock'] ?></td>
    <td><?= skoolyst_status_badge(str_replace('_', ' ', ucfirst($product['status'])), $product['status']) ?></td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <div class="text-end mt-2"><a href="<?= url('store/products') ?>" class="small fw-semibold">View all products <i class="bi bi-arrow-right"></i></a></div>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/store-owner.php';
