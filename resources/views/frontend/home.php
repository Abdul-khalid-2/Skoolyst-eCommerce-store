<?php
$title = "Skoolyst Stores — Everything Students Need, From Trusted Stores";
$description = "Discover school uniforms, shoes, bags, stationery, books and educational essentials from trusted stores across Pakistan.";
$active = 'home';

$categories = [
    ['icon' => 'bi-person-badge', 'name' => 'Uniforms', 'cat' => 'uniforms'],
    ['icon' => 'bi-bag-heart', 'name' => 'Shoes', 'cat' => 'shoes'],
    ['icon' => 'bi-backpack', 'name' => 'School Bags', 'cat' => 'bags'],
    ['icon' => 'bi-pencil-ruler', 'name' => 'Stationery', 'cat' => 'stationery'],
    ['icon' => 'bi-book', 'name' => 'Books', 'cat' => 'books'],
    ['icon' => 'bi-rulers', 'name' => 'Supplies', 'cat' => 'supplies'],
    ['icon' => 'bi-watch', 'name' => 'Accessories', 'cat' => 'accessories'],
];

$stores = [
    ['name' => 'School Choice Store', 'city' => 'Karachi', 'rating' => 4.9, 'products' => 128, 'verified' => true, 'desc' => 'Your one-stop shop for quality school uniforms and accessories in Karachi.', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Student Essentials', 'city' => 'Lahore', 'rating' => 4.7, 'products' => 95, 'verified' => true, 'desc' => 'Trusted destination for school uniforms, bags, stationery and everyday educational supplies.', 'img' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Karachi School Mart', 'city' => 'Karachi', 'rating' => 4.8, 'products' => 76, 'verified' => true, 'desc' => 'Premium school shoes, bags and accessories for students of all ages.', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200'],
    ['name' => 'Education Point', 'city' => 'Islamabad', 'rating' => 4.6, 'products' => 112, 'verified' => false, 'desc' => 'Books, stationery and educational supplies for schools across Islamabad.', 'img' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200'],
];

$products = [
    ['name' => 'School Uniform Set', 'title' => 'School Uniform Set — White Shirt & Navy Trousers', 'store' => 'School Choice Store', 'rating' => 4.5, 'reviews' => 128, 'price' => 1850, 'oldPrice' => 2200, 'discount' => '-15%', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Premium School Backpack', 'title' => 'Premium School Backpack — Water Resistant', 'store' => 'Student Essentials', 'rating' => 4.9, 'reviews' => 85, 'price' => 2500, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Black Leather School Shoes', 'title' => 'Black Leather School Shoes — Size 32-38', 'store' => 'Karachi School Mart', 'rating' => 4.6, 'reviews' => 64, 'price' => 2200, 'oldPrice' => 2450, 'discount' => '-10%', 'img' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Complete Stationery Set', 'title' => 'Complete Stationery Set — 24 Pcs', 'store' => 'Education Point', 'rating' => 4.7, 'reviews' => 92, 'price' => 750, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Mathematics Textbook Class 8', 'title' => 'Mathematics Textbook — Class 8', 'store' => 'Education Point', 'rating' => 4.4, 'reviews' => 56, 'price' => 680, 'oldPrice' => 850, 'discount' => '-20%', 'img' => 'https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Insulated Water Bottle', 'title' => 'Insulated Water Bottle — 750ml', 'store' => 'Student Essentials', 'rating' => 4.5, 'reviews' => 43, 'price' => 950, 'img' => 'https://images.pexels.com/photos/1152078/pexels-photo-1152078.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => '3-Compartment Lunch Box', 'title' => '3-Compartment Lunch Box — BPA Free', 'store' => 'Karachi School Mart', 'rating' => 4.3, 'reviews' => 38, 'price' => 1100, 'oldPrice' => 1250, 'discount' => '-12%', 'img' => 'https://images.pexels.com/photos/636243/pexels-photo-636243.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Mathematical Geometry Box', 'title' => 'Mathematical Geometry Box — 10 Pcs', 'store' => 'School Choice Store', 'rating' => 4.6, 'reviews' => 71, 'price' => 450, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
];

$stars = static function (float $rating): string {
    $full = (int) round($rating);
    $html = '';
    for ($i = 0; $i < 5; $i++) {
        $html .= '<i class="bi bi-star' . ($i < $full ? '-fill' : '') . '"></i>';
    }
    return $html;
};

ob_start();
?>
<section class="hero-section">
  <div class="container position-relative">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <span class="badge bg-accent mb-3 px-3 py-2">Pakistan's Education Marketplace</span>
        <h1 class="mb-3">Everything Students Need, From Trusted Stores</h1>
        <p class="hero-sub mb-4">Discover school uniforms, shoes, bags, stationery, books and educational essentials from stores across Pakistan.</p>
        <div class="d-flex flex-wrap gap-3">
          <?= skoolyst_btn('Explore Stores', ['variant' => 'accent', 'size' => 'lg', 'icon' => 'bi-shop', 'href' => url('stores')]) ?>
          <?= skoolyst_btn('Browse Products', ['variant' => 'outline-light', 'size' => 'lg', 'icon' => 'bi-grid', 'href' => url('products')]) ?>
        </div>
        <div class="d-flex gap-4 mt-4 pt-2">
          <div><div class="fs-4 fw-bold">500+</div><div class="small text-white-50">Trusted Stores</div></div>
          <div><div class="fs-4 fw-bold">10,000+</div><div class="small text-white-50">Products</div></div>
          <div><div class="fs-4 fw-bold">8</div><div class="small text-white-50">Cities</div></div>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <div class="hero-img-wrap">
          <img src="https://images.pexels.com/photos/8617715/pexels-photo-8617715.jpeg?auto=compress&cs=tinysrgb&w=900" alt="Students with school supplies" loading="eager" style="width:100%;height:360px;object-fit:cover;">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-heading">
      <h2>Shop by Category</h2>
      <a href="<?= url('products') ?>">View all products <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-3">
      <?php foreach ($categories as $cat): ?>
      <div class="col-6 col-md-3 col-lg">
        <a href="<?= url('products?cat=' . $cat['cat']) ?>" class="card card-hover text-decoration-none">
          <div class="card-body category-card">
            <div class="cat-icon"><i class="bi <?= clean($cat['icon']) ?>"></i></div>
            <div class="cat-name"><?= clean($cat['name']) ?></div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section bg-light-surface">
  <div class="container">
    <div class="section-heading">
      <h2>Featured Stores</h2>
      <a href="<?= url('stores') ?>">View all stores <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
      <?php foreach ($stores as $store): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card card-hover store-card h-100">
          <div class="card-body d-flex flex-column gap-3">
            <div class="d-flex gap-3 align-items-center">
              <div class="store-logo-wrap"><img src="<?= clean($store['img']) ?>" alt="<?= clean($store['name']) ?> logo"></div>
              <div>
                <h5 class="mb-0 fs-6"><?= clean($store['name']) ?> <?php if ($store['verified']): ?><i class="bi bi-patch-check-fill verified-icon" title="Verified"></i><?php endif; ?></h5>
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
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-heading">
      <h2>Popular Products</h2>
      <a href="<?= url('products') ?>">View all products <i class="bi bi-arrow-right"></i></a>
    </div>
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
            <div class="store-name"><i class="bi bi-shop"></i> <?= clean($p['store']) ?></div>
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
  </div>
</section>

<section class="section bg-light-surface">
  <div class="container">
    <div class="text-center mb-4">
      <h2>Why Skoolyst Stores?</h2>
      <p class="text-muted">The trusted education marketplace built for Pakistani schools, parents and students.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-shield-check"></i></div>
          <h5>Trusted Stores</h5>
          <p>Every store is verified. Shop with confidence from established school-related businesses.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-mortarboard"></i></div>
          <h5>Education-Focused Products</h5>
          <p>Uniforms, books, stationery, bags and supplies — everything a student needs, in one place.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-bag-check"></i></div>
          <h5>Easy Shopping</h5>
          <p>Browse stores, compare products and checkout with cash on delivery or online payment.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-graph-up-arrow"></i></div>
          <h5>Growing Local Marketplace</h5>
          <p>Connecting schools, parents and businesses across 8 cities in Pakistan and growing.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-section">
      <div class="position-relative" style="z-index:1">
        <h2 class="mb-3">Are you a school-related business?</h2>
        <p class="mb-4">Create your store on Skoolyst and reach students, parents and schools across Pakistan.</p>
        <?= skoolyst_btn('Open Your Store', ['variant' => 'accent', 'size' => 'lg', 'icon' => 'bi-shop-window', 'href' => url('register')]) ?>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
