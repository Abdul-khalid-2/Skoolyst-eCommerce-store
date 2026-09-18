<?php
/**
 * Auth page shell (login/register): left brand sidebar + right form card.
 * Views set $title, $authHeading, $authIntro, $authFeatures (array),
 * and $content (captured via ob_start, rendered inside .auth-card).
 */
$authHeading = $authHeading ?? 'Welcome!';
$authIntro = $authIntro ?? '';
$authFeatures = $authFeatures ?? [];
?>
<!doctype html>
<html lang="en">
<head>
<?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
<div class="auth-wrapper">
  <div class="auth-sidebar">
    <a href="<?= url('') ?>" class="text-decoration-none mb-4 d-inline-block">
      <div class="footer-brand" style="font-size:1.5rem">Skoolyst<span class="brand-accent">Stores</span></div>
    </a>
    <h2 class="mb-3"><?= clean($authHeading) ?></h2>
    <?php if ($authIntro): ?><p class="mb-4"><?= clean($authIntro) ?></p><?php endif; ?>
    <?php if ($authFeatures): ?>
    <ul class="list-unstyled auth-features">
      <?php foreach ($authFeatures as $feature): ?>
      <li><i class="bi bi-check-circle-fill"></i> <?= clean($feature) ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <div class="mt-auto small text-white-50 pt-4">&copy; <?= date('Y') ?> Skoolyst Stores</div>
  </div>
  <div class="auth-main">
    <div class="auth-card"><?= $content ?? '' ?></div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
