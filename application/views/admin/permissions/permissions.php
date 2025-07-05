<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <h4>Roles and Permission</h4>
            </div>
            <div class="col-12">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input" id="selectAllGlobal"> Select All
                </label>
              </div>
            </div>
          </div>


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

          <div class="row">
            <?php foreach ($arr as $key => $val) {
              $add = $edit = $view = 0;
              if (is_array($permissions_list) && count($permissions_list) > 0) {
                foreach ($permissions_list as $k) {
                  if ($k->sq_p_tabname == $key) {
                    $add = $k->sq_p_add;
                    $edit = $k->sq_p_edit;
                    $view = $k->sq_p_view;
                  }
                }
              }
            ?>
              <div class="col-md-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $val; ?></h4>
                    <!-- Section Select All -->
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input checkboxes selectAllSection" <?php if ($add == 1 && $edit == 1 && $view == 1) {
                                                                                            echo "checked";
                                                                                          } ?> data-section="<?php echo $key; ?>"> Select All ( <?php echo $val; ?> )
                      </label>
                    </div>

                    <!-- Checkboxes for Add, Edit, View -->
                    <div class="d-none">
                        <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input checkboxes addCheck" <?php if ($add == 1) {
                                                                                              echo "checked";
                                                                                            } ?> data-role="add" data-tabname="<?php echo $key; ?>"> Add
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input checkboxes editCheck" <?php if ($edit == 1) {
                                                                                                echo "checked";
                                                                                              } ?> data-role="edit" data-tabname="<?php echo $key; ?>"> Edit
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input checkboxes viewCheck" <?php if ($view == 1) {
                                                                                                echo "checked";
                                                                                              } ?> data-role="view" data-tabname="<?php echo $key; ?>"> View
                      </label>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="">

            <button type="button" class="btn btn-primary" onclick="updateAllRoles();">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  // Function for global select all
  $('#selectAllGlobal').click(function() {
    $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
  });

  // Function for section-specific select all
  $('.selectAllSection').click(function() {
    var section = $(this).data('section');
    $('input[data-tabname="' + section + '"]').prop('checked', $(this).prop('checked'));
  });

  function updateAllRoles() {
    var updates = [];
    var role_type = '<?php echo $role_type; ?>'; // Get the role_type

    // Collect only valid roles
    $('input[type="checkbox"]').each(function() {
      var role = $(this).data('role');
      var tabname = $(this).data('tabname');
      var checked = $(this).is(':checked') ? 1 : 0;

      if (role && tabname) {
        updates.push({
          role: role,
          tabname: tabname,
          checked: checked
        });
      }
    });

    Swal.fire({
      title: 'Are you sure?',
      text: 'You are about to update the role.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, update it!',
      cancelButtonText: 'No, cancel!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Admin/updateRoles"; ?>',
          data: {
            updates: updates,
            role_type: role_type // Include role_type in the request
          },
          success: function(response) {

            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Roles updated successfully!',
              showConfirmButton: true,
            }).then(() => {
              location.reload();
            });
          },
          error: function(xhr, status, error) {

            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'There was an issue updating roles. Please try again.',
              showConfirmButton: true,
            }).then(() => {
              location.reload();
            });
          }
        });
      }
    });
  }

  // Function to check if all checkboxes are checked
  function checkAllCheckboxes() {
    if ($('.checkboxes:checked').length == $('.checkboxes').length) {
      $('#selectAllGlobal').prop('checked', true);
    } else {
      $('#selectAllGlobal').prop('checked', false);
    }
  }

  // On page load, check the status of checkboxes
  $(document).ready(function() {
    checkAllCheckboxes();

    // On change or click, update the global selectAll checkbox
    $(".checkboxes, #selectAllGlobal").on('change click', function() {
      checkAllCheckboxes();
    });
  });
</script>