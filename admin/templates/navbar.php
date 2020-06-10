<nav class="navbar user-info-navbar"  role="navigation">
			
				<!-- Left links for user info navbar -->
				<ul class="user-info-menu left-links list-inline list-unstyled">
			
					<li class="hidden-sm hidden-xs">
						<a href="#" data-toggle="sidebar">
							<i class="fa-bars"></i>
						</a>
					</li>
			
					<li class="dropdown hover-line">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa-envelope-o"></i>
							<span class="badge badge-green"><?php echo $stats -> pendingTickets($odb, $_SESSION['ID']); ?></span>
						</a>
			
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
							<img src="../assets/images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
							<span>
								<?php echo $_SESSION['username']; ?>
								<i class="fa-angle-down"></i>
							</span>
						</a>
			
						<ul class="dropdown-menu user-profile-menu list-unstyled">
							<li>
								<a href="../index.php">
									<i class="fa-reply"></i>
									Back to Home
								</a>
							</li>
							<li>
								<a href="../account.php">
									<i class="fa-wrench"></i>
									Settings
								</a>
							</li>
							<li class="last">
								<a href="../logout.php">
									<i class="fa-lock"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>
						
				</ul>
			
			</nav>