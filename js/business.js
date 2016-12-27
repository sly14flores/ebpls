cur_page = 1;
total_page = 0;

$(function() {

tab_content_b(0);

});

function tab_content_b() {

var loading  = '<div style="text-align: center;">';
	loading += '<img src="images/progress.gif">';
	loading	+= '</div>';

$('#in-business').html(loading);

var args = tab_content_b.arguments;
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
	url: 'business-ajax.php?p=contents' + page,
	type: 'get',
	success: function(data, status) {		
		var sdata = data.split('|');
		$('#in-business').html(sdata[0]);
		total_page = parseInt(sdata[1]);	
	}
});

}

function iniBAForm() {

$.ajax({
	url: 'business-ajax.php?p=add',
	type: 'post',
	success: function(data, status) {
		$('#ba_id').val(data);
		$.unblockUI();
	}
});

}

function asyncSql(e) {

var id = $('#ba_id').val();
var eid = $(e).attr('id');
var val = $(e).val();

$.ajax({
	url: 'business-ajax.php?p=async_add',
	type: 'post',
	data: {pid: id, field: eid, value: val},
	success: function(data, status) {

	}
});

}

function addBusiness() {

if (disModuleMainB()) return;

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });

var c = 'form/business.php?src=1';
$('#in-business').load(c, function() {
	iniBAForm();
	fillLocalTaxesFeesCharges(0);
	
	$('input').focusout(function() {
		var t = $(this).attr('type');

		if (t == 'text') {

			asyncSql(this);

		}
	});
	$('select').focusout(function() {

			asyncSql(this);
			
	});
	
});

}

function editBusiness() {

if (disModuleMainB()) return;

if ( (count_checks('ltfcContent') == 0) || (count_checks('ltfcContent') > 1) ) {
	var f = function() { uncheckMulti('ltfcContent'); };
	notification('Please select one.',f);
	return;
}

id = getCheckedId('ltfcContent');
$('#ba_id').val(id);

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });

var c = 'form/business.php?src=2&baid=' + id;
$('#in-business').load(c, function() {
	
	$.ajax({
		url: 'business-ajax.php?p=edit',
		type: 'post',
		dataType: 'json',
		data: {bid: id},
		success: function(data, status) {		
			$.each(data, function(key, value) {
				$('#' + key).val(value);
			});
			
			$(function() {
				$('input').focusout(function() {
					var t = $(this).attr('type');

					if (t == 'text') {

						asyncSql(this);

					}
				});
				$('select').focusout(function() {

						asyncSql(this);
						
				});			
			});
			
		}
	});	

	fillLocalTaxesFeesCharges(id);
	
	$.unblockUI();
	
});

}

function saveBA() {

var chk = $('#ba_line').val();

if (chk == '') {
	$.notify("Please enter Line of Business", {className: "error", globalPosition: "top center"});
	return;
}

tab_content_b(0);

}

function cancelBusinessActivityForm(src) {

if (src == 2) {
	$('#ba_id').val(0);
	tab_content_b(0);
	return;
}

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });

var id = $('#ba_id').val();
$.ajax({
	url: 'business-ajax.php?p=cancel_ba',
	type: 'post',
	data: {ba_id: id},
	success: function(data, status) {
		$('#ba_id').val(0);
		tab_content_b(0);
		$.unblockUI();
	}
});

}

function filterBusinessActivity() {

var fbdesc = $.trim($('#fbdesc').val());

var par = '&fbdesc=' + fbdesc;

tab_content_b(0,par);

}

function rBusinessActivityF() {

var fbdesc = $.trim($('#fbdesc').val());

var par = '&fbdesc=' + fbdesc;

return par;

}

function delBusiness() {

if (disModuleMainB()) return;

if (count_checks('ltfcContent') == 0) {
	var f = function() { uncheckMulti('ltfcContent'); };
	notification('Please select one.',f);
	return;
}

if (count_checks('ltfcContent') > 1) {
	var f = function() { uncheckMulti('ltfcContent'); };
	notification('You are only allowed to delete one record at a time.',f);
	return;
}

id = getCheckedId('ltfcContent');

unbindConfirmYes();
var f = function() { pdelBusiness(id); };	
confirmation('Are you sure you want to delete this business activity?',f,function() { uncheckMulti('ltfcContent'); });

}

function pdelBusiness() {

$.ajax({
	url: 'business-ajax.php?p=delete',
	type: 'post',
	data: {ba_id: id},
	success: function(data, status) {
		notification(data,function() { tab_content_b(0); });		
	}
});

}

function fetch_ba_items(id) {

	$.ajax({
		url: 'business-ajax.php?p=fetch_ba_items',
		type: 'post',
		dataType: 'json',
		data: {bbaid: id},
		success: function(data, status) {		
			$.each(data.ba_items, function(i,d){
		
				if ($('#chk_' + d.ba_assessment_id)[0]) {
				$('#chk_' + d.ba_assessment_id).prop('checked',true);

				if (parseInt(d.ba_item_is_tax) == 0) { // amount
					$('#amt_' + d.ba_assessment_id).val(d.ba_item_amount);
					$('#amt_' + d.ba_assessment_id).prop('disabled',false);
					togSelected(d.ba_assessment_id,(document.getElementById('chk_' + d.ba_assessment_id)));
				}
				if (parseInt(d.ba_item_is_tax) == 1) { // tax					
					$('#rate_' + d.ba_assessment_id).val(d.formula);
					$('#rate_' + d.ba_assessment_id).prop('disabled',false);
					togSelected(d.ba_assessment_id,(document.getElementById('chk_' + d.ba_assessment_id)));
				}		
				$('#hbaid_' + d.ba_assessment_id).val(d.ba_item_id);
				}
					
			});			
			
		}
	});

}

function fillLocalTaxesFeesCharges(id) {

$.ajax({
	url: 'business-ajax.php?p=fill_local_taxes_fees_charges',
	type: 'get',
	success: function(data, status) {
		$('#ba-local-taxes-fees-charges').html(data);
		fetch_ba_items(id);
	}
});

}

function chkAll(e,chk) {

$('#' + e + ' .chk_all input:checkbox').each(function() {

this.checked = chk.checked;
var _id = this.id.split('_');
var id = _id[1];
togSelected(id,chk);

});

}

function uncheckParent(e,chk) {

var ee = document.getElementById(e);

if (!chk.checked && ee.checked) {
	ee.checked = false;
}

}

function asyncBIAmt(baaid,e) {

var id = $('#ba_id').val(); // business activity ID FK
var amt = $(e).val();

$.ajax({
	url: 'business-ajax.php?p=async_add_bi_amt',
	type: 'post',
	data: {ba_item_baid: id, ba_assessment_id: baaid, ba_item_is_tax: 0, ba_item_amount: amt},
	success: function(data, status) {

	}
});

}

function asyncCancelAmt(baaid) {

var id = $('#ba_id').val(); // business activity ID FK

$.ajax({
	url: 'business-ajax.php?p=async_cancel_bi_amt',
	type: 'post',
	data: {ba_item_baid: id, ba_assessment_id: baaid},
	success: function(data, status) {

	}
});

}

function asyncBITax(baaid,e) {

$.blockUI({ message: '<h4 style="padding-top: 5px;"><img src="images/busy.gif" /> Please wait...</h4>' });

var id = $('#ba_id').val(); // business activity ID FK

$.ajax({
	url: 'business-ajax.php?p=async_add_bi_tax',
	type: 'post',
	data: {ba_item_baid: id, ba_assessment_id: baaid, ba_item_is_tax: 1},
	success: function(data, status) {
		biTaxFormula(data);		
		$.unblockUI();
	}
});

}

function asyncCancelTax(baaid) {

var id = $('#ba_id').val(); // business activity ID FK

$.ajax({
	url: 'business-ajax.php?p=async_cancel_bi_tax',
	type: 'post',
	data: {ba_item_baid: id, ba_assessment_id: baaid},
	success: function(data, status) {

	}
});

}

function biTaxFormula(baiid) {

var t = 'Query Tax Formula';
var c = 'form/query-tax.php';
var show = function() {

$('#qtax').keyup(function() {

asyncSearchTax(this,baiid);

});

};
var hide = function() {

}
pModal(t,c,show,hide);

}

function asyncSearchTax(e,id) {

var rows_results = '';
var f = 'tax_description';
var v = e.value;

$.ajax({
	url: 'business-ajax.php?p=async_search_tax',
	type: 'post',
	data: {field: f, val: v, ba_item_id: id},
	success: function(data, status) {
		$('#query-tax tbody').html(data);
		$('#query-tax tr').hover(function() {
			$(this).css("cursor","pointer");
		});		
	}
});

}

function clickUpdateTax(tax_description,ba_item_id,tax_id) {

pModalHide();
$('#rate_1').val(tax_description);
$.ajax({
	url: 'business-ajax.php?p=async_update_tax&ba_item_id=' + ba_item_id,
	type: 'post',
	data: {ba_item_tax_formula: tax_id},
	success: function(data, status) {

	}
});

}

/* function addFormula(baiid) {

 // add formula
$.ajax({
	url: 'business-ajax.php?p=async_add_formula',
	type: 'post',
	data: {formula_ba_item_id: baiid, formula_param: 'percentage'},
	success: function(data, status) {
		appendFormula(data);
	}
});

} */

/* function appendFormula(tfid) {

var row = '<tr id="baif_' + tfid + '">';
row += '<td>';
row += '<select class="form-control" id="formula_param_' + tfid + '" onchange="asyncBITaxF(this,' + tfid + '); impositionDesc(this,' + tfid + ');" style="width: 195px;">';
row += '<option value="percentage">Percentage</option>';
row += '<option value="block">Block/Bracket</option>';
row += '<option value="percentage_of_percentage">X% of X%</option>';
row += '<option value="percentage_increment">Percentage Increment</option>';
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

} */

/* function delFormula(tfid) {

$.ajax({
	url: 'business-ajax.php?p=async_del_formula',
	type: 'post',
	data: {formula_id: tfid},
	success: function(data, status) {
		
	}
});

$('#baif_' + tfid).remove();

} */

/* function asyncBITaxF(e,tfid) {

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

} */

/* function asyncPerAmt(e,tfid) {

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

} */

/* function impositionDesc(e,tfid) {

$('#formula_desc_' + tfid).html(desc[e.value]);
if (e.value == 'percentage_of_percentage') {
	$('#formula_percentage_of_' + tfid).prop('disabled',false);
} else {
	$('#formula_percentage_of_' + tfid).prop('disabled',true);
}

} */

function togSelected(id,chk) {

if ($('#amt_' + id)[0]) {
	$('#amt_' + id).prop('disabled',!chk.checked);
	if (chk.checked) {
		$(function(){

			$('#amt_' + id).focusout(function() {
				asyncBIAmt(id,this);
			});
		
		});
	} else {
		$('#amt_' + id).val(0);
		asyncCancelAmt(id);
	}
}

if ($('#rate_' + id)[0]) {
	$('#rate_' + id).prop('disabled',!chk.checked);
	if (chk.checked) {
		$(function(){

			$('#rate_' + id).focus(function() {
				asyncBITax(id,this);
			});
		
		});	
	} else {
		$('#rate_' + id).val('');	
		asyncCancelTax(id);			
	}
}

}

function getItemID(e) {

var id = '';

var _id = e.split('_');
id = _id[1];

return id;

}

function disModuleMainB() {

var chk = false;

var chkf = $('#frmBusinessActivity')[0];
if (chkf) chk = true;

return chk;

}

function navigateAway(m) {

if (disModuleMainB()) {

if (m == 'manage.php') return;

var f = function() { };
notification('Cannot navigate to other module while on adding/editing process.',f);
return;

}

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