<?php

$f_name = $client->sq_first_name ?? '';
$l_name = $client->sq_last_name ?? '';
$name = trim("$f_name $l_name");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRX Credit Repair</title>

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/lock.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style id="sqhead">
  /* some styles here */
</style>
    <style>
        body {
            background-color: #f5f5f5;
        }

        /* Fixed Navbar */
        .navbar {
            background-color: #0558b5;
            /* padding: 15px; */
            padding: 10px 15px 10px 15px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar .navbar-brand span {
            color: white;
            font-size: 18px;
            font-weight: 500;
        }

        .navbar .contact-info {
            color: white;
            font-size: 16px;
        }

        .navbar .ml-auto {
            display: flex;
            align-items: center;
            color: white;
        }

        .navbar .ml-auto img {
            height: 25px;
            margin-right: 10px;
        }

        .navbar .ml-auto span {
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        /* Dropdown Menu */
        .navbar .dropdown .dropdown-toggle {
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            /* background-color: #0558b5; */
            background-color: #054a98;
            border: 1px solid transparent;
            transition: background-color 0.3s ease;
        }

        .navbar .dropdown .dropdown-toggle:hover {
            background-color: #054a98;
        }

        .navbar .dropdown-menu {
            background-color: #2f373e;
            border: none;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar .dropdown-menu a {
            color: white;
            font-size: 14px;
            padding: 10px 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar .dropdown-menu a:hover {
            background-color: #f5f5f5;
            color: #2f373e;
        }

        .dashboard-container {
            max-height: 100vh;
            overflow-y: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            margin: 80px auto 20px auto;
            /* Add margin to account for fixed navbar */
            width: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .agreement-box {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .signature-pad {
            border: 1px dashed #333;
            background-color: #f9f9f9;
            width: 100%;
            max-width: 600px;
            height: auto;
        }

        .signature-box {
            margin-top: 20px;
        }

        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }

        /* Footer */
        footer {
            background-color: #0558b5;
            color: white;
            text-align: center;
            padding: 10px;
            /*position: fixed;*/
            bottom: 0;
            width: 100%;
        }

        .agreement_heading {
            font-size: 24px !important;
            font-weight: 300 !important;
            border-bottom: 1px solid #e7ecf1 !important;
            padding-bottom: 5px !important;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
            <img src="/assets/images/logo.png" alt="Logo">
            <!-- <span>The CRX Credit Repair</span> -->
        </a>

        <div>
            <span style="color: white;">
                <strong>The CRX Credit Repair </strong><br>
                (856) 515-6408 <br>
                www.thecreditrepairxperts.com
            </span>
        </div>

        <div class="ml-auto">
            <img src="https://thecreditrepairxperts.com/assets/images/lock.png" alt="Secure Access">
            <span>Secure Client Access</span>
        </div>

        <div class="ml-3 dropdown">
            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $name; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Change Password</a>
                <a class="dropdown-item" href="<?php echo base_url('signout'); ?>">Logout</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container" style="margin-top: 120px !important;">
        <h2 class="agreement_heading">Sign Agreement</h2>

        <div class="agreement-box">
            <div><?= $agreement_text ?></div>

            <div>
                <h2 class="agreement_heading">Digital Signature</h2>
            </div>
            <div class="form-group">
                <label for="">Enter your name</label>
                <input type="text" class="form-control" id="clientName" placeholder="Enter your name" value="<?php echo $name; ?>" readonly>
            </div>

            <div class="signature-box">
                <h2 class="agreement_heading">Enter your signature</h2>
                <canvas id="signature-pad" class="signature-pad" width="600" height="200"></canvas>
            </div>

            <div class="mt-2">
                <p>Date: <span id="current-date"><?= date('Y-m-d') ?></span></p>
                <p>Name: <span id="client-name-display"><?php echo $name; ?></span></p>
            </div>

            <div class="buttonss">
                <button type="button" class="btn btn-danger mt-2" id="clear">Clear Signature</button>
                <button type="button" class="btn btn-success mt-2" id="submit_agreement">Submit Now</button>
            </div>

            <button class="btn btn-primary mt-4" id="openPrintPreview" data-toggle="modal" data-target="#printModal">Print Preview</button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date('Y'); ?> The CRX Credit Repair. All Rights Reserved.
    </footer>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Print Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="print-content">
                        <h3>Sign Agreement</h3>
                        <div id="agreement_text"><?= $agreement_text ?></div>

                        <div class="signature-box" id="client_signature"></div>

                        <p>Date: <span id="modal-date"></span></p>
                        <p>Name: <span id="modal-name"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary print_button">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
  
   $("body").on("click", ".print_button", function () {
  var prtContent = document.getElementById("print-content");
  var style = document.getElementById("sqhead");

  if (!prtContent || !style) {
    alert("Print content or style not found!");
    return;
  }

  var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=570,toolbar=0,scrollbars=0,status=0');

  WinPrint.document.write(style.innerHTML + '<style>.ptbtn{display:none !important;}</style>' + prtContent.innerHTML);
  WinPrint.document.close();
  WinPrint.focus();
  WinPrint.print();
  WinPrint.onafterprint = function () {
    WinPrint.close();
  };
});

        function resizeCanvas() {
            var canvas = document.getElementById('signature-pad');
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
        }

        $(document).ready(function() {
            var canvas = document.getElementById('signature-pad');
            var signaturePad = new SignaturePad(canvas);
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Set current date
            var currentDate = new Date().toLocaleDateString();
            document.getElementById('current-date').textContent = currentDate;

            // Clear signature pad
            document.getElementById('clear').addEventListener('click', function() {
                signaturePad.clear();
            });


            document.getElementById('submit_agreement').addEventListener('click', function() {
                var clientName = document.getElementById('clientName').value;
                if (!clientName) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Name Required!',
                        text: 'Please enter your name.'
                    });
                    return;
                }
                document.getElementById('client-name-display').textContent = clientName;

                if (signaturePad.isEmpty()) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Signature Required!',
                        text: 'Please provide a signature first.'
                    });
                } else {
                    var signatureData = signaturePad.toDataURL(); // Base64-encoded PNG signature 
                    console.log(signatureData);
                  
                    $.ajax({
                        url: '<?php echo base_url('client/save_agreement') ?>',
                        type: 'POST',
                        data: {
                            signature: signatureData,
                            agreement_text: '<?= json_encode($agreement_text) ?>',
                            agreement_id: '<?= $agreement->id ?>'
                        },
                        success: function(response) {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Agreement signed successfully!'
                                }).then(() => {
                                    window.location.href = "<?php echo base_url('client/dashboard'); ?>";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message
                                });
                            }
                        }
                    });
                }
            });


            // Capture signature and show it in the Print Preview modal
            document.getElementById('openPrintPreview').addEventListener('click', function() {
                var clientName = document.getElementById('clientName').value;
                document.getElementById('modal-name').textContent = clientName;
                document.getElementById('modal-date').textContent = currentDate;

                if (!signaturePad.isEmpty()) {
                    var signatureData = signaturePad.toDataURL();
                    var signatureBox = document.getElementById('client_signature');
                    signatureBox.innerHTML = '<h5>My Digital Signature:</h5><img src="' + signatureData + '" alt="Signature" class="img-fluid">';
                }
            });

            // Reset modal content on close or click outside
            $('#printModal').on('hidden.bs.modal', function() {
                var signatureBox = document.getElementById('client_signature');
                signatureBox.innerHTML = '<h5>My Digital Signature:</h5>';
            });
        });
       
    </script>

</body>

</html>