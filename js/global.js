$(function() {

	liveNotifications();
	var iniNotification = setInterval(liveNotifications,6000);

});

function popNotify() {

$.ajax({
	url: 'notifications.php?p=count_notifications',
	type: 'post',
	success: function(data, status) {
		if (data != '') {
			var popNotify = $.notify('You have ' + data + ' notifications.  Please click the bell icon on the upper right to check them', {className: "info", globalPosition: "bottom left", clickToHide: true});			
		}
	}
});

}

function liveNotifications() {

var nn =  '<li>';
	nn += '<a href="#">';
	nn += '<div>';
	nn += '<i class="fa fa-info-circle fa-fw"></i> No notifications';
	nn += '<span class="pull-right text-muted small"></span>';
	nn += '</div>';
	nn += '</a>';
	nn += '</li>';

$.ajax({
	url: 'notifications.php?p=fetch_notifications_applications',
	type: 'post',
	success: function(data, status) {
		if (data != '') {
			popNotify();
			$('#notification-bell').addClass('notify-color');
			$('#notification-caret').addClass('notify-color');
			$('#notifications-container').html(data);
		} else {
			$('#notification-bell').removeClass('notify-color');
			$('#notification-caret').removeClass('notify-color');
			$('#notifications-container').html(nn);			
		}
	}
});

}

var verification_enabled = true;

function populateSelect(tab,val,opt,d,s) { // table, field value, field option, dom, selected

$.ajax({
	url: 'ajax-global.php?p=populate_select',
	type: 'post',
	data: {table: tab, value: val, option: opt, sel: s},
	success: function(data, status) {
		$('#' + d).html(data);
	}
});

}

function getPK(pk,tab,c,s) {

var pk = 0;

$.ajax({
	url: 'ajax-global.php?p=get_primary_key',
	type: 'post',
	async: false,
	data: {primary_key: pk, table: tab, criteria: c, str: s},
	success: function(data, status) {
		pk = data;
	}
});

return pk;

}

function deptID(fk,tab,pk,id) {

var dept_id = 0;

$.ajax({
	url: 'ajax-global.php?p=get_department_id',
	type: 'post',
	async: false,
	data: {foreign_key: fk, table: tab, primary_key: pk, get_id: id},
	success: function(data, status) {
		dept_id = data;
	}
});

return dept_id;

}

function appID(pk,tab,c,s) {

var app_id = 0;

$.ajax({
	url: 'ajax-global.php?p=get_application_id',
	type: 'post',
	async: false,
	data: {primary_key: pk, table: tab, criteria: c, str: s},
	success: function(data, status) {
		app_id = data;
	}
});

return app_id;

}

function populateTypehead(e,sel,tab,ord) { // element, selects, table, order

var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
	var matches, substringRegex;
 
	// an array that will be populated with substring matches
	matches = [];
 
	// regex used to determine if a string contains the substring `q`
	substrRegex = new RegExp(q, 'i');
 
	// iterate through the pool of strings and for any string that
	// contains the substring `q`, add it to the `matches` array
	$.each(strs, function(i, str) {
	  if (substrRegex.test(str)) {
		// the typeahead jQuery plugin expects suggestions to a
		// JavaScript object, refer to typeahead docs for more info
		matches.push({ value: str });
	  }
	});
 
	cb(matches);
  };
};

var autocomplete;

$.ajax({
	url: 'ajax-global.php?p=typeahead',
	type: 'post',
	async: false,
	data: {selects: sel, table: tab, order: ord},
	success: function(data, status) { autocomplete = eval(data); }
});

$('#' + e).typeahead({			
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'kwords',
  displayKey: 'value',
  source: substringMatcher(autocomplete)
}).on('typeahead:selected', function() { });

}

function get_aid() {

var aid = 0;

$.ajax({
	url: 'user-account.php',
	type: 'post',
	async: false,
	success: function(data, status) {
		aid = data;
	}
});

return aid;

}

function pModal(t,c,s,h) {

$('#parentModal').modal('show');
$('#parentModal .modal-title').html(t);
$('#parentModal .modal-body').load(c, function() { s(); });
$('#parentModal').on('hidden.bs.modal', function (e) {
	h();
});

}

function pModalHide() {

$('#parentModal').modal('hide');

}

function pModalL(t,c,s,h) {

$('#parentModalL').modal('show');
$('#parentModalL .modal-title').html(t);
$('#parentModalL .modal-body').load(c, function() { s(); });
$('#parentModalL').on('hidden.bs.modal', function (e) {
	h();
});

}

function pModalLHide() {

$('#parentModalL').modal('hide');

}

function confirmation(c,y,n) {

$('#btnYes').on('click', function () {
	y();
	$('#modal-confirm').modal('hide');
});
$('#modal-confirm').modal('show');
$('#modal-confirm .modal-body').html(c);
$('#modal-confirm').on('hidden.bs.modal', function (e) {
	n();
});

}

function unbindConfirmYes() {
	$('#btnYes').unbind('click');
}

function notification(c,f) {

$('#modal-notify').modal('show');
$('#modal-notify .modal-body').html(c);
$('#modal-notify').on('hidden.bs.modal', function (e) {
	f();
});

}

function logout() {

unbindConfirmYes();
var f = function() { logout_confirmed(); };	
confirmation('Are you sure you want to logout?',f);
clearInterval(iniNotification);

}

function logout_confirmed() {

window.location.href = 'logout.php';

}

function Check_all(theForm, theParentCheck){
	elem = theForm.elements;
		
	for(i=0; i<elem.length; ++i){
		if(elem[i].type == "checkbox"){
			elem[i].checked	= theParentCheck.checked;
		}
	}
}

function Uncheck_Parent(ParentCheckboxName, me){
	var theParentCheckbox = document.getElementById(ParentCheckboxName);
	
	if(!me.checked && theParentCheckbox.checked){
		theParentCheckbox.checked = false;		
	}
}

function uncheckSelected(id) {

	$('#chk_' + id).prop('checked',false);

}

function uncheckMulti(frm) {

	var f = $('#' + frm)[0];
	var e = f.elements;

	for (i=0; i<e.length; ++i) {
		if (e[i].type == "checkbox") {
			if (e[i].checked) e[i].checked = false;
		}
	}

}

function getCheckedId(theFormName){
var theForm		= document.getElementById(theFormName);
var	elem		= theForm.elements;
var tmp_arr, rec_id;

	rec_id	= "";

	for(i=0; i<elem.length; ++i){
		if(elem[i].type == "checkbox"){
			if (elem[i].checked && elem[i].name != 'chk_checkall'){
				tmp_arr	= elem[i].name.split('_');
				rec_id	+= tmp_arr[1] + ',';
			}
		}
	}

	if (rec_id.length > 0){
		rec_id = rec_id.substr(0, rec_id.length-1);
	}
	return rec_id;
}

function count_checks(theFormName){
var theForm		= document.getElementById(theFormName);
var	elem		= theForm.elements;
var int_count	= 0;
		
	for(i=0; i<elem.length; ++i){
		if(elem[i].type == "checkbox"){
			if (elem[i].checked  && elem[i].name != 'chk_checkall') ++int_count;
		}
	}
	
	return int_count;
}

function privileges(p) {

var chk = 0;
$.ajax({
	url: 'privileges.php?p=check',
	type: 'post',	
	data: {privilege: p},
	async: false,
	success: function(data, status) {
		chk = data;
	}
});

return chk;

}

function user_account(m) {

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

function disableF5(e) {

	if (e.which == 116 || e.keyCode == 116) e.preventDefault();

}

function verUnameG() {

$('#account_username + span').html('');
$('#account_username').css('border-color','');
$('#username-exists').val(0);

var uname = $('#account_username').val();
var huname = $('#h_account_username').val();
if (uname == '') return;
if (uname == huname) return;

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

function popPwordG() {

$.ajax({
	url: 'user-accounts-ajax.php?p=pop_pword',
	type: 'post',
	data: {puaid: 0},
	success: function(data, status) {
		$('#account_password').val(data);
	}
});

}

function userProfileC() {

var t = 'User Account Verification';
var c = 'form/user-profile-verify.php';
var show = function() {
	$('#frmUserAccountV button').click(function() {
		var password_verification = $('#password_verification').val();
		$.ajax({
			url: 'user-accounts-ajax.php?p=verify_user_profile',
			type: 'post',
			data: {account_password: password_verification},
			success: function(data, status) {
				if (parseInt(data) == 1) {			
					userProfile();
				} else {
					pModalHide();
					var f = function() { };
					notification('Invalid password, cannot proceed.',f);
				}
			}
		});		
	});	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function userProfile() {

var t = 'User Profile';
var c = 'form/user-profile.php';
var show = function() {
	$('#frmUserProfile button').click(function() { userProfileForm(); pModalHide(); });
	$('#frmUserProfile').validator();
	$('#account_password').showPassword();
	$('#account_username').change(function() { verUnameG(); });
	popPwordG();
	
	// signature
	$('#account_signature').signature();
	$('#clear_sig').click(function() {
		$('#account_signature').signature('clear');
	});
	
	popSignature();	
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function userProfileForm() {

var uname_exists = $('#username-exists').val();
if (parseInt(uname_exists) == 1) return;

var user_account = {
	account_lname: $('#account_lname').val(),
	account_fname: $('#account_fname').val(),
	account_mname: $('#account_mname').val(),
	account_username: $('#account_username').val(),
	account_password: $('#account_password').val(),
	account_email: $('#account_email').val(),
	account_contact: $('#account_contact').val(),
	account_title_position: $('#account_title_position').val(),
	account_signature: $('#account_signature').signature('toJSON')
};

$.ajax({
	url: 'user-accounts-ajax.php?p=update_user_profile',
	type: 'post',
	data: user_account,
	success: function(data, status) {
		pModalHide();
	}
});

}

function popSignature() {

$.ajax({
	url: 'user-accounts-ajax.php?p=pop_signature',
	type: 'post',
	data: {puaid: 0},
	success: function(data, status) {
		$('#account_signature').signature('draw', eval(data));
	}
});

}

function openApplication(id) {

if ($('#application_id')[0]) {
	viewApplication(id);
} else {
	notification('Please navigate to Applications Module then click the notification item again.');
}

}

function roundToTwo(value) { // round off float to 2 decimal places
    return(Math.round(value * 100) / 100);
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}