<?php

require '../config.php';

?>
<form class="form-inline" role="form" onSubmit="return false;">
	<div class="form-group">
	<label for="qcode">Code</label>
	<input type="text" class="form-control" id="qcode" placeholder="Enter Code" value="">
	</div>
	<div class="form-group">
	<label for="qline">Line of Business</label>
	<input type="text" class="form-control" id="qline" placeholder="Enter Line of Business" value="">
	</div>
</form>
<hr>
<h4>Results:</h4>
<table id="query-ba" class="table table-striped">
<thead><tr><th>Code</th><th>Line of Business</th><th>Note</th><th>Applies to</th><th>Organization</th></tr></thead>
<tbody></tbody>
</table>