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

		<!--<li class="nav-item dropdown noti-dropdown logged-item">-->

		<!--	<a>-->

		<!--		<select class="form-control" id="default_nav_lang">-->

		<!--			<option value='1'>en</option>-->

		<!--		</select>-->

		<!--	</a>-->

		<!--</li>-->

	

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
			<?php if ($this->session->userdata('affiliates_user_id')): ?>
				<div class="dropdown-menu dropdown-menu-right">

					<!--<a class="dropdown-item" id="profile_setting" href="<?php echo base_url('client/profile_setting?tab=profile'); ?>">Profile</a>-->
					<a class="dropdown-item" href="<?php echo $base_url; ?>signout">Logout</a>

				</div>
			<?php endif; ?>
		</li>
	</ul>
</div>