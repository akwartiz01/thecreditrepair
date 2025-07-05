<?php

$f_name = $getClient[0]->sq_first_name ?? '';
$l_name = $getClient[0]->sq_last_name ?? '';
$name = trim("$f_name $l_name");

?>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- Digital Signature -->
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Dancing+Script&family=Pacifico&family=Shadows+Into+Light&display=swap" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<style>
    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #dee2e6;
    }

    .coming-soon h2 {
        animation: blink 1.5s step-end infinite;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Settings</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <a type="button" class="btn btn-primary" id="password_setting" href="<?php echo base_url('client/profile_setting?tab=password'); ?>">Change Password</a>

                                </div>
                            </div>
                        </div>

                        <h3>Login Details for Credit Monitoring</h3>
                        <hr>

                        <form id="credit_monitoring" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= (!empty($user['id'])) ? $user['id'] : '' ?>" id="user_id">
                            <input type="hidden" id="client_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Report Provider</label>
                                        <select class="form-control" id="report_provider" name="report_provider">
                                            <option value="0">Select Report provider</option>
                                            <option value="CreditHeroScore">CRX Hero</option>
                                            <option value="other">other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Other Report Provider Name</label>
                                        <input class="form-control datepicker" type="text" id="other_provider" name="other_provider" placeholder='Enter other report provider name'>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Username<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="User_name" id="User_name">
                                    </div>
                                    <div class="col-6">
                                        <label>Password<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="password" id="password">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone Number</label>
                                        <input class="form-control" type="text" name="phone_number" id="phone_number">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Security Word (if you created one)</label>
                                        <input class="form-control" type="text" name="security_word" id="security_word">
                                    </div>
                                </div>
                            </div>


                            <div class="mt-4">
                                <button type="button" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        <br>
                        <h4>Choose a Signature Style</h4>
                        <hr>

                        <br>
                        <p>To challenge negative items on your report, we will send carefully drafted letters to creditors and credit bureaus on your behalf.</p>
                        <br>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Enter your full name as it should appear in your signature</label>
                                    <input class="form-control" type="text" name="name_input" id="name-input">
                                </div>
                            </div>
                        </div>

                        <div id="signature-style">
                            <label class="d-block mb-2">
                                <input type="radio" name="signature-font" value="Great Vibes">
                                <span class="signature-preview" style="font-family: 'Great Vibes'; font-size: 30px; margin-left: 10px;"></span>
                            </label>
                            <label class="d-block mb-2">
                                <input type="radio" name="signature-font" value="Dancing Script">
                                <span class="signature-preview" style="font-family: 'Dancing Script'; font-size: 30px; margin-left: 10px;"></span>
                            </label>
                            <label class="d-block mb-2">
                                <input type="radio" name="signature-font" value="Pacifico">
                                <span class="signature-preview" style="font-family: 'Pacifico'; font-size: 30px; margin-left: 10px;"></span>
                            </label>
                            <label class="d-block mb-2">
                                <input type="radio" name="signature-font" value="Shadows Into Light">
                                <span class="signature-preview" style="font-family: 'Shadows Into Light'; font-size: 30px; margin-left: 10px;"></span>
                            </label>
                        </div>

                        <div id="selected-signature-preview" style="font-size: 40px; margin-top: 20px; border: 1px solid #ddd; padding: 10px;"></div>
                        <br>
                        <form action="" method="post" id="signature-style-form">
                            <input type="hidden" name="name" id="name-hidden">
                            <input type="hidden" name="font" id="font-hidden">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="deletePopup" class="swal-overlay swal-overlay--show-modal" tabindex="-1" style="display: none;">
    <div id="deletePopupModal" class="swal-modal" role="dialog" aria-modal="true" style="display: none;">
        <input type="hidden" name="hiddenClientId" id="hiddenClientId" value="">
        <div class="swal-icon swal-icon--warning">
            <span class="swal-icon--warning__body">
                <span class="swal-icon--warning__dot"></span>
            </span>
        </div>
        <div class="swal-title" style="">Are you sure?</div>
        <div class="swal-text" style="">You won't be able to revert this!</div>
        <div class="swal-footer">
            <div class="swal-button-container">
                <button class="swal-button swal-button--cancel btn btn-danger" onclick="deleteCancel();">Cancel</button>
                <div class="swal-button__loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="swal-button-container">
                <button class="swal-button swal-button--confirm btn btn-primary" onclick="deleteClient();">OK</button>
                <div class="swal-button__loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Initialize DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#clients_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    function deleteClientPopUp(that, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url('deleteClient'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Client has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the client.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was a problem processing your request.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var initialName = "<?php echo $name ?>";
        document.getElementById('name-input').value = initialName;
        updateAllPreviews();
        updateSelectedSignaturePreview();
    });

    document.getElementById('name-input').addEventListener('input', function() {
        updateAllPreviews();
        updateSelectedSignaturePreview();
    });

    document.querySelectorAll('input[name="signature-font"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            updateSelectedSignaturePreview();
        });
    });

    function updateAllPreviews() {
        var name = document.getElementById('name-input').value;
        document.querySelectorAll('.signature-preview').forEach(function(preview) {
            preview.innerHTML = name;
        });
    }

    function updateSelectedSignaturePreview() {
        var name = document.getElementById('name-input').value;
        var selectedFont = '';

        document.querySelectorAll('input[name="signature-font"]').forEach(function(radio) {
            if (radio.checked) {
                selectedFont = radio.value;
            }
        });

        var preview = document.getElementById('selected-signature-preview');
        preview.innerHTML = name;
        preview.style.fontFamily = selectedFont;

        document.getElementById('name-hidden').value = name;
        document.getElementById('font-hidden').value = selectedFont;
    }

    $('#signature-style-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get the entered name and selected font
        var name = $('#name-hidden').val();
        var font = $('#font-hidden').val();

        // Check if name and font are filled
        if (name === '' || font === '') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter your name and select a signature style.',
                confirmButtonText: 'OK'
            });
            return; // Stop submission
        }

        // Check if the signature preview is empty (if no text is displayed)
        var preview = document.getElementById('selected-signature-preview');
        if (!preview || preview.innerHTML.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Signature preview is empty. Please make sure your name is entered and a style is selected.',
                confirmButtonText: 'OK'
            });
            return; // Stop submission
        }

        // Proceed to capture the signature image and submit it
        html2canvas(preview).then(function(canvas) {
            // Convert canvas to base64 image
            var imgData = canvas.toDataURL('image/png');

            // Prepare the form data
            var formData = new FormData();
            formData.append('signature_image', imgData);
            formData.append('name', name);
            formData.append('font', font);

            // Use jQuery for AJAX request
            $.ajax({
                url: '<?php echo base_url("client/save_digital_signature"); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire(
                            'Success!',
                            'Signature saved successfully.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            res.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving the signature. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>