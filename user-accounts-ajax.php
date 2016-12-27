<?php

session_start();
$aid = 	$_SESSION['account_id'];

require 'config.php';
require 'globalf.php';

$req = "";
$START_T = "START TRANSACTION;";
$END_T = "COMMIT;";

if (isset($_GET["p"])) $req = $_GET["p"];

$str_response = "";
$json = "";
$jpage = "";

switch ($req) {

case "add":
$data = $_POST;

$data["account_password"] = enc($_POST["account_password"]);
$data["account_date_registered"] = "CURRENT_TIMESTAMP";
$data["account_aid"] = $aid;

$ua_query = new dbase('accounts');
$ua_query->one();
$ua_query->execute();
$ua_query->add($data);
$ua_query->execute();
// $ua_query->debug();

$str_response = "User Account Successfully Added.";

echo $str_response;

break;

case "update":
$data = $_POST;
$arr_id = $_GET;

$data["account_password"] = enc($_POST["account_password"]);

$ua_query = new dbase('accounts');
$ua_query->update($data,$arr_id);
$ua_query->execute();
// $ua_query->debug();

$str_response = "User Account Info Successfully Updated.";

echo $str_response;

break;

case "delete":
$data = $_POST;

$ua_query = new dbase('accounts');
$ua_query->delete($data);
$ua_query->execute();
// $ua_query->debug();

$str_response = "User Account Successfully Added.";

echo $str_response;

break;

case "contents":
$per_page = 10;
$total_num_rows = 0;
$total_pages = 0;

$d = (isset($_GET['d'])) ? $_GET['d'] : 0;
$current_page = (isset($_GET['cp'])) ? $_GET['cp'] : 1;

$ffullname = (isset($_GET['ffullname'])) ? $_GET['ffullname'] : "";

$filter = " WHERE account_id != 0";
$c1 = " and concat(account_lname, ', ', account_fname, ' ', account_mname) like '%$ffullname%'";

if ($ffullname == "") $c1 = "";

$filter .= $c1;

$sql = "SELECT count(*) FROM accounts $filter";
db_connect();
$rs = $db_con->query($sql);
$rec = $rs->fetch_array();
$total_num_rows = $rec[0];
db_close();

$total_pages = ceil($total_num_rows / $per_page);
if ($d == 3) $current_page = $total_pages;
$last_page = "|$total_pages";

$offset = ($current_page - 1) * $per_page;
$row_page = " LIMIT $offset, $per_page";

$str_response = '<form name="frmContent" id="frmContent">';
$str_response .= '<table class="table table-striped">';

$arr_head = array("ID","Department","Full Name","Username","Contact No(s)","Date Registered");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT account_id, (select department_name from departments where department_id = account_department) account_d, concat(account_lname, ', ', account_fname, ' ', account_mname) full_name, account_username, account_contact, account_privileges, account_date_registered FROM accounts $filter ORDER BY account_id $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		
		$arr_body[$i] = array(
		$rec['account_id'],
		$rec['account_id'],		
		$rec['account_d'],
		$rec['full_name'],
		$rec['account_username'],
		$rec['account_contact'],
		date("M j, Y",strtotime($rec['account_date_registered']))
		);

		$c++;
	}	
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

if ($total_num_rows > $per_page) {

	$pagination = new pageNav('rfilterUserAccounts()',$current_page,$total_pages,'content');

	$str_response .= '<tfoot>';
	$str_response .= '<tr>';
	$str_response .= '<td colspan="' . sizeof($arr_body) . '">';
	$str_response .= $pagination->getNav();	
	$str_response .= '</td>';
	$str_response .= '</tr>';
	$str_response .= '</tfoot>';

}

$str_response .= '</table>';
$str_response .= '</form>' . $last_page;

echo $str_response;
break;

case "pop_pword":
$puaid = $_POST['puaid'];

if ($puaid == 0) $puaid = $aid;

$sql = "SELECT account_password FROM accounts WHERE account_id = $puaid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$rec = $rs->fetch_array();
$str_response = dec($rec['account_password']);
}
db_close();

echo $str_response;
break;

case "verify_uname":
$puname = (isset($_POST['puname'])) ? $_POST['puname'] : "";

$sql = "SELECT account_username FROM accounts WHERE account_username = '$puname'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) echo 1; else echo 0;
db_close();

echo $str_response;
break;

case "update_user_profile":
$data = $_POST;
$arr_id["p"] = "update_user_profile";
$arr_id["account_id"] = $aid;

$data["account_password"] = enc($_POST['account_password']);

$ua_query = new dbase('accounts');
$ua_query->update($data,$arr_id);
$ua_query->execute();
// debug_log($ua_query->debug_r());

echo $str_response;
break;

case "verify_user_profile":
$account_password = $_POST['account_password'];

$sql = "SELECT * FROM accounts WHERE account_id = $aid AND account_password = '" . enc($account_password) . "'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
$str_response = $rc;
db_close();
echo $str_response;
break;

case "pop_signature":
$puaid = $_POST['puaid'];
// $puaid = $_GET['puaid'];

if ($puaid == 0) $puaid = $aid;

$sql = "SELECT account_signature FROM accounts WHERE account_id = $puaid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$rec = $rs->fetch_array();
$str_response = json_encode($rec['account_signature']);
// $str_response = $rec['account_signature'];
}
db_close();

echo $str_response;
break;

}

?>