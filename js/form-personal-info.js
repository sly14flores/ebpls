$(function() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Initializing form...</h4>' });
var personal_info_ini = ($('#application_id').val() == 0) ? false : true;
if (!personal_info_ini) iniAppForm();
else resumeAppForm();
 
$('input').focusout(function() {

	var t = $(this).attr('type');

	if (t == 'text') {

		asyncSql(this);

	}

});

$('#application_dti_sec_cda_date_dt').datetimepicker({pickTime: false});
$('#application_ctc_date_dt').datetimepicker({pickTime: false});
$('#application_date_dt').datetimepicker({pickTime: false});
$('#application_dti_sec_cda_date_dt').on("dp.change",function(e) { 
	var tar = document.getElementById('application_dti_sec_cda_date');
	asyncSql(tar);
});
$('#application_ctc_date_dt').on("dp.change",function(e) { 
	var tar = document.getElementById('application_ctc_date');
	asyncSql(tar);
});
$('#application_date_dt').on("dp.change",function(e) { 
	var tar = document.getElementById('application_date');
	asyncSql(tar);
});

// togAppForm(document.getElementById('applicant_profile'));

});

function iniAppForm() {

$.ajax({
	url: 'applications-ajax.php?p=add',
	type: 'post',
	dataType: 'json',
	success: function(data, status) {
		$.each(data, function(key, value) {
			$('#' + key).val(value);
		});
		$.unblockUI();
	}
});

}

function resumeAppForm() {

var id = $('#application_id').val();

$.ajax({
	url: 'applications-ajax.php?p=view',
	type: 'post',
	dataType: 'json',
	data: {pid: id},
	success: function(data, status) {		
		$.each(data, function(key, value) {
			$('#' + key).val(value);
			if (key == 'application_form') if (value) $('#' + value).prop('checked',true);
			if (key == 'application_amendment') if (value) $('#' + value).prop('checked',true);
			if (key == 'application_mode_of_payment') if (value) $('#' + value).prop('checked',true);			
			if (key == 'application_organization_type') if (value) $('#' + value).prop('checked',true);
			if (key == 'application_entity') {
				if (value) $('#tax_incentive_yes').prop('checked',true);
				else $('#tax_incentive_no').prop('checked',true);
			}
			if (key == 'application_business_rented') {
				if (value) $('#' + value).prop('checked',true);
			}
		});
		fetchBusinessActivity(id);		
	}
});

}

function donePersonalInfo() {

verifyPersonalInfo('done');

}

function cancelPersonalInfo() {

$(document).on("keydown", null);

window.onbeforeunload = null;

var id = $('#application_id').val();
$.ajax({
	url: 'applications-ajax.php?p=cancel_application',
	type: 'post',
	data: {application_id: id},
	success: function(data, status) {
		$('#application_id').val(0);
		// content(0);
		location.reload();
	}
});

}

function fillApplicantInfo(src) {

$('#applicant_fullname_error').html('');
var chk = $('#applicant_fullname').val();

if (chk == '') {
	$('#applicant_fullname_error').html('Please fill out applicant full name.');
	return;
}

id = appID("application_id","applications","concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)",chk);

pModalHide();

if (id == 0) {

$('#' + src).prop('checked',false);

} else {



}

}