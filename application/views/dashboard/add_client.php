<?php
$client_status = $this->config->item('client_status');
$client_days_opt = $this->config->item('client_days_opt');


?> 
  <style type="text/css">
    /**** New Styling ****/
    select.form-control{
      color: black!important;
    }
    /**** End New Styling ****/
  </style>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel pnel" >
          <div class="content-wrapper">
            <div class="page-header">
              <h1> Add New Client </h1>
              <!--<nav aria-label="breadcrumb">-->
              <!--  <ol class="breadcrumb">-->
              <!--    <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>-->
              <!--    <li class="breadcrumb-item active" aria-current="page">Add New Client</li>-->
              <!--  </ol>-->
              <!--</nav>-->
            </div>
                <div class="card">
              <div class="card-body">
                  <?php if($this->session->flashdata('success')){ ?>
                      <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Client added!</div><div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>
                  <?php }?>


                  <div class="col-md-6">
                    <?php if(!isset($clientspouse) ){ ?>

                      <h4 class="task-title2"><button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#spouseModal"><i class="mdi mdi-plus"></i> Add spouse</button></h4>

                    <?php }else{ ?>

                        <h4 class="task-title2"><?php echo isset($clientspouse) ? $clientspouse[0]->sname : '';?> </h4>
                        <hr>
                        <p><?php echo isset($clientspouse) ? $clientspouse[0]->sphone : '';?></p>
                        <p><a href="mailto:<?php echo isset($clientspouse) ? $clientspouse[0]->semail : '';?>"><?php echo isset($clientspouse) ? $clientspouse[0]->semail : '';?></a></p>
                        <p><?php echo isset($clientspouse) ? $clientspouse[0]->saddress : '';?></p>
                        
                        <p>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sent Email</button>
                              <div class="dropdown-menu" x-placement="bottom-start">
                                <a class="dropdown-item" onclick="sendWelcomeemail('<?php echo $fetchClientinfo[0]->sq_email;?>','<?php echo $fetchClientinfo[0]->sq_client_id;?>');">Welcome Email</a>
                                <!-- <a class="dropdown-item" href="#">Something else here</a>
                                <a class="dropdown-item" href="#">Demo link</a> -->
                              </div>
                            </div>
                          </div>
                        </p>

                    <?php } ?>
                  </div>                
                </div>



          <form class="form-sample" method="POST"> 
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="first_name" name="first_name" value="" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Middle name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="middle_name" name="middle_name" value="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="last_name" name="last_name" value="" required="">
                            </div>
                          </div>
                        </div>
						<div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Suffix</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="suffix" name="suffix" value="">
                            </div>
                          </div>
                        </div>
                         
                      </div>
					  <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="email" name="email" value="" required="">
                            </div>
                          </div>
                        </div>
						 
                         <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Client has no email </label>
                            <div class="col-sm-4">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="noEmail" id="noEmail" value="1" onclick="hideEmail();" >  <i class="input-helper"></i></label>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
					  <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SSN</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="ssn" name="ssn" value="">
                            </div>
                          </div>
                        </div>
						<div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">DOB</label>
                            <div class="col-sm-9">
                              
                                <input type="text" class="form-control datepicker" id="dob" name="dob" value="00/00/0000">
                                
                            </div>
                          </div>
                        </div>
                         
                      </div>
					  <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone (H)</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="phone_home" name="phone_home" value="">
                            </div>
                          </div>
                        </div>
						<div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone (W)</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="phone_work" name="phone_work" value="">
                            </div>
                          </div>
                        </div>
                         
                      </div>
					  <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone (M)</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="phone_mobile" name="phone_mobile" value="" required>
                            </div>
                          </div>
                        </div>
						<div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alt Phone</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="fax" name="fax" value="">
                            </div>
                          </div>
                        </div>
                         
                      </div>

                          <hr>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="status" name="status">
                                <?php foreach($client_status as $key => $value){ ?>
                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date of start</label>
                            <div class="col-sm-9">
                              
                                <input type="text" class="form-control datepicker" id="date_of_start" name="date_of_start" value="<?php echo date('m/d/Y');?>">
                                
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Assigned to</label>
                            <div class="col-sm-9">
                              
                              <select class="form-control" id="assigned" name="assigned">
                                <option value="">Select One</option>
                                <?php foreach($get_allusers_name as $key => $value){ ?>
                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php } ?>
                              </select>

                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Referred by</label>
                            <div class="col-sm-9">
                               
                              <select class="form-control" id="referred" name="referred">
                                <option value="">Select One</option>
                                <?php foreach($get_allaffiliate_name as $key => $value){ ?>
                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php } ?>
                              </select>

                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
           
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Portal access</label>
                            <div class="col-sm-4">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="portalAccess" id="portalAccess" value="1" checked=""> Yes <i class="input-helper"></i></label>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="portalAccess" id="portalAccess" value="0"> No <i class="input-helper"></i></label>
                              </div>
                            </div>
                          </div>
                        </div>

                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Client Days</label>
                              <div class="col-sm-9">
                                <select class="form-control" id="clientdays" name="client_days">
                                  <?php foreach($client_days_opt as $key => $value){ ?>
                                      <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mailing address</label>
                            <div class="col-sm-9">
                               <textarea   class="form-control" id="mailing_address" name="mailing_address"></textarea>
                            </div>
                          </div>
                        </div>
                       
                      </div>

					  <hr>
                      <p class="card-description"> Address </p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="city" name="city">
                                
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">State</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="state" name="state" value="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Zip code</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="zipcode" name="zipcode" value="">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="country" name="country" value="">
                            </div>
                          </div>
                        </div>
                      </div>
					  <hr>
					  <div class="col-md-12">
					  <div class="form-group row">
              <div class="col-sm-1">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="previousMailing" id="previousMailing" onclick="displayPreviousMailing();" >  <i class="input-helper"></i></label>
                </div>
              </div>
              <label class="col-sm-9 col-form-label">Previous mailing address (only if at current mailing address for less than 2 years) </label>
            </div>
                          
            </div>            

            <div id="displayPreviousMailing" style="display: none;" >
              <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Previous Mailing address</label>
                            <div class="col-sm-7">
                <textarea class="form-control" id="p_mailing_address" name="p_mailing_address"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <p class="card-description">Previous Address </p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Previous City</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="p_city" name="p_city">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Previous State</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="p_state" name="p_state" value="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Previous Zip code</label>
                            <div class="col-sm-9">
                          <input type="text" class="form-control" id="p_zipcode" name="p_zipcode" value="">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Previous Country</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="p_country" name="p_country" value="">
                            </div>
                          </div>
                        </div>
                      </div>
        
            </div>
                          
				
						<div class="row">
					 
						   
						  <div class="col-md-10">
						  &nbsp;
						  </div>
						  <div class="col-md-2">
                          <div class="form-group row">
                            <button type="submit" class="btn btn-gradient-primary btn-icon-text" id="btn_client" name="btn_client">
                             Submit </button>
                          </div>
                        </div>
                       
                          
            </div>
          </form>
        </div>
      </div>
    </div>
          <script type="text/javascript">
            function displayPreviousMailing()
            {
              if($('#previousMailing').is(':checked'))
              {
               $('#displayPreviousMailing').css('display', '');
              } 
              else
              {
                $('#displayPreviousMailing').css('display', 'none');
              }

            }

            function hideEmail()
            {

              if($('#noEmail').is(':checked'))
              {
                $("#email").prop('disabled', true);
                $('#email').removeAttr("required"); 
              } 
              else
              {
                $("#email").prop('disabled', false);
                $('#email').attr("required","required"); 
              }

               
            }
            function closeSuccessModal()
            {
              $('#pDsuccess').css('display','none');
              $('#pDMsuccess').css('display','none');

            }
             function addClientScore(){

      var clientID        = '<?php echo $fetchClientinfo[0]->sq_client_id;?>';
      var dateadd         = $('#addeditscore input[name="date"]').val();
      var equfaxScore     = $('#addeditscore input[name="equfaxScore"]').val();
      var experianScore   = $('#addeditscore input[name="experianScore"]').val();
      var TUScore         = $('#addeditscore input[name="TUScore"]').val();

      if(dateadd && equfaxScore && experianScore && TUScore !=''){

        $.ajax({

              type : 'POST',
              url  : '<?php echo base_url()."Dashboard/addScore";?>',
              data : {'clientID':clientID, 'dateadd':dateadd, 'equfaxScore':equfaxScore, 'experianScore':experianScore, 'TUScore':TUScore },
              success : function(response){

                  if(response == '1'){

                    var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Client Score</div><div class="swal-text" style="">Client score added successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                      $('#msgAppend11task').after(succesMsg);
                  }
              }
        });
      }
  }
            function saveSpouseinfo(that){

      var formval = $('#spouseform');

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url()."Dashboard/spousedatasave";?>',
            data: formval.serialize(),
            success: function(response){
              
              var data = JSON.parse(response);
                if(data.code == '1'){

                    var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Spouse Data!</div><div class="swal-text" style="">'+data.msg+'</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                    $('#msgAppend11task').after(succesMsg);
                }
            }
        });
  }

          </script>

