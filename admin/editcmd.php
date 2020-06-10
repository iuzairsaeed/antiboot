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
	header('location: servers.php');
	die();
}

$checkIfExists = $odb -> prepare("SELECT * FROM `commands` WHERE `id` = :cid");
$checkIfExists -> execute(array(':cid' => $_GET['id']));
if($checkIfExists -> rowCount() == 0) 
{
	header('location: servers.php');
	die();
}
$id = $_GET['id'];
$SQLGetServer = $odb -> prepare("SELECT * FROM `commands` WHERE `id` = :id LIMIT 1");
$SQLGetServer -> execute(array(':id' => $_GET['id']));
$getInfo = $SQLGetServer -> fetch(PDO::FETCH_ASSOC);
$serverid = $getInfo['sid'];
$command = $getInfo['command'];
$stopcmd = $getInfo['stopCmd'];
$method = $getInfo['method'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>Edit Command</title>

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
				   if (isset($_POST['updateCmd']))
				   {
					$update = false;
					$errors = array();
					if ($command != $_POST['command'])
					{
						$SQL = $odb -> prepare("UPDATE `commands` SET `command` = :cmd WHERE `id` = :id");
						$SQL -> execute(array(':cmd' => $_POST['command'], ':id' => $id));
						$update = true;
						$command = $_POST['command'];
					}
					if ($stopcmd != $_POST['stopcmd'])
					{
						$SQL = $odb -> prepare("UPDATE `commands` SET `stopCmd` = :cmd WHERE `id` = :id");
						$SQL -> execute(array(':cmd' => $_POST['stopcmd'], ':id' => $id));
						$update = true;
						$stopcmd = $_POST['stopcmd'];
					}
					if ($method != $_POST['method'])
					{
						$SQL = $odb -> prepare("UPDATE `commands` SET `method` = :method WHERE `id` = :id");
						$SQL -> execute(array(':method' => $_POST['method'], ':id' => $id));
						$update = true;
						$method = $_POST['method'];
					}
					if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the command!</div>';
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
				   if (isset($_POST['deleteCmd']))
				   {
					$sql = $odb -> prepare("DELETE FROM `commands` WHERE `id` = :id");
					$sql -> execute(array(':id' => $id));
					echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> Command has been removed! Redirecting in 2 ...</div><meta http-equiv="REFRESH" content="2;url=servers.php">';
				   }
				  ?>
                <section class="panel">
                    <header class="panel-heading">
                        Edit Command
                    </header>
                    <div class="panel-body">
					<form class="form-horizontal adminex-form" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Command</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="command" value="<?php echo $command; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Stop Command</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="stopcmd" value="<?php echo $stopcmd; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Method</label>
                        <div class="col-sm-4">
                            <select name="method" class="form-control">
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
					<div class="col-lg-offset-4 col-sm-4 btn-group">
						<button type="submit" name="updateCmd" class="col-sm-4 btn btn-primary">Update Command</button>
						<button type="button" href="deleteCmd" onclick="return confirm('Are you sure?')" class="col-sm-4 btn btn-danger">Delete Command</button>
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