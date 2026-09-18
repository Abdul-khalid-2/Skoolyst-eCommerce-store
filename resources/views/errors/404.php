<?php
$title = 'Page Not Found — Skoolyst Stores';
$active = '';

ob_start();
?>
<section class="section-sm">
  <div class="container">
    <?= skoolyst_empty_state(
        'bi-signpost-split',
        '404 — Page Not Found',
        "The page you're looking for doesn't exist or may have been moved.",
        skoolyst_btn('Back to Home', ['variant' => 'navy', 'icon' => 'bi-house', 'href' => url('')])
    ) ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
