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
$data = array("ba_organization"=>"All","ba_cen"=>"capitalization","ba_date"=>"CURRENT_TIMESTAMP","ba_aid"=>$aid);

$ba_query = new dbase('business_activities');
$ba_query->one();
$ba_query->execute();

$ba_query->add($data);
$last_ba_id = $ba_query->sql_get_id();
// $ba_query->debug();

echo $last_ba_id;
break;

case "async_add":
$key = "ba_id";
$id = $_POST['pid'];
$field = $_POST['field'];
$value = $_POST['value'];

$ba_query = new dbase('business_activities');
$ba_query->async_add($field,$value,$key,$id);
$ba_query->execute();
// $ba_query->debug();

echo $str_response;

break;

case "async_add_bi_amt":
$data = $_POST;

$sql = "SELECT * FROM business_activity_items WHERE ba_item_baid = " . $data['ba_item_baid'] . " AND ba_assessment_id = " . $data['ba_assessment_id'];
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
db_close();

$data['ba_item_date'] = "CURRENT_TIMESTAMP";
$data['ba_item_aid'] = $aid;

if ($rc == 0) {

$bai_query = new dbase('business_activity_items');
$bai_query->one();
$bai_query->execute();
$bai_query->add($data);
$bai_query->execute();
// $bai_query->debug();

} else {

$sql = "UPDATE business_activity_items SET ba_item_amount = " . $data['ba_item_amount'] . ", ba_item_date = " . $data['ba_item_date'] . ", ba_item_aid = " . $data['ba_item_aid'] . " WHERE ba_item_baid = " . $data['ba_item_baid'] . " AND ba_assessment_id = " . $data['ba_assessment_id'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

}

echo $str_response;

break;

case "async_cancel_bi_amt":
$data = $_POST;

$sql = "DELETE FROM business_activity_items WHERE ba_item_baid = " . $data['ba_item_baid'] . " AND ba_assessment_id = " . $data['ba_assessment_id'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "async_add_bi_tax":
$data = $_POST;

$last_bai_id = 0;

$sql = "SELECT ba_item_id FROM business_activity_items WHERE ba_item_baid = " . $data['ba_item_baid'] . " AND ba_assessment_id = " . $data['ba_assessment_id'];
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$last_bai_id = $rec['ba_item_id'];
}
db_close();

if ($rc) {
	echo $last_bai_id;
	return;
}

$data['ba_item_date'] = "CURRENT_TIMESTAMP";
$data['ba_item_aid'] = $aid;
$bai_query = new dbase('business_activity_items');
$bai_query->one();
$bai_query->execute();
$bai_query->add($data);
$last_bai_id = $bai_query->sql_get_id();
// $bai_query->execute();
// $bai_query->debug();

echo $last_bai_id;

break;

case "async_cancel_bi_tax":
$data = $_POST;

$sql = "DELETE FROM business_activity_items WHERE ba_item_baid = " . $data['ba_item_baid'] . " AND ba_assessment_id = " . $data['ba_assessment_id'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "async_add_formula":
$data = $_POST;

$data['formula_date'] = "CURRENT_TIMESTAMP";
$data['formula_aid'] = $aid;

$tf_query = new dbase('tax_formulas');
$tf_query->one();
$tf_query->execute();
$tf_query->add($data);
$last_tf_id = $tf_query->sql_get_id();

echo $last_tf_id;
break;

case "async_update_formula":
$formula_id = $_POST['formula_id'];
$field = $_POST['field'];
$value = $_POST['value'];

$sql = "UPDATE tax_formulas SET $field = '$value' WHERE formula_id = $formula_id";
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

echo $str_response;
break;

case "async_del_formula":
$data = $_POST;

$tf_query = new dbase('tax_formulas');
$tf_query->delete($data);
$tf_query->execute();
// $tf_query->debug();

echo $str_response;
break;

case "edit":
$bid = $_POST['bid'];

$sql = "SELECT ba_organization, ba_cen, ba_code, ba_line, ba_note FROM business_activities WHERE ba_id = $bid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$str_response = $rec;
}
db_close();

$str_response = json_encode($str_response);

echo $str_response;
break;

case "cancel_ba":
$data = $_POST;

$ba_query = new dbase('business_activities');
$ba_query->delete($data);
$ba_query->execute();
// $ba_query->debug();

$many = array("ba_item_baid"=>$data['ba_id']);
$bai_query = new dbase('business_activity_items');
$bai_query->delete($many);
$bai_query->execute();
// $bai_query->debug();

echo $str_response;
break;

case "delete":
$data = $_POST;

$ba_query = new dbase('business_activities');
$ba_query->delete($data);
$ba_query->execute();
// $ba_query->debug();

$many = array("ba_item_baid"=>$data['ba_id']);
$bai_query = new dbase('business_activity_items');
$bai_query->delete($many);
$bai_query->execute();
// $bai_query->debug();

$str_response = "Business Activity Successfully Added.";

echo $str_response;

break;

case "fetch_ba_items":
$bbaid = $_POST['bbaid'];

$json = '{ "ba_items": [';
$sql = "SELECT ba_item_id, ba_item_baid, ba_assessment_id, ba_item_is_tax, (SELECT tax_description FROM taxes WHERE tax_id = ba_item_tax_formula) formula, ba_item_amount, ba_item_penalty, ba_item_date, ba_item_aid FROM business_activity_items WHERE ba_item_baid = $bbaid";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$json .= '{';
		$rec = $rs->fetch_array();
		$json .= '"ba_assessment_id":' . $rec['ba_assessment_id'] . ',';	
		$json .= '"ba_item_id":' . $rec['ba_item_id'] . ',';		
		$json .= '"ba_item_is_tax":' . $rec['ba_item_is_tax'] . ',';		
		$json .= '"ba_item_amount":' . $rec['ba_item_amount'] . ',';
		$json .= '"formula":"' . $rec['formula'] . '"';
		$json .= '},';		
	}
}
db_close();

$json = substr($json,0,strlen($json)-1);
$json .= ']}';

echo $json;
break;

case "contents":
$per_page = 20;
$total_num_rows = 0;
$total_pages = 0;

$d = (isset($_GET['d'])) ? $_GET['d'] : 0;
$current_page = (isset($_GET['cp'])) ? $_GET['cp'] : 1;

$fbdesc = (isset($_GET['fbdesc'])) ? $_GET['fbdesc'] : "";

$filter = " WHERE ba_id != 0";
$c1 = " and ba_line like '%$fbdesc%'";

if ($fbdesc == "") $c1 = "";

$filter .= $c1;

$sql = "SELECT count(*) FROM business_activities $filter";
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

$str_response = '<form name="ltfcContent" id="ltfcContent">';
$str_response .= '<table class="table table-striped">';

$arr_head = array("No.","Applies to","Organization","Code","Line of Business","Tax Formula","Note","Date Added/Modified");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT ba_id, ba_organization, ba_cen, ba_code, ba_line, ba_note, ifnull((SELECT tax_description FROM taxes WHERE tax_id = (SELECT ba_item_tax_formula FROM business_activity_items WHERE ba_item_baid = ba_id AND ba_assessment_id = 1)),'') tax_formula, ba_date, ba_aid FROM business_activities $filter $row_page";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['ba_id'],
		$c,
		$ba_cen[$rec['ba_cen']],
		$rec['ba_organization'],
		$rec['ba_code'],
		$rec['ba_line'],
		$rec['tax_formula'],
		$rec['ba_note'],
		date("M j, Y",strtotime($rec['ba_date']))
		);		
		
		$c++;
	}
$str_response .= $content->body($arr_body,$c,$per_page);
}
db_close();

if ($total_num_rows > $per_page) {

	$pagination = new pageNav('rBusinessActivityF()',$current_page,$total_pages,'tab_content_b');

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

case "fill_local_taxes_fees_charges":

$str_response = '<table class="table table-striped">';
$str_response .= '<thead>';
$str_response .= '<tr>';
$str_response .= '<th><input type="checkbox" name="ltfc_checkall" id="ltfc_checkall" onclick="chkAll(\'ba-local-taxes-fees-charges\',this);"></th>';
$str_response .= '<th>No.</th>';
$str_response .= '<th style="width: 25%;">Description</th>';
$str_response .= '<th>Amount</th>';
$str_response .= '<th>Tax</th>';
$str_response .= '<th>Penalty</th>';
$str_response .= '<th>Tools</th>';
$str_response .= '</tr>';
$str_response .= '</thead>';
$str_response .= '<tbody>';

$sql = "SELECT assessment_id, assessment_order, assessment_type, assessment_description, assessment_reference, assessment_note, assessment_date, assessment_aid FROM assessments ORDER BY assessment_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$str_response .= '<tr>';
		$rec = $rs->fetch_array();
		$str_response .= '<td class="chk_all chk_item"><input type="checkbox" name="chk_' . $rec['assessment_id'] . '" id="chk_' . $rec['assessment_id'] . '" onClick="uncheckParent(\'ltfc_checkall\',this); togSelected(' . $rec['assessment_id'] . ',this);"></td>';
		$str_response .= '<td>' . $c . '</td>';
		$str_response .= '<td>' . $rec['assessment_description'] . '<input id="hbaid_' . $rec['assessment_id'] . '" type="hidden" value="0"></td>';
		if ($rec['assessment_id'] != 1) $str_response .= '<td><input id="amt_' . $rec['assessment_id'] . '" type="text" style="width: 50%;" value="0" disabled></td>';
		else $str_response .= '<td>&nbsp;</td>';
		if ($rec['assessment_id'] == 1) $str_response .= '<td><input id="rate_' . $rec['assessment_id'] . '" type="text" style="width: 50%;" value="" disabled></td>';
		else $str_response .= '<td>&nbsp;</td>';
		$str_response .= '<td>&nbsp;</td>';
		$str_response .= '<td>&nbsp;</td>';
		$str_response .= '</tr>';
		$c++;
	}
}
db_close();

$str_response .= '</tbody>';
$str_response .= '</table>';

echo $str_response;
break;

case "fetch_formulas":
$formula_tax_id = $_POST['formula_tax_id'];

$json = '{ "tax_formulas": [';
$json .= '{';
$json .= '"formula_id":0,';
$json .= '"formula_param":"",';
$json .= '"formula_start":0,';
$json .= '"formula_end":0,';
$json .= '"formula_amount_percentage":0,';
$json .= '"formula_percentage_of":0';
$json .= '},';
$sql = "SELECT formula_id, formula_ba_item_id, formula_param, formula_start, formula_end, formula_amount_percentage, formula_percentage_of, formula_date, formula_aid FROM tax_formulas WHERE formula_tax_id = $formula_tax_id ORDER BY formula_id";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
		for ($i=0; $i<$rc; ++$i) {
			$rec = $rs->fetch_array();		
			$json .= '{';
			$json .= '"formula_id":' . $rec['formula_id'] . ',';
			$json .= '"formula_param":"' . $rec['formula_param'] . '",';
			$json .= '"formula_start":' . $rec['formula_start'] . ',';
			$json .= '"formula_end":' . $rec['formula_end'] . ',';
			$json .= '"formula_amount_percentage":' . $rec['formula_amount_percentage'] . ',';
			$json .= '"formula_percentage_of":' . $rec['formula_percentage_of'];
			$json .= '},';
		}
}
db_close();
$json = substr($json,0,strlen($json)-1);

$json .= '] }';

echo $json;
break;

case "async_search_tax":
$field = $_POST['field'];
$val = $_POST['val'];
$ba_item_id = $_POST['ba_item_id'];

$sql = "SELECT tax_id, tax_description, tax_note FROM taxes WHERE $field like '%$val%'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$str_response .= '<tr onclick="clickUpdateTax(\'' . $rec['tax_description'] . '\',' . $ba_item_id . ',' . $rec['tax_id'] . ');">';
		$str_response .= '<td>' . $rec['tax_description'] . '</td>';
		$str_response .= '<td>' . $rec['tax_note'] . '</td>';
		$str_response .= '</tr>';
	}
}
db_close();

echo $str_response;
break;

case "async_update_tax":
$data = $_POST;
$arr_id = $_GET;

$bai_query = new dbase('business_activity_items');
$bai_query->update($data,$arr_id);
$bai_query->execute();
$bai_query->debug();

echo $str_response;
break;

}

?>