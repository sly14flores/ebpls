$(function() {

iniTab('tabs/taxes.php','#taxes','js/taxes.js');

$('[data-toggle="tabajax-in"]').click(function(e) {
    e.preventDefault()
    var loadurl = $(this).attr('href')
    var targ = $(this).attr('data-target')
    $.get(loadurl, function(data) {
        $(targ).html(data)

		switch (targ) {

		case "#taxes":
		jQuery.getScript('js/taxes.js',function(data, status, jqxhr) {});
		break;		
		
		case "#local-taxes":
		jQuery.getScript('js/local-taxes.js',function(data, status, jqxhr) {});		
		break;
		
		case "#fees-charges":
		jQuery.getScript('js/fees-charges.js',function(data, status, jqxhr) {});
		break;	

		case "#others":
		jQuery.getScript('js/others.js',function(data, status, jqxhr) {});
		break;			
		
		}
		
    });
    $(this).tab('show');
});

});