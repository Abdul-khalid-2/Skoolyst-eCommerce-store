<?php
/** Vars from StoreController::show(): $store, $products, $reviews. */
require __DIR__ . '/../products/_card.php';

$title = clean($store['name']) . ' — Skoolyst Store';
$description = store_meta_description($store);
$active = 'stores';

$stars = static function (float $rating): string {
    $full = (int) round($rating);
    $html = '';
    for ($i = 0; $i < 5; $i++) {
        $html .= '<i class="bi bi-star' . ($i < $full ? '-fill' : '') . '"></i>';
    }
    return $html;
};

// No aggregateRating here on purpose: the "Skoolyst Score" is an internal
// listing score, not a customer-review aggregate, so it must not be
// represented as one in structured data.
$storeSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Store',
    'name' => $store['name'],
    'url' => url('stores/' . $store['slug']),
    'description' => $store['description'] ?: ($store['name'] . ' on Skoolyst Store.'),
];
if (!empty($store['logo'])) {
    $storeSchema['image'] = media_url($store['logo']);
}
if (!empty($store['address']) || !empty($store['city'])) {
    $storeSchema['address'] = array_filter([
        '@type' => 'PostalAddress',
        'streetAddress' => $store['address'] ?: null,
        'addressLocality' => $store['city'] ?: null,
        'addressCountry' => 'PK',
    ]);
}
if (!empty($store['phone'])) {
    $storeSchema['telephone'] = $store['phone'];
}

ob_start();
?>
<script type="application/ld+json"><?= json_encode($storeSchema, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?></script>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?= url('stores') ?>">Stores</a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= clean($store['name']) ?></li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <div class="store-header">
      <div class="store-cover"></div>
      <div class="store-body">
        <div class="store-logo-lg"><img src="<?= clean(media_url($store['logo'], 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=300')) ?>" alt="<?= clean($store['name']) ?> logo"></div>
        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <h1 class="mb-0 fs-4"><?= clean($store['name']) ?></h1>
            <?php if ($store['verified']): ?><?= skoolyst_badge('Verified', 'verified', 'bi-patch-check-fill') ?><?php endif; ?>
            <?php if ($store['status'] === 'active'): ?><?= skoolyst_badge('Active', 'success', 'bi-circle-fill') ?><?php endif; ?>
          </div>
          <div class="d-flex gap-3 mt-2 flex-wrap">
            <?php if ($store['city']): ?><span class="small text-muted"><i class="bi bi-geo-alt"></i> <?= clean($store['city']) ?></span><?php endif; ?>
            <span class="small text-muted" title="Skoolyst listing score, not a customer review"><span class="stars"><?= $stars((float) $store['rating']) ?></span> <?= number_format((float) $store['rating'], 1) ?> Skoolyst Score</span>
            <?php if (!empty($store['category_name'])): ?><span class="small text-muted"><i class="bi bi-tag"></i> <?= clean($store['category_name']) ?></span><?php endif; ?>
          </div>
          <?php if ($store['description']): ?><p class="text-muted mt-2 mb-0" style="max-width:600px"><?= clean($store['description']) ?></p><?php endif; ?>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
          <?php if ($store['phone']): ?><a href="tel:<?= clean($store['phone']) ?>" class="btn btn-navy btn-sm"><i class="bi bi-telephone"></i> Contact</a><?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="section-heading"><h2>Products</h2></div>
        <?php if (!$products): ?>
          <?= skoolyst_empty_state('bi-box-seam', 'No products listed yet', 'This store has not added any products to their listing yet.') ?>
        <?php else: ?>
        <div class="row g-3 g-lg-4">
          <?php foreach ($products as $product): ?>
            <?php if ($product['status'] !== 'active') { continue; } ?>
            <?= render_product_card(array_merge($product, ['store_name' => $store['name'], 'store_slug' => $store['slug']])) ?>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="section-heading mt-5"><h2>Reviews</h2></div>
        <?php if ($msg = flash('success')): ?><?= skoolyst_alert($msg, 'success', 'bi-check-circle-fill') ?><?php endif; ?>
        <?php if ($errors = flash('errors')): ?>
          <?= skoolyst_alert(implode(' ', $errors), 'danger', 'bi-exclamation-triangle-fill') ?>
        <?php endif; ?>

        <?php if (!$reviews): ?>
          <?= skoolyst_empty_state('bi-chat-square-text', 'No reviews yet', 'Be the first to review this store.') ?>
        <?php else: ?>
        <div class="d-flex flex-column gap-3 mb-4">
          <?php foreach ($reviews as $review): ?>
          <div class="dash-panel">
            <div class="d-flex justify-content-between align-items-center">
              <span class="stars"><?= $stars((float) $review['rating']) ?></span>
              <span class="small text-muted"><?= clean($review['user_name'] ?? 'Guest') ?></span>
            </div>
            <?php if ($review['title']): ?><div class="fw-semibold mt-2"><?= clean($review['title']) ?></div><?php endif; ?>
            <?php if ($review['comment']): ?><p class="small text-muted mb-0 mt-1"><?= clean($review['comment']) ?></p><?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (is_authenticated()): ?>
        <div class="dash-panel">
          <h5 class="panel-title">Write a Review</h5>
          <form method="post" action="<?= url('stores/' . $store['slug'] . '/reviews') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label class="form-label small">Rating</label>
              <select name="rating" class="form-select form-select-sm" style="width:auto" required>
                <?php foreach ([5, 4, 3, 2, 1] as $value): ?>
                <option value="<?= $value ?>"><?= $value ?> Star<?= $value > 1 ? 's' : '' ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label small">Title (optional)</label>
              <input type="text" name="title" class="form-control form-control-sm" maxlength="160">
            </div>
            <div class="mb-3">
              <label class="form-label small">Comment (optional)</label>
              <textarea name="comment" class="form-control form-control-sm" rows="3" maxlength="2000"></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-navy">Submit Review</button>
          </form>
        </div>
        <?php else: ?>
          <p class="small text-muted"><a href="<?= url('login') ?>">Log in</a> to write a review for this store.</p>
        <?php endif; ?>
      </div>
      <div class="col-lg-4">
        <div class="dash-panel">
          <h5 class="panel-title">Store Information</h5>
          <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
            <?php if ($store['address']): ?><li><i class="bi bi-geo-alt text-navy me-2"></i> <span class="small"><?= clean($store['address']) ?></span></li><?php endif; ?>
            <?php if ($store['phone']): ?><li><i class="bi bi-telephone text-navy me-2"></i> <span class="small"><?= clean($store['phone']) ?></span></li><?php endif; ?>
            <?php if ($store['email']): ?><li><i class="bi bi-envelope text-navy me-2"></i> <span class="small"><?= clean($store['email']) ?></span></li><?php endif; ?>
            <?php if ($store['website']): ?><li><i class="bi bi-globe text-navy me-2"></i> <a class="small" href="<?= clean($store['website']) ?>" target="_blank" rel="noopener"><?= clean($store['website']) ?></a></li><?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
