<?php

require '../config.php';
require '../globalf.php';

$baid = (isset($_GET['baid'])) ? $_GET['baid'] : 0;
$src = (isset($_GET['src'])) ? $_GET['src'] : 1;

$legend_title = "Add New Business Activity";
$save_update = "Save";
$cancel_close = "Cancel";
if ($src == 2) {
	$legend_title = "Edit Business Activity Info";
	$cancel_close = "Close";
	$save_update = "Update";
}

$up = '<div class="clearfix" style="position: relative; margin-bottom: 10px;">';
$down = '<div class="clearfix" style="position: relative; margin-bottom: 10px;">';

$buttons = '<div style="position: absolute; top: 0; right: 0;">';
$buttons .= '<button class="btn btn-primary btn-sm" onclick="saveBA(' . $src . ',' . $baid . ');">' . $save_update . '</button>&nbsp;&nbsp;';
$buttons .= '<input type="button" class="btn btn-default btn-sm" onclick="cancelBusinessActivityForm(' . $src . ');" value="' . $cancel_close . '">';
$buttons .= '</div>';
$buttons .= '</div>';

?>

<form role="form" id="frmBusinessActivity" onSubmit="return false;">
<?php echo $up.$buttons; ?>
<fieldset>
    <legend><?php echo $legend_title; ?></legend>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="ba_organization">Applies to (organization)</label>
                <select id="ba_organization" class="form-control">
				<option value="All">All</option>				
				<option value="Single">Single</option>
				<option value="Partnership">Partnership</option>
				<option value="Corporation">Corporation</option>
				<option value="Cooperative">Cooperative</option>
				</select>
            </div>
        </div>
		<div class="col-sm-3">
			<div class="form-group">
				<label for="ba_cen">Applies to</label>
				<select id="ba_cen" class="form-control">
				<option value="capitalization">Capitalization</option>
				<option value="essential">Essential</option>
				<option value="non-essential">Non-essential</option>
				</select>
			</div>
		</div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="ba_code">Code</label>
                <input id="ba_code" class="form-control" size="30" type="text" placeholder="Enter code (optional)" value="">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="ba_line">Line of Business</label>
                <input id="ba_line" class="form-control" size="30" type="text" placeholder="Enter description" value="">
				<span class="help-block with-errors"></span>
            </div>
        </div>		
    </div>
	<div class="row">
		<div class="col-sm-3">
            <div class="form-group">
                <label for="ba_note">Note</label>
                <input id="ba_note" class="form-control" size="30" type="text" placeholder="Enter note (optional)" value="">
            </div>		
		</div>
		<div class="col-sm-9">&nbsp;</div>
	</div>
</fieldset>
<fieldset>
	<legend>Local Taxes / Regulatory Fees and Charges</legend>
	<div class="row">
		<div class="col-sm-12">
		<h4 style="margin-top: -10px;">Check the following local taxes/regulatory fees and charges that applies to this line of business</h4>
		<div id="ba-local-taxes-fees-charges"></div>
		</div>
	</div>
</fieldset>
<?php echo $down.$buttons; ?>
<hr style="margin-top: 40px;">
</form>