<?php
$us_states = $this->config->item('us_states');

$name = trim(($client[0]->sq_first_name ?? '') . ' ' . ($client[0]->sq_last_name ?? ''));
$clientAddress = trim(($client[0]->sq_mailing_address ?? ''));
$clientFullAddress = trim(($client[0]->sq_city ?? '') . ' ' . ($client[0]->sq_state ?? '') . ' ' . ($client[0]->sq_zipcode ?? ''));
$client_id = get_encoded_id($client[0]->sq_client_id);
$letterFilter = (int) ($_GET['letterFilter'] ?? 0);


function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $now = time();
    $diff = $now - $timestamp;

    if ($diff < 0) {
        return 'just now'; // Or: return 'in the future';
    }

    if ($diff < 60)
        return $diff . ' seconds ago';
    elseif ($diff < 3600)
        return floor($diff / 60) . ' minutes ago';
    elseif ($diff < 86400)
        return floor($diff / 3600) . ' hours ago';
    elseif ($diff < 604800)
        return floor($diff / 86400) . ' days ago';
    else
        return date('d M Y', $timestamp);
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
  tinymce.init({
    selector: '#contentTextarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    document_base_url: '<?php echo base_url(); ?>',
    relative_urls: false,
    remove_script_host: false,
  });
</script>
<style>
.tooltip-container {
    position: relative;
    display: inline-block;
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
.heading-h4{
        font-size: 32px !important;
    margin-bottom: 24px !important;
    font-weight: 400 !important;
}

.tooltip-container .tooltip-text {
    visibility: hidden;
    width: 250px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 8px;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Top me le jane ke liye */
    left: 20%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 12px;
}

.tooltip-container .tooltip-text::after {
    content: "";
    position: absolute;
    top: 100%; /* Neeche pointing arrow */
    left: 50%;
    margin-left: 5px;
    border-width: 5px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}

.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}
  .mce-notification {
    display: none;
  }
  .mail-method .method-box:hover {
  box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
}

  .mail-method .method-box {
  border: 2px solid #ccc;
  border-radius: 16px;
  padding: 30px 20px;
  text-align: center;
  width: 100%;
  max-width: 320px;
  min-height: 250px;
  cursor: pointer;
  transition: 0.3s ease;
  background-color: #f9f9f9;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.mail-method .method-box.selected {
  border-color: #007bff;
  background-color: #e9f2ff;
  box-shadow: 0 0 15px rgba(0, 123, 255, 0.2);
}

.mail-method {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}


.form-check{

    padding-left:1.25rem!important;
}
  .form_error {
    color: red;
    font-weight: bold;
  }

  legend {
    padding: 5px 20px;
    font-size: 20px;
    font-weight: bold;
  }

  .placeholder_section .col-md-6 {
    font-size: 13px;
    line-height: 20px;
  }

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

  /* errors css s  */
  .is-invalid {
    border-color: #dc3545;
  }

  .invalid-feedback {
    color: #dc3545;
    display: block;
  }

  /* errors css e */


  /* Swal css s */

  .swal2-modal .swal2-icon,
  .swal2-modal .swal2-success-ring {
    margin-top: 0 !important;
    margin-bottom: 0px !important;
  }

  /* Swal css e */

  .form-control {
    color: black !important;
  }

  input[type="tel"]::placeholder {
    color: black;
  }

  input[type="text"]::placeholder {
    color: black;
  }

  .form-sample .form-group.row {
    margin-bottom: 1.5rem !important;
  }

  select.is-invalid {
    outline: 1px solid #dc3545 !important;
  }

  .cloudmailAddress {
    font-weight: 700 !important;
    font-size: 15px !important;
  }

  #envelope_address {
    border: 1px solid #d0d0d0 !important;
    padding: 15px 0px 15px 0px !important;
    margin: auto !important;
    border-radius: 10px !important;
  }

  .envelopeAddress {
    display: none;
  }
</style>
<style>
  .step {
    margin-bottom: 15px;
    border-left: 4px solid transparent;
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 15px;
  }

  .step.active {
    border-left-color: #007bff;
    background-color: #e9f1ff;
  }

  .step-content {
    display: none;
    margin-top: 10px;
  }

  .step.active .step-content {
    display: block;
  }

  .step-title {
    font-weight: 600;
  }

  .invalid-feedback {
    display: none;
    color: red;
    font-size: 0.9em;
  }

  input.is-invalid ~ .invalid-feedback {
    display: block;
  }
</style>

<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: '#contentTextarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    document_base_url: '<?php echo base_url(); ?>',
    relative_urls: false,
    remove_script_host: false,
  });
</script>

<div id="loader">
  <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>

<div class="container-fluid page-body-wrapper">
    <div class="main-panel pnel">
        <div class="content-wrapper">
            <div class="step-navigation border rounded-lg p-2 px-3 mb-3">
  <div class="d-flex flex-wrap justify-content-center gap-2">

    <a href="<?= base_url(); ?>dashboard/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      Dashboard
    </a>

    <a href="<?= base_url(); ?>import_audit/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">1</span> Import / Audit
    </a>

    <a href="<?= base_url(); ?>pending_report/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">2</span> Tag Pending Report
    </a>

    <a href="<?= base_url(); ?>generate-letters/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">3</span> Generate Letters
    </a>

    <a href="<?= base_url(); ?>send_letter/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link active">
      <span class="step-num">4</span> Send Letters
    </a>

    <a href="<?= base_url('letters-status/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Letters & Status
    </a>

    <a href="<?= base_url('dispute_items/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Dispute Items
    </a>

    <a href="<?= base_url('messages/send/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Messages
    </a>

  </div>
</div>
       
      <div class="page-header mt-3">
        <h3 class="heading-h4"> Send Letters  (<?php echo $name; ?>) </h3>
        <!--<nav aria-label="breadcrumb">-->
        <!--  <ol class="breadcrumb">-->
        <!--    <li class="breadcrumb-item"><a href="#">Home</a></li>-->
        <!--    <li class="breadcrumb-item active" aria-current="page">Dispute Wizard</li>-->
        <!--  </ol>-->
        <!--</nav>-->
      </div>
<div class="card">
  <div class="card-body">
    <div id="verticalStepper">

      <!-- Step 1 -->
      <div class="step" data-step="1">
        <h5 class="step-title">1: Select Letters</h5>
      <div class="step-content">
  <p class="mb-3">
    This is a list of all unsent and unprinted letters that you have created for this client. You can make any last minute changes, rename, or remove accidental letters by clicking the <strong>"View/Edit"</strong> button. All sent or printed letters will be shown in the upcoming "Track" screen.
  </p>

  <!-- Filter Radio -->
  <form method="get" id="filterForm">
  <div class="filter d-flex gap-4 mb-3">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="letterFilter" id="unsent" value="0" <?= ($letterFilter == 0 ? 'checked' : '') ?>>
      <label class="form-check-label mr-2" for="unsent">View Unprinted/Unsent Letters</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="letterFilter" id="all" value="1"  <?= ($letterFilter == 1 ? 'checked' : '') ?>>
      <label class="form-check-label" for="all">View All Letters</label>
    </div>
  </div>
  </form>
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
          <th scope="col"><input type="checkbox" id="select_all" /></th>
          <th scope="col">Letter To</th>
          <th scope="col">Created</th>
          <th scope="col">Print Status</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
          
 <?php
 if ($letterFilter == 0):
$creditBureaus = [
    'equifax' => ['label' => 'Equifax', 'status_field' => 'equi_status','account' => 'equi_ac'],
    'experian' => ['label' => 'Experian', 'status_field' => 'exper_status','account' => 'exper_ac'],
    'transUnion' => ['label' => 'TransUnion', 'status_field' => 'tu_status','account' => 'tu_ac']
];
$disputeItems = $disputeItems ?? []; // Initialize if not already set
foreach ($disputeItems as $item):
    foreach ($creditBureaus as $key => $info):
        if ($item->$key == 1):
            $statusField = $info['status_field'];
            $accountField = $info['account'];
            $status = $item->$statusField;
            $account = $item->$accountField;
?>
<tr>
  <td><input type="checkbox" class="row_checkbox" data-formate="<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_formate) ? htmlspecialchars($clientSaveLatter[0]->letter_formate) : '' ?>" data-id="<?= $item->id ?>" data-instruction ="<?= $item->instruction ?>" data-status="<?= $statusField ?>" data-bureau="<?= $key ?>" data-account="<?= $account ?>" data-reason="<?= $item->reason ?>" /></td>
  <td>
     <?php
$letterName = isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_name) ? $clientSaveLatter[0]->letter_name : '';
$label = isset($info['label']) ? strtolower($info['label']) : '';
echo $letterName . "_" . $label;
?>

  </td>
  <td><?php echo timeAgo($clientSaveLatter[0]->created_at); ?></td>
  <td>
   <span class="badge bg-warning text-dark">
    <?php 
    if ($status == 'Negative') {
        echo "Pending Print";
    } elseif ($status == 'In Dispute') {
        echo "Printed/Sent";
    }
    ?>
</span>

  </td>
  <td>
        <button class="btn btn-sm btn-outline-primary me-2 preview-row" data-formate="<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_formate) ? htmlspecialchars($clientSaveLatter[0]->letter_formate) : '' ?>" data-name="<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_name) ? htmlspecialchars($clientSaveLatter[0]->letter_name) : '' ?>"  data-id="<?= $item->id ?>" data-bureau="<?= $key ?>" data-company="<?= $item->instruction ?>" data-reason="<?= $item->reason ?>" data-account="<?= $account ?>" data-created="<?= $clientSaveLatter[0]->created_at ?>">View/Edit</button>
<i class="fas fa-trash-alt text-danger delete-row" data-id="<?= $item->id ?>" data-bureau="<?= $key ?>" style="cursor: pointer; float:right;"></i>
  </td>
</tr>
<?php
        endif;
    endforeach;
endforeach;
else:
    $creditBureaus = [
    'equifax' => ['label' => 'Equifax', 'status_field' => 'equi_status','account' => 'equi_ac'],
    'experian' => ['label' => 'Experian', 'status_field' => 'exper_status','account' => 'exper_ac'],
    'transUnion' => ['label' => 'TransUnion', 'status_field' => 'tu_status','account' => 'tu_ac']
];

 foreach ($alldisputeItems as $item):
    foreach ($creditBureaus as $key => $info):
        if ($item->$key == 1):
            $statusField = $info['status_field'];
            $accountField = $info['account'];
            $status = $item->$statusField;
            $account = $item->$accountField;
?>
<tr>
  <td><input type="checkbox" class="row_checkbox" data-formate="<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_formate) ? htmlspecialchars($clientSaveLatter[0]->letter_formate) : '' ?>" data-id="<?= $item->id ?>" data-status="<?= $statusField ?>" data-bureau="<?= $key ?>" data-account="<?= $account ?>" data-reason="<?= $item->reason ?>" /></td>
  <td>
           <?php
$letterName = isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_name) ? $clientSaveLatter[0]->letter_name : '';
$label = isset($info['label']) ? strtolower($info['label']) : '';
echo $letterName . "_" . $label;
?>
  </td>
  <td><?php echo timeAgo($clientSaveLatter[0]->created_at); ?></td>
  <td>
    <span class="badge bg-warning text-dark">
    <?php 
    if ($status == 'Negative') {
        echo "Pending Print";
    } elseif ($status == 'In Dispute') {
        echo "Printed/Sent";
    }
    ?>
</span>

  </td>

  <td>
        <button class="btn btn-sm btn-outline-primary me-2 preview-row" data-formate="<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_formate) ? htmlspecialchars($clientSaveLatter[0]->letter_formate) : '' ?>"  data-name="<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_name) ? htmlspecialchars($clientSaveLatter[0]->letter_name) : '' ?>"  data-id="<?= $item->id ?>" data-bureau="<?= $key ?>" data-company="<?= $item->furnisher ?>" data-reason="<?= $item->reason ?>"  data-account="<?= $account ?>">View/Edit</button>
<i class="fas fa-trash-alt text-danger delete-row" data-id="<?= $item->id ?>" data-bureau="<?= $key ?>" style="cursor: pointer; float:right;"></i>
  </td>
</tr>
<?php
        endif;
    endforeach;
endforeach;
endif;
?>


      </tbody>
    </table>
  </div>

  <!-- Letter Table -->


          <div class="step-nav d-flex justify-content-end mt-3">
            <button class="btn btn-primary next-btn">Next</button>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="step" data-step="2">
        <h5 class="step-title">2: Attach Documents</h5>
        <div class="step-content">
          <p class="mb-3">Where do you want to include ID attachments? (Typically only needed for Round 1)  </p>
            <!-- Filter Radio -->
  <div class="filter d-flex gap-4 mb-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="docFilter" value="0" checked>
      <label class="form-check-label mr-2" for="0">Include ID attachments on:</label>
    </div>  
    <div class="form-check">
      <input class="form-check-input" type="radio" name="docFilter" value="0" checked>
      <label class="form-check-label mr-2" for="0">All round 1 letters (Recommended)</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="docFilter" id="all" value="1">
      <label class="form-check-label" for="all">All letters (Not Recommended)</label>
    </div>
     <div class="form-check">
      <input class="form-check-input" type="checkbox" name="docFilter" id="all" value="2" checked>
      <label class="form-check-label" for="all">Include return address on envelope (Recommended)</label>
    </div>
  </div>
    <div class="document-upload">
          <?php foreach ($client_docs as $document): ?>
            <?php if ($document->document_type !== 'digital_signature' && $document->document_type !== 'agreement'): ?>
                <div class="">
                    <img src="<?= $document->document_path ?>" style="width:auto" height="70" class="mb-1">
                    <div class="small font-weight-bold">
                        <?= ucwords(str_replace('_', ' ', $document->document_type)) ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-sm btn-outline-primary me-2 previewWithLetterAttachments">Generate Letter Preview(s)</button>
          </div>

          <div class="step-nav d-flex justify-content-end mt-3">
            <button class="btn btn-secondary back-btn mr-2">Back</button>
            <button class="btn btn-primary next-btn">Next</button>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="step" data-step="3">
        <h5 class="step-title">3: Select Print & Mail Methods</h5>
        <div class="step-content">
          <p>Select an automated delivery method or choose to print at home.</p>
          <div class="mail-method d-flex gap-3 flex-wrap">
              <div class="method-box selected" data-method="email">
                <h4>Electronic Mailing</h4><br/><br/><br/>
                <p>Print at home or office and mail your letters from your local USPS</p>
              </div>
        
            </div>
            <input type="hidden" id="selectedMethod" name="selected_method" value="email">

<div class="mailicon" style="text-align: right; padding: 10px; position: relative;">
    <img src="<?php echo base_url('assets/img/lob.png'); ?>" 
         style="height: 16px; cursor: pointer;" 
         alt="Company Logo">
         
    <span class="tooltip-container" style="margin-left: 8px; font-size: 18px; color: #007bff; cursor: pointer;">
        ℹ️
        <span class="tooltip-text">Lob is our mail distributor partner responsible for generating the letter and sending it to USPS.</span>
    </span>
</div>
          <div class="step-nav d-flex justify-content-end mt-3">
            <button class="btn btn-secondary back-btn mr-2">Back</button>
            <button class="btn btn-primary" id="finalbtn">Next</button>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="step" data-step="4">
        <h5 class="step-title">4: Confirm Letter Sending Options</h5>
        <div class="step-content">
          
          <div class="step-nav d-flex justify-content-end mt-3">
            <button class="btn btn-secondary back-btn mr-2">Back</button>
            <button class="btn btn-success finish-btn">Finish</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


    </div>
  </div>
</div>
<!-- Bootstrap Modal -->
<div class="modal fade" id="PreivewModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Preview Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <input type="hidden" id="item_id"/>
           <span style="margin-bottom: 10px">Letter envelope information</span>
                 <div class="form-group row mt-3" id="envelope_address">
                      <div class="col-md-6">
                        <label style="font-size: 17px !important;">Send From Address:</label><br>
                        <span class="cloudmailAddress clientName"></span><br>
                        <span class="cloudmailAddress clientAddress"></span><br>
                        <span class="cloudmailAddress clientFullAddress"></span>
                      </div>
                      <div class="col-md-6">
                        <label style="font-size: 17px !important;">Send To Address:</label><br>
                        <span class="cloudmailAddress companyName"></span><br>
                        <span class="cloudmailAddress companyAddress"></span><br>
                        <span class="cloudmailAddress companyFullAddress"></span>
                      </div>
                 </div>
                 <h4 style="margin-top: 10px">Title:<span class="tittlepr"></span></h4>
            <div class="row d-none" id="printthissec">
              <div class="col-md-12">
                <div class="form-group row" style="padding: 10px 20px;">
                  <textarea cols="30" rows="20" name="content" id="contentTextarea">
                  </textarea>
                </div>
              </div>
            </div>
         
             <div class="form-group row" style="padding: 0 20px;float:right;">
                  
              <button type="button" class="btn btn-success btn-icon-text" id="save_letter" style="margin-right: 10px;">Save For Later</button>
            </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="previewWithLetterAttachmentsModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Preview Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row" style="padding: 10px 20px;">
                  <div class="contentTextareas" id="contentTextareas">
                  </div>
                </div>
              </div>
            </div>

        </div>
      </div>
    </div>
</div>
<div id="pdfContent" style="display:none;"></div>
<div class="modal fade" id="finalModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Preview Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="pdfdownload">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row" style="padding: 10px 20px;">
                  <div class="contentTextareas">
                  </div>
                </div>
              </div>
            </div>

        </div>
         <div class="form-group row" style="padding: 0 20px;justify-content: right;">
               <button type="button"class="btn btn-success btn-icon-text mr-2" id="generatePDF">Download as PDF</button>
              <button type="button" class="btn btn-success btn-icon-text" id="confirmbtn" style="margin-right: 10px;">Print</button>
            </div>
      </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
let currentStep = 1;
const totalSteps = 4;
  const selectedIds = [];
  const selectedbureau = [];
    const selectedaccount = [];
    const selectedstatus = [];
    const selectedreson = [];
    const selectedins = [];
    const selectedformate = [];
function updateSteps() {
  // Hide all steps first
  $('.step').each(function () {
    const stepNum = parseInt($(this).attr('data-step'));
    if (stepNum === currentStep) {
      $(this).addClass('active');
      $(this).find('.step-content').show();  // Show active step content
    } else {
      $(this).removeClass('active');
      $(this).find('.step-content').hide();  // Hide non-active step content
    }
  });

  // Update visibility of Next and Back buttons
  if (currentStep === totalSteps) {
    $('.next-btn').hide();  // Hide Next button on last step
    $('.finish-btn').show(); // Show Finish button on last step
  } else {
    $('.next-btn').show();  // Show Next button
    $('.finish-btn').hide(); // Hide Finish button
  }

  if (currentStep === 1) {
    $('.back-btn').hide();  // Hide Back button on first step
  } else {
    $('.back-btn').show();  // Show Back button for subsequent steps
  }
}

$(document).on('click', '.next-btn', function () {
       console.log($('.row_checkbox:checked').length);
if (currentStep === 1) {

  $('.row_checkbox:checked').each(function() {
    selectedIds.push($(this).data('id'));
     selectedbureau.push($(this).data('bureau'));
     selectedaccount.push($(this).data('account'));
          selectedstatus.push($(this).data('status'));
           selectedreson.push($(this).data('reason'));
           selectedins.push($(this).data('instruction'));
              selectedformate.push($(this).data('formate'));
  });

  if (selectedIds.length === 0) {
    alert('Please select at least one item before proceeding.');
    return false; 
  }

  console.log('Selected IDs:', selectedIds);
}


  // Proceed to next step
  if (currentStep < totalSteps) {
    currentStep++;  // Move to the next step
    updateSteps();  // Update the displayed step
  }
});

$(document).on('click', '.back-btn', function () {
  if (currentStep > 1) {
    currentStep--;  // Go back to the previous step
    updateSteps();  // Update the displayed step
  }
});

$(document).on('click', '.finish-btn', function () {
  alert("All steps completed!");
  // You can also add your form submission logic here.
});

// Initialize the first step on page load
$(document).ready(function () {
  updateSteps();
});

</script>
<script>
$(document).ready(function() {
  // Select/Deselect All
  $('#select_all').on('change', function() {
   
    $('.row_checkbox').prop('checked', $(this).prop('checked'));
  });

  // If any checkbox is unchecked, uncheck the "select all" checkbox
  $('.row_checkbox').on('change', function() {
    if (!$(this).prop('checked')) {
      $('#select_all').prop('checked', false);
    }

    // If all checkboxes are checked, set "select all" as checked
    if ($('.row_checkbox:checked').length === $('.row_checkbox').length) {
      $('#select_all').prop('checked', true);
    }
  });

//   $('#yourCustomButton').on('click', function() {
//     const selectedIds = [];
//     $('.row_checkbox:checked').each(function() {
//       selectedIds.push($(this).data('id'));
//     });
//     console.log('Selected IDs:', selectedIds);
//   });

$('.delete-row').on('click', function() {
  const itemId = $(this).data('id');
  const bureau = $(this).data('bureau');

          if (confirm('Are you sure you want to delete this letter? This will permanently delete this letter from this client`s account too.')) {
            $.ajax({
              url: '<?= base_url("Admin/client_dispute_item_bureau_remove") ?>',
              type: 'POST',
              data: { id: itemId, bureau: bureau },
              success: function(response) {
                 location.reload(); 
              }.bind(this),
              error: function() {
                alert('Error with AJAX request.');
              }
            });
          }
        });
$('.preview-row').on('click', function() {
   const formate = $(this).data('formate');
  
      const itemId = $(this).data('id');
      const created = $(this).data('created');

     $("#item_id").val(itemId);
  const bureau = $(this).data('bureau');
  const name = $(this).data('name');
    const company = $(this).data('company');
      const account = $(this).data('account');
        const reason = $(this).data('reason');
      $('.tittlepr').text(name+ '_' +bureau);
var companyName, companyAddress, companyFullAddress;

switch (bureau) {
  case 'equifax':
    companyName = "Equifax";
    companyAddress = "P.O. Box 740241";
    companyFullAddress = "Atlanta, GA 30374";
    break;

  case 'experian':
    companyName = "Experian";
    companyAddress = "P.O. Box 4500";
    companyFullAddress = "Allen, TX 7501";
    break;

  case 'transUnion':
    companyName = "TransUnion";
    companyAddress = "P.O. Box 2000, Chester";
    companyFullAddress = "Chester, PA 19016";
    break;
}

// Set values in the DOM
$('.companyName').text(companyName);
$('.companyAddress').text(companyAddress);
$('.companyFullAddress').text(companyFullAddress);

      $('.clientName').text("<?= $name ?>");
    $('.clientAddress').text("<?= $clientAddress ?>");
$('.clientFullAddress').text("<?= $clientFullAddress ?>");
      $('#PreivewModal').modal('show');
      $('#printthissec').removeClass('d-none').addClass('d-block');
      
      
    var message = `<?= $name ?><br><?= $clientAddress ?><br><?= $clientFullAddress ?><br>
Date of Birth: <?= $client[0]->sq_dob ?><br>#<?= $client[0]->sq_ssn ?><br><br>
<?= date('m/d/y') ?><br><br>
${companyName}<br>${companyAddress}<br>${companyFullAddress}<br><br>
Re: Letter to Remove Inaccurate Credit Information<br><br>
I received a copy of my credit report and found the following item(s) to be in error:<br><br>
1. ${reason}<br>${company}<br>Account Number:${account}<br>Please remove it from my credit report.<br><br><br>
By the provisions of the Fair Credit Reporting Act, I demand that these items be investigated and removed from my report. It is my understanding that you will recheck these items with the creditor who has posted them. Please remove any information that the creditor cannot verify. I understand that under 15 U.S.C. Sec. 1681i(a), you must complete this reinvestigation within 30 days of receipt of this letter.<br><br>
Please send an updated copy of my credit report to the above address. According to the act, there shall be no charge for this updated report. I also request that you please send notices of corrections to anyone who received my credit report in the past six months.<br><br>
Thank you for your time and help in this matter.<br><br>
Sincerely,<br><br>
<img id="img-signature" src="<?= $client[0]->agreement_path ?>" alt="Saved Signature"><br>
_____________________________________<br><?= $name ?>`;

 if(formate != '1'){
let formates = $(this).data('formate');
formates = formates
  .replace(/{client_first_name}/g, "<?= $client[0]->sq_first_name; ?>")
  .replace(/{client_last_name}/g, "<?= $client[0]->sq_last_name; ?>")
  .replace(/{client_address}/g, "<?= $clientAddress ?>")
  .replace(/{ss_number}/g, "<?= $client[0]->sq_ssn; ?>")
  .replace(/{bdate}/g, "<?= $client[0]->sq_dob; ?>")
  .replace(/{t_no}/g, "<?= $client[0]->sq_phone_mobile; ?>")
  .replace(/{client_suffix}/g, "<?= $client[0]->sq_suffix; ?>")
  .replace(/{client_middle_name}/g, "<?= $client[0]->sq_middle_name; ?>")
  .replace(/{client_email}/g, "<?= $client[0]->sq_email; ?>")
  .replace(/{dispute_item_and_explanation}/g, "")
  .replace(/{bureau_name}/g, "")
  .replace(/{bureau_address}/g, "")
  .replace(/{client_previous_address}/g, "<?= trim(($client[0]->sq_p_city ?? '') . ' ' . ($client[0]->sq_p_state ?? '') . ' ' . ($client[0]->sq_p_zipcode ?? '')) ?>")
  .replace(/{client_signature}/g, "<img id='img-signature' src='<?= $client[0]->agreement_sign; ?>' alt='Saved Signature'>")
  .replace(/{CLIENT NAME}/g, "<?= $name ?>")
  .replace(/{CLIENT ADDRESS}/g, "<?= $clientAddress ?>")
  .replace(/{CLIENT FULL ADDRESS}/g, "<?= $clientFullAddress ?>")
  .replace(/{curr_date}/g, "<?= date('Y-m-d') ?>")
  .replace(/{TODAY'S DATE}/g, "<?= date('m/d/y') ?>")
  .replace(/{COMPANY WEBSITE}/g, "<?= base_url() ?>")
  .replace(/{COMPANY LOGO}/g, '<img src="<?= base_url('assets/images/logo.png') ?>" alt="Company Logo" id="simple_audit_logo" style="min-width:55px; height:55px;">');



tinymce.get('contentTextarea').setContent(formates);
}

else{
 tinymce.get('contentTextarea').setContent(message);
   
}


});
    $('#save_letter').on('click', function() {
  const itemId = $("#item_id").val();
  const client_letter = tinymce.get('contentTextarea').getContent().trim();

  $.ajax({
    type: 'POST',
    url: '<?= base_url("update_client_letter"); ?>',
    data: {
      id: <?= $client[0]->sq_client_id ?>,
       client_letter: tinymce.get('contentTextarea').getContent().trim()
    },
    success: function(response) {
      let res = JSON.parse(response);
      alert("Letter updated successfully!");
      $('#PreivewModal').modal('hide');
    },
    error: function() {
      alert('Error saving letter.');
    }
  });
});
});
$(document).ready(function() {
       let companyName = '';
    let companyAddress = '';
    let companyFullAddress = '';
    let accounts ='';
    let instruction='';
        accounts = $(this).data('account');
         
         let letters = '';
    function preview(){
            letters = '';
  selectedIds.forEach((id, index) => {
    const bureau = selectedbureau[index];
    const account = selectedaccount[index];
     const reason = selectedreson[index];
const instruction = selectedins[index];
const formatedata = selectedformate[index];
console.log(formatedata);
    switch (bureau) {
      case 'equifax':
        companyName = "Equifax";
        companyAddress = "P.O. Box 740241";
        companyFullAddress = "Atlanta, GA 30374";
        break;
      case 'experian':
        companyName = "Experian";
        companyAddress = "P.O. Box 4500";
        companyFullAddress = "Allen, TX 7501";
        break;
      case 'transUnion':
        companyName = "TransUnion";
        companyAddress = "P.O. Box 2000, Chester";
        companyFullAddress = "Chester, PA 19016";
        break;
    }
 if(formatedata != '1'){
     let formatedatas = selectedformate[index];
formatedatas = formatedatas
  .replace(/{client_first_name}/g, "<?= $client[0]->sq_first_name; ?>")
  .replace(/{client_last_name}/g, "<?= $client[0]->sq_last_name; ?>")
  .replace(/{client_address}/g, "<?= $clientAddress ?>")
  .replace(/{ss_number}/g, "<?= $client[0]->sq_ssn; ?>")
  .replace(/{bdate}/g, "<?= $client[0]->sq_dob; ?>")
  .replace(/{t_no}/g, "<?= $client[0]->sq_phone_mobile; ?>")
  .replace(/{client_suffix}/g, "<?= $client[0]->sq_suffix; ?>")
  .replace(/{client_middle_name}/g, "<?= $client[0]->sq_middle_name; ?>")
  .replace(/{client_email}/g, "<?= $client[0]->sq_email; ?>")
  .replace(/{dispute_item_and_explanation}/g, "")
  .replace(/{bureau_name}/g, "")
  .replace(/{bureau_address}/g, "")
  .replace(/{client_previous_address}/g, "<?= trim(($client[0]->sq_p_city ?? '') . ' ' . ($client[0]->sq_p_state ?? '') . ' ' . ($client[0]->sq_p_zipcode ?? '')) ?>")
  .replace(/{client_signature}/g, "<img id='img-signature' src='<?= $client[0]->agreement_sign; ?>' alt='Saved Signature'>")
  .replace(/{CLIENT NAME}/g, "<?= $name ?>")
  .replace(/{CLIENT ADDRESS}/g, "<?= $clientAddress ?>")
  .replace(/{CLIENT FULL ADDRESS}/g, "<?= $clientFullAddress ?>")
  .replace(/{curr_date}/g, "<?= date('Y-m-d') ?>")
  .replace(/{TODAY'S DATE}/g, "<?= date('m/d/y') ?>")
  .replace(/{COMPANY WEBSITE}/g, "<?= base_url() ?>")
  .replace(/{COMPANY LOGO}/g, '<img src="<?= base_url('assets/images/logo.png') ?>" alt="Company Logo" id="simple_audit_logo" style="min-width:55px; height:55px;">');
     
    letters +=formatedatas;
  
     
 }

else{
 letters += `
      <div class="single-letter p-3 mb-4 border rounded shadow-sm">
        <?= $name ?><br><?= $clientAddress ?><br><?= $clientFullAddress ?><br>
        Date of Birth: <?= $client[0]->sq_dob ?><br>#<?= $client[0]->sq_ssn ?><br><br>
        <?= date('m/d/y') ?><br><br>
        ${companyName}<br>${companyAddress}<br>${companyFullAddress}<br><br>
        Re: Letter to Remove Inaccurate Credit Information<br><br>
        I received a copy of my credit report and found the following item(s) to be in error:<br><br>
        1. ${reason}<br>${instruction}<br>Account Number: ${account}<br>Please remove it from my credit report.<br><br>
        By the provisions of the Fair Credit Reporting Act, I demand that these items be investigated and removed from my report. It is my understanding that you will recheck these items with the creditor who has posted them. Please remove any information that the creditor cannot verify. I understand that under 15 U.S.C. Sec. 1681i(a), you must complete this reinvestigation within 30 days of receipt of this letter.<br><br>
        Please send an updated copy of my credit report to the above address. According to the act, there shall be no charge for this updated report. I also request that you please send notices of corrections to anyone who received my credit report in the past six months.<br><br>
        Thank you for your time and help in this matter.<br><br>
        Sincerely,<br><br>
        <img id="img-signature" src="<?= $client[0]->agreement_path ?>" alt="Saved Signature"><br>
        _____________________________________<br><?= $name ?>
      </div>
    `;   
}
   
     <?php foreach ($client_docs as $document): ?>
      <?php if ($document->document_type !== 'digital_signature' && $document->document_type !== 'agreement'): ?>
          letters += `<div><img src="<?= $document->document_path ?>" style="width:100%" height="100%" class="mb-1"></div>`;
      <?php endif; ?>
  <?php endforeach; ?>
  
  });
  $('.contentTextareas').html(letters);
    }
    
    
    
 $('.previewWithLetterAttachments').on('click', function() {
  $('#previewWithLetterAttachmentsModal').modal('show');
  preview();
});
 $('#finalbtn').on('click', function() {
  $('#finalModal').modal('show');
  preview();
  });
  
 $("#confirmbtn").on('click', function() {
  if (confirm('Are you ready to print all selected letters now? Clicking OK will generate a PDF file for you to download and print yourself on your own printer. In CRC they will be marked as printed.')) {

    // Gather your data here (example fields; replace with your actual values)
    let dataToSend = {
        client_Id:"<?= $client[0]->sq_client_id ?>",
      client_name: "<?= $name ?>",
      client_address: "<?= $clientAddress ?>",
      client_full_address: "<?= $clientFullAddress ?>",
      dob: "<?= $client[0]->sq_dob ?>",
      ssn: "<?= $client[0]->sq_ssn ?>",
      company_name: companyName,
      letters:letters,
      company_address: companyAddress,
      company_full_address: companyFullAddress,
      account_number: accounts,
      selectedIds:selectedIds,
      selectedbureau:selectedbureau,
    letter_name: "<?= isset($clientSaveLatter[0]) && isset($clientSaveLatter[0]->letter_name) ? addslashes($clientSaveLatter[0]->letter_name) : '' ?>",

      selectedstatus:selectedstatus,
      signature_path: "<?= $client[0]->agreement_path ?>",
      documents: [
        <?php foreach ($client_docs as $document): ?>
          <?php if ($document->document_type !== 'digital_signature' && $document->document_type !== 'agreement'): ?>
            "<?= $document->document_path ?>",
          <?php endif; ?>
        <?php endforeach; ?>
      ]
    };

    // AJAX request
    $.ajax({
      url: '<?= base_url("Lob/dispute_send_letter") ?>', 
      type: 'POST',
      data: JSON.stringify(dataToSend),
      contentType: 'application/json',
       beforeSend: function() {
    $('#loader').show(); // Show loader before request
  },
  success: function(response) {
      let res = JSON.parse(response);
      console.log(res);
      if(res.status === 'success'){
      alert(res.message);
  
           window.open('<?= base_url("downloads/dispute_letter/credit_dispute_letter_"); ?>' + res.client_Id + '.pdf', '_blank');
       window.location.href = '<?= base_url("letters-status/$client_id"); ?>';
          }
      else{
          
            alert(res.message);
      }
  },

  error: function(xhr, status, error) {
    alert('An error occurred while sending the letter.');
    console.error('Error:', error);
  },

  complete: function() {
    $('#loader').hide(); // Hide loader after success or error
  }
    });
  }
});

    //  $("#generatePDF").on('click', function() {
   
    //         html2pdf().from(letters).save('credit_dispute_letter.pdf');
    //  });  

});

</script>

<script>
  document.querySelectorAll('input[name="letterFilter"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      document.getElementById('filterForm').submit();
    });
  });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  document.getElementById("generatePDF").addEventListener("click", async function () {
    const { jsPDF } = window.jspdf;

    const pdfContent = document.getElementById("pdfdownload");

    html2canvas(pdfContent).then((canvas) => {
      const imgData = canvas.toDataURL("image/png");
      const pdf = new jsPDF("p", "mm", "a4");

      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
      pdf.save("download.pdf");
    });
  });
</script>

