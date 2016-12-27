<?php

session_start();
$aid = 	$_SESSION['account_id'];
$ad = $_SESSION['account_department'];

require 'config.php';
require 'globalf.php';

$req = "";
$START_T = "START TRANSACTION;";
$END_T = "COMMIT;";

if (isset($_GET["p"])) $req = $_GET["p"];

$str_response = "";
$json = "";
$jpage = "";

$arr_office = array(1=>"treasurer_office",2=>"mpdc",3=>"mho",4=>"engineering",5=>"bof");

switch ($req) {

case "add":
$data['sn_fid'] = $_POST['application_id'];
$data['sn_an'] = $_POST['application_no'];
$data['personal_info'] = "CURRENT_TIMESTAMP";

$sql = "SELECT * FROM status_notifications WHERE sn_an = '" . $_POST['application_no'] . "'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
db_close();

if (($rc) || ($_POST['application_no'] == "")) {
	echo $str_response;
	exit();
}
$n_query = new dbase('status_notifications');
$n_query->one();
$n_query->execute();
$n_query->add($data);
$n_query->execute();
// debug_log($n_query->debug_r());

echo $str_response;

break;

case "notify_assessors":
$arr_id = $_GET;
$data['assessment'] = "CURRENT_TIMESTAMP";

$n_query = new dbase('status_notifications');
$n_query->update($data,$arr_id);
$n_query->execute();
// debug_log($n_query->debug_r());

$str_response = "Notifications Sent.";

echo $str_response;

break;

case "verification_notification":
$dv = $_POST['dv'];
$arr_id = $_GET;

if ($dv == 0) {
	$data[$arr_office[$ad]] = "CURRENT_TIMESTAMP";
} else {
	$data[$arr_office[$dv]] = "CURRENT_TIMESTAMP";
}

$n_query = new dbase('status_notifications');
$n_query->update($data,$arr_id);
$n_query->execute();
// debug_log($n_query->debug_r());

echo $str_response;
break;

case "count_notifications":

if ( ($ad == 2) || ($ad == 3) || ($ad == 4) || ($ad == 5) ) {

$sql = "SELECT sn_fid, sn_an, (SELECT application_date FROM applications WHERE application_id = sn_fid) sn_date FROM status_notifications WHERE assessment != '0000-00-00 00:00:00' AND " . $arr_office[$ad] . " = '0000-00-00 00:00:00' ORDER BY sn_id DESC";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$str_response = $rc;
}
db_close();

}

echo $str_response;
break;

case "fetch_notifications_applications":

if ( ($ad == 2) || ($ad == 3) || ($ad == 4) || ($ad == 5) ) {

$sql = "SELECT sn_fid, sn_an, (SELECT application_date FROM applications WHERE application_id = sn_fid) sn_date FROM status_notifications WHERE assessment != '0000-00-00 00:00:00' AND " . $arr_office[$ad] . " = '0000-00-00 00:00:00' ORDER BY sn_id DESC";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$str_response .= '<li>';
		$str_response .= '<a href="javascript: openApplication(\'' . $rec['sn_fid'] . '\');">';
		$str_response .= '<div style="padding-bottom: 10px;">';
		$str_response .= '<i class="fa fa-file fa-fw"></i> App.No. <strong>' . $rec['sn_an'] . '</strong> for verification';
		$str_response .= '<span class="pull-right text-muted small">' . date("F j, Y h:i A",strtotime($rec['sn_date'])) . '</span>';
		$str_response .= '</div>';
		$str_response .= '</a>';
		$str_response .= '</li>';
		$str_response .= '<li class="divider"></li>';
	}
}
db_close();

}

echo $str_response;
break;

}

?>