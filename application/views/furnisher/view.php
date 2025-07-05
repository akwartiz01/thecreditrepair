<style type="text/css">
  
  #importfurnisher .modal-dialog .modal-content .modal-body {
      padding:  0px 26px 0px 26px;
  }
  
</style>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Dancing+Script&family=Pacifico&family=Shadows+Into+Light&display=swap" rel="stylesheet">

<!-- Signature pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<style>
    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #dee2e6;
    }


    .steps-list {
        margin-top: 20px;
    }

    .step-item {
        margin-bottom: 10px;
        display: inline-flex;
        align-items: center;
        width: 100%;
    }

    .step-item input[type="checkbox"] {
        margin-right: 8px;
    }

    .step-item .btn {
        margin-left: 10px;
    }

    .mt-checkbox {
        display: inline-flex;
        align-items: center;
        width: auto;
        font-weight: 400;
    }

    .mt-checkbox span {
        margin-left: 5px;
    }

    .btn-success {
        background: #3972FC !important;
        color: #fff !important;
        border: #3972FC !important;
    }

    .btn-success:hover {
        background: #3972FC !important;
        color: #fff !important;
        border: #3972FC !important;
    }

    /*  */

    .client-header {
        color: #525e64 !important;
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
        padding: 10px;
    }


    .client-info-section {
        padding: 15px 10px;
        border-top: 1px solid #ddd;
    }

    .portlet-body {
        padding: 15px 10px;
        border-top: 1px solid #ddd;
    }

    .client-image {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        object-fit: cover;

    }

    .client-name {
        font-weight: bold;
        font-size: 20px;
        display: block;
    }

    .client-email,
    .client-referred-by,
    .client-status {
        font-size: 15px;
        color: #555;
        display: block;
    }

    .client-referred-by {
        margin-top: 10px;
    }

    .client-status {
        margin-top: 5px;
    }

    .padding-top-10.client-options {
        margin-top: 15px;
    }


    /*  */


    /* agreement css s  */

    .signature-pad {
        border: 1px dashed #333;
        background-color: #f9f9f9;
        width: 100%;
        max-width: 600px;
        height: auto;
    }

    .signature-box {
        margin-top: 20px;
    }

    #printModal .modal-body {
        max-height: 400px;
        overflow-y: auto;
    }

    /* agreement css e */

    .btn.disabled {
        pointer-events: none;
        /* Disables clicking */
        opacity: 0.65;
        /* Visually indicate it's disabled */
        cursor: not-allowed;
        /* Change cursor to indicate disabled state */
    }


    #progressModal .main-heading {
        text-align: center;
    }


    #progressModal .step-content {
        display: none;
    }

    #progressModal .progress-bar {
        background-color: #4caf50;
    }


    #progressModal .modal-md-custom {
        max-width: 650px;
    }

    #progressModal .modal-body {
        padding: 20px;
        min-height: 300px;
    }

    #progressModal .step-content {
        padding-top: 10px;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    /* chart css s */
    #range_chart {
        margin-top: 30px;
    }

    .highcharts-credits {
        display: none;
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
    /* chart css e */
</style>
<?php if($this->session->flashdata('success')){ ?>
    <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Furnisher Data!</div><div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>
<?php }?>

<?php if($this->session->flashdata('error')){ ?>
    <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--warning"><span class="swal-icon--warning__body"><span class="swal-icon--warning__dot"></span></span></div><div class="swal-title" style="">Furnisher Error!</div><div class="swal-text" style=""><?php echo $this->session->flashdata('error'); ?></div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>
<?php }?>

<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
        <!--<div class="page-header mb-4">-->
        <!--  <h1> Creditors/Furnishers </h1>-->
        <!--   <button type="button" id="add_furnishers" class="btn btn-gradient-primary btn-sm btn-icon-text"> <i class="mdi mdi-plus btn-icon-prepend"></i> Add Creditors/Furnishers </button>-->
        <!--  </div>-->
          <div class="page-header mb-4">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
    <h1 class="mb-2 mb-md-0">Creditors/Furnishers</h1>
    
    <button type="button" id="add_furnishers" class="btn btn-gradient-primary btn-sm btn-icon-text">
      <i class="mdi mdi-plus btn-icon-prepend"></i>
      Add Creditors/Furnishers
    </button>
  </div>
</div>
      <div class="card">
        <div class="card-body">
        <div class="row">
            <div class="col-12 mb-4">
                <a href="<?php echo base_url('Furnishers/export_csv'); ?>" class="csv-link float-right"> Export CSV</a>
                <a data-toggle="modal" data-target="#importfurnisher" class="csv-link float-right"> <i class="mdi mdi-file-import"></i> Import&nbsp;/ </a>
            </div>
          </div>
          <form method="POST" action="<?php echo base_url();?>submitData"> 
            <div class="row" id="appendrow">
                <div class="col-12 col-md-8">

                  <div class="row mb-3 align-items-center">
                    <div class="col-12 col-md-3">
                        <label>Company name:</label>
                    </div>
                    <div class="col-9">
                        <input type="hidden" name="id" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->id : '';?>">
                        <input type="text" name="company_name" class="form-control" required="required" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->company_name : '';?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mb-3 align-items-center">
                    <div class="col-12 col-md-3">
                        <label>E-mail:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="email" name="email" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->email : '';?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-12 col-md-3">
                        <label>Fax:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="fax" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->fax : '';?>" autocomplete="off">
                    </div>
                  </div>
                  <hr>
                  <div class="addmo">
                    <?php if(isset($companyinfo_address) && is_array($companyinfo_address)){ 
                            foreach($companyinfo_address as $row){ ?>

                            <div id="moreadd<?php echo $row->id;?>" class="countss">
                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>Address:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="address[]" class="form-control" required="required" value="<?php echo $row->address;?>">
                                    <input type="hidden" name="add_id[]" class="form-control" required="required" value="<?php echo $row->id;?>" >
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>City:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="city[]" class="form-control" value="<?php echo $row->city;?>">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>State:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="state[]" class="form-control" value="<?php echo $row->state;?>">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>Zip:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="number" name="zip[]" class="form-control" value="<?php echo $row->zip;?>">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>Phone Number:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="pNumber[]" class="form-control" value="<?php echo $row->phone;?>" maxlength="10">
                                </div>
                                <div class="col-12 col-md-3">
                                    
                                </div>
                              </div>
                            </div>

                    <?php } }else{ ?>

                            <div id="moreadd1" class="countss">
                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>Address:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="address[]" class="form-control" required="required" value="">
                                    <input type="hidden" name="add_id[]" class="form-control" required="required" value="">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>City:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="city[]" class="form-control" value="">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>State:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="state[]" class="form-control" value="">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>Zip:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="number" name="zip[]" class="form-control" value="">
                                </div>
                              </div>

                              <div class="row mb-3 align-items-center">
                                <div class="col-12 col-md-3">
                                    <label>Phone Number:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="pNumber[]" class="form-control" value="" maxlength="10">
                                </div>
                                <div class="col-12 col-md-3">
                                    <a href="javascript:;" class="text-primary btn-sm" onclick="addMoreaddress();">Add address</a>
                                </div>
                              </div>
                            </div>

                    <?php } ?>
                  </div>

                  <div class="row mt-2 mb-3">
                    <div class="col-12 col-md-3">
                        <label>Account Type:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="accounttype" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->account_type : '';?>" >
                    </div>
                  </div>

                  <div class="row mb-3 align-items-center">
                    <div class="col-12 col-md-3">
                        <label>Notes:</label>
                    </div>
                    <div class="col-9">
                        <textarea name="notes" class="form-control" rows="3"><?php echo isset($companyinfo_data) ? $companyinfo_data[0]->notes : '';?></textarea>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn btn-gradient-primary btn-sm" type="submit" name="submit">Submit</button>
                    </div>
                  </div>

                </div>


              </div>

          </form>
        </div>
        
         <div class="card pt-0">
        <div class="card-body">
           <div class="row">
                  <div class="col-12">
                      <div class="table-responsive">
                    <table class="table furnishers_datatable">
                      <thead>
                        <tr>
                          <th>Company Name</th>
                          <th>Email</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
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
<form id="filterform" method="post" action="<?php echo base_url();?>furnisher">
  <input type="hidden" name="comID" value="" id="comID">
</form>

<!------------------------------------------>
<div class="modal fade show" id="importfurnisher" tabindex="-1" role="dialog" aria-labelledby="importfurnisher" style="display: none;" aria-modal="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url();?>Furnishers/import_csv" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Import CSV</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-4">
                  <label>Choose CSV File:</label>
                </div>
                <div class="col-8">
                  <input type="file" name="csvfile"  required="required">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="import" class="btn btn-success btn-sm">Import</button>
            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
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
<div id="msgAppend">
<!------------------------------------------>
<script type="text/javascript">
  $('#appendrow').removeClass('d-block').addClass('d-none');
     $('#add_furnishers').on('click', function() {
        console.log('testing');
      if ($('#appendrow').hasClass('d-none')) {
        $('#appendrow').removeClass('d-none').addClass('d-block');
      } else {
        $('#appendrow').removeClass('d-block').addClass('d-none');
      }
    });


  function addMoreaddress(){

      var count = $('#appendrow .addmo .countss').length;
      count++;

      $('#appendrow .addmo').append('<div id="moreadd'+count+'" class="countss"><div class="row mb-3 align-items-center"><div class="col-12 col-md-3"><label>Address:</label></div><div class="col-9"><input type="text" name="address[]" class="form-control" required="required" value=""></div></div><div class="row mb-3 align-items-center"><div class="col-12 col-md-3"><label>City:</label></div><div class="col-12 col-md-9"><input type="text" name="city[]" class="form-control" value=""> </div></div><div class="row mb-3 align-items-center"><div class="col-12 col-md-3"> <label>State:</label></div><div class="col-12 col-md-9"><input type="text" name="state[]" class="form-control" value=""></div></div><div class="row mb-3 align-items-center"><div class="col-12 col-md-3"><label>Zip:</label></div><div class="col-12 col-md-9"><input type="number" name="zip[]" class="form-control" value=""></div></div><div class="row mb-3 align-items-center"><div class="col-12 col-md-3"><label>Phone Number:</label></div><div class="col-12 col-md-9"><input type="text" name="pNumber[]" class="form-control" value="" maxlength="10"></div><div class="col-12 col-md-3"><a href="javascript:;" class="text-primary" title="Remove" onclick="removerow('+count+');"><i class="mdi mdi-delete"></i></a> </div></div></div>');
  }

  function removerow(id){
    $('#moreadd'+id).remove();
  }

  function closeSuccessModal()
  {
    $('#pDsuccess').css('display','none');
    $('#pDMsuccess').css('display','none');

  }

  function fetchComanyinfo(companyID){
    if(companyID !=''){
        $('form#filterform input#comID').val(companyID);
        $('form#filterform').submit();
    }
  }
  
function closeSuccessModal() {
        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');
        location.reload();

      }
  function deleteFurnisher(id){
   $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Furnishers/delete_furnisher"; ?>',
          data: {
            'id': id
          },
          success: function(response) {

            var data = JSON.parse(response);

            if ($.trim(data) == 'deleted') {
              console.log("f",data);
              // Show Success message 
              $('#deletePopup').css('display', 'none');
              $('#deletePopupModal').css('display', 'none');

              var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Furnisher Deleted!</div><div class="swal-text" style="">You have deleted the Furnisher successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend').after(succesMsg);

            }

          }
        });
}
</script>