<?php
$title = 'Store Profile — Skoolyst Stores Dashboard';
$active = 'store-profile';
$topbarTitle = 'Store Profile';

ob_start();
?>
<form method="post" action="<?= url('admin/store-profile') ?>" data-validate>
  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-shop text-navy me-1"></i> Store Information</div>
    <div class="row g-3">
      <div class="col-md-8"><?= skoolyst_input(['name' => 'storeName', 'id' => 'sName', 'label' => 'Store Name', 'required' => true, 'value' => 'Student Essentials']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['name' => 'established', 'id' => 'sEst', 'label' => 'Established', 'value' => '2019']) ?></div>
      <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'storeDescription', 'id' => 'sDesc', 'label' => 'Store Description', 'value' => 'Your trusted destination for school uniforms, bags, stationery and everyday educational supplies.']) ?></div>
    </div>
    <hr class="my-3">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Store Logo</label>
        <div class="d-flex align-items-center gap-3">
          <div class="store-logo-wrap" style="width:64px;height:64px;border-radius:12px;border:2px solid var(--skoolyst-border)"><img src="https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200" alt="Store logo"></div>
          <?= skoolyst_btn('Change Logo', ['variant' => 'outline-navy', 'size' => 'sm']) ?>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Cover Image</label>
        <div class="upload-area" style="padding:1.5rem"><div class="upload-icon" style="font-size:1.5rem"><i class="bi bi-image"></i></div><p class="small mb-0">Click to upload cover image</p></div>
      </div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-telephone-fill text-navy me-1"></i> Contact</div>
    <div class="row g-3">
      <div class="col-md-4"><?= skoolyst_input(['type' => 'tel', 'name' => 'phone', 'id' => 'sPhone', 'label' => 'Phone', 'required' => true, 'value' => '+92 42 111 222 333']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'id' => 'sEmail', 'label' => 'Email', 'required' => true, 'value' => 'info@studentessentials.pk']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'url', 'name' => 'website', 'id' => 'sWeb', 'label' => 'Website', 'placeholder' => 'https://...']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-geo-alt-fill text-navy me-1"></i> Location</div>
    <div class="row g-3">
      <div class="col-12"><?= skoolyst_input(['name' => 'address', 'id' => 'sAddr', 'label' => 'Address', 'required' => true, 'value' => 'Main Boulevard, Gulberg III']) ?></div>
      <div class="col-md-4">
        <label class="form-label" for="sCity">City</label>
        <select class="form-select" id="sCity" name="city" required>
          <?php foreach (['Lahore', 'Karachi', 'Islamabad', 'Rawalpindi', 'Hyderabad', 'Faisalabad', 'Multan', 'Peshawar'] as $city): ?>
          <option><?= clean($city) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4"><?= skoolyst_input(['name' => 'area', 'id' => 'sArea', 'label' => 'Area', 'value' => 'Gulberg III']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['name' => 'postalCode', 'id' => 'sPostal', 'label' => 'Postal Code', 'value' => '54600']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-building-fill text-navy me-1"></i> Business Information</div>
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label" for="sCat">Store Category</label><select class="form-select" id="sCat" name="storeCategory"><option>School Supplies</option><option>Uniforms</option><option>Books</option><option>Stationery</option><option>Shoes</option><option>Bags</option></select></div>
      <div class="col-md-6"><label class="form-label" for="sType">Store Type</label><select class="form-select" id="sType" name="storeType"><option>Retail Store</option><option>Wholesale</option><option>Brand Outlet</option></select></div>
      <div class="col-md-6"><?= skoolyst_input(['type' => 'time', 'name' => 'openingTime', 'id' => 'sOpen', 'label' => 'Opening Time', 'value' => '09:00']) ?></div>
      <div class="col-md-6"><?= skoolyst_input(['type' => 'time', 'name' => 'closingTime', 'id' => 'sClose', 'label' => 'Closing Time', 'value' => '20:00']) ?></div>
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap mb-4">
    <?= skoolyst_btn('Save Changes', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'bi-check-lg']) ?>
    <?= skoolyst_btn('Reset', ['variant' => 'outline-secondary', 'type' => 'reset']) ?>
  </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
