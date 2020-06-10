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

	<title><?php echo $web_title;?>Manage API's</title>

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
					if (isset($_POST['addAPI']))
					{
						$apiurl = $_POST['apiurl'];
						$stopurl = $_POST['stopurl'];
						$methods = $_POST['methods'];
						$notes = $_POST['notes'];
						$errors = array();
						
						if (empty($apiurl) || empty($methods))
						{
							$errors[] = 'Please fill in all fields.';
						}
						$apiurl = str_replace("{","[",$apiurl);
						$apiurl = str_replace("}","]",$apiurl);
						$apiurl = str_replace("$","",$apiurl);
						$stopurl = str_replace("{","[",$stopurl);
						$stopurl = str_replace("}","]",$stopurl);
						$stopurl = str_replace("$","",$stopurl);
						if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$apiurl))
						{
							$errors[] = 'Please enter a valid api url address.';
						}
						if ($stopurl == NULL)
						{
							$stopurl = 'none';
						}
						if(empty($errors)) {
							$insertAPI = $odb -> prepare("INSERT INTO `apis` VALUES (NULL, :apiurl, :stopurl, :methods, :notes)");
							$insertAPI -> execute(array(':apiurl' => $apiurl, ':stopurl' => $stopurl, ':methods' => json_encode($methods), ':notes' => $notes));
							echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong><br> You have added a new api url successfully!</div>';
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
                        Add New API URL
                    </header>
                    <div class="panel-body">
					<form class="form-horizontal adminex-form" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">API URL</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="apiurl" placeholder="For ex; http://externalapiprovider.com/send.php?host=[host]&port=[port]&time=[time]&method=[method]">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Stop URL</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="stopurl" placeholder="For ex; http://externalapiprovider.com/stop.php?target=:target">
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
					<div class="form-group">
                        <label class="col-sm-3 control-label">Additional Notes</label>
                        <div class="col-sm-6">
                           <textarea rows="3" name="notes" class="form-control"></textarea>
                        </div>
                    </div>
					<div class="col-lg-offset-4 col-lg-10">
						<button type="submit" name="addAPI" class="col-sm-4 btn btn-primary">Add API</button>
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