<?php
$title = 'Privacy Policy — Skoolyst Store';
$description = 'How Skoolyst Store collects, uses and protects the information you provide when browsing, ordering or contacting us.';
$active = '';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container" style="max-width:760px">
    <h1 class="mb-2">Privacy Policy</h1>
    <p class="text-muted small mb-4">Last updated: <?= date('F Y') ?></p>

    <h2 class="h5 mt-4">Information we collect</h2>
    <p>When you create an account, place an order, or open a store on Skoolyst Store, we collect the information you provide directly, such as your name, phone number, email address and delivery address. If you save items to your favorites, that list is stored only in your browser session and is not saved to your account or our database.</p>

    <h2 class="h5 mt-4">How we use your information</h2>
    <ul>
      <li>To process and deliver orders you place through the platform, and to share the necessary order and contact details with the relevant store so they can fulfil it.</li>
      <li>To operate your account, including login and store owner dashboards.</li>
      <li>To respond to enquiries sent through our <a href="<?= url('contact') ?>">Contact page</a>.</li>
      <li>To maintain the security and reliability of the site.</li>
    </ul>

    <h2 class="h5 mt-4">Sharing your information</h2>
    <p>Order details (such as your name, phone number and delivery address) are shared with the store you are ordering from so they can fulfil and deliver your order. We do not sell your personal information to third parties.</p>

    <h2 class="h5 mt-4">Payment information</h2>
    <p>Skoolyst Store currently supports Cash on Delivery, paid directly to the courier or store. We do not collect or store card numbers or other payment card details. See our <a href="<?= url('terms') ?>">Terms of Service</a> for more on payment methods.</p>

    <h2 class="h5 mt-4">Data retention</h2>
    <p>We retain account and order information for as long as your account is active or as needed to resolve disputes and comply with our legal obligations.</p>

    <h2 class="h5 mt-4">Your choices</h2>
    <p>You can update your account details at any time while logged in. To request deletion of your account or data, contact us at <a href="mailto:hello@skoolyst.pk">hello@skoolyst.pk</a>.</p>

    <h2 class="h5 mt-4">Contact us</h2>
    <p>Questions about this policy can be sent to <a href="mailto:hello@skoolyst.pk">hello@skoolyst.pk</a> or via our <a href="<?= url('contact') ?>">Contact page</a>.</p>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
