<?php
$task_type = $this->config->item('task_type');
$task_time = $this->config->item('task_time');

//fetch clients...
$fetchClient = $this->User_model->select_star('sq_clients');
if ($fetchClient->num_rows() > 0) {
  $fetchClientsss = $fetchClient->result();
}

//fetch team...
$fetchteam = $this->User_model->select_star('sq_users');
if ($fetchteam->num_rows() > 0) {
  $fetchteamsss = $fetchteam->result();
}

?>
<style type="text/css">
  #TaskModal .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  label {
    font-weight: 500;
    font-size: 14px;
  }
</style>
<div id="msgAppend123"></div>

<!-- Loader HTML -->
<div id="loader_clients" style="display: none;">
  <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>

<!-- Task Modal -->
<div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Add New Team Task</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3 mt-3">
          <div class="col">
            <label>Task type:</label>
            <select class="form-control required-field" id="task_type">
              <option value="">Select One</option>
              <?php foreach ($task_type as $key => $row) { ?>
                <option value="<?php echo $key; ?>"><?php echo $row; ?></option>
              <?php } ?>
            </select>
            <small class="text-danger error-message"></small>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label>Subject:</label>
            <input type="text" id="subject" class="form-control required-field" autocomplete="off">
            <small class="text-danger error-message"></small>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label>Due Date:</label>
            <input type="text" id="due_date" class="form-control datepicker required-field" autocomplete="off">
            <small class="text-danger error-message"></small>
          </div>
          <div class="col">
            <label>Time:</label>
            <select class="form-control required-field" id="due_time">
              <option value="">Select One</option>
              <?php foreach ($task_time as $key => $row) { ?>
                <option value="<?php echo $key; ?>"><?php echo date("h:i A", strtotime($row)); ?></option>
              <?php } ?>
            </select>
            <small class="text-danger error-message"></small>
          </div>
        </div>

        <div class="row mb-3" id="clientrow">
          <div class="col">
            <label>Clients:</label>
            <select class="form-control required-field" id="clients">
              <option value="">Select One</option>
              <?php if (isset($fetchClientsss) && is_array($fetchClientsss)) {
                foreach ($fetchClientsss as $value) { ?>
                  <option value="<?php echo $value->sq_client_id; ?>"><?php echo $value->sq_first_name . ' ' . $value->sq_last_name; ?></option>
              <?php }
              } ?>
            </select>
            <small class="text-danger error-message"></small>
          </div>
        </div>

        <div class="row mb-3" id="teamrow">
          <div class="col">
            <label>Team member:</label>
            <select class="form-control required-field" id="team_member">
              <option value="">Select One</option>
              <?php if (isset($fetchteamsss) && is_array($fetchteamsss)) {
                foreach ($fetchteamsss as $value) { ?>
                  <option value="<?php echo $value->sq_u_id; ?>"><?php echo $value->sq_u_first_name . ' ' . $value->sq_u_last_name; ?></option>
              <?php }
              } ?>
            </select>
            <small class="text-danger error-message"></small>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label>Notes:</label>
            <textarea class="form-control required-field" id="notes" rows="4"></textarea>
            <small class="text-danger error-message"></small>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" onclick="SavetaskData();" class="btn btn-success btn-sm">Save</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!---------------- task popup ------------->
<!-- partial:partials/_footer.html -->
<footer class="footer mt-auto py-4 bg-light shadow-sm border-top">
  <div class="container text-center">
    <span class="text-dark">
      &copy; <?php echo date('Y'); ?> 
      <a href="<?php echo base_url(); ?>" class="text-decoration-none fw-semibold text-dark" target="_blank">
        <b>CRX Credit Repair</b>
      </a>. All rights reserved.
    </span>
  </div>
</footer>


<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="<?php echo base_url(); ?>assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- Custom js for this page -->
<script src="<?php echo base_url(); ?>assets/vendors/summernote/dist/summernote-bs4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/chart.js/Chart.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script> -->
<!-- End plugin js for this page -->
<script src="<?php echo base_url(); ?>assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>

<!-- inject:js -->
<script src="<?php echo base_url(); ?>assets/vendors/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/off-canvas.js"></script>
<script src="<?php echo base_url(); ?>assets/js/hoverable-collapse.js"></script>
<script src="<?php echo base_url(); ?>assets/js/misc.js"></script>
<script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
<script src="<?php echo base_url(); ?>assets/js/todolist.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/sweetalert/sweetalert.min.js"></script>


<!-- endinject -->
<!-- Custom js for this page -->
<script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>

<script src="<?php echo base_url(); ?>assets/js/formpickers.js"></script>
<script src="<?php echo base_url(); ?>assets/js/alerts.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
  // $(window).load(function() {
  //     $(".jumping-dots-loader").fadeOut("slow");
  // });

  $(function() {
    $(".datepicker").datepicker();
  });

  $(document).ready(function() {

    $('.datatable').DataTable({
         order: [[0, 'desc']],
      "bLengthChange": false,
    });


    $('#summernoteExample').summernote({
      height: 185, //set editable area's height
      codemirror: { // codemirror options
        theme: 'monokai'
      },
      toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['paragraph']],
        //['view', ['fullscreen', 'codeview']],
      ],
    });

    $('#summernoteNotes').summernote({
      height: 185, //set editable area's height
      codemirror: { // codemirror options
        theme: 'monokai'
      },
      toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['paragraph']],
        //['view', ['fullscreen', 'codeview']],
      ],
    });
  });
</script>
<script src="<?php echo base_url(); ?>assets/js/calendar.js?ver=<?php echo time(); ?>"></script>

<!-- End plugin js for this page -->
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#advance").click(function() {
      jQuery("#advancediv").show();
      jQuery("#advanceremove").show();
      jQuery("#advance").hide();

    });
    jQuery("#advanceremove").click(function() {
      jQuery("#advancediv").hide();
      jQuery("#advanceremove").hide();
      jQuery("#advance").show();
    });
  });
</script>


<script type="text/javascript">
  function isNumber(evt, that) {
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
      return false;
    } else {
      var curchr = that.value.length;
      var curval = $(that).val();
      if (curchr == 3) {
        if (evt.keyCode != 8) {
          $(that).val("(" + curval + ")" + " ");
        }
      } else if (curchr == 9) {
        if (evt.keyCode != 8) {
          $(that).val(curval + "-");
        }
      }
    }
  }
</script>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#previousMailing2").click(function() {
      jQuery("#displayPreviousMailing2").show();
      jQuery("#basicsearch").hide();
    });
    jQuery("#lnkbasic").click(function() {
      jQuery("#displayPreviousMailing2").hide();
      jQuery("#basicsearch").show();
    });
  });


  $(document).ready(function() {
    $(".number_only").keydown(function(e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });
  });

  $(document).ready(function() {
    /***phone number format***/
    $(".phone-format").keypress(function(e) {
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
      }
      var curchr = this.value.length;
      var curval = $(this).val();
      if (curchr == 3 && curval.indexOf("(") <= -1) {
        $(this).val("(" + curval + ")" + "-");
      } else if (curchr == 4 && curval.indexOf("(") > -1) {
        $(this).val(curval + ")-");
      } else if (curchr == 5 && curval.indexOf(")") > -1) {
        $(this).val(curval + "-");
      } else if (curchr == 9) {
        $(this).val(curval + "-");
        $(this).attr('maxlength', '14');
      }
    });
  });

  function locatioBack() {
    window.history.back();
  }

  function closeSuccessModalNew() {

    $('#pDsuccess11').css('display', 'none');
    $('#pDMsuccess11').css('display', 'none');
    location.reload();

  }
</script>


<script>
  $(document).ready(function() {
    $('.required-field').on('keyup change', function() {
      if ($(this).val().trim() !== "") {
        $(this).removeClass("is-invalid");
        $(this).siblings(".error-message").text("");
      }
    });

    function SavetaskData() {
      let isValid = true;
      $(".required-field").each(function() {
        if ($(this).val().trim() === "") {
          $(this).addClass("is-invalid");
          $(this).siblings(".error-message").text("This field is required.");
          isValid = false;
        }
      });

      if (!isValid) {
        Swal.fire({
          icon: 'error',
          title: 'Validation Error',
          text: 'Please fill in all required fields!'
        });
        return;
      }

      $.post("<?php echo base_url('Invoices/taskData'); ?>", $("#taskForm").serialize(), function(response) {
        Swal.fire({
          icon: response.status ? 'success' : 'error',
          title: response.message
        }).then(() => {
          if (response.status) location.reload();
        });
      }, "json");
    }

    $('.task-checkbox').change(function() {
      let taskId = $(this).data('id');
      let status = $(this).is(':checked') ? 'Completed' : 'Pending';
      $.post("<?php echo base_url('Invoices/update_task_status'); ?>", {
        task_id: taskId,
        status: status
      }, function(response) {
        Swal.fire({
          icon: response.status ? 'success' : 'error',
          title: response.message
        });
      }, "json");
    });
  });

  $(document).on('click', '.edit-task', function() {
    var taskId = $(this).data('id');
    alert(taskId)
    $.ajax({
      url: 'Invoices/getTaskData',
      type: 'POST',
      data: {
        task_id: taskId
      },
      dataType: 'json',
      success: function(response) {
        // if (response.status) {
        //   $('#TaskModal').modal('show');
        //   $('#task_type').val(response.data.task_type);
        //   $('#subject').val(response.data.subject);
        //   $('#due_date').val(response.data.due_date);
        //   $('#due_time').val(response.data.due_time);
        //   $('#clients').val(response.data.clients);
        //   $('#team_member').val(response.data.team_member);
        //   $('#notes').val(response.data.notes);
        //   $('#task_id').val(taskId);
        // } else {
        //   Swal.fire('Error', response.message, 'error');
        // }
      }
    });
  });

  $(document).on('click', '.delete-task', function() {
    var taskId = $(this).data('id');
    Swal.fire({
      title: "Are you sure?",
      text: "This task will be deleted permanently!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'Invoices/deleteTask',
          type: 'POST',
          data: {
            task_id: taskId
          },
          dataType: 'json',
          success: function(response) {
            if (response.status) {
              Swal.fire('Deleted!', response.message, 'success').then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error', response.message, 'error');
            }
          }
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#navbar-search-input').on('keyup', function() {
      var query = $(this).val();
      if (query !== '') {
        $.ajax({
          url: "<?= base_url(); ?>Admin/search",
          method: "POST",
          data: {
            query: query
          },
          success: function(data) {
            $('#clientList').fadeIn();
            $('#clientList').html(data);
          }
        });
      } else {
        $('#clientList').fadeOut();
      }
    });

    $(document).on('click', 'li.client-item', function() {
      $('#navbar-search-input').val($(this).text());
      $('#clientList').fadeOut();
    });
  });
</script>

<script>
  function confirmLogout() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you really want to log out?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, log out!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?php echo base_url(); ?>sign-out';
      }
    });
  }
</script>


<script src="<?php echo base_url(); ?>assets/assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('.datepicker_time').datetimepicker({
      format: 'YYYY-MM-DD hh:mm A',
      showClose: true,
      showClear: true,
      useCurrent: false,
      sideBySide: true,
      icons: {
        time: 'fa fa-clock',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-calendar-check-o',
        clear: 'fa fa-trash',
        close: 'fa fa-times'
      }
    });

    $('#allDayEvent').on('change', function() {
      if ($(this).is(':checked')) {
        $('.datepicker_time').each(function() {
          $(this).data("DateTimePicker").format('YYYY-MM-DD');
        });
      } else {
        $('.datepicker_time').each(function() {
          $(this).data("DateTimePicker").format('YYYY-MM-DD hh:mm A');
        });
      }
    });
  });


  function add_new_calendar_event() {
    let select = $('#team_members').find(":selected").val();
    let event_type = $('#eventType').find(":selected").val();
    let event_subject = $('#event_subject').val();
    let event_title = $('#event_title').val();
    let eventStartDateTime = $('#eventStartDateTime').val();
    let eventEndDateTime = $('#eventEndDateTime').val();
    let event_clients = $('#event_clients').find(":selected").val();
    let event_location = $('#event_location').val();
    let event_remarks = $('#event_remarks').val();

    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    let isValid = true;

    if (event_title == "") {
      $('#event_title').addClass('is-invalid');
      $('#event_title').after('<div class="invalid-feedback">Event Name is required.</div>');
      isValid = false;
    }

    if (event_subject == "") {
      $('#event_subject').addClass('is-invalid');
      $('#event_subject').after('<div class="invalid-feedback">Subject is required.</div>');
      isValid = false;
    }

    if (eventStartDateTime == "") {
      $('#eventStartDateTime').addClass('is-invalid');
      $('#eventStartDateTime').after('<div class="invalid-feedback">Start Date is required.</div>');
      isValid = false;
    }

    if (eventEndDateTime == "") {
      $('#eventEndDateTime').addClass('is-invalid');
      $('#eventEndDateTime').after('<div class="invalid-feedback">End Date is required.</div>');
      isValid = false;
    }

    if (!isValid) {
      Swal.fire({
        title: 'Error',
        text: 'Please provide all mandatory fields!',
        icon: 'error',
        confirmButtonText: 'Retry'
      });
      return false;
    } else {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('create_new_event'); ?>',
        data: {
          'select': select,
          'event_type': event_type,
          'event_subject': event_subject,
          'event_title': event_title,
          'eventStartDateTime': eventStartDateTime,
          'eventEndDateTime': eventEndDateTime,
          'event_clients': event_clients,
          'event_location': event_location,
          'event_remarks': event_remarks,
        },
        success: function(response) {
          let res = JSON.parse(response);
          if (res.status == 'success') {
            Swal.fire({
              title: 'Success',
              text: res.message,
              icon: 'success',
              confirmButtonText: 'Continue'
            }).then(() => {
              window.location.href = "<?php echo base_url('schedule'); ?>";
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
  $(document).ready(function() {
    $('.my_clients_datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo base_url('Admin/fetch_clients'); ?>",
        "type": "POST"
      },
      "language": {
        "processing": $("#loader_clients").html()
      },
      "columns": [

        {
          "data": "sq_first_name"
        },
        {
          "data": "sq_email"
        },
        {
          "data": "sq_phone_work"
        },
        {
          "data": "assigned_to"
        },
        {
          "data": "referred_by"
        },
        {
          "data": "added_date"
        },
        {
          "data": "start_date"
        },
        {
          "data": "last_login"
        },
        {
          "data": "onboarding_stage"
        },
        {
          "data": "company"
        },
        {
          "data": "status"
        },
        {
          "data": "actions"
        },

      ],
      "drawCallback": function(settings) {
        $('#loader_clients').hide();
      }
    });

    $('.my_clients_datatable').on('processing.dt', function(e, settings, processing) {
      $('#loader_clients').css('display', processing ? 'block' : 'none');
    });
  });

  function filterclientfn() {
    $('#filterclient').submit();
  }

  $('#chat_list').on('click', function() {

    window.location.href = "<?php echo base_url('secure-messages'); ?>"

  });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  $(document).ready(function() {

    // Clear displayed notifications if needed
     localStorage.removeItem('displayedNotifications');

    let latestNotificationID = null;
    let displayedNotifications = JSON.parse(localStorage.getItem('displayedNotifications')) || [];

    // Fetch and display unread notifications
    function fetchUnreadNotifications() {
      $.ajax({
        url: "<?php echo base_url('admin/get_unread_notifications'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
          updateNotificationCount(response.notifications.length);
          response.notifications.forEach(notification => {
            if (!displayedNotifications.includes(notification.id)) {
              showToasterNotification(notification.msg, notification.id);
              displayedNotifications.push(notification.id);
            }

          });
          localStorage.setItem('displayedNotifications', JSON.stringify(displayedNotifications));
        }
      });
    }


    function updateNotificationCount(count) {
      let countElement = $('#notification-count');
      if (count > 0) {
        countElement.text(count).show();
      } else {
        countElement.hide();
      }
    }

    function showToasterNotification(message, id) {
      toastr.options = {
        "closeButton": true,
        "positionClass": "toast-top-right",
        "onclick": function() {
          removeNotification(id);
        },
        "timeOut": "7000",
        "extendedTimeOut": "2000",
        "newestOnTop": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };

      toastr.info(message, "New Notification", {
        iconClass: 'toast-dark-info',
      });
       removeNotification(id);
    }

    // Mark notifications as read on dropdown click and update count
    $('#messageDropdown').on('click', function() {
      $.ajax({
        url: "<?php echo base_url('admin/mark_all_read'); ?>",
        type: "POST",
        success: function() {
          $('#notification-count').text('0').hide(); // Reset count
        }
      });
    });

    // Check for unread notifications at intervals
    setInterval(fetchUnreadNotifications, 5000);

    // Remove notification on click
    function removeNotification(notificationID) {
      $.ajax({
        url: "<?php echo base_url('admin/mark_as_read'); ?>",
        type: "POST",
        data: {
          notification_id: notificationID
        }
      });
    }

    setInterval(() => {
        
      localStorage.removeItem('displayedNotifications'); // Clear periodically
    }, 3600000);

  });
</script>
<script>
      
$(document).ready(function() {
  $('.furnishers_datatable').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "<?php echo base_url('Furnishers/furnisher_ajax'); ?>",
      "type": "POST"
    },
        "language": {
          "processing": $("#loader_clients").html()
        },
    "columns": [
      { "data": "company_name" },
      { "data": "email" },
    //   { "data": "phone" },
      { "data": "actions", "orderable": false }
    ],
    "drawCallback": function(settings) {
      $('#loader_clients').hide();
    }
  });

  $('.furnishers_datatable').on('processing.dt', function(e, settings, processing) {
    $('#loader_clients').css('display', processing ? 'block' : 'none');
  });
});

  
  
  
  
  
  
  
  
</script>

</body>

</html>