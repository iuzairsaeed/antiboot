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


$SQLGetHomePage = $odb -> prepare("SELECT homepage FROM `settings` WHERE `id` = 1 LIMIT 1");
$SQLGetHomePage -> execute();
$getInfo = $SQLGetHomePage -> fetch(PDO::FETCH_ASSOC);
$hptext = $getInfo['homepage'];

$SQLGetUserI = $odb -> prepare("SELECT `package`,`maxboot` FROM `users` WHERE `id` = :id LIMIT 1");
$SQLGetUserI -> execute(array(':id' => $_SESSION['ID']));
$packageInfo = $SQLGetUserI -> fetchColumn(0);
$userpackage = $packageInfo['package'];
if($userpackage > 0){
	$SQLGetTime = $odb -> prepare("SELECT `packages`.`mbt` FROM `packages` LEFT JOIN `users` ON `users`.`package` = `packages`.`ID` WHERE `users`.`ID` = :id");
	$SQLGetTime -> execute(array(':id' => $_SESSION['ID']));
	$maxboott = $SQLGetTime -> fetchColumn(0);
	$SQL = $odb -> prepare("UPDATE `users` SET `maxboot` = :maxboot WHERE `ID` = :id");
	$SQL -> execute(array(':maxboot' => $maxboott, ':id' => $_SESSION['ID']));
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
          <span class="breadcrumb-item active">Dashboard</span>
        </nav>
      </div><!-- sh-breadcrumb -->
      <div class="sh-pagetitle">
        <div class="input-group">          
        </div><!-- input-group -->
        <div class="sh-pagetitle-left">
          <div class="sh-pagetitle-icon"><i class="icon ion-ios-home"></i></div>
          <div class="sh-pagetitle-title">
            <span>All Features Summary</span>
            <h2>Dashboard</h2>
          </div><!-- sh-pagetitle-left-title -->
        </div><!-- sh-pagetitle-left -->
      </div><!-- sh-pagetitle -->

      <div class="sh-pagebody">
        

        <div class="row row-sm mg-t-20">

          <div class="col-xl-8">

            <div class="col-xl-12">

              <div class="card bd-primary">

                <div class="card-header bg-primary tx-white">Attack Graph</div>

                <div class="card-body pd-sm-30">

                  <p>Total Atacks.</p>

                  <canvas id="AttackChart" height="95"></canvas>

                </div><!-- card-body -->

              </div><!-- card -->
            </div><!-- col-12 -->
            
            <br>

            <?php
         
              $SQLGetNews = $odb -> query("SELECT * FROM `news` ORDER BY id DESC");
				      while($row_news = $SQLGetNews ->fetch())								
				
                {

                  $str_news .= '
                  <div class="media">
                  <div class="sh-pagetitle-icon"><i class="icon ion-ios-paper-outline"></i></div>
                    <div class="media-body mg-l-20">
                      <h6 class="tx-15 mg-b-5"><a href="">'.$row_news[1].'</a></h6>
                      <p class="mg-b-20">by: <a href="">'.$my_site_name.'</a></p>
                      <p>'.$row_news[2].'</p>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <hr class="mg-y-20">';                             

                
                    
                }
          if($str_news != ''){ 
          ?>

            <div class="col-xl-12">

              <div class="card bd-primary">

                <div class="card-header bg-primary tx-white">News</div>

                <div class="card-body pd-sm-30">
                <div class="media-list">
                  <?php echo $str_news; ?>
                  </div><!-- media-list -->

                  
                </div><!-- card-body -->

              </div><!-- card -->
            </div><!-- col-12 -->
          <?php } ?>
          </div><!-- col-8 -->

          <div class="col-xl-4">
            
            <div class="col-xl-12" style="display:none;">

              <div class="card bd-primary">

                <div class="card-header bg-primary tx-white">Account info</div>

                <div class="card-body pd-sm-30">

                  <p><strong>Email:</strong> <?php echo $user -> getEmail($odb, $_SESSION['username']); ?></p>
                  <p><strong>Plan:</strong> <?php echo $user -> getPackage($odb, $_SESSION['username']); ?></p>
                  <p><strong>Max Boot Time:</strong> <?php echo $user -> getMBT($odb, $_SESSION['username']); ?></p>
                  <p><strong>Expiration:</strong> <?php echo $user -> getExpiration($odb, $_SESSION['username']); ?></p>
                  <p><?php echo $user -> progressBarPlan($odb, $_SESSION['username']); ?></p>
                  

                </div><!-- card-body -->

              </div><!-- card -->

              </div><!-- col-12 -->
              
              <div class="col-xl-12" style="display:none;">

                  <div class="card bd-primary">

                    <div class="card-header bg-primary tx-white">Network Status</div>

                    <div class="card-body pd-sm-30">
                  <?php
                  if ($stats -> runningBoots($odb)==0) {
                   $server_load = 0;
                  }else{
                    $server_load = ($stats -> runningBoots($odb))*10;
                  }
                    if ($server_load <= 25) {
                      $label = 'bg-success';
                    }elseif ($server_load <= 50) {
                        $label = '';
                    }elseif ($server_load <= 75) {
                        $label = 'bg-warning';
                    }elseif ($server_load >= 76) {
                        $label = 'bg-danger';
                    }
                  ?>

                      <span> Server load in: <?php echo $server_load; ?>%</span>
                      <div class="progress mg-b-10">
                       
                        <div class="progress-bar <?php echo $label; ?> wd-<?php echo $server_load; ?>p" role="progressbar" aria-valuenow="<?php echo $server_load; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $server_load; ?>%</div>

                    </div>

                    </div><!-- card-body -->

                  </div><!-- card -->

                </div><!-- col-12 -->

                <div class="row">
                <div class="col-sm-12">
                
            <div class="card card-body tx-white-8 bg-primary bd-0">
			  <h3 style="text-align:center"><?php echo $stats -> totalBoots($odb); ?></h3>
              
              <div class="row">
              <div class="col-sm-12">
				  <h6 style="text-align:center" class="tx-white mg-b-15">Total Attacks
					  
				  </h6>  
				  <h3><i style="float:left;" class="icon ion-stats-bars"></i></h3>
                
            
				
              </div>
             </div>
            
            </div><!-- card -->
            <br>
          </div><!-- col -->

          <div class="col-sm-12">
		  
		  <div class="card card-body tx-white-8 bg-primary bd-0">
			  <h3 style="text-align:center"><?php echo $stats -> totalUsers($odb); ?></h3>
              
              <div class="row">
              <div class="col-sm-12">
				  <h6 style="text-align:center" class="tx-white mg-b-15">Registered Users
					  
				  </h6>  
				  <h3><i style="float:left;" class="icon ion-ios-people"></i></h3>
                
            
				
              </div>
             </div>
            
            </div><!-- card -->
		 
            <br>
          </div><!-- col -->

          <div class="col-sm-6" style="display:none;">

            <div class="card card-body tx-white-8 bg-primary bd-0">

              <h3 class="tx-white mg-b-15">Attack<br> Servers</h3>
                <div class="row">
                <div class="col-md">
                  
                  <h1><?php echo $stats -> totalServers($odb) + $stats -> totalApis($odb); ?></h1>
                </div>
                <div class="col-md">
                <h3><i class="icon ion-wrench"></i></h3>
                </div>
              </div>
              
            </div><!-- card -->
            <br>
          </div><!-- col -->

          <div class="col-sm-12">
		  
		  <div class="card card-body tx-white-8 bg-primary bd-0">
			  <h3 style="text-align:center"><?php echo $stats -> runningBoots($odb); ?></h3>
              
              <div class="row">
              <div class="col-sm-12">
				  <h6 style="text-align:center" class="tx-white mg-b-15">Running Attacks
					  
				  </h6>  
				  <h3><i style="float:left;" class="icon ion-speedometer"></i></h3>
                
            
				
              </div>
             </div>
            
            </div><!-- card -->

           
            <br>
          </div><!-- col -->
                  
          </div><!-- row -->      
                <div class="col-xl-12 pd-sm-0">

                  <div class="card bd-primary">

                    <div class="card-header bg-primary tx-white">Method Statistics</div>

                    <div class="card-body pd-sm-30">

                   

                    <canvas id="AllMethodsChart" height="250"></canvas>
                       


                    </div><!-- card-body -->

                  </div><!-- card -->

                </div><!-- col-12 -->

                                
                

          </div><!-- col-4 -->   
            

        </div><!-- row -->













        
      </div><!-- sh-pagebody -->
      <?php require_once('include/footer.php'); ?>
    </div><!-- sh-mainpanel -->
    <?php require_once('include/js.php');?>
    

  </body>
</html>
