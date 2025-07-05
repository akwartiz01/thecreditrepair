<?php
$base_url = base_url();

$user_type = $this->session->userdata('user_type');
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

		<li class="nav-item dropdown">
			<a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
				<span class="user-img">
					<?php
					$user_id = $this->session->userdata('user_id');
					if (!empty($user_id)) {
						$admin_profile = $this->db->where('sq_u_id', $user_id)->get('sq_users')->row_array();

						$profile_image = (!empty($admin_profile['sq_u_profile_picture'])) ? $admin_profile['sq_u_profile_picture'] : base_url('assets/assets/img/user.jpg');
					}

					?>
					<img class="rounded-circle" src="<?php echo $profile_image; ?>" width="40" alt="Admin">
				</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<?php if ($user_type == 'super') { ?>
					<a class="dropdown-item" href="<?php echo base_url('profile'); ?>">Profile</a>
					<a class="dropdown-item" href="<?php echo $base_url; ?>sign-out">Logout</a>
				<?php } elseif ($user_type == 'client') { ?>
					<a class="dropdown-item" href="">Profile</a>
					<a class="dropdown-item" href="<?php echo $base_url; ?>signout">Logout</a>
				<?php } else { ?>
					<a class="dropdown-item" href="">Profile</a>
					<a class="dropdown-item" href="<?php echo $base_url; ?>sign-out">Logout</a>
				<?php } ?>
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