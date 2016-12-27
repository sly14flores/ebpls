<?php

$signatory_for = "";
$signatory_name = "";

require '../config.php';

$signatory_id = (isset($_GET['signatory_id'])) ? $_GET['signatory_id'] : 0;

$sql = "SELECT signatory_id, (SELECT concat(account_lname, ', ', account_fname, ' ', account_mname) FROM accounts WHERE account_id = signatory_account) signatory_name, (SELECT department_name FROM departments WHERE department_id = (SELECT account_department FROM accounts WHERE account_id = signatory_account)) department, signatory_for, signatory_date, signatory_aid FROM signatories WHERE signatory_id = $signatory_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$signatory_for = $rec['signatory_for'];
	$signatory_name = $rec['signatory_name'];
}
db_close();

?>
<form role="form" id="frmSignatory" onSubmit="return false;">
	<div class="form-group">
	<label for="signatory_account">Signatory Name</label>
	<input type="text" style="width: 565px;" class="form-control" id="signatory_account" placeholder="Enter signatory name" value="<?php echo $signatory_name; ?>" onkeyup="$('#signatory_account_h').val(this.value);">
	<input type="hidden" id="signatory_account_h" data-error="Please fill out signatory name" value="" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="signatory_for">For</label>
    <select id="signatory_for" class="form-control">
	<option value="business_permit" <?php echo ($signatory_for == 'business_permit') ? 'selected="selected"' : ''; ?>>Business Permit Signatory</option>
	<option value="assessment_reviewer" <?php echo ($signatory_for == 'assessment_reviewer') ? 'selected="selected"' : ''; ?>>Assessment Reviewer</option>
	<option value="approval_recommendation" <?php echo ($signatory_for == 'approval_recommendation') ? 'selected="selected"' : ''; ?>>Approval Recommendation</option>
	</select>
	</div>	
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Submit</button>
	</div>	
</form>