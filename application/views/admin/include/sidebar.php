<?php
    $page = $this->uri->segment(1);
    $active =$this->uri->segment(2);
	$access_result_data_array = $this->session->userdata('access_module');	
	$admin_id=$this->session->userdata('admin_id');
	//echo "<pre>";print_r($this->session->userdata('admin_id'));exit;	
 ?>
 <div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo $base_url; ?>dashboard">
			<img src="<?php echo $base_url; ?>assets/img/logo-icon.png" class="img-fluid" alt="">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="<?php echo ($page == 'dashboard')?'active':'';?>">
					<a href="<?php echo $base_url; ?>dashboard"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
				</li>
				<?php if(in_array(2,$access_result_data_array) || in_array(3,$access_result_data_array)) { ?>
				<li class="submenu <?php echo ($page == 'categories' || $page == 'add-category' || $page == 'edit-category' || $page == 'subcategories' || $page == 'add-subcategory' || $page == 'edit-subcategory') ? 'active':'';?>">
					<a href="#">
						<i class="fas fa-layer-group"></i> <span>Categories</span>
					</a>
					<ul>
						<?php
						if(in_array(2,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'categories' || $page == 'add-category' || $page == 'edit-category') ? 'active':'';?>" href="<?php echo $base_url; ?>categories"> <span>Categories</span></a>
						</li>
						<?php
						} if(in_array(3,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'subcategories' || $page == 'add-subcategory' || $page == 'edit-subcategory') ? 'active':'';?>" href="<?php echo $base_url; ?>subcategories"> <span>Sub Categories</span></a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				<?php } ?>
				
				<?php if(in_array(4,$access_result_data_array)) { ?>
				<li class="<?php echo ($page == 'service-list' || $page == 'service-details') ? 'active':'';?>">
					<a href="<?php echo $base_url; ?>service-list">
						<i class="fas fa-bullhorn"></i> <span> Services</span>
					</a>
				</li>
				<?php } ?>
				
				<?php if(in_array(1,$access_result_data_array) || in_array(13,$access_result_data_array) || in_array(12,$access_result_data_array)) { ?>
				<li class="submenu <?php echo ($page == 'adminusers')?'active':''; echo ($page == 'edit_adminuser')?'active':''; echo ($page == 'adminuser_details')?'active':''; echo ($page == 'users')?'active':''; echo ($page == 'service-providers')?'active':''; echo ($page == 'user-details')?'active':''; echo ($page == 'provider-details')?'active':'';?>">
					<a href="#">
						<i class="fas fa-users"></i> <span>User Settings </span>
					</a>
					<ul>
					    <?php
						if(in_array(1,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'adminusers')?'active':''; echo ($page == 'edit_adminuser')?'active':''; echo ($page == 'adminuser_details')?'active':'';?>" href="<?php echo $base_url; ?>adminusers"><span>Admin</span></a>
						</li>
						<?php
						} if(in_array(13,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'users')?'active':'';echo ($page == 'user-details')?'active':'';?>" href="<?php echo $base_url; ?>users"> <span>Users</span></a>
						</li>
						<?php
						} if(in_array(12,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'service-providers')?'active':''; echo ($page == 'provider-details')?'active':''; ?>" href="<?php echo $base_url; ?>service-providers"> <span> Service Providers</span></a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				<?php } if (in_array(27, $access_result_data_array) || in_array(28,$access_result_data_array) || in_array(29,$access_result_data_array) ) { ?>
                <li class="submenuu <?php echo ($active == 'chat' || $page == 'provider-chat' || $page == 'client-chat') ? 'active' : ''; ?>">
                <a  href="<?php echo $base_url; ?>admin/chat"><i class="far fa-comments"></i> <span>Chat</span></a>
					<?php /* ?>
                   <ul>
                        <?php if (in_array(28, $access_result_data_array)) { ?>
                            <li>
                                <a class="<?php echo ($page == 'provider-chat') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>provider-chat"><span>Provider Chat</span></a>
                            </li>
                        <?php }
                        if (in_array(29, $access_result_data_array)) { ?>
                            <li>
                                <a class="<?php echo ($page == 'client-chat') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>client-chat"> <span>User Chat</span></a>
                            </li>
                        <?php } ?>
                    </ul> <?php */ ?>
                </li>
                <?php } if(in_array(5,$access_result_data_array)) { ?>
				<li class="<?php echo ($active =='total-report' || $active =='pending-report' || $active == 'inprogress-report' || $active == 'complete-report' || $active == 'reject-report' || $active == 'cancel-report' ||$page == 'reject-payment')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/total-report"><i class="far fa-calendar-check"></i> <span> Booking List</span></a>
				</li>
				<?php } if(in_array(30,$access_result_data_array) || in_array(31,$access_result_data_array) || in_array(32,$access_result_data_array)) { ?>
				<!--li class="submenu <?php echo ($page == 'provider-block' || $page == 'user-block') ? 'active' : ''; ?>">
	                <a href="#"><i class="fas fa-ban"></i> <span> Blocked List</span></a>
                   <ul>
                        <?php if (in_array(31, $access_result_data_array)) { ?>
                            <li>
                                <a class="<?php echo ($page == 'provider-block') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>provider-block"><span>Blocked Provider</span></a>
                            </li>
                        <?php }
                        if (in_array(32, $access_result_data_array)) { ?>
                            <li>
                                <a class="<?php echo ($page == 'user-block') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>user-block"> <span>Blocked User</span></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li--><!-- 
				<li class="<?php echo ($page == 'blocked-users') ? 'active' : ''; ?>">
					<a href="<?php echo $base_url; ?>blocked-users"><i class="fas fa-ban"></i> <span> Blocked Users</span></a>
				</li> -->
				<?php } ?>
				<?php if(in_array(9,$access_result_data_array) || in_array(6,$access_result_data_array) || in_array(10,$access_result_data_array) || in_array(11,$access_result_data_array)|| in_array(18,$access_result_data_array)) { ?>
					<li class="submenu <?php echo ($page == 'payment_list' || $page == 'payment_details' || $page == 'admin-payment' || $page == 'withdraw_list' || $page == 'view_withdraw' || $page == 'subscriptions' || $page == 'add-subscription' || $page == 'edit-subscription' || $active =='wallet' || $active =='wallet-history')? 'active':''; echo ($page == 'Revenue')?'active':''; echo ($active == 'cod')?'active':'';?>">
					<a href="#">
						<i class="far fa-money-bill-alt"></i> <span>Accounting </span>
					</a>
					<ul>
						<?php if(in_array(9,$access_result_data_array)) { ?>				
				<li>
					<a href="<?php echo $base_url; ?>subscriptions" class="<?php echo ($page == 'subscriptions')?'active':''; echo ($page == 'add-subscription')?'active':''; echo ($page == 'edit-subscription')?'active':'';?>"> <span>Subscriptions</span></a>
				</li>
				<?php } if(in_array(6,$access_result_data_array)) {?>
					<li>
						<a href="<?php echo $base_url; ?>payment_list" class="<?php echo ($page == 'payment_list')?'active':''; echo ($page == 'admin-payment')?'active':'';?>"><span>Payments</span></a>
					</li>
				<?php
				} if(in_array(10,$access_result_data_array)) { 
				?>
					<li>
						 <a href="<?php echo $base_url; ?>admin/wallet" class="<?php echo ($active =='wallet' || $active =='wallet-history')? 'active':''; ?>"><span> Wallet</span></a>
					</li>
				<?php
				} if(in_array(11,$access_result_data_array)) {
				?>
					<li>
						<a class="<?php echo ($page == 'Revenue') ? 'active':'';?>"  href="<?php echo $base_url; ?>Revenue"> <span>Revenue</span></a>
					</li>
				<?php
				} if(in_array(18,$access_result_data_array)) {
				?>
					<li>
						<a class="<?php echo ($active == 'cod') ? 'active':'';?>"  href="<?php echo $base_url; ?>admin/cod"> <span>COD</span></a>
					</li>
				<?php
				}
                ?>				
					</ul>
				</li>
				<?php } ?>
				<?php if(in_array(14,$access_result_data_array) || in_array(15,$access_result_data_array) || in_array(16,$access_result_data_array)) { ?>
					<li class="submenu <?php echo ($active == 'settings' || $active =='emailsettings' || $active =='stripe_payment_gateway' || $active =='sms-settings' || $active =='theme-color' || $active == 'cancellation-amount-settings' || $page == 'language' || $page == 'add-language' || $page == 'wep_language' || $page == 'add-app-keyword' || $page == 'app_page_list' || $active == 'country_code_config' || $page == 'district' || $page == 'taluk' || $page == 'area' || $page == 'cod') ? 'active':''; ?>">
					<a href="#">
						<i class="fas fa-cog"></i> <span>Web Settings </span>
					</a>
					<ul>
						<?php if(in_array(14,$access_result_data_array)) { ?>
							<li >
								<a href="<?php echo $base_url; ?>admin/settings" class="<?php echo ($active == 'settings' || $active =='emailsettings' || $active =='stripe_payment_gateway' || $active =='sms-settings' || $active == 'theme-color')? 'active':''; ?>"> <span> Settings</span></a>
							</li> 
						
						<?php } if(in_array(15,$access_result_data_array)) { ?>
						<li>
							<a href="<?php echo $base_url; ?>language" class="<?php echo ($page == 'language' || $page == 'wep_language' || $page == 'app_page_list' || $page == 'add-app-keyword' || $page == 'add-language')?'active':'';?>"> <span>Language</span></a>
						</li>
						<?php } if(in_array(16,$access_result_data_array)) { ?>
						<li>
							<a href="<?php echo $base_url; ?>admin/country_code_config" class="<?php echo ($active == 'country_code_config')?'active':'';?>"> <span>Country Code</span></a>
						</li>	
						<?php } ?>						
						<li class="d-none">
							<a class="<?php echo ($page == 'cod')? 'active':''; ?>" href="<?php echo $base_url; ?>admin/cod"> <span> COD</span></a>
						</li>
					</ul>
				</li>
				<?php } if(in_array(17,$access_result_data_array) || in_array(7,$access_result_data_array) || in_array(8,$access_result_data_array)) { ?>
					<li class="submenu <?php echo ($active == 'contact' || $page == 'contact-details' || $page == 'ratingstype' || $page == 'add-ratingstype' || $page == 'edit-ratingstype' || $page == 'review-reports' || $page == 'add-review-reports' || $page == 'edit-review-reports' || $page == 'view_review') ? 'active':'';?>">
					<a href="#">
						<i class="far fa-address-book"></i> <span>Contact </span></a>
					<ul>						
				<?php if(in_array(17,$access_result_data_array)) { ?>
				<li >
					<a href="<?php echo $base_url; ?>admin/contact" class="<?php echo ($active == 'contact' ||				
					 $page == 'contact-details')?'active':''; ?>"><span>Contact Details</span></a>
				</li>
				<?php } ?>
				<?php if(in_array(7,$access_result_data_array)) { ?>
				<li>
					 <a href="<?php echo $base_url; ?>ratingstype" class="<?php echo ($page == 'ratingstype')?'active':''; echo ($page == 'add-ratingstype')?'active':''; echo ($page == 'edit-ratingstype')?'active':'';?>"><span>Rating Type</span></a>
				</li> 
				<?php }if(in_array(8,$access_result_data_array)) { ?>
				<li>
					 <a href="<?php echo $base_url; ?>review-reports" class="<?php echo ($page == 'review-reports')?'active':''; echo ($page == 'add-review-reports')?'active':''; echo ($page == 'edit-review-reports')?'active':'';?>"><span>Ratings</span></a>
				</li>
				<?php } ?>	
					</ul>
				</li>
				<?php } if(in_array(20,$access_result_data_array)) { ?>
				<li class="<?php echo ($active == 'emailtemplate' || $active =='edit-emailtemplate')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/emailtemplate"><i class="fas fa-envelope"></i> <span> Email Templates</span></a>
				</li>
				<?php } if(in_array(19,$access_result_data_array)) { ?>	
				<li class="<?php echo ($active == 'SendPushNotificationList' || $active =='SendPushNotification')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/SendPushNotificationList"><i class="fa fa-bell"></i> <span> Push Notifications</span></a>
				</li>
				<?php } ?>
				<?php if(in_array(21,$access_result_data_array) || in_array(22,$access_result_data_array)) { ?>	
				<li class="submenu <?php echo ($active == 'footer_menu' || $active == 'footer_submenu')?'active':''; ?>">
					<a href="#">
						<i class="fas fa-cog"></i> <span>Menu Settings </span>
					</a>
					<ul>
					<?php if(in_array(21,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'footer_menu')?'active':'';?>" href="<?php echo $base_url; ?>admin/footer_menu"> <span>Footer Menu</span></a>
					</li>
					<?php } if(in_array(22,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'footer_submenu')?'active':'';?>" href="<?php echo $base_url; ?>admin/footer_submenu"> <span>Footer Sub menu</span></a>
					</li>
					<?php }?>
					</ul>
				</li>
				<?php } ?>
				<?php if(in_array(23,$access_result_data_array) || in_array(24,$access_result_data_array) || in_array(25,$access_result_data_array) || in_array(26,$access_result_data_array)) { ?>	
				<li class="submenu <?php echo ($active == 'aboutus' || $active == 'privacypolicy' || $active == 'termconditions'|| $active == 'banner_image')?'active':''; ?>">
					<a href="#">						
						<i class="fas fa-cogs"></i> <span>CMS </span></a>
					<ul>
					<?php  if(in_array(23,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'banner_image')?'active':'';?>" href="<?php echo $base_url; ?>admin/banner_image"> <span>Home Banner</span></a>
					</li>
					<?php } if(in_array(24,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'aboutus')?'active':'';?>" href="<?php echo $base_url; ?>admin/aboutus"> <span>About Us</span></a>
					</li>
					<?php } if(in_array(25,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'privacypolicy')?'active':'';?>" href="<?php echo $base_url; ?>admin/privacypolicy"> <span>Privacy Policy</span></a>
					</li>
					<?php } if(in_array(26,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'termconditions')?'active':'';?>" href="<?php echo $base_url; ?>admin/termconditions"> <span>Terms and Conditions</span></a>
					</li>
					<?php }?>
					</ul>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>