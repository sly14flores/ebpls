$(function() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Checking verification...</h4>' });
iniAppVerification();

});

function iniAppVerification() {


var id = $('#application_id').val();

$.ajax({
	url: 'applications-ajax.php?p=ini_app_verification',
	type: 'post',
	data: {pid: id},
	success: function(data, status) {
		fetchVerfications(id);
	}
});

}

function fetchVerfications(id) {

$.ajax({
	url: 'applications-ajax.php?p=fetch_verifications',
	type: 'post',
	data: {pid: id},
	success: function(data, status) {
		$('#tab-verifications tbody').html(data);
		$('[data-toggle=tooltip]').tooltip();
		$.unblockUI();
	}
});

}

function verifyDocument(id) {

var t = 'Verification';
var c = 'form/verify.php';
var show = function() {

$('#frmVerification button').click(function() { confirmVerifyDocument(id); pModalHide(); });
$('#verification_issued_dt').datetimepicker({pickTime: false});
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function confirmVerifyDocument(id) {

unbindConfirmYes();
var f = function() { documentVerification(id); };	
confirmation('Confirm verification?',f,function() { });

}

function documentVerification(id) {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Verifiying...</h4>' });

var vi = $('#verification_issued').val();

$.ajax({
	url: 'applications-ajax.php?p=document_verification',
	type: 'post',
	data: {verification_id: id, verification_issued: vi},
	success: function(data, status) {
		verificationNotification();	
	}
});

}

function aVerifyDocument(id,d) {

var t = 'Verification';
var c = 'form/verify.php?ver_id=' + id;
var show = function() {

$('#frmVerification button').click(function() { confirmAVerifyDocument(id,d); pModalHide(); });
$('#verification_issued_dt').datetimepicker({pickTime: false});
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function confirmAVerifyDocument(id,d) {

unbindConfirmYes();
var f = function() { aDocumentVerification(id,d); };	
confirmation('Confirm verification?',f,function() { });

}

function aDocumentVerification(id,d) {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Verifiying...</h4>' });

var vi = $('#verification_issued').val();

$.ajax({
	url: 'applications-ajax.php?p=document_verification_auto',
	type: 'post',
	data: {verification_id: id, dv: d, verification_issued: vi},
	success: function(data, status) {
		verificationNotification(d);
	}
});

}

function verificationNotification() {

var d = 0;
var arg = verificationNotification.arguments;
if (arg.length > 0) d = arg[0];

/* update notification
**/
var id = $('#application_id').val();
var an = $('#application_no').val();

$.ajax({
	url: 'notifications.php?p=verification_notification&sn_fid=' + id,
	type: 'post',
	data: {application_no: an, dv: d},
	success: function(data, status) {
		iniAppVerification();
	}
});
/*
**/

}