<?php
/** Vars from Admin\StoreController::edit()/update(): $store, $categories, $errors (optional). */
$errors = $errors ?? [];
$title = 'Edit Store — Skoolyst Store Admin';
$active = 'stores';
$topbarTitle = 'Edit Store';

ob_start();
?>
<form method="post" action="<?= url('admin/stores/' . $store['id'] . '/update') ?>" enctype="multipart/form-data" data-validate>
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
        <?php if (!empty($errors['logo'])): ?><div class="form-error"><?= clean($errors['logo']) ?></div><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-location-dot text-navy me-1"></i> Location</div>
    <div class="row g-3">
      <div class="col-md-6"><?= skoolyst_input(['name' => 'city', 'label' => 'City', 'value' => $store['city'] ?? '']) ?></div>
      <div class="col-md-6"><?= skoolyst_input(['name' => 'address', 'label' => 'Address', 'value' => $store['address'] ?? '']) ?></div>
      <div class="col-md-6">
        <label class="form-label" for="store_type">Store Type</label>
        <select class="form-select" id="store_type" name="store_type">
          <?php foreach (['retail' => 'Retail Store', 'wholesale' => 'Wholesale', 'brand_outlet' => 'Brand Outlet'] as $value => $label): ?>
          <option value="<?= $value ?>" <?= $store['store_type'] === $value ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-phone text-navy me-1"></i> Contact</div>
    <div class="row g-3">
      <div class="col-md-4"><?= skoolyst_input(['name' => 'phone', 'label' => 'Phone', 'value' => $store['phone'] ?? '']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'value' => $store['email'] ?? '', 'error' => $errors['email'] ?? null]) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'url', 'name' => 'website', 'label' => 'Website', 'value' => $store['website'] ?? '']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-toggle-on text-navy me-1"></i> Status</div>
    <div class="d-flex gap-3 flex-wrap">
      <?php foreach (['pending' => 'Pending', 'active' => 'Active', 'inactive' => 'Inactive'] as $value => $label): ?>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-<?= $value ?>" value="<?= $value ?>" <?= $store['status'] === $value ? 'checked' : '' ?>>
        <label class="form-check-label" for="status-<?= $value ?>"><?= skoolyst_status_badge($label, $value) ?></label>
      </div>
      <?php endforeach; ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="verified" id="verified" value="1" <?= $store['verified'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="verified">Verified store</label>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap mb-4">
    <?= skoolyst_btn('Save Changes', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'fa-solid fa-check']) ?>
    <?= skoolyst_btn('Cancel', ['variant' => 'outline-secondary', 'href' => url('admin/stores')]) ?>
  </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
