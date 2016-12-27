<?php

$id = 0;

require '../config.php';

$assessed_by = "";
$assessed_by_title = "";
$approved_by = "";
$approved_by_title = "";
$date_issued = "";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Application Form (Back) - Print</title>
<style type="text/css">

@page {

size: 8.5in 13in;
margin: .25in;
orphans: 1;
widows: 1;

}

@media all {

	* {
		margin: 0;
		padding: 0;		
	}
	
	body {
		font: 10px sans-serif;
	}
	
	.header p {
		margin-bottom: 5px;
	}
	
	.one {
		margin-top: 15px;
		width: 100%;
		border-collapse: collapse;
	}
	
	.one td {
		padding: 5px;
		border-width: 1px 1px 1px 1px;
		border-style: solid;		
	}

	.one tr:nth-child(1), .one tr:nth-child(2) {
		text-align: center;
	}
	
	.two {
		width: 100%;
		border-collapse: collapse;	
	}
	
	.two td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.two tr:nth-child(1), .two tr:nth-child(2) {
		text-align: center;
	}

	.three {
		width: 100%;
		border-collapse: collapse;	
	}
	
	.three td {
		padding: 20px;
	}

	.instructions {
		margin-top: 25px;
		border: 1px solid;
		padding: 5px;
		font-size: 9px;
	}
	
	.instructions p:nth-child(1) {
		font-weight: bold;
	}
	
	.instructions p {
		margin-bottom: 3px;
	}
	
	span {
		font-size: 12px;
	}
	
}	

</style>
</head>

<body>
<div class="header" style="text-align: center;">
<p>Application Form for Business Permit</p>
<p>Application No.</p>
</div>
<table class="one">
<tr><td colspan="6">ASSESSMENTS</td></tr>
<tr><td style="width: 200px;">LOCAL TAXES</td><td>REFERENCE</td><td>AMOUNT DUE</td><td>PENALTY/SURCHARGE</td><td>TOTAL</td><td>ASSESSED BY</td></tr>

<?php

$local_taxes = '';
$sql = "SELECT assessment_id, assessment_order, assessment_type, assessment_description, assessment_reference FROM assessments WHERE assessment_type = 'local_taxes'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$local_taxes .= '<tr><td>' . $rec['assessment_description'] . '</td><td style="text-align: center;">' . $rec['assessment_reference'] . '</td><td><span id="aba_item_amount_' . $rec['assessment_id'] . '"></span></td><td></td><td><span id="aba_item_total_' . $rec['assessment_id'] . '"></span></td><td></td></tr>';
	}
}
db_close();

echo $local_taxes;

?>

<tr><td colspan="6" style="font-weight: bold;">REGULATORY FEES AND CHARGES</td></tr>

<?php

$fees_charges = '';
$sql = "SELECT assessment_id, assessment_order, assessment_type, assessment_description, assessment_reference FROM assessments WHERE assessment_type = 'fees_charges'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$fees_charges .= '<tr><td>' . $rec['assessment_description'] . '</td><td style="text-align: center;">' . $rec['assessment_reference'] . '</td><td><span id="aba_item_amount_' . $rec['assessment_id'] . '"></span></td><td></td><td><span id="aba_item_total_' . $rec['assessment_id'] . '"></span></td><td></td></tr>';
	}
}
db_close();

echo $fees_charges;

?>

<tr><td>Others</td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td style="font-weight: bold; text-align: center;">TOTAL:</td><td></td><td></td><td></td><td><span id="assessment-total"></span></td><td></td></tr>
</table>
<table class="two">
<tr><td colspan="4" style="font-weight: bold;">VERIFICATION OF DOCUMENTS</td></tr>
<tr><td>Description</td><td>Office/Agency</td><td>Date Issued</td><td>VERIFIED BY: (BPLO Staff)</td></tr>
<?php

$verifications = '';
$sql = "SELECT verification_id, verification_fid, (SELECT manage_verification_description FROM manage_verification WHERE manage_verification_id = verification_verification_id) verification_description, (SELECT manage_verification_agency FROM manage_verification WHERE manage_verification_id = verification_verification_id) verification_agency, (SELECT concat(account_fname, ' ', account_lname) FROM accounts WHERE account_id = verification_verified_by) verified_by, (SELECT manage_verification_department FROM manage_verification WHERE manage_verification_id = verification_verification_id) verification_department, verification_verification_id, verification_issued, verification_verified_by FROM application_verifications WHERE verification_fid = $id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$verification_issued = ($rec['verification_issued'] == "0000-00-00 00:00:00") ? "" : date("M j, Y",strtotime($rec['verification_issued']));
		$verifications .= '<tr>';
		$verifications .= '<td>' . $rec['verification_description'] . '</td>';
		$verifications .= '<td>' . $rec['verification_agency'] . '</td>';
		$verifications .= '<td><span>' . $verification_issued  . '</span></td>';
		$verifications .= '<td><span>' . $rec['verified_by'] . '</span></td>';
		$verifications .= '</tr>';
	}
}
db_close();

echo $verifications;

$default_verifications = '<tr><td>Barangay Clearance</td><td>Barangay</td><td></td><td></td></tr>';
$default_verifications .= '<tr><td>Zoning Clearance</td><td>Zoning Admin. (MPDC)</td><td></td><td></td></tr>';
$default_verifications .= '<tr><td>Sanitary/Health Clearance</td><td>City/Mun. Health Department</td><td></td><td></td></tr>';
$default_verifications .= '<tr><td>Occupancy Permit</td><td>Bldg. Official</td><td></td><td></td></tr>';
$default_verifications .= '<tr><td>Fire Safety Inspection Certificate</td><td>City/Mun. Fire Department</td><td></td><td></td></tr>';

if ($rc == 0) echo $default_verifications;

?>

<tr><td>Others, please specify</td><td></td><td></td><td></td></tr>
</table>
<table class="three">
<tr><td colspan="2">OR#&nbsp;&nbsp;&nbsp;<span style="display: inline-block; width: 30px; border-width: 0 0 1px 0 !important; border-style: solid !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;<span style="display: inline-block; width: 100px; text-align: center; border-width: 0 0 1px 0 !important; border-style: solid !important;"><?php if ($date_issued != "") echo date("F j, Y",strtotime($date_issued)); ?></span></td></tr>
<tr>
<td style="width: 50%; position: relative;">
<div style="position: absolute; top: 25px; left: 15px; width: 150px; text-align: center;">
<p style="margin-bottom: 5px; font-weight: bold;"><span><?php echo $assessed_by; ?></span></p>
<p style="margin-bottom: 3px; border-bottom: 1px solid;"><?php echo $assessed_by_title; ?></p>
<p>Assessment reviewed by:</p>
</div>
<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>
</td>
<td style="witdh: 50%; position: relative;">
<div style="position: absolute; top: 25px; right: 15px; width: 150px; text-align: center;">
<p style="margin-bottom: 5px; font-weight: bold;"><span><?php echo $approved_by; ?></span></p>
<p style="margin-bottom: 3px; border-bottom: 1px solid;"><span><?php echo $approved_by_title; ?></span></p>
<p>Approval recommended by:</p>
</div>
</td>
</tr>
</table>
<div class="instructions">
<p>Instructions:</p>
<p>1. Provide accurate information and print legibly to avoid delays.  Incomplete application form will be returned to the applicant.</p>
<p>2. Ensure that all documents attached to this application form are complete and properly filled out.</p>
</div>
<script src="../jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">

$(function() {

window.print();
	
});

</script>
</body>

</html>