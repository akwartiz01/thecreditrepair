
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

    /*.navigation_mini .btn {*/
    /*    padding: 10px 38px !important;*/
    /*}*/

    .text-success {
        color: #3972fc !important;
    }
    .dropdown .dropdown-menu .dropdown-item:hover {
    color: #000!important;
}
</style>

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


                 <a class="btn btn-success btn-new-item" href="<?php echo base_url(); ?>dispute_items_add/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" ><i class="fas fa-plus"></i> Add New Item</a>


            <!--<table class="table table-bordered">-->
            <!--    <thead class="table-light">-->
            <!--        <tr>-->
            <!--            <th>Creditor/Furnisher</th>-->
            <!--            <th>Account #</th>-->
            <!--            <th>Dispute Items</th>-->
            <!--            <th class="credit-header">Equifax</th>-->
            <!--            <th class="credit-header">Experian</th>-->
            <!--            <th class="credit-header">TransUnion</th>-->
            <!--            <th></th>-->
            <!--        </tr>-->
            <!--    </thead>-->
            <!--    <tbody>-->
            <!--        <tr>-->
            <!--            <td>WFBNB CARD</td>-->
            <!--            <td>-->
            <!--                Equifax: <br>-->
            <!--                Experian: <br>-->
            <!--                Transunion:-->
            <!--            </td>-->
            <!--            <td>-</td>-->
            <!--            <td colspan="3" class="text-center text-muted">-</td>-->
            <!--            <td class="text-end">-->
            <!--                <div class="dropdown">-->
            <!--                    <button class="btn btn-link text-dark dropdown-toggle" data-bs-toggle="dropdown">-->
            <!--                        <i class="fas fa-ellipsis-v"></i>-->
            <!--                    </button>-->
            <!--                    <ul class="dropdown-menu">-->
            <!--                        <li><a class="dropdown-item" href="#">Edit</a></li>-->
            <!--                        <li><a class="dropdown-item" href="#">Delete</a></li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </td>-->
            <!--        </tr>-->
            <!--        <tr>-->
            <!--            <td>ROUNDPOINT MORTGAGE</td>-->
            <!--            <td>-->
            <!--                Equifax: 596201123456<br>-->
            <!--                Experian: 596201123456<br>-->
            <!--                Transunion: 596201123456-->
            <!--            </td>-->
            <!--            <td>-</td>-->
            <!--            <td class="text-center"><i class="fas fa-check status-check"></i><br>-->
            <!--                <select class="form-select">-->
            <!--                    <option selected>Select</option>-->
            <!--                    <option>Unspecified</option>-->
            <!--                    <option>Positive</option>-->
            <!--                    <option>Deleted</option>-->
            <!--                    <option>Repaired</option>-->
            <!--                    <option>Updated</option>-->
            <!--                    <option>In Dispute</option>-->
            <!--                    <option>Verified</option>-->
            <!--                    <option>Negative</option>-->
            <!--                </select>-->
            <!--            </td>-->
            <!--            <td class="text-center"><i class="fas fa-check status-check"></i><br>-->
            <!--                <select class="form-select">-->
            <!--                    <option selected>Select</option>-->
            <!--                    <option>Unspecified</option>-->
            <!--                    <option>Positive</option>-->
            <!--                    <option>Deleted</option>-->
            <!--                    <option>Repaired</option>-->
            <!--                    <option>Updated</option>-->
            <!--                    <option>In Dispute</option>-->
            <!--                    <option>Verified</option>-->
            <!--                    <option>Negative</option>-->
            <!--                </select>-->
            <!--            </td>-->
            <!--            <td class="text-center"><i class="fas fa-check status-check"></i><br>-->
            <!--                <select class="form-select">-->
            <!--                    <option selected>Select</option>-->
            <!--                    <option>Unspecified</option>-->
            <!--                    <option>Positive</option>-->
            <!--                    <option>Deleted</option>-->
            <!--                    <option>Repaired</option>-->
            <!--                    <option>Updated</option>-->
            <!--                    <option>In Dispute</option>-->
            <!--                    <option>Verified</option>-->
            <!--                    <option>Negative</option>-->
            <!--                </select>-->
            <!--            </td>-->
            <!--            <td class="text-end">-->
            <!--                <div class="dropdown">-->
            <!--                    <button class="btn btn-link text-dark dropdown-toggle" data-bs-toggle="dropdown">-->
            <!--                        <i class="fas fa-ellipsis-v"></i>-->
            <!--                    </button>-->
            <!--                    <ul class="dropdown-menu">-->
            <!--                        <li><a class="dropdown-item" href="#">Edit</a></li>-->
            <!--                        <li><a class="dropdown-item" href="#">Delete</a></li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </td>-->
            <!--        </tr>-->
                    <!-- Repeat similar structure for other rows -->
            <!--    </tbody>-->
            <!--</table>-->
            <div class="table-responsive mb-4">
	<table class="table table-bordered table-hover jsgrid">
								    <thead class="thead-dark">
    <tr>
      <th>Creditor/Furnisher</th>
      <th>Account #</th>
      <th>Dispute Items</th>
      <th class="credit-header">Equifax</th>
      <th class="credit-header">Experian</th>
      <th class="credit-header" colspan="2">TransUnion</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($dispute_items)): ?>
      <?php foreach ($dispute_items as $item): ?>
        <tr>
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



          <!-- Actions -->
          <td class="text-end">
            <div class="dropdown">
              <button class="btn btn-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item edit-dispute-btn" href="#" data-id="<?= $item->id; ?>" data-bs-toggle="modal" data-bs-target="#editDisputeModal">Edit</a></li>
                <li><a class="dropdown-item delete-link" data-id="<?= $item->id; ?>" href="#">Delete</a></li>
              </ul>
            </div>
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editDisputeModal" tabindex="-1" aria-labelledby="editDisputeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDisputeModalLabel">Edit dispute item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                    <input type="hidden" id="dispute_id">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Date:</label>
                            <input type="text" class="form-control" id="added_date" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Creditor/Furnisher:</label>
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Reason:</label>
                             <select class="form-control" id="dispute_reason" required>
                              <option value="">Sample Reason</option>
                              <option value="">The following personal information is incorrect</option>
                              <option value="">The following account is not mine</option>
                              <option value="">The status is incorrect for the following account</option>
                              <option value="">The status is incorrect for the following account</option>
                              <option value="">The following information is outdated. I would like it removed from my credit history report</option>
                              <option value="">The following inquiry is more than two years old and I would like it removed</option>
                              <option value="">The inquiry was not authorized</option>
                              <option value="">The following accounts were closed by me and should state that</option>
                              <option value="">The following account was a Bankruptcy/Charge-off. Balance should be $0</option>
                              <option value="">Mistaken Identity</option>
                              <option value="">Identity Theft</option>
                              <option value="">Other information I would like changed</option>
                              <option value="">This is a duplicate account</option>
                              <option value="">The wrong amount is being reported</option>
                              <option value="">This is the wrong creditor for this item</option>
                              <option value="">Validate Account</option>
                              <option value="">-</option>
                              <option value="">Late Payments</option>
                              <option value="">Charged Off</option>
                              <option value="">Account Closed</option>
                              <option value="">15 USC 1666 USC 1666B 12 CFR 1026.13 - Billing Error - Late Payments</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Instruction:</label>
                             <input type="text" class="form-control" id="dispute_instruction">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Equifax -->
                        <div class="col-md-4 form-section">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="equifax">
                                <label class="form-check-label">
                       <img src="<?php echo base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 30px !important;" alt="Equifax">                                </label>
                                </label>
                            </div>
                            <div class="mb-2" id="statusequi">
                                <label class="form-label">Status:</label>
                              <select class="form-control" id="equiStatus">
                                  <option value=''>Select Status</option>  
    <option value="Positive">Positive</option>
    <option value="Negative">Negative</option>
    <option value="Repaired">Repaired</option>
    <option value="Deleted">Deleted</option>
    <option value="In Dispute">In Dispute</option>
    <option value="Verified">Verified</option>
    <option value="Updated">Updated</option>
    <option value="Unspecified">Unspecified</option>
   
</select>
                            </div>
                        </div>

                        <!-- Experian -->
                        <div class="col-md-4 form-section">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="experian">
                                <label class="form-check-label">
                  <img src="<?php echo base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 30px !important;" alt="TransUnion">
                                </label>
                            </div>
                            <div class="mb-2" id="statusexper">
                                <label class="form-label">Status:</label>
                               <select class="form-control" id="experStatus">
                                   <option value=''>Select Status</option>  
    <option value="Positive">Positive</option>
    <option value="Negative">Negative</option>
    <option value="Repaired">Repaired</option>
    <option value="Deleted">Deleted</option>
    <option value="In Dispute">In Dispute</option>
    <option value="Verified">Verified</option>
    <option value="Updated">Updated</option>
    <option value="Unspecified">Unspecified</option>
   
</select>
                            </div>
                           
                        </div>

                        <!-- TransUnion -->
                        <div class="col-md-4 form-section">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="transUnion">
                               <img src="<?php echo base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 30px !important;" alt="TransUnion">
                                <label class="form-check-label">
                            </div>
                            <div class="mb-2" id="statustu">
                                <label class="form-label">Status:</label>
                              <select class="form-control" id="tuStatus">
                                 <option value=''>Select Status</option>  
    <option value="Positive">Positive</option>
    <option value="Negative">Negative</option>
    <option value="Repaired">Repaired</option>
    <option value="Deleted">Deleted</option>
    <option value="In Dispute">In Dispute</option>
    <option value="Verified">Verified</option>
    <option value="Updated">Updated</option>
    <option value="Unspecified">Unspecified</option>
   
</select>
                            </div>
                     
                        </div>
                    </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="submitdata">Save</button>
            </div>
              
        </div>
    </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).on('click', '.delete-link', function(e) {
    if (!confirm('WARNING: If you attempt to delete any of these items on this page, you will not get an accurate reimport summary. We recommend that you do not delete anything.')) {
      e.preventDefault(); // Stop the link from doing anything
    }
     var disputeId = $(this).data('id');
      $.ajax({
    url: '<?= base_url("delete_dispute_item/") ?>' + disputeId,
    type: 'DELETE',
    success: function(response) {
      alert('Item successfully deleted.');
     location.reload();
    },
    error: function(xhr, status, error) {
      console.error('Delete failed:', error);
      alert('Failed to delete item.');
    }
  });
  });
  $(document).on('click', '.edit-dispute-btn', function() {
    var disputeId = $(this).data('id');
    $('#dispute_id').val(disputeId); // set hidden input

    $.ajax({
        url: '<?= base_url("edit_dispute_item/") ?>' + disputeId, // replace with your actual API route
        type: 'GET',
        success: function(response) {
              let res = JSON.parse(response);
             $('#added_date').val(res.data[0].added_date);
             $('#dispute_instruction').val(res.data[0].instruction);
              $('#transUnion').prop('checked', res.data[0].transUnion != 0);
               $('#experian').prop('checked', res.data[0].experian != 0);
                $('#equifax').prop('checked', res.data[0].equifax != 0);
                $('#equiStatus option').filter(function() {
    return $(this).text().trim() === res.data[0].equi_status;
}).prop('selected', true);
     $('#experStatus option').filter(function() {
    return $(this).text().trim() === res.data[0].exper_status;
}).prop('selected', true);
     $('#tuStatus option').filter(function() {
    return $(this).text().trim() === res.data[0].tu_status;
}).prop('selected', true);
if (!res.data[0].equi_status) {
    $('#statusequi').hide();
} else {
    $('#statusequi').show();
}
if (!res.data[0].exper_status) {
    $('#statusexper').hide();
} else {
    $('#statusexper').show();
}

if (!res.data[0].tu_status) {
    $('#statustu').hide();
} else {
    $('#statustu').show();
}

        },
        error: function() {
            alert('Failed to fetch dispute data.');
        }
    });
});
$(document).ready(function() {
$('#submitdata').click(function() {

        let formData = {
        added_date: $('#added_date').val(),
        creditor_furnisher: $('#creditor_furnisher').val(),
        dispute_reason: $('#dispute_reason').val(),
        dispute_instruction: $('#dispute_instruction').val(),

        equifax: $('#equifax').is(':checked') ? 1 : 0,
        equi_status: $('#equiStatus').val(),

        experian: $('#experian').is(':checked') ? 1 : 0,
        exper_status: $('#experStatus').val(),

        transUnion: $('#transUnion').is(':checked') ? 1 : 0,
        tu_status: $('#tuStatus').val()
    };
  var disputeId =   $('#dispute_id').val();
        $.ajax({
        url: '<?= base_url("update_dispute_item/") ?>' + disputeId,
        type: 'POST', 
        data: formData,
        success: function (response) {
            alert('Dispute updated successfully!');
            $('#editDisputeModal').modal('hide');
             location.reload();
        },
        error: function (xhr) {
            alert('Error updating dispute.');
            console.error(xhr.responseText);
        }
    });
});
});
</script>