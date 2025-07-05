<style>
  .col-form-label span {
    color: red;
    margin-left: 3px;
  }
</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel pnel">
    <div class="content-wrapper">

      <div class="card">
        <div class="card-body">
          <?php if ($this->session->flashdata('emp-insertion-success')) { ?>
            <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
              <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
                <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
                  <div class="swal-icon--success__ring"></div>
                  <div class="swal-icon--success__hide-corners"></div>
                </div>
                <div class="swal-title" style="">Employee Updated!</div>
                <div class="swal-text" style=""><?php echo $this->session->flashdata('emp-insertion-success'); ?></div>
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

          <div class="row">
            <div class="col-6">
              <h4 style="padding-bottom: 17px;">Edit Member </h4>
            </div>
             <div class="col-6" style="text-align: right; margin-bottom: 24px;">
              <a href="<?php echo base_url() ?>my-company">
                <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-arrow-left-thick btn-icon-prepend"></i> Back </button>
              </a>
            </div>

          </div>
  
          <form class="form-sample" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="hidEmpId" id="hidEmpId" value="<?php echo $empID; ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">First Name<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="first_name" required name="first_name" value="<?php echo isset($resultMyEmp[0]->sq_u_first_name) ? $resultMyEmp[0]->sq_u_first_name : ''; ?>">
                    <?php echo form_error('first_name'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                                      <input type="hidden" class="form-control" id="user_id" required name="user_id" value="<?php echo isset($resultMyEmp[0]->sq_u_user_id) ? $resultMyEmp[0]->sq_u_user_id : ''; ?>">

           <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Email<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($resultMyEmp[0]->sq_u_email_id) ? $resultMyEmp[0]->sq_u_email_id : ''; ?>">
                    <?php echo form_error('email'); ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Last Name<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="last_name" required name="last_name" value="<?php echo isset($resultMyEmp[0]->sq_u_last_name) ? $resultMyEmp[0]->sq_u_last_name : ''; ?>">
                    <?php echo form_error('last_name'); ?>

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Password<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="password" name="password" required value="<?php echo isset($resultMyEmp[0]->sq_u_apassword) ? $resultMyEmp[0]->sq_u_apassword : ''; ?>">
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <?php
                if ($resultMyEmp[0]->sq_u_gender == '1') {
                  $malecheck = 'checked="checked"';
                  $femalecheck = '';
                } elseif ($resultMyEmp[0]->sq_u_gender == '2') {
                  $malecheck = '';
                  $femalecheck = 'checked="checked"';
                } else {
                  $malecheck = '';
                  $femalecheck = '';
                }

                ?>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gender</label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender1" id="gender1" value="1" checked="" <?php echo $malecheck; ?>> Male <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender1" id="gender1" value="2" <?php echo $femalecheck; ?>> Female <i class="input-helper"></i></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-sm-1">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="send_login1" id="send_login1" value="1"> <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <label class="col-sm-11 col-form-label mt-1"> Send login information (recommended)</label>


                </div>

              </div>


            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <div class="card card-inverse-warning smaltext" id="context-menu-multi">

                  <p class="card-text"> Each team member must have their own unique email address for messages sent to clients, affiliates and team members. Email addresses can be changed by a user with admin permissions. What a team member can see and do depends upon the role you assign them. For more information visit Roles & Permissions. </p>

                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Phone<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="phone" name="phone" required value="<?php echo isset($resultMyEmp[0]->sq_u_phone) ? $resultMyEmp[0]->sq_u_phone : ''; ?>">
                    <?php echo form_error('phone'); ?>

                  </div>
                </div>
              </div>
    <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Status<span></span></label>
                  <div class="col-sm-9">
                    <select id="status" name="sq_u_status" class="form-control">
                      <?php
                      $status = array("active" => "Active", "inactive" => "Inactive");
                      foreach ($status as $st => $val) {
                        $seleced = '';
                        if ($resultMyEmp[0]->sq_u_status == $st) {
                          $seleced = ' selected';
                        }
                      ?>
                        <option value="<?php echo $st; ?>" <?php echo $seleced; ?>><?php echo $val; ?></option>
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
                  <label class="col-sm-3 col-form-label">Mobile</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($resultMyEmp[0]->sq_u_mobile) ? $resultMyEmp[0]->sq_u_mobile : ''; ?>">
                    <?php echo form_error('mobile'); ?>


                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fax<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="fax" name="fax" required value="<?php echo isset($resultMyEmp[0]->sq_u_fax) ? $resultMyEmp[0]->sq_u_fax : ''; ?>">
                    <?php echo form_error('fax'); ?>

                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Title for portal<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title_for_portal" required name="title_for_portal" value="<?php echo isset($resultMyEmp[0]->sq_u_title) ? $resultMyEmp[0]->sq_u_title : ''; ?>">
                    <?php echo form_error('title_for_portal'); ?>

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Address</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($resultMyEmp[0]->sq_u_address) ? $resultMyEmp[0]->sq_u_address : ''; ?>">
                    <?php echo form_error('address'); ?>

                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Role<span>*</span></label>
                  <div class="col-sm-9">
                    <select id="role" name="role" class="form-control">
                      <?php
                      $roles = array("emp" => "Employee", "super" => "Admin");
                      foreach ($roles as $role => $val) {
                        $seleced = '';
                        if ($resultMyEmp[0]->sq_u_type == $role) {
                          $seleced = ' selected';
                        }
                      ?>
                        <option value="<?php echo $role; ?>" <?php echo $seleced; ?>><?php echo $val; ?></option>
                      <?php } ?>
                    </select>
                    <?php echo form_error('role'); ?>

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                    <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Proof of Address</label>
                  <div class="col-sm-9">
                      <?php if(!empty($resultMyEmp[0]->sq_u_address_proof)){?>
                        <img src="<?php echo $resultMyEmp[0]->sq_u_address_proof; ?>" alt="profile" class="img-sm mb-3">
                        <?php } ?>
                    <input type="file" id="addressfile" name="addressfile">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Photo</label>
                  <div class="col-sm-9">
                      <?php if(!empty($resultMyEmp[0]->sq_u_profile_picture)){?>
                        <img src="<?php echo $resultMyEmp[0]->sq_u_profile_picture; ?>" alt="profile" class="img-lg rounded-circle mb-3">
                        <?php } ?>
                    <input type="file" id="myfile" name="myfile">
                  </div>
                </div>
              </div>

            </div>
            <hr>

            <div class="row">


              <div class="col-md-10">
                &nbsp;
              </div>
              <div class="col-md-2">
                <div class="form-group row">
                    <?php 
                 
                          //if($resultMyEmp[0]->added_by == $user_id){?>
                  <button type="submit" class="btn btn-gradient-primary btn-icon-text" id="btnEmpSubmit" name="btnEmpSubmit">
                    Update </button>
                    <?php //} ?>
                </div>
              </div>


            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->


    <script type="text/javascript">

      function closeSuccessModal() {
        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');

      }
    </script>