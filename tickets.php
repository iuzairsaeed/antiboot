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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>View Tickets</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="assets/css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="assets/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/xenon-core.css">
	<link rel="stylesheet" href="assets/css/xenon-forms.css">
	<link rel="stylesheet" href="assets/css/xenon-components.css">
	<link rel="stylesheet" href="assets/css/xenon-skins.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.1.min.js"></script>

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
					<section class="panel">
                        <header class="panel-heading custom-tab blue-tab">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#Waiting">
                                       <i class="fa fa-pencil"></i>
                                        Pending Tickets
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#Answered">
                                        <i class="fa fa-check"></i>
                                        Answered Tickets
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#Closed">
                                        <i class="fa fa-minus-circle"></i>
                                        Closed Tickets
                                    </a>
                                </li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="Waiting" class="tab-pane active">
                                    <section class="panel">
									<div class="panel-body">
										<div class="adv-table">
										<table  class="display table table-bordered table-striped" id="dynamic-table">
											<thead>
											<tr>
												<th>Title</th>
												<th>Date</th>
												<th>Status</th>
												<th>View</th>
											</tr>
											</thead>
											<tbody>
												<?php 
													$GetPending = $odb -> prepare("SELECT * FROM `tickets` WHERE `senderid` = :sender AND `status` = 1 ORDER BY `id` DESC LIMIT 5");
													$GetPending -> execute(array(':sender' => $_SESSION['ID']));
													while ($getInfo = $GetPending -> fetch(PDO::FETCH_ASSOC))
													{
														$id = $getInfo['id'];
														$date = gmdate("F j, Y, g:i A", $getInfo['date']);
														$title = substr($getInfo['title'],0,16).'...';
														switch($getInfo['status'])
														{
														case 1:
														$status = '<span class="label label-warning label-mini">Pending</span>';
														break;
														case 2:
														$status = '<span class="label label-success label-mini">Answered</span>';
														break;
														case 3:
														$status = '<span class="label label-primary label-mini">Closed</span>';
														break;
														}
														
														echo '
														<tr class="gradeX">
															<td>'.$title.' </td>
															<td>'.$date.'</td>
															<td>'.$status.'</td>
															<td><a href="viewticket.php?id='.$id.'"><button class="btn btn-info btn-xs" type="button">View</button></a></td>
														</tr>';
													}
												?>
											</tbody>
										</table>
										</div>
									</div>
								</section>
                                </div>
                                <div id="Answered" class="tab-pane">
								<section class="panel">
									<div class="panel-body">
										<div class="adv-table">
										<table  class="display table table-bordered table-striped" id="dynamic-table">
											<thead>
											<tr>
												<th>Title</th>
												<th>Date</th>
												<th>Status</th>
												<th>View</th>
											</tr>
											</thead>
											<tbody>
												<?php 
													$GetAnswered = $odb -> prepare("SELECT * FROM `tickets` WHERE `senderid` = :sender AND `status` = 2 ORDER BY `id` DESC LIMIT 5");
													$GetAnswered -> execute(array(':sender' => $_SESSION['ID']));
													while ($getInfo = $GetAnswered -> fetch(PDO::FETCH_ASSOC))
													{
														$id = $getInfo['id'];
														$date = gmdate("F j, Y, g:i A", $getInfo['date']);
														$title = substr($getInfo['title'],0,16).'...';
														switch($getInfo['status'])
														{
														case 1:
														$status = '<span class="label label-warning label-mini">Pending</span>';
														break;
														case 2:
														$status = '<span class="label label-success label-mini">Answered</span>';
														break;
														case 3:
														$status = '<span class="label label-primary label-mini">Closed</span>';
														break;
														}
														
														echo '
														<tr class="gradeX">
															<td>'.$title.' </td>
															<td>'.$date.'</td>
															<td>'.$status.'</td>
															<td><a href="viewticket.php?id='.$id.'"><button class="btn btn-info btn-xs" type="button">View</button></a></td>
														</tr>';
													}
												?>
											</tbody>
										</table>
										</div>
									</div>
								</section>
								</div>
                                <div id="Closed" class="tab-pane ">
								<section class="panel">
									<div class="panel-body">
										<div class="adv-table">
										<table  class="display table table-bordered table-striped" id="dynamic-table">
											<thead>
											<tr>
												<th>Title</th>
												<th>Date</th>
												<th>Status</th>
												<th>View</th>
											</tr>
											</thead>
											<tbody>
												<?php 
													$GetClosed = $odb -> prepare("SELECT * FROM `tickets` WHERE `senderid` = :sender AND `status` = 3 ORDER BY `id` DESC LIMIT 5");
													$GetClosed -> execute(array(':sender' => $_SESSION['ID']));
													while ($getInfo = $GetClosed -> fetch(PDO::FETCH_ASSOC))
													{
														$id = $getInfo['id'];
														$date = gmdate("F j, Y, g:i A", $getInfo['date']);
														$title = substr($getInfo['title'],0,16).'...';
														switch($getInfo['status'])
														{
														case 1:
														$status = '<span class="label label-warning label-mini">Pending</span>';
														break;
														case 2:
														$status = '<span class="label label-success label-mini">Answered</span>';
														break;
														case 3:
														$status = '<span class="label label-primary label-mini">Closed</span>';
														break;
														}
														
														echo '
														<tr class="gradeX">
															<td>'.$title.' </td>
															<td>'.$date.'</td>
															<td>'.$status.'</td>
															<td><a href="viewticket.php?id='.$id.'"><button class="btn btn-info btn-xs" type="button">View</button></a></td>
														</tr>';
													}
												?>
											</tbody>
										</table>
										</div>
									</div>
								</section>
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
	<link rel="stylesheet" href="assets/css/fonts/meteocons/css/meteocons.css">

	<!-- Bottom Scripts -->
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/TweenMax.min.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/xenon-api.js"></script>
	<script src="assets/js/xenon-toggles.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/js/xenon-widgets.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/xenon-custom.js"></script>

</body>
</html>