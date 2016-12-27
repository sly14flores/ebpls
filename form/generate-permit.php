<?php

require '../config.php';

?>
<form role="form" onSubmit="return false;">
	<div class="form-group">
	<label for="qappno">Application No.</label>
	<input type="text" class="form-control" id="qappno" placeholder="Enter application no" value="">
	</div>
</form>
<hr>
<h4>Results:</h4>
<table id="generate-permit" class="table table-striped">
<thead><tr><th>App.No.</th><th>Ref.No.</th><th>Full Name</th><th>Business Name</th></tr></thead>
<tbody></tbody>
</table>