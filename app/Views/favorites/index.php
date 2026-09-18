<?php
/** Vars from FavoriteController::index(): $products. Favorites are session-only, not stored in the database. */
require __DIR__ . '/../products/_card.php';
$title = 'My Favorites — Skoolyst Store';
$description = 'Products you have saved on Skoolyst Store.';
$active = 'products';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">My Favorites</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container">
    <h1 class="mb-1">My Favorites</h1>
    <p class="text-muted mb-4">Saved for this browser session only — they'll be gone if you clear your session.</p>
    <?php if (!$products): ?>
      <?= skoolyst_empty_state(
          'bi-heart',
          'No favorites yet',
          "Tap the heart icon on any product to save it here for quick access.",
          skoolyst_btn('Browse Products', ['variant' => 'navy', 'icon' => 'bi-bag', 'href' => url('products')])
      ) ?>
    <?php else: ?>
    <div class="row g-4">
      <?php foreach ($products as $product): ?>
        <?= render_product_card($product) ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
