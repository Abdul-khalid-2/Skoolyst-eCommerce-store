<?php
/**
 * Storefront page shell. Views set $title, $description, $active and
 * $content (captured via ob_start) before requiring this layout.
 */
?>
<!doctype html>
<html lang="en">
<head>
<?php require __DIR__ . '/partials/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/partials/navbar.php'; ?>
<main><?= $content ?? '' ?></main>
<?php require __DIR__ . '/partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>window.SK_URL_BASE = <?= json_encode(url('')) ?>;</script>
<script src="<?= asset('js/app.js') ?>"></script>
<?php if (!empty($inlineScript)): ?>
<script><?= $inlineScript ?></script>
<?php endif; ?>
</body>
</html>
