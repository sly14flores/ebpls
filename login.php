<?php

require 'config.php';

$lgu_logo = "lgu-logo.png";
if (!file_exists("images/$lgu_logo")) $lgu_logo = "default-logo.png";
$lgu = "Bacnotan";

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

    <title>Login - <?php echo $lgu; ?> e-BPLS</title>

    <!-- Bootstrap Core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

	<style type="text/css">
		
		.company-heading {
			margin-top: 10px;
			margin-bottom: 15px;
		}
		
		.company-heading * {
			margin: 0;
		}
		
		.company-heading {
			color: #5b5b5b;
			text-align: center;			
		}

		.login-footer {
			position: absolute;
			bottom: 0;
			height: 35px;
			width: 100%;
			border-top: 1px solid #e5e5e5;
			overflow: hidden;
			text-align: center;
			font-family: inherit;
			color: #aaaaaa;
		}
		
		.login-footer p {
			margin-top: 4px;
		}
		
		.forgot-password {
			margin-top: -8px;
			margin-bottom: 8px;
			text-align: right;
		}
		
		.forgot-password a {
			margin-right: 12px;
		}

		.forgot-password a:hover {		
			cursor: pointer;
		}
		
		.form-error {
			border: 1px solid #dd4b39;
		}
		
	</style>
	
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
				<div class="company-heading">
				<img src="images/<?php echo $lgu_logo; ?>" alt="logo">
				<h2><?php echo $lgu; ?> | e-BPLS</h2>
				</div>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
                                </div>
								<div id="login-alert" class="alert alert-danger" style="display: none;"></div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button id="login" class="btn btn-lg btn-success btn-block" onclick="return false;">Login</button>
                            </fieldset>
                        </form>
                    </div>
					<div class="forgot-password" >
					<a href="javascript: forgotPassword();">Forgot Password?</a>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="jquery/1.11.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
	
		$(function() {
			$('#login').click(function() { login(); });
			$('.forgot-password a').click(function() { forgotPassword(); });
		});
			
		function login() {
			
			var uname = $('#username').val();
			var pword = $('#password').val();
			
			if ((uname == '') || (pword == '')) {
				
				if ((uname == '') && (pword != '')) {
					$('#login-alert').html('Enter your username.');
					$('#username').addClass('form-error');
				}
				if ((uname != '') && (pword == '')) {
					$('#login-alert').html('Enter your password.');
					$('#password').addClass('form-error');
				}
				if ((uname == '') && (pword == '')) {
					$('#login-alert').html('Enter your usermame and password.');
					$('#username').addClass('form-error');
					$('#password').addClass('form-error');					
				}				
				
				$('#login-alert').css('display','block');
				return;
			}
			
			$('#login-alert').css('display','none');
			$('#username').removeClass('form-error');
			$('#password').removeClass('form-error');			
			
			$.ajax({
				url: 'account.php',
				type: 'post',
				data: {username: uname, password: pword},
				success: function(data, status) {
					if (data == "proceed") {
						window.location.href = 'applications.php';
					} else if (data == "login") {
						$('#login-alert').html('Your account is logged-in from another device.');
						$('#login-alert').css('display','block');						
					} else {
						$('#login-alert').html('The username or password you entered is incorrect.');
						$('#login-alert').css('display','block');						
					}
				}
			});
			
		}
		
		function forgotPassword() {
		
		}
	
	</script>

<div class="login-footer"><p>Copyright &copy; IT Worx <?php echo date("Y"); ?>. All Rights Reserved.</p></div>
<?php include 'modals.php'; ?>
<script src="dist/js/validator.min.js"></script>
<script src="js/jquery.blockUI.js"></script>
<script src="js/global.js"></script>
<script src="js/login.js"></script>
</body>

</html>
