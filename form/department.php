<?php

$dname = "";
$dhead = "";
$dnote = "";

require '../config.php';

$deptid = (isset($_GET['deptid'])) ? $_GET['deptid'] : 0;
$src = (isset($_GET['src'])) ? $_GET['src'] : 1;

$legend_title = "Add New Department";
$save_update = "Save";
$cancel_close = "Cancel";
if ($src == 2) {
	$legend_title = "Update Department Info";
	$save_update = "Update";	
	$cancel_close = "Close";	
}

$sql = "SELECT department_name, (select concat(account_lname, ', ', account_fname, ' ', account_mname) from accounts where account_id = department_head) d_head, department_note, department_aid FROM departments WHERE department_id = $deptid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$dname = stripslashes($rec['department_name']);
	$dhead = $rec['d_head'];
	$dnote = stripslashes($rec['department_note']);
}
db_close();

$up = '<div class="clearfix" style="position: relative; margin-bottom: 10px;">';
$down = '<div class="clearfix" style="position: relative; margin-bottom: 10px;">';

$buttons = '<div style="position: absolute; top: 0; right: 0;">';
$buttons .= '<button class="btn btn-primary btn-sm" disabled="disabled" onclick="deptForm(' . $src . ',' . $deptid . ');">' . $save_update . '</button>&nbsp;&nbsp;';
$buttons .= '<input type="button" class="btn btn-default btn-sm" onclick="cancelDeptForm();" value="' . $cancel_close . '">';
$buttons .= '</div>';
$buttons .= '</div>';

?>
<form role="form" id="frmDepartments" onSubmit="return false;">
<?php echo $up.$buttons; ?>
<fieldset>
    <legend><?php echo $legend_title; ?></legend>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
			<label for="department_name">Name</label>
			<input type="text" class="form-control" id="department_name" placeholder="Enter department name" data-error="Please fill out department name" value="<?php echo $dname; ?>" required>
			<span class="help-block with-errors"></span>
			</div>
		</div>
		<div class="col-sm-4">		
			<div class="form-group">
			<label for="department_head">Department Head</label>
			<input style="width: 300px;" type="text" class="form-control" id="department_head" placeholder="Enter department head (optional)" value="<?php echo $dhead; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			<label for="department_note">Note</label>
			<input type="text" class="form-control" id="department_note" placeholder="Enter note (optional)" value="<?php echo $dnote; ?>">
			</div>
		</div>
	</div>
</fieldset>
<fieldset id="privileges">
<legend>Privileges</legend>
<div class="row">
	<div class="col-sm-4">
		<label>Applications</label>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="add_application">Add Application			
		  </label>
		</div>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="view_application">View Application			
		  </label>
		</div>		
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="edit_application">Edit Application			
		  </label>
		</div>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="delete_application">Delete Application			
		  </label>
		</div>			
	</div>
	<div class="col-sm-4">
		<label>Business Permits</label>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="permits_module">Module Access			
		  </label>
		</div>		
	</div>
	<div class="col-sm-4">
		<label>Departments</label>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="departments_module">Departments Module
		  </label>
		</div>		
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="add_department">Add Department			
		  </label>
		</div>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="edit_department">Edit Department			
		  </label>
		</div>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="delete_department">Delete Department			
		  </label>
		</div>				
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<label>User Accounts</label>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="accounts_module">Module Access			
		  </label>
		</div>		
	</div>
	<div class="col-sm-4">
		<label>Management</label>
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="management_module">Module Access			
		  </label>
		</div>		
	</div>
	<div class="col-sm-4">&nbsp;</div>
</div>
</fieldset>
<?php echo $down.$buttons; ?>
<hr style="margin-top: 40px;">
</form>