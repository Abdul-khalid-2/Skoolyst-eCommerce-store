<?php
/** Vars from Admin\CategoryController::index(): $categories. */
$title = 'Manage Categories — Skoolyst Store Admin';
$active = 'categories';
$topbarTitle = 'Categories';
$topbarActions = skoolyst_btn('Add Category', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'fa-solid fa-plus', 'href' => url('admin/categories/create')]);

ob_start();
?>
<?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>

<div class="dash-panel">
  <?= skoolyst_table_open(['Category', 'Stores', 'Action']) ?>
  <?php foreach ($categories as $cat): ?>
  <tr>
    <td><i class="fa-solid <?= clean($cat['icon'] ?: 'fa-tag') ?> text-navy me-2"></i><?= clean($cat['name']) ?></td>
    <td><?= (int) $cat['store_count'] ?></td>
    <td>
      <form method="post" action="<?= url('admin/categories/' . $cat['id'] . '/delete') ?>" onsubmit="return confirm('Delete this category?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-sm btn-light-navy text-danger" <?= $cat['store_count'] > 0 ? 'disabled title="Cannot delete a category with stores"' : '' ?>><i class="fa-solid fa-trash"></i></button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?php if (!$categories): ?>
    <?= skoolyst_empty_state('bi-tags', 'No categories yet', 'Add a category to organize your store listings.') ?>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
