<?php

require '../config.php';

?>
<form role="form" id="frmCustomAba" onSubmit="return false;">
	<div class="form-group">
	<label for="department_name">Amount:</label>
	<input type="text" class="form-control" id="aba_custom_amount" placeholder="Enter amount" data-error="Please fill out amount" value="" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Save</button>
	</div>	
</form>