<?php
/** Vars from StoreController::city(): $result, $city, $cityStoreCount, $categories, $cities, $filters. */
require __DIR__ . '/_card.php';

$title = 'Stores in ' . clean($city) . ' — Skoolyst Store';
$description = city_meta_description($city, (int) $result['total']);
$active = 'stores';
$paginationBase = url('stores/city/' . slugify($city));

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('stores') ?>">Stores</a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= clean($city) ?></li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <h1 class="mb-1">Stores in <?= clean($city) ?></h1>
    <p class="text-muted mb-0">Browse <?= (int) $result['total'] ?> trusted store<?= (int) $result['total'] === 1 ? '' : 's' ?> in <?= clean($city) ?> selling school uniforms, shoes, bags, stationery and books.</p>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3">
        <div class="filter-sidebar sticky-top" style="top:80px">
          <div class="filter-group">
            <div class="filter-title">Search in <?= clean($city) ?></div>
            <form method="get" action="<?= url('stores/city/' . slugify($city)) ?>" class="input-group input-group-sm">
              <input type="text" name="q" class="form-control" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search stores...">
              <button type="submit" class="btn btn-outline-navy"><i class="bi bi-search"></i></button>
            </form>
          </div>
          <?php if ($categories): ?>
          <div class="filter-group">
            <div class="filter-title">Browse by Category</div>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
              <?php foreach ($categories as $cat): ?>
                <li><a href="<?= url('stores/category/' . $cat['slug']) ?>"><?= clean($cat['name']) ?> <span class="text-muted small">(<?= (int) $cat['store_count'] ?>)</span></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
          <?php if ($cities): ?>
          <div class="filter-group">
            <div class="filter-title">Other Cities</div>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
              <?php foreach ($cities as $c): ?>
                <?php if (slugify($c['city']) === slugify($city)) continue; ?>
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
