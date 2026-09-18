<?php
$title = 'Products — Skoolyst Stores Dashboard';
$active = 'products';
$topbarTitle = 'Products';
$topbarActions = skoolyst_btn('Add Product', ['variant' => 'accent', 'size' => 'sm', 'icon' => 'bi-plus-circle', 'href' => url('admin/products/create')]);

$products = [
    ['name' => 'School Uniform Set', 'sku' => 'UNI-001', 'cat' => 'Uniforms', 'price' => 'Rs. 1,850', 'stock' => 45, 'status' => 'active', 'label' => 'Active', 'updated' => '10 Sep', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'Premium School Backpack', 'sku' => 'BAG-002', 'cat' => 'Bags', 'price' => 'Rs. 2,500', 'stock' => 28, 'status' => 'active', 'label' => 'Active', 'updated' => '9 Sep', 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'Black Leather School Shoes', 'sku' => 'SHO-003', 'cat' => 'Shoes', 'price' => 'Rs. 2,200', 'stock' => 12, 'status' => 'active', 'label' => 'Active', 'updated' => '8 Sep', 'img' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'Complete Stationery Set', 'sku' => 'STA-004', 'cat' => 'Stationery', 'price' => 'Rs. 750', 'stock' => 0, 'status' => 'out-of-stock', 'label' => 'Out of Stock', 'updated' => '7 Sep', 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'Mathematics Textbook Class 8', 'sku' => 'BOO-005', 'cat' => 'Books', 'price' => 'Rs. 680', 'stock' => 56, 'status' => 'active', 'label' => 'Active', 'updated' => '6 Sep', 'img' => 'https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'Insulated Water Bottle', 'sku' => 'ACC-006', 'cat' => 'Accessories', 'price' => 'Rs. 950', 'stock' => 33, 'status' => 'draft', 'label' => 'Draft', 'updated' => '5 Sep', 'img' => 'https://images.pexels.com/photos/1152078/pexels-photo-1152078.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => '3-Compartment Lunch Box', 'sku' => 'ACC-007', 'cat' => 'Accessories', 'price' => 'Rs. 1,100', 'stock' => 19, 'status' => 'active', 'label' => 'Active', 'updated' => '4 Sep', 'img' => 'https://images.pexels.com/photos/636243/pexels-photo-636243.jpeg?auto=compress&cs=tinysrgb&w=100'],
    ['name' => 'School Tie', 'sku' => 'UNI-008', 'cat' => 'Uniforms', 'price' => 'Rs. 300', 'stock' => 87, 'status' => 'active', 'label' => 'Active', 'updated' => '3 Sep', 'img' => 'https://images.pexels.com/photos/259924/pexels-photo-259924.jpeg?auto=compress&cs=tinysrgb&w=100'],
];

ob_start();
?>
<div class="d-flex gap-2 mb-4 flex-wrap">
  <div class="flex-grow-1" style="min-width:200px"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" class="form-control" placeholder="Search products..."></div></div>
  <select class="form-select form-select-sm" style="width:auto"><option>All Categories</option><option>Uniforms</option><option>Shoes</option><option>Bags</option><option>Stationery</option><option>Books</option></select>
  <select class="form-select form-select-sm" style="width:auto"><option>All Status</option><option>Active</option><option>Draft</option><option>Out of Stock</option></select>
</div>

<div class="dash-panel">
  <?= skoolyst_table_open(['Product', 'Category', 'Price', 'Stock', 'Status', 'Updated', 'Actions']) ?>
  <?php foreach ($products as $p): ?>
  <tr>
    <td>
      <div class="d-flex align-items-center gap-2">
        <div style="width:40px;height:40px;border-radius:8px;overflow:hidden;flex-shrink:0"><img src="<?= clean($p['img']) ?>" alt="" style="width:100%;height:100%;object-fit:cover"></div>
        <div><div class="fw-semibold small"><?= clean($p['name']) ?></div><div class="small text-muted">SKU: <?= clean($p['sku']) ?></div></div>
      </div>
    </td>
    <td><?= clean($p['cat']) ?></td>
    <td><?= clean($p['price']) ?></td>
    <td><span class="fw-semibold"><?= $p['stock'] ?></span></td>
    <td><?= skoolyst_status_badge($p['label'], $p['status']) ?></td>
    <td class="small text-muted"><?= clean($p['updated']) ?></td>
    <td>
      <div class="dropdown">
        <button class="btn btn-sm btn-light-navy" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="<?= url('admin/products') ?>"><i class="bi bi-eye me-2"></i>View</a></li>
          <li><a class="dropdown-item" href="<?= url('admin/products/create') ?>"><i class="bi bi-pencil me-2"></i>Edit</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-2"></i>Delete</a></li>
        </ul>
      </div>
    </td>
  </tr>
  <?php endforeach; ?>
  <?= skoolyst_table_close() ?>
  <?= skoolyst_pagination(1, 3, url('admin/products'), 'Products pagination') ?>
</div>

<?= skoolyst_modal_open('deleteModal', 'Delete Product?') ?>
<p class="mb-0">Are you sure you want to delete this product? This action cannot be undone.</p>
<?= skoolyst_modal_footer(
    skoolyst_btn('Cancel', ['variant' => 'outline-navy', 'attrs' => ['data-bs-dismiss' => 'modal']])
    . skoolyst_btn('Delete', ['variant' => 'danger', 'attrs' => ['data-bs-dismiss' => 'modal']])
) ?>
<?= skoolyst_modal_close() ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
