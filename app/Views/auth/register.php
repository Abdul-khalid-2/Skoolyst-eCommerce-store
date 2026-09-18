<?php
/** Vars from AuthController::registerForm(): $errors (optional), $old (optional). */
$errors = $errors ?? [];
$old = $old ?? [];
$title = 'Create Account — Skoolyst Store';
$description = 'Create your Skoolyst Store account.';
$authHeading = 'Join Skoolyst Store';
$authIntro = 'Create an account to manage your store listing on Skoolyst.';
$authFeatures = [];

ob_start();
?>
<div class="auth-logo mb-4">Skoolyst<span class="brand-accent">Store</span></div>
<h3 class="fs-5 mb-1">Create your account</h3>
<p class="text-muted small mb-4">Fill in your details to get started.</p>

<form method="post" action="<?= url('register') ?>" data-validate>
  <?= csrf_field() ?>
  <?= skoolyst_input(['name' => 'name', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'e.g. Ayesha Khan', 'value' => $old['name'] ?? '', 'error' => $errors['name'] ?? null]) ?>
  <?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true, 'placeholder' => 'ayesha@example.com', 'value' => $old['email'] ?? '', 'error' => $errors['email'] ?? null]) ?>
  <?= skoolyst_input(['type' => 'password', 'name' => 'password', 'label' => 'Password', 'required' => true, 'placeholder' => '••••••••', 'error' => $errors['password'] ?? null, 'hint' => 'At least 8 characters.']) ?>
  <?= skoolyst_input(['type' => 'password', 'name' => 'confirmPassword', 'label' => 'Confirm Password', 'required' => true, 'placeholder' => '••••••••', 'error' => $errors['confirmPassword'] ?? null]) ?>
  <?= skoolyst_btn('Create Account', ['variant' => 'accent', 'class' => 'w-100 mb-3', 'type' => 'submit', 'icon' => 'bi-person-plus']) ?>
</form>

<hr class="my-4">
<div class="text-center small">
  Already have an account? <a href="<?= url('login') ?>" class="fw-semibold">Login here</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
