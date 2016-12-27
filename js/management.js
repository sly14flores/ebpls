$(function() {

iniTab('tabs/business.php','#business','js/business.js');

$('[data-toggle="tabajax"]').click(function(e) {
    e.preventDefault()
    var loadurl = $(this).attr('href')
    var targ = $(this).attr('data-target')
    $.get(loadurl, function(data) {
        $(targ).html(data)

		switch (targ) {
		
		case "#business":
		jQuery.getScript('js/business.js',function(data, status, jqxhr) {});
		break;
		
		case "#verification":
		jQuery.getScript('js/verification.js',function(data, status, jqxhr) {});		
		break;
		
		case "#assessment":
		jQuery.getScript('js/assessment.js',function(data, status, jqxhr) {});
		break;

		case "#signatories":
		jQuery.getScript('js/signatories.js',function(data, status, jqxhr) {});
		break;		
		
		}
		
    });
    $(this).tab('show');
});

});

function iniTab(loadurl, targ, js) {

$.get(loadurl, function(data) {
	$(targ).html(data)
	jQuery.getScript(js,function(data, status, jqxhr) {});
});

}