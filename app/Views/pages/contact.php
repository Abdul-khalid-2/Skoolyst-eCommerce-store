<?php
$title = 'Contact Us — Skoolyst Store';
$description = 'Get in touch with the Skoolyst Store team for questions about listings, orders or the platform.';
$active = '';

ob_start();
?>
<div class="sk-breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= url('') ?>">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
</ol></nav></div></div>

<section class="section-sm">
  <div class="container" style="max-width:760px">
    <h1 class="mb-4">Contact Us</h1>
    <p>Have a question about a store listing, an order, or Skoolyst Store in general? Reach out using the details below.</p>

    <div class="row g-4 mt-1">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6 mb-2"><i class="bi bi-envelope me-1"></i> Email</h2>
            <p class="mb-0"><a href="mailto:hello@skoolyst.pk">hello@skoolyst.pk</a></p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6 mb-2"><i class="bi bi-geo-alt me-1"></i> Location</h2>
            <p class="mb-0">Karachi, Pakistan</p>
          </div>
        </div>
      </div>
    </div>

    <p class="mt-4 text-muted small">For questions about a specific order — including delivery status, cash on delivery, or an order you placed with a particular store — please contact that store directly using the phone number or email shown on its store page, as Skoolyst Store does not fulfil orders itself.</p>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
