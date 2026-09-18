<?php
/** Vars from StoreOwnerController::productCreate()/productStore(): $categories, $errors (optional), $old (optional). */
$errors = $errors ?? [];
$old = $old ?? [];
$title = 'Add Product — Skoolyst Store';
$active = 'products';
$topbarTitle = 'Add Product';

ob_start();
?>
<form method="post" action="<?= url('store/products') ?>" enctype="multipart/form-data" data-validate>
  <?= csrf_field() ?>
  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-circle-info text-navy me-1"></i> Basic Information</div>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select" id="category_id" name="category_id">
          <option value="">Select Category</option>
          <?php foreach ($categories as $cat): ?>
          <option value="<?= (int) $cat['id'] ?>"><?= clean($cat['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12"><?= skoolyst_input(['name' => 'name', 'label' => 'Product Name', 'required' => true, 'value' => $old['name'] ?? '', 'error' => $errors['name'] ?? null]) ?></div>
      <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'value' => $old['description'] ?? '']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-tag text-navy me-1"></i> Pricing &amp; Stock</div>
    <div class="row g-3">
      <div class="col-md-4"><?= skoolyst_input(['type' => 'number', 'name' => 'price', 'label' => 'Price (Rs.)', 'required' => true, 'value' => $old['price'] ?? '', 'error' => $errors['price'] ?? null]) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'number', 'name' => 'sale_price', 'label' => 'Sale Price (Rs.)', 'value' => $old['sale_price'] ?? '']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'number', 'name' => 'stock', 'label' => 'Stock Quantity', 'value' => $old['stock'] ?? '0']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-image text-navy me-1"></i> Media</div>
    <input type="file" class="form-control" name="image" accept="image/png,image/jpeg,image/webp">
    <?php if (!empty($errors['image'])): ?><div class="form-error"><?= clean($errors['image']) ?></div><?php endif; ?>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-toggle-on text-navy me-1"></i> Status</div>
    <div class="d-flex gap-3 flex-wrap">
      <?php foreach (['active' => 'Active', 'draft' => 'Draft', 'out_of_stock' => 'Out of Stock'] as $value => $label): ?>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-<?= $value ?>" value="<?= $value ?>" <?= $value === 'active' ? 'checked' : '' ?>>
        <label class="form-check-label" for="status-<?= $value ?>"><?= skoolyst_status_badge($label, $value) ?></label>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap mb-4">
    <?= skoolyst_btn('Save Product', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'fa-solid fa-check']) ?>
    <?= skoolyst_btn('Cancel', ['variant' => 'outline-secondary', 'href' => url('store/products')]) ?>
  </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/store-owner.php';
