<?php
ob_start(); 
require_once '../engine/config.php';
require_once '../engine/init.php';

if (!($user -> LoggedIn()))
{
	header('Location: ../login.php');
	die();
}
if ($user -> IsBanned($odb))
{
	header('Location: ../logout.php');
	die();
}
if (!($user -> IsAdmin($odb)))
{
	header('Location: ../index.php');
	die();
}

$id = '1';
$SQLGetSettings = $odb -> prepare("SELECT * FROM `settings` WHERE `id` = :id LIMIT 1");
$SQLGetSettings -> execute(array(':id' => $id));
$getInfo = $SQLGetSettings -> fetch(PDO::FETCH_ASSOC);
$siteurl = $getInfo['siteurl'];
$sitetitle = $getInfo['sitetitle'];
$sitemail = $getInfo['sitemail'];
$contactmail = $getInfo['contact'];
$ppmail = $getInfo['paypal'];
$btcaddress = $getInfo['btc'];
$skypeapi = $getInfo['skypeapi'];
$trialseconds = $getInfo['trialseconds'];
$custompackages = $getInfo['custompackages'];
$custompbase = $getInfo['custompbase'];
$mailingtype = $getInfo['mailingtype'];
$smtphost = $getInfo['smtphost'];
$smtpuser = $getInfo['smtpuser'];
$smtppass = $getInfo['smtppass'];
$smtpport = $getInfo['smtpport'];
$cpmerchant = $getInfo['cpmerchant'];
$cpipnsecret = $getInfo['cpipnsecret'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>System Settings</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="../assets/css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="../assets/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/css/xenon-core.css">
	<link rel="stylesheet" href="../assets/css/xenon-forms.css">
	<link rel="stylesheet" href="../assets/css/xenon-components.css">
	<link rel="stylesheet" href="../assets/css/xenon-skins.css">
	<link rel="stylesheet" href="../assets/css/custom.css">

	<script src="../assets/js/jquery-1.11.1.min.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<div class="page-loading-overlay">
	<div class="loader-2"></div>
</div>
<body class="page-body">
	
	<div class="page-container">
			
		<?php include 'templates/sidebar.php'; ?>
	
		<div class="main-content">
					
			<?php include 'templates/navbar.php'; ?>
			
			<div class="row">
						
				<div class="col-sm-12">
					<?php
			if (isset($_POST['updateGeneral']))
			{
				$update = false;
				$errors = array();
				
				if ($siteurl != $_POST['siteurl'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `siteurl` = :siteurl WHERE `id` = :id");
					$SQL -> execute(array(':siteurl' => $_POST['siteurl'], ':id' => $id));
					$update = true;
					$siteurl = $_POST['siteurl'];
				}
				if ($sitetitle != $_POST['sitetitle'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `sitetitle` = :sitetitle WHERE `id` = :id");
					$SQL -> execute(array(':sitetitle' => $_POST['sitetitle'], ':id' => $id));
					$update = true;
					$sitetitle = $_POST['sitetitle'];
				}
				if ($sitemail != $_POST['sitemail'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `sitemail` = :sitemail WHERE `id` = :id");
					$SQL -> execute(array(':sitemail' => $_POST['sitemail'], ':id' => $id));
					$update = true;
					$sitemail = $_POST['sitemail'];
				}
				if ($contactmail != $_POST['contactmail'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `contact` = :contactmail WHERE `id` = :id");
					$SQL -> execute(array(':contactmail' => $_POST['contactmail'], ':id' => $id));
					$update = true;
					$contactmail = $_POST['contactmail'];
				}
				
				if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the general settings successfully!</div>';
					}
					else
					{
						echo '<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Mhmm..</strong> No changes made.</div>';
					}
					if (!empty($errors))
					{
						echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Error!</strong><br />';
						foreach($errors as $error)
						{
							echo '- '.$error.'<br />';
						}
						echo '</div>';
					}
			}
			if (isset($_POST['updatePayment']))
			{
				$update = false;
				$errors = array();
				
				if ($ppmail != $_POST['ppmail'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `paypal` = :ppmail WHERE `id` = :id");
					$SQL -> execute(array(':ppmail' => $_POST['ppmail'], ':id' => $id));
					$update = true;
					$ppmail = $_POST['ppmail'];
				}
				if ($cpmerchant != $_POST['cpmerchant'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `cpmerchant` = :cpmerchant WHERE `id` = :id");
					$SQL -> execute(array(':cpmerchant' => $_POST['cpmerchant'], ':id' => $id));
					$update = true;
					$cpmerchant = $_POST['cpmerchant'];
				}
				if ($cpipnsecret != $_POST['cpipnsecret'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `cpipnsecret` = :cpipnsecret WHERE `id` = :id");
					$SQL -> execute(array(':cpipnsecret' => $_POST['cpipnsecret'], ':id' => $id));
					$update = true;
					$cpipnsecret = $_POST['cpipnsecret'];
				}
				
				if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the payment settings successfully!</div>';
					}
					else
					{
						echo '<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Mhmm..</strong> No changes made.</div>';
					}
					if (!empty($errors))
					{
						echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Error!</strong><br />';
						foreach($errors as $error)
						{
							echo '- '.$error.'<br />';
						}
						echo '</div>';
					}
			}
			if (isset($_POST['updateMisc']))
			{
				$update = false;
				$errors = array();
				
				if ($skypeapi != $_POST['skypeapi'])
				{
					$SQL = $odb -> prepare("UPDATE `settings` SET `skypeapi` = :skypeapi WHERE `id` = :id");
					$SQL -> execute(array(':skypeapi' => $_POST['skypeapi'], ':id' => $id));
					$update = true;
					$skypeapi = $_POST['skypeapi'];
				}
				
				if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the misc settings successfully!</div>';
					}
					else
					{
						echo '<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Mhmm..</strong> No changes made.</div>';
					}
					if (!empty($errors))
					{
						echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Error!</strong><br />';
						foreach($errors as $error)
						{
							echo '- '.$error.'<br />';
						}
						echo '</div>';
					}
			}
			
			?>
			<section class="panel" style = "box-shadow:4px 5px 4px rgba(0, 0, 0, .5);">
					<header class="panel-heading custom-tab dark-tab">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#general" data-toggle="tab">General Settings</a>
							</li>
							<li class="">
								<a href="#payment" data-toggle="tab">Payment Settings</a>
							</li>
							<li class="">
								<a href="#misc" data-toggle="tab">Misc. Settings</a>
							</li>
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane active" id="general">
								<form class="form-horizontal adminex-form" method="post">
									<div class="form-group">
										<label class="col-sm-3 control-label">Website Title</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="sitetitle" placeholder="My Booter" value="<?php echo $sitetitle; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Website URL</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="siteurl" placeholder="Ex; mybooter.com or mybooter.com/path" value="<?php echo $siteurl; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Site Mail</label>
										<div class="col-sm-6">
											<input type="email" class="form-control" name="sitemail" placeholder="Enter the address which the system mails will be sent from" value="<?php echo $sitemail; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Contact Mail</label>
										<div class="col-sm-6">
											<input type="email" class="form-control" name="contactmail" placeholder="Will be used for contact form" value="<?php echo $contactmail; ?>">
										</div>
									</div>
									<div class="col-lg-offset-5 col-sm-5 btn-group">
										<button type="submit" name="updateGeneral" class="col-sm-5 btn btn-primary">Update General Settings</button>
									</div>  
								</form>
							</div>
							<div class="tab-pane" id="payment">
								<form class="form-horizontal adminex-form" method="post">
									<div class="form-group">
										<label class="col-sm-3 control-label">Paypal E-Mail</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="ppmail" value="<?php echo $ppmail; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Coinpayments Merchant ID</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="cpmerchant" value="<?php echo $cpmerchant; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Coinpayments IPN Secret</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="cpipnsecret" value="<?php echo $cpipnsecret; ?>">
										</div>
									</div>
									<div class="col-lg-offset-5 col-sm-5 btn-group">
										<button type="submit" name="updatePayment" class="col-sm-5 btn btn-primary">Update Payment Settings</button>
									</div>  
								</form>
							</div>
							<div class="tab-pane" id="misc">
								<form class="form-horizontal adminex-form" method="post">
									<div class="form-group">
										<label class="col-sm-3 control-label">Skype API</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="skypeapi" placeholder="http://skyeapi.com/resolve.php?name=:skypename" value="<?php echo $skypeapi; ?>">
										</div>
									</div>
									<div class="col-lg-offset-5 col-sm-5 btn-group">
										<button type="submit" name="updateMisc" class="col-sm-5 btn btn-primary">Update Misc Settings</button>
									</div>  
								</form>
							</div>
						</div>
					</div>
				</section>
				</div>
							
				<div class="clearfix"></div>
				
			</div>
			
			<?php include 'templates/footer.php'; ?>
		</div>
		
	</div>
	

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="../assets/css/fonts/meteocons/css/meteocons.css">

	<!-- Bottom Scripts -->
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/TweenMax.min.js"></script>
	<script src="../assets/js/resizeable.js"></script>
	<script src="../assets/js/joinable.js"></script>
	<script src="../assets/js/xenon-api.js"></script>
	<script src="../assets/js/xenon-toggles.js"></script>


	<!-- Imported scripts on this page -->
	<script src="../assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../assets/js/xenon-widgets.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="../assets/js/xenon-custom.js"></script>

</body>
</html>