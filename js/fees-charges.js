cur_page = 1;
total_page = 0;

$(function() {

tab_content_fc(0);

});

function tab_content_fc() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-fees-charges').html(loading);

var args = tab_content_fc.arguments;
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
	url: 'fees-charges-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#in-fees-charges').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function addFeesCharges() {

var t = 'Add New Fee/Charge';
var c = 'form/fees-charges.php';
var show = function() {
	$('#frmFeeCharge button').click(function() { feeChargeForm(1,0); pModalHide(); });
	$('#frmFeeCharge').validator();
		
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function editFeesCharges() {

if ( (count_checks('fcContent') == 0) || (count_checks('fcContent') > 1) ) {
	var f = function() { uncheckMulti('fcContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('fcContent');

var t = 'Update Fee/Charge Info';
var c = 'form/fees-charges.php?fc_id=' + id;
var show = function() {
	$('#frmFeeCharge button').click(function() { feeChargeForm(2,id); pModalHide(); });
	$('#frmFeeCharge').validator();
};
var hide = function() {
	uncheckMulti('fcContent');
}
pModal(t,c,show,hide);

}

function delFeesCharges() {

if (count_checks('fcContent') == 0) {
	var f = function() { uncheckMulti('fcContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('fcContent');

unbindConfirmYes();
var f = function() { pdelFeesCharges(id); };
confirmation('Are you sure you want to delete this fee(s)/charge(s)?',f,function() { uncheckMulti('fcContent'); });

}

function pdelFeesCharges(id) {

$.ajax({
	url: 'fees-charges-ajax.php?p=delete',
	type: 'post',
	data: {assessment_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_fc(0); });
	}
});

}

function feeChargeForm(src,id) {

var fcdesc = $('#assessment_description').val();
var fcref = $('#assessment_reference').val();
var fcnote = $('#assessment_note').val();

switch (src) {

case 1:
$.ajax({
	url: 'fees-charges-ajax.php?p=add',
	type: 'post',
	data: {assessment_description: fcdesc, assessment_reference: fcref, assessment_note: fcnote},
	success: function(data, status) {
		notification(data,function() {
			tab_content_fc(0);
		});		
	}
});
break;

case 2:
$.ajax({
	url: 'fees-charges-ajax.php?p=update&assessment_id=' + id,
	type: 'post',
	data: {assessment_description: fcdesc, assessment_reference: fcref, assessment_note: fcnote},
	success: function(data, status) {
		notification(data,function() {
			tab_content_fc(0);
		});		
	}
});
break;

}

}

function filterFeesCharges() {

var ffcdesc = $.trim($('#ffcdesc').val());

var par = '&ffcdesc=' + ffcdesc;

tab_content_fc(0,par);

}