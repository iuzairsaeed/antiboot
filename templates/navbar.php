<style>
.dropdown-menu {
    background-color: #393a3d;
}
.user-info-navbar .user-info-menu>li .dropdown-menu.user-profile-menu li.last, .navbar.horizontal-menu .navbar-inner>.nav>li .dropdown-menu.user-profile-menu li.last {
    background: #393a3d;
}
</style>
<nav class="navbar user-info-navbar"  role="navigation">
			
				
						<!--a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="far fa-comment"></i>
							<span class="badge badge-dark"><?php echo $stats -> pendingTickets($odb, $_SESSION['ID']); ?></span>
						</a-->
			
						<ul class="dropdown-menu messages">
							<li>
								
								<ul class="dropdown-menu-list list-unstyled ps-scrollbar">
									<?php
										$checkIfExists = $odb -> prepare("SELECT * FROM `tickets` WHERE `senderid` = :userID AND `status` = 2");
										$checkIfExists -> execute(array(':userID' => $_SESSION['ID']));
										if($checkIfExists -> rowCount() == 0) 
										{
											echo
											'
												<li class="">
													<a href="#">
														<span class="line">
															<i>No new ticket replies found.</i>
														</span>
													</a>
												</li>
											';
										} else {
											$SQLGetTickets = $odb -> prepare("SELECT * FROM `tickets` WHERE `senderid` = :sender AND `status` = 2 ORDER BY `date` DESC LIMIT 15");
											$SQLGetTickets -> execute(array(':sender' => $_SESSION['ID']));
											while($getInfo = $SQLGetTickets -> fetch(PDO::FETCH_ASSOC))
											{
												$tid = $getInfo['id'];
												$title = substr($getInfo['title'],0,20).'...';
												$reply = substr($getInfo['details'],0,45).'...';
												
												echo '
													<li class="">
														<a href="viewticket.php?id='.$tid.'">
															<span class="line">
																<strong>'.$title.'</strong>
															</span>
											
															<span class="line desc small">
																'.$reply.'
															</span>
														</a>
													</li>
												';
											}
										}
										?>
								</ul>
							
							</li>
							
							<li class="external">
								<a href="tickets.php">
									<span>All Tickets</span>
									<i class="fa-link-ext"></i>
								</a>
							</li>
						</ul>
					</li>			
				</ul>
			
			
				<!-- Right links for user info navbar -->
				<ul class="user-info-menu right-links list-inline list-unstyled">
			
					<li class="dropdown user-profile">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="assets/images/user-4.png" alt="" width="28" />
							<span>
							    <?php echo $_SESSION['username']; ?>
								<?php echo $_SESSION['']; ?>
							</span>
						</a>
			
						<ul class="dropdown-menu user-profile-menu list-unstyled">
						
								</a>
							</li>
							<li class="last">
								<a href="logout.php">
									<i class="fa fa-close"></i>
									Disconnect
								</a>
							</li>
						</ul>
					</li>
						
				</ul>
			
			</nav>