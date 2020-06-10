<?php
ob_start();
require_once 'engine/config.php';
require_once 'engine/init.php';
if (!($user -> LoggedIn())) {
    header('Location: login.php');
    die();
}
if ($user -> IsBanned($odb)) {
    header('Location: logout.php');
    die();
}
if (!($user->hasMembership($odb))) {
    header('location: packages.php');
    die();
}
$SQLGetTerms = $odb -> prepare("SELECT tos FROM `settings` WHERE `id` = 1 LIMIT 1");
$SQLGetTerms -> execute();
$getInfo = $SQLGetTerms -> fetch(PDO::FETCH_ASSOC);
$tos = $getInfo['tos'];

$GetMaxTime = $odb -> prepare("SELECT `maxboot` FROM `users` WHERE `ID` = :id AND `username` = :username");
$GetMaxTime -> execute(array(':id' => $_SESSION['ID'], ':username' => $_SESSION['username']));
$maxBoot = $GetMaxTime -> fetchColumn(0);



if (isset($_POST['stressBtn']) || isset($_GET['renewAttack'])) {
	

	
$SQLGetUser = $odb -> prepare("SELECT `package` FROM `users` WHERE `id` = :id LIMIT 1");
$SQLGetUser -> execute(array(':id' => $_SESSION['ID']));
$getInfo = $SQLGetUser -> fetch(PDO::FETCH_ASSOC);
$package = $getInfo['package'];
//$maxboot = $getInfo['maxboot'];
$SQLGetMSInfo = $odb -> prepare("SELECT `methods`, `concurrents` FROM `packages` WHERE `id` = :id LIMIT 1");
$SQLGetMSInfo -> execute(array(':id' => $package));
$packageInfo = $SQLGetMSInfo -> fetch(PDO::FETCH_ASSOC);
$concurrents = $packageInfo['concurrents'];
$methodz = json_decode($packageInfo['methods'], true);
$errors = array();

	if (isset($_GET['renewAttack'])) {
		$logID = $_GET['renewAttack'];
		$GetAttacks = $odb -> prepare("SELECT * FROM `attacklogs` WHERE `id` = :logID");
		$GetAttacks -> execute(array(':logID' => $logID));
		$getInfo = $GetAttacks -> fetch(PDO::FETCH_ASSOC);
		
		$target = $getInfo['ip'];
		$port = $getInfo['port'];
		$time = $getInfo['time'];
		$method = $getInfo['method'];
										
	}else{
		$target = $_POST['target'];
		$port = $_POST['port'];
		$time = $_POST['time'];
		$method = $_POST['method'];
	}


                  
if (empty($target) || empty($port) || empty($time) || empty($method)) {
  $errors[] = 'Please fill in all fields.';
}
$checkBlacklist = $odb->prepare("SELECT COUNT(*) FROM `blacklist` WHERE `ip` = :ip");
$checkBlacklist -> execute(array(':ip' => $target));
$IsBlacklisted = $checkBlacklist->fetchColumn(0);
if (!($IsBlacklisted == 0)) {
  $errors[] = 'You can not attack this ip address.';
}
if (!in_array($method, $methodz)) {
  $errors[] = 'This method is not available for your plan.';
}
if ($time > $maxBoot) {
  $errors[] = 'You have exceeded your maximum attack time. Please try again!';
}
if ($package == 0) {
  $RunningBoots = $odb->prepare("select count(*) from `attacklogs` where `user` = :user and `time` + date > UNIX_TIMESTAMP()");
  $RunningBoots->execute(array(":user" => $_SESSION['username']));
  $countRB = intval($RunningBoots->fetchColumn(0));
  if ($countRB != 0) {
      $errors[] = 'You have reached your concurrent limit. Please wait until your current attack(s) are finished before attacking again!';
  }
} else {
  $RunningBoots = $odb->prepare("select count(*) from `attacklogs` where `user` = :user and `time` + date > UNIX_TIMESTAMP()");
  $RunningBoots->execute(array(":user" => $_SESSION['username']));
  $countRB = intval($RunningBoots->fetchColumn(0));
  if ($countRB > $concurrents) {
      $errors[] = 'You have reached your concurrent limit. Please wait until your current attack(s) are finished before attacking again!';
  }
}
                  
if (empty($errors)) {
  $apimng -> prepareAttack($odb, $target, $port, $time, $method);
  $servermng -> prepareAttack($odb, $target, $port, $time, $method);
  $success_modal = 'You have started the attack successfully!';
} else {
  foreach ($errors as $error) {
      $danger_modal .=  '- '.$error.'<br />';
  }
}
}



              if (isset($_GET['stopAttack'])) {
                  $stopID = $_GET['stopAttack'];
                  if (!isset($_GET['stopAttack']) || !is_numeric($_GET['stopAttack'])) {
                      header('location: hub.php');
                      die();
                  }
                  $getInfo = $odb->prepare("select * from `attacklogs` where `id` = :id");
                  $getInfo->execute(array(":id" => $stopID));
                  $Info = $getInfo->fetch(PDO::FETCH_ASSOC);
                  if ($Info['user'] != $_SESSION['username']) {
                      header('location: hub.php');
                      die();
                  }
                  $type = $Info['type'];
                  $targetip = $Info['ip'];
                  $targetport = $Info['port'];
                  $targettime = $Info['time'];
                  $method = $Info['method'];
                  if ($type == 'server') {
                      $serverid = $Info['sid'];
                      if ($servermng -> stopAttack($odb, $targetip, $serverid, $method)) {
                          $SQL = $odb -> prepare("UPDATE `attacklogs` SET `time` = 0 WHERE `id` = :id");
                          $SQL -> execute(array(':id' => $stopID));
                          $success_modal .= 'Attack stopped';
                      } else {
                          $danger_modal .= 'Seems like the attack method / server does not support this function.';
                      }
                  } else {
                      $stopurl = $Info['stopurl'];
                      if ($apimng -> stopAttack($odb, $targetip, $targetport, $targettime, $stopurl)) {
                          $SQL = $odb -> prepare("UPDATE `attacklogs` SET `time` = 0 WHERE `id` = :id");
                          $SQL -> execute(array(':id' => $stopID));
                          $success_modal .= ' The command to stop attack has been executed!';
                      } else {
                          $danger_modal .= ' Seems like the attack method / server does not support this function. ';
                      }
                  }
              }
              $CheckAPIs = "SELECT count(*) FROM `apis`";
              $resultAPI = $result = $odb->prepare($CheckAPIs);
              $resultAPI->execute();
              $countAPIs = $resultAPI->fetchColumn();
              $CheckServers = "SELECT count(*) FROM `servers` WHERE NOT `response` = :response";
              $result = $odb->prepare($CheckServers);
              $result->execute(array(':response' => 'offline'));
              $countServers = $result->fetchColumn();
              if ($countServers == 0 && $countAPIs == 0) {
                  $disableAttack = 'disabled="disabled"';
                  $warning_modal .= ' All servers are busy at the moment, please try again soon! ';
              }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once("include/head.php"); ?>
  </head>
<body>

<?php require_once("include/header.php"); ?>

    <div class="sh-mainpanel">
      <div class="sh-breadcrumb">
        <nav class="breadcrumb">
          <a class="breadcrumb-item" href="<?php echo $my_site_url; ?>"><?php echo $my_site_name; ?></a>
          <span class="breadcrumb-item active">Attack Hub</span>
        </nav>
      </div><!-- sh-breadcrumb -->
      <div class="sh-pagetitle">
        <div class="input-group">          
        </div><!-- input-group -->
        <div class="sh-pagetitle-left">
          <div class="sh-pagetitle-icon"><i class="icon ion-ios-bolt"></i></div>
          <div class="sh-pagetitle-title">
            <span>Stress Test</span>
            <h2>Attack Hub</h2>
          </div><!-- sh-pagetitle-left-title -->
        </div><!-- sh-pagetitle-left -->
      </div><!-- sh-pagetitle -->

      <div class="sh-pagebody">
     <div class="col-sm-12">
          <div class="alert alert-info"><strong>Guarantee</strong>
								<br>We guarantee power for all plans but only for AMP methods (UDP-SE, LDAP, NTP).<br></div>
      <?php require_once("include/modal.php"); ?>
        <!-- Put your content here -->
        <div class="row row-sm mg-t-20">
        
        <div class="col-xl-4">
        <form action="hub.php" role="form" class="form-horizontal" method="post">
        <div class="card bd-primary mg-t-20">

          <div class="card-header bg-primary tx-white">New Stress Test</div>

          <div class="card-body pd-sm-30">

            <div class="form-layout">

              <div class="row mg-b-25">

                <div class="col-lg-12">

                  <div class="form-group">

                    <label class="form-control-label">Target: </label>

                    <input input type="text" name="target" class="form-control" placeholder="Target">

                  </div>

                </div><!-- col-12 -->
                <div class="col-lg-12">

                  <div class="form-group">

                    <label class="form-control-label">Port: </label>

                    <input type="text" name="port" class="form-control" placeholder="80">

                  </div>

                </div><!-- col-12 -->
                
                <div class="col-lg-12">

                  <div class="form-group">

                    <label class="form-control-label">Time: </label>

                    <input type="text" name="time" class="form-control" placeholder="60" maxlength="<?php echo $maxBoot; ?>">

                  </div>

                </div><!-- col-12 -->

                
                <div class="col-lg-12">

                    <div class="form-group mg-b-10-force">

                    <label class="form-control-label">Method: </label>

                    <select class="form-control" id="methodselect-1" name="method">
									
						<optgroup label="Layer 4">
							<?php
                                $GetMethods = $odb -> prepare("SELECT * FROM `methods` WHERE `group` = :group");
                                $GetMethods -> execute(array(':group' => 'layer4'));
                                while ($methods = $GetMethods -> fetch(PDO::FETCH_ASSOC)) {
                                   //$mi = $methods['id'];
                                    $mn = $methods['method'];
                                        echo '<option value="'.$mn.'">'.$mn.'</option>';
                                    }
                            ?>
									
							</optgroup>
							
						</select>

                    </div>

                   </div><!-- col-12 -->

              </div><!-- row -->



              <div class="form-layout-footer ">

                <button type="submit" name="stressBtn"  class="btn btn-success mg-r-5">Start Attack</button>

              </div><!-- form-layout-footer -->

            </div><!-- form-layout -->

          </div><!-- card-body -->

        </div>  
        </form>
        </div><!-- col 4 -->

        <div class="col-xl-8">

            <div class="card bd-primary mg-t-20">

            <div class="card-header bg-primary tx-white">Last Attacks</div>

            <div class="card-body pd-sm-30">


                <div class="table-responsive">

                <table class="table mg-b-0">

                    <thead>

                    <tr>

                        
                    <th>Target</th>
					<th>Time</th>
					<th>Status</th>
					<th>Method</th>
					<th>Manage</th>

                    </tr>

                    </thead>

                    <tbody>

                    

                        

                    <?php
									$GetAttacks = $odb -> prepare("SELECT *, UNIX_TIMESTAMP() AS time_stamp FROM `attacklogs` WHERE `user` = :user ORDER BY `id` DESC LIMIT 10");
									$GetAttacks -> execute(array(':user' => $_SESSION['username']));
								
									while ($getInfo = $GetAttacks -> fetch(PDO::FETCH_ASSOC))
									{
										$disabled = '';
										$disabled_2 = '';
										$id = $getInfo['id'];
										$target = $getInfo['ip'];
										$port = $getInfo['port'];
										$time = $getInfo['time'];
										$type = $getInfo['type'];
										$method = $getInfo['method'];
										$date = $getInfo['date'];
										//$currents = new DateTime('now');
										//$timestamp = $currents->getTimestamp();
										$timestamp = $getInfo['time_stamp'];

										if ( $date + $time > $timestamp )
										{
											$status = '<span class="label label-warning label-mini">Running</span>';
											$disabled_2 = 'disabled';
										} else {
											$status = '<span style="background-color:96968d;">Done</span>';
											$disabled = 'disabled';
										}
						
										echo '
										<tr>
											<td>
												<a href="#" style="color:#96968d;">
													'.$target.':'.$port.'
												</a>
											</td>
											<td>'.$time.' Seconds </td>
											<td>'.$status.'</td>
											<td>'.$method.'</td>
											<td><a href="hub.php?stopAttack='.$id.'"><button class="btn btn-danger" type="button" '.$disabled.'>Stop</button></a>
											<a href="hub.php?renewAttack='.$id.'"><button class="btn btn-success" type="button" '.$disabled_2.'>Restart</button></a></td>
										</tr>';
									}
								?>

                    
                   

                    
                    </tbody>

                </table>

                </div>

            </div><!-- card-body -->

            </div>

        </div>
        </div><!-- row -->

        <div class="row row-sm mg-t-20" style="display:none;">
            <div class="col-xl-6">
                <div class="card bd-primary mg-t-20">

                <div class="card-header bg-primary tx-white">Methods Help</div>

                <div class="card-body pd-sm-30">
                                    
                        <p>MEMCACHE -</p>
                        <p>CLDAP -</p>
                        <p>DNS - Generates the largest amplification power. Best for home connection and some servers</p>
                        <p>NTP - Generates the large pps. good for unprotected servers and home connection</p>
                        <p>SNMP - Use in most case unprotected routers on world to amplification attack</p>
                        <p>STORM - Custom method. Recomended for miedium protected servers</p>
                        <p>XACK/XMAS/XSYN - Generates a large number of pps.  recomended for servers works on TCP protocol.</p>
                        <p>TCP-AMP -</p>
                        <p>Ts3-Fuck - Custom bypass for teamspeak servers</p>
                        <p>PPTP -</p>
                        <p>SOURCE - Based on Steam servers for amplification flood</p>
                        <p>JSBypass - HEAD/POST/GET - Can bypass Cloudflare (not CAPTCHA), SonicFast, ArvanCloud, BlazingFast, Nooder</p>
                        <p>HTTP-GOOGLE - Method which spoof google bot. May be able to drop websites protected by DDos-Guard and Cloudflare UAM.</p>
                        <p>HTTP-GET - GET flood, generate a decent amount of request per seconds.</p>
                        <p>HTTP-POST - Type of attack which is using POSTs instead GETs.</p>
                        <p>HTTP-NULL - Flood with as low as possible packet size, generates a lot of requests per seconds.</p>
        
                </div><!-- card-body -->

                </div>

            </div>

            <div class="col-xl-6">
            
                <div class="col-xl-12">

                    <div class="card bd-primary mg-t-20">

                        <div class="card-header bg-primary tx-white">Network Status</div>

                        <div class="card-body pd-sm-30">
                    <?php
                    if ($stats -> runningBoots($odb)==0) {
                        $server_load = 0;
                    } else {
                        $server_load = ($stats -> runningBoots($odb))*10;
                    }
                        if ($server_load <= 25) {
                            $label = 'bg-success';
                        } elseif ($server_load <= 50) {
                            $label = '';
                        } elseif ($server_load <= 75) {
                            $label = 'bg-warning';
                        } elseif ($server_load >= 76) {
                            $label = 'bg-danger';
                        }
                    ?>

                        <span> Server load in: <?php echo $server_load; ?>%</span>
                        <div class="progress mg-b-10">
                        
                            <div class="progress-bar <?php echo $label; ?> wd-<?php echo $server_load; ?>p" role="progressbar" aria-valuenow="<?php echo $server_load; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $server_load; ?>%</div>

                        </div>

                        </div><!-- card-body -->

                    </div><!-- card -->

                </div>
                <div class="row">
                <div class="col-xl-6 mg-t-20 ">

                    <div class="card card-body tx-white-8 bg-danger bd-0">

                    <h6 class="tx-white mg-b-15">Attack Servers</h6>
                        <div class="row">
                        <div class="col-md">
                        
                        <h1><?php echo $stats -> totalServers($odb) + $stats -> totalApis($odb); ?></h1>
                        </div>
                        <div class="col-md">
                        <h1><i class="icon ion-wrench"></i></h1>
                        </div>
                    </div>

                    </div><!-- card -->

                </div><!-- col -->

                <div class="col-xl-6 mg-t-20">

                    <div class="card card-body tx-white-8 bg-primary bd-0">

                    <h6 class="tx-white mg-b-15">Running Attacks</h6>
                        <div class="row">
                        <div class="col-md">
                        
                        <h1><?php echo $stats -> runningBoots($odb); ?></h1>
                        </div>
                        <div class="col-md">
                        <h1><i class="icon ion-speedometer"></i></h1>
                        </div>
                    </div>

                    </div><!-- card -->

                </div><!-- col -->
                </div><!-- row -->
            </div><!-- col -->
        </div><!-- row -->

       

        <!-- end of your content -->
      </div><!-- sh-pagebody -->
      <?php require_once('include/footer.php'); ?>
    </div><!-- sh-mainpanel -->
    <?php require_once('include/js.php');?>
  </body>
</html>
