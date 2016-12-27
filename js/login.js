function forgotPassword() {

var t = 'Forgot Password';
var c = 'form/email.php';
var show = function() {
	$('#frmEmail button').click(function() { emailPassword(); pModalHide(); });
	$('#frmEmail').validator();
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function emailPassword() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });
var euname = $('#email-username').val()

$.ajax({
	url: 'login-ajax.php?p=email_password',
	type: 'post',
	data: {peuname: euname},
	success: function(data, status) {
		$.unblockUI();
		notification(data,function() {  });		
	}
});

}