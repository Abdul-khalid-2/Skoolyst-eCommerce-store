<?php
$title = 'Student Essentials — Skoolyst Stores';
$description = 'Student Essentials — Your trusted destination for school uniforms, bags, stationery and everyday educational supplies in Lahore.';
$active = 'stores';

$featured = [
    ['name' => 'Premium School Backpack', 'rating' => 4.9, 'price' => 2500, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Insulated Water Bottle 750ml', 'rating' => 4.5, 'price' => 950, 'img' => 'https://images.pexels.com/photos/1152078/pexels-photo-1152078.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'School Uniform Set', 'rating' => 4.5, 'price' => 1850, 'oldPrice' => 2200, 'discount' => '-15%', 'img' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Complete Stationery Set 24 Pcs', 'rating' => 4.7, 'price' => 750, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
];
$allProducts = array_merge($featured, [
    ['name' => '3-Compartment Lunch Box', 'rating' => 4.3, 'price' => 1100, 'oldPrice' => 1250, 'discount' => '-12%', 'img' => 'https://images.pexels.com/photos/636243/pexels-photo-636243.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Mathematics Textbook Class 8', 'rating' => 4.4, 'price' => 680, 'img' => 'https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Black Leather School Shoes', 'rating' => 4.6, 'price' => 2200, 'img' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Mathematical Geometry Box 10 Pcs', 'rating' => 4.6, 'price' => 450, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
]);
$reviews = [
    ['initials' => 'AK', 'name' => 'Ayesha Khan', 'date' => '12 Jan 2026', 'rating' => 5, 'text' => 'Excellent quality uniforms and very friendly staff. The delivery was quick and everything fit perfectly. Highly recommended for school shopping!'],
    ['initials' => 'MR', 'name' => 'Mohammad Raza', 'date' => '8 Jan 2026', 'rating' => 4, 'text' => 'Good products and reasonable prices. The backpack I bought for my son is very durable. Would shop here again.'],
    ['initials' => 'FA', 'name' => 'Fatima Ali', 'date' => '2 Jan 2026', 'rating' => 5, 'text' => 'Best stationery store in Lahore! They have everything my kids need for school. The staff helped me find exactly what I was looking for.'],
    ['initials' => 'SI', 'name' => 'Sana Iqbal', 'date' => '28 Dec 2025', 'rating' => 3, 'text' => 'Products are good but delivery took a bit longer than expected. Overall satisfied with the quality.'],
];
$ratingBreakdown = [5 => [68, 159], 4 => [22, 52], 3 => [7, 16], 2 => [2, 5], 1 => [1, 2]];

$stars = static function (int $rating): string {
    $html = '';
    for ($i = 0; $i < 5; $i++) { $html .= '<i class="bi bi-star' . ($i < $rating ? '-fill' : '') . '"></i>'; }
    return $html;
};

$productCard = static function (array $p) use ($stars): string {
    $discountBadge = !empty($p['discount']) ? '<span class="badge badge-discount position-absolute top-0 start-0 m-2">' . clean($p['discount']) . '</span>' : '';
    $oldPrice = !empty($p['oldPrice']) ? '<span class="product-old-price">Rs. ' . number_format($p['oldPrice']) . '</span>' : '';
    return '<div class="card card-hover product-card h-100">'
        . '<a href="' . url('product') . '" class="text-decoration-none"><div class="product-img-wrap"><img src="' . clean($p['img']) . '" alt="' . clean($p['name']) . '">' . $discountBadge . '</div></a>'
        . '<div class="card-body d-flex flex-column gap-1">'
        . '<a href="' . url('product') . '" class="product-title text-decoration-none text-reset">' . clean($p['name']) . '</a>'
        . '<div class="stars">' . $stars((int) round($p['rating'])) . ' <span class="rating-num">' . $p['rating'] . '</span></div>'
        . '<div class="d-flex align-items-baseline gap-2"><span class="product-price">Rs. ' . number_format($p['price']) . '</span>' . $oldPrice . '</div>'
        . '<button class="btn btn-sm btn-navy mt-1" data-add-cart data-name="' . clean($p['name']) . '" data-price="' . (int) $p['price'] . '" data-store="Student Essentials" data-img="' . clean($p['img']) . '"><i class="bi bi-bag-plus me-1"></i>Add to Cart</button>'
        . '</div></div>';
};

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('stores') ?>">Stores</a></li>
  <li class="breadcrumb-item active" aria-current="page">Student Essentials</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="store-header">
      <div class="store-cover"></div>
      <div class="store-body">
        <div class="store-logo-lg"><img src="https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=300" alt="Student Essentials logo"></div>
        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <h1 class="mb-0 fs-4">Student Essentials</h1>
            <?= skoolyst_badge('Verified', 'verified', 'bi-patch-check-fill') ?>
            <?= skoolyst_badge('Open Now', 'success', 'bi-circle-fill') ?>
          </div>
          <div class="d-flex gap-3 mt-2 flex-wrap">
            <span class="small text-muted"><i class="bi bi-geo-alt"></i> Lahore, Punjab</span>
            <span class="small text-muted"><span class="stars"><?= $stars(5) ?></span> 4.7 (234 reviews)</span>
            <span class="small text-muted"><i class="bi bi-bag"></i> 95 products</span>
            <span class="small text-muted"><i class="bi bi-clock"></i> Est. 2019</span>
          </div>
          <p class="text-muted mt-2 mb-0" style="max-width:600px">Your trusted destination for school uniforms, bags, stationery and everyday educational supplies.</p>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
          <button class="btn btn-outline-navy btn-sm" data-follow-btn data-follow-text="Follow"><i class="bi bi-bookmark-plus"></i> Follow</button>
          <a href="#contact" class="btn btn-navy btn-sm"><i class="bi bi-telephone"></i> Contact</a>
        </div>
      </div>
    </div>

    <ul class="nav store-tabs mt-3" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#home">Home</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#storeProducts">Products</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#about">About</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews</a></li>
    </ul>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="tab-content">

      <div class="tab-pane fade show active" id="home">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="section-heading"><h2>Featured Products</h2><a href="#storeProducts" data-bs-toggle="tab">View all <i class="bi bi-arrow-right"></i></a></div>
            <div class="row g-3">
              <?php foreach ($featured as $p): ?>
              <div class="col-6 col-md-4"><?= $productCard($p) ?></div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="dash-panel">
              <h5 class="panel-title">Store Information</h5>
              <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                <li><i class="bi bi-geo-alt text-navy me-2"></i> <span class="small"><strong>Location:</strong> Main Boulevard, Gulberg III, Lahore</span></li>
                <li><i class="bi bi-clock text-navy me-2"></i> <span class="small"><strong>Hours:</strong> Mon–Sat, 9am–8pm</span></li>
                <li><i class="bi bi-telephone text-navy me-2"></i> <span class="small"><strong>Phone:</strong> +92 42 111 222 333</span></li>
                <li><i class="bi bi-envelope text-navy me-2"></i> <span class="small"><strong>Email:</strong> info@studentessentials.pk</span></li>
                <li><i class="bi bi-calendar text-navy me-2"></i> <span class="small"><strong>Established:</strong> 2019</span></li>
                <li><i class="bi bi-tags text-navy me-2"></i> <span class="small"><strong>Categories:</strong> Uniforms, Bags, Stationery</span></li>
              </ul>
              <hr>
              <div class="d-flex gap-2 flex-wrap">
                <?php foreach (['Uniforms', 'Bags', 'Stationery', 'Supplies'] as $cat): ?>
                <?= skoolyst_badge($cat, 'navy') ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="storeProducts">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <div class="search-bar w-auto"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" class="form-control" placeholder="Search within store..."></div></div>
          <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width:auto"><option>All Categories</option><option>Uniforms</option><option>Bags</option><option>Stationery</option><option>Supplies</option></select>
            <select class="form-select form-select-sm" style="width:auto"><option>Sort: Featured</option><option>Price: Low to High</option><option>Price: High to Low</option><option>Top Rated</option><option>Newest</option></select>
          </div>
        </div>
        <div class="row g-3 g-lg-4">
          <?php foreach ($allProducts as $p): ?>
          <div class="col-6 col-md-4 col-lg-3"><?= $productCard($p) ?></div>
          <?php endforeach; ?>
        </div>
        <?= skoolyst_pagination(1, 3, url('store') . '?tab=storeProducts', 'Store products pagination') ?>
      </div>

      <div class="tab-pane fade" id="about">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="dash-panel">
              <h5 class="panel-title">About Student Essentials</h5>
              <p>Student Essentials has been serving the educational community in Lahore since 2019. We started as a small uniform shop and have grown into a trusted destination for school uniforms, bags, stationery and everyday educational supplies.</p>
              <p>Our mission is to make back-to-school shopping easy and affordable for parents across Punjab. We work directly with schools to ensure our uniforms meet their specifications, and we stock a wide range of products from trusted brands.</p>
              <h6 class="mt-4 mb-3">Why Choose Us?</h6>
              <div class="row g-3">
                <?php foreach (['School-approved uniforms', 'Quality guaranteed products', 'Competitive prices', 'Fast delivery across Lahore'] as $reason): ?>
                <div class="col-md-6"><div class="d-flex gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i><span class="small"><?= clean($reason) ?></span></div></div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="dash-panel" id="contact">
              <h5 class="panel-title">Contact Information</h5>
              <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                <li><i class="bi bi-geo-alt text-navy me-2"></i><span class="small">Main Boulevard, Gulberg III, Lahore</span></li>
                <li><i class="bi bi-telephone text-navy me-2"></i><span class="small">+92 42 111 222 333</span></li>
                <li><i class="bi bi-envelope text-navy me-2"></i><span class="small">info@studentessentials.pk</span></li>
                <li><i class="bi bi-clock text-navy me-2"></i><span class="small">Mon–Sat: 9am – 8pm<br>Sun: Closed</span></li>
              </ul>
              <hr>
              <div class="d-flex gap-2">
                <a href="#" class="btn btn-sm btn-outline-navy"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                <a href="#" class="btn btn-sm btn-outline-navy"><i class="bi bi-geo"></i> Directions</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="reviews">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="dash-panel text-center">
              <div class="display-5 fw-bold text-navy">4.7</div>
              <div class="stars fs-5"><?= $stars(5) ?></div>
              <p class="small text-muted mt-1">Based on 234 reviews</p>
              <hr>
              <?php foreach ($ratingBreakdown as $star => [$pct, $count]): ?>
              <div class="rating-bar"><span class="bar-label"><?= $star ?> star</span><div class="bar-track"><div class="bar-fill" style="width:<?= $pct ?>%"></div></div><span class="bar-count"><?= $count ?></span></div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="d-flex flex-column gap-3">
              <?php foreach ($reviews as $r): ?>
              <div class="review-card">
                <div class="d-flex gap-3">
                  <div class="review-avatar"><?= clean($r['initials']) ?></div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <div><strong><?= clean($r['name']) ?></strong> <span class="small text-muted ms-2"><?= clean($r['date']) ?></span></div>
                      <div class="stars"><?= $stars($r['rating']) ?></div>
                    </div>
                    <p class="small text-muted mt-2 mb-0"><?= clean($r['text']) ?></p>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="text-center mt-4"><?= skoolyst_btn('Load More Reviews', ['variant' => 'outline-navy']) ?></div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
