<style type="text/css">
  
  #importfurnisher .modal-dialog .modal-content .modal-body {
      padding:  0px 26px 0px 26px;
  }
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
      <div class="page-header">
        <h3 class="page-title"> Creditors/Furnishers </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Creditors/Furnishers</li>
          </ol>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">
          <form method="POST" action="<?php echo base_url();?>submitData"> 
            <div class="row mb-3">
              <div class="col-6">
	   
	            </div>
	   
		          <div class="col-6" style="text-align: right; margin-bottom: 24px;" >
                <!-- <button type="button" data-toggle="modal" data-target="#importfurnisher" class="btn btn-gradient-success btn-sm btn-icon-text">Import CSV </button> -->
                <a href="<?php echo base_url();?>Furnishers/export_csv">
                  <button type="button" class="btn btn-gradient-success btn-sm btn-icon-text">Export CSV </button>
                </a>
					       <a href="<?php echo base_url();?>furnisher">
                    <button type="button" class="btn btn-gradient-primary btn-sm btn-icon-text"> <i class="mdi mdi-plus btn-icon-prepend"></i> Add Creditors/Furnishers </button>
                 </a>
                 
		          </div>
	          </div>

            <div class="row d-none" id="appendrow">
                <div class="col-8">

                  <div class="row mb-3">
                    <div class="col-3">
                        <label>Company name:</label>
                    </div>
                    <div class="col-9">
                        <input type="hidden" name="id" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->id : '';?>">
                        <input type="text" name="company_name" class="form-control" required="required" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->company_name : '';?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-3">
                        <label>E-mail:</label>
                    </div>
                    <div class="col-6">
                        <input type="email" name="email" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->email : '';?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-3">
                        <label>Fax:</label>
                    </div>
                    <div class="col-6">
                        <input type="text" name="fax" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->fax : '';?>" autocomplete="off">
                    </div>
                  </div>
                  <hr>
                  <div class="addmo">
                    <?php if(isset($companyinfo_address) && is_array($companyinfo_address)){ 
                            foreach($companyinfo_address as $row){ ?>

                            <div id="moreadd<?php echo $row->id;?>" class="countss">
                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>Address:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="address[]" class="form-control" required="required" value="<?php echo $row->address;?>">
                                    <input type="hidden" name="add_id[]" class="form-control" required="required" value="<?php echo $row->id;?>" >
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>City:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="city[]" class="form-control" value="<?php echo $row->city;?>">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>State:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="state[]" class="form-control" value="<?php echo $row->state;?>">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>Zip:</label>
                                </div>
                                <div class="col-6">
                                    <input type="number" name="zip[]" class="form-control" value="<?php echo $row->zip;?>">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>Phone Number:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="pNumber[]" class="form-control" value="<?php echo $row->phone;?>" maxlength="10">
                                </div>
                                <div class="col-3">
                                    
                                </div>
                              </div>
                            </div>

                    <?php } }else{ ?>

                            <div id="moreadd1" class="countss">
                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>Address:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="address[]" class="form-control" required="required" value="">
                                    <input type="hidden" name="add_id[]" class="form-control" required="required" value="">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>City:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="city[]" class="form-control" value="">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>State:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="state[]" class="form-control" value="">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>Zip:</label>
                                </div>
                                <div class="col-6">
                                    <input type="number" name="zip[]" class="form-control" value="">
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-3">
                                    <label>Phone Number:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="pNumber[]" class="form-control" value="" maxlength="10">
                                </div>
                                <div class="col-3">
                                    <a href="javascript:;" class="text-primary btn-sm" onclick="addMoreaddress();">Add address</a>
                                </div>
                              </div>
                            </div>

                    <?php } ?>
                  </div>

                  <div class="row mt-2 mb-3">
                    <div class="col-3">
                        <label>Account Type:</label>
                    </div>
                    <div class="col-6">
                        <input type="text" name="accounttype" class="form-control" value="<?php echo isset($companyinfo_data) ? $companyinfo_data[0]->account_type : '';?>" >
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-3">
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

                <div class="col-4">
                  <div class="row mb-3">
                      <div class="col-2">
                        <label><b>Search:</b></label>
                      </div>
                      <div class="col-10">
                        <select class="form-control" onchange="fetchComanyinfo(this.value);" style="color:black;border:1px solid #d0d0d0;">
                          <option value="">Select One</option>
                          <?php if(isset($furnisher_data) && is_array($furnisher_data)){
                                  foreach($furnisher_data as $val){ ?>
                                    <option value="<?php echo $val->id;?>"><?php echo $val->company_name;?></option>
                          <?php } } ?>
                        </select>
                      </div>
                  </div>
                </div>

              </sdiv>

          </form>
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
<!------------------------------------------>
<script type="text/javascript">
  
  function addMoreaddress(){

      var count = $('#appendrow .addmo .countss').length;
      count++;

      $('#appendrow .addmo').append('<div id="moreadd'+count+'" class="countss"><div class="row mb-3"><div class="col-3"><label>Address:</label></div><div class="col-9"><input type="text" name="address[]" class="form-control" required="required" value=""></div></div><div class="row mb-3"><div class="col-3"><label>City:</label></div><div class="col-6"><input type="text" name="city[]" class="form-control" value=""> </div></div><div class="row mb-3"><div class="col-3"> <label>State:</label></div><div class="col-6"><input type="text" name="state[]" class="form-control" value=""></div></div><div class="row mb-3"><div class="col-3"><label>Zip:</label></div><div class="col-6"><input type="number" name="zip[]" class="form-control" value=""></div></div><div class="row mb-3"><div class="col-3"><label>Phone Number:</label></div><div class="col-6"><input type="text" name="pNumber[]" class="form-control" value="" maxlength="10"></div><div class="col-3"><a href="javascript:;" class="text-primary" title="Remove" onclick="removerow('+count+');"><i class="mdi mdi-delete"></i></a> </div></div></div>');
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
</script>