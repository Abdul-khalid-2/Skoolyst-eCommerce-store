<?php
$title = 'Terms of Service — Skoolyst Store';
$description = 'The terms that apply when you browse, order from, or list a store on Skoolyst Store.';
$active = '';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Terms of Service</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container" style="max-width:760px">
    <h1 class="mb-2">Terms of Service</h1>
    <p class="text-muted small mb-4">Last updated: <?= date('F Y') ?></p>

    <h2 class="h5 mt-4">What Skoolyst Store is</h2>
    <p>Skoolyst Store is a directory platform that lists independent school uniform, shoe, stationery and book stores. Stores listed on the platform are independent businesses, not owned or operated by Skoolyst Store. When you place an order, you are entering into that transaction with the store, and the store is responsible for fulfilling it.</p>

    <h2 class="h5 mt-4">Store listings and verification</h2>
    <p>Store listings are reviewed before publication, and stores that pass our verification checks display a "Verified" badge. This review confirms basic listing accuracy; it is not a guarantee of a store's stock, pricing, or service quality, and Skoolyst Store is not a party to the sale between you and the store.</p>

    <h2 class="h5 mt-4">Payment methods</h2>
    <p>Cash on Delivery is fully supported today — you pay the store or courier when your order is delivered or picked up. Online Payment can be selected at checkout as your intended method, but no online payment gateway is connected yet, so no card or wallet payment is actually processed through the platform at this time. We will update this page when that changes.</p>

    <h2 class="h5 mt-4">Orders and delivery</h2>
    <p>Order fulfilment, delivery timelines and delivery fees are set out at checkout. Because stores are independent, delivery times and availability can vary by store and location.</p>

    <h2 class="h5 mt-4">Returns and refunds</h2>
    <p>Returns, exchanges and refunds are handled directly by the store you ordered from. See our <a href="<?= url('returns') ?>">Returns &amp; Refunds</a> page for details.</p>

    <h2 class="h5 mt-4">Account responsibilities</h2>
    <p>You are responsible for keeping your account credentials secure and for the accuracy of the information you provide, including delivery details at checkout.</p>

    <h2 class="h5 mt-4">Changes to these terms</h2>
    <p>We may update these terms from time to time. Continued use of Skoolyst Store after changes are posted means you accept the updated terms.</p>

    <h2 class="h5 mt-4">Contact us</h2>
    <p>Questions about these terms can be sent to <a href="mailto:hello@skoolyst.pk">hello@skoolyst.pk</a> or via our <a href="<?= url('contact') ?>">Contact page</a>.</p>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
