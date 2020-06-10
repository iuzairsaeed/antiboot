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

	<title><?php echo $web_title;?>Attack Logs</title>

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
					<section class="panel" style = "box-shadow:4px 5px 4px rgba(0, 0, 0, .5);">
						<header class="panel-heading">
							Attack Logs
						</header>
						<div class="panel-body">
						<script type="text/javascript">
						jQuery(document).ready(function($)
						{
							$("#table-1").dataTable({
								aLengthMenu: [
									[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
								]
							});
						});
						</script>
						<table id="table-1" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th>User</th>
							<th>Target</th>
							<th>Time</th>
							<th>Method</th>
							<th>Type</th>
						</tr>
						</thead>
						<tbody>
						<?php 
							$SQLGetLogs = $odb -> prepare("SELECT * FROM `attacklogs` ORDER BY `id`");
							$SQLGetLogs -> execute();
							while ($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
							{
								$user = $getInfo['user'];
								$target = $getInfo['ip'];
								$time = $getInfo['time'];
								$method = $getInfo['method'];
								$type = $getInfo['type'];
								if ($type == 'server')
								{
									$type = '<span class="label label-success">Server</span>';
								} else {
									$type = '<span class="label label-success">External API</span>'; 
								}
								echo '
								<tr class="gradeX">
									<td>'.$user.'</td>
									<td>'.$target.'</td>
									<td>'.$time.'</td>
									<td class="center">'.$method.'</td>
									<td class="center">'.$type.'</a></td>
								</tr>';
							}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th>User</th>
							<th>Target</th>
							<th>Time</th>
							<th>Method</th>
							<th>Type</th>
						</tr>
						</tfoot>
						</table>
						</div>
						</div>
					</section>
				</div>
							
				<div class="clearfix"></div>
				
			</div>
			
			<?php include 'templates/footer.php'; ?>
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


	<!-- Imported scripts on this page -->
	<script src="../assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../assets/js/xenon-widgets.js"></script>
	
	<script src="../assets/js/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/datatables/dataTables.bootstrap.js"></script>
	<script src="../assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
	<script src="../assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="../assets/js/xenon-custom.js"></script>

</body>
</html>