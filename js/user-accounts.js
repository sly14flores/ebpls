cur_page = 1;
total_page = 0;

$(function() {

	$('#search-button').click(function() { filterfilterUserAccounts(); });
	// populateTypehead("ffullname","concat(account_lname, ', ', account_fname, ' ', account_mname)","accounts","account_lname, account_fname, account_mname");	
	content(0);	
	
});

function addUser() {

if ($('#frmUserAccounts')[0]) return;

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#module-content').html(loading);

var c = 'form/user-account.php?src=1';
$('#module-content').load(c, function() {
	populateSelect('departments','department_id','department_name','account_department',0);
	$('#frmUserAccounts').validator();
	$('#account_password').showPassword();
	$('#account_username').change(function() { verUname(); });
});

}

function editUser() {

if ( (count_checks('frmContent') == 0) || (count_checks('frmContent') > 1) ) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

var t = 'Update User Account Info';
var c = 'form/user-account.php?uaid=' + id + '&src=2';
$('#module-content').load(c, function() {
	populateSelect('departments','department_id','department_name','account_department',deptID('account_department','accounts','account_id',id));
	$('#frmUserAccounts').validator();
	$('#account_password').showPassword();
	popPword(id);
	$('#account_username').change(function() { verUname(); });
});

}

function delUser() {

if (count_checks('frmContent') == 0) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

unbindConfirmYes();
var f = function() { pdelUserAccount(id); };	
confirmation('Are you sure you want to delete this user account(s)?',f,function() { uncheckMulti('frmContent'); });

}

function pdelUserAccount(id) {

$.ajax({
	url: 'user-accounts-ajax.php?p=delete',
	type: 'post',
	data: {account_id: id},
	success: function(data, status) {
		notification(data,function() { content(0); });		
	}
});

}

function userAccountForm(src,id) {

var uname_exists = $('#username-exists').val();
if (parseInt(uname_exists) == 1) return;

var adept = $('#account_department').val();
var alname = $('#account_lname').val();
var afname = $('#account_fname').val();
var amname = $('#account_mname').val();
var aemail = $('#account_email').val();
var acontact = $('#account_contact').val();
var auname = $('#account_username').val();
var apword = $('#account_password').val();
var atitle = $('#account_title_position').val();

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

switch (src) {

case 1:
$('#module-content').html(loading);
$.ajax({
	url: 'user-accounts-ajax.php?p=add',
	type: 'post',
	data: {account_department: adept, account_lname: alname, account_fname: afname, account_mname: amname, account_email: aemail, account_contact: acontact, account_username: auname, account_password: apword, account_title_position: atitle},
	success: function(data, status) {
		notification(data,function() {
			content(0);
		});		
	}
});
break;

case 2:
$('#module-content').html(loading);
$.ajax({
	url: 'user-accounts-ajax.php?p=update&account_id=' + id,
	type: 'post',
	data: {account_department: adept, account_lname: alname, account_fname: afname, account_mname: amname, account_email: aemail, account_contact: acontact, account_username: auname, account_password: apword, account_title_position: atitle},
	success: function(data, status) {
		notification(data,function() { content(0); });		
	}
});
break;

}

}

function cancelUserForm() {

content(0);

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
	url: 'user-accounts-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#module-content').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function filterfilterUserAccounts() {

var ffullname = $.trim($('#ffullname').val());

var par = '&ffullname=' + ffullname;

content(0,par);

}

function rfilterUserAccounts() {

var ffullname = $.trim($('#ffullname').val());

var par = '&ffullname=' + ffullname;

return par;

}

function popPword(id) {

$.ajax({
	url: 'user-accounts-ajax.php?p=pop_pword',
	type: 'post',
	data: {puaid: id},
	success: function(data, status) {
		$('#account_password').val(data);
	}
});

}

function verUname() {

var uname = $('#account_username').val();
if (uname == '') return;

$.ajax({
	url: 'user-accounts-ajax.php?p=verify_uname',
	type: 'post',
	data: {puname: uname},
	success: function(data, status) {
		if (parseInt(data) == 1) {
			$('#account_username + span').html('<span style="color: #A94442;">Username is already taken.</span>');
			$('#account_username').css('border-color','rgb(169, 68, 66)');
			$('#username-exists').val(1);
		} else {
			$('#account_username + span').html('');
			$('#account_username').css('border-color','');
			$('#username-exists').val(0);
		}
	}
});

}