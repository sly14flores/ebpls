$(function(){

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Generating assessment items...</h4>' });
initAppAssessment();
$('[data-toggle=tooltip]').tooltip();

});

function initAppAssessment() {

var id = $('#application_id').val();
var ini_p = ($('#apply-penalty').prop('checked')) ? 'ini_penalty' : '';

$.ajax({
	url: 'applications-ajax.php?p=ini_app_assessment',
	type: 'post',
	dataType: 'json',
	data: {pid: id, ini_check_penalty: ini_p},
	success: function(data, status) {
		var d = data.aba[0];
		$('#aba_b_line_desc').html(d.aba_b_line_desc);
		$('#'+d.ba_cen).html(d.aba_gross_amount);
		taxesFeesCharges();
	}
});

}

function taxesFeesCharges() {

var id = $('#application_id').val();
var amount_penalty = 0;

$.ajax({
	url: 'applications-ajax.php?p=taxes_fees_charges',
	type: 'post',
	dataType: 'json',	
	data: {pid: id},
	success: function(data, status) {
		var amount_total = 0;
		var penalty_total = 0;
		var assessment_total = 0;
		$.each(data.aba_items, function(i, d) {
			amount_penalty = 0;
			if ($('#chk_' + d.aba_item_assessment)[0]) {
				$('#chk_' + d.aba_item_assessment).prop('disabled',false);			
				if (d.aba_item_not_applicable == 0) $('#chk_' + d.aba_item_assessment).prop('checked',true);
				$('#aba_item_id_' + d.aba_item_assessment).val(d.aba_item_id);
				$('#aba_item_amount_' + d.aba_item_assessment).val(d.aba_item_amount);
				$('#aba_item_penalty_' + d.aba_item_assessment).val(d.aba_item_penalty);				
				if (d.aba_item_not_applicable == 0) {
					amount_penalty = d.aba_item_amount + d.aba_item_penalty;
					amount_total += d.aba_item_amount;
					penalty_total += d.aba_item_penalty;
				}
				if (d.aba_item_custom == 1) $('#assessment_note_' + d.aba_item_assessment).html('Custom');
				$('#aba_item_total_' + d.aba_item_assessment).html(numberWithCommas(amount_penalty));
				if (d.aba_item_assessment != 1) $('#add_custom_' + d.aba_item_assessment).html('<a href="javascript: editAAmount(' + d.aba_item_assessment + ');" data-toggle="tooltip" data-placement="top" title="Edit Amount"><img src="images/edit.png"></a>');
			}
		assessment_total = amount_total + penalty_total;
		});		
		$('#amount-total').html(numberWithCommas(amount_total));
		$('#penalty-total').html(numberWithCommas(penalty_total));
		$('#assessment-total').html(numberWithCommas(assessment_total));
		$('[data-toggle=tooltip]').tooltip();
		$.unblockUI();		
	}
});

}

function noApplicable(assessment_id,e) {

if (privileges('edit_application') == 0) {
	$('#chk_' + assessment_id).prop('checked',!e.checked);
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Updating assessment items...</h4>' });

var id = $('#application_id').val();
var aba_item_id = $('#aba_item_id_' + assessment_id).val();
var val = (e.checked) ? 0 : 1;

$.ajax({
	url: 'applications-ajax.php?p=not_applicable&aba_item_id=' + aba_item_id,
	type: 'post',
	data: {aba_item_not_applicable: val},
	success: function(data, status) {

	}
});

initAppAssessment();

}

function addCustomTax(assessment_id) {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

var id = $('#application_id').val();

var t = 'Add Custom Tax Amount';
var c = 'form/add-custom-tax.php';
var show = function() {
	$('#frmCustomTax button').click(function() { formCustomTax(assessment_id); pModalHide(); });
	$('#frmCustomTax').validator();

	$.ajax({
		url: 'applications-ajax.php?p=fetch_tax_amount',
		type: 'post',
		dataType: 'json',
		data: {aba_item_fid: id},
		success: function(data, status) {
			var d = data.fetch_tax[0];
			$('#aba_custom_amount').val(d.aba_item_amount);			
			$('#default-tax').prop('checked',(d.aba_item_custom == 1) ? false : true);
		}
	});	
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function formCustomTax(assessment_id) {

var id = $('#application_id').val();
var aba_custom_amount = $('#aba_custom_amount').val();
var default_tax = ($('#default-tax').prop('checked')) ? 0 : 1;
var ap = ($('#apply-penalty').prop('checked')) ? 'apply_penalty' : '';

$.ajax({
	url: 'applications-ajax.php?p=add_custom_tax&ap=' + ap,
	type: 'post',
	data: {aba_item_fid: id, aba_item_assessment: assessment_id, aba_item_amount: aba_custom_amount, aba_item_penalty: 0, aba_item_custom: default_tax},
	success: function(data, status) {
		initAppAssessment();
	}
});

}

function addCustomAba(assessment_id) {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

var id = $('#application_id').val();

var t = 'Add Custom';
var c = 'form/add-custom-aba.php';
var show = function() {
	$('#frmCustomAba button').click(function() { formCustomAba(assessment_id); pModalHide(); });
	$('#frmCustomAba').validator();
		
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function formCustomAba(assessment_id) {

var id = $('#application_id').val();
var aba_custom_amount = $('#aba_custom_amount').val();
var ap = ($('#apply-penalty').prop('checked')) ? 'apply_penalty' : '';

$.ajax({
	url: 'applications-ajax.php?p=add_custom_ba&ap=' + ap,
	type: 'post',
	data: {aba_item_fid: id, aba_item_assessment: assessment_id, aba_item_amount: aba_custom_amount, aba_item_custom: 1},
	success: function(data, status) {
		initAppAssessment();
	}
});

}

function closeAssessment() {

	$('#application_id').val(0);
	content(0);

}

function editAAmount(id) {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}


var aba_item_fid_ = $('#application_id').val();

var t = 'Edit Amount';
var c = 'form/edit-assessment-amount.php';

var show = function() {

$.ajax({
	url: 'applications-ajax.php?p=get_ba_amount',
	type: 'post',
	data: {aba_item_fid: aba_item_fid_, aba_item_assessment: id},
	success: function(data, status) {
		$('#edit-aamount').val(data);
	}
});

$('#frmEditAAmount button').click(function() {

var aba_item_amount_ = $('#edit-aamount').val();
var ap = ($('#apply-penalty').prop('checked')) ? 'apply_penalty' : '';

$.ajax({
	url: 'applications-ajax.php?p=update_ba_amount&ap=' + ap,
	type: 'post',
	data: {aba_item_fid: aba_item_fid_, aba_item_assessment: id, aba_item_amount: aba_item_amount_},
	success: function(data, status) {
		pModalHide();
		initAppAssessment();
	}
});
	
});

};

var hide = function() {

}
pModal(t,c,show,hide);

}

function notifyVericators() {

/* generate notification
**/
var id = $('#application_id').val();
var an = $('#application_no').val();

$.ajax({
	url: 'notifications.php?p=notify_assessors&sn_fid=' + id,
	type: 'post',
	data: {application_no: an},
	success: function(data, status) {
		notification(data,function() {});
	}
});
/*
**/

}

function recomputeTax() {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Generating assessment items...</h4>' });
togRecomputeTax("recompute_tax");

}

function togRecomputeTax(tog) {

var id = $('#application_id').val();
var ap = ($('#apply-penalty').prop('checked')) ? 'apply_penalty' : '';

$.ajax({
	url: 'applications-ajax.php?p=ini_app_assessment',
	type: 'post',
	dataType: 'json',
	data: {pid: id, recompute: tog, recompute_tax_penalty: ap},
	success: function(data, status) {
		var d = data.aba[0];
		$('#aba_b_line_desc').html(d.aba_b_line_desc);
		$('#'+d.ba_cen).html(d.aba_gross_amount);
		taxesFeesCharges();
	}
});

}

function applyPenalty(e) {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Generating assessment items...</h4>' });
var arg = (e.checked) ? "toggle_penalty" : "";
togPenalty(arg);

}

function togPenalty(tog) {

var id = $('#application_id').val();

$.ajax({
	url: 'applications-ajax.php?p=ini_app_assessment',
	type: 'post',
	dataType: 'json',
	data: {pid: id, apply_penalty: tog},
	success: function(data, status) {
		var d = data.aba[0];
		$('#aba_b_line_desc').html(d.aba_b_line_desc);
		$('#'+d.ba_cen).html(d.aba_gross_amount);
		taxesFeesCharges();
	}
});

}