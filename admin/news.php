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
$id = '1';
$SQLGetSettings = $odb -> prepare("SELECT `homepage`,`tos` FROM `settings` WHERE `id` = :id LIMIT 1");
$SQLGetSettings -> execute(array(':id' => $id));
$getInfo = $SQLGetSettings -> fetch(PDO::FETCH_ASSOC);
$hptext = $getInfo['homepage'];
$tos = $getInfo['tos'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />

	<title><?php echo $web_title;?>Manage News</title>

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
				if (isset($_POST['updateHP']))
				{
					$update = false;
					$errors = array();
					if ($hptext != $_POST['hptext'])
					{
						$SQL = $odb -> prepare("UPDATE `settings` SET `homepage` = :homepage WHERE `id` = :id");
						$SQL -> execute(array(':homepage' => $_POST['hptext'], ':id' => $id));
						$update = true;
						$hptext = $_POST['hptext'];
					}
					if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the homepage information!</div>';
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
				if (isset($_POST['updateTOS']))
				{
					$update = false;
					$errors = array();
					if ($tos != $_POST['tos'])
					{
						$SQL = $odb -> prepare("UPDATE `settings` SET `tos` = :tos WHERE `id` = :id");
						$SQL -> execute(array(':tos' => $_POST['tos'], ':id' => $id));
						$update = true;
						$tos = $_POST['tos'];
					}
					if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the terms of service!</div>';
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
			?>
			 <section class="panel" style = "box-shadow:4px 5px 4px rgba(0, 0, 0, .5);">
					<header class="panel-heading custom-tab yellow-tab">
						<ul class="nav nav-tabs">
							<li class="active">
								<a data-toggle="tab" href="#homepage">
									<i class="fa fa-dashboard"></i>
									Home Page
								</a>
							</li>
							<li>
								<a data-toggle="tab" href="#terms">
									<i class="fa fa-asterisk"></i>
									Terms Of Service
								</a>
							</li>
							<!-----------------------------------my work-------------------------------->
							<li>
								<a data-toggle="tab" href="#news">
									<i class="fa fa-newspaper-o"></i>
									New News
								</a>
							</li>
							<!-----------------------------------my work-------------------------------->
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content">
							<div id="homepage" class="tab-pane active">
								<form method="post" class="form-horizontal ">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <textarea class="form-control ckeditor" name="hptext" rows="10"><?php echo $hptext; ?></textarea>
                                    </div>
                                </div>
								<button type="submit" name="updateHP" class="btn btn-primary btn-block">Confirm & Update Home Page</button>
                            </form>
							</div>
							<div id="terms" class="tab-pane">
								<form method="post" class="form-horizontal ">
                                <div class="form-group">
                                    <div class="col-md-12">
										<textarea class="form-control wysihtml5" data-stylesheet-url="assets/js/wysihtml5/lib/css/wysiwyg-color.css" name="tos" id="sample_wysiwyg"><?php echo $tos; ?></textarea>
                                    </div>
                                </div>
								<button type="submit" name="updateTOS" class="btn btn-primary btn-block">Confirm & Update Terms of Service</button>
                            </form>
							</div>
							<!-----------------------------------my work-------------------------------->
							<div id="news" class="tab-pane">
								<form method="post" class="form-horizontal ">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h2>Title.</h2>
                                        <input class="form-control" type="text" name="txt_title" placeholder="Enter News Title...">
										<h2>Write News</h2>
										<textarea class="form-control" rows="6" name="txt_news" placeholder="Enter News Here..."></textarea>
                                    </div>
                                </div>
								<button type="submit" name="btn_news" class="btn btn-primary btn-block">Post New News</button>
                            </form>
							</div>
							<?php							
        				
        					if(isset($_POST['btn_news']))
        					{
        					    $title = $_POST['txt_title'];
        					    $news = $_POST['txt_news'];        					   
						  
								$SQL = $odb -> prepare("INSERT INTO news(title,detail) VALUES(:title,:news)");
								$SQL -> execute(array(':title' => $title, ':news' => $news));
        					    /*if($con->query($insert_query) == True)
        					    {
        					        echo "<div class='alert alert-success><strong>Success!</strong> Data Inserted</div>";
        					    }
        					    else
        					    {
        					        echo "<div class='alert alert-danger'><strong>Insertion Fail!</strong> Data Inserted</div>";
        					    }*/
        					}
        					?>
							<!-----------------------------------my work-------------------------------->
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
	<link rel="stylesheet" href="../assets/css/fonts/meteocons/css/meteocons.css">
	<link rel="stylesheet" href="../assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
	<link rel="stylesheet" href="../assets/js/uikit/vendor/codemirror/codemirror.css">
	<link rel="stylesheet" href="../assets/js/uikit/uikit.css">
	<link rel="stylesheet" href="../assets/js/uikit/css/addons/uikit.almost-flat.addons.min.css">

	<!-- Bottom Scripts -->
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/TweenMax.min.js"></script>
	<script src="../assets/js/resizeable.js"></script>
	<script src="../assets/js/joinable.js"></script>
	<script src="../assets/js/xenon-api.js"></script>
	<script src="../assets/js/xenon-toggles.js"></script>
	<script src="../assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
	<script src="../assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
	<script src="../assets/js/uikit/js/addons/htmleditor.min.js"></script>
	<script src="../assets/js/ckeditor/ckeditor.js"></script>


	<!-- Imported scripts on this page -->
	<script src="../assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../assets/js/xenon-widgets.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="../assets/js/xenon-custom.js"></script>

</body>
</html>