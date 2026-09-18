<?php
$title = 'Validation Error — Skoolyst Store';
$active = '';

ob_start();
?>
<section class="section-sm">
  <div class="container">
    <?= skoolyst_empty_state(
        'bi-exclamation-circle',
        '422 — Validation Error',
        'Some of the submitted data was invalid. Please go back and check the form.',
        skoolyst_btn('Back to Home', ['variant' => 'navy', 'icon' => 'bi-house', 'href' => url('')])
    ) ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
