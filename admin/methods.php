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

	<title><?php echo $web_title;?>Manage Methods</title>

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
				if (isset($_POST['addMethod']))
				{
					$method = $_POST['method'];
					$group = $_POST['group'];
					
					if (empty($method) || empty($group))
					{
						$errors[] = 'Please fill in all fields.';
					}
					if(empty($errors)) {
						$insertMethod = $odb -> prepare("INSERT INTO `methods` VALUES (NULL, :method, :group, 0)");
						$insertMethod -> execute(array(':method' => $method, ':group' => $group));
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong><br> You have added a new method successfully!</div>';
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
                <section class="panel" style = "box-shadow:4px 5px 4px rgba(0, 0, 0, .5);">
                    <header class="panel-heading">
                        Add Method to System
                    </header>
                    <div class="panel-body">
                      <form class="form-horizontal adminex-form" method="post">
						<div class="form-group">
							<label class="col-sm-3 control-label">Group</label>
							<div class="col-sm-6">
								<select name="group" class="form-control">
								<option value="layer4">Layer-4</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Method</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="method">
							</div>
						</div>
						<div class="col-lg-offset-4 col-lg-10">
							<button type="submit" name="addMethod" class="col-sm-4 btn btn-primary">Add Method</button>
						</div>    
					</form>

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