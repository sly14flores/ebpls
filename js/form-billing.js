$(function() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Generating payment schedule...</h4>' });
iniBilling();

});

function iniBilling() {

var id = $('#application_id').val();

$.ajax({
	url: 'applications-ajax.php?p=ini_billing',
	type: 'post',
	dataType: 'json',
	data: {application_id: id},
	success: function(data, status) {
		$.each(data, function(i, d) {
			$('#' + i).html(d);
			$('#' + i).css({"font-weight":"bold"});
		});
		$('#form-billing thead th').css({"text-align":"center"});
		$('#form-billing tbody td').css({"text-align":"center"});
		fetchBilling(id);
	}
});

}

function recomputeBillingC() {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

unbindConfirmYes();
var f = function() { recomputeBilling(); };	
confirmation('Are you sure you want to recompute this application\'s payment?',f,function() { });

}

function recomputeBilling() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Generating payment schedule...</h4>' });

var id = $('#application_id').val();

$.ajax({
	url: 'applications-ajax.php?p=ini_billing',
	type: 'post',
	dataType: 'json',
	data: {application_id: id, recompute_billing: 1},
	success: function(data, status) {
		$.each(data, function(i, d) {
			$('#' + i).html(d);
			$('#' + i).css({"font-weight":"bold"});
		});
		$('#form-billing thead th').css({"text-align":"center"});
		$('#form-billing tbody td').css({"text-align":"center"});
		fetchBilling(id);
	}
});

}

function fetchBilling(id) {

$.ajax({
	url: 'applications-ajax.php?p=fetch_billing',
	type: 'post',
	data: {application_id: id},
	success: function(data, status) {
		$('#payment-schedule tbody').html(data);
		$('[data-toggle=tooltip]').tooltip();		
		$.unblockUI();
	}
});

}

function payAmount(id,dd,src) {

var t = 'Pay Due Amount - ' + dd;
var c = 'form/payment-schedule.php?pay_id=' + id + '&src=' + src;
var show = function() {

	$('#payment_schedule_date_paid_dt').datetimepicker({pickTime: false});

	$('#frmPayment').validator();
	$('#frmPayment button').click(function() {
		updatePayment(id);
		pModalHide();
	});
};
var hide = function() {
	
}
pModal(t,c,show,hide);

}

function updatePayment(id) {

var or_no = $('#payment_schedule_or').val();
var or_date = $('#payment_schedule_date_paid').val();

$.ajax({
	url: 'applications-ajax.php?p=update_payment&payment_schedule_id=' + id,
	type: 'post',
	data: {payment_schedule_or: or_no, payment_schedule_date_paid: or_date},
	success: function(data, status) {
		iniBilling();
	}
});

}