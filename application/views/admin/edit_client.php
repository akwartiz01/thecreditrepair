<?php
$client_status = $this->config->item('client_status');
$client_days_opt = $this->config->item('client_days_opt');

?>

<style>
.switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 25px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

input:checked+.slider {
    background-color: #4CAF50;
}

input:checked+.slider:before {
    transform: translateX(26px);
}


.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
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
            <div class="page-header">
                <div class="page-header">
                    <h1> Edit Client </h1>
                </div>
                <!--<h3 class="page-title"> Edit Client </h3>-->
                <!--<nav aria-label="breadcrumb">-->
                <!--  <ol class="breadcrumb">-->
                <!--    <li class="breadcrumb-item"><a href="#">Home</a></li>-->
                <!--    <li class="breadcrumb-item active" aria-current="page">Edit Client</li>-->
                <!--  </ol>-->
                <!--</nav>-->
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
            <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
                <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
                    <div class="swal-icon swal-icon--success"><span
                            class="swal-icon--success__line swal-icon--success__line--long"></span><span
                            class="swal-icon--success__line swal-icon--success__line--tip"></span>
                        <div class="swal-icon--success__ring"></div>
                        <div class="swal-icon--success__hide-corners"></div>
                    </div>
                    <div class="swal-title">Client Updated!</div>
                    <div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div>
                    <div class="swal-footer">
                        <div class="swal-button-container"><button
                                class="swal-button swal-button--confirm btn btn-primary"
                                onclick="closeSuccessModal();">Continue</button>
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
            <div class="card p-4">
                <div class="card-body">
                    <form class="form-sample" method="POST">
                        <input type="hidden" name="hiddenRowId" id="hiddenRowId"
                            value="<?php echo isset($resultMyClients[0]->sq_client_id) ? $resultMyClients[0]->sq_client_id : ''; ?>">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="first_name" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="<?php echo isset($resultMyClients[0]->sq_first_name) ? $resultMyClients[0]->sq_first_name : ''; ?>"
                                    required>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name"
                                    value="<?php echo isset($resultMyClients[0]->sq_middle_name) ? $resultMyClients[0]->sq_middle_name : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="last_name" class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="<?php echo isset($resultMyClients[0]->sq_last_name) ? $resultMyClients[0]->sq_last_name : ''; ?>"
                                    required>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="suffix" class="form-label">Suffix</label>
                                <input type="text" class="form-control" id="suffix" name="suffix"
                                    value="<?php echo isset($resultMyClients[0]->sq_suffix) ? $resultMyClients[0]->sq_suffix : ''; ?>">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="<?php echo isset($resultMyClients[0]->sq_email) ? $resultMyClients[0]->sq_email : ''; ?>"
                                    required>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3 d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input ml-2" name="noEmail" id="noEmail"
                                        value="1" onclick="hideEmail();">
                                    <label class="form-check-label ms-2" for="noEmail">Client has no email</label>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="ssn" class="form-label">SSN</label>
                                <input type="text" class="form-control" id="ssn" name="ssn"
                                    value="<?php echo isset($resultMyClients[0]->sq_ssn) ? $resultMyClients[0]->sq_ssn : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="text" class="form-control datepicker" id="dob" name="dob"
                                    value="<?php echo (isset($resultMyClients[0]->sq_dob) && $resultMyClients[0]->sq_dob != '0000-00-00') ? date('m-d-Y', strtotime($resultMyClients[0]->sq_dob)) : ''; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="phone_home" class="form-label">Phone (H)</label>
                                <input type="text" class="form-control" id="phone_home" name="phone_home"
                                    value="<?php echo isset($resultMyClients[0]->sq_phone_home) ? $resultMyClients[0]->sq_phone_home : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="phone_work" class="form-label">Phone (W)</label>
                                <input type="text" class="form-control" id="phone_work" name="phone_work"
                                    value="<?php echo isset($resultMyClients[0]->sq_phone_work) ? $resultMyClients[0]->sq_phone_work : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="phone_mobile" class="form-label">Phone (M)</label>
                                <input type="text" class="form-control" id="phone_mobile" name="phone_mobile"
                                    value="<?php echo isset($resultMyClients[0]->sq_phone_mobile) ? $resultMyClients[0]->sq_phone_mobile : ''; ?>"
                                    >
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="fax" class="form-label">Alt Phone</label>
                                <input type="text" class="form-control" id="fax" name="fax"
                                    value="<?php echo isset($resultMyClients[0]->sq_fax) ? $resultMyClients[0]->sq_fax : ''; ?>"
                                    minlength="10">
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-12 mb-3">
                                <label for="city" class="form-label">Memo</label>
                                <input type="text" class="form-control" id="memo" name="memo"
                                    value="<?php echo isset($resultMyClients[0]->memo) ? $resultMyClients[0]->memo : ''; ?>">
                            </div>
                       </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    value="<?php echo isset($resultMyClients[0]->sq_city) ? $resultMyClients[0]->sq_city : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state"
                                    value="<?php echo isset($resultMyClients[0]->sq_state) ? $resultMyClients[0]->sq_state : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="zipcode" class="form-label">Zip code</label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode"
                                    value="<?php echo isset($resultMyClients[0]->sq_zipcode) ? $resultMyClients[0]->sq_zipcode : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    value="<?php echo isset($resultMyClients[0]->sq_country) ? $resultMyClients[0]->sq_country : ''; ?>">
                            </div>
                        </div>


                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <?php foreach ($client_status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"
                                        <?php if ($resultMyClients[0]->sq_status == $key) echo 'selected'; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="date_of_start" class="form-label">Date of start</label>
                                <input type="text" class="form-control datepicker" id="date_of_start"
                                    name="date_of_start"
                                    value="<?php echo isset($resultMyClients[0]->sq_date_of_start) ? date('m-d-Y', strtotime($resultMyClients[0]->sq_date_of_start)) : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="assigned" class="form-label">Assigned to</label>
                                <select class="form-control" id="assigned" name="assigned">
                                    <option value="">Select One</option>
                                    <?php foreach ($get_allusers_name as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"
                                        <?php if ($resultMyClients[0]->sq_assigned_to == $key) echo 'selected'; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="referred" class="form-label">Referred by</label>
                                <select class="form-control" id="referred" name="referred">
                                    <option value="">Select One</option>
                                    <?php foreach ($get_allaffiliate_name as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"
                                        <?php if ($resultMyClients[0]->sq_referred_by == $key) echo 'selected'; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="row">

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label class="form-label d-block">Portal Access (For Client Onboarding)</label>
                                <div style="margin-top: 8px;">
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="portalAccess"
                                            name="portalAccess"
                                            <?php echo ($resultMyClients[0]->sq_portal_access == 1) ? 'checked' : ''; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="clientdays" class="form-label">Client Days</label>
                                <select class="form-control" id="clientdays" name="client_days">
                                    <?php foreach ($client_days_opt as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"
                                        <?php if ($resultMyClients[0]->client_days == $key) echo 'selected'; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <label for="mailing_address" class="form-label">Mailing address</label>
                                <input class="form-control" id="mailing_address" name="mailing_address"
                                    value="<?php echo isset($resultMyClients[0]->sq_mailing_address) ? $resultMyClients[0]->sq_mailing_address : ''; ?>"
                                    placeholder="Enter your address">
                            </div>

                        </div>



                        <hr>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="previousMailing"
                                                id="previousMailing" onclick="displayPreviousMailing();"> <i
                                                class="input-helper"></i></label>
                                    </div>
                                </div>
                                <label class="col-sm-9 col-form-label">Previous mailing address (only if at current
                                    mailing address for less than 2 years) </label>
                            </div>

                        </div>

                        <div id="displayPreviousMailing" style="display: none;">
                            <div class="row">
                                <div class="col-12">
                                    <label for="p_mailing_address" class="form-label">Previous Mailing address</label>
                                    <input type="text" class="form-control" id="p_mailing_address"
                                        name="p_mailing_address"
                                        value="<?php echo isset($resultMyClients[0]->sq_p_mailing_address) ? $resultMyClients[0]->sq_p_mailing_address : ''; ?>">
                                </div>
                            </div>

                            <hr>
                            <p class="card-description">Previous Address </p>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_city" class="form-label">Previous City</label>
                                    <input type="text" class="form-control" id="p_city" name="p_city"
                                        value="<?php echo isset($resultMyClients[0]->sq_p_city) ? $resultMyClients[0]->sq_p_city : ''; ?>">
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_state" class="form-label">Previous State</label>
                                    <input type="text" class="form-control" id="p_state" name="p_state"
                                        value="<?php echo isset($resultMyClients[0]->sq_p_state) ? $resultMyClients[0]->sq_p_state : ''; ?>">
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_zipcode" class="form-label">Previous Zip code</label>
                                    <input type="text" class="form-control" id="p_zipcode" name="p_zipcode"
                                        value="<?php echo isset($resultMyClients[0]->sq_p_zipcode) ? $resultMyClients[0]->sq_p_zipcode : ''; ?>">
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_country" class="form-label">Previous Country</label>
                                    <input type="text" class="form-control" id="p_country" name="p_country"
                                        value="<?php echo isset($resultMyClients[0]->sq_p_country) ? $resultMyClients[0]->sq_p_country : ''; ?>">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-gradient-secondary btn-icon-text mr-2" id="welcommail">
                                    Welcom Mail Send
                                </button>
                                <button type="submit" class="btn btn-gradient-primary btn-icon-text" id="btn_client"
                                    name="btn_client">
                                    Update
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->

<script type="text/javascript">
function displayPreviousMailing() {
    if ($('#previousMailing').is(':checked')) {
        $('#displayPreviousMailing').css('display', '');
    } else {
        $('#displayPreviousMailing').css('display', 'none');
    }

}

function hideEmail() {

    if ($('#noEmail').is(':checked')) {
        $("#email").prop('disabled', true);
        $('#email').removeAttr("required");
    } else {
        $("#email").prop('disabled', false);
        $('#email').attr("required", "required");
    }


}
</script>
<script type="text/javascript">
function closeSuccessModal() {
    $('#pDsuccess').css('display', 'none');
    $('#pDMsuccess').css('display', 'none');

}
  $('#welcommail').on('click', function () {
        $('#ajaxLoader').show()
    $.ajax({
      url: '<?= base_url("sendWelcomeMail"); ?>',
      type: 'POST',
      data: {
        id: '<?= $resultMyClients[0]->sq_client_id ?>',
        type: 'client'
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

</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1Jih1_t0oYWSky2LI9ZM399JMrjvh9o&libraries=places">
</script>

<script>
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
    document.getElementById('zipcode').value = zipcode;
    document.getElementById('country').value = country;
}

google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
</script>