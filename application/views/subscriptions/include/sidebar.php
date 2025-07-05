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

				<?php if ($user_type == 'super') { ?>

					<li>
						<a href="<?php echo $base_url; ?>admin"><i class="fas fa-columns"></i>
							<span>Home</span>
						</a>
					</li>

					<!-- <li class="<?php echo ($page == 'chat') ? 'active' : ''; ?>">

						<a href="<?php echo base_url('chat'); ?>"><i class="fas fa-comments"></i> <span>Chat</span></a>

					</li> -->

					<li class="<?php echo ($page == 'secure-messages') ? 'active' : ''; ?>">

						<a href="<?php echo base_url('secure-messages'); ?>"><i class="mdi mdi-comment"></i> <span>Messages</span></a>

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

				<?php } else { ?>

					<li class="menu-title">
						<span>Main</span>
					</li>
					<li class="<?php echo ($page == 'subscriber/dashboard') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>subscriber/dashboard"><i class="fas fa-columns"></i>
							<span>Dashboard</span>
						</a>
					</li>

					<li class="<?php echo ($page == 'clients_list') ? 'active' : ''; ?>">
						<a href="<?php echo base_url('clients_list'); ?>"><i class="fa fa-group"></i>
							<span>Clients</span>
						</a>
					</li>

					<li class="<?php echo ($page == 'team-members') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>team-members"><i class="fa fa-user"></i>
							<span>Team Members</span>
						</a>
					</li>

					<li class="<?php echo ($page == 'my_company') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>my_company"><i class="fa fa-building-o"></i>
							<span>My Company</span>
						</a>
					</li>

					<li class="<?php echo ($page == 'contacts') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>contacts"><i class="fa fa-address-book"></i>
							<span>Contacts</span>
						</a>
					</li>

					<li class="<?php echo ($page == 'credit-monitoring') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>credit-monitoring"><i class="fa fa-credit-card"></i>
							<span>CRX Credit Monitoring</span>
						</a>
					</li>

				<?php  } ?>
			</ul>
		</div>
	</div>
</div>