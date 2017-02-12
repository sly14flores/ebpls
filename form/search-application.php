<form role="form" id="frmSearchApplication" onSubmit="return false;">
	<div class="form-group">
	<label for="application_no">Application No.</label>
	<input type="text" class="form-control" id="application_no" placeholder="Enter application number" value="" onkeyup="mirrorFilter(this);">
	</div>
	<div class="form-group">
	<label for="application_reference_no">Reference No.</label>
	<input type="text" class="form-control" id="application_reference_no" placeholder="Enter reference number" value="" onkeyup="mirrorFilter(this);">
	</div>	
	<div class="form-group">
	<label for="applicant_fullname">Full Name</label>
	<input type="text" class="form-control" style="width: 565px !important;" id="applicant_fullname" placeholder="Enter applicant last name, first name middle name" value="" onkeyup="mirrorFilter(this);">
	</div>
	<div class="form-group">
	<label for="application_form">Type</label>
	<select class="form-control" id="application_form" onchange="mirrorFilter(this);">
	<option value="all">All</option>
	<option value="new_app">New</option>
	<option value="renew_app">Renewal</option>
	<option value="additional_app">Additional</option>
	</select>
	</div>
	<div class="form-group">
	<label for="application_organization_type">Organization</label>
	<select class="form-control" id="application_organization_type" onchange="mirrorFilter(this);">
	<option value="all">All</option>
	<option value="single_organization">Single</option>
	<option value="partnership_organization">Partnership</option>
	<option value="corporation_organization">Corporation</option>
	<option value="cooperative_organization">Cooperative</option>
	</select>
	</div>
	<div class="form-group">
	<label for="application_mode_of_payment">Mode of Payment</label>
	<select class="form-control" id="application_mode_of_payment" onchange="mirrorFilter(this);">
	<option value="all">All</option>
	<option value="pay_annually">Annually</option>
	<option value="pay_bi_annually">Bi-Annually</option>
	<option value="pay_quarterly">Quarterly</option>
	</select>
	</div>	
	<div class="form-group">
	<label for="application_date">Date</label>
	<div id="application_date_dt" class="input-group date">
	<input id="application_date" class="form-control" type="text" placeholder="Enter date" value="" onchange="mirrorFilter(this);">
	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>
	</div>
	<div class="form-group">
	<label for="application_month">Month</label>
	<select class="form-control" id="application_month" onchange="mirrorFilter(this);">
	<option value="0">All</option>
	<option value="01" <?php // if (date("m") == "01") echo "selected=\"selected\""; ?>>January</option>
	<option value="02" <?php // if (date("m") == "02") echo "selected=\"selected\""; ?>>February</option>
	<option value="03" <?php // if (date("m") == "03") echo "selected=\"selected\""; ?>>March</option>
	<option value="04" <?php // if (date("m") == "04") echo "selected=\"selected\""; ?>>April</option>
	<option value="05" <?php // if (date("m") == "05") echo "selected=\"selected\""; ?>>May</option>
	<option value="06" <?php // if (date("m") == "06") echo "selected=\"selected\""; ?>>June</option>
	<option value="07" <?php // if (date("m") == "07") echo "selected=\"selected\""; ?>>July</option>
	<option value="08" <?php // if (date("m") == "08") echo "selected=\"selected\""; ?>>August</option>
	<option value="09" <?php // if (date("m") == "09") echo "selected=\"selected\""; ?>>September</option>
	<option value="10" <?php // if (date("m") == "10") echo "selected=\"selected\""; ?>>October</option>
	<option value="11" <?php // if (date("m") == "11") echo "selected=\"selected\""; ?>>November</option>
	<option value="12" <?php // if (date("m") == "12") echo "selected=\"selected\""; ?>>December</option>
	</select>
	</div>
	<?php
	
		if(isset($_GET['r'])) {
			if ($_GET['r'] == "generate_report") {
		
	?>
	<div class="form-group">
	<label for="business_status">Business Status</label>
	<select class="form-control" id="business_status">
		<option value="">-</option>
		<option value="delinquent">Delinquent</option>
	</select>
	</div>
	<?php
			}
		}
	?>
	<div class="form-group">
	<label for="application_year">Year</label>
	<input type="text" class="form-control" id="application_year" placeholder="Enter year" value="<?php // echo date("Y"); ?>" onkeyup="mirrorFilter(this);">
	</div>	
	<div class="form-group" style="padding-bottom: 20px;">
	<button id="search-application-button" type="submit" class="btn btn-primary pull-right">Search</button>
	</div>	
</form>