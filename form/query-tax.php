<?php

require '../config.php';

?>
<form class="form-inline" role="form" onSubmit="return false;">
	<div class="form-group">
	<label for="qtax">Description</label>
	<input type="text" class="form-control" id="qtax" placeholder="Enter description" value="">
	</div>
</form>
<hr>
<h4>Results:</h4>
<table id="query-tax" class="table table-striped">
<thead><tr><th>Description</th><th>Note</th></tr></thead>
<tbody></tbody>
</table>