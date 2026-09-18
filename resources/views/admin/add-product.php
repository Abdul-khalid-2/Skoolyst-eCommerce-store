<?php
$title = 'Add Product — Skoolyst Stores Dashboard';
$active = 'add-product';
$topbarTitle = 'Add Product';

ob_start();
?>
<form method="post" action="<?= url('admin/products') ?>" data-validate>
  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-info-circle-fill text-navy me-1"></i> Basic Information</div>
    <div class="row g-3">
      <div class="col-md-8"><?= skoolyst_input(['name' => 'productName', 'label' => 'Product Name', 'required' => true, 'placeholder' => 'e.g. School Uniform Set']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['name' => 'sku', 'label' => 'SKU', 'placeholder' => 'e.g. UNI-001']) ?></div>
      <div class="col-md-6">
        <label class="form-label" for="pCat">Category</label>
        <select class="form-select" id="pCat" name="category" required>
          <option value="">Select Category</option>
          <?php foreach (['Uniforms', 'Shoes', 'School Bags', 'Stationery', 'Books', 'Educational Supplies', 'Accessories'] as $cat): ?>
          <option><?= clean($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12"><?= skoolyst_input(['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'placeholder' => 'Describe your product...']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-tag-fill text-navy me-1"></i> Pricing</div>
    <div class="row g-3">
      <div class="col-md-4"><?= skoolyst_input(['type' => 'number', 'name' => 'price', 'label' => 'Price (Rs.)', 'required' => true, 'placeholder' => '1850']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'number', 'name' => 'salePrice', 'label' => 'Sale Price (Rs.)', 'placeholder' => '1600']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['type' => 'number', 'name' => 'costPrice', 'label' => 'Cost Price (Rs.)', 'placeholder' => '1200']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-box-fill text-navy me-1"></i> Inventory</div>
    <div class="row g-3">
      <div class="col-md-6"><?= skoolyst_input(['type' => 'number', 'name' => 'stock', 'label' => 'Stock Quantity', 'required' => true, 'placeholder' => '50']) ?></div>
      <div class="col-md-6"><?= skoolyst_input(['type' => 'number', 'name' => 'lowStock', 'label' => 'Low Stock Threshold', 'placeholder' => '10']) ?></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-image-fill text-navy me-1"></i> Media</div>
    <div class="upload-area" onclick="document.getElementById('pImg').click()">
      <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
      <p>Click to upload product images or drag and drop</p>
      <p class="small text-muted">PNG, JPG up to 5MB. Recommended 800x800px.</p>
    </div>
    <input type="file" id="pImg" name="images[]" accept="image/*" multiple style="display:none">
    <div class="upload-preview">
      <div class="preview-item"><img src="https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200" alt="Preview 1"><button type="button" class="remove-btn"><i class="bi bi-x"></i></button></div>
      <div class="preview-item"><img src="https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=200" alt="Preview 2"><button type="button" class="remove-btn"><i class="bi bi-x"></i></button></div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-title"><i class="bi bi-toggle-on text-navy me-1"></i> Status</div>
    <div class="d-flex gap-3 flex-wrap">
      <div class="form-check"><input class="form-check-input" type="radio" name="status" id="stActive" value="active" checked><label class="form-check-label" for="stActive"><?= skoolyst_status_badge('Active', 'active') ?> <span class="small text-muted ms-1">Visible to customers</span></label></div>
      <div class="form-check"><input class="form-check-input" type="radio" name="status" id="stDraft" value="draft"><label class="form-check-label" for="stDraft"><?= skoolyst_status_badge('Draft', 'draft') ?> <span class="small text-muted ms-1">Hidden from store</span></label></div>
      <div class="form-check"><input class="form-check-input" type="radio" name="status" id="stOos" value="out-of-stock"><label class="form-check-label" for="stOos"><?= skoolyst_status_badge('Out of Stock', 'out-of-stock') ?> <span class="small text-muted ms-1">Marked unavailable</span></label></div>
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap mb-4">
    <?= skoolyst_btn('Save Product', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'bi-check-lg']) ?>
    <?= skoolyst_btn('Save as Draft', ['variant' => 'outline-navy', 'type' => 'submit', 'icon' => 'bi-file-earmark']) ?>
    <?= skoolyst_btn('Cancel', ['variant' => 'outline-secondary', 'href' => url('admin/products')]) ?>
  </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
