<?php
$page = $this->uri->segment(1) . '/' . $this->uri->segment(2);
$active = $this->uri->segment(2);
$page2 = $this->uri->segment(3);

$getUser = '';
$access_result_data_array = [];
$user_id = $this->session->userdata('user_id');

$sidebar = '';
$base_url = base_url();

$user_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE `read_status` = 0 AND `recipient_type` = 'client' AND `receiver_id` ='$user_id'");
$user_result = $user_query->num_rows();
$unread_message_count = $user_result;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo $base_url; ?>">
			<img src="<?php echo $base_url; ?>assets/images/logo.png" alt="" class="img-fluid">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>

				<li class="<?php echo ($page == 'client/dashboard') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/dashboard'); ?>"><i class="mdi mdi-home"></i> <span>Home</span></a>

				</li>


				<li class="<?php echo ($page == 'client/credit-reports') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/credit-reports'); ?>">
						<img src="<?php echo base_url('assets/credit/credit-score.png'); ?>" style="height: 17px;" alt="">
						<span>Credit Reports</span></a>

				</li>

				<li class="<?php echo ($page == 'client/saved-reports') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/saved-reports'); ?>"><i class="mdi mdi-file-chart"></i><span>Saved Reports</span></a>

				</li>



				<li class="<?php echo ($page == 'client/saved_letters') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/saved_letters'); ?>">
						<i class="fa fa-envelope"></i>
						<span>Saved Letters</span></a>

				</li>

				<?php if ($this->session->userdata('user_type') == 'client'): ?>
					<li class="<?php echo ($page == 'client/dispute-details') ? 'active' : ''; ?>">

						<a href="<?php echo base_url('client/dispute-details'); ?>"><i class="mdi mdi-credit-card-scan"></i> <span>Dispute Details</span></a>

					</li>
				<?php endif; ?>

				<li class="<?php echo ($page == 'client/secure-messages') ? 'active' : ''; ?>">
					<a href="<?php echo base_url('client/secure-messages'); ?>">
						<i class="mdi mdi-forum"></i>
						<span>Messages</span>
						<?php if ($unread_message_count > 0): ?>
							<span class="badge badge-pill badge-danger"><?php echo $unread_message_count; ?></span>
						<?php endif; ?>
					</a>
				</li>


				<li class="<?php echo ($page == 'client/bills-section') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/bills-section'); ?>"><i class="mdi mdi-file-document menu-icon"></i> <span>My Bills Section</span></a>

				</li>

				<li class="<?php echo ($page == 'client/credit-info') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/credit-info'); ?>"><i class="mdi mdi-file-document-box menu-icon"></i> <span>Credit Info</span></a>

				</li>

				<li class="<?php echo ($page == 'client/resources') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/resources'); ?>"><i class="mdi mdi-credit-card-scan"></i> <span>Resources</span></a>

				</li>

				<li class="<?php echo ($page == 'client/settings' || $page == 'client/profile_setting' || $page == 'client/profile_setting') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('client/profile_setting?tab=profile'); ?>"><i class="mdi mdi-cogs"></i> <span>Settings</span></a>

				</li>

			</ul>
		</div>
	</div>
</div>