<?php

session_start();
$aid = 	$_SESSION['account_id'];
$account_department = $_SESSION['account_department'];

require 'config.php';
require 'globalf.php';

$req = "";
$START_T = "START TRANSACTION;";
$END_T = "COMMIT;";

if (isset($_GET["p"])) $req = $_GET["p"];

$str_response = "";
$json = "";
$jpage = "";

$app_form = array(""=>"","new_app"=>"New","renew_app"=>"Renewal","additional_app"=>"Additional");

$app_amendment = array(""=>"","single_partnership"=>"From Single to Partnership","single_corporation"=>"From Single to Corporation","partnership_single"=>"From Partnership to Single","partnership_corporation"=>"From Partnership to Corporation","corporation_single"=>"From Corporation to Single","corporation_partnership"=>"From Corporation to Partnership");

$app_organization = array(""=>"","single_organization"=>"Single","partnership_organization"=>"Partnership","corporation_organization"=>"Corporation","cooperative_organization"=>"Cooperative");

$app_mode_of_payment = array(""=>"","pay_annually"=>"Annually","pay_bi_annually"=>"Bi-Annually","pay_quarterly"=>"Quarterly");

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

$filter = " WHERE application_id != 0";
$c1 = " and application_reference_no like '%$application_reference_no%'";
$c2 = " and concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename) = '$applicant_fullname'";
$c3 = " and application_form = '$application_form'";
$c4 = " and application_organization_type = '$application_organization_type'";
$c5 = " and application_mode_of_payment = '$application_mode_of_payment'";
$c6 = " and substring(application_date,1,10) = '$application_date'";
$c7 = " and application_date like '%-$application_month-%'";
$c8 = " and application_date like '$application_year-%'";
$c9 = " and application_no like '%$application_no%'";

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

$sql = "SELECT count(*) FROM applications $filter";
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

$arr_head = array("Ref.No.","App.No.","Date","Full Name","Application","Organization","Business Name","Business Line","Mode of Payment","Business Status","App Status");
$content = new content($arr_head);
$str_response .= $content->header();

$business_status = array(""=>"","operating"=>"Operating","not_renewed"=>"Not Renewed","closed_terminated"=>"Closed/Terminated","delinquent"=>"Delinquent");
/*
** delinquent permits
*/
$renewal_due = date("Y-01-20");
$sql = "SELECT application_id, application_no, application_form, application_amendment, application_taxpayer_business_name, application_mode_of_payment, application_date, application_reference_no, application_dti_sec_cda, application_dti_sec_cda_date, application_organization_type, application_ctc_no, application_ctc_date, application_tin, application_entity, application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename, application_taxpayer_business_name, application_trade_franchise, application_treasurer_lastname, application_treasurer_firstname, application_treasurer_middlename, application_business_address_no, application_business_address_bldg, application_business_address_unit_no, application_business_address_street, application_business_address_brgy, application_business_address_subd, application_business_address_mun_city, application_business_address_province, application_business_address_tel_no, application_business_address_email, application_owner_address_no, application_owner_address_bldg, application_owner_address_unit_no, application_owner_address_street, application_owner_address_brgy, application_owner_address_subd, application_owner_address_mun_city, application_owner_address_province, application_owner_address_tel_no, application_owner_address_email, application_pin, application_business_area, application_no_employees, application_no_residing, application_lessor_lastname, application_lessor_firstname, application_lessor_middlename, application_monthly_rental, application_lessor_address_no, application_lessor_address_street, application_lessor_address_brgy, application_lessor_address_subd, application_lessor_address_mun_city, application_lessor_address_province, application_lessor_address_tel_no, application_lessor_address_email, application_contact_person, application_position_title, (concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)) full_name, (SELECT ba_line FROM business_activities WHERE ba_id = (SELECT aba_b_line FROM application_business_activities WHERE aba_fid = application_id)) business_line, business_status FROM applications $filter ORDER BY application_date DESC, application_no DESC, application_reference_no DESC $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$bs = $rec['business_status'];
		$succeeding_year = date("Y",strtotime("+1 Year",strtotime($rec['application_date'])));
		$sql1 = "SELECT * FROM applications WHERE application_reference_no = '$rec[application_reference_no]' AND SUBSTRING(application_date,1,4) = $succeeding_year";
		$rs1 = $db_con->query($sql1);
		$rc1 = $rs1->num_rows;
		if ($rc1 == 0) $bs = "delinquent";
		else $bs = "operating";
		if (date("Y",strtotime($rec['application_date'])) == date("Y")) $bs = "operating";
		$arr_body[$i] = array(
		$rec['application_id'],
		$rec['application_reference_no'],
		'<a href="javascript: viewApplication(\'' . $rec['application_id'] . '\');">' . $rec['application_no'] . '</a>',		
		date("M j, Y",strtotime($rec['application_date'])),
		$rec['full_name'],
		$app_form[$rec['application_form']],
		$app_organization[$rec['application_organization_type']],
		$rec['application_taxpayer_business_name'],
		$rec['business_line'],
		$app_mode_of_payment[$rec['application_mode_of_payment']],
		$business_status[$bs],
		'<a href="javascript: checkStatus(\'' . $rec['application_id'] . '\');" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Click to check application status for application no: ' . $rec['application_no'] . '"><img src="images/search-icon.png"></span>'
		);		
		
		$c++;
	}
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

if ($total_num_rows > $per_page) {

	$pagination = new pageNav('rfilterApplication()',$current_page,$total_pages,'content');

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

case "add":
$city_municipality = "Bacnotan";
$province = "La Union";

$data["application_date"] = "CURRENT_TIMESTAMP";
$data["application_business_address_mun_city"] = $city_municipality;
$data["application_business_address_province"] = $province;
$data["application_owner_address_mun_city"] = $city_municipality;
$data["application_owner_address_province"] = $province;
$data["application_lessor_address_mun_city"] = $city_municipality;
$data["application_lessor_address_province"] = $province;
$data["application_taxpayer_gender"] = "Male";

$a_query = new dbase('applications');
$a_query->one();
$a_query->execute();
$a_query->add($data);
$arr_response['application_id'] = $a_query->sql_get_id();
// $a_query->debug();

// $arr_response['application_reference_no'] = genRefNo($arr_response['application_id']);

$str_response = json_encode($arr_response);

echo $str_response;

break;

case "async_add":
$key = "application_id";
$id = $_POST['pid'];
$field = $_POST['field'];
$value = $_POST['value'];

if ($field == 'application_dti_sec_cda_date') {
	if ($value != '') $value = date("Y-m-d",strtotime($value));
}
if ($field == 'application_ctc_date') {
	if ($value != '') $value = date("Y-m-d",strtotime($value));
}
if ($field == 'application_date') {
	if ($value != '') $value = date("Y-m-d",strtotime($value));
}

$a_query = new dbase('applications');
$a_query->async_add($field,$value,$key,$id);
$a_query->execute();
// $a_query->debug();

echo $str_response;

break;

case "async_add_ba":
$key = "aba_id";
$id = $_POST['pid'];
$field = $_POST['field'];
$value = $_POST['value'];

$aba_query = new dbase('application_business_activities');
$aba_query->async_add($field,$value,$key,$id);
$aba_query->execute();
// $aba_query->debug();

echo $str_response;

break;

case "async_update_field":
$key = "application_id";
$id = $_POST['pid'];
$field = $_POST['field'];
$value = $_POST['value'];

$a_query = new dbase('applications');
$a_query->async_update_field($field,$value,$key,$id);
$a_query->execute();
// $a_query->debug();

echo $str_response;

break;

case "cancel_application":
$data = $_POST;

$a_query = new dbase('applications');
$a_query->delete($data);
$a_query->execute();
// $a_query->debug();

$mdata["aba_fid"] = $_POST['application_id'];
$a_query = new dbase('application_business_activities');
$a_query->delete($mdata);
$a_query->execute();
// $a_query->debug();

$_mdata["aba_item_fid"] = $_POST['application_id'];
$a_query = new dbase('aba_items');
$a_query->delete($_mdata);
$a_query->execute();
// $a_query->debug();

$_mdata_["verification_fid"] = $_POST['application_id'];
$a_query = new dbase('application_verifications');
$a_query->delete($_mdata_);
$a_query->execute();
// $a_query->debug();

$pk_data["payment_schedule_fid"] = $_POST['application_id'];
$a_query = new dbase('billing');
$a_query->delete($pk_data);
$a_query->execute();
// $a_query->debug();

/* $_pk_data["permit_fid"] = $_POST['application_id'];
$a_query = new dbase('permits');
$a_query->delete($_pk_data);
$a_query->execute();
// $a_query->debug(); */

$sn_pk["sn_fid"] = $_POST['application_id'];
$a_query = new dbase('status_notifications');
$a_query->delete($sn_pk);
$a_query->execute();
// $a_query->debug();

echo $str_response;

break;

case "view":
$pid = $_POST['pid'];

$sql = "SELECT application_id, application_no, application_form, application_amendment, application_mode_of_payment, application_date, application_reference_no, application_dti_sec_cda, application_dti_sec_cda_date, application_organization_type, application_ctc_no, application_ctc_date, application_tin, application_entity, application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename, application_taxpayer_gender, application_taxpayer_business_name, application_trade_franchise, application_treasurer_lastname, application_treasurer_firstname, application_treasurer_middlename, application_business_address_no, application_business_address_bldg, application_business_address_unit_no, application_business_address_street, application_business_address_brgy, application_business_address_subd, application_business_address_mun_city, application_business_address_province, application_business_address_tel_no, application_business_address_email, application_owner_address_no, application_owner_address_bldg, application_owner_address_unit_no, application_owner_address_street, application_owner_address_brgy, application_owner_address_subd, application_owner_address_mun_city, application_owner_address_province, application_owner_address_tel_no, application_owner_address_email, application_pin, application_business_area, application_no_employees, application_no_residing, application_business_rented, application_lessor_lastname, application_lessor_firstname, application_lessor_middlename, application_monthly_rental, application_lessor_address_no, application_lessor_address_street, application_lessor_address_brgy, application_lessor_address_subd, application_lessor_address_mun_city, application_lessor_address_province, application_lessor_address_tel_no, application_lessor_address_email, application_contact_person, application_position_title, concat(application_taxpayer_firstname, ' ', ucase(substring(application_taxpayer_middlename,1,1)), '. ', application_taxpayer_lastname) printed_name, application_signatory_lastname, application_signatory_firstname, application_signatory_middlename, concat(application_signatory_firstname, ' ', ucase(substring(application_signatory_middlename,1,1)), '. ', application_signatory_lastname) signatory_name FROM applications WHERE application_id = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$rec['application_date'] = date("m/d/Y",strtotime($rec['application_date']));
	$rec['application_dti_sec_cda_date'] = ($rec['application_dti_sec_cda_date'] == "0000-00-00") ? "" : date("m/d/Y",strtotime($rec['application_dti_sec_cda_date']));
	$rec['application_ctc_date'] = ($rec['application_ctc_date'] == "0000-00-00") ? "" : date("m/d/Y",strtotime($rec['application_ctc_date']));
	$rec['application_monthly_rental_p'] = ($rec['application_monthly_rental'] == 0) ? "0" : "Php. " . number_format($rec['application_monthly_rental'],2);
	if ($rec['application_signatory_lastname'] != "") $rec['printed_name'] = $rec['signatory_name'];
	$str_response = $rec;
}
db_close();

$str_response = json_encode($str_response);

echo $str_response;
break;

case "view_ba":
$pid = $_POST['pid'];

$json = '{ "aba_items": [';
$json .= '{';
$json .= '"aba_id":0,';
$json .= '"aba_code":0,';
$json .= '"aba_code_name":"",';
$json .= '"aba_b_line":0,';
$json .= '"aba_b_line_name":"",';
$json .= '"aba_units":0,';
$json .= '"aba_gross_base":"",';
$json .= '"aba_gross_amount":0';
$json .= '},';
$sql = "SELECT aba_id, aba_fid, aba_code, (SELECT ba_code FROM business_activities WHERE ba_id = aba_code) aba_code_name, aba_b_line, (SELECT ba_line FROM business_activities WHERE ba_id = aba_b_line) aba_b_line_name, aba_units, aba_gross_base, aba_gross_amount, aba_date, aba_aid FROM application_business_activities WHERE aba_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$json .= '{';
		$rec = $rs->fetch_array();
		$json .= '"aba_id":' . $rec['aba_id'] . ',';
		$json .= '"aba_code":' . $rec['aba_code'] . ',';
		$json .= '"aba_code_name":"' . $rec['aba_code_name'] . '",';
		$json .= '"aba_b_line":' . $rec['aba_b_line'] . ',';
		$json .= '"aba_b_line_name":"' . $rec['aba_b_line_name'] . '",';
		$json .= '"aba_units":' . $rec['aba_units'] . ',';
		$json .= '"aba_gross_base":"' . $rec['aba_gross_base'] . '",';
		if (isset($_POST['origin'])) $json .= '"aba_gross_amount":"Php. ' . number_format($rec['aba_gross_amount'],2) . '"'; 
		else $json .= '"aba_gross_amount":' . $rec['aba_gross_amount'] . '';
		$json .= '},';
	}
}
db_close();

$json = substr($json,0,strlen($json)-1);
$json .= ']}';

echo $json;
break;

case "delete":
$data = $_POST;

$a_query = new dbase('applications');
$a_query->delete($data);
$a_query->execute();
// $a_query->debug();

$mdata["aba_fid"] = $_POST['application_id'];
$a_query = new dbase('application_business_activities');
$a_query->delete($mdata);
$a_query->execute();
// $a_query->debug();

$_mdata["aba_item_fid"] = $_POST['application_id'];
$a_query = new dbase('aba_items');
$a_query->delete($_mdata);
$a_query->execute();
// $a_query->debug();

$_mdata_["verification_fid"] = $_POST['application_id'];
$a_query = new dbase('application_verifications');
$a_query->delete($_mdata_);
$a_query->execute();
// $a_query->debug();

$pk_data["payment_schedule_fid"] = $_POST['application_id'];
$a_query = new dbase('billing');
$a_query->delete($pk_data);
$a_query->execute();
// $a_query->debug();

/* $_pk_data["permit_fid"] = $_POST['application_id'];
$a_query = new dbase('permits');
$a_query->delete($_pk_data);
$a_query->execute();
// $a_query->debug(); */

$sn_pk["sn_fid"] = $_POST['application_id'];
$a_query = new dbase('status_notifications');
$a_query->delete($sn_pk);
$a_query->execute();
// $a_query->debug();

$str_response = "Application Successfully Deleted.";

echo $str_response;

break;

case "add_ba":
$data = $_POST;

$data["aba_date"] = "CURRENT_TIMESTAMP";
$data["aba_aid"] = $aid;

$aba_query = new dbase('application_business_activities');
$aba_query->one();
$aba_query->execute();
$aba_query->add($data);
$str_response = $aba_query->sql_get_id();
// $aba_query->debug();

echo $str_response;
break;

case "rem_ba":
$data = $_POST;

$aba_fid = 0;
$sql = "SELECT aba_fid FROM application_business_activities WHERE aba_id = " . $data['aba_id'];
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$aba_fid = $rec['aba_fid'];
}
db_close();

$aba_query = new dbase('application_business_activities');
$aba_query->delete($data);
$aba_query->execute();
// $aba_query->debug();

$del['aba_item_fid'] = $aba_fid;
$aba_query = new dbase('aba_items');
$aba_query->delete($del);
$aba_query->execute();
// $aba_query->debug();

echo $str_response;
break;

case "async_search_ba":
$field = $_POST['field'];
$val = $_POST['val'];
$abaid = $_POST['abaid'];

$sql = "SELECT ba_id, ba_organization, ba_cen, ba_code, ba_line, ba_note, ba_date FROM business_activities WHERE $field like '%$val%'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$str_response .= '<tr onclick="clickUpdateBA(' . $abaid . ',\'' . addslashes($rec['ba_code']) . '\',\'' . addslashes($rec['ba_line']) . '\',' . $rec['ba_id'] . ',\'' . $rec['ba_cen'] . '\');">';
		$str_response .= '<td>' . $rec['ba_code'] . '</td>';
		$str_response .= '<td>' . $rec['ba_line'] . '</td>';
		$str_response .= '<td>' . $rec['ba_note'] . '</td>';
		$str_response .= '<td>' . $ba_cen[$rec['ba_cen']] . '</td>';
		$str_response .= '<td>' . $rec['ba_organization'] . '</td>';
		$str_response .= '</tr>';
	}
}
db_close();

echo $str_response;
break;

case "ini_app_assessment":
$pid = $_POST['pid'];
$ini_check_penalty = isset($_POST['ini_check_penalty']) ? $_POST['ini_check_penalty'] : ""; debug_log($ini_check_penalty);
$recompute = (isset($_POST['recompute'])) ? $_POST['recompute'] : "";
$recompute_tax_penalty = (isset($_POST['recompute_tax_penalty'])) ? $_POST['recompute_tax_penalty'] : "";
$apply_penalty = (isset($_POST['apply_penalty'])) ? $_POST['apply_penalty'] : "";

if ($apply_penalty == "toggle_penalty") $ini_check_penalty = "ini_penalty";

$date_due = date("Y-m-d");
$recent_application_date = date("Y");
$sql = "SELECT application_date FROM applications WHERE application_id = (SELECT application_fid FROM applications WHERE application_id = $pid)";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$recent_application_date = date("Y",strtotime("+1 Year",strtotime($rec['application_date'])));
}
db_close();

// check if renewal - for penalty purposes
$for_renewal = false;
$sql = "SELECT application_form FROM applications WHERE application_id = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_form'] == "renew_app") $for_renewal = true;
}
db_close();

$ra_date = "$recent_application_date-01-01";
$jan_due_date = "$recent_application_date-01-20";
$month_diff = (int)(monthsBetween($ra_date,$date_due));
$penalty_interest = $month_diff*2;

$aba_b_line = 0;
$aba_b_line_desc = "";
$ba_cen = "";
$aba_gross_amount = 0;
$sql = "SELECT aba_b_line, (SELECT ba_line FROM business_activities WHERE ba_id = aba_b_line) aba_b_line_desc, aba_gross_base, aba_gross_amount FROM application_business_activities WHERE aba_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$aba_b_line = $rec['aba_b_line'];
	$aba_b_line_desc = $rec['aba_b_line_desc'];
	$ba_cen = $rec['aba_gross_base'];	
	$aba_gross_amount = $rec['aba_gross_amount'];
}
db_close();

$json = '{ "aba": [{';
$json .= '"aba_b_line_desc":"' . $aba_b_line_desc . '",';
$json .= '"ba_cen":"' . $ba_cen . '",';
$json .= '"aba_gross_amount":"' . number_format($aba_gross_amount,2) . '"';
$json .= '}] }';

// cache items that are already added
$sql = "SELECT aba_item_id, aba_item_fid, aba_item_assessment, aba_item_amount, aba_item_penalty, aba_item_assessed_by, aba_item_aid FROM aba_items WHERE aba_item_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$arr_items_added[$i] = $rec['aba_item_assessment'];
	}
}
db_close();

function chk_items($arr,$a) {
$result = false;
	foreach ($arr as $key => $value) {
		if ($value == $a) $result = true;
	}
return $result;	
}
//
// if (isset($arr_items_added)) debug_log(print_r($arr_items_added));
$_insert = "";
$insert = "";
$sql = "SELECT ba_item_id, ba_item_baid, ba_assessment_id, ba_item_is_tax, ba_item_amount, if(ba_assessment_id = 1,ba_item_tax_formula,0) tax_formula, ba_item_penalty, ba_item_date, ba_item_aid FROM business_activity_items WHERE ba_item_baid = $aba_b_line ORDER BY ba_assessment_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$_insert = 'INSERT INTO aba_items (aba_item_fid, aba_item_assessment, aba_item_amount, aba_item_penalty, aba_item_assessed_by, aba_item_aid) VALUES ';
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		
		$penalty = 0;
		$surcharge = 0;
		$ba_item_amount = $rec['ba_item_amount'];
		$ba_item_penalty = 0;
		if ($rec['tax_formula'] != 0) {
			$sql_formula = "SELECT formula_id, formula_param, formula_start, formula_end, formula_amount_percentage, formula_percentage_of FROM tax_formulas WHERE formula_tax_id = " . $rec['tax_formula'] . " ORDER BY formula_id";
			$nrs = $db_con->query($sql_formula);			
			$nrc = $nrs->num_rows;
			if ($nrc) {
				$percentage_for_percentage_excess = 0;
				for ($ni=0; $ni<$nrc; ++$ni) {
					$nrec = $nrs->fetch_array();
					if ($nrec['formula_param'] == "percentage") $percentage_for_percentage_excess = $nrec['formula_amount_percentage'];
					if (($aba_gross_amount >= $nrec['formula_start']) && ($aba_gross_amount <= $nrec['formula_end'])) {
						if ($nrec['formula_param'] == "block") $ba_item_amount = $nrec['formula_amount_percentage'];
						if ($nrec['formula_param'] == "percentage") {
							$ba_item_amount = $aba_gross_amount*($nrec['formula_amount_percentage']/100);
							// debug_log("1:" . $ba_item_amount);
						}
					}
					if (($aba_gross_amount >= $nrec['formula_start']) && ($nrec['formula_end'] == 0)) {
						if ($nrec['formula_param'] == "percentage") $ba_item_amount = $aba_gross_amount*($nrec['formula_amount_percentage']/100);
						if ($nrec['formula_param'] == "percentage_of_percentage") $ba_item_amount = ($aba_gross_amount*($nrec['formula_amount_percentage']/100))*($nrec['formula_percentage_of']/100);
						if ($nrec['formula_param'] == "percentage_increment") $ba_item_amount = $ba_item_amount + $ba_item_amount*($nrec['formula_amount_percentage']/100);
						if ($nrec['formula_param'] == "percentage_excess") {
							$ba_item_amount = ($nrec['formula_start']*($percentage_for_percentage_excess/100)) + (($aba_gross_amount - $nrec['formula_start'])*($nrec['formula_amount_percentage']/100));							
							// debug_log("2:" . $ba_item_amount);
						}
						if ($nrec['formula_param'] == "times_percentage") $ba_item_amount = $ba_item_amount*($nrec['formula_amount_percentage']/100); 
					}
					// 
				}
			}
			// if ($ba_cen == "capitalization") $ba_item_amount = $aba_gross_amount;
		}
		
		/** Penalty **/
		if (($for_renewal) && ($ini_check_penalty == "ini_penalty")) {
		if (strtotime($date_due) > strtotime($jan_due_date)) {
			$ba_item_amount_d = $ba_item_amount; if ($rec['ba_assessment_id'] == 1) debug_log($ba_item_amount_d);
			
			$dq = 0.25; // 1/4
			$second_q = "$recent_application_date-04-20"; // 1/2
			$third_q = "$recent_application_date-07-20"; // 3/4
			$fourth_q = "$recent_application_date-10-20"; // 1
			if (strtotime($date_due) > strtotime($second_q)) $dq = 0.50;
			if (strtotime($date_due) > strtotime($third_q)) $dq = 0.75;
			if (strtotime($date_due) > strtotime($fourth_q)) $dq = 1;
			if ($rec['ba_assessment_id'] == 1) $ba_item_amount_d = $ba_item_amount*$dq;
			if ($rec['ba_assessment_id'] == 1) debug_log("1.".$ba_item_amount_d);
			
			$incr_by_month = date("Y-m-20");
			if (strtotime($date_due) <= strtotime($incr_by_month)) $penalty_interest = $penalty_interest - 2;
			if ($penalty_interest < 0) $penalty_interest = 0;
			
			if ($rec['ba_assessment_id'] != 11) {
				$penalty = $ba_item_amount_d*0.25; if ($rec['ba_assessment_id'] == 1) debug_log("2.".$penalty);
				$surcharge = ($ba_item_amount_d + $penalty)*($penalty_interest/100); if ($rec['ba_assessment_id'] == 1) debug_log("3.".$surcharge);
				$ba_item_penalty = $penalty + $surcharge; if ($rec['ba_assessment_id'] == 1) debug_log("4.".$ba_item_penalty);
			}
		}
		}
		/**/
		
		if (isset($arr_items_added)) {
			if (chk_items($arr_items_added,$rec['ba_assessment_id'])) {
				if ($rec['ba_assessment_id'] == 1) {
					if (isset($_POST['recompute'])) {
						$update_ba_tax = "UPDATE aba_items SET aba_item_amount = $ba_item_amount";
						if ($recompute_tax_penalty == "apply_penalty") $update_ba_tax .= ", aba_item_penalty = $ba_item_penalty ";
						$update_ba_tax .= "WHERE aba_item_assessment = 1 AND aba_item_custom = 0 AND aba_item_fid = $pid";
						$db_con->query($START_T);
						$db_con->query($update_ba_tax);
						$db_con->query($END_T);
					}
				}
				// apply/don't apply penalty
				if ($for_renewal) {
					if (isset($_POST['apply_penalty'])) {
						if ($apply_penalty == "") $ba_item_penalty = 0;
						$update_ba_penalty = "UPDATE aba_items SET aba_item_penalty = $ba_item_penalty WHERE aba_item_assessment = " . $rec['ba_assessment_id'] . " AND aba_item_fid = $pid";
						$db_con->query($START_T);
						$db_con->query($update_ba_penalty);
						$db_con->query($END_T);
					}					
				}
				
				continue;
			}
		}

		$insert .= '(';
		$insert .= $pid . ', ';
		$insert .= $rec['ba_assessment_id'] . ', ';
		$insert .= $ba_item_amount . ', ';
		$insert .= $ba_item_penalty . ', ';
		$insert .= $aid . ', ';
		$insert .= $aid;
		$insert .= '),';
	}
	$insert = substr($insert,0,strlen($insert)-1);
}
db_close();

if ($insert != "") {
$sql = "ALTER TABLE aba_items AUTO_INCREMENT = 1";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

$_insert .= $insert; debug_log($_insert);
db_connect();
$db_con->query($START_T);
$db_con->query($_insert);
$db_con->query($END_T);
db_close();
}

echo $json;
break;

case "taxes_fees_charges":
$pid = $_POST['pid'];

$json = '{ "aba_items": [';
$json .= '{';
$json .= '"aba_item_id":0,';
$json .= '"aba_item_assessment":0,';
$json .= '"aba_item_amount":0,';
$json .= '"aba_item_penalty":0,';
$json .= '"aba_item_assessed_by":0';
$json .= '},';
$sql = "SELECT aba_item_id, aba_item_fid, aba_item_assessment, aba_item_amount, aba_item_penalty, aba_item_assessed_by, aba_item_not_applicable, aba_item_custom, aba_item_aid FROM aba_items WHERE aba_item_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$json .= '{';
		$json .= '"aba_item_id":' . $rec['aba_item_id'] . ',';
		$json .= '"aba_item_assessment":' . $rec['aba_item_assessment'] . ',';
		$json .= '"aba_item_amount":' . $rec['aba_item_amount'] . ',';
		$json .= '"aba_item_penalty":' . $rec['aba_item_penalty'] . ',';
		$json .= '"aba_item_assessed_by":' . $rec['aba_item_assessed_by'] . ',';
		$json .= '"aba_item_custom":' . $rec['aba_item_custom'] . ',';
		$json .= '"aba_item_not_applicable":' . $rec['aba_item_not_applicable'];
		$json .= '},';	
	}
}
db_close();
$json = substr($json,0,strlen($json)-1);

$json .= '] }';

echo $json;
break;

case "taxes_fees_charges_p":
$pid = $_POST['pid'];

$amop = "";
$gst = 0; // annual tax
$_gst = 0; // tax due derived from mode of payment / net tax
$tpenalty = 0; // total penalty
$_gst_penalty = 0; // net tax penalty
$gst_penalty = 0; // total tax penalty
$atotal = 0;
$sql = "SELECT application_mode_of_payment, application_form FROM applications WHERE application_id = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$amop = $rec['application_mode_of_payment'];
	$aform = $rec['application_form'];
}
db_close();

$json = '{ "aba_items": [';
$json .= '{';
$json .= '"aba_item_id":0,';
$json .= '"aba_item_assessment":0,';
$json .= '"aba_item_amount":0,';
$json .= '"aba_item_penalty":0,';
$json .= '"aba_item_total_amount":0,';
$json .= '"aba_item_assessed_by":0,';
$json .= '"gst":0,';
$json .= '"gstt":0,';
$json .= '"tpenalty":0,';
$json .= '"stotal":0,';
$json .= '"atotal":0';
$json .= '},';
$sql = "SELECT aba_item_id, aba_item_fid, aba_item_assessment, (SELECT assessment_type FROM assessments WHERE assessment_id = aba_item_assessment) is_other, aba_item_amount, aba_item_penalty, aba_item_assessed_by, aba_item_not_applicable, aba_item_aid, (SELECT assessment_description FROM assessments WHERE assessment_id = aba_item_assessment) aba_item_desc, (SELECT assessment_reference FROM assessments WHERE assessment_id = aba_item_assessment) aba_item_ref FROM aba_items WHERE aba_item_fid = $pid AND aba_item_not_applicable = 0";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		if ($rec['aba_item_assessment'] == 1) {
			$gst = $rec['aba_item_amount'];
			$gst_penalty = $rec['aba_item_penalty'];
		}
		if ($amop == "pay_annually") {
			$_gst = $gst;
			$_gst_penalty = $gst_penalty;
		}
		if ($amop == "pay_bi_annually") {
			$_gst = $gst/2;
			$_gst_penalty = $gst_penalty/2;			
			if ($aform == "new_app") $_gst = $gst;
		}
		if ($amop == "pay_quarterly") {
			$_gst = $gst/4;
			$_gst_penalty = $gst_penalty/4;			
			if ($aform == "new_app") $_gst = $gst;
		}
		if ($rec['aba_item_assessment'] == 1) $_gst += $gst_penalty;
		if ($rec['aba_item_assessment'] != 1) if ($rec['aba_item_not_applicable'] == 0) $atotal = $atotal + $rec['aba_item_amount'];
		$tpenalty += $rec['aba_item_penalty'];
		$json .= '{';
		$json .= '"aba_item_id":' . $rec['aba_item_id'] . ',';
		$json .= '"aba_item_assessment":' . $rec['aba_item_assessment'] . ',';
		$json .= '"aba_item_amount":"' . number_format($rec['aba_item_amount'],2) . '",';
		$str_penalty = ($rec['aba_item_assessment'] == 1) ? "Php. " . number_format($rec['aba_item_penalty'],2) : number_format($rec['aba_item_penalty'],2);
		if ($rec['aba_item_penalty'] == 0) $str_penalty = "";
		$json .= '"aba_item_penalty":"' . $str_penalty . '",';
		$json .= '"aba_item_total_amount":"' . number_format(($rec['aba_item_amount'] + $rec['aba_item_penalty']),2) . '",';
		$json .= '"aba_item_assessed_by":' . $rec['aba_item_assessed_by'] . ',';
		$json .= '"aba_item_not_applicable":' . $rec['aba_item_not_applicable'] . ',';
		$json .= '"gst":"Php. ' . number_format($_gst,2) . '",'; // net tax
		$json .= '"gstt":"Php. ' . number_format($gst,2) . '",'; // total tax
		$str_tpenalty = "Php. " . number_format($tpenalty,2);
		if ($tpenalty == 0) $str_tpenalty = "";
		$json .= '"tpenalty":"' . $str_tpenalty  . '",';
		$json .= '"is_other":"' . $rec['is_other'] . '",';
		$json .= '"aba_item_desc":"' . $rec['aba_item_desc'] . '",';
		$json .= '"aba_item_ref":"' . $rec['aba_item_ref'] . '",';
		$json .= '"stotal":"Php. ' . number_format(($_gst + $tpenalty + $atotal),2) . '",';
		$json .= '"atotal":"Php. ' . number_format(($gst + $atotal),2) . '"';
		$json .= '},';
	}
}
db_close();
$json = substr($json,0,strlen($json)-1);

$json .= '] }';

echo $json;
break;

case "not_applicable":
$data = $_POST;
$arr_id = $_GET;

$ai_query = new dbase('aba_items');
$ai_query->update($data,$arr_id);
$ai_query->execute();
// $ai_query->debug();

echo $str_response;
break;

case "add_custom_ba":
$data = $_POST;
$ap = $_GET['ap'];

$data["aba_item_aid"] = $aid;
$data["aba_item_penalty"] = ($ap == "apply_penalty") ? computePenalty($data["aba_item_fid"],$data["aba_item_amount"],0) : 0;

$aba_query = new dbase('aba_items');
$aba_query->one();
$aba_query->execute();
$aba_query->add($data);
$aba_query->execute();
// $aba_query->debug();

break;

case "add_custom_tax":
$ap = $_GET['ap'];
$data = $_POST;

$data["aba_item_aid"] = $aid;

$sql = "SELECT * FROM aba_items WHERE aba_item_assessment = 1 AND aba_item_fid = " . $data['aba_item_fid'];
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
db_close();

if ($ap == "apply_penalty") $data["aba_item_penalty"] = computePenalty($data["aba_item_fid"],$data["aba_item_amount"],1);
if ($rc) {
$sql = "UPDATE aba_items SET aba_item_amount = " . $data['aba_item_amount'] . ", aba_item_penalty = " . $data["aba_item_penalty"] . ", aba_item_custom = " . $data['aba_item_custom'] . " WHERE aba_item_assessment = 1 AND aba_item_fid = " . $data['aba_item_fid'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();
} else {
$aba_query = new dbase('aba_items');
$aba_query->one();
$aba_query->execute();
$aba_query->add($data);
$aba_query->execute();
// $aba_query->debug();
}

break;

case "ini_app_verification":
$pid = $_POST['pid'];

// check if application has gone assessment already
$sql = "SELECT * FROM aba_items WHERE aba_item_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$chk_assessment = $rs->num_rows;
db_close();

// check if verification items were already added
$sql = "SELECT * FROM application_verifications WHERE verification_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$chk_verifications = $rs->num_rows;
db_close();

$_insert = "";
$insert = "";
$sql = "SELECT manage_verification_id, manage_verification_order, manage_verification_description, manage_verification_agency, manage_verification_department, manage_verification_date, manage_verification_aid FROM manage_verification ORDER BY manage_verification_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$_insert = "INSERT INTO application_verifications (verification_fid, verification_verification_id) VALUES ";
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$insert .= '(';
		$insert .= $pid . ', ';
		$insert .= $rec['manage_verification_id'];
		$insert .= '),';
	}
	$insert = substr($insert,0,strlen($insert)-1);
}
db_close();

if (($chk_verifications == 0) && ($chk_assessment > 0)) {
$sql = "ALTER TABLE application_verifications AUTO_INCREMENT = 1";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

$_insert .= $insert;
db_connect();
$db_con->query($START_T);
$db_con->query($_insert);
$db_con->query($END_T);
db_close();
}

break;

case "fetch_verifications":
$pid = $_POST['pid'];

$sql = "SELECT verification_id, verification_fid, (SELECT manage_verification_description FROM manage_verification WHERE manage_verification_id = verification_verification_id) verification_description, (SELECT manage_verification_agency FROM manage_verification WHERE manage_verification_id = verification_verification_id) verification_agency, (SELECT concat(account_fname, ' ', account_lname) FROM accounts WHERE account_id = verification_verified_by) verified_by, (SELECT manage_verification_department FROM manage_verification WHERE manage_verification_id = verification_verification_id) verification_department, verification_verification_id, verification_issued, verification_verified_by FROM application_verifications WHERE verification_fid = $pid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$n = 1;
	for ($i=0; $i<$rc; ++$i) {
		$highlight = "";
		$rec = $rs->fetch_array();
		$verification_status = "Not yet verified";
		if (($rec['verification_department'] == $account_department) && ($rec['verification_issued'] == "0000-00-00 00:00:00")) $highlight = 'style="background-color: #FFE6EA;"';		
		if ($rec['verification_issued'] != "0000-00-00 00:00:00") $verification_status = "Verified";
		$verification_issued = ($rec['verification_issued'] == "0000-00-00 00:00:00") ? "" : date("M j, Y",strtotime($rec['verification_issued']));
		$str_response .= '<tr ' . $highlight . '>';
		$str_response .= '<td>' . $n . '</td>';
		$str_response .= '<td>' . $rec['verification_description'] . '</td>';
		$str_response .= '<td>' . $rec['verification_agency'] . '</td>';
		$str_response .= '<td>' . $verification_status . '</td>';		
		$str_response .= '<td>' . $verification_issued  . '</td>';
		$str_response .= '<td>' . $rec['verified_by'] . '</td>';
		if (($account_department == 1) || ($account_department == 8)) {
			$str_response .= '<td style="text-align: center;"><a data-toggle="tooltip" data-placement="top" title="Verify" href="javascript: aVerifyDocument(' . $rec['verification_id'] . ',' . $rec['verification_verification_id'] . ');"><img src="images/Like-icon.png"></a></td>';
		} else {
			if (($rec['verification_department'] == $account_department) && ($rec['verification_issued'] == "0000-00-00 00:00:00")) $str_response .= '<td style="text-align: center;"><a data-toggle="tooltip" data-placement="top" title="Verify" href="javascript: verifyDocument(' . $rec['verification_id'] . ');"><img src="images/folder-check-icon.png"></a></td>';
			else $str_response .= '<td>&nbsp;</td>';
		}
		$str_response .= '</tr>';
		$n++;
	}
}
db_close();

echo $str_response;
break;

case "document_verification":
$verification_id = $_POST['verification_id'];
$verification_issued = $_POST['verification_issued'];
if ($verification_issued != "") $verification_issued = date("Y-m-d",strtotime($verification_issued));

$sql = "UPDATE application_verifications SET verification_issued = '$verification_issued', verification_verified_by = $aid WHERE verification_id = $verification_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "document_verification_auto":
$verification_id = $_POST['verification_id'];
$dv = $_POST['dv'];
$verification_issued = $_POST['verification_issued'];
if ($verification_issued != "") $verification_issued = date("Y-m-d",strtotime($verification_issued));

$verificator = 0;
$sql = "SELECT account_id FROM accounts WHERE account_department = $dv AND verificator = 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$verificator = $rec['account_id'];
}
db_close();

$sql = "UPDATE application_verifications SET verification_issued = '$verification_issued', verification_verified_by = $verificator WHERE verification_id = $verification_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "ini_billing":
$application_id = $_POST['application_id'];
$recompute_billing = (isset($_POST['recompute_billing'])) ? 1 : 0;

$_insert = '';
$insert = '';
$sql = "SELECT application_date, application_form, application_organization_type, application_mode_of_payment, (SELECT if(aba_item_not_applicable = 0,aba_item_amount,0) FROM aba_items WHERE aba_item_fid = application_id AND aba_item_assessment = 1) tax_due, (SELECT sum(if(aba_item_not_applicable = 0,aba_item_amount,0)) FROM aba_items WHERE aba_item_fid = application_id AND aba_item_assessment != 1) others_due, (SELECT sum(if(aba_item_not_applicable = 0,aba_item_penalty,0)) FROM aba_items WHERE aba_item_fid = application_id AND aba_item_assessment = 1) tax_penalty, (SELECT sum(if(aba_item_not_applicable = 0,aba_item_penalty,0)) FROM aba_items WHERE aba_item_fid = application_id AND aba_item_assessment != 1) others_penalty FROM applications WHERE application_id = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$tax_due = 0;
	$others_due = 0;
	$payment_schedule_due_amount = 0;
	$payment_schedule_penalty = 0;
	$first_due = 0;
	$application_mode_of_payment = "";
	$_insert .= "INSERT INTO billing (payment_schedule_fid, payment_schedule_payment_mode, payment_schedule_duedate, payment_schedule_due_amount, payment_schedule_penalty, payment_schedule_date, payment_schedule_aid) VALUES ";
	$rec = $rs->fetch_array();
	$rec['application_form'] = $app_form[$rec['application_form']];
	$rec['application_organization_type'] = $app_organization[$rec['application_organization_type']];
	$rec['application_mode_of_payment_desc'] = $app_mode_of_payment[$rec['application_mode_of_payment']];	
	$tax_due = $rec['tax_due'];
	$others_due = $rec['others_due'];
	$payment_schedule_penalty = $rec['tax_penalty'] + $rec['others_penalty'];
	$payment_schedule_penalty_c = $payment_schedule_penalty;
	$application_mode_of_payment = $rec['application_mode_of_payment'];
	$rec['tax_due'] = number_format($rec['tax_due'],2);
	
	switch ($rec['application_mode_of_payment']) {
	
	case "pay_annually":
	$payment_schedule_due_amount = $tax_due + $others_due;
	// $payment_schedule_duedate = date("Y-m-d");
	$payment_schedule_duedate = $rec['application_date'];
	$insert .= "($application_id, '" . $rec['application_mode_of_payment'] . "', '$payment_schedule_duedate', $payment_schedule_due_amount, $payment_schedule_penalty, CURRENT_TIMESTAMP, $aid)";
	break;
	
	case "pay_bi_annually":
	$payment_schedule_due_amount = $tax_due/2;
	if ($rec['application_form'] == "New") $payment_schedule_due_amount = $tax_due;
	$first_due = $payment_schedule_due_amount + $others_due;
	// $payment_schedule_duedate = date("Y-m-d");
	$payment_schedule_duedate = $rec['application_date'];	
	for ($i=1; $i<=2; $i++) {	
		if ($i == 1) {
			$insert .= "($application_id, '" . $rec['application_mode_of_payment'] . "', '$payment_schedule_duedate', $first_due, $payment_schedule_penalty, CURRENT_TIMESTAMP, $aid),";
		}
		else {
			if ($i == 2) $payment_schedule_duedate = date("Y-07-20");
			if ($rec['application_form'] == "New") $payment_schedule_due_amount = 0;
			$payment_schedule_penalty = 0;
			$insert .= "($application_id, '" . $rec['application_mode_of_payment'] . "', '$payment_schedule_duedate', $payment_schedule_due_amount, $payment_schedule_penalty, CURRENT_TIMESTAMP, $aid),";
		}
		// $payment_schedule_duedate = date("Y-01-20",strtotime("+6 months",strtotime($payment_schedule_duedate)));
	}
	$insert = substr($insert,0,strlen($insert)-1);
	break;
	
	case "pay_quarterly":
	$payment_schedule_due_amount = $tax_due/4;
	if ($rec['application_form'] == "New") $payment_schedule_due_amount = $tax_due;	
	$first_due = $payment_schedule_due_amount + $others_due;
	// $payment_schedule_duedate = date("Y-m-d");
	$payment_schedule_duedate = $rec['application_date'];	
	for ($i=1; $i<=4; $i++) {	
		if ($i == 1) {
			$insert .= "($application_id, '" . $rec['application_mode_of_payment'] . "', '$payment_schedule_duedate', $first_due, $payment_schedule_penalty, CURRENT_TIMESTAMP, $aid),";
		} else {
			if ($i == 2) $payment_schedule_duedate = date("Y-04-20");
			if ($i == 3) $payment_schedule_duedate = date("Y-07-20");
			if ($i == 4) $payment_schedule_duedate = date("Y-10-20");		
			if ($rec['application_form'] == "New") $payment_schedule_due_amount = 0;		
			$payment_schedule_penalty = 0;		
			$insert .= "($application_id, '" . $rec['application_mode_of_payment'] . "', '$payment_schedule_duedate', $payment_schedule_due_amount, $payment_schedule_penalty, CURRENT_TIMESTAMP, $aid),";
		}
		// $payment_schedule_duedate = date("Y-m-d",strtotime("+3 months",strtotime($payment_schedule_duedate)));		
	}
	$insert = substr($insert,0,strlen($insert)-1);
	break;
	
	}
	$rec['total_amount_due'] = $tax_due + $others_due + $payment_schedule_penalty_c;
	$rec['total_amount_due'] = number_format($rec['total_amount_due'],2);
	$str_response = json_encode($rec);
}
db_close();

$b_insert = true;
$sql = "SELECT * FROM billing WHERE payment_schedule_fid = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$b_insert = false;
}
db_close();

if ($recompute_billing) $b_insert = true;

if ($b_insert) {
if ($insert != "") {
		$sql = "DELETE FROM billing WHERE payment_schedule_fid = $application_id";
		db_connect();
		$db_con->query($START_T);
		$db_con->query($sql);
		$db_con->query($END_T);
		db_close();

		$sql = "ALTER TABLE billing AUTO_INCREMENT = 1";
		db_connect();
		$db_con->query($START_T);
		$db_con->query($sql);
		$db_con->query($END_T);
		db_close();

		$_insert .= $insert;
		db_connect();
		$db_con->query($START_T);
		$db_con->query($_insert);
		$db_con->query($END_T);
		db_close();
}
}

echo $str_response;
break;

case "fetch_billing":
$application_id = $_POST['application_id'];

$sql = "SELECT payment_schedule_id, payment_schedule_fid, payment_schedule_payment_mode, payment_schedule_duedate, payment_schedule_due_amount, payment_schedule_penalty, payment_schedule_date, payment_schedule_or, payment_schedule_date_paid, payment_schedule_aid FROM billing WHERE payment_schedule_fid = '$application_id'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$n = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$payment_schedule_date_paid = "";
		$str_response .= '<tr>';
		$str_response .= '<td>' . $n . '</td>';
		$str_response .= '<td>' . date("M j, Y",strtotime($rec['payment_schedule_duedate'])) . '</td>';
		$str_response .= '<td>' . number_format($rec['payment_schedule_due_amount'],2)  . '</td>';
		$str_response .= '<td>' . number_format($rec['payment_schedule_penalty'],2)  . '</td>';
		$str_response .= '<td>' . $rec['payment_schedule_or'] . '</td>';
		if ($rec['payment_schedule_date_paid'] != "0000-00-00") $payment_schedule_date_paid = date("M j, Y",strtotime($rec['payment_schedule_date_paid']));
		$str_response .= '<td>' . $payment_schedule_date_paid . '</td>';
		$str_response .= '<td></td>';
		if ($rec['payment_schedule_or'] == "") $str_response .= '<td><a href="javascript: payAmount(' . $rec['payment_schedule_id'] . ',\'' . date("M j, Y",strtotime($rec['payment_schedule_duedate'])) . '\',1)" data-toggle="tooltip" data-placement="top" title="Pay this amount due"><img src="images/money.png"></a></td>';
		else $str_response .= '<td><a href="javascript: payAmount(' . $rec['payment_schedule_id'] . ',\'' . date("M j, Y",strtotime($rec['payment_schedule_duedate'])) . '\',2)" data-toggle="tooltip" data-placement="top" title="Pay this amount due"><img src="images/edit.png"></a></td>';
		$str_response .= '</tr>';
	$n++;
	}
}
db_close();

echo $str_response;
break;

case "update_payment":
$data = $_POST;
$arr_id = $_GET;

if ( ($data['payment_schedule_date_paid'] != "") || ($data['payment_schedule_date_paid'] != "0000-00-00") ) $data['payment_schedule_date_paid'] = date("Y-m-d",strtotime($data['payment_schedule_date_paid']));

$sql = "UPDATE billing SET payment_schedule_or = '" . $data['payment_schedule_or'] . "', payment_schedule_date_paid = '" . $data['payment_schedule_date_paid'] . "', payment_schedule_aid = $aid WHERE payment_schedule_id = " . $arr_id['payment_schedule_id'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

$permit_fid = 0;
$permit_application_no = "";
$permit_reference_no = "";
$permit_fee = 0;
$permit_tax = 0;
$permit_mode_of_payment = "";

$permit_or_no = $data['payment_schedule_or'];
$permit_or_date = $data['payment_schedule_date_paid'];
$sql = "SELECT payment_schedule_fid, (SELECT application_no FROM applications WHERE application_id = payment_schedule_fid) permit_application_no, (SELECT application_reference_no FROM applications WHERE application_id = payment_schedule_fid) permit_reference_no, payment_schedule_payment_mode, (SELECT aba_item_amount FROM aba_items WHERE aba_item_fid = payment_schedule_fid AND aba_item_assessment = 8) permit_fee, (SELECT aba_item_amount FROM aba_items WHERE aba_item_fid = payment_schedule_fid AND aba_item_assessment = 1) permit_tax FROM billing WHERE payment_schedule_id = " . $arr_id['payment_schedule_id'];
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$permit_fid = $rec['payment_schedule_fid'];
	$permit_application_no = $rec['permit_application_no'];
	$permit_reference_no = $rec['permit_reference_no'];
	$permit_mode_of_payment = $rec['payment_schedule_payment_mode'];
	$permit_fee = $rec['permit_fee'];
	$permit_tax = $rec['permit_tax'];
}
db_close();

$sql = "SELECT * FROM permits WHERE permit_fid = $permit_fid";
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
$db_con->query($END_T);
db_close();

// update application date issued
$sql = "UPDATE applications SET application_date_issued = CURRENT_TIMESTAMP WHERE application_id = $permit_fid";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();
}

echo $str_response;
break;

case "gen_app_no":
$application_id = $_POST['application_id'];
$pstat = $_POST['pstat'];

$str_response = genAppNo($application_id,$pstat);

echo $str_response;
break;

case "reset_app_no":
$application_id = $_POST['application_id'];

$sql = "UPDATE applications SET application_no = '' WHERE application_id = $application_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "gen_ref_no":
$application_id = $_POST['application_id'];
$pstat = $_POST['pstat'];

$str_response = genRefNo($application_id,$pstat);

echo $str_response;
break;

case "reset_ref_no":
$application_id = $_POST['application_id'];

$sql = "UPDATE applications SET application_reference_no = '' WHERE application_id = $application_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "ref_appno_renewal":
$prefno = $_POST['prefno'];
$app_id = $_POST['app_id'];

$s = date("y");
$pref = "B$s-";

$app_no = $pref."0001";

$ref_appno_renewal = explode("-",$app_no);

$sql = "SELECT application_no FROM applications WHERE application_no LIKE '$pref%' ORDER BY application_no DESC LIMIT 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_no'] != "") {
	$ref_appno_renewal = explode("-",$rec['application_no']);
	$int_an = (int)$ref_appno_renewal[1] + 1;
	$app_no = $pref . str_pad((string)$int_an, 4, '0', STR_PAD_LEFT);
	}
}
db_close();

$json  = '{ "refappno": [{';
$json .= '"application_no":"' . $app_no . '",';
$json .= '"application_reference_no":"' . $prefno . '"';
$json .= '}] }';

$sql = "UPDATE applications SET application_reference_no = '$prefno' WHERE application_id = $app_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

$sql = "UPDATE applications SET application_no = '".$app_no."' WHERE application_id = $app_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $json;
break;

case "async_search_ap":
$field = $_POST['field'];
$val = $_POST['val'];

if ($field == "applicant_fullname") $field = "concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)";
if ($val == "") return $str_response;

// $sql = "SELECT application_id, application_reference_no, application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename, application_taxpayer_business_name, concat(application_business_address_no, ' ', application_business_address_bldg, ' ', application_business_address_unit_no, ' ', application_business_address_street, ' ', application_business_address_brgy, ' ', application_business_address_subd, ' ', application_business_address_mun_city, ' ', application_business_address_province) applicant_address FROM applications WHERE application_id IN (SELECT MAX(application_id) FROM applications GROUP BY application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename) AND $field like '$val%'";
$sql = "SELECT application_id, application_date, application_no, application_reference_no, application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename, application_taxpayer_business_name, concat(application_business_address_no, ' ', application_business_address_bldg, ' ', application_business_address_unit_no, ' ', application_business_address_street, ' ', application_business_address_brgy, ' ', application_business_address_subd, ' ', application_business_address_mun_city, ' ', application_business_address_province) applicant_address FROM applications WHERE $field like '$val%' ORDER BY application_id DESC";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$str_response .= '<tr onclick="clickFillPA(\'' . $rec['application_id'] . '\',\'' . $rec['application_reference_no'] . '\');">';
		$str_response .= '<td>' . $rec['application_id'] . '</td>';
		$str_response .= '<td>' . date("M j, Y",strtotime($rec['application_date'])) . '</td>';
		$str_response .= '<td>' . $rec['application_no'] . '</td>';
		$str_response .= '<td>' . $rec['application_reference_no'] . '</td>';
		$str_response .= '<td><strong>' . $rec['application_taxpayer_lastname'] . '</strong></td>';
		$str_response .= '<td><strong>' . $rec['application_taxpayer_firstname'] . '</strong></td>';
		$str_response .= '<td><strong>' . $rec['application_taxpayer_middlename'] . '</strong></td>';
		$str_response .= '<td>' . $rec['application_taxpayer_business_name'] . '</td>';		
		$str_response .= '<td>' . $rec['applicant_address'] . '</td>';		
		$str_response .= '</tr>';
	}
}
db_close();

echo $str_response;
break;

case "fetch_tax_amount":
$aba_item_fid = $_POST['aba_item_fid'];

$json = '{ "fetch_tax": [{';
$sql = "SELECT aba_item_amount, aba_item_custom FROM aba_items WHERE aba_item_fid = $aba_item_fid AND aba_item_assessment = 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$json .= '"aba_item_amount": ' . $rec['aba_item_amount'] . ',';
	$json .= '"aba_item_custom": ' . $rec['aba_item_custom'];
}
db_close();
$json .= '}] }';

echo $json;

break;

case "get_ba_amount":
$aba_item_fid = $_POST['aba_item_fid'];
$aba_item_assessment = $_POST['aba_item_assessment'];


$sql = "SELECT aba_item_amount FROM aba_items WHERE aba_item_fid = $aba_item_fid AND aba_item_assessment = $aba_item_assessment";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$str_response = $rec['aba_item_amount'];
}
db_close();

echo $str_response;

break;

case "update_ba_amount":
$ap = $_GET['ap'];
$aba_item_fid = $_POST['aba_item_fid'];
$aba_item_assessment = $_POST['aba_item_assessment'];
$aba_item_amount = $_POST['aba_item_amount'];
$aba_item_penalty = ($ap == "apply_penalty") ? computePenalty($aba_item_fid,$aba_item_amount,0) : 0;

$sql = "UPDATE aba_items SET aba_item_amount = $aba_item_amount, aba_item_penalty = $aba_item_penalty WHERE aba_item_fid = $aba_item_fid AND aba_item_assessment = $aba_item_assessment";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "check_ba":
$application_id = $_POST['application_id'];

$sql = "SELECT aba_gross_base, aba_gross_amount FROM application_business_activities WHERE aba_fid = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$str_response = $rc;
	$rec = $rs->fetch_array();
	if ($rec['aba_gross_amount'] == 0) $str_response = "";
	if ($rec['aba_gross_base'] == "capitalization") $str_response = $rc;
}
db_close();

echo $str_response;
break;

case "check_assessment":
$application_id = $_POST['application_id'];

$sql = "SELECT * FROM aba_items WHERE aba_item_fid = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$str_response = $rc;
}
db_close();

echo $str_response;
break;

case "quarter_check":

$str_response = false;
$date_t = date("Y-m-d");
$_2ndQtr = date("Y-03-31");
if (strtotime($date_t) > strtotime($_2ndQtr)) $str_response = true;

echo $str_response;

break;

case "bi_annual_check":

$str_response = false;
$date_t = date("Y-m-d");
$_3rdQtr = date("Y-06-30");
if (strtotime($date_t) > strtotime($_3rdQtr)) $str_response = true;

echo $str_response;

break;

case "get_business_status":
$application_id = $_GET['application_id'];

$sql = "SELECT business_status FROM applications WHERE application_id = $application_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array(MYSQLI_ASSOC);
	$str_response = $rec['business_status'];
}
db_close();

echo $str_response;
break;

}

function genRefNo($id,$stat) {

$pref = "B-";

$ref_no = $pref . "0001";

global $db_con, $START_T, $END_T;

// get last ref no
$sql = "SELECT application_reference_no FROM applications WHERE application_reference_no LIKE '$pref%' ORDER BY application_reference_no DESC LIMIT 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_reference_no'] != "") {
	$str_an = explode("-",$rec['application_reference_no']);
	$int_an = (int)$str_an[1] + 1;
	$ref_no = $pref . str_pad((string)$int_an, 4, '0', STR_PAD_LEFT);
	}
}
db_close();

// if ref no exists use it disregard generate
$chkr = "";
$sql = "SELECT application_reference_no FROM applications WHERE application_id = $id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_reference_no'] != "") {
		$ref_no = $rec['application_reference_no'];
		$chkr = $rec['application_reference_no'];
	}
}
db_close();
if ($chkr != "") {
	echo $ref_no; exit();
}

$sql = "UPDATE applications SET application_reference_no = '$ref_no' WHERE application_id = $id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

return $ref_no;

}

function genAppNo($id,$stat) {

$s = date("y");
$pref = "B$s-";

// $app_no = $pref . "1089"; // application number
$app_no = $pref . "0001"; // application number

global $db_con, $START_T, $END_T;

/* $sql = "SELECT application_reference_no FROM applications WHERE application_reference_no LIKE 'B-%' ORDER BY application_reference_no DESC LIMIT 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_reference_no'] != "") {
	$str_an = explode("-",$rec['application_reference_no']);
	$int_an = (int)$str_an[1] + 1;
	$app_no = $pref . str_pad((string)$int_an, 4, '0', STR_PAD_LEFT);
	}
}
db_close(); */

$sql = "SELECT application_no FROM applications WHERE application_no LIKE '$pref%' ORDER BY application_no DESC LIMIT 1";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_no'] != "") {
	$str_an = explode("-",$rec['application_no']);
	$int_an = (int)$str_an[1] + 1;
	$app_no = $pref . str_pad((string)$int_an, 4, '0', STR_PAD_LEFT);
	}
}
db_close();

$chka = "";
$sql = "SELECT application_no FROM applications WHERE application_id = $id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_no'] != "") {
		$app_no = $rec['application_no'];
		$chka = $rec['application_no'];
	}
}
db_close();
if ($chka != "") {
	echo $app_no; exit();
}

$sql = "UPDATE applications SET application_no = '$app_no' WHERE application_id = $id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

return $app_no;

}

?>
