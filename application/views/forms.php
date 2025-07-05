<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residential Tenancies Regulations 2021</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3fe;
        }

        .container {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            /* background-color: #f9f9f9; */
            background-color: #fff;
        }

        .header-title {
            text-align: center;
            font-style: italic;
            font-size: 16px;
            color: #2c5b8f;
        }

        .header-main {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #2c5b8f;
        }

        .description {
            text-align: justify;
            font-size: 14px;
            margin-top: 10px;
        }

        .section-header {
            background-color: #2c5b8f;
            color: white;
            padding: 10px;
            font-weight: bold;
            margin-top: 20px;
        }

        .form-group {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .column {
            flex: 1;
            min-width: 250px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .checkbox input {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="header-title">Residential Tenancies Regulations 2021</p>
        <p class="header-main">Electrical Safety Check – Report</p>
        <p class="description">
            This electrical safety check is for electrical safety purposes only and is in accordance with
            the requirements of the <i>Residential Tenancies Regulations 2021</i> and is prepared in
            accordance with section 2 of the Australian/New Zealand Standard <i>AS/NZS 3019, Electrical
                installations—Periodic verification</i> to confirm that the installation is not damaged or has not
            deteriorated so as to impair electrical safety; and to identify installation defects and
            departures from the requirements that may give rise to danger.
        </p>

        <form id="residential-form">

            <div class="form-group">
                <div class="column">
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="main-switchboard"><label for="main-switchboard" class="form-label">Main switchboard</label>
                    </div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="main-earthing"><label for="main-earthing" class="form-label">Main earthing system</label></div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input" id="kitchen"><label
                            for="kitchen" class="form-label">Kitchen</label></div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="bathroom-main"><label for="bathroom-main" class="form-label">Bathroom (main)</label></div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="other-bathrooms"><label for="other-bathrooms" class="form-label">Other
                            bathrooms/ensuites</label></div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="bedroom-main"><label for="bedroom-main" class="form-label">Bedroom (main)</label></div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="other-bedrooms"><label for="other-bedrooms" class="form-label">Other bedrooms</label></div>
                    <div class="checkbox"><input type="checkbox" name="b_section[]" class="form-check-input"
                            id="living-room"><label for="living-room" class="form-label">Living room</label></div>
                </div>
                <div class="column">
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="consumers-mains"><label for="consumers-mains" class="form-label">Consumers mains</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="switchboards"><label for="switchboards" class="form-label">Switchboards</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="earth-electrode"><label for="earth-electrode" class="form-label">Exposed earth electrode</label>
                    </div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="water-pipe-bond"><label for="water-pipe-bond" class="form-label">Metallic water pipe
                            bond</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input" id="rcds"><label
                            for="rcds" class="form-label">RCDs (Safety switches)</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="circuit-protection"><label for="circuit-protection" class="form-label">Circuit protection
                            (circuit breakers / fuses)</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="socket-outlets"><label for="socket-outlets" class="form-label">Socket-outlets</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="light-fittings"><label for="light-fittings" class="form-label">Light fittings</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="electric-water-heater"><label for="electric-water-heater" class="form-label">Electric water
                            heater</label></div>
                    <div class="checkbox"><input type="checkbox" name="c_section[]" class="form-check-input"
                            id="air-conditioners"><label for="air-conditioners" class="form-label">Air conditioners</label>
                    </div>
                </div>

            </div>
            <div class="column">
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input"
                        id="consumers-mains-test"><label for="consumers-mains-test" class="form-label">Consumers mains</label>
                </div>
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input"
                        id="circuit-protection-test"><label for="circuit-protection-test" class="form-label">Circuit protection
                        (circuit breakers / fuses)</label></div>
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input" id="rcds-test"><label
                        for="rcds-test" class="form-label">RCDs (Safety switches)</label></div>
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input"
                        id="socket-outlets-test"><label for="socket-outlets-test" class="form-label">Socket-outlets</label>
                </div>
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input"
                        id="circuit-protection-test-2"><label for="circuit-protection-test-2" class="form-label">Circuit
                        protection (circuit breakers / fuses)</label></div>
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input"
                        id="socket-outlets-test-2"><label for="socket-outlets-test-2" class="form-label">Socket-outlets</label>
                </div>
                <div class="checkbox"><input type="checkbox" name="d_section[]" class="form-check-input"
                        id="light-fittings-test"><label for="light-fittings-test" class="form-label">Light fittings</label>
                </div>
            </div>

            <div class="button-group mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <button id="downloadBtn" class="btn btn-primary">Download PDF</button>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1Jih1_t0oYWSky2LI9ZM399JMrjvh9o&libraries=places"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $("#downloadBtn").click(function() {
            window.location.href = "<?= base_url('Forms/download') ?>";
        });
    </script>

    <script>
        $(document).ready(function() {

            $("#residential-form").on("submit", function(e) {
                e.preventDefault();

                let formData = $(this).serializeArray();
                let b_sectionValues = [];
                let c_sectionValues = [];
                let d_sectionValues = [];

                $("input[name='b_section[]']:checked").each(function() {
                    b_sectionValues.push($(this).val());
                });
                $("input[name='c_section[]']:checked").each(function() {
                    c_sectionValues.push($(this).val());
                });
                $("input[name='d_section[]']:checked").each(function() {
                    d_sectionValues.push($(this).val());
                });

                let data = {
                    email: $("input[name='email']").val(),
                    name: $("input[name='name']").val(),
                    address: $("input[name='address']").val(),
                    city: $("input[name='city']").val(),
                    state: $("input[name='state']").val(),
                    country: $("input[name='country']").val(),
                    b_section: JSON.stringify(b_sectionValues),
                    c_section: JSON.stringify(c_sectionValues),
                    d_section: JSON.stringify(d_sectionValues)
                };

                $.ajax({
                    url: "<?= base_url('submit-form') ?>",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            alert("Form submitted successfully!");
                            location.reload();
                        } else {
                            alert("Form submission failed.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                        alert("Something went wrong. Please try again.");
                    }
                });
            });


            $("#downloadBtn").click(function() {
                window.location.href = "<?= base_url('Forms/download') ?>";
            });
        });
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
            // document.getElementById('zip_code').value = zipcode;
            document.getElementById('country').value = country;
        }

        // google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
        window.addEventListener('load', initializeAutocomplete);
    </script>
</body>

</html>