<form class="form-inline" role="form" id="frmAppProfile" onSubmit="return false;">
	<div class="form-group">
	<label for="application_ref_no">Ref.No.:</label>
	<input type="text" class="form-control" id="application_ref_no" placeholder="Enter reference number" value="">
	</div>
	<div class="form-group">
	<label for="applicant_fullname">Full Name:</label>
	<input type="text" class="form-control" style="width: 400px !important;" id="applicant_fullname" placeholder="Enter applicant last name, first name middle name" value="">
	</div>
</form>
<hr>
<h4>Results:</h4>
<table id="query-applicant" class="table table-striped">
<thead><tr><th>App.ID.</th><th>Date</th><th>App.No.</th><th>Ref.No.</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Business Name</th><th>Address</th></tr></thead>
<tbody></tbody>
</table>