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

if (!isset($_GET['id']))
{
	header('location: packages.php');
	die();
}

$checkIfExists = $odb -> prepare("SELECT * FROM `packages` WHERE `id` = :package");
$checkIfExists -> execute(array(':package' => $_GET['id']));
if($checkIfExists -> rowCount() == 0) 
{
	header('location: packages.php');
	die();
}
$id = $_GET['id'];
$SQLGetPackages = $odb -> prepare("SELECT * FROM `packages` WHERE `id` = :id LIMIT 1");
$SQLGetPackages -> execute(array(':id' => $_GET['id']));
$getInfo = $SQLGetPackages -> fetch(PDO::FETCH_ASSOC);
$name = $getInfo['name'];
$price = $getInfo['price'];
$maxboot = $getInfo['mbt'];
$unit = $getInfo['unit'];
$length = $getInfo['length'];
$concurrents = $getInfo['concurrents'];
$methods = $getInfo['methods'];
$public = $getInfo['public'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>Edit Package</title>

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
					if (isset($_POST['updatePackage']))
					{
						$update = false;
						$errors = array();
						if ($name != $_POST['name'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `name` = :name WHERE `id` = :id");
							$SQL -> execute(array(':name' => $_POST['name'], ':id' => $id));
							$update = true;
							$name = $_POST['name'];
						}
						if ($price != $_POST['price'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `price` = :price WHERE `id` = :id");
							$SQL -> execute(array(':price' => $_POST['price'], ':id' => $id));
							$update = true;
							$price = $_POST['price'];
						}
						if ($maxboot != $_POST['maxboot'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `mbt` = :maxboot WHERE `id` = :id");
							$SQL -> execute(array(':maxboot' => $_POST['maxboot'], ':id' => $id));
							$update = true;
							$maxboot = $_POST['maxboot'];
						}
						if ($concurrents != $_POST['concurrents'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `concurrents` = :concurrents WHERE `id` = :id");
							$SQL -> execute(array(':concurrents' => $_POST['concurrents'], ':id' => $id));
							$update = true;
							$concurrents = $_POST['concurrents'];
						}
						if ($unit != $_POST['unit'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `unit` = :unit WHERE `id` = :id");
							$SQL -> execute(array(':unit' => $_POST['unit'], ':id' => $id));
							$update = true;
							$unit = $_POST['unit'];
						}
						if ($length != $_POST['length'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `length` = :length WHERE `id` = :id");
							$SQL -> execute(array(':length' => $_POST['length'], ':id' => $id));
							$update = true;
							$length = $_POST['length'];
						}
						if ($public != $_POST['public'])
						{
							$SQL = $odb -> prepare("UPDATE `packages` SET `public` = :public WHERE `id` = :id");
							$SQL -> execute(array(':public' => $_POST['public'], ':id' => $id));
							$update = true;
							$public = $_POST['public'];
						}
						if (empty($_POST['methods']))
						{
							$errors[] = 'Please select the allowed methods for this package.';
						} else {
							$SQL = $odb -> prepare("UPDATE `packages` SET `methods` = :methods WHERE `id` = :id");
							$SQL -> execute(array(':methods' => json_encode($_POST['methods']), ':id' => $id));
							$update = true;
							$methods = json_encode($_POST['methods']);
						}
						if ($update == true)
						{
							echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the package information!</div>';
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
					
					if (isset($_POST['deletePackage']))
					{
						$sql = $odb -> prepare("DELETE FROM `packages` WHERE `id` = :id");
						$sql -> execute(array(':id' => $id));
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> The package has been removed! Redirecting in 2 ...</div><meta http-equiv="REFRESH" content="2;url=packages.php">';
					}
				?>
                <section class="panel">
                    <header class="panel-heading">
                        Update Package Information
                    </header>
                    <div class="panel-body">
					<div class="alert alert-info fade in">
						<button type="button" class="close close-sm" data-dismiss="alert">
							<i class="fa fa-times"></i>
						</button>
						<strong>Notice:</strong> Don't forget to <u>re-select</u> the allowed methods while you are updating the package information.
					</div>
					<form class="form-horizontal adminex-form" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Package Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="control-label control-label col-lg-3" for="inputSuccess">Duration</label>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="text" name="length" class="form-control" value="<?php echo $length; ?>">
                                </div>
                                <div class="col-lg-3">
                                    <select name="unit" class="form-control">
										<?php
											function selectedR($check, $unit)
											{
												if ($check == $unit)
												{
													return 'selected="selected"';
												}
											}
										?>
										<option value="Days" <?php echo selectedR('Days', $unit); ?>>Day(s)</option>
										<option value="Months" <?php echo selectedR('Months', $unit); ?>>Month(s)</option>
										<option value="Years" <?php echo selectedR('Years', $unit); ?>>Year(s)</option>
									</select>
                                </div>
                            </div>

                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Max Boot Time</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="maxboot" value="<?php echo $maxboot; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Concurrents</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="concurrents" value="<?php echo $concurrents; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Allowed Methods</label>
                        <div class="col-sm-6">
                            <select name="methods[]" multiple="" class="form-control">
								<?php 
									$GetMethods = $odb -> query("SELECT * FROM `methods`");
									while($methodnames = $GetMethods -> fetch(PDO::FETCH_ASSOC))
									{
										//$mi = $methods['id'];
										$mn = $methodnames['method'];
										echo '<option value="'.$mn.'">'.$mn.'</option>';
									}
								?>
							</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Is Public Package ?</label>
                        <div class="col-sm-2">
                            <select name="public" class="form-control">
								<?php
									function selectedP($check, $public)
									{
										if ($check == $public)
										{
											return 'selected="selected"';
										}
									}
								?>
								<option value="1" <?php echo selectedP(1, $public); ?>>No</option>
								<option value="2" <?php echo selectedP(2, $public); ?>>Yes</option>
							</select>
                        </div>
                    </div>
					<div class="col-lg-offset-4 col-sm-6 btn-group">
						<button type="submit" name="updatePackage" class="col-sm-4 btn btn-primary">Update Package</button>
						<button type="button" href="deletePackage" onclick="return confirm('Are you sure?')" class="col-sm-4 btn btn-danger">Delete Package</button>
					</div> 
					</form>
                </div>
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