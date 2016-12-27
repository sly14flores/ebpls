<?php

$vdesc = "";
$vagency = "";

require '../config.php';

$vid = (isset($_GET['vid'])) ? $_GET['vid'] : 0;

$sql = "SELECT manage_verification_id, manage_verification_order, manage_verification_description, manage_verification_agency, (select department_name from departments where department_id = manage_verification_department) manage_verification_d, manage_verification_date, manage_verification_aid FROM manage_verification WHERE manage_verification_id = $vid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$vdesc = stripslashes($rec['manage_verification_description']);
	$vagency = stripslashes($rec['manage_verification_agency']);
}
db_close();

?>
<form role="form" id="frmVerification" onSubmit="return false;">
	<div class="form-group">
	<label for="manage_verification_description">Description</label>
	<input type="text" class="form-control" id="manage_verification_description" placeholder="Enter description" data-error="Please fill out description" value="<?php echo $vdesc; ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="manage_verification_agency">Office/Agency</label>
	<input type="text" class="form-control" id="manage_verification_agency" placeholder="Enter office/agency" data-error="Please fill out office/agency" value="<?php echo $vagency; ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="manage_verification_department">Department</label>
    <select id="manage_verification_department" class="form-control"></select>
	</div>
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Submit</button>
	</div>	
</form>