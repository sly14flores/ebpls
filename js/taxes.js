$(function() {

tab_content_t(0);

});

var desc = {
	percentage: "X% of Gross Sales",
	block: "Corresponding Fixed Amount",
	percentage_of_percentage: "X% of X%",
	percentage_increment: "Plus X% of amount resulting from preceding parameter",
	percentage_excess: "Plus X% of excess amount from preceding parameter",
	times_percentage: "Times X% of amount resulting from preceding parameter."
};

function asyncField(e,id) {

var eid = $(e).attr('id');
var val = $(e).val();

$.ajax({
	url: 'taxes-ajax.php?p=async_field',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function addTaxes() {

var t = 'Tax Computation Formula';
var c = 'form/tax-formula.php';
var show = function() {

var taxes = {
	tax_description: $('#tax_description').val(),
	tax_note: $('#tax_note').val()
};

$.ajax({
	url: 'taxes-ajax.php?p=async_add_tax',
	type: 'post',
	data: taxes,
	success: function(data, status) {

		$('#tax_description').focusout(function() {
			asyncField(document.getElementById('tax_description'),data);
		});

		$('#tax_note').focusout(function() {
			asyncField(document.getElementById('tax_note'),data);			
		});		
		
		$('#addFormula').click(function() {
			addFormula(data);
		});	
	
	}
});
	
};
var hide = function() {
	tab_content_t(0);
}
pModalL(t,c,show,hide);

}

function editTaxes() {

if ( (count_checks('tContent') == 0) || (count_checks('tContent') > 1) ) {
	var f = function() { uncheckMulti('tContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('tContent');

var t = 'Update Tax Computation Formula';
var c = 'form/tax-formula.php?tax_id=' + id;
var show = function() {

	$('#tax_description').focusout(function() {
		asyncField(document.getElementById('tax_description'),id);
	});

	$('#tax_note').focusout(function() {
		asyncField(document.getElementById('tax_note'),id);			
	});		

	$.ajax({
		url: 'business-ajax.php?p=fetch_formulas',
		type: 'post',
		dataType: 'json',
		data: {formula_tax_id: id},
		success: function(data, status) {
			$.each(data.tax_formulas, function(i,d){
				if (d.formula_id == 0) {
					return;
				}
				appendFormula(d.formula_id);
				$('#formula_param_' + d.formula_id).val(d.formula_param);
				$('#formula_start_' + d.formula_id).val(d.formula_start);
				$('#formula_end_' + d.formula_id).val(d.formula_end);			
				$('#formula_amount_percentage_' + d.formula_id).val(d.formula_amount_percentage);			
				$('#formula_percentage_of_' + d.formula_id).val(d.formula_percentage_of);			
				$('#formula_desc_' + d.formula_id).html(desc[d.formula_param]);
				if (d.formula_param == 'percentage_of_percentage') $('#formula_percentage_of_' + d.formula_id).prop('disabled',false);
			});
		}
	});	

	$('#addFormula').click(function() {
		addFormula(id);
	});	

};
var hide = function() {
	uncheckMulti('tContent');
	tab_content_t(0);
}
pModalL(t,c,show,hide);

}

function addFormula(tid) {

 // add formula
$.ajax({
	url: 'business-ajax.php?p=async_add_formula',
	type: 'post',
	data: {formula_tax_id: tid, formula_param: 'percentage'},
	success: function(data, status) {
		appendFormula(data);
	}
});

}

function appendFormula(tfid) {

var row = '<tr id="baif_' + tfid + '">';
row += '<td>';
row += '<select class="form-control" id="formula_param_' + tfid + '" onchange="asyncBITaxF(this,' + tfid + '); impositionDesc(this,' + tfid + ');" style="width: 195px;">';
row += '<option value="percentage">Percentage</option>';
row += '<option value="block">Block/Bracket</option>';
row += '<option value="percentage_of_percentage">X% of X%</option>';
row += '<option value="percentage_increment">Percentage Increment</option>';
row += '<option value="percentage_excess">Percentage Excess</option>';
row += '<option value="times_percentage">X% of Y%</option>';
row += '</select>';
row += '</td>';
row += '<td>';
row += '<input type="text" id="formula_start_' + tfid  + '" class="form-control" style="width: 150px;" onfocusout="asyncBITaxF(this,' + tfid + ');" value="">';
row += '</td>';
row += '<td>';
row += '<input type="text" id="formula_end_' + tfid + '" class="form-control" style="width: 150px;" onfocusout="asyncBITaxF(this,' + tfid + ');" value="">';
row += '</td>';
row += '<td>';
row += '<input type="text" id="formula_amount_percentage_' + tfid + '" class="form-control" style="width: 150px;" onfocusout="asyncPerAmt(this,' + tfid + ');" value="">';
row += '</td>';
row += '<td>';
row += '<input type="text" id="formula_percentage_of_' + tfid + '" class="form-control" style="width: 150px;" onfocusout="asyncPerAmt(this,' + tfid + ');" value="" disabled>';
row += '</td>';
row += '<td id="formula_desc_' + tfid + '" style="width: 200px;">';
row += 'X% of Gross Sales';
row += '</td>';
row += '<td style="text-align: center;">';
row += '<a href="javascript: delFormula(' + tfid + ');"><img src="images/delete.png"></a>';
row += '</td>';
row += '</tr>';

$(row).appendTo('#tax-formula tbody');

}

function tab_content_t() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-taxes').html(loading);

var args = tab_content_t.arguments;
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
	url: 'taxes-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#in-taxes').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function filterTaxes() {

var ftdesc = $.trim($('#ftdesc').val());

var par = '&ftdesc=' + ftdesc;

tab_content_t(0,par);

}

function delTaxes() {

if (count_checks('tContent') == 0) {
	var f = function() { uncheckMulti('tContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('tContent');

unbindConfirmYes();
var f = function() { pdelTax(id); };	
confirmation('Are you sure you want to delete this tax formula?',f,function() { uncheckMulti('tContent'); });

}

function pdelTax(id) {

$.ajax({
	url: 'taxes-ajax.php?p=delete',
	type: 'post',
	data: {tax_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_t(0); });
	}
});

}

function asyncBITaxF(e,tfid) {

var _eid = e.id.split("_");
var f = _eid[0] + "_" + _eid[1];
var v = e.value; 

$.ajax({
	url: 'business-ajax.php?p=async_update_formula',
	type: 'post',
	data: {formula_id: tfid, field: f, value: v},
	success: function(data, status) {
		
	}
});

}

function asyncPerAmt(e,tfid) {

var _eid = e.id.split("_");
var f = _eid[0] + "_" + _eid[1] + "_" + _eid[2];
var v = e.value; 

$.ajax({
	url: 'business-ajax.php?p=async_update_formula',
	type: 'post',
	data: {formula_id: tfid, field: f, value: v},
	success: function(data, status) {
		
	}
});

}

function impositionDesc(e,tfid) {

$('#formula_desc_' + tfid).html(desc[e.value]);
if (e.value == 'percentage_of_percentage') {
	$('#formula_percentage_of_' + tfid).prop('disabled',false);
} else {
	$('#formula_percentage_of_' + tfid).prop('disabled',true);
}

}

function delFormula(tfid) {

$.ajax({
	url: 'business-ajax.php?p=async_del_formula',
	type: 'post',
	data: {formula_id: tfid},
	success: function(data, status) {
		
	}
});

$('#baif_' + tfid).remove();

}