<?php
// Fetch the latest added_date from the scores array
$latest_date = null;
$days_since_last_import = 0;
$new_report_available = false;
$client_id = get_encoded_id($client[0]->sq_client_id);
if (!empty($result)) {
	foreach ($result as $value) {
		$scores = unserialize($value->scores);
		foreach ($scores as $score_record) {
	$date = isset($score_record['added_date']) ? strtotime($score_record['added_date']) : false;

			if (!$latest_date || $date > $latest_date) {
				$latest_date = $date;
			}
		}
	}
}

// Calculate days since the last imported date
if ($latest_date) {
	$days_since_last_import = floor((time() - $latest_date) / (60 * 60 * 24));
	$new_report_available = $days_since_last_import >= 30; // Assume a report is generated every month
}

?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style type="text/css">
	#order-listing {
		border-collapse: collapse;
	}
	.tick-mark {
    float: left;
}
.nav-tabs .nav-link.active{
    color: #000!important;
    font-weight:bold;
}
.nav-tabs .nav-link{
    color: #343a40!important;
}
	.tick-mark .material-icons {
    color: #00a650;
    font-size: 36px;
}
	.uploaded-audit {
    width: 500px;
    margin: 0 auto;
    padding: 16px 24px;
    height: 84px;
    border-radius: 8px;
    border: solid 1px #dddbda;
    margin-bottom: 40px;
    margin-top: 24px;
}
.uploaded-text {
       float: left;
    margin-left: 30px;
}
.sans-p {
    font-size: 14px;
    color: #4a4a4a;
}
.tab-content {
    border: 1px solid #dee2e6!important;
    margin-top: 0px !important;
}

.nav-tabs, .tab-content {
    border: 1px solid #dee2e6!important;
}
	#order-listing thead th {
		background-color: #343a40;
		color: #fff;
		font-size: 0.9rem;
		font-weight: bold;
	}

	#order-listing tbody tr:nth-child(odd) {
		background-color: #f9f9f9;
	}

	#order-listing tbody tr:nth-child(even) {
		background-color: #ffffff;
	}

	#order-listing tbody tr:hover {
		background-color: #f1f1f1;
	}

	#order-listing td,
	#order-listing th {
		padding: 12px;
		text-align: center;
		vertical-align: middle;
	}

	.btn-sm {
		padding: 5px 10px;
		font-size: 0.8rem;
	}


	.readonly-input {
		background-color: #f5f8fa !important;
		color: #6c757d !important;
	}

	#frm_report_access_detail .editable-input {

		background-color: #f5f8fa;
	}

	.disabled-input {
		/* background-color: red !important; */
		background-color: #6c757d !important;
		color: #fff !important;
	}

	.pointer {
		cursor: pointer;
	}


	.input-group-text .mdi-content-copy {

		cursor: pointer;
		color: #0075cc;
	}

	.input-group-text .mdi-eye {
		cursor: pointer;
		color: #0075cc;
	}

	.input-group-text .mdi-eye-off {
		cursor: pointer;
		color: #343a40;
	}

	.input-group-append {
		background-color: #f5f8fa !important;
		border: 1px solid #d0d0d0 !important;
		border-color: #d0d0d0 !important;
	}

	.input-group-text {
		background-color: #f5f8fa !important;
		border: 0px solid #d0d0d0 !important;
		border-color: #d0d0d0 !important;
		padding: 12px !important;
	}

	span#search {
		background-color: transparent !important;
	}

	span.secondary-background#copy_email {
		background-color: #6c757d !important;
	}

	span.secondary-background#copy_email i.mdi.mdi-content-copy {
		color: white !important;
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

	/*.navigation_mini .btn {*/
	/*	padding: 10px 38px !important;*/
	/*}*/
</style>

<div id="msgAppend1234"></div>

<div class="container-fluid page-body-wrapper">
	<div class="main-panel pnel">
		<div class="content-wrapper">
<div class="step-navigation border rounded-lg p-2 px-3 mb-3">
  <div class="d-flex flex-wrap justify-content-center gap-2">

    <a href="<?= base_url(); ?>dashboard/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      Dashboard
    </a>

    <a href="<?= base_url(); ?>import_audit/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link active">
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

    <a href="<?= base_url('dispute_items/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Dispute Items
    </a>

    <a href="<?= base_url('messages/send/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Messages
    </a>

  </div>
</div>
 
		

			<!-- <div class="page-header">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Credit Reports </li>
					</ol>

				</nav>
			</div> -->


			<div class="row">
				<div class="col-md-12" id="formobile">
					<div class="card">

						<div class="card-body">
							<div class="row">
								<div class="col-12 col-md-6">

									<h4 class="heading-h4 table-heading">Import/Audit  (<?php echo htmlspecialchars($get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name); ?>) </h4>
									<p>Last imported <?php echo $days_since_last_import; ?> days ago


										| <span id="inreport" style="color:red; <?php echo $new_report_available ? 'display:none;' : ''; ?>">
											New Report available in <span style="font-weight: bold;"><span class="days_count"><?php echo max(0, 30 - $days_since_last_import); ?></span> days</span>
										</span>

										<span id="nowreport" style="color: rgb(0, 166, 80); <?php echo $new_report_available ? '' : 'display:none;'; ?>">
											New Report available <span style="font-weight: bold;">now</span>
										</span>
									</p>
									<div class="text-center">
									<p>
										<img width="84" src="<?php echo base_url('downloads/importcloud.png'); ?>" alt="Reimport Credit Report">
									</p>
									<p>
										<a href="javascript:void(0)" class="btn" id="reimport_credit_reports" style="background-color: rgb(0, 166, 80);color:white;">
											Reimport Credit Report
										</a>
									</p>
									</div>
								</div>

								<div class="col-12 col-md-6">
                                  <div class="table-responsive">
									<table id="order-listing" class="table table-bordered table-hover jsgrid">
										<thead class="thead-dark">
											<tr class="text-uppercase text-center">
												<th>Added Date</th>
												<th>Equifax</th>
												<th>Experian</th>
												<th>TransUnion</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($result as $value): ?>
												<?php
												$scores = unserialize($value->scores);
												foreach ($scores as $score_record):
												?>
													<tr>
														<td class="text-center align-middle">
														<?php echo htmlspecialchars($score_record['added_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
														</td>
														<td class="text-center align-middle">
															<?php echo htmlspecialchars($score_record['providers']['EFX'] ?? 'N/A'); ?>
														</td>
														<td class="text-center align-middle">
															<?php echo htmlspecialchars($score_record['providers']['EXP'] ?? 'N/A'); ?>
														</td>
														<td class="text-center align-middle">
															<?php echo htmlspecialchars($score_record['providers']['TU'] ?? 'N/A'); ?>
														</td>
														<td class="text-center align-middle">
															<a type="button" href="<?php echo htmlspecialchars($score_record['report_path']); ?>" class="btn btn-sm btn-primary text-white" target="_blank">Download</a>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endforeach; ?>
										</tbody>
									</table>
</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="row mt-4">

				<div class="col-md-12" id="formobile">
					<div class="card">

						<div class="card-body">

							<p style="font-size: 20px !important;">Clients Credit Report Access Details:</p>
							<form id="frm_report_access_detail" autocomplete="off">
								<input type="hidden" name="crx_id" value="<?= $result[0]->id ?? '' ; ?>">
								<div class="row">

									<div class="col-md-4">
										<div class="form-group">
											<label>Report Provider</label>
											<input type="text" class="form-control readonly-input" id="report_provider" name="report_provider" value="CRX Hero" readonly>
										</div>
										<div class="form-group">
											<label>Phone</label>
											<input type="text" class="form-control editable-input" id="phone" name="phone" value="<?= $result[0]->phone ?? '' ?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Username</label>
											<div class="input-group">
												<input type="text" class="form-control readonly-input" id="user_name" name="user_name" value="<?= $result[0]->user_name ?? '' ; ?>" readonly>
												<div class="input-group-append">

													<span class="input-group-text pointer copy-email" id="copy_email">
														<i class="mdi mdi-content-copy"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Security Word</label>
											<input type="text" class="form-control editable-input" id="security_word" name="security_word" value="<?= $result[0]->security_word ?? '' ; ?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Password</label>
											<div class="input-group">
												<input type="password" class="form-control editable-input" id="s_password" name="s_password" value="<?= $result[0]->s_password ?? '' ; ?>" readonly>
												<div class="input-group-append">
													<span class="input-group-text pointer toggle-password" id="toggle_password">
														<i class="mdi mdi-eye"></i>
													</span>
													<span class="input-group-text pointer copy-password" id="copy_password">
														<i class="mdi mdi-content-copy"></i>
													</span>
												</div>
											</div>
										</div>


										<div class="form-group">
											<label>Notes</label>
											<input type="text" class="form-control editable-input" id="notes" name="notes" value="<?= $result[0]->notes ?? '' ; ?>" readonly>
										</div>
									</div>
								</div>
								<button type="button" id="edit_btn" class="btn btn-primary">Edit</button>
								<button type="button" id="save_btn" class="btn btn-success d-none">Save</button>
								<button type="button" id="cancel_btn" class="btn btn-secondary d-none">Cancel</button>
							</form>
						</div>

					</div>
				</div>

			</div>

		</div>
	</div>
</div>
<div class="modal fade" id="reimportModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Import Credit Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
     <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab">1-Click Auto-import</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab2" role="tab">manual source code entry (not recommended)</a>
          </li>
        </ul>
       <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="tab1" role="tabpanel">
               <div class="uploaded-audit m-t-0 m-b-24">
                <div class="tick-mark m-t-6">
                    <span class="material-icons">done</span>
                </div>
                <div class="uploaded-text chbox-blue import-report-top-text">
                    <p class="sans-p font-16 font-400 m-b-3">Client Credit Monitoring Login Details Found</p>
                    <p class="sans-p"><a href="javascript:void(0);" id="edit_credentials" class="blue" onclick="$('#no_details').show();$('#auto_deatils_found').hide();">Edit Credentials</a></p> 
                </div>
            </div>
                    <div class="text-center  mt-3">
                <button type="button" class="btn btn-success btn-icon-text" id="reimport_credit_report"> Reimport Credit Report</button>
        </div>
          </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel">
  <p>
    Use the form below to manually import alternate providers (Not Recommended). Out of all 6 alternate providers available below, CreditHeroScore works best. Others can’t import scores and give fewer details. Using raw source code requires advanced computer skill and practice.
  </p>

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label><strong>Credit Report Source Code *</strong></label>
        <textarea class="form-control" rows="10" placeholder="Paste your source code here..."></textarea>
      </div>
    </div>
  </div>

  <p class="mt-3">
    A "time-out" message may appear if the source code is too large for your system (most common in Chrome).
    You can: <br>
    (a) Try a different web browser -- or <br>
    (b) Save the source code as a txt or html file and click here to browse for the file.
  </p>

  <div class="form-group d-flex justify-content-end mt-4">
    <button type="button" class="btn btn-secondary mr-2" id="cancelimport">Cancel</button>
    <button type="button" class="btn btn-success" id="manualImport">Reimport Credit Report</button>
  </div>
</div>

        </div>

     </div>
    </div>
  </div>
</div>

<div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Duplicate Report Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
  <div class="text-center">
    <img src="<?php echo base_url('assets/img/auditwarning.png'); ?>" 
         style="height: 100px; cursor: pointer; margin-bottom: 20px;" />
  </div>

  <div id="duplicatereportcontent" style="text-align: center; font-size: 16px;"></div>

  <div class="note mt-3" style="font-size: 14px; color: #6c757d; border-left: 4px solid #007bff; padding-left: 10px; margin-top: 20px;">
    Note: Reports update once a month, unless you physically log into the credit monitoring service itself to purchase an additional report. Then it will become available in CRC.
  </div>

  <div class="form-group row" style="padding: 0 20px; display: flex; justify-content: space-between; margin-top: 20px;">
    <button type="button" class="btn btn-success btn-icon-text" style="width: 48%;" id="reimport_credit_report_continue"> Continue Anyway</button>
    <a type="button" class="btn btn-secondary btn-icon-text" style="width: 48%;" href="<?php echo base_url(); ?>dashboard/<?php echo get_encoded_id($client[0]->sq_client_id); ?>"> Back to Dashboard</a>
  </div>
</div>

    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready(function() {
		let originalValues = {}; // Store original values for cancel action
$('#reimport_credit_reports').on('click', function() {
    $('#reimportModal').modal('show');
  });
  $('#cancelimport').on('click', function() {
    $('#reimportModal').modal('hide');
  });
    $('#manualImport').on('click', function() {
    $('#reimportModal').modal('hide');
    Swal.fire({
    		title: '',
    		text: 'Manual Import for CreditHeroScore is not supported. Please import CreditHeroScore report using 1-Click Auto Import.',
    		icon: '',
    		showConfirmButton: true,
    	});
  });
		$('#edit_btn').click(function() {
			$('.readonly-input').addClass('disabled-input');
			$('.copy-email').addClass('secondary-background');
			$('.editable-input').prop('readonly', false);
			$('.editable-input').css('background-color', 'white');

			$('#edit_btn').addClass('d-none');
			$('#save_btn, #cancel_btn').removeClass('d-none');

			// Store original values
			$('.editable-input').each(function() {
				originalValues[$(this).attr('id')] = $(this).val();
			});
		});

		$('#cancel_btn').click(function() {
			// Reset values
			$('.editable-input').each(function() {
				$(this).val(originalValues[$(this).attr('id')]).prop('readonly', true);
			});
			$('.editable-input').css('background-color', '#f5f8fa ');
			$('.readonly-input').removeClass('disabled-input');
			$('.copy-email').removeClass('secondary-background');

			$('#edit_btn').removeClass('d-none');
			$('#save_btn, #cancel_btn').addClass('d-none');
		});

		$('#save_btn').click(function() {
			$.ajax({
				url: '<?= base_url('Dashboard/update_crx_credentials'); ?>',
				method: 'POST',
				data: $('#frm_report_access_detail').serialize(),
				dataType: 'json',
				success: function(response) {
					// let res = JSON.parse(response);
					if (response.status === 'success') {
						Swal.fire({
							title: 'Success',
							text: response.message,
							icon: 'success',
							showConfirmButton: true,
						}).then(() => {
							location.reload();
						});
					} else {
						Swal.fire({
							title: 'Error',
							text: response.message,
							icon: 'error',
							showConfirmButton: true,
						});
					}
				}
			});
		});

		// Toggle password visibility
		$('#toggle_password').click(function() {
			let passwordField = $('#s_password');
			let icon = $(this).find('i');

			if (passwordField.attr('type') === 'password') {
				passwordField.attr('type', 'text');
				icon.removeClass('mdi-eye').addClass('mdi-eye-off');
			} else {
				passwordField.attr('type', 'password');
				icon.removeClass('mdi-eye-off').addClass('mdi-eye');
			}
		});

		// Copy password
		$('#copy_password').click(function() {
			let passwordField = $('#s_password');
			let tempInput = $('<input>');
			$('body').append(tempInput);
			tempInput.val(passwordField.val()).select();
			document.execCommand('copy');
			tempInput.remove();

			Swal.fire({
				title: 'Copied!',
				text: 'Password copied to clipboard.',
				icon: 'success',
				timer: 1500,
				showConfirmButton: false
			});
		});

		// Copy Email
		$('#copy_email').click(function() {
			let emailField = $('#user_name');
			let tempInput = $('<input>');
			$('body').append(tempInput);
			tempInput.val(emailField.val()).select();
			document.execCommand('copy');
			tempInput.remove();

			Swal.fire({
				title: 'Copied!',
				text: 'User Name copied to clipboard.',
				icon: 'success',
				timer: 1500,
				showConfirmButton: false
			});
		});
	});

	$(document).on('click', '#reimport_credit_report', function(e) {
		e.preventDefault();

		let newReportAvailable = <?php echo json_encode($new_report_available); ?>;
		let id = <?= $result[0]->id ?? '0' ?>;
	$('#loader').show();
if (!newReportAvailable) {
    let lastday = <?= $days_since_last_import ?>;
    
    setTimeout(function() {
        $('#loader').hide();
        $('#reimportModal').modal('hide');
        $('#duplicateModal').modal('show');
        
        var daysCount = $('.days_count').text(); // Pehle value nikal lo
        var content = `You imported this same report ${lastday} day ago. If you continue there will be no changes to the report.<br/>A new report will be available in ${daysCount} days.`;
        document.getElementById("duplicatereportcontent").innerHTML = content;
    }, 3000); // 3 second delay

    return;
}


		Swal.fire({
			title: 'Are you sure?',
			text: 'You are about to download the new report.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, download it!',
			cancelButtonText: 'No, cancel!'
		}).then((result) => {
			if (result.isConfirmed) {
				$('#loader').show();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url() . "Credit_report/reimportCreditReport"; ?>',
					data: {
						id: id
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
							 window.location.href = '<?php echo base_url("preview_credit_report/$client_id"); ?>';
							});
						} else {
							Swal.fire({
								title: res.status === 'no_report' ? 'Credit Report Info' : 'Error',
								text: res.message,
								icon: res.status === 'no_report' ? 'info' : 'error',
								confirmButtonText: 'Close'
							});
						}
					},
					error: function() {
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
$(document).on('click', '#reimport_credit_report_continue', function(e) {
    e.preventDefault();

    let id = <?= $result[0]->id ?? '0' ?>;
 $('#duplicateModal').modal('hide');
    $('#loader').show();
    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Credit_report/reimportCreditReport"; ?>',
        data: {
            id: id
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
                   window.location.href = '<?php echo base_url("preview_credit_report/$client_id"); ?>';
                });
            } else {
                Swal.fire({
                    title: res.status === 'no_report' ? 'Credit Report Info' : 'Error',
                    text: res.message,
                    icon: res.status === 'no_report' ? 'info' : 'error',
                    confirmButtonText: 'Close'
                });
            }
        },
        error: function() {
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
});
</script>