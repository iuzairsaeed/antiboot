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

$checkIfExists = $odb -> prepare("SELECT * FROM `servers` WHERE `id` = :server");
$checkIfExists -> execute(array(':server' => $_GET['id']));
if($checkIfExists -> rowCount() == 0) 
{
	header('location: servers.php');
	die();
}
$id = $_GET['id'];
$SQLGetServer = $odb -> prepare("SELECT * FROM `servers` WHERE `id` = :id LIMIT 1");
$SQLGetServer -> execute(array(':id' => $_GET['id']));
$getInfo = $SQLGetServer -> fetch(PDO::FETCH_ASSOC);
$host = $getInfo['host'];
$username = $getInfo['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>Edit Server</title>

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
				   if (isset($_POST['updateServer']))
				   {
					$update = false;
					$errors = array();
					if (!empty($_POST['password']))
					{
						$SQL = $odb -> prepare("UPDATE `servers` SET `password` = :password WHERE `id` = :id");
						$SQL -> execute(array(':password' => encryptData($_POST['password'], $encKey), ':id' => $id));
						$update = true;
						$password = encryptData($_POST['password'], $encKey);
					}
					if ($host != $_POST['serverip'])
					{
						$SQL = $odb -> prepare("UPDATE `servers` SET `host` = :host WHERE `id` = :id");
						$SQL -> execute(array(':host' => $_POST['serverip'], ':id' => $id));
						$update = true;
						$host = $_POST['serverip'];
					}
					if ($username != $_POST['username'])
					{
						$SQL = $odb -> prepare("UPDATE `servers` SET `username` = :username WHERE `id` = :id");
						$SQL -> execute(array(':username' => $_POST['username'], ':id' => $id));
						$update = true;
						$username = $_POST['username'];
					}
					if (empty($_POST['methods']))
					{
						$errors[] = 'Please select the available methods for this server.';
					} else {
						$SQL = $odb -> prepare("UPDATE `servers` SET `methods` = :methods WHERE `id` = :id");
						$SQL -> execute(array(':methods' => json_encode($_POST['methods']), ':id' => $id));
						$update = true;
						$methods = json_encode($_POST['methods']);
					}
					if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the server information!</div>';
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
				   
				   if(isset($_POST['addCmd']))
				   {
					  $sCommand = $_POST['sCommand'];
					  $sStopCmd = $_POST['stopCmd'];
					  $sMethod = $_POST['sMethod'];
					  
					  // Check if the method command added before.
					  
					  
					  if(empty($sCommand) || empty($sMethod))
					  {
						echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Error!</strong> Please fill in all required fields. </div>';
					  } else {
						if ($sStopCmd == NULL)
						{
							$sStopCmd = 'none';
						}
						$insertCmd = $odb -> prepare("INSERT INTO `commands` VALUES (NULL, :server, :command, :stopcmd, :method)");
						$insertCmd -> execute(array(':server' => $id, ':command' => $sCommand, ':stopcmd' => $sStopCmd, ':method' => $sMethod));
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong><br> You have added a new command to the server successfully!</div>';
					  }
					  
				   }
				   
				   if (isset($_POST['deleteServer']))
					{
						$sql = $odb -> prepare("DELETE FROM `servers` WHERE `id` = :id");
						$sql -> execute(array(':id' => $id));
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> The server has been removed! Redirecting in 2 ...</div><meta http-equiv="REFRESH" content="2;url=servers.php">';
					}
				  ?>
                <section class="panel">
                    <header class="panel-heading">
                        Edit Server Information
                    </header>
                    <div class="panel-body">
					<div class="alert alert-info fade in">
						<button type="button" class="close close-sm" data-dismiss="alert">
							<i class="fa fa-times"></i>
						</button>
						<strong>Notice:</strong> Don't forget to <u>re-select</u> the available methods while you are updating the server information.
					</div>
					<form class="form-horizontal adminex-form" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Server IP</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="serverip" value="<?php echo $host; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Server Username</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Server Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password" placeholder="Leave blank if you don't want to update">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Methods</label>
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
					<!--
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Command</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="command" ata-trigger="hover" data-toggle="tooltip" placeholder="For example; ./:method :host :time :port list.txt :power" title="" data-original-title="For example; ./:method :host :time :port list.txt :power">
                            <span class="help-block">Use <strong>":host, :port, :time, :method, :power"</strong> variables in your command.</span>
                        </div>
                    </div> -->
					<div class="col-lg-offset-4 col-sm-4 btn-group">
						<button type="submit" name="updateServer" class="col-sm-4 btn btn-primary">Update Server</button>
						<button type="button" data-toggle="modal" data-target="#modal-addcmd" class="col-sm-4 btn btn-info">Add Command</button>
						<button type="button" href="deleteServer" onclick="return confirm('Are you sure?')" class="col-sm-4 btn btn-danger">Delete Server</button>
					</div>   
					<div class="modal fade" id="modal-addcmd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Add Server Command</h4>
						  </div>
						  <div class="modal-body">
							<form method="post" class="form-horizontal" role="form">
									<div class="form-group">
										<label for="serverCmd" class="col-lg-2 col-sm-2 control-label">Command</label>
										<div class="col-lg-10">
											<input type="text" name="sCommand" id="serverCmd" class="form-control" placeholder="Example; ./syn :host :port :time list.txt :power">
										</div>
									</div>
									<div class="form-group">
										<label for="stopCmd" class="col-lg-2 col-sm-2 control-label">Stop Command</label>
										<div class="col-lg-10">
											<input type="text" name="stopCmd" id="stopCmd" class="form-control" placeholder="Example; ./stop ssyn :target">
										</div>
									</div>
									<div class="form-group">
										<label for="serverMethod" class="col-lg-2 col-sm-2 control-label">Method</label>
										<div class="col-sm-6">
											<select name="sMethod" id="serverMethod" class="form-control">
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
								</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" name="addCmd" class="col-sm-5 btn btn-primary">Add Command</button>
						  </div>
						</div>
					  </div>
					</div>
						<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirmDelete" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
										<h4 class="modal-title">Are you sure ?</h4>
									</div>
									<div class="modal-body">

										Do you really want to remove this server from the system ? <br>
										Please note that this action can not be un-done!

									</div>
									<form method="post">
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" name="deleteServer" class="btn btn-danger">Confirm</button>
									</div>
									</form>
								</div>
							</div>
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