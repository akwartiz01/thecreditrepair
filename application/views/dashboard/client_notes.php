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
</style>
<?php if ($this->session->flashdata('success')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style="">Notes Data!</div>
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
<?php if ($this->session->flashdata('error')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--warning"><span class="swal-icon--warning__body"><span class="swal-icon--warning__dot"></span></span></div>
      <div class="swal-title" style="">Notes Error!</div>
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
        <h3 class="page-title"> Internal Notes </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notes</li>
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

              <a onclick="createNote();">
                <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-plus btn-icon-prepend"></i> Create Notes </button>
              </a>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-12 ">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th width="40%">Note</th>
                    <th>Added By</th>
                    <th>Attachment</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($fetchnotes) && is_array($fetchnotes)) {
                    foreach ($fetchnotes as $row) { ?>
                      <tr>
                        <td style="vertical-align: top;"><?php echo date('Y/d/m', strtotime($row->date)); ?></td>
                        <!-- <td><?php echo mb_strimwidth($row->notes, 0, 40, "..."); ?></td> -->
                        <td style="vertical-align: top;"><?php echo $row->notes; ?></td>
                        <td style="vertical-align: top;"><?php echo $get_allusers_name[$row->added_by]; ?></td>
                        <td style="vertical-align: top;">
                          <?php if ($row->attachment != '') { ?>
                            <a href="<?php echo $row->attachment; ?>" download class="text-success"><i class="mdi mdi-attachment"></i></a>
                          <?php } ?>
                        </td>
                        <td>
                          <a title="Edit" class="text-success mr-1" onclick="editmynotes('<?php echo $row->id; ?>');"><i class="mdi mdi-pencil"></i></a>
                          <a title="Remove" class="text-success" onclick="removemynotes('<?php echo $row->id; ?>');"><i class="mdi mdi-delete"></i></a>
                        </td>
                      </tr>

                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="5" style="text-align: center;">No Notes found for this client!</td>
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
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="<?php echo base_url(); ?>notesData" enctype="Multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><b>Client Notes</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="noteID" value="">
          <input type="hidden" name="clientid" value="<?php echo $clientid; ?>">
          <div class="row mt-2 mb-3">
            <div class="col-12">
              <!-- <label>Notes:</label> -->
              <!-- <textarea class="form-control" name="notes" rows="5" placeholder="Enter your note here..."></textarea> -->
              <textarea name="notes" id="summernoteNotes" class="textarea"></textarea>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-12">
              <label>Attachment:</label>
              <input type="file" name="fileupload">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" name="sub_note" class="btn btn-primary btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!------------------------------>
<script type="text/javascript">
  function closeSuccessModal() {
    $('#pDsuccess').css('display', 'none');
    $('#pDMsuccess').css('display', 'none');

    location.reload();
  }

  function removemynotes(rowID) {

    if (rowID != '') {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/deleteNote"; ?>',
        data: {
          'id': rowID
        },
        success: function(response) {

          if (response == '1') {

            var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Notes Deleted!</div><div class="swal-text" style="">Notes deleted successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

            $('#msgAppend').after(succesMsg);

          }
        }
      });
    }
  }

  function createNote() {

    $('#notesModal input[name="noteID"]').val('');
    $('#notesModal textarea[name="notes"]').val('');
    $('#summernoteNotes').summernote('code', '');
    $('#notesModal').modal('show');
  }

  function editmynotes(rowID) {

    $('#summernoteNotes').summernote('code', '');

    if (rowID != '') {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/editNote"; ?>',
        data: {
          'id': rowID
        },
        success: function(response) {

          var data = JSON.parse(response);

          $('#notesModal input[name="noteID"]').val(data.id);
          $('#notesModal input[name="clientid"]').val(data.client_id);
          //$('#notesModal textarea#summernoteNotes').text(data.notes);
          $('#summernoteNotes').summernote('code', data.notes);

          $('#notesModal').modal('show');
        }
      });
    }
  }

  function backtoprevious() {
    window.history.back();
  }
</script>