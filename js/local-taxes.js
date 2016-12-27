cur_page = 1;
total_page = 0;

$(function() {

tab_content_lt(0);

});

function tab_content_lt() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-local-taxes').html(loading);

var args = tab_content_lt.arguments;
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
	url: 'local-taxes-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#in-local-taxes').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function addLocalTaxes() {

var t = 'Add New Local Tax';
var c = 'form/local-tax.php';
var show = function() {
	$('#frmLocalTax button').click(function() { localTaxForm(1,0); pModalHide(); });
	$('#frmLocalTax').validator();
		
};
var hide = function() {

}
pModal(t,c,show,hide);

}

function editLocalTaxes() {

if ( (count_checks('ltContent') == 0) || (count_checks('ltContent') > 1) ) {
	var f = function() { uncheckMulti('ltContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('ltContent');

var t = 'Update Local Tax Info';
var c = 'form/local-tax.php?lt_id=' + id;
var show = function() {
	$('#frmLocalTax button').click(function() { localTaxForm(2,id); pModalHide(); });
	$('#frmLocalTax').validator();
};
var hide = function() {
	uncheckMulti('ltContent');
}
pModal(t,c,show,hide);

}

function delLocalTaxes() {

if (count_checks('ltContent') == 0) {
	var f = function() { uncheckMulti('ltContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('ltContent');

unbindConfirmYes();
var f = function() { pdelLocalTax(id); };	
confirmation('Are you sure you want to delete this local tax(es)?',f,function() { uncheckMulti('ltContent'); });

}

function pdelLocalTax(id) {

$.ajax({
	url: 'local-taxes-ajax.php?p=delete',
	type: 'post',
	data: {assessment_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_lt(0); });
	}
});

}

function localTaxForm(src,id) {

var ltdesc = $('#assessment_description').val();
var ltref = $('#assessment_reference').val();
var ltnote = $('#assessment_note').val();

switch (src) {

case 1:
$.ajax({
	url: 'local-taxes-ajax.php?p=add',
	type: 'post',
	data: {assessment_description: ltdesc, assessment_reference: ltref, assessment_note: ltnote},
	success: function(data, status) {
		notification(data,function() {
			tab_content_lt(0);
		});		
	}
});
break;

case 2:
$.ajax({
	url: 'local-taxes-ajax.php?p=update&assessment_id=' + id,
	type: 'post',
	data: {assessment_description: ltdesc, assessment_reference: ltref, assessment_note: ltnote},
	success: function(data, status) {
		notification(data,function() {
			tab_content_lt(0);
		});		
	}
});
break;

}

}

function filterLocalTaxes() {

var fltdesc = $.trim($('#fltdesc').val());

var par = '&fltdesc=' + fltdesc;

tab_content_lt(0,par);

}