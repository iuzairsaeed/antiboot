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
										$SQLGetInfo = $odb -> prepare("SELECT `username`, `ID`,`status`,email FROM `users` WHERE `username` = :username AND `password` = :password");
										$SQLGetInfo -> execute(array(':username' => $username, ':password' => $sha));
										$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
										$status = $userInfo['status'];
										$userid = $userInfo['ID'];
										$userip = $_SERVER['REMOTE_ADDR'];
										if ($status == 1)
										{
											$danger_modal = 'Your account has been banned.';
										}
										elseif ($status == 0)
										{
										$username = $userInfo['username'];
                    
                      $_SESSION['email'] = $userInfo['email'];
											$_SESSION['username'] = $userInfo['username'];
											$_SESSION['ID'] = $userInfo['ID'];
											$_SESSION['wsource'] = generateRandomString();
											$success_modal = 'You have logged in successfully. Redirecting..
		                                    <meta http-equiv="refresh" content="3;url=index.php">';
										}
									}
									else
									{
										$danger_modal = 'Incorrect username or password entered!';
									}
								}
								else
								{
									
									foreach($errors as $error)
									{
										$danger_modal .= '- '.$error.'<br />';
									}
								
								}
							}
					}
					else
					{
						header('location: index.php');
					}

?>
<!DOCTYPE html>

<html lang="en">

  <head>

    <?php require_once("include/head.php"); ?>

  </head>



  <body class="bg-gray-900">
  <?php require_once("include/modal.php"); ?>

  <!-- Add class "fade-in-effect" for login form effect -->
  <form method="post" role="form" id="login" class="login-form fade-in-effect">
    <div class="signpanel-wrapper">

   

      <div class="signbox">

        <div class="signbox-header">

          <h2><?php echo $my_site_name; ?></h2>

          <p class="mg-b-0">Login Page</p>

        </div><!-- signbox-header -->

        <div class="signbox-body">

          <div class="form-group">

            <label class="form-control-label">Username:</label>

            <input type="username" name="username" placeholder="Enter your username" class="form-control" autofocus required>

          </div><!-- form-group -->

          <div class="form-group">

            <label class="form-control-label">Password:</label>

            <input type="password" name="passwd" placeholder="Enter your password" class="form-control" required>

          </div><!-- form-group -->
          <!--
          <div class="form-group">

            <a href="">Forgot password?</a>

          </div> form-group -->

          <button type="submit" name="loginBtn"  class="btn btn-success btn-block">Sign In</button>

          <div class="tx-center bg-white bd pd-10 mg-t-40">Don't have an account ? <a href="register.php"> Register here!</a></div>

        </div><!-- signbox-body -->

      </div><!-- signbox -->

    </div><!-- signpanel-wrapper -->
</form>
    <?php require_once('include/js.php');?>
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
  </body>

</html>

