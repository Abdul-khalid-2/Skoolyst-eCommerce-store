<?php
/** Vars from ProductController::index(): $result, $filters. */
require __DIR__ . '/_card.php';

$title = 'Browse Products — Skoolyst Store';
$description = 'Browse school uniforms, shoes, bags, stationery and books listed by trusted stores.';
$active = 'products';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Products</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div><h1 class="mb-1">Browse Products</h1><p class="text-muted mb-0">School essentials from trusted stores.</p></div>
      <form method="get" action="<?= url('products') ?>" class="d-flex gap-2">
        <input type="text" name="q" class="form-control form-control-sm" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search products...">
        <button type="submit" class="btn btn-sm btn-navy">Search</button>
      </form>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted small">Showing <?= count($result['rows']) ?> of <?= $result['total'] ?> products</span>
    </div>
    <?php if (!$result['rows']): ?>
      <?= skoolyst_empty_state('bi-box-seam', 'No products found', 'Try a different search term.') ?>
    <?php else: ?>
    <div class="row g-3 g-lg-4">
      <?php foreach ($result['rows'] as $product): ?>
        <?= render_product_card($product) ?>
      <?php endforeach; ?>
    </div>
    <?php
    $queryWithoutPage = array_diff_key($_GET, ['page' => null]);
    $baseUrl = url('products') . ($queryWithoutPage ? '?' . http_build_query($queryWithoutPage) : '');
    ?>
    <?= skoolyst_pagination($result['page'], $result['totalPages'], $baseUrl, 'Products pagination') ?>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
