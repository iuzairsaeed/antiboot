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

	<title><?php echo $web_title;?>Admin Dashboard</title>

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
			
				<div class="col-sm-3">
					
					<div class="xe-widget xe-counter" data-count=".num" data-from="0" data-to="<?php echo $stats -> earnedToday($odb); ?>" data-duration="3" data-easing="false">
						<div class="xe-icon">
							<i class="fa-dollar"></i>
						</div>
						<div class="xe-label">
							<strong class="num"><?php echo $stats -> earnedToday($odb); ?></strong>
							<span>Earned Today</span>
						</div>
					</div>
					
				</div>
				
				<div class="col-sm-3">
					
					<div class="xe-widget xe-counter xe-counter-blue" data-count=".num" data-from="0" data-to="<?php echo $stats -> earnedThisWeek($odb); ?>" data-duration="3" data-easing="true">
						<div class="xe-icon">
							<i class="fa-dollar"></i>
						</div>
						<div class="xe-label">
							<strong class="num"><?php echo $stats -> earnedThisWeek($odb); ?></strong>
							<span>Earned This Week</span>
						</div>
					</div>
				
				</div>
				
				<div class="col-sm-3">
					
					<div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="0" data-to="<?php echo $stats -> earnedThisMonth($odb) + $stats -> totalApis($odb); ?>" data-duration="3" data-easing="true">
						<div class="xe-icon">
							<i class="fa-dollar"></i>
						</div>
						<div class="xe-label">
							<strong class="num"><?php echo $stats -> earnedThisMonth($odb) + $stats -> totalApis($odb); ?></strong>
							<span>Earned This Month</span>
						</div>
					</div>
				
				</div>
				
				<div class="col-sm-3">
					
					<div class="xe-widget xe-counter xe-counter-red" data-count=".num" data-from="0" data-to="<?php echo $stats -> earnedOverall($odb); ?>" data-duration="3" data-easing="true">
						<div class="xe-icon">
							<i class="fa-dollar"></i>
						</div>
						<div class="xe-label">
							<strong class="num"><?php echo $stats -> earnedOverall($odb); ?></strong>
							<span>Total Earned</span>
						</div>
					</div>
				
				</div>
				
				<div class="clearfix"></div>
			
				<div class="col-sm-12">
					<div class="panel panel-color panel-gray" >
						<div class="panel-heading">
							<h3 class="panel-title">Admin Notes</h3>
						</div>
						
						<div class="panel-body" >
							<p>You can have your notes here</p>	
						</div>
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