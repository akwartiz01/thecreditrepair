<?php
$us_states = $this->config->item('us_states');

$name = trim(($client[0]->sq_first_name ?? '') . ' ' . ($client[0]->sq_last_name ?? ''));

?>

<style>
  .mce-notification {
    display: none;
  }

  .form_error {
    color: red;
    font-weight: bold;
  }

  legend {
    padding: 5px 20px;
    font-size: 20px;
    font-weight: bold;
  }

  .placeholder_section .col-md-6 {
    font-size: 13px;
    line-height: 20px;
  }

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

  /* errors css s  */
  .is-invalid {
    border-color: #dc3545;
  }

  .invalid-feedback {
    color: #dc3545;
    display: block;
  }

  /* errors css e */


  /* Swal css s */

  .swal2-modal .swal2-icon,
  .swal2-modal .swal2-success-ring {
    margin-top: 0 !important;
    margin-bottom: 0px !important;
  }

  /* Swal css e */

  .form-control {
    color: black !important;
  }

  input[type="tel"]::placeholder {
    color: black;
  }

  input[type="text"]::placeholder {
    color: black;
  }

  .form-sample .form-group.row {
    margin-bottom: 1.5rem !important;
  }

  select.is-invalid {
    outline: 1px solid #dc3545 !important;
  }

  .cloudmailAddress {
    font-weight: 700 !important;
    font-size: 15px !important;
  }

  #envelope_address {
    border: 1px solid #d0d0d0 !important;
    padding: 15px 0px 15px 0px !important;
    margin: auto !important;
    border-radius: 10px !important;
  }

  .envelopeAddress {
    display: none;
  }
</style>

<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: '#contentTextarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    document_base_url: '<?php echo base_url(); ?>',
    relative_urls: false,
    remove_script_host: false,
  });
</script>

<div id="loader">
  <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>

<div class="container-fluid page-body-wrapper">
  <div class="main-panel pnel">
    <div class="content-wrapper" style="width: 60%;">
      <div class="page-header">
        <h3 class="page-title"> Dispute Wizard (<?php echo $name; ?>) </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dispute Wizard</li>
          </ol>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">
          <form class="form-sample" method="POST">
            <div class="form-group row masked">
              <div class="col-md-6">
                <label>Category<span class="text-danger">*</span></label>
                <select class="form-control" name="category" id="category" required>
                  <option value="0">Select Category</option>
                  <?php foreach ($templates_category as $category) { ?>
                    <option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
                  <?php } ?>
                </select>

              </div>

              <div class="col-md-6">
                <label>Sub-Category<span class="text-danger">*</span></label>
                <select class="form-control" name="subcategory" id="subcategory" required>
                  <option value="0">Select Sub-Category</option>
                </select>

              </div>
            </div>

            <div class="form-group row masked">
              <div class="col-md-6">
                <label>Letter Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="letter_name" id="letter_name" placeholder="Enter letter name">

              </div>

              <div class="col-md-6">
                <label>Client<span class="text-danger">*</span></label>
                <select class="form-control" name="clients" id="clients" required disabled>
                  <option value="<?php echo $client[0]->sq_client_id; ?>" selected readonly><?php echo $name; ?></option>

                </select>

              </div>
            </div>


            <hr class="mb-4 masked">
            <p class="card-description masked"> To Address </p>

            <div class="form-group row masked">
              <div class="col-md-6">
                <label>Select Credit Bureau</label>
                <select class="form-control" id="credit_bureau" onchange="fillDetails()">
                  <option value="">Select Credit Bureau</option>
                  <option value="experian"
                    data-name="Experian"
                    data-address="P.O. Box 4500"
                    data-phone="1-888-397-3742"
                    data-city="Allen"
                    data-state="TX"
                    data-zip="75013">Experian - P.O. Box 4500, Allen, TX 75013</option>
                  <option value="transunion"
                    data-name="TransUnion"
                    data-address="P.O. Box 2000"
                    data-phone="1-800-916-8800"
                    data-city="Chester"
                    data-state="PA"
                    data-zip="19016">TransUnion - P.O. Box 2000, Chester, PA 19016</option>
                  <option value="equifax"
                    data-name="Equifax"
                    data-address="P.O. Box 740241"
                    data-phone="1-800-685-1111"
                    data-city="Atlanta"
                    data-state="GA"
                    data-zip="30374">Equifax - P.O. Box 740241, Atlanta, GA 30374</option>
                </select>
              </div>
            </div>


            <div class="form-group row masked">
              <div class="col-md-6">
                <label>Company Name<span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" placeholder="Enter a name" class="form-control" value="" />

              </div>

              <div class="col-md-6">
                <label>Address<span class="text-danger">*</span></label>
                <input type="text" id="address" name="address" placeholder="Enter an address" class="form-control" value="" />

              </div>
            </div>

            <div class="form-group row masked">
              <div class="col-md-6">
                <label>Phone<span class="text-danger">*</span></label>
                <input type="tel" id="phone" name="phone" placeholder="Enter Phone Number" class="form-control" value="" />

              </div>

              <div class="col-md-6">
                <label>City<span class="text-danger">*</span></label>
                <input type="text" id="city" name="city" placeholder="Enter city" class="form-control" value="" />
              </div>
            </div>

            <div class="form-group row masked">
              <div class="col-md-6">
                <label>State<span class="text-danger">*</span></label>
                <select class="form-control" id="state" name="state">

                  <?php foreach ($us_states as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-6">
                <label>Zip<span class="text-danger">*</span></label>
                <input type="text" id="zip" name="zip" placeholder="Enter zip" class="form-control" value="" />
              </div>
            </div>

            <div class="form-group row envelopeAddress" id="envelope_address">
              <div class="col-md-6">
                <label style="font-size: 17px !important;">Send From Address:</label><br>
                <span class="cloudmailAddress" id="clientName"></span><br>
                <span class="cloudmailAddress" id="clientAddress"></span><br><br>
                <span class="cloudmailAddress" id="clientFullAddress"></span>
              </div>
              <div class="col-md-6">
                <label style="font-size: 17px !important;">Send To Address:</label><br>
                <span class="cloudmailAddress" id="companyName"></span><br>
                <span class="cloudmailAddress" id="companyAddress"></span><br><br>
                <span class="cloudmailAddress" id="companyFullAddress"></span>
              </div>

            </div>

            <div class="row d-none" id="printthissec">
              <div class="col-md-12">
                <div class="form-group row" style="padding: 10px 20px;">
                  <textarea cols="30" rows="20" name="content" id="contentTextarea"></textarea>
                </div>
              </div>
            </div>


            <div class="form-group row" style="padding: 10px 20px;" id="generate_letter">

              <button type="button" class="btn btn-success btn-icon-text" onclick="generate_letter_client();">Generate Library Letter</button>

            </div>

            <div class="form-group row" style="padding: 10px 20px; display:none" id="saveCreateLetter">

              <button type="button" class="btn btn-gradient-primary btn-icon-text" id="save_letter" onclick="save_client_letter();" style="margin-right: 10px; display:none">Save For Later</button>

              <button type="button" class="btn btn-gradient-primary btn-icon-text" id="create_letter" onclick="create_and_send_letter();">Save and Continue to Print</button>

            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    $('#category').change(function() {
      var categoryId = $(this).val();
      $('#loader').show();
      $.ajax({
        url: '<?php echo base_url("Admin/get_subcategories"); ?>',
        type: 'POST',
        data: {
          category_id: categoryId
        },
        dataType: 'json',
        success: function(response) {
          $('#loader').hide();
          var subcategorySelect = $('#subcategory');
          subcategorySelect.empty();
          if (response.length > 0) {
            subcategorySelect.append('<option value="0">Select Sub Category</option>');
            $.each(response, function(index, subcategory) {
              subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.letter_title + '</option>');
            });
          } else {
            subcategorySelect.append('<option value="">No subcategories available</option>');
            tinymce.get('contentTextarea').setContent('');
          }
        }
      });
    });

  });


  $(document).ready(function() {
    $('#subcategory').change(function() {
      var signatureUrl = "<?php echo $client[0]->agreement_sign; ?>";

      var client_Id = $('#clients').val();
      var subcategoryId = $(this).val();
      $('#loader').show();

      $.ajax({
        url: '<?php echo base_url("Admin/get_subcategories_content"); ?>',
        type: 'POST',
        data: {
          subcategoryId: subcategoryId,
          client_Id: client_Id,
        },
        dataType: 'json',
        success: function(response) {
          $('#loader').hide();
          if (response.status === 'success') {
            if (response.content) {

              var signatureBoxContent = "";

              // Check if there's a saved signature URL
              if (signatureUrl) {
                // Prepare signatureBox content
                signatureBoxContent = '<img src="' + signatureUrl + '" alt="Saved Signature" id="img-signature">';
              }

              // Replace `{client_signature}` in letterContent with signatureBoxContent
              if (response.content.includes("{client_signature}")) {

                // response.content.replace("{client_signature}", signatureBoxContent);
                if (response.content.includes("{client_signature}")) {
                  response.content = response.content.replace("{client_signature}", signatureBoxContent);
                }
              }

              tinymce.get('contentTextarea').setContent(response.content);
            }
            if (response.client_data) {
              // Populate client data fields (if required in the UI)
              $('#clientName').text(response.client_data.sq_first_name + ' ' + response.client_data.sq_last_name);
              $('#clientAddress').text(response.client_data.sq_mailing_address);
              $('#clientFullAddress').text(response.client_data.sq_city + ' ' + response.client_data.sq_state + ' ' + response.client_data.sq_zipcode);

            }
          } else {
            alert(response.message || 'An error occurred.');
          }
        },
        error: function() {
          $('#loader').hide();
          alert('An error occurred. Please try again.');
        }
      });
    });
  });


  function generate_letter_client() {
    const fields = [{
        id: 'name',
        label: 'Name'
      },
      {
        id: 'address',
        label: 'Address'
      },
      {
        id: 'phone',
        label: 'Phone'
      },
      {
        id: 'city',
        label: 'City'
      },

      {
        id: 'zip',
        label: 'Zip'
      },
      {
        id: 'letter_name',
        label: 'Letter Name'
      }
    ];
    const dropdowns = [{
        id: 'category',
        label: 'Category'
      },
      {
        id: 'subcategory',
        label: 'Sub Category'
      },
      {
        id: 'clients',
        label: 'Client'
      },
      {
        id: 'state',
        label: 'State'
      },
    ];

    let isValid = true;

    // Clear previous error highlights
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // Validate fields
    fields.forEach(field => {
      const value = $(`#${field.id}`).val();
      if (!value) {
        $(`#${field.id}`).addClass('is-invalid').after(`<div class="invalid-feedback">${field.label} is required.</div>`);
        isValid = false;
      }
    });

    // Validate dropdowns
    dropdowns.forEach(dropdown => {
      const value = $(`#${dropdown.id}`).find(":selected").val();
      if (value == 0) {
        $(`#${dropdown.id}`).addClass('is-invalid').after(`<div class="invalid-feedback">${dropdown.label} is required.</div>`);
        isValid = false;
      }
    });

    if (!isValid) {
      Swal.fire({
        title: 'Error',
        text: 'Please provide all mandatory fields!',
        icon: 'error',
        confirmButtonText: 'Retry'
      });
      return false;
    }

    // Show and hide relevant sections and buttons
    $('#envelope_address').removeClass('envelopeAddress');
    $('#printthissec').removeClass('d-none').addClass('d-block');
    $('.masked').css('display', 'none');
    $('#generate_letter').css('display', 'none');
    $('#saveCreateLetter').css('display', 'block');

  }


  function save_client_letter() {
    const category = $('#category').find(":selected").val();
    const subcategory = $('#subcategory').find(":selected").val();
    const client_id = $('#clients').find(":selected").val();
    const letter_name = $('#letter_name').val();
    const client_letter = tinymce.get('contentTextarea').getContent().trim();

    if (letter_name == '') {
      Swal.fire({
        title: 'Error',
        text: 'Letter Name is required!',
        icon: 'error',
        confirmButtonText: 'Retry',
        allowOutsideClick: false // Prevent closing on outside click
      }).then(() => {
        const letterInput = document.getElementById('letter_name');
        letterInput.focus();
        letterInput.style.borderColor = 'red';

        // Delay to ensure focus/scroll works properly
        setTimeout(() => {
          letterInput.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
        }, 500);
      });
      return false;
    } else {
      $('#loader').show();
      const formData = new FormData();
      formData.append('category', category);
      formData.append('subcategory', subcategory);
      formData.append('client_id', client_id);
      formData.append('letter_name', letter_name);
      formData.append('client_letter', client_letter);

      $.ajax({
        url: '<?= base_url("save_client_letter") ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          let res = JSON.parse(response);
          $('#loader').hide();

          if (res.status === 'success') {
            Swal.fire({
              title: 'Success!',
              text: res.message,
              icon: 'success',
              confirmButtonText: 'Continue',
              allowOutsideClick: false // Prevent closing on outside click
            }).then(() => {
              $('#save_letter').css('display', 'none');
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: res.message,
              icon: 'error',
              confirmButtonText: 'Close',
              allowOutsideClick: false // Prevent closing on outside click
            });
          }
        },
        error: function(xhr, status, error) {
          Swal.fire({
            title: 'Error!',
            text: 'An error occurred while submitting the message.',
            icon: 'error',
            confirmButtonText: 'Close',
            allowOutsideClick: false // Prevent closing on outside click
          });
        }
      });
    }

  }

  function create_and_send_letter() {
    save_client_letter();
    let category_Id = $('#category').find(":selected").val();
    let category_name = $('#category').find(":selected").text();
    let sub_category_Id = $('#subcategory').find(":selected").val();
    let sub_category_name = $('#subcategory').find(":selected").text();
    let client_Id = $('#clients').find(":selected").val();
    let message_content = tinymce.get('contentTextarea').getContent();
    let name = $('#name').val();
    let address = $('#address').val();
    let phone = $('#phone').val();
    let city = $('#city').val();
    let state = $('#state').val();
    let zip = $('#zip').val();
    let isValid = true;

    if (client_Id == 0 || sub_category_Id == 0 || category_Id == 0) {
      Swal.fire({
        title: 'Error',
        text: 'Please provide all mandatory fields!',
        icon: 'error',
        confirmButtonText: 'Retry',
        allowOutsideClick: false // Prevent closing on outside click
      });
      return false;
    } else {
      $('#loader').show();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('Lob/create_and_send_letter'); ?>',
        data: {
          'category_Id': category_Id,
          'category_name': category_name,
          'sub_category_Id': sub_category_Id,
          'sub_category_name': sub_category_name,
          'client_Id': client_Id,
          'message_content': message_content,
          'name': name,
          'phone': phone,
          'address': address,
          'city': city,
          'state': state,
          'zip': zip
        },
        success: function(response) {
          $('#loader').hide();
          let res = JSON.parse(response);
          if (res.status == 'success') {
            Swal.fire({
              title: 'Success',
              text: res.message,
              icon: 'success',
              confirmButtonText: 'Continue',
              allowOutsideClick: false // Prevent closing on outside click
            }).then(() => {
              location.reload();
            });
          } else if (res.status == 'error') {
            Swal.fire({
              title: 'Error',
              text: res.message,
              icon: 'error',
              confirmButtonText: 'Close',
              allowOutsideClick: false // Prevent closing on outside click
            });
          }
        }
      });
    }
  }
  
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1Jih1_t0oYWSky2LI9ZM399JMrjvh9o&libraries=places"></script>

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

  google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
</script>
</body>

</html>

<script>
  function fillDetails() {
    // Get the selected option
    const select = document.getElementById("credit_bureau");

    // Clear previous error highlights
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    const selectedOption = select.options[select.selectedIndex];

    // Populate the fields with the data attributes
    document.getElementById("name").value = selectedOption.getAttribute("data-name") || "";
    document.getElementById("address").value = selectedOption.getAttribute("data-address") || "";
    document.getElementById("phone").value = selectedOption.getAttribute("data-phone") || "";
    document.getElementById("city").value = selectedOption.getAttribute("data-city") || "";
    document.getElementById("state").value = selectedOption.getAttribute("data-state") || "";
    document.getElementById("zip").value = selectedOption.getAttribute("data-zip") || "";

    $('#companyName').text($('#name').val());
    $('#companyAddress').text($('#address').val());
    $('#companyFullAddress').text($('#city').val() + ' ' + $('#state').find(':selected').val() + ' ' + $('#zip').val());
  }
</script>