<?php
$client_status_subscriber = $this->config->item('client_status_subscriber');
$client_days_opt = $this->config->item('client_days_opt');
$portal_access = $this->config->item('portal_access');
?>

<style>
    .custom-control-input:checked~.custom-control-label::before {
        background-color: green;
        border-color: green;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Add Client</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-body">
                        <form id="add_client" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= (!empty($user['id'])) ? $user['id'] : '' ?>" id="user_id">
                            <input type="hidden" id="client_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>First Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="first_name" id="first_name">
                                    </div>
                                    <div class="col-6">
                                        <label>Last Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="last_name" id="last_name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Middle Name</label>
                                        <input class="form-control" type="text" name="middle_name" id="middle_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Suffix</label>
                                        <input class="form-control" type="text" name="suffix" id="suffix">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email Address (Necessary for Onboarding)</label>
                                        <input class="form-control" type="email" name="email" id="email">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <label>Check if no email</label> -->
                                        <div class="form-check" style="margin-top: 38px !important;">
                                            <input type="checkbox" class="form-check-input" name="noEmail" id="noEmail" value="1" onclick="hideEmail();">
                                            <label class="form-check-label">Doesn't have email address (Not recommended)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>SSN</label>
                                        <input class="form-control" type="text" name="ssn" id="ssn">
                                    </div>
                                    <div class="col-md-6">
                                        <label>DOB</label>
                                        <input class="form-control datepicker" type="text" name="dob" id="dob" placeholder='DD/MM/YYYY'>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone (H)</label>
                                        <input class="form-control" type="text" name="phone_home" id="phone_home">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Phone (W)</label>
                                        <input class="form-control" type="text" name="phone_work" id="phone_work">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone (M)<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="phone_mobile" id="phone_mobile">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Alt Phone</label>
                                        <input class="form-control" type="text" name="fax" id="fax">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <p class="card-description">Spouse Details</p>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="sname" id="sphone">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                        <input class="form-control" type="text" name="sphone" id="sphone">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" name="semail" id="semail">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Social</label>
                                        <input class="form-control" type="text" name="ssocial" id="ssocial">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>DOB</label>
                                        <input class="form-control datepicker" type="text" name="sdob" id="sdob" placeholder='DD/MM/YYYY'>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <?php foreach ($client_status_subscriber as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date of start</label>
                                        <input class="form-control datepicker" type="text" id="date_of_start" name="date_of_start" placeholder='DD/MM/YYYY'>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Assigned to</label>
                                        <select class="form-control" id="assigned" name="assigned">
                                            <option value="">Select One</option>
                                            <?php foreach ($get_allusers_name as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Referred by</label>
                                        <select class="form-control" id="referred" name="referred">
                                            <option value="">Select One</option>
                                            <?php foreach ($get_allaffiliate_name as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label>Portal Access (For Client Onboarding)<span class="text-danger">*</span>
                                            <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Client must have an email address for portal access and client onboarding."></i>
                                        </label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="portalAccess" name="portalAccess">
                                            <label class="custom-control-label" for="portalAccess">Off / On (Recommended)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Client Days</label>
                                        <select class="form-control" id="clientdays" name="client_days">
                                            <?php foreach ($client_days_opt as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Mailing address</label>
                                        <!-- <textarea class="form-control" id="mailing_address" name="mailing_address"></textarea> -->
                                        <input class="form-control" id="mailing_address" name="mailing_address" placeholder="Enter your address">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <p class="card-description">Address</p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input class="form-control" type="text" id="city" name="city">
                                    </div>
                                    <div class="col-md-6">
                                        <label>State</label>
                                        <input class="form-control" type="text" id="state" name="state">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Zip Code</label>
                                        <input class="form-control" type="text" id="zip_code" name="zipcode">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Country</label>
                                        <input class="form-control" type="text" id="country" name="country">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">

                                <label>Profile Image</label>

                                <div class="media align-items-center">

                                    <div class="media-left">

                                        <?php

                                        $client_image = base_url('assets/img/user.jpg');

                                        ?>

                                        <img class="rounded-circle" src="<?php echo $client_image; ?>" width="100" height="100" class="profile-img avatar-view-img" id="blah" onclick="openfilepopup();">

                                        <input type="file" name="file" id="imgupload" style="display:none" />

                                    </div>

                                    <div class="media-body">

                                        <div class="uploader">

                                            <button type="button" class="btn btn-secondary btn-sm ml-2 avatar-view-btn" onclick="openfilepopup();">Add profile picture</button>

                                            <input type="hidden" id="crop_prof_img" name="profile_img">

                                        </div>

                                        <span id="image_error" class="text-danger"></span>

                                    </div>

                                </div>

                            </div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" onclick="add_new_client();">Add Client</button>
                                <a href="<?php echo base_url('clients_list'); ?>" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1Jih1_t0oYWSky2LI9ZM399JMrjvh9o&libraries=places"></script>
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

    function hideEmail() {
        if ($('#noEmail').is(':checked')) {
            $("#email").prop('disabled', true).val(''); // Clear the email value
            $('#email').removeAttr("required").removeClass('is-invalid'); // Remove invalid class
            $('#email').next('.invalid-feedback').remove(); // Remove error message if exists
        } else {
            $("#email").prop('disabled', false);
            $('#email').attr("required", "required");
        }
    }

    function validateFieldsOnKeyup() {
        $('#first_name, #last_name, #email, #phone_mobile').on('keyup', function() {
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
            case 'phone_mobile':
                let phonePattern = /^\d{10}$/;
                if (value === "") {
                    handleFieldValidation($field, "Phone is required.");
                } else if (!phonePattern.test(value)) {
                    handleFieldValidation($field, "Please enter a valid 10-digit phone number.");
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
    }

    // Real-time field validation on keyup
    validateFieldsOnKeyup();

    function add_new_client() {
        let isValid = true;

        // Clear any previous validation states before new validation
        clearFieldValidation($('#first_name'));
        clearFieldValidation($('#last_name'));
        clearFieldValidation($('#email'));
        clearFieldValidation($('#phone_mobile'));

        let first_name = $('#first_name').val();
        let middle_name = $('#middle_name').val();
        let last_name = $('#last_name').val();
        let suffix = $('#suffix').val();
        let email = $('#email').val();
        let ssn = $('#ssn').val();
        let dob = $('#dob').val();
        let phone_home = $('#phone_home').val();
        let phone_work = $('#phone_work').val();
        let phone_mobile = $('#phone_mobile').val();
        let fax = $('#fax').val();
        let sname = $('#sname').val();
        let sphone = $('#sphone').val();
        let semail = $('#semail').val();
        let ssocial = $('#ssocial').val();
        let sdob = $('#sdob').val();
        let status = $('#status').find(":selected").val();
        let date_of_start = $('#date_of_start').val();
        let assigned = $('#assigned').find(":selected").val();
        let referred = $('#referred').val();
        let portalAccess = $('#portalAccess').is(':checked') ? '1' : '0';
        let client_days = $('#client_days').find(":selected").val();
        let mailing_address = $('#mailing_address').val();
        let city = $('#city').val();
        let state = $('#state').val();
        let zipcode = $('#zip_code').val();
        let country = $('#country').val();
        let imgupload = $("#imgupload")[0].files[0];

        if (first_name == "") {
            handleFieldValidation($('#first_name'), "First Name is required.");
            isValid = false;
        }

        if (last_name == "") {
            handleFieldValidation($('#last_name'), "Last Name is required.");
            isValid = false;
        }

        if (!$('#noEmail').is(':checked') && email == "") {
            handleFieldValidation($('#email'), "Email is required.");
            isValid = false;
        }

        if (phone_mobile == "") {
            handleFieldValidation($('#phone_mobile'), "Phone is required.");
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
            formData.append('middle_name', middle_name);
            formData.append('last_name', last_name);
            formData.append('suffix', suffix);
            formData.append('email', email);
            formData.append('ssn', ssn);
            formData.append('dob', dob);
            formData.append('phone_home', phone_home);
            formData.append('phone_work', phone_work);
            formData.append('phone_mobile', phone_mobile);
            formData.append('fax', fax);
            formData.append('sname', sname);
            formData.append('sphone', sphone);
            formData.append('semail', semail);
            formData.append('ssocial', ssocial);
            formData.append('sdob', sdob);
            formData.append('status', status);
            formData.append('date_of_start', date_of_start);
            formData.append('assigned', assigned);
            formData.append('referred', referred);
            formData.append('portalAccess', portalAccess);
            formData.append('client_days', client_days);
            formData.append('mailing_address', mailing_address);
            formData.append('city', city);
            formData.append('state', state);
            formData.append('zipcode', zipcode);
            formData.append('country', country);
            if (imgupload) {
                formData.append('imgupload', imgupload); // Only append if file is uploaded
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("add_new_client"); ?>',
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
                            window.location.href = "<?php echo base_url('clients_list') ?>";
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
    }



    $(function() {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            viewMode: 'years',
            icons: {
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
            }
        });
    });


    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function initializeAutocomplete() {
        var input = document.getElementById('mailing_address');
        var autocomplete = new google.maps.places.Autocomplete(input);


        autocomplete.setFields(['address_component', 'geometry']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            fillAddressFields(place);
        });
    }

    function fillAddressFields(place) {
        var components = place.address_components;

        // console.log(components);

        var city = '',
            state = '',
            country = '',
            zipcode = '';

        for (var i = 0; i < components.length; i++) {
            var componentType = components[i].types[0];

            // console.log(componentType);

            switch (componentType) {
                case 'locality':
                    city = components[i].long_name;
                    break;
                case 'administrative_area_level_1':
                    // state = components[i].short_name;
                    state = components[i].long_name;
                    break;
                case 'country':
                    country = components[i].long_name;
                    break;
                case 'postal_code':
                    zipcode = components[i].long_name;
                    break;
            }
        }

        document.getElementById('city').value = city;
        document.getElementById('state').value = state;
        document.getElementById('zip_code').value = zipcode;
        document.getElementById('country').value = country;
    }

    // google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
    window.addEventListener('load', initializeAutocomplete);
</script>