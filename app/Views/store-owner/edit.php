<?php
/** Vars from StoreOwnerController::edit()/update(): $store, $categories, $errors (optional). */
$errors = $errors ?? [];
$title = 'Store Details — Skoolyst Store';
$active = 'store';
$topbarTitle = 'Store Details';

ob_start();
?>
<form method="post" action="<?= url('store/update') ?>" enctype="multipart/form-data" data-validate>
  <?= csrf_field() ?>
  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-store text-navy me-1"></i> Store Information</div>
    <div class="row g-3">
      <div class="col-md-8"><?= skoolyst_input(['name' => 'name', 'label' => 'Store Name', 'required' => true, 'value' => $store['name'], 'error' => $errors['name'] ?? null]) ?></div>
      <div class="col-md-4">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select" id="category_id" name="category_id">
          <option value="">Select Category</option>
          <?php foreach ($categories as $cat): ?>
          <option value="<?= (int) $cat['id'] ?>" <?= (int) $store['category_id'] === (int) $cat['id'] ? 'selected' : '' ?>><?= clean($cat['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'value' => $store['description'] ?? '']) ?></div>
      <div class="col-md-6">
        <label class="form-label">Store Logo</label>
        <div class="mb-2"><img data-file-preview src="<?= clean($store['logo'] ?: '') ?>" alt="" style="width:64px;height:64px;border-radius:12px;object-fit:cover;<?= $store['logo'] ? '' : 'display:none' ?>"></div>
        <input type="file" class="form-control" name="logo" accept="image/png,image/jpeg,image/webp">
      </div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-location-dot text-navy me-1"></i> Location &amp; Contact</div>
    <div class="row g-3">
      <div class="col-md-6"><?= skoolyst_input(['name' => 'city', 'label' => 'City', 'value' => $store['city'] ?? '']) ?></div>
      <div class="col-md-6"><?= skoolyst_input(['name' => 'address', 'label' => 'Address', 'value' => $store['address'] ?? '']) ?></div>
      <div class="col-md-4">
        <label class="form-label" for="store_type">Store Type</label>
        <select class="form-select" id="store_type" name="store_type">
          <?php foreach (['retail' => 'Retail Store', 'wholesale' => 'Wholesale', 'brand_outlet' => 'Brand Outlet'] as $value => $label): ?>
          <option value="<?= $value ?>" <?= $store['store_type'] === $value ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4"><?= skoolyst_input(['name' => 'phone', 'label' => 'Phone', 'value' => $store['phone'] ?? '']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'value' => $store['email'] ?? '', 'error' => $errors['email'] ?? null]) ?></div>
    </div>
  </div>

  <div class="alert alert-info small">
    <i class="bi bi-info-circle-fill me-1"></i> Approval status and verification are managed by Skoolyst admins and can't be changed here.
  </div>

  <?= skoolyst_btn('Save Changes', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'fa-solid fa-check', 'class' => 'mb-4']) ?>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/store-owner.php';
