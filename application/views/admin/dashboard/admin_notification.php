<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Notification List</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->

	
		<div class="admin-noti-wrapper">

			<?php //echo count($admin_notification); echo count($booking_list); //exit();
			if(count($admin_notification)>0){
				foreach ($admin_notification as $key => $value) {
	                $full_date =date('Y-m-d H:i:s', strtotime($value['created_at']));
					$date=date('Y-m-d',strtotime($full_date));
					$date_f=date('d-m-Y',strtotime($full_date));
					$yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
					$time=date('H:i',strtotime($full_date));
					$session = date('h:i A', strtotime($time));
					if($date == date('Y-m-d')){
						$timeBase ="Today ".$session;
					}elseif($date == $yes_date){
						$timeBase ="Yester day ".$session;
					}else{
						$timeBase =$date_f." ".$session;
					}
				?>
				<div class="noti-list">
					<div class="noti-avatar">
						<?php
						if(file_exists($value['profile_img'])){
							$image=base_url().'uploads/profile_img/'.$value['profile_img'];
						}else{
							$image=base_url().'assets/img/user.jpg';
						}
						?>
						<img src="<?php echo $image;?>" alt="">
					</div>
					<div class="noti-contents">
						<h3><?=strtolower($value['message']);?></h3>
						<span><?=$timeBase;?></span>
					</div>
				</div>

			<?php } 
			} /*else if(count($booking_list) > 0) { 
				foreach ($booking_list as $key => $booking) {
	                $full_date =date('Y-m-d H:i:s', strtotime($booking->request_date));
					$date=date('Y-m-d',strtotime($full_date));
					$date_f=date('d-m-Y',strtotime($full_date));
					$yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
					$time=date('H:i',strtotime($full_date));
					$session = date('h:i A', strtotime($time));
					if($date == date('Y-m-d')){
						$timeBase ="Today ".$session;
					}elseif($date == $yes_date){
						$timeBase ="Yester day ".$session;
					}else{
						$timeBase =$date_f." ".$session;
					}
				?>
				<div class="noti-list">
					<div class="noti-avatar">
						<?php
						if(!empty($booking->profile_img)){
							$image=base_url().'uploads/profile_img/'.$booking->profile_img;
						}else{
							$image=base_url().'assets/img/user.jpg';
						}
						?>
						<img src="<?php echo $image;?>" alt="">
					</div>
					<div class="noti-contents">
						<h3>
							<?php 
							if(empty($booking->notes)) {
								echo "- -";
							}else{
								echo ucfirst(strtolower($booking->notes));
							}
							?>								
						</h3>
						<span><?=$timeBase;?></span>
					</div>
				</div>
			<?php }
			}*/ else{ ?>
			<div class="notificationlist">
				<p class="text-danger mt-3">Notification Empty</p>
			</div>
	       <?php } ?>
		</div>		   
      
	</div>
</div>