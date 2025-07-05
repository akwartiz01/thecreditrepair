<?php
$page = $this->uri->segment(1);
$active = $this->uri->segment(2);
$page2 = $this->uri->segment(3);

$getUser = '';
$access_result_data_array = [];
$user_id = $this->session->userdata('user_id');

$user_type = $this->session->userdata('user_type');

$sidebar = '';
$base_url = base_url();

$user_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE `read_status` = 0 AND `recipient_type` = 'admin' AND `receiver_id` ='$user_id'");
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
				<li class="menu-title">
					<span>Main</span>
				</li>

				<li>
					<a href="<?php echo $base_url; ?>admin"><i class="fas fa-columns"></i>
						<span>Home</span>
					</a>
				</li>

				<li class="<?php echo ($page == 'secure-messages') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('secure-messages'); ?>"><i class="mdi mdi-comment"></i> <span>Messages</span>
						<?php if ($unread_message_count > 0): ?>
							<span class="badge badge-pill badge-danger"><?php echo $unread_message_count; ?></span>
						<?php endif; ?>
					</a>

				</li>

				<li class="<?php echo ($page == 'quick_notes') ? 'active' : ''; ?>">

					<a href="<?php echo base_url('quick_notes'); ?>"><i class="mdi mdi-text"></i> <span>Quick Notes</span></a>

				</li>

				<li>
					<a href="<?php echo $base_url; ?>clients"><i class="mdi mdi-account-multiple menu-icon"></i>
						<span>Clients</span>
					</a>
				</li>

				<li>

					<a href="<?php echo base_url('plans'); ?>"><i class="mdi mdi-cash-multiple menu-icon"></i> <span>My Plans</span></a>

				</li>

				<li>
					<a href="<?php echo $base_url; ?>schedule"><i class="mdi mdi-calendar-clock menu-icon"></i>
						<span>Schedule</span>
					</a>
				</li>

				<li>

					<a href="<?php echo base_url('my-company'); ?>"><i class="mdi mdi-home-map-marker menu-icon"></i> <span>My Company</span></a>

				</li>

				<li>

					<a href="<?php echo base_url('invoices'); ?>"><i class="mdi mdi-file-document menu-icon"></i> <span>Invoices</span></a>

				</li>

				<li>

					<a href="<?php echo base_url('templates'); ?>"><i class="mdi mdi-library menu-icon"></i> <span>Letter Library</span></a>

				</li>

				<li>

					<a href="<?php echo base_url('affiliates'); ?>"><i class="mdi mdi-webpack menu-icon"></i> <span>Affiliate</span></a>

				</li>

				<li>

					<a href="<?php echo base_url('furnisher'); ?>"><i class="mdi mdi-file-document-box menu-icon"></i> <span>Creditor Furnisher</span></a>

				</li>


			</ul>
		</div>
	</div>
</div>