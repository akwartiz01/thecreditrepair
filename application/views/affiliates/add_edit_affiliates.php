<style>
  a#advance,
  #advanceremove {
    /* color: #ed1c24; */
    color: #3972FC;
    margin-bottom: 16px;
    float: left;
  }
</style>
<!-- partial -->
 <div id="ajaxLoader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
     background: rgba(255,255,255,0.7); z-index: 9999; text-align: center; padding-top: 20%;">
  <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

<div class="container-fluid page-body-wrapper">
  <div class="main-panel pnel">
    <div class="content-wrapper">
          <div class="page-header mb-4">
          <h1> <?php echo $title; ?> Affiliate Partner</h1>
          </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6" style="text-align: right; margin-bottom: 0px;">
              <a href="<?php echo base_url('affiliates'); ?>"> <button type="button" class="btn btn-gradient-primary btn-icon-text add-new">
                  Back </button></a>
            </div>
          </div>
          <hr>
          <?php if ($this->session->flashdata('aff-insertion-success')) { ?>
            <div id="affSuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
              <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
                <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
                  <div class="swal-icon--success__ring"></div>
                  <div class="swal-icon--success__hide-corners"></div>
                </div>
                <div class="swal-title" style="">Record <?php echo $title; ?>ed!</div>
                <div class="swal-text" style=""><?php echo $this->session->flashdata('aff-insertion-success'); ?></div>
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
          <form class="form-sample" style="padding-top:10px;" action="" method="POST" id="affiliatesFormID" enctype="multipart/form-data">

            <?php if ($this->session->flashdata('aff-insertion-error')) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('aff-insertion-error'); ?>
              </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">First Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if (isset($affiliate->sq_affiliates_first_name)) {
                                                                                                        echo $affiliate->sq_affiliates_first_name;
                                                                                                      } ?>" autocomplete="off" required>
                    <?php echo form_error('first_name'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Last Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="last_name" value="<?php if (isset($affiliate->sq_affiliates_last_name)) {
                                                                                      echo $affiliate->sq_affiliates_last_name;
                                                                                    } ?>" id="last_name" autocomplete="off">
                    <?php //echo form_error('last_name'); 
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gender</label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" id="gender1" value="0" <?php if (isset($affiliate->sq_affiliates_gender) && $affiliate->sq_affiliates_gender == 0) {
                                                                                                            echo "checked";
                                                                                                          }
                                                                                                          if (!isset($affiliate->sq_affiliates_gender)) {
                                                                                                            echo "checked";
                                                                                                          } ?>> Male <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" id="gender2" value="1" <?php if (isset($affiliate->sq_affiliates_gender) && $affiliate->sq_affiliates_gender == 1) {
                                                                                                            echo "checked";
                                                                                                          } ?>> Female <i class="input-helper"></i></label>
                    </div>
                  </div>
                </div>
                <?php //echo form_error('gender'); 
                ?>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-sm-1">
                    <div class="form-check">
                      <label class="form-check-label">

                    </div>
                  </div>
                  <label class="col-sm-11 col-form-label"> </label>


                </div>

              </div>


            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Company</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="company" name="company" value="<?php if (isset($affiliate->sq_affiliates_company)) {
                                                                                                  echo $affiliate->sq_affiliates_company;
                                                                                                } ?>" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Website URL</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="website_url" name="website_url" value="<?php if (isset($affiliate->sq_affiliates_website_url)) {
                                                                                                          echo $affiliate->sq_affiliates_website_url;
                                                                                                        } ?>" autocomplete="off">
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($affiliate->sq_affiliates_last_name)) {
                                                                                              echo $affiliate->sq_affiliates_email;
                                                                                            } ?>" autocomplete="off" required>
                    <?php echo form_error('email'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Phone</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control phone" name="phone" id="phone" value="<?php if (isset($affiliate->sq_affiliates_phone)) {
                                                                                                    echo $affiliate->sq_affiliates_phone;
                                                                                                  } ?>" autocomplete="off" maxlength="14" minlength="14" onkeypress="return isNumber(event,this);">
                    <?php //echo form_error('phone'); 
                    ?>
                  </div>
                  <label class="col-sm-2 col-form-label">Ext</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="phone_ext" value="<?php if (isset($affiliate->sq_affiliates_phone_ext)) {
                                                                                      echo $affiliate->sq_affiliates_phone_ext;
                                                                                    } ?>" autocomplete="off">
                    <?php echo form_error('phone_ext'); ?>
                  </div>
                </div>
              </div>


            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Alternate Phone</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control phone" id="alternate_phone" name="alternate_phone" value="<?php if (isset($affiliate->sq_affiliates_alternate_phone)) {
                                                                                                                        echo $affiliate->sq_affiliates_alternate_phone;
                                                                                                                      } ?>" autocomplete="off" maxlength="14" minlength="14" onkeypress="return isNumber(event,this);">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fax</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="fax" name="fax" value="<?php if (isset($affiliate->sq_affiliates_fax)) {
                                                                                          echo $affiliate->sq_affiliates_fax;
                                                                                        } ?>" autocomplete="off" maxlength="14" minlength="14" onkeypress="return isNumber(event,this);">
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">

                  <div class="col-sm-7">
                    <a id="advance" <?php if (isset($affiliate->sq_affiliates_mailing_address) || isset($affiliate->sq_affiliates_city) || isset($affiliate->sq_affiliates_state) || isset($affiliate->sq_affiliates_zip_code) || isset($affiliate->sq_affiliates_country)) { ?> style="display: none;" <?php } else { ?> style="display: block;" <?php } ?>>+ Add Mailing Address (optional)</a>

                    <a id="advanceremove" <?php if (isset($affiliate->sq_affiliates_mailing_address) || isset($affiliate->sq_affiliates_city) || isset($affiliate->sq_affiliates_state) || isset($affiliate->sq_affiliates_zip_code) || isset($affiliate->sq_affiliates_country)) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?>>- Remove Mailing Address</a>
                  </div>
                </div>
              </div>
            </div>
            <div id="advancediv" <?php if (isset($affiliate->sq_affiliates_mailing_address) || isset($affiliate->sq_affiliates_city) || isset($affiliate->sq_affiliates_state) || isset($affiliate->sq_affiliates_zip_code) || isset($affiliate->sq_affiliates_country)) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?>>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row" style="margin-bottom: 21px !important;">
                    <label class="col-sm-3 col-form-label">Mailing Address</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="mailing_address" name="mailing_address" autocomplete="off"><?php if (isset($affiliate->sq_affiliates_mailing_address)) {
                                                                                                                                  echo $affiliate->sq_affiliates_mailing_address;
                                                                                                                                } ?></textarea>
                    </div>
                  </div>
                </div>


              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">City</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="city" id="city" value="<?php if (isset($affiliate->sq_affiliates_city)) {
                                                                                              echo $affiliate->sq_affiliates_city;
                                                                                            } ?>" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">State</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="state" id="state" value="<?php if (isset($affiliate->sq_affiliates_state)) {
                                                                                                echo $affiliate->sq_affiliates_state;
                                                                                              } ?>" autocomplete="off">
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Zip code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="zip_code" id="zip_code" value="<?php if (isset($affiliate->sq_affiliates_zip_code)) {
                                                                                                      echo $affiliate->sq_affiliates_zip_code;
                                                                                                    } ?>" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Country</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="country" id="country" value="<?php if (isset($affiliate->sq_affiliates_country)) {
                                                                                                    echo $affiliate->sq_affiliates_country;
                                                                                                  } ?>" autocomplete="off">
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Status</label>
                  <div class="col-sm-9">
                    <select name="status" id="status" class="form-control">
                      <option value="">Select status</option>
                      <option value="1" <?php if (isset($affiliate->sq_affiliates_status) && $affiliate->sq_affiliates_status == 1) {
                                          echo "selected";
                                        } ?>>Active</option>
                      <option value="0" <?php if (isset($affiliate->sq_affiliates_status) && $affiliate->sq_affiliates_status == 0) {
                                          echo "selected";
                                        } ?>>Inactive</option>
                      <option value="2" <?php if (isset($affiliate->sq_affiliates_status) && $affiliate->sq_affiliates_status == 2) {
                                          echo "selected";
                                        } ?>>Pending</option>
                    </select>
                    <?php //echo form_error('status'); 
                    ?>
                  </div>
                </div>
              </div>


            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Notes (internal)</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="notes" id="notes" autocomplete="off"><?php if (isset($affiliate->sq_affiliates_notes)) {
                                                                                                echo $affiliate->sq_affiliates_notes;
                                                                                              } ?></textarea>
                  </div>
                </div>
              </div>


            </div>
            <div class="row">

              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Photo</label>
                  <div class="col-sm-9">
                    <input type="file" id="myfile" name="myfile"><br><br>
                    <?php if (isset($affiliate->sq_affiliates_photo_url)) {
                      echo "<img src='" . $affiliate->sq_affiliates_photo_url . "' style='width:200px;'/>";
                    } ?>
                  </div>
                </div>
              </div>

            </div>
            <!-- <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Assigned to</label>
                  <div class="col-sm-9"> -->
            <?php
            // foreach ($clients as $client) {
            //   $checked = "";
            //   $assigned_to = array();
            //   if (isset($affiliate->sq_affiliates_assigned_to)) {
            //     $assigned_to = unserialize($affiliate->sq_affiliates_assigned_to);

            //     if (is_array($assigned_to) && in_array($client->sq_client_id, $assigned_to)) {
            //       $checked = "checked";
            //     }
            //   }
            //   $name = $client->sq_first_name . " " . $client->sq_last_name;
            //   echo '<input type="checkbox" value="' . $client->sq_client_id . '" name="assigned_to[]" ' . $checked . '>' . $name . "<br>";
            // }
            ?>
            <!-- </div>
                </div>
              </div>
            </div> -->
            <?php if (!isset($affiliate->sq_affiliates_email)) { ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">

                    <div class="col-sm-7">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" value="0" checked="" id="masterContactList" name="master_contact_list"> Add to master contact list <i class="input-helper"></i></label>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <hr>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Portal Access</label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="portal_access" id="portal1" value="1" name="portal" <?php if (isset($affiliate->sq_affiliates_portal) && $affiliate->sq_affiliates_portal == 1) {
                                                                                                                                  echo "checked";
                                                                                                                                }      if (!isset($affiliate->sq_affiliates_portal)) {
                                                                                                            echo "checked";
                                                                                                          } ?>> Yes <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input <?php if (isset($affiliate->sq_affiliates_portal) && $affiliate->sq_affiliates_portal == 0) {
                                  echo "checked";
                                }
                              ?> type="radio" class="form-check-input" name="portal_access" id="portal2" value="0" name="portal">No<i class="input-helper"></i></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row affiliate_user_sec" <?php if (isset($affiliate->sq_affiliates_portal) && $affiliate->sq_affiliates_portal == 1) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?>>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label" style="padding-right: 0;">Affiliate's User ID (Email)</label>
                  <div class="col-sm-8" style="padding-left: 0;">
                    <input type="email" class="form-control" name="affiliate_user_id" value="<?php if (isset($affiliate->sq_affiliates_email)) {
                                                                                                echo $affiliate->sq_affiliates_email;
                                                                                              } ?>" id="affiliate_user_id" disabled>
                  </div>
                </div>
              </div>
              <div class="col-md-12">*Your affiliate will be sent login details. They create their own password when they first log in.</div>
            </div>

            <div class="row">

                            <div class="col-12 d-flex justify-content-end">
                    <?php
                    if($title == "Edit"){?>
                    <button type="button" class="btn btn-gradient-secondary btn-icon-text mr-2" id="welcommail">
                                    Welcom Mail Send
                                </button>
                    <?php } ?>
                  <button type="submit" class="btn btn-gradient-primary btn-icon-text" name="affiliatesSubmitButton">
                    Submit </button>
                </div>


            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <script>
    //   $("input[name='portal_access'],#status").on("change mouseover", function() {
    //     var status = $("#status").val();
    //     var access = $("input[name='portal_access']:checked").val();
    //     if (access == 1) {
    //       if (status == 1) {
    //         $("#portal1").attr("title", '');
    //         $(".affiliate_user_sec").show();
    //         $("#affiliate_user_id").val($("#email").val());

    //       } else {
    //         $("#portal1").prop("checked", false);
    //         $("#portal2").prop("checked", true);
    //         $("#portal1").attr("title", 'Only active affiliates can access the portal. Please change this affiliates status and before turning portal access on.');
    //       }
    //     } else {
    //       $(".affiliate_user_sec").hide();
    //     }
    //   })

      $("#email").on("change", function() {
        $("#affiliate_user_id").val($("#email").val());
      });

     
       $('#welcommail').on('click', function () {
        $('#ajaxLoader').show()
    $.ajax({
      url: '<?= base_url("sendWelcomeMail"); ?>',
      type: 'POST',
      data: {
        id: '<?= $affiliate->sq_affiliates_id?>',
        type: 'affiliate'
      },
      success: function (response) {
            $('#ajaxLoader').hide()
        alert('Welcome mail sent successfully!');
        console.log(response);
      },
      error: function (xhr, status, error) {
        alert('Error sending welcome mail.');
        console.error(error);
      }
    });
  });
    </script>
    <script>
function closeSuccessModal() {
  
  $('#affSuccess').css('display', 'none');
}
</script>