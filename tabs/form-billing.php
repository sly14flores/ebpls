<?php

$src = isset($_GET['src']) ? $_GET['src'] : 1;

require '../config.php';
require '../globalf.php';

$rbB = '<input type="button" onclick="recomputeBillingC();" class="btn btn-primary btn-sm" value="Recompute Payment">';

?>
<div id="billing-on"></div>
<div class="pull-right" style="margin-bottom: 15px;">
<?php echo $rbB; ?>
</div>
<div style="padding: 5px 0 5px 20px;">
<table id="form-billing" class="table table-striped">
<thead><tr><th>For</th><th>Type of Organization</th><th>Total Amount Due</th><th>Mode of Payment</th></tr></thead>
<tbody><tr><td><span id="application_form"></span></td><td><span id="application_organization_type"></span></td><td><span id="total_amount_due"></span</td><td><span id="application_mode_of_payment_desc"></span></td></tr></tbody>
</table>
<fieldset>
<legend>Payment Schedule</legend>
<table id="payment-schedule" class="table table-striped">
<thead><tr><th>#</th><th>Due Date</th><th>Amount Due</th><th>Penalty</th><th>OR#</th><th>Date Paid</th><th>Remarks</th><th>Action</th></tr></thead>
<tbody></tbody>
</table>
</fieldset>
</div>