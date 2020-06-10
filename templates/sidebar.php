<style>
.sidebar-menu .logo-env .logo {
    float: none;
}
</style>
<div class="sidebar-menu toggle-others fixed">
    <script src="https://code.iconify.design/1/1.0.0-rc7/iconify.min.js"></script>
		
			<div class="sidebar-menu-inner">
				
				<header class="logo-env">
		
					<!-- logo -->
					<div class="logo">
						<center>
						  <a href="index.php" class="logo-expanded">
							<img src="assets/images/Nullboot.png" width="130"> 
						</a>
						</center>
					</div>
		
					<!-- This will toggle the mobile menu and will be visible only on mobile devices -->
					<div class="mobile-menu-toggle visible-xs">
						<!--<a href="#" data-toggle="user-info-menu">
							<i class="fa-bell-o"></i>
							<span class="badge badge-dark">7</span>
						</a>-->
		
						<a href="#" data-toggle="mobile-menu">
							<i class="fa-bars"></i>
						</a>
					</div>
		
					
				</header>
				
				
						
				<ul id="main-menu" class="main-menu">
					<li class="<?php CheckPageA('index.php'); ?>">
						<a href="index.php">
							<i class="fa fa-align-justify"></i>
							<span class="title">Dashboard</span>
						</a>
					</li>
					<li class="<?php CheckPageA('hub.php'); ?>">
						<a href="hub.php">
							<i class="fa fa-rocket"></i>
							<span class="title">Attack Hub</span>
						</a>
					</li>

					<li class="<?php CheckPageB('skyperesolver.php') || CheckPageB('isup.php') || CheckPageB('domainresolver.php') || CheckPageB('iplogger.php'); ?>">
						<a href="#">
							<i class="fa fa-cube"></i>
							<span class="title">Tools</span>
						</a>
						<ul>
							<li class="<?php CheckPageA('skyperesolver.php'); ?>">
								<a href="skyperesolver.php">
									<span class="title">Skype Resolver</span>
								</a>
							</li>
							<li class="<?php CheckPageA('domainresolver.php'); ?>">
								<a href="domainresolver.php">
									<span class="title">Domain Resolver</span>
								</a>
							</li>
						
						</ul>
					</li>
					<li class="<?php CheckPageA('packages.php') || CheckPageA('order.php'); ?>">
						<a href="packages.php">
							<i class="fa-shopping-cart"></i>
							<span class="title">Plans</span>
						</a>
					</li>
					<li class="<?php CheckPageB('newticket.php') || CheckPageB('tickets.php') || CheckPageB('viewticket.php'); ?>">
						<a href="#">
							<i class="far fa-comment"></i>
							<span class="title">Contact</span>
						</a>
						<ul>
							<li class="<?php CheckPageA('https://discord.gg/SBGNbS3'); ?>">
						<a href="https://discord.gg/SBGNbS3">
							<span class="iconify" data-icon="fa-brands:discord" data-inline="false"></span>
							<span style="margin-left: 10px;">DISCORD</span>
								</a>
							</li>
							</li>
						</ul>
					</li>
					<?php 
					if ($user -> IsAdmin($odb)) {?>
					<li>
						<a href="admin/index.php">
							<i class="fa fa-code-fork"></i>
							<span class="title">Administration</span>
							
							
									</a>
				
						</a>
					</li>
					
		
										<?php } ?>

					<li class="<?php CheckPageA('faq.php'); ?>">
						<a href="faq.php">
							<i class="fa-question"></i>
							<span class="title">FAQ</span>
						</a>
					</li>
					
					<li class="<?php CheckPageA('account.php'); ?>">
						<a href="account.php">
							<i class="fa fa-user"></i>
							<span class="title">Account Settings</span>
						</a>
					</li>
						</a> 
					</li>					
				</ul>
				
			</div>
		
		</div>