<?php

$src = isset($_GET['src']) ? $_GET['src'] : 1;

require '../config.php';
require '../globalf.php';

?>
<div id="verfication-on"></div>
<div style="padding: 5px 0 5px 20px;">
<fieldset style="margin-top: 30px;">
<legend>Verification of Documents</legend>
<table id="tab-verifications" class="table table-striped">
<thead><tr><th>#</th><th>Description</th><th>Office/Agency</th><th>Status</th><th>Date Issued</th><th>Verified by</th><th>Action</th></tr></thead>
<tbody></tbody>
<tfoot><tr><td colspan="7">NOTE: You are only allowed to verify documents that are assigned to your office</td></tr></tfoot>
</table>
</fieldset>
</div>