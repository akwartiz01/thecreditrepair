<?php
$isSuperUser = $this->session->userdata('user_type') == 'super';

$client_status = $this->config->item('client_status_subscriber');

$name = $isSuperUser ? 'Sample Client' : trim(($getClient[0]->sq_first_name ?? '') . ' ' . ($getClient[0]->sq_last_name ?? ''));


// Initialize variables with default values to avoid undefined warnings
$client_agreement = $client_sign = $client_photo = $client_address = $digital_signature = '';
$sq_status = '';
$sq_referred_by = '';
$security_code=$getClient[0]->security_code;
// Process client documents
foreach ($client_document as $value) {
    switch ($value->document_type) {
        case 'agreement':
            $client_agreement = $value->document_type;
            $client_sign = $value->document_path;
            $client_agreement_pdf = $value->agreement_pdf;
            break;
        case 'photo_id':
            $client_photo = $value->document_path;
            break;
        case 'address_photo':
            $client_address = $value->document_path;
            break;
        case 'digital_signature':
            $digital_signature = $value->document_path;
            break;
    }
}

// Process client status
$sq_status = $client_status[$getClient[0]->sq_status] ?? '';
$sq_status = ($sq_status === 'Select One') ? '' : $sq_status;

// Process affiliates
foreach ($sq_affiliates as $a_value) {
    if ($getClient[0]->sq_referred_by == $a_value->sq_affiliates_id) {
        $affiliates_f_name = $a_value->sq_affiliates_first_name ?? '';
        $affiliates_l_name = $a_value->sq_affiliates_last_name ?? '';
        $sq_referred_by = trim("$affiliates_f_name $affiliates_l_name");
        break; // Exit loop once the referred affiliate is found
    }
}

?>

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
                            <h3 class="margin-top-0 mb-font-20">Welcome <?php echo $name; ?>!</h3>
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
                                    <input type="checkbox" <?php echo (!empty($digital_signature)) ? 'checked' : ''; ?>>
                                    Setup Digital Signature
                                    <a class="btn btn-success btn-sm <?php echo (!empty($digital_signature)) ? 'disabled' : ''; ?>" id="digital_signature" <?php echo (!empty($digital_signature)) ? 'aria-disabled="true"' : ''; ?>>Complete Now</a>
                                </label>
                            </div>
                            <div class="step-item">
                                <label class="mt-checkbox mt-checkbox-outline homepagesteps">
                                    <input type="checkbox" <?php echo (!empty($client_photo)) ? 'checked' : ''; ?>>
                                    Upload Photo ID
                                    <a class="btn btn-success btn-sm <?php echo (!empty($client_photo)) ? 'disabled' : ''; ?>" id="photo_id" <?php echo (!empty($client_photo)) ? 'aria-disabled="true"' : ''; ?>>Complete Now</a>
                                </label>
                            </div>
                            <div class="step-item">
                                <label class="mt-checkbox mt-checkbox-outline homepagesteps">
                                    <input type="checkbox" <?php echo (!empty($client_address)) ? 'checked' : ''; ?>>
                                    Upload Proof of Address
                                    <a class="btn btn-success btn-sm <?php echo (!empty($client_address)) ? 'disabled' : ''; ?>" id="address_proof" <?php echo (!empty($client_address)) ? 'aria-disabled="true"' : ''; ?>>Complete Now</a>
                                </label>
                            </div>
                        </div>

                        <?php if ($this->session->userdata('user_type') != 'super'): ?>
                        <?php endif; ?>
                        <button class="btn btn-primary" id="openPrintPreview" data-toggle="modal" data-target="#printModal" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>View Agreement</button>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
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
                                            <img class="img-responsive img-rounded client-image" src="<?php echo isset($getClient[0]->profile_img) ? $getClient[0]->profile_img : base_url('assets/img/user.jpg'); ?>" alt="Client Image">
                                        </div>
                                        <div class="col-sm-8 col-xs-8">
                                            <span class="client-name font-dgrey"><?php echo $name; ?></span>
                                            <?php
                                            $clientEmail = $isSuperUser ? 'Sample@client.com' : (isset($getClient) ? $getClient[0]->sq_email : '');
                                            $referredBy = $isSuperUser ? 'Sample Affiliate' : (!empty($sq_referred_by) ? $sq_referred_by : '---');
                                            $status = $isSuperUser ? 'Client' : (isset($sq_status) ? $sq_status : '');
                                            ?>

                                            <span class="client-email"><?php echo $clientEmail; ?></span>
                                            <span class="client-referred-by">Referred By : <?php echo $referredBy; ?></span>
                                            <span class="client-status">Status : <b><span style="color: green;"><?php echo $status; ?></span></b></span>
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
                                    <?php
                                    if ($this->session->userdata('user_type') == 'super') {
                                        // Generate 5 test entries with different months for super user
                                        $result = [];
                                        for ($i = 1; $i <= 12; $i++) {
                                            $result[] = (object)[
                                                'scores' => serialize([
                                                    [
                                                        'added_date' => date('Y-m-d', strtotime("-$i month")),
                                                        'providers' => [
                                                            'EFX' => rand(300, 850), // Random score for Equifax
                                                            'EXP' => rand(300, 850), // Random score for Experian
                                                            'TU' => rand(300, 850),  // Random score for TransUnion
                                                        ]
                                                    ]
                                                ])
                                            ];
                                        }
                                    }
                                    ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-light center">
                                        <thead>
                                            <tr class="uppercase">
                                                <th class='text-center'> &nbsp;</th>
                                                <th class='text-center'>
                                                    <img class="" alt="" src="<?php echo base_url(); ?>assets/crx/equifax.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                </th>
                                                <th class='text-center'>
                                                    <img class="" alt="" src="<?php echo base_url(); ?>assets/crx/experian.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                </th>
                                                <th class='text-center'>
                                                    <img class="" alt="" src="<?php echo base_url(); ?>assets/crx/trans_union.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $value): ?>
                                                <?php
                                                $scores = unserialize($value->scores);

                                                foreach ($scores as $score_record):
                                                ?>
                                                    <tr>
                                                        <td class='text-center'><?php echo htmlspecialchars($score_record['added_date']); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($score_record['providers']['EFX'] ?? 'N/A'); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($score_record['providers']['EXP'] ?? 'N/A'); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($score_record['providers']['TU'] ?? 'N/A'); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                    <div id="range_chart">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="client-header bg-grey text-white p-2">
                                    <span class="caption-subject font-dgrey bold uppercase">Dispute Status</span>
                                </div>

                                <div class="portlet-body m-t-0">
                                    <div class="row m-t-0">
                                        <div class="margin-bottom-10 visible-sm "></div>
                                        <div class="col-md-8 w-100">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-light dipute">
                                                    <thead>
                                                        <tr class="uppercase">
                                                            <th class="text-left"> Status </th>
                                                            <th width="22%" align="center" valign="middle">
                                                                <img class="" alt="" src="<?php echo base_url(); ?>assets/crx/equifax.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                            </th>
                                                            <th width="22%" align="center" valign="middle">
                                                                <img class="" alt="" src="<?php echo base_url(); ?>assets/crx/experian.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                            </th>
                                                            <th width="22%" align="center" valign="middle">
                                                                <img class="" alt="" src="<?php echo base_url(); ?>assets/crx/trans_union.png" style="height:16px;width: 63px;vertical-align:middle;display: inline-block !important;">
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num8">Unspecified</td>
                                                            <td align="center" valign="top" class="num8">0</td>
                                                            <td align="center" valign="top" class="num8">0</td>
                                                            <td align="center" valign="top" class="num8">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num1">Positive</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num1">Deleted</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num1">Repaired</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num1">Updated</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                            <td align="center" valign="top" class="num1">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num4">In Dispute</td>
                                                            <td align="center" valign="top" class="num4">0</td>
                                                            <td align="center" valign="top" class="num4">0</td>
                                                            <td align="center" valign="top" class="num4">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num6">Verified</td>
                                                            <td align="center" valign="top" class="num6">0</td>
                                                            <td align="center" valign="top" class="num6">0</td>
                                                            <td align="center" valign="top" class="num6">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="32" align="left" valign="top" class="num6">Negative</td>
                                                            <td align="center" valign="top" class="num6">0</td>
                                                            <td align="center" valign="top" class="num6">0</td>
                                                            <td align="center" valign="top" class="num6">0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6 chart-skill m-t-30">
                                            <div id="chartdiv"><img class="img-responsive" src="<?php echo base_url(); ?>assets/crx/no_piechart.jpg" style="vertical-align:middle; padding-left:3px;  padding-top:25px; padding-bottom:25px;"></div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="skillbar dispute-status-skill-bar" data-percent="0">
                                                        <p class="skillbar-bar" style="background: rgb(60, 204, 20); overflow: hidden; width: 0%;"></p>
                                                        <div class="skill-bar-dispute-status">
                                                            Progress: <span class="skill-bar-percent">0%</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="margin-bottom-10 visible-sm"></div>
                                        <div class="actions">
                                        </div>
                                    </div>
                                    <div class="detailed margin-top-20">
                                        <a class="btn btn-info btn-block" href="">See Detailed View </a>

                                    </div>
                                    <div class="padding-top-10 client-options">
                                        <a class="font-green" href="<?php echo base_url('client/saved_letters'); ?>" id="my_save_letter_pp">Client's Saved Letters</a>

                                        <div class="modal fade in" id="agreement" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 17px;">
                                            <div class="modal-dialog">
                                                <div class="modal-content popup-btn" style="height: auto !important;">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" onclick="$('#agreement').hide();" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Sign Agreement</h4>
                                                    </div>
                                                    <div class="modal-body" id="agreement_details" style="height: auto !important;">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success ok-btn" onclick="$('#agreement').hide();" data-dismiss="modal">Ok
                                                        </button>
                                                        <button id="btnprint" name="btnprint" type="button" value="Print" class="btn btn-success" style="margin-top: 0 !important;" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>Print</button>
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
            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3972FC; color:white;">
                <h5 class="modal-title" id="signatureModalLabel">Choose a Signature Style</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body" style="max-height: 500px !important;">
                <p>To challenge negative items on your report, we will send carefully drafted letters to creditors and credit bureaus on your behalf.</p>
                <p>Enter your full name as it should appear in your signature</p>

                <input type="text" id="name-input" placeholder="Enter your name" class="form-control mb-3">


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
            </div>
            <div class="modal-footer">

                <form action="" method="post" id="signature-style-form">
                    <input type="hidden" name="name" id="name-hidden">
                    <input type="hidden" name="font" id="font-hidden">
                    <button type="submit" class="btn btn-primary" id="save_digital_signature" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>Save Signature</button>
                </form>
            </div>
        </div>
    </div>


</div>

<div class="modal fade" id="upload_photo_modal" tabindex="-1" role="dialog" aria-labelledby="upload_photo_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3972FC; color:white;">
                <h5 class="modal-title" id="upload_photo_modalLabel">Upload Photo ID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="" method="post" id="photo_form">
                <div class="modal-body">
                    <p>If you like, you can take a photo of these with your phone and upload it here.</p>
                    <div class="row">
                        <div class="col-7">

                            <p>This can be a:</p>
                            <ul>
                                <li>Driver's license</li>
                                <li>State ID card</li>
                                <li>Other government issued photo ID card</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <?php $client_image = base_url('assets/img/client-license-en.png'); ?>
                            <img class="rounded-circle" src="<?php echo $client_image; ?>" width="100" height="100" class="profile-img avatar-view-img" id="photo_img" onclick="open_photo_popup();" style="width: auto !important; border-radius:0px !important;">

                            <input type="file" name="photo_file" id="photo_upload" style="display:none">

                        </div>
                    </div>

                    <div class="row" style="text-align: center !important;">
                        <div class="col-12">
                            <button type="button" class="btn btn-success" style="background-color: #16ad00 !important;" onclick="open_photo_popup();">Upload image using computer</button>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save_photo_id" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>Save Photo</button>
                </div>
            </form>
        </div>
    </div>

</div>

<div class="modal fade" id="address_proof_modal" tabindex="-1" role="dialog" aria-labelledby="address_proof_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3972FC; color:white;">
                <h5 class="modal-title" id="address_proof_modalLabel">Upload Proof of Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="" method="post" id="address_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-7">
                            <p>If you like, you can take a photo of these with your phone and upload it here.</p>

                            <p>This can be a:</p>
                            <ul>
                                <li>Utility bill</li>
                                <li>Bank statement</li>
                                <li>Insurance statement</li>
                                <li>Something official addressed to you at the address you've given us.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <?php $client_image = base_url('assets/img/proof_add.png'); ?>
                            <img class="rounded-circle" src="<?php echo $client_image; ?>" width="100" height="100" class="profile-img avatar-view-img" id="address_img" onclick="open_address_popup();" style="width: auto !important; border-radius:0px !important; height:180px !important;">

                            <input type="file" name="address_file" id="address_photo" style="display:none">

                        </div>
                    </div>

                    <div class="row" style="text-align: center !important;">
                        <div class="col-12">
                            <button type="button" class="btn btn-success" style="background-color: #16ad00 !important;" onclick="open_address_popup();">Upload image using computer</button>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary" id="save_address" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Print Modal s -->
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
                    <div><?= $agreement_text ?></div>

                    <div class="signature-box" id="client_signature">
                        <canvas id="signature-pad" class="signature-pad" width="600" height="200"></canvas>
                    </div>

                    <p>Name: <span id="modal-name"><?php echo $name; ?></span></p>
                    <p>Date: <span id="modal-date"><?php echo $getClient[0]->agreement_sign_date; ?></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
                 <button type="button" class="btn btn-primary print_button" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>Print</button>
            </div>
        </div>
    
    </div>
</div>
<!-- Print Modal e -->

<!-- The Navigation Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel" aria-hidden="true">
    <div id="modalDialog" class="modal-dialog modal-md-custom" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <div class="col-2">
                    <h5 class="modal-title" id="progressModalLabel">Progress</h5>
                </div>
                <div class="col-8">
                    <!-- Progress Bar -->
                    <div class="progress mt-2">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="close" style="color: white !important;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <!-- Step 1 Content -->
                <div id="stepContent1" class="step-content">
                    <h4 class="main-heading"><?php echo $name; ?>, Welcome to your Client Portal</h4>
                    <p>You can login 24/7 to see the live status of our progress, to communicate and exchange documents securely.</p>
                    <p>Here's a quick video to show you our process:</p>

                    <!-- Embed Video -->
                    <div class="embed-responsive embed-responsive-16by9 mb-3">
                        <!--<iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/sy41imOrHbg?rel=0&showinfo=0" allowfullscreen></iframe>-->
                    <iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/e79sjCsS9pw?rel=0&showinfo=0" allowfullscreen></iframe>

                    </div>

                    <p>So are we ready to get started? Great, let's go!</p>
                    <div class="text-right">
                        <button type="button" class="btn btn-success" onclick="nextStep(2)">Continue</button>
                    </div>
                </div>

                <!-- Step 2 Content -->
                <div id="stepContent2" class="step-content">
                    <div class="row">
                        <div class="col-5">
                            <h4>Let's Get Your Reports And Scores!</h4>
                            <p><strong>What is Credit Monitoring?</strong></p>
                            <p>Instant access to all 3 credit reports and scores, as well as tools to monitor and safeguard your identity...</p>
                            <p><strong>Why Do I Need It?</strong></p>
                            <p>Credit Monitoring is essential for credit repair because it's the only way to see real-time changes to your reports and scores directly from all 3 bureaus.</p>
                        </div>
                        <div class="col-7 text-center">
                            <img style="height: 250px !important;" src="<?php echo base_url(); ?>assets/crx/reports-scores-bg.png" alt="">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" onclick="previousStep(1)">Back</button>
                        <!-- <button type="button" class="btn btn-success" onclick="nextStep(3)">Ok, Ready To Set Up!</button> -->
                        <button type="button" class="btn btn-success" id="crx-hero-sign-up" <?php echo ($this->session->userdata('user_type') == 'super') ? 'disabled' : ''; ?>>Ok, Ready To Set Up!</button>
                    </div>
                </div>

                <!-- Step 3 Content -->
                <!-- <div id="stepContent3" class="step-content">
                    <h4>Final Step</h4>
                    <p>You're all set to begin! Ready to get started?</p>
                    <div class="text-right">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Finish</button>
                        <button type="button" class="btn btn-secondary" onclick="previousStep(2)">Back</button>
                    </div>
                </div> -->
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
         let security_code = "<?= $security_code ?>";
        window.location.href = "https://crxhero.com/sign-up?referral_code=" + security_code;
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
   $("body").on("click", ".print_button", function() {
        var prtContent = document.getElementById("print-content");
        var style = document.getElementById("sqhead");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=570,toolbar=0,scrollbars=0,status=0');

        WinPrint.document.write(style.innerHTML + '<style>.ptbtn{display:none !important;}</style> ' + prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.onafterprint = function() {
          WinPrint.close();
        }
      });

//   function printDiv(divId) {
//             const divToPrint = document.getElementById(divId);

//             if (!divToPrint) {
//                 alert("Print content not found!");
//                 return;
//             }

//             const originalContents = document.body.innerHTML;
//             document.body.innerHTML = divToPrint.outerHTML;  // Only the content of the selected div

//             window.print();

//             document.body.innerHTML = originalContents;  // Restore original content after printing
//         }

</script>

