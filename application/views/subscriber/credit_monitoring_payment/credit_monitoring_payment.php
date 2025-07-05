<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Credit Repair Xperts</title>
    <link rel="shortcut icon" href="https://team20.in/credit_repair_xperts/assets/images/logo.png" />
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
    <!-- Toastr s -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <!-- Toastr e -->


    <style>
        .carousel-inner {
            height: 500px;
        }

        .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        /*  */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            display: block;
        }

        /*  */

        /* Loader CSS */
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
    </style>
</head>

<body>
    <div id="loader">
        <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="https://team20.in/credit_repair_xperts/assets/images/logo.png" width="30" height="30" alt="Credit Repair Xperts">
            Credit Repair Xperts
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="<?php echo base_url('sign-in'); ?>">Sign In</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="main-wrapper">
        <div class="page-wrapper" style="margin-left: 150px !important; margin-right:150px !important; padding-top:0px; background-color:white;">
            <div class="content container-fluid">

            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal fade" id="subscription_modal_payment" tabindex="-1" role="dialog" aria-labelledby="subscription_modal_payment" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Credit Monitoring Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-sample" id="addTeamMemberForm" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="amount" id="amount" class="form-control card-amount">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Name on Card<span class="text-danger">*</span></label>
                                <input type="text" name="ccname" id="ccname" class="form-control" size="4">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Card Number<span class="text-danger">*</span></label>
                                <input type="text" name="ccnumber" id="ccnumber" autocomplete="off" class="form-control card-number" size="20">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Expiration Date<span class="text-danger">*</span></label>
                                <input type="text" name="ccexp" id="ccexp" class="form-control card-expiry-month" placeholder="MMYY" size="4">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>CVC<span class="text-danger">*</span></label>
                                <input type="text" name="cvv" id="cvv" autocomplete="off" class="form-control card-cvc" placeholder="ex. 311" size="4">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="save_card" name="save_card" checked>
                                    <label class="form-check-label" for="save_card" style="margin-left: 0px !important;">
                                        Save Card for Auto-Renew Subscription
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                    <button type="button" class="btn btn-danger" id="total_amount" onclick="credit_monitoring_payment();">Submit Payment</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- hidden s -->
    <input type="hidden" name="sq_email" id="sq_email" value="<?php echo $sq_email; ?>">
    <input type="hidden" name="sq_first_name" id="sq_first_name" value="<?php echo $sq_first_name; ?>">
    <input type="hidden" name="sq_last_name" id="sq_last_name" value="<?php echo $sq_last_name; ?>">
    <!-- hidden e -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
    
            <?php if ($this->session->flashdata('error')) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $this->session->flashdata('error'); ?>'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo base_url(); ?>";
                    }
                });
            <?php } ?>
        });

        $(document).ready(function() {
            $('#subscription_modal_payment').modal('show');
            $('#amount').val(20);
            $('#total_amount').text('Pay $20.00');
        });

        $('#subscription_modal_payment').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        function credit_monitoring_payment() {
            let ccname = $('#ccname').val();
            let ccnumber = $('#ccnumber').val();
            let ccexp = $('#ccexp').val();
            let cvv = $('#cvv').val();
            let amount = $('#amount').val();
            let save_card = $('#save_card').is(':checked') ? '1' : '0';

            let sq_email = $('#sq_email').val();
            let sq_first_name = $('#sq_first_name').val();
            let sq_last_name = $('#sq_last_name').val();

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
                    url: '<?php echo base_url('credit_monitoring_payment'); ?>',
                    data: {
                        'ccname': ccname,
                        'ccnumber': ccnumber,
                        'ccexp': ccexp,
                        'cvv': cvv,
                        'amount': amount,
                        'save_card': save_card,
                        'sq_email': sq_email,
                        'sq_first_name': sq_first_name,
                        'sq_last_name': sq_last_name,
                    },
                    success: function(response) {
                        $('#loader').hide();
                        var data = JSON.parse(response);
                        if (data.success) {
                            toastr.success(data.message);
                            setTimeout(function() {
                                window.location.href = "https://team20.in/credit_repair_xperts/sign-in";
                            }, 1500);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        toastr.error('An error occurred while processing your request.');
                    }
                });
            }
        }
    </script>

</body>

</html>