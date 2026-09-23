<?php
/**
 * Vars provided by HomeController::index(): $categories, $featuredStores, $recentStores, $cities.
 */
$title = "Skoolyst Store — Find Trusted School Uniform, Shoe & Stationery Stores";
$description = "Discover school uniforms, shoes, bags, stationery, books and educational essentials from trusted stores across Pakistan.";
$active = 'home';

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
        <span class="badge bg-accent mb-3 px-3 py-2">Pakistan's Education Store Directory</span>
        <h1 class="mb-3">Find Trusted Stores for Everything Students Need</h1>
        <p class="hero-sub mb-4">Discover school uniform, shoe, bag, stationery and book stores near you, browse what they offer, and get in touch directly.</p>
        <form action="<?= url('stores') ?>" method="get" class="d-flex flex-wrap gap-2 mb-4">
          <input type="text" name="q" class="form-control" style="max-width:320px" placeholder="Search stores by name...">
          <button type="submit" class="btn btn-accent"><i class="bi bi-search me-2"></i>Search Stores</button>
        </form>
        <div class="d-flex flex-wrap gap-3">
          <a href="<?= url('stores') ?>" class="btn btn-outline-light btn-lg"><i class="bi bi-shop me-2"></i>Browse All Stores</a>
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
      <h2>Browse by Category</h2>
      <a href="<?= url('stores') ?>">View all stores <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-3">
      <?php foreach ($categories as $cat): ?>
      <div class="col-6 col-md-3 col-lg">
        <a href="<?= url('stores/category/' . $cat['slug']) ?>" class="card card-hover text-decoration-none">
          <div class="card-body category-card">
            <div class="cat-icon"><i class="fa-solid <?= clean($cat['icon'] ?: 'fa-shop') ?>"></i></div>
            <div class="cat-name"><?= clean($cat['name']) ?></div>
            <div class="small text-muted"><?= (int) $cat['store_count'] ?> stores</div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ($cities): ?>
<section class="section bg-light-surface">
  <div class="container">
    <div class="section-heading">
      <h2>Browse by City</h2>
      <a href="<?= url('stores') ?>">View all stores <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="d-flex flex-wrap gap-2">
      <?php foreach ($cities as $c): ?>
      <a href="<?= url('stores/city/' . slugify($c['city'])) ?>" class="badge bg-light text-dark border px-3 py-2 text-decoration-none">
        <i class="bi bi-geo-alt me-1"></i><?= clean($c['city']) ?> <span class="text-muted">(<?= (int) $c['store_count'] ?>)</span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section">
  <div class="container">
    <div class="section-heading">
      <h2>Featured Stores</h2>
      <a href="<?= url('stores') ?>">View all stores <i class="bi bi-arrow-right"></i></a>
    </div>
    <?php if (!$featuredStores): ?>
      <?= skoolyst_empty_state('bi-shop', 'No stores yet', 'Store listings will appear here once added.') ?>
    <?php else: ?>
    <div class="row g-4">
      <?php foreach ($featuredStores as $store): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card card-hover store-card h-100">
          <div class="card-body d-flex flex-column gap-3">
            <div class="d-flex gap-3 align-items-center">
              <div class="store-logo-wrap"><img src="<?= clean($store['logo'] ?: 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200') ?>" alt="<?= clean($store['name']) ?> logo"></div>
              <div>
                <h5 class="mb-0 fs-6"><?= clean($store['name']) ?> <?php if ($store['verified']): ?><i class="bi bi-patch-check-fill verified-icon" title="Verified"></i><?php endif; ?></h5>
                <div class="small text-muted"><i class="bi bi-geo-alt"></i> <?= clean($store['city'] ?? '') ?></div>
                <div class="stars mt-1" title="Skoolyst listing score, not a customer review"><?= $stars((float) $store['rating']) ?> <span class="rating-num ms-1"><?= number_format((float) $store['rating'], 1) ?></span> <span class="text-muted" style="font-size:.7em">Skoolyst Score</span></div>
              </div>
            </div>
            <p class="small text-muted mb-0"><?= clean(mb_strimwidth((string) $store['description'], 0, 110, '...')) ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <?= skoolyst_badge($store['store_type'] === 'wholesale' ? 'Wholesale' : 'Retail', 'navy') ?>
              <a href="<?= url('stores/' . $store['slug']) ?>" class="btn btn-sm btn-navy">View Store</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="text-center mb-4">
      <h2>Why Skoolyst Store?</h2>
      <p class="text-muted">A trusted directory built for Pakistani schools, parents and students to find the right store.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-shield-check"></i></div>
          <h5>Trusted Listings</h5>
          <p>Every store listing is reviewed before going live, with verified badges for established businesses.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-mortarboard"></i></div>
          <h5>Education-Focused</h5>
          <p>Uniforms, books, stationery, bags and supplies — find the right specialist store for what you need.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card feature-card h-100">
          <div class="feat-icon"><i class="bi bi-geo-alt"></i></div>
          <h5>Local Discovery</h5>
          <p>Filter by city and category to find stores that are actually close to you.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!is_store_admin() && !is_admin()): ?>
<section class="section">
  <div class="container">
    <div class="cta-section">
      <div class="position-relative" style="z-index:1">
        <h2 class="mb-3">Run a school uniform, shoe, stationery or book store?</h2>
        <p class="mb-4">Open your store on Skoolyst and get discovered by parents and students searching for what you sell.</p>
        <?= skoolyst_btn('Open Your Store', ['variant' => 'accent', 'size' => 'lg', 'icon' => 'bi-shop-window', 'href' => url(is_authenticated() ? 'store/create' : 'register')]) ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
