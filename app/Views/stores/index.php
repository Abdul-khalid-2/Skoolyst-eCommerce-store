<?php
/** Vars from StoreController::index(): $result, $categories, $filters. */
require __DIR__ . '/_card.php';

$title = 'Browse Stores — Skoolyst Store';
$description = 'Find trusted school uniform, shoe, bag, stationery and book stores near you.';
$active = 'stores';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Stores</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <h1 class="mb-1">Browse Stores</h1>
    <p class="text-muted mb-0">Find trusted stores for school and educational needs.</p>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3">
        <form method="get" action="<?= url('stores') ?>" class="filter-sidebar sticky-top" style="top:80px" id="storeFilterForm">
          <div class="filter-group">
            <div class="filter-title">Search</div>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" name="q" class="form-control" value="<?= clean($filters['q'] ?? '') ?>" placeholder="Search stores...">
            </div>
          </div>
          <div class="filter-group">
            <div class="filter-title">Category</div>
            <select class="form-select form-select-sm" name="category">
              <option value="">All Categories</option>
              <?php foreach ($categories as $cat): ?>
              <option value="<?= (int) $cat['id'] ?>" <?= (int) ($filters['category_id'] ?? 0) === (int) $cat['id'] ? 'selected' : '' ?>><?= clean($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="filter-group">
            <div class="filter-title">Store Type</div>
            <?php foreach (['' => 'All', 'retail' => 'Retail Store', 'wholesale' => 'Wholesale', 'brand_outlet' => 'Brand Outlet'] as $value => $label): ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="type" id="type-<?= clean($value ?: 'all') ?>" value="<?= clean($value) ?>" <?= (($filters['store_type'] ?? '') === $value) ? 'checked' : '' ?>>
              <label class="form-check-label" for="type-<?= clean($value ?: 'all') ?>"><?= clean($label) ?></label>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="filter-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="verified" id="verifiedOnly" value="1" <?= !empty($filters['verified_only']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="verifiedOnly"><i class="bi bi-patch-check-fill verified-icon"></i> Verified stores only</label>
            </div>
          </div>
          <button type="submit" class="btn btn-sm btn-navy w-100">Apply Filters</button>
          <a href="<?= url('stores') ?>" class="btn btn-sm btn-outline-navy w-100 mt-2">Clear All Filters</a>
        </form>
      </div>

      <div class="col-lg-9">
        <div id="storeResults">
          <?php require __DIR__ . '/_results.php'; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
