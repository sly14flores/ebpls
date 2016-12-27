<?php

require '../config.php';

$application_id = (isset($_GET['application_id'])) ? $_GET['application_id'] : 0;

$application_reference_no = "";
$sql = "SELECT application_reference_no FROM applications WHERE application_id = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$application_reference_no = $rec['application_reference_no'];
}
db_close();

$personal_info_status = "Pending";
$sql = "SELECT * FROM aba_items WHERE aba_item_fid = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$personal_info_status = "Completed";
}
db_close();

$assessments_status = "Pending";
$sql = "SELECT * FROM application_verifications WHERE verification_fid = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$assessments_status = "Completed";
}
db_close();

?>
<form role="form" id="frmAppStatus" onSubmit="return false;">
<fieldset>
<legend>Ref. No.: <?php echo $application_reference_no; ?></legend>
<table class="table table-striped table-bordered">
<thead><tr><th>Process</th><th>Status</th></tr></thead>
<tbody>
<tr><td style="width: 70%;">Personal/Business Info</td><td><?php echo $personal_info_status; ?></td></tr>
<tr><td>Assessments</td><td><?php echo $assessments_status; ?></td></tr>
</tbody>
</table>
<h4>Verification of Documents</h4>
<table class="table table-striped table-bordered">
<thead>
<tr><th style="width: 70%;">Document</th><th>Status</th></tr>
</thead>
<tbody>
<?php

$verifications = '';
$sql = "SELECT verification_id, (SELECT manage_verification_description FROM manage_verification WHERE manage_verification_id = verification_verification_id) document, verification_issued FROM application_verifications WHERE verification_fid = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$verification_status = "Pending";
		$rec = $rs->fetch_array();
		if ($rec['verification_issued'] != '0000-00-00 00:00:00') $verification_status = "Completed on " . date("F j, Y",strtotime($rec['verification_issued']));
		$verifications .= '<tr>';		
		$verifications .= '<td>' . $rec['document'] . '</td>';
		$verifications .= '<td>' . $verification_status . '</td>';
		$verifications .= '</tr>';
	}
} else {

$verifications .= '<tr><td>Barangay Clearance</td><td>Pending</td></tr>';
$verifications .= '<tr><td>Zoning Clearance</td><td>Pending</td></tr>';
$verifications .= '<tr><td>Sanitary/Health Clearance</td><td>Pending</td></tr>';
$verifications .= '<tr><td>Occupancy Permit</td><td>Pending</td></tr>';
$verifications .= '<tr><td>Fire Safety Inspection Certificate</td><td>Pending</td></tr>';

}
echo $verifications;
db_close();

?>
</tbody>
</table>
</fieldset>
</form>