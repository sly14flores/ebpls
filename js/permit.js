cur_page = 1;
total_page = 0;

$(function() {

	content(0);

});

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
	url: 'permits-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#module-content').html(sdata[0]);
		total_page = parseInt(sdata[1]);
		$('[data-toggle=tooltip]').tooltip();		
	}
});

}

function browsePermits() {

var t = 'Search Permit';
var c = 'form/search-application.php';
var show = function() {

$('#application_date_dt').datetimepicker({pickTime: false});
$('#frmSearchApplication button').click(function() { filterPermit(); });
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

function filterPermit() {

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

function rfilterPermits() {

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

function refreshPermits() {

content(0);

}

function printBusinessPermit(id) {

window.open('reports/business-permit.php?permit_id=' + id);

}

function editBusinessPermit(id) {

var t = 'Edit Business Permit Info';
var c = 'form/edit-permit.php?permit_id=' + id;
var show = function() {

$('#permit_or_date_dt').datetimepicker({pickTime: false});
$('#permit_sss_date_dt').datetimepicker({pickTime: false});
$('#frmBusinessPermit button').click(function() { businessPermitForm(id); });
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function businessPermitForm(id) {

var update = {
	permit_or_no: $('#permit_or_no').val(),
	permit_or_date: $('#permit_or_date').val(),
	permit_sss_clearance: $('#permit_sss_clearance').val(),
	permit_sss_date: $('#permit_sss_date').val()
};

$.ajax({	
	url: 'permits-ajax.php?p=update&permit_id=' + id,
	type: 'post',
	data: update,
	success: function(data, status) {
		pModalHide();
		var f = null;
		notification(data,f);
	}
});

}

function generatePermits() {

var t = 'Generate Business Permit';
var c = 'form/generate-permit.php';
var show = function() {

$('#qappno').keyup(function() {

asyncSearchAppNo(this);
	
});
	
};
var hide = function() {

};
pModal(t,c,show,hide);

}

function asyncSearchAppNo(e) {

var rows_results = '';
var f = 'application_no';
var v = e.value;

$.ajax({
	url: 'permits-ajax.php?p=async_search_appno',
	type: 'post',
	data: {field: f, val: v},
	success: function(data, status) {
		$('#generate-permit tbody').html(data);
		$('#generate-permit tr').hover(function() {
			$(this).css("cursor","pointer");
		});		
	}
});

}

function clickGenPermit(id) {

pModalHide();
generateBusinessPermit(id);

}

function generateBusinessPermit(id) {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });

$.ajax({
	url: 'permits-ajax.php?p=generate_business_permit',
	type: 'post',
	data: {application_id: id},
	success: function(data, status) {
		$.unblockUI();
		if (isNaN(data)) {
			notification(data,function() { });		
		} else {
			content(0);
			editBusinessPermit(data);
		}
	}
});

}

function deletePermit(id) {

if (count_checks('frmContent') == 0) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

unbindConfirmYes();
var f = function() { pdelPermit(id); };	
confirmation('Are you sure you want to delete this busines permit(s)?',f,function() { uncheckMulti('frmContent'); });

}

function pdelPermit(id) {

$.ajax({
	url: 'permits-ajax.php?p=delete',
	type: 'post',
	data: {permit_id: id},
	success: function(data, status) {
		content(0);
		notification(data,function() { });		
	}
});

}