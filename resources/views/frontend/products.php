<?php
$title = 'Browse Products — Skoolyst Stores';
$description = 'Browse school uniforms, shoes, bags, stationery, books and educational supplies from trusted stores across Pakistan.';
$active = 'products';

$products = [
    ['name' => 'School Uniform Set', 'title' => 'School Uniform Set — White Shirt & Navy Trousers', 'store' => 'School Choice Store', 'verified' => true, 'rating' => 4.5, 'reviews' => 128, 'price' => 1850, 'oldPrice' => 2200, 'discount' => '-15%', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Premium School Backpack', 'title' => 'Premium School Backpack — Water Resistant', 'store' => 'Student Essentials', 'verified' => true, 'rating' => 4.9, 'reviews' => 85, 'price' => 2500, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Black Leather School Shoes', 'title' => 'Black Leather School Shoes — Size 32-38', 'store' => 'Karachi School Mart', 'verified' => true, 'rating' => 4.6, 'reviews' => 64, 'price' => 2200, 'oldPrice' => 2450, 'discount' => '-10%', 'img' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Complete Stationery Set', 'title' => 'Complete Stationery Set — 24 Pcs', 'store' => 'Education Point', 'verified' => false, 'rating' => 4.7, 'reviews' => 92, 'price' => 750, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Mathematics Textbook Class 8', 'title' => 'Mathematics Textbook — Class 8', 'store' => 'Education Point', 'verified' => false, 'rating' => 4.4, 'reviews' => 56, 'price' => 680, 'oldPrice' => 850, 'discount' => '-20%', 'img' => 'https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Insulated Water Bottle', 'title' => 'Insulated Water Bottle — 750ml', 'store' => 'Student Essentials', 'verified' => true, 'rating' => 4.5, 'reviews' => 43, 'price' => 950, 'img' => 'https://images.pexels.com/photos/1152078/pexels-photo-1152078.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => '3-Compartment Lunch Box', 'title' => '3-Compartment Lunch Box — BPA Free', 'store' => 'Karachi School Mart', 'verified' => true, 'rating' => 4.3, 'reviews' => 38, 'price' => 1100, 'oldPrice' => 1250, 'discount' => '-12%', 'img' => 'https://images.pexels.com/photos/636243/pexels-photo-636243.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Mathematical Geometry Box', 'title' => 'Mathematical Geometry Box — 10 Pcs', 'store' => 'School Choice Store', 'verified' => true, 'rating' => 4.6, 'reviews' => 71, 'price' => 450, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'English Grammar Book Class 6', 'title' => 'English Grammar Book — Class 6', 'store' => 'Lahore Book Corner', 'verified' => true, 'rating' => 4.5, 'reviews' => 48, 'price' => 520, 'img' => 'https://images.pexels.com/photos/159775/books-library-education-knowledge-159775.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'School Tie', 'title' => 'School Tie — Navy & Red Striped', 'store' => 'School Choice Store', 'verified' => true, 'rating' => 4.4, 'reviews' => 29, 'price' => 300, 'oldPrice' => 400, 'discount' => '-25%', 'img' => 'https://images.pexels.com/photos/259924/pexels-photo-259924.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Color Pencil Set 36 Colors', 'title' => 'Color Pencil Set — 36 Colors', 'store' => 'Faisalabad Stationery Mart', 'verified' => true, 'rating' => 4.7, 'reviews' => 61, 'price' => 650, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Kids School Trolley Bag', 'title' => 'Kids School Trolley Bag — 3 Wheels', 'store' => 'Karachi School Mart', 'verified' => true, 'rating' => 4.8, 'reviews' => 34, 'price' => 3200, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400'],
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
  <li class="breadcrumb-item active" aria-current="page">Products</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div><h1 class="mb-1">Browse Products</h1><p class="text-muted mb-0">School essentials from trusted stores across Pakistan.</p></div>
      <div class="d-flex gap-2 align-items-center">
        <button class="btn btn-outline-navy btn-sm d-lg-none" data-filter-toggle><i class="bi bi-funnel"></i> Filters</button>
        <select class="form-select form-select-sm" style="width:auto">
          <option>Sort: Featured</option><option>Price: Low to High</option><option>Price: High to Low</option><option>Top Rated</option><option>Newest</option>
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
            <div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" class="form-control" placeholder="Search products..."></div>
          </div>
          <div class="filter-group">
            <div class="filter-title">Category</div>
            <?php foreach (['Uniforms', 'Shoes', 'School Bags', 'Stationery', 'Books', 'Educational Supplies', 'Accessories'] as $i => $label): ?>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="pc<?= $i ?>"><label class="form-check-label" for="pc<?= $i ?>"><?= clean($label) ?></label></div>
            <?php endforeach; ?>
          </div>
          <div class="filter-group">
            <div class="filter-title">Store</div>
            <select class="form-select form-select-sm"><option value="">All Stores</option><option>School Choice Store</option><option>Student Essentials</option><option>Karachi School Mart</option><option>Education Point</option><option>Lahore Book Corner</option></select>
          </div>
          <div class="filter-group">
            <div class="filter-title">Price Range</div>
            <div class="d-flex gap-2">
              <input type="number" class="form-control form-control-sm" placeholder="Min" value="0">
              <input type="number" class="form-control form-control-sm" placeholder="Max" value="5000">
            </div>
            <div class="price-range-display"><span>Rs. 0</span><span>Rs. 5,000+</span></div>
          </div>
          <div class="filter-group">
            <div class="filter-title">Rating</div>
            <?php foreach ([4, 3, 2] as $i => $min): ?>
            <div class="form-check"><input class="form-check-input" type="radio" name="prating" id="pr<?= $min ?>" <?= $i === 0 ? 'checked' : '' ?>><label class="form-check-label" for="pr<?= $min ?>"><span class="stars"><?= $stars((float) $min) ?></span> & Up</label></div>
            <?php endforeach; ?>
          </div>
          <div class="filter-group">
            <div class="filter-title">Availability</div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="avIn" checked><label class="form-check-label" for="avIn">In Stock</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="avOut"><label class="form-check-label" for="avOut">Out of Stock</label></div>
          </div>
          <div class="filter-group">
            <div class="form-check"><input class="form-check-input" type="checkbox" id="pvVerified" checked><label class="form-check-label" for="pvVerified"><i class="bi bi-patch-check-fill verified-icon"></i> Verified stores only</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="pvDiscount"><label class="form-check-label" for="pvDiscount"><i class="bi bi-tag-fill text-danger"></i> On sale</label></div>
          </div>
          <?= skoolyst_btn('Clear All Filters', ['variant' => 'outline-navy', 'size' => 'sm', 'class' => 'w-100']) ?>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3"><span class="text-muted small">Showing 1–<?= count($products) ?> of 248 products</span></div>
        <div class="row g-3 g-lg-4">
          <?php foreach ($products as $p): ?>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-hover product-card h-100">
              <a href="<?= url('product') ?>" class="text-decoration-none">
                <div class="product-img-wrap">
                  <img src="<?= clean($p['img']) ?>" alt="<?= clean($p['name']) ?>">
                  <?php if (!empty($p['discount'])): ?><span class="badge badge-discount position-absolute top-0 start-0 m-2"><?= clean($p['discount']) ?></span><?php endif; ?>
                </div>
              </a>
              <div class="card-body d-flex flex-column gap-1">
                <a href="<?= url('product') ?>" class="product-title text-decoration-none text-reset"><?= clean($p['title']) ?></a>
                <div class="store-name"><i class="bi bi-shop"></i> <?= clean($p['store']) ?> <?php if ($p['verified']): ?><i class="bi bi-patch-check-fill verified-icon"></i><?php endif; ?></div>
                <div class="stars"><?= $stars($p['rating']) ?> <span class="rating-num"><?= $p['rating'] ?> (<?= $p['reviews'] ?>)</span></div>
                <div class="d-flex align-items-baseline gap-2 mt-1">
                  <span class="product-price">Rs. <?= number_format($p['price']) ?></span>
                  <?php if (!empty($p['oldPrice'])): ?><span class="product-old-price">Rs. <?= number_format($p['oldPrice']) ?></span><?php endif; ?>
                </div>
                <button class="btn btn-sm btn-navy mt-2 w-100" data-add-cart data-name="<?= clean($p['name']) ?>" data-price="<?= (int) $p['price'] ?>" data-store="<?= clean($p['store']) ?>" data-img="<?= clean($p['img']) ?>"><i class="bi bi-bag-plus me-1"></i>Add to Cart</button>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <?= skoolyst_pagination(1, 21, url('products'), 'Products pagination') ?>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
