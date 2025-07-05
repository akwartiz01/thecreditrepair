<?php

$client_image = base_url('assets/img/user.jpg');

?>

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
<div class="page-header mb-4">
          <h1> Add Team Member </h1>
          </div>

      <div class="card">
        <div class="card-body">
          <?php if ($this->session->flashdata('emp-insertion-success')) { ?>
            <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
              <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
                <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
                  <div class="swal-icon--success__ring"></div>
                  <div class="swal-icon--success__hide-corners"></div>
                </div>
                <div class="swal-title" style="">Employee Added!</div>
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
          
            
            </div>

          </div>
          <form class="form-sample" id="member-form" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">First Name<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="first_name" name="first_name" value="">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                     <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Email<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="">
<input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Last Name<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="last_name" name="last_name" value="">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Password<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="password" name="password" value="">
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
                        <input type="radio" class="form-check-input" name="gender" id="gender" value="1" checked=""> Male <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" id="gender" value="2"> Female <i class="input-helper"></i></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-sm-1">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="send_login_info" id="send_login_info" value="1" checked> <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <label class="col-sm-11 col-form-label"> Send login information (recommended)</label>


                </div>

              </div>


            </div>
            <div class="row">
              <div class="col-md-6">
             
              </div>

              <!--  -->
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-8 col-form-label">System genereated password (not recommended)</label>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="sq_u_sys_login" id="sq_u_sys_login" value="1"> Yes <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="sq_u_sys_login" id="sq_u_sys_login" value="0" checked=""> No <i class="input-helper"></i></label>
                    </div>
                  </div>

                </div>
              </div>
              <!--  -->


            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Phone<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="phone" name="phone" value="">


                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-inverse-warning smaltext" id="context-menu-multi">

                  <p class="card-text"> Each team member must have their own unique email address for messages sent to clients, affiliates and team members. Email addresses can be changed by a user with admin permissions. What a team member can see and do depends upon the role you assign them. For more information visit Roles & Permissions. </p>

                </div>
              </div>

            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Mobile</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="mobile" name="mobile" value="">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fax<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="fax" name="fax" value="">

                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Title for portal<span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title_for_portal" name="title_for_portal" value="">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Address</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" name="address" value="">
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
                      foreach ($roles as $role => $val) { ?>
                        <option value="<?php echo $role; ?>"><?php echo $val; ?></option>
                      <?php } ?>
                    </select>

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                    <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Proof of Address</label>
                  <div class="col-sm-9">
                    <input type="file" id="addressfile" name="addressfile">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Photo</label>
                  <div class="col-sm-9">
                    <img class="rounded-circle" src="<?php echo $client_image; ?>" width="100" height="100" class="profile-img avatar-view-img" id="blah" onclick="openfilepopup();">
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
                  <button type="button" class="btn btn-gradient-primary btn-icon-text" id="btnEmpSubmit" name="btnEmpSubmit">
                    Submit </button>
                </div>
              </div>


            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
      function openfilepopup() {
        $('#myfile').trigger('click');
      }

      $("#myfile").change(function() {
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

      function closeSuccessModal() {
        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');

      }

      function validateFieldsOnKeyup() {
        $('#first_name, #last_name, #email,#user_id, #phone, #password,#fax,#title_for_portal').on('keyup', function() {
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
        //   case 'user_id':
        //     let user_id_Pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //     if (value === "") {
        //       handleFieldValidation($field, "User ID is required.");
        //     } else if (!user_id_Pattern.test(value)) {
        //       handleFieldValidation($field, "Please enter a valid User ID.");
        //     } else {
        //       clearFieldValidation($field);
        //     }
        //     break;
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
          case 'fax':
            if (value === "") {
              handleFieldValidation($field, "Fax Number is required.");
            } else {
              clearFieldValidation($field);
            }
            break;

          case 'title_for_portal':
            if (value === "") {
              handleFieldValidation($field, "Portal title is required.");
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
        let isPasswordRequired = true; // Track if password validation is required

        // Function to update password validation based on send_system_gen_password value
        function updatePasswordValidation() {
          isPasswordRequired = $("input[name='sq_u_sys_login']:checked").val() != "1";
          if (!isPasswordRequired) {
            clearFieldValidation($('#password')); // Clear password validation if not required
            $('#password').attr('disabled', true);
            $('#password').val('');
          }
          else{
            
            $('#password').attr('disabled', false);
          }
        }

        // Listen for changes on the send_system_gen_password radio buttons
        $("input[name='sq_u_sys_login']").change(function() {
          updatePasswordValidation();
        });

        $("#btnEmpSubmit").click(function(event) {
          event.preventDefault(); // Prevent form submission

          let isValid = true;

          // Clear any previous validation states before new validation
          clearFieldValidation($('#first_name'));
          clearFieldValidation($('#last_name'));
          clearFieldValidation($('#email'));
          clearFieldValidation($('#user_id'));
          clearFieldValidation($('#phone'));
          clearFieldValidation($('#password'));
          clearFieldValidation($('#fax'));
          clearFieldValidation($('#title_for_portal'));

          let first_name = $('#first_name').val();
          let last_name = $('#last_name').val();
          let user_id = $('#user_id').val();
          let password = $('#password').val();
          let gender = $("input[name='gender']:checked").val();
          let send_login_info = $("input[name='send_login_info']:checked").val();
          let send_system_gen_password = $("input[name='sq_u_sys_login']:checked").val();
          let email = $('#email').val();
          let phone = $('#phone').val();
          let mobile = $('#mobile').val();
          let fax = $('#fax').val();
          let title_for_portal = $('#title_for_portal').val();
          let address = $('#address').val();
          let role = $('#role').find(":selected").val();
          let myfile = $("#myfile")[0].files[0];
           let addressfile = $("#addressfile")[0].files[0];

          if (first_name == "") {
            handleFieldValidation($('#first_name'), "First Name is required.");
            isValid = false;
          }

          if (last_name == "") {
            handleFieldValidation($('#last_name'), "Last Name is required.");
            isValid = false;
          }

        //   if (user_id == "") {
        //     handleFieldValidation($('#user_id'), "User ID is required.");
        //     isValid = false;
        //   }

          // Validate password only if password validation is required
          if (isPasswordRequired && password == "") {
            handleFieldValidation($('#password'), "Password is required.");
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

          if (send_login_info == 0 || send_login_info == '') {
            handleFieldValidation($('#send_login_info'), "This is required.");
            isValid = false;
          }
          if (fax == "") {
            handleFieldValidation($('#fax'), "Fax Number is required.");
            isValid = false;
          }
          if (title_for_portal == "") {
            handleFieldValidation($('#title_for_portal'), "Portal title is required.");
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
            formData.append('first_name', first_name);
            formData.append('last_name', last_name);
            formData.append('user_id', user_id);
            formData.append('password', password);
            formData.append('gender', gender);
            formData.append('send_login_info', send_login_info);
            formData.append('send_system_gen_password', send_system_gen_password);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('mobile', mobile);
            formData.append('fax', fax);
            formData.append('title_for_portal', title_for_portal);
            formData.append('address', address);
            formData.append('role', role);


            if (myfile) {
              formData.append('myfile', myfile); // Only append if file is uploaded
            }
   if (addressfile) {
              formData.append('addressfile', addressfile); // Only append if file is uploaded
            }
            $.ajax({
              type: 'POST',
              url: '<?php echo base_url("new-team"); ?>',
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
                    window.location.href = "<?php echo base_url('my-company'); ?>";
                  });
                } else if (res.status == 'error') {
                  Swal.fire({
                    title: 'Error',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'Close'
                  });
                }
              }
            });
          }
        });

        // Initial call to set up the validation based on current value
        updatePasswordValidation();
      });
    </script>