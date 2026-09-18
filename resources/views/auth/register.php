<?php
$title = 'Create Account — Skoolyst Stores';
$description = 'Create your Skoolyst Stores account and start shopping or selling school essentials.';
$authHeading = 'Join Skoolyst Stores';
$authIntro = 'Create your account to shop for school essentials or open your own store and reach customers across Pakistan.';
$authFeatures = [
    'Shop from 500+ trusted stores',
    'Open your own store and sell',
    'Manage orders and inventory',
    'Reach parents and schools nationwide',
];

ob_start();
?>
<div class="auth-logo mb-4">Skoolyst<span class="brand-accent">Stores</span></div>
<h3 class="fs-5 mb-1">Create your account</h3>
<p class="text-muted small mb-4">Fill in your details to get started.</p>

<form method="post" action="<?= url('register') ?>" data-validate>
  <?= skoolyst_input(['name' => 'fullName', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'e.g. Ayesha Khan']) ?>
  <?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true, 'placeholder' => 'ayesha@example.com']) ?>
  <?= skoolyst_input(['type' => 'tel', 'name' => 'phone', 'label' => 'Phone', 'required' => true, 'placeholder' => '0300 1234567']) ?>
  <?= skoolyst_input(['type' => 'password', 'name' => 'password', 'label' => 'Password', 'required' => true, 'placeholder' => '••••••••']) ?>
  <?= skoolyst_input(['type' => 'password', 'name' => 'confirmPassword', 'label' => 'Confirm Password', 'required' => true, 'placeholder' => '••••••••', 'attrs' => ['data-match' => 'password']]) ?>
  <div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
    <label class="form-check-label small" for="agreeTerms">I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a></label>
  </div>
  <?= skoolyst_btn('Create Account', ['variant' => 'accent', 'class' => 'w-100 mb-3', 'type' => 'submit', 'icon' => 'bi-person-plus']) ?>
</form>

<hr class="my-4">
<div class="text-center small">
  Already have an account? <a href="<?= url('login') ?>" class="fw-semibold">Login here</a>
</div>
<div class="text-center mt-3">
  <a href="<?= url('admin/dashboard') ?>" class="small text-muted text-decoration-none"><i class="bi bi-speedometer2 me-1"></i> Seller Dashboard</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
