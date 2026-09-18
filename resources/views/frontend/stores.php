<?php
$title = 'Explore Stores — Skoolyst Stores';
$description = 'Find trusted stores for school and educational needs across Pakistan.';
$active = 'stores';

$stores = [
    ['name' => 'School Choice Store', 'city' => 'Karachi', 'rating' => 4.9, 'products' => 128, 'verified' => true, 'desc' => 'Your one-stop shop for quality school uniforms and accessories in Karachi.', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Student Essentials', 'city' => 'Lahore', 'rating' => 4.7, 'products' => 95, 'verified' => true, 'desc' => 'Trusted destination for school uniforms, bags, stationery and everyday educational supplies.', 'img' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Karachi School Mart', 'city' => 'Karachi', 'rating' => 4.8, 'products' => 76, 'verified' => true, 'desc' => 'Premium school shoes, bags and accessories for students of all ages.', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Education Point', 'city' => 'Islamabad', 'rating' => 4.6, 'products' => 112, 'verified' => false, 'desc' => 'Books, stationery and educational supplies for schools across Islamabad.', 'img' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Lahore Book Corner', 'city' => 'Lahore', 'rating' => 4.5, 'products' => 203, 'verified' => true, 'desc' => 'Textbooks, reference books and novels for all grade levels.', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Hyderabad Uniform House', 'city' => 'Hyderabad', 'rating' => 4.2, 'products' => 54, 'verified' => false, 'desc' => "Custom school uniforms stitched to your school's specifications.", 'img' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Faisalabad Stationery Mart', 'city' => 'Faisalabad', 'rating' => 4.6, 'products' => 167, 'verified' => true, 'desc' => 'Wholesale and retail stationery for schools, offices and students.', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Multan School Supplies', 'city' => 'Multan', 'rating' => 4.1, 'products' => 43, 'verified' => false, 'desc' => 'School supplies, bags and accessories at affordable prices in Multan.', 'img' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200'],
];

$stars = static function (float $rating): string {
    $full = (int) round($rating);
    $html = '';
    for ($i = 0; $i < 5; $i++) { $html .= '<i class="bi bi-star' . ($i < $full ? '-fill' : '') . '"></i>'; }
    return $html;
};

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Stores</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div><h1 class="mb-1">Explore Stores</h1><p class="text-muted mb-0">Find trusted stores for school and educational needs.</p></div>
      <div class="d-flex gap-2 align-items-center">
        <button class="btn btn-outline-navy btn-sm d-lg-none" data-filter-toggle><i class="bi bi-funnel"></i> Filters</button>
        <select class="form-select form-select-sm" style="width:auto">
          <option>Sort by: Top Rated</option><option>Sort by: Most Products</option><option>Sort by: Newest</option><option>Sort by: Name (A-Z)</option>
        </select>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 d-none d-lg-block" data-filter-sidebar>
        <div class="filter-sidebar sticky-top" style="top:80px">
          <div class="filter-group">
            <div class="filter-title">Search</div>
            <div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" class="form-control" placeholder="Search stores..."></div>
          </div>
          <div class="filter-group">
            <div class="filter-title">Location</div>
            <select class="form-select form-select-sm">
              <option value="">All Cities</option>
              <option>Karachi</option><option>Lahore</option><option>Islamabad</option>
              <option>Rawalpindi</option><option>Hyderabad</option><option>Faisalabad</option>
              <option>Multan</option><option>Peshawar</option>
            </select>
          </div>
          <div class="filter-group">
            <div class="filter-title">Category</div>
            <?php foreach (['Uniforms', 'Shoes', 'School Bags', 'Stationery', 'Books', 'Educational Supplies', 'Accessories'] as $i => $label): ?>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="cat<?= $i ?>"><label class="form-check-label" for="cat<?= $i ?>"><?= clean($label) ?></label></div>
            <?php endforeach; ?>
          </div>
          <div class="filter-group">
            <div class="filter-title">Store Type</div>
            <div class="form-check"><input class="form-check-input" type="radio" name="stype" id="stAll" checked><label class="form-check-label" for="stAll">All</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="stype" id="stRetail"><label class="form-check-label" for="stRetail">Retail Store</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="stype" id="stWholesale"><label class="form-check-label" for="stWholesale">Wholesale</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="stype" id="stBrand"><label class="form-check-label" for="stBrand">Brand Outlet</label></div>
          </div>
          <div class="filter-group">
            <div class="form-check"><input class="form-check-input" type="checkbox" id="verified" checked><label class="form-check-label" for="verified"><i class="bi bi-patch-check-fill verified-icon"></i> Verified stores only</label></div>
          </div>
          <?= skoolyst_btn('Clear All Filters', ['variant' => 'outline-navy', 'size' => 'sm', 'class' => 'w-100']) ?>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3"><span class="text-muted small">Showing 1–<?= count($stores) ?> of 42 stores</span></div>
        <div class="row g-3 g-lg-4">
          <?php foreach ($stores as $store): ?>
          <div class="col-md-6 col-xl-4">
            <div class="card card-hover store-card h-100">
              <div class="card-body d-flex flex-column gap-3">
                <div class="d-flex gap-3 align-items-center">
                  <div class="store-logo-wrap"><img src="<?= clean($store['img']) ?>" alt="<?= clean($store['name']) ?> logo"></div>
                  <div>
                    <h5 class="mb-0 fs-6"><?= clean($store['name']) ?> <?php if ($store['verified']): ?><i class="bi bi-patch-check-fill verified-icon"></i><?php endif; ?></h5>
                    <div class="small text-muted"><i class="bi bi-geo-alt"></i> <?= clean($store['city']) ?></div>
                    <div class="stars mt-1"><?= $stars($store['rating']) ?> <span class="rating-num ms-1"><?= $store['rating'] ?></span></div>
                  </div>
                </div>
                <p class="small text-muted mb-0"><?= clean($store['desc']) ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <?= skoolyst_badge($store['products'] . ' products', 'navy') ?>
                  <?= skoolyst_btn('View Store', ['variant' => 'navy', 'size' => 'sm', 'href' => url('store')]) ?>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <?= skoolyst_pagination(1, 5, url('stores'), 'Store pagination') ?>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
