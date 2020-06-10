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


$SQLGetHomePage = $odb -> prepare("SELECT homepage FROM `settings` WHERE `id` = 1 LIMIT 1");
$SQLGetHomePage -> execute();
$getInfo = $SQLGetHomePage -> fetch(PDO::FETCH_ASSOC);
$hptext = $getInfo['homepage'];

$SQLGetUserI = $odb -> prepare("SELECT `package`,`maxboot` FROM `users` WHERE `id` = :id LIMIT 1");
$SQLGetUserI -> execute(array(':id' => $_SESSION['ID']));
$packageInfo = $SQLGetUserI -> fetchColumn(0);
$userpackage = $packageInfo['package'];
if($userpackage > 0){
	$SQLGetTime = $odb -> prepare("SELECT `packages`.`mbt` FROM `packages` LEFT JOIN `users` ON `users`.`package` = `packages`.`ID` WHERE `users`.`ID` = :id");
	$SQLGetTime -> execute(array(':id' => $_SESSION['ID']));
	$maxboott = $SQLGetTime -> fetchColumn(0);
	$SQL = $odb -> prepare("UPDATE `users` SET `maxboot` = :maxboot WHERE `ID` = :id");
	$SQL -> execute(array(':maxboot' => $maxboott, ':id' => $_SESSION['ID']));
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
          <span class="breadcrumb-item active">Dashboard</span>
        </nav>
      </div><!-- sh-breadcrumb -->
      <div class="sh-pagetitle">
        <div class="input-group">          
        </div><!-- input-group -->
        <div class="sh-pagetitle-left">
          <div class="sh-pagetitle-icon"><i class="icon ion-ios-home"></i></div>
          <div class="sh-pagetitle-title">
            <span>All Features Summary</span>
            <h2>Dashboard</h2>
          </div><!-- sh-pagetitle-left-title -->
        </div><!-- sh-pagetitle-left -->
      </div><!-- sh-pagetitle -->

      <div class="sh-pagebody">
      <?php require_once("include/modal.php"); ?>
        <!-- Put your content here -->
        
        <!-- end of your content -->
      </div><!-- sh-pagebody -->
      <?php require_once('include/footer.php'); ?>
    </div><!-- sh-mainpanel -->
    <?php require_once('include/js.php');?>
  </body>
</html>
