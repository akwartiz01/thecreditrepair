<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="aTZUxZSMmgRGSYwuwWYfn6ZnfGgZbSQRyESdRcx7">

    <meta name="keyword" content="">
    <meta name="description" content="">

    <title> Login &dash; CRX Hero</title>


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

        .auth-wrapper .navbar .navbar-brand img {
            width: unset !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
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
                    <div class="col-xl-6">
                        <div class="card-body w-100">
                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600">Login</h2>
                            </div>
                            <form id="crx_hero_login" method="POST" action="" class="needs-validation" novalidate="">
                                <input type="hidden" name="_token" value="">

                                <div>
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" value="" placeholder="Email" required autofocus>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex">Password</label>
                                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                        <div class="mb-2 mt-2 d-flex">
                                            <a href="<?php echo base_url(); ?>" class="small text-muted text-underline--dashed border-primar">Forgot Your Password?</a>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block mt-2" id="submit">Login</button>
                                    </div>

                                    <p class="my-4 text-center">Not a Member Yet?
                                        <a href="<?php echo base_url('creditheroscore/sign-up'); ?>" class="my-4 text-primary" style="color: #162CCA !important;">Signup Now!</a>
                                    </p>
                                </div>
                            </form>

                        </div>

                    </div>
                    <!-- <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="<?php echo base_url('assets/images/macbook.png'); ?>" alt="" class="img-fluid">

                        </div>
                    </div> -->

                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <!-- <img src="<?php echo base_url('assets/images/macbook.png'); ?>" alt="" class="img-fluid"> -->
                            <h4>Should I expect to find errors in my credit profile?</h4>
                            <p>It's likely, according to financial experts and analysts. Your credit report can include errors and inaccuracies that can lower your credit score. As a member, you'll have access to your credit report from all 3 credit bureaus - TransUnion®, Experian®, Equifax® - so you can be sure that your credit information is correct.</p>


                            <h4>What are the benefits of my Credit Hero Score membership?</h4>
                            <p>You will have unlimited access to:</p>
                            <ul>
                                <li>24/7 Credit Monitoring5</li>
                                <li>Get email alerts about changes in your credit profile</li>
                                <li>Credit Education Center access</li>
                                <li>Social Security Number Monitoring</li>
                                <li>Identity Theft Protection4</li>

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
        $(document).ready(function() {
            $("#crx_hero_login").on('submit', function(e) {
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
                    url: "<?php echo base_url('creditheroscore/login'); ?>",
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
                        } else if (data.status === "success") {
                            window.location.href = data.redirect_url;
                        }
                    }
                });
            });
        });
    </script>
</body>