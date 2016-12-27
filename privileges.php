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

$data["privilege_date"] = "CURRENT_TIMESTAMP";
$data["privilege_aid"] = $aid;

$p_query = new dbase('privileges');
$p_query->one();
$p_query->execute();
$p_query->add($data);
$p_query->execute();
// $p_query->debug();

$str_response = "Department Successfully Added.";

echo $str_response;

break;

case "edit":
$privilege_department = $_POST['privilege_department'];

$sql = "SELECT * FROM privileges WHERE privilege_department = $privilege_department";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$str_response = json_encode($rec);
}
db_close();

echo $str_response;
break;

case "update":
$data = $_POST;
$arr_id = $_GET;

$sql = "SELECT * FROM privileges WHERE privilege_department = " . $arr_id['privilege_department'];
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
db_close();

if ($rc) {
$p_query = new dbase('privileges');
$p_query->update($data,$arr_id);
$p_query->execute();
// $p_query->debug();
} else {
$data["privilege_date"] = "CURRENT_TIMESTAMP";
$data["privilege_aid"] = $aid;

$p_query = new dbase('privileges');
$p_query->one();
$p_query->execute();
$p_query->add($data);
$p_query->execute();
// $p_query->debug();
}

$str_response = "Department Info Successfully Updated.";

echo $str_response;
break;

case "check":
$privilege = $_POST['privilege'];

$account_department = $_SESSION['account_department'];
$account_privileges = $_SESSION['account_privileges'];

$ap = 0;

$sql = "SELECT * FROM privileges WHERE privilege_department = $account_department";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
		$rec = $rs->fetch_array();
		if ($rec[$privilege] == 1) $ap = 1;
}
db_close();

if ($account_privileges == 1114) $ap = 1;

echo $ap;
break;

}

?>