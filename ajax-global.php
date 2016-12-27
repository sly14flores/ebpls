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

case "populate_select":
$table = $_POST['table'];
$value = $_POST['value'];
$option = $_POST['option'];
$sel = $_POST['sel'];

$str_response = populateSelect($table,$value,$option,$sel);

echo $str_response;
break;

case "get_primary_key":
$primary_key = $_POST['primary_key'];
$table = $_POST['table'];
$criteria = $_POST['criteria'];
$str = $_POST['str'];

$pk = 0;

$sql = "SELECT $primary_key FROM $table WHERE $criteria = '$str'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$pk = $rec[0];
}
db_close();

echo $pk;
break;

case "get_department_id":
$foreign_key = $_POST['foreign_key'];
$table = $_POST['table'];
$primary_key = $_POST['primary_key'];
$get_id = $_POST['get_id'];

$dept_id = 0;

$sql = "SELECT $foreign_key FROM $table WHERE $primary_key = $get_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$dept_id = $rec[0];
}
db_close();

echo $dept_id;
break;

case "get_application_id":
$primary_key = $_POST['primary_key'];
$table = $_POST['table'];
$criteria = $_POST['criteria'];
$str = $_POST['str'];

$app_id = 0;

$sql = "SELECT $primary_key FROM $table WHERE $criteria = '$str'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$app_id = $rec[0];
}
db_close();

echo $app_id;
break;

case "typeahead":
$selects = $_POST['selects'];
$table = $_POST['table'];
$order = $_POST['order'];

$order_group = "ORDER";
if ($table == "applications") $order_group = "GROUP";

$sql = "SELECT $selects FROM $table $order_group BY $order";

$json = '[';
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$json .= "'" . addslashes($rec[0]) . "', ";
	}
$json = substr($json,0,strlen($json)-2);
}
db_close();
$json .= ']';

echo $json;
break;

}

?>