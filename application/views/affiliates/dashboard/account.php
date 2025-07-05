<style>
    .is-invalid {
        border-color: #dc3545;
    }

    .is-valid {
        border-color: #28a745;
    }

    #password_match_feedback {
        display: block;
        margin-top: 5px;
    }

    #current_password_match {
        display: block;
        margin-top: 5px;
    }

    .input-group-text {
        background-color: transparent;
        border: none;
    }

    .avatar-view-btn:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
</style>

<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="row">

            <div class="col-xl-12">



                <!-- Page Header -->

                <div class="page-header">

                    <div class="row">

                        <div class="col-sm-12">

                            <h3 class="page-title">My Account</h3>

                        </div>

                    </div>

                </div>

                <!-- /Page Header -->

                <div class="card">

                    <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-solid" role="tablist" id="profile_setting_page">

                            <li class="nav-item home_tab" id="profile_li"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-home"></i></span>

                                    <span class="hidden-xs-down">Profile Settings </span></a>

                            </li>

                            <li class="nav-item home_add" id="password_li"> <a class="nav-link" data-toggle="tab" href="#pass" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>

                                    <span class="hidden-xs-down">Change password</span></a>

                            </li>

                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane fade " id="pass" role="tabpanel">

                                <form id="change_password_form" class="settings-form" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="current_password" name="current_password">
                                            <div class="input-group-append">
                                                <span id="current_password_icon" class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <small id="current_password_match"></small>
                                    </div>

                                    <div class="form-group">
                                        <label>New Password</label>
                                        <div class="input-group">
                                            <input type="password" id="new_password" name="new_password" class="form-control">
                                            <div class="input-group-append">
                                                <span id="new_password_icon" class="input-group-text"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                                            <div class="input-group-append">
                                                <span id="confirm_password_icon" class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <small id="password_match_feedback"></small> <!-- Feedback message for matching passwords -->
                                    </div>

                                    <div class="mt-4 save-form">
                                        <button name="save_profile_change" id="cform_submit" class="btn save-btn btn-primary" type="submit">Save Changes</button>
                                    </div>
                                </form>



                            </div>

 <div class="tab-pane fade show active" id="profile" role="tabpanel">
     <form id="profile_settings_form" class="settings-form" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                  <div class="row">
    <!-- Email (Full width and readonly) -->
    <div class="col-4 mb-3">
      <label>Email Address</label>
      <input type="text" class="form-control" id="adminmail" name="email" value="<?php echo $client_result[0]->sq_affiliates_email; ?>" placeholder="Enter email address" readonly>
      <span id="email_error" class="text-danger"></span>
    </div>

    <!-- First Name -->
    <div class="col-md-4 mb-3">
      <label>First Name</label>
      <input type="text" class="form-control" name="first_name" value="<?php echo $client_result[0]->sq_affiliates_first_name; ?>" placeholder="Enter first name">
    </div>

    <!-- Last Name -->
    <div class="col-md-4 mb-3">
      <label>Last Name</label>
      <input type="text" class="form-control" name="last_name" value="<?php echo $client_result[0]->sq_affiliates_last_name; ?>" placeholder="Enter last name">
    </div>

    <!-- Gender -->
    <div class="col-md-4 mb-3">
      <label>Gender</label>
      <select class="form-control" name="gender">
        <option value="0" <?php echo ($client_result[0]->sq_affiliates_gender == '0') ? 'selected' : ''; ?>>Select Gender</option>
        <option value="1" <?php echo ($client_result[0]->sq_affiliates_gender == '1') ? 'selected' : ''; ?>>Male</option>
        <option value="2" <?php echo ($client_result[0]->sq_affiliates_gender == '2') ? 'selected' : ''; ?>>Female</option>
      </select>
    </div>

    <!-- Company -->
    <div class="col-md-4 mb-3">
      <label>Company</label>
      <input type="text" class="form-control" name="company" value="<?php echo $client_result[0]->sq_affiliates_company; ?>" placeholder="Enter company name">
    </div>

    <!-- Website URL -->
    <div class="col-md-4 mb-3">
      <label>Website URL</label>
      <input type="url" class="form-control" name="website" value="<?php echo $client_result[0]->sq_affiliates_website_url; ?>" placeholder="https://example.com">
    </div>

    <!-- Phone -->
    <div class="col-md-4 mb-3">
      <label>Phone</label>
      <input type="text" class="form-control" name="phone" value="<?php echo $client_result[0]->sq_affiliates_phone; ?>" placeholder="Enter phone number">
    </div>

    <!-- Alternate Phone -->
    <div class="col-md-4 mb-3">
      <label>Alternate Phone</label>
      <input type="text" class="form-control" name="alt_phone" value="<?php echo $client_result[0]->sq_affiliates_alternate_phone; ?>" placeholder="Enter alternate phone">
    </div>

    <!-- Fax -->
    <div class="col-md-4 mb-3">
      <label>Fax</label>
      <input type="text" class="form-control" name="fax" value="<?php echo $client_result[0]->sq_affiliates_fax; ?>" placeholder="Enter fax number">
    </div>
  </div>


                                    <!--<div class="form-group">-->

                                    <!--    <label>Profile Image</label>-->

                                    <!--    <div class="media align-items-center">-->

                                    <!--        <div class="media-left">-->

                                    <!--            <?php-->

                                    <!--            if ((!empty($client_result[0]->profile_img))) {-->

                                    <!--                $client_image = $client_result[0]->profile_img;-->
                                    <!--            } else {-->

                                    <!--                $client_image = base_url('assets/img/user.jpg');-->
                                    <!--            }-->

                                    <!--            ?>-->

                                    <!--            <img class="rounded-circle" src="<?php echo $client_image; ?>" width="100" height="100" class="profile-img avatar-view-img" id="blah" onclick="openfilepopup();">-->

                                    <!--            <input type="file" name="file" id="imgupload" style="display:none" />-->

                                    <!--        </div>-->

                                    <!--        <div class="media-body">-->

                                    <!--            <div class="uploader">-->

                                    <!--                <button type="button" class="btn btn-secondary btn-sm ml-2 avatar-view-btn" onclick="openfilepopup();">Change profile picture</button>-->

                                    <!--                <input type="hidden" id="crop_prof_img" name="profile_img">-->

                                    <!--            </div>-->

                                    <!--            <span id="image_error" class="text-danger"></span>-->

                                    <!--        </div>-->

                                    <!--    </div>-->

                                    <!--</div>-->

                                    <div class="mt-4 save-form">
<button type="submit" class="btn btn-primary">Update Profile</button>
                                        <!--<button name="save_profile_image" id="save_profile_image" class="btn btn-primary save-btn" type="button">Save Changes</button>-->

                                    </div>

                                </form>
</div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Profile Image</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">



                <?php $curprofile_img = (!empty($client_result->profile_img)) ? $client_result->profile_img : ''; ?>

                <form class="avatar-form" action="<?= base_url('admin/profile/crop_profile_img/' . $curprofile_img) ?>" enctype="multipart/form-data" method="post">

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />



                    <div class="avatar-body">

                        <!-- Upload image and data -->

                        <div class="avatar-upload">

                            <input class="avatar-src" name="avatar_src" type="hidden">

                            <input class="avatar-data" name="avatar_data" type="hidden">

                            <label for="avatarInput">Select Image</label>

                            <input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/*">

                            <span id="image_upload_error" class="error"></span>

                        </div>

                        <!-- Crop and preview -->

                        <div class="row">

                            <div class="col-md-12">

                                <div class="avatar-wrapper"></div>

                            </div>

                        </div>

                        <div class="mt-4 text-center">

                            <button class="btn btn-primary avatar-save upload_images" id="upload_images" type="submit">Yes, Save Changes</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        // $('.avatar-view-btn').on('click', function() {

        //     $('#avatar-modal').modal('show');
        // });

        // Real-time validation for current password
        $('#current_password').on('keyup', function() {
            let current_password = $(this).val();

            if (current_password !== '') {
                $.ajax({
                    url: '<?php echo base_url('affiliate/verify_current_password'); ?>',
                    type: 'POST',
                    data: {
                        current_password: current_password
                    },
                    success: function(response) {
                        let res = JSON.parse(response);

                        if (res.status === 'correct') {
                            $('#current_password').removeClass('is-invalid').addClass('is-valid');
                            $('#current_password_match').html('<i class="fa fa-check text-success"></i> Current password is correct');
                        } else {
                            $('#current_password').removeClass('is-valid').addClass('is-invalid');
                            $('#current_password_match').html('<i class="fa fa-times text-danger"></i> Current passwords is incorrect');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            } else {
                $('#current_password').removeClass('is-valid is-invalid');
            }
        });

        // Real-time validation for matching passwords
        $('#confirm_password').on('keyup', function() {
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();

            if (new_password === confirm_password && new_password !== '') {
                $('#confirm_password').removeClass('is-invalid').addClass('is-valid');
                $('#new_password').removeClass('is-invalid').addClass('is-valid');
                $('#password_match_feedback').html('<i class="fa fa-check text-success"></i> Passwords match');
            } else {
                $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
                $('#new_password').removeClass('is-valid').addClass('is-invalid');
                $('#password_match_feedback').html('<i class="fa fa-times text-danger"></i> Passwords do not match');
            }
        });

        $('#new_password').on('keyup', function() {
            let new_password = $('#new_password').val();

            // if (new_password != '') {
            //     $('#new_password').removeClass('is-invalid').addClass('is-valid');
            // } else {
            //     $('#new_password').removeClass('is-valid').addClass('is-invalid');
            // }
        });

        $('#change_password_form').on('submit', function(e) {
            e.preventDefault(); // Prevent form submission

            let current_password = $('#current_password').val();
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();

            let isValid = true;

            if (current_password === '') {
                $('#current_password').removeClass('is-valid').addClass('is-invalid');
                isValid = false;
            } else if (current_password != '' && $("#current_password").hasClass("is-invalid")) {
                $('#current_password').removeClass('is-valid').addClass('is-invalid');

                // isValid = false;
            } else {
                $('#current_password').removeClass('is-invalid').addClass('is-valid');

            }

            if (new_password === '') {
                $('#new_password').removeClass('is-valid').addClass('is-invalid');
                isValid = false;
            } else {
                $('#new_password').removeClass('is-invalid').addClass('is-valid');
            }

            if (confirm_password === '' || new_password !== confirm_password) {
                $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
                isValid = false;
            } else {
                $('#confirm_password').removeClass('is-invalid').addClass('is-valid');
            }

            if (isValid) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change password!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo base_url('affiliate/profile_setting'); ?>',
                            type: 'POST',
                            data: {
                                current_password: current_password,
                                new_password: new_password,
                                confirm_password: confirm_password
                            },
                            success: function(response) {
                                let res = JSON.parse(response);
                                if (res.status === 'success') {
                                    Swal.fire(
                                        'Success!',
                                        'Password changed successfully.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    $('#current_password').removeClass('is-valid').addClass('is-invalid');
                                    Swal.fire(
                                        'Error!',
                                        res.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'There was a problem processing your request.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            } else {
                Swal.fire(
                    'Error!',
                    'Please fill out all required fields.',
                    'error'
                );
            }
        });
    });

    function openfilepopup() {
        $('#imgupload').trigger('click');
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

    $('#save_profile_image').on('click', function(e) {
        e.preventDefault(); // Prevent form submission

        let imgupload = $("#imgupload")[0].files[0];

        let isValid = true;

        if (!imgupload) {
            $('#imgupload').removeClass('is-valid').addClass('is-invalid');
            isValid = false;
        } else {
            $('#imgupload').removeClass('is-invalid').addClass('is-valid');
        }

        if (isValid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update profile!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();
                    formData.append('imgupload', imgupload);
                    formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>'); // Adding CSRF token

                    $.ajax({
                        url: '<?php echo base_url('client/update_profile'); ?>',
                        type: 'POST',
                        data: formData,
                        processData: false, // Prevent jQuery from automatically transforming the data into a query string
                        contentType: false, // Tell jQuery not to set the content type
                        success: function(response) {
                            let res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire(
                                    'Success!',
                                    'Profile updated successfully.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                $('#imgupload').removeClass('is-valid').addClass('is-invalid');
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was a problem processing your request.',
                                'error'
                            );
                        }
                    });
                }
            });
        } else {
            Swal.fire(
                'Error!',
                'Please fill out all required fields.',
                'error'
            );
        }
    });
</script>
<script>
$(document).ready(function () {
  $('#profile_settings_form').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
      url: "<?php echo base_url('affiliate/update-profile'); ?>",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        let res = JSON.parse(response);
        alert(res.message);
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        alert("Something went wrong. Please try again.");
      }
    });
  });
});
</script>
