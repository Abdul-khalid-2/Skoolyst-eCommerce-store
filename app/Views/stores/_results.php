<?php
/** Results grid + pagination fragment, shared by stores/index.php and stores/search.php (AJAX). Expects $result. */
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <span class="text-muted small">Showing <?= count($result['rows']) ?> of <?= $result['total'] ?> stores</span>
</div>
<?php if (!$result['rows']): ?>
  <?= skoolyst_empty_state('bi-shop-window', 'No stores found', 'Try adjusting your search or filters.') ?>
<?php else: ?>
<div class="row g-3 g-lg-4">
  <?php foreach ($result['rows'] as $store): ?>
  <?= render_store_card($store) ?>
  <?php endforeach; ?>
</div>
<?php
$queryWithoutPage = array_diff_key($_GET, ['page' => null]);
$baseUrl = url('stores') . ($queryWithoutPage ? '?' . http_build_query($queryWithoutPage) : '');
?>
<?= skoolyst_pagination($result['page'], $result['totalPages'], $baseUrl, 'Store pagination') ?>
<?php endif; ?>
