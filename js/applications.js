cur_page = 1;
total_page = 0;
personal_info_verified = false;

$(function() {

	content(0);

});

function disElems(opt) {

var elem = new Array("application_date","new_app","renew_app","additional_app","single_partnership","single_corporation","partnership_single","partnership_corporation","corporation_single","corporation_partnership","pay_annually","pay_bi_annually","pay_quarterly","single_organization","application_dti_sec_cda","application_dti_sec_cda_date","partnership_organization","corporation_organization","cooperative_organization","application_ctc_no","application_ctc_date","application_tin","tax_incentive_yes","tax_incentive_no","application_entity","application_taxpayer_lastname","application_taxpayer_firstname","application_taxpayer_middlename","application_taxpayer_gender","application_taxpayer_sss","application_taxpayer_business_name","application_trade_franchise","application_treasurer_lastname","application_treasurer_firstname","application_treasurer_middlename","application_business_address_no","application_business_address_bldg","application_business_address_unit_no","application_business_address_street","application_business_address_brgy","application_business_address_subd","application_business_address_mun_city","application_business_address_province","application_business_address_tel_no","application_business_address_email","application_owner_address_no","application_owner_address_bldg","application_owner_address_unit_no","application_owner_address_street","application_owner_address_brgy","application_owner_address_subd","application_owner_address_mun_city","application_owner_address_province","application_owner_address_tel_no","application_owner_address_email","application_pin","application_business_area","application_no_employees","application_no_residing","application_business_rented","rented_yes","rented_no","application_lessor_lastname","application_lessor_firstname","application_lessor_middlename","application_monthly_rental","application_lessor_address_no","application_lessor_address_street","application_lessor_address_brgy","application_lessor_address_subd","application_lessor_address_mun_city","application_lessor_address_province","application_lessor_address_tel_no","application_lessor_address_email","application_contact_person","application_position_title","application_signatory_lastname","application_signatory_firstname","application_signatory_middlename");

$.each(elem, function(index, value) {
	$('#' + value).prop('disabled',opt);
	if ($('#tax_incentive_no').prop('checked')) $('#application_entity').prop('disabled',true);
});

if ($('#rented_no').prop('checked')) {
	var ne = ["application_lessor_lastname","application_lessor_firstname","application_lessor_middlename","application_monthly_rental","application_lessor_address_no","application_lessor_address_street","application_lessor_address_brgy","application_lessor_address_subd","application_lessor_address_mun_city","application_lessor_address_province","application_lessor_address_tel_no","application_lessor_address_email"];
	$.each(ne, function(index, value) {
		$('#' + value).prop('disabled',true);
	});
}

}

function disModuleMainB() {

var chk = false;

var chkf = $('#form-personal-info')[0];
if (chkf) chk = true;

return chk;

}

function verifyPersonalInfo(src) {

var chk = false;
var chks = [];

// new/renewal/additional

/* var nra = ["new_app","renew_app","additional_app"];
$.each(nra, function(index, value) {
	chk = $('#'+value).prop('checked');
	if (chk) return false;
});
if (!chk) {
	$('#notify-nra').notify("Please select New, Renewal, or Additional.", {className: "error", globalPosition: "top center"});
}	
chks.push(chk); */

// mode of payment

/* var mop = ["pay_annually","pay_bi_annually","pay_quarterly"];
$.each(mop, function(index, value) {	
	chk = $('#'+value).prop('checked');
	if (chk) return false;
});
if (!chk) {
	$('#notify-mop').notify("Please select Mode of Payment.", {className: "error", globalPosition: "top center"});
}
chks.push(chk); */

// type of organization
var chk_too = "";
var too = ["single_organization","partnership_organization","corporation_organization","cooperative_organization"];
$.each(too, function(index, value) {	
	chk = $('#'+value).prop('checked');
	if (chk) {
		chk_too = value;
		return false;
	}
});
if (!chk) {
	$('#notify-too').notify("Please select type of organization.", {className: "error", globalPosition: "top center"});
}
chks.push(chk);

// tax incentive
var ti = ["tax_incentive_yes","tax_incentive_no"];
$.each(ti, function(index, value) {	
	chk = $('#'+value).prop('checked');
	if (chk) return false;
});
if (!chk) {
	$('#notify-incentive').notify("Please answer this question.", {className: "error", globalPosition: "top center"});
}
chks.push(chk);

// business rented
var br = ["rented_yes","rented_no"];
$.each(br, function(index, value) {	
	chk = $('#'+value).prop('checked');
	if (chk) return false;
});
if (!chk) {
	$('#notify-rented').notify("Please answer this question.", {className: "error", globalPosition: "top center"});
}
chks.push(chk);

var elem = new Array("application_taxpayer_lastname","application_taxpayer_business_name","application_position_title");
if (chk_too == 'corporation_organization') elem.splice(0,1);
$.each(elem, function(index, value) {
	val = $('#'+value).val();
	if (val == '') {
		$('#'+value).notify("Please fill up this field.", {className: "error", globalPosition: "top center"});	
		chks.push(false);
	} else {
		chks.push(true);
	}
});

/* var ba = $('#business-activity tbody tr').length;
if (ba == 0) {
	$('#business-activity').notify("Please add business activity.", {className: "error", globalPosition: "top center"});
	chk = false;
} else {
	chk = true;
}	
chks.push(chk); */

var count_false = 0;
$.each(chks, function(index, value) {
	if (!value) {
		if (src == 'done') $.notify("Please scroll up/down, some fields need to be completed.", {className: "error", globalPosition: "top left"});
		count_false++;
		return false;
	}
});

if (count_false == 0) {
	if (src == 'done') $.notify("Success! You may now proceed to Assessment.", {className: "success", globalPosition: "top left"});
	personal_info_verified = true;

	doneAdd();
}
	
}

function doneAdd() {

var src = $('#app-add-edit').val();

var previewB = '<input style="margin-right: 10px;" type="button" onclick="previewForm();" class="btn btn-primary btn-sm" value="Print Preview">';
var cancelB = '<input type="button" onclick="cancelPersonalInfo();" class="btn btn-primary btn-sm" value="Cancel">';
var closeB = '<input style="margin-right: 10px;" type="button" onclick="closePersonalInfo();" class="btn btn-primary btn-sm" value="Close">';

var buttons = closeB + previewB + cancelB;
if (parseInt(src) == 2) buttons = closeB + previewB;
$('#personal-info-buttons-top').html(buttons).fadeIn('slow');
$('#personal-info-buttons-bottom').html(buttons).fadeIn('slow');

/* generate notification
**/
if (parseInt(src) == 1) {
	var id = $('#application_id').val();
	var an = $('#application_no').val();

	$.ajax({
		url: 'notifications.php?p=add',
		type: 'post',
		data: {application_id: id, application_no: an},
		success: function(data, status) {

		}
	});
}
/*
**/

}

function navigateAway(m) {

if (disModuleMainB()) {

if (m == 'applications.php') return;

var f = function() { };
notification('Cannot navigate to other module while on encoding/editing process.',f);
return;

}

switch (m) {

case 'business-permits.php':
	if (privileges('permits_module') == 0) {
		$.notify("Business Permits module is restricted.", {className: "error", globalPosition: "top left"});
		return;
	}	
break;

case 'departments.php':
	if (privileges('departments_module') == 0) {
		$.notify("Departments module is restricted.", {className: "error", globalPosition: "top left"});
		return;
	}	
break;

case 'user-accounts.php':
	if (privileges('accounts_module') == 0) {
		$.notify("User Accounts module is restricted.", {className: "error", globalPosition: "top left"});
		return;
	}	
break;

case 'manage.php':
	if (privileges('management_module') == 0) {
		$.notify("Management module is restricted.", {className: "error", globalPosition: "top left"});
		return;
	}	
break;

}

window.location.href = m;

}

function content() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#module-content').html(loading);

var args = content.arguments;
var dir = args[0];
var par = '';
if (args.length > 1) par = args[1];

switch (dir) {

case 0: // first page
cur_page = 1;
break;

case 2: // current page
break;

case 3: // last page
cur_page = total_page;
break;

default: // previous next -1/1
cur_page = (cur_page) + parseInt(dir);

}

var page = '&cp=' + cur_page + '&d=' + dir + par;

$.ajax({	
	url: 'applications-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#module-content').html(sdata[0]);
		total_page = parseInt(sdata[1]);
		$('[data-toggle=tooltip]').tooltip();
	}
});

}

function asyncSql(e) {

var id = $('#application_id').val();
var eid = $(e).attr('id');
var val = $(e).val();

$.ajax({
	url: 'applications-ajax.php?p=async_add',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function asyncSqlBA(e) {

var _id = e.id.split("_");
var id = _id[2];
var eid = _id[0] + "_" + _id[1];
if (_id.length == 4) {
	id = _id[3];
	eid = _id[0] + "_" + _id[1] + "_" + _id[2];
}
var val = $(e).val();

$.ajax({
	url: 'applications-ajax.php?p=async_add_ba',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function chkboxAsyncSql(eid,val) {

var id = $('#application_id').val();

$.ajax({
	url: 'applications-ajax.php?p=async_add',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function asyncUpdateField(id) {

var val = $('#business_status').val();

$.ajax({
	url: 'applications-ajax.php?p=async_update_field',
	type: 'post',
	data: {pid: id, field: 'business_status', value: val},
	success: function(data, status) {
		
	}
});

}

function addApplication(src,id) {

if (src == 1) {

$(document).on("keydown", disableF5);

window.onbeforeunload = function() {
	return "Warning! Reloading the page without completing the required information will result in unknown application number.";
}

if (privileges('add_application') == 0) {
	$.notify("Add application is restricted.", {className: "error", globalPosition: "top left"});
	return;
}	

} else {

if (privileges('view_application') == 0) {
	$.notify("View application is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

}

if (disModuleMainB()) {

var f = function() { };
notification('Cannot add another application while on encoding/editing process.',f);
return;

}

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#module-content').html(loading);
$('#module-content').load('application-wizard.php?src=' + src, function() { applicationWizard(src,id); });

}

function applicationWizard(src,id) {

var personal_info_js;
var verification_js;
var assessment_js;
var billing_js;

switch (src) {

case 1:
personal_info_js = 'js/form-personal-info.js';
assessment_js = 'js/form-assessment.js';
verification_js = 'js/form-verification.js';
billing_js = 'js/form-billing.js';
break;

case 2:
personal_info_js = 'js/form-personal-info-view.js';
assessment_js = 'js/form-assessment.js';
verification_js = 'js/form-verification.js';
billing_js = 'js/form-billing.js';
break;

}

iniTab('tabs/form-personal-info.php?src=' + src,'#personal-info',personal_info_js);

$('[data-toggle="tabajax"]').click(function(e) {

    e.preventDefault();
    var loadurl = $(this).attr('href') + '?src=' + src;
    var targ = $(this).attr('data-target');
	
	var personal_info_on = false;
	var assessment_on = false;
	var verification_on = false;
	var billing_on = false;	
	
	// determinse source tab
	personal_info_on = ($('#on-tab').val() == 'personal-info-on') ? true : false;
	assessment_on = ($('#on-tab').val() == 'assessment-on') ? true : false;
	verification_on = ($('#on-tab').val() == 'verification-on') ? true : false;
	billing_on = ($('#on-tab').val() == 'billing-on') ? true : false;
	
	// don't proceed if personal info is not verified
	if (verification_enabled) {
	
	if ( ((targ == '#assessment') && (personal_info_on)) || ((targ == '#verification') && (personal_info_on)) || ((targ == '#billing') && (personal_info_on)) ) {

		verifyPersonalInfo('assessment');

		if (!personal_info_verified) {
			$.notify("Please complete filling up the required information before proceeding to assessment/verification.", {className: "error", globalPosition: "top left"});
			return;
		}
	
	}
	
	}
	
	// don't proceed to assessment if no business activity defined
	if (targ == '#assessment') {
		var ba = $('#business-activity tbody tr').length;
		if ( (ba == 0) || (checkBA() == false) ) {
		$.notify("No business activity defined.", {className: "error", globalPosition: "top left"});
		return;
		}
	}
	
	if (targ == '#verification') {
		if (checkAssessment() == false) {
		$.notify("Assessment not yet done.", {className: "error", globalPosition: "top left"});
		return;		
		}	
	}
	
	// don't proceed to billing if no assessment defined
	if (targ == '#billing') {
		if (checkAssessment() == false) {
		$.notify("Assessment not yet done.", {className: "error", globalPosition: "top left"});
		return;		
		}
	}
	
    $.get(loadurl, function(data) {
        $(targ).html(data);

		switch (targ) {
		
		case "#personal-info":
		jQuery.getScript(personal_info_js,function(data, status, jqxhr) {});
		$('#on-tab').val('personal-info-on');
		break;
			
		case "#assessment":
		jQuery.getScript(assessment_js,function(data, status, jqxhr) {});
		$('#on-tab').val('assessment-on');		
		break;
		
		case "#verification":
		jQuery.getScript(verification_js,function(data, status, jqxhr) {});
		$('#on-tab').val('verification-on');		
		break;

		case "#billing":
		jQuery.getScript(billing_js,function(data, status, jqxhr) {});
		$('#on-tab').val('billing-on');		
		break;		
				
		}
		
    });
    $(this).tab('show');
});

}

function iniTab(loadurl, targ, js) {

$.get(loadurl, function(data) {
	$(targ).html(data);
	jQuery.getScript(js,function(data, status, jqxhr) {});
});
$('#personal-info').tab('show');

}

function viewApplication() {

var arg = viewApplication.arguments;

if (disModuleMainB()) {

var f = function() { };
notification('To view another application close this application first.  Select one from the list/table or search result then click View Application.',f);
return;

}

if (arg.length == 0) {
	if (count_checks('frmContent') == 0) {
		var f = function() { uncheckMulti('frmContent'); };
		notification('Please select one.',f);
		return;
	}
id = getCheckedId('frmContent');	
} else {
	id = arg[0];
} 

$('#application_id').val(id);

addApplication(2,id);

}

function delApplication() {

if (privileges('add_application') == 0) {
	$.notify("Delete application is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

if (disModuleMainB()) {

var f = function() { };
notification('To delete an this application select it from the applications list/table.  If you have added a new application by mistake just click cancel to discard it.',f);
return;

}

if (count_checks('frmContent') == 0) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

unbindConfirmYes();
var f = function() { pdelApplication(id); };	
confirmation('Are you sure you want to delete this application(s)?',f,function() { uncheckMulti('frmContent'); });

}

function pdelApplication(id) {

$.ajax({
	url: 'applications-ajax.php?p=delete',
	type: 'post',
	data: {application_id: id},
	success: function(data, status) {
		notification(data,function() { content(0); });		
	}
});

}

function addBusinessActivity() {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

var ba = $('#business-activity tbody tr').size();
if (ba > 0) return;	

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });
var id = $('#application_id').val();

var ba_tbody = '';
$.ajax({
	url: 'applications-ajax.php?p=add_ba',
	type: 'post',
	data: {aba_fid: id},
	success: function(data, status) {
		$.unblockUI();
		var n = data;
		ba_tbody = '<tr id="bar_' + n + '">';
		ba_tbody += '<td>' + '<input id="aba_code_' + n + '" type="hidden" value="0"><a id="query_code" data-toggle="tooltip" data-placement="top" title="Add Business Activity by Code" href="javascript: queryBA(' + n + ');"><img src="images/arrow-down-icon.png"></a> <input id="aba_code_d_' + n + '" style="width: 130px;" type="text" value="" onfocus="this.blur();">' + '</td>';
		ba_tbody += '<td>' + '<input id="aba_b_line_' + n + '" type="hidden" value="0"><a id="query_line" data-toggle="tooltip" data-placement="top" title="Add Business Activity by Business Line" href="javascript: queryBA(' + n + ');"><img src="images/arrow-down-icon.png"></a> <input id="aba_b_line_d_' + n + '" style="width: 130px;" type="text" value="" onfocus="this.blur();">' + '</td>';
		ba_tbody += '<td>' + '<input id="aba_units_' + n + '" style="width: 130px;" type="text" onfocusout="asyncSqlBA(this);" value="">' + '</td>';
		ba_tbody += '<td>' + '<input id="togCap_' + n + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + n + ');"> <input id="aba_cap_' + n + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="" disabled>' + '</td>';
		ba_tbody += '<td>' + '<input id="togEss_' + n + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + n + ');"> <input id="aba_ess_' + n + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="" disabled>' + '</td>';
		ba_tbody += '<td>' + '<input id="togNes_' + n + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + n + ')"> <input id="aba_nes_' + n + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="" disabled>' + '</td>';
		ba_tbody += '<td id="ba_edit_save_' + n + '" style="text-align: center;"><a href="javascript: rBA(' + n + ');" data-toggle="tooltip" data-placement="top" title="Delete"><img src="images/delete.png"></a></td>';
		ba_tbody += '</tr>';

		$(ba_tbody).appendTo('#business-activity tbody');
		$('[data-toggle=tooltip]').tooltip();
				
	}
});

}

function fetchBusinessActivity(id) {

var ba_tbody = '';
$.ajax({
	url: 'applications-ajax.php?p=view_ba',
	type: 'post',
	dataType: 'json',
	data: {pid: id},
	success: function(data, status) {
		$.unblockUI();		
		$.each(data.aba_items, function(i,d){		
			
			if (d.aba_id == 0) return;
			
			ba_tbody = '<tr id="bar_' + d.aba_id + '">';
			ba_tbody += '<td>' + '<input id="aba_code_' + d.aba_id + '" type="hidden" value="' + d.aba_code + '"><a id="query_code" data-toggle="tooltip" data-placement="top" title="Change Business Activity" href="javascript: queryBA(' + d.aba_id + ');"><img src="images/arrow-down-icon.png"></a> <input id="aba_code_d_' + d.aba_id + '" style="width: 130px;" type="text" value="' + d.aba_code_name + '" onfocus="this.blur();">' + '</td>';
			ba_tbody += '<td>' + '<input id="aba_b_line_' + d.aba_id + '" type="hidden" value="' + d.aba_b_line + '"><a id="query_line" data-toggle="tooltip" data-placement="top" title="Change Business Activity" href="javascript: queryBA(' + d.aba_id + ');"><img src="images/arrow-down-icon.png"></a> <input id="aba_b_line_d_' + d.aba_id + '" style="width: 130px;" type="text" value="' + d.aba_b_line_name + '" onfocus="this.blur();">' + '</td>';
			ba_tbody += '<td>' + '<input id="aba_units_' + d.aba_id + '" style="width: 130px;" type="text" onfocusout="asyncSqlBA(this);" value="' + d.aba_units + '" disabled>' + '</td>';
			if (d.aba_gross_base == 'capitalization')
			ba_tbody += '<td>' + '<input id="togCap_' + d.aba_id + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + d.aba_id + ');" checked="checked" disabled> <input id="aba_cap_' + d.aba_id + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="' + d.aba_gross_amount + '" disabled>' + '</td>';			
			else
			ba_tbody += '<td>' + '<input id="togCap_' + d.aba_id + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + d.aba_id + ');" disabled> <input id="aba_cap_' + d.aba_id + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="" disabled>' + '</td>';
			if (d.aba_gross_base == 'essential')
			ba_tbody += '<td>' + '<input id="togEss_' + d.aba_id + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + d.aba_id + ');" checked="checked" disabled> <input id="aba_ess_' + d.aba_id + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="' + d.aba_gross_amount + '" disabled>' + '</td>';			
			else
			ba_tbody += '<td>' + '<input id="togEss_' + d.aba_id + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + d.aba_id + ');" disabled> <input id="aba_ess_' + d.aba_id + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="" disabled>' + '</td>';
			if (d.aba_gross_base == 'non-essential')
			ba_tbody += '<td>' + '<input id="togNes_' + d.aba_id + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + d.aba_id + ')" checked="checked" disabled> <input id="aba_nes_' + d.aba_id + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="' + d.aba_gross_amount + '" disabled>' + '</td>';
			else
			ba_tbody += '<td>' + '<input id="togNes_' + d.aba_id + '" class="aba_gross_base" type="checkbox" onchange="togGbase(this,' + d.aba_id + ')" disabled> <input id="aba_nes_' + d.aba_id + '" style="width: 180px;" type="text" class="aba_gross_amount" onfocusout="asyncSqlGAmt(this);" value="" disabled>' + '</td>';
			ba_tbody += '<td id="ba_edit_save_' + d.aba_id + '" style="text-align: center;">';
			ba_tbody += '<a id="ba_edit_' + d.aba_id + '" data-toggle="tooltip" data-placement="top" title="Edit" href="javascript: eBA(' + d.aba_id + ');"><img src="images/edit.png" style="margin-right: 10px;"></a>';
			ba_tbody += '<a data-toggle="tooltip" data-placement="top" title="Delete" href="javascript: rBA(' + d.aba_id + ');"><img src="images/delete.png"></a>';
			ba_tbody += '</td>';
			ba_tbody += '</tr>';

			$(ba_tbody).appendTo('#business-activity tbody');
			$('[data-toggle=tooltip]').tooltip();
		
		});
	}
});

}

function eBA(id) {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

$('#aba_units_'+id).prop('disabled',false);

$('#togCap_'+id).prop('disabled',false);
$('#togEss_'+id).prop('disabled',false);
$('#togNes_'+id).prop('disabled',false);

if ($('#togCap_'+id).prop('checked')) $('#aba_cap_'+id).prop('disabled',false); 
if ($('#togEss_'+id).prop('checked')) $('#aba_ess_'+id).prop('disabled',false);
if ($('#togNes_'+id).prop('checked')) $('#aba_nes_'+id).prop('disabled',false);

var s = '<a href="javascript: sBA(' + id + ');" data-toggle="tooltip" data-placement="top" title="Save"><img src="images/save.png" style="margin-right: 10px;"></a>';
s += '<a href="javascript: rBA(' + id + ');" data-toggle="tooltip" data-placement="top" title="Delete"><img src="images/delete.png"></a>';
$('#ba_edit_save_'+id).html(s);
$('[data-toggle=tooltip]').tooltip();

}

function sBA(id) {

$('#aba_units_'+id).prop('disabled',true);

$('#togCap_'+id).prop('disabled',true);
$('#togEss_'+id).prop('disabled',true);
$('#togNes_'+id).prop('disabled',true);

if ($('#togCap_'+id).prop('checked')) $('#aba_cap_'+id).prop('disabled',true); 
if ($('#togEss_'+id).prop('checked')) $('#aba_ess_'+id).prop('disabled',true);
if ($('#togNes_'+id).prop('checked')) $('#aba_nes_'+id).prop('disabled',true);

var e = '<a id="ba_edit_' + id + '" href="javascript: eBA(' + id + ');" data-toggle="tooltip" data-placement="top" title="Edit"><img src="images/edit.png" style="margin-right: 10px;"></a>';
e += '<a href="javascript: rBA(' + id + ');" data-toggle="tooltip" data-placement="top" title="Delete"><img src="images/delete.png"></a>';
$('#ba_edit_save_'+id).html(e);
$('[data-toggle=tooltip]').tooltip();

}

function rBA(id) {

if (privileges('edit_application') == 0) {
	$.notify("This option is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

$('#bar_' + id).remove();
$.ajax({
	url: 'applications-ajax.php?p=rem_ba',
	type: 'post',
	data: {aba_id: id},
	success: function(data, status) {
		
	}
});

}

function togGbase(e,id) {

var k = null;
var togs = ["togCap_","togEss_","togNes_"];
var targs = ["aba_cap_","aba_ess_","aba_nes_"];

var v = e.checked;

$.each(togs, function(index, value) {
	$('#' + value+id).prop('checked',false);
});

$.each(targs, function(index, value) {
	$('#' + value+id).prop('disabled',true);
	$('#' + value+id).val('');
});

e.checked = v;

var tog = e.id.split("_");

switch (tog[0]) {

case "togCap":
	$('#aba_cap_'+id).prop('disabled',false);
	k = 0;
break;

case "togEss":
	$('#aba_ess_'+id).prop('disabled',false);
	k = 1;
break;

case "togNes":
	$('#aba_nes_'+id).prop('disabled',false);
	k = 2;
break;

}

asyncSqlGBase(e,k);

}

function asyncSqlGBase(e,k) {

var gbase = ["capitalization","essential","non-essential"];

var _id = e.id.split("_");
var id = _id[1];
var eid = e.className;
var val = gbase[k];

$.ajax({
	url: 'applications-ajax.php?p=async_add_ba',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function asyncSqlGAmt(e) {

var _id = e.id.split("_");
var id = _id[2];
var eid = e.className;
var val = $(e).val();

$.ajax({
	url: 'applications-ajax.php?p=async_add_ba',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function queryBA(id) {

if ($('#ba_edit_'+id)[0]) return;

var t = 'Query Code/Line of Business';
var c = 'form/query-ba.php';
var show = function() {

$('#qcode').keyup(function() {

asyncSearchBA(this,id);
$('#qline').val('');
	
});

$('#qline').keyup(function() {

asyncSearchBA(this,id);
$('#qcode').val('');

});
	
};
var hide = function() {

};
pModal(t,c,show,hide);

}

function asyncSearchBA(e,id) {

var rows_results = '';
var f = (e.id == 'qcode') ? 'ba_code' : 'ba_line';
var v = e.value;

$.ajax({
	url: 'applications-ajax.php?p=async_search_ba',
	type: 'post',
	data: {field: f, val: v, abaid: id},
	success: function(data, status) {
		$('#query-ba tbody').html(data);
		$('#query-ba tr').hover(function() {
			$(this).css("cursor","pointer");
		});		
	}
});

}

function clickUpdateBA(id,bcode,bline,baid,cen) {

$('#aba_code_d_'+id).val(bcode);
$('#aba_code_'+id).val(baid);
$('#aba_b_line_d_'+id).val(bline);
$('#aba_b_line_'+id).val(baid);
pModalHide();

var ce = document.getElementById('aba_code_'+id);
asyncSqlBA(ce);
var le = document.getElementById('aba_b_line_'+id);
asyncSqlBA(le);

// preciseCen(id,cen);

}

function preciseCen(id,cen) {

$('#togCap_'+id).prop('disabled',true);
$('#aba_cap_'+id).prop('disabled',true);
$('#togEss_'+id).prop('disabled',true);
$('#aba_ess_'+id).prop('disabled',true);
$('#togNes_'+id).prop('disabled',true);
$('#aba_nes_'+id).prop('disabled',true);

if (cen == "capitalization") {
$('#togCap_'+id).prop('disabled',false);
$('#togCap_'+id).prop('checked',true);
$('#aba_cap_'+id).prop('disabled',false);
}

if (cen == "essential") {
$('#togEss_'+id).prop('disabled',false);
$('#togEss_'+id).prop('checked',true);
$('#aba_ess_'+id).prop('disabled',false);
}

if (cen == "non-essential") {
$('#togNes_'+id).prop('disabled',false);
$('#togNes_'+id).prop('checked',true);
$('#aba_nes_'+id).prop('disabled',false);
}

}

function togAppForm(e) {

var v = e.checked;

if (v) {
$('#new_app').prop('disabled',false);
$('#renew_app').prop('disabled',true);
$('#additional_app').prop('disabled',true);
} else {
$('#new_app').prop('disabled',true);
$('#renew_app').prop('disabled',false);
$('#additional_app').prop('disabled',false);
}

}

function appStatus(e) {

var v = e.checked;

if (e.id == 'new_app') {
	if (v) {
		if ( ($('#renew_app').prop('checked')) || ($('#additional_app').prop('checked')) ) {
			$.notify("Please cancel this application first.", {className: "error", globalPosition: "top left"});			
			$('#new_app').prop('checked',false);
			return;
		}
	}
	if (!v) {
	$('#new_app').prop('checked',true);
	return;
	}
}

if (e.id == 'renew_app') {
	if (v) {
		if ( ($('#new_app').prop('checked')) || ($('#additional_app').prop('checked')) ) {
			$.notify("Please cancel this application first if you want to renew an application.", {className: "error", globalPosition: "top left"});
			$('#renew_app').prop('checked',false);
			return;
		}		
	}
	if (!v) {
		$('#renew_app').prop('checked',true);
		return;		
	}
}

if (e.id == 'additional_app') {
	if (v) {
		if ( ($('#new_app').prop('checked')) || ($('#renew_app').prop('checked')) ) {
			$.notify("Please cancel this application first if you want to add additional application.", {className: "error", globalPosition: "top left"});
			$('#additional_app').prop('checked',false);
			return;
		}		
	}
	if (!v) {
		$('#additional_app').prop('checked',true);
		return;		
	}
}

$('#new_app').prop('checked',false);
$('#renew_app').prop('checked',false);
$('#additional_app').prop('checked',false);

e.checked = v;

if ((e.id == 'renew_app') || (e.id == 'additional_app')) if (v == true) renew_additional(e.id);

if (v == true) chkboxAsyncSql('application_form',e.id);
else chkboxAsyncSql('application_form','');

// generate application no
if ((e.id == 'new_app') || (e.id == 'additional_app')) {
	if (v == true) {
		genAppNo(v,e.id);
		genRefNo(v,e.id);
	}
}

// if new application set mode of payment to pay_quarterly
$('#pay_quarterly').prop('checked',false);
if (e.id == 'new_app') {
	if (v == true) {
	$('#pay_quarterly').prop('checked',true);
	}
	togPay(document.getElementById('pay_quarterly'));
}

// if date is past March 31 set payment mode to pay_bi_annually
// if quarterCheck()
if (quarterCheck()) {
	if (v == true) {
	$('#pay_bi_annually').prop('checked',true);
	}
	togPay(document.getElementById('pay_bi_annually'));
}

// if date is past June 31 set payment mode to pay_quarterly
// if biAnnualCheck()
if (biAnnualCheck()) {
	if (v == true) {
	$('#pay_annually').prop('checked',true);
	}
	togPay(document.getElementById('pay_annually'));
}

}

function togAmendment(e) {

var v = e.checked;

$('#single_partnership').prop('checked',false);
$('#single_corporation').prop('checked',false);
$('#partnership_single').prop('checked',false);
$('#partnership_corporation').prop('checked',false);
$('#corporation_single').prop('checked',false);
$('#corporation_partnership').prop('checked',false);

e.checked = v;

if (v == true) chkboxAsyncSql('application_amendment',e.id);
else chkboxAsyncSql('application_amendment','');

}

function togPay(e) {

var v = e.checked;

$('#pay_annually').prop('checked',false);
$('#pay_bi_annually').prop('checked',false);
$('#pay_quarterly').prop('checked',false);

e.checked = v;

if (v == true) chkboxAsyncSql('application_mode_of_payment',e.id);
else chkboxAsyncSql('application_mode_of_payment','');

}

function organizationType(e) {

var v = e.checked;

$('#single_organization').prop('checked',false);
$('#partnership_organization').prop('checked',false);
$('#corporation_organization').prop('checked',false);
$('#cooperative_organization').prop('checked',false);

e.checked = v;

if (v == true) chkboxAsyncSql('application_organization_type',e.id);
else chkboxAsyncSql('application_organization_type','');

}

function renew_additional(src) {

var t = (src == 'renew_app') ? 'Renew Application' : 'Additional Application';
var c = 'form/applicant-profile.php';
var show = function() {
	// fillApplicantInfo(src);
	
	$('#application_ref_no').keyup(function() {

	asyncSearchAP(this);
	$('#applicant_fullname').val('');
		
	});

	$('#applicant_fullname').keyup(function() {

	asyncSearchAP(this);
	$('#application_ref_no').val('');

	});	
	
	// populateTypehead("applicant_fullname","concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)","applications","application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename");
	
};
var hide = function() {

if ($('#application_id_ref_no').val() == '') {
	$('#' + src).prop('checked',false);
	chkboxAsyncSql('application_form','');
	genAppNo(false);
	genRefNo(false);
	checkAppStatus();
}	

}
pModalL(t,c,show,hide);

}

function asyncSearchAP(e) {

var rows_results = '';
var f = (e.id == 'application_ref_no') ? 'application_reference_no' : 'applicant_fullname';
var v = e.value;

$.ajax({
	url: 'applications-ajax.php?p=async_search_ap',
	type: 'post',
	data: {field: f, val: v},
	success: function(data, status) {
		$('#query-applicant tbody').html(data);
		$('#query-applicant tr').hover(function() {
			$(this).css("cursor","pointer");
		});		
	}
});

}

function clickFillPA(id,refno) {

$('#application_id_ref_no').val(id);
pModalLHide();
fillAppForm(id,refno);

}

function togTaxIncentive(e) {

if (e.id == 'tax_incentive_yes') $('#application_entity').prop('disabled',false);
if (e.id == 'tax_incentive_no') {
	$('#application_entity').val('');
	$('#application_entity').prop('disabled',true);
	asyncSql(document.getElementById('application_entity'));
}

}

function togBusinessPlace(e) {

var elem = ["application_lessor_lastname","application_lessor_firstname","application_lessor_middlename","application_monthly_rental","application_lessor_address_no","application_lessor_address_street","application_lessor_address_brgy","application_lessor_address_subd","application_lessor_address_mun_city","application_lessor_address_province","application_lessor_address_tel_no","application_lessor_address_email"];

if (e.id == 'rented_yes') {
	
	$.each(elem, function(index, value) {
		
		$('#'+value).prop('disabled',false);
		chkboxAsyncSql('application_business_rented',e.id);		
		
	});
	
}
 
if (e.id == 'rented_no') {

	$.each(elem, function(index, value) {
		
		$('#'+value).prop('disabled',true);
		
			$('#'+value).val('');
		
		asyncSql(document.getElementById(value));
		chkboxAsyncSql('application_business_rented',e.id);		
		
	});

}

}

function selGender(e) {

asyncSql(e);

}

function previewForm() {

var t = 'Preview Application Form';
var c = 'form/print-application-form.php';

var show = function() {

};

var hide = function() {

}
pModal(t,c,show,hide);

}

function printAFFront() {

var id = $('#application_id').val();

window.open('reports/application-form-front.php?app_id=' + id);

}

function printAFBack() {

var id = $('#application_id').val();

window.open('reports/application-form-back.php?app_id=' + id);

}

function checkStatus(id) {

var t = 'Application Status';
var c = 'form/application-status.php?application_id=' + id;
var show = function() {
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function browseApplications() {

if (disModuleMainB()) {

var f = function() { pModalHide(); };
notification('Cannot search applications while on encoding/editing process.',f);
return;

}

var t = 'Search Application';
var c = 'form/search-application.php';
var show = function() {

$('#application_date_dt').datetimepicker({pickTime: false});
$('#frmSearchApplication button').click(function() { filterApplication(); });
populateTypehead("applicant_fullname","concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)","applications","application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename");	

clearFilterCache();

$('#application_date_dt').change(function() {
	$('#h_application_date').val($('#application_date').val());
});
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function mirrorFilter(e) {

$('#h_' + e.id).val(e.value);

}

function clearFilterCache() {

$('#h_application_no').val('');
$('#h_application_reference_no').val('');
$('#h_applicant_fullname').val('');
$('#h_application_form').val('all');
$('#h_application_organization_type').val('all');
$('#h_application_mode_of_payment').val('all');
$('#h_application_date').val('');
$('#h_application_month').val('0');
$('#h_application_year').val('');

}

function filterApplication() {

var application_no = $.trim($('#application_no').val());
var application_reference_no = $.trim($('#application_reference_no').val());
var applicant_fullname = $.trim($('#applicant_fullname').val());
var application_form = $.trim($('#application_form').val());
var application_organization_type = $.trim($('#application_organization_type').val());
var application_mode_of_payment = $.trim($('#application_mode_of_payment').val());
var application_date = $.trim($('#application_date').val());
var application_month = $.trim($('#application_month').val());
var application_year = $.trim($('#application_year').val());

var par = '&application_no=' + application_no + '&application_reference_no=' + application_reference_no + '&applicant_fullname=' + applicant_fullname + '&application_form=' + application_form + '&application_organization_type=' + application_organization_type + '&application_mode_of_payment=' + application_mode_of_payment + '&application_date=' + application_date + '&application_month=' + application_month + '&application_year=' + application_year;

content(0,par);

pModalHide();

}

function rfilterApplication() {

var application_no = $.trim($('#h_application_no').val());
var application_reference_no = $.trim($('#h_application_reference_no').val());
var applicant_fullname = $.trim($('#h_applicant_fullname').val());
var application_form = $.trim($('#h_application_form').val());
var application_organization_type = $.trim($('#h_application_organization_type').val());
var application_mode_of_payment = $.trim($('#h_application_mode_of_payment').val());
var application_date = $.trim($('#h_application_date').val());
var application_month = $.trim($('#h_application_month').val());
var application_year = $.trim($('#h_application_year').val());

var par = '&application_no=' + application_no + '&application_reference_no=' + application_reference_no + '&applicant_fullname=' + applicant_fullname + '&application_form=' + application_form + '&application_organization_type=' + application_organization_type + '&application_mode_of_payment=' + application_mode_of_payment + '&application_date=' + application_date + '&application_month=' + application_month + '&application_year=' + application_year;

return par;

}

function closePersonalInfo() {

$(document).on("keydown", null);

window.onbeforeunload = null;

verifyPersonalInfo('close');

if (!personal_info_verified) {
	$.notify("Please edit this application and complete filling up the required information before closing.", {className: "error", globalPosition: "top left"});
	return;
}

	$('#application_id').val(0);
	// content(0);
	
	location.reload();

}

function refreshApplications() {

content(0);

}

function printBlanks() {

var t = 'Preview Blank Forms';
var c = 'form/print-blank-application-form.php';

var show = function() {

};

var hide = function() {

}
pModal(t,c,show,hide);

}

function printAFFrontBlank() {

window.open('reports/application-form-front-blank.php');

}

function printAFBackBlank() {

window.open('reports/application-form-back-blank.php');

}

function genAppNo() {

var id = $('#application_id').val();

var args = genAppNo.arguments;
var v = args[0];
var stat = '';
if (args.length > 1) stat = args[1];

if (v) {
	$.ajax({
		url: 'applications-ajax.php?p=gen_app_no',
		type: 'post',	
		data: {application_id: id, pstat: stat},
		success: function(data, status) {
			$('#application_no').val(data); // console.log(data);
		}
	});
} else {
	$.ajax({
		url: 'applications-ajax.php?p=reset_app_no',
		type: 'post',	
		data: {application_id: id},
		success: function(data, status) {
			$('#application_no').val('');
		}
	});
}

}

function genRefNo() {

var id = $('#application_id').val();
 
var args = genRefNo.arguments;
var v = args[0];
var stat = '';
if (args.length > 1) stat = args[1];

if (v) {
	$.ajax({
		url: 'applications-ajax.php?p=gen_ref_no',
		type: 'post',	
		data: {application_id: id, pstat: stat},
		success: function(data, status) {
			$('#application_reference_no').val(data);
		}
	});
} else {
	$.ajax({
		url: 'applications-ajax.php?p=reset_ref_no',
		type: 'post',	
		data: {application_id: id},
		success: function(data, status) {
			$('#application_reference_no').val('');
		}
	});
}

}

function fillAppForm(id,refno) {

$.ajax({
	url: 'applications-ajax.php?p=view',
	type: 'post',
	dataType: 'json',
	data: {pid: id},
	success: function(data, status) {

		$.each(data, function(key, value) {
			if (key == 'application_date') return;
			if (key == 'application_no') return;
			if (key == 'application_reference_no') return;
			
			/* take note of application_id for penalty computation - for renewal only */
			if (key == 'application_id') $('#application_fid').val(value);
			
			if (key != 'application_id') {
			
				$('#' + key).val(value);
				var t = $('#' + key).attr('type');

				if (t == 'text') {

					asyncSql(document.getElementById(key));

				}
				
			}
			
			/* take note of applcation_id for penalty computation - for renewal only */
			if (key == 'application_id') asyncSql(document.getElementById('application_fid'));
			
			// if (key == 'application_form') if (value) $('#' + value).prop('checked',true);
			// if (key == 'application_amendment') if (value) $('#' + value).prop('checked',true);
			if (key == 'application_mode_of_payment') {
				if (value) if ( ($('#new_app').prop('checked')) || ($('#renew_app').prop('checked')) || ($('#additional_app').prop('checked')) ) $('#' + value).prop('checked',true);
			}
			if (key == 'application_organization_type') {
				if (value) {
					$('#' + value).prop('checked',true);
					organizationType(document.getElementById(value));
				}
			}
			if (key == 'application_entity') {
				if (value) $('#tax_incentive_yes').prop('checked',true);
				else $('#tax_incentive_no').prop('checked',true);
			}
			if (key == 'application_business_rented') {
				if (value) {
				$('#' + value).prop('checked',true);
				togBusinessPlace(document.getElementById(value));
				}
			}
			if (key == 'application_taxpayer_gender') $('#application_taxpayer_gender').val(value);	
			
		});
		// fetchBusinessActivity(id);
		
		refAppNoRenewal(refno);
		
	}
});

}

function checkBA() {

var id = $('#application_id').val();

var chk = false;

$.ajax({
	url: 'applications-ajax.php?p=check_ba',
	type: 'post',
	async: false,
	data: {application_id: id},
	success: function(data, status) {
		if (data) chk = true;
	}
});

return chk;

}

function checkAssessment() {

var id = $('#application_id').val();

var chk = false;

$.ajax({
	url: 'applications-ajax.php?p=check_assessment',
	type: 'post',
	async: false,
	data: {application_id: id},
	success: function(data, status) {
		if (data) chk = true;
	}
});

return chk;

}

function generateReports() {

if (disModuleMainB()) {

var f = function() { pModalHide(); };
notification('Cannot generate reports while on encoding/editing process.',f);
return;

}

var t = 'Business Licenses Reports';
var c = 'form/search-application.php';
var show = function() {

$('#application_date_dt').datetimepicker({pickTime: false});
$('#frmSearchApplication button').click(function() { licensesReports(); });
populateTypehead("applicant_fullname","concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)","applications","application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename");	

// clearFilterCache();

/* $('#application_date_dt').change(function() {
	$('#h_application_date').val($('#application_date').val());
}); */

$('#search-application-button').html('Generate');
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function licensesReports() {

var application_no = $.trim($('#application_no').val());
var application_reference_no = $.trim($('#application_reference_no').val());
var applicant_fullname = $.trim($('#applicant_fullname').val());
var application_form = $.trim($('#application_form').val());
var application_organization_type = $.trim($('#application_organization_type').val());
var application_mode_of_payment = $.trim($('#application_mode_of_payment').val());
var application_date = $.trim($('#application_date').val());
var application_month = $.trim($('#application_month').val());
var application_year = $.trim($('#application_year').val());

var par = '?application_no=' + application_no + '&application_reference_no=' + application_reference_no + '&applicant_fullname=' + applicant_fullname + '&application_form=' + application_form + '&application_organization_type=' + application_organization_type + '&application_mode_of_payment=' + application_mode_of_payment + '&application_date=' + application_date + '&application_month=' + application_month + '&application_year=' + application_year;

window.open('generate-reports.php' + par);

}

function quarterCheck() {

var chk = 0;

$.ajax({
	url: 'applications-ajax.php?p=quarter_check',
	type: 'post',
	async: false,
	success: function(data, status) {
		chk = data;
	}
});

return chk;

}

function biAnnualCheck() {

var chk = 0;

$.ajax({
	url: 'applications-ajax.php?p=bi_annual_check',
	type: 'post',
	async: false,
	success: function(data, status) {
		chk = data;
	}
});

return chk;

}

/*
* On renewal/additional dialog box - if close remove application mode of payment
*/
function checkAppStatus() {
	
var oneIsChecked = true;	
setTimeout((function(){
$('input', $('#notify-nra')).each(function(ind, obj) {
	if ($(this).prop('checked') == false) oneIsChecked = false;		
});	
})(),250);

if (!oneIsChecked) {
	$('input', $('#notify-mop')).each(function(ind, obj) {
		$(this).prop('checked',false);
	});
	chkboxAsyncSql('application_mode_of_payment','');	
}

}

function refAppNoRenewal(refno) {	

var chk = $('#renew_app').prop('checked');
var aid = $('#application_id').val();

if (!chk) return;

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });
$.ajax({
	url: 'applications-ajax.php?p=ref_appno_renewal',
	type: 'post',
	dataType: 'json',
	data: {prefno: refno, app_id: aid},
	success: function(data, status) {
		$.each(data.refappno[0], function(key, value) {
			setTimeout(function() { if ($('#' + key)[0]) $('#'+key).val(value); },1000);
			// if ($('#' + key)[0]) $('#'+key).val(value);
		});
		$.unblockUI();		
	}
});
	
}

function businessStat() {

if (!$('#frmContent')[0]) {
	var f = function() {};
	notification('You cannot use this feature while encoding/updating an application.',f);
	return;	
}

var id = 0;

if (count_checks('frmContent') == 0) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

if (count_checks('frmContent') > 1) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select only one.',f);
	return;
}

id = getCheckedId('frmContent');

var t = 'Business Status';
var c = 'form/business-status.php?application_id=' + id;
var show = function() {
	$('#business_status').change(function() {
		asyncUpdateField(id);
	});
	
	$.ajax({
		url: 'applications-ajax.php?p=get_business_status&application_id=' + id,
		type: 'post',
		success: function(data, status) {
			// console.log(data);
			$('#business_status').val(data);
		}
	});
};
var hide = function() {
	uncheckSelected(id);
	refreshApplications();
}
pModal(t,c,show,hide);

}