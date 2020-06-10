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
	header('location: users.php');
	die();
}

$checkIfExists = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :user");
$checkIfExists -> execute(array(':user' => $_GET['id']));
if($checkIfExists -> rowCount() == 0) 
{
	header('location: users.php');
	die();
}
$id = $_GET['id'];
$SQLGetUser = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id LIMIT 1");
$SQLGetUser -> execute(array(':id' => $_GET['id']));
$getInfo = $SQLGetUser -> fetch(PDO::FETCH_ASSOC);
$username = $getInfo['username'];
$email = $getInfo['email'];
$rank = $getInfo['rank'];
$package = $getInfo['package'];
$maxboot = $getInfo['maxboot'];
$expire = $getInfo['expire'];
$status = $getInfo['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>Edit User</title>

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
				   if (isset($_POST['updateUser']))
				   {
					$update = false;
					$errors = array();
					if (!empty($_POST['password']))
					{
						$sha = hash("sha512", $_POST['password']);
						$SQL = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id");
						$SQL -> execute(array(':password' => $sha, ':id' => $id));
						$update = true;
						$password = SHA1($_POST['password']);
					}
					if ($username != $_POST['username'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `username` = :username WHERE `ID` = :id");
						$SQL -> execute(array(':username' => $_POST['username'], ':id' => $id));
						$update = true;
						$username = $_POST['username'];
					}
					if ($email != $_POST['email'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `email` = :email WHERE `ID` = :id");
						$SQL -> execute(array(':email' => $_POST['email'], ':id' => $id));
						$update = true;
						$email = $_POST['email'];
					}
					if ($rank != $_POST['rank'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `rank` = :rank WHERE `ID` = :id");
						$SQL -> execute(array(':rank' => $_POST['rank'], ':id' => $id));
						$update = true;
						$rank = $_POST['rank'];
					}
					if ($package != $_POST['package'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `package` = :package WHERE `ID` = :id");
						$SQL -> execute(array(':package' => $_POST['package'], ':id' => $id));
						//Set Expire
						$getPlanInfo = $odb -> prepare("SELECT `unit`,`length`,`mbt` FROM `packages` WHERE `id` = :plan");
						$getPlanInfo -> execute(array(':plan' => $_POST['package']));
						$plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
						$unit = $plan['unit'];
						$length = $plan['length'];
						$maxbtime = $plan['mbt'];
						$newExpire = strtotime("+{$length} {$unit}");
						$updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `package` = :plan, `maxboot` = :mbt WHERE `ID` = :id");
						$updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $_POST['package'], ':id' => $id, ':mbt' => $maxbtime));
						$update = true;
						$package = $_POST['package'];
					}
					if ($maxboot != $_POST['maxboot'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `maxboot` = :maxboot WHERE `ID` = :id");
						$SQL -> execute(array(':maxboot' => $_POST['maxboot'], ':id' => $id));
						$update = true;
						$maxboot = $_POST['maxboot'];
					}
					if ($expire != $_POST['expire'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire WHERE `ID` = :id");
						$SQL -> execute(array(':expire' => $_POST['expire'], ':id' => $id));
						$update = true;
						$expire = $_POST['expire'];
					}
					if ($status != $_POST['status'])
					{
						$SQL = $odb -> prepare("UPDATE `users` SET `status` = :status WHERE `ID` = :id");
						$SQL -> execute(array(':status' => $_POST['status'], ':id' => $id));
						$update = true;
						$status = $_POST['status'];
					}
					if ($update == true)
					{
						echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> You have updated the user information!</div>';
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
				 
				   if (isset($_POST['deleteUser']))
					{
						if($id == 1) // enter super admin id here.
						{
							echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Error!</strong> You are not allowed to delete super administrator from the system. </div>';
						} else {
							$sql = $odb -> prepare("DELETE FROM `users` WHERE `id` = :id");
							$sql -> execute(array(':id' => $id));
							echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a><strong>Success!</strong> The user has been removed! Redirecting in 2 ...</div><meta http-equiv="REFRESH" content="2;url=servers.php">';
						}
					}
				  ?>
                <section class="panel">
                    <header class="panel-heading">
                        Edit User Information
                    </header>
                    <div class="panel-body">
					<form class="form-horizontal adminex-form" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password" placeholder="Leave blank if you don't want to update">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">E-Mail</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Rank</label>
                        <div class="col-sm-6">
						<select name="rank" class="form-control">
						<?php
						function selectedR($check, $rank)
						{
							if ($check == $rank)
							{
								return 'selected="selected"';
							}
						}
						?>
						<option value="0" <?php echo selectedR(0, $rank); ?> >Regular User</option>
						<option value="2" <?php echo selectedR(2, $rank); ?> >Support Team</option>
						<option value="1" <?php echo selectedR(1, $rank); ?> >Administrator</option>
						</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Package </label>
                        <div class="col-sm-6">
						<select name="package" class="form-control">
						<option value="0">No Package</option>
						<?php 
							$SQLGetMembership = $odb -> query("SELECT * FROM `packages`");
							while($memberships = $SQLGetMembership -> fetch(PDO::FETCH_ASSOC))
							{
								$mi = $memberships['id'];
								$mn = $memberships['name'];
								$selectedM = ($mi == $package) ? 'selected="selected"' : '';
								echo '<option value="'.$mi.'" '.$selectedM.'>'.$mn.'</option>';
							}
						?>
						</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Max Boot Time</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="maxboot" value="<?php echo $maxboot; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Expiry (Unixtime)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="expire" value="<?php echo $expire; ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Account Status</label>
                        <div class="col-sm-2">
						<select name="status" class="form-control">
						<?php
						function selectedSt($check, $status)
						{
							if ($check == $status)
							{
								return 'selected="selected"';
							}
						}
						?>
						<option value="0" <?php echo selectedSt(0, $status); ?> >Active</option>
						<option value="1" <?php echo selectedSt(1, $status); ?> >Banned</option>
						</select>
                        </div>
                    </div>
					
					<div class="col-lg-offset-4 col-sm-6 btn-group">
						<button type="submit" name="updateUser" class="col-sm-4 btn btn-primary">Update User</button>
						<button type="button" href="deleteUser" onclick="return confirm('Are you sure?')" class="col-sm-4 btn btn-danger">Delete User</button>
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