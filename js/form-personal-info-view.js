$(function() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Initializing form...</h4>' });
iniViewAppForm();
	
});

function iniViewAppForm() {

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
			if (key == 'application_taxpayer_gender') $('#application_taxpayer_gender').val(value);
		});
		fetchBusinessActivity(id);
		disElems(true);		
	}
});

}

function disEditElems() {

var elem = new Array("new_app","renew_app","additional_app");

$.each(elem, function(index, value) {
	$('#' + value).prop('disabled',true);
});

}

function editPersonalInfo() {

if (privileges('edit_application') == 0) {
	$.notify("Edit application is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

disElems(false);
disEditElems();

$(function() {

	$('input').focusout(function() {

	var t = $(this).attr('type');

	if (t == 'text') {

		asyncSql(this);

	}
	
	});

$('.edit-personal-info').attr('value','Done');
$('.edit-personal-info').animate({
	width: '50'
});

$('.edit-personal-info').attr("onclick","doneEditPersonalInfo();");
$('#add-business-activity').attr("onclick","addBusinessActivity();");

	
})();

}

function doneEditPersonalInfo() {

verifyPersonalInfo('done_edit');

if (!personal_info_verified) {
	$.notify("Please complete filling up the required information before closing.", {className: "error", globalPosition: "top left"});
	return;
}

disElems(true);

$(function() {
	$('.edit-personal-info').attr('value','Edit Application');	
	$('.edit-personal-info').animate({
		width: '110'
	});
	
	$('.edit-personal-info').attr('onclick','editPersonalInfo();');
	$('#add-business-activity').attr("onclick","noEditBA();");

})();	
	
}

function noEditBA() {

$.notify("Click Edit Personal Info to add business activity.", {className: "error", globalPosition: "top left"});

}