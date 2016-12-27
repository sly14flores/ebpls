<?php

session_start();
$aid = 	$_SESSION['account_id'];
$account_department = $_SESSION['account_department'];

// $src = isset($_GET['src']) ? $_GET['src'] : 1;
$snB = '<input type="button" onclick="notifyVericators();" class="btn btn-primary btn-sm" value="Notify Assessors">';
$rtB = '<input type="button" onclick="recomputeTax();" class="btn btn-primary btn-sm" value="Recompute Tax">';
$apB = '<label><input onchange="applyPenalty(this);" id="apply-penalty" type="checkbox">&nbsp;Apply/Recompute Penalty</label>';

?>
<div id="assessment-on"></div>
<div class="pull-right" style="margin-bottom: 25px;">
<?php 

if (($account_department == 1) || ($account_department == 8)) {
	echo "$snB&nbsp;&nbsp;&nbsp;$rtB&nbsp;&nbsp;&nbsp;$apB";
}

?>
</div>
<div style="padding: 5px 0 5px 20px;">
<table class="table table-striped">
<thead><tr><th>Line of Business</th><th>Capitalization</th><th>Essential</th><th>Non-Essential</th></tr></thead>
<tbody>
<tr><td><span style="font-weight: bold;" id="aba_b_line_desc"></span></td><td><span style="font-weight: bold;" id="capitalization"></span></td><td><span style="font-weight: bold;" id="essential"></span></td><td><span id="non-essential"></span></td></tr>
</tbody>
</table>
<?php if (($account_department == 1) || ($account_department == 8)) { ?>
<div style="color: #FF4D5D; font-size: 16px;">Note: To apply/reset penalty for Custom fees and charges, click edit then just update.</div>
<?php } ?>
<fieldset style="margin-top: 30px;">
<legend>Local Taxes / Regulatory Fees &amp; Charges</legend>
<table class="table table-striped">
<thead>
<tr><th>&nbsp;</th><th>#</th><th style="width: 30%;">Description</th><th>Reference</th><th>Amount Due</th><th>Penalty/Surcharge</th><th>Total</th><th>Assessed by</th><th>Note</th><th>Action</th></tr>
</thead>
<tbody>
<?php

require '../config.php';
require '../globalf.php';

$rows = '';
$sql = "SELECT assessment_id, assessment_order, assessment_type, assessment_description, assessment_reference, assessment_note, assessment_date, assessment_aid FROM assessments ORDER BY assessment_id";
$c = 1;
db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		$rows .= '<tr>';
		$rows .= '<td><input type="hidden" id="aba_item_id_' . $rec['assessment_id'] . '"><input type="checkbox" name="chk_' . $rec['assessment_id'] . '" id="chk_' . $rec['assessment_id'] . '" onClick="noApplicable(' . $rec['assessment_id'] . ',this);" disabled></td>';
		$rows .= '<td style="width: 20px;">' . $c . '</td>';		
		$rows .= '<td>' . $rec['assessment_description'] . '</td>';
		$rows .= '<td>' . $rec['assessment_reference'] . '</td>';
		$rows .= '<td><input id="aba_item_amount_' . $rec['assessment_id'] .'" type="text" class="form-control" style="width: 60%;" onfocus="this.blur();" value="0"></td>';
		$rows .= '<td><input id="aba_item_penalty_' . $rec['assessment_id'] .'" type="text" class="form-control" style="width: 60%;" onfocus="this.blur();" value="0"></td>';
		$rows .= '<td id="aba_item_total_' . $rec['assessment_id'] . '"></td>';
		$rows .= '<td></td>';
		$rows .= '<td><span id="assessment_note_' . $rec['assessment_id'] . '"></span></td>';
		if ($rec['assessment_id'] == 1) {
			$rows .= '<td style="text-align: center;"><span id="add_custom_' . $rec['assessment_id'] . '"><a href="javascript: addCustomTax(' . $rec['assessment_id'] . ');" data-toggle="tooltip" data-placement="top" title="Add Custom Tax Amount"><img src="images/add-icon.png"></a><span></td>';
		} else {
			$rows .= '<td style="text-align: center;"><span id="add_custom_' . $rec['assessment_id'] . '"><a href="javascript: addCustomAba(' . $rec['assessment_id'] . ');" data-toggle="tooltip" data-placement="top" title="Add Custom Amount for ' . $rec['assessment_description'] . '"><img src="images/add-icon.png"></a><span></td>';
		}
		$rows .= '</tr>';
		$c++;
	}
}
db_close();

echo $rows;

?>
</tbody>
<tfoot>
<tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: right;"><strong>Total:</strong></td><td>&nbsp;</td><td id="amount-total"></td><td id="penalty-total">&nbsp;</td><td id="assessment-total"></td><td>&nbsp;</td><td>&nbsp;</td></tr>
</tfoot>
</table>
</fieldset>
</div>