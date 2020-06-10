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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>Manage Servers</title>

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
            	<div class="col-lg-12">
					<?php
					if (isset($_POST['addServer']))
					{
						$ipaddr = $_POST['serverip'];
						$username = $_POST['username'];
						$password = $_POST['password'];
						$methods = $_POST['methods'];
						$errors = array();
						
							if (empty($ipaddr) || empty($username) || empty($password) || empty($methods))
							{
								$errors[] = 'Please fill in all fields.';
							}
							
							if (!filter_var($ipaddr, FILTER_VALIDATE_IP))
							{
								$errors[] = 'Please enter a valid ip address.';
							}
							if(empty($errors)) {
								$insertServer = $odb -> prepare("INSERT INTO `servers` VALUES (NULL, :host, :username, :password, :method, 0)");
								$insertServer -> execute(array(':host' => $ipaddr, ':username' => $username, ':password' => encryptData($password, $encKey), ':method' => json_encode($methods))); //implode(",", $methods)
								echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong><br> You have added a new server successfully!</div>';
							} else {
								echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Error!</strong><br />';
								foreach($errors as $error)
								{
									echo '- '.$error.'<br />';
								}
								echo '</div>';
							}
					}
				?>
                <section class="panel" style = "box-shadow:3px 5px 4px rgba(0, 0, 0, .5);">
                    <header class="panel-heading">
                        Add New Server
                    </header>
                    <div class="panel-body">
					<form class="form-horizontal adminex-form" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Server IP</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="serverip" placeholder="127.0.0.1">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Server Username</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="username" placeholder="root">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Server Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password">
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
					<div class="col-lg-offset-4 col-lg-10">
						<button type="submit" name="addServer" class="col-sm-4 btn btn-primary">Add Server</button>
					</div>    
                </form>
            </div>
                </section>
                </div>
            </div>
			<div class="row">
			<div class="col-sm-12">
			<section class="panel"  style = "box-shadow:3px 5px 4px rgba(0, 0, 0, .5);">
			<header class="panel-heading">
				Manage Servers
			</header>
			<div class="panel-body">
			<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				$("#table-3").dataTable({
					aLengthMenu: [
						[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
					]
				});
			});
			</script>
			<table id="table-3" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Server IP</th>
				<th>Available Methods</th>
				<th>Manage</th>
			</tr>
			</thead>
			<tbody>
				<?php 
					$SQLGetServers = $odb -> prepare("SELECT * FROM `servers`");
					$SQLGetServers -> execute();
					while ($getInfo = $SQLGetServers -> fetch(PDO::FETCH_ASSOC))
					{
						$id = $getInfo['id'];
						$host = $getInfo['host'];
						$methods = json_decode($getInfo['methods'], true);
						echo '
						<tr class="gradeX">
							<td>'.$host.'</td>
							<td class="center">'.implode(", ", $methods).'</td>
							<td class="center"><a href="editserver.php?id='.$id.'"><button class="btn btn-primary" type="button">Edit Server</button></a></td>
						</tr>';
					}
				?>
			</tbody>
			<tfoot>
			<tr>
				<th>Server IP</th>
				<th>Available Methods</th>
				<th>Manage</th>
			</tr>
			</tfoot>
			</table>
			</div>
			</section>
			</div>
			</div>
			
			<?php include 'templates/footer.php'; ?>
		</div>
		
	</div>
	

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="../assets/css/fonts/meteocons/css/meteocons.css">
	<link rel="stylesheet" href="../assets/js/datatables/dataTables.bootstrap.css">

	<!-- Bottom Scripts -->
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/TweenMax.min.js"></script>
	<script src="../assets/js/resizeable.js"></script>
	<script src="../assets/js/joinable.js"></script>
	<script src="../assets/js/xenon-api.js"></script>
	<script src="../assets/js/xenon-toggles.js"></script>
	
	<script src="../assets/js/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/datatables/dataTables.bootstrap.js"></script>
	<script src="../assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
	<script src="../assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="../assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../assets/js/xenon-widgets.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="../assets/js/xenon-custom.js"></script>

</body>
</html>