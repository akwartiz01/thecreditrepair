<div class="container-fluid page-body-wrapper">
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Auto E-mails (<?php echo $get_client_info->sq_first_name.' '.$get_client_info->sq_last_name;?>) </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Auto E-mails</li>
                </ol>
              </nav>
            </div>
            <div class="card">
              <div class="card-body">
                    <div class="row">
                        <div class="col-md-9" style="text-align: left;" >
                          <h5 class="text-primary">Below tick box shows how many auto emails sent to this clients!</h5>
                        </div>
                        <div class="col-md-3" style="text-align: right;" >
                          <a onclick="backtoprevious();">
                            <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-arrow-left-thick btn-icon-prepend"></i> Back </button>
                         </a>
                        </div>
                       
                    </div>

                  <div class="row mt-4">
                    <div class="col-md-12 ">
                      <table class="table datatable">
                        <thead>
                          <tr>
                            <th>S. No.</th>
                            <th>Template Name</th>
                            <th>Sent E-mails</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $count = 0;
                          if(isset($GetAutoEmailTemp) && is_array($GetAutoEmailTemp)){ 
                                  foreach($GetAutoEmailTemp as $row){  $count++; ?>
                                    <tr>
                                      <td><?php echo $count;?></td>
                                      <td><?php echo $row->temp_name;?></td>
                                      <td>
                                        <input type="checkbox" name="chkornot" <?if(isset($fetchSentEmailTemp[$row->id]) == 1){echo 'checked="checked"';}?> >
                                      </td>
                                    </tr>

                                  <?php } }else{ ?>
                                    <tr>
                                      <td colspan="3">No Notes found for this client!</td>
                                    </tr>
                                  <?php } ?>
                        </tbody>
                        
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script type="text/javascript">

        function backtoprevious(){
          window.history.back();
        }
      </script>