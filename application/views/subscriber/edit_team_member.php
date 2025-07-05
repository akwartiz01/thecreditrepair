<?php
$gender = $this->config->item('gender');
$send_login_info = $this->config->item('send_login_info');
?>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Edit Team Member</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-body">
                        <form id="add_client" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="hidEmpId" id="hidEmpId" value="<?php echo $empID; ?>">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>First Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo isset($resultMyEmp[0]->sq_u_first_name) ? $resultMyEmp[0]->sq_u_first_name : ''; ?>">
                                    </div>
                                    <div class="col-6">
                                        <label>User ID<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="user_id" name="user_id" value="<?php echo isset($resultMyEmp[0]->sq_u_user_id) ? $resultMyEmp[0]->sq_u_user_id : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-password">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Last Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo isset($resultMyEmp[0]->sq_u_last_name) ? $resultMyEmp[0]->sq_u_last_name : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Password</label>
                                        <div class="input-group position-relative">
                                            <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($resultMyEmp[0]->sq_u_apassword) ? $resultMyEmp[0]->sq_u_apassword : ''; ?>" autocomplete="new-password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <?php foreach ($gender as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>" <?php if ($resultMyEmp[0]->sq_u_gender == $key) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Send login information (recommended)</label>
                                        <select class="form-control" id="send_login" name="send_login">
                                            <?php foreach ($send_login_info as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>" <?php if ($resultMyEmp[0]->sq_u_sys_login == $key) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($resultMyEmp[0]->sq_u_email_id) ? $resultMyEmp[0]->sq_u_email_id : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($resultMyEmp[0]->sq_u_phone) ? $resultMyEmp[0]->sq_u_phone : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($resultMyEmp[0]->sq_u_mobile) ? $resultMyEmp[0]->sq_u_mobile : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Fax</label>
                                        <input type="text" class="form-control" id="fax" name="fax" value="<?php echo isset($resultMyEmp[0]->sq_u_fax) ? $resultMyEmp[0]->sq_u_fax : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Title for portal</label>
                                        <input type="text" class="form-control" id="title_for_portal" name="title_for_portal" value="<?php echo isset($resultMyEmp[0]->sq_u_title) ? $resultMyEmp[0]->sq_u_title : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($resultMyEmp[0]->sq_u_address) ? $resultMyEmp[0]->sq_u_address : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">

                                <label>Profile Image</label>

                                <div class="media align-items-center">

                                    <div class="media-left">

                                        <?php

                                        if ((!empty($resultMyEmp[0]->sq_u_profile_picture))) {

                                            $_image = $resultMyEmp[0]->sq_u_profile_picture;
                                        } else {

                                            $_image = base_url('assets/img/user.jpg');
                                        }

                                        ?>

                                        <img class="rounded-circle" src="<?php echo $_image; ?>" width="100" height="100" class="profile-img avatar-view-img" id="blah" onclick="openfilepopup();">

                                        <input type="file" name="file" id="imgupload" style="display:none" />

                                    </div>

                                    <div class="media-body">

                                        <div class="uploader">

                                            <button type="button" class="btn btn-secondary btn-sm ml-2 avatar-view-btn" onclick="openfilepopup();">Change profile picture</button>

                                            <input type="hidden" id="crop_prof_img" name="profile_img">

                                        </div>

                                        <span id="image_error" class="text-danger"></span>

                                    </div>

                                </div>

                            </div>



                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" onclick="edit_team_member();">Submit</button>
                                <a href="<?php echo base_url('team-members'); ?>" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
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

    function validateFieldsOnKeyup() {
        $('#first_name, #last_name,#send_login, #email,#user_id, #phone, #password').on('keyup', function() {
            validateField($(this));
        });
    }

    function validateField($field) {
        let id = $field.attr('id');
        let value = $field.val();

        switch (id) {
            case 'first_name':
                if (value === "") {
                    handleFieldValidation($field, "First Name is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'last_name':
                if (value === "") {
                    handleFieldValidation($field, "Last Name is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'send_login':
                if (value === 0) {
                    handleFieldValidation($field, "This is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'email':
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value === "") {
                    handleFieldValidation($field, "Email is required.");
                } else if (!emailPattern.test(value)) {
                    handleFieldValidation($field, "Please enter a valid Email address.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'user_id':
                let user_id_Pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value === "") {
                    handleFieldValidation($field, "User ID is required.");
                } else if (!user_id_Pattern.test(value)) {
                    handleFieldValidation($field, "Please enter a valid User ID.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'phone':
                let phonePattern = /^\d{10}$/;
                if (value === "") {
                    handleFieldValidation($field, "Phone is required.");
                } else if (!phonePattern.test(value)) {
                    handleFieldValidation($field, "Please enter a valid 10-digit phone number.");
                } else {
                    clearFieldValidation($field);
                }
                break;

            case 'password':
                let passwordPattern = /^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*\d).{8,}$/;
                if (value === "") {
                    handleFieldValidation($field, "Password is required.");
                } else if (!passwordPattern.test(value)) {
                    $('.form-password').css('margin-bottom', '45px');
                    handleFieldValidation($field, "Password must contain at least 8 characters, a number, and a special character.");

                } else {
                    clearFieldValidation($field);
                }
                break;
        }
    }

    function handleFieldValidation($field, message) {
        $field.addClass('is-invalid');
        if (!$field.next('.invalid-feedback').length) {
            $field.after('<div class="invalid-feedback"><strong>' + message + '</strong></div>');
        }
    }

    function clearFieldValidation($field) {
        $field.removeClass('is-invalid');
        $field.next('.invalid-feedback').remove();
        $('.form-password').css('margin-bottom', 'revert-layer');
    }

    // Real-time field validation on keyup
    validateFieldsOnKeyup();

    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            let passwordField = $('#password');
            let type = passwordField.attr('type') === 'password' ? 'text' : 'password';

            // Store current value to prevent losing it on type switch
            let currentValue = passwordField.val();

            // Set the field type
            passwordField.attr('type', type);

            // Restore the value to prevent system auto-fill issues
            passwordField.val(currentValue);

            // Toggle the icon between eye and eye-slash
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
    });

    function edit_team_member() {
        let hidEmpId = $('#hidEmpId').val();

        let isValid = true;

        // Clear any previous validation states before new validation
        clearFieldValidation($('#first_name'));
        clearFieldValidation($('#last_name'));
        clearFieldValidation($('#email'));
        clearFieldValidation($('#phone_mobile'));

        let first_name = $('#first_name').val();
        let user_id = $('#user_id').val();
        let last_name = $('#last_name').val();
        let password = $('#password').val();
        let gender = $('#gender').find(":selected").val();
        let send_login_info = $('#send_login').find(":selected").val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let mobile = $('#mobile').val();
        let fax = $('#fax').val();
        let title_for_portal = $('#title_for_portal').val();
        let address = $('#address').val();
        let imgupload = $("#imgupload")[0].files[0];

        if (first_name == "") {
            handleFieldValidation($('#first_name'), "First Name is required.");
            isValid = false;
        }

        if (user_id == "") {
            handleFieldValidation($('#user_id'), "User ID is required.");
            isValid = false;
        }
        if (last_name == "") {
            handleFieldValidation($('#last_name'), "Last Name is required.");
            isValid = false;
        }


        if (email == "") {
            handleFieldValidation($('#email'), "Email is required.");
            isValid = false;
        }

        if (phone == "") {
            handleFieldValidation($('#phone'), "Phone is required.");
            isValid = false;
        }

        if (password == "") {
            handleFieldValidation($('#password'), "Password is required.");
            isValid = false;
        }

        if (send_login_info == 0) {
            handleFieldValidation($('#send_login'), "This is required.");
            isValid = false;
        }

        if (!isValid) {
            Swal.fire({
                title: 'Error',
                text: 'Please provide all mandatory fields!',
                icon: 'error',
                confirmButtonText: 'Retry'
            });

            // Scroll to the first invalid field
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 50 // Offset for smooth scrolling
            }, 500);

        } else {
            $('#loader').show();


            // Using FormData to handle file uploads and other fields
            let formData = new FormData();
            formData.append('hidEmpId', hidEmpId);
            formData.append('first_name', first_name);
            formData.append('user_id', user_id);
            formData.append('last_name', last_name);
            formData.append('password', password);
            formData.append('gender', gender);
            formData.append('send_login_info', send_login_info);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('mobile', mobile);
            formData.append('fax', fax);
            formData.append('title_for_portal', title_for_portal);
            formData.append('address', address);


            if (imgupload) {
                formData.append('imgupload', imgupload); // Only append if file is uploaded
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('update_team_member'); ?>',
                data: formData,
                contentType: false, // Important for FormData
                processData: false, // Important for FormData
                success: function(response) {
                    let res = JSON.parse(response);
                    $('#loader').hide();
                    if (res.status == 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'Continue'
                        }).then(() => {
                            window.location.href = "<?php echo base_url('team-members'); ?>";
                        });
                    } else if (res.status == 'error') {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'Retry'
                        });
                    }
                }
            });
        }
    }
</script>