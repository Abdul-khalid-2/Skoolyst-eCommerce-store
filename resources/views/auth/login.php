<?php
$title = 'Login — Skoolyst Stores';
$description = 'Login to your Skoolyst Stores account.';
$authHeading = 'Welcome Back!';
$authIntro = 'Login to continue shopping for school essentials from trusted stores across Pakistan.';
$authFeatures = [
    'Track your orders',
    'Save your favorite stores',
    'Faster checkout experience',
    'Exclusive deals and offers',
];

ob_start();
?>
<div class="auth-logo mb-4">Skoolyst<span class="brand-accent">Stores</span></div>
<h3 class="fs-5 mb-1">Login to your account</h3>
<p class="text-muted small mb-4">Enter your email/phone and password to continue.</p>

<form method="post" action="<?= url('login') ?>" data-validate>
  <?= skoolyst_input([
      'type' => 'email', 'name' => 'email', 'label' => 'Email or Phone',
      'required' => true, 'placeholder' => 'ayesha@example.com',
      'error' => 'Please enter a valid email address.',
  ]) ?>
  <div class="form-group">
    <label class="form-label d-flex justify-content-between align-items-center" for="loginPass">
      <span>Password</span>
      <a href="#" class="small text-decoration-none">Forgot password?</a>
    </label>
    <input type="password" class="form-control" id="loginPass" name="password" required placeholder="••••••••">
  </div>
  <div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
    <label class="form-check-label small" for="rememberMe">Remember me on this device</label>
  </div>
  <?= skoolyst_btn('Login', ['variant' => 'navy', 'class' => 'w-100 mb-3', 'type' => 'submit', 'icon' => 'bi-box-arrow-in-right']) ?>
</form>

<div class="text-center small text-muted my-3">— or —</div>
<div class="d-flex gap-2">
  <a href="#" class="btn btn-outline-secondary w-100 btn-sm"><i class="bi bi-google me-1"></i> Google</a>
  <a href="#" class="btn btn-outline-secondary w-100 btn-sm"><i class="bi bi-facebook me-1"></i> Facebook</a>
</div>

<hr class="my-4">
<div class="text-center small">
  Don't have an account? <a href="<?= url('register') ?>" class="fw-semibold">Create one</a>
</div>
<div class="text-center mt-3">
  <a href="<?= url('admin/dashboard') ?>" class="small text-muted text-decoration-none"><i class="bi bi-speedometer2 me-1"></i> Seller Dashboard</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
