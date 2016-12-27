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

$data["department_date_added"] = "CURRENT_TIMESTAMP";
$data["department_aid"] = $aid;

$dhead_id = returnTypeaheadID("account_id","accounts","concat(account_lname, ', ', account_fname, ' ', account_mname)",$_POST['department_head']);
$data["department_head"] = $dhead_id;

$d_query = new dbase('departments');
$d_query->one();
$d_query->execute();
$d_query->add($data);
$str_response = $d_query->sql_get_id();
// $d_query->debug();

echo $str_response;

break;

case "update":
$data = $_POST;
$arr_id = $_GET;

$dhead_id = returnTypeaheadID("account_id","accounts","concat(account_lname, ', ', account_fname, ' ', account_mname)",$_POST['department_head']);
$data["department_head"] = $dhead_id;

$d_query = new dbase('departments');
$d_query->update($data,$arr_id);
$d_query->execute();
// $d_query->debug();

$str_response = $arr_id['department_id'];

echo $str_response;

break;

case "delete":
$data = $_POST;

$d_query = new dbase('departments');
$d_query->delete($data);
$d_query->execute();
// $d_query->debug();

$del['privilege_department'] = $data['department_id'];
$p_query = new dbase('privileges');
$p_query->delete($del);
$p_query->execute();
// $p_query->debug();

$str_response = "Department Successfully Deleted.";

echo $str_response;

break;

case "contents":
$per_page = 10;
$total_num_rows = 0;
$total_pages = 0;

$d = (isset($_GET['d'])) ? $_GET['d'] : 0;
$current_page = (isset($_GET['cp'])) ? $_GET['cp'] : 1;

$fdeptname = (isset($_GET['fdeptname'])) ? $_GET['fdeptname'] : "";

$filter = " WHERE department_id != 0";
$c1 = " and department_name like '$fdeptname%'";

if ($fdeptname == "") $c1 = "";

$filter .= $c1;

$sql = "SELECT count(*) FROM departments $filter";
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

$arr_head = array("Name","Head","Note","Date Added");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT department_id, department_name, (select concat(account_lname, ', ', account_fname, ' ', account_mname) from accounts where account_id = department_head) d_head, department_note, department_date_added, department_aid FROM departments $filter $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['department_id'],
		$rec['department_name'],
		$rec['d_head'],
		$rec['department_note'],
		date("M j, Y",strtotime($rec['department_date_added']))		
		);		
		
		$c++;
	}
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

if ($total_num_rows > $per_page) {

	$pagination = new pageNav('rfilterDept()',$current_page,$total_pages,'content');

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

}

?>