<?php
/** Vars from StoreOwnerController::create()/store(): $categories, $errors (optional), $old (optional). */
$errors = $errors ?? [];
$old = $old ?? [];
$title = 'Open a Store — Skoolyst Store';
$description = 'Open your store on Skoolyst and reach parents and students across Pakistan.';
$active = 'home';

ob_start();
?>
<section class="section-sm">
  <div class="container" style="max-width:760px">
    <h1 class="mb-1">Open a Store</h1>
    <p class="text-muted mb-4">Tell us about your store. It will go live once a Skoolyst admin reviews and approves it.</p>

    <form method="post" action="<?= url('store/create') ?>" enctype="multipart/form-data" data-validate>
      <?= csrf_field() ?>
      <div class="form-card">
        <div class="form-card-title"><i class="bi bi-shop text-navy me-1"></i> Store Information</div>
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
        <div class="form-card-title"><i class="bi bi-geo-alt text-navy me-1"></i> Location &amp; Contact</div>
        <div class="row g-3">
          <div class="col-md-6"><?= skoolyst_input(['name' => 'city', 'label' => 'City', 'value' => $old['city'] ?? '']) ?></div>
          <div class="col-md-6"><?= skoolyst_input(['name' => 'address', 'label' => 'Address', 'value' => $old['address'] ?? '']) ?></div>
          <div class="col-md-4">
            <label class="form-label" for="store_type">Store Type</label>
            <select class="form-select" id="store_type" name="store_type">
              <option value="retail">Retail Store</option>
              <option value="wholesale">Wholesale</option>
              <option value="brand_outlet">Brand Outlet</option>
            </select>
          </div>
          <div class="col-md-4"><?= skoolyst_input(['name' => 'phone', 'label' => 'Phone', 'value' => $old['phone'] ?? '']) ?></div>
          <div class="col-md-4"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'value' => $old['email'] ?? '', 'error' => $errors['email'] ?? null]) ?></div>
        </div>
      </div>

      <?= skoolyst_btn('Submit for Review', ['variant' => 'accent', 'type' => 'submit', 'icon' => 'bi-send', 'class' => 'mb-4']) ?>
    </form>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
