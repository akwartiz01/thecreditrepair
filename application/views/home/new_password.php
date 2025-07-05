<!DOCTYPE html>
<html lang="en">
  
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Credit Repair Xperts</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
   
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/demo_3/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png" />
	<style>
	
    .auth form .form-group {
        margin-bottom: 1.0rem !important;
    }

    @media only screen and (max-width: 768px) {
      .login-half-bg{
        display: none !important;
      }
    }
 </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
          <div class="row flex-grow">
            <div class="col-lg-6 d-flex justify-content-center">
              <div class="auth-form-transparent text-left p-3">
                <a href="<?php echo base_url();?>"><div class="brand-logo">
                  <img src="<?php echo base_url();?>assets/images/logo.png" alt="logo">
                </div> 
                </a>
                <?php 
                if(!empty($msg2) && $status2 == 'true'){ ?>
                 <h4 style="color: green;"><?php echo $msg2;?></h4>
                <?php  } ?>
                <?php 
                if(!empty($msg) && $status == 'false'){ ?>
                 <h4 style="color: red;"><?php echo $msg;?></h4>
                <?php  } ?>
             <form class="pt-3" id="resetPasswordForm">
  <input type="hidden" name="UserId" value="<?php echo $id;?>">
  <input type="hidden" name="type" value="<?php echo $type;?>">

  <div class="form-group">
    <label>Password</label>
    <div class="input-group">
      <div class="input-group-prepend bg-transparent">
        <span class="input-group-text bg-transparent border-right-0">
          <i class="mdi mdi-lock-outline text-primary"></i>
        </span>
      </div>
      <input type="password" class="form-control form-control-lg border-left-0" name="new_password" placeholder="Password">
      <div class="form-error" id="new_password_error"></div>
    </div>
  </div>

  <div class="form-group">
    <label>Confirm Password</label>
    <div class="input-group">
      <div class="input-group-prepend bg-transparent">
        <span class="input-group-text bg-transparent border-right-0">
          <i class="mdi mdi-lock-outline text-primary"></i>
        </span>
      </div>
      <input type="password" class="form-control form-control-lg border-left-0" name="confirm_password" placeholder="Confirm Password">
      <div class="form-error" id="confirm_password_error"></div>
    </div>
  </div>

  <div class="my-3">
    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">RESET</button>
<?php
switch ($type) {
    case "client":
        $login_url = base_url() . "client-login";
        break;
    case "affiliate":
        $login_url = base_url() . "affiliate-login";
        break;
    case "subscription":
    $login_url = base_url() . "subscriber/login";
    break;
    default:
        $login_url = base_url();
        break;
}
?>
<div class="text-center mt-4 font-weight-light">
    You have account? <a href="<?= $login_url ?>" class="text-primary">Login</a>
</div>

  </div>
</form>

<div id="reset-response" class="mt-2 text-center"></div>

              </div>
            </div>
            <div class="col-lg-6 login-half-bg d-flex flex-row">
              <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; <?php echo date("Y"); ?> All rights reserved.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo base_url();?>assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo base_url();?>assets/js/off-canvas.js"></script>
    <script src="<?php echo base_url();?>assets/js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url();?>assets/js/misc.js"></script>
    <script src="<?php echo base_url();?>assets/js/settings.js"></script>
    <script src="<?php echo base_url();?>assets/js/todolist.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#resetPasswordForm').submit(function(e) {
    e.preventDefault(); // prevent normal form submission

    // Clear previous error messages
    $('#new_password_error').text('');
    $('#confirm_password_error').text('');
    $('#reset-response').text('').removeClass('text-danger text-success');

    // Serialize form data
    var formData = $(this).serialize();

    $.ajax({
      url: "<?php echo base_url('resetPassword'); ?>",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function(response) {
        if (response.status) {
          $('#reset-response').addClass('text-success').text(response.message);
          $('#resetPasswordForm')[0].reset(); // clear form
        } else {
          // show errors if any
          if (response.messages.new_password) {
            $('#new_password_error').text(response.messages.new_password).addClass('text-danger');
          }
          if (response.messages.confirm_password) {
            $('#confirm_password_error').text(response.messages.confirm_password).addClass('text-danger');
          }
          if (response.message) {
            $('#reset-response').addClass('text-danger').text(response.message);
          }
        }
      },
      error: function() {
        $('#reset-response').addClass('text-danger').text('An error occurred while processing your request.');
      }
    });
  });
</script>

    <!-- endinject -->
  </body>

</html>