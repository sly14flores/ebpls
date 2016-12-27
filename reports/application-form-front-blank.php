<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Application Form (Front) - Print</title>
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
		border: 1px solid;
	}
	
	.one td {
		padding: 5px;
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
	
	.three {
		width: 100%;
		border-collapse: collapse;	
	}
	
	.three td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.in-three {
		width: 100%;
		margin: 0;
		border-collapse: collapse;
		border: 0 !important;
	}
	
	.four {
		width: 100%;
		border-collapse: collapse;	
	}	
	
	.four td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.five {
		width: 100%;
		border-collapse: collapse;	
	}	
	
	.five td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.six {
		width: 100%;
		border-collapse: collapse;	
	}	
	
	.six td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.seven {
		width: 100%;
		border-collapse: collapse;	
	}	
	
	.seven td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.eight {
		width: 100%;
		border-collapse: collapse;	
	}	
	
	.eight td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}
	
	.nine {
		width: 100%;
		border-collapse: collapse;
		text-align: center;
	}	
	
	.nine td {
		padding: 5px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
	}	

}

</style>
</head>

<body>
<div class="header" style="text-align: center;">
<p>Application Form for Business Permit</p>
<p>Tax Year: <?php date_default_timezone_set('Asia/Manila'); echo date("Y"); ?></p>
<p>City/Municipality BACNOTAN, LA UNION</p>
</div>
<table class="one">
<tr>
<td style="width: 250px;">
<input id="new_app" type="checkbox"> New<br>
<input id="renew_app" type="checkbox"> Renewal<br>
<input id="additional_app" type="checkbox"> Additional<br><br>
Transfer<br>
<input type="checkbox"> Owenership<br>
<input type="checkbox"> Location
</td>
<td style="width: 250px;">
<p style="text-align: center; margin-bottom: 2px;">Amendment<p>
<input id="single_partnership" style="margin-left: 30px;" type="checkbox"> From Single to Partnership<br>
<input id="single_corporation" style="margin-left: 30px;" type="checkbox"> From Single to Corporation<br>
<input id="partnership_single" style="margin-left: 30px;" type="checkbox"> From Partnership to Single<br>
<input id="partnership_corporation" style="margin-left: 30px;" type="checkbox"> From Partnership to Corporation<br>
<input id="corporation_single" type="checkbox" style="margin-left: 30px;" type="checkbox"> From Corporation to Single<br>
<input id="corporation_partnership" style="margin-left: 30px;" type="checkbox"> From Corporation to Partnership<br>
</td>
<td>
<p style="text-align: right; margin-bottom: 2px;">Mode of Payment</p>
<input id="pay_annually" style="margin-left: 100px;" type="checkbox"> Annually<br>
<input id="pay_bi_annually" style="margin-left: 100px;" type="checkbox"> Bi-Annually<br>
<input id="pay_quarterly" style="margin-left: 100px;" type="checkbox"> Quarterly<br>
<br><br><br><br>
</td>
</tr>
</table>
<table class="two">
<tr>
<td style="width: 45%;">Date of Application: <span id="application_date"></span></td>
<td style="width: 55%;">DTI/SEC/CDA Registration NO.: <span id="application_dti_sec_cda"></span></td>
</tr>
<tr>
<td>Reference No.: <span id="application_reference_no"></span></td>
<td>DTI/SEC/CDA Date of Registration: <span id="application_dti_sec_cda_date"></span></td>
</tr>
</table>
<table class="three">
<tr>
<td style="width: 60%;">
Type of Organization:&nbsp;&nbsp;<input id="single_organization" type="checkbox"> Single
&nbsp;&nbsp;&nbsp;<input id="partnership_organization" type="checkbox"> Partnership
&nbsp;&nbsp;&nbsp;<input id="corporation_organization" type="checkbox"> Corporation
&nbsp;&nbsp;&nbsp;<input id="cooperative_organization" type="checkbox"> Cooperative
</td>
<td style="padding: 0 !important;">
	<table class="in-three">
	<tr>
	<td style="width: 20%; border-width: 0 0 1px 0 !important; border-style: solid !important;">CTC No.</td><td style="width: 35%;"><span id="application_ctc_no"></span></td><td style="width: 10%; border-bottom-width: 0; border-style: solid;" rowspan="2">TIN:</td><td style="border-width: 0; border-style: solid;" rowspan="2"><span id="application_tin"></span></td>
	</tr>
	<tr>
	<td style="border-width: 1px 1px 0 0; border-style: solid;">DATE</td><td style="border-bottom-width: 0; border-style: solid;"><span id="application_ctc_date"></span></td>
	</tr>
	</table>
</td>
</tr>
</table>
<table class="four">
<tr><td colspan="3">Are you enjoying tax incentive from Government Entity?&nbsp;&nbsp;&nbsp;&nbsp;( <span id="tax_incentive_yes"></span> )&nbsp;yes&nbsp;&nbsp;&nbsp;( <span id="tax_incentive_no"></span> )&nbsp;no&nbsp;&nbsp;&nbsp;Please specify the entity: <span id="application_entity"></span></td></tr>
<tr>
<td style="width: 45%;">Last Name: <span id="application_taxpayer_lastname"></span></td>
<td style="width: 30%;">First Name: <span id="application_taxpayer_firstname"></span></td>
<td style="width: 25%;">Middle Name: <span id="application_taxpayer_middlename"></span></td>
</tr>
<tr>
<td>Gender: &nbsp;&nbsp;&nbsp;<input type="checkbox"> Male &nbsp;&nbsp;&nbsp;<input type="checkbox"> Female<span id="application_taxpayer_gender"></span></td>
<td colspan="2">Business Name: <span id="application_taxpayer_business_name"></span></td>
</tr>
<tr>
<td colspan="3">Trade Name/Franchise: <span id="application_trade_franchise"></span></td>
</tr>
<tr>
<td colspan="3">Name of President/Treasurer of Corporation <span></span></td>
</tr>
<tr>
<td style="width: 45%;">Last Name: <span id="application_treasurer_lastname"></span></td>
<td style="width: 30%;">First Name: <span id="application_treasurer_firstname"></span></td>
<td style="width: 25%;">Middle Name: <span id="application_treasurer_middlename"></span></td>
</tr>
</table>
<table class="five">
<tr><td style="width: 50%; font-weight: bold; text-align: center;">Business Address</td><td style="width: 50%; font-weight: bold; text-align: center;">Owner Address</td></tr>
<tr><td>House No./Bldg. No.: <span id="application_business_address_no"></span></td><td>House No./Bldg. No.: <span id="application_owner_address_no"></span></td></tr>
<tr><td>Building Name: <span id="application_business_address_bldg"></span></td><td>Building Name: <span id="application_owner_address_bldg"></span></td></tr>
<tr><td>Unit No.: <span id="application_business_address_unit_no"></span></td><td>Unit No.: <span id="application_owner_address_unit_no"></span></td></tr>
<tr><td>Street: <span id="application_business_address_street"></span></td><td>Street: <span id="application_owner_address_street"></span></td></tr>
<tr><td>Barangay: <span id="application_business_address_brgy"></span></td><td>Barangay: <span id="application_owner_address_brgy"></span></td></tr>
<tr><td>Subdivision: <span id="application_business_address_subd"></span></td><td>Subdivision: <span id="application_owner_address_subd"></span></td></tr>
<tr><td>City/Municipality: <span id="application_business_address_mun_city"></span></td><td>City/Municipality: <span id="application_owner_address_mun_city"></span></td></tr>
<tr><td>Province: <span id="application_business_address_province"></span></td><td>Province: <span id="application_owner_address_province"></span></td></tr>
<tr><td>Tel. No.: <span id="application_business_address_tel_no"></span></td><td>Tel. No.: <span id="application_owner_address_tel_no"></span></td></tr>
<tr><td>Email Address: <span id="application_business_address_email"></span></td><td>Email Address: <span id="application_owner_address_email"></span></td></tr>
<tr><td colspan="2">Property Index Number (PIN): <span id="application_pin"></span></td></tr>
</table>
<table class="six">
<tr><td style="width: 30%;">Business Area (in aq.m.): <span id="application_business_area"></span></td><td style="width: 40%;">Total No. of Employees in Establishment: <span id="application_no_employees"></span></td><td style="width: 30%;"># of Employees Residing in LGU: <span id="application_no_residing"></span></td></tr>
</table>
<table class="seven">
<tr><td colspan="3" style="width: 75%">If Place of Business is Rented, please identify the following: (Lessor's Name)</td><td rowspan="2" style="width: 30%; vertical-align: top;">Monthly Rental: <span style="display: block; text-align: center; padding-top: 5px;" id="application_monthly_rental"></span></td></tr>
<tr><td style="width: 25%">Last Name: <span id="application_lessor_lastname"></span></td><td style="width: 25%">First Name: <span id="application_lessor_firstname"></span></td><td style="width: 25%">Middle Name: <span id="application_lessor_middlename"></span></td></tr>
<tr><td colspan="4" style="font-weight: bold;">Lessor's Address</td></tr>
<tr><td colspan="2" style="width: 50%">House No./Bldg. No.: <span id="application_lessor_address_no"></span></td><td colspan="2" style="width: 50%;">Subdivision: <span id="application_lessor_address_subd"></span></td></tr>
<tr><td colspan="2" style="width: 50%">Street: <span id="application_lessor_address_street"></span></td><td colspan="2" style="width: 50%;">City/Municipality: <span id="application_lessor_address_mun_city"></span></td></tr>
<tr><td colspan="2" style="width: 50%">Barangay: <span id="application_lessor_address_brgy"></span></td><td colspan="2" style="width: 50%;">Province: <span id="application_lessor_address_province"></span></td></tr>
<tr><td colspan="2" style="width: 50%">Tel No.: <span id="application_lessor_address_tel_no"></span></td><td colspan="2" style="width: 50%;">Email Address: <span id="application_lessor_address_email"></span></td></tr>
<tr><td style="width: 25%; font-weight: bold;">In case of emergency</td><td colspan="3" style="width: 75%;">Contact Person/Tel. No./Mobile Phone No./Email Address: <span id="application_contact_person"></span></td></tr>
</table>
<table id="business-activity" class="eight">
<thead>
<tr><td colspan="2" style="width: 25.2%; text-align: center; font-weight: bold;">Business Activity</td><td rowspan="2" style="text-align: center;">No. of Units</td><td rowspan="2" style="text-align: center;">Capitalization (for new business)</td><td colspan="2" style="text-align: center;">Gross Sales/Receipts (for renewal)</td></tr>
<tr><td style="width: 10%; text-align: center;">Code</td><td style="text-align: center;">Line of Business</td><td style="text-align: center;">Essential</td><td style="text-align: center;">Non-essential</td></tr>
</thead>
<tbody>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</tbody>
</table>
<table class="nine">
<tr>
<td colspan="2" style="font-style: italic;">
<span>Oath of Undertaking</span>
<p style="margin-top: 5px;">I undertake to comply with the regulatory requirement and other deficiences within 30 days from release of the business permit</p>
</td>
</tr>
<tr>
<td style="width: 50%;"><p style="margin-top: 30px;">SIGNATURE OF APPLICANT OVER PRINTED NAME</p></td>
<td style=""><div style="margin-top: 20px;"><p id="application_position_title" style="margin-bottom: 10px;"></p><p>POSITION/TITLE</p></div></td>
</tr>
</table>
<script src="../jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {

window.print();
	
});
</script>
</body>
</html>