<?php

$odesc = "";
$oref = "";
$onote = "";

require '../config.php';

$o_id = (isset($_GET['o_id'])) ? $_GET['o_id'] : 0;

$sql = "SELECT assessment_id, assessment_order, assessment_type, assessment_description, assessment_reference, assessment_note, assessment_date, assessment_aid FROM assessments WHERE assessment_type = 'others' AND assessment_id = $o_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$odesc = stripslashes($rec['assessment_description']);
	$oref = stripslashes($rec['assessment_reference']);
	$onote = $rec['assessment_note'];
}
db_close();

?>
<form role="form" id="frmOther" onSubmit="return false;">
	<div class="form-group">
	<label for="assessment_description">Description</label>
	<input type="text" class="form-control" id="assessment_description" placeholder="Enter description" data-error="Please fill out description" value="<?php echo $odesc; ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="assessment_reference">Reference</label>
	<input type="text" class="form-control" id="assessment_reference" placeholder="Enter reference (optional)" value="<?php echo $oref; ?>">
	</div>
	<div class="form-group">
	<label for="assessment_note">Note</label>
	<input type="text" class="form-control" id="assessment_note" placeholder="Enter note (optional)" value="<?php echo $onote; ?>">
	</div>	
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Submit</button>
	</div>	
</form>