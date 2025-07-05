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
            <div class="page-header">
                <h3 class="page-title">Saved Letters</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Saved Letters</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Letter Name</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr_no = 1;
                                    if (!empty($saved_letters)):
                                        foreach ($saved_letters as $key => $value): ?>
                                            <tr>
                                                <td><?php echo $sr_no++; ?></td>
                                                <td><?php echo htmlspecialchars($value->letter_name); ?></td>
                                                <td><?php echo htmlspecialchars($value->created_at); ?></td>
                                                <td>
                                                    <a href="#" title="Preview" class="text-primary openPrintPreview"
                                                        data-toggle="modal" data-target="#printModal"
                                                        data-letter-content="<?php echo htmlspecialchars($value->client_letter); ?>" data-letter-date="<?php echo htmlspecialchars($value->created_at); ?>">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="#" title="Edit" class="text-success">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <a href="#" title="Delete" class="text-success">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- Print Modal s -->

            <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="printModalLabel">Preview letter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div id="print-content">
                                <div id="letter_content"></div>
                                <p>Date: <span id="modal-date"></span></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="printDiv('print-content')">Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Print Modal e -->


            <!-- Initialize DataTables -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.6/purify.min.js"></script>

            <!-- <script>
                $(document).ready(function() {
                    $('#save_letters').DataTable({
                        "paging": true,
                        "searching": true,
                        "info": true
                    });
                });
            </script> -->

            <script>
                var signatureUrl = "<?php echo $client_result->agreement_sign; ?>";

                $(document).on('click', '.openPrintPreview', function() {
                    var letterContent = $(this).data('letter-content');
                    var letterDate = $(this).data('letter-date');
                    $('#modal-date').text(letterDate);
                    var signatureBoxContent = "";

                    // Check if there's a saved signature URL
                    if (signatureUrl) {
                        // Prepare signatureBox content
                        signatureBoxContent = '<img src="' + signatureUrl + '" alt="Saved Signature" id="img-signature">';
                    }

                    // Replace `{client_signature}` in letterContent with signatureBoxContent
                    if (letterContent.includes("{client_signature}")) {
                        letterContent = letterContent.replace("{client_signature}", signatureBoxContent);
                    }

                    // Set the updated content to the preview container
                    $('#letter_content').html(letterContent);
                });

                function printDiv(divId) {
                    var divToPrint = document.getElementById(divId).innerHTML;
                    var newWin = window.open('', 'Print-Window');
                    newWin.document.open();
                    newWin.document.write('<html><body onload="window.print()">' + divToPrint + '</body></html>');
                    newWin.document.close();
                    setTimeout(function() {
                        newWin.close();
                    }, 10);
                }
            </script>