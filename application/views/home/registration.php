<?php
if (empty($subscription_id && $subscription_price)) {

    redirect(base_url());
}
?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="TKf8PWrswSiVxKwdLwohiK7onJ6dkXrEYaUuEyvS">


    <title> Register &dash; Credit Repair Xperts</title>

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

        .invalid-feedback {
            font-size: 14px !important;
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

        .auth-navbar-brand {
            height: 45px !important;
        }

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

        .select2-container .select2-selection--single {

            height: 42px !important;
        }

        .select2-container--default .select2-selection--single {

            border: 1px solid #ced4da !important;

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

        #top-bar p {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            color: white !important;
            font-size: 14px !important;
            font-family: "Jost", sans-serif !important;
        }

        #loginDropdown:hover {
            color: white !important;
        }


        ul .nav-item .header-nav {
            font-family: "Jost", sans-serif !important;
            font-size: 14px !important;
            color: #002332 !important;
            font-weight: bold !important;
        }

        #loginDropdown {
            color: white !important;
            background-color: #5360c6 !important;
            border-color: #5360c6 !important;
        }

        #loginDropdown:hover {
            color: black !important;
            background-color: #ffffff !important;
            background-color: #5360c6 !important;
        }

        #create_subscription_btn {
            color: white !important;
            background-color: #5360c6 !important;
            border-color: #5360c6 !important;
        }

        #create_subscription_btn:hover {
            color: black !important;
            background-color: #ffffff !important;
            border-color: #5360c6 !important;
        }

        #forgot-password:hover {
            text-decoration: underline !important;
        }

        .login-btn {
            color: #5360c6 !important;
            font-weight: bold !important;
        }

        .login-btn:hover {
            text-decoration: underline !important;
        }
    </style>

</head>

<body class="theme-6">

    <div class="announcement bg-dark text-center p-2" id="top-bar">
        <p></p>
        <p>The Credit Repair Xperts, LLC</p>
        <p></p>
    </div>


    <div class="auth-wrapper auth-v3">

        <div class="auth-content">

            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">

                    <a class="navbar-brand" href="<?php echo base_url(); ?>">
                        <img id="blah" alt="your image" src="<?php echo base_url(); ?>assets/images/logo.png" alt="The Credit Repair Xperts" class="navbar-brand-img auth-navbar-brand">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

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


                            <li class="nav-item dropdown" style="margin-left: 20px !important;">
                                <a class="nav-link dropdown-toggle btn btn-outline-primary px-3" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Login
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                                    <li><a class="dropdown-item" href="<?php echo base_url('sign-in'); ?>">Admin || Staff Login</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('subscriber/login'); ?>">Subscriber Login</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('client-login'); ?>">Client Login</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="card">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6">
                        <input type="hidden" name="_token" value="TKf8PWrswSiVxKwdLwohiK7onJ6dkXrEYaUuEyvS">

                        <div class="card-body w-100" id="subscription-form">
                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600">Register</h2>
                            </div>
                            <div class="">

                                <div class="form-group mb-3">
                                    <label class="form-label d-flex">First Name</label>
                                    <input id="first_name" type="text" class="form-control " name="first_name" value="" required autocomplete="first_name" autofocus placeholder="Enter Your First Name">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label d-flex">Last Name</label>
                                    <input id="last_name" type="text" class="form-control " name="last_name" value="" required autocomplete="last_name" autofocus placeholder="Enter Your Last Name">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label d-flex">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" value="" required autofocus placeholder="Enter Your Email">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label d-flex">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Enter Your Password">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label d-flex">Confirm Password</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Your Password">
                                </div>

                                <div class="form-group">
                                    <label class="form-label d-flex">Country</label>
                                    <select class="form-control" id="country" name="country" style="background: white !important; border-color:#dee2e6 !important; color:#625858 !important;">
                                        <option selected value="0">Choose country</option>
                                        <option value="1">United States</option>
                                    </select>
                                </div>


                                <div class="d-grid">
                                    <button class="btn btn-primary btn-block mt-2" type="button" id="create_subscription_btn">Register</button>
                                </div>

                            </div>
                            <p class="mb-2 my-4 text-center">Already have an account? <a
                                    href="<?php echo base_url('sign-in'); ?>" class="f-w-400 text-primary login-btn">Login</a></p>
                        </div>


                        <div class="card-body w-100" id="payment-form" style="display: none;">

                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600">Payment</h2>
                            </div>
                            <div class="">
                                <form action="<?php echo base_url('submit_payment'); ?>">
                                    <input type="hidden" id="p_subscription_id" name="p_subscription_id">
                                    <input type="hidden" id="p_amount" name="p_amount">
                                    <input type="hidden" id="p_first_name" name="p_first_name">
                                    <input type="hidden" id="p_last_name" name="p_last_name">
                                    <input type="hidden" id="p_email" name="p_email">
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">First Name</label>
                                        <input id="pp_first_name" type="text" class="form-control " name="p_first_name" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Last Name</label>
                                        <input id="pp_last_name" type="text" class="form-control " name="p_last_name" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Email</label>
                                        <input id="pp_email" type="email" class="form-control" name="p_email" readonly>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-block mt-2" type="button" id="payButton"></button>
                                    </div>
                                </form>
                            </div>
                            <p class="mb-2 my-4 text-center">Already have an account? <a href="<?php echo base_url('sign-in'); ?>" class="f-w-400 text-primary">Login</a></p>
                        </div>

                    </div>
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="<?php echo base_url(); ?>Landing_page/public/assets/images/auth/img-auth-3.svg" alt="" class="img-fluid">

                        </div>
                    </div>
                </div>
            </div>
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
                    </form>
                </div>

                <div class="modal-footer" style="justify-content: center;">
                    <button type="button" class="btn btn-danger" id="total_amount" onclick="pay_now();"></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    <div id="loader">
        <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
    </div>

    <input type="hidden" name="subscription_id" id="subscription_id" value="<?php echo $subscription_id; ?>">
    <input type="hidden" name="subscription_price" id="subscription_price" value="<?php echo $subscription_price; ?>">

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Include jQuery (if not already included) -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- Include select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Maverick collectJs -->
    <script src="https://secure.maverickgateway.com/token/Collect.js" data-tokenization-key="d5Q838-adc8u9-U2c7UD-K367VB"></script>
    <script>
        $('#subscription_modal_payment').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        function validateFieldsOnKeyup() {

            $('#first_name').on('keyup', function() {
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>First Name is required.</strong></div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            $('#last_name').on('keyup', function() {
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>Last Name is required.</strong></div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            $('#email').on('keyup', function() {
                let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>Email is required.</strong></div>');
                    }
                } else if (!emailPattern.test($(this).val())) {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>Please enter a valid Email address.</strong></div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            $('#password').on('keyup', function() {
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>Password is required.</strong></div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            $('#password_confirmation').on('keyup', function() {
                let password = $('#password').val();
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>Confirm Password is required.</strong></div>');
                    }
                } else if ($(this).val() !== password) {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback"><strong>Passwords do not match.</strong></div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            $('#country').on('change', function() {
                if ($(this).val() == 0) {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $('.select2-container').after('<div class="invalid-feedback"><strong>Country is required.</strong></div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                    $('.select2-container').next('.invalid-feedback').remove();
                }
            });
        }

        validateFieldsOnKeyup();

        $('#create_subscription_btn').click(function(e) {
            e.preventDefault();

            clearFieldValidation($('#first_name'));
            clearFieldValidation($('#last_name'));
            clearFieldValidation($('#email'));
            clearFieldValidation($('#password'));
            clearFieldValidation($('#password_confirmation'));
            clearFieldValidation($('#country'));

            create_subscription();
        });

        function clearFieldValidation($field) {
            $field.removeClass('is-invalid');
            $field.next('.invalid-feedback').remove();
        }

        $(document).ready(function() {

            $('#country').select2({
                placeholder: 'Choose Team Member',
                allowClear: true,
                width: '100%'
            });


            $('.select2-selection').addClass('form-control');

        });

        function create_subscription() {
            let subscription_id = $('#subscription_id').val();
            let first_name = $('#first_name').val();
            let last_name = $('#last_name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let c_password = $('#password_confirmation').val();
            let country = $('#country').find(":selected").val();
            let subscription_amount = $('#subscription_price').val();

            $('#amount').val(subscription_amount);
            $('#total_amount').text('Pay $' + subscription_amount + '.00');

            // Validation logic
            let isValid = true;

            if (first_name == "") {
                $('#first_name').addClass('is-invalid');
                $('#first_name').after('<div class="invalid-feedback"><strong>First Name is required.</strong></div>');
                isValid = false;
            }

            if (last_name == "") {
                $('#last_name').addClass('is-invalid');
                $('#last_name').after('<div class="invalid-feedback"><strong>Last Name is required.</strong></div>');
                isValid = false;
            }

            if (email == "") {
                $('#email').addClass('is-invalid');
                $('#email').after('<div class="invalid-feedback"><strong>Email is required.</strong></div>');
                isValid = false;
            }

            if (password == "") {
                $('#password').addClass('is-invalid');
                $('#password').after('<div class="invalid-feedback"><strong>Password is required.</strong></div>');
                isValid = false;
            }

            if (c_password == "") {
                $('#password_confirmation').addClass('is-invalid');
                $('#password_confirmation').after('<div class="invalid-feedback"><strong>Confirm Password is required.</strong></div>');
                isValid = false;
            } else if (password !== c_password) {
                $('#password_confirmation').addClass('is-invalid');
                $('#password_confirmation').after('<div class="invalid-feedback"><strong>Passwords do not match.</strong></div>');
                isValid = false;
            }

            if (country == 0) {
                $('#country').addClass('is-invalid');
                $('.select2-container').after('<div class="invalid-feedback"><strong>Country is required.</strong></div>');
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    title: 'Error',
                    text: 'Please provide all mandatory fields!',
                    icon: 'error',
                    confirmButtonText: 'Retry',
                    allowOutsideClick: false,
                    didOpen: () => {
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
                return false;
            } else {
                $('#loader').show();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('create_subscription'); ?>',
                    data: {
                        'first_name': first_name,
                        'last_name': last_name,
                        'email': email,
                        'password': password,
                        'country': country,
                        'subscription_id': subscription_id,
                    },
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (data.subscribed) {
                            $('#loader').hide();
                            Swal.fire({
                                title: 'Error',
                                text: "You have already purchased a subscription.",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Continue',
                                allowOutsideClick: false,
                                didOpen: () => {
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
                            return false;
                        }

                        if (data.success) {
                            setTimeout(function() {
                                $('#loader').hide();

                                Swal.fire({
                                    title: 'Registration Done!',
                                    text: "Please complete your payment to proceed.",
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Continue',
                                    allowOutsideClick: false,
                                    didOpen: () => {
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
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // $('#subscription_modal_payment').modal('show');

                                        $('#p_subscription_id').val(subscription_id);
                                        $('#p_first_name').val(first_name);
                                        $('#pp_first_name').val(first_name);
                                        $('#p_last_name').val(last_name);
                                        $('#pp_last_name').val(last_name);
                                        $('#p_email').val(email);
                                        $('#pp_email').val(email);
                                        $('#p_amount').val(subscription_amount);
                                        // $('#p_amount').val(41);

                                        $('#payButton').text('Pay $' + subscription_amount + '.00');

                                        $('#payment-form').css('display', 'block');
                                        $('#subscription-form').css('display', 'none');

                                    }
                                });
                            }, 2000);
                        } else {
                            $('#loader').hide();
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to submit form',
                                icon: 'error',
                                confirmButtonText: 'Retry',
                                allowOutsideClick: false,
                                didOpen: () => {
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
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your request.',
                            icon: 'error',
                            confirmButtonText: 'Retry',
                            allowOutsideClick: false,
                            didOpen: () => {
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
                    }
                });
            }
        }

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
                    confirmButtonText: 'Retry',
                    allowOutsideClick: false,
                    didOpen: () => {
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
                                text: data.message,
                                icon: 'success',
                                // showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Continue',
                                allowOutsideClick: false,
                                didOpen: () => {
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
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?php echo base_url('sign-in'); ?>";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Retry',
                                allowOutsideClick: false,
                                didOpen: () => {
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
                            })
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        Swal.fire({
                            title: 'Error',
                            text: "An error occurred while processing your request.",
                            icon: 'error',
                            confirmButtonText: 'Retry',
                            allowOutsideClick: false,
                            didOpen: () => {
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
                        })
                    }
                });
            }
        }
    </script>


</body>