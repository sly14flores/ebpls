$(function() {

tab_content_s();

});

function tab_content_s() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-signatories').html(loading);

$.ajax({	
	url: 'signatory-ajax.php?p=contents',
	type: 'get',
	success: function(data, status) {	
		$('#in-signatories').html(data);
	}
});

}

function addSignatory() {

var t = 'Add New Signatory';
var c = 'form/signatory.php';
var show = function() {
	$('#frmSignatory button').click(function() { signatoryForm(1,0); pModalHide(); });
	$('#frmSignatory').validator();	
	populateTypehead("signatory_account","concat(account_lname, ', ', account_fname, ' ', account_mname)","accounts","account_lname, account_fname, account_mname");	
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function editSignatory() {

if ( (count_checks('frmSContent') == 0) || (count_checks('frmSContent') > 1) ) {
	var f = function() { uncheckMulti('frmSContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmSContent');

var t = 'Update Signatory Info';
var c = 'form/signatory.php?signatory_id=' + id;
var show = function() {
	$('#frmSignatory button').click(function() { signatoryForm(2,id); pModalHide(); });
	$('#frmSignatory').validator();
	populateTypehead("signatory_account","concat(account_lname, ', ', account_fname, ' ', account_mname)","accounts","account_lname, account_fname, account_mname");		

};
var hide = function() {
	uncheckMulti('frmSContent');
}
pModal(t,c,show,hide);

}

function delSignatory() {

if (count_checks('frmSContent') == 0) {
	var f = function() { uncheckMulti('frmSContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('frmSContent');

unbindConfirmYes();
var f = function() { pdelSignatory(id); };	
confirmation('Are you sure you want to delete this signatory?',f,function() { uncheckMulti('frmContent'); });

}

function pdelSignatory() {

$.ajax({
	url: 'signatory-ajax.php?p=delete',
	type: 'post',
	data: {signatory_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_s(); });
	}
});

}

function signatoryForm(src,id) {

var signatory = {
	signatory_account: $('#signatory_account').val(),
	signatory_for: $('#signatory_for').val()
};

switch (src) {

case 1:
$.ajax({
	url: 'signatory-ajax.php?p=add',
	type: 'post',
	data: signatory,
	success: function(data, status) {
		notification(data,function() {
			tab_content_s(0);
		});	
	}
});
break;

case 2:
$.ajax({
	url: 'signatory-ajax.php?p=update&signatory_id=' + id,
	type: 'post',
	data: signatory,
	success: function(data, status) {
		notification(data,function() {
			tab_content_s(0);
		});	
	}
});
break;

}

}