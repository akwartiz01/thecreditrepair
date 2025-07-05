<?php
$arr = array(
	"client" => 'My Client',
	'schedule' => 'My Schedule',
	'company' => 'My Company',
	'invoice' => 'My Invoice',
	'library' => 'My Library',
	'affiliate' => 'My Affiliate',
	'creditor' => 'Creditor Furnisher',
	'dashboard' => 'Dashboard',
);
?>



<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Add Roles & Permissions</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="card">
					<div class="card-body">
						<form id="add_roles" action="" method="post" autocomplete="off" enctype="multipart/form-data">
							<input type="hidden" name="" value="" />
							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label>Role Name <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="role_name" id="role_name">
									</div>
								</div>

							</div>
							<div class="form-group">
								<!-- <label class="set-access">Set Access</label>
								<div class="example1">
									<div class="checkbox-select-all">
										<label class="custom_check">
											<input type="checkbox" name="selectall1" id="selectall1" class="all" value="1">
											<span for="selectall1" class="checkmark"></span> Select all
										</label>
									</div>
									<ul class="nav checkbox-list">

										<li>
											<label class="custom_check">
												<input type="checkbox" name="accesscheck[]" id="check" value="">
												<span for="check1" class="checkmark"></span>
											</label>
										</li>

									</ul>
								</div> -->
							</div>
							<div class="service-fields-btns mt-0">
								<button class="btn btn-primary mr-2" name="form_submit" type="button" onclick="add_new_role()">Submit</button>
								<a href="<?php echo base_url(); ?>admin/roles" class="btn btn-cancel">Cancel</a>
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
	function validateFieldsOnKeyup() {
		$('#role_name').on('keyup', function() {
			validateField($(this));
		});
	}

	function validateField($field) {
		let id = $field.attr('id');
		let value = $field.val();

		switch (id) {
			case 'role_name':
				if (value === "") {
					handleFieldValidation($field, "Role Name is required.");
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

	function add_new_role() {
		let isValid = true;

		clearFieldValidation($('#role_name'));


		let role_name = $('#role_name').val();

		if (role_name == "") {
			handleFieldValidation($('#role_name'), "Role Name is required.");
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
			formData.append('role_name', role_name);

			$.ajax({
				type: 'POST',
				url: '<?php echo base_url("add_new_role"); ?>',
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
							window.location.href = "<?php echo base_url('roles') ?>";
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