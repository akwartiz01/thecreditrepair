<?php
$page = $this->uri->segment(1);
$active = $this->uri->segment(2);
$page2 = $this->uri->segment(3);

$pages = $page . '/' . $active;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo base_url(); ?>subscriber/dashboard"">
			<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="" class="img-fluid">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>

				<li class="menu-title">
					<span>Main</span>
				</li>
				<li class="<?php echo ($pages == 'subscriber/dashboard') ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>subscriber/dashboard"><i class="fas fa-columns"></i>
						<span>Dashboard</span>
					</a>
				</li>

				<li class="<?php echo ($page == 'clients_list') ? 'active' : ''; ?>">
					<a href="<?php echo base_url('clients_list'); ?>"><i class="fa fa-group"></i>
						<span>Clients</span>
					</a>
				</li>

				<!-- <li class="submenu <?php //echo ($pages == 'subscriber/company' || $page == 'team-members' || $page = 'roles') ? 'active' : ''; 
										?>"> -->
				<li class="submenu <?php echo ($pages == 'subscriber/company') ? 'active' : ''; ?>">
					<a href="#">

						<i class="fa fa-building-o"></i> <span> My Company</span><span class="menu-arrow"><i class="fas fa-angle-right"></i></span>

					</a>

					<ul>


						<li>

							<a href="<?php echo base_url(); ?>subscriber/company" class="<?php echo ($pages == 'subscriber/company') ? 'active' : ''; ?>"> <i class="fa fa-building-o"></i> <span>Company</span></a>

						</li>


						<li>

							<a href="<?php echo base_url(); ?>team-members" class="<?php echo ($page == 'team-members') ? 'active' : ''; ?>"><i class="fa fa-group"></i> <span>Team Members</span></a>

						</li>
   <!--ashok - role not required-->
						<!--<li>-->

						<!--	<a href="<?php echo base_url('roles'); ?>" class="<?php echo ($page == 'roles') ? 'active' : ''; ?>"> <i class="fas fa-key"></i> <span>Roles & Permissions</span></a>-->

						<!--</li>-->

					</ul>
				</li>
        <?php
$subscriber_id = $this->session->userdata('user_id');
$this->db->where('sq_u_id_subscriber', $subscriber_id);
$payment_details = $this->db->get('sq_subscription_payment_details')->row_array();
if (!empty($payment_details['subscription_end_date'])) {
    $end_date = strtotime($payment_details['subscription_end_date']);
    $today = strtotime(date('d-m-Y'));

    if ($end_date < $today) {
        // Subscription is expired
    }
    else{ ?>

				<li class="<?php echo ($page == 'credit-monitoring') ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>credit-monitoring"><i class="fa fa-credit-card"></i>
						<span>CRX Credit Monitoring</span>
					</a>
				</li>

				<li class="<?php echo ($page == 'subscriber/subscription') ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>subscriber/subscription"><i class="far fa-calendar-alt"></i>
						<span>Subscription</span>
					</a>
				</li>

				<li class="<?php echo ($page == 'profile-stting') ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>profile-stting?tab=profile" id="profile_setting"><i class="fa fa-gear"></i>
						<span>Profile Setting</span>
					</a>
				</li>
    <?php
        
    }
}
?>
			</ul>
		</div>
	</div>
</div>