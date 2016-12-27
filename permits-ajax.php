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

$application_no = (isset($_GET['application_no'])) ? $_GET['application_no'] : "";
$application_reference_no = (isset($_GET['application_reference_no'])) ? $_GET['application_reference_no'] : "";
$applicant_fullname = (isset($_GET['applicant_fullname'])) ? $_GET['applicant_fullname'] : "";
$application_form = (isset($_GET['application_form'])) ? $_GET['application_form'] : "all";
$application_organization_type = (isset($_GET['application_organization_type'])) ? $_GET['application_organization_type'] : "all";
$application_mode_of_payment = (isset($_GET['application_mode_of_payment'])) ? $_GET['application_mode_of_payment'] : "all";
$application_date = (isset($_GET['application_date'])) ? $_GET['application_date'] : "";
if ($application_date != "") $application_date = date("Y-m-d",strtotime($application_date));
$application_month = (isset($_GET['application_month'])) ? $_GET['application_month'] : "0";
$application_year = (isset($_GET['application_year'])) ? $_GET['application_year'] : "";

$filter = " WHERE permit_id != 0";
$c1 = " and permit_reference_no = '$application_reference_no'";
$c2 = " and (SELECT concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename) FROM applications WHERE application_id = permit_fid) = '$applicant_fullname'";
$c3 = " and (SELECT application_form FROM applications WHERE application_id = permit_fid) = '$application_form'";
$c4 = " and (SELECT application_organization_type FROM applications	WHERE application_id = permit_fid) = '$application_organization_type'";
$c5 = " and permit_mode_of_payment = '$application_mode_of_payment'";
$c6 = " and substring(permit_date_issued,1,10) = '$application_date'";
$c7 = " and permit_date_issued like '%-$application_month-%'";
$c8 = " and permit_date_issued like '$application_year-%'";
$c9 = " and permit_application_no like '%$application_no%'";

if ($application_reference_no == "") $c1 = "";
if ($applicant_fullname == "") $c2 = "";
if ($application_form == "all") $c3 = "";
if ($application_organization_type == "all") $c4 = "";
if ($application_mode_of_payment == "all") $c5 = "";
if ($application_date == "") $c6 = "";
if ($application_month == "0") $c7 = "";
if ($application_year == "") $c8 = "";
if ($application_no == "") $c9 = "";

$filter .= $c1 . $c2 . $c3 . $c4 . $c5 . $c6 . $c7 . $c8 . $c9;

$sql = "SELECT count(*) FROM permits $filter";
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

$arr_head = array("Application No.","Ref.No.","Full Name","Business Name","Date Issued","Action");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT permit_id, permit_application_no, permit_reference_no, (SELECT concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename) FROM applications WHERE application_id = permit_fid) full_name, (SELECT application_taxpayer_business_name FROM applications WHERE application_id = permit_fid) business_name, permit_date_issued, (SELECT application_date FROM applications WHERE application_id = permit_fid) date_of_application FROM permits $filter ORDER BY permit_id DESC $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['permit_id'],
		$rec['permit_application_no'],
		$rec['permit_reference_no'],
		$rec['full_name'],
		$rec['business_name'],
		date("M j, Y",strtotime($rec['date_of_application'])),		
		'<a style="margin-right: 15px;" href="javascript: editBusinessPermit(' . $rec['permit_id'] . ');" data-toggle="tooltip" data-placement="top" title="Edit additional info"><img src="images/edit.png"></a><a href="javascript: printBusinessPermit(' . $rec['permit_id'] . ');" data-toggle="tooltip" data-placement="top" title="Print Business Permit"><img src="images/Printer-icon.png"></a>'
		);		
		
		$c++;
	}
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

if ($total_num_rows > $per_page) {

	$pagination = new pageNav('rfilterPermits()',$current_page,$total_pages,'content');

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

case "update":
$data = $_POST;
$arr_id = $_GET;

$data['permit_or_date'] = ($data['permit_or_date'] != "") ? date("Y-m-d",strtotime($_POST['permit_or_date'])) : "";
$data['permit_sss_date'] = ($data['permit_sss_date'] != "") ? date("Y-m-d",strtotime($_POST['permit_sss_date'])) : "";

$sql = "UPDATE permits SET permit_or_no = '" . $data['permit_or_no'] . "', permit_or_date = '" . $data['permit_or_date'] . "', permit_sss_clearance = '" . $data['permit_sss_clearance'] . "', permit_sss_date = '" . $data['permit_sss_date'] . "' WHERE permit_id = ". $arr_id['permit_id'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

$str_response = "Business Permit Info Updated.";

echo $str_response;

break;

case "async_search_appno":
$field = $_POST['field'];
$val = $_POST['val'];

$sql = "SELECT application_id, application_no, application_reference_no, CONCAT(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename) application_fullname, application_taxpayer_business_name FROM applications WHERE $field like '%$val%'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$str_response .= '<tr onclick="clickGenPermit(\'' . $rec['application_id'] . '\');">';
		$str_response .= '<td>' . $rec['application_no'] . '</td>';
		$str_response .= '<td>' . $rec['application_reference_no'] . '</td>';
		$str_response .= '<td>' . $rec['application_fullname'] . '</td>';
		$str_response .= '<td>' . $rec['application_taxpayer_business_name'] . '</td>';
		$str_response .= '</tr>';
	}
}
db_close();

echo $str_response;
break;

case "generate_business_permit":
$data = $_POST;

$permit_id = 0;

$permit_fid = $data['application_id'];
$permit_application_no = "";
$permit_reference_no = "";
$permit_fee = 0;
$permit_tax = 0;
$permit_mode_of_payment = "";

$permit_or_no = "";
$permit_or_date = "CURRENT_TIMESTAMP";

$sql = "SELECT payment_schedule_fid, (SELECT application_no FROM applications WHERE application_id = payment_schedule_fid) permit_application_no, (SELECT application_reference_no FROM applications WHERE application_id = payment_schedule_fid) permit_reference_no, payment_schedule_payment_mode, ifnull((SELECT aba_item_amount FROM aba_items WHERE aba_item_fid = payment_schedule_fid AND aba_item_assessment = 8),0) permit_fee, ifnull((SELECT aba_item_amount FROM aba_items WHERE aba_item_fid = payment_schedule_fid AND aba_item_assessment = 1),0) permit_tax FROM billing WHERE payment_schedule_fid = $permit_fid ORDER BY payment_schedule_id ASC LIMIT 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	// $permit_fid = $rec['payment_schedule_fid'];
	$permit_application_no = $rec['permit_application_no'];
	$permit_reference_no = $rec['permit_reference_no'];
	$permit_mode_of_payment = $rec['payment_schedule_payment_mode'];
	$permit_fee = $rec['permit_fee'];
	$permit_tax = $rec['permit_tax'];
}
db_close();

if (($permit_application_no == "") || ($permit_reference_no == "")) {
	$str_response = "Application has no payment schedule. Please ask at the Treasurer's Office.";
	return $str_response;
}

$sql = "SELECT permit_application_no FROM permits WHERE permit_application_no = '$permit_application_no'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
db_close();

if ($rc == 0) {
$incr = "ALTER TABLE permits AUTO_INCREMENT = 1";
db_connect();
$db_con->query($START_T);
$db_con->query($incr);
$db_con->query($END_T);
db_close();

// generate mayor's permit
$sql = "INSERT INTO permits ";
$sql .= "(permit_fid, permit_application_no, permit_reference_no, permit_fee, permit_tax, permit_mode_of_payment, permit_or_no, permit_or_date, permit_date_issued, permit_aid) VALUES ";
$sql .= "($permit_fid, '$permit_application_no', '$permit_reference_no', $permit_fee, $permit_tax, '$permit_mode_of_payment', '$permit_or_no', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, $aid)";

db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$str_response = $db_con->insert_id;
$db_con->query($END_T);
db_close();
} else {
	$str_response = "Mayor's Permit for $permit_application_no was already generated. Please use the search option.";
}

echo $str_response;
break;

case "delete":
$data = $_POST;

$bp_query = new dbase('permits');
$bp_query->delete($data);
$bp_query->execute();
// $bp_query->debug();

$str_response = "Permit(s) Successfully Deleted.";

echo $str_response;
break;

}

?>