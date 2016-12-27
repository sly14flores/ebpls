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
$per_page = 20;
$total_num_rows = 0;
$total_pages = 0;

$d = (isset($_GET['d'])) ? $_GET['d'] : 0;
$current_page = (isset($_GET['cp'])) ? $_GET['cp'] : 1;

$ffcdesc = (isset($_GET['ffcdesc'])) ? $_GET['ffcdesc'] : "";

$filter = " WHERE assessment_id != 0 AND assessment_type = 'fees_charges'";
$c1 = " and assessment_description like '%$ffcdesc%'";

if ($ffcdesc == "") $c1 = "";

$filter .= $c1;

$sql = "SELECT count(*) FROM assessments $filter";
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

$str_response = '<form name="fcContent" id="fcContent">';
$str_response .= '<table class="table table-striped">';

$arr_head = array("No.","Description","Reference","Note","Date Added/Modified");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT assessment_id, assessment_order, assessment_type, assessment_description, assessment_reference, assessment_note, assessment_date, assessment_aid FROM assessments $filter $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['assessment_id'],
		$c,
		$rec['assessment_description'],
		$rec['assessment_reference'],
		$rec['assessment_note'],
		date("M j, Y",strtotime($rec['assessment_date']))		
		);		
		
		$c++;
	}
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

$str_response .= '</table>';
$str_response .= '</form>' . $last_page;

echo $str_response;
break;

case "add":
$data = $_POST;

$data["assessment_type"] = "fees_charges";
$data["assessment_date"] = "CURRENT_TIMESTAMP";
$data["assessment_aid"] = $aid;

$fc_query = new dbase('assessments');
$fc_query->one();
$fc_query->execute();
$fc_query->add($data);
$fc_query->execute();
// $fc_query->debug();

$str_response = "Fee/Charge Successfully Added.";

echo $str_response;
break;

case "update":
$data = $_POST;
$arr_id = $_GET;

$fc_query = new dbase('assessments');
$fc_query->update($data,$arr_id);
$fc_query->execute();
// $fc_query->debug();

$str_response = "Fee/Charge Info Successfully Updated.";

echo $str_response;
break;

case "delete":
$data = $_POST;

$fc_query = new dbase('assessments');
$fc_query->delete($data);
$fc_query->execute();
// $fc_query->debug();

$str_response = "Fee(s)/Charge(s) Successfully Deleted.";

echo $str_response;
break;

}

?>