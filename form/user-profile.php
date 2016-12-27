<?php

session_start();
$aid = 	$_SESSION['account_id'];

require '../config.php';
require '../globalf.php';

$account_lname = "";
$account_fname = "";
$account_mname = "";
$account_username = "";
$account_password = "";
$account_email = "";
$account_contact = "";
$account_title_position = "";
$sql = "SELECT account_username, account_password, account_fname, account_mname, account_lname, account_privileges, account_contact, account_title_position, account_email, account_department, account_date_registered, account_log, is_login, account_aid FROM accounts WHERE account_id = $aid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$account_lname = $rec['account_lname'];
	$account_fname = $rec['account_fname'];
	$account_mname = $rec['account_mname'];
	$account_username = $rec['account_username'];
	$account_password = $rec['account_password'];
	$account_email = $rec['account_email'];
	$account_contact = $rec['account_contact'];
	$account_title_position = $rec['account_title_position'];
}
db_close();

?>
<form role="form" id="frmUserProfile" onSubmit="return false;">
	<div class="form-group">
	<label for="account_lname">Last Name</label>
	<input type="text" class="form-control" id="account_lname" placeholder="Enter Last Name" data-error="Please fill out last name" value="<?php echo $account_lname;  ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="account_fname">First Name</label>
	<input type="text" class="form-control" id="account_fname" placeholder="Enter First Name" data-error="Please fill out first name" value="<?php echo $account_fname;  ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="account_mname">Middle Name</label>
	<input type="text" class="form-control" id="account_mname" placeholder="Enter Last Name" data-error="Please fill out middle name" value="<?php echo $account_mname; ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="account_username">Username</label>
	<input type="text" class="form-control" id="account_username" placeholder="Enter username" data-error="Please fill out username" value="<?php echo $account_username; ?>" required>
	<span class="help-block with-errors"></span>
	</div>
	<div class="form-group">
	<label for="account_password">Password</label>
	<input type="password" class="form-control" id="account_password" placeholder="Enter password" data-error="Please fill out password" data-typetoggle="#show-password" value="<?php echo dec($account_password); ?>" required>
	<div class="checkbox">
	  <label><input id="show-password" type="checkbox">Show Password</label>
	</div>
	<span class="help-block with-errors"></span>
	</div>	
	<div class="form-group">
	<label for="account_email">Email Address</label>
	<input type="text" class="form-control" id="account_email" placeholder="Enter email address" value="<?php echo $account_email; ?>">
	</div>
	<div class="form-group">
	<label for="account_contact">Contact</label>
	<input type="text" class="form-control" id="account_contact" placeholder="Enter contact number" value="<?php echo $account_contact; ?>">
	</div>
	<div class="form-group">
	<label for="account_title_position">Title/Position</label>
	<input type="text" class="form-control" id="account_title_position" placeholder="Enter title/position" value="<?php echo $account_title_position; ?>">
	</div>
	<div class="form-group">
	<label style="vertical-align: top;" for="account_signature">Signature</label>
	<div id="account_signature"></div>
	<div style="margin-left: 75px; margin-top: 3px;"><input type="button" id="clear_sig" class="btn btn-default btn-sm" value="Clear"></div>
	</div>
	<div class="form-group" style="padding-bottom: 20px;">
	<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Update</button>
	</div>	
</form>
<div><input id="h_account_username" type="hidden" value="<?php echo $account_username; ?>"><input id="username-exists" type="hidden" value="0"></div>