<?php
/**
 * Admin/seller dashboard page shell. Views set $title, $active
 * (sidebar key), $topbarTitle, $topbarActions (optional HTML) and
 * $content (captured via ob_start) before requiring this layout.
 */
$extraCss = ['assets/css/admin.css'];
$topbarTitle = $topbarTitle ?? ($title ?? 'Dashboard');
$topbarActions = $topbarActions ?? '';
?>
<!doctype html>
<html lang="en">
<head>
<?php require __DIR__ . '/partials/head.php'; ?>
</head>
<body class="dashboard-body">
<div class="dashboard-layout">
<?php require __DIR__ . '/partials/sidebar.php'; ?>
  <div class="dashboard-main">
    <div class="dashboard-topbar">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" data-sidebar-toggle><i class="bi bi-list"></i></button>
        <h1 class="topbar-title"><?= clean($topbarTitle) ?></h1>
      </div>
      <div class="d-flex align-items-center gap-2">
        <?= $topbarActions ?>
        <div class="dropdown">
          <button class="btn btn-sm btn-light-navy dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person-circle me-1"></i> <?= clean(auth_user()['name'] ?? 'Admin') ?></button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="dashboard-content"><?= $content ?? '' ?></div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= url('assets/js/app.js') ?>"></script>
<script src="<?= url('assets/js/admin.js') ?>"></script>
<?php if (!empty($inlineScript)): ?>
<script><?= $inlineScript ?></script>
<?php endif; ?>
</body>
</html>
