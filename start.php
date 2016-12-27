<?php

require 'verify-session.php';

$lgu_logo = "lgu-logo.png";
if (!file_exists("images/$lgu_logo")) $lgu_logo = "default-logo.png";
$lgu = "Bacnotan";

$account_fname = $_SESSION['account_fname'];
$account_d = $_SESSION['account_d'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="sly@unlimited">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $lgu; ?> | e-BPLS</title>

	<!-- jqurey 1.11.1 CSS -->
    <link href="jquery-ui-1.11.1/jquery-ui.min.css" rel="stylesheet">
	
	<!-- jquery ui signature -->
	<link type="text/css" href="jquery.signature.package-1.1.1/jquery.signature.css" rel="stylesheet"> 
	
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="dist/css/typeahead.css" rel="stylesheet">
    <link href="css/nav-wizard.bootstrap.css" rel="stylesheet">
	
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <link href="datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">	
	
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- Custom Fonts -->
    <link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!--[if IE]> 
	<script type="text/javascript" src="jquery.signature.package-1.1.1/excanvas.js"></script> 
	<![endif]-->	
	
	<style type="text/css">
	
	.welcome, .department {
		text-align: center;
		padding-top: 15px;
		font-weight: bold;
		color: #777;
	}
	
	.welcome {
		padding-right: 10px;
	}
	
	.wel-sep-dep {
		padding-top: 14px;		
	}
	
	.department {
		padding-left: 10px;
	}
	
	.page-header {
		margin-bottom: 0;
	}
	
	#module-menu {
		padding-top: 10px;
		padding-bottom: 0;
		background-color: #ecf5fc;
	}
	
	#module-buttons ul, #module-buttons-right ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
	}
	
	#module-buttons li, #module-buttons-right li {
		float: left;
		text-align: center;
		padding-left: 25px;
	}
	
	#module-buttons li h6, #module-buttons-right li h6 {
		margin-top: 5px;
		line-height: 15px;
		color: #428bca;
	}
	
	#module-search {
		padding: 0;
		margin: -50px;
		color: #777;
	}
	
	#module-search .form-group {
		margin-top: 10px;
	}
	
	#module-content {
		/*color: #777;*/
		color: #333;
	}
	
	.dropdown-alerts {
		width: 310px;
		min-width: 0;
		margin-left: -123px;
	}

	.notify-color {
		color: #FA4B4B;
	}
	
	.kbw-signature { width: 300px; height: 100px; }	
	
	</style>
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Electronic Business Permit and Licensing System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
			<li class="welcome">Welcome <?php echo $account_fname; ?>!</li>
			<li class="wel-sep-dep">|</li>
			<li class="department">Department: <?php echo $account_d; ?></li>
            <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href=""><i id="notification-bell" class="fa fa-bell fa-fw"></i>  <i id="notification-caret" class="fa fa-caret-down"></i></a>
				<ul id="notifications-container" class="dropdown-menu dropdown-alerts">
					<li>
						<a href="#">
							<div>
								<i class="fa fa-info-circle fa-fw"></i> No notifications
								<span class="pull-right text-muted small"></span>
							</div>
						</a>
					</li>					
				</ul>
			</li>			
            <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i></a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="javascript: userProfileC();"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
					<!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>-->
					<li class="divider"></li>
					<li><a href="javascript: logout();"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
				</ul>				
			</li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">