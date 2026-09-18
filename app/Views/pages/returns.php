<?php
$title = 'Returns & Refunds — Skoolyst Store';
$description = 'How returns, exchanges and refunds work for orders placed with stores on Skoolyst Store.';
$active = '';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Returns &amp; Refunds</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container" style="max-width:760px">
    <h1 class="mb-4">Returns &amp; Refunds</h1>

    <p>Every store on Skoolyst Store is an independent business, so returns, exchanges and refunds are handled directly by the store you ordered from rather than by Skoolyst Store.</p>

    <h2 class="h5 mt-4">How to request a return or refund</h2>
    <ol>
      <li>Find the store's contact details on its store page, or check the "Sold by this store" section on the product you ordered.</li>
      <li>Contact the store directly with your order number (shown on your order confirmation) and the reason for the return.</li>
      <li>The store will let you know its return window, condition requirements, and whether an exchange or refund applies.</li>
    </ol>

    <h2 class="h5 mt-4">Cash on Delivery orders</h2>
    <p>Since Cash on Delivery orders are paid directly to the store or courier at delivery, any refund for those orders is issued by the store using the method they specify — this may be a bank transfer, store credit, or another arrangement agreed with the store.</p>

    <h2 class="h5 mt-4">If a store is unresponsive</h2>
    <p>If you're unable to reach a store about a return or refund, contact us at <a href="mailto:hello@skoolyst.pk">hello@skoolyst.pk</a> with your order number and we'll help you follow up.</p>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
