<!DOCTYPE html>
<html lang="en" dir="">

<head>
	<title>CRX Credit Repair</title>
	<!-- Meta -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
	<meta name="title" content="">
	<meta name="description" content="">


	<!-- Favicon icon -->
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png" type="image/x-icon" />

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
	</style>

	<style>
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
	<!-- [ Header ] start -->
	<header class="main-header">
		<div class="announcement bg-dark text-center p-2">
			<p class="mb-0">
			<p>CRX Credit Repair</p>
			</p>
		</div>
		<div class="container">
			<nav class="navbar navbar-expand-md  default top-nav-collapse">
				<div class="header-left">
					<a class="navbar-brand bg-transparent" href="<?php echo base_url(); ?>">
						<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" style="width: 50% !important;">
					</a>
				</div>

				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
						</li>

						<li class="nav-item" style="display:none;">
							<a class="nav-link" href="<?php echo base_url('subscription-plans'); ?>">Plans</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="https://thecreditrepairxperts.com/subscription-plans/#faq">FAQS</a>
						</li>
					</ul>

					<button class="navbar-toggler bg-primary" type="button" data-bs-toggle="collapse"
						data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>

				<div class="ml-auto d-flex justify-content-end gap-2">
					<!-- Dropdown Button for Login -->
					<div class="dropdown">
						<button class="btn btn-outline-dark dropdown-toggle rounded" type="button" id="loginDropdown"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #e38c11 !important;">
							<span class="hide-mob me-2">Login</span> <i data-feather="log-in"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="loginDropdown">
							<a class="dropdown-item" href="<?php echo base_url('sign-in'); ?>">Admin || Staff Login</a>
							<a class="dropdown-item" href="<?php echo base_url('subscriber/login'); ?>">Subscriber Login</a>
							<a class="dropdown-item" href="<?php echo base_url('client-login'); ?>">Client Login</a>
							<a class="dropdown-item" href="<?php echo base_url('affiliate-login'); ?>">Affiliate Login</a>
						</div>
					</div>

					<!-- Register Button -->
					<a href="<?php echo base_url('subscription-plans'); ?>" class="btn btn-outline-dark rounded">
						<span class="hide-mob me-2">Register</span>
						<i data-feather="user-check"></i>
					</a>

					<button class="navbar-toggler" type="button" data-toggle="collapse"
						data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>

			</nav>
		</div>

	</header>