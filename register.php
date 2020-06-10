<?php
ob_start();
include 'engine/config.php';
include 'engine/init.php';

if ($user -> LoggedIn())
{
	header('location: index.php');
	die();
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if (isset($_POST['registerBtn']))
{
  $captcha = $_POST['g-recaptcha-response'];
  $response=file_get_contents($secret_key."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
  if($response.success==false || !($captcha))
  {
    echo '<div class="alert alert-block alert-danger fade in"   style="background:#2d2b2b;border:none;"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button></strong> Invalid captcha code entered.</div>';
  } else {
    $username = $_POST['username'];
    $password = $_POST['passwd'];
    $repeat = $_POST['rpasswd'];
    $email = $_POST['email'];
    $terms = $_POST['terms'];
    $errors = array();
    if (empty($username) || empty($password) || empty($repeat) || empty($email))
    {
      $errors[] = 'Please fill in all required fields.';
    }
    $checkUsername = $odb -> prepare("SELECT * FROM `users` WHERE `username`= :username");
    $checkUsername -> execute(array(':username' => $username));
    $countUsername = $checkUsername -> rowCount();
    if ($countUsername != 0)
    {
    $errors[] = 'The username you have entered is already in use.';
    }
    $checkEmail = $odb -> prepare("SELECT * FROM `users` WHERE `email`= :email");
    $checkEmail -> execute(array(':email' => $email));
    $countEmail = $checkEmail -> rowCount();
    if ($countEmail0 != 0)
    {
      $errors[] = 'The email you have entered is already in use.';
    }
      if (strlen($_POST['passwd']) < 4) {
      $errors[] = 'The username you have entered is too short.';
      }
      if (strlen($_POST['username']) > 15) {
      $errors[] = 'The username you have entered is too long.';
      }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $errors[] = 'You have entered an invalid e-mail address.';
    }
    if (!ctype_alnum($username))
    {
      $errors[] = 'The username you have entered is invalid.';
    }
    if ($password != $repeat)
    {
      $errors[] = 'The passwords you have entered does not match.';
    }
    /*
    if ($terms != 'agree')
    {
      $errors[] = 'You have to agree t.o.s before using our service.';
    }*/
    if (empty($errors))
    {
      $sha = hash("sha512", $password);
      $activation = generateRandomString();
      $insertUser = $odb -> prepare("INSERT INTO `users` VALUES(NULL, :username, :password, :email, 0, :package, :maxboot, $date_to_expire, 0, 0)");
      $insertUser -> execute(array(':username' => $username, ':password' => $sha, ':email' => $email, ':package' => $package_default, ':maxboot' => $maxboot_default));
      //Send mail here
      
      $success_modal = 'You have registered your account successfully! Redirecting..</div><meta http-equiv="refresh" content="3;url=login.php">';
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

?>
<!DOCTYPE html>

<html lang="en">

<head>

<?php require_once("include/head.php"); ?>

</head>



  <body class="bg-gray-900">
  <?php require_once("include/modal.php"); ?>

  <!-- Add class "fade-in-effect" for login form effect -->
  <form method="post" role="form" id="register" class="login-form fade-in-effect">
    <div class="signpanel-wrapper">

      <div class="signbox signup">

        <div class="signbox-header">

        <h2><?php echo $my_site_name; ?></h2>

          <p class="mg-b-0">Signup Page</p>

        </div><!-- signbox-header -->

        <div class="signbox-body">

          <div class="form-group">

            <label class="form-control-label">Email:</label>

            <input type="email" name="email" id="email" autocomplete="off" class="form-control" placeholder="Type email address" autofocus required>

          </div><!-- form-group -->



          <div class="row row-xs">

            <div class="col-sm">

              <div class="form-group">

                <label class="form-control-label">Username:</label>

                <input type="username" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" required>

              </div><!-- form-group -->

            </div><!-- col -->

            
          </div><!-- row -->



          <div class="row row-xs">

            <div class="col-sm">

              <div class="form-group">

                <label class="form-control-label">Password:</label>

                <input type="password" name="passwd" id="passwd" autocomplete="off" class="form-control" placeholder="Type password" required>

              </div><!-- form-group -->

            </div><!-- col -->

            <div class="col-sm">

              <div class="form-group">

                <label class="form-control-label">Confirm Password:</label>

                <input type="password" name="rpasswd" id="rpasswd" autocomplete="off" class="form-control" placeholder="Retype password" required>

              </div><!-- form-group -->

            </div><!-- col -->

          </div><!-- row -->
          <div class="form-group">
						<center><div class="g-recaptcha" data-sitekey="<?php echo $site_key;?>"></div></center>

						

					</div>


          <button type="submit" name="registerBtn" class="btn btn-success btn-block">Sign Up</button>

          <div class="tx-center bd pd-10 mg-t-40">Already have an account? <a href="login.php">Sign In</a></div>

        </div><!-- signbox-body -->

      </div><!-- signbox -->

    </div><!-- signpanel-wrapper -->
  </form>


  <?php require_once('include/js.php');?>
    <script type="text/javascript">
					jQuery(document).ready(function($)
					{
						setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);
	
	
						// Validation and Ajax action
						$("form#register").validate({
							rules: {
								username: {
									required: true
								},
								
								email: {
									required: true
								},
	
								passwd: {
									required: true
								},
								
								rpasswd: {
									required: true
								}
							},
	
						
						// Set Form focus
						$("form#register .form-group:has(.form-control):first .form-control").focus();
					});
				</script>
        
  </body>

</html>

