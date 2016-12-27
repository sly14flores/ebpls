<?php

$ualname = "";
$uafname = "";
$uamname = "";
$uaemail = "";
$uacontact = "";
$uauname = "";
$uapword = "";
$uatitle = "";

require '../config.php';
require '../globalf.php';

$uaid = (isset($_GET['uaid'])) ? $_GET['uaid'] : 0;
$src = (isset($_GET['src'])) ? $_GET['src'] : 1;

$legend_title = "Add New User";
$save_update = "Save";
$cancel_close = "Cancel";
if ($src == 2) {
	$legend_title = "Edit User Info";
	$save_update = "Update";	
	$cancel_close = "Close";
}

$sql = "SELECT account_id, account_username, account_password, account_fname, account_mname, account_lname, account_privileges, account_contact, account_email, account_department, account_title_position, account_date_registered, account_log, account_aid FROM accounts WHERE account_id = $uaid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$ualname = $rec['account_lname'];
	$uafname = $rec['account_fname'];
	$uamname = $rec['account_mname'];
	$uaemail = $rec['account_email'];
	$uacontact = $rec['account_contact'];
	$uauname = $rec['account_username'];
	$uapword = dec($rec['account_password']);
	$uatitle = $rec['account_title_position'];
}
db_close();

$up = '<div class="clearfix" style="position: relative; margin-bottom: 10px;">';
$down = '<div class="clearfix" style="position: relative; margin-bottom: 10px;">';

$buttons = '<div style="position: absolute; top: 0; right: 0;">';
$buttons .= '<button class="btn btn-primary btn-sm" disabled="disabled" onclick="userAccountForm(' . $src . ',' . $uaid . ');">' . $save_update . '</button>&nbsp;&nbsp;';
$buttons .= '<input type="button" class="btn btn-default btn-sm" onclick="cancelUserForm();" value="' . $cancel_close . '">';
$buttons .= '</div>';
$buttons .= '</div>';

?>

<form role="form" id="frmUserAccounts" onSubmit="return false;">
<?php echo $up.$buttons; ?>
<fieldset>
    <legend><?php echo $legend_title; ?></legend>
    <div class="row">
        <div class="col-sm-3">    
            <div class="form-group">
                <label for="account_department">Department</label>
                <select id="account_department" class="form-control"></select>
            </div>
        </div>
		<div class="col-sm-9">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-sm-4">    
            <div class="form-group">
                <label for="account_lname">Last Name</label>
                <input id="account_lname" class="form-control" size="30" type="text" placeholder="Enter Last Name" data-error="Please fill out last name" value="<?php echo $ualname; ?>" required>
				<span class="help-block with-errors"></span>
            </div>
        </div>
        <div class="col-sm-4">    
            <div class="form-group">
                <label for="account_fname">First Name</label>
                <input id="account_fname" class="form-control" size="30" type="text" placeholder="Enter First Name" data-error="Please fill out first name" value="<?php echo $uafname; ?>" required>
				<span class="help-block with-errors"></span>
            </div>
        </div>
        <div class="col-sm-4">    
            <div class="form-group">
                <label for="account_mname">Middle Name</label>
                <input id="account_mname" class="form-control" size="30" type="text" placeholder="Enter Middle Name" data-error="Please fill out middle name" value="<?php echo $uamname; ?>" required>
				<span class="help-block with-errors"></span>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-6">    
            <div class="form-group">
                <label for="account_email">Email</label>
                <input id="account_email" class="form-control" size="30" type="text" placeholder="Enter Email Address" value="<?php echo $uaemail; ?>">
            </div>
        </div>
        <div class="col-sm-6">    
            <div class="form-group">
                <label for="account_contact">Contact No(s)</label>
                <input id="account_contact" class="form-control" size="30" type="text" placeholder="Enter Contact Number(s)" value="<?php echo $uacontact; ?>">
            </div>
        </div>
	</div>
	<div class="row">
        <div class="col-sm-6">    
            <div class="form-group">
                <label for="account_username">Username</label>
                <input id="account_username" class="form-control" size="30" type="text" placeholder="Enter Username" data-error="Please fill out username" value="<?php echo $uauname; ?>" required>
				<span class="help-block with-errors"></span>
            </div>
        </div>
        <div class="col-sm-6">    
            <div class="form-group">
                <label for="account_password">Password</label>
                <input id="account_password" class="form-control" size="30" type="password" placeholder="Enter Password" data-error="Please fill out password" value="<?php echo $uapword; ?>" data-typetoggle="#show-password" required>
				<div class="checkbox">
				  <label><input id="show-password" type="checkbox">Show Password</label>
				</div>
				<span class="help-block with-errors"></span>
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-sm-3">
            <div class="form-group">
                <label for="account_title_position">Title/Position</label>
                <input id="account_title_position" class="form-control" size="30" type="text" placeholder="Enter title or position" value="<?php echo $uatitle; ?>">
            </div>		
		</div>
		<div class="col-sm-9">&nbsp;</div>
	</div>
</fieldset>
<?php echo $down.$buttons; ?>
<hr style="margin-top: 40px;">
</form>
<div><input id="username-exists" type="hidden" value="0"></div>