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

case "async_add_tax":
$data = $_POST;

$data['tax_date'] = "CURRENT_TIMESTAMP";
$data['tax_aid'] = $aid;

$t_query = new dbase('taxes');
$t_query->one();
$t_query->execute();
$t_query->add($data);
$last_t_id = $t_query->sql_get_id();

echo $last_t_id;
break;

case "async_field":
$key = "tax_id";
$id = $_POST['pid'];
$field = $_POST['field'];
$value = $_POST['value'];

$t_query = new dbase('taxes');
$t_query->async_add($field,$value,$key,$id);
$t_query->execute();
// $t_query->debug();

echo $str_response;
break;

case "contents":
$per_page = 20;
$total_num_rows = 0;
$total_pages = 0;

$d = (isset($_GET['d'])) ? $_GET['d'] : 0;
$current_page = (isset($_GET['cp'])) ? $_GET['cp'] : 1;

$ftdesc = (isset($_GET['ftdesc'])) ? $_GET['ftdesc'] : "";

$filter = " WHERE tax_id != 0";
$c1 = " and tax_description like '%$ftdesc%'";

if ($ftdesc == "") $c1 = "";

$filter .= $c1;

$sql = "SELECT count(*) FROM taxes $filter";
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

$str_response = '<form name="tContent" id="tContent">';
$str_response .= '<table class="table table-striped">';

$arr_head = array("No.","Description","Note","Date Added/Modified");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT tax_id, tax_description, tax_note, tax_date, tax_aid FROM taxes $filter $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['tax_id'],
		$c,		
		$rec['tax_description'],
		$rec['tax_note'],
		date("M j, Y",strtotime($rec['tax_date']))	
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

case "delete":
$data = $_POST;

$t_query = new dbase('taxes');
$t_query->delete($data);
$t_query->execute();
// $t_query->debug();

$_data["formula_tax_id"] = $_POST['tax_id'];
$tf_query = new dbase('tax_formulas');
$tf_query->delete($_data);
$tf_query->execute();
// $tf_query->debug();

$str_response = "Tax Formula Successfully Deleted.";

echo $str_response;
break;

}

?>