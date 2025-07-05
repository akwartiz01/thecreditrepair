<?php
$base_url = base_url();
$chat_detail = '';
$user_id = $this->session->userdata('user_id');
$recent_activity = $this->User_model->query("SELECT * FROM sq_activity WHERE `user_id` = '$user_id ' AND `user_status` = 'client' ORDER BY id desc LIMIT 10");
if ($recent_activity->num_rows() > 0) {
	$client_notification = $recent_activity->result_array();
} else {
	$client_notification = [];
}

?>
<div class="header">
	<div class="header-left">
		<a href="<?php echo $base_url; ?>" class="logo">
			<img src="<?php echo $base_url; ?>assets/images/logo.png" width="140" height="46" alt="">
		</a>
		<a href="<?php echo $base_url; ?>" class="logo logo-small">
			<img src="<?php echo $base_url; ?>assets/images/logo.png" alt="Logo" width="30" height="30">
		</a>
	</div>
		<a href="javascript:void(0);" id="toggle_btn">
		<i class="fas fa-align-left"></i>
	</a>
	<a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
		<i class="fas fa-align-left"></i>
	</a>

	<ul class="nav user-menu header-navbar-rht  head-chat-badge">

		<!-- Notifications -->

	

		<li class="nav-item dropdown noti-dropdown logged-item d-none">


			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

				<i class="far fa-bell"></i>

				<?php

				if (!empty($client_notification)) {

				?>

					<span class="badge badge-pill" style="padding: unset !important;"></span>

				<?php }
				?>

			</a>

			<!-- chat -->


			<a href='<?php echo base_url('client/secure-messages'); ?>' alt="Chat" data-toggle="tooltip" class="nav-link" title="Chat">

				<i class="far fa-comment-dots"></i>

				<div class="chat_counts">

					<!-- <span class="chat_count position-absolute chat_color badge_col bg-yellow-chat chat-bg-yellow" id="chat_counts"></span> -->

					<span class='chat_count position-absolute badge badge-theme' id="chat_counts"></span>


				</div>

			</a>

			<div class="dropdown-menu dropdown-menu-right notifications">

				<div class="topnav-dropdown-header">

					<span class="notification-title">Notifications</span>

					<a href="javascript:void(0)" class="clear-noti noty_clear" data-token=""> Clear All</a>

				</div>

				<div class="noti-content">

					<ul class="notification-list">

						<?php foreach ($client_notification as $value) {

							$full_date = date('Y-m-d H:i:s', strtotime($value['datetime']));

							$time = date('H:i', strtotime($full_date));

							$session = date('h:i A', strtotime($time));

							$timeBase = $value['datetime'];

							$sq_client_id = $value['user_id'];
							$fetch_data = $this->User_model->query("SELECT * FROM `sq_clients` WHERE `sq_client_id` ='" . $sq_client_id . "'");
							$fetch_result = $fetch_data->result();

							$f_name = $fetch_result[0]->sq_first_name ?? '';
							$l_name = $fetch_result[0]->sq_last_name ?? '';
							$name = trim("$f_name $l_name");

							if (!empty($fetch_result && $fetch_result[0]->profile_img)) {

								$image = $fetch_result[0]->profile_img;
							} else {

								$image = base_url('assets/img/user.jpg');
							}

						?>

							<li class="notification-message">

								<a href="">

									<div class="media">

										<span class="avatar avatar-sm">

											<img class="avatar-img rounded-circle" alt="Image" src="<?php echo $image; ?>">

										</span>

										<div class="media-body">

											<p class="noti-details"><span class="noti-title"></span> <span class="noti-title"><?= $name; ?></span></p>

											<p class="noti-time"><span class="notification-time"><?= $value['status'] . ' - ' . $timeBase; ?></span></p>

										</div>

									</div>

								</a>

							</li>

						<?php } ?>

					</ul>

				</div>

				<div class="topnav-dropdown-footer">

					<a href="">View all Notifications</a>

				</div>

			</div>

		</li>

		<!-- /Notifications -->

		<li class="nav-item dropdown">
			<a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
				<span class="user-img">
					<?php
					$user_id = $this->session->userdata('user_id');

					$prof_img = '';
					if (!empty($user_id)) {
						$client_profile = $this->db->where('sq_client_id', $user_id)->get('sq_clients')->row_array();

						if (!empty($client_profile['profile_img'])) {
							$prof_img = $client_profile['profile_img'];
						} else {
							$prof_img = base_url('assets/img/user.jpg');
						}
					}

					?>
					<img class="rounded-circle" src="<?php echo $prof_img; ?>" width="40" alt="Admin">
				</span>
			</a>
			<?php if ($this->session->userdata('user_type') == 'client'): ?>
				<div class="dropdown-menu dropdown-menu-right">

					<a class="dropdown-item" id="profile_setting" href="<?php echo base_url('client/profile_setting?tab=profile'); ?>">Profile</a>
					<a class="dropdown-item" href="<?php echo $base_url; ?>signout">Logout</a>

				</div>
			<?php endif; ?>
		</li>
	</ul>
</div>