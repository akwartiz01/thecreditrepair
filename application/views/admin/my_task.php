<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
            <div class="page-header mb-4">
          <h1> My Tasks </h1>
          </div>
      </div>
        <div class="table-responsive">
                <table class="table" id="datatable1">
                 <thead class="table-dark">
                    <tr>
                        <th>Type</th>
                      <th> Task </th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($tasks_data) && is_array($tasks_data)) {
                      foreach ($tasks_data as $row) { ?>

                        <tr>
                         <td> <?php echo $row->task_type; ?> </td>
                          <td> <?php echo $row->notes; ?> </td>

                        </tr>

                    <?php }
                    } ?>

                  </tbody>
                </table>
              </div>
      </div>
      </div>
      </div>