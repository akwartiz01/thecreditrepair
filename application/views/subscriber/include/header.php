<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>CRX Credit Repair</title>

	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/animate.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/owlcarousel/owl.theme.default.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/bootstrap-select.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/admin_blue.css">

	<link href="https://cdn.materialdesignicons.com/3.7.95/css/materialdesignicons.min.css" rel="stylesheet">

	<!-- Toastr s -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
	<!-- Toastr e -->

</head>

<style>
	.toast-info,
	.toast-success,
	.toast-warning,
	.toast-error {
		background-color: #3972FC !important;
		color: #ffffff !important;
	}

	.toast-info .toast-progress,
	.toast-success .toast-progress,
	.toast-warning .toast-progress,
	.toast-error .toast-progress {
		background-color: #ffffff !important;
	}

	/* Styling the input field */
	.datepicker input {
		border: 1px solid #ced4da;
		border-radius: 4px;
		padding: 10px;
		font-size: 16px;
		color: #495057;
		width: 100%;
	}

	/* Styling the datepicker widget */
	.bootstrap-datetimepicker-widget {
		background-color: #fff;
		border: 1px solid #ced4da;
		border-radius: 4px;
		box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
	}

	/* Styling the header (month and year) */
	.bootstrap-datetimepicker-widget .datepicker-switch {
		background-color: #007bff;
		color: #fff;
		padding: 10px;
		font-weight: bold;
		border-radius: 4px 4px 0 0;
		text-align: center;
	}

	/* Styling the days of the week */
	.bootstrap-datetimepicker-widget .dow {
		color: #007bff;
		font-weight: bold;
	}

	/* Styling individual day cells */
	.bootstrap-datetimepicker-widget td.day {
		padding: 10px;
		border-radius: 50%;
		transition: background-color 0.2s, color 0.2s;
	}

	/* Styling selected and hovered days */
	.bootstrap-datetimepicker-widget td.active,
	.bootstrap-datetimepicker-widget td.active:hover,
	.bootstrap-datetimepicker-widget td.day:hover {
		background-color: #007bff;
		color: #fff;
	}

	/* Styling the navigation arrows */
	.bootstrap-datetimepicker-widget .prev,
	.bootstrap-datetimepicker-widget .next {
		color: #007bff;
		font-size: 18px;
		padding: 10px;
		transition: color 0.2s;
	}

	.bootstrap-datetimepicker-widget .prev:hover,
	.bootstrap-datetimepicker-widget .next:hover {
		color: #0056b3;
	}

	.mdi {
		font-size: 16px !important;
	}

	.btn-secondary:hover {
		background-color: #6c757d !important;
		border-color: #6c757d !important;
	}

	.sidebar-logo img {
		max-height: 57px !important;
		width: auto;
	}

	.swal2-icon.swal2-error {
		border-color: #f27474 !important;
		color: #f27474 !important;
	}

	.swal2-icon.swal2-error [class^="swal2-x-mark-line"] {
		background-color: #f27474 !important;
	}

	.invalid-feedback {
		font-size: 14px !important;
	}

	.position-relative .invalid-feedback {
		position: absolute !important;
		top: 100% !important;
		left: 0 !important;
		width: 100% !important;
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

</style>

<body>

	<div id="loader">
		<img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
	</div>

	<div class="main-wrapper">