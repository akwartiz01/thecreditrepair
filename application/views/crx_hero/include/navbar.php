<?php
$base_url = base_url();

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

		<li class="nav-item dropdown noti-dropdown logged-item">

			<a>

				<select class="form-control" id="default_nav_lang">

					<option value='1'>en</option>

				</select>

			</a>

		</li>

		<li class="nav-item dropdown noti-dropdown logged-item">

			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

				<i class="far fa-bell"></i>


				<span class="" style="padding: unset !important;"></span>


			</a>

			<!-- chat -->


			<a href='' alt="Chat" data-toggle="tooltip" class="nav-link" title="Chat">

				<i class="far fa-comment-dots"></i>

				<div class="chat_counts">

					<!-- <span class="chat_count position-absolute chat_color badge_col bg-yellow-chat chat-bg-yellow" id="chat_counts"></span> -->

					<span class='chat_count position-absolute badge-theme' id="chat_counts"></span>


				</div>

			</a>

			<div class="dropdown-menu dropdown-menu-right notifications">

				<div class="topnav-dropdown-header">

					<span class="notification-title">Notifications</span>

					<a href="javascript:void(0)" class="clear-noti noty_clear" data-token=""> Clear All</a>

				</div>

				<div class="noti-content">

					<ul class="notification-list">

						<li class="notification-message">

							<a href="">

								<div class="media">

									<span class="avatar avatar-sm">

										<!-- <img class="avatar-img rounded-circle" alt="Image" src=""> -->

									</span>

									<div class="media-body">

										<p class="noti-details"><span class="noti-title"></span> <span class="noti-title"></span></p>

										<p class="noti-time"><span class="notification-time"></span></p>

									</div>

								</div>

							</a>

						</li>
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

					<img class="rounded-circle" src="<?php echo base_url(); ?>assets/img/user.jpg" width="40" alt="Admin">
				</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">

				<a class="dropdown-item" id="profile_setting" href="<?php echo base_url(); ?>">Profile</a>
				<a class="dropdown-item" href="<?php echo $base_url; ?>creditheroscore/signout">Logout</a>

			</div>
		</li>
	</ul>
</div>