<?php
$title = 'Session Expired — Skoolyst Store';
$active = '';

ob_start();
?>
<section class="section-sm">
  <div class="container">
    <?= skoolyst_empty_state(
        'bi-clock-history',
        '419 — Session Expired',
        'Your form session expired. Please go back and try again.',
        skoolyst_btn('Back to Home', ['variant' => 'navy', 'icon' => 'bi-house', 'href' => url('')])
    ) ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
