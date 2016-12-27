<?php

$ba_cen = array(""=>"","capitalization"=>"Capitalization","essential"=>"Essential","non-essential"=>"Non-essential");

class dbase {

var $table;
var $START_T;
var $END_T;
var $sql;
var $fields;
var $values;
var $fields_values;
var $last_auto_id;

	function __construct($table) {

	$this->table = $table;
	$this->START_T = "START TRANSACTION;";
	$this->END_T = "COMMIT;";

	}

	function one() {

	$this->sql = "ALTER TABLE " . $this->table . " AUTO_INCREMENT = 1";

	}

	function add($data) {

		foreach ($data as $field => $value) {
			$this->fields .= $field . ",";
			if (is_numeric($value) || ($value == "CURRENT_TIMESTAMP")) $this->values .= addslashes($value) . ",";
			else $this->values .= "'" . addslashes($value) . "'" . ",";
		}

	$this->fields = substr($this->fields,0,strlen($this->fields)-1);
	$this->values = substr($this->values,0,strlen($this->values)-1);
	$this->sql = "INSERT INTO " . $this->table . " (" . $this->fields . ") VALUES (" . $this->values . ")";

	}

	function update($data,$arr_id) {

	$this->fields_values = "";

		foreach ($data as $field => $value) {
			if (is_numeric($value) || ($value == "CURRENT_TIMESTAMP")) $this->fields_values .= " $field = " . addslashes($value) . ",";
			else $this->fields_values .= " $field = '" . addslashes($value) . "',";
		}

	$this->fields_values = substr($this->fields_values,0,strlen($this->fields_values)-1);
	$this->sql = "UPDATE " . $this->table . " SET" . $this->fields_values . " WHERE " . array_keys($arr_id)[1] . " = " . array_values($arr_id)[1];
		
	}
	
	function async_add($field,$value,$key,$id) {
	
		$this->sql = "UPDATE " . $this->table . " SET " . $field . " = '" . addslashes($value) . "' WHERE $key = $id";
	
	}

	function async_add_num($field,$value,$key,$id) {
	
		$this->sql = "UPDATE " . $this->table . " SET " . $field . " = " . $value . " WHERE $key = $id";
	
	}	

	function async_update_field($field,$value,$key,$id) {
	
		$this->sql = "UPDATE " . $this->table . " SET " . $field . " = '" . addslashes($value) . "' WHERE $key = $id";
	
	}	
	
	function delete($data) {

		foreach ($data as $field => $value) {
			$this->fields .= $field;
			$this->values .= $value;
		}

	$this->sql = "DELETE FROM " . $this->table . " WHERE " . $this->fields . " IN (" . $this->values .")";

	}

	function execute() {

	global $db_con;
				
		db_connect();
		$db_con->query($this->START_T);
		$db_con->query($this->sql);
		$db_con->query($this->END_T);
		db_close();
		
	}

	function sql_get_id() {
	
	global $db_con;
	
		db_connect();
		$db_con->query($this->START_T);
		$db_con->query($this->sql);	
		$this->last_auto_id = $db_con->insert_id;
		$db_con->query($this->END_T);
		db_close();
		
	return $this->last_auto_id;
	
	}
	
	function debug() {

	echo $this->sql;

	}
	
	function debug_r() {

	return $this->sql;

	}	

}

class content {

var $table_head;
var $table_body;
var $table_row;
var $ctd;

	function __construct($arr_head) {

		$this->ctd = count($arr_head) + 1;
	
		$this->table_head .= '<thead><tr>';
		$this->table_head .= '<th><input type="checkbox" name="chk_checkall" id="chk_checkall" onclick="Check_all(this.form, this);"></th>';		
		
		foreach ($arr_head as $th) {

			$this->table_head .= '<th><strong>' . $th . '</strong></th>';

		}

		$this->table_head .= '</tr></thead>';		
	
	}

	function header() {		
		
		return $this->table_head;
		
	}
	
	function row($id,$arr_row) {
		
		$this->table_row = '<tr>';
		$this->table_row .= '<td><input type="checkbox" name="chk_' . $id . '" id="chk_' . $id . '" onClick="Uncheck_Parent(\'chk_checkall\',this);"></td>';
		
		foreach ($arr_row as $td) {
			$this->table_row .= '<td>' . $td . '</td>';
		}
		
		$this->table_row .= '</tr>';
	
		return $this->table_row;
	
	}
	
	function srow() {
		
		return '<tr><td colspan="' . $this->ctd . '">&nbsp;</td></tr>';
		
	}
	
	function body($arr_body,$c,$per_page) {
	
		$this->table_body = '<tbody>';

		for ($i=0; $i<sizeof($arr_body); ++$i) {
		
			$this->table_body .= '<tr>';
			foreach($arr_body[$i] as $key => $td) {
			
				if ($key == 0) $this->table_body .= '<td><input type="checkbox" name="chk_' . $td . '" id="chk_' . $td . '" onClick="Uncheck_Parent(\'chk_checkall\',this);"></td>';
				else $this->table_body .= '<td>' . $td . '</td>';
				
			}
			$this->table_body .= '</tr>';
			
		}
		
		if ($c < $per_page) {
			for ($i=$c; $i<=$per_page; ++$i) {
				$this->table_body .= '<tr><td colspan="' . $this->ctd . '">&nbsp;</td></tr>';
			}
		}			
		
		$this->table_body .= '</tbody>';		
		
		return $this->table_body;
	
	}

}

class pageNav {

var $param;
var $cur;
var $min;
var $max;
var $str_first;
var $str_previous;
var $cur_page;
var $str_next;
var $str_last;
var $inNav;

function __construct($par,$cur_page,$max_page,$jf) {

	$this->param = $par;
	$this->cur = $cur_page;
	$this->min = 1;
	$this->max = $max_page;

	$this->str_first = '<li><a href="javascript: ' . $jf . '(0,' . $this->param . ');">&laquo;</a></li>';
	$this->str_previous = '<li><a href="javascript: ' . $jf . '(-1,' . $this->param . ');">&lsaquo;</a></li>';
	$this->cur_page = '<li class="active"><a href="javascript: ' . $jf . '(2,' . $this->param . ');">' . $this->cur . '</a></li>';
	$this->str_next = '<li><a href="javascript: ' . $jf . '(1,' . $this->param . ');">&rsaquo;</a></li>';
	$this->str_last = '<li><a href="javascript: ' . $jf . '(3,' . $this->param . ');">&raquo;</a></li>';

	if ($this->cur == $this->min) {
		$this->str_first = '<li class="disabled"><a href="javascript: ' . $jf . '(2,' . $this->param . ');">&laquo;</a></li>';
		$this->str_previous = '<li class="disabled"><a href="javascript: ' . $jf . '(2,' . $this->param . ');">&lsaquo;</a></li>';
	}
	if ($this->cur == $this->max) {
		$this->str_next = '<li class="disabled"><a href="javascript: ' . $jf . '(2,' . $this->param . ');">&rsaquo;</a></li>';
		$this->str_last = '<li class="disabled"><a href="javascript: ' . $jf . '(2,' . $this->param . ');">&raquo;</a></li>';
	}
	
}

function getNav() {

	$this->inNav  = '<ul class="pagination">';
	$this->inNav .= '<li>' . $this->str_first . '</li>';
	$this->inNav .= '<li>' . $this->str_previous . '</li>';
	$this->inNav .= '<li>' . $this->cur_page . '</li>';
	$this->inNav .= '<li>' . $this->str_next . '</li>';
	$this->inNav .= '<li>' . $this->str_last . '</li>';
	$this->inNav .= '</ul>';

	return $this->inNav;
	
}

}

function enc($q) {
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function dec($q) {
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}

function populateSelect($table,$value,$option,$sel) {

global $db_con;

$options = "";
$sql = "SELECT $value, $option FROM $table";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		if ($sel == $rec[0]) $options .= '<option value="' . $rec[0] . '" selected="selected">' . $rec[1] . '</option>';
		else $options .= '<option value="' . $rec[0] . '">' . $rec[1] . '</option>';
	}
}
db_close();

return $options;

}

function returnTypeaheadID($id,$table,$criteria,$match) {

$typeahead_id = 0;
global $db_con;

$sql = "SELECT $id FROM $table WHERE $criteria = '$match'";
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$typeahead_id = $rec[0];
}
db_close();

return $typeahead_id;

}

function debug_log($txt) {

$file = fopen("debug.txt","a+");
fwrite($file,$txt."\r\n");
fclose($file);

}

function get_grad_rates($grad,$gross) {

$per_amt = 0;

$arr_grad = array(0=>0);
$arr_per = array(0=>0);
$start_b_pos=0;
for ($i=1; $i<=substr_count($grad,'['); $i++) {
$start_b_pos = strpos($grad,'[',$start_b_pos);
$end_b_pos = strpos($grad,']',$start_b_pos);
$arr_grad[$i] = substr($grad,$start_b_pos+1,($end_b_pos-$start_b_pos)-1);

$start_p_pos = strpos($grad,'(',$start_b_pos);
$end_p_pos = strpos($grad,')',$start_b_pos);
$arr_per[$i] = substr($grad,$start_p_pos+1,($end_p_pos-$start_p_pos)-1);


$start_b_pos++;
}
// print_r($arr_grad);
// print_r($arr_per);

foreach ($arr_grad as $key => $value) {

if ($key == 0 )continue;
$nkey = $key + 1;

if (isset($arr_grad[$nkey])) {
	if (($gross >= $arr_grad[$key]) && ($gross <= $arr_grad[$nkey])) $per_amt = ($gross*($arr_per[$key]/100));	
} else {
	if ($per_amt == 0) $per_amt = ($gross*($arr_per[$key]/100));
}

}

return $per_amt;

}

function get_grad_fixed($grad,$gross) {

$per_amt = 0;

$arr_grad = array(0=>0);
$arr_per = array(0=>0);
$start_b_pos=0;
for ($i=1; $i<=substr_count($grad,'['); $i++) {
$start_b_pos = strpos($grad,'[',$start_b_pos);
$end_b_pos = strpos($grad,']',$start_b_pos);
$arr_grad[$i] = substr($grad,$start_b_pos+1,($end_b_pos-$start_b_pos)-1);

$start_p_pos = strpos($grad,'(',$start_b_pos);
$end_p_pos = strpos($grad,')',$start_b_pos);
$arr_per[$i] = substr($grad,$start_p_pos+1,($end_p_pos-$start_p_pos)-1);


$start_b_pos++;
}
// print_r($arr_grad);
// print_r($arr_per);

foreach ($arr_grad as $key => $value) {

if ($key == 0 )continue;
$nkey = $key + 1;

if (isset($arr_grad[$nkey])) {
	if (($gross >= $arr_grad[$key]) && ($gross <= $arr_grad[$nkey])) $per_amt = $arr_per[$key];
} else {
	if ($per_amt == 0) $per_amt = $arr_per[$key];
}

}

return $per_amt;

}

function monthsBetween($startDate, $endDate) {
    $retval = "";

    // Assume YYYY-mm-dd - as is common MYSQL format
    $splitStart = explode('-', $startDate);
    $splitEnd = explode('-', $endDate);

    if (is_array($splitStart) && is_array($splitEnd)) {
        $difYears = $splitEnd[0] - $splitStart[0];
        $difMonths = $splitEnd[1] - $splitStart[1];
        $difDays = $splitEnd[2] - $splitStart[2];

        // $retval = ($difDays > 0) ? $difMonths : $difMonths - 1;
		$retval = $difMonths;
        $retval += $difYears * 12;
    }
    return $retval;
}

function db_connect_n() {
	global $db_con_n, $DB_HOST, $DB_USER, $DB_PWD, $DB_FILE, $DB_PORT;
	$db_con_n = new mysqli($DB_HOST, $DB_USER, $DB_PWD, $DB_FILE, $DB_PORT);
}

function db_close_n() {
	global $db_con_n;
	$db_con_n->close();
}

function computePenalty($pid,$ba_item_amount,$ba_assessment_id) {

global $db_con_n;

$date_due = date("Y-m-d");
$recent_application_date = date("Y");
$sql = "SELECT application_date FROM applications WHERE application_id = (SELECT application_fid FROM applications WHERE application_id = $pid)";
db_connect_n();
$rs = $db_con_n->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	$recent_application_date = date("Y",strtotime("+1 Year",strtotime($rec['application_date'])));
}
db_close_n();

// check if renewal - for penalty purposes
$for_renewal = false;
$sql = "SELECT application_form FROM applications WHERE application_id = $pid";
db_connect_n();
$rs = $db_con_n->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	$rec = $rs->fetch_array();
	if ($rec['application_form'] == "renew_app") $for_renewal = true;
}
db_close_n();

$ra_date = "$recent_application_date-01-01";
$jan_due_date = "$recent_application_date-01-20";
$month_diff = (int)(monthsBetween($ra_date,$date_due));
$penalty_interest = $month_diff*2;

/** Penalty **/

$penalty = 0;
$surcharge = 0;
$ba_item_penalty = 0;

if ($for_renewal) {
if (strtotime($date_due) > strtotime($jan_due_date)) {

	$ba_item_amount_d = $ba_item_amount;

	$dq = 0.25; // 1/4
	$second_q = "$recent_application_date-04-20"; // 1/2
	$third_q = "$recent_application_date-07-20"; // 3/4
	$fourth_q = "$recent_application_date-10-20"; // 1
	if (strtotime($date_due) > strtotime($second_q)) $dq = 0.50;
	if (strtotime($date_due) > strtotime($third_q)) $dq = 0.75;
	if (strtotime($date_due) > strtotime($fourth_q)) $dq = 1;
	if ($ba_assessment_id == 1) $ba_item_amount_d = $ba_item_amount*$dq;	
	
	$incr_by_month = date("Y-m-20");
	if (strtotime($date_due) <= strtotime($incr_by_month)) $penalty_interest = $penalty_interest - 2;
	if ($penalty_interest < 0) $penalty_interest = 0;
	

		$penalty = $ba_item_amount_d*0.25;
		$surcharge = ($ba_item_amount_d + $penalty)*($penalty_interest/100);
		$ba_item_penalty = $penalty + $surcharge;

}
}
/**/

return $ba_item_penalty;

}

?>