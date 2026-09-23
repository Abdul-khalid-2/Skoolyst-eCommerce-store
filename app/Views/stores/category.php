<?php
/** Vars from StoreController::category(): $result, $category, $categories, $cities, $filters. */
require __DIR__ . '/_card.php';

$title = clean($category['name']) . ' Stores — Skoolyst Store';
$description = category_meta_description($category['name'], (int) $result['total']);
$active = 'stores';
$paginationBase = url('stores/category/' . $category['slug']);

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('stores') ?>">Stores</a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= clean($category['name']) ?></li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <h1 class="mb-1"><?= clean($category['name']) ?> Stores</h1>
    <p class="text-muted mb-0">Browse <?= (int) $result['total'] ?> trusted <?= clean(mb_strtolower($category['name'])) ?> store<?= (int) $result['total'] === 1 ? '' : 's' ?> on Skoolyst Store.</p>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3">
        <div class="filter-sidebar sticky-top" style="top:80px">
          <div class="filter-group">
            <div class="filter-title">Search within <?= clean($category['name']) ?></div>
            <form method="get" action="<?= url('stores/category/' . $category['slug']) ?>" class="input-group input-group-sm">
              <input type="text" name="q" class="form-control" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search stores...">
              <button type="submit" class="btn btn-outline-navy"><i class="bi bi-search"></i></button>
            </form>
          </div>
          <?php if ($categories): ?>
          <div class="filter-group">
            <div class="filter-title">Other Categories</div>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
              <?php foreach ($categories as $cat): ?>
                <?php if ((int) $cat['id'] === (int) $category['id']) continue; ?>
                <li><a href="<?= url('stores/category/' . $cat['slug']) ?>"><?= clean($cat['name']) ?> <span class="text-muted small">(<?= (int) $cat['store_count'] ?>)</span></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
          <?php if ($cities): ?>
          <div class="filter-group">
            <div class="filter-title">Browse by City</div>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
              <?php foreach (array_slice($cities, 0, 8) as $c): ?>
                <li><a href="<?= url('stores/city/' . slugify($c['city'])) ?>"><?= clean($c['city']) ?> <span class="text-muted small">(<?= (int) $c['store_count'] ?>)</span></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
          <a href="<?= url('stores') ?>" class="btn btn-sm btn-outline-navy w-100 mt-2">All Stores &amp; Filters</a>
        </div>
      </div>

      <div class="col-lg-9">
        <?php require __DIR__ . '/_results.php'; ?>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
