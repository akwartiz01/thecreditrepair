<?php if ($this->session->flashdata('success')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style="">Profile Data!</div>
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
      <div class="swal-title" style="">Profile Error!</div>
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

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title"> Profile </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
      </ol>
    </nav>
  </div>
  <?php
  // echo '<pre>';
  // print_r($get_loginUser_info);
  // echo '</pre>';
  ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form method="post" action="<?php echo base_url(); ?>profile" enctype="Multipart/form-data">
            <div class="row">
              <div class="col-lg-4">

                <div class="border-bottom text-center pb-4">
                  <?php if ($get_loginUser_info->sq_u_profile_picture != '') {
                    $imglink = $get_loginUser_info->sq_u_profile_picture;
                  } else {
                    $imglink = base_url() . 'assets/images/faces/face12.jpg';
                  }
                  ?>

                  <img src="<?php echo $imglink; ?>" id="blah" alt="profile" class="img-lg rounded-circle mb-3" onclick="openfilepopup();">
                  <input type="file" name="file" id="imgupload" style="display:none" />

                  <div class="text-center">
                    <button type="button" class="btn btn-gradient-success btn-sm" onclick="openfilepopup();">Change Profile Picture</button>
                  </div>
                  <div class="py-4">
                    <p class="clearfix">
                      <span class="float-left"> Role </span>
                      <span class="float-right text-muted"> <?php echo $get_loginUser_info->sq_u_type; ?> </span>
                    </p>
                    <p class="clearfix">
                      <span class="float-left"> Status </span>
                      <span class="float-right text-muted"> <?php echo $get_loginUser_info->sq_u_status; ?> </span>
                    </p>
                    <p class="clearfix">
                      <span class="float-left"> Phone </span>
                      <span class="float-right text-muted"> <?php echo $get_loginUser_info->sq_u_phone; ?> </span>
                    </p>
                    <p class="clearfix">
                      <span class="float-left"> Mail </span>
                      <span class="float-right text-muted"> <?php echo $get_loginUser_info->sq_u_email_id; ?> </span>
                    </p>

                  </div>
                </div>

              </div>

              <div class="col-lg-8">
                <div class="d-flex justify-content-between">
                  <div>
                    <h3><?php echo $get_loginUser_info->sq_u_first_name . ' ' . $get_loginUser_info->sq_u_last_name; ?></h3>
                    <div class="d-flex align-items-center">
                      <h5 class="mb-0 mr-2 text-muted"><?php echo $get_loginUser_info->sq_u_email_id; ?></h5>

                    </div>
                  </div>
                  <div>

                    <button type="submit" name="update" class="btn btn-gradient-primary btn-sm">Update User</button>
                  </div>
                </div>



                <div class="row mt-4 mb-3">
                  <div class="col-3">
                    <label>First Name:</label>
                  </div>
                  <div class="col-6">
                    <input type="text" name="fname" class="form-control" value="<?php echo isset($get_loginUser_info) ? $get_loginUser_info->sq_u_first_name : ''; ?>" required="required" autocomplete="off">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-3">
                    <label>Last Name:</label>
                  </div>
                  <div class="col-6">
                    <input type="text" name="lname" class="form-control" value="<?php echo isset($get_loginUser_info) ? $get_loginUser_info->sq_u_last_name : ''; ?>" required="required" autocomplete="off">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-3">
                    <label>Address:</label>
                  </div>
                  <div class="col-6">
                    <input type="text" name="address" class="form-control" value="<?php echo isset($get_loginUser_info) ? $get_loginUser_info->sq_u_address : ''; ?>"  autocomplete="off">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-3">
                    <label>Phone:</label>
                  </div>
                  <div class="col-6">
                    <input type="number" name="phone" class="form-control" value="<?php echo isset($get_loginUser_info) ? $get_loginUser_info->sq_u_phone : ''; ?>" autocomplete="off">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-3">
                    <label>Mobile:</label>
                  </div>
                  <div class="col-6">
                    <input type="number" name="mobile" class="form-control" value="<?php echo isset($get_loginUser_info) ? $get_loginUser_info->sq_u_mobile : ''; ?>" autocomplete="off">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-3">
                    <label>Fax:</label>
                  </div>
                  <div class="col-6">
                    <input type="number" name="fax" class="form-control" value="<?php echo isset($get_loginUser_info) ? $get_loginUser_info->sq_u_fax : ''; ?>" autocomplete="off">
                  </div>
                </div>


              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<script type="text/javascript">
  function openfilepopup() {
    $('#imgupload').trigger('click');
  }

  function closeSuccessModal() {
    $('#pDsuccess').css('display', 'none');
    $('#pDMsuccess').css('display', 'none');
    //location.reload();
  }

  $("#imgupload").change(function() {
    readURL(this);
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>