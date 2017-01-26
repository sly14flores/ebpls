<?php

$permit_id = $_GET['permit_id'];

require '../config.php';

$sql = "SELECT permit_fid, (SELECT application_date FROM applications WHERE application_id = permit_fid) date_of_application, permit_application_no, permit_reference_no, permit_fee, permit_tax, permit_mode_of_payment, permit_or_no, permit_or_date, permit_date_issued, (SELECT concat(application_taxpayer_firstname, ' ', substring(application_taxpayer_middlename,1,1), '. ', application_taxpayer_lastname) FROM applications WHERE application_id = permit_fid) full_name, (SELECT ba_line FROM business_activities WHERE ba_id = (SELECT aba_b_line FROM application_business_activities WHERE aba_fid = permit_fid)) business_type, (SELECT application_taxpayer_business_name FROM applications WHERE application_id = permit_fid) business_name, (SELECT application_business_address_bldg FROM applications WHERE application_id = permit_fid) building_name, (SELECT application_business_address_street FROM applications WHERE application_id = permit_fid) street, (SELECT application_business_address_brgy FROM applications WHERE application_id = permit_fid) barangay, (SELECT concat(account_fname, ' ', account_mname, ' ', account_lname) FROM accounts WHERE account_id = (SELECT signatory_account FROM signatories WHERE signatory_for = 'business_permit')) signatory, (SELECT account_title_position FROM accounts WHERE account_id = (SELECT signatory_account FROM signatories WHERE signatory_for = 'business_permit')) signatory_title, permit_sss_clearance, permit_sss_date, (SELECT application_trade_franchise FROM applications WHERE application_id = permit_fid) trade_name, (SELECT CONCAT(application_treasurer_firstname, CASE WHEN application_treasurer_middlename='' THEN ' ' WHEN application_treasurer_middlename=0 THEN ' ' ELSE CONCAT(' ',SUBSTRING(application_taxpayer_lastname,1,1),'.') END, ' ', application_treasurer_lastname) FROM applications WHERE application_id = permit_fid) president_name, (SELECT application_organization_type FROM applications WHERE application_id = permit_fid) organization_type FROM permits WHERE permit_id = $permit_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mayor's Permit - Print</title>
<style type="text/css">

@page {

size: 8.5in 11in;
margin: .25in;

}

@media all {

	* {
		margin: 0;
		padding: 0;		
	}
	
	body {
		font: 14px serif;
		margin: 30px  30px 0 30px;
	}
	
	.series {
		position: absolute;
		top: 45px;
		right: 35px;
		font-family: 'Brush Script MT';
		font-weight: bold;
		font-size: 18px;
	}
	
	.logo {
		text-align: center;
		margin-bottom: 5px;
	}
	
	.logo img {
		width: 110px;
		margin-left: auto;
		margin-right: auto;
	}
	
	.header {
		text-align: center;
	}
	
	.one {
		margin-top: 10px;
		width: 100%;
		border-collapse: collapse;
	}
	
	.one td {

	}
	
	.two {
		width: 100%;
		border-collapse: collapse;	
	}
	
	.two td {

	}
		
}
	
</style>
</head>

<body onload="window.print();">
<div class="series"><p>Series <?php echo date("Y",strtotime($rec['date_of_application'])); ?></p></div>
<div class="logo">
<img src="../images/logo.jpg" alt="Logo" style="width: 80px; height: 81px;">
</div>
<div class="header">
<p style="font-weight: bold;">Republic of the Philippines</p>
<p style="font-weight: bold;">Province of La Union</p>
<p style="font-weight: bold;">Municipality of Bacnotan</p>
<p style="font-size: 12px;">Tel. Nos. (072) 719-0100: (072) 607-3573: Telefax No. (072) 607-4261</p>
</div>
<p style="margin-top: 25px; font-weight: bold;">MAYOR'S PERMIT NO. <?php echo $rec['permit_application_no']; ?></p>
<p style="margin-top: 20px; font-weight: bold; text-align: center; font-family: 'Brush Script MT'; font-size: 26px;"><strong>Office of the Mayor</strong></p>
<p style="margin-top: 20px; font-weight: bold;">TO WHOM IT MAY CONCERN:</p>
<table class="one">
<tr><td style="text-indent: 50px; width: 40%;">PERMIT is hereby granted to</td><td style="text-align: center; font-weight: bold;"><?php echo ($rec['organization_type'] == "corporation_organization") ? strtoupper($rec['president_name']) : strtoupper($rec['full_name']); ?></td></tr>
<tr><td>to maintain and operate a</td><td style="text-align: center;"><?php echo $rec['business_type']; ?></td></tr>
<tr><td>under the business name of</td><td style="text-align: center; font-weight: bold;"><?php echo ($rec['organization_type'] == "corporation_organization") ? strtoupper($rec['trade_name']) : strtoupper($rec['business_name']); ?></td></tr>
<tr><td>located at</td><td style="text-align: center;"><?php echo ($rec['building_name'] != "") ? $rec['building_name'] . " " : ""; echo ($rec['street'] != "") ? $rec['street'] : "Street/Barangay" . " "; echo $rec['barangay']; ?></td></tr>
<tr><td colspan="2">this municipality to the provisions of existing laws and ordinances and to the payment of all corresponding fees and licenses.</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
</table>
<table>
<tr><td colspan="2" style="text-indent: 50px;">In accordance with pertinent provisions of the Revenue Code of the Municipality, the PERMIT may be revoked should the Permitte refuse to pay an indebtedness or liability to the municipality or abuse his privilege to do business in the municipality to the injury of public morale or peace or when the place where such business is established is being conducted in a disorderly manner, a nuisance or is permitted to be used as a resort for shady characters, criminals or women of ill repute.</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" style="text-indent: 50px;"><p>Issued this&nbsp;&nbsp;&nbsp;<?php echo addOrdinalNumberSuffix((int)date("j",strtotime($rec['date_of_application']))); ?>&nbsp;&nbsp;&nbsp;of&nbsp;&nbsp;&nbsp;<?php echo date("F, Y",strtotime($rec['date_of_application'])); ?></p></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;<br><br><br><br><br></td><td style="position: relative;"><div style="width: 300px; position: absolute; top: 40px; right: 0;" class="signatory"><p style="text-align: center; font-weight: bold;"><?php echo strtoupper($rec['signatory']); ?></p><p style="text-align: center; font-weight: bold;"><?php echo $rec['signatory_title']; ?></p></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
</table>
<table class="two">
<tr><td style="width: 20%;">Application No.</td><td style="width: 3px;">:&nbsp;</td><td><?php echo $rec['permit_application_no']; ?></td></tr>
<tr><td>Date</td><td style="width: 3px;">:&nbsp;</td><td><?php echo date("j F, Y",strtotime($rec['date_of_application'])); ?></td></tr>
<tr><td>Mayor's Permit Fee</td><td style="width: 3px;">:&nbsp;</td><td><?php echo "Php. " . number_format($rec['permit_fee'],2); ?></td></tr>
<tr><td>Municipality License</td><td style="width: 3px;">:&nbsp;</td><td><?php echo "Php. " . number_format($rec['permit_tax'],2); ?></td></tr>
<tr><td colspan="3">Quarterly <span style="display: inline-block; text-align: center; border-bottom: 1px solid; width: 50px;"><?php if ($rec['permit_mode_of_payment'] == "pay_quarterly") echo "xxx"; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;Semestral <span style="display: inline-block; text-align: center; border-bottom: 1px solid; width: 50px;"><?php if ($rec['permit_mode_of_payment'] == "pay_bi_annually") echo "xxx"; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;Annual <span style="display: inline-block; text-align: center; border-bottom: 1px solid; width: 50px;"><?php if ($rec['permit_mode_of_payment'] == "pay_annually") echo "xxx"; ?></span></td></tr>
<tr><td colspan="3">O.R. No. <span style="border-bottom: 1px solid;"><?php echo $rec['permit_or_no']; ?></span>&nbsp;&nbsp;&nbsp;Dated: <span style="border-bottom: 1px solid;"><?php echo date("m/d/Y",strtotime($rec['permit_or_date'])); ?></span>&nbsp;&nbsp;&nbsp;SSS Clearance: <span style="border-bottom: 1px solid;"><?php echo ($rec['permit_sss_clearance'] != "") ? $rec['permit_sss_clearance'] : "xxx"; ?></span>&nbsp;&nbsp;&nbsp;Dated: <span style="border-bottom: 1px solid;"><?php echo ($rec['permit_sss_date'] != "0000-00-00") ? date("m/d/Y",strtotime($rec['permit_sss_date'])) : "xxx"; ?></span></td></tr>
</table>
<div style="text-align: justify; font-size: 12px;">
<p style="margin-top: 5px; margin-bottom: 5px; border-top: 1px dotted;"></p>
<p>This permit must be displayed conspicuously at the place of business.</p>
<p>Upon discontinuance or retirement of business, trade or activity above cited, the permitee shall notify the Office of the Mayor or Municipal Treasurer not later than the date or retirement and surrender this permit and such other permits issued prior thereto.</p>
<p>This permit may be cancelled upon violation of any law, ordinances, rules and regulations.</p>
<p>This permit is good only for the place applied for any change of address shall be reported to the Office of the Mayor or Municipal Treasurer.</p>
</div>
</body>

</html>
<?php

db_close();

function addOrdinalNumberSuffix($num) {
if (!in_array(($num % 100),array(11,12,13))){
  switch ($num % 10) {
	// Handle 1st, 2nd, 3rd
	case 1:  return $num.'<sup>st</sup>';
	case 2:  return $num.'<sup>nd</sup>';
	case 3:  return $num.'<sup>rd</sup>';
  }
}
return $num.'<sup>th</sup>';
}

?>