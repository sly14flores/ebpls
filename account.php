<?php

require 'config.php';
require 'globalf.php';

$START_T = "START TRANSACTION;";
$END_T = "COMMIT;";

$username = $_POST['username'];
$password = $_POST['password'];

$result = false;

db_connect();
$sql = "SELECT account_id, account_username, account_password, account_fname, account_mname, account_lname, account_privileges, account_contact, account_email, account_department, (select department_name from departments where department_id = account_department) account_d, account_date_registered, account_log, is_login, account_aid FROM accounts WHERE account_username = '$username' AND account_password = '" . enc($password) . "'";
$rs = $db_con->query($sql);
$rc = $rs->num_rows;

if ($rc>0) {
	session_start();
	$rec = $rs->fetch_array();
	// if ($rec['is_login'] == 1) {
		// $result = "login";
	// } else {
		$_SESSION['account_id'] = $rec['account_id'];
		$_SESSION['account_fname'] = $rec['account_fname'];
		$_SESSION['account_department'] = $rec['account_department'];	
		$_SESSION['account_d'] = $rec['account_d'];	
		$_SESSION['account_privileges'] = $rec['account_privileges'];
	
		$sql = "UPDATE accounts SET is_login = 1 WHERE account_id = " . $rec['account_id'];
		$db_con->query($START_T);
		$db_con->query($sql);
		$db_con->query($END_T);
		
		$result = "proceed";
	// }
}

db_close();

echo $result;

?>