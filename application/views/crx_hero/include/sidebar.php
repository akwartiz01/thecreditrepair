<?php
$page = $this->uri->segment(1) . '/' . $this->uri->segment(2);
$active = $this->uri->segment(2);
$page2 = $this->uri->segment(3);

$getUser = '';
$access_result_data_array = [];
$user_id = $this->session->userdata('user_id');

$sidebar = '';

$user_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE `read_status` = 0 AND `recipient_type` = 'client' AND `receiver_id` ='$user_id'");
$user_result = $user_query->num_rows();
$unread_message_count = $user_result;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo base_url(); ?>">
			<img src="<?php echo base_url(); ?>assets/images/credit_hero_logo.png" alt="" class="img-fluid">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>

				<li class="<?php echo ($page == 'creditheroscore/credit-reports') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('creditheroscore/credit-reports'); ?>">
						<img src="<?php echo base_url('assets/credit/credit-score.png'); ?>" style="height: 17px;" alt=""> <span>Credit Reports</span>
					</a>
				</li>

				<li class="<?php echo ($page == 'creditheroscore/saved-reports') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('creditheroscore/saved-reports'); ?>"><i class="mdi mdi-file-chart"></i> <span>Saved Reports</span>
					</a>

				</li>

				<li class="<?php echo ($page == 'creditheroscore/myaccount') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('creditheroscore/myaccount'); ?>"><i class="mdi mdi-account"></i> <span>My Account</span></a>

				</li>

				<!-- <li class="">

					<a href=""><i class="mdi mdi-cogs"></i> <span>Settings</span></a>

				</li> -->


			</ul>
		</div>
	</div>
</div>