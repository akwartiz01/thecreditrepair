<?php
$client_status = $this->config->item('client_status');
$client_days_opt = $this->config->item('client_days_opt');
$disabled = '';
if (empty($fetchClientinfo[0]->crx_hero_userId)) {
  $crxdisabled = 'disabled';
}

if (!empty($fetchClientinfo[0]->crx_hero_userId)) {
  $crxInviteNone = 'd-none';
}
if (empty($fetchClientinfo[0]->agreement_signed)) {
  $agreementdisabled = 'disabled';
}


// Initialize variables with default values to avoid undefined warnings
$client_agreement = $client_sign = $client_photo = $client_address = $digital_signature = '';

// Process client documents
foreach ($client_document as $value) {
  switch ($value->document_type) {
    case 'agreement':
      $client_agreement = $value->document_type;
      $client_sign = $value->document_path;
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

?>
<!-- Signature pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<style>
  a#advance,
  #advanceremove {
    color: #ed1c24;
    margin-bottom: 16px;
    float: left;
  }
.css-13ia1ff {
    margin: 0px 0px 0.35em 2px;
    font-family: Latofont, sans-serif;
    line-height: 1.6;
    letter-spacing: 0.0075em;
    font-size: 14px;
    font-weight: 700;
}
  .board-wrapper2 .board-portlet {
    min-width: 345px;
    width: 103%;

  }

  .board-wrapper2 .portlet-card-list {
    padding-left: 0;
    list-style: none;
    min-height: 70px;
  }

  .board-wrapper2 .portlet-card .progress {
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    border-radius: 6px 6px 0px 0px;
    height: 4px;
  }

  #teamalltasks .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  .board-wrapper2 .portlet-card {
    width: 100%;
    border-radius: 4px;
    padding: 20px 20px 20px 20px;
    background: #fff;
    display: grid;
    grid-template-rows: 5;
    grid-template-columns: 2;
    border-radius: 6px;
    position: relative;
    margin-bottom: 15px;
    cursor: -webkit-grab;
    cursor: grab;
  }

  .liste {
    float: left;
    margin-bottom: 0px;
    width: 100%;
    cursor: pointer;
    padding: 5px 0px;
    background: none;
    border: 0;
  }

  .page-title .page-title-icon {
    display: inline-block;
    width: 29px;
    height: 30px;
    float: left;

  }

  .liste h3 {
    font-size: 13px;
    font-weight: 200;
    line-height: 17px;
  }

  .page-title .page-title-icon i {

    line-height: 30px;
  }

  .simple p {
    padding-bottom: 0 !important;
    margin-bottom: 5px;
    color: #8c8c8c;
    font-size: 14px;
  }

  .simple p a,
  h3.page-title a {
    color: red;
  }

  .mttabs .tab-content {
    border: 0px solid #ebedf2 !important;
    border-top: 0 !important;
    padding: 0 !important;
    text-align: justify !important;
  }

  .mttabs li.nav-item {
    width: 50%;
    border: 0 !important;
  }

  .mttabs li .nav-tabs .nav-link {
    background: #f4eff5;
    color: #000000;
    border-radius: 0;
    border: 1px solid #ffffff;
    padding: .25rem 1.5rem;
    text-align: center;
    font-weight: 600;
  }

  .mttabs a.nav-link.active {
    background: #ffffff !important;
  }

  hr {
    margin: 5px 0px 12px !important;
  }

  a.lft {
    float: left;
    color: #ed1c24;
  }

  a.rit {
    float: right;
    color: #ed1c24;
  }

  .media.flx {
    display: block;
  }

  .form-group label {
    font-size: 0.875rem;
    line-height: 18px;
    vertical-align: top;
    margin-bottom: .1rem;
    padding: 0px 0 4px 0;
  }

  .buttons button.btn {
    width: 100%;
    margin-top: 11px;
  }

  .btn-success:hover {

    background-color: #ed1c24;
    border-color: #ed1c24;
  }

  .jsgrid img {
    width: 100% !important;
    height: auto !important;
  }

  .gridheader {
    background: #f2f2f2;
    font-weight: 400;
    color: #333;
    line-height: 20px;
    font-size: 12px;
    height: 25px;
    padding: 2px 2px 2px 5px;
    letter-spacing: 1px;
  }

  .list-wrapper ul li {
    font-size: .9375rem;
    padding: .2rem 0 !important;
    border-bottom: 0px !important;
  }

  #addeditscore .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  #addeditscore .table td,
  .table th {
    padding: 0.3375rem !important;
  }

  #addeditscore .modal-dialog .modal-content .modal-header {
    padding: 14px 26px;
  }

  #ClientCompletetasks .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  #spouseModal .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  #Customizelist .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  #Customizelist .table td {
    padding: 0.3375rem !important;
    white-space: normal !important;
  }

  table#docutab td {
    padding: 0.3375rem !important;
  }


  #ClientCompletetasks .table td {
    padding: 0.3375rem !important;
    white-space: normal !important;
  }

  .num8 {
    color: #00b0dc;
  }

  .num1,
  .num2,
  .num3 {
    color: #090;
  }

  .num4 {
    color: #f60;
  }

  .num5,
  .num6 {
    color: red;
  }

  .num7 {
    color: #000;
  }

  .dropdown-item {
    display: block;
    width: 100%;
    padding: 0.10rem 1.5rem;
    clear: both;
    font-weight: 400;
    font-size: 14px;
    color: #343a40;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
  }

  @media screen and (max-width: 767px) {
    #TaskModal .modal-dialog {
      max-width: 100% !important;
    }

    #addeditscore .modal-dialog {
      max-width: 100% !important;
    }

    #ScorebarChart {
      width: 100%;
    }

    #clientdoughnutChart {
      width: 100%;
    }
  }


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

  style attribute {
    margin-left: 10px;
    text-transform: none;
    border: 2px solid rgb(102, 102, 102);
    color: rgb(102, 102, 102);
    font-weight: 600;
    width: max-content;
    display: flex;
  }

  .btn-secondary.navigation_btns {
    color: #3972fc !important;
    background: white !important;
    /* border: 1px solid #3972fc !important; */
    border: none;
    text-decoration: underline;
    padding: 10px 10px !important;
    width: fit-content !important;
    font-size: 14px !important;
    font-family: Arial, Helvetica, sans-serif !important;
  }

  .btns-outline-success {
    color: #198754 !important;
    border-color: #198754 !important;
    border-radius: 20px;
    padding: 4px 10px;
    width: fit-content;

  }

  .btns-outline-success:hover {
    background-color: #fff !important;
    opacity: 0.8 !important;
  }


  .btns-outline-successs.navigation_btn {
    color: #198754 !important;
    border-color: #198754 !important;
    background: white !important;
    /* border: 1px solid #3972fc !important; */
    padding: 10px!important;
    width: fit-content !important;
    font-size: 15px !important;
    font-family: Arial, Helvetica, sans-serif !important;
  }

  .btns-outlines-successs {
    color: #fff !important;
    background: #198754 !important;
    border: 1px solid #198754 !important;
    padding: 10px !important;
    width: fit-content !important;
    font-size: 15px !important;
    font-family: Arial, Helvetica, sans-serif !important;
  }

  .btns-outlines-successs:hover {
    background-color: #fff !important;
    color: #198754 !important;

  }

  .btns-outline-successs:hover {
    background-color: #198754 !important;
    color: #fff !important;

  }

  .btn-secondary.navigation_btn:hover {

    background-color: #3972fc !important;
    color: white !important;
    border: 1px solid #3972fc !important;
  }

  .navigation_btn.disabled {
    pointer-events: none;
    cursor: default;
  }

  /* agreement css s  */

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

  .agreement_heading {
    font-size: 24px !important;
    font-weight: 300 !important;
    border-bottom: 1px solid #e7ecf1 !important;
    padding-bottom: 5px !important;
  }

  /* agreement css e */

  div#print-content {
    padding: 16px !important;
    color: rgb(74, 74, 74) !important;
    border: 1px solid rgb(221, 219, 218) !important;
    background: rgb(243, 243, 243) !important;
  }

  div#print-content * {
    background-color: rgb(243, 243, 243) !important;
    font-family: 'Segoe UI', sans-serif !important;
    color: black !important;
  }

  div#print-content span,
  p {
    font-size: 16px !important;
  }

  h5#printModalLabel {
    font-family: Latofont, sans-serif !important;
    font-weight: 400 !important;
    font-size: 20px !important;
  }

  div#printModal .modal-body {
    max-height: 450px !important;
  }

  div#printModal .modal-footer .btn-danger {
    background-color: white !important;
    color: #dc3545 !important;
    border-color: #dc3545 !important;
  }

  div#printModal .modal-footer .btn-primary {
    background-color: white !important;
    color: #28a745 !important;
    border-color: #28a745 !important;
  }

  div#printModal .modal-footer .btn-secondary {
    background-color: white !important;
    color: #28a745 !important;
    border-color: #28a745 !important;
  }

  div#printModal .modal-footer .btn-danger:hover {
    background-color: #dc3545 !important;
    color: white !important;
    border-color: #dc3545 !important;
  }

  div#printModal .modal-footer .btn-primary:hover {
    background-color: #28a745 !important;
    color: white !important;
    border-color: #28a745 !important;
  }

  div#printModal .modal-footer .btn-secondary:hover {
    background-color: #28a745 !important;
    color: white !important;
    border-color: #28a745 !important;
  }

  .btns-outline-success {
    color: #198754 !important;
    border-color: #198754 !important;
    border-radius: 20px;
    padding: 4px 10px;
    width: fit-content;

  }

  .btns-outline-success:hover {
    background-color: #fff !important;
    opacity: 0.8 !important;
  }

  #client_info span.mdi-email {
    font-size: 20px !important;
    color: rgb(176, 173, 171) !important;
  }

  .tox.tox-tinymce {
    width: 100% !important;
    height: 300px !important;
  }

  .clientNotes {
    font-size: 14px !important;
    font-weight: 700 !important;
    padding: 16px;
    margin-bottom: 16px;
    background-color: rgb(255, 253, 245);
    border: 1px solid rgb(222, 222, 222);
    color: rgb(74, 74, 74) !important;
  }

  .clientNotes span {
    font-family: Latofont, sans-serif !important;
    font-size: 13px !important;
    color: rgb(102, 102, 102) !important;
  }

  .client_nt .btn-outline-dark {
    padding: 10px 15px !important;
    color: #6c757d !important;
    background-color: transparent !important;
    background-image: none !important;
    border-color: #6c757d !important;
  }

  .client_nt .btn-outline-dark:hover {
    padding: 10px 15px !important;
    color: #fff !important;
    background-color: #6c757d !important;
    border-color: #6c757d !important;
  }

  .client_nt .btn-outline-dark.active {
    padding: 10px 15px !important;
    color: #fff !important;
    background-color: #6c757d !important;
    border-color: #6c757d !important;
  }

  .client_nt .btn-primary {
    padding: 11px 30px !important;
    color: #fff !important;
    background-color: rgb(0, 92, 179) !important;
    border-color: rgb(0, 92, 179) !important;
  }

  .client_nt .btn-primary:hover {
    padding: 11px 30px !important;
    color: #fff !important;
    background-color: rgb(36, 72, 148) !important;
    border-color: rgb(36, 72, 148) !important;
  }
</style>

<style>
  #loader_audit {
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
  }
.numspam{
        border-radius: 50%;
    background: #0075cc;
    padding: 2px;
    color: #fff;
    width: 15px;
    height: 15px;
    font-size: 11px !important;
}
}

</style>

<div id="msgAppend11task"></div>

<?php if ($this->session->flashdata('success') || $this->session->flashdata('error')) { ?>
  <script>
    Swal.fire({
      icon: '<?php echo $this->session->flashdata("success") ? "success" : "error"; ?>',
      title: '<?php echo $this->session->flashdata("success") ? "Success" : "Error!"; ?>',
      text: '<?php echo addslashes($this->session->flashdata("success") ?: $this->session->flashdata("error")); ?>',
      confirmButtonText: 'Close',
      customClass: {
        confirmButton: 'btn btn-primary'
      },
      buttonsStyling: false
    });
  </script>
<?php } ?>


<div class="container-fluid page-body-wrapper">
  <div class="main-panel pnel">
    <div class="content-wrapper">
        
<div class="step-navigation border rounded-lg p-2 px-3 mb-3">
  <div class="d-flex flex-wrap justify-content-center gap-2">

    <a href="<?= base_url(); ?>dashboard/<?= get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>" class="step-link active">
      Dashboard
    </a>

    <a href="<?= base_url(); ?>import_audit/<?= get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">1</span> Import / Audit
    </a>

    <a href="<?= base_url(); ?>pending_report/<?= get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">2</span> Tag Pending Report
    </a>

    <a href="<?= base_url(); ?>generate-letters/<?= get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">3</span> Generate Letters
    </a>

    <a href="<?= base_url(); ?>send_letter/<?= get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">4</span> Send Letters
    </a>

    <a href="<?= base_url('letters-status/' . get_encoded_id($fetchClientinfo[0]->sq_client_id)); ?>" class="step-link">
      Letters & Status
    </a>

    <a href="<?= base_url('dispute_items/' . get_encoded_id($fetchClientinfo[0]->sq_client_id)); ?>" class="step-link">
      Dispute Items
    </a>

    <a href="<?= base_url('messages/send/' . get_encoded_id($fetchClientinfo[0]->sq_client_id)); ?>" class="step-link">
      Messages
    </a>

  </div>
</div>
 

        <div class="row">
          <div class="col-md-12 mt-2">
            <div class="card w-100">
              <div class="progress" style="height: 4px !important;">
                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" styl></div>
              </div>
              <div class="card-body">

                <h4 class="task-title2"><?php echo isset($fetchClientinfo) ? $fetchClientinfo[0]->sq_first_name . ' ' . $fetchClientinfo[0]->sq_last_name : ''; ?> </h4>
                <hr>
                <span id="client_info">
                  <?php if (isset($client_status[$fetchClientinfo[0]->sq_status])):
                    $client_status =  $client_status[$fetchClientinfo[0]->sq_status];
                  endif; ?>

                  <button class="btn btn-sm btns-outline-success"><?php echo $client_status; ?></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="mdi mdi-email"></span>&nbsp;&nbsp;&nbsp;<a href="mailto:<?php echo isset($fetchClientinfo) ? $fetchClientinfo[0]->sq_email : ''; ?>"><?php echo isset($fetchClientinfo) ? $fetchClientinfo[0]->sq_email : ''; ?></a>
                  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                  <a class="btn btns-outlines-successs navigation_btn " onclick="send_invite(<?php echo $fetchClientinfo[0]->sq_client_id ?>);">Send CRX Hero Invite</a>

                </span>
                <div class="row">
                  <div class="col-md-6 mt-3 navigation_mini" style="padding-left: 0px !important;">

                    <a href="<?php echo base_url(); ?>edit-client/<?php echo base64_encode(base64_encode($fetchClientinfo[0]->sq_client_id)); ?>" class="btn btn-secondary navigation_btns">View/Edit Profile</a>
                    <a class="btn btn-secondary navigation_btns <?php echo $agreementdisabled; ?>" id="openPrintPreview" data-toggle="modal" data-target="#printModal">View Client Aggreement</a>
                    <span class="mdi mdi-lock"></span><a href="<?php echo base_url(); ?>redirectToDashboard/<?php echo $fetchClientinfo[0]->sq_client_id; ?>" class="btn btn-secondary navigation_btns <?php echo $crxdisabled; ?>" target="_blank">View CRX Hero Account</a>

                  </div>

                  <div class="col-md-6 mt-3 navigation_mini" style="padding-left: 0px !important;">

                    <a href="<?php echo base_url(); ?>import_audit/<?php echo get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>" class="mb-3 btn btns-outlines-successs navigation_btn">Import/Audit</a>
                    <a class="btn btns-outline-successs navigation_btn mb-3" id="generate_simple_audit">Generate Simple Audit</a>
                    <a class="btn btns-outline-successs navigation_btn mb-3" href="<?php echo base_url(); ?>send_letter/<?php echo get_encoded_id($fetchClientinfo[0]->sq_client_id); ?>"> Run Dispute Wizard</a>
                    <a href="<?php echo base_url('messages/send/' . get_encoded_id($fetchClientinfo[0]->sq_client_id)); ?>" class="mb-3 btn btns-outline-successs navigation_btn" target="_blank">Send Secure Message</a>
                  </div>
                </div>
                <hr>

                </li>

                </ul>

              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-md-6 mt-2">

            <h4>Scores</h4>
            <div class="card w-100">
              <div class="progress" style="height: 4px !important;">
                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" styl></div>
              </div>
              <div class="card-body">
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
                    <?php foreach ($client_score as $value): ?>
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
            </div>
            <div id="range_chart"></div>
            <br>
            <h4>Dispute Status</h4>
            <div class="card w-100">
              <div class="progress" style="height: 4px !important;">
                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" styl></div>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dipute">
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
                      <td align="center" valign="top" class="num4"><?= $disputestatus[0]->in_dispute_equi; ?></td>
                      <td align="center" valign="top" class="num4"><?= $disputestatus[0]->in_dispute_exper; ?></td>
                      <td align="center" valign="top" class="num4"><?= $disputestatus[0]->in_dispute_tu; ?></td>
                    </tr>
                    <tr>
                      <td height="32" align="left" valign="top" class="num6">Verified</td>
                      <td align="center" valign="top" class="num6">0</td>
                      <td align="center" valign="top" class="num6">0</td>
                      <td align="center" valign="top" class="num6">0</td>
                    </tr>
                    <tr>
                      <td height="32" align="left" valign="top" class="num6">Negative</td>
                      <td align="center" valign="top" class="num7"><?= $negativestatus[0]->negative_equi; ?></td>
                      <td align="center" valign="top" class="num7"><?= $negativestatus[0]->negative_exper; ?></td>
                      <td align="center" valign="top" class="num7"><?= $negativestatus[0]->negative_tu; ?></td>
                    </tr>
                  </tbody>
                </table>
</div>
              </div>
            </div>

            <br>
            <h4>Progress</h4>

            <div class="card-group">
              <div class="card w-100">
                <div class="progress" style="height: 4px !important;">
                  <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" styl></div>
                </div>
                <div class="card-body text-center">

                  <div class="progress-container">
                    <?php


                    $steps = [
                      'login_detail_sent_date' => 'Login Details Sent',
                      'last_login' => 'Last Login',
                      'agreement_signed' => 'Agreement Signed',
                      'crx_hero_userId' => 'Onboarding Completed',
                      'crx_hero_report_path' => 'Report Imported',
                      'letter_saved' => 'Letter Saved'
                    ];

                    $stepCounter = 1;
                    foreach ($steps as $key => $label) {

                      if (isset($progress[$key]) && $progress[$key] != 0 && !empty($progress[$key])) {

                        $isCompleted  = 'completed';
                      } else {
                        $isCompleted = '';
                      }


                    ?>

                      <div class="progress-step <?php echo $isCompleted; ?>">
                        <div class="circle"><?= $isCompleted ? '<i class="mdi mdi-check"></i>' : $stepCounter ?></div>
                        <div class="text"><?= $label ?></div>
                        <?php if ($stepCounter < count($steps)) { ?>
                          <div class="progress-line"></div>
                          <div class="progress-arrow"></div>
                        <?php } ?>
                      </div>
                    <?php
                      $stepCounter++;
                    }

                    ?>

                  </div>

                </div>
              </div>

            </div>
              <?php if ($get_login_user_info->sq_u_profile_picture != '') { ?>
            <h4 class="mt-3">Contacts Assigned</h4>

            <div class="card-group">
              <div class="card w-100">
                <div class="progress" style="height: 4px !important;">
                  <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" styl></div>
                </div>
                <div class="card-body text-center">
                  <p class="card-text">
                    <?php if (isset($get_login_user_info)) { ?>
                  <div class="text-center pb-3">
                    <?php if ($get_login_user_info->sq_u_profile_picture != '') { ?>
                      <img src="<?php echo $get_login_user_info->sq_u_profile_picture; ?>" alt="profile" class="img-lg rounded-circle mb-3 float-left">
                    <?php } else { ?>
                      <img src="<?php echo base_url(); ?>assets/images/faces/face1.jpg" alt="profile" class="img-lg rounded-circle mb-3 float-left">
                    <?php } ?>
                  </div>
                  <br>

                <?php } ?>
                </p>
                <p class="card-text"> <a href="mailto:<?php echo $get_login_user_info->sq_u_email_id; ?>" class="btn btn btns-outlines-successs btn-sm" style="width:25%;">Send E-mail</a></p>
                </div>
              </div>

            </div>
            <?php } ?>
          </div>

          <div class="col-md-6 board-wrapper2">

            <!-- <br> -->

            <!-- <h4>Tasks</h4>
     
          <div class="card w-100">
            <div class="progress" style="height: 4px !important;">
              <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs mttabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="team-tab" data-toggle="tab" href="#team-tasks" role="tab">Team Tasks</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="client-tab" data-toggle="tab" href="#client-tasks" role="tab">Client Tasks</a>
                </li>
              </ul>
              <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="team-tasks" role="tabpanel">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Task</th>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Completed</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      function get_status($due_date, $due_time)
                      {
                        $due_datetime = strtotime("$due_date $due_time");
                        $current_time = time();

                        if ($due_datetime < $current_time) {
                          return '<button class="btn btn-danger btn-sm" style = "background-color:#e4251b !important;border-color:#e4251b;">Overdue</button>';
                        } elseif (date('Y-m-d', $due_datetime) == date('Y-m-d')) {
                          return '<button class="btn btn-success btn-sm" style = "background-color:#00a650 !important;border-color:#00a650;">Due Today</button>';
                        } else {
                          return '<button class="btn btn-warning btn-sm" style = "background-color:#ff9634 !important;border-color:#ff9634;">Upcoming</button>';
                        }
                      }

                      usort($team_member_task, function ($a, $b) {
                        return strtotime($a->due_date . ' ' . $a->due_time) - strtotime($b->due_date . ' ' . $b->due_time);
                      });

                      if (!empty($team_member_task)):
                        foreach ($team_member_task as $task): ?>
                          <tr>
                            <td class="text-center"><?php echo $task->subject; ?></td>
                            <td class="text-center"><?php echo date('M d, Y h:i A', strtotime($task->due_date . ' ' . $task->due_time)); ?></td>
                            <td class="text-center"><?php echo get_status($task->due_date, $task->due_time); ?></td>
                            <td class="text-center">
                              <input type="checkbox" class="task-checkbox" data-id="<?php echo $task->id; ?>" <?php echo ($task->task_status == 'Completed') ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                              <button class="btn btn-sm btn-primary edit-task" data-id="<?php echo $task->id; ?>">Edit</button>
                              <button class="btn btn-sm btn-danger delete-" data-id="<?php echo $task->id; ?>">Delete</button>
                            </td>

                          </tr>
                        <?php endforeach;
                      else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No tasks available</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                  <a href="#" class="rit" onclick="openTaskModal('team');">Add Team Task</a>
                </div>

                <div class="tab-pane fade" id="client-tasks" role="tabpanel">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Task</th>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Completed</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      usort($fetchsq_task, function ($a, $b) {
                        return strtotime($a->due_date . ' ' . $a->due_time) - strtotime($b->due_date . ' ' . $b->due_time);
                      });

                      if (!empty($fetchsq_task)):
                        foreach ($fetchsq_task as $task): ?>
                          <tr>
                            <td class="text-center"><?php echo $task->subject; ?></td>
                            <td class="text-center"><?php echo date('M d, Y h:i A', strtotime($task->due_date . ' ' . $task->due_time)); ?></td>
                            <td class="text-center"><?php echo get_status($task->due_date, $task->due_time); ?></td>
                            <td class="text-center">
                              <input type="checkbox" class="task-checkbox" data-id="<?php echo $task->id; ?>" <?php echo ($task->task_status == 'Completed') ? 'checked' : ''; ?>>
                            </td>
                          </tr>
                        <?php endforeach;
                      else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No tasks available</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                  <a href="#" class="rit" onclick="openTaskModal('client');">Add Client Task</a>
                </div>
              </div>
            </div>
          </div> -->
            <br>

            <h4>Tasks</h4>
            <div class="card w-100">
              <div class="progress" style="height: 4px !important;">
                <div class="progress-bar bg-gradient-primary" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="card-body" style="padding-top: 1.5rem;">
                <div class="row mb-3">
                  <div class="col-12">
                    <button type="button" id="tasksaddEdit" class="btn btn-outline-dark float-right"><i class="mdi mdi-plus"></i> New Tasks</button>
                  </div>
                  <div class="col-12 d-none" id="back_cols">
                    <button type="button" id="back_note" class="btn btn-outline-dark float-right back_note"><i class="mdi mdi-arrow-left"></i> Back</button>
                  </div>
                </div>
                <div class="table-responsive">
 <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th>Task</th>
                        <th>Subject</th>
                        <th>Team Member</th>
                        <th>Due Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($tasks as $task):?>
                         <tr>
                             <td><?= $task->notes ?></td>
                              <td><?= $task->subject ?></td>
                                <td><?= htmlspecialchars($task->team_member_id) ?></td>
                              <td><?= $task->due_date ?></td>
                                <td>
                                      <a title="Delete" class="text-success delete-tasks" data-id="<?= $task->id ?>"style="font-size: large !important; color:#dc3545!important">
                          <i class="mdi mdi-delete"></i>
                        </a>
                        <a title="Edit" class="text-success edit-tasks"   data-id="<?= $task->id ?>"
      data-subject="<?= htmlspecialchars($task->subject) ?>"
      data-type="<?= htmlspecialchars($task->task_type) ?>"
      data-due="<?= $task->due_date ?>"
      data-time="<?= $task->time ?>"
      data-member="<?= htmlspecialchars($task->team_member_id) ?>"
      data-notes="<?= htmlspecialchars($task->notes) ?>" style="font-size: large !important;margin-right: 5px !important; color:#28a745!important">
                          <i class="mdi mdi-pencil"></i>
                        </a>
                                </td>
                         </tr>
                                <?php endforeach; ?>
                        </tbody>
                        </table>
                        </div>

              </div>
            </div>
<br/>
            <h4>Notes</h4>
            <div class="card w-100 client_nt">
              <div class="progress" style="height: 4px !important;">
                <div class="progress-bar bg-gradient-primary" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="card-body" style="padding-top: 1.5rem;">
                <div class="row mb-3">
                  <div class="col-12">
                    <button type="button" id="new_note" class="btn btn-outline-dark float-right"><i class="mdi mdi-plus"></i> New Note</button>
                  </div>
                  <div class="col-12 d-none" id="back_col">
                    <button type="button" id="back_note" class="btn btn-outline-dark float-right back_note"><i class="mdi mdi-arrow-left"></i> Back</button>
                  </div>
                </div>

                <div class="notes-list">
                  <?php foreach ($notes as $note):
                    $attachment = ''; // Initialize attachment as empty string

                    if (!empty($note->attachments)) {
                      foreach ($note->attachments as $att) { // Use different variable name to avoid conflict
                        $attachment .= '<a href="' . htmlspecialchars($att->file_path) . '" alt="Attachment" target="_blank" 
                        style="font-size:16px !important; font-style:normal !important; color: rgb(102, 102, 102) !important;">
                        <i class="mdi mdi-paperclip"></i></a> ';
                      }
                    }
                  ?>
                    <div class="note" data-id="<?= $note->id ?>">
                      <p class="clientNotes <?= $note->is_pinned ? 'pinned' : '' ?>">
                        <?= $note->is_pinned ? '<i class="mdi mdi-pin" style="font-size:20px !important; color: #dc3545 !important;"></i> ' : '' ?>
                        <?= strip_tags($note->note) . '&nbsp;&nbsp;<span class="font-italic font-weight-light">' . $note->created_at . ' ' . $attachment . '</span>'; ?>

                        <a title="Delete" class="text-success delete-note" style="font-size: large !important; float:right !important; color:#dc3545!important">
                          <i class="mdi mdi-delete"></i>
                        </a>
                        <a title="Edit" class="text-success edit-note" style="font-size: large !important; float:right !important; margin-right: 5px !important; color:#28a745!important">
                          <i class="mdi mdi-pencil"></i>
                        </a>
                      </p>
                    </div>
                  <?php endforeach; ?>
                </div>


                <!-- Editor Container -->
                <div class="editor-container d-none">
                      <textarea id="tinymce_editor_notes" class="form-control" name="client_notes"></textarea>
                  <div class="row mt-3">
                    <div class="col">
                      <button type="button" class="btn btn-outline-dark mb-3" id="pin_note"><i class="mdi mdi-pin"></i> Pin</button>
                      <button type="button" class="btn btn-outline-dark mb-3" id="attach_files"><i class="mdi mdi-paperclip"></i> Attachment</button>
                    </div>
                    <div class="col text-right">
                      <button type="button" class="btn btn-outline-dark back_note mb-3" id=""><i class="mdi mdi-delete-outline"></i> Delete</button>
                      <button type="button" class="btn btn-primary mb-3" id="save_note" disabled>Save</button>
                    </div>
                  </div>
                  <div id="attachment_preview" class="mt-3"></div>
                </div>
              </div>
            </div>

            <br>
            <h4>Documents</h4>
            <div class="card w-100">
              <div class="progress" style="height: 4px !important;">
                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" styl></div>
              </div>
              <div class="card-body">
                <h4 class="task-title2">Issued/Received</h4>

                <div class="list-wrapper">
                  <form id="uploaddocs" method="post" action="<?php echo base_url(); ?>Dashboard/docupload" enctype="multipart/form-data">
                    <input type="file" id="imgupload" name="fileupload" style="display:none">
                    <input type="hidden" id="docid" name="docid">
                    <input type="hidden" id="ClientID" name="ClientID" value="<?php echo $fetchClientinfo[0]->sq_client_id; ?>">
                  </form>
                  <table class="table" id="docutab">
                    <tr>
                      <td><input type="checkbox" <?php echo (!empty($client_agreement)) ? 'checked' : ''; ?>></td>

                      <td><span>Client Agreement</span></td>

                      <td></td>
                    </tr>

                    <tr>
                      <td>
                        <input type="checkbox" <?php echo (!empty($client_photo)) ? 'checked' : ''; ?>>
                      </td>

                      <td>
                        <span>Upload Photo ID</span>
                      </td>

                      <td>
                        <?php if (empty($client_photo)): ?>
                          <a onclick="open_popup('photo_upload');" title="Upload" style="font-size: 18px;">
                            <i class="mdi mdi-upload"></i>
                          </a>
                          <input type="file" name="photo_file" id="photo_upload" style="display:none">
                        <?php else: ?>
                          <a download target="_blank" href="<?php echo $client_photo; ?>" title="Download" style="font-size: 18px;">
                            <i class="mdi mdi-download"></i>
                          </a>
                          <a onclick="deleteFile('photo_upload', '<?php echo $fetchClientinfo[0]->sq_client_id; ?>');" title="Remove" style="font-size: 18px;">
                            <i class="mdi mdi-close-circle-outline"></i>
                          </a>
                        <?php endif; ?>
                      </td>

                    </tr>

                    <tr>
                      <td>
                        <input type="checkbox" <?php echo (!empty($client_address)) ? 'checked' : ''; ?>>
                      </td>

                      <td>
                        <span>Upload Proof of Address</span>
                      </td>

                      <td>
                        <?php if (empty($client_address)): ?>
                          <a onclick="open_popup('address_photo');" title="Upload" style="font-size: 18px;">
                            <i class="mdi mdi-upload"></i>
                          </a>
                          <input type="file" name="address_file" id="address_photo" style="display:none">
                        <?php else: ?>
                          <a download target="_blank" href="<?php echo $client_address; ?>" title="Download" style="font-size: 18px;">
                            <i class="mdi mdi-download"></i>
                          </a>
                          <a onclick="deleteFile('address_photo', '<?php echo $fetchClientinfo[0]->sq_client_id; ?>');" title="Remove" style="font-size: 18px;">
                            <i class="mdi mdi-close-circle-outline"></i>
                          </a>
                        <?php endif; ?>
                      </td>

                    </tr>
                    <?php
                    foreach ($fetch_all_docName as $row):

                      if (isset($document_id[$row->id]) && $document_id[$row->id] == $row->id) {
                        $displayupload = 'hide';
                      } else {
                        $displayupload = 'display';
                      }


                      if (isset($status[$row->id]) && $status[$row->id] == 1) {
                        $statusval = 'checked';
                      } else {
                        $statusval = '';
                      }

                      if (isset($docreceid[$row->id])) {
                        $docreceid =  $docreceid[$row->id];
                      }
                    ?>
                      <tr>
                        <td>
                          <input type="checkbox" value="" id="drev<?php echo $row->id; ?>" name="boxcheck" <?php echo $statusval; ?> onclick="checkboxcheck(this,'<?php echo $row->id; ?>','<?php echo $docreceid; ?>');">
                        </td>
                        <td>
                          <span><?php echo $row->doc_name; ?></span>
                        </td>
                        <td>
                          <?php if ($displayupload == 'display') { ?>

                            <a onclick="OpenImgUpload(this,'<?php echo $row->id; ?>');" title="Upload" style="font-size: 18px;"><i class="mdi mdi-upload"></i></a>

                          <?php } else { ?>

                            <a Download target="_blank" href="<?php echo $document_link[$row->id]; ?>" title="Download" style="font-size: 18px;"><i class="mdi mdi-download"></i></a>

                            <a onclick="Removethisdoc(this,'<?php echo $docreceid[$row->id]; ?>');" title="Remove" style="font-size: 18px;"><i class="mdi mdi-close-circle-outline"></i>
                            </a>

                          <?php } ?>

                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                  <a class="lft" data-toggle="modal" data-target="#Customizelist">Customize list</a>
                </div>

              </div>
            </div>
          </div>




          <div class="row">
            <!-- <div class="col-md-6 board-wrapper2 mt-3">
              <div class="board-portlet">
                <h4 class="portlet-heading">Memo</h4>
                <ul id="portlet-card-list-1" class="portlet-card-list">
                  <li class="portlet-card simple">
                    <div class="progress">
                      <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <textarea type="text" class="form-control" id="client_memo" rows="6" placeholder="Write something here..."><?php echo $clientMemo; ?></textarea>
                      </div>
                      <div class="col-2 mt-2">
                        <button type="button" onclick="SaveClientmemo(this,'<?php echo $fetchClientinfo[0]->sq_client_id; ?>');" class="btn btn-gradient-success btn-sm">Save</button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div> -->

          </div>



        </div>
      </div>
    </div>

    <!-- All Task -->
    <div class="modal fade" id="Customizelist" tabindex="-1" role="dialog" aria-labelledby="alltasks" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>New Client Checklist</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 text-center">
                <small><b>Note: Change made to this list are global for all your clients</b></small>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-3">
                <label><b>New Item:</b></label>
              </div>
              <div class="col-6">
                <input type="text" id="doc_name" class="form-control">
              </div>
              <div class="col-2">
                <button type="button" onclick="SaveDocName(this);" class="btn btn-gradient-success btn-sm">Save</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <table class="table">
                  <tr>
                    <th>Document Type</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  $countdoc = 0;
                  foreach ($fetch_all_docName as $row) { ?>
                    <tr>
                      <td><?php echo $row->doc_name; ?></td>
                      <td><i class="mdi mdi-lock"></i></td>
                    </tr>
                  <?php $countdoc++;
                  } ?>
                  <tr>
                    <th>Total: <?php echo $countdoc; ?></th>
                    <th></th>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- All Task -->
    <div class="modal fade" id="ClientCompletetasks" tabindex="-1" role="dialog" aria-labelledby="alltasks" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Client Completed Tasks</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <table class="table table-striped jsgrid">
                  <thead>
                    <tr>
                      <th></th>
                      <th><b>Subject</b></th>
                      <th><b>Notes</b></th>
                      <th><b>Due Date</b></th>
                      <th><b>Action</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($fetchsqtaskComle) && is_array($fetchsqtaskComle)):
                      foreach ($fetchsqtaskComle as $row): ?>
                        <tr>
                          <td><input type="checkbox" name="taskcheck" onclick="updatetaskstatus(this,'Completed','<?php echo $row->id; ?>');"> </td>
                          <td><?php echo $row->subject; ?></td>
                          <td><?php echo $row->notes; ?></td>
                          <td><?php echo date('m/d/Y', strtotime($row->due_date)); ?></td>
                          <td>
                            <input class="jsgrid-button jsgrid-delete-button" type="button" title="Delete" onclick="removeTask('<?php echo $row->id; ?>');">
                          </td>

                        </tr>
                      <?php endforeach; ?>

                    <?php endif;  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!----------- Team task -------------->
    <div class="modal fade" id="teamalltasks" tabindex="-1" role="dialog" aria-labelledby="teamalltasks" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Team Completed Tasks</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <table class="table table-striped jsgrid">
                  <thead>
                    <tr>
                      <th></th>
                      <th><b>Subject</b></th>
                      <th><b>Notes</b></th>
                      <th><b>Due Date</b></th>
                      <th><b>Action</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($fetchsq_teamcc) && is_array($fetchsq_teamcc)) {
                      foreach ($fetchsq_teamcc as $row) { ?>
                        <tr>
                          <td><input type="checkbox" name="taskcheck" onclick="updatetaskstatus(this,'Completed','<?php echo $row->id; ?>');"> </td>
                          <td><?php echo $row->subject; ?></td>
                          <td><?php echo $row->notes; ?></td>
                          <td><?php echo date('m/d/Y', strtotime($row->due_date)); ?></td>
                          <td>
                            <input class="jsgrid-button jsgrid-delete-button" type="button" title="Delete" onclick="removeTask('<?php echo $row->id; ?>');">
                          </td>

                        </tr>
                      <?php }
                    } else { ?>
                      <tr>
                        <td colspan="4">No completed task found!</td>
                      </tr>
                    <?php }  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- All Tasks Ends -->

    <!-- All score -->
    <div class="modal fade" id="addeditscore" tabindex="-1" role="dialog" aria-labelledby="#addeditscore" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 55%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel"><b>Client Score</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-striped jsgrid">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Equifax</th>
                  <th>Experian</th>
                  <th>Trans Union</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <input type="text" name="date" class="form-control datepicker">
                  </td>
                  <td>
                    <input type="number" name="equfaxScore" class="form-control">
                  </td>
                  <td>
                    <input type="number" name="experianScore" class="form-control">
                  </td>
                  <td>
                    <input type="number" name="TUScore" class="form-control">
                  </td>
                  <td>
                    <button type="button" onclick="addClientScore();" class="btn btn-success btn-sm">Add</button>
                  </td>
                </tr>
              </tbody>
            </table>

            <?php if (isset($fetchClientscore) && is_array($fetchClientscore)) { ?>
              <table class="table mt-4" style="border: 1px solid #dcd4d4;">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Equifax</th>
                    <th>Experian</th>
                    <th>Trans Union</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($fetchClientscore as $row) { ?>
                    <input type="hidden" id="client_id<?php echo $row->id; ?>" value="<?php echo $row->client_id; ?>">
                    <tr>
                      <td>
                        <input type="text" id="date<?php echo $row->id; ?>" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y', strtotime($row->date)); ?>">
                      </td>
                      <td>
                        <input type="number" id="equfaxScore<?php echo $row->id; ?>" name="equfaxScore" class="form-control" value="<?php echo $row->equifax; ?>">
                      </td>
                      <td>
                        <input type="number" id="experianScore<?php echo $row->id; ?>" name="experianScore" class="form-control" value="<?php echo $row->experian; ?>">
                      </td>
                      <td>
                        <input type="number" id="TUScore<?php echo $row->id; ?>" name="TUScore" class="form-control" value="<?php echo $row->transunion; ?>">
                      </td>
                      <td>
                        <a onclick="updateScore('<?php echo $row->id; ?>');" class="text-success" title="Update" style="font-size: 20px;"><i class=" mdi mdi-content-save"></i></a>
                        <a onclick="removeScore('<?php echo $row->id; ?>');" class="text-success" title="Remove" style="font-size: 20px;"><i class="mdi mdi-delete"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>



          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- partial -->
  </div>
  <!-- Agreement Preview e-->

  <div id="simpleAuditModal" class="modal fade" tabindex="-1" role="dialog" style="top: -90px !important;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="background-color: #fff !important;">
        <div class="modal-header">
          <h5 class="modal-title">Simple Audit Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="auditContent"></div>
        <div class="modal-footer">
             <button class="btn btn-success" id="emailAuditButton">Email Audit to Client</button> 
          <button class="btn btn-primary printAudit">Print</button>
          
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Modal -->
<div class="modal fade" id="updatetaskModal" tabindex="-1" aria-labelledby="updatetaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editTaskForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editTaskId" name="id">
          <div class="mb-3">
            <label class="form-label">Task Type</label>
            <select class="form-control" id="editTaskType" name="taskType">
              <option value="General">General</option>
              <option value="Billing">Billing</option>
              <option value="Send Invoice">Send Invoice</option>
              <option value="Follow Up">Follow Up</option>
              <option value="Appointment">Appointment</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" id="editSubject" name="subject">
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" id="editDueDate" name="dueDate">
          </div>
          <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" class="form-control" id="editTime" name="time">
          </div>
          <div class="mb-3">
            <label class="form-label">Team Member</label>
            <select class="form-control" id="editTeamMember" name="teamMember">
                <?php
                if (!empty($fetchempinfo)){
                        foreach ($fetchempinfo as $team){ ?>
                        <option data-id="<?= $team->sq_u_id; ?>" value="<?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?>"><?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?></option>
                   <?php } } ?>
                        
            </select>
         
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" id="editNotes" name="notes" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelModalUpdate">Cancel</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

    <div id="taskModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-mg" role="document">
      <div class="modal-content" style="background-color: #fff !important;">
        <div class="modal-header">
          <h5 class="modal-title">Add Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
     <form id="taskForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="taskType" class="form-label">Task Type</label>
             <select class="form-control" id="taskType" name="taskType" required>
              <option value="">-- Select Task Type --</option>
              <option value="General">General</option>
              <option value="Billing">Billing</option>
              <option value="Send Invoice">Send Invoice</option>
              <option value="Follow Up">Follow Up</option>
              <option value="Appointment">Appointment</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
          </div>
          <div class="mb-3">
            <label for="dueDate" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="dueDate" name="dueDate" required>
          </div>
          <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time">
          </div>
          <div class="mb-3">
            <label for="teamMember" class="form-label">Team Member</label>
          <select class="form-control" id="teamMember" name="teamMember">
                  <?php
                if (!empty($fetchempinfo)){
                        foreach ($fetchempinfo as $team){ ?>
                      <option data-id="<?= $team->sq_u_id; ?>" value="<?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?>"><?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?></option>

    
                   <?php } } ?>
                        
            </select>
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  <div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
  </div>

  <!-- Print Modal s -->
  <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 60% !important;">
      <div class="modal-content" style="background-color: white !important;">
        <div class="modal-header">
          <h5 class="modal-title" id="printModalLabel">Agreement Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="font-size: 34px !important;">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="print-content">
            <div><?= $agreement_text ?></div>
<div class="digital-signature">
           <img src="<?=$fetchClientinfo[0]->agreement_path?>" height="80" width="300" style="border-bottom: 1px solid #000">

            <h6 class="css-13ia1ff"><?= $fetchClientinfo[0]->sq_first_name . ' '. $fetchClientinfo[0]->sq_last_name ?>,<?= date('M d, Y', strtotime($fetchClientinfo[0]->agreement_sign_date)) ?></h6>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="reset_agreement">Reset Agreement</button>
          <button type="button" class="btn btn-primary print_button" >Print</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Print Modal e -->

  <!-- Agreement Preview s-->

  <div class="dashboard-container" style="margin-top: 120px !important; display:none;">
    <h2 class="agreement_heading">Agreement Preview</h2>

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
        <p>Date: <span id="current-date"></span></p>
        <p>Name: <span id="client-name-display"><?php echo $name; ?></span></p>
      </div>

      <div class="buttonss">
        <button type="button" class="btn btn-danger mt-2" id="clear">Clear Signature</button>
        <button type="button" class="btn btn-success mt-2" id="submit_agreement">Submit Now</button>
      </div>

      <button class="btn btn-primary mt-4" id="openPrintPreview" data-toggle="modal" data-target="#printModal">Print Preview</button>
    </div>
  </div>



  <input type="hidden" class="form-control" id="clientName" value="<?php echo $name; ?>">
  <input type="hidden" class="form-control" id="sq_client_id" value="<?php echo $fetchClientinfo[0]->sq_client_id; ?>">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
         $('#taskForm').submit(function(e) {
    e.preventDefault();

    // Show loader
    $('#loader').show();

    // Prepare form data
    const formData = {
      taskType: $('#taskType').val(),
      subject: $('#subject').val(),
      dueDate: $('#dueDate').val(),
      time: $('#time').val(),
      teamMember: $('#teamMember').val(),
      teamMemberid: $('#teamMember option:selected').data('id'),
      notes: $('#notes').val(),
       client_id: <?= $fetchClientinfo[0]->sq_client_id; ?>
    };

    $.ajax({
      url: '<?= base_url("taskSave") ?>', // change to your endpoint
      type: 'POST',
      data: formData,
      success: function(response) {
        // Hide loader
        $('#loader').hide();

        // You can parse response if JSON or just show message
        alert('Task saved successfully!');
       
        // Close modal
        var modalEl = $('#taskModal');
        modalEl.modal('hide');

        // Reset form
        $('#taskForm')[0].reset();
      window.location.reload();

      },
      error: function(xhr, status, error) {
        $('#loader').hide();
        alert('Error: ' + error);
      }
    });
  });
      $('#generate_simple_audit').click(function() {

        $('#loader').show(); // Show loader
        $.ajax({
          url: '<?= base_url("Dashboard/generate_simple_audit") ?>',
          type: 'POST',
          data: {
            client_id: <?= $fetchClientinfo[0]->sq_client_id; ?>
          },
          success: function(response) {
            $('#loader').hide(); // Hide loader
            $('#auditContent').html(response); // Set modal content
            $('#simpleAuditModal').modal('show'); // Show modal
          },
          error: function() {
            $('#loader').hide(); // Hide loader on error
            alert('Failed to generate audit report.');
          }
        });
      });

  $('#emailAuditButton').on('click', function() {
    $(this).prop('disabled', true).text('Sending...');

    $.ajax({
         url: '<?= base_url("Dashboard/auditEmailSendtoClient") ?>',
          type: 'POST',
          data: {
            client_id: <?= $fetchClientinfo[0]->sq_client_id; ?>
          },
        success: function(response) {
            alert('Audit Email sent successfully!');
            console.log(response);
        },
        error: function(xhr, status, error) {
            alert('Something went wrong! Please try again.');
        },
        complete: function() {
            $('#emailAuditButton').prop('disabled', false).text('Email Audit to Client');
        }
    });
});

      // Download PDF functionality
      $('#downloadPDF').click(function() {
        window.location.href = '<?= base_url("Dashboard/download_pdf") ?>?client_id=<?= $fetchClientinfo[0]->sq_client_id; ?>';
      });
    });
  </script>

  <script>
    tinymce.init({
      selector: '#tinymce_editor_notes',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
      setup: function(editor) {
        editor.on('keyup change', function() {
          const content = editor.getContent();
          $('#save_note').prop('disabled', !content.trim());
        });
      }
    });


    $(document).ready(function() {
      // Create and append file input to the DOM
      let fileInput = $('<input type="file" multiple id="attachments_input" style="display:none;" />');
      $('body').append(fileInput); // Append to body for it to exist in the DOM

      // Attach file input click event
      $('#attach_files').on('click', function() {
        fileInput.click();
      });

      // Handle file selection
      fileInput.on('change', function(event) {
        let files = event.target.files;
        let previewContainer = $('#attachment_preview');
        previewContainer.empty(); // Clear previous previews

        // Loop through files and display preview
        Array.from(files).forEach(file => {
          let fileReader = new FileReader();
          fileReader.onload = function(e) {
            let preview = '';

            if (file.type.startsWith('image/')) {
              preview = `<img src="${e.target.result}" alt="${file.name}" style="max-width: 150px; margin-right: 10px;" />`;
            } else if (file.type === 'application/pdf') {
              preview = `<embed src="${e.target.result}" type="application/pdf" width="150px" height="100px" style="margin-right: 10px;" />`;
            } else {
              preview = `<p>${file.name}</p>`;
            }

            previewContainer.append(preview);
          };

          fileReader.readAsDataURL(file);
        });
      });

      $('#save_note').on('click', function() {
        const note = tinymce.get('tinymce_editor_notes').getContent();
        const is_pinned = $('#pin_note').hasClass('active') ? 1 : 0;
        const formData = new FormData();
  var clientID = '<?php echo $fetchClientinfo[0]->sq_client_id; ?>';

        formData.append('note', note);
          formData.append('client_id', clientID);
        formData.append('is_pinned', is_pinned);

        let files = $('#attachments_input')[0].files;
        for (let i = 0; i < files.length; i++) {
          formData.append('attachments[]', files[i]);
        }
 $('#loader').show();
        $.ajax({
          url: '<?= base_url("Dashboard/save_notes") ?>',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
               $('#loader').hide();
            let res = JSON.parse(response);
            if (res.status === 'success') {
              Swal.fire({
                title: 'Success!',
                text: res.message,
                icon: 'success',
                allowOutsideClick: false,
                confirmButtonText: 'OK',
              }).then(() => {
                // Clear inputs or update UI here if needed
                tinymce.get('tinymce_editor_notes').setContent('');
                $('#attachment_preview').empty();
                $('#pin_note').removeClass('active');
                location.reload();
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: res.message,
                icon: 'error',
                confirmButtonText: 'OK',
              });
            }
          },
          error: function() {
               $('#loader').hide();
            Swal.fire({
              title: 'Error!',
              text: 'An unexpected error occurred.',
              icon: 'error',
              confirmButtonText: 'OK',
            });
          },
        });
      });

    });


    $(document).ready(function() {
          $('#tasksaddEdit').on('click', function() {
              console.log("gg");
        $('#taskModal').modal('show');
        //  $('#back_cols').removeClass('d-none');
        });
          $('#cancelModal').on('click', function() {
        $('#taskModal').modal('hide');
        });
        $('.edit-tasks').on('click', function() {
          $('#editTaskId').val($(this).data('id'));
    $('#editSubject').val($(this).data('subject'));
    $('#editTaskType').val($(this).data('type'));
    $('#editDueDate').val($(this).data('due'));
    $('#editTime').val($(this).data('time'));
    $('#editTeamMember').val($(this).data('member'));
    $('#editNotes').val($(this).data('notes'));
       $('#updatetaskModal').modal('show');
    });
        $('#cancelModalUpdate').on('click', function() {
        $('#updatetaskModal').modal('hide');
        });
      let isEdited = false;

      $('#new_note').on('click', function() {
        $('.notes-list').hide();
        $('#new_note').hide();
        $('.editor-container').removeClass('d-none');
        $('#back_col').removeClass('d-none');
      });

      $('.back_note').on('click', function() {
        const noteContent = tinymce.get('tinymce_editor_notes').getContent().trim();
        if (noteContent) {

          Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to exit without saving?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
          }).then((result) => {
            if (result.isConfirmed) {

              resetEditor();
            }
          });
        } else {
          resetEditor();
        }
      });

      $('#pin_note').on('click', function() {
        $(this).toggleClass('active');
      });

      $('#attach_files').on('click', function() {
        $('#attachment_modal').modal('show');
      });

      $('#upload_attachments').on('click', function() {
        const files = $('#attachments')[0].files;
        const preview = $('#attachment_preview');
        preview.empty();

        if (files.length) {
          for (let i = 0; i < files.length; i++) {
            preview.append('<div>' + files[i].name + '</div>');
          }
          alert('Files uploaded successfully!');
        }
      });

      function resetEditor() {
        $('.notes-list').show();
        $('#new_note').show();
        $('.editor-container').addClass('d-none');
        $('#back_col').addClass('d-none');
        tinymce.get('tinymce_editor_notes').setContent('');
      }
    
    $('.delete-tasks').on('click', function() {
       const taskId = $(this).data('id');
       console.log(taskId);
       // const taskId = $(this).closest('.task').data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure you want to delete this task?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, keep it'
        }).then((result) => {
          if (result.isConfirmed) {
            $.post('<?= base_url("delete_task") ?>', {
              task_id: taskId
            }, function(response) {
              Swal.fire('Deleted!', 'Task deleted successfully!', 'success');
              location.reload();
            });
          }
        });
      });
    $('#editTaskForm').submit(function (e) {
    e.preventDefault();
// Get the selected team member's data-id
const teamMemberId = $('#editTeamMember option:selected').data('id');

// Append hidden input just before serialization
$('<input>').attr({
    type: 'hidden',
    name: 'teamMemberid',
    value: teamMemberId
}).appendTo(this);

// Now serialize
const formData = $(this).serialize();
    $.ajax({
      url: '<?= base_url("update_task") ?>',
      type: 'POST',
      data: formData,
      success: function (response) {
        const res = JSON.parse(response);
        if (res.status === 'success') {
          alert('Task updated successfully');
          $('#editTaskModal').modal('hide');
          location.reload(); // Or dynamically update the task on the page
        } else {
          alert(res.message || 'Update failed');
        }
      },
      error: function () {
        alert('Server error occurred');
      }
    });
  });
      $('.delete-note').on('click', function() {
        const noteId = $(this).closest('.note').data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure you want to delete this note?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, keep it'
        }).then((result) => {
          if (result.isConfirmed) {

            $.post('<?= base_url("Dashboard/delete_note") ?>', {
              note_id: noteId
            }, function(response) {
              Swal.fire('Deleted!', 'Note deleted successfully!', 'success');
              location.reload();
            });
          }
        });
      });

      $('.edit-note').on('click', function() {
        const noteId = $(this).closest('.note').data('id');
        let noteContent = $(this).closest('.note').find('.clientNotes').html();

        // Remove the created_at timestamp from the content
        noteContent = noteContent.replace(/<span class="font-italic font-weight-light">.*<\/span>/, '');

        // Display note content in TinyMCE editor
        $('.notes-list').hide();
        $('#new_note').hide();
        $('.editor-container').removeClass('d-none');
        $('#back_col').removeClass('d-none');
        tinymce.get('tinymce_editor_notes').setContent(noteContent); // Set content in TinyMCE

        $('#save_note').prop('disabled', false).off('click').on('click', function() {
          const note = tinymce.get('tinymce_editor_notes').getContent();
          const is_pinned = $('#pin_note').hasClass('active') ? 1 : 0;

          if (!note.trim()) {
            Swal.fire('Error', 'Note content cannot be empty!', 'error');
            return;
          }

          Swal.fire({
            title: 'Are you sure?',
            text: "You want to save the changes to this note?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.post('<?= base_url("Dashboard/edit_note") ?>', {
                note_id: noteId,
                note: note,
                is_pinned: is_pinned
              }, function(response) {
                Swal.fire('Success', 'Note updated successfully!', 'success').then(() => {
                  location.reload();
                });
              }).fail(function() {
                Swal.fire('Error', 'Failed to update the note. Please try again.', 'error');
              });
            }
          });
        });
      });



    });
  </script>

  <script>
    var signatureUrl = "<?php echo isset($client_sign) ? $client_sign : ''; ?>";

    window.onload = function() {
      var signaturePad = new SignaturePad(document.getElementById('signature-pad'));

      // Set the current date
      document.getElementById('current-date').textContent = new Date().toLocaleDateString();

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

  <script type="text/javascript">
    function sendWelcomeemail(email, id) {

      if (email != '') {

        $.ajax({

          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/welcomeEmail"; ?>',
          data: {
            'email': email,
            'id': id
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Welcome Email</div><div class="swal-text" style="">Welcome email sent successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });
      }
    }

    function removeScore(rowID) {
      if (rowID != '') {

        $.ajax({

          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/RemoveScore"; ?>',
          data: {
            'rowID': rowID
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Client Score</div><div class="swal-text" style="">Client score removed successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });

      }
    }


    function updateScore(rowID) {

      if (rowID != '') {

        var clientID = $('#addeditscore input#client_id' + rowID).val();
        var dateadd = $('#addeditscore input#date' + rowID).val();
        var equfaxScore = $('#addeditscore input#equfaxScore' + rowID).val();
        var experianScore = $('#addeditscore input#experianScore' + rowID).val();
        var TUScore = $('#addeditscore input#TUScore' + rowID).val();

        $.ajax({

          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/UpdateScore"; ?>',
          data: {
            'clientID': clientID,
            'dateadd': dateadd,
            'equfaxScore': equfaxScore,
            'experianScore': experianScore,
            'TUScore': TUScore,
            'rowID': rowID
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Client Score</div><div class="swal-text" style="">Client score updated successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });
      }
    }

    function addClientScore() {

      var clientID = '<?php echo $fetchClientinfo[0]->sq_client_id; ?>';
      var dateadd = $('#addeditscore input[name="date"]').val();
      var equfaxScore = $('#addeditscore input[name="equfaxScore"]').val();
      var experianScore = $('#addeditscore input[name="experianScore"]').val();
      var TUScore = $('#addeditscore input[name="TUScore"]').val();

      if (dateadd && equfaxScore && experianScore && TUScore != '') {

        $.ajax({

          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/addScore"; ?>',
          data: {
            'clientID': clientID,
            'dateadd': dateadd,
            'equfaxScore': equfaxScore,
            'experianScore': experianScore,
            'TUScore': TUScore
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Client Score</div><div class="swal-text" style="">Client score added successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });
      }
    }

    function openScorepopup() {
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
      //$(window).scrollTop(0);
      $('#addeditscore').modal('show');
    }

    function OpenImgUpload(that, id) {
      $('form#uploaddocs #docid').val(id);
      $('form#uploaddocs #imgupload').trigger('click');
    }

    document.getElementById('imgupload').onchange = function() {
      $('form#uploaddocs').submit();
    };


    function openTaskModal(type) {

      if (type == 'client') {
        $('#TaskModal div#teamrow').css('display', 'none');
        $('#TaskModal div#clientrow').css('display', 'flex');
      } else if (type == 'team') {
        $('#TaskModal div#clientrow').css('display', 'none');
        $('#TaskModal div#teamrow').css('display', 'flex');
      } else {
        $('#TaskModal div#teamrow').css('display', 'flex');
        $('#TaskModal div#clientrow').css('display', 'flex');
      }

      $("#TaskModal").modal('show');
    }

    function SaveDocName(that) {

      var newItem = $('#Customizelist input#doc_name').val();
      if (newItem != '') {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/SaveDocumentName"; ?>',
          data: {
            'newItem': newItem
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Documet added!</div><div class="swal-text" style="">Dcoument type added successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });
      }
    }


    function updatetaskstatus(that, key, rowID) {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/updateTask"; ?>',
        data: {
          'status': key,
          'id': rowID
        },
        success: function(response) {
          var data = JSON.parse(response);

          var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Task Data!</div><div class="swal-text" style="">' + data.msg + '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

          $('#msgAppend11task').after(succesMsg);
        }
      });
    }

    function closeSuccessModalNewtask() {

      $('#pDsuccess11').css('display', 'none');
      $('#pDMsuccess11').css('display', 'none');
      //$('#items tr#row'+id).remove();
      location.reload();

    }

    function closeSuccessModal() {
      $('#pDsuccess').css('display', 'none');
      $('#pDMsuccess').css('display', 'none');
      location.reload();
    }

    function removeTask(id) {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/delateTask"; ?>',
        data: {
          'id': id
        },
        success: function(response) {

          if (response == '1') {

            var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Task Deleted!</div><div class="swal-text" style="">Task deleted successfully!</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

            $('#msgAppend11task').after(succesMsg);
          }
        }
      });
    }

    function saveSpouseinfo(that) {

      var formval = $('#spouseform');

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/spousedatasave"; ?>',
        data: formval.serialize(),
        success: function(response) {

          var data = JSON.parse(response);
          if (data.code == '1') {

            var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Spouse Data!</div><div class="swal-text" style="">' + data.msg + '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

            $('#msgAppend11task').after(succesMsg);
          }
        }
      });
    }


    function SaveClientmemo(that, clientID) {

      var client_memo = $('textarea#client_memo').val();

      if (client_memo != '') {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/SaveMemo"; ?>',
          data: {
            'client_memo': client_memo,
            'clientID': clientID
          },
          success: function(response) {

            var data = JSON.parse(response);
            if (data.code == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Memo Data!</div><div class="swal-text" style="">' + data.msg + '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });
      } else {
        $('textarea#client_memo').focus();
      }
    }


    function saveSpouseinfo(that) {

      var formval = $('#spouseform');

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/spousedatasave"; ?>',
        data: formval.serialize(),
        success: function(response) {

          var data = JSON.parse(response);
          if (data.code == '1') {

            var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Spouse Data!</div><div class="swal-text" style="">' + data.msg + '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

            $('#msgAppend11task').after(succesMsg);
          }
        }
      });
    }


    function Removethisdoc(that, recID) {

      if (recID != '') {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/DeleteDocument"; ?>',
          data: {
            'recID': recID
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Document Data!</div><div class="swal-text" style="">Document removed successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }

        });

      }
    }


    function checkboxcheck(that, id, recID) {

      if ($(that).is(':checked')) {
        $('#drev' + id).val('1');
      } else {
        $('#drev' + id).val('2');
      }

      changeDocstatus(this, id, recID);
    }

    function changeDocstatus(that, id, recID) {

      var status = $('#drev' + id).val();

      if (status && recID != '') {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Dashboard/ReceivedDocumentdata"; ?>',
          data: {
            'status': status,
            'recID': recID
          },
          success: function(response) {

            var data = JSON.parse(response);
            if (data.code == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Document Data!</div><div class="swal-text" style="">' + data.msg + '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend11task').after(succesMsg);
            }
          }
        });
      }
    }


    $(function() {

      var data = {
        labels: ["<?php echo $datesVal; ?>"],
        datasets: [{
          label: 'Score',
          data: [<?php echo $scoreVal; ?>],
          backgroundColor: ['<?php echo $colorVal; ?>'],
          borderColor: ['<?php echo $colorVal; ?>'],
          borderWidth: 1,
          fill: false
        }]
      };

      var doughnutPieData = {
        datasets: [{
          data: [<?php echo $forPositive; ?>, <?php echo $forInDispute; ?>, <?php echo $forNegative; ?>],
          backgroundColor: ['#090', '#f60', '#f10505'],
          borderColor: ['#090', '#f60', '#f10505'],
        }],
        labels: [
          'Positive',
          'In Dispute',
          'Negative',
        ]
      };

      var options = {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
        legend: {
          display: false
        },
        elements: {
          point: {
            radius: 0
          }
        }

      };

      var doughnutPieOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        }
      };


      if ($("#ScorebarChart").length) {
        var barChartCanvas = $("#ScorebarChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart = new Chart(barChartCanvas, {
          type: 'bar',
          data: data,
          options: options
        });
      }

      if ($("#clientdoughnutChart").length) {
        var doughnutChartCanvas = $("#clientdoughnutChart").get(0).getContext("2d");
        var doughnutChart = new Chart(doughnutChartCanvas, {
          type: 'doughnut',
          data: doughnutPieData,
          options: doughnutPieOptions
        });
      }

    });
  </script>

  <script>
    function send_invite(sq_client_id) {

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, send invite!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loader
          $('#loader').show();

          $.ajax({
            url: '<?php echo base_url('crxHeroInvite'); ?>',
            type: 'POST',
            data: {
              sq_client_id: sq_client_id
            },
            success: function(response) {
              $('#loader').hide();
              let res = JSON.parse(response);
              if (res.status === 'success') {
                Swal.fire(
                  'Invited!',
                  'Invitation has been sent successfully.',
                  'success'
                ).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire(
                  'Error!',
                  'There was a problem inviting the client.',
                  'error'
                );
              }
            },
            error: function(xhr, status, error) {
              $('#loader').hide();
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

    $(document).on('click', '#reset_agreement', function(e) {
      e.preventDefault();

      let sq_client_id = $('#sq_client_id').val();
      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to reset this signature so your client must sign again ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reset!',
        cancelButtonText: 'No, cancel!'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#loader').show();
          $.ajax({
            type: 'POST',
            url: '<?php echo base_url('reset_agreement'); ?>',
            data: {
              sq_client_id: sq_client_id
            },
            success: function(response) {
              let res = JSON.parse(response);
              $('#loader').hide();
              if (res.status === 'success') {
                Swal.fire({
                  title: 'Success',
                  text: res.message,
                  icon: 'success',
                  showConfirmButton: true,
                }).then(() => {
                  location.reload();
                });
              } else if (res.status === 'error') {

                Swal.fire({
                  title: 'Error',
                  text: res.message,
                  icon: 'error',
                  confirmButtonText: 'Close'
                });
              }

            },
            error: function(xhr, status, error) {
              $('#loader').hide();
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'There was an issue. Please try again.',
                showConfirmButton: true,
              }).then(() => {
                location.reload();
              });
            }
          });
        }
      });
    });


    function open_popup(inputId) {
      $(`#${inputId}`).trigger('click');
    }

    function handleFileUpload(inputId, uploadUrl) {
      $(`#${inputId}`).on('change', function() {
        if (this.files.length > 0) {
          let client_id = "<?php echo $fetchClientinfo[0]->sq_client_id; ?>";
          let file_data = $(`#${inputId}`)[0].files[0];

          let formData = new FormData();
          formData.append(inputId, file_data);
          formData.append('client_id', client_id);

          $.ajax({
            url: uploadUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              let res = JSON.parse(response);
              if (res.status === 'success') {
                Swal.fire('Success!', 'Photo saved successfully.', 'success').then(() => location.reload());
              }
            },
            error: function() {
              Swal.fire('Error!', 'There was a problem processing your request.', 'error');
            }
          });
        }
      });
    }

    // Initialize file upload events
    handleFileUpload('photo_upload', '<?php echo base_url('Dashboard/save_photo_id'); ?>');
    handleFileUpload('address_photo', '<?php echo base_url('Dashboard/save_address_photo'); ?>');


    function deleteFile(type, client_id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This file will be permanently deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?php echo base_url("Dashboard/delete_client_file"); ?>',
            type: 'POST',
            data: {
              type: type,
              client_id: client_id
            },
            success: function(response) {
              let res = JSON.parse(response);
              if (res.status === 'success') {
                Swal.fire('Deleted!', res.message, 'success').then(() => {
                  location.reload();
                });
              } else {
                Swal.fire('Error!', res.message, 'error');
              }
            },
            error: function(xhr, status, error) {
              Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
            }
          });
        }
      });
    }
  </script>

<?php
  $current_year = date('Y');
  $monthly_scores = [];

  // Initialize months
  for ($i = 1; $i <= 12; $i++) {
    $monthly_scores[$i] = ['count' => 0, 'total_score' => 0];
  }

  foreach ($client_score as $value) {
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
        }],
        accessibility: {
          enabled: false // Disables accessibility features
        }
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
           $("body").on("click", ".printAudit", function() {
        var prtContent = document.getElementById("auditContent");
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
  

  </script>