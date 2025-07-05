<!DOCTYPE html>
<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Credit Repair Xperts</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->

  <!-- Layout styles -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo_3/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png" />
  <style>
    .auth form .form-group {
      margin-bottom: 1.0rem !important;
    }

    @media only screen and (max-width: 768px) {
      .login-half-bg {
        display: none !important;
      }
    }

    /* Loader CSS s*/
    #loader {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 28%;
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

    /* Loader CSS e*/
  </style>
</head>

<body>

  <div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 40px;" alt="Loading..." class="loader-image">
  </div>

  <div id="msgAppend11task"></div>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <a href="<?php echo base_url(); ?>">
                <div class="brand-logo">
                  <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo">
                </div>
              </a>
              <form class="pt-3">
                <div class="form-group">
                  <h4>Forgot Password</h4>
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control form-control-lg border-left-0" id="email" name="email" placeholder="Email">
                  </div>
                </div>
                <div class="my-3">
                  <a class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" onclick="resetPassword();">RESET</a>
                </div>
                <div class="text-center mt-4 font-weight-light"> You have account? <a href="<?php echo base_url(); ?>" class="text-primary">Login</a>
                </div>
              </form>
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
  <script src="<?php echo base_url(); ?>assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?php echo base_url(); ?>assets/vendors/sweetalert/sweetalert.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/jquery.avgrund/jquery.avgrund.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>assets/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/misc.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/todolist.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript">
    function resetPassword() {

      var email = $('#email').val();

      if (email != '') {
        $('#loader').show();
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Home/reset_password"; ?>',
          data: {
            'email': email
          },
          success: function(response) {
            //var data = JSON.parse(response);

            if ($.trim(response) == 1) {
              $('#loader').hide();

              $('#email').val('');

              Swal.fire({
                title: 'Forgot Password',
                text: 'Email sent successfully',
                icon: 'success',
                confirmButtonText: 'Close'
              });

            } else {
              $('#loader').hide();

              Swal.fire({
                title: 'Email Error!',
                text: 'This email is not associated with any account!',
                icon: 'error',
                confirmButtonText: 'Close'
              });
            }

          }
        });
      } else {
        $('#email').focus();
      }
    }

  </script>
  <!-- endinject -->
</body>

</html>