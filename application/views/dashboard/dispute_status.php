<?php
$credit_bureau = $this->config->item('credit_bureau');
$dispute_status_opt = $this->config->item('dispute_status_opt');
$dispute_status_color = $this->config->item('dispute_status_color');

?>
<style type="text/css">
  .modal .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px !important;
  }

  .modal .modal-dialog .modal-content .modal-header {
    padding: 12px 26px;
  }

  label {
    font-weight: 600;
  }

  i.mdi {
    font-size: 18px;
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
</style>
<?php if ($this->session->flashdata('success')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style="">Dispute Item!</div>
      <div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div>
      <div class="swal-footer">
        <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Close</button>
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
<?php if ($this->session->flashdata('error')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--warning"><span class="swal-icon--warning__body"><span class="swal-icon--warning__dot"></span></span></div>
      <div class="swal-title" style="">Dispute Item!</div>
      <div class="swal-text" style=""><?php echo $this->session->flashdata('error'); ?></div>
      <div class="swal-footer">
        <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Close</button>
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

<div id="msgAppend"></div>
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> All Dispute Items (<?php echo $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name; ?>) </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dispute Items</li>
          </ol>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6" style="text-align: left; margin-bottom: 24px;">
              <a onclick="backtoprevious();">
                <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-arrow-left-thick btn-icon-prepend"></i> Back </button>
              </a>
            </div>
            <div class="col-6" style="text-align: right; margin-bottom: 24px;">

              <a onclick="adddisputeItem();">
                <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Item </button>
              </a>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12 table-responsive">
              <table class="table jsgrid datatable">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Creditor/Furnisher</th>
                    <th>Account#</th>
                    <th>Reason</th>
                    <th>Equifax</th>
                    <th>Experian</th>
                    <th>TransUnion</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($getalldisputeItem) && is_array($getalldisputeItem)) {
                    foreach ($getalldisputeItem as $row) {

                      $equi_ac  = trim(str_replace('ng-show="true"', '', strip_tags($row->equi_ac)));
                      $exper_ac  = trim(str_replace('>', '', strip_tags($row->exper_ac)));
                      $equi_status  = trim(str_replace('ng-show="true"', '', strip_tags($row->equi_status)));
                      $exper_status  = trim(str_replace('>', '', strip_tags($row->exper_status)));

                  ?>
                      <tr>
                        <td><?php echo date('m/d/Y', strtotime($row->added_date)); ?></td>
                        <td><?php if ($row->furnisher != "") {
                              echo $getfurnisherNames[$row->furnisher];
                            } ?></td>
                        <td>
                          <span>Equifax: <?php echo $equi_ac; ?></span><br>
                          <span>Experian: <?php echo $exper_ac; ?></span><br>
                          <span>TransUnion: <?php echo $row->tu_ac; ?></span>
                        </td>
                        <td><?php echo mb_strimwidth($row->reason, 0, 20, "..."); ?></td>

                        <!-- New added old deleted 09/08/2024 s  -->
                        <td class="<?php echo isset($dispute_status_color[$equi_status]) ? $dispute_status_color[$equi_status] : ''; ?>">
                          <?php echo isset($dispute_status_opt[$equi_status]) ? $dispute_status_opt[$equi_status] : ''; ?>
                        </td>

                        <td class="<?php echo isset($dispute_status_color[$exper_status]) ? $dispute_status_color[$exper_status] : ''; ?>">
                          <?php echo isset($dispute_status_opt[$exper_status]) ? $dispute_status_opt[$exper_status] : ''; ?>
                        </td>

                        <td class="<?php echo isset($dispute_status_color[$row->tu_status]) ? $dispute_status_color[$row->tu_status] : 'default-color'; ?>">
                          <?php echo isset($dispute_status_opt[$row->tu_status]) ? $dispute_status_opt[$row->tu_status] : ''; ?>
                        </td>

                        <!-- New added old deleted 09/08/2024 s  -->

                        <td>
                          <a title="Edit" class="text-success mr-1" onclick="editmydisputeitem('<?php echo $row->id; ?>');"><i class="mdi mdi-pencil"></i></a>
                          <a title="Remove" class="text-success" onclick="removemydisputeitem('<?php echo $row->id; ?>');"><i class="mdi mdi-delete"></i></a>
                        </td>
                      </tr>

                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="8">No dispute item found for this client!</td>
                    </tr>
                  <?php } ?>
                </tbody>

              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!------------------------------>
<div class="modal fade" id="disitemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 900px;">
    <div class="modal-content">
      <form method="post" action="<?php echo base_url(); ?>disStatusData">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><b>Client Dispute Item</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="diID" value="">
          <input type="hidden" name="clientid" value="<?php echo $clientid; ?>">
          <div class="row mt-2 mb-3">
            <div class="col-3">
              <label>Credit Bureau(s):</label>
            </div>
            <div class="col-9">
              <?php foreach ($credit_bureau as $key => $row) { ?>
                <input type="checkbox" id="credit<?php echo $key; ?>" class="ml-3" name="credit_bureaus[]" value="<?php echo $key; ?>"> <?php echo $row; ?>
              <?php } ?>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Creditor/Furnisher:</label>
            </div>
            <div class="col-4">
              <select name="furnisher" id="cfurnisher" class="form-control">
                <option value="">Select One</option>
                <?php if (isset($getallfurnisher) && is_array($getallfurnisher)) {
                  foreach ($getallfurnisher as $row) { ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->company_name; ?></option>
                <?php }
                } ?>
              </select>
            </div>
            <div class="col-4">
              <a href="<?php echo base_url(); ?>furnisher" class="text-success btn-sm">Add creditor/furnisher</a>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Account Number:</label>
            </div>
            <div class="col-3">
              <input type="text" id="equac" name="account_number[]" class="form-control" placeholder="Equifax account number" autocomplete="off">
            </div>
            <div class="col-3">
              <input type="text" id="exac" name="account_number[]" class="form-control" placeholder="Experian account number" autocomplete="off">
            </div>
            <div class="col-3">
              <input type="text" id="tuac" name="account_number[]" class="form-control" placeholder="TransUnion account number" autocomplete="off">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Status:</label>
            </div>
            <div class="col-3">
              <input type="text" id="equacss" name="status[]" class="form-control" autocomplete="off">
              <!-- <select name="status[]" class="form-control" id="equs">
                          <?php foreach ($dispute_status_opt as $key => $value) : ?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                          <?php endforeach ?>
                        </select> -->
            </div>
            <div class="col-3">
              <input type="text" id="exacss" name="status[]" class="form-control" autocomplete="off">
              <!--  <select name="status[]" class="form-control" id="exs">
                          <?php foreach ($dispute_status_opt as $key => $value) : ?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                          <?php endforeach ?>
                        </select> -->
            </div>
            <div class="col-3">
              <input type="text" id="tuacss" name="status[]" class="form-control" autocomplete="off">
              <!-- <select name="status[]" class="form-control" id="tus">
                          <?php foreach ($dispute_status_opt as $key => $value) : ?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                          <?php endforeach ?>
                        </select> -->
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Reason:</label>
            </div>
            <div class="col-9">
              <input type="text" name="reason" class="form-control" autocomplete="off">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Instruction:</label>
            </div>
            <div class="col-9">
              <input type="text" name="instruction" class="form-control" autocomplete="off">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" name="dis_status" class="btn btn-primary btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!------------------------------>
<script type="text/javascript">
  function backtoprevious() {
    window.history.back();
  }

  function closeSuccessModal() {
    $('#pDsuccess').css('display', 'none');
    $('#pDMsuccess').css('display', 'none');

    location.reload();
  }

  function adddisputeItem() {

    $('#disitemModal input[name="diID"]').val('');
    $('#disitemModal input[name="account_number[]"]').val('');
    $('#disitemModal input[name="status[]"]').val('');
    $('#disitemModal input[name="reason"]').val('');
    $('#disitemModal input[name="instruction"]').val('');
    //$('#disitemModal select option').attr('selected',false);
    $('#disitemModal input').attr('checked', false);

    $('#disitemModal').modal('show');
  }

  function editmydisputeitem(rowID) {

    if (rowID != '') {

      $('#disitemModal select option').attr('selected', false);
      $('#disitemModal input').attr('checked', false);

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/editDisItem"; ?>',
        data: {
          'id': rowID
        },
        success: function(response) {

          var data = JSON.parse(response);

          $('#disitemModal input[name="diID"]').val(data.id);
          $('#disitemModal input[name="clientid"]').val(data.client_id);

          $('#disitemModal input#credit' + data.equifax).attr('checked', true);
          $('#disitemModal input#credit' + data.experian).attr('checked', true);
          $('#disitemModal input#credit' + data.transUnion).attr('checked', true);

          $('#disitemModal select#cfurnisher option[value="' + data.furnisher + '"] ').attr('selected', true);

          $('#disitemModal input#equac').val(data.equi_ac);
          $('#disitemModal input#exac').val(data.exper_ac);
          $('#disitemModal input#tuac').val(data.tu_ac);

          $('#disitemModal input#equacss').val(data.equi_status);
          $('#disitemModal input#exacss').val(data.exper_status);
          $('#disitemModal input#tuacss').val(data.tu_status);

          // $('#disitemModal select#equs option[value="'+data.equi_status+'"] ').attr('selected',true);
          // $('#disitemModal select#exs option[value="'+data.exper_status+'"] ').attr('selected',true);
          // $('#disitemModal select#tus option[value="'+data.tu_status+'"] ').attr('selected',true);

          $('#disitemModal input[name="reason"]').val(data.reason);
          $('#disitemModal input[name="instruction"]').val(data.instruction);

          $('#disitemModal').modal('show');
        }
      });
    }

  }

  function removemydisputeitem(rowID) {

    if (rowID != '') {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/deletedisItem"; ?>',
        data: {
          'id': rowID
        },
        success: function(response) {

          if (response == '1') {

            var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Dispute Item</div><div class="swal-text" style="">Dispute item deleted successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

            $('#msgAppend').after(succesMsg);

          }
        }
      });
    }
  }
</script>