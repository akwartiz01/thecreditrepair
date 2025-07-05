<?php
$this->load->helper('cookie');

?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="aTZUxZSMmgRGSYwuwWYfn6ZnfGgZbSQRyESdRcx7">
<!-- Add this in the <head> section of your HTML -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <meta name="keyword" content="">
  <meta name="description" content="">

  <title> Login - CRX Credit Repair</title>

  <!-- Favicon icon -->
  <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/css/style.css" id="main-style-link">

  <style>
    .auth-navbar-brand {
      height: 45px !important;
    }

.auth-wrapper {
    min-height: unset!important;
}
    .auth-wrapper .navbar .navbar-brand img {
      width: unset !important;
    }

    #top-bar p {
      margin-top: 0px !important;
      margin-bottom: 0px !important;
      color: white !important;
      font-size: 14px !important;
      font-family: "Jost", sans-serif !important;
    }

    ul .nav-item .header-nav {
      font-family: "Jost", sans-serif !important;
      font-size: 14px !important;
      color: #002332 !important;
      font-weight: bold !important;
    }

    .btn-primary#sign_up_ {
      color: white !important;
      background-color: #5360c6 !important;
      border-color: #5360c6 !important;
    }

    .btn-primary#sign_up_:hover {
      color: black !important;
      background-color: #ffffff !important;
      border-color: #5360c6 !important;
    }

    #submit {
      color: white !important;
      background-color: #5360c6 !important;
      border-color: #5360c6 !important;
    }

    #submit:hover {
      color: black !important;
      background-color: #ffffff !important;
      border-color: #5360c6 !important;
    }

    #forgot-password:hover {
      text-decoration: underline !important;
    }

    .register-btn {
      color: #5360c6 !important;
      font-weight: bold !important;
    }

    .register-btn:hover {
      text-decoration: underline !important;
    }
  </style>

</head>

<body class="theme-6">

  <div class="announcement bg-dark text-center p-2" id="top-bar">
    <p></p>
    <p>CRX Credit Repair</p>
    <p></p>
  </div>

  <div class="auth-wrapper auth-v3">

    <div class="auth-content">

      <nav class="navbar navbar-expand-md navbar-light default">
        <div class="container-fluid pe-2">
          <!-- Logo -->
          <a class="navbar-brand" href="<?php echo base_url(); ?>">
            <img id="blah" alt="your image" src="<?php echo base_url(); ?>assets/images/logo.png" alt="CRX Credit Repair" class="navbar-brand-img auth-navbar-brand">
          </a>

          <!-- Navbar Toggler for Mobile -->
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
          <!-- Navbar Links -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">

              <li class="nav-item">
                <a class="nav-link header-nav" href="<?php echo base_url(); ?>">Home</a>
              </li>
              <!--<li class="nav-item" style="margin-left: 20px !important;">-->
              <!--  <a class="nav-link header-nav" href="<?php echo base_url('subscription-plans'); ?>">Plans</a>-->
              <!--</li>-->
              <li class="nav-item" style="margin-left: 20px !important;">
                <a class="nav-link header-nav" href="<?php echo base_url(); ?>#faq">FAQS</a>
              </li>
              <!--<li class="nav-item" style="margin-left: 20px !important;">-->
              <!--  <a href="<?php echo base_url('subscription-plans'); ?>" class="btn btn-primary" id="sign_up_"><span class="hide-mob me-2">Register</span></a>-->
              <!--</li>-->
            </ul>

          </div>
        </div>
      </nav>


      <div class="card mt-4">
        <div class="row align-items-center text-start">
          <div class="col-xl-6 offset-md-3">
            <div class="card-body w-100">
              <div class="d-flex">
                <h2 class="mb-3 f-w-600">Administrator Login</h2>
              </div>
              <form id="loginForm" method="POST" action="<?php echo base_url('sign-in'); ?>">
                <div class="form-group mb-3">
                  <label class="form-label d-flex">Username</label>
                  <input id="email" type="text" class="form-control" name="email" placeholder="Username">
                  <small class="text-danger font-weight-bold" id="emailError"></small>
                </div>

              <div class="form-group mb-3 position-relative">
  <label class="form-label d-flex">Password</label>
  
  <div class="input-group">
    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
    <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1" style="border:1px solid #ced4da">
      <i class="fa fa-eye" id="eyeIcon" style="font-size:14px"></i>
    </button>
  </div>
  
  <small class="text-danger font-weight-bold" id="passwordError"></small>
  
  <div class="mb-2 mt-2 d-flex">
    <a href="<?php echo base_url('recover-password/admin'); ?>" class="small text-muted text-underline--dashed border-primar" style="font-size: 13px !important; font-weight:bold !important; color:#5360c6!important;">Forgot Your Password?</a>
  </div>
</div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-block mt-2" id="submit">Login</button>
                </div>

                <div id="redirectMessage" class="text-center mt-3 text-success font-weight-bold" style="display: none;"></div>

                <div id="loader" class="text-center mt-3" style="display: none;">
                  <span class="spinner-border text-primary"></span>
                  <!-- <p class="mt-2 text-primary">Redirecting in <span id="countdown">5</span> seconds...</p> -->
                  <p class="mt-2 text-primary">Redirecting</p>
                </div>
              </form>


            </div>

          </div>

        </div>
      </div>

      <footer class="footer mt-auto py-4 bg-light shadow-sm border-top">
  <div class="container-fluid text-center">
    <span class="text-muted">
      &copy; <?php echo date('Y'); ?> 
      <a href="<?php echo base_url(); ?>" class="text-decoration-none fw-semibold text-dark" target="_blank">
        <b>CRX Credit Repair</b>
      </a>. All rights reserved.
    </span>
  </div>
</footer>
    </div>
  </div>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
 <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Real-time validation
      $('#email, #password').on('keyup', function() {
        validateForm();
      });

      function validateForm() {
        let email = $('#email').val().trim();
        let password = $('#password').val().trim();
        let isValid = true;

       if (email === '') {
            $('#emailError').text('Email is required').show();
            $('#email').css('border-color', 'red').focus();
            isValid = false;
            return;
          } else if (!isValidEmail(email)) {
            $('#emailError').text('Invalid email format').show();
            $('#email').css('border-color', 'red').focus();
            isValid = false;
            return;
          } else {
            $('#emailError').hide();
            $('#email').css('border-color', '');
          }

        if (password === '') {
          $('#passwordError').text('Password is required').show();
           $('#password').css('border-color', 'red').focus();
          isValid = false;
        } else {
          $('#passwordError').hide();
          $('#password').css('border-color', '');
        }

        return isValid;
      }
function isValidEmail(email) {
  // Basic email regex pattern
  let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return pattern.test(email);
}
      $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        if (!validateForm()) return;

        let email = $('#email').val();
        let password = $('#password').val();
        $('#submit').prop('disabled', true);
        $('#loader').show();

        $.ajax({
          type: "POST",
          url: "<?php echo base_url('sign-in'); ?>",
          data: {
            email: email,
            password: password
          },
          dataType: "json",
          success: function(response) {
            if (response.status === 'error') {
              $('#emailError').text(response.emailError).show();
              $('#passwordError').text(response.passwordError).show();
              $('#email, #password').css('border-color', 'red');
              $('#loader').hide();
              $('#submit').prop('disabled', false);
            } else {
              $('#redirectMessage').text('Login successful! Redirecting...').show();
              window.location.href = response.redirect_url;
              // let seconds = 5;

              // let countdown = setInterval(function() {
              //   $('#countdown').text(seconds);
              //   seconds--;
              //   if (seconds < 0) {
              //     clearInterval(countdown);
              //     window.location.href = response.redirect_url;
              //   }
              // }, 1000);
            }
          },
          error: function() {
            $('#emailError').text('Server error, please try again.').show();
            $('#passwordError').hide();
            $('#submit').prop('disabled', false);
            $('#loader').hide();
          }
        });
      });
    });
  </script>
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    
    // Toggle eye / eye-slash icon
    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
  });
</script>
</body>