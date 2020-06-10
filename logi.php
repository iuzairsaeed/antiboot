<?php
ob_start(); 
require_once 'engine/config.php';
require_once 'engine/init.php';

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title><?php echo $web_title;?>Login</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="assets/css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="assets/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/xenon-forms.css">
	<link rel="stylesheet" href="assets/css/xenon-components.css">
	<link rel="stylesheet" href="assets/css/xenon-skins.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.1.min.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<style>
.form-control {
    color: #fff;
    background-color: #444549;
    border: 0px solid #444549;
}
.form-control:focus {
    border-color: none;
    outline: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
}
html .select2-container .select2-choice {
    background: #4c5667!important;
    border-color: #4c5667!important;
    color:#2f343e;
    border: 0px solid #e4e4e4;
}
.login-header {
    text-align: center !important;    
}
.indigo {
    background: #414f9e;
    color: white;
    text-transform: uppercase;
    padding: 8px 14px;
}
</style>
</head>
<body class="page-body logifn-page" style="padding-top:30vh">

	
	<div class="login-container">
	
		<div class="row">
			
			<div class="col-sm-6 col-sm-offset-3">
				<script type="text/javascript">
				
					jQuery(document).ready(function($)
					{
						// Reveal Login form
						setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);
	
	
						// Validation and Ajax action
						$("form#login").validate({
							rules: {
								username: {
									required: true
								},
	
								passwd: {
									required: true
								}
							},
	
						
								}
							},
						});
	
						// Set Form focus
						$("form#login .form-group:has(.form-control):first .form-control").focus();
					});
				</script>
	
				<div class="errors-container">
					<?php
						if (!($user -> LoggedIn()))
						{
							if (isset($_POST['loginBtn']))
							{
								$username = $_POST['username'];
								$password = $_POST['passwd'];
								$errors = array();
								if (empty($username) || empty($password))
								{
									$errors[] = 'Please enter your username and password.';
								}
								if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15)
								{
									$errors[] = 'Username must be 4-15 characters and alphanumeric only!';
								}
								
								if (empty($errors))
								{
									$sha = hash("sha512", $password);
									$SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
									$SQLCheckLogin -> execute(array(':username' => $username, ':password' => $sha));
									$countLogin = $SQLCheckLogin -> fetchColumn(0);
									if ($countLogin == 1)
									{
										$SQLGetInfo = $odb -> prepare("SELECT `username`, `ID`,`status` FROM `users` WHERE `username` = :username AND `password` = :password");
										$SQLGetInfo -> execute(array(':username' => $username, ':password' => $sha));
										$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
										$status = $userInfo['status'];
										$userid = $userInfo['ID'];
										$userip = $_SERVER['REMOTE_ADDR'];
										if ($status == 1)
										{
											echo '<div class="alert alert-block alert-danger fade in" style="background:#2d2b2b;border:none;"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oops!</strong> Your account has been banned.</div>';
										}
										elseif ($status == 0)
										{
										$username = $userInfo['username'];
										
											$_SESSION['username'] = $userInfo['username'];
											$_SESSION['ID'] = $userInfo['ID'];
											$_SESSION['wsource'] = generateRandomString();
											echo '	<div class="alert alert-block alert-success fade in" style="background:#2d2b2b;border:none;"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Success!</strong> You have logged in successfully. Redirecting..
												</div><meta http-equiv="refresh" content="3;url=index.php">';
										}
									}
									else
									{
										echo '<div class="alert alert-block alert-danger fade in"  style="background:#2d2b2b;border:none;"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oops!</strong><br>Incorrect username or password entered!</div>';
									}
								}
								else
								{
									echo '<div class="alert alert-block alert-danger fade in"  style="background:#2d2b2b;border:none;"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oops! </strong><br />';
									foreach($errors as $error)
									{
										echo '- '.$error.'<br />';
									}
									echo '</div>';
								}
							}
					}
					else
					{
						header('location: index.php');
					}
					?>
				</div>

				<!-- Add class "fade-in-effect" for login form effect -->
				<form method="post" role="form" id="login" class="login-form fade-in-effect">
	
					<div class="login-header">
						<a href="index.php" class="logo">
							<img src="/assets/images/NullBooter.jpg" alt="" width="120" />
							
						</a>
	
					</div>
	
	
					<div class="form-group">
						<label class="control-label" for="username" style="color:#ddd">Username</label>
						<input type="text" class="form-control input-dark" name="username" id="username" placeholder="Enter Username" autocomplete="off" autofocus/>
					</div>
	
					<div class="form-group">
						<label class="control-label" for="passwd" style="color:#ddd">Password</label>
						<input type="password" class="form-control input-dark" name="passwd" id="passwd" placeholder="Enter Password" autocomplete="off" />
					</div>
	
					<div class="form-group" style="text-align: center">
						<button type="submit" name="loginBtn"  class="btn btn-dark btn-primary text-center" style="background:#2d2b2b;">
						
							>_ Login
						</button>
					</div>
	
					<div class="login-footer">
					<button type="submit" name="loginBtn" class="btn btn-dark  btn-block text-center">	<a href="register.php">Don't have an account ? Register here!</a>
							
							
						</div>
	
					</div>
	
				</form>
			</div>
	
		</div>
	
	</div>



	<!-- Bottom Scripts -->
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/TweenMax.min.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/xenon-api.js"></script>
	<script src="assets/js/xenon-toggles.js"></script>
	<script src="assets/js/jquery-validate/jquery.validate.min.js"></script>
	<script src="assets/js/toastr/toastr.min.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/xenon-custom.js"></script>

</body>
</html>