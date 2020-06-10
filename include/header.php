<div class="sh-logopanel">
      <a href="" class="sh-logo-text"><?php echo $my_site_name; ?></a>
      <a id="navicon" href="" class="sh-navicon d-none d-xl-block"><i class="icon ion-navicon"></i></a>
      <a id="naviconMobile" href="" class="sh-navicon d-xl-none"><i class="icon ion-navicon"></i></a>
    </div><!-- sh-logopanel -->

    <?php require_once("include/menu.php");?>

    <div class="sh-headpanel">
      <div class="sh-headpanel-left">

        <!-- START: HIDDEN IN MOBILE -->
        <a href="skyperesolver.php" class="sh-icon-link" style="display:none;">
          <div>
            <i class="icon ion-social-skype-outline"></i>
            <span>Skype <br>Resolver</span>
          </div>
        </a>
        <a href="domainresolver.php" class="sh-icon-link" style="display:none;">
          <div>
            <i class="icon ion-android-globe"></i>
            <span>Domain<br> Resolver</span>
          </div>
        </a>
		<a href="hub.php" class="sh-icon-link">
          <div>
            <i class="icon ion-ios-bolt"></i>
            <span>Atack <br>Hub</span>
          </div>
        </a>
		
        <a href="account.php" class="sh-icon-link">
          <div>
            <i class="icon ion-ios-gear-outline"></i>
            <span>Account <br>Settings</span>
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
              <div class="col-4" style="display:none;">
                <a href="skyperesolver.php" class="dropdown-menu-link">
                  <div>
                  <i class="icon ion-social-skype-outline"></i>
                  <span>Skype <br>Resolver</span>
                  </div>
                </a>
              </div><!-- col-4 -->
              <div class="col-4" style="display:none;">
                <a href="domainresolver.php" class="dropdown-menu-link">
                  <div>
                    <i class="icon ion-android-globe"></i>
                    <span>Domain <br>Resolver</span>
                  </div>
                </a>
              </div><!-- col-4 -->
			  <div class="col-4">
                <a href="hub.php" class="dropdown-menu-link">
                  <div>
                    <i class="icon ion-ios-bolt"></i> 
                    <span>Atack <br>Hub</span>
                  </div>
                </a>
              </div><!-- col-4 -->
              <div class="col-4">
                <a href="account.php" class="dropdown-menu-link">
                  <div>
                    <i class="icon ion-ios-gear-outline"></i>
                    <span>Account<br>Settings</span>
                  </div>
                </a>
              </div><!-- col-4 -->
            </div><!-- row -->
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
        <!-- END: DISPLAYED IN MOBILE ONLY -->

      </div><!-- sh-headpanel-left -->

      <div class="sh-headpanel-right">
          <!-- notifications and mailbox 
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
            </div>

            <div class="media-list">
              
              <a href="" class="media-list-link read">
                <div class="media pd-x-20 pd-y-15">
                  <img src="<?php echo $my_site_url; ?>/FILES/img/img8.jpg" class="wd-40 rounded-circle" alt="">
                  <div class="media-body">
                    <p class="tx-13 mg-b-0"><strong class="tx-medium">Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                    <span class="tx-12">October 03, 2017 8:45am</span>
                  </div>
                </div>
              </a>
              
              <a href="" class="media-list-link read">
                <div class="media pd-x-20 pd-y-15">
                  <img src="<?php echo $my_site_url; ?>/FILES/img/img9.jpg" class="wd-40 rounded-circle" alt="">
                  <div class="media-body">
                    <p class="tx-13 mg-b-0"><strong class="tx-medium">Mellisa Brown</strong> appreciated your work <strong class="tx-medium">The Social Network</strong></p>
                    <span class="tx-12">October 02, 2017 12:44am</span>
                  </div>
                </div>
              </a>
              <a href="" class="media-list-link read">
                <div class="media pd-x-20 pd-y-15">
                  <img src="<?php echo $my_site_url; ?>/FILES/img/img10.jpg" class="wd-40 rounded-circle" alt="">
                  <div class="media-body">
                    <p class="tx-13 mg-b-0">20+ new items added are for sale in your <strong class="tx-medium">Sale Group</strong></p>
                    <span class="tx-12">October 01, 2017 10:20pm</span>
                  </div>
                </div>
              </a>
              <a href="" class="media-list-link read">
                <div class="media pd-x-20 pd-y-15">
                  <img src="<?php echo $my_site_url; ?>/FILES/img/img5.jpg" class="wd-40 rounded-circle" alt="">
                  <div class="media-body">
                    <p class="tx-13 mg-b-0"><strong class="tx-medium">Julius Erving</strong> wants to connect with you on your conversation with <strong class="tx-medium">Ronnie Mara</strong></p>
                    <span class="tx-12">October 01, 2017 6:08pm</span>
                  </div>
                </div>
              </a>
              <div class="media-list-footer">
                <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Show All Notifications</a>
              </div>
            </div><
          </div>
        </div>
        -->
        <div class="dropdown dropdown-profile">
          <a href="" data-toggle="dropdown" class="dropdown-link">
            <img src="<?php echo $my_site_url; ?>/FILES/img/img11.jpg" class="wd-60 rounded-circle" alt="">
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="media align-items-center">
              <img src="<?php echo $my_site_url; ?>/FILES/img/img11.jpg" class="wd-60 ht-60 rounded-circle bd pd-5" alt="">
              <div class="media-body">
                <h6 class="tx-inverse tx-15 mg-b-5"><?php echo $_SESSION['username']; ?></h6>
                <p class="mg-b-0 tx-12"><?php echo $_SESSION['email']; ?></p>
              </div><!-- media-body -->
            </div><!-- media -->
            <hr>
            <ul class="dropdown-profile-nav">
              <li><a href="account.php"><i class="icon ion-ios-gear"></i>Account Settings</a></li>
              <li><a href="logout.php"><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div>
      </div><!-- sh-headpanel-right -->
    </div><!-- sh-headpanel -->