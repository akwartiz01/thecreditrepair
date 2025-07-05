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
<div class="container-fluid page-body-wrapper">
    <div class="main-panel pnel">
        <div class="content-wrapper">
            <div class="page-header">
                <h1>Add New Client</h1>
                <!--<nav aria-label="breadcrumb">-->
                <!--  <ol class="breadcrumb">-->
                <!--    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>-->
                <!--    <li class="breadcrumb-item active" aria-current="page">Add New Client</li>-->
                <!--  </ol>-->
                <!--</nav>-->
            </div>
            <div class="">
                <?php if ($this->session->flashdata('success')) { ?>
                <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
                    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
                        <div class="swal-icon swal-icon--success"><span
                                class="swal-icon--success__line swal-icon--success__line--long"></span><span
                                class="swal-icon--success__line swal-icon--success__line--tip"></span>
                            <div class="swal-icon--success__ring"></div>
                            <div class="swal-icon--success__hide-corners"></div>
                        </div>
                        <div class="swal-title" style="">Client added!</div>
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


                <div class="col-md-6">
                    <?php if (!isset($clientspouse)) { ?>



                    <?php } else { ?>

                    <h4 class="task-title2"><?php echo isset($clientspouse) ? $clientspouse[0]->sname : ''; ?> </h4>
                    <hr>
                    <p><?php echo isset($clientspouse) ? $clientspouse[0]->sphone : ''; ?></p>
                    <p><a
                            href="mailto:<?php echo isset($clientspouse) ? $clientspouse[0]->semail : ''; ?>"><?php echo isset($clientspouse) ? $clientspouse[0]->semail : ''; ?></a>
                    </p>
                    <p><?php echo isset($clientspouse) ? $clientspouse[0]->saddress : ''; ?></p>

                    <p>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sent Email</button>
                            <div class="dropdown-menu" x-placement="bottom-start">
                                <a class="dropdown-item"
                                    onclick="sendWelcomeemail('<?php echo $fetchClientinfo[0]->sq_email; ?>','<?php echo $fetchClientinfo[0]->sq_client_id; ?>');">Welcome
                                    Email</a>
                                <!-- <a class="dropdown-item" href="#">Something else here</a>
                                <a class="dropdown-item" href="#">Demo link</a> -->
                            </div>

                        </div>
                    </div>
                    </p>

                    <?php } ?>
                </div>
            </div>

            <div class="card p-4">
                <form id="clientForm" class="form-sample" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="first_name">First Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="Enter first name" required>
                                    <span class="text-danger" id="first_name_error"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                        placeholder="Enter middle name">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Enter last name" required>
                                    <span class="text-danger" id="last_name_error"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix"
                                        placeholder="e.g., Jr., Sr., III">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email + Checkbox -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter email" required>
                                    <span class="text-danger" id="email_error"></span>

                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input ml-2" name="noEmail" id="noEmail"
                                            value="1" onclick="hideEmail();">
                                        <label class="form-check-label" for="noEmail">Client has no email</label>
                                    </div>
                                </div>
                            </div>

                            <!-- SSN -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="ssn">SSN</label>
                                    <input type="text" class="form-control" id="ssn" name="ssn" placeholder="Enter SSN">
                                </div>
                            </div>

                            <!-- DOB -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="text" class="form-control datepicker" id="dob" name="dob"
                                        placeholder="MM/DD/YYYY">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="phone">Phone (H)</label>
                                    <input type="text" class="form-control" id="phone_home" name="phone_home"
                                        placeholder="Enter work home">
                                </div>
                            </div>
                            <!-- Phone (Work) -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="phone_work">Phone (W)</label>
                                    <input type="text" class="form-control" id="phone_work" name="phone_work"
                                        placeholder="Enter work phone">
                                </div>
                            </div>

                            <!-- Phone (Mobile) -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="phone_mobile">Phone (M)</label>
                                    <input type="text" class="form-control" id="phone_mobile" name="phone_mobile"
                                        placeholder="Enter mobile number" required>
                                </div>
                            </div>

                            <!-- Alternate Phone -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="fax">Alt Phone</label>
                                    <input type="text" class="form-control" id="fax" name="fax"
                                        placeholder="Enter alternate phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- City -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Enter city">
                                </div>
                            </div>

                            <!-- State -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="Enter state">
                                </div>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code</label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                                        placeholder="Enter zip code">
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        placeholder="Enter country">
                                </div>
                            </div>
                        </div>


                        <hr>
                        <p class="card-description"> Spouse Detalis</p>
                        <div class="row">
                            <!-- Name -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="sname">Name</label>
                                    <input type="text" class="form-control" id="sname" name="sname"
                                        placeholder="Enter name">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="sphone">Phone</label>
                                    <input type="text" class="form-control" id="sphone" name="sphone"
                                        placeholder="Enter phone">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="semail">Email</label>
                                    <input type="text" class="form-control" id="semail" name="semail"
                                        placeholder="Enter email">
                                </div>
                            </div>

                            <!-- Social -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="ssocial">Social</label>
                                    <input type="text" class="form-control" id="ssocial" name="ssocial"
                                        placeholder="Enter social info">
                                </div>
                            </div>

                            <!-- Sdob -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="sdob">DOB</label>
                                    <input type="text" class="form-control" id="sdob" name="sdob"
                                        placeholder="MM/DD/YYYY">
                                </div>
                            </div>
                        </div>


                        <hr>
                        <div class="row">
                            <!-- Status -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <?php foreach ($client_status as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Date of Start -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="date_of_start">Date of Start</label>
                                    <input type="text" class="form-control datepicker" id="date_of_start"
                                        name="date_of_start" value="<?php echo date('m/d/Y'); ?>">
                                </div>
                            </div>

                            <!-- Assigned to -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="assigned">Assigned to</label>
                                    <select class="form-control" id="assigned" name="assigned">
                                        <option value="">Select One</option>
                                        <?php foreach ($get_allusers_name as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Referred by -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="referred">Referred by</label>
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


                        <div class="row">
                            <!-- Client Days -->
                            <div class="col-12 col-sm-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="clientdays">Client Days</label>
                                    <select class="form-control" id="clientdays" name="client_days">
                                        <?php foreach ($client_days_opt as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Mailing Address -->
                            <div class="col-12 col-sm-12 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="mailing_address">Mailing Address</label>
                                    <input type="text" class="form-control" id="mailing_address" name="mailing_address"
                                        placeholder="Enter your address">
                                </div>
                            </div>
                            <!-- Portal Access (Client Onboarding) -->
                            <div class="col-12 col-sm-6 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="portalAccess">Portal Access (For Client Onboarding)</label><br>
                                    <label class="switch">
                                        <input type="checkbox" id="portalAccess" name="portalAccess" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">

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
                        </div>

                        <div id="displayPreviousMailing" style="display: none;">
                            <div class="row">
                                <div class="col-12">
                                    <label for="p_mailing_address" class="form-label">Previous Mailing address</label>
                                    <input type="text" class="form-control" id="p_mailing_address"
                                        name="p_mailing_address">
                                </div>
                            </div>

                            <hr>
                            <p class="card-description">Previous Address </p>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_city" class="form-label">Previous City</label>
                                    <input type="text" class="form-control" id="p_city" name="p_city">
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_state" class="form-label">Previous State</label>
                                    <input type="text" class="form-control" id="p_state" name="p_state">
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_zipcode" class="form-label">Previous Zip code</label>
                                    <input type="text" class="form-control" id="p_zipcode" name="p_zipcode">
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <label for="p_country" class="form-label">Previous Country</label>
                                    <input type="text" class="form-control" id="p_country" name="p_country">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-gradient-primary btn-icon-text" id="btn_client"
                                    name="btn_client">
                                    Submit
                                </button>
                            </div>
                        </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

function closeSuccessModal() {
    $('#pDsuccess').css('display', 'none');
    $('#pDMsuccess').css('display', 'none');


}

function addClientScore() {

    var clientID = '<?php echo $fetchClientinfo[0]->sq_client_id ?? ''; ?>';
    var dateadd = $('#addeditscore input[name="date"]').val();
    var equfaxScore = $('#addeditscore input[name="equfaxScore"]').val();
    var experianScore = $('#addeditscore input[name="experianScore"]').val();
    var TUScore = $('#addeditscore input[name="TUScore"]').val();

    if (dateadd && equfaxScore && experianScore && TUScore != '') {

        $.ajax({

            type: 'POST',
            url: '<?php echo base_url() . "Dashboard/addScore"; ?>',
            data: {
                'clientID': clientID,
                'dateadd': dateadd,
                'equfaxScore': equfaxScore,
                'experianScore': experianScore,
                'TUScore': TUScore
            },
            success: function(response) {

                if (response == '1') {

                    var succesMsg =
                        '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Client Score</div><div class="swal-text" style="">Client score added successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Continue</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                    $('#msgAppend11task').after(succesMsg);
                }
            }
        });
    }
}

function saveSpouseinfo(that) {

    var formval = $('#spouseform');

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "Dashboard/spousedatasave"; ?>',
        data: formval.serialize(),
        success: function(response) {

            var data = JSON.parse(response);
            if (data.code == '1') {

                var succesMsg =
                    '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Spouse Data!</div><div class="swal-text" style="">' +
                    data.msg +
                    '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNewtask();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                $('#msgAppend11task').after(succesMsg);
            }
        }
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1Jih1_t0oYWSky2LI9ZM399JMrjvh9o&libraries=places">
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

// $("#btn_client").click(function(event) {
//   event.preventDefault();

//   let email = $('#email').val();

//   if (email !== '') {
//     let formData = new FormData();
//     formData.append('email', email);

//     $.ajax({
//       type: 'POST',
//       url: '<?php echo base_url("check_client"); ?>',
//       data: formData,
//       contentType: false,
//       processData: false,
//       success: function(response) {
//         let res = JSON.parse(response);

//         if (res.status === 'error') {
//           Swal.fire({
//             title: 'Error',
//             text: res.message,
//             icon: 'error',
//             confirmButtonText: 'Ok'
//           });
//         } else {
//           // Proceed to submit the form after successful validation
//           $("#clientForm")[0].submit();
//         }
//       }
//     });
//   } else {
//     Swal.fire({
//       title: 'Error',
//       text: 'Email is required',
//       icon: 'error',
//       confirmButtonText: 'Ok'
//     });
//   }
// });
</script>

<script>
$("#btn_client").click(function(event) {
    event.preventDefault();
console.log("ff");
    // Clear previous error messages
    $('.text-danger').text('');

    let firstName = $('#first_name').val().trim();
    let lastName = $('#last_name').val().trim();
    let email = $('#email').val().trim();
        let noEmail = $('#noEmail').val();
    // let phone = $('#phone_mobile').val().trim();

    let isValid = true;

    if (firstName === '') {
        $('#first_name_error').text('First name is required');
        isValid = false;
    }

    if (lastName === '') {
        $('#last_name_error').text('Last name is required');
        isValid = false;
    }

    if (email === '' && !$('#noEmail').is(':checked')) {
        console.log('f');
        $('#email_error').text('Email is required');
        isValid = false;
    }

    // if (phone === '') {
    //   $('#phone_mobile_error').text('Mobile phone is required');
    //   isValid = false;
    // }

    if (!isValid) {

        return;
    }

    let formData = new FormData();
    formData.append('email', email);
     formData.append('noEmail', noEmail);

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url("check_client"); ?>',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            let res = JSON.parse(response);

            if (res.status === 'error') {
                $('#email_error').text(res.message);
            } else {
                $("#clientForm")[0].submit();
            }
        }
    });
});
</script>