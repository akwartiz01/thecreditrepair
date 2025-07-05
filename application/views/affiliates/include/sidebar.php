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
		<a href="<?php echo $base_url; ?>affiliate/account">
			<img src="<?php echo $base_url; ?>assets/images/logo.png" alt="" class="img-fluid">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
			   <li class="<?php echo ($page == 'affiliate/account') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('affiliate/account'); ?>"><i class="mdi mdi-account-circle"></i> <span>My Account</span></a>

				</li>
                 <li class="<?php echo ($page == 'affiliate/sendreferral') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('affiliate/sendreferral'); ?>"><i class="mdi mdi-send"></i> <span>Send a Referral</span></a>

				</li>
                 <li class="<?php echo ($page == 'affiliate/myreferrals') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('affiliate/myreferrals'); ?>"><i class="mdi mdi-account-multiple-plus"></i> <span>My Referrals</span></a>

				</li>
				<!--<li class="<?php echo ($page == 'affiliate/messages') ? 'active' : ''; ?>">-->
				<!--	<a href="<?php echo base_url('affiliate/messages'); ?>">-->
				<!--		<i class="mdi mdi-forum"></i>-->
				<!--		<span>Messages</span>-->
				<!--		<?php if ($unread_message_count > 0): ?>-->
				<!--			<span class="badge badge-pill badge-danger"><?php echo $unread_message_count; ?></span>-->
				<!--		<?php endif; ?>-->
				<!--	</a>-->
				<!--</li>-->
				<li class="<?php echo ($page == 'affiliate/webleadform') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('affiliate/webleadform'); ?>"><i class="mdi mdi-file-document-edit-outline"></i> <span>Web Lead Form</span></a>

				</li>
				<li class="<?php echo ($page == 'affiliate/creditinfo') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('affiliate/creditinfo'); ?>"><i class="mdi mdi-file-document-box menu-icon"></i> <span>Credit Info</span></a>

				</li>
				<li class="<?php echo ($page == 'affiliate/resources') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('affiliate/resources'); ?>"><i class="mdi mdi-book-open-page-variant"></i> <span>Resources</span></a>

				</li>


			

			</ul>
		</div>
	</div>
</div>