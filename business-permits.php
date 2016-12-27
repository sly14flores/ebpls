<?php include 'start.php'; ?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
	<li style="margin-top: -18px; text-align: center; padding-bottom: 3px;">
		<img src="images/<?php echo $lgu_logo; ?>" alt="logo" width="135">
	</li>
	<li><a href="applications.php"><i class="fa fa-folder fa-fw"></i> Applications</a></li>
	<li class="active"><a href="business-permits.php"><i class="fa fa-certificate fa-fw"></i> Business Permits</a></li>
	<li><a href="javascript: user_account('departments.php');"><i class="fa fa-building fa-fw"></i> Departments</a></li>
	<li><a href="javascript: user_account('user-accounts.php');"><i class="fa fa-users fa-fw"></i> User Accounts</a></li>
	<li><a href="javascript: user_account('manage.php');"><i class="fa fa-gears fa-fw"></i> Management</a></li>
  </ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<!--<p style="text-align: right; font-weight: bold; color: #777;">Welcome! Admin<br>Department: Treasurer's Office</p>-->
	<h3 class="page-header">Business Permits</h3>
	
	<div id="module-menu" class="row">
	  <div id="module-buttons-right" class="col-sm-6">
		<ul>
		<li>
		<a href="javascript: refreshPermits();">
		  <img src="images/Data-Refresh-48.png" alt="Refresh">
		</a>
		<h6>Refresh</h6>				
		</li>		
		<li>
		<a href="javascript: browsePermits();">
		  <img src="images/Folder-48.png" alt="Search Permits">
		</a>
		<h6>Search<br>Permits</h6>				
		</li>
		<li>
		<a href="javascript: generatePermits();">
		  <img src="images/Data-Add-48.png" alt="Generate Permit">
		</a>
		<h6>Generate<br>Permit</h6>				
		</li>
		<li>
		<a href="javascript: deletePermit();">
		  <img src="images/Data-Delete-48.png" alt="Delete Permit">
		</a>
		<h6>Delete<br>Permit</h6>				
		</li>		
		</ul>
	  </div>	
	  <div id="module-buttons" class="col-sm-6">&nbsp;</div>
	</div>			
	<hr style="margin-top: 0; margin-bottom: 10px;">			
	<div id="module-content"></div>		
 
</div>
  </div>
</div>

<?php include 'modals.php'; ?>

<?php include 'end.php'; ?>

<script src="js/permit.js?ver=1.0"></script>
<input id="application_id" type="hidden" value="0">
<!-- browse applications -->
<input type="hidden" id="h_application_no" value="">
<input type="hidden" id="h_application_reference_no" value="">
<input type="hidden" id="h_applicant_fullname" value="">
<input type="hidden" id="h_application_form" value="all">
<input type="hidden" id="h_application_organization_type" value="all">
<input type="hidden" id="h_application_mode_of_payment" value="all">
<input type="hidden" id="h_application_date" value="">
<input type="hidden" id="h_application_month" value="0">
<input type="hidden" id="h_application_year" value="">
<!-- *** -->
</body>
</html>	
