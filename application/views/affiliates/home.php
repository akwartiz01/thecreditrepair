

<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Dancing+Script&family=Pacifico&family=Shadows+Into+Light&display=swap" rel="stylesheet">

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- Signature pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<style>
    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #dee2e6;
    }


    .steps-list {
        margin-top: 20px;
    }

    .step-item {
        margin-bottom: 10px;
        display: inline-flex;
        align-items: center;
        width: 100%;
    }

    .step-item input[type="checkbox"] {
        margin-right: 8px;
    }

    .step-item .btn {
        margin-left: 10px;
    }

    .mt-checkbox {
        display: inline-flex;
        align-items: center;
        width: auto;
        font-weight: 400;
    }

    .mt-checkbox span {
        margin-left: 5px;
    }

    .btn-success {
        background: #3972FC !important;
        color: #fff !important;
        border: #3972FC !important;
    }

    .btn-success:hover {
        background: #3972FC !important;
        color: #fff !important;
        border: #3972FC !important;
    }

    /*  */

    .client-header {
        color: #525e64 !important;
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
        padding: 10px;
    }


    .client-info-section {
        padding: 15px 10px;
        border-top: 1px solid #ddd;
    }

    .portlet-body {
        padding: 15px 10px;
        border-top: 1px solid #ddd;
    }

    .client-image {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        object-fit: cover;

    }

    .client-name {
        font-weight: bold;
        font-size: 20px;
        display: block;
    }

    .client-email,
    .client-referred-by,
    .client-status {
        font-size: 15px;
        color: #555;
        display: block;
    }

    .client-referred-by {
        margin-top: 10px;
    }

    .client-status {
        margin-top: 5px;
    }

    .padding-top-10.client-options {
        margin-top: 15px;
    }


    /*  */


    /* agreement css s  */

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

    #printModal .modal-body {
        max-height: 400px;
        overflow-y: auto;
    }

    /* agreement css e */

    .btn.disabled {
        pointer-events: none;
        /* Disables clicking */
        opacity: 0.65;
        /* Visually indicate it's disabled */
        cursor: not-allowed;
        /* Change cursor to indicate disabled state */
    }


    #progressModal .main-heading {
        text-align: center;
    }


    #progressModal .step-content {
        display: none;
    }

    #progressModal .progress-bar {
        background-color: #4caf50;
    }


    #progressModal .modal-md-custom {
        max-width: 650px;
    }

    #progressModal .modal-body {
        padding: 20px;
        min-height: 300px;
    }

    #progressModal .step-content {
        padding-top: 10px;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    /* chart css s */
    #range_chart {
        margin-top: 30px;
    }

    .highcharts-credits {
        display: none;
    }

    /* chart css e */
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Dashboard</h3>
                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-7">
                            <h3 class="margin-top-0 mb-font-20">Welcome </h3>
                            <span>Here are a few things we need you to complete.</span>
                        </div>
                        <div class="steps-list">
                            <div class="step-item">
                                <label class="mt-checkbox mt-checkbox-outline homepagesteps">
                                    <input type="checkbox">Sign up for CRX Hero and Share Login Details <a id="navigation_video" class=" btn btn-success btn-sm">Complete Now</a>
                                </label>
                            </div>
                            <div class="step-item">
                                <label class="mt-checkbox mt-checkbox-outline homepagesteps">
                                    <input type="checkbox" >
                                    Setup Digital Signature
                                    <a class="btn btn-success btn-sm" id="digital_signature" >Complete Now</a>
                                </label>
                            </div>
                            <div class="step-item">
                                <label class="mt-checkbox mt-checkbox-outline homepagesteps">
                                    <input type="checkbox" >
                                    Upload Photo ID
                                    <a class="btn btn-success btn-sm ">Complete Now</a>
                                </label>
                            </div>
                            <div class="step-item">
                                <label class="mt-checkbox mt-checkbox-outline homepagesteps">
                                   
                                    Upload Proof of Address Complete Now                          </label>
                            </div>
                        </div>

                     
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="client-header bg-grey text-white p-2">
                                    <span class="caption-subject font-dgrey bold uppercase">Client</span>
                                </div>

                                <div class="client-info-section">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-4 text-center">
                                            <img class="img-responsive img-rounded client-image" src="" alt="Client Image">
                                        </div>
                                        <div class="col-sm-8 col-xs-8">
                                            <span class="client-name font-dgrey"></span>
                                           
                                            <span class="client-email"><?php echo $clientEmail; ?></span>
                                            <span class="client-referred-by">Referred By : </span>
                                            <span class="client-status">Status : <b><span style="color: green;"></span></b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="client-header bg-grey text-white p-2">
                                    <span class="caption-subject font-dgrey bold uppercase">Scores</span>
                                </div>

                                <div class="client-info-section">
                                   
                                    <table class="table table-hover table-light center">
                                        <thead>
                                            <tr class="uppercase">
                                                <th class='text-center'> &nbsp;</th>
                                                <th class='text-center'>
                                                    <img class="" alt="" src="assets/crx/equifax.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                </th>
                                                <th class='text-center'>
                                                    <img class="" alt="" src="assets/crx/experian.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                </th>
                                                <th class='text-center'>
                                                    <img class="" alt="" src="assets/crx/trans_union.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                                    <tr>
                                                        <td class='text-center'></td>
                                                        <td class='text-center'></td>
                                                        <td class='text-center'></td>
                                                       
                                                    </tr>
                                               
                                        </tbody>
                                    </table>

                                    <div id="range_chart">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      

        </div>

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var signatureUrl = "<?php echo isset($client_sign) ? $client_sign : ''; ?>";

    window.onload = function() {
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'));

        // Check if there's a saved signature URL
        if (signatureUrl) {
            var canvas = document.getElementById('signature-pad');
            var context = canvas.getContext('2d');
            var img = new Image();
            img.onload = function() {
                context.drawImage(img, 0, 0); // Draw the signature image on the canvas
            };
            img.src = signatureUrl; // Load the saved signature image
        }
    }

    // function printDiv(divId) {
    //     var divToPrint = document.getElementById(divId).innerHTML;
    //     var newWin = window.open('', 'Print-Window');
    //     newWin.document.open();
    //     newWin.document.write('<html><body onload="window.print()">' + divToPrint + '</body></html>');
    //     newWin.document.close();
    //     setTimeout(function() {
    //         newWin.close();
    //     }, 10);
    // }

    function printDiv(divId) {
        var divToPrint = document.getElementById(divId).innerHTML;
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(`
        <html>
            <head><title>Print</title></head>
            <body onload="window.print()">
                ${divToPrint}
            </body>
        </html>
    `);
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 10);
    }


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

        // Capture signature and show it in the Print Preview modal
        document.getElementById('openPrintPreview').addEventListener('click', function() {

            var signatureBox = document.getElementById('client_signature');
            signatureBox.innerHTML = '<h5>Digital Signature:</h5>';

            // Check if there's a saved signature URL
            if (signatureUrl) {
                // Display saved signature in print preview
                signatureBox.innerHTML += '<img src="' + signatureUrl + '" alt="Saved Signature" class="img-fluid-agreement">';
            } else if (!signaturePad.isEmpty()) {
                // If the signature pad is not empty, show the new signature
                var signatureData = signaturePad.toDataURL();
                signatureBox.innerHTML += '<img src="' + signatureData + '" alt="Signature" class="img-fluid-agreement">';
            }
        });

        // Reset modal content on close or click outside
        $('#printModal').on('hidden.bs.modal', function() {
            var signatureBox = document.getElementById('client_signature');
            signatureBox.innerHTML = '<h5>Digital Signature:</h5>';
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#clients_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });
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


    $('#crx-hero-sign-up').click(function() {
        window.location.href = "<?php echo base_url('creditheroscore/sign-up'); ?>";
    });
    $('#navigation_video').click(function() {
        $('#progressModal').modal('show');
    });

    $('#digital_signature').click(function() {
        $('#signatureModal').modal('show');
    });

    $('#photo_id').click(function() {
        $('#upload_photo_modal').modal('show');
    });

    $('#address_proof').click(function() {
        $('#address_proof_modal').modal('show');
    });

    function open_address_popup() {
        $('#address_photo').trigger('click');
    }

    function open_photo_popup() {
        $('#photo_upload').trigger('click');
    }

    $("#photo_upload").change(function() {
        readURL_photo(this);
    });

    $("#address_photo").change(function() {
        readURL_address(this);
    });

    function readURL_photo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#photo_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL_address(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#address_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
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

    $('#save_photo_id').on('click', function(e) {
        e.preventDefault(); // Prevent form submission

        let photo_upload = $("#photo_upload")[0].files[0];

        let isValid = true;

        if (!photo_upload) {
            $('#photo_upload').removeClass('is-valid').addClass('is-invalid');
            isValid = false;
        } else {
            $('#photo_upload').removeClass('is-invalid').addClass('is-valid');
        }

        let formData = new FormData();
        formData.append('photo_upload', photo_upload);

        $.ajax({
            url: '<?php echo base_url('client/save_photo_id'); ?>',
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire(
                        'Success!',
                        'Photo saved successfully.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    $('#photo_upload').removeClass('is-valid').addClass('is-invalid');
                    Swal.fire(
                        'Error!',
                        res.message,
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
    });

    $('#save_address').on('click', function(e) {
        e.preventDefault(); // Prevent form submission

        let address_photo = $("#address_photo")[0].files[0];

        let isValid = true;

        if (!address_photo) {
            $('#address_photo').removeClass('is-valid').addClass('is-invalid');
            isValid = false;
        } else {
            $('#address_photo').removeClass('is-invalid').addClass('is-valid');
        }

        let formData = new FormData();
        formData.append('address_photo', address_photo);

        $.ajax({
            url: '<?php echo base_url('client/save_address_photo'); ?>',
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire(
                        'Success!',
                        'Address saved successfully.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    $('#address_photo').removeClass('is-valid').addClass('is-invalid');
                    Swal.fire(
                        'Error!',
                        res.message,
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
    });
</script>

<script>
    $(document).ready(function() {
        // Get the last shown time from localStorage
        const lastShownTime = localStorage.getItem('progressModalLastShown');
        const currentTime = new Date().getTime();
        const twentyFourHours = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

        // Check if the modal was shown more than 24 hours ago or if it's the first time
        if (!lastShownTime || (currentTime - lastShownTime > twentyFourHours)) {
            // Show the modal
            $('#progressModal').modal('show');

            // Update the timestamp in localStorage
            localStorage.setItem('progressModalLastShown', currentTime);
        }
    });

    let currentStep = 1;

    function nextStep(step) {
        document.getElementById(`stepContent${currentStep}`).style.display = 'none';
        document.getElementById(`stepContent${step}`).style.display = 'block';
        currentStep = step;
        updateProgressBar(step);
        adjustModalSize(step);
    }

    function previousStep(step) {
        document.getElementById(`stepContent${currentStep}`).style.display = 'none';
        document.getElementById(`stepContent${step}`).style.display = 'block';
        currentStep = step;
        updateProgressBar(step);
        adjustModalSize(step);
    }

    function updateProgressBar(step) {
        const progressValues = {
            1: 33,
            2: 66,
            3: 100
        };
        const progress = progressValues[step];
        const progressBar = document.getElementById('progressBar');
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
        progressBar.innerText = `${progress}%`;
    }

    function adjustModalSize(step) {
        const modalDialog = document.getElementById('modalDialog');
        modalDialog.classList.remove('modal-md-custom', 'modal-xl');
        if (step === 1) {
            modalDialog.classList.add('modal-md-custom');
        } else {
            modalDialog.classList.add('modal-xl');
        }
    }

    $(document).ready(function() {
        currentStep = 1;
        document.getElementById('stepContent1').style.display = 'block';
        document.getElementById('stepContent2').style.display = 'none';
        // document.getElementById('stepContent3').style.display = 'none';
        updateProgressBar(1);
        adjustModalSize(1);
    });
</script>

<?php
$current_year = date('Y');
$monthly_scores = [];

// Initialize months
for ($i = 1; $i <= 12; $i++) {
    $monthly_scores[$i] = ['count' => 0, 'total_score' => 0];
}

foreach ($result as $value) {
    $scores = unserialize($value->scores);
    foreach ($scores as $score_record) {
        $added_date = $score_record['added_date'];
        $date = new DateTime($added_date);
        $year = $date->format('Y');
        $month = $date->format('n'); // Month number (1-12)

        if ($year == $current_year) {
            $efx = $score_record['providers']['EFX'] ?? 0;
            $exp = $score_record['providers']['EXP'] ?? 0;
            $tu = $score_record['providers']['TU'] ?? 0;

            $average_score = ($efx + $exp + $tu) / 3;

            $monthly_scores[$month]['count']++;
            $monthly_scores[$month]['total_score'] += $average_score;
        }
    }
}

// Prepare data for chart
$chart_data = [];
$month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

foreach ($monthly_scores as $month => $scores) {
    if ($scores['count'] > 0) {
        $average = $scores['total_score'] / $scores['count'];
        $chart_data[] = [
            'month' => $month_names[$month - 1] . " " . $current_year,
            'avg' => round($average)
        ];
    }
}
?>
<script>
    var chartData = <?php echo json_encode($chart_data); ?>;
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define score range colors
        const colors = {
            poor: '#FF0000',
            fair: '#FFA500',
            good: '#FFFF00',
            excellent: '#00FF00'
        };

        const getColor = (score) => {
            if (score < 580) return colors.poor;
            if (score < 670) return colors.fair;
            if (score < 740) return colors.good;
            return colors.excellent;
        };

        // Extract data for chart
        const categories = chartData.map(data => data.month);
        const avgData = chartData.map(data => ({
            y: data.avg,
            color: getColor(data.avg)
        }));

        // Create the chart
        Highcharts.chart('range_chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Average Credit Scores - <?php echo $current_year; ?>'
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'Months'
                }
            },
            yAxis: {
                min: 300,
                max: 900,
                tickInterval: 100,
                title: {
                    text: 'Scores'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b>{point.y}</b>'
            },
            series: [{
                name: 'Average Score',
                data: avgData,
                showInLegend: false
            }]
        });
    });
</script>