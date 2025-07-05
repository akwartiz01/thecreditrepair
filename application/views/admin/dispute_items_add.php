<style>
    .status-check {
        color: green;
        font-size: 1.2rem;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .credit-header {
        text-align: center;
        font-weight: bold;
    }

    .btn-new-item {
        float: right;
        margin-bottom: 10px;
    }

    .navigation_mini .btn {
        padding: 10px 38px !important;
    }

    .text-success {
        color: #3972fc !important;
    }
</style>
<?php
$client_id = get_encoded_id($client[0]->sq_client_id);
?>
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

    <a href="<?= base_url(); ?>send_letter/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">4</span> Send Letters
    </a>

    <a href="<?= base_url('letters-status/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Letters & Status
    </a>

    <a href="<?= base_url('dispute_items/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link active">
      Dispute Items
    </a>

    <a href="<?= base_url('messages/send/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Messages
    </a>

  </div>
</div>
</div>
<div class="container">
    <form id="disputeItemForm" class="form-sample mb-4" mehtod="post">
          <h1 class="title mb-3">Add New Dispute Item</h1>
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
           
                <select class="form-control" id="creditor_furnisher" name="creditor_furnisher" required>
    <option value="0" selected>Search a Creditor/Furnisher</option>
    <?php if (!empty($furnishers)) : ?>
        <?php foreach ($furnishers as $furnisher) : ?>
            <option value="<?= htmlspecialchars($furnisher->company_name) ?>">
                <?= htmlspecialchars($furnisher->company_name) ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>


              </div>


              <div class="form-group">
                <label>Reason <span class="text-danger">*</span></label>
                <select class="form-control" id="dispute_reason" required>
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
                <select class="form-control" id="dispute_instructions" required>
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

            <!--<div class="form-check" style="display: none;">-->
            <!--  <input type="text" class="form-control mt-2" id="account_number_all" placeholder="Enter account number">-->
            <!--</div>-->

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
   <div class="d-flex gap-2">
  <button type="submit" class="btn btn-primary btn-icon-text mr-2" id="add_btn_dispute_item">
    Submit
  </button>
  
  <a href="<?php echo base_url('dispute_items/' . $this->uri->segment(2)); ?>" class="btn btn-secondary btn-icon-text">
    Back
  </a>
</div>

</form>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script>
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
window.location.href = '<?php echo base_url("dispute_items/$client_id"); ?>';

    },
    error: function(xhr, status, error) {
      console.log("AJAX Error:", status, error);
    }
  });
});

</script>