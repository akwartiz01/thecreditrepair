<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.fc-event-title {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
  display: block;
  font-weight: bold;
}
.fc-more-popover .fc-event-container {
    max-height: 150px !important;
    overflow-y: auto !important;
}


.fc-day-grid-event .fc-content{
      white-space:unset!important;
}
.underlink{
    color: #0056b3!important;
    text-decoration: underline!important;
    margin:0px 5px;
}
.link{
    color: #0056b3!important;
}
.fc-event-client {
  font-size: 0.85em;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.fc-daygrid-event-title {
  white-space: normal;       /* Allow title line-wrap */
}

.fc .fc-more-link {
  font-size: 0.75rem;
  color: #444;
}
.fc-daygrid-event {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.fc .fc-event.fc-not-start, .fc .fc-event.fc-not-end{
    border-left:unset!important;
}
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  border-radius: 6px;
}

.btn-primary:hover {
  background-color: #0056b3;
}
.task-highlight {
    background-color: #1cc94e !important;
    border-color: #1cc94e !important;
    color: #fff !important;
}

#calendar {
  padding: 10px;
}

.fc {
  font-size: 0.92rem;
}

.fc-toolbar-title {
  font-size: 1.4rem;
  font-weight: 600;
  color: #343a40;
}

.fc-event {
  background-color: #0d6efd;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 3px 5px;
  font-weight: 500;
}

.fc-event:hover {
  background-color: #084298;
}

.fc .fc-button {
  background-color: #0d6efd;
  border: none;
  border-radius: 6px;
  padding: 5px 10px;
}
.fc .fc-button:hover {
    color: #fff;
}
.fc .fc-button:hover {
  background-color: #084298;
}

.fc-daygrid-event-dot {
  border-color: #0d6efd;
}

.fc-more-popover {
  border-radius: 10px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}
.fc .fc-event{
    padding:2px!important;
}

</style>
<div id="deletePopup" class="swal-overlay swal-overlay--show-modal" tabindex="-1" style="display: none;">
  <div id="deletePopupModal" class="swal-modal" role="dialog" aria-modal="true" style="display: none;">
    <input type="hidden" name="hiddenClientId" id="hiddenClientId" value="">
    <div class="swal-icon swal-icon--warning">
      <span class="swal-icon--warning__body">
        <span class="swal-icon--warning__dot"></span>
      </span>
    </div>
    <div class="swal-title" style="">Are you sure?</div>
    <div class="swal-text" style="">You won't be able to revert this!</div>
    <div class="swal-footer">
      <div class="swal-button-container">
        <button class="swal-button swal-button--cancel btn btn-danger" onclick="deleteCancel();">Cancel</button>
        <div class="swal-button__loader">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div class="swal-button-container">
        <button class="swal-button swal-button--confirm btn btn-primary" onclick="deleteEvent();">OK</button>
        <div class="swal-button__loader">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="msgAppend"></div>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
<div class="content-wrapper">
  <div class="page-header mb-4">
    <h1 class="fw-bold">My Schedule</h1>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card shadow-sm rounded-4 border-0" id="scheduler">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6 col-sm-12 mb-2 mb-md-0">
              <label class="fw-semibold mb-1">Team Member:</label>
              <select id="team_members" class="form-control" style="max-width: 300px;">
                <option value="">All</option>
                <?php foreach ($team_members as $key => $value) { ?>
                  <option value="<?php echo $value->sq_u_id; ?>">
                    <?php echo $value->sq_u_first_name . ' ' . $value->sq_u_last_name; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
              <button type="button" class="btn btn-primary py-1 px-2" id="add_event">
                <i class="mdi mdi-plus"></i> Add Event
              </button>
                <button type="button" class="btn btn-primary py-1 px-2" onclick="taskeventview();">Tasks & Events View
              </button>
            </div>
          </div>

          <div id="calendar" class="full-calendar"></div>
        </div>
      </div>
      
        <div class="card shadow-sm rounded-4 border-0" id="taskEventView">
  <div class="card-body">
    <!-- Back Button Row -->
    <div class="row">
      <div class="col-12 text-end"> <!-- text-right changed to text-end for Bootstrap 5 -->
        <button type="button" class="btn btn-secondary py-1 px-3" onclick="back();">Back</button>
        <button type="button" class="btn btn-success py-1 px-3" onclick="newTask();">New Task</button>
      </div>
    </div>

    <!-- Table Row -->
    <div class="row mt-4">
      <div class="col-12">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Current Tasks</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="complete-tab" data-bs-toggle="tab" data-bs-target="#complete" type="button" role="tab" aria-controls="profile" aria-selected="false">Completed Tasks</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <div class="form-group col-lg-3 col-md-6 col-sm-12">
   <?php $user_id  = $this->session->userdata('user_id'); ?>
<label class="fw-semibold mb-1">Team Member:</label>
<select id="team_member_current" class="form-control">
    <option value="">All</option>
    <?php foreach ($team_members as $key => $value) {
        $full_name = $value->sq_u_first_name . ' ' . $value->sq_u_last_name;
        $selected = ($value->sq_u_id == $user_id) ? 'selected' : '';
    ?>
        <option value="<?php echo $full_name; ?>" <?php echo $selected; ?>>
            <?php echo $full_name; ?>
        </option>
    <?php } ?>
</select>

  </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Task/Event</th>
                <th>Client</th>
                <th>Team Member</th>
                <th>Due Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="task_table_body">
              
            </tbody>
          </table>
        </div>
  </div>
  <div class="tab-pane fade" id="complete" role="tabpanel" aria-labelledby="complete-tab">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Task/Event</th>
                <th>Client</th>
                <th>Team Member</th>
                <th>Due Date</th>
                <th>Action</th>
              </tr>
            </thead>
           <tbody id="task_table_body_com">
           
            </tbody>
          </table>
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

    <!-- content-wrapper ends -->

    <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><b>Add Calendar Event</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <?php echo form_open(base_url("Admin/add_event"), array("class" => "form-horizontal")) ?>
            <div class="form-group">
              <label for="p-in" class="col-md-4 label-heading">Event Name</label>
              <div class="col-md-12 ui-front">
                <input type="text" class="form-control" name="title" value="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="p-in" class="col-md-4 label-heading">Start Date</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="start" id="startTime" required>
              </div>
            </div>
            <div class="form-group">
              <label for="p-in" class="col-md-4 label-heading">End Date</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="end" id="endTime" required>
                <input type="hidden" class="form-control" name="select" id="select">
              </div>
            </div>
            <p id="when" style="margin-left: 20px;"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-success btn-sm" value="Add Event">
            <?php echo form_close() ?>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="AddEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document" style="max-width: 600px !important;">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><b>Add Calendar Event</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="p-in" class="label-heading">Event Type:</label>
                <select class="form-control" id="eventType" name="eventType" style="border:1px solid #d0d0d0 !important;">
                  <option value="0">Choose</option>
                  <option value="Billing">Billing</option>
                  <option value="Send Invoice">Send Invoice</option>
                  <option value="Follow Up">Follow Up</option>
                  <option value="Appointment">Appointment</option>
                  <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
              <div class="row event_calendar">
                <div class="col-md-6">
                  <label>Subject</label>
                  <input type="text" class="form-control" name="event_subject" id="event_subject" value="">
                </div>
                <div class="col-md-6">
                  <label>Event Name</label>
                  <input type="text" class="form-control" name="title" id="event_title" value="">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row event_calendar">
                <div class="col-md-6">
                  <label>Start Date & Time</label>
                  <input type="text" class="form-control datepicker_time" name="start" id="eventStartDateTime">
                </div>
                <div class="col-md-6">
                  <label>End Date & Time</label>
                  <input type="text" class="form-control datepicker_time" name="end" id="eventEndDateTime">
                  <input type="hidden" class="form-control" name="select" id="select">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row event_calendar">
                <div class="col-md-6">
                  <div class="form-check" style="margin-top: unset !important;">
                    <input type="checkbox" class="form-check-input" name="allDayEvent" id="allDayEvent" value="1" style="margin-left: unset !important;">
                    <label class="form-check-label">All Day Event</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="p-in" class="label-heading">Clients</label>
                <select id="event_clients" class="form-control" style="border:1px solid #d0d0d0 !important;">
                  <option value="0">Choose</option>
                  <?php foreach ($clients as $clients_key => $clients_value) { ?>
                    <option value="<?php echo $clients_value->sq_client_id; ?>"><?php echo $clients_value->sq_first_name; ?> <?php echo $clients_value->sq_last_name; ?></option>
                  <?php  } ?>
                </select>
            </div>

            <div class="form-group">
              <label for="p-in" class="label-heading">Location</label>
                <input type="text" class="form-control" name="event_location" id="event_location" value="">
            </div>

            <div class="form-group">
              <label for="p-in" class="label-heading">Remarks</label>
                <input type="text" class="form-control" name="event_remarks" id="event_remarks" value="">
            </div>

            <p id="when" style="margin-left: 20px;"></p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <input type="button" class="btn btn-success btn-sm" value="Add Event" onclick="add_new_calendar_event();">
          </div>
        </div>
      </div>
    </div>

<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa fa-calendar"></i> Event Details
        </h5>
        <button type="button" class="close" id="cancelModalevent">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="eventTitle"></p>
      <div class="date">
  <p><b>Start Date:</b> <span id="eventDate"></span></p>
  <p><b>End Date:</b> <span id="eventDateend"></span></p>
</div>

        <p id="eventTime"></p>
        <p id="eventClient"></p>
      </div>
      <div class="modal-footer">
        <!--<button class="btn btn-sm btn-primary" id="editEventBtn"><i class="fa fa-pencil"></i></button>-->
        <button class="btn btn-sm btn-danger" id="deleteEventBtn"><i class="fa fa-trash"></i></button>
      </div>
    </div>
  </div>
</div>

 <div id="taskModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-mg" role="document">
      <div class="modal-content" style="background-color: #fff !important;">
        <div class="modal-header">
          <h5 class="modal-title">Add Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
     <form id="taskForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="taskType" class="form-label">Task Type</label>
             <select class="form-control" id="taskType" name="taskType" required>
              <option value="">-- Select Task Type --</option>
              <option value="General">General</option>
              <option value="Billing">Billing</option>
              <option value="Send Invoice">Send Invoice</option>
              <option value="Follow Up">Follow Up</option>
              <option value="Appointment">Appointment</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
          </div>
          <div class="mb-3">
            <label for="dueDate" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="dueDate" name="dueDate" required>
          </div>
          <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time">
          </div>
          <div class="mb-3">
            <label for="teamMember" class="form-label">Team Member</label>
          <select class="form-control" id="teamMember" name="teamMember">
                  <?php
                if (!empty($team_members)){
                        foreach ($team_members as $team){ ?>
                      <option data-id="<?= $team->sq_u_id; ?>" value="<?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?>"><?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?></option>

    
                   <?php } } ?>
                        
            </select>
          </div>
           <div class="mb-3">
            <label for="client" class="form-label">Client</label>
          <select class="form-control" id="client" name="client">
                 <?php foreach ($clients as $clients_key => $clients_value) { ?>
                    <option value="<?php echo $clients_value->sq_client_id; ?>"><?php echo $clients_value->sq_first_name; ?> <?php echo $clients_value->sq_last_name; ?></option>
                  <?php  } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
      </div>
    </div>
  </div>
<div class="modal fade" id="updatetaskModal" tabindex="-1" aria-labelledby="updatetaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editTaskForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
            
        </div>
        <div class="modal-body">
          <input type="hidden" id="editTaskId" name="id">
          <input type="hidden" id="tasktype" name="tasktype"/>
          <div class="mb-3">
            <label class="form-label">Task Type</label>
            <select class="form-control" id="editTaskType" name="taskType">
              <option value="General">General</option>
              <option value="Billing">Billing</option>
              <option value="Send Invoice">Send Invoice</option>
              <option value="Follow Up">Follow Up</option>
              <option value="Appointment">Appointment</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" id="editSubject" name="subject">
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" id="editDueDate" name="dueDate">
          </div>
          <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" class="form-control" id="editTime" name="time">
          </div>
          <div class="mb-3">
            <label class="form-label">Team Member</label>
            <select class="form-control" id="editTeamMember" name="teamMember">
                <?php
                if (!empty($team_members)){
                        foreach ($team_members as $team){ ?>
                        <option data-id="<?= $team->sq_u_id; ?>" value="<?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?>"><?= $team->sq_u_first_name. ' ' .$team->sq_u_last_name ?></option>
                   <?php } } ?>
                        
            </select>
         
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" id="editNotes" name="notes" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelModalUpdate">Cancel</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        
// $(document).ready(function () {
//     $('#calendar').fullCalendar({
//         header: {
//             left: 'prev,next today',



//             center: 'title',
//             right: 'month,agendaWeek,agendaDay'
//         },
//         timeZone: 'Asia/Kolkata', // IST is used in FullCalendar
//         editable: true,
//         selectable: true,
//         events: "Admin/loadEventData",

//         eventRender: function (event, element) {
         
//             console.log("Event Start:", event.start._i);
//             console.log("Event End:", event.end._i);
//         },

//         select: function (start, end) {
//              var startTime = moment(start).format('YYYY-MM-DD HH:mm:ss');
//             var endTime = moment(end).format('YYYY-MM-DD HH:mm:ss');
//             console.log("Selected Start:", startTime);
//             console.log("Selected End:", endTime);
//         },

//         eventDrop: function (event) {
//               var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
//             var end = event.end ? moment(event.end).format('YYYY-MM-DD HH:mm:ss') : null;
//             $.ajax({
//                 url: 'Admin/edit_event',
//                 type: "POST",
//                 data: { id: event.id, start: start, end: end },
//                 success: function (response) {
//                     alert("Event updated successfully!");
//                 }
//             });
//         }
//     });
// });

    
    function taskeventview(){
          $('#scheduler').css('display', 'none');
        $('#taskEventView').css('display', 'block');
    }
      function back(){
          $('#scheduler').css('display', 'block');
        $('#taskEventView').css('display', 'none');
    }
    function newTask(){
          $('#taskModal').modal('show');
    }
      function openmydeletepopup(delID) {

        $('#hiddenClientId').val(delID);
        $('#deletePopup').css('display', '');
        $('#deletePopupModal').css('display', '');
        $('#loader').css('display', '');

      }

      function deleteCancel() {
        $('#deletePopup').css('display', 'none');
        $('#deletePopupModal').css('display', 'none');
      }

      function deleteEvent() {

        var id = $('#hiddenClientId').val();
        // Add Loader
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Admin/delete_event"; ?>',
          data: {
            'id': id
          },
          success: function(response) {

            if (response == '1') {
              // Show Success message 
              $('#deletePopup').css('display', 'none');
              $('#deletePopupModal').css('display', 'none');

              var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Event Deleted!</div><div class="swal-text" style="">You have deleted one event successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalee();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend').after(succesMsg);

            }

          }
        });
      }

      function closeSuccessModalee() {

        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');
        //$('#items tr#row'+id).remove();
        location.reload();

      }

      function updateevent(msg) {

        var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Event Updated!</div><div class="swal-text" style="">' + msg + '</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalee();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

        $('#msgAppend').after(succesMsg);

      }

      $('#add_event').on('click', function() {
        $('#AddEventModal').modal('show');
      });

  $(document).ready(function () {
      task_current();
      task_complete();
$(document).on('change', '.task-status-toggle', function () {
        console.log('dfd');
      const checkbox = $(this);
      const taskId = checkbox.data('task-id');
      const status = checkbox.is(':checked') ? '1' : '0'; // adjust according to your status values

      $.ajax({
        url: '<?= base_url("task/update_status") ?>',
        method: 'POST',
        data: {
          task_id: taskId,
          task_status: status
        },
        success: function (response) {
          console.log('Status updated:', response);
          let res = JSON.parse(response);
           task_current(); 
             task_complete(); 
        //   if(res.status == 1){
        //       task_current(); 
        //   }
        //   else{
        //       task_complete(); 
        //   }
        },
        error: function () {
          alert('Failed to update status');
          checkbox.prop('checked', !checkbox.is(':checked')); // revert checkbox
        }
      });
    });
$(document).on('click', '.delete-tasks', function () {
       const taskId = $(this).data('id');
        const taskname = $(this).data('name');
       console.log(taskname);
       // const taskId = $(this).closest('.task').data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure you want to delete this task?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, keep it'
        }).then((result) => {
          if (result.isConfirmed) {
            $.post('<?= base_url("delete_task") ?>', {
              task_id: taskId
            }, function(response) {
              Swal.fire('Deleted!', 'Task deleted successfully!', 'success');
              if(taskname == "current"){
              task_current(); 
          }
          else{
              task_complete(); 
          }
           
            });
          }
        });
      });

$('#team_member_current').on('change', function () {
  const fullName = $(this).val(); // full name sent as value

  $.ajax({
    url: '<?= base_url("task/filter_by_team_member") ?>',
    method: 'POST',
    data: { full_name: fullName },
    success: function (response) {
      $('#task_table_body').html(response);
    },
    error: function () {
      alert('Failed to load tasks');
    }
  });
});
function task_current(){
$.ajax({
      url: '<?= base_url("task_current") ?>',
      type: 'POST',
      data: {id:<?=$this->session->userdata('user_id'); ?>},
      success: function (html) {
        $('#task_table_body').html(html); // Replace task rows
      },
      error: function () {
        alert("Something went wrong!");
      }
    });
}
function task_complete(){
$.ajax({
      url: '<?= base_url("task_complete") ?>',
      type: 'POST',
      data: '',
      success: function (html) {
        $('#task_table_body_com').html(html); // Replace task rows
      },
      error: function () {
        alert("Something went wrong!");
      }
    });
}


   $('#cancelModal').on('click', function() {
        $('#taskModal').modal('hide');
        });
        
        $('#cancelModalevent').on('click', function() {
        $('#eventDetailsModal').modal('hide');
        });
        
         $('#taskForm').submit(function(e) {
    e.preventDefault();

    // Show loader
    $('#loader').show();

    // Prepare form data
    const formData = {
      taskType: $('#taskType').val(),
      subject: $('#subject').val(),
      dueDate: $('#dueDate').val(),
      time: $('#time').val(),
      teamMember: $('#teamMember').val(),
      teamMemberid: $('#teamMember option:selected').data('id'),
      notes: $('#notes').val(),
       client_id: $('#client').val()
    };

    $.ajax({
      url: '<?= base_url("taskSave") ?>', // change to your endpoint
      type: 'POST',
      data: formData,
      success: function(response) {
        // Hide loader
        $('#loader').hide();

        // You can parse response if JSON or just show message
        alert('Task saved successfully!');
       
        // Close modal
        var modalEl = $('#taskModal');
        modalEl.modal('hide');

        // Reset form
        $('#taskForm')[0].reset();
     task_current();

      },
      error: function(xhr, status, error) {
        $('#loader').hide();
        alert('Error: ' + error);
      }
    });
  });
  $(document).on('click', '.edit-tasks', function () {
          $('#editTaskId').val($(this).data('id'));
            $('#tasktype').val($(this).data('name'));
    $('#editSubject').val($(this).data('subject'));
    $('#editTaskType').val($(this).data('type'));
    $('#editDueDate').val($(this).data('due'));
    $('#editTime').val($(this).data('time'));
    $('#editTeamMember').val($(this).data('member'));
    $('#editNotes').val($(this).data('notes'));
       $('#updatetaskModal').modal('show');
    });
    
      $('#editTaskForm').submit(function (e) {
    e.preventDefault();
// Get the selected team member's data-id
const teamMemberId = $('#editTeamMember option:selected').data('id');
 let taskname = $('#tasktype').val();
 
// Append hidden input just before serialization
$('<input>').attr({
    type: 'hidden',
    name: 'teamMemberid',
    value: teamMemberId
}).appendTo(this);

// Now serialize
const formData = $(this).serialize();
    $.ajax({
      url: '<?= base_url("update_task") ?>',
      type: 'POST',
      data: formData,
      success: function (response) {
        const res = JSON.parse(response);
        if (res.status === 'success') {
          alert('Task updated successfully');
            $('#updatetaskModal').modal('hide');
             if(taskname == "current"){
              task_current(); 
              
          }
          else{
              task_complete(); 
          }
        } else {
          alert(res.message || 'Update failed');
        }
      },
      error: function () {
        alert('Server error occurred');
      }
    });
  });
  });
  
    </script>