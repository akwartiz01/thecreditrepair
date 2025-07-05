<?php
$this->load->helper('cookie');
$link = '';

switch ($type) {
    case 'admin':
        $link = base_url('sign-in');
        break;
    case 'client':
        $link = base_url('client-login');
        break;
    case 'subscription':
        $link = base_url('subscriber/login');
        break;
     case 'affiliate':
    $link = base_url('affiliate-login');
    break;
    default:
        $link = base_url('sign-in'); // fallback
        break;
}
?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="aTZUxZSMmgRGSYwuwWYfn6ZnfGgZbSQRyESdRcx7">

    <meta name="keyword" content="">
    <meta name="description" content="">

    <title> Forgot Password - CRX Credit Repair</title>

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/css/style.css" id="main-style-link">

    <style>
        .auth-navbar-brand {
            height: 45px !important;
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

        .btn-primary#login_ {
            color: white !important;
            background-color: #162CCA !important;
        }

        .btn-primary#login_:hover {
            color: black !important;
            background-color: #ffffff !important;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(0);
            }
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
                            <li class="nav-item" style="margin-left: 20px !important;">
                                <a class="nav-link header-nav" href="<?php echo base_url('subscription-plans'); ?>">Plans</a>
                            </li>
                            <li class="nav-item" style="margin-left: 20px !important;">
                                <a class="nav-link header-nav" href="<?php echo base_url(); ?>#faq">FAQS</a>
                            </li>

                            <li class="nav-item" style="margin-left: 20px !important;">
                                <a href="<?php echo base_url('sign-in'); ?>" class="btn btn-primary" id="login_"><span class="hide-mob me-2">Login</span></a>
                            </li>

                            <li class="nav-item" style="margin-left: 20px !important;">
                                <a href="<?php echo base_url('subscription-plans'); ?>" class="btn btn-primary" id="sign_up_"><span class="hide-mob me-2">Register</span></a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>


            <div class="card">
                <div class="row align-items-center text-start">
          <div class="col-xl-6 offset-md-3">
                        <div class="card-body w-100">
                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600">Forgot Password</h2>
                            </div>
                            <form id="forgot_password" class="needs-validation" novalidate>
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                    <div class="text-danger email_error"></div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-submit mt-2" disabled>Send Password Reset Link</button>
                                </div>

                                <p class="my-4 text-center">Back to
                                
                                    <a href="<?= $link; ?>" class="text-primary">Login</a>
                                </p>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function() {
            const $btn = $('.btn-submit');

            $('input[name="email"]').on('keyup', function() {
                $('.email_error').text('');
                $btn.prop('disabled', $(this).val().trim() === '');
            });

            $('#forgot_password').on('submit', function(e) {
                e.preventDefault();
                $btn.prop('disabled', true);

                let countdown = 5;

                Swal.fire({
                    title: 'Sending Reset Email...',
                    html: `<p>Please wait <b id="countdown">${countdown}</b> seconds while we send the reset link to your email.</p>`,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        const content = Swal.getHtmlContainer();
                        const countdownElem = content.querySelector('#countdown');
                        const interval = setInterval(() => {
                            countdown--;
                            countdownElem.textContent = countdown;
                            if (countdown === 0) clearInterval(interval);
                        }, 1000);
                        // Add event listener for clicking outside
                        $('.swal2-container').on('click', function(event) {
                            if (!Swal.getPopup().contains(event.target)) {
                                let popup = Swal.getPopup();
                                $(popup).css('animation', 'shake 0.5s');

                                setTimeout(() => {
                                    $(popup).css('animation', '');
                                }, 500);
                            }
                        });
                    }
                });
let userType = "<?= $type ?>"; // PHP variable ko JS variable me store karo
let formData = $(this).serialize() + '&type=' + encodeURIComponent(userType);

                // $.post('<?= base_url('reset_password1') ?>', $(this).serialize(), function(res) {
                    $.post('<?= base_url('reset_password1') ?>', formData, function(res) {
                    Swal.close();

                    if (res.status) {
                        Swal.fire('Success', res.message, 'success');
                        $('#forgot_password')[0].reset();
                        $btn.prop('disabled', true);
                    } else {
                        $.each(res.messages, function(key, val) {
                            $('.' + key + '_error').text(val);
                        });
                        $btn.prop('disabled', false);
                    }
                }, 'json');
            });
        });
    </script>

</body>