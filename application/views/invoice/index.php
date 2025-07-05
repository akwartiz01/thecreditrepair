<style type="text/css">
  #paymentrevModal .modal-dialog .modal-content .modal-body {
      padding: 0px 26px 0px 26px;
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
<div id="msgAppend"></div>
<div id="msgAppend123"></div>
<?php 
	if($this->uri->segment(1) == 'edit'){ 
		$title = 'Edit Invoice';
	}else{
		$title = 'New Invoice';
	}
?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"><?php echo $title;?></h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
                </ol>
              </nav>
            </div>
            <div class="card">
              <div class="card-body">
                <form method="POST" action="<?php echo base_url();?>add"> 
			            <div class="row">
                    <div class="col-md-6">
				   
				            </div>
				   
  				          <div class="col-md-6" style="text-align: right; margin-bottom: 24px;" >
  				   
  							       <a onclick="backtoprevious();">
                          <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-arrow-left-thick btn-icon-prepend"></i> Back </button>
                       </a>
  				          </div>
				          </div>
                
                  <div class="row">
                    <div class="col-md-5">
                      <label>Invoice # Auto generated &nbsp;&nbsp;&nbsp;&nbsp; Reference # (optional):</label>
                    </div>
                    
                    <div class="col-md-2">
                      <input type="text" class="form-control" name="reference" value="<?php echo isset($invoices_historys[0]->ref_id) ? $invoices_historys[0]->ref_id : '';?>" autocomplete="off">
                    </div>

                    <?php if($this->uri->segment(1) == 'edit'){ ?>
                      <div class="col-md-3">
                          <label>Status: <?php echo isset($invoices_historys[0]->status) ? $invoices_historys[0]->status : '';?></label>
                      </div>
                    <?php } ?>
                      <input type="hidden" name="invoid" value="<?php echo isset($invoices_historys[0]->id) ? $invoices_historys[0]->id : '';?>">
                  </div>

                  <div class="row mt-4">
                    <div class="col-md-2">
                      <label>Client Name:</label>
                    </div>
                    <div class="col-md-3">
                      <select name="client_name" class="form-control" required <?php if(!empty($sq_client_id) && isset($sq_client_id)){ echo "readonly"; } ?>>
                        <option value="">Select One</option>
                        <?php if(is_array($fetchallClient)){ foreach($fetchallClient as $Row){ ?>
                            <option value="<?php echo $Row->sq_client_id; ?>" <?php if(isset($invoices_historys[0]->client_id)){
                            if($invoices_historys[0]->client_id == $Row->sq_client_id){echo 'selected';} }?> <?php if(isset($sq_client_id)){
                            if($sq_client_id == $Row->sq_client_id){echo 'selected';} }?>  ><?php echo $Row->sq_first_name .' '.$Row->sq_last_name; ?></option>
                        <?php } } ?>
                      </select>
                    </div>

                    <div class="col-md-2">
                      <label>Terms:</label>
                    </div>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="terms" value="<?php echo isset($invoices_historys[0]->term) ? $invoices_historys[0]->term : '';?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-md-2">
                      <label>Invoice date:</label>
                    </div>
                    <div class="col-md-3">
                      
                        <input type="text" class="form-control datepicker" name="invoice_date" value="<?php echo isset($invoices_historys[0]->invoice_date) ? date('m-d-Y', strtotime($invoices_historys[0]->invoice_date)) : '';?>" autocomplete="off">
                        
                    </div>

                    <div class="col-md-2">
                      <label>Due date:</label>
                    </div>
                    <div class="col-md-3">
                      
                        <input type="text" class="form-control datepicker" name="due_date" value="<?php echo isset($invoices_historys[0]->due_date) ? date('m-d-Y', strtotime($invoices_historys[0]->due_date)) : '';?>" autocomplete="off">
                        
                    </div>
                  </div>

                  <div class="row mt-4" id="items">
                    <div class="col-md-12 table-responsive">
                        <table class="table jsgrid">
                          <thead>
                            <tr>
                              <th>Description</th>
                              <th>Save for<br>future use</th>
                              <th>Price</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php 
                          $countrows = 0;
                          $sumprice = 0;
                          if(isset($fetch_preitem) && is_array($fetch_preitem)){ 
                                  foreach($fetch_preitem as $row){ 

                                    $countrows++; 
                                    $sumprice += $row->price;
                              ?>

                                <tr class="item" id="row<?php echo $countrows;?>">
                                  <td>
                                    <input type="text" class="form-control" required name="description[]" value="<?php echo $row->description;?>">
                                    <input type="hidden" name="initemid[]" value="<?php echo $row->id;?>">
                                  </td>
                                  <td>
                                    <input type="checkbox" onclick="boxcheckes(this,'<?php echo $countrows;?>');" <?php if($row->for_future == 1){echo 'checked';}?>>
                                    <input type="hidden" name="for_fueture[]" id="chk<?php echo $countrows;?>" value="<?php echo $row->for_future;?>">
                                  </td>
                                  <td>
                                    <input type="text" required class="form-control number_only amount" name="price[]" onkeyup="loadgrandtotal()" value="<?php echo $row->price;?>">
                                  </td>
                                  <td>
                                    <input class="jsgrid-button jsgrid-delete-button" type="button" title="Delete" onclick="deleteClientPopUp(this,'<?php echo $row->id;?>');">
                                  </td>
                                </tr>


                            <?php } }else{ ?>

                              <tr class="item" id="row1">
                                <td>
                                  <input type="text" class="form-control" required name="description[]" autocomplete="off">
                                  <input type="hidden" name="initemid[]" value="0">
                                </td>
                                <td>
                                  <input type="checkbox" onclick="boxcheckes(this,1);">
                                  <input type="hidden" name="for_fueture[]" id="chk1" value="0">
                                </td>
                                <td>
                                  <input type="text" required class="form-control number_only amount" name="price[]" onkeyup="loadgrandtotal()">
                                </td>
                                <td>
                                  <input class="jsgrid-button jsgrid-delete-button" type="button" title="Delete">
                                </td>
                              </tr>

                            <?php } ?>

                          </tbody>
                          <tfoot>
                            <tr id="price">
                              <th></th>
                              <th>Total:</th>
                              <th><span id="price_total">$<?php echo number_format($sumprice,2);?></span></th>
                              <th></th>
                            </tr>
                            <tr>
                              <td colspan="4">
                                <button type="button" class="btn btn-sm btn-gradient-primary btn-icon-text" onclick="addmoreitem(this);"> <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Item </button>
                              </td>
                            </tr>
                          </tfoot>
                        </table>

                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" name="new_invoice" class="btn btn-gradient-primary float-right btn-icon-text mr-2 mb-2">Save Invoice</button>
                        <?php if($this->uri->segment(1) == 'edit'){ ?>
                          <button type="button" onclick="window.print()" class="btn btn-gradient-primary float-right btn-icon-text mr-2 mb-2">Print Invoice</button>
                          <button type="button" onclick="recpaymant()" class="btn btn-gradient-primary float-right btn-icon-text mr-2 mb-2">Receive Payment</button>
                        <?php } ?>
                          
                    </div>
                  </div>

                </form>
              </div>
          </div>

        </div>
      </div>
      <!-------------------------------->
      <div class="modal fade show" id="paymentrevModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" style="display: none;" aria-modal="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel"><b>Payment Receive</b></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              
              <input type="hidden" id="invoice_no" value="<?php echo $invoices_historys[0]->invoice_no;?>">
              <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Date:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" id="pay_date" class="form-control datepicker" autocomplete="off" value="<?php echo date('m/d/Y');?>">
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Amount paid:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" id="pay_amt" class="form-control" autocomplete="off" value="<?php echo $sumprice - $totalPay;?>">
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Description:</label>
                  </div>
                  <div class="col-md-8">
                    <textarea id="pay_description" class="form-control" rows="4"></textarea>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" onclick="AddinvoicePay();" class="btn btn-success btn-sm">Add</button>
              <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-------------------------------->
      <!-- content-wrapper ends -->
      <script type="text/javascript">  

        function AddinvoicePay(){

          var invoice_no = $('#paymentrevModal input#invoice_no').val();
          var pay_date = $('#paymentrevModal input#pay_date').val();
          var pay_amt = $('#paymentrevModal input#pay_amt').val();
          var pay_description = $('#paymentrevModal textarea#pay_description').val();
          var pay_total = '<?php echo $sumprice - $totalPay;?>';

          $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url()."Invoices/invoicePayment";?>',
                  data: {'invoice_no':invoice_no, 'pay_total':pay_total, 'pay_date':pay_date, 'pay_amt':pay_amt, 'pay_description':pay_description },
                  success: function(response){

                      if(response == '1'){

                          var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Invoice Payment!</div><div class="swal-text" style="">Invoice payment add successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNew1111();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                          $('#msgAppend123').after(succesMsg);

                      }else{

                        var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--warning"><span class="swal-icon--warning__body"><span class="swal-icon--warning__dot"></span></span></div><div class="swal-title" style="">Invoice Payment Error!</div><div class="swal-text" style="">Something is wrong!</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNew1111();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                          $('#msgAppend123').after(succesMsg);

                      }

                  }
              })
        }

        function closeSuccessModalNew1111()
        {
          //alert('kk');
          $('#pDsuccess11').css('display','none');
          $('#pDMsuccess11').css('display','none');

          window.history.back();
          //window.location.href = "<?php echo base_url();?>invoices";
          
        }

        function recpaymant(){
          $('html, body').animate({scrollTop:0}, 'slow');
          //$(window).scrollTop(0);
          $('#paymentrevModal').modal('show');
        }      
        
        function backtoprevious(){
          window.history.back();
        }

        function addmoreitem(that){

          var count = $('#items table tr.item').length;
          //alert(count);
          count++;

          $('#items table tbody').append('<tr class="item" id="row'+count+'"><td><input type="text" required class="form-control" name="description[]" autocomplete="off"><input type="hidden" name="initemid[]" value="0"></td><td><input type="checkbox" onclick="boxcheckes(this,'+count+');" ><input type="hidden" name="for_fueture[]" id="chk'+count+'" value="0"></td><td><input type="text" required class="form-control number_only amount" name="price[]" onkeyup="loadgrandtotal()"></td><td><input class="jsgrid-button jsgrid-delete-button" type="button" title="Delete" onclick="rowremove(this,'+count+')"></td></tr>');
        }

        function rowremove(that,id){

          $('tr#row'+id).remove();
          loadgrandtotal();
        }

        function boxcheckes(that,key){
          
          if($(that).is(':checked')){
            $('#chk'+key).val('1');
          }else{
            $('#chk'+key).val('0');
          }

        }

        function loadgrandtotal() {
            var allsum = 0;
            $('.item td input[name="price[]"]').each(function(){
              var allvalue = $(this).val();
              var replaceval = allvalue.replace(/\$/g,"");
              if(replaceval > 0){
                allsum += parseFloat(replaceval);
              }
            });

            var total = allsum.toFixed(2);
            $('tr#price th span#price_total').text('');
            $('tr#price th span#price_total').text('$'+total);
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

        function closeSuccessModal(id)
        {
        	
          $('#pDsuccess').css('display','none');
          $('#pDMsuccess').css('display','none');
          //$('#items tr#row'+id).remove();
          location.reload();

        }

        function deleteClient()
        {

          var id = $('#hiddenClientId').val();
          // Add Loader
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()."Invoices/deleteItem";?>',
                data: {'id':id},
                success: function(response){

                 if(response == '1')
                 {   
                   // Show Success message 
                      $('#deletePopup').css('display','none');
                      $('#deletePopupModal').css('display','none');

                      var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Item Deleted!</div><div class="swal-text" style="">You have deleted one item successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal('+id+');">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                      $('#msgAppend').after(succesMsg);

                 }

                }
              });
        }

      </script>

      