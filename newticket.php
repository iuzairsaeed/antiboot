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

	<title><?php echo $web_title;?>Create New Ticket</title>

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
					<?php
						if (isset($_POST['sendTicket']))
						{
							$title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
							$details = htmlspecialchars($_POST['details'], ENT_QUOTES, 'UTF-8');
							$department = htmlspecialchars($_POST['department'], ENT_QUOTES, 'UTF-8');
							$errors = array();
							
							if(empty($title) || empty($details) || empty($department))
							{
								$errors[] = 'Please fill in all required fields.';
							}
							if(!($department == '1' || $department == '2' || $department == '3'))
							{
								$errors[] = 'Invalid department detected. Please don\'t abuse.';
							}
							if (strlen($title) > 35 || strlen($details) > 255)
							{
								$errors[] = 'Title must be 35 characters in length. Details must be 255 characters in length.';
							}
							
							if ($department == '1')
							{
								$department = 'General Inquire';
							} elseif ($department == '2') {
								$department = 'Sales';
							} elseif ($department == '3') {
								$department = 'Bug Report';
							}
							
							if (empty($errors))
							{
								$SQL = $odb -> prepare("INSERT INTO `tickets` VALUES(NULL, :department, :senderid, :title, :details, UNIX_TIMESTAMP(), 1)");
								$SQL -> execute(array(':department' => $department, ':senderid' => $_SESSION['ID'], ':title' => $title, ':details' => $details));
								echo '<div class="alert alert-block alert-success fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Success!</strong> You have sent the ticket successfully.</div>';
							}
							else
							{
								echo '<div class="alert alert-block alert-danger fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oops!</strong><br>';
								foreach($errors as $error)
								{
									echo '- '.$error.'<br />';
								}
								echo '</div>';
							}
						}
					?>
				</div>
				<div class="col-sm-12">
				<section class="panel">
                    <header class="panel-heading">
                        Create New Ticket
                    </header>
					<div class="panel-body">
					<form class="form-horizontal" role="form" method="post">
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 control-label">Department</label>
							<div class="col-lg-9">
								<select class="form-control m-bot15" name="department">
									<option value="1">General Inquire</option>
									<option value="2">Sales</option>
									<option value="3">Bug Report</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 control-label">Title</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="title" maxlength="35">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 control-label">Details</label>
							<div class="col-lg-9">
								<textarea rows="6" class="form-control" name="details" maxlength="255"></textarea>
							</div>
						</div>
						<div class="col-lg-offset-4 col-sm-7 btn-group">
							<button type="submit" name="sendTicket" class="col-sm-8 btn btn-success">Submit Ticket</button>
						</div>   
					</form>
					</div>
				</section>
				</div>
				
				<div class="col-sm-12">
					<section class="panel">
                    <header class="panel-heading">
                        Last 5 tickets
                    </header>
                    <div class="panel-body">
                        <table class="table  table-hover general-table">
							<thead>
							<tr>
								<th>Department</th>
								<th>Title</th>
								<th>Status</th>
								<th>Manage</th>
							</tr>
							</thead>
							<tbody>
							<?php 
								$GetTickets = $odb -> prepare("SELECT * FROM `tickets` WHERE `senderid` = :sender ORDER BY `id` DESC LIMIT 5");
								$GetTickets -> execute(array(':sender' => $_SESSION['ID']));
								while ($getInfo = $GetTickets -> fetch(PDO::FETCH_ASSOC))
								{
									$id = $getInfo['id'];
									$department = $getInfo['department'];
									$title = substr($getInfo['title'],0,15).'...';
									switch($getInfo['status'])
									{
									case 1:
									$status = '<span class="label label-warning label-mini">Waiting</span>';
									break;
									case 2:
									$status = '<span class="label label-success label-mini">Answered</span>';
									break;
									case 3:
									$status = '<span class="label label-primary label-mini">Closed</span>';
									break;
									}
									
									echo '
									<tr>
										<td>'.$department.'</td>
										<td>'.$title.' </td>
										<td>'.$status.'</td>
										<td><a href="viewticket.php?id='.$id.'"><button class="btn btn-info btn-xs" type="button">View</button></a></td>
									</tr>';
								}
							?>
							</tbody>
                        </table>
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