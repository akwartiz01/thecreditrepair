<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
            <div class="page-header mb-4">
          <h1> All Activity </h1>
          </div>
      </div>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-3">
                  <label for="member_list" class="form-label">Team Member(s):</label>
                  <select name="teamactivity" class="form-control" onchange="fetchteamactivity(this.value);" id="member_list">
                    <option value="">All activity</option>
                    <?php foreach ($get_allusers_name as $key => $row) { ?>
                      <option value="<?php echo $key; ?>" <?php if ($key == $teamid) {
                                                            echo 'selected';
                                                          } ?>><?php echo $row; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>


              <div class="table-responsive">
                <table class="table" id="datatable1">
                  <thead>
                    <tr>
                      <th> Team Member </th>
                      <th> Message </th>
                      <th> Date & Time </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($fetchactivity) && is_array($fetchactivity)) {
                      foreach ($fetchactivity as $row) { ?>

                        <tr>
                          <td>
                            <img src="<?php echo $row['userprofileimg']; ?>" class="mr-2" alt="image"> <?php echo $row['fullname'] ?>
                          </td>
                          <td> <?php echo $row['message']; ?> </td>
                          <td> <div class="d-none"><?php echo $row['datetime']; ?> </div><?php echo date('d-m-y H:i:s A', strtotime($row['datetime'])); ?>
</td>
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

    </div>
  </div>
</div>

<form id="activityform" method="post" action="<?php echo base_url(); ?>allactivity">
  <input type="hidden" name="teamid" id="teamid" value="">
</form>
<script type="text/javascript">
  $(document).ready(function() {

    $('#datatable1').DataTable({

      "bLengthChange": false,
      "order": [
        [2, 'desc']
      ],
    });
  });

  function fetchteamactivity(that) {

    $('form#activityform input#teamid').val(that);
    $('form#activityform').submit();

  }
</script>