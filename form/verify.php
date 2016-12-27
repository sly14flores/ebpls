<?php

require '../config.php';

$ver_id = (isset($_GET['ver_id'])) ? $_GET['ver_id'] : 0;
$verification_issued = date("m/d/Y");

$sql = "SELECT verification_issued FROM application_verifications WHERE verification_id = $ver_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['verification_issued'] != "0000-00-00 00:00:00") $verification_issued = date("m/d/Y",strtotime($rec['verification_issued']));
}
db_close();

?>

<form role="form" id="frmVerification" onSubmit="return false;">
	<div class="form-group">
	<label for="verification_issued">Date</label>
	<div id="verification_issued_dt" class="input-group date">	
	<input type="text" class="form-control" id="verification_issued" value="<?php echo $verification_issued; ?>">
	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>	
	</div>
	<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right">Submit</button>
	</div>	
</form>