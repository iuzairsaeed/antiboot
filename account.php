<?php
ob_start(); 
require_once 'engine/config.php';
require_once 'engine/init.php';

if (!($user -> LoggedIn()))
{
	header('Location: login.php');
	die();
}
if ($user -> IsBanned($odb))
{
	header('Location: logout.php');
	die();
}

if (isset($_POST['updatePass'])) {
  $cpassword = $_POST['cpassword'];
  $npassword = $_POST['npassword'];
  $rpassword = $_POST['rpassword'];
  if (!empty($cpassword) && !empty($npassword) && !empty($rpassword))
  {
    if ($npassword == $rpassword)
    {
      $shacpass = hash("sha512", $cpassword);
      $shanpass = hash("sha512", $npassword);
      $SQLCheckCurrent = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
      $SQLCheckCurrent -> execute(array(':username' => $_SESSION['username'], ':password' => $shacpass));
      $countCurrent = $SQLCheckCurrent -> fetchColumn(0);
      if ($countCurrent == 1)
      {
        $SQLUpdate = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `username` = :username AND `ID` = :id");
        $SQLUpdate -> execute(array(':password' => $shanpass,':username' => $_SESSION['username'], ':id' => $_SESSION['ID']));
        $success_modal = 'You have updated your password successfully.';
      }
      else
      {
        $danger_modal = 'Your current password is not valid.';
      }
    }
    else
    {
      $danger_modal = 'New passwords does not match.';
    }
  }
  else
  {
    $danger_modal = 'Please fill in all fields.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once("include/head.php"); ?>
  </head>
<body>

  <?php require_once("include/header.php"); ?>

    <div class="sh-mainpanel">
      <div class="sh-breadcrumb">
        <nav class="breadcrumb">
          <a class="breadcrumb-item" href="<?php echo $my_site_url; ?>"><?php echo $my_site_name; ?></a>
          <span class="breadcrumb-item active">Account</span>
        </nav>
      </div><!-- sh-breadcrumb -->
      <div class="sh-pagetitle">
        <div class="input-group">          
        </div><!-- input-group -->
        <div class="sh-pagetitle-left">
          <div class="sh-pagetitle-icon"><i class="icon ion-ios-gear"></i></div>
          <div class="sh-pagetitle-title">
            <span>Update account information</span>
            <h2>Account</h2>
          </div><!-- sh-pagetitle-left-title -->
        </div><!-- sh-pagetitle-left -->
      </div><!-- sh-pagetitle -->

      <div class="sh-pagebody">
      <?php require_once("include/modal.php"); ?>
        <!-- Put your content here -->

        <div class="row row-sm mg-t-20">
        
        <div class="col-xl-6">
        <form id="default" class="form-horizontal" method="post">
        <div class="card bd-primary mg-t-20">

          <div class="card-header bg-primary tx-white">Update Account</div>

          <div class="card-body pd-sm-30">

            <div class="form-layout">

              <div class="row mg-b-25">

                <div class="col-lg-12">

                  <div class="form-group">

                    <label class="form-control-label">Current Password: </label>
                    <input type="password" name="cpassword" class="form-control">          

                  </div>

                </div><!-- col-12 -->

                <div class="col-lg-12">

                  <div class="form-group">

                    <label class="form-control-label">New Password: </label>
                    <input type="password" name="npassword" class="form-control">         

                  </div>

                </div><!-- col-12 -->

                <div class="col-lg-12">

                  <div class="form-group">

                    <label class="form-control-label">Re-type New Password: </label>
                    <input type="password" name="rpassword" class="form-control">         

                  </div>

                </div><!-- col-12 -->
                

              </div><!-- row -->



              <div class="form-layout-footer ">

                <button type="submit" name="updatePass" class="btn btn-primary">Update Password</button>

              </div><!-- form-layout-footer -->

            </div><!-- form-layout -->

          </div><!-- card-body -->

        </div>  
        </form>
        </div><!-- col 4 -->
        
        
        <div class="col-xl-6">

            <div class="card bd-primary mg-t-20">

            <div class="card-header bg-primary tx-white">Account Information </div>

            <div class="card-body pd-sm-30">

            <p><strong> Email:</strong> <?php echo $user -> getEmail($odb, $_SESSION['username']); ?></p>
							<p><strong> Plan:</strong> <?php echo $user -> getPackage($odb, $_SESSION['username']); ?></p>
							<p><strong> Boot Time:</strong> <?php echo $user -> getMBT($odb, $_SESSION['username']); ?></p>
							<p><strong> Expiration:</strong> <?php echo $user -> getExpiration($odb, $_SESSION['username']); ?></p>
              <p><?php echo $user -> progressBarPlan($odb, $_SESSION['username']); ?></p>


            </div><!-- card-body -->

            </div>

        </div>
        

        </div>
        
        <!-- end of your content -->
      </div><!-- sh-pagebody -->
      <?php require_once('include/footer.php'); ?>
    </div><!-- sh-mainpanel -->
    <?php require_once('include/js.php');?>
  </body>
</html>
