<?php
$base_url = base_url();

$recent_activity = $this->User_model->query("SELECT * FROM sq_activity WHERE user_status = 'subscriber' ORDER BY id desc LIMIT 5");
if ($recent_activity->num_rows() > 0) {
	//   $admin_notification = $recent_activity->result();
	$admin_notification = $recent_activity->result_array();
} else {
	$admin_notification = [];
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

				if (!empty($admin_notification)) {

				?>

					<span class="badge badge-pill"></span>

				<?php }
				?>

			</a>

			<!-- chat -->




			<a alt="Chat" data-toggle="tooltip" class="nav-link" title="Chat" href="">

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

						<?php foreach ($admin_notification as $value) {

							$full_date = date('Y-m-d H:i:s', strtotime($value['datetime']));

							$time = date('H:i', strtotime($full_date));

							$session = date('h:i A', strtotime($time));

							$timeBase = $value['datetime'];

							$userID = $value['user_id'];
							$user = $this->User_model->query("SELECT * FROM sq_users WHERE `sq_u_id` ='" . $userID . "'");

							$user = $user->result();
							if (!empty($user[0]->sq_u_profile_picture)) {

								$image = $user[0]->sq_u_profile_picture;
							} else {
								$user = [];
								$image = base_url('assets/assets/img/user.jpg');
							}

							$f_name = $user[0]->sq_u_first_name ?? '';
							$l_name = $user[0]->sq_u_last_name ?? '';
							$name = trim("$f_name $l_name");

						?>

							<li class="notification-message">

								<a href="">

									<div class="media">

										<span class="avatar avatar-sm">

											<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo $image; ?>">

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
					if (!empty($user_id)) {
						$get_data = $this->db->where('sq_u_id', $user_id)->get('sq_users')->row_array();

						$profile_image = (!empty($get_data['sq_u_profile_picture'])) ? $get_data['sq_u_profile_picture'] : base_url('assets/assets/img/user.jpg');
					}

					?>
					<img class="rounded-circle" src="<?php echo $profile_image; ?>" width="40" alt="Admin">
				</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">

				<!-- <a class="dropdown-item" href="<?php echo base_url('profile-stting'); ?>">Profile</a> -->
				<a class="dropdown-item" id="profile_setting" href="<?php echo base_url('profile-stting?tab=profile'); ?>">Profile</a>
				<a class="dropdown-item" href="<?php echo $base_url; ?>sign-out">Logout</a>

			</div>
		</li>
	</ul>

</div>

<?php if ($this->session->flashdata('error_message')) {  ?>
	<div class="alert alert-danger text-center" id="flash_error_message"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;<?php echo $this->session->flashdata('error_message'); ?></div>
<?php $this->session->unset_userdata('error_message');
} ?>
<?php if ($this->session->flashdata('success_message')) {  ?>
	<div class="alert alert-success text-center" id="flash_succ_message"><i class="fas fa-check" aria-hidden="true"></i>&nbsp;
		<?php echo $this->session->flashdata('success_message'); ?></div>
<?php $this->session->unset_userdata('success_message');
} ?>


