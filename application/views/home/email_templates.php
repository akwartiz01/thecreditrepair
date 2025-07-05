<?php
  $template_for = $this->config->item('template_for');

?>

<style type="text/css">
  .modal .modal-dialog .modal-content .modal-body {
      padding: 0px 26px 0px 26px;
  }
</style>

<?php if($this->session->flashdata('success')){ ?>
      <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style=""> Auto E-mail Templates!</div><div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>
<?php } ?>
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h1> Auto E-mail Templates </h1>
        <!--<nav aria-label="breadcrumb">-->
        <!--  <ol class="breadcrumb">-->
        <!--    <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>-->
        <!--    <li class="breadcrumb-item active" aria-current="page">Auto E-mail Templates</li>-->
        <!--  </ol>-->
        <!--</nav>-->
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
	          <div class="col-md-12 mb-4" >
	   
				       <button type="button" onclick="AddMoretemp();" class="btn btn-success btn-sm float-right"><i class="mdi mdi-email"></i> Add Templates</button>
	          </div>
	        </div>
  
          
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Template Name</th>
                    <th>Template For</th>
                    <th>E-mail Template Text</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $count = 0;  
                  if(isset($GetAllEmailTemp) && is_array($GetAllEmailTemp)){ 
                            foreach($GetAllEmailTemp as $row){ $count++; ?> 
                              <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $row->temp_name;?></td>
                                <td><?php echo $template_for[$row->temp_for];?></td>
                                <td><?php echo mb_strimwidth($row->temp_text, 0, 60,'...');?></td>
                                <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center">
                                  <a title="Edit" class="text-success" onclick="EditTemplate(<?php echo $row->id;?>)"><i class="mdi mdi-pencil"></i></a>
                                     <a title="Delete" class="text-danger" onclick="DeleteTemplate(<?php echo $row->id;?>)"><i class="mdi mdi-delete"></i></a>

                                </td>
                              </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<!---------- email temp ------------->
<div class="modal fade" id="emailTemp" tabindex="-1" role="dialog" aria-labelledby="emailTempLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 800px;">
    <div class="modal-content">
        <form method="post" action="<?php echo base_url();?>email_templates">
          <div class="modal-header">
            <h5 class="modal-title" id="emailTempLabel"><b>E-mail Templates</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="temid" id="tempid" value="">

            <div class="row mb-4">
                <div class="col-md-6">
                    <label>E-mail Template Name:</label>
                    <input type="text" name="temp_name" id="temp_namess" class="form-control" required="required" autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label>E-mail Template For:</label>
                    <select class="form-control" name="temp_for" required="required">
                      <?php foreach($template_for as $key => $value) { ?>
                          <option value="<?php echo $key;?>"><?php echo $value;?></option>
                      <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label>E-mail Template Text:</label>
                    <textarea class="form-control" name="temp_msg" id="temp_msgss" rows="10"></textarea>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" name="save" class="btn btn-success btn-sm">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!---------- email temp ------------->
<!--delte template start popup-->
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
<div id="msgAppend">
</div>





<script type="text/javascript">
  
  function AddMoretemp(){

    $('#emailTemp input#tempid').val('new');
    $('#emailTemp input#temp_namess').val('');
    $('#emailTemp select option[value=""]').attr('selected',true);
    $('#emailTemp textarea#temp_msgss').val('');
    $('#emailTemp').modal('toggle');
  }

  function EditTemplate(tempid){

    $.ajax({

          type : 'post',
          url  : '<?php echo base_url()."Home/getEmailtemplate";?>',
          data : {'id': tempid},
          success : function(response){

              var data = JSON.parse(response);

              $('#emailTemp input#tempid').val(data.id);
              $('#emailTemp input#temp_namess').val(data.temp_name);
              $('#emailTemp select option[value="'+data.temp_for+'"]').attr('selected',true);
              $('#emailTemp textarea#temp_msgss').val(data.temp_text);

              $('#emailTemp').modal('toggle');
          }
    })
  }

  function closeSuccessModal()
  {
    $('#pDsuccess').css('display','none');
    $('#pDMsuccess').css('display','none');
    location.reload();
  }
  
  
  // delete template 16 aprl ashok
  function DeleteTemplate(tempid){
   $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Home/deleteTemplate"; ?>',
          data: {
            'id': tempid
          },
          success: function(response) {
              console.log(response);
            var data = JSON.parse(response);

            if ($.trim(data) == 'deleted') {
              console.log("f",data);
              // Show Success message 
              $('#deletePopup').css('display', 'none');
              $('#deletePopupModal').css('display', 'none');

              var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Template Deleted!</div><div class="swal-text" style="">You have deleted the template successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend').after(succesMsg);

            }

          }
        });
}
</script>

