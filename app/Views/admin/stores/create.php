<?php
/** Vars from Admin\StoreController::create()/store(): $categories, $errors (optional), $old (optional). */
$errors = $errors ?? [];
$old = $old ?? [];
$title = 'Add Store — Skoolyst Store Admin';
$active = 'stores';
$topbarTitle = 'Add Store';

ob_start();
?>
<form method="post" action="<?= url('admin/stores') ?>" enctype="multipart/form-data" data-validate>
  <?= csrf_field() ?>
  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-store text-navy me-1"></i> Store Information</div>
    <div class="row g-3">
      <div class="col-md-8"><?= skoolyst_input(['name' => 'name', 'label' => 'Store Name', 'required' => true, 'value' => $old['name'] ?? '', 'error' => $errors['name'] ?? null]) ?></div>
      <div class="col-md-4">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select" id="category_id" name="category_id">
          <option value="">Select Category</option>
          <?php foreach ($categories as $cat): ?>
          <option value="<?= (int) $cat['id'] ?>"><?= clean($cat['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'value' => $old['description'] ?? '']) ?></div>
      <div class="col-md-6">
        <label class="form-label">Store Logo</label>
        <div class="mb-2"><img data-file-preview alt="" style="width:64px;height:64px;border-radius:12px;object-fit:cover;display:none"></div>
        <input type="file" class="form-control" name="logo" accept="image/png,image/jpeg,image/webp">
        <?php if (!empty($errors['logo'])): ?><div class="form-error"><?= clean($errors['logo']) ?></div><?php endif; ?>
      </div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-location-dot text-navy me-1"></i> Location</div>
    <div class="row g-3">
      <div class="col-md-6"><?= skoolyst_input(['name' => 'city', 'label' => 'City', 'value' => $old['city'] ?? '']) ?></div>
      <div class="col-md-6"><?= skoolyst_input(['name' => 'address', 'label' => 'Address', 'value' => $old['address'] ?? '']) ?></div>
      <div class="col-md-6">
        <label class="form-label" for="store_type">Store Type</label>
        <select class="form-select" id="store_type" name="store_type">
          <option value="retail">Retail Store</option>
          <option value="wholesale">Wholesale</option>
          <option value="brand_outlet">Brand Outlet</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-phone text-navy me-1"></i> Contact</div>
    <div class="row g-3">
      <div class="col-md-4"><?= skoolyst_input(['name' => 'phone', 'label' => 'Phone', 'value' => $old['phone'] ?? '']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'value' => $old['email'] ?? '', 'error' => $errors['email'] ?? null]) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'url', 'name' => 'website', 'label' => 'Website', 'value' => $old['website'] ?? '', 'placeholder' => 'https://...']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="fa-solid fa-toggle-on text-navy me-1"></i> Status</div>
    <div class="d-flex gap-3 flex-wrap">
      <?php foreach (['pending' => 'Pending', 'active' => 'Active', 'inactive' => 'Inactive'] as $value => $label): ?>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-<?= $value ?>" value="<?= $value ?>" <?= $value === 'pending' ? 'checked' : '' ?>>
        <label class="form-check-label" for="status-<?= $value ?>"><?= skoolyst_status_badge($label, $value) ?></label>
      </div>
      <?php endforeach; ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="verified" id="verified" value="1">
        <label class="form-check-label" for="verified">Verified store</label>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap mb-4">
    <?= skoolyst_btn('Save Store', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'fa-solid fa-check']) ?>
    <?= skoolyst_btn('Cancel', ['variant' => 'outline-secondary', 'href' => url('admin/stores')]) ?>
  </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
