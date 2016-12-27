$(function() {

tab_content_v();

});

function tab_content_v() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-verification').html(loading);

$.ajax({	
	url: 'verification-ajax.php?p=contents',
	type: 'get',
	success: function(data, status) {	
		$('#in-verification').html(data);
	}
});

}

function addVerification() {

var t = 'Add New Verification';
var c = 'form/verification.php';
var show = function() {
	$('#frmVerification button').click(function() {verificationForm(1,0); pModalHide(); });
	$('#frmVerification').validator();
	
	populateSelect('departments','department_id','department_name','manage_verification_department',0);
	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function editVerification() {

if ( (count_checks('frmContent') == 0) || (count_checks('frmContent') > 1) ) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

var t = 'Update Verification Info';
var c = 'form/verification.php?vid=' + id;
var show = function() {
	$('#frmVerification button').click(function() { verificationForm(2,id); pModalHide(); });
	$('#frmVerification').validator();
	populateSelect('departments','department_id','department_name','manage_verification_department',deptID('manage_verification_department','manage_verification','manage_verification_id',id));
};
var hide = function() {
	uncheckMulti('frmContent');
}
pModal(t,c,show,hide);

}

function delVerification() {

if (count_checks('frmContent') == 0) {
	var f = function() { uncheckMulti('frmContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmContent');

unbindConfirmYes();
var f = function() { pdelVerification(id); };	
confirmation('Are you sure you want to delete this verification(s)?',f,function() { uncheckMulti('frmContent'); });

}

function pdelVerification() {

$.ajax({
	url: 'verification-ajax.php?p=delete',
	type: 'post',
	data: {manage_verification_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_v(); });
	}
});

}

function verificationForm(src,id) {

var mvde = $('#manage_verification_description').val();
var mva = $('#manage_verification_agency').val();
var mvd = $('#manage_verification_department').val();

switch (src) {

case 1:
$.ajax({
	url: 'verification-ajax.php?p=add',
	type: 'post',
	data: {manage_verification_description: mvde, manage_verification_agency: mva, manage_verification_department: mvd},
	success: function(data, status) {
		notification(data,function() {
			tab_content_v();
		});		
	}
});
break;

case 2:
$.ajax({
	url: 'verification-ajax.php?p=update&manage_verification_id=' + id,
	type: 'post',
	data: {manage_verification_description: mvde, manage_verification_agency: mva, manage_verification_department: mvd},
	success: function(data, status) {
		notification(data,function() {
			tab_content_v();
		});		
	}
});
break;

}

}