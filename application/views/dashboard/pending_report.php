<?php
// Fetch the latest added_date from the scores array
$latest_date = null;
$days_since_last_import = 0;
$new_report_available = false;

if (!empty($result)) {
	foreach ($result as $value) {
		$scores = unserialize($value->scores);
		foreach ($scores as $score_record) {
		$date = !empty($score_record['added_date']) ? strtotime($score_record['added_date']) : null;

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
<style type="text/css">
	#order-listing {
		border-collapse: collapse;
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
	.numspam{
        border-radius: 50%;
    background: #0075cc;
    padding: 2px;
    color: #fff;
    width: 15px;
    height: 15px;
    font-size: 11px !important;
}

.link{
        color: #0056b3!important;
    text-decoration: underline!important;
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

    <a href="<?= base_url(); ?>import_audit/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">1</span> Import / Audit
    </a>

    <a href="<?= base_url(); ?>pending_report/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link active">
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

									<h4 class="heading-h4 table-heading">Tag Pending Report (<?php echo htmlspecialchars($get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name); ?>) </h4>
									<p>Last imported <?php echo $days_since_last_import; ?> days ago

										<!--| <span id="inreport" style="color:red; <?php echo $new_report_available ? 'display:none;' : ''; ?>">-->
										<!--	New Report available in <span style="font-weight: bold;"><span class="days_count"><?php echo max(0, 30 - $days_since_last_import); ?></span> days</span>-->
										<!--</span>-->

										<span id="nowreport" style="color: rgb(0, 166, 80); <?php echo $new_report_available ? '' : 'display:none;'; ?>">
											New Report available <span style="font-weight: bold;">now</span>
										</span>
									</p>
									<p>
										<img width="84" src="<?php echo base_url('downloads/importcloud.png'); ?>" alt="Reimport Credit Report">
									</p>
									<p>
									    <a href="<?php echo base_url(); ?>import_audit/<?php echo get_encoded_id($client[0]->sq_client_id); ?>"  class="btn" style="background-color: rgb(0, 166, 80);color:white;">
										Tag And Save Pending Report
										</a>
									</p>
									<p>
										<a href="javascript:void(0)" class="btn" id="reimport_credit_report" style="background-color: rgb(0, 166, 80);color:white;">
											Reimport Credit Report
										</a>
									</p>
								</div>

								<div class="col-12 col-md-6">
                               <h4>Pending Reports</h4>
								<table class="table table-bordered table-hover jsgrid">
								    <thead class="thead-dark">
								        <tr>
								            <th>Date Saved As Pending</th>
								            <th>Team Member</th>
								        </tr>
								    </thead>
								    <tbody>
								          <?php if (!empty($pending_logs)): ?>
                                        <?php foreach ($pending_logs as $logitem): ?>
                                            <tr>
                                                <td>
                                                    <?= $logitem->date; ?>
                                                </td>
                                             <td>
    <?= $logitem->added_by; ?> 
    <span class="float-end">
        <a href="<?= base_url('preview_credit_report/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="link">Click to preview</a>
    </span>
</td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center" colspan="2">No reports pending</td>
                                        </tr>
                                    <?php endif; ?>
								    
								    </tbody>
								</table>

                                <h4 class="mt-4">Import Logs</h4>
								<table class="table table-bordered table-hover jsgrid">
								    <thead class="thead-dark">
								        <tr>
								            <th>Date Imported</th>
								            <th>Team Member</th>
								        </tr>
								    </thead>
								    <tbody>
								       <?php if (!empty($report_logs)): ?>
                                        <?php foreach ($report_logs as $logitem): ?>
                                            <tr>
                                                <td>
                                                    <?= $logitem->datetime; ?>
                                                </td>
                                                <td><?= $logitem->added_by; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center" colspan="2">No Logs</td>
                                        </tr>
                                    <?php endif; ?>

								    </tbody>
								</table>
								</div>
							</div>
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

		if (!newReportAvailable) {
	let lastday = <?= $days_since_last_import ?>;
$('#duplicateModal').modal('show');

var daysCount = $('.days_count').text(); // Pehle value nikal lo
var content = `You imported this same report ${lastday} day ago. If you continue there will be no changes to the report.<br/>A new report will be available in ${daysCount} days.`;

document.getElementById("duplicatereportcontent").innerHTML = content;

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
								location.reload();
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
                    location.reload();
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