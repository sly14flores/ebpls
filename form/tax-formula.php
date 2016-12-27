<?php

require '../config.php';
$tax_id = (isset($_GET['tax_id'])) ? $_GET['tax_id'] : 0;

$tax_description = "";
$tax_note = "";
$sql = "SELECT tax_description, tax_note FROM taxes WHERE tax_id = $tax_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$tax_description = $rec['tax_description'];
	$tax_note = $rec['tax_note'];
}
db_close();

?>
<form role="form" id="frmTaxes" onSubmit="return false;" style="margin-bottom: 25px;">
<fieldset>
</fieldset>
<div class="row">
	<div class="col-sm-6">
		<label for="tax_description">Description</label>
		<input type="text" class="form-control" id="tax_description" placeholder="Enter tax name" value="<?php echo $tax_description ?>">
	</div>
	<div class="col-sm-6">
		<label for="tax_note">Note</label>
		<input type="text" class="form-control" id="tax_note" placeholder="Enter tax note" value="<?php echo $tax_note; ?>">
	</div>
</div>
</form>
<div class="form-group">
<button id="addFormula" type="button" class="btn btn-primary btn-sm">Add</button>
</div>
<hr>
<table id="tax-formula" class="table table-striped">
<thead><tr><th>Imposition</th><th>Greater than/Equal to</th><th>Less than/Equal to</th><th>Amount/Percentage</th><th>Percentage of</th><th>Description</th><th>Action</th></tr></thead>
<tbody></tbody>
</table>
<p>Note: Put Zero for infinite value</p>