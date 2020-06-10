<div class="sidebar-menu toggle-others fixed">
		
			<div class="sidebar-menu-inner">
				
				<header class="logo-env">
		
					<!-- logo -->
					<div class="logo">
						<a href="index.php" class="logo-expanded">
							<img src="../assets/images/logo@2x.png" width="80" alt="" />
						</a>
		
						<a href="index.php" class="logo-collapsed">
							<img src="../assets/images/logo-collapsed@2x.png" width="40" alt="" />
						</a>
					</div>
		
					<!-- This will toggle the mobile menu and will be visible only on mobile devices -->
					<div class="mobile-menu-toggle visible-xs">
						<a href="#" data-toggle="user-info-menu">
							<i class="fa-bell-o"></i>
							<span class="badge badge-success">7</span>
						</a>
		
						<a href="#" data-toggle="mobile-menu">
							<i class="fa-bars"></i>
						</a>
					</div>
		
					
				</header>
				
				
						
				<ul id="main-menu" class="main-menu">
					<li class="<?php CheckPageA('index.php'); ?>">
						<a href="index.php">
							<i class="fa-desktop"></i>
							<span class="title">Dashboard</span>
						</a>
					</li>
					<li class="<?php CheckPageA('servers.php') || CheckPageA('editserver.php') || CheckPageA('editcmd.php'); ?>">
						<a href="servers.php">
							<i class="fa-bolt"></i>
							<span class="title">Manage Servers</span>
						</a>
					</li>
					<li class="<?php CheckPageA('apis.php') || CheckPageA('editapi.php'); ?>">
						<a href="apis.php">
							<i class="fa-code-fork"></i>
							<span class="title">Manage API's</span>
						</a>
					</li>
					<li class="<?php CheckPageA('packages.php') || CheckPageA('editpackage.php'); ?>">
						<a href="packages.php">
							<i class="fa-shopping-cart"></i>
							<span class="title">Manage Packages</span>
						</a>
					</li>
					<li class="<?php CheckPageA('users.php') || CheckPageA('edituser.php'); ?>">
						<a href="users.php">
							<i class="fa-users"></i>
							<span class="title">Manage Users</span>
						</a>
					</li>
					<li class="<?php CheckPageB('pendingtickets.php') || CheckPageB('tickets.php') || CheckPageB('viewticket.php'); ?>">
						<a href="#">
							<i class="fa-support"></i>
							<span class="title">Help Desk</span>
						</a>
						<ul>
							<li class="<?php CheckPageA('pendingtickets.php'); ?>"><a href="pendingtickets.php"> Pending Tickets</a></li>
							<li class="<?php CheckPageA('alltickets.php'); ?>"><a href="alltickets.php"> View All Tickets</a></li>
						</ul>
					</li>
					<li class="<?php CheckPageB('news.php') || CheckPageB('attacklogs.php') || CheckPageB('paymentlogs.php') || CheckPageB('methods.php'); ?>">
						<a href="#">
							<i class="fa-asterisk"></i>
							<span class="title">Miscellaneous</span>
						</a>
						<ul>
							<li class="<?php CheckPageA('news.php'); ?>"><a href="news.php"> Manage News</a></li>
							<li class="<?php CheckPageA('methods.php'); ?>"><a href="methods.php"> Manage Methods</a></li>
							<li class="<?php CheckPageA('attacklogs.php'); ?>"><a href="attacklogs.php"> Attack Logs</a></li>
							<li class="<?php CheckPageA('paymentlogs.php'); ?>"><a href="paymentlogs.php"> Payment Logs</a></li>
						</ul>
					</li>
					<li class="<?php CheckPageA('settings.php'); ?>">
						<a href="settings.php">
							<i class="fa-cog"></i>
							<span class="title">System Settings</span>
						</a>
					</li>
				</ul>
				
			</div>
		
		</div>