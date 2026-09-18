<?php
$title = 'Access Denied — Skoolyst Store';
$active = '';

ob_start();
?>
<section class="section-sm">
  <div class="container">
    <?= skoolyst_empty_state(
        'bi-shield-lock',
        '403 — Access Denied',
        "You don't have permission to view this page.",
        skoolyst_btn('Back to Home', ['variant' => 'navy', 'icon' => 'bi-house', 'href' => url('')])
    ) ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
