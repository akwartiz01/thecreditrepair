<?php $time_zone = $this->config->item('time_zone'); ?>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<style>
    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #dee2e6;
    }


    /* Loader CSS s*/
    #loader {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }


    /* Loader CSS e*/
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <?php
$subscriber_id = $this->session->userdata('user_id');
$this->db->where('sq_u_id_subscriber', $subscriber_id);
$payment_details = $this->db->get('sq_subscription_payment_details')->row_array();
if (!empty($payment_details['subscription_end_date'])) {
    $end_date = strtotime($payment_details['subscription_end_date']);
    $today = strtotime(date('d-m-Y'));

    if ($end_date < $today) {
        // Subscription is expired
        echo '<div class="alert alert-danger">Your subscription has expired.</div>';
    }
}
?>
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">My Company</h3>
                </div>
                <div class="col-auto text-right">
                    <a href="" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>
                    <a class="btn btn-white filter-btn mr-2" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                    <a href="" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-12">
                                <div class="tab-content tab-content-vertical">
                                    <div class="tab-pane fade show active" id="home-2" role="tabpanel"
                                        aria-labelledby="home-tab">

                                        <form class="form-sample" action="" method="POST">
                                            <input type="hidden" name="sq_company_id" id="sq_company_id" value="<?php echo isset($resultMyComp[0]->sq_company_id) ? $resultMyComp[0]->sq_company_id : ''; ?>">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Company name</label>
                                                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo isset($resultMyComp[0]->sq_company_name) ? $resultMyComp[0]->sq_company_name : ''; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Website URL</label>
                                                        <input type="text" class="form-control" id="website_url" name="website_url" value="<?php echo isset($resultMyComp[0]->sq_company_url) ? $resultMyComp[0]->sq_company_url : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Address</label>
                                                        <input class="form-control" id="address" name="address" value="<?php echo isset($resultMyComp[0]->sq_company_address) ? $resultMyComp[0]->sq_company_address : ''; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>City</label>
                                                        <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($resultMyComp[0]->sq_company_city) ? $resultMyComp[0]->sq_company_city : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>State</label>
                                                        <input type="text" class="form-control" id="state" name="state" value="<?php echo isset($resultMyComp[0]->sq_company_state) ? $resultMyComp[0]->sq_company_state : ''; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Zip</label>
                                                        <input type="text" class="form-control zip" id="zip" name="zip" value="<?php echo isset($resultMyComp[0]->sq_company_zip) ? $resultMyComp[0]->sq_company_zip : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Country</label>
                                                        <input type="text" class="form-control" id="country" name="country" value="United States" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Time Zone</label>
                                                        <select id="time_zone" name="time_zone" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <optgroup label="United States">
                                                                <?php foreach ($time_zone as $key => $timeZone) {
                                                                    if ($resultMyComp[0]->sq_company_time_zone == $key) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                    <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $timeZone; ?></option>
                                                                <?php } ?>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Phone</label>
                                                        <input type="text" class="form-control phone" id="phone" name="phone" value="<?php echo isset($resultMyComp[0]->sq_company_contact_no) ? $resultMyComp[0]->sq_company_contact_no : ''; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Fax</label>
                                                        <input type="text" class="form-control fax" id="fax" name="fax" value="<?php echo isset($resultMyComp[0]->sq_company_fax) ? $resultMyComp[0]->sq_company_fax : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>
                                            <p>By default, automated notifications are sent from the account
                                                holder's name and email address. Or you may designate a different
                                                name (or a company name) and email for all automated notifications
                                                sent.</p>
                                            <hr>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Sender Name</label>
                                                        <input type="text" class="form-control" id="sender_name" name="sender_name" value="<?php echo isset($resultMyComp[0]->sq_company_sender_name) ? $resultMyComp[0]->sq_company_sender_name : ''; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Sender Email </label>
                                                        <input type="email" class="form-control" id="sender_email" name="sender_email" value="<?php echo isset($resultMyComp[0]->sq_company_sender_email) ? $resultMyComp[0]->sq_company_sender_email : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Name/company that your client invoices should be payable to</label>
                                                        <input type="text" class="form-control" id="payable_company" name="payable_company" value="<?php echo isset($resultMyComp[0]->sq_company_payable_company) ? $resultMyComp[0]->sq_company_payable_company : ''; ?>">
                                                    </div>

                                                </div>
                                            </div>


                                            <?php //if (check_permisions("company", "edit") == 1 || check_permisions("company", "add") == 1) { 
                                            ?>
                                            <button type="button" class="btn btn-primary btn-icon-text add-new" name="addCompanyButton" id="addCompanyButton" onclick="add_company();">Submit </button>
                                            <?php //} 
                                            ?>


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
</div>

<div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1Jih1_t0oYWSky2LI9ZM399JMrjvh9o&libraries=places"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#clients_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    function validateFieldsOnKeyup() {
        $('#company_name, #sender_name, #sender_email, #phone').on('keyup', function() {
            validateField($(this));
        });
    }

    function validateField($field) {
        let id = $field.attr('id');
        let value = $field.val();

        switch (id) {
            case 'company_name':
                if (value === "") {
                    handleFieldValidation($field, "Company Name is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'sender_name':
                if (value === "") {
                    handleFieldValidation($field, "Sender Name is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'sender_email':
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value === "") {
                    handleFieldValidation($field, "Sender Email is required.");
                } else if (!emailPattern.test(value)) {
                    handleFieldValidation($field, "Please enter a valid Email address.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'phone':
                let phonePattern = /^\d{10}$/;
                if (value === "") {
                    handleFieldValidation($field, "Phone Number is required.");
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

    function add_company() {
        let isValid = true;

        // Clear any previous validation states before new validation
        clearFieldValidation($('#company_name'));
        clearFieldValidation($('#phone'));
        clearFieldValidation($('#sender_name'));
        clearFieldValidation($('#sender_email'));
        clearFieldValidation($('#payable_company'));

        let sq_company_id = $('#sq_company_id').val();

        let company_name = $('#company_name').val();
        let website_url = $('#website_url').val();
        let address = $('#address').val();
        let city = $('#city').val();
        let state = $('#state').val();
        let zip = $('#zip').val();
        let country = $('#country').val();
        let time_zone = $('#time_zone').find(":selected").val();
        let fax = $('#fax').val();
        let phone = $('#phone').val();
        let sender_name = $('#sender_name').val();
        let sender_email = $('#sender_email').val();
        let payable_company = $('#payable_company').val();

        if (company_name == "") {
            handleFieldValidation($('#company_name'), "Company Name is required.");
            isValid = false;
        }

        if (phone == "") {
            handleFieldValidation($('#phone'), "Phone Number is required.");
            isValid = false;
        }


        if (sender_name == "") {
            handleFieldValidation($('#sender_name'), "Sender Name is required.");
            isValid = false;
        }

        if (sender_email == "") {
            handleFieldValidation($('#sender_email'), "Sender Email is required.");
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
            formData.append('sq_company_id', sq_company_id);
            formData.append('company_name', company_name);
            formData.append('website_url', website_url);
            formData.append('address', address);
            formData.append('city', city);
            formData.append('state', state);
            formData.append('zip', zip);
            formData.append('country', country);
            formData.append('time_zone', time_zone);
            formData.append('fax', fax);
            formData.append('phone', phone);
            formData.append('sender_name', sender_name);
            formData.append('sender_email', sender_email);
            formData.append('payable_company', payable_company);


            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("subscriber/add_company"); ?>',
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
                            window.location.href = "<?php echo base_url('subscriber/company') ?>";
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
</script>
<script>
    function initializeAutocomplete() {
        var input = document.getElementById('address');
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
        document.getElementById('zip').value = zipcode;
        // document.getElementById('country').value = country;
    }

    // google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
    window.addEventListener('load', initializeAutocomplete);
</script>