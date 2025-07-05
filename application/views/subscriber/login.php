<?php

$subscription_id = $this->session->userdata('subscription_id');
$subscription_price = $this->session->userdata('subscription_price');
$first_name = $this->session->userdata('first_name');
$last_name = $this->session->userdata('last_name');
$email = $this->session->userdata('email');
?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="aTZUxZSMmgRGSYwuwWYfn6ZnfGgZbSQRyESdRcx7">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <meta name="keyword" content="">
    <meta name="description" content="">

    <title> Login &dash; CRX Credit Repair</title>

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png" type="image/x-icon" />
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/fonts/fontawesome.css">
    <!-- font css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/fonts/feather.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/fonts/material.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/custom/css/custom.css">
    <!-- vendor css -->


    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/css/style.css" id="main-style-link">

    <style>
    .auth-wrapper {
    min-height: unset!important;
}
        [dir="rtl"] .dash-sidebar {
            left: auto !important;
        }

        [dir="rtl"] .dash-header {
            left: 0;
            right: 280px;
        }

        [dir="rtl"] .dash-header:not(.transprent-bg) .header-wrapper {
            padding: 0 0 0 30px;
        }

        [dir="rtl"] .dash-header:not(.transprent-bg):not(.dash-mob-header)~.dash-container {
            margin-left: 0px !important;
        }

        [dir="rtl"] .me-auto.dash-mob-drp {
            margin-right: 10px !important;
        }

        [dir="rtl"] .me-auto {
            margin-left: 10px !important;
        }

        .auth-navbar-brand {
            height: 45px !important;
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


        /* Loader CSS e*/


        .swal2-icon.swal2-error {
            border-color: #f27474 !important;
            color: #f27474 !important;
        }

        .swal2-icon.swal2-error [class^="swal2-x-mark-line"] {
            background-color: #f27474 !important;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log('test');
            $('.tox-notifications-container').each(function() {
                $(this).addClass('d-none');
            });
        });
    </script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/css/customizer.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/custom/css/custom.css">

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
                                <a href="<?php echo base_url('subscription-plans'); ?>" class="btn btn-primary" id="sign_up_"><span class="hide-mob me-2">Register</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="card mt-4">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6 offset-md-3">
                        <div class="card-body w-100">
                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600">Subscriber Login</h2>
                            </div>
                            <form id="subscriber_login_Form" method="POST" action="" class="needs-validation" novalidate="">
                                <input type="hidden" name="_token" value="aTZUxZSMmgRGSYwuwWYfn6ZnfGgZbSQRyESdRcx7">

                                <div>
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" value="" placeholder="Email" required autofocus>
                                    </div>

                                <div class="form-group mb-3">
  <label class="form-label d-flex">Password</label>

  <div class="input-group">
    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
    <button type="button" class="btn btn-outline-secondary" id="togglePasswordSubscription" tabindex="-1" style="border:1px solid #ced4da;">
      <i class="fa-solid fa-eye" id="eyeIconSubscription" style="font-size:14px;"></i>
    </button>
  </div>

  <div class="mb-2 mt-2 d-flex">
    <a href="<?php echo base_url('recover-password/subscription'); ?>" class="small text-muted" style="font-weight: bold; color:#5360c6 !important;" id="forgot-password">
      Forgot Your Password?
    </a>
  </div>
</div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block mt-2" id="submit">Login</button>
                                    </div>

                                    <p class="my-4 text-center">Don't have an account?
                                        <a href="<?php echo base_url(); ?>subscription-plans" class="my-4 text-primary register-btn" style="color: #5360c6 !important;">Register</a>
                                    </p>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
          <footer class="footer mt-auto py-4 bg-light shadow-sm border-top">
  <div class="container-fluid text-center">
    <span class="text-dark">
      &copy; <?php echo date('Y'); ?> 
      <a href="<?php echo base_url(); ?>" class="text-decoration-none fw-semibold text-dark" target="_blank">
        <b>CRX Credit Repair</b>
      </a>. All rights reserved.
    </span>
  </div>
</footer>
        </div>
    </div>

    <div class="modal fade" id="subscription_modal_payment" tabindex="-1" role="dialog" aria-labelledby="subscription_modal_payment" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Payment</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form class="form-sample" id="addTeamMemberForm" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <input type='hidden' name="amount" id="amount" class='form-control card-amount'>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Name on Card<span class="text-danger">*</span></label>
                                <input type='text' name="ccname" id="ccname" class='form-control' size='4'>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Card Number<span class="text-danger">*</span></label>
                                <input type='text' name="ccnumber" id="ccnumber" autocomplete='off' class='form-control card-number' size='20'>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Expiration Date<span class="text-danger">*</span></label>
                                <input type='text' name="ccexp" id="ccexp" class='form-control card-expiry-month' placeholder='MMYY' size='4'>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>CVC<span class="text-danger">*</span></label>
                                <input type='text' name="cvv" id="cvv" autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4'>

                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="save_card" name="save_card" checked>
                                    <label class="form-check-label" for="save_card" style="margin-left: 0px !important;">
                                        Save Card for Auto-Renew Subscription
                                    </label>
                                </div>
                            </div>
                        </div> -->

                    </form>
                </div>

                <div class="modal-footer" style="justify-content: center;">
                    <button type="button" class="btn btn-danger" id="total_amount" onclick="pay_now();"></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    <input type="hidden" name="subscription_id" id="subscription_id" value="<?php echo $subscription_id; ?>">
    <input type="hidden" name="subscription_price" id="subscription_price" value="<?php echo $subscription_price; ?>">
    <input type="hidden" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
    <input type="hidden" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
    <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">

    <div id="loader">
        <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
    </div>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script>
        var toster_pos = 'right';
    </script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            $("#form_data").submit(function(e) {
                $("#login_button").attr("disabled", true);
                return true;
            });
        });
    </script>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#subscription_modal_payment').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $(document).ready(function() {
            $("#subscriber_login_Form").on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting the default way

                var email = $("#email").val();
                var password = $("#password").val();

                if (email === "" || password === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'All fields are required'
                    });
                    return;
                }

                $.ajax({
                    url: "<?php echo base_url('subscriber/login'); ?>",
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        submit: true // So that it follows your current signin logic
                    },
                    success: function(response) {
                        // Parse the JSON response
                        var data = JSON.parse(response);

                        if (data.status === "error") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: data.message
                            });
                        } else if (data.status === "unpaid") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: data.message,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Continue'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    let subscription_amount = $('#subscription_price').val();

                                    $('#amount').val(subscription_amount);
                                    $('#total_amount').text('Pay $' + subscription_amount + '.00');
                                    $('#subscription_modal_payment').modal('show');

                                }
                            });
                        } else if (data.status === "success") {
                            window.location.href = data.redirect_url;
                        }
                    }
                });
            });
        });

        function pay_now() {
            let ccname = $('#ccname').val();
            let ccnumber = $('#ccnumber').val();
            let ccexp = $('#ccexp').val();
            let cvv = $('#cvv').val();
            let amount = $('#amount').val();
            let first_name = $('#first_name').val();
            let last_name = $('#last_name').val();
            let email = $('#email').val();
            // let save_card = $('#save_card').is(':checked') ? '1' : '0';
            let save_card = 1;
            let subscription_id = $('#subscription_id').val();


            // Remove previous error highlights
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            let isValid = true;

            if (ccname == "") {
                $('#ccname').addClass('is-invalid');
                $('#ccname').after('<div class="invalid-feedback">Name on Card is required.</div>');
                isValid = false;
            }
            if (ccnumber == "") {
                $('#ccnumber').addClass('is-invalid');
                $('#ccnumber').after('<div class="invalid-feedback">Card Number is required.</div>');
                isValid = false;
            }
            if (ccexp == "") {
                $('#ccexp').addClass('is-invalid');
                $('#ccexp').after('<div class="invalid-feedback">Expiration Date is required.</div>');
                isValid = false;
            }
            if (cvv == "") {
                $('#cvv').addClass('is-invalid');
                $('#cvv').after('<div class="invalid-feedback">CVC is required.</div>');
                isValid = false;
            }
            if (amount == "") {
                $('#amount').addClass('is-invalid');
                $('#amount').after('<div class="invalid-feedback">Amount is required.</div>');
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    title: 'Error',
                    text: 'Please provide all mandatory fields!',
                    icon: 'error',
                    confirmButtonText: 'Retry'
                });
                return false;
            } else {
                $('#loader').show();

                // Disable closing the modal by clicking outside
                $('#subscription_modal_payment').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('pay_now'); ?>',
                    data: {
                        'ccname': ccname,
                        'ccnumber': ccnumber,
                        'ccexp': ccexp,
                        'cvv': cvv,
                        'amount': amount,
                        'first_name': first_name,
                        'last_name': last_name,
                        'email': email,
                        'save_card': save_card,
                        'subscription_id': subscription_id
                    },
                    success: function(response) {
                        $('#loader').hide();
                        var data = JSON.parse(response);
                        if (data.success) {

                            Swal.fire({
                                title: 'Success!',
                                text: 'Payment Received. You can login now.',
                                icon: 'success',
                                // showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Continue'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // setTimeout(function() {
                                    window.location.href = "<?php echo base_url('subscriber/login') ?>";
                                    // }, 1500);
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Retry'
                            })
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        Swal.fire({
                            title: 'Error',
                            text: "An error occurred while processing your request.",
                            icon: 'error',
                            confirmButtonText: 'Retry'
                        })
                    }
                });
            }
        }
    </script>
    <?php
    $payment_status = $this->session->flashdata('payment_status');
    $message = $this->session->flashdata('message');
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let status = "<?php echo $payment_status; ?>";
            let message = "<?php echo $message; ?>";
            let title = "";

            switch (status) {
                case 'success':
                    title = 'Success';
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('subscriber/login'); ?>";
                        }
                    });
                    break;
                case 'declined':
                    title = 'Payment Declined';
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: 'warning',
                        confirmButtonText: 'Retry'
                    });
                    break;
                case 'error':
                    title = 'Error';
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'Retry'
                    });
                    break;
            }
        });
    </script>
    <script>
  document.getElementById('togglePasswordSubscription').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIconSubscription');

    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';

    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
  });
</script>
</body>