<?php
/** Vars from AuthController::loginForm(): $errors (optional). */
$errors = $errors ?? [];
$title = 'Login — Skoolyst Store';
$description = 'Login to your Skoolyst Store account.';
$authHeading = 'Welcome Back!';
$authIntro = 'Login to manage your store listing on Skoolyst.';
$authFeatures = [];

ob_start();
?>
<div class="auth-logo mb-4">Skoolyst<span class="brand-accent">Store</span></div>
<h3 class="fs-5 mb-1">Login to your account</h3>
<p class="text-muted small mb-4">Enter your email and password to continue.</p>

<?php if (!empty($errors['email']) || !empty($errors['general'])): ?>
<?= skoolyst_alert($errors['general'] ?? $errors['email'], 'danger', 'bi-exclamation-triangle-fill') ?>
<?php endif; ?>

<form method="post" action="<?= url('login') ?>" data-validate>
  <?= csrf_field() ?>
  <?= skoolyst_input([
      'type' => 'email', 'name' => 'email', 'label' => 'Email',
      'required' => true, 'placeholder' => 'admin@skoolyst.pk',
  ]) ?>
  <div class="form-group">
    <label class="form-label" for="loginPass">Password</label>
    <input type="password" class="form-control" id="loginPass" name="password" required placeholder="••••••••">
  </div>
  <?= skoolyst_btn('Login', ['variant' => 'navy', 'class' => 'w-100 mb-3', 'type' => 'submit', 'icon' => 'bi-box-arrow-in-right']) ?>
</form>

<hr class="my-4">
<div class="text-center small">
  Don't have an account? <a href="<?= url('register') ?>" class="fw-semibold">Create one</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
