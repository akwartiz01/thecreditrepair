<style>
  .category_sec .sec {
    display: inline-block;
  }

  .category_sec label {
    vertical-align: text-top;
    padding-left: 5px;
  }

  #managecategory .modal-footer {
    margin: 10px 24px;
    border-top: 1px solid #80808091;
    padding: 0;
  }

  #managecategory table th {
    background: #80808014;
  }

  .swal-footer {
    text-align: center;
  }

  .modal-content {
    background: #fff;
  }

  .modal-content .modal-header {
    padding-bottom: 15px;
    margin-bottom: 25px;
  }
</style>

<?php if ($this->session->flashdata('success')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style=""><?php echo $this->session->flashdata('success'); ?></div>
      <div class="swal-footer">
        <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button>
          <div class="swal-button__loader">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>


<div id="deletePopup" class="swal-overlay swal-overlay--show-modal" tabindex="-1" style="display: none;">
  <div id="deletePopupModal" class="swal-modal" role="dialog" aria-modal="true" style="display: none;">
    <input type="hidden" name="hiddentemplateId" id="hiddentemplateId" value="">
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
        <button class="swal-button swal-button--confirm btn btn-primary" onclick="deleteClient();">OK</button>
        <div class="swal-button__loader">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="managecategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><b>Manage Category</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="padding: 0px 0px;">
        <?php echo form_open(base_url("Admin/add_template_category"), array("class" => "form-horizontal")) ?>
        <div class="form-group">
          <div class="col-md-12 ui-front category_sec">
            <label for="p-in" class="col-md-2 label-heading sec">Category</label>
            <input type="text" class="col-md-6 form-control sec" name="category_name" value="" required>
            <div class="col-md-3 sec">
              <input type="submit" class="btn btn-primary" value="Add">
            </div>
          </div>
        </div>
        <?php echo form_close() ?>
      </div>
      <div class="modal-footer">
        <table id="order-listing" class="table jsgrid">
          <thead>
            <tr>
              <th>Category Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($templates_category) && is_array($templates_category) && count($templates_category) > 0) {

              foreach ($templates_category as $row) {  ?>
                <tr>
                  <td><?php echo $row->category_name ?></td>
                  <td style="width: 1%">
                    <a href="<?php echo base_url("Admin/delete_template_category/") . $row->id; ?>" title="Delete"><i class="mdi mdi-trash-can"></i></a>
                  </td>
                </tr>
              <?php }
            } else { ?>
              <td colspan="4" style="text-align: center;">No Records found</td>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header mb-0">
            <div class="page-header mb-4">
          <h1> Letters</h1>
          </div>
        <!--<h3 class="page-title">Search Letters </h3>-->
        <!--<nav aria-label="breadcrumb">-->
        <!--  <ol class="breadcrumb">-->
        <!--    <li class="breadcrumb-item"><a href="#">Home</a></li>-->
        <!--    <li class="breadcrumb-item active" aria-current="page">Search Letters</li>-->
        <!--  </ol>-->
        <!--</nav>-->
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">

            <div class="col-12 d-flex" style="justify-content: right;">

              <a href="<?php echo base_url(); ?>add_template"><button type="button" class="btn btn-gradient-primary btn-icon-text mb-3 mr-2">
                  <i class="mdi mdi-account btn-icon-prepend"></i> Add New Letter </button></a>

              <button type="button" class="btn btn-gradient-primary btn-icon-text mb-3" data-toggle="modal" data-target="#managecategory">
                Manage Category </button>
            </div>
          </div>

    <div class="row">
  <div class="col-12">
    <form method="get">
      <div class="row g-3 align-items-end mb-4">
        <!-- Letter Title -->
        <div class="col-md-3 mb-3">
          <label class="form-label">Letter Title</label>
          <input type="text" name="srch_title" class="form-control"
            value="<?php echo $srch_title; ?>" placeholder="Enter title">
        </div>

        <!-- Category -->
        <div class="col-md-2 mb-3">
          <label class="form-label">Category</label>
          <select name="category" class="form-control text-dark">
            <option value="">All</option>
            <?php foreach ($templates_category as $categories) { ?>
              <option value="<?php echo $categories->id; ?>" 
                <?php echo ($category == $categories->id) ? 'selected' : ''; ?>>
                <?php echo $categories->category_name; ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <!-- Quick Filter -->
        <div class="col-md-2 mb-3">
          <label class="form-label">Quick Filter</label>
          <select name="qfilter" class="form-control text-dark">
            <option value="">All</option>
            <option value="1" <?php if ($qfilter == 1) echo 'selected'; ?>>Active</option>
            <option value="0" <?php if ($qfilter === '0') echo 'selected'; ?>>Inactive</option>
          </select>
        </div>

        <!-- Submit Button -->
        <div class="col-md-2 mb-3">
          <button type="submit" name="button" class="btn btn-gradient-primary w-100">
            Search
          </button>
        </div>
      </div>
    </form>
  </div>
</div>


          <div class="row mt-4">
            <div class="col-12">
                <div class="table-responsive">
              <table class="table datatable">
                <thead>
                  <tr>
                      <th style="display:none;">Letter ID</th> <!-- hidden id column -->
                    <th>Letter Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th> </th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php if (isset($templates) && is_array($templates) && count($templates) > 0) {

                    foreach ($templates as $row) {  ?>
                      <tr>
                            <td style="display:none;"><?= $row->id; ?></td> <!-- hidden id -->
                        <td style="width: 50%;white-space: unset;"><?php echo $row->letter_title; ?></td>
                        <td><?php echo get_template_category_name($row->category) ?></td>
                        <td><?php if ($row->status == 1) {
                              echo "Active";
                            } else {
                              echo "Inactive";
                            } ?></td>
                        <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="text-align: right;">

                          <a class="text-success" href="<?php echo base_url("edit_template/") . $row->id; ?>" title="Edit"><i class="mdi mdi-pencil"></i></a>
                          <a class="text-success" onclick="deleteClientPopUp(this,<?php echo $row->id ?>);" title="Delete"><i class="mdi mdi-delete"></i></a>

                        </td>
                      </tr>
                    <?php }
                  } else { ?>
                    <td colspan="4" style="text-align: center;">No Records found</td>
                  <?php } ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->

    <script type="text/javascript">
      function deleteClientPopUp(that, id) {

        $('#hiddentemplateId').val(id);
        $('#deletePopup').css('display', '');
        $('#deletePopupModal').css('display', '');
        $('#loader').css('display', '');

      }

      function deleteCancel() {
        $('#deletePopup').css('display', 'none');
        $('#deletePopupModal').css('display', 'none');
      }

      function closeSuccessModal() {
        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');
      }

      function deleteClient() {

        var id = $('#hiddentemplateId').val();
        window.location.href = "Admin/delete_template/" + id;

      }
    </script>
  