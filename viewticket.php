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

$ticketid = $_GET['id'];
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	header('location: tickets.php');
	die();
}
//Check if ticket is belongs to the user
$getInfo = $odb->prepare("select * from `tickets` where `id` = :id");
$getInfo->execute(array(":id" => $ticketid));
$Info = $getInfo->fetch(PDO::FETCH_ASSOC);
//Prevent from accessing others ticket.
if($Info['senderid'] != $_SESSION['ID'])
{
	header('location: tickets.php');
	die;
}
$SQLGetInfo = $odb -> prepare("SELECT * FROM `tickets` WHERE `id` = :id AND `senderid` = :owner LIMIT 1");
$SQLGetInfo -> execute(array(':id' => $ticketid, ':owner' => $_SESSION['ID']));
$ticketInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
$title = $ticketInfo['title'];
$details = $ticketInfo['details'];
$category = $ticketInfo['department'];
$status = $ticketInfo['status'];
$date = $ticketInfo['date'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="Woopza.com" />

	<title><?php echo $web_title;?>View Ticket (#<?php echo $ticketid; ?>)</title>

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
            	<div class="col-lg-12">
				<?php
					if (isset($_POST['sendReply']))
					{
						if ($status == 2 && $closed == 0) {
						$reply = htmlspecialchars($_POST['reply']);
						$errors = array();
						if (empty($reply))
						{
							$errors[] = 'Please enter a reply to send.';
						}
						if (strlen($reply) < 10 || strlen($reply) > 4096)
						{
							$errors[] = 'Your answer must contain between 10 - 4096 characters.';
						}
						
						if(empty($errors)) {
							$insertReply = $odb -> prepare("INSERT INTO `ticketreplies` (`tid`, `author`, `reply`, `date`) VALUES
																			(:tickedID, :author, :reply, UNIX_TIMESTAMP())");
							$insertReply -> execute(array(':tickedID' => $ticketid, ':author' => $_SESSION['ID'], ':reply' => $reply));
							$SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `status` = 1 WHERE `id` = :id ");
							$SQLUpdate -> execute(array(':id' => $ticketid));
							echo '<div class="alert alert-success fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Success!</strong> You have sent your reply successfully!</div><meta http-equiv="refresh" content="0;url='.$_SERVER['REQUEST_URI'].'">';
							} else {
							echo '<div class="alert alert-block alert-danger fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oops!</strong><br />';
							foreach($errors as $error)
							{
								echo '- '.$error.'<br />';
							}
							echo '</div>';
							}
						} else {
							echo '<div class="alert alert-block alert-danger fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oops!</strong> The ticket is closed or waiting for an answer from staff.</div>';
						}
					}
					
					if (isset($_POST['closeTicket']))
					{
						$SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `status` = 3 WHERE `id` = :id ");
						$SQLUpdate -> execute(array(':id' => $ticketid));
						echo '<div class="alert alert-success fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Success!</strong> You have closed the ticket successfully!</div><meta http-equiv="refresh" content="0;url='.$_SERVER['REQUEST_URI'].'">';
					}
				?>
				<section class="panel">
                    <header class="panel-heading">
                        Ticket Details
                    </header>
                    <div class="panel-body">
						<dl>
							<dt>Department</dt>
							<dd><?php echo $category; ?></dd>
							<dt>Title - Date</dt>
							<dd><?php echo $title; ?> - (<?php echo date("m-d-Y h:i:s A", $date); ?>)</dd>
							<dt>Details</dt>
							<dd><?php echo $details; ?></dd>
						</dl>
                    </div>
                </section>
                </div>
            </div>
			<div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Ticket Replies
                    </header>
                    <div class="panel-body">
					<?php
						$checkIfExists = $odb -> prepare("SELECT * FROM `ticketreplies` WHERE `id` = :ticketID");
						$checkIfExists -> execute(array(':ticketID' => $ticketid));
						if($checkIfExists -> rowCount() == 0) 
						{
							echo '<i>No replies found for this ticket yet.</i>';
						} else {
							$SQLGetReplies = $odb -> prepare("SELECT * FROM `ticketreplies` WHERE `tid` = :tid ORDER BY `date` DESC LIMIT 3");
							$SQLGetReplies -> execute(array(':tid' => $ticketid));
							while($getInfo = $SQLGetReplies -> fetch(PDO::FETCH_ASSOC))
							{
								$author = $getInfo['author'];
								$reply = $getInfo['reply'];
								$date = date("m-d-Y h:i:s A", $getInfo['date']);
								
								if ($author == $_SESSION['ID']){
									echo '
									<blockquote>
										<p>'.$reply.'</p>
										<small>Posted by Staff, on '.$date.'</small>
									</blockquote>';
								} else {
									echo '
									<blockquote class="pull-right">
                                    <p>'.$reply.'</p>
                                    <small>Posted by you, on '.$date.'</small>
									</blockquote>';
								}
							}
						}
					?>
                    </div>
                </section>
            </div>
			</div>
			<div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Ticket Options
                    </header>
					<div class="panel-body">
						<form method="post" class="form-horizontal bucket-form">
						<div class="form-group">
							<label class="col-sm-1 control-label">Reply</label>
							<div class="col-sm-10">
								<textarea rows="6" class="form-control" name="reply" maxlength="4096" <?php if ($status == 1){ echo 'disabled="disabled"'; } ?>></textarea>
								<?php if ($status == 1){ echo '<p class="text-danger">You have to wait for a staff to reply before sending another reply. If your problem solved, please close the ticket!</p>'; } ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-7 text-right">
								<button type="submit" name="sendReply" class="btn btn-primary">Submit Reply</button>
								<?php if ($status != 3) { ?>
								<button type="submit" name="closeTicket" class="btn btn-danger" onclick="return confirm('Do you really want to close the ticket ?')">Close Ticket</button>
								<?php } ?>
							</div>
						</div>
						</form>
					</div>
                </section>
            </div>
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