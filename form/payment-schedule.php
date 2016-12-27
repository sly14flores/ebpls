<?php

require '../config.php';

$pay_id = (isset($_GET['pay_id'])) ? $_GET['pay_id'] : 0;
$src = (isset($_GET['src'])) ? $_GET['src'] : 1;

$payment_schedule_or = "";
$payment_schedule_date_paid = date("m/d/Y");

$sql = "SELECT payment_schedule_or, payment_schedule_date_paid, (SELECT application_date FROM applications WHERE application_id = payment_schedule_fid) payment_schedule_application_date FROM billing WHERE payment_schedule_id = $pay_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$payment_schedule_or = $rec['payment_schedule_or'];
	$payment_schedule_date_paid = $rec['payment_schedule_date_paid'];
	if (($src == 1) && ($payment_schedule_date_paid == "0000-00-00")) $payment_schedule_date_paid = $rec['payment_schedule_application_date'];
	if (($src == 2) && ($payment_schedule_date_paid == "0000-00-00")) $payment_schedule_date_paid = date("m/d/Y");
	if ($payment_schedule_date_paid != "0000-00-00") $payment_schedule_date_paid = date("m/d/Y",strtotime($payment_schedule_date_paid));
}
db_close();

?>
<form role="form" id="frmPayment" onSubmit="return false;">
	<div class="form-group">
	<label for="payment_schedule_or">OR. No.</label>
	<input type="text" class="form-control" id="payment_schedule_or" placeholder="Enter OR no." data-error="Please fill out OR no." value="<?php echo $payment_schedule_or; ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
		<label for="payment_schedule_date_paid">OR. Date</label>
		<div id="payment_schedule_date_paid_dt" class="input-group date">			
		<input id="payment_schedule_date_paid" class="form-control" type="text" placeholder="" value="<?php echo $payment_schedule_date_paid; ?>">
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
	</div>	
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Ok</button>
	</div>	
</form>