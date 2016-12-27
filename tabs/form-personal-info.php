<?php

$src = isset($_GET['src']) ? $_GET['src'] : 1;

$city_municipality = "Bacnotan";
$province = "La Union";
$applicant_profile = '<div class="checkbox"><label><input id="applicant_profile" type="checkbox" checked="checked" onclick="togAppForm(this);"> <strong>ADD TO APPLICANT PROFILE</strong></label></div>';
$editB = '<input type="button" onclick="editPersonalInfo();" class="btn btn-primary btn-sm edit-personal-info" value="Edit Personal Info">';

?>
<div id="personal-info-on"></div>
<div style="margin-top: 15px;">
<?php // if ($src == 1) echo $applicant_profile; ?>
</div>
<div class="pull-right">
<?php if ($src == 2) echo $editB; ?>
</div>
<div id="form-personal-info" style="padding: 5px 0 5px 20px;">
<fieldset <?php if ($src == 2) echo 'style="margin-top: 50px;"' ?>>

<div class="row">
	<div class="col-sm-4">
		<div id="notify-nra" class="form-group">
			<div class="checkbox">
			<label>
			<input id="new_app" type="checkbox" onclick="appStatus(this);">New
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="renew_app" type="checkbox" onclick="appStatus(this);">Renewal
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="additional_app" type="checkbox" onclick="appStatus(this);">Additional
			</label>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<p><strong>Amendment</strong></p>	
		<div class="form-group">
			<div class="checkbox">
			<label>
			<input id="single_partnership" type="checkbox" onclick="togAmendment(this);">From Single to Partnership
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="single_corporation" type="checkbox" onclick="togAmendment(this);">From Single to Corporation
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="partnership_single" type="checkbox" onclick="togAmendment(this);">From Partnership to Single
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="partnership_corporation" type="checkbox" onclick="togAmendment(this);">From Partnership to Corporation
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="corporation_single" type="checkbox" onclick="togAmendment(this);">From Corporation to Single
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="corporation_partnership" type="checkbox" onclick="togAmendment(this);">From Corporation to Partnership
			</label>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<p><strong>Mode of Payment</strong></p>	
		<div id="notify-mop" class="form-group">
			<div class="checkbox">
			<label>
			<input id="pay_annually" type="checkbox" onclick="togPay(this);">Annually
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="pay_bi_annually" type="checkbox" onclick="togPay(this);">Bi-Annually
			</label>
			</div>
			<div class="checkbox">
			<label>
			<input id="pay_quarterly" type="checkbox" onclick="togPay(this);">Quarterly
			</label>
			</div>			
		</div>	
	</div>	
</div>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_date">Date of Application</label>
			<div id="application_date_dt" class="input-group date">
			<input id="application_date" class="form-control" type="text" placeholder="" value="<?php echo date("m/d/Y"); ?>">
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_reference_no">Reference Number</label>
			<input id="application_reference_no" class="form-control" type="text" value="">
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_dti_sec_cda">DTI/SEC/CDA Registration Number</label>
			<input id="application_dti_sec_cda" class="form-control" type="text" placeholder="Enter DTI/SEC/CDA registration number" value="">
		</div>	
	</div>	
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_dti_sec_cda_date">DTI/SEC/CDA Date of Registration</label>
			<div id="application_dti_sec_cda_date_dt" class="input-group date">
			<input id="application_dti_sec_cda_date" class="form-control" type="text" placeholder="Enter DTI/SEC/CDA date of registration" value="">
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>		
	</div>	
</div>
<div class="row">
	<div class="col-sm-3">
		<p><strong>Type of Organization</strong></p>
		<div class="row" style="margin-top: -10px;">
			<div class="col-sm-6">
				<div id="notify-too"></div>
				<div class="form-group">
				<div class="checkbox">
				<label>
				<input id="single_organization" type="checkbox" onclick="organizationType(this);" value="single">Single
				</label>
				</div>
				<div class="checkbox">
				<label>
				<input id="partnership_organization" type="checkbox" onclick="organizationType(this);" value="partnership">Partnership
				</label>
				</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
				<div class="checkbox">
				<label>
				<input id="corporation_organization" type="checkbox" onclick="organizationType(this);" value="corporation">Corporation
				</label>
				</div>
				<div class="checkbox">
				<label>
				<input id="cooperative_organization" type="checkbox" onclick="organizationType(this);" value="cooperative">Cooperative
				</label>
				</div>				
				</div>			
			</div>			
		</div>				
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_ctc_no">CTC Number</label>
			<input id="application_ctc_no" class="form-control" type="text" placeholder="Enter CTC number" value="">
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_ctc_date">Date</label>
			<div id="application_ctc_date_dt" class="input-group date">
			<input id="application_ctc_date" class="form-control" type="text" placeholder="Enter CTC date" value="">
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>			
			</div>
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_tin">TIN</label>
			<input id="application_tin" class="form-control" type="text" placeholder="Enter TIN number" value="">
		</div>		
	</div>	
</div>
<div class="row">
	<div class="col-sm-6">
	<div id="notify-incentive" class="form-group">
	<strong>Are you enjoying tax incentive from Government Entity?</strong>
		<label class="radio-inline">
		<input type="radio" name="tax_incentive" id="tax_incentive_yes" value="false" onclick="togTaxIncentive(this);">
		(Yes)
		</label>
		<label class="radio-inline">
		<input type="radio" name="tax_incentive" id="tax_incentive_no" value="true" onclick="togTaxIncentive(this);">
		(No)
		</label>
	</div>
	</div>
	<div class="col-sm-6">
	<div class="form-group">
		<label for="application_entity">Please specify the entity</label>
		<input id="application_entity" class="form-control" type="text" placeholder="Enter entity" value="" disabled>		
	</div>
	</div>
</div>
</fieldset>
<fieldset>
<legend>Name of Taxpayer:</legend>
<div class="row">
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_taxpayer_lastname">Last Name</label>
			<input id="application_taxpayer_lastname" class="form-control" type="text" placeholder="Enter last name" value="">		
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_taxpayer_firstname">First Name</label>
			<input id="application_taxpayer_firstname" class="form-control" type="text" placeholder="Enter first name" value="">		
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_taxpayer_middlename">Middle Name</label>
			<input id="application_taxpayer_middlename" class="form-control" type="text" placeholder="Enter middle name" value="">		
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_taxpayer_gender">Gender</label>
            <select id="application_taxpayer_gender" class="form-control" onchange="selGender(this);"><option value="Male">Male</option><option value="Female">Female</option></select>
		</div>
	</div>
	<div class="col-sm-8">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="application_taxpayer_business_name">Business Name</label>
			<input id="application_taxpayer_business_name" class="form-control" type="text" placeholder="Enter name of business" value="">		
		</div>		
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="application_trade_franchise">Trade Name/Franchise</label>
			<input id="application_trade_franchise" class="form-control" type="text" placeholder="Enter trade name/franchise" value="">		
		</div>		
	</div>
</div>
</fieldset>
<fieldset>
<legend>Name of President/Treasurer of Corporation:</legend>
<div class="row">
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_treasurer_lastname">Last Name</label>
			<input id="application_treasurer_lastname" class="form-control" type="text" placeholder="Enter last name" value="">		
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_treasurer_firstname">First Name</label>
			<input id="application_treasurer_firstname" class="form-control" type="text" placeholder="Enter first name" value="">		
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_treasurer_middlename">Middle Name</label>
			<input id="application_treasurer_middlename" class="form-control" type="text" placeholder="Enter middle name" value="">		
		</div>
	</div>
</div>
</fieldset>
<fieldset>
<legend>Business Address:</legend>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_no">House No./Bldg. No.</label>
			<input id="application_business_address_no" class="form-control" type="text" placeholder="Enter house no./bldg. no." value="">
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_bldg">Building Name</label>
			<input id="application_business_address_bldg" class="form-control" type="text" placeholder="Enter building name" value="">		
		</div>	
	</div>
		<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_unit_no">Unit Number</label>
			<input id="application_business_address_unit_no" class="form-control" type="text" placeholder="Enter unit number" value="">
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_street">Street</label>
			<input id="application_business_address_street" class="form-control" type="text" placeholder="Enter street" value="">		
		</div>	
	</div>	
</div>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_brgy">Barangay</label>
			<input id="application_business_address_brgy" class="form-control" type="text" placeholder="Enter barangay" value="">		
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_subd">Subdivision</label>
			<input id="application_business_address_subd" class="form-control" type="text" placeholder="Enter subdivision" value="">		
		</div>	
	</div>
		<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_mun_city">City/Municipality</label>
			<input id="application_business_address_mun_city" class="form-control" type="text" placeholder="" value="<?php echo $city_municipality; ?>" disabled>
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_address_province">Province</label>
			<input id="application_business_address_province" class="form-control" type="text" placeholder="" value="<?php echo $province; ?>" disabled>
		</div>	
	</div>	
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="application_business_address_tel_no">Tel. No.</label>
			<input id="application_business_address_tel_no" class="form-control" type="text" placeholder="Enter tel. no." value="">		
		</div>		
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="application_business_address_email">Email Address</label>
			<input id="application_business_address_email" class="form-control" type="text" placeholder="Enter email address" value="">		
		</div>		
	</div>	
</div>
</fieldset>
<fieldset>
<legend>Owner's Address:</legend>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_no">House No./Bldg. No.</label>
			<input id="application_owner_address_no" class="form-control" type="text" placeholder="Enter house no./bldg. no." value="">		
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_bldg">Building Name</label>
			<input id="application_owner_address_bldg" class="form-control" type="text" placeholder="Enter building name" value="">		
		</div>	
	</div>
		<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_unit_no">Unit Number</label>
			<input id="application_owner_address_unit_no" class="form-control" type="text" placeholder="Enter unit number" value="">		
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_street">Street</label>
			<input id="application_owner_address_street" class="form-control" type="text" placeholder="Enter street" value="">
		</div>	
	</div>	
</div>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_brgy">Barangay</label>
			<input id="application_owner_address_brgy" class="form-control" type="text" placeholder="Enter barangay" value="">		
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_subd">Subdivision</label>
			<input id="application_owner_address_subd" class="form-control" type="text" placeholder="Enter subdivision" value="">		
		</div>	
	</div>
		<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_mun_city">City/Municipality</label>
			<input id="application_owner_address_mun_city" class="form-control" type="text" placeholder="" value="<?php echo $city_municipality; ?>">
		</div>	
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_owner_address_province">Province</label>
			<input id="application_owner_address_province" class="form-control" type="text" placeholder="" value="<?php echo $province; ?>">
		</div>	
	</div>	
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="application_owner_address_tel_no">Tel. No.</label>
			<input id="application_owner_address_tel_no" class="form-control" type="text" placeholder="Enter tel. no." value="">		
		</div>		
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="application_owner_address_email">Email Address</label>
			<input id="application_owner_address_email" class="form-control" type="text" placeholder="Enter email address" value="">		
		</div>		
	</div>	
</div>
</fieldset>
<fieldset>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_pin">Property Index Number (PIN)</label>
			<input id="application_pin" class="form-control" type="text" placeholder="Enter property index number" value="">		
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_business_area">Business Area (in sq.m.)</label>
			<input id="application_business_area" class="form-control" type="text" placeholder="Enter business area in sq.m." value="">
		</div>		
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_no_employees">Total No. of Employees in Establishment</label>
			<input id="application_no_employees" class="form-control" type="text" placeholder="Enter total number of employees" value="">		
		</div>		
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_no_residing"># of Employees Residing in LGU</label>
			<input id="application_no_residing" class="form-control" type="text" placeholder="Enter # employees residing in LGU" value="">		
		</div>		
	</div>	
</div>
</fieldset>
<fieldset>
<legend>If a Place of Business is Rented, please specify the following</legend>
<div class="row" style="margin-top: -8px; margin-bottom: 10px;">
	<div id="notify-rented" class="col-sm-12">
		<strong>Is the Place of Business Rented?</strong>
		<label class="radio-inline">
		<input type="radio" name="business_place" id="rented_yes" value="false" onclick="togBusinessPlace(this);">
		(Yes)
		</label>
		<label class="radio-inline">
		<input type="radio" name="business_place" id="rented_no" value="true" onclick="togBusinessPlace(this);">
		(No)
		</label>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<h4>Lessor's Name</h4>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_lessor_lastname">Last Name</label>
			<input id="application_lessor_lastname" class="form-control" type="text" placeholder="Enter last name" value="" disabled>		
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_lessor_firstname">First Name</label>
			<input id="application_lessor_firstname" class="form-control" type="text" placeholder="Enter first name" value="" disabled>		
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="application_lessor_middlename">Middle Name</label>
			<input id="application_lessor_middlename" class="form-control" type="text" placeholder="Enter middle name" value="" disabled>		
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_monthly_rental">Monthly Rental</label>
			<input id="application_monthly_rental" class="form-control" type="text" placeholder="Enter monthly rental" value="" disabled>		
		</div>
	</div>
	<div class="col-sm-9">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<h4>Lessor's Address</h4>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_no">House No./Bldg. No.</label>
			<input id="application_lessor_address_no" class="form-control" type="text" placeholder="Enter house no./bldg. no." value="" disabled>	
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_street">Street</label>
			<input id="application_lessor_address_street" class="form-control" type="text" placeholder="Enter street" value="" disabled>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_brgy">Barangay</label>
			<input id="application_lessor_address_brgy" class="form-control" type="text" placeholder="Enter barangay" value="" disabled>			
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_subd">Subdivision</label>
			<input id="application_lessor_address_subd" class="form-control" type="text" placeholder="Enter subdivision" value="" disabled>	
		</div>
	</div>	
</div>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_mun_city">City/Municipality</label>
			<input id="application_lessor_address_mun_city" class="form-control" type="text" placeholder="" value="<?php echo $city_municipality; ?>" disabled>			
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_province">Province</label>
			<input id="application_lessor_address_province" class="form-control" type="text" placeholder="" value="<?php echo $province; ?>" disabled>			
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_tel_no">Tel. No.</label>
			<input id="application_lessor_address_tel_no" class="form-control" type="text" placeholder="Enter tel. no." value="" disabled>			
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_lessor_address_email">Email Address</label>
			<input id="application_lessor_address_email" class="form-control" type="text" placeholder="Enter email address" value="" disabled>			
		</div>
	</div>	
</div>
<div class="row">
	<div class="col-sm-3">
		<p class="form-control-static"><strong>In case of emergency:</strong></p>
	</div>
	<div class="col-sm-9">
		<label for="application_contact_person">Contact Person/Tel. No./Mobile Phone No./Email Address</label>
		<input id="application_contact_person" class="form-control" type="text" placeholder="Enter tel. no./mobile phone no./email address" value="">	
	</div>
</div>
</fieldset>
<fieldset>
<legend>Business Activity</legend>
<div class="form-group">
<input type="button" id="add-business-activity" class="btn btn-primary btn-sm" onclick="<?php echo ($src == 1) ? 'addBusinessActivity();' : 'noEditBA();'; ?>" value="Add Business Activity">
</div>
<table id="business-activity" class="table table-striped">
<thead>
<tr><th rowspan="2" style="vertical-align: middle; text-align: center;">Code</th><th rowspan="2" style="vertical-align: middle; text-align: center;">Line of Business</th><th rowspan="2" style="vertical-align: middle; text-align: center;">No. of Units</th><th rowspan="2" style="vertical-align: middle; text-align: center;">Capitalization (for new business)</th><th colspan="2" style="text-align: center;">Gross Sales/Receipts (for renewal)</th><th rowspan="2">Action</th></tr>
<tr><th style="text-align: center;">Essential</th><th style="text-align: center;">Non-essential</th></tr>
</thead>
<tbody>
</tbody>
</table>
</fieldset>
<fieldset style="margin-top: 30px;">
<legend style="text-align: right;">Name of Signatory (if applicable)</legend>
<div class="row">
	<div class="col-sm-3">&nbsp;</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_signatory_lastname">Last Name</label>
			<input id="application_signatory_lastname" class="form-control" type="text" placeholder="Enter last name" value="">		
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_signatory_firstname">First Name</label>
			<input id="application_signatory_firstname" class="form-control" type="text" placeholder="Enter first name" value="">		
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label for="application_signatory_middlename">Middle Name</label>
			<input id="application_signatory_middlename" class="form-control" type="text" placeholder="Enter middle name" value="">		
		</div>
	</div>
</div>
</fieldset>
<fieldset style="margin-top: 25px;">
<div class="row">
	<div class="col-sm-9">&nbsp;</div>
	<div class="col-sm-3">
		<label for="application_position_title">POSITION/TITLE</label>
		<input id="application_position_title" class="form-control" type="text" placeholder="" value="">		
	</div>
</div>
</fieldset>
</div>
<div>
<?php if ($src == 2) echo $editB; ?>
</div>