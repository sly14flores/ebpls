<?php $src = isset($_GET['src']) ? $_GET['src'] : 1; ?>
<input type="hidden" id="app-add-edit" value="<?php echo $src; ?>">
<input type="hidden" id="on-tab" value="personal-info-on">
<?php

$doneB = '<input style="margin-right: 10px;" type="button" onclick="donePersonalInfo();" class="btn btn-primary btn-sm" value="Done">';
$previewB = '<input style="margin-right: 10px;" type="button" onclick="previewForm();" class="btn btn-primary btn-sm" value="Print Preview">';
$cancelB = '<input type="button" onclick="cancelPersonalInfo();" class="btn btn-primary btn-sm" value="Cancel">';
$closeB = '<input style="margin-right: 10px;" type="button" onclick="closePersonalInfo();" class="btn btn-primary btn-sm" value="Close">';

?>
<div class="form-group" style="margin-bottom: 40px;">
	<label for="application_no">Application No.:&nbsp;&nbsp;</label><input id="application_no" class="form-control" type="text" value="" style="width: 100px; display: inline;">
</div>
<div id="personal-info-buttons-top" class="pull-right" style="margin-top: -35px;">
<?php 

if ($src == 1) {
	echo "$doneB$previewB$cancelB";
}	
if ($src == 2) {
	echo "$closeB$previewB";
}	

?>
</div>
<div role="tabpanel" style="margin-top: 55px;">
	<ul class="nav nav-pills nav-wizard" role="tablist">
	<li role="presentation" class="active"><a href="tabs/form-personal-info.php" data-target="#personal-info" aria-controls="home" role="tab" data-toggle="tabajax">Personal / Business Info</a><div class="nav-arrow"></div></li>
	<li role="presentation"><div class="nav-wedge"></div><a href="tabs/form-assessment.php" data-target="#assessment" aria-controls="profile" role="tab" data-toggle="tabajax">Assessment</a><div class="nav-arrow"></div></li>
	<li role="presentation"><div class="nav-wedge"></div><a href="tabs/form-verification.php" data-target="#verification" aria-controls="profile" role="tab" data-toggle="tabajax">Verification</a><div class="nav-arrow"></div></li>
	<li role="presentation"><div class="nav-wedge"></div><a href="tabs/form-billing.php" data-target="#billing" aria-controls="profile" role="tab" data-toggle="tabajax">Billing</a></li>	
	</ul>
	<div class="tab-content" style="margin-top: 10px;">
		<div role="tabpanel" class="tab-pane fade in active" id="personal-info"></div>
		<div role="tabpanel" class="tab-pane fade in" id="assessment"></div>
		<div role="tabpanel" class="tab-pane fade in" id="verification"></div>				
		<div role="tabpanel" class="tab-pane fade in" id="billing"></div>				
	</div>
</div>
<hr>
<div id="personal-info-buttons-bottom" style="margin-top: 25px;">
<?php 

if ($src == 1) {
	echo "$doneB$previewB$cancelB";
}	
if ($src == 2) {
	echo "$closeB$previewB";
}	

?>
</div>