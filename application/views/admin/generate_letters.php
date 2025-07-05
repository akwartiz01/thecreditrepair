<?php
$us_states = $this->config->item('us_states');

$name = trim(($client[0]->sq_first_name ?? '') . ' ' . ($client[0]->sq_last_name ?? ''));
$clientAddress = trim(($client[0]->sq_mailing_address ?? ''));
$clientFullAddress = trim(($client[0]->sq_city ?? '') . ' ' . ($client[0]->sq_state ?? '') . ' ' . ($client[0]->sq_zipcode ?? ''));

$client_id = get_encoded_id($client[0]->sq_client_id);
$template_category = $this->db->get('sq_template_category');

?>

<style>
#letter-container{
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    }
  .mce-notification {
    display: none;
  }
  .btn-generate-unique {
    background-color: #0d6efd;
    color: white;
}
#latterEdit .card-body {
    padding: 3.5rem 2.5rem;
}
.tab-content {
    border: 1px solid #dee2e6!important;
    margin-top: 0px !important;
}

.nav-tabs, .tab-content {
    border: 1px solid #dee2e6!important;
}
.numspam{
        border-radius: 50%;
       background: #0075cc;
    padding: 3px 5px;
    color: #fff;
    font-size: 11px !important;
    margin-right: 10px;
}
.heading-h4{
        font-size: 32px !important;
    margin-bottom: 24px !important;
    font-weight: 400 !important;
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
  body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 20px;
    color: #343a40;
  }

  h2 {
    color: #343a40;
  }

  #dispute-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }

  .step-title {
    font-weight: bold;
    margin-bottom: 10px;
  }

  .radio-group {
    margin-bottom: 20px;
  }

  .radio-group label {
    display: block;
    margin-bottom: 5px;
  }

  .link {
    color: #1a73e8;
    text-decoration: none;
    font-size: 14px;
  }

  .link:hover {
    text-decoration: underline;
  }

  .btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
  }

  #btn-saved-dispute {
    background-color: #28a745;
    color: white;
    margin-right: 10px;
  }

  #btn-new-dispute {
    background-color: #e0e0e0;
    color: #555;
  }

  #btn-generate-unique {
    background-color: #0d6efd;
    color: white;
  }

  #dispute-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }

  #dispute-table th,
  #dispute-table td {
    padding: 12px;
    border-bottom: 1px solid #ccc;
    text-align: left;
  }

  #dispute-table th {
    background-color: #f1f1f1;
  }

  .no-data {
    text-align: center;
    padding: 20px;
    color: #999;
  }

  #btn-container {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
  }

  #btn-generate-library {
    background-color: #e0e0e0;
    color: #555;
    margin-right: 10px;
  }

  #link-generate-letter {
    float: right !important;
  }

  .radio-group label {
    margin-bottom: 20px !important;
  }

  .step-title {
    margin-bottom: 20px !important;
  }

  input[type="radio"],
  input[type="checkbox"] {

    margin-right: 10px !important;
  }


  .text-success {
    color: #3972fc !important;
  }
  .btn-container{
      margin-top: 20px;
    display: flex;
    justify-content: flex-end;
  }
</style>


<!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>-->

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

    <a href="<?= base_url(); ?>generate-letters/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link active">
      <span class="step-num">3</span> Generate Letters
    </a>

    <a href="<?= base_url(); ?>send_letter/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
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
    
<input type="hidden" id="selComqui">
<input type="hidden" id="selComexper">
<input type="hidden" id="selComtu">
      <div class="card" id="disputeWizard">
        <div class="card-body">

          <h2>Dispute Wizard (<?php echo $name; ?>)</h2>

          <p>
            Build a dispute letter by either selecting saved dispute items or adding new items manually.
            <!-- <a href="#" class="link" id="link-quick-video">Quick Video</a> -->
          </p>

          <div id="dispute-container">
            <div class="step-title">Step 1: Choose Letter Type</div>
            <div class="radio-group" id="radio-group-letter-type">
              <label>
                <input type="radio" name="letter_type" id="basic_dispute" checked>Round 1 <em>Basic Dispute</em><br/><br/>
                <input type="radio" name="letter_type" id="other_dispute">Round 2+ <em>All Other Letters</em>
              </label>

            </div>

          </div>

          <div id="dispute-container">
            <div class="step-title">Step 2: Add Dispute Items</div>
            <p>
              To ensure your disputes are taken seriously and not rejected by the credit bureaus, we advise limiting the number of dispute items to 5 per month per bureau (unless it involves identity theft with a police report).
            </p>
            <button class="btn mb-3" id="btn-saved-dispute">+ Saved Dispute Item</button>
            <button type="button" class="btn mb-3" id="btn-new-dispute">+ New Dispute Item</button>

<div class="table-responsive">
            <table class="table table-bordered shadow-sm mt-3">

              <thead class="thead-light">
                <tr>
                  <th>Creditor/Furnisher</th>
                  <th>Account #</th>
                  <th>Dispute Items</th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 30px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 30px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 30px !important; width: auto !important;"></th>
                  <th></th>
                </tr>
              </thead>

              <tbody id="selectedItemsBody">
                 <tr class="no-data">
                    <td colspan="7" class="text-center text-muted">No dispute items found.</td>
                  </tr>
              </tbody>
            </table>
            </div>


            <div id="btn-container" class="r2">
              <button class="btn btn-generate-library" id="btn-generate-library">Generate Library Letter</button>
              <button class="btn btn-generate-library" id="btn-generate-unique">Generate Unique AI Letter</button>
            </div>
            <div class="btn-container">
                 <button class="btn btn-generate-unique" id="r2s" style="display:none">Save and Continue</button>
            </div>
           
          </div>
        <div id="letter-container" style="display:none">
            <div class="step-title">Step 3: Choose A Letter</div>
 <div class="row">
     <div class="col-12 col-md-4">
         <div class="form-group">
             <label>Letter Category <span class="text-danger">*</span></label>
<select class="form-control" name="category" id="categoryDropdown">
  <option value="">Select a Category</option>
  <option value="0">All</option>
  <?php foreach ($template_category->result() as $cat): ?>
    <option value="<?= $cat->id; ?>"><?= htmlspecialchars($cat->category_name); ?></option>
  <?php endforeach; ?>
</select>



         </div>
     </div>
     <div class="col-12 col-md-4">
         <div class="form-group">
             <label>Letter Name  <span class="text-danger">*</span></label>
             <select class="form-control" id="letterDropdown" name="letter">
                   <option value="">Select a Letter</option>
             </select>
         </div>
     </div>
     
 </div>
     <div id="btn-container">
              <button class="btn btn-generate-librarys" id="btn-generate-library">Generate Library Letter</button>
              <button class="btn btn-generate-librarys" id="btn-generate-unique">Generate Unique AI Letter</button>
            </div>
            </div>
        </div>
      </div>
      <div class="card" id="latterEdit" style="display:none">
        <div class="card-body">
             <h2>Letter Editor (<?php echo $name; ?>)</h2>
             <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab"><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 20px !important; width: auto !important;"></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 20px !important; width: auto !important;"></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab"><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 20px !important; width: auto !important;"></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab">Client Docs</a>
                  </li>
                </ul>
                
                <div class="tab-content mt-3">
                  <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                      <span>Letter envelope information</span>
                      <div class="form-group row" id="envelope_address">
                          <div class="col-md-6">
                              <label style="font-size: 17px !important;">Send From Address:</label><br>
                           <span class="cloudmailAddress clientName"></span><br>
                            <span class="cloudmailAddress clientAddress"></span><br>
                            <span class="cloudmailAddress clientFullAddress"></span>
                          </div>
                          <div class="col-md-6">
                            <label style="font-size: 17px !important;">Send To Address:</label><br>
                            <span class="cloudmailAddress">Equifax</span><br>
                            <span class="cloudmailAddress">P.O. Box 740241</span><br>
                            <span class="cloudmailAddress">Atlanta, GA 30374</span>
                          </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="tab2" role="tabpanel">
                      <span>Letter envelope information</span>
                    <div class="form-group row" id="envelope_address">
                          <div class="col-md-6">
                             <label style="font-size: 17px !important;">Send From Address:</label><br>
                            <span class="cloudmailAddress clientName"></span><br>
                            <span class="cloudmailAddress clientAddress"></span><br>
                            <span class="cloudmailAddress clientFullAddress"></span>
                          </div>
                          <div class="col-md-6">
                            <label style="font-size: 17px !important;">Send To Address:</label><br>
                            <span class="cloudmailAddress">Experian</span><br>
                            <span class="cloudmailAddress">P.O. Box 4500</span><br>
                            <span class="cloudmailAddress">Allen, TX 75013</span>
                          </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="tab3" role="tabpanel">
                      <span>Letter envelope information</span>
                     <div class="form-group row" id="envelope_address">
                          <div class="col-md-6">
                            <label style="font-size: 17px !important;">Send From Address:</label><br>
                            <span class="cloudmailAddress clientName"></span><br>
                            <span class="cloudmailAddress clientAddress"></span><br>
                            <span class="cloudmailAddress clientFullAddress"></span>
                          </div>
                          <div class="col-md-6">
                            <label style="font-size: 17px !important;">Send To Address:</label><br>
                            <span class="cloudmailAddress">TransUnion</span><br>
                            <span class="cloudmailAddress">P.O. Box 2000, Chester</span><br>
                            <span class="cloudmailAddress">Chester, PA 19016</span>
                          </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="tab4" role="tabpanel">
                   <span><?php echo $name; ?> Documents</span>
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

                  </div>
                </div>
<input type="hidden" id="selectedIds" name="selectedIds">

             <div class="row d-none" id="printthissec">
              <div class="col-md-12">
                <div class="form-group row" style="padding: 10px 20px;">
                  <textarea cols="30" rows="20" name="content" id="contentTextarea">
                        
                  </textarea>
                </div>
           
              </div>
              
            </div>
             <div class="form-group row" style="padding: 0 20px;float:right;">
              <button type="button" class="btn btn-success btn-icon-text create_letter" id="save_letter" style="margin-right: 10px;">Save For Later</button>
              <button type="button" class="btn btn-success btn-icon-text create_letter" id="create_letter">Save and Continue to Print</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="SavedisputeModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add Saved/Pending Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
         <table class="table table-bordered shadow-sm mt-3">

              <thead class="thead-light">
                <tr>
                  <th><input type="checkbox" id="select_all"/></th>
                  <th>Creditor/Furnisher</th>
                  <th>Account #</th>
                  <th>Reason</th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 30px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 30px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 30px !important; width: auto !important;"></th>
                
                </tr>
              </thead>

              <tbody>
                   <?php if (!empty($dispute_items)): ?>
      <?php foreach ($dispute_items as $index => $item): ?>
        <tr data-id="<?= $item->id; ?>" data-equi="<?= $item->equi_status; ?>" data-exper="<?= $item->exper_status; ?>" data-tu="<?= $item->tu_status; ?>">
      <td><input type="checkbox" class="row_checkbox" value="<?= $item->id; ?>"/></td>
          <td><?= htmlspecialchars($item->furnisher) ?></td>
          <td>
            Equifax: <?= $item->equi_ac ?? '-' ?><br>
            Experian: <?= $item->exper_ac ?? '-' ?><br>
            Transunion: <?= $item->tu_ac ?? '-' ?>
          </td>
          <td><?= htmlspecialchars($item->reason) ?></td>

          <!-- Equifax Column -->
<!-- Equifax Column -->
<td class="text-center">
    <?= ($item->equi_status !== null && $item->equi_status !== '0') 
        ? ($item->equi_status === 'Negative' 
            ? '<i class="fas fa-times status-close" style="color: red;"></i><br>' . htmlspecialchars($item->equi_status) 
            : '<i class="fas fa-check status-check"></i><br>' . htmlspecialchars($item->equi_status)) 
        : '-' ?><br>
</td>

<!-- Experian Column -->
<td class="text-center">
    <?= ($item->exper_status !== null && $item->exper_status !== '0') 
        ? ($item->exper_status === 'Negative' 
            ? '<i class="fas fa-times status-close" style="color: red;"></i><br>' . htmlspecialchars($item->exper_status) 
            : '<i class="fas fa-check status-check"></i><br>' . htmlspecialchars($item->exper_status)) 
        : '-' ?><br>
</td>

<!-- TransUnion Column -->
<td class="text-center">
    <?= ($item->tu_status !== null && $item->tu_status !== '0') 
        ? ($item->tu_status === 'Negative' 
            ? '<i class="fas fa-times status-close" style="color: red;"></i><br>' . htmlspecialchars($item->tu_status) 
            : '<i class="fas fa-check status-check"></i><br>' . htmlspecialchars($item->tu_status)) 
        : '-' ?><br>
</td>


        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="7" class="text-center text-muted">No dispute items found.</td>
      </tr>
    <?php endif; ?>
              </tbody>
            </table>
</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success" id="addtoDispute">Add to Dispute</button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="disputeModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add New Dispute Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form id="disputeItemForm" class="form-sample" mehtod="post">
      <div class="modal-body">
          
        <div class="row">
          <div class="col-6">
            <div class="col">
<input type="hidden" id="id" value="<?php echo $client[0]->sq_client_id ?>"/>
              <label>Select Credit Bureaus <span class="text-danger">*</span></label>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="equifax" value="1" />
                <label class="form-check-label credit-bureau-logo" for="equifax">
                  <img src="<?php echo base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 30px !important;" alt="Equifax">
                </label>
              </div>

              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="experian" value="1" />
                <label class="form-check-label credit-bureau-logo" for="experian">
                  <img src="<?php echo base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 30px !important;" alt="Experian">
                </label>
              </div>

              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="transunion" value="1" />
                <label class="form-check-label credit-bureau-logo" for="transunion">
                  <img src="<?php echo base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 30px !important;" alt="TransUnion">
                </label>
              </div>

              <div class="form-group" style="margin-top: 30px !important;">
                <label>Account Number (Optional)</label>
                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="accountNumber" id="sameForAll" />
                    <label class="form-check-label" for="sameForAll">Same for all bureaus</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="accountNumber" id="differentForEach" />
                    <label class="form-check-label" for="differentForEach">Different for each bureau</label>
                  </div>
                </div>

              </div>


            </div>
          </div>

          <div class="col-6">

            <div class="col">
              <div class="form-group mt-3">
                <label>Creditor/Furnisher</label>
                <select class="form-control" id="creditor_furnisher">
                   <option value="0" selected>Search a Creditor/Furnisher</option>
    <?php if (!empty($furnishers)) : ?>
        <?php foreach ($furnishers as $furnisher) : ?>
            <option value="<?= htmlspecialchars($furnisher->company_name) ?>">
                <?= htmlspecialchars($furnisher->company_name) ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>
                </select>

              </div>


              <div class="form-group">
                <label>Reason <span class="text-danger">*</span></label>
                <select class="form-control" id="dispute_reason">
                  <option value="0" selected>Select a reason for your dispute</option>
                 <option value="Sample Reason">Sample Reason</option>
<option value="The following personal information is incorrect">The following personal information is incorrect</option>
<option value="The following account is not mine">The following account is not mine</option>
<option value="The status is incorrect for the following account">The status is incorrect for the following account</option>
<option value="The status is incorrect for the following account">The status is incorrect for the following account</option>
<option value="The following information is outdated. I would like it removed from my credit history report">The following information is outdated. I would like it removed from my credit history report</option>
<option value="The following inquiry is more than two years old and I would like it removed">The following inquiry is more than two years old and I would like it removed</option>
<option value="The inquiry was not authorized">The inquiry was not authorized</option>
<option value="The following accounts were closed by me and should state that">The following accounts were closed by me and should state that</option>
<option value="The following account was a Bankruptcy/Charge-off. Balance should be $0">The following account was a Bankruptcy/Charge-off. Balance should be $0</option>
<option value="Mistaken Identity">Mistaken Identity</option>
<option value="Identity Theft">Identity Theft</option>
<option value="Other information I would like changed">Other information I would like changed</option>
<option value="This is a duplicate account">This is a duplicate account</option>
<option value="The wrong amount is being reported">The wrong amount is being reported</option>
<option value="This is the wrong creditor for this item">This is the wrong creditor for this item</option>
<option value="Validate Account">Validate Account</option>
<option value="-">-</option>
<option value="Late Payments">Late Payments</option>
<option value="Charged Off">Charged Off</option>
<option value="Account Closed">Account Closed</option>
<option value="15 USC 1666 USC 1666B 12 CFR 1026.13 - Billing Error - Late Payments">15 USC 1666 USC 1666B 12 CFR 1026.13 - Billing Error - Late Payments</option>

                </select>

              </div>

              <div class="form-group">
                <label>Instruction</label>
                <select class="form-control" id="dispute_instructions">
                   <option value="0" selected>Choose instructions</option>
                     <option value="Please correct/update this inaccurate information on my credit report.">Please correct/update this inaccurate information on my credit report.</option>
                    <option value="Please remove this inaccurate information from my credit report." >Please remove this inaccurate information from my credit report.</option>
                    <option value="Please remove it from my credit report." >Please remove it from my credit report.</option>
                    <option value="This is not mine. I am a victim of ID Theft and I have included a police report. Please investigate and remove from my credit report.">This is not mine. I am a victim of ID Theft and I have included a police report. Please investigate and remove from my credit report.</option>
                    <option value="Please supply information on how you have verified this item.">Please supply information on how you have verified this item.</option>
                    <option value="This is not mine.">This is not mine.</option>
                    <option value="My parent has the same name as me." >My parent has the same name as me.</option>
                    <option value="Please investigate and delete from my credit report." >Please investigate and delete from my credit report.</option>
                    <option value="Please ensure that all information is accurate" >Please ensure that all information is accurate</option>
                    <option value="Please verify that the information is correct">Please verify that the information is correct</option>
                    <option value="Pursuant to 15 USC § 1681s-2 (a) Duty of Furnishers of Information to Provide Accurate information (1) Prohibition (A) Reporting information with actual knowledge of errors A person shall not furnish any information relating to a consumer to any consumer reporting agency if the person knows or has reasonable cause to believe that the information is inaccurate. " >Pursuant to 15 USC § 1681s-2 (a) Duty of Furnishers of Information to Provide Accurate information (1) Prohibition (A) Reporting information with actual knowledge of errors A person shall not furnish any information relating to a consumer to any consumer reporting agency if the person knows or has reasonable cause to believe that the information is inaccurate. </option>

                </select>

              </div>

            </div>
          </div>

          <div class="col-6">

            <div class="form-check" style="display: none;">
              <input type="text" class="form-control mt-2" id="account_number_all" placeholder="Enter account number">
            </div>

            <div class="form-check" style="display: none;">
              <label>Equifax</label>
              <input type="text" name="equifax_account" id="equifax_account" class="form-control">
            </div>

            <div class="form-check" style="display: none;">
              <label>Experian</label>
              <input type="text" name="experian_account" id="experian_account" class="form-control">
            </div>

            <div class="form-check" style="display: none;">
              <label>Transunion</label>
              <input type="text" name="transunion_account" id="transunion_account" class="form-control">
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success" id="add_btn_dispute_item">Save</button>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="letterSave" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Save Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="letterSaveForm" class="form-sample" method="post">
        <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Round</label>
              <select class="form-control" id="round" name="round">
                 <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Name of this letter</label>
              <input type="text" class="form-control mt-2" name="letter_name" id="letter_name" value="RD">
            </div>
          </div>

          <div class="form-group">
            <label>Abbreviation (Optional)</label>
              <input type="text" class="form-control mt-2" name="abbrevation" id="abbrevation">
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="follow_up" name="follow_up" checked>
            <label class="form-check-label" for="follow_up">
              Create task to follow-up on these disputed items in 45 days
            </label>
          </div>

          <p class="mt-3">Note: Only save once. This button saves all letters for all bureau tabs with 1 click</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="saveLettersBtn">Save All Letters</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- <script>
  $(document).ready(function() {
    function toggleAccountFields() {
      const sameForAll = $('#sameForAll').is(':checked');
      const differentForEach = $('#differentForEach').is(':checked');

      // If same for all, show only one input
      if (sameForAll) {
        $('#account_number_all').closest('.form-check').show();

        if ($('#equifax').is(':checked')) $('#equifax_account').closest('.form-check').hide();
        if ($('#experian').is(':checked')) $('#experian_account').closest('.form-check').hide();
        if ($('#transunion').is(':checked')) $('#transunion_account').closest('.form-check').hide();
      }

      // If different for each, show individual ones
      if (differentForEach) {
        $('#account_number_all').val('').closest('.form-check').hide();

        if ($('#equifax').is(':checked')) $('#equifax_account').closest('.form-check').show();
        if ($('#experian').is(':checked')) $('#experian_account').closest('.form-check').show();
        if ($('#transunion').is(':checked')) $('#transunion_account').closest('.form-check').show();
      }
    }

    // When radio buttons change
    $('#sameForAll, #differentForEach').change(function() {
      toggleAccountFields();
    });

    // When checkboxes change
    $('#equifax, #experian, #transunion').change(function() {
      toggleAccountFields();
    });

    // Save button click
    $('.btn-success').click(function() {
      const data = {
        bureaus: {
          equifax: $('#equifax').is(':checked'),
          experian: $('#experian').is(':checked'),
          transunion: $('#transunion').is(':checked')
        },
        account_mode: $('input[name="accountNumber"]:checked').attr('id'),
        account_number_all: $('#account_number_all').val(),
        equifax_account: $('#equifax_account').val(),
        experian_account: $('#experian_account').val(),
        transunion_account: $('#transunion_account').val(),
        creditor_furnisher: $('#creditor_furnisher').val(),
        dispute_reason: $('#dispute_reason').val(),
        dispute_instruction: $('#dispute_instructions').val()
      };

      $.ajax({
        url: '<?= base_url("Admin/save_dispute_item") ?>',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(res) {
          if (res.status === 'success') {
            alert('Dispute item saved!');
            $('#disputeModal').modal('hide');
          } else {
            alert('Error: ' + res.message);
          }
        },
        error: function() {
          alert('AJAX error. Please try again.');
        }
      });
    });
  });

  function loadDisputeItems() {
    $.ajax({
      url: '<?= base_url("Admin/get_dispute_items") ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        const tbody = $('#dispute-table tbody');
        tbody.empty();

        if (data.length === 0) {
          tbody.html('<tr><td class="no-data" colspan="6">No dispute items added</td></tr>');
        } else {
          data.forEach(item => {
            const eqIcon = item.equifax == 1 ? '<img src="NEGATIVE_ICON_URL" height="25">' : '';
            const exIcon = item.experian == 1 ? '<img src="NEGATIVE_ICON_URL" height="25">' : '';
            const tuIcon = item.transunion == 1 ? '<img src="NEGATIVE_ICON_URL" height="25">' : '';

            tbody.append(`
            <tr>
              <td>${item.creditor_furnisher}</td>
              <td>
                ${item.equifax_account ? 'EQ: ' + item.equifax_account + '<br>' : ''}
                ${item.experian_account ? 'EX: ' + item.experian_account + '<br>' : ''}
                ${item.transunion_account ? 'TU: ' + item.transunion_account : ''}
              </td>
              <td>${item.dispute_reason}</td>
              <td>${eqIcon}</td>
              <td>${exIcon}</td>
              <td>${tuIcon}</td>
            </tr>
          `);
          });
        }
      }
    });
  }
</script> -->

<script>
  let selectedIds = [];
  let selComqui= [];
   let selComexper= [];
   let selComtu= [];
            
            
  function getStatusHtml(status) {
    if (!status || status === '0') return '-';
    if (status === 'Negative') {
        return `<i class="fas fa-times status-close" style="color: red;"></i><br>${status}`;
    }
    return `<i class="fas fa-check status-check"></i><br>${status}`;
}

$('#sameForAll').click(function () {
    // Get checkbox states
    let transunion = $('#transunion').is(':checked') ? '1' : '0';
    let experian   = $('#experian').is(':checked') ? '1' : '0';
    let equifax    = $('#equifax').is(':checked') ? '1' : '0';

    // First hide all account fields
    $('#equifax_account').closest('.form-check').hide();
    $('#experian_account').closest('.form-check').hide();
    $('#transunion_account').closest('.form-check').hide();

    // Show only the ones that are checked
    if (equifax === '1') {
        $('#equifax_account').closest('.form-check').show();
    }

    if (experian === '1') {
        $('#experian_account').closest('.form-check').show();
    }

    if (transunion === '1') {
        $('#transunion_account').closest('.form-check').show();
    }

    // If any one is selected, show the "all" field too
    if (equifax === '1' || experian === '1' || transunion === '1') {
        $('#account_number_all').closest('.form-check').show();
    } else {
        $('#account_number_all').closest('.form-check').hide();
    }
});
$('#differentForEach').click(function () {
    // Get checkbox states
    let transunion = $('#transunion').is(':checked') ? '1' : '0';
    let experian   = $('#experian').is(':checked') ? '1' : '0';
    let equifax    = $('#equifax').is(':checked') ? '1' : '0';

    // First hide all account fields
    $('#equifax_account').closest('.form-check').hide();
    $('#experian_account').closest('.form-check').hide();
    $('#transunion_account').closest('.form-check').hide();

    // Show only the ones that are checked
    if (equifax === '1') {
        $('#equifax_account').closest('.form-check').show();
    }

    if (experian === '1') {
        $('#experian_account').closest('.form-check').show();
    }

    if (transunion === '1') {
        $('#transunion_account').closest('.form-check').show();
    }

    // If any one is selected, show the "all" field too
    if (equifax === '1' || experian === '1' || transunion === '1') {
        $('#account_number_all').closest('.form-check').show();
    } else {
        $('#account_number_all').closest('.form-check').hide();
    }
});

    $("#add_btn_dispute_item").click(function(event) {
  event.preventDefault();
 let formData = new FormData();
let dispute_reason = $('#dispute_reason').val().trim();
let creditor_furnisher = $('#creditor_furnisher').val().trim();

  if (dispute_reason === '') {
    alert("Please select a dispute reason.");
    $('#dispute_reason').focus();
    return;
  }

  if (creditor_furnisher === '0' || creditor_furnisher === '') {
    alert("Please select a creditor/furnisher.");
    $('#creditor_furnisher').focus();
    return;
  }
//     if (dispute_instructions === '') {
//     alert("Please enter dispute instructions.");
//     $('#dispute_instructions').focus();
//     return;
//   }
let transunion = $('#transunion').is(':checked') ? '1' : '0';
let experian   = $('#experian').is(':checked') ? '1' : '0';
let equifax    = $('#equifax').is(':checked') ? '1' : '0';
let dispute_instructions = $('#dispute_instructions').val().trim();
let id = $('#id').val();
 let transunion_account = $('#transunion').is(':checked') ? $('#transunion_account').val() : '';
  let experian_account   = $('#experian').is(':checked') ? $('#experian_account').val() : '';
  let equifax_account    = $('#equifax').is(':checked') ? $('#equifax_account').val() : '';
formData.append('id', id);
formData.append('reason', dispute_reason);
formData.append('instruction', dispute_instructions);
formData.append('furnisher', creditor_furnisher);
formData.append('transunion', transunion);
formData.append('experian', experian);
formData.append('equifax', equifax);
  formData.append('transunion_account', transunion_account);
  formData.append('experian_account', experian_account);
  formData.append('equifax_account', equifax_account);
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url("save_dispute_item_client"); ?>',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
      let res = JSON.parse(response);
    $('.no-data').hide();

      const id = res.data.id;
    selectedIds.push(id); 
       selComqui.push(res.data.equi_status); 
          selComexper.push(res.data.exper_status); 
             selComtu.push(res.data.tu_status); 
    console.log(selectedIds);
      $('#selectedIds').val(selectedIds.join(','));
          $('#selectedIds').val(selectedIds.join(','));
      $('#selComqui').val(selComqui.join(','));
        $('#selComexper').val(selComexper.join(','));
          $('#selComtu').val(selComtu.join(','));
               updateNoDataMessage();
                    $('.no-data').hide();
            $('#SavedisputeModal').modal('hide');
            
var Comquidata = $('#selComqui').val();
var Comexperdata = $('#selComexper').val();
var Comtudata = $('#selComtu').val();

if (Comquidata === '' || Comquidata === ',') {
     $('#tab1-tab').hide();
}
if (Comexperdata === '' || Comexperdata === ',') {
     $('#tab2-tab').hide();
}
if (Comtudata === '' || Comtudata === ',') {
     $('#tab3-tab').hide();
}
     let newRow = `
      <tr data-id="${res.data.id}">
        <td>${res.data.furnisher}</td>
        <td>
          Equifax: ${res.data.equi_ac ?? '-'}<br>
          Experian: ${res.data.exper_ac ?? '-'}<br>
          Transunion: ${res.data.tu_ac ?? '-'}
        </td>
        <td>${res.data.reason}</td>

        <td class="text-center">
          ${getStatusHtml(res.data.equi_status)}
        </td>
        <td class="text-center">
          ${getStatusHtml(res.data.exper_status)}
        </td>
        <td class="text-center">
          ${getStatusHtml(res.data.tu_status)}
        </td>
        <td class="text-center">
          <i class="fas fa-trash-alt text-danger delete-row" style="cursor: pointer;"></i>
        </td>
      </tr>
    `;
 $('#selectedItemsBody').append(newRow);
 

      $('#disputeModal').modal('hide');

    },
    error: function(xhr, status, error) {
      console.log("AJAX Error:", status, error);
    }
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    $('.delete-dispute').click(function(e) {
      e.preventDefault();
      const id = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: 'This dispute item will be deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url("Admin/delete_dispute_item") ?>',
            method: 'POST',
            data: {
              id
            },
            dataType: 'json',
            success: function(res) {
              if (res.status === 'success') {
                Swal.fire('Deleted!', 'Item removed.', 'success').then(() => {
                  location.reload(); // Refresh the table
                });
              } else {
                Swal.fire('Error!', 'Could not delete item.', 'error');
              }
            },
            error: function() {
              Swal.fire('Error!', 'AJAX failed.', 'error');
            }
          });
        }
      });
    });
  });
</script>



<script>
  $(document).ready(function() {

    function toggleAccountFields() {
      const sameForAll = $('#sameForAll').is(':checked');
      const differentForEach = $('#differentForEach').is(':checked');

      if (sameForAll) {
        $('#account_number_all').closest('.form-check').show();
        $('#equifax_account, #experian_account, #transunion_account').closest('.form-check').hide();
      }

      if (differentForEach) {
        $('#account_number_all').val('').closest('.form-check').hide();
        if ($('#equifax').is(':checked')) $('#equifax_account').closest('.form-check').show();
        if ($('#experian').is(':checked')) $('#experian_account').closest('.form-check').show();
        if ($('#transunion').is(':checked')) $('#transunion_account').closest('.form-check').show();
      }
    }

    $('#sameForAll, #differentForEach, #equifax, #experian, #transunion').change(function() {
      toggleAccountFields();
    });

    function loadDisputeItems() {
      $.ajax({
        url: '<?= base_url("Admin/get_dispute_items") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          const tbody = $('#dispute-table tbody');
          tbody.empty();

          if (data.length === 0) {
            tbody.append('<tr><td class="no-data" colspan="6">No dispute items added</td></tr>');
          } else {
            data.forEach(item => {
              const eqIcon = item.equifax == 1 ? '<img src="<?= base_url("downloads/simple_audit_images/negative.png") ?>" height="25">' : '';
              const exIcon = item.experian == 1 ? '<img src="<?= base_url("downloads/simple_audit_images/negative.png") ?>" height="25">' : '';
              const tuIcon = item.transunion == 1 ? '<img src="<?= base_url("downloads/simple_audit_images/negative.png") ?>" height="25">' : '';

              const accounts = [
                item.equifax_account ? 'EQ: ' + item.equifax_account : '',
                item.experian_account ? 'EX: ' + item.experian_account : '',
                item.transunion_account ? 'TU: ' + item.transunion_account : ''
              ].filter(Boolean).join('<br>');

              tbody.append(`
              <tr>
                <td>${item.creditor_furnisher}</td>
                <td>${accounts}</td>
                <td>${item.dispute_reason}</td>
                <td>${eqIcon}</td>
                <td>${exIcon}</td>
                <td>${tuIcon}</td>
              </tr>
            `);
            });
          }
        }
      });
    }

    // loadDisputeItems();

    $('.btn-successs').click(function() {
      let hasError = false;
      $('.is-invalid').removeClass('is-invalid');

      // if ($('#creditor_furnisher').val() === "0") {
      //   $('#creditor_furnisher').addClass('is-invalid');
      //   hasError = true;
      // }

      if ($('#dispute_reason').val() === "0") {
        $('#dispute_reason').addClass('is-invalid');
        hasError = true;
      }

    //   if (!$('#equifax').is(':checked') && !$('#experian').is(':checked') && !$('#transunion').is(':checked')) {
    //     Swal.fire({
    //       icon: 'warning',
    //       title: 'Validation Error',
    //       text: 'Please select at least one bureau.'
    //     });
    //     hasError = true;
    //   }

      if (hasError) return;

      const data = {
        bureaus: {
          equifax: $('#equifax').is(':checked') ? 1 : 0,
          experian: $('#experian').is(':checked') ? 1 : 0,
          transunion: $('#transunion').is(':checked') ? 1 : 0
        },
        account_mode: $('input[name="accountNumber"]:checked').attr('id'),
        account_number_all: $('#account_number_all').val(),
        equifax_account: $('#equifax_account').val(),
        experian_account: $('#experian_account').val(),
        transunion_account: $('#transunion_account').val(),
        creditor_furnisher: $('#creditor_furnisher').val(),
        dispute_reason: $('#dispute_reason').val(),
        dispute_instruction: $('#dispute_instructions').val()
      };

      $.ajax({
        url: '<?= base_url("Admin/save_dispute_item") ?>',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(res) {
          if (res.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Saved!',
              text: 'Dispute item saved successfully!',
              timer: 2000,
              showConfirmButton: false
            });
            $('#disputeModal').modal('hide');
            loadDisputeItems();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: res.message
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'AJAX Error',
            text: 'Something went wrong. Try again.'
          });
        }
      });
    });
  });
</script>

<script>
function updateNoDataMessage() {
  const hasRows = $('#selectedItemsBody tr').not('.no-data').length > 0;
  $('.no-data').toggle(!hasRows);
}
$(document).ready(function(){
    
    $('#select_all').on('click', function(){
        $('.row_checkbox').prop('checked', this.checked);
    });

    $('.row_checkbox').on('click', function(){
        if($('.row_checkbox:checked').length == $('.row_checkbox').length){
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    });
    
    
    /// add to Dispute  
       $('#addtoDispute').on('click', function() {
       $('#selectedItemsBody').find('tr').not('.no-data').remove();

       $('.row_checkbox:checked').each(function(){
          const row = $(this).closest('tr').clone(); // Clone row
          row.find('td:first').remove(); // Remove checkbox
const rows = $(this).closest('tr');
 const id = rows.attr('data-id');
  const dataequi = rows.attr('data-equi');
 const dataexper = rows.attr('data-exper');
 const datatu = rows.attr('data-tu');
 selComqui.push(dataequi);
 selComexper.push(dataexper);
 selComtu.push(datatu);

        selectedIds.push(id); // Store ID
        
              // Append delete button
              row.append(`
               <td class="text-center">
                  <i class="fas fa-trash-alt text-danger delete-row" style="cursor: pointer;"></i>
                </td>
              `);
        
              $('#selectedItemsBody').append(row);
            });
            
    // Save IDs to hidden input
    $('#selectedIds').val(selectedIds.join(','));
      $('#selComqui').val(selComqui.join(','));
        $('#selComexper').val(selComexper.join(','));
          $('#selComtu').val(selComtu.join(','));
               updateNoDataMessage();
            $('#SavedisputeModal').modal('hide');
            
var Comquidata = $('#selComqui').val();
var Comexperdata = $('#selComexper').val();
var Comtudata = $('#selComtu').val();

if (Comquidata === '' || Comquidata === ',') {
     $('#tab1-tab').hide();
}
if (Comexperdata === '' || Comexperdata === ',') {
     $('#tab2-tab').hide();
}
if (Comtudata === '' || Comtudata === ',') {
     $('#tab3-tab').hide();
}
         });

  // Delegate delete button click
  $('#selectedItemsBody').on('click', '.delete-row', function(){
    $(this).closest('tr').remove();
    updateNoDataMessage();
  });
  updateNoDataMessage();
});


  $('#btn-new-dispute').on('click', function() {
    $('#disputeModal').modal('show');
  });

  $('#btn-saved-dispute').on('click', function() {
    $('#SavedisputeModal').modal('show');
  });
$('.create_letter').on('click', function() {
    $('#letterSave').modal('show');
  });
  $('.btn-generate-library').on('click', function() {
   const hasItems = $('#selectedItemsBody tr').not('.no-data').length > 0;

  if (!hasItems) {
    alert('Please select at least one dispute item.');
    return;
  }
   $('.clientName').text("<?= $name ?>");
    $('.clientAddress').text("<?= $clientAddress ?>");
    var dispute_reason = $('#dispute_reason').val().trim();
$('.clientFullAddress').text("<?= $clientFullAddress ?>");
   $('#printthissec').removeClass('d-none').addClass('d-block');
    $('#disputeWizard').css('display', 'none');
    $('#latterEdit').css('display', 'block');
 var message = `<?= $name ?><br><?= $clientAddress ?><br><?= $clientFullAddress ?><br>Date of Birth:<?= $client[0]->sq_dob ?><br>#<?= $client[0]->sq_ssn ?><br><br><?= date('m/d/y') ?><br><br>
     Re: Letter to Remove Inaccurate Credit Information<br><br>I received a copy of my credit report and found the following item(s) to be in error:<br><br>
    By the provisions of the Fair Credit Reporting Act, I demand that these items be investigated and removed from my report. It is my understanding that you will recheck these items with the creditor who has posted them. Please remove any information that the creditor cannot verify. I understand that under 15 U.S.C. Sec. 1681i(a), you must complete this reinvestigation within 30 days of receipt of this letter.<br><br>
    Please send an updated copy of my credit report to the above address. According to the act, there shall be no charge for this updated report. I also request that you please send notices of corrections to anyone who received my credit report in the past six months.<br><br>
    Thank you for your time and help in this matter.<br><br>
    Sincerely,<br><br><img id="img-signature" src="<?= $client[0]->agreement_path ?>" alt="Saved Signature"><br>_____________________________________<br><?= $name ?>`;
    tinymce.get('contentTextarea').setContent(message);
  });
  
    $('#r2s').on('click', function() {
   const hasItems = $('#selectedItemsBody tr').not('.no-data').length > 0;
   $('#round').val(2);
    if (!hasItems) {
    alert('Please select at least one dispute item.');
    return;
  }
      $('#letter-container').css('display', 'block');
});
$('.btn-generate-librarys').on('click', function() {
    var selectedContent = $('#letterDropdown option:selected').data('content');

    // Replace placeholders
    selectedContent = selectedContent
     .replace(/{client_first_name}/g, "<?= $client[0]->sq_first_name; ?>")
      .replace(/{client_last_name}/g, "<?= $client[0]->sq_last_name;	 ?>")
       .replace(/{client_address}/g, "<?= $clientAddress	 ?>")
         .replace(/{ss_number}/g, "<?= $client[0]->sq_ssn;	 ?>")
            .replace(/{bdate}/g, "<?= $client[0]->sq_dob;	 ?>")
               .replace(/{t_no}/g, "<?= $client[0]->sq_phone_mobile;	 ?>")
                .replace(/{client_suffix}/g, "<?= $client[0]->sq_suffix;	 ?>")
                 .replace(/{client_middle_name}/g, "<?= $client[0]->sq_middle_name;	 ?>")
                  .replace(/{client_email}/g, "<?= $client[0]->sq_email;	 ?>")
                    .replace(/{dispute_item_and_explanation}/g, "")
                     .replace(/{bureau_name}/g, "")
                         .replace(/{bureau_address}/g, "")
                .replace(/{client_previous_address}/g, "<?=  trim(($client[0]->sq_p_city ?? '') . ' ' . ($client[0]->sq_p_state ?? '') . ' ' . ($client[0]->sq_p_zipcode ?? ''))	 ?>")
          .replace(/{client_signature}/g, "<img id='img-signature' src='<?= $client[0]->agreement_sign;	 ?>' alt='Saved Signature'>")
        .replace(/{CLIENT NAME}/g, "<?= $name ?>")
        .replace(/{CLIENT ADDRESS}/g, "<?= $clientAddress ?>")
        .replace(/{CLIENT FULL ADDRESS}/g, "<?= $clientFullAddress ?>")
        .replace(/{curr_date}/g, "<?= date('Y-m-d') ?>")
        .replace(/{TODAY'S DATE}/g, "<?= date('m/d/y') ?>")
        .replace(/{COMPANY WEBSITE}/g, "<?= base_url() ?>")
        .replace(/{COMPANY LOGO}/g, '<img src="<?= base_url('assets/images/logo.png') ?>" alt="Company Logo" id="simple_audit_logo" style="min-width:55px; height:55px;">')


    // Update visible info
    $('.clientName').text("<?= $name ?>");
    $('.clientAddress').text("<?= $clientAddress ?>");
    $('.clientFullAddress').text("<?= $clientFullAddress ?>");

    // Show/hide relevant sections
    $('#printthissec').removeClass('d-none').addClass('d-block');
    $('#disputeWizard').css('display', 'none');
    $('#latterEdit').css('display', 'block');

    // Set content in TinyMCE editor
    tinymce.get('contentTextarea').setContent(selectedContent);
});

  document.addEventListener('DOMContentLoaded', () => {
    const basic_dispute = document.getElementById('basic_dispute');
    const other_letters = document.getElementById('other_letters');
    const credit_bureau = document.getElementById('credit_bureau');
    const creditor_furnisher = document.getElementById('creditor_furnisher');
    const letterRecipientDiv = document.querySelector('.step-title + .radio-group');
    const step2Container = document.querySelector('#dispute-container:nth-of-type(2)');
    const recipientRadios = letterRecipientDiv.querySelectorAll('input[type="radio"]');

    // 1. Show/Hide "Choose Letter Recipient (Round 2 Only)" based on Round 2 selection
    basic_dispute.addEventListener('change', () => {
      if (basic_dispute.checked) {
        // letterRecipientDiv.style.display = 'block';
        $('.step-2').css('display', 'none');
      }
    });

    other_letters.addEventListener('change', () => {
      if (other_letters.checked) {
        // letterRecipientDiv.style.display = 'block';
        $('.step-2').css('display', 'block');
      }
    });

    // 2. Smooth scroll to Step 2 when selecting Round 1
    basic_dispute.addEventListener('click', () => {
      if (basic_dispute.checked) {
        scrollToStep2();
      }
    });

    credit_bureau.addEventListener('click', () => {
      if (credit_bureau.checked) {
        scrollToStep2();
      }
    });
    creditor_furnisher.addEventListener('click', () => {
      if (creditor_furnisher.checked) {
        scrollToStep2();
      }
    });

    // 3. Smooth scroll to Step 2 when selecting recipient after Round 2+ is selected
    // recipientRadios.forEach(radio => {
    //   radio.addEventListener('click', () => {
    //     if (other_letters.checked) {
    //       scrollToStep2();
    //     }
    //   });
    // });

    // Smooth scroll and highlight Step 2 container
    function scrollToStep2() {
      step2Container.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
      step2Container.style.border = '2px solid #007bff';

      // Remove border after 1 second
      setTimeout(() => {
        step2Container.style.border = 'none';
      }, 1000);
    }
  });
</script>
<script>

$("#saveLettersBtn").click(function(event) {
    
  event.preventDefault();
    
  let formData = new FormData();

  // Manually append form fields
  let round = $('#round').val();
    let selectedIds = $('#selectedIds').val();
  let abbrevation = $('#abbrevation').val();
  let followUp = $('#follow_up').is(':checked') ? 1 : 0;
      let client_id = "<?= $client[0]->sq_client_id ?>";
    let letter_name = $('#letter_name').val();
    let client_letter = tinymce.get('contentTextarea').getContent().trim();
    
  formData.append('round', round);
  formData.append('letter_name', letter_name);
  formData.append('abbrevation', abbrevation);
  formData.append('follow_up', followUp);
  formData.append('client_letter', client_letter);
   formData.append('client_id', client_id);
   formData.append('dispute_item_id', selectedIds);
      var selectedContents = $('#letterDropdown option:selected').data('content');
     if(selectedContents == undefined){
        formData.append('letter_formate', '1');
     }
     else{
       formData.append('letter_formate', selectedContents);
     }
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url("save_client_letters"); ?>',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
      let res = JSON.parse(response);

      alert("Letter saved successfully!");
window.location.href = '<?php echo base_url("send_letter/$client_id"); ?>';

      $('#letterSave').modal('hide');
      $('#letterSaveForm')[0].reset();
    },
    error: function(xhr, status, error) {
      console.log("AJAX Error:", error);
      alert("Something went wrong while saving.");
    }
  });
  console.log(selComqui,selComexper,selComtu)
  });
  
$(document).ready(function() {
  $('#categoryDropdown').on('change', function() {
    var categoryId = $(this).val();

    if (categoryId !== "") {
      $.ajax({
        url: "<?= base_url('get_letters_by_category') ?>",
        type: "POST",
        data: { category_id: categoryId },
        success: function(response) {
          $('#letterDropdown').html(response);
        }
      });
    } else {
      $('#letterDropdown').html('<option value="">Select a Letter</option>');
    }
  });
});
$(document).ready(function() {
  function toggleButtons() {
    if ($('#other_dispute').is(':checked')) {
      $('#r2s').show();
      $('#btn-container').hide();
    } else {
      $('#r2s').hide();
      $('#btn-container').show();
    }
  }

  // Call initially
  toggleButtons();

  // On radio button change
  $('input[name="letter_type"]').change(function() {
    toggleButtons();
  });
});
</script>

