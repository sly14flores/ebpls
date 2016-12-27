<?php include 'start.php'; ?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
	<li style="margin-top: -18px; text-align: center; padding-bottom: 3px;">
		<img src="images/<?php echo $lgu_logo; ?>" alt="logo" width="135">
	</li>
	<li><a href="javascript: navigateAway('applications.php');"><i class="fa fa-folder fa-fw"></i> Applications</a></li>
	<li><a href="javascript: navigateAway('business-permits.php');"><i class="fa fa-certificate fa-fw"></i> Business Permits</a></li>
	<li><a href="javascript: navigateAway('departments.php');"><i class="fa fa-building fa-fw"></i> Departments</a></li>
	<li><a href="javascript: navigateAway('user-accounts.php');"><i class="fa fa-users fa-fw"></i> User Accounts</a></li>
	<li class="active"><a href="javascript: navigateAway('manage.php');"><i class="fa fa-gears fa-fw"></i> Management</a></li>
  </ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	
	<h3 class="page-header">Management</h3>
	
	<div id="module-content">
		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="tabs/business.php" data-target="#business" aria-controls="profile" role="tab" data-toggle="tabajax">Business Activity</a></li>
			<li role="presentation"><a href="tabs/assessment.php" data-target="#assessment" aria-controls="profile" role="tab" data-toggle="tabajax">Assessments</a></li>
			<li role="presentation"><a href="tabs/verification.php" data-target="#verification" aria-controls="home" role="tab" data-toggle="tabajax">Documents Verification</a></li>
			<li role="presentation"><a href="tabs/signatories.php" data-target="#signatories" aria-controls="home" role="tab" data-toggle="tabajax">Signatories</a></li>
			</ul>
			<div class="tab-content" style="margin-top: 10px;">
				<div role="tabpanel" class="tab-pane fade in active" id="business"></div>			
				<div role="tabpanel" class="tab-pane fade in" id="assessment"></div>
				<div role="tabpanel" class="tab-pane fade in" id="verification"></div>				
				<div role="tabpanel" class="tab-pane fade in" id="signatories"></div>				
			</div>
		</div>
	</div>

</div>
  </div>
</div>

<?php $mw=1200; include 'modals-custom.php'; ?>

<?php include 'end.php'; ?>

<script src="js/management.js?ver=1.0"></script>
</body>
</html>	
