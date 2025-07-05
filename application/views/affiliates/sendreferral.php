<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Send a Referral</h3>
                </div>
 
            </div>
        </div>
        <div class="alert alert-info shadow-sm rounded-4">
  <h5 class="mb-2">Refer us a New Client/Lead</h5>
  <p class="mb-0">Fill out this simple form to refer us a new client/lead, and you’ll be able to log in and track their progress.</p>
</div>
<div class="card shadow-sm rounded-4 mt-4">
  <div class="card-body">
    <h5 class="card-title mb-4">New Client / Lead Info</h5>

    <form id="clientForm" enctype="multipart/form-data">
      <div class="row g-3">
        <!-- First & Last Name -->
        <div class="col-md-6 mb-3">
          <label for="firstName" class="form-label">First Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
        </div>
      <div class="col-md-6 mb-3">
          <label for="lastName" class="form-label">Last Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>
          
          <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="noEmail" name="noEmail">
            <label class="form-check-label" for="noEmail">
              Client has no email
            </label>
          </div>
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email"  name="email" placeholder="Enter email">
        </div>

        <!-- Last 4 of SSN -->
        <div class="col-md-6 mb-3">
          <label for="ssn" class="form-label">Last 4 of SSN</label>
          <input type="text" class="form-control" id="ssn" name="ssn"  placeholder="e.g., 1234" maxlength="4">
        </div>

        <!-- Address -->
        <div class="col-md-12 mb-3">
          <label for="address" class="form-label">Address</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="Street address">
        </div>

        <!-- DOB -->
        <div class="col-md-6 mb-3">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" id="dob" name="dob">
        </div>

        <!-- City -->
        <div class="col-md-6 mb-3">
          <label for="city" class="form-label">City</label>
          <input type="text" class="form-control" name="city" name="city">
        </div>

        <!-- State -->
        <div class="col-md-4 mb-3">
          <label for="state" class="form-label">State</label>
          <input type="text" class="form-control" name="state" id="state">
        </div>

        <!-- County -->
        <div class="col-md-4 mb-3">
          <label for="county" class="form-label">County</label>
          <input type="text" class="form-control" name="county" id="county">
        </div>

        <!-- Zip Code -->
        <div class="col-md-4 mb-3">
          <label for="zip" class="form-label">Zip Code</label>
          <input type="text" class="form-control" name="zip" id="zip">
        </div>

        <!-- Memo -->
        <div class="col-md-12 mb-3">
          <label for="memo" class="form-label">Memo</label>
          <textarea class="form-control" id="memo" name="memo" rows="3" placeholder="Additional notes..."></textarea>
        </div>

        <!-- Attachment -->
        <!--<div class="col-md-12 mb-3">-->
        <!--  <label for="attachment" class="form-label">Attachment</label>-->
        <!--  <input class="form-control" type="file" id="attachment" name="attachment">-->
        <!--</div>-->

        <!-- Submit Button -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
  $("#clientForm").submit(function (e) {
    e.preventDefault();

    const firstName = $("#firstName").val().trim();
    const lastName = $("#lastName").val().trim();
    const email = $("#email").val().trim();
    const noEmail = $("#noEmail").is(":checked");

    // Basic Validation
    if (!firstName || !lastName) {
      alert("First Name and Last Name are required.");
      return;
    }

    // if (!noEmail && !email) {
    //   alert("Email is required unless 'Client has no email' is checked.");
    //   return;
    // }

    // Prepare form data
    const formData = new FormData(this);

    // Send via AJAX
 $.ajax({
  url: '<?php echo base_url("/affiliate/save-client"); ?>',
  type: 'POST',
  data: formData,
  processData: false,
  contentType: false,
  success: function (response) {
    try {
      const res = JSON.parse(response); // Safely parse the JSON response
      alert(res.message);
      if (res.status === 'success') {
        $("#clientForm")[0].reset();
      }
    } catch (e) {
      console.error("Response parsing error:", e, response);
      alert("Unexpected response from server.");
    }
  },
  error: function (xhr, status, error) {
    console.error("AJAX Error:", error);
    alert("Something went wrong. Please try again.");
  }
});

  });
});
</script>


