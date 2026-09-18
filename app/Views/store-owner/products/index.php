<?php
/** Vars from StoreOwnerController::productsIndex(): $store, $products. */
$title = 'My Products — Skoolyst Store';
$active = 'products';
$topbarTitle = 'Products';
$topbarActions = skoolyst_btn('Add Product', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'fa-solid fa-plus', 'href' => url('store/products/create')]);

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<div class="dash-panel">
  <?php if (!$products): ?>
    <?= skoolyst_empty_state('bi-box-seam', 'No products yet', 'Add your first product to your store.', skoolyst_btn('Add Product', ['variant' => 'navy', 'href' => url('store/products/create')])) ?>
  <?php else: ?>
  <?= skoolyst_table_open(['Product', 'Price', 'Stock', 'Status', 'Action']) ?>
  <?php foreach ($products as $product): ?>
  <tr>
    <td>
      <div class="d-flex align-items-center gap-2">
        <div style="width:36px;height:36px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--skoolyst-surface-alt)">
          <?php if ($product['image']): ?><img src="<?= clean($product['image']) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php endif; ?>
        </div>
        <div class="fw-semibold small"><?= clean($product['name']) ?></div>
      </div>
    </td>
    <td>Rs. <?= number_format((float) $product['price']) ?></td>
    <td><?= (int) $product['stock'] ?></td>
    <td><?= skoolyst_status_badge(str_replace('_', ' ', ucfirst($product['status'])), $product['status']) ?></td>
    <td>
      <form method="post" action="<?= url('store/products/' . $product['id'] . '/delete') ?>" onsubmit="return confirm('Delete this product?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-sm btn-light-navy text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/store-owner.php';
