<?php

$modal_width = (isset($mw)) ? ' style="width: ' . $mw . 'px; margin-left: ' . ((600-$mw)/2) . 'px;"'  : "";

?>
<div class="modal fade" id="parentModalL" tabindex="-1" role="dialog" aria-labelledby="parent-modal" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
	<div class="modal-content"<?php echo $modal_width; ?>>
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="parent-modal"></h4>
	  </div>
	  <div class="modal-body"></div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="parentModal" tabindex="-1" role="dialog" aria-labelledby="parent-modal" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="parent-modal"></h4>
	  </div>
	  <div class="modal-body"></div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>
<div style="margin-top: 15%;" class="modal fade bs-example-modal-sm" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="confirmation">Confirmation</h4>
	  </div>
	  <div class="modal-body"></div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" id="btnYes">Yes</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	  </div>
	</div>
  </div>
</div>
<div style="margin-top: 15%;" class="modal fade bs-example-modal-sm" id="modal-notify" tabindex="-1" role="dialog" aria-labelledby="notification" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="notification">Notification</h4>
	  </div>
	  <div class="modal-body"></div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	  </div>
	</div>
  </div>
</div>