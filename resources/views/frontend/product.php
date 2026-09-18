<?php
$title = 'Premium School Backpack — Skoolyst Stores';
$description = 'Premium School Backpack — Water Resistant. Available at Student Essentials, Lahore. Rs. 2,500.';
$active = 'products';

$images = [
    'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=800',
    'https://images.pexels.com/photos/1294731/pexels-photo-1294731.jpeg?auto=compress&cs=tinysrgb&w=200',
    'https://images.pexels.com/photos/1152078/pexels-photo-1152078.jpeg?auto=compress&cs=tinysrgb&w=200',
    'https://images.pexels.com/photos/636243/pexels-photo-636243.jpeg?auto=compress&cs=tinysrgb&w=200',
];

$related = [
    ['name' => 'Kids School Trolley Bag', 'store' => 'Karachi School Mart', 'price' => 3200, 'img' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Insulated Water Bottle', 'store' => 'Student Essentials', 'price' => 950, 'img' => 'https://images.pexels.com/photos/1152078/pexels-photo-1152078.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => '3-Compartment Lunch Box', 'store' => 'Karachi School Mart', 'price' => 1100, 'oldPrice' => 1250, 'img' => 'https://images.pexels.com/photos/636243/pexels-photo-636243.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['name' => 'Complete Stationery Set', 'store' => 'Education Point', 'price' => 750, 'img' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
];

$reviews = [
    ['initials' => 'AK', 'name' => 'Ayesha Khan', 'date' => '15 Jan 2026', 'rating' => 5, 'text' => "Best backpack I've bought for my daughter. Very spacious and the quality is excellent. The water resistance really works!"],
    ['initials' => 'MR', 'name' => 'Mohammad Raza', 'date' => '10 Jan 2026', 'rating' => 5, 'text' => 'Great quality and fast delivery. My son loves it. The laptop sleeve is very handy.'],
    ['initials' => 'SI', 'name' => 'Sana Iqbal', 'date' => '5 Jan 2026', 'rating' => 4, 'text' => 'Good backpack but the straps could be a bit more padded. Overall satisfied with the purchase.'],
];

$stars = static function (int $rating): string {
    $html = '';
    for ($i = 0; $i < 5; $i++) { $html .= '<i class="bi bi-star' . ($i < $rating ? '-fill' : '') . '"></i>'; }
    return $html;
};

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('products') ?>">Products</a></li>
  <li class="breadcrumb-item"><a href="<?= url('products?cat=bags') ?>">School Bags</a></li>
  <li class="breadcrumb-item active" aria-current="page">Premium School Backpack</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="gallery-main"><img src="<?= clean($images[0]) ?>" alt="Premium School Backpack — main view" id="galleryMain"></div>
        <div class="gallery-thumbs">
          <?php foreach ($images as $i => $img): ?>
          <div class="gallery-thumb<?= $i === 0 ? ' active' : '' ?>"><img src="<?= clean($img) ?>" alt="Backpack view <?= $i + 1 ?>"></div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-lg-6">
        <?= skoolyst_badge('School Bags', 'navy') ?>
        <h1 class="mb-2 mt-2">Premium School Backpack — Water Resistant</h1>
        <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
          <div class="stars"><?= $stars(5) ?> <span class="rating-num ms-1">4.9 (85 reviews)</span></div>
          <span class="text-muted small">|</span>
          <span class="small text-success"><i class="bi bi-check-circle-fill"></i> In Stock</span>
        </div>
        <div class="d-flex align-items-baseline gap-3 mb-3">
          <span class="product-price" style="font-size:2rem">Rs. 2,500</span>
        </div>
        <p class="text-muted mb-3">Durable, water-resistant school backpack with multiple compartments, padded laptop sleeve, and ergonomic shoulder straps. Perfect for students of all ages. Available in multiple colors.</p>

        <div class="row g-2 mb-3">
          <?php foreach (['Water resistant material', 'Padded laptop sleeve', 'Ergonomic straps', 'Multiple compartments'] as $feat): ?>
          <div class="col-6"><div class="small"><i class="bi bi-check-circle text-success me-1"></i> <?= clean($feat) ?></div></div>
          <?php endforeach; ?>
        </div>

        <hr>
        <div class="row g-3 align-items-center mb-3">
          <div class="col-auto"><label class="fw-semibold small">Color:</label></div>
          <div class="col-auto"><select class="form-select form-select-sm" style="width:auto"><option>Navy Blue</option><option>Black</option><option>Red</option><option>Grey</option></select></div>
        </div>
        <div class="row g-3 align-items-center mb-4">
          <div class="col-auto"><label class="fw-semibold small">Quantity:</label></div>
          <div class="col-auto">
            <div class="quantity-selector">
              <button data-qty-btn="minus" aria-label="Decrease quantity">−</button>
              <input type="text" value="1" data-qty aria-label="Quantity">
              <button data-qty-btn="plus" aria-label="Increase quantity">+</button>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mb-4">
          <button class="btn btn-navy btn-lg flex-grow-1" data-add-cart data-name="Premium School Backpack" data-price="2500" data-store="Student Essentials" data-img="<?= clean($images[0]) ?>"><i class="bi bi-bag-plus me-2"></i>Add to Cart</button>
          <a href="<?= url('checkout') ?>" class="btn btn-accent btn-lg flex-grow-1"><i class="bi bi-lightning-fill me-2"></i>Buy Now</a>
        </div>

        <div class="d-flex gap-3 flex-wrap">
          <span class="small text-muted"><i class="bi bi-truck text-navy me-1"></i> Free delivery over Rs. 3,000</span>
          <span class="small text-muted"><i class="bi bi-shield-check text-navy me-1"></i> Quality guaranteed</span>
          <span class="small text-muted"><i class="bi bi-arrow-repeat text-navy me-1"></i> 7-day returns</span>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body d-flex align-items-center gap-3 flex-wrap">
            <div class="store-logo-wrap" style="width:56px;height:56px;border-width:2px"><img src="https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200" alt="Student Essentials logo"></div>
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0">Student Essentials</h6>
                <i class="bi bi-patch-check-fill verified-icon"></i>
              </div>
              <div class="small text-muted"><i class="bi bi-geo-alt"></i> Lahore | <span class="stars"><?= $stars(5) ?></span> 4.7 | 95 products</div>
            </div>
            <?= skoolyst_btn('View Store', ['variant' => 'outline-navy', 'size' => 'sm', 'href' => url('store')]) ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-8">
        <ul class="nav sk-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#desc">Description</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specs">Specifications</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prodReviews">Reviews (85)</a></li>
        </ul>
        <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="desc">
            <p>This premium school backpack is designed for durability and comfort. Made from high-quality water-resistant polyester fabric, it features multiple compartments to keep books, stationery and supplies organized. The padded laptop sleeve fits devices up to 15 inches, while the ergonomic shoulder straps ensure comfortable carrying even when fully loaded.</p>
            <p>The backpack also includes side mesh pockets for water bottles, a front organizer pocket for small items, and a reinforced bottom for extra durability. Perfect for school, college and everyday use.</p>
          </div>
          <div class="tab-pane fade" id="specs">
            <table class="table table-borderless" style="max-width:500px">
              <tbody>
                <?php foreach ([
                    'Material' => 'Polyester (Water Resistant)', 'Capacity' => '30 Liters',
                    'Laptop Sleeve' => 'Up to 15 inches', 'Compartments' => '3 Main + 2 Front',
                    'Colors Available' => 'Navy, Black, Red, Grey', 'Warranty' => '6 months', 'Brand' => 'Student Essentials',
                ] as $label => $value): ?>
                <tr><td class="fw-semibold text-muted" style="width:40%"><?= clean($label) ?></td><td><?= clean($value) ?></td></tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="prodReviews">
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
            <div class="text-center mt-3"><?= skoolyst_btn('Load More Reviews', ['variant' => 'outline-navy', 'size' => 'sm']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <div class="section-heading"><h2>Related Products</h2><a href="<?= url('products?cat=bags') ?>">View all <i class="bi bi-arrow-right"></i></a></div>
      <div class="row g-3 g-lg-4">
        <?php foreach ($related as $p): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card card-hover product-card h-100">
            <a href="<?= url('product') ?>" class="text-decoration-none">
              <div class="product-img-wrap">
                <img src="<?= clean($p['img']) ?>" alt="<?= clean($p['name']) ?>">
                <?php if (!empty($p['oldPrice'])): ?><span class="badge badge-discount position-absolute top-0 start-0 m-2">-12%</span><?php endif; ?>
              </div>
            </a>
            <div class="card-body d-flex flex-column gap-1">
              <a href="<?= url('product') ?>" class="product-title text-decoration-none text-reset"><?= clean($p['name']) ?></a>
              <div class="store-name"><i class="bi bi-shop"></i> <?= clean($p['store']) ?></div>
              <div class="d-flex align-items-baseline gap-2">
                <span class="product-price">Rs. <?= number_format($p['price']) ?></span>
                <?php if (!empty($p['oldPrice'])): ?><span class="product-old-price">Rs. <?= number_format($p['oldPrice']) ?></span><?php endif; ?>
              </div>
              <button class="btn btn-sm btn-navy mt-1" data-add-cart data-name="<?= clean($p['name']) ?>" data-price="<?= (int) $p['price'] ?>" data-store="<?= clean($p['store']) ?>" data-img="<?= clean($p['img']) ?>"><i class="bi bi-bag-plus me-1"></i>Add to Cart</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
