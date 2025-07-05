<?php

$user_type = $this->session->userdata('user_type');

$user_id = $this->session->userdata('user_id');
$fetch_user = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_id` = '" . $user_id . "'");
$sq_u_role = '';
if ($fetch_user->num_rows() > 0) {
  $fetch_user = $fetch_user->row();
  $sq_u_role =  $fetch_user->sq_u_role;
} else {
  $fetch_user = [];
}

$date = date('Y-m-d');
$calendar = $this->User_model->query("SELECT * FROM sq_calender WHERE `start` >= '" . $date . "' ORDER BY start asc LIMIT 5");
if ($calendar->num_rows() > 0) {
  $calendar = $calendar->result();
} else {
  $calendar = [];
}

$leads = $this->User_model->query("SELECT * FROM sq_clients WHERE `sq_status` = 1 ORDER BY sq_client_id desc LIMIT 5");
if ($leads->num_rows() > 0) {
  $leads = $leads->result();
} else {
  $leads = [];
}


$clients = $this->User_model->query("SELECT * FROM sq_clients");
if ($clients->num_rows() > 0) {
  $client_data = $clients->result();
} else {
  $client_data = [];
}
$user_id = $this->session->userdata('user_id');

// Fetch recent activities and count unread activities in one query
$this->db->select('*');
$this->db->from('notifications');
$this->db->where('receiver_id', $user_id);
$this->db->where('sender_id !=', $user_id);
$this->db->order_by('id', 'desc');
$recent_activity_query = $this->db->get();

$recent_activity = $recent_activity_query->result();

// Count unread notifications
$this->db->select('COUNT(*) AS unread_count');
$this->db->from('notifications');
$this->db->where('receiver_id', $user_id);
$this->db->where('sender_id !=', $user_id);
$this->db->where('read_status', 0);
$recent_activity_count_query = $this->db->get();

$recent_activity_count = $recent_activity_count_query->row()->unread_count;

$query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE `read_status` = 0 AND `recipient_type` = 'admin' AND `receiver_id` ='$user_id'");
$unread_message_count = $query->num_rows();

?>
<?php
$CI =& get_instance();
$segment = $CI->uri->segment(1); // Get the first segment of the URL

switch ($segment) {
    case '':
        $active = 'home';
        break;
    case 'clients':
        $active = 'clients';
        break;
    case 'plans':
        $active = 'plans';
        break;
    case 'schedule':
        $active = 'schedule';
        break;
    case 'my-company':
        $active = 'company';
        break;
    case 'templates':
        $active = 'library';
        break;
    case 'affiliates':
        $active = 'affiliate';
        break;
    case 'furnisher':
        $active = 'furnisher';
        break;
    default:
        $active = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head id="sqhead">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>CRX Credit Repair</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/fullcalendar/fullcalendar.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/summernote/dist/summernote-bs4.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo_3/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      background-color: #f5f8fa;
    }
.fc-scroller.fc-day-grid-container{
    height:unset!important;
}
    .chrightboxinner-img i {
      font-size: 39px;
      color: #231f20;
    }
.recent .dropdown-menu .dropdown-item:hover {
    color: #000!important;
}

.tox .tox-promotion{
    display:none!important;
}
    div#order-listing_filter {
      display: none;
    }
.tox-silver-sink{
      display: none;
}
    div#order-listing_length {
      display: none;
    }

    table#order-listing a {

      color: #3972FC;
    }

    .loading {
      padding-top: 20%;
      padding-left: 50%;
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      opacity: 0.9;
      background-color: rgba(7, 7, 7, 0.5);
    }

    div#DataTables_Table_0_filter {
      float: right;
    }

    @media screen and (max-width: 768px) {
      .horizontal-menu .top-navbar .navbar-brand-wrapper .navbar-brand img {

        height: 55px;
        min-width: 110px;
      }
    }

    .tox.tox-tinymce {
      width: 100% !important;
      height: 500px !important;
    }

    .custom-search-input {
      border-radius: 20px;
      padding: 10px 40px 10px 20px;
      font-size: 14px;
      position: relative;
    }

    .custom-search-input:focus {
      box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.25);
      border-color: #007bff;
    }

    .input-group-text.search-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      border: none;
      background: transparent;
      color: #888;
      font-size: 18px;
      cursor: pointer;
    }

    .client-list-dropdown {
      position: absolute;
      background-color: #fff;

      border-radius: 4px;

      width: 250px;
      max-height: 200px;
      overflow-y: auto;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      margin-top: 5px;
    }

    .client-list-dropdown ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .client-list-dropdown li.client-item {
      padding: 10px 20px;
      cursor: pointer;
      border-bottom: 1px solid #f1f1f1;
    }

    .client-list-dropdown li.client-item:last-child {
      border-bottom: none;
    }

    .client-list-dropdown li.client-item:hover {
      background-color: #f8f9fa;
    }

    .client-list-dropdown li.no-clients {
      padding: 10px 20px;
      color: #999;
      text-align: center;
    }


    .swal2-icon.swal2-success.swal2-icon-show {
      margin-top: 25px !important;
    }

    .swal2-icon.swal2-warning.swal2-icon-show {
      margin-top: 25px !important;
    }

    .swal2-icon.swal2-info.swal2-icon-show {
      margin-top: 25px !important;
    }

    .swal2-icon.swal2-error.swal2-icon-show {
      margin-top: 25px !important;
    }

    select.form-control,
    select.asColorPicker-input,
    .dataTables_wrapper select,
    .jsgrid .jsgrid-table .jsgrid-filter-row select,
    .select2-container--default select.select2-selection--single,
    .select2-container--default .select2-selection--single select.select2-search__field,
    select.typeahead,
    select.tt-query,
    select.tt-hint {

      outline: 1px solid #d0d0d0 !important;
      color: #495057 !important;
    }

    /* Loader CSS s*/
    #loader {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }

    .spinner {
      border: 16px solid #f3f3f3;
      border-top: 16px solid #3498db;
      border-radius: 50%;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }


    .horizontal-menu .top-navbar .navbar-brand-wrapper .navbar-brand img {

      height: 55px !important;

    }

    span.count-symbol.notification-count {
      position: absolute !important;
      top: -5px !important;
      right: -5px !important;
      background-color: red !important;
      color: white !important;
      border-radius: 50% !important;
      padding: 3px 6px !important;
      font-size: 12px !important;
      font-weight: 600 !important;

      width: 24px !important;
      height: 27px !important;
    }

    .toast-dark-info {
      background-color: #1c2331 !important;
      color: white !important;
      width: 350px !important;
    }

    .toast-dark-info .toast-message {
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
    }
#client_lists{
     margin-top: 40px;
}
    .table th,
    .jsgrid .jsgrid-table th,
    .table td,
    .jsgrid .jsgrid-table td {

      border-top: 1px solid rgba(0, 0, 0, 0.12) !important;
    }

    #onboarding_date {
      color: rgb(136, 136, 136);
      font-size: 13px;
      font-style: italic;
    }

    #onboarding_stage_login {
      font-style: italic;
    }

    #onboarding_stage_agreement {
      text-decoration: underline;
      font-style: italic;
      text-decoration-color: #3972fc;
    }

    #range_chart {
      margin-top: 30px;
    }

    .highcharts-credits {
      display: none;
    }


    .container-scroller .content-wrapper {
      max-width: 100% !important;
    }


    .progress-container {
      display: flex;

      justify-content: space-between;
      margin: 20px auto;
      max-width: 800px;
      padding: 0 10px;
    }

    .progress-step {
      text-align: center;
      position: relative;
      flex: 1;
    }

    .progress-step .circle {
      width: 40px;
      height: 40px;
      background: lightgray;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      font-size: 18px;
      font-weight: bold;
      color: #333;
      position: relative;
      z-index: 2;
    }

    .progress-step.completed .circle {

      background: rgb(129, 205, 243);
      color: white;
    }

    .progress-step .text {
      margin-top: 10px;
      font-size: 14px;
      color: #666;
    }

    .progress-step.completed .text {
      font-family: Arial, Helvetica, sans-serif;

      color: rgb(129, 205, 243);
    }

    .progress-line {
      position: absolute;
      height: 3px;
      background: lightgray;
      top: 20px;
      left: 50%;
      right: -50%;
      z-index: 1;
    }

    .progress-step.completed.progress-step .progress-line {

      background: rgb(129, 205, 243);
    }

    .progress-arrow {
      position: absolute;
      top: 26%;
      right: -10px;
      transform: translateY(-50%);
      width: 0;
      height: 0;
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
      border-left: 10px solid rgb(129, 205, 243);
      z-index: 3;
    }

    .progress-step:not(:last-child) .progress-arrow {
      display: block;
    }

    .progress-step:not(.completed) .progress-arrow {
      border-left-color: lightgray;
    }

    .card-group {
      margin-top: 20px;
    }

    .card-body {
      padding: 20px;
    }

    .navigation-buttons {
      background-color: #f9f9f9;
      border: 1px solid #e0e0e0;
      padding: 10px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 500;
    }

    .navigation-buttons i {
      font-size: 16px;
    }

    .navigation-buttons:hover {
      background-color: #e9f5e9;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
    }
  </style>
     <style>
     .navbar .badge {
  font-size: 12px;
  padding: 4px 6px;
}

.navbar .dropdown-menu {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

  .modern-nav {
   background: linear-gradient(to right, #004e92, #004e92, #3570FE);
    padding: 0.5rem 1rem;
  }
.input-group-append .input-group-text, .input-group-prepend .input-group-text
 {    padding: 0.75rem 0.90rem!important;
}
  .modern-nav .nav-link {
    color: #ffffff;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.3);
    margin: 0 5px;
    border-radius: 8px 8px 0 0;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
  }

  .modern-nav .nav-link:hover,
  .modern-nav .nav-link.active {
    background-color: #ffffff;
    color: #004e92;
    font-weight: 400;
  }

  .modern-nav .mdi {
    margin-right: 5px;
  }

  @media (max-width: 768px) {
    .modern-nav .nav-link {
      font-size: 0.9rem;
      padding: 0.4rem 0.6rem;
    }
  }
  
  
.step-navigation {
  background: #f9f9f9;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  padding: 10px 15px;
}

.step-link {
  padding: 8px 16px;
  margin: 4px;
  background: #3570FE;
  color: white;
  border-radius: 25px;
  font-weight: 600;
  font-size: 14px;
  text-decoration: none;
  transition: 0.2s ease-in-out;
  display: flex;
  align-items: center;
  gap: 6px;
}

.step-link:hover {
  background: #004e92;
  color: white;
}

.step-link.active {
  background: #004e92;
}

.step-num {
  background-color: white;
  color: #3570FE;
  font-size: 12px;
  font-weight: bold;
  width: 22px;
  height: 22px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.title-activity:hover {
    color: #000!important;
    }
@media screen and (min-width: 320px) and (max-width: 992px) {
  .modern-nav{
    display: none;
  }
  .navbar-nav{
      display:ruby;
  }
  ul li, ol li, dl li {
    margin-bottom: 5px;
}
.card .card-body {
    padding: 10px!important;
}
.btn{
padding: 10px!important;
}
.navbar-toggler {
    margin-left: 15px;
}
}

</style>

</head>

<body>

  <div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
  </div>

  <div class="container-scroller">

    <div class="horizontal-menu">


     <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #004e92, #3570FE); padding: 0.7rem 1rem;">
  <div class="container-fluid">
    <!-- Logo -->
<a class="navbar-brand d-flex align-items-center" href="<?php echo base_url(); ?>">
<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" class="img-fluid" style="max-height: 50px; opacity: 1; filter: none;">
</a>



    <!-- Main nav content -->

      <ul class="navbar-nav ml-auto align-items-center">

        <!-- Notification Bell -->
        <li class="nav-item dropdown recent">
          <a class="nav-link position-relative" href="#" id="notificationDropdown" data-toggle="dropdown">
            <i class="mdi mdi-bell-outline text-white" style="font-size: 22px;"></i>
            <?php if (!empty($recent_activity_count)) : ?>
              <span class="badge badge-pill badge-danger position-absolute" style="top: 0; right: 0;"><?php echo $recent_activity_count; ?></span>
            <?php endif; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right p-0 shadow rounded-lg" style="min-width: 300px; max-height: 300px; overflow-y: auto;">
            <h6 class="dropdown-header">Recent Login Activity</h6>
            <div class="dropdown-divider"></div>
            <?php if (!empty($recent_activity)) : ?>
              <?php foreach ($recent_activity as $activity) :
                $user = $this->db->get_where('sq_users', ['sq_u_id' => $activity->sender_id])->row();
                if ($user) :
                  $img = !empty($user->sq_u_profile_picture) ? $user->sq_u_profile_picture : base_url('assets/img/user.jpg');
              ?>
                <a class="dropdown-item d-flex align-items-center">
                  <img src="<?php echo $img; ?>" alt="img" class="rounded-circle mr-2" width="35">
                  <div>
                    <strong class="title-activity"><?php echo $user->sq_u_first_name . ' ' . $user->sq_u_last_name; ?></strong><br>
                    <small class="text-muted"><?php echo substr($activity->msg, 0, 50); ?></small><br>
                    <small class="text-muted"><?php echo $activity->created_at; ?></small>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
              <?php endif; endforeach; ?>
            <?php else : ?>
              <p class="text-center p-2">No recent activity</p>
            <?php endif; ?>
            <a class="dropdown-item text-center text-primary" href="<?php echo base_url('allactivity'); ?>">See all activities</a>
          </div>
        </li>

        <!-- Messages -->
        <li class="nav-item">
          <a class="nav-link position-relative" href="<?php echo base_url(); ?>secure-messages" id="messageDropdown">
            <i class="mdi mdi-comment-outline text-white" style="font-size: 22px;"></i>
            <?php if ($unread_message_count > 0) : ?>
              <span class="badge badge-pill badge-danger position-absolute" style="top: 0; right: 0;"><?php echo $unread_message_count; ?></span>
            <?php endif; ?>
          </a>
        </li>

        <!-- Search -->
  <li class="nav-item d-none d-lg-flex ml-3" style="position: relative;">
  <div class="input-group mb-3 pt-3">
    <input type="text" id="navbar-search-input" class="form-control rounded-left" placeholder="Search..." style="border: none; padding: 0.5rem;">
    <div class="input-group-append">
      <span class="input-group-text bg-white rounded-right">
        <i class="mdi mdi-magnify text-primary"></i>
      </span>
    </div>
  </div>

  <div id="client-lists" style="display: none; max-height: 300px; overflow-y: auto; position: absolute; background: white; width: 100%; border: 1px solid #ddd; z-index: 1000;margin-top:40px;">
    <?php foreach ($client_data as $list): ?>
      <a href="<?= base_url('dashboard/' . get_encoded_id($list->sq_client_id)); ?>" 
         class="text-decoration-none text-dark d-flex justify-content-between client-item px-2 py-1">
        <span><?= $list->sq_first_name . ' ' . $list->sq_last_name . ' (' . $list->sq_status . ')' ?></span>
      </a>
    <?php endforeach; ?>
  </div>

  <div id="no-data" style="display:none; position: absolute; top: 80%; left: 0; width: 100%; background: white; border: 1px solid #ddd; padding: 8px; color: #999; font-style: italic; z-index: 1000;">
    No data found
  </div>
</li>



        <!-- Logout -->
        <li class="nav-item ml-3">
          <a class="nav-link text-white" href="javascript:void(0);" onclick="confirmLogout()">
           <i class="mdi mdi-power" style="font-size: 20px;"></i> 
          </a>
        </li>

      </ul>
     <!-- Toggler -->
    <button class="navbar-toggler" type="button" onclick="arrowfunc()";>
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>


<nav class="modern-nav d-lg-block">
  <div class="container">
    <ul class="nav justify-content-center">
      <?php if (check_permisions("home", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'home' ? 'active' : '' ?>" href="<?php echo base_url(); ?>">
          
            <i class="mdi mdi-home"></i> Home
          </a>
        </li>
      <?php endif; ?>
      <?php if (check_permisions("client", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'clients' ? 'active' : '' ?>" href="<?php echo base_url(); ?>clients">
            <i class="mdi mdi-account-multiple"></i> Clients
          </a>
        </li>
      <?php endif; ?>
      <?php if ($user_type != 'subscriber' && check_permisions("client", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'plans' ? 'active' : '' ?>" href="<?php echo base_url(); ?>plans">
            <i class="mdi mdi-cash-multiple"></i> Plans
          </a>
        </li>
      <?php endif; ?>
      <?php if (check_permisions("schedule", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'schedule' ? 'active' : '' ?>" href="<?php echo base_url(); ?>schedule">
            <i class="mdi mdi-calendar-clock"></i> Schedule
          </a>
        </li>
      <?php endif; ?>
      <?php if (check_permisions("company", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'company' ? 'active' : '' ?>" href="<?php echo base_url(); ?>my-company">
            <i class="mdi mdi-home-map-marker"></i> My Company
          </a>
        </li>
      <?php endif; ?>
      <?php if (check_permisions("library", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'library' ? 'active' : '' ?>" href="<?php echo base_url(); ?>templates">
            <i class="mdi mdi-library"></i> Letter Library
          </a>
        </li>
      <?php endif; ?>
      <?php if (check_permisions("affiliate", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'affiliate' ? 'active' : '' ?>" href="<?php echo base_url(); ?>affiliates">
            <i class="mdi mdi-webpack"></i> Affiliate
          </a>
        </li>
      <?php endif; ?>
      <?php if (check_permisions("creditor", "view")) : ?>
        <li class="nav-item">
          <a class="nav-link <?= $active == 'furnisher' ? 'active' : '' ?>" href="<?php echo base_url(); ?>furnisher">
            <i class="mdi mdi-file-document-box"></i> Creditor Furnisher
          </a>
        </li>
      <?php endif; ?>

    </ul>
  </div>
</nav>

    </div>
    
    
<script>
  const searchInput = document.getElementById('navbar-search-input');
  const clientList = document.getElementById('client-lists');
  const noData = document.getElementById('no-data');

  searchInput.addEventListener('input', function() {
    const filter = this.value.toLowerCase().trim();

    if (filter === '') {
      clientList.style.display = 'none';
      noData.style.display = 'none';
      return;
    }

    // Convert HTMLCollection to array for sorting
    const clients = Array.from(clientList.getElementsByClassName('client-item'));

    // Filter matching clients
    const matched = [];
    const unmatched = [];

    clients.forEach(client => {
      const text = client.textContent.toLowerCase();
      if (text.includes(filter)) {
        matched.push(client);
      } else {
        unmatched.push(client);
      }
    });

    // If no matches
    if (matched.length === 0) {
      clientList.style.display = 'none';
      noData.style.display = 'block';
      return;
    }

    // Show matched items, hide unmatched
    matched.forEach(client => {
      client.style.display = 'flex';
    });
    unmatched.forEach(client => {
      client.style.display = 'none';
    });

    // Clear existing children and append matched first to the container
    clientList.innerHTML = '';
    matched.forEach(client => clientList.appendChild(client));
    unmatched.forEach(client => clientList.appendChild(client));

    clientList.style.display = 'block';
    noData.style.display = 'none';
  });

  // Hide on outside click
  document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('navbar-search-input');
    const clientList = document.getElementById('client-lists');
    const noData = document.getElementById('no-data');
    if (!searchInput.contains(e.target) && !clientList.contains(e.target) && !noData.contains(e.target)) {
      clientList.style.display = 'none';
      noData.style.display = 'none';
    }
  });
function arrowfunc(){
    $(".modern-nav").slideToggle();
}

</script>
