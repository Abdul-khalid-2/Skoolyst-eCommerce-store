<?php
$title = 'Server Error — Skoolyst Store';
$active = '';

ob_start();
?>
<section class="section-sm">
  <div class="container">
    <?= skoolyst_empty_state(
        'bi-exclamation-triangle',
        '500 — Something Went Wrong',
        'An unexpected error occurred on our end. Please try again shortly.',
        skoolyst_btn('Back to Home', ['variant' => 'navy', 'icon' => 'bi-house', 'href' => url('')])
    ) ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
