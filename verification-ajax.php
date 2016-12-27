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

case "contents":
$per_page = 10;

$str_response = '<form name="frmContent" id="frmContent">';
$str_response .= '<table class="table table-striped">';

$arr_head = array("Description","Office/Agency","Department","Date Added/Modified");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT manage_verification_id, manage_verification_order, manage_verification_description, manage_verification_agency, (select department_name from departments where department_id = manage_verification_department) manage_verification_d, manage_verification_date, manage_verification_aid FROM manage_verification";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['manage_verification_id'],
		$rec['manage_verification_description'],
		$rec['manage_verification_agency'],
		$rec['manage_verification_d'],
		date("M j, Y",strtotime($rec['manage_verification_date']))		
		);		
		
		$c++;
	}
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

$str_response .= '</table>';
$str_response .= '</form>';

echo $str_response;
break;

case "add":
$data = $_POST;

$data["manage_verification_date"] = "CURRENT_TIMESTAMP";
$data["manage_verification_aid"] = $aid;

$v_query = new dbase('manage_verification');
$v_query->one();
$v_query->execute();
$v_query->add($data);
$v_query->execute();
// $v_query->debug();

$str_response = "Verification Successfully Added.";

echo $str_response;
break;

case "update":
$data = $_POST;
$arr_id = $_GET;

$v_query = new dbase('manage_verification');
$v_query->update($data,$arr_id);
$v_query->execute();
// $v_query->debug();

$str_response = "Verification Info Successfully Updated.";

echo $str_response;
break;

case "delete":
$data = $_POST;

$v_query = new dbase('manage_verification');
$v_query->delete($data);
$v_query->execute();
// $v_query->debug();

$str_response = "Verification(s) Successfully Deleted.";

echo $str_response;

break;

}

?>