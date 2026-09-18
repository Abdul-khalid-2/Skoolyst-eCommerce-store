<?php
/** Vars from Admin\CategoryController::create()/store(): $errors (optional), $old (optional). */
$errors = $errors ?? [];
$old = $old ?? [];
$title = 'Add Category — Skoolyst Store Admin';
$active = 'categories';
$topbarTitle = 'Add Category';

ob_start();
?>
<form method="post" action="<?= url('admin/categories') ?>" data-validate>
  <?= csrf_field() ?>
  <div class="form-card">
    <div class="row g-3">
      <div class="col-md-8"><?= skoolyst_input(['name' => 'name', 'label' => 'Category Name', 'required' => true, 'value' => $old['name'] ?? '', 'error' => $errors['name'] ?? null, 'placeholder' => 'e.g. Uniforms']) ?></div>
      <div class="col-md-4"><?= skoolyst_input(['name' => 'icon', 'label' => 'Icon (Font Awesome class)', 'value' => $old['icon'] ?? '', 'placeholder' => 'fa-shirt', 'hint' => 'e.g. fa-shirt, fa-shoe-prints']) ?></div>
    </div>
  </div>
  <div class="d-flex gap-2 flex-wrap mb-4">
    <?= skoolyst_btn('Save Category', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'fa-solid fa-check']) ?>
    <?= skoolyst_btn('Cancel', ['variant' => 'outline-secondary', 'href' => url('admin/categories')]) ?>
  </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
