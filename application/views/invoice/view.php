<style type="text/css">
  .form-control{
    border: 1px solid darkgray;
  }
</style>
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
    <?php if($this->session->flashdata('success')){ ?>
        <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Invoices Data!</div><div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>
    <?php }?>
      

      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Invoices (all clients) </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                </ol>
              </nav>
            </div>
            <div class="card">
              <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6" style="text-align: right; margin-bottom: 24px;" >
                 
                           <a href="<?php echo base_url();?>add">
                              <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-plus btn-icon-prepend"></i> Create Invoice </button>
                           </a>
                        </div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                          <div class="card-body">
                            <!-- <img src="https://www.bootstrapdash.com/demo/purple/jquery/template/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"> -->
                            <img src="https://demo.bootstrapdash.com/purple/jquery/template/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal mb-2">Total Outstanding <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-1">$<?php echo number_format($total_invoiced - $total_received,2);?></h2>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-info card-img-holder text-white">
                          <div class="card-body">
                            <img src="https://demo.bootstrapdash.com/purple/jquery/template/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal mb-2">Past Due <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-1">$0</h2>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-success card-img-holder text-white">
                          <div class="card-body">
                            <img src="https://demo.bootstrapdash.com/purple/jquery/template/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal mb-2">Paid in last 30 days <i class="mdi mdi-diamond mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-1">$<?php echo number_format($amount_pay_in_last30day,2);?></h2>
                            
                          </div>
                        </div>
                      </div>
                    </div>

                    <form class="mt-4" method="post" action="<?php echo base_url();?>invoices" id="filterinvoice">
    			        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group d-flex">
                                  <label style="width: 22%;font-weight: bold;">Client Name:</label>
                                  <select name="client_name" class="form-control" onchange="applyfilter(this)" style="color: black;border: 1px solid darkgray;">
                                    <option value="">Select One</option>
                                    <?php if(is_array($fetchallClient)){ foreach($fetchallClient as $Row){ ?>
                                        <option value="<?php echo $Row->sq_client_id; ?>" <?php if($client_names == $Row->sq_client_id){echo 'selected';}?>><?php echo $Row->sq_first_name .' '.$Row->sq_last_name.' ('.$Row->sq_email.')'; ?></option>
                                    <?php } } ?>
                                  </select>
                                </div>
          				    </div>
                        
    				   
              				<!--<div class="col-md-3">
                                <div class="form-group d-flex">
                                  <label style="font-weight: bold;">Status:</label>
                                  <select name="status" class="form-control ml-1" >
                                    <option value="">Select One</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Declined">Declined</option>
                                  </select>
                                </div>
          				    </div>
          				    <div class="col-md-3">
                                <div class="form-group d-flex">
                                  <label style="font-weight: bold;">Date:</label>
                                  <input type="text" name="date" class="form-control datepicker ml-1" autocomplete="off"> 
                                </div>
          				    </div>
          				    <div class="col-md-2">
                                <div class="form-group d-flex">
                                  <label style="font-weight: bold;"></label>
                                  <input type="hidden" name="dreport" value="filter">
                                  <button title="Download Report" type="submit" class="btn btn-success btn-xs" onclick="applyfilter(this)"><i class="mdi mdi-download"></i></button>
                                </div>
          				    </div>-->
                        
    				    </div>
                  </form>

                  <div class="row mt-4">
                    <div class="col-12 table-responsive">
                      <table class="table jsgrid datatable">
                        <thead>
                          <tr>
                            <th>Client</th>
                            <th>Pending Invoices</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($fetchinvoice) && is_array($fetchinvoice)){ 
                                  foreach($fetchinvoice as $row){ ?>
                                    <tr>
                                      <td width="40%"><a class="text-success" href="<?php echo base_url();?>client_invoices_history/<?php echo base64_encode(urlencode(($row->id*12345678)/12345));?>"><?php echo $fetchClientName[$row->client_id];?></a></td>
                                      <td width="20%"><a href="<?php echo base_url();?>client_invoices_history/<?php echo base64_encode(urlencode(($row->id*12345678)/12345));?>"><?php echo $row->status;?></a></td>
                                      <td width="40%">
                                          <a href="javascript:;" title="Delete Invoice" class="text-success mr-2" onclick="deleteClientPopUp(this,'<?php echo $row->id;?>');">Delete Invoice</a>
                                          <a onclick="opentaskpopup('client');" title="Set Reminder" class="text-success ml-2">Set Reminder</a>
                                      </td>
                                    </tr>

                                  <?php } }else{ ?>
                                    <tr>
                                      <td colspan="3">No invoice found!</td>
                                    </tr>
                                  <?php } ?>
                        </tbody>
                        
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <script type="text/javascript">
            
            function applyfilter(){

              $('form#filterinvoice').submit();
            }

            function closeSuccessModal()
            {
              $('#pDsuccess').css('display','none');
              $('#pDMsuccess').css('display','none');

            }

            function deleteClientPopUp(that,id)
            {

              $('#hiddenClientId').val(id);
              $('#deletePopup').css('display','');
              $('#deletePopupModal').css('display','');
              $('#loader').css('display','');

            }

            function deleteCancel()
            {
              $('#deletePopup').css('display','none');
              $('#deletePopupModal').css('display','none');
            }            

            function closeSuccessModalNew()
            {
              
              $('#pDsuccess11').css('display','none');
              $('#pDMsuccess11').css('display','none');
              //$('#items tr#row'+id).remove();
              location.reload();

            }

            function deleteClient()
            {

              var id = $('#hiddenClientId').val();
              // Add Loader
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()."Invoices/deleteInvoices";?>',
                    data: {'id':id},
                    success: function(response){

                     if(response == '1')
                     {   
                       // Show Success message 
                          $('#deletePopup').css('display','none');
                          $('#deletePopupModal').css('display','none');

                          var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Invoice Deleted!</div><div class="swal-text" style="">You have deleted one invoice successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNew();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                          $('#msgAppend').after(succesMsg);

                     }

                    }
                  });
            }

            function opentaskpopup(type){

                if(type == 'client'){
                    $('#TaskModal div#teamrow').css('display','none');
                    $('#TaskModal div#clientrow').css('display','flex');
                }else if(type == 'team'){
                    $('#TaskModal div#clientrow').css('display','none');
                    $('#TaskModal div#teamrow').css('display','flex');
                }else{
                  $('#TaskModal div#teamrow').css('display','flex');
                  $('#TaskModal div#clientrow').css('display','flex');
                }

                $('#TaskModal').modal('show');
            }

          </script>

          