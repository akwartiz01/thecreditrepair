<style type="text/css">
  @media screen and (max-width: 748px) {
    .chrightboxinner {
      width: 100%;
    }
  }

  .backgorund_color {
    background-color: #3972FC !important;
  }
.link {
    color: #0056b3;
    text-decoration: underline;
}
  /**** NEW STYLING ****/
  .fc .fc-button-group {
    border: 1px solid darkgray;
  }

  td.fc-widget-content {
    border: 1px solid darkgray;
  }

  /**** END NEW STYLING ****/

  /* css 02-May-25 start */
  @media screen and (max-width: 767px) {
    .col-sm-12.col-md-6 {
      padding: 0px;
    }
    .fc-center {
      padding-left: 11px;
    }
    .fc-toolbar .fc-right {
      float: left;
      margin-top: 15px;
    }
    .fc .fc-widget-header table tr th {
      border-width: 0 0 1px 0;
      text-align: center;
      padding: unset;
    }
    .fc .fc-widget-header {
      margin-bottom: 10px!important;
    }
    .fc-basic-view .fc-body .fc-row {
      min-height: auto;
    }
  }
  /* css 02-May-25 end */

</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">

      </div>

      <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card ch">
            <div class="card-body">
              <h4 class="card-title"> Quick Start </h4> <br>

              <div class="chleftbox">

                <a href="<?php echo base_url(); ?>add-client">
                  <div class="liste">
                    <h3 class="page-title">
                      <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-account"></i>
                      </span>
                      <span class="icon_text"> Add a New Client</span>
                    </h3>
                  </div>
                </a>
                <a href="<?php echo base_url(); ?>clients">
                  <div class="liste">
                    <h3 class="page-title">
                      <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-account-multiple-plus"></i>
                      </span>
                      <span class="icon_text">Select an Existing Client</span>
                    </h3>
                  </div>
                </a>
                <div class="liste" id="clientbutton">
                  <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                      <i class="mdi mdi-credit-card-scan"></i>
                    </span>
                    <span class="icon_text">Run Credit Dispute Wizard</span>
                  </h3>
                </div>
                <a href="<?php echo base_url() ?>my-company">
                  <div class="liste">
                    <h3 class="page-title">
                      <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-city"></i>
                      </span>
                      <span class="icon_text">My Company</span>
                    </h3>
                  </div>
                </a>

                <a href="<?php echo base_url(); ?>profile">
                  <div class="liste">
                    <h3 class="page-title">
                      <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-account"></i>
                      </span>
                      <span class="icon_text"> My Profile</span>
                    </h3>
                  </div>
                </a>

              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8 stretch-card grid-margin">
          <div class="card ch">
            <div class="card-body">
              <div class="chleftbox">
                <div class="chrightbox">
                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>my-company'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-home-map-marker"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>My Company Profile</strong><br>
                        Configure users, permissions, billing </div>
                    </div>
                  </div>

                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>clients'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-account-multiple"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Clients</strong><br>
                        Add or delete clients and records </div>
                    </div>
                  </div>


                  <div id="tip5" class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>furnisher'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-credit-card-multiple"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Creditor Furnisher</strong><br>
                        Get Credit Repair Training and Certificate </div>
                    </div>
                  </div>
                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>schedule'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-calendar-clock"></i></div>
                      <div class="chrightboxinner-txt"> <strong>Schedule</strong><br>
                        Time organization and appointments </div>
                    </div>
                  </div>
                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>my-company'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-account-key"></i> </div>
                      <div class="chrightboxinner-txt"> <strong> Permission </strong><br>
                        Users Permissions </div>
                    </div>
                    <div id="help-txt-website" class="tooltipbox" style="top: 4.0em; margin-left:-10px; width: 280px; line-height: 18px; display: none;">
                      <p style="margin:0px;" class="normaltext1"> Upgrade to Credit Repair Cloud Paid Subscription and receive a coupon code for 2 free months of hosting. </p>
                      <div id="tail1-bottom"></div>
                      <div id="tail2-bottom"></div>
                    </div>
                  </div>
                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>affiliates'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-webpack"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Affiliate</strong><br>
                        Add and View affiliates here </div>
                    </div>
                    <div id="help-txt-portal" class="tooltipbox" style="top: 3em; margin-left: -10px; width: 280px; line-height: 18px; display: none;">
                      <p style="margin:0px;" class="normaltext1"> Your "Portal" is where clients and affiliates log in to see updates, secure messages and sensitive documents. It's private label with only your company logo. Try the demos with these User IDs and Passwords: client/demo and affiliate/demo </p>
                      <div id="tail1-bottom"></div>
                      <div id="tail2-bottom"></div>
                    </div>
                  </div>

                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>templates'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-library"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Letter Library</strong><br>
                        Also add your own custom letters. </div>
                    </div>
                  </div>

                  <!-- <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>send_letter'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-email"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Send Letters</strong><br>Send letter to clients </div>
                    </div>
                  </div> -->

                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>email_templates'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-email"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Auto E-mail Templates</strong><br>
                        Also add auto email templates. </div>
                    </div>
                  </div>

                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>allactivity'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-file-tree"></i> </div>
                      <div class="chrightboxinner-txt"> 
                      <strong> 
                      All Activities
                      </strong>
                      <br>
                      View All Activities
                        <!--Also add auto email templates.-->
                        </div>
                    </div>
                  </div>
                  <!-- <div class="chrightboxinner" onclick="javascript:location.href='#'">
    <div  >
      <div class="chrightboxinner-img"> <i class="mdi mdi-note-plus"></i> </div>
      <div class="chrightboxinner-txt"> <strong>Internal Notes</strong><br>
        Add internal notes.These internal notes are not seen by clients. </div>
    </div>
  </div> -->
                  <div class="chrightboxinner" onclick="javascript:location.href='<?php echo base_url(); ?>new-team'">
                    <div>
                      <div class="chrightboxinner-img"> <i class="mdi mdi-account-multiple-plus"></i> </div>
                      <div class="chrightboxinner-txt"> <strong>Add New Team Member</strong><br>
                        Add New Team Member to give login access to your co-workers. </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>

      </div>



      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body table-responsive">
              <h4 class="card-title">Recent Login Activity</h4>
               <div class="table-responsive"> 
              <table class="table" id="datatable11">
                <thead>
                  <tr>
                    <th> User </th>
                    <th> IP Address </th>
                    <th> Access Type </th>
                    <th> Status </th>
                    <th> Date & Time </th>
                    <th> Location </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($fetchLoginDetails) && is_array($fetchLoginDetails)) {
                    foreach ($fetchLoginDetails as $value) { ?>

                      <tr>
                        <td> <?php echo $value->sq_u_first_name . ' ' . $value->sq_u_last_name; ?> </td>
                        <td> <?php echo $value->ip_address; ?> </td>
                        <td> <?php echo $value->access_type; ?> </td>
                        <td> <label class="badge badge-gradient-success"><?php echo $value->status; ?></label> </td>
                        <td> <?php echo $value->datetime; ?> </td>
                        <td> <?php echo $value->location; ?> </td>
                      </tr>
                  <?php }
                  } ?>

                </tbody>
              </table>
               </div> 
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="clearfix">
                <h4 class="card-title float-left">Today's Schedule</h4>
                <a class="float-right link" href="<?php echo base_url(); ?>schedule">Manage Schedule</a>
                <div class="row">
                  <div class="col-md-7">
                  </div>
                  <div class="col-md-5">
                  </div>
                </div>
                <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>
              </div>
              <div id="calendar" class="full-calendar"></div>
            </div>
          </div>
        </div>
        <!--<div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">My Tasks</h4>
                    <div class="add-items d-flex">
                      <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                      <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
                    </div>
                    <div class="list-wrapper">
                      <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Meeting with Alisa </label>
                          </div>
                          <i class="remove mdi mdi-close-circle-outline"></i>
                        </li>
                        <li class="completed">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox" checked> Call John </label>
                          </div>
                          <i class="remove mdi mdi-close-circle-outline"></i>
                        </li>
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Create invoice </label>
                          </div>
                          <i class="remove mdi mdi-close-circle-outline"></i>
                        </li>
                        
						            <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                          </div>
                          <i class="remove mdi mdi-close-circle-outline"></i>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>-->
      </div>
    </div>
    <div class="modal fade" id="ClientModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-mg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Select a client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <div class="modal-body">
  <input type="text" id="nameSearch" class="form-control mb-2" placeholder="Search name...">
  <div style="max-height: 300px; overflow-y: auto;">
    <ul class="list-group">
      <?php foreach ($client_data as $list): ?>
        <li class="list-group-item">
          <a href="<?= base_url('generate-letters/' . get_encoded_id($list->sq_client_id)); ?>" class="text-decoration-none text-dark d-flex justify-content-between">
            <span><?= $list->sq_first_name . ' ' . $list->sq_last_name ?></span>
            <span class="text-muted"><?= $list->sq_email; ?></span>
          </a>
        </li>

      <?php endforeach; ?>
    </ul>
  </div>
</div>

      </div>
    </div>
  </div>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable11').DataTable({
          "bLengthChange": false,
          "order": [
            [4, 'desc']
          ],
        });
          $('#clientbutton').on('click', function() {
    $('#ClientModal').modal('show');
  });
      });
       document.getElementById('nameSearch').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const listItems = document.querySelectorAll('.list-group-item');

    listItems.forEach(function (item) {
      const name = item.textContent.toLowerCase();
      if (name.includes(filter)) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });
    </script>
    <!-- content-wrapper ends -->