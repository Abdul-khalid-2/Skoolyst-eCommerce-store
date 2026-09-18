<?php
$title = 'Settings — Skoolyst Stores Dashboard';
$active = 'settings';
$topbarTitle = 'Settings';

ob_start();
?>
<ul class="nav sk-tabs mb-4" role="tablist">
  <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabGeneral">General</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabStore">Store</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabNotif">Notifications</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabSecurity">Security</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane fade show active" id="tabGeneral">
    <form method="post" action="<?= url('admin/settings') ?>" data-validate>
      <div class="form-card">
        <div class="form-card-title"><i class="bi bi-person text-navy me-1"></i> Account Information</div>
        <div class="row g-3">
          <div class="col-md-6"><?= skoolyst_input(['name' => 'fullName', 'label' => 'Full Name', 'required' => true, 'value' => 'Ayesha Khan']) ?></div>
          <div class="col-md-6"><?= skoolyst_input(['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true, 'value' => 'ayesha@studentessentials.pk']) ?></div>
          <div class="col-md-6"><?= skoolyst_input(['type' => 'tel', 'name' => 'phone', 'label' => 'Phone', 'value' => '+92 42 111 222 333']) ?></div>
          <div class="col-md-6">
            <label class="form-label" for="setLang">Language</label>
            <select class="form-select" id="setLang"><option>English</option><option>Urdu</option></select>
          </div>
        </div>
      </div>
      <?= skoolyst_btn('Save Changes', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'bi-check-lg']) ?>
    </form>
  </div>

  <div class="tab-pane fade" id="tabStore">
    <div class="form-card">
      <div class="form-card-title"><i class="bi bi-shop text-navy me-1"></i> Store Preferences</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="setCurrency">Currency</label><select class="form-select" id="setCurrency"><option>PKR (Rs.)</option><option>USD ($)</option></select></div>
        <div class="col-md-6"><label class="form-label" for="setTimezone">Timezone</label><select class="form-select" id="setTimezone"><option>Asia/Karachi (PKT)</option><option>Asia/Dubai (GST)</option></select></div>
        <div class="col-md-6"><?= skoolyst_input(['type' => 'number', 'name' => 'taxRate', 'id' => 'setTax', 'label' => 'Tax Rate (%)', 'value' => '0']) ?></div>
        <div class="col-md-6"><?= skoolyst_input(['type' => 'number', 'name' => 'deliveryFee', 'id' => 'setDelivery', 'label' => 'Default Delivery Fee (Rs.)', 'value' => '200']) ?></div>
        <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" id="setAutoAccept" checked><label class="form-check-label" for="setAutoAccept">Automatically accept new orders</label></div></div>
        <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" id="setFreeShip"><label class="form-check-label" for="setFreeShip">Free shipping on orders over Rs. 3,000</label></div></div>
      </div>
    </div>
    <?= skoolyst_btn('Save Store Settings', ['variant' => 'navy', 'icon' => 'bi-check-lg', 'attrs' => ['onclick' => "skShowToast('Store settings saved')"]]) ?>
  </div>

  <div class="tab-pane fade" id="tabNotif">
    <div class="form-card">
      <div class="form-card-title"><i class="bi bi-bell text-navy me-1"></i> Notification Preferences</div>
      <div class="d-flex flex-column gap-3">
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nNewOrder" checked><label class="form-check-label" for="nNewOrder">New order received</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nLowStock" checked><label class="form-check-label" for="nLowStock">Low stock alerts</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nReview"><label class="form-check-label" for="nReview">New customer reviews</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nMsg" checked><label class="form-check-label" for="nMsg">Customer messages</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nPromo"><label class="form-check-label" for="nPromo">Promotional tips and updates from Skoolyst</label></div>
        <hr>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nEmail" checked><label class="form-check-label" for="nEmail">Email notifications</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="nSms"><label class="form-check-label" for="nSms">SMS notifications</label></div>
      </div>
    </div>
    <?= skoolyst_btn('Save Preferences', ['variant' => 'navy', 'icon' => 'bi-check-lg', 'attrs' => ['onclick' => "skShowToast('Notification preferences saved')"]]) ?>
  </div>

  <div class="tab-pane fade" id="tabSecurity">
    <form method="post" action="<?= url('admin/settings/security') ?>" data-validate>
      <div class="form-card">
        <div class="form-card-title"><i class="bi bi-shield-lock text-navy me-1"></i> Change Password</div>
        <div class="row g-3">
          <div class="col-md-4"><?= skoolyst_input(['type' => 'password', 'name' => 'currentPassword', 'id' => 'curPass', 'label' => 'Current Password', 'required' => true]) ?></div>
          <div class="col-md-4"><?= skoolyst_input(['type' => 'password', 'name' => 'password', 'id' => 'newPass', 'label' => 'New Password', 'required' => true]) ?></div>
          <div class="col-md-4"><?= skoolyst_input(['type' => 'password', 'name' => 'confirmPassword', 'id' => 'confPass', 'label' => 'Confirm Password', 'required' => true, 'attrs' => ['data-match' => 'password']]) ?></div>
        </div>
      </div>
      <div class="form-card">
        <div class="form-card-title"><i class="bi bi-shield-check text-navy me-1"></i> Two-Factor Authentication</div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="twoFA"><label class="form-check-label" for="twoFA">Enable 2FA via SMS</label></div>
        <div class="small text-muted mt-1">Add an extra layer of security to your account.</div>
      </div>
      <?= skoolyst_btn('Update Security', ['variant' => 'navy', 'type' => 'submit', 'icon' => 'bi-check-lg']) ?>
    </form>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
