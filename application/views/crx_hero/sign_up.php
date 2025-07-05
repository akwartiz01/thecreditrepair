<?php
$crx_hero_states = $this->config->item('crx_hero_states');
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="aTZUxZSMmgRGSYwuwWYfn6ZnfGgZbSQRyESdRcx7">

    <meta name="keyword" content="">
    <meta name="description" content="">

    <title> Sign Up &dash; CRX Hero</title>


    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/credit_hero_logo.png" type="image/x-icon" />
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

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

        button.btn-primary {
            background-color: #162CCA !important;
        }

        body.theme-6 .form-check-input:focus,
        body.theme-6 .form-select:focus,
        body.theme-6 .form-control:focus,
        body.theme-6 .custom-select:focus,
        body.theme-6 .dataTable-selector:focus,
        body.theme-6 .dataTable-input:focus {
            border-color: #162CCA !important;
        }

        ul .nav-item .nav-link {
            color: #162CCA !important;
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

        .auth-wrapper .navbar .navbar-brand img {
            width: unset !important;
        }

        /* progressbar s*/
        .progress-box-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .progress-box {
            width: 30%;
            padding: 10px;
            text-align: center;
            background-color: #e0e0e0;
            border-radius: 5px;
            color: #333;
        }

        .progress-box.active {
            background-color: #162CCA;
            color: white;
        }

        #CrxHeroForm .form-control {
            border-radius: 5px;
            box-shadow: none;
        }

        #CrxHeroForm .btn-primary {
            background-color: #007bff;
            border: none;
        }

        #CrxHeroForm .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        #progress-box-1 {
            clip-path: polygon(0px 0px, 90% 0px, 100% 50%, 90% 100%, 0px 100%, 0% 0%);
        }

        #progress-box-2 {
            clip-path: polygon(0px 0px, 90% 0px, 100% 50%, 90% 100%, 0px 100%, 10% 50%);
        }

        #progress-box-3 {
            /* clip-path: polygon(0px 0px, 90% 0px, 100% 50%, 90% 100%, 0px 100%, 10% 50%); */
            clip-path: polygon(0px 0px, 90% 0px, 90% 50%, 90% 100%, 0px 100%, 10% 50%);
        }

        #progress-box-4 {
            clip-path: polygon(0px 0px, 90% 0px, 90% 50%, 90% 100%, 0px 100%, 10% 50%);
        }

        .progress-box {
            background-color: rgb(233, 236, 255);
        }

        /* progressbar e*/

        #success_message {
            background-color: rgb(239, 241, 255);
            padding: 15px;
        }

        .col-6.processed {
            text-align: end;
            color: rgb(22, 44, 202);
        }

        span.select2-selection.select2-selection--single {
            height: unset !important;
        }

        span.select2-selection.select2-selection--single.select2-selection--clearable.form-control {
            padding: 5px !important;
        }

        span.select2-selection.select2-selection--single.form-control {
            padding: 5px !important;
        }
    </style>

    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/assets/css/customizer.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/public/custom/css/custom.css">

</head>

<body class="theme-6">


    <div class="auth-wrapper auth-v3">
        <!-- <div class="bg-auth-side bg-primary"></div> -->

        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="<?php echo base_url('creditheroscore'); ?>">

                        <img id="blah" alt="your image" src="<?php echo base_url(); ?>assets/images/credit_hero_logo.png" alt="CRX Hero" class="navbar-brand-img auth-navbar-brand">

                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" style="flex-grow: 0;">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('creditheroscore'); ?>">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Support</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Terms</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Privacy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="card">
                <div class="row align-items-center text-start">
                    <!-- Progress Boxes -->
                    <div class="progress-box-container mt-5">
                        <div class="progress-box" id="progress-box-1">Step 1</div>
                        <div class="progress-box" id="progress-box-2">Step 2</div>
                        <div class="progress-box" id="progress-box-3">Step 3</div>
                        <!-- <div class="progress-box" id="progress-box-4">Step 4</div> -->
                    </div>

                    <div class="col-xl-7">
                        <div class="card-body w-100" style="padding-top: 20px !important;" id="crx-hero-registration-form">
                            <div class="d-flex sign-up">
                                <h2 class="mb-3 f-w-600">Sign Up</h2>
                            </div>

                            <form id="CrxHeroForm" method="POST">

                                <div id="step1" class="step">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">First Name</label>
                                                <input type="text" class="form-control" name="first_name" id="first_name" value="" placeholder="First Name" required autofocus>
                                                <span class="error" id="first_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">Last Name</label>
                                                <input type="text" class="form-control" name="last_name" id="last_name" value="" placeholder="Last Name" required autofocus>
                                                <span class="error" id="first_name_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">Address</label>
                                                <input type="text" class="form-control" name="address" id="address" value="" placeholder="Address" required autofocus>
                                                <span class="error" id="address_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">City</label>
                                                <input type="text" class="form-control" name="city" id="city" value="" placeholder="City" required autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">State</label>

                                                <select class="form-control" id="state" name="state">

                                                    <?php foreach ($crx_hero_states as $key => $value) { ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">Zip</label>
                                                <input type="text" class="form-control" name="zip" id="zip" value="" placeholder="Zip" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">Phone</label>
                                                <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="Phone" required autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid">

                                        <button type="button" class="btn btn-primary btn-block mt-2 next-step" id="submit">Click to Continue</button>
                                    </div>

                                </div>

                                <div id="step2" class="step" style="display:none;">
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Social Security Number</label>
                                        <input type="text" class="form-control" name="ssn" id="ssn" value="" placeholder="SSN" required autofocus>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Date of Birth</label>
                                        <input type="text" class="form-control" name="dob" id="dob" placeholder="Date of Birth" required autofocus>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">User Name</label>
                                        <input type="email" class="form-control" name="user_name" id="user_name" value="" placeholder="User Name" required autofocus>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Password</label>

                                        <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" required autofocus>

                                    </div>

                                    <div class="d-grid">

                                        <button type="button" class="btn btn-secondary btn-block mt-2 prev-step">Back</button>
                                        <button type="submit" class="btn btn-primary btn-block mt-2 next-step" id="submit">Click to Continue</button>
                                    </div>

                                </div>

                            </form>


                        </div>

                        <div class="card-body w-100" id="payment-form" style="display:none">
                            <div class="d-flex sign-up">
                                <h2 class="mb-3 f-w-600">Sign Up</h2>
                            </div>

                            <form action="<?php echo base_url('submit_crx_hero_payment'); ?>">
                                <div id="" class="">

                                    <input type='hidden' name="p_amount" id="p_amount">
                                    <input type='hidden' name="p_first_name" id="p_first_name">
                                    <input type='hidden' name="p_last_name" id="p_last_name">
                                    <input type='hidden' name="p_user_name" id="p_user_name">
                                    <input type="hidden" class="form-control" name="pp_zip" id="pp_zip">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">First Name</label>
                                                <input type="text" class="form-control" name="pp_first_name" id="pp_first_name" value="" disabled>
                                                <span class="error" id="first_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">Last Name</label>
                                                <input type="text" class="form-control" name="pp_last_name" id="pp_last_name" value="" disabled>
                                                <span class="error" id="first_name_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label d-flex">User Name</label>
                                                <input type="email" class="form-control" name="pp_user_name" id="pp_user_name" value="" disabled>
                                            </div>
                                        </div>
                                   
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary btn-block mt-2 next-step" id="payButton">Pay $21.30</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="card-body w-100" id="success_message" style="display:none;">
                            <div class="d-flex sign-up">
                                <h2 class="mb-3 f-w-600">Sign Up</h2>
                            </div>

                            <div id="">
                                <div class="row">
                                    <div class="col-6">
                                        <p>Equifax<sup>&reg;</sup> Credit Score</p>
                                    </div>
                                    <div class="col-6 processed">
                                        <i class="fa fa-check"></i> <span>Processed</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Experian<sup>&reg;</sup> Credit Score</p>
                                    </div>
                                    <div class="col-6 processed">
                                        <i class="fa fa-check"></i> <span>Processed</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>TransUnion<sup>&reg;</sup> Credit Score</p>
                                    </div>
                                    <div class="col-6 processed">
                                        <i class="fa fa-check"></i> <span>Processed</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Pulling Your Accounts on File</p>
                                    </div>
                                    <div class="col-6 processed">
                                        <i class="fa fa-check"></i> <span>Processed</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Credit Bureau Monitoring</p>
                                    </div>
                                    <div class="col-6 processed">
                                        <i class="fa fa-check"></i> <span>Processed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 img-card-side">
                        <div class="auth-img-content">
                            <h4>Should I expect to find errors in my credit profile?</h4>
                            <p>It's likely, according to financial experts and analysts. Your credit report can include errors and inaccuracies that can lower your credit score. As a member, you'll have access to your credit report from all 3 credit bureaus - TransUnion®, Experian®, Equifax® - so you can be sure that your credit information is correct.</p>

                            <h4>What are the benefits of my Credit Hero Score membership?</h4>
                            <p>You will have unlimited access to:</p>
                            <ul>
                                <li>24/7 Credit Monitoring</li>
                                <li>Get email alerts about changes in your credit profile</li>
                                <li>Credit Education Center access</li>
                                <li>Social Security Number Monitoring</li>
                                <li>Identity Theft Protection</li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                    <p class="mb-0"> Copyright &copy;
                        2024 The CRX Hero - All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="loader">
        <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
    </div>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script>
        var toster_pos = 'right';
    </script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 
    <!-- Include select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Maverick collectJs -->
    <script src="https://secure.maverickgateway.com/token/Collect.js" data-tokenization-key="d5Q838-adc8u9-U2c7UD-K367VB"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <script>
        $(document).ready(function() {
            const currentYear = new Date().getFullYear();
            $("#dob").datepicker({
                dateFormat: "mm/dd/yy",
                changeMonth: true,
                changeYear: true,
                yearRange: `1900:${currentYear}`,
            });
        });

        $(document).ready(function() {
            $('#state').select2({
                placeholder: 'Choose State',
                allowClear: true,
                width: '100%'
            });
            $('.select2-selection').addClass('form-control');

        });


        function validateFieldsOnKeyup() {
            $('#first_name,#last_name,#address,#city,#state,#zip,#phone,#ssn,#dob,#user_name,#password').on('keyup', function() {
                validateField($(this));
            });
        }

        function validateField($field) {
            let id = $field.attr('id');
            let value = $field.val();

            switch (id) {
                case 'first_name':
                    if (value === "") {
                        handleFieldValidation($field, "First Name is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'last_name':
                    if (value === "") {
                        handleFieldValidation($field, "Last Name is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'address':
                    if (value === "") {
                        handleFieldValidation($field, "Address is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'city':
                    if (value === "") {
                        handleFieldValidation($field, "City is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'state':
                    if (value === "") {
                        handleFieldValidation($field, "State is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'zip':
                    if (value === "") {
                        handleFieldValidation($field, "Zip is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'phone':
                    let phonePattern = /^\d{10}$/;
                    if (value === "") {
                        handleFieldValidation($field, "Phone is required.");
                    } else if (!phonePattern.test(value)) {
                        handleFieldValidation($field, "Please enter a valid 10-digit phone number.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'ssn':
                    if (value === "") {
                        handleFieldValidation($field, "Social Security Number is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;
                case 'dob':
                    if (value === "") {
                        handleFieldValidation($field, "Date of Birth is required.");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;

                case 'user_name':
                    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (value === "") {
                        handleFieldValidation($field, "User Name is required.");
                    } else if (!emailPattern.test(value)) {
                        handleFieldValidation($field, "User Name should be your email address");
                    } else {
                        clearFieldValidation($field);
                    }
                    break;

                case 'password':
                    let passwordPattern = /^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*\d).{8,}$/;
                    if (value === "") {
                        handleFieldValidation($field, "Password is required.");
                    } else if (!passwordPattern.test(value)) {
                        $('.form-password').css('margin-bottom', '45px');
                        handleFieldValidation($field, "Password must contain at least 8 characters, a number, and a special character.");

                    } else {
                        clearFieldValidation($field);
                    }
                    break;
            }
        }

        function handleFieldValidation($field, message) {
            $field.addClass('is-invalid');
            if (!$field.next('.invalid-feedback').length) {
                $field.after('<div class="invalid-feedback"><strong>' + message + '</strong></div>');
            }
        }

        function clearFieldValidation($field) {
            $field.removeClass('is-invalid');
            $field.next('.invalid-feedback').remove();
            $('.form-password').css('margin-bottom', 'revert-layer');
        }

        // Real-time field validation on keyup
        validateFieldsOnKeyup();


        $(document).ready(function() {
            let currentStep = 1;

            // Show the initial step
            showStep(currentStep);

            // Handle Next Button Click
            $('.next-step').click(function() {
                if (validateStep(currentStep)) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            // Handle Previous Button Click
            $('.prev-step').click(function() {
                currentStep--;
                showStep(currentStep);
            });

            // Handle Form Submission on Final Step
            $('#CrxHeroForm').submit(function(event) {
                event.preventDefault();

                let first_name = $('#first_name').val();
                let last_name = $('#last_name').val();
                let email = $('#user_name').val();
                let zip = $('#zip').val();

                if (validateStep(2)) {
                    $('#loader').show();
                    $.ajax({
                        url: '<?= base_url("creditheroscore/CrxHeroScoreRegistration") ?>',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            let res = JSON.parse(response);
                            $('#loader').hide();
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: 'Success',
                                    text: res.message,
                                    icon: 'success',
                                    confirmButtonText: 'Continue'
                                }).then(() => {
                                    $('#p_first_name').val(first_name);
                                    $('#pp_first_name').val(first_name);
                                    $('#p_last_name').val(last_name);
                                    $('#pp_last_name').val(last_name);
                                    $('#p_user_name').val(email);
                                    $('#pp_user_name').val(email);
                                    $('#pp_zip').val(zip);
                                    $('#p_amount').val(21.33);

                                    $('#payment-form').css('display', 'block');
                                    $('#crx-hero-registration-form').css('display', 'none');
                                });
                            } else if (res.status === 'error') {

                                currentStep--;
                                showStep(currentStep);

                                Swal.fire({
                                    title: 'Error',
                                    text: res.message,
                                    icon: 'error',
                                    confirmButtonText: 'Close'
                                });
                            }
                        }
                    });
                }
            });

            function showStep(step) {
                $('.step').hide();
                $('#step' + step).show();
                updateProgressBar(step);
            }

            function updateProgressBar(step) {
                $('.progress-box').removeClass('active');
                for (let i = 1; i <= step; i++) {
                    $('#progress-box-' + i).addClass('active');
                }
            }

            function validateStep(step) {
                let isValid = true;

                clearFieldValidation($('#first_name'));
                clearFieldValidation($('#last_name'));
                clearFieldValidation($('#address'));
                clearFieldValidation($('#city'));
                clearFieldValidation($('#state'));
                clearFieldValidation($('#zip'));
                clearFieldValidation($('#ssn'));
                clearFieldValidation($('#dob'));
                clearFieldValidation($('#user_name'));
                clearFieldValidation($('#password'));

                if (step === 1) {
                    if (!$('#first_name').val()) {
                        handleFieldValidation($('#first_name'), "First Name is required.");
                        isValid = false;
                    }
                    if (!$('#last_name').val()) {
                        handleFieldValidation($('#last_name'), "Last Name is required.");
                        isValid = false;
                    }
                    if (!$('#address').val()) {
                        handleFieldValidation($('#address'), "Address is required.");
                        isValid = false;
                    }
                    if (!$('#city').val()) {
                        handleFieldValidation($('#city'), "City is required.");
                        isValid = false;
                    }
                    if (!$('#state').val()) {
                        handleFieldValidation($('#state'), "State is required.");
                        isValid = false;
                    }
                    if (!$('#zip').val()) {
                        handleFieldValidation($('#zip'), "Zip is required.");
                        isValid = false;
                    }
                    if (!$('#phone').val()) {
                        handleFieldValidation($('#phone'), "Phone is required.");
                        isValid = false;
                    }
                }

                if (step === 2) {
                    if (!$('#ssn').val()) {
                        handleFieldValidation($('#ssn'), "Social Security Number is required.");
                        isValid = false;
                    }
                    if (!$('#dob').val()) {
                        handleFieldValidation($('#dob'), "Date of Birth is required.");
                        isValid = false;
                    }
                    if (!$('#user_name').val()) {
                        handleFieldValidation($('#user_name'), "User Name is required.");
                        isValid = false;
                    }
                    if (!$('#password').val()) {
                        handleFieldValidation($('#password'), "Password is required.");
                        isValid = false;
                    }
                }

                return isValid;
            }

        });
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
                            // window.location.href = "<?php echo base_url('subscriber/login'); ?>";
                            $('#success_message').css('display', 'block');
                            $('#payment-form').css('display', 'none');
                            $('#crx-hero-registration-form').css('display', 'none');
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
</body>