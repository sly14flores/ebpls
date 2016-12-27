<?php include 'start.php'; ?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
	<li style="margin-top: -18px; text-align: center; padding-bottom: 3px;">
		<img src="images/<?php echo $lgu_logo; ?>" alt="logo" width="135">
	</li>
	<li class="active"><a href="javascript: navigateAway('applications.php');"><i class="fa fa-folder fa-fw"></i> Applications</a></li>
	<li><a href="javascript: navigateAway('business-permits.php');"><i class="fa fa-certificate fa-fw"></i> Business Permits</a></li>
	<li><a href="javascript: navigateAway('departments.php');"><i class="fa fa-building fa-fw"></i> Departments</a></li>
	<li><a href="javascript: navigateAway('user-accounts.php');"><i class="fa fa-users fa-fw"></i> User Accounts</a></li>
	<li><a href="javascript: navigateAway('manage.php');"><i class="fa fa-gears fa-fw"></i> Management</a></li>
  </ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<!--<p style="text-align: right; font-weight: bold; color: #777;">Welcome! Admin<br>Department: Treasurer's Office</p>-->
	<h3 class="page-header">Applications</h3>
	
	<div id="module-menu" class="row">
	  <div id="module-buttons" class="col-sm-6">
		<ul>
		<li>
		<a href="javascript: addApplication(1,0);">
		  <img src="images/Data-Add-48.png" alt="Add Application">
		</a>
		<h6>Add<br>Application</h6>				
		</li>
		<li>
		<a href="javascript: viewApplication();">
		  <img src="images/Data-Find-48.png" alt="View Application">
		</a>
		<h6>View<br>Application</h6>
		</li>
		<li>
		<a href="javascript: delApplication();">
		  <img src="images/Data-Delete-48.png" alt="Delete Application">
		</a>
		<h6>Delete<br>Application</h6>				
		</li>
		</ul>
	  </div>
	  <div id="module-buttons-right" class="col-sm-6">
		<ul>
		<li>
		<a href="javascript: browseApplications();">
		  <img src="images/Folder-48.png" alt="Search Applications">
		</a>
		<h6>Search<br>Applications</h6>				
		</li>
		<li>
		<a href="javascript: generateReports();">
		  <img src="images/Document-48.png" alt="Generate Reports">
		</a>
		<h6>Generate<br>Reports</h6>				
		</li>		
		<li>
		<a href="javascript: refreshApplications();">
		  <img src="images/Data-Refresh-48.png" alt="Refresh">
		</a>
		<h6>Refresh</h6>				
		</li>		
		<li>
		<a href="javascript: printBlanks();">
		  <img src="images/Item-New-48.png" alt="Blank Forms">
		</a>
		<h6>Blank<br>Forms</h6>				
		</li>
		<li>
		<a href="javascript: businessStat();">
		  <img src="images/Note-Memo-01-48.png" alt="Business Status">
		</a>
		<h6>Business<br>Status</h6>				
		</li>			
		</ul>
	  </div>
	</div>			
	<hr style="margin-top: 0; margin-bottom: 10px;">			
	<div id="module-content"></div>		
 
</div>
  </div>
</div>

<?php $mw=1200; include 'modals-custom.php'; ?>

<?php include 'end.php'; ?>

<script src="js/applications.js?ver=1.0.0.3"></script>
<input id="application_id" type="hidden" value="0">
<input id="application_id_ref_no" type="hidden" value="">
<input id="application_fid" type="hidden" value="0">
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
