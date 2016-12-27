cur_page = 1;
total_page = 0;

$(function() {

	$('#search-button').click(function() { filterDept(); });
	content(0);	
	
});

function addDept() {

if (privileges('add_department') == 0) {
	$.notify("Add department is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

if ($('#frmDepartments')[0]) return;

var c = 'form/department.php?src=1';

$('#module-content').load(c, function() {
	$('#frmDepartments').validator();
	
	populateTypehead("department_head","concat(account_lname, ', ', account_fname, ' ', account_mname)","accounts","account_lname, account_fname, account_mname");
});

}

function editDept() {

if (privileges('edit_department') == 0) {
	$.notify("Edit department is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

if ( (count_checks('frmContent') == 0) || (count_checks('frmContent') > 1) ) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

var c = 'form/department.php?src=2&deptid=' + id;
$('#module-content').load(c, function() {
	$('#frmDepartments').validator();
	populateTypehead("department_head","concat(account_lname, ', ', account_fname, ' ', account_mname)","accounts","account_lname, account_fname, account_mname");
	editPrivilege(id);
});

}

function editPrivilege(did) {

$.ajax({
	url: 'privileges.php?p=edit',
	type: 'post',	
	dataType: 'json',
	data: {privilege_department: did},
	success: function(data, status) {
		$.each(data, function(key, value) {
			if ($('#' + key)[0]) $('#' + key).prop('checked',(value == 1) ? true : false);
		});
	}
});

}

function cancelDeptForm() {

content(0);

}

function delDept() {

if (privileges('delete_department') == 0) {
	$.notify("Delete department is restricted.", {className: "error", globalPosition: "top left"});
	return;
}

if (count_checks('frmContent') == 0) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

unbindConfirmYes();
var f = function() { pdelDept(id); };	
confirmation('Are you sure you want to delete this department(s)?',f,function() { uncheckMulti('frmContent'); });

}

function pdelDept(id) {

$.ajax({
	url: 'departments-ajax.php?p=delete',
	type: 'post',
	data: {department_id: id},
	success: function(data, status) {
		notification(data,function() { content(0); });		
	}
});

}

function deptForm(src,id) {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });

var department = {
	department_name: $('#department_name').val(),
	department_head: $('#department_head').val(),
	department_note: $('#department_note').val()
};

switch (src) {

case 1:
$.ajax({
	url: 'departments-ajax.php?p=add',
	type: 'post',
	data: department,
	success: function(data, status) {
		addUpdatePrivileges(src,data);
	}
});
break;

case 2:
$.ajax({
	url: 'departments-ajax.php?p=update&department_id=' + id,
	type: 'post',
	data: department,
	success: function(data, status) {
		addUpdatePrivileges(src,data);
	}
});
break;

}

}

function addUpdatePrivileges(src,did) {

var privileges = {
	privilege_department: did,
	add_application: ($('#add_application').prop('checked')) ? 1 : 0,
	view_application: ($('#view_application').prop('checked')) ? 1 : 0,
	edit_application: ($('#edit_application').prop('checked')) ? 1 : 0,
	delete_application: ($('#delete_application').prop('checked')) ? 1 : 0,
	permits_module: ($('#permits_module').prop('checked')) ? 1 : 0,	
	departments_module: ($('#departments_module').prop('checked')) ? 1 : 0,	
	add_department: ($('#add_department').prop('checked')) ? 1 : 0,
	edit_department: ($('#edit_department').prop('checked')) ? 1 : 0,
	delete_department: ($('#delete_department').prop('checked')) ? 1 : 0,
	accounts_module: ($('#accounts_module').prop('checked')) ? 1 : 0,
	management_module: ($('#management_module').prop('checked')) ? 1 : 0
}

switch (src) {

case 1:
$.ajax({
	url: 'privileges.php?p=add',
	type: 'post',
	data: privileges,
	success: function(data, status) {
		notification(data,function() {
			$.unblockUI();
			content(0);
		});		
	}
});
break;

case 2:
$.ajax({
	url: 'privileges.php?p=update&privilege_department=' + did,
	type: 'post',
	data: privileges,
	success: function(data, status) {
		notification(data,function() {
			$.unblockUI();
			content(0);
		});		
	}
});
break;

}

}

function editPrivileges(did) {


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
	url: 'departments-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#module-content').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function filterDept() {

var fdeptname = $.trim($('#fdeptname').val());

var par = '&fdeptname=' + fdeptname;

content(0,par);

}

function rfilterDept() {

var fdeptname = $.trim($('#fdeptname').val());

var par = '&fdeptname=' + fdeptname;

return par;

}