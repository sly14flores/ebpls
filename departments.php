<?php include 'start.php'; ?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
	<li style="margin-top: -18px; text-align: center; padding-bottom: 3px;">
		<img src="images/<?php echo $lgu_logo; ?>" alt="logo" width="135">
	</li>
	<li><a href="applications.php"><i class="fa fa-folder fa-fw"></i> Applications</a></li>
	<li><a href="javascript: user_account('business-permits.php');"><i class="fa fa-certificate fa-fw"></i> Business Permits</a></li>
	<li class="active"><a href="departments.php"><i class="fa fa-building fa-fw"></i> Departments</a></li>
	<li><a href="javascript: user_account('user-accounts.php');"><i class="fa fa-users fa-fw"></i> User Accounts</a></li>
	<li><a href="javascript: user_account('manage.php');"><i class="fa fa-gears fa-fw"></i> Management</a></li>
  </ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<!--<p style="text-align: right; font-weight: bold; color: #777;">Welcome! Admin<br>Department: Treasurer's Office</p>-->
	<h3 class="page-header">Departments</h3>
	
	<div id="module-menu" class="row">
	  <div id="module-buttons" class="col-sm-6">
		<ul>
		<li>
		<a href="javascript: addDept();">
		  <img src="images/Data-Add-48.png" alt="Add Department">
		</a>
		<h6>Add<br>Department</h6>				
		</li>
		<li>
		<a href="javascript: editDept();">
		  <img src="images/Data-Edit-48.png" alt="Edit Department">
		</a>
		<h6>Edit<br>Department</h6>
		</li>
		<li>
		<a href="javascript: delDept();">
		  <img src="images/Data-Delete-48.png" alt="Delete Department">
		</a>
		<h6>Delete<br>Department</h6>				
		</li>				
		</ul>
	  </div>
	  <div id="module-search" class="col-sm-6">
	  <h4>Search Departments</h4>
		<form class="form-inline" role="form" onSubmit="return false;">								  
		  <div class="form-group">
			<label for="fdeptname">Department:</label>
			<input type="text" class="form-control" id="fdeptname" placeholder="Enter department name">
		  </div>				  
		  <div class="form-group">
			<button id="search-button" type="submit" class="btn btn-default">Go!</button>
		  </div>
		</form>		
	  </div>
	</div>			
	<hr style="margin-top: 0; margin-bottom: 10px;">			
	<div id="module-content">
			
	</div>		
 
</div>
  </div>
</div>

<?php include 'modals.php'; ?>

<?php include 'end.php'; ?>

<script src="js/departments.js?ver=1.0"></script>
</body>
</html>	
