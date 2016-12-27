<?php

require '../config.php';

$permit_id = (isset($_GET['permit_id'])) ? $_GET['permit_id'] : 0;

$permit_or_no = "";
$permit_or_date = "CURRENT_TIMESTAMP";
$permit_sss_clearance = "";
$permit_sss_date = date("m/d/Y");

$sql = "SELECT permit_or_no, permit_or_date, permit_sss_clearance, permit_sss_date FROM permits WHERE permit_id = $permit_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$permit_or_no = $rec['permit_or_no'];
	$permit_or_date = ($rec['permit_or_date'] == "0000-00-00") ? date("m/d/Y") : date("m/d/Y",strtotime($rec['permit_or_date']));	
	$permit_sss_clearance = $rec['permit_sss_clearance'];
	$permit_sss_date = ($rec['permit_sss_date'] == "0000-00-00") ? "" : date("m/d/Y",strtotime($rec['permit_sss_date']));
}
db_close();

?>
<form id="frmBusinessPermit" role="form" onSubmit="return false;">
	<div class="form-group">
	<label for="permit_or_no">OR no.</label>
	<input type="text" class="form-control" id="permit_or_no" placeholder="Enter OR number" value="<?php echo $permit_or_no; ?>">
	</div>
	<div class="form-group">
		<label for="permit_or_date">OR Date</label>
		<div id="permit_or_date_dt" class="input-group date">			
		<input id="permit_or_date" class="form-control" type="text" placeholder="" value="<?php echo $permit_or_date; ?>">
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
	</div>	
	<div class="form-group">
	<label for="permit_sss_clearance">SSS Clearance</label>
	<input type="text" class="form-control" id="permit_sss_clearance" placeholder="Enter sss clearance" value="<?php echo $permit_sss_clearance; ?>">
	</div>
	<div class="form-group">
		<label for="permit_sss_date">SSS Clearance Date</label>
		<div id="permit_sss_date_dt" class="input-group date">			
		<input id="permit_sss_date" class="form-control" type="text" placeholder="" value="<?php echo $permit_sss_date; ?>">
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
	</div>
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right">Update</button>
	</div>	
</form>