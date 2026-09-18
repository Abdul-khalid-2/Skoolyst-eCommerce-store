<?php
$title = 'About Us — Skoolyst Store';
$description = 'Skoolyst Store is Pakistan\'s education store directory, connecting parents and students with trusted uniform, shoe, stationery and book stores.';
$active = '';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">About Us</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container" style="max-width:760px">
    <h1 class="mb-4">About Skoolyst Store</h1>

    <p>Skoolyst Store is a directory that connects parents, students and schools across Pakistan with independent stores selling school uniforms, shoes, bags, stationery and books. Rather than selling products ourselves, we help shoppers discover stores near them and get in touch directly with the store owner.</p>

    <h2 class="h4 mt-4">What we do</h2>
    <p>Store owners create a listing on Skoolyst Store describing their business, location and the products they carry. Shoppers can browse or search stores and products by category and city, then contact a store directly or place an order for delivery or pickup where the store supports it.</p>

    <h2 class="h4 mt-4">Listing review</h2>
    <p>New store listings are reviewed by our team before they go live, and stores that meet our verification checks display a "Verified" badge. This review covers listing accuracy and completeness — it is not a guarantee or endorsement of any store's products, pricing or service quality.</p>

    <h2 class="h4 mt-4">Get in touch</h2>
    <p>Questions about a listing, an order, or Skoolyst Store in general? Visit our <a href="<?= url('contact') ?>">Contact page</a> to reach us.</p>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
