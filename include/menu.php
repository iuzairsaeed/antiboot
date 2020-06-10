<div class="sh-sideleft-menu">
      <label class="sh-sidebar-label">Navigation</label>
      <ul class="nav">
        <li class="nav-item">
          <a href="index.php" class="nav-link <?php CheckPageA('/index.php'); ?>">
            <i class="icon ion-ios-home-outline"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- nav-item -->
		
        <li class="nav-item">
          <a href="hub.php" class="nav-link <?php CheckPageA('/hub.php'); ?>">
            <i class="icon ion-ios-bolt-outline"></i>
            <span>Atack Hub</span>
          </a>
        </li><!-- nav-item -->
		
        <li class="nav-item" style="display:none;">
          <a href="" class="nav-link with-sub <?php CheckPageA('/skyperesolver.php'); ?><?php CheckPageA('domainresolver.php'); ?>">
            <i class="icon ion-ios-gear-outline"></i>
            <span>Tools</span>
          </a>
          <ul class="nav-sub">
            <li class="nav-item"><a href="skyperesolver.php" class="nav-link <?php CheckPageA('skyperesolver.php'); ?>">Skype Resolver</a></li>
            <li class="nav-item"><a href="domainresolver.php" class="nav-link <?php CheckPageA('domainresolver.php'); ?>">Domain Resolver</a></li>
          </ul>
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="packages.php" class="nav-link <?php CheckPageA('/packages.php'); ?>">
            <i class="icon ion-ios-cart-outline"></i>
            <span>Plans</span>
          </a>          
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="" class="nav-link with-sub">
            <i class="icon ion-ios-chatbubble-outline"></i>
            <span>Contact</span>
          </a>
          <ul class="nav-sub">
            <li class="nav-item"><a href="https://discord.gg/SBGNbS3" class="nav-link">Discord</a></li>
          </ul>
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="faq.php" class="nav-link <?php CheckPageA('/faq.php'); ?>">
            <i class="icon ion-ios-help-outline"></i>
            <span>FAQ</span>
          </a>
          
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="account.php" class="nav-link <?php CheckPageA('/account.php'); ?>">
            <i class="icon ion-ios-gear-outline"></i>
            <span>Account Settings</span>
          </a>
          
        </li><!-- nav-item -->
      </ul>
    </div><!-- sh-sideleft-menu -->