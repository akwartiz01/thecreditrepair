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
			$date = strtotime($score_record['added_date']);
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

	/*.navigation_mini .btn {*/
	/*	padding: 10px 38px !important;*/
	/*}*/
</style>

<div id="msgAppend1234"></div>

<div class="container-fluid page-body-wrapper">
	<div class="main-panel pnel">
		<div class="content-wrapper">

			<div class="row">
				<div class="col-md-12 navigation_mini" style="display: flex; flex-wrap: wrap; gap: 10px; justify-content:center;">

					<a type="button" href="<?php echo base_url(); ?>dashboard/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-account-circle"></i> Dashboard</a>

					<a type="button" href="<?php echo base_url(); ?>import_audit/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="active btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-file-document"></i> Import/Audit</a>

					<a type="button" href="<?php echo base_url(); ?>pending_report/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-file-powerpoint"></i> Tag Pending Report</a>

          <a type="button" href="<?php echo base_url(); ?>generate-letters/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-email"></i> Generate Letters</a>


					<a type="button" href="<?php echo base_url(); ?>send_letter/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-email"></i> Send Letters</a>

					<a type="button" href="<?php echo base_url('letters-status/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-email"></i> Letters & Status
					</a>

					<a type="button" href="<?php echo base_url('dispute_items/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-note-plus"></i> Dispute Items</a>

					<a type="button" href="<?php echo base_url('messages/send/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-comment"></i> Messages
					</a>

				</div>
			</div>
            <div class="row">
    				<div class="col-md-12">
    					<div class="card">
    						<div class="card-body">
    							<div class="row">
    								<div class="col-12">
    									<h1>Simple Audit (Credit Analysis)</h1>
    								</div>
    									<div class="col-12 mt-5 text-center">
                                            <h1>Generate Simple Audit Now</h1>
                                            <p>Last imported <?php echo $days_since_last_import; ?> days ago</p>
                                            <button type="button" class="btn btn-success btn-icon-text" id="generate_simple_audit">
                                                Generate Simple Audit
                                            </button>
                                        </div>
                                        
                                   <div class="col-12">
                                      <h4 class="mt-4">Saved Audits</h4>
                                        <table class="table table-bordered table-hover jsgrid">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Audit Name</th>
                                                    <th>Team Member</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <tr>
        								            <td class="text-center" colspan="3">No Data Found.</td>
        								        </tr>
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
</div>
  <div id="simpleAuditModal" class="modal fade" tabindex="-1" role="dialog" style="top: -90px !important;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="background-color: #fff !important;">
        <div class="modal-header">
          <h5 class="modal-title">Simple Audit (Credit Analysis)</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
                  <p style="margin:20px">Share the Simple Audit PDF below with your client. It provides an awesome overview of your service and the value you provide. Next, move on to step #2 to tag all negative items on your client's 3 Bureau Report.</p>

        <div class="modal-body" id="auditContent"></div>
        <div class="modal-footer">
             <button class="btn btn-success" id="emailAuditButton">Email Audit to Client</button> 
          <button class="btn btn-primary printAudit">Print</button>
          
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
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