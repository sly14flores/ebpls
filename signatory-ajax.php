<?php

session_start();
$aid = 	$_SESSION['account_id'];

require 'config.php';
require 'globalf.php';

$req = "";
$START_T = "START TRANSACTION;";
$END_T = "COMMIT;";

$arr_signatory_for = array("business_permit"=>"Business Permit Signatory","assessment_reviewer"=>"Assessment Reviewer","approval_recommendation"=>"Approval Recommendation");

if (isset($_GET["p"])) $req = $_GET["p"];

$str_response = "";
$json = "";
$jpage = "";

switch ($req) {

case "contents":
$per_page = 5;

$str_response = '<form name="frmSContent" id="frmSContent">';
$str_response .= '<table class="table table-striped">';

$arr_head = array("For","Name","Department","Date Added/Modified");
$content = new content($arr_head);
$str_response .= $content->header();

$sql = "SELECT signatory_id, (SELECT concat(account_lname, ', ', account_fname, ' ', account_mname) FROM accounts WHERE account_id = signatory_account) signatory_name, (SELECT department_name FROM departments WHERE department_id = (SELECT account_department FROM accounts WHERE account_id = signatory_account)) department, signatory_for, signatory_date, signatory_aid FROM signatories";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
$c = 1;
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();	
		
		$arr_body[$i] = array(
		$rec['signatory_id'],
		$arr_signatory_for[$rec['signatory_for']],
		$rec['signatory_name'],
		$rec['department'],
		date("M j, Y",strtotime($rec['signatory_date']))		
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

$signatory_account_id = returnTypeaheadID("account_id","accounts","concat(account_lname, ', ', account_fname, ' ', account_mname)",$_POST['signatory_account']);
$data["signatory_account"] = $signatory_account_id;
$data["signatory_date"] = "CURRENT_TIMESTAMP";
$data["signatory_aid"] = $aid;

$s_query = new dbase('signatories');
$s_query->one();
$s_query->execute();
$s_query->add($data);
$s_query->execute();
// $s_query->debug();

$str_response = "Signatory Successfully Added.";

echo $str_response;
break;

case "update":
$data = $_POST;
$arr_id = $_GET;

$signatory_account_id = returnTypeaheadID("account_id","accounts","concat(account_lname, ', ', account_fname, ' ', account_mname)",$_POST['signatory_account']);
$data["signatory_account"] = $signatory_account_id;

$s_query = new dbase('signatories');
$s_query->update($data,$arr_id);
$s_query->execute();
// $s_query->debug();

$str_response = "Signatory Info Successfully Updated.";

echo $str_response;
break;

case "delete":
$data = $_POST;

$s_query = new dbase('signatories');
$s_query->delete($data);
$s_query->execute();
// $s_query->debug();

$str_response = "Signatory(s) Successfully Deleted.";

echo $str_response;

break;

}

?>