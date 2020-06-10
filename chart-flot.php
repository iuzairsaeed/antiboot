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
?><!DOCTYPE html>

<html lang="en">

<head>
    <?php require_once("include/head.php"); ?>
  </head>



  <body>



    <div class="sh-logopanel">

      <a href="" class="sh-logo-text">Shamcey</a>

      <a id="navicon" href="" class="sh-navicon d-none d-xl-block"><i class="icon ion-navicon"></i></a>

      <a id="naviconMobile" href="" class="sh-navicon d-xl-none"><i class="icon ion-navicon"></i></a>

    </div><!-- sh-logopanel -->



    <div class="sh-sideleft-menu">

      <label class="sh-sidebar-label">Navigation</label>

      <ul class="nav">

        <li class="nav-item">

          <a href="index.html" class="nav-link">

            <i class="icon ion-ios-home-outline"></i>

            <span>Dashboard</span>

          </a>

        </li><!-- nav-item -->

        <li class="nav-item">

          <a href="" class="nav-link with-sub">

            <i class="icon ion-ios-bookmarks-outline"></i>

            <span>Pages</span>

          </a>

          <ul class="nav-sub">

            <li class="nav-item"><a href="blank.html" class="nav-link active">Blank Page</a></li>

            <li class="nav-item"><a href="page-mailbox.html" class="nav-link">Mailbox</a></li>

            <li class="nav-item"><a href="page-chat.html" class="nav-link">Chat Page</a></li>

            <li class="nav-item"><a href="page-calendar.html" class="nav-link">Calendar</a></li>

            <li class="nav-item"><a href="page-edit-profile.html" class="nav-link">Edit Profile</a></li>

            <li class="nav-item"><a href="page-file-manager.html" class="nav-link">File Manager</a></li>

            <li class="nav-item"><a href="page-invoice.html" class="nav-link">Invoice Page</a></li>

            <li class="nav-item"><a href="page-forum-list.html" class="nav-link">Forum List Page</a></li>

            <li class="nav-item"><a href="page-forum-topic.html" class="nav-link">Forum Topic View</a></li>

            <li class="nav-item"><a href="page-signin.html" class="nav-link">Signin Page</a></li>

            <li class="nav-item"><a href="page-signup.html" class="nav-link">Signup Page</a></li>

            <li class="nav-item"><a href="page-notfound.html" class="nav-link">404 Page Not Found</a></li>

          </ul>

        </li><!-- nav-item -->

        <li class="nav-item">

          <a href="" class="nav-link with-sub">

            <i class="icon ion-ios-gear-outline"></i>

            <span>Forms</span>

          </a>

          <ul class="nav-sub">

            <li class="nav-item"><a href="form-elements.html" class="nav-link">Form Elements</a></li>

            <li class="nav-item"><a href="form-layouts.html" class="nav-link">Form Layouts</a></li>

            <li class="nav-item"><a href="form-validation.html" class="nav-link">Form Validation</a></li>

            <li class="nav-item"><a href="form-wizards.html" class="nav-link">Form Wizards</a></li>

            <li class="nav-item"><a href="form-editor-text.html" class="nav-link">Text Editor</a></li>

          </ul>

        </li><!-- nav-item -->

        <li class="nav-item">

          <a href="" class="nav-link with-sub">

            <i class="icon ion-ios-filing-outline"></i>

            <span>UI Elements</span>

          </a>

          <ul class="nav-sub">

            <li class="nav-item"><a href="accordion.html" class="nav-link">Accordion</a></li>

            <li class="nav-item"><a href="alerts.html" class="nav-link">Alerts</a></li>

            <li class="nav-item"><a href="buttons.html" class="nav-link">Buttons</a></li>

            <li class="nav-item"><a href="cards.html" class="nav-link">Cards</a></li>

            <li class="nav-item"><a href="icons.html" class="nav-link">Icons</a></li>

            <li class="nav-item"><a href="modal.html" class="nav-link">Modal</a></li>

            <li class="nav-item"><a href="navigation.html" class="nav-link">Navigation</a></li>

            <li class="nav-item"><a href="pagination.html" class="nav-link">Pagination</a></li>

            <li class="nav-item"><a href="popups.html" class="nav-link">Tooltip &amp; Popover</a></li>

            <li class="nav-item"><a href="progress.html" class="nav-link">Progress</a></li>

            <li class="nav-item"><a href="spinners.html" class="nav-link">Spinners</a></li>

            <li class="nav-item"><a href="typography.html" class="nav-link">Typography</a></li>

          </ul>

        </li><!-- nav-item -->

        <li class="nav-item">

          <a href="" class="nav-link with-sub active">

            <i class="icon ion-ios-analytics-outline"></i>

            <span>Charts</span>

          </a>

          <ul class="nav-sub">

            <li class="nav-item"><a href="chart-morris.html" class="nav-link">Morris Charts</a></li>

            <li class="nav-item"><a href="chart-flot.html" class="nav-link active">Flot Charts</a></li>

            <li class="nav-item"><a href="chart-chartjs.html" class="nav-link">Chart JS</a></li>

            <li class="nav-item"><a href="chart-rickshaw.html" class="nav-link">Rickshaw</a></li>

            <li class="nav-item"><a href="chart-sparkline.html" class="nav-link">Sparkline</a></li>

          </ul>

        </li><!-- nav-item -->

        <li class="nav-item">

          <a href="" class="nav-link with-sub">

            <i class="icon ion-ios-navigate-outline"></i>

            <span>Maps</span>

          </a>

          <ul class="nav-sub">

            <li class="nav-item"><a href="map-google.html" class="nav-link">Google Maps</a></li>

            <li class="nav-item"><a href="map-vector.html" class="nav-link">Vector Maps</a></li>

          </ul>

        </li><!-- nav-item -->

        <li class="nav-item">

          <a href="" class="nav-link with-sub">

            <i class="icon ion-ios-list-outline"></i>

            <span>Tables</span>

          </a>

          <ul class="nav-sub">

            <li class="nav-item"><a href="table-basic.html" class="nav-link">Basic Table</a></li>

            <li class="nav-item"><a href="table-datatable.html" class="nav-link">Data Table</a></li>

          </ul>

        </li><!-- nav-item -->

      </ul>

    </div><!-- sh-sideleft-menu -->



    <div class="sh-headpanel">

      <div class="sh-headpanel-left">



        <!-- START: HIDDEN IN MOBILE -->

        <a href="" class="sh-icon-link">

          <div>

            <i class="icon ion-ios-folder-outline"></i>

            <span>Directory</span>

          </div>

        </a>

        <a href="" class="sh-icon-link">

          <div>

            <i class="icon ion-ios-calendar-outline"></i>

            <span>Events</span>

          </div>

        </a>

        <a href="" class="sh-icon-link">

          <div>

            <i class="icon ion-ios-gear-outline"></i>

            <span>Settings</span>

          </div>

        </a>

        <!-- END: HIDDEN IN MOBILE -->



        <!-- START: DISPLAYED IN MOBILE ONLY -->

        <div class="dropdown dropdown-app-list">

          <a href="" data-toggle="dropdown" class="dropdown-link">

            <i class="icon ion-ios-keypad tx-18"></i>

          </a>

          <div class="dropdown-menu">

            <div class="row no-gutters">

              <div class="col-4">

                <a href="" class="dropdown-menu-link">

                  <div>

                    <i class="icon ion-ios-folder-outline"></i>

                    <span>Directory</span>

                  </div>

                </a>

              </div><!-- col-4 -->

              <div class="col-4">

                <a href="" class="dropdown-menu-link">

                  <div>

                    <i class="icon ion-ios-calendar-outline"></i>

                    <span>Events</span>

                  </div>

                </a>

              </div><!-- col-4 -->

              <div class="col-4">

                <a href="" class="dropdown-menu-link">

                  <div>

                    <i class="icon ion-ios-gear-outline"></i>

                    <span>Settings</span>

                  </div>

                </a>

              </div><!-- col-4 -->

            </div><!-- row -->

          </div><!-- dropdown-menu -->

        </div><!-- dropdown -->

        <!-- END: DISPLAYED IN MOBILE ONLY -->



      </div><!-- sh-headpanel-left -->



      <div class="sh-headpanel-right">

        <div class="dropdown mg-r-10">

          <a href="" class="dropdown-link dropdown-link-notification">

            <i class="icon ion-ios-filing-outline tx-24"></i>

          </a>

        </div>

        <div class="dropdown dropdown-notification">

          <a href="" data-toggle="dropdown" class="dropdown-link dropdown-link-notification">

            <i class="icon ion-ios-bell-outline tx-24"></i>

            <span class="square-8"></span>

          </a>

          <div class="dropdown-menu dropdown-menu-right">

            <div class="dropdown-menu-header">

              <label>Notifications</label>

              <a href="">Mark All as Read</a>

            </div><!-- d-flex -->



            <div class="media-list">

              <!-- loop starts here -->

              <a href="" class="media-list-link read">

                <div class="media pd-x-20 pd-y-15">

                  <img src="../img/img8.jpg" class="wd-40 rounded-circle" alt="">

                  <div class="media-body">

                    <p class="tx-13 mg-b-0"><strong class="tx-medium">Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>

                    <span class="tx-12">October 03, 2017 8:45am</span>

                  </div>

                </div><!-- media -->

              </a>

              <!-- loop ends here -->

              <a href="" class="media-list-link read">

                <div class="media pd-x-20 pd-y-15">

                  <img src="../img/img9.jpg" class="wd-40 rounded-circle" alt="">

                  <div class="media-body">

                    <p class="tx-13 mg-b-0"><strong class="tx-medium">Mellisa Brown</strong> appreciated your work <strong class="tx-medium">The Social Network</strong></p>

                    <span class="tx-12">October 02, 2017 12:44am</span>

                  </div>

                </div><!-- media -->

              </a>

              <a href="" class="media-list-link read">

                <div class="media pd-x-20 pd-y-15">

                  <img src="../img/img10.jpg" class="wd-40 rounded-circle" alt="">

                  <div class="media-body">

                    <p class="tx-13 mg-b-0">20+ new items added are for sale in your <strong class="tx-medium">Sale Group</strong></p>

                    <span class="tx-12">October 01, 2017 10:20pm</span>

                  </div>

                </div><!-- media -->

              </a>

              <a href="" class="media-list-link read">

                <div class="media pd-x-20 pd-y-15">

                  <img src="../img/img5.jpg" class="wd-40 rounded-circle" alt="">

                  <div class="media-body">

                    <p class="tx-13 mg-b-0"><strong class="tx-medium">Julius Erving</strong> wants to connect with you on your conversation with <strong class="tx-medium">Ronnie Mara</strong></p>

                    <span class="tx-12">October 01, 2017 6:08pm</span>

                  </div>

                </div><!-- media -->

              </a>

              <div class="media-list-footer">

                <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Show All Notifications</a>

              </div>

            </div><!-- media-list -->

          </div><!-- dropdown-menu -->

        </div>

        <div class="dropdown dropdown-profile">

          <a href="" data-toggle="dropdown" class="dropdown-link">

            <img src="../img/img1.jpg" class="wd-60 rounded-circle" alt="">

          </a>

          <div class="dropdown-menu dropdown-menu-right">

            <div class="media align-items-center">

              <img src="../img/img1.jpg" class="wd-60 ht-60 rounded-circle bd pd-5" alt="">

              <div class="media-body">

                <h6 class="tx-inverse tx-15 mg-b-5">Kevin Douglas</h6>

                <p class="mg-b-0 tx-12">kdouglas@domain.com</p>

              </div><!-- media-body -->

            </div><!-- media -->

            <hr>

            <ul class="dropdown-profile-nav">

              <li><a href=""><i class="icon ion-ios-person"></i> Edit Profile</a></li>

              <li><a href=""><i class="icon ion-ios-gear"></i> Settings</a></li>

              <li><a href=""><i class="icon ion-ios-download"></i> Downloads</a></li>

              <li><a href=""><i class="icon ion-ios-star"></i> Favorites</a></li>

              <li><a href=""><i class="icon ion-power"></i> Sign Out</a></li>

            </ul>

          </div><!-- dropdown-menu -->

        </div>

      </div><!-- sh-headpanel-right -->

    </div><!-- sh-headpanel -->



    <div class="sh-mainpanel">

      <div class="sh-breadcrumb">

        <nav class="breadcrumb">

          <a class="breadcrumb-item" href="index.html">Shamcey</a>

          <a class="breadcrumb-item" href="index.html">Charts</a>

          <span class="breadcrumb-item active">Flot Chart</span>

        </nav>

      </div><!-- sh-breadcrumb -->

      <div class="sh-pagetitle">

        <div class="input-group">

          <input type="search" class="form-control" placeholder="Search">

          <span class="input-group-btn">

            <button class="btn"><i class="fa fa-search"></i></button>

          </span><!-- input-group-btn -->

        </div><!-- input-group -->

        <div class="sh-pagetitle-left">

          <div class="sh-pagetitle-icon"><i class="icon ion-ios-analytics"></i></div>

          <div class="sh-pagetitle-title">

            <span>Graphs &amp; Charts</span>

            <h2>Flot Chart</h2>

          </div><!-- sh-pagetitle-left-title -->

        </div><!-- sh-pagetitle-left -->

      </div><!-- sh-pagetitle -->



      <div class="sh-pagebody">



        <div class="row row-sm">

          <div class="col-xl-6">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Bar Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">A bar chart or bar graph is a chart with rectangular bars with lengths proportional to the values that they represent.</p>

                <div id="flotBar1" class="ht-200 ht-sm-300"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

          <div class="col-xl-6 mg-t-25 mg-xl-t-0">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Bar Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">A bar chart or bar graph is a chart with rectangular bars with lengths proportional to the values that they represent.</p>

                <div id="flotBar2" class="ht-200 ht-sm-300"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

        </div><!-- row -->



        <div class="row row-sm mg-t-20">

          <div class="col-xl-6">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Line Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">A bar chart or bar graph is a chart with rectangular bars with lengths proportional to the values that they represent.</p>

                <div id="flotLine1" class="ht-200 ht-sm-300"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

          <div class="col-xl-6 mg-t-25 mg-xl-t-0">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Line Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">The stacked charts are used when data sets have to be broken down into their constituents.</p>

                <div id="flotLine2" class="ht-200 ht-sm-300"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

        </div><!-- row -->



        <div class="row row-sm mg-t-20">

          <div class="col-xl-6">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Area Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">A line graph is a type of chart which displays information as a series of data points connected by straight line segments.</p>

                <div id="flotArea1" class="ht-200 ht-sm-300"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

          <div class="col-xl-6 mg-t-25 mg-xl-t-0">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Area Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">Area charts are used to represent cumulated totals using numbers or percentages (stacked area charts in this case) over time.</p>

                <div id="flotArea2" class="ht-200 ht-sm-300"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

        </div><!-- row -->





        <div class="row row-sm mg-t-20">

          <div class="col-xl-6">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Real Time Updates</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</p>

                <div id="flotRealtime1" class="ht-200 ht-sm-250"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

          <div class="col-xl-6 mg-t-25 mg-xl-t-0">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Real Time Updates</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</p>

                <div id="flotRealtime2" class="ht-200 ht-sm-250"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

        </div><!-- row -->



        <div class="row row-sm mg-t-20">

          <div class="col-xl-6">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Pie Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">Labels can be hidden if the slice is less than a given percentage of the pie.</p>

                <div id="flotPie1" class="ht-200 ht-sm-250"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

          <div class="col-xl-6 mg-t-25 mg-xl-t-0">

            <div class="card bd-primary">

              <div class="card-header bg-primary tx-white">Pie Chart</div>

              <div class="card-body pd-sm-30">

                <p class="mg-b-20 mg-sm-b-30">Labels can be hidden if the slice is less than a given percentage of the pie.</p>

                <div id="flotPie2" class="ht-200 ht-sm-250"></div>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-6 -->

        </div><!-- row -->



      </div><!-- sh-pagebody -->

      <div class="sh-footer">

        <div>Copyright &copy; 2017. All Rights Reserved. Shamcey Dashboard Admin Template</div>

        <div class="mg-t-10 mg-md-t-0">Designed by: <a href="http://themepixels.me">ThemePixels</a></div>

      </div><!-- sh-footer -->

    </div><!-- sh-mainpanel -->



    <script src="<?php echo $my_site_url; ?>/FILES/lib/jquery/jquery.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/popper.js/popper.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/bootstrap/bootstrap.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/Flot/jquery.flot.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/Flot/jquery.flot.pie.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/Flot/jquery.flot.resize.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/lib/flot-spline/jquery.flot.spline.js"></script>



    <script src="<?php echo $my_site_url; ?>/FILES/js/shamcey.js"></script>

    <script src="<?php echo $my_site_url; ?>/FILES/js/chart.flot.js"></script>

  </body>

</html>

