<style type="text/css">
  .modal .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
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
</style>
<div id="msgAppend11task"></div>
<div class="modal fade" id="print_affiliate" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 75%;">
    <div class="modal-content">
      <div class="modal-header ptbtn" style="padding-bottom: 0px;">
        <h5 class="modal-title" id="ModalLabel">Print affiliate partners</h5>
        <button type="button" id="cltbtn" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="print_affiliate"></div>
      </div>
      <div class="modal-footer" style="padding: 15px 20px;">

        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-success ptbtn">OK</button>
        <button type="button" class="btn btn-success print_button ptbtn">Print</button>
        <!-- <button type="button" class="btn btn-light" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ImportCSV" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header ptbtn" style="padding-bottom: 0px;">
        <h5 class="modal-title" id="ModalLabel">Import affiliates from csv file</h5>
        <button type="button" id="cltbtn" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="csvfrm" id="csvfrm" method="post" action="<?php echo base_url("affiliates/import_affiliate_csv_from_anywhere"); ?>" enctype="multipart/form-data">
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
              <!-- added on 05-01-2017 start -->
              <!-- added on 05-01-2017 end -->
              </tr>
            </tbody>
          </table>

      </div>
      <div class="modal-footer" style="padding: 15px 20px;">
        <button type="submit" class="btn btn-success" name="submit">Import</button>
        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-success">Close</button>
        </form>
        <!-- <button type="button" class="btn btn-light" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>

<?php if ($this->session->flashdata('success')) { ?>
  <div id="affSuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style="">Record Uploaded!</div>
      <div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div>
      <div class="swal-footer">
        <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button>
          <div class="swal-button__loader">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php if ($this->session->flashdata('successemail')) { ?>
  <div id="affSuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style="">Email Notification</div>
      <div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div>
      <div class="swal-footer">
        <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button>
          <div class="swal-button__loader">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
          <div class="page-header mb-4">
          <h1> Affiliate Partners </h1>
                              <button type="button" class="btn btn-gradient-primary btn-icon-text  float-right" onclick="return go_to_affiliates();"> <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Affiliate </button>

          </div>
      <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $this->session->flashdata('error'); ?>
        </div>
      <?php } ?>
      <div class="card">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-12">
                            <a href="javascript:;" class="csv-link float-right print_affiliate_sec">
  <i class="mdi mdi-printer"></i> Print
</a>

<a href="<?php echo base_url("Affiliates/export_affiliate_csv"); ?>" class="csv-link float-right mr-4">
 Export CSV
</a>

<a data-toggle="modal" data-target="#ImportCSV" class="csv-link float-right">
  <i class="mdi mdi-file-import"></i> Import&nbsp;/
</a>
            </div>
          </div>
  <form method="get mt-3">
    <div class="row mb-3">
      <div class="col-md-3">
        <label for="aname" class="form-label font-weight-bold">Affiliate Name</label>
        <input type="text" name="aname" id="aname" class="form-control" value="<?php echo $this->input->get('aname'); ?>" placeholder="Enter Name" autocomplete="off">
      </div>

      <div class="col-md-3">
        <label for="aemail" class="form-label font-weight-bold">Email</label>
        <input type="text" name="aemail" id="aemail" class="form-control" value="<?php echo $this->input->get('aemail'); ?>" placeholder="Enter Email">
      </div>

      <div class="col-md-3">
        <label for="acompany" class="form-label font-weight-bold">Company</label>
        <input type="text" name="acompany" id="acompany" class="form-control" value="<?php echo $this->input->get('acompany'); ?>" placeholder="Enter Company">
      </div>

      <div class="col-md-3">
        <label for="qf" class="form-label font-weight-bold">Status</label>
        <select name="qf" id="qf" class="form-control">
          <option value="">All</option>
            <?php
            $status = array(1 => "Active", 0 => "Inactive", 2 => "Pending");
            $qf = $this->input->get("qf");
            
            foreach ($status as $key => $val) {
                // If qf is set and not empty, use it; otherwise default to 1
                $selected = ($qf !== '' && $qf !== null) ? ($qf == $key ? "selected" : "") : ($key == 1 ? "selected" : "");
                echo "<option value='$key' $selected>$val</option>";
            }
            ?>

        </select>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col text-right">
        <button type="submit" name="search" id="search" class="btn btn-primary"
          onclick="return list_pagination('https://app.creditrepaircloud.com/affiliate/affiliates_ajax/0');">
          <i class="mdi mdi-magnify"></i> Search
        </button>
      </div>
    </div>
  </form>


          <div class="row">
            <div class="col-md-12 table-responsive">
              <table id="order-listing" class="table jsgrid datatable">
                <thead>
                  <tr>
                        <th style="display:none;">Affiliate ID</th> <!-- hidden id column -->
                    <th>Affiliate Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Clients Referred</th>
                    <th>Phone</th>
                    <th>Added</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php if ($affilates_data != '') {
                    foreach ($affilates_data as $affiliates) {
                      $edit_url = base_url("edit-affiliates/" . $affiliates->sq_affiliates_id);
                  ?>
                      <tr>
                            <td style="display:none;"><?= $affiliates->sq_affiliates_id; ?></td> <!-- hidden id -->
                        <td><a href="<?php echo $edit_url; ?>"><?php echo $affiliates->sq_affiliates_first_name . ' ' . $affiliates->sq_affiliates_last_name; ?></a></td>
                        <td><?php echo $affiliates->sq_affiliates_company; ?></td>
                        <td><a href="mailto:<?php echo $affiliates->sq_affiliates_email; ?>"><?php echo $affiliates->sq_affiliates_email; ?></a></td>
                        <td><?php
                            if (isset($affiliates->sq_affiliates_assigned_to)) {
                              $assigned_to = unserialize($affiliates->sq_affiliates_assigned_to);
                              if (is_array($assigned_to)) {
                                echo '<a href="' . $edit_url . '">' . count($assigned_to) . ' clients</a>';
                              }
                            } else {
                              echo "0 clients";
                            }
                            ?></td>
                        <td><?php echo preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $affiliates->sq_affiliates_phone); ?></td>
                        <td><?php echo date('m/d/Y', strtotime($affiliates->sq_affiliates_created_at)); ?></td>
                        <td><?php echo $status[$affiliates->sq_affiliates_status]; ?></td>
                        <!-- <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center">
                        <?php if ($affiliates->sq_affiliates_portal == 1) { ?>
                          <i class="mdi mdi-message-text menu-icon"></i>
                        <?php } ?>
                      </td> -->
                        <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center">
                          <a title="Edit" href="<?php echo $edit_url; ?>"><i class="mdi mdi-pencil"></i></a>
                          <a title="Remove" onclick="removeAffiliates(this,'<?php echo $affiliates->sq_affiliates_id; ?>')"><i class="mdi mdi-delete"></i></a>
                          <a title="Send Email" class="text-success" onclick="sendEmailPopUp(this,'<?php echo $affiliates->sq_affiliates_id; ?>');"><i class="mdi mdi-email"></i></a>
                        </td>

                      </tr>
                    <?php }
                  } else { ?>
                    <td colspan="8" style="text-align: center;">Records not found</td>
                  <?php } ?>



                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- content-wrapper ends -->
    <!---------- email send ------------->
    <div class="modal fade" id="emailsend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo base_url(); ?>Affiliates/sendemailNotificationaff">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><b>Email Notification</b></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="affID" id="affID" value="">

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

    <script>
      function removeAffiliates(that, affid) {

        if (affid != '') {

          if (confirm('Are you sure to remove this affiliate?')) {

            $.ajax({

              type: 'post',
              url: '<?php echo base_url() . "Affiliates/removedata"; ?>',
              data: {
                'id': affid
              },
              success: function(response) {


                if (response == '1') {

                  var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Affiliates Data</div><div class="swal-text" style="">Data removed successfully!</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                  $('#msgAppend11task').after(succesMsg);
                }
              }
            })
          }
        }

      }

      function closeSuccessModalNewtask() {

        $('#pDsuccess11').css('display', 'none');
        $('#pDMsuccess11').css('display', 'none');
        //$('#items tr#row'+id).remove();
        location.reload();

      }

      function sendEmailPopUp(that, affid) {

        $('#emailsend input#affID').val(affid);
        $('#emailsend').modal('show');

      }

      function go_to_affiliates() {
        window.location.href = "<?php echo base_url() ?>new-affiliates";
      }
      $(".print_affiliate_sec").on("click", function() {
        $("#print_affiliate").modal("show");
        $.ajax({
          type: 'POST',
          url: '<?php echo "Affiliates/get_all_affiliate_to_print"; ?>',
          data: {},
          success: function(response) {
            $(".print_affiliate").html(response);
          }

        });
      })

      $("body").on("click", ".print_button", function() {
        var prtContent = document.getElementById("print_affiliate");
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

      function closeSuccessModal() {
        $('#affSuccess').css('display', 'none');
      }
    </script>