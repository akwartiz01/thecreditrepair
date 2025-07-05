<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <title>Credit Hero Score</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title" content="">
    <meta name="description" content="Credit Monitoring4 And Identity Theft Protection. Discover ways to improve your credit by getting access to all three credit reports3 and credit scores.">


    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/credit_hero_logo.png" type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/fonts/feather.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/fonts/material.css" />

    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/css/customizer.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/css/landing-page.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/css/custom.css" />


    <link rel="stylesheet" href="<?php echo base_url(); ?>Landing_page/assets/css/style.css" id="main-style-link">

    <!-- Popper.js and Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        #des p {
            padding-left: 48px;
        }


        body.theme-6 {
            background-color: white !important;
        }

        .dropdown-toggle {
            background-color: #f8f9fa;
            color: #343a40;
            border: 1px solid #343a40;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .dropdown-toggle:hover,
        .dropdown-toggle:focus {
            background-color: #343a40;
            color: #f8f9fa;
        }

        /* Style the dropdown menu */
        .dropdown-menu {
            background-color: #ffffff;
            border: 1px solid #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .dropdown-item {
            color: #343a40;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #343a40;
            color: #ffffff;
        }

        .dropdown-toggle i {
            margin-left: 5px;
        }

        a.dropdown-item {
            font-size: 15px !important;
            font-weight: 400 !important;
        }

        .swal2-icon.swal2-error {
            border-color: #f27474 !important;
            color: #f27474 !important;
        }

        .swal2-icon.swal2-error [class^="swal2-x-mark-line"] {
            background-color: #f27474 !important;
        }

        header.main-header {
            background-color: white !important;
        }

        .log-in {
            background-color: #162CCA !important;
            color: white !important;
            font-family: '__Bricolage_Grotesque_114db6', '__Bricolage_Grotesque_Fallback_114db6';
            font-weight: 500;
            padding: 8px 22px !important;
        }

        .sign-up {
            border-color: #162CCA !important;
            color: #162CCA !important;
            font-family: '__Bricolage_Grotesque_114db6', '__Bricolage_Grotesque_Fallback_114db6';
            font-weight: 500;
            padding: 8px 22px !important;
        }

        section#home {
            background-color: #162CCA !important;
        }

        h1,
        .h1,
        h2,
        .h2,
        h3,
        .h3,
        h4,
        .h4,
        h5,
        .h5,
        h6,
        .h6 {

            color: #fff !important;
        }

        a.btn.btn-outline-dark {
            background-color: #f5f5f5 !important;
            color: black !important;
        }

        h1.mb-3 {
            font-family: "Jost", sans-serif !important;
            font-size: 40px;
        }

        .credit-goals-section {
            padding: 40px 20px;
            /* background-color: #f5f5f5; */
            background-color: #fff;
        }

        .credit-goals-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .credit-goals-header h4 {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
        }

        .credit-goals-boxes {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .credit-goals-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1 1 30%;
            /* Makes 3 boxes per row, adjusts based on screen size */
            transition: transform 0.3s ease;
        }

        .credit-goals-box#monitor {

            border: 1px solid #CC2121;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
            box-shadow: 0px 117px 97px -95px #CC2121, 0px 27px 28px -21px rgba(0, 0, 0, 0.22);

        }

        .credit-goals-box#protect {

            border: 1px solid #162CCA;
            box-shadow: 0px 117px 97px -95px #162CCA, 0px 27px 28px -21px rgba(0, 0, 0, 0.22);

        }

        .credit-goals-box#achieve {

            border: 1px solid #FFBE00;
            box-shadow: 0px 117px 97px -95px #FFBE00, 0px 27px 28px -21px rgba(0, 0, 0, 0.22);

        }

        .credit-goals-box:hover {
            transform: translateY(-10px);
        }

        .credit-goals-box img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .credit-goals-box h6 {
            font-size: 20px !important;
            color: #333 !important;
            font-weight: 600 !important;
            margin-bottom: 10px;
        }

        .credit-goals-box p {
            font-size: 16px;
            color: #777;
        }

        @media (max-width: 768px) {
            .credit-goals-box {
                flex: 1 1 100%;
                /* Stacks the boxes on smaller screens */
            }
        }

        h6 {
            font-size: 15px !important;
        }

        .site-footer ol li {
            color: white !important;
        }

        .site-footer {
            background-color: #162CCA !important;
        }

        /* Section 1: What You Will Get */
        #section-what-you-get .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: center;
            margin-bottom: 50px;
        }

        #section-what-you-get .image-container img {
            width: 100%;
            height: auto;
        }

        #section-what-you-get .text-container h4,
        #section-what-you-get .text-container h6 {
            color: #0077b6;
        }

        #section-what-you-get .text-container h4 {
            font-size: 1.25rem;
            margin-bottom: 15px;
        }

        #section-what-you-get .text-container h6 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        #section-what-you-get .text-container p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.8;
        }

        /* Section 2: Protecting Your Identity */
        #section-protect-identity .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: center;
            margin-bottom: 50px;
        }

        #section-protect-identity .image-container img {
            width: 100%;
            height: auto;
        }

        #section-protect-identity .text-container h6 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #0077b6;
        }

        #section-protect-identity .text-container p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.8;
        }

        /* Section 3: Understand Your Credit */
        #section-understand-credit .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: center;
            margin-bottom: 50px;
        }

        #section-understand-credit .image-container img {
            width: 100%;
            height: auto;
        }

        #section-understand-credit .text-container h6 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #0077b6;
        }

        #section-understand-credit .text-container p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.8;
        }


        .responsive-image {
            width: 100%;
            height: auto;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {

            #section-what-you-get .content-grid,
            #section-protect-identity .content-grid,
            #section-understand-credit .content-grid {
                grid-template-columns: 1fr;
            }

            .image-container {
                text-align: center;
            }
        }

        .content-section {
            margin-bottom: 80px !important;
        }

        .footer-row p {
            color: white !important;
        }

        .dash-preview .preview-img {
            object-fit: contain !important;
        }

        a#sign-up:hover {
            background-color: #162CCA !important;
            color: white !important;
        }

        a#log-in:hover {
            background-color: white !important;
            color: #162CCA !important;
            border-color: #162CCA !important;
        }

        .images-section li {
            list-style: none !important;
        }

        .images-section img {
            width: 50% !important;
        }
    </style>
</head>

<body class="theme-6">

    <header class="main-header">

        <div class="container">
            <nav class="navbar navbar-expand-md  default top-nav-collapse">
                <div class="header-left">
                    <a class="navbar-brand bg-transparent" href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url(); ?>assets/images/credit_hero_logo.png" alt="logo" style="width: 30% !important;">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('creditheroscore'); ?>" style="display: block !important;">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#contact-us">Contact Us</a>
                        </li>
                    </ul>
                    <button class="navbar-toggler bg-primary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="ms-auto d-flex justify-content-end gap-2">
                    <a href="<?php echo base_url(); ?>creditheroscore/login" class="btn log-in" id="log-in"><span
                            class="hide-mob me-2">Log In</span></a>
                    <a href="<?php echo base_url('creditheroscore/sign-up'); ?>" class="btn sign-up" id="sign-up"><span class="hide-mob me-2">Sign Up</span></a>
                    <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>


            </nav>
        </div>

    </header>

    <section class="main-banner bg-primary" id="home" style="background-image: url('<?php echo base_url('assets/images/home-header.svg'); ?>') !important; background-size: cover!important; background-position: center!important;">
        <div class="container-offset">
            <div class="row gy-3 g-0 align-items-center">
                <div class="col-xxl-5 col-md-6">
                    <h1 class="mb-3">Credit Monitoring And Identity Theft Protection</h1>
                    <h6 class="mb-0">CRX Hero is dedicated to helping you improve your credit score and achieve financial freedom. Our team of experts works tirelessly to provide you with the best service and support.</h6>

                    <div class="d-flex gap-3 mt-4 banner-btn">
                        <a href="<?php echo base_url('creditheroscore/sign-up'); ?>" class="btn btn-outline-dark">Get Started</a>
                    </div>
                    <h6 class="mb-3 mt-3">3-Days $1.00 Access Fee, then a Monthly Membership fee of $19.99 + tax will apply.</h6>
                </div>
                <div class="col-xxl-7 col-md-6">
                    <div class="dash-preview">
                        <img class="img-fluid preview-img" src="<?php echo base_url('assets/images/CreditScore.png'); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="credit-goals-section content-section">
        <div class="credit-goals-container">
            <div class="credit-goals-header">
                <h4 style="color: black !important;">Reach Your Credit Goals</h4>
            </div>
            <div class="credit-goals-boxes">
                <div class="credit-goals-box" id="monitor">
                    <img alt="logos" src="<?php echo base_url('assets/images/monitor.svg'); ?>">
                    <h6>Monitor</h6>
                    <p>Unlimited access to your credit reports and credit scores from all three bureaus</p>
                </div>
                <div class="credit-goals-box" id="protect">
                    <img alt="logos" src="<?php echo base_url('assets/images/protect.svg'); ?>">
                    <h6>Protect</h6>
                    <p>Daily monitoring alerts you to suspicious activity</p>
                </div>
                <div class="credit-goals-box" id="achieve">
                    <img alt="logos" src="<?php echo base_url('assets/images/achieve.svg'); ?>">
                    <h6>Achieve</h6>
                    <p>Help you get approved and lower your interest</p>
                </div>
            </div>
        </div>
    </section>

    <section id="section-what-you-get" class="content-section">
        <div class="container">
            <div class="content-grid">
                <div class="image-container">
                    <img src="<?php echo base_url('assets/images/credit_score.svg'); ?>" alt="What you will get" class="responsive-image">
                </div>
                <div class="text-container">
                    <h2 style="color:black !important;">What you will get</h2><br>
                    <h4 style="color:black !important;">Monitor Your Credit</h4>
                    <p>Get access to your credit reports and credit scores from all 3 bureaus.</p>

                    <div style="display: flex;" class="images-section">
                        <li><img src="<?php echo base_url(); ?>downloads/simple_audit_images/trans_union.png" alt=""></li>
                        <li><img src="<?php echo base_url(); ?>downloads/simple_audit_images/equifax.png" alt=""></li>
                        <li><img src="<?php echo base_url(); ?>downloads/simple_audit_images/experian.png" alt=""></li>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="section-protect-identity" class="content-section">
        <div class="container">
            <div class="content-grid">
                <div class="image-container">
                    <img src="<?php echo base_url('assets/images/macbook.png'); ?>" alt="Protecting Your Identity" class="responsive-image">
                </div>
                <div class="text-container">
                    <h2 style="color: black !important;">Protecting Your Identity</h2>
                    <p>Tools to monitor and protect your identity.</p>
                </div>
            </div>
        </div>
    </section>


    <section id="section-understand-credit" class="content-section">
        <div class="container">
            <div class="content-grid">
                <div class="image-container">
                    <img src="<?php echo base_url('assets/images/credit_history.svg'); ?>" alt="Understand Your Credit" class="responsive-image">
                </div>
                <div class="text-container">
                    <h2 style="color: black !important;">Understand Your Credit</h2>
                    <p>Learn to maximize your credit scores and take steps to reach your goals.</p>

                </div>
            </div>
        </div>
    </section>

    <section class="credit-goals-section" class="content-section">
        <div class="credit-goals-container">
            <div class="credit-goals-header">
                <h4 style="color: black !important;">We’ve got you covered</h4>
            </div>
            <div class="credit-goals-boxes">
                <div class="credit-goals-box" id="monitor">
                    <img alt="logos" src="<?php echo base_url('assets/images/monitor.svg'); ?>">
                    <h6>1-Click Cancellation</h6>
                    <p>Checking your own credit will not affect your credit scores</p>
                </div>
                <div class="credit-goals-box" id="protect">
                    <img alt="logos" src="<?php echo base_url('assets/images/protect.svg'); ?>">
                    <h6>Will Not Hurt Your Credit Scores</h6>
                    <p>Checking your own credit will not affect your credit scores</p>
                </div>
                <div class="credit-goals-box" id="achieve">
                    <img alt="logos" src="<?php echo base_url('assets/images/achieve.svg'); ?>">
                    <h6>Bank-level security</h6>
                    <p>Protected by 128-bit data encryption</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer bg-gray-100" id="contact-us">
        <div class="container">
            <div class="footer-row">
                <div class="ftr-col cmp-detail">
                    <div class="footer-logo mb-3">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/images/credit_hero_logo.png" alt="logo" style="filter: drop-shadow(2px 3px 7px #011C4B);">
                        </a>
                    </div>

                </div>

                <div class="ftr-col">
                    <ul class="list-unstyled">
                    </ul>
                </div>

                <div class="ftr-col ftr-subscribe">
                    <h2>Contact Us</h2>
                    <p>Email : info@crxhero.com</p>
                    <p>Call us : (000) 000-0000</p>
                    <p>Address : 1 Eves Drive Suite 103B Mt. Laurel, NJ 08054</p>
                </div>


            </div>

        </div>
        <div class="border-top border-dark text-center p-2">

            <p class="mb-0"> Copyright &copy; 2024 - <?php echo date('Y'); ?> CRX Hero - All Rights Reserved.</p>
        </div>
    </footer>

    <script src="<?php echo base_url(); ?>Landing_page/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/assets/js/plugins/feather.min.js"></script>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let ost = 0;
        document.addEventListener("scroll", function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector(".navbar").classList.add("top-nav-collapse");
            } else if (cOst > ost) {
                document.querySelector(".navbar").classList.add("top-nav-collapse");
                document.querySelector(".navbar").classList.remove("default");
            } else {
                document.querySelector(".navbar").classList.add("default");
                document
                    .querySelector(".navbar")
                    .classList.remove("top-nav-collapse");
            }
            ost = cOst;
        });

        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: "#navbar-example",
        });
        feather.replace();


        $(document).ready(function() {
            $('.tox-notifications-container').addClass('d-none')
        });
    </script>

    <script>
        function subscribe(subscriptionId, price) {
            $.ajax({
                url: "<?php echo base_url('subscribe'); ?>",
                type: "POST",
                data: {
                    id: subscriptionId,
                    price: price
                },
                success: function(response) {
                    window.location.href = "<?php echo base_url('registration'); ?>";
                },
                error: function(xhr, status, error) {
                    console.error("Subscription failed: " + error);
                }
            });
        }
    </script>

</body>

</html>