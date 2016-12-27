<?php

require '../config.php';

$application_id = (isset($_GET['application_id'])) ? $_GET['application_id'] : 0;

$application_no = "";
$sql = "SELECT application_no FROM applications WHERE application_id = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$application_no = $rec['application_no'];
}
db_close();


?>
<form class="form-horizontal" role="form" id="frmBusinessStatus" onSubmit="return false;">
<fieldset>
<legend>App. No.: <?php echo $application_no; ?></legend>
<div class="form-group" style="margin-top: 15px; margin-bottom: 15px;">
<label for="business_status" class="col-sm-2 control-label">Status:</label>
<div class="col-sm-10">
<select id="business_status" class="form-control">
<option value="operating">Operating</option>
<option value="not_renewed">Not Renewed</option>
<option value="closed_terminated">Closed/Terminated</option>
<option value="delinquent">Delinquent</option>
</select>
</div>
</div>
</fieldset>
</form>