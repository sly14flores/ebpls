cur_page = 1;
total_page = 0;

$(function() {

tab_content_o(0);

});

function tab_content_o() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-others').html(loading);

var args = tab_content_o.arguments;
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
	url: 'others-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#in-others').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function addOthers() {

var t = 'Add New Other Fee';
var c = 'form/others.php';
var show = function() {
	$('#frmOther button').click(function() { otherForm(1,0); pModalHide(); });
	$('#frmOther').validator();
		
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function editOthers() {

if ( (count_checks('oContent') == 0) || (count_checks('oContent') > 1) ) {
	var f = function() { uncheckMulti('oContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('oContent');

var t = 'Update Other Fee Info';
var c = 'form/others.php?o_id=' + id;
var show = function() {
	$('#frmOther button').click(function() { otherForm(2,id); pModalHide(); });
	$('#frmOther').validator();
};
var hide = function() {
	uncheckMulti('oContent');
}
pModal(t,c,show,hide);

}

function delOthers() {

if (count_checks('oContent') == 0) {
	var f = function() { uncheckMulti('oContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('oContent');

unbindConfirmYes();
var f = function() { pdelOthers(id); };
confirmation('Are you sure you want to delete this other fee(s)?',f,function() { uncheckMulti('oContent'); });

}

function pdelOthers(id) {

$.ajax({
	url: 'others-ajax.php?p=delete',
	type: 'post',
	data: {assessment_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_o(0); });
	}
});

}

function otherForm(src,id) {

var odesc = $('#assessment_description').val();
var oref = $('#assessment_reference').val();
var onote = $('#assessment_note').val();

switch (src) {

case 1:
$.ajax({
	url: 'others-ajax.php?p=add',
	type: 'post',
	data: {assessment_description: odesc, assessment_reference: oref, assessment_note: onote},
	success: function(data, status) {
		notification(data,function() {
			tab_content_o(0);
		});		
	}
});
break;

case 2:
$.ajax({
	url: 'others-ajax.php?p=update&assessment_id=' + id,
	type: 'post',
	data: {assessment_description: odesc, assessment_reference: oref, assessment_note: onote},
	success: function(data, status) {
		notification(data,function() {
			tab_content_o(0);
		});		
	}
});
break;

}

}

function filterOthers() {

var fodesc = $.trim($('#fodesc').val());

var par = '&fodesc=' + fodesc;

tab_content_o(0,par);

}