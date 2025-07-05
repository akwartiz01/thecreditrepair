<?php
$client_status = $this->config->item('client_status');

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style type="text/css">
  .modal .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }
/*  .sorting_asc::before,  .sorting_asc::after, .sorting::before,  .sorting::after{*/
/*    content:""!important;*/
/*}*/
  @keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
#asclient{
    width:150px!important;
}
.bg-green{
    background:green!important;
}
 .csv-link {
        color: #007bff !important;
    text-decoration: none !important;
    font-weight: 500;
    margin-right:5px;
    cursor: pointer;
  }
  .csv-link:hover {
    text-decoration: underline;
  }
  /**** NEW CODE ****/
  a.s_icon {
    font-size: 20px;
  }

  select.custom-select-sm {
    color: black;
    border: 1px solid #d0d0d0;
  }

  .card .card-body {
    padding: 1.25rem !important;
  }

  /* @media (min-width: 1200px) {
    .container-scroller .content-wrapper {
      max-width: 1550px !important;
    }
  }

  @media (min-width: 992px) {
    .container-scroller .content-wrapper {
      max-width: 1350px !important;
    }
  } */

  /**** END NEW CODE ****/

  /* css 02-May-25 start */
  @media screen and (max-width: 767px) {
    div#DataTables_Table_0_length {
      text-align: left;
    }
    div#DataTables_Table_0_filter {
      float: left;
      text-align: left;
    }
    div.dataTables_wrapper div.dataTables_filter input {
      width: 100%;
    }
    .col-sm-12.col-md-6 div#DataTables_Table_0_filter {
      margin-left: -20px;
      margin-top: 5px;
    }
    .col-sm-12.col-md-7 {
      padding: 0;
    }
    .col-sm-12.col-md-7 a.page-link {
      padding: 8px 7.5px;
    }
    .col-sm-12.col-md-5 div#DataTables_Table_0_info {
      text-align: left;
      margin-bottom: 5px;
    }
  }
  /* css 02-May-25 end */

</style>
<div id="loader-overlay" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; text-align:center;">
  <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
    <div class="spinner" style="border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;"></div>
    <p style="margin-top:10px;">Importing, please wait...</p>
  </div>
</div>
<div id="deletePopup" class="swal-overlay swal-overlay--show-modal" tabindex="-1" style="display: none;">
  <div id="deletePopupModal" class="swal-modal" role="dialog" aria-modal="true" style="display: none;">
    <input type="hidden" name="hiddenClientId" id="hiddenClientId" value="">
    <div class="swal-icon swal-icon--warning">
      <span class="swal-icon--warning__body">
        <span class="swal-icon--warning__dot"></span>
      </span>
    </div>
    <div class="swal-title" style="">Are you sure?</div>
    <div class="swal-text" style="">You won't be able to revert this!</div>
    <div class="swal-footer">
      <div class="swal-button-container">
        <button class="swal-button swal-button--cancel btn btn-danger" onclick="deleteCancel();">Cancel</button>
        <div class="swal-button__loader">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div class="swal-button-container">
        <button class="swal-button swal-button--confirm btn btn-primary" onclick="deleteClient();">OK</button>
        <div class="swal-button__loader">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php if ($this->session->flashdata('success')) { ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Record Uploaded!',
      text: '<?php echo addslashes($this->session->flashdata('success')); ?>',
      confirmButtonText: 'Continue',
      customClass: {
        confirmButton: 'btn btn-primary'
      },
      buttonsStyling: false
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('successs')) { ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Email Notification!',
      text: '<?php echo $this->session->flashdata('success'); ?>',
      confirmButtonText: 'Continue',
      customClass: {
        confirmButton: 'btn btn-primary'
      },
      buttonsStyling: false
    });
  </script>
<?php } ?>


<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
            <div class="page-header">
          <h1> Clients </h1>
          </div>
        <!--<h3 class="page-title"> My Clients </h3>-->
        <!--<nav aria-label="breadcrumb">-->
        <!--  <ol class="breadcrumb">-->
        <!--    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>-->
        <!--    <li class="breadcrumb-item active" aria-current="page">My Clients</li>-->
        <!--  </ol>-->
        <!--</nav>-->
                               <a href="<?php echo base_url(); ?>add-client"><button type="button" class="btn btn-success mr-2 btn-sm float-right"><i class="mdi mdi-account"></i> Add Client</button></a>

      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12 mb-4">
                         <a href="<?php echo base_url('client/Client/export_csv'); ?>" class="csv-link float-right"> Export CSV</a>

<a data-toggle="modal" data-target="#ImportCSV" class="csv-link float-right"> <i class="mdi mdi-file-import"></i> Import&nbsp;/ </a>


            </div>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table jsgrid datatable" id="clientdata"><!--my_clients_datatable-->
                <thead class="thclickdisabled">
                  <tr>
                      <th style="display:none;">Client ID</th> <!-- hidden id column -->
                    <th>Name</th>
                    <th>Referred By</th>
                    <th>Added</th>
                    <th>Last Login</th>
                    <th>Onboarding Stage</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                     <?php if ($clients_data != '') {
                    foreach ($clients_data as $row) {
                        $value = $row->sq_referred_by;

                        if($row->payment_status == 1){
                    
                  ?>
                  <tr>
                       <td style="display:none;"><?= $row->sq_client_id; ?></td> <!-- hidden id -->
                        <td><?php echo '<a title="Name" class="text-success" href="' . base_url() . 'dashboard/' . get_encoded_id($row->sq_client_id) . '">' . ucwords($row->sq_first_name . ' ' . $row->sq_last_name) . '</a>';?></td>
                            <td> <?php
if (is_numeric($value)) {
    $this->db->where('sq_affiliates_id ', $value);
    $user = $this->db->get('sq_affiliates')->row();

    if ($user) {
        echo $user->sq_affiliates_first_name . ' ' . $user->sq_affiliates_last_name;
    } 
} else {
  
    echo $value;
}
?></td>
                          <td><?= $row->sq_client_added;?></td>
                          <td><?= $row->last_login;?></td>
                          <td>
                              <?php
                              
                               if ($row->agreement_signed == '0') {
               echo '<p style = "text-align:center;"><span id = "onboarding_stage_login">Login Details</span>' . '<br><span id = "onboarding_date">' . $row->login_detail_sent_date . '</span></p>';
            } elseif ($row->agreement_signed == '1') {
               echo '<p style = "text-align:center;"><span id = "onboarding_stage_agreement"><a title="Name" class="text-success" href="' . $row->agreement_pdf_path . '" target = "_blank">Agreement Signed<br></a></span><span style id = "onboarding_date">' . $row->agreement_sign_date . '</span></p>';
            } else {

               echo "";
            }
                              ?>
                          </td>
                          <td><?= !empty($row->sq_status) ? [
                    1 => "Lead",
                    2 => "Prospect",
                    3 => "Lead/Inactive",
                    4 => "Client",
                    5 => "Inactive",
                    6 => "Suspended"
                ][$row->sq_status] ?? "" : ""?></td>
               
                                 <td>
                      <span class="badge bg-green text-white">
                        <i class="bi bi-check-circle-fill"></i> PAID
                      </span>
                    </td>
                          <td>
                              <?=
                              '<a title="Edit" class="text-success s_icon" href="' . base_url() . 'edit-client/' . base64_encode(base64_encode($row->sq_client_id)) . '"><i class="mdi mdi-pencil"></i></a>
                              <a title="Delete" class="text-success s_icon" onclick="deleteClientPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-delete"></i></a>
                              <a title="Send Email" class="text-success s_icon" onclick="sendEmailPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-email"></i></a>'
                              ?>
                          </td>
                          </tr>
                   <?php } 
                   if($row->payment_status == 2){?>
                             <tr>
                       <td style="display:none;"><?= $row->sq_client_id; ?></td> <!-- hidden id -->
                        <td class="text-danger"><?= ucwords($row->sq_first_name . ' ' . $row->sq_last_name) ;?></td>
                            <td> <?php
if (is_numeric($value)) {
    $this->db->where('sq_affiliates_id ', $value);
    $user = $this->db->get('sq_affiliates')->row();

    if ($user) {
        echo $user->sq_affiliates_first_name . ' ' . $user->sq_affiliates_last_name;
    } 
} else {
  
    echo $value;
}
?></td>
                          <td><?= $row->sq_client_added;?></td>
                          <td><?= $row->last_login;?></td>
                          <td>
                              <?php
                              
                               if ($row->agreement_signed == '0') {
               echo '<p style = "text-align:center;"><span id = "onboarding_stage_login">Login Details</span>' . '<br><span id = "onboarding_date">' . $row->login_detail_sent_date . '</span></p>';
            } elseif ($row->agreement_signed == '1') {
               echo '<p style = "text-align:center;"><span id = "onboarding_stage_agreement"><a title="Name" class="text-success" href="' . $row->agreement_pdf_path . '" target = "_blank">Agreement Signed<br></a></span><span style id = "onboarding_date">' . $row->agreement_sign_date . '</span></p>';
            } else {

               echo "";
            }
                              ?>
                          </td>
                          <td><?= !empty($row->sq_status) ? [
                    1 => "Lead",
                    2 => "Prospect",
                    3 => "Lead/Inactive",
                    4 => "Client",
                    5 => "Inactive",
                    6 => "Suspended"
                ][$row->sq_status] ?? "" : ""?></td>
                  <td>
                          <span class="badge bg-danger text-white">
                            <i class="bi bi-x-circle-fill"></i> NOT PAID
                          </span>
                        </td>
                         
                          <td>
                              <?=
                              '<a title="Resend Payment Link" class="text-success s_icon" onclick="resendPaymentLink(this,' . $row->sq_client_id . ');"><i class="bi bi-arrow-repeat"></i></a>
                              <a title="Edit" class="text-success s_icon" href="' . base_url() . 'edit-client/' . base64_encode(base64_encode($row->sq_client_id)) . '"><i class="mdi mdi-pencil"></i></a>
                              <a title="Delete" class="text-success s_icon" onclick="deleteClientPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-delete"></i></a>
                              <a title="Send Email" class="text-success s_icon" onclick="sendEmailPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-email"></i></a>'
                              ?>
                          </td>
                          </tr>
               <?php    }
                         if($row->payment_status == 0){
                    
                  ?>
                  <tr>
                       <td style="display:none;"><?= $row->sq_client_id; ?></td> <!-- hidden id -->
                        <td><?php echo '<a title="Name" class="text-success" href="' . base_url() . 'dashboard/' . get_encoded_id($row->sq_client_id) . '">' . ucwords($row->sq_first_name . ' ' . $row->sq_last_name) . '</a>';?></td>
                            <td>
                                <?php
if (is_numeric($value)) {
    $this->db->where('sq_affiliates_id ', $value);
    $user = $this->db->get('sq_affiliates')->row();

    if ($user) {
        echo $user->sq_affiliates_first_name . ' ' . $user->sq_affiliates_last_name;
    } 
} else {
  
    echo $value;
}
?>
                            </td>
                          <td><?= $row->sq_client_added;?></td>
                          <td><?= $row->last_login;?></td>
                          <td>
                              <?php
                              
                               if ($row->agreement_signed == '0') {
               echo '<p style = "text-align:center;"><span id = "onboarding_stage_login">Login Details</span>' . '<br><span id = "onboarding_date">' . $row->login_detail_sent_date . '</span></p>';
            } elseif ($row->agreement_signed == '1') {
               echo '<p style = "text-align:center;"><span id = "onboarding_stage_agreement"><a title="Name" class="text-success" href="' . $row->agreement_pdf_path . '" target = "_blank">Agreement Signed<br></a></span><span style id = "onboarding_date">' . $row->agreement_sign_date . '</span></p>';
            } else {

               echo "";
            }
                              ?>
                          </td>
                          <td><?= !empty($row->sq_status) ? [
                    1 => "Lead",
                    2 => "Prospect",
                    3 => "Lead/Inactive",
                    4 => "Client",
                    5 => "Inactive",
                    6 => "Suspended"
                ][$row->sq_status] ?? "" : ""?></td>
               
                                 <td>
                     
                          <td>
                              <?=
                              '<a title="Edit" class="text-success s_icon" href="' . base_url() . 'edit-client/' . base64_encode(base64_encode($row->sq_client_id)) . '"><i class="mdi mdi-pencil"></i></a>
                              <a title="Delete" class="text-success s_icon" onclick="deleteClientPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-delete"></i></a>
                              <a title="Send Email" class="text-success s_icon" onclick="sendEmailPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-email"></i></a>'
                              ?>
                          </td>
                          </tr>
                   <?php }
                    }
                 } else { ?>
                    <td colspan="12" style="text-align: center;">Records not found</td>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!---------- email send ------------->
    <div class="modal fade" id="emailsend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo base_url(); ?>Admin/sendemailNotification">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><b>Email Notification</b></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="clientID" id="clientID" value="">

              <div class="row mb-2">
                <div class="col-12">
                  <label>Subject:</label>
                  <input type="text" name="subject" class="form-control" required="required" autocomplete="off">
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-12">
                  <label>Message:</label>
                  <textarea class="form-control" name="msg" rows="5"></textarea>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" name="send" class="btn btn-success btn-sm">Send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!---------- email send ------------->
    
    <div class="modal fade" id="ImportCSV" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header ptbtn" style="padding-bottom: 0px;">
        <h5 class="modal-title mb-2" id="ModalLabel">Import Clients from csv file</h5>
        <button type="button" id="cltbtn" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <form name="csvfrm" id="csvfrm" method="post" action="<?php echo base_url("client/Client/ImportData"); ?>" enctype="multipart/form-data">
          <table width="100%" cellspacing="5" cellpadding="0" border="0">
            <tbody>
              <tr>
                <td valign="top" align="left" class="normaltext1" colspan="2">
                  <div style="width:auto" class="chbox"> Choose the CSV file.</div><br>
                </td>
              </tr>
              <tr>
                <td class="normaltext1">File: </td>
                <td><input type="file" id="upload_csv" name="upload_csv" required></td>
              </tr>
              </tr>
            </tbody>
          </table>

      </div>
      <div class="modal-footer" style="padding: 15px 20px;">
        <button type="submit" class="btn btn-success" name="submit">Import</button>
        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-success">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <!-- content-wrapper ends -->

    <script type="text/javascript">

      function sendEmailPopUp(that, clientID) {

        $('#emailsend input#clientID').val(clientID);
        $('#emailsend').modal('show');

      }

    //   function deleteClientPopUp(that, id) {

    //     $('#hiddenClientId').val(id);
    //     $('#deletePopup').css('display', '');
    //     $('#deletePopupModal').css('display', '');
    //     $('#loader').css('display', '');

    //   }

      function deleteCancel() {
        $('#deletePopup').css('display', 'none');
        $('#deletePopupModal').css('display', 'none');
      }

      function closeSuccessModal() {
        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');
        location.reload();

      }

     
function deleteClientPopUp(that, id) {
//   var id = $('#hiddenClientId').val();

  Swal.fire({
    title: 'Are you sure?',
    text: 'Do you really want to delete this client?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with deletion
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url("Admin/deleteClient"); ?>',
        data: { id: id },
        success: function(response) {
          var data = JSON.parse(response);

          if ($.trim(data) == 'deleted') {
          
            Swal.fire({
              icon: 'success',
              title: 'Client Deleted!',
              text: 'You have deleted the client successfully',
              confirmButtonText: 'Continue'
            }).then(() => {
              location.reload(); // Reload the page
            });
          }
        }
      });
    }
  });
}

    </script>
    <script>
  document.getElementById("csvfrm").addEventListener("submit", function() {
    document.getElementById("loader-overlay").style.display = "block";
  });
function resendPaymentLink(elem, clientId) {
  if (!confirm("Are you sure you want to resend the payment link?")) {
    return;
  }

  // Disable the button temporarily and show spinner
  var originalContent = $(elem).html();
  $(elem).html('<i class="bi bi-arrow-repeat spin"></i> Sending...').addClass('disabled');

  $.ajax({
    url: '<?= base_url("Admin/resend_payment_link") ?>',
    type: 'POST',
    data: { client_id: clientId },
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        alert("✅ Payment link resent successfully.");
      } else {
        alert("❌ Failed to resend link: " + response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error(error);
      alert("🚫 AJAX error occurred. Please try again.");
    },
    complete: function() {
      // Restore original button content
      $(elem).html(originalContent).removeClass('disabled');
    }
  });
}

</script>