<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<style>
    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #dee2e6;
    }

    /* Pending status: Red background */
    .status-pending {
        background-color: #dc3545;
        /* background: linear-gradient(to right, #ffbf96, #fe7096); */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    /* Paid status: Green background */
    .status-paid {
        background-color: #28a745;
        /* background: linear-gradient(to right, #84d9d2, #07cdae); */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    /* Default status: Grey background (for other statuses) */
    .status-default {
        background-color: #6c757d;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    td a.text-primary:hover {
        text-decoration: underline !important;
        cursor: pointer;
    }

    td a.preview_invoice:hover {
        text-decoration: underline !important;
        cursor: pointer;
    }

    #previewModal .table thead th {
        color: white !important;
    }

    .btn-view-report:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }

    .btn-download-report:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }

    .invalid-feedback {
        font-size: 14px !important;
    }

    /* Loader CSS s*/
    #loader {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Loader CSS e*/
</style>

<div class="page-wrapper">

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">Credit Reports</h3>

                </div>

                <div class="col-auto text-right">

                    <!-- <a href="" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a> -->

                    <!-- <a class="btn btn-primary add-button get_new_report"><i class="fas fa-plus"></i></a> -->

                </div>

            </div>

        </div>

        <!-- /Page Header -->

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="form-group" style="float: right;">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- <button type="button" class="btn btn-primary" id="get_new_report">Order New Report</button> -->
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">

                            <table class="table custom-table mb-0 w-100 credit_report_table" id="credit_report_table">

                                <thead>

                                    <tr>
                                        <th style="text-align: center !important;">#</th>
                                        <th style="text-align: center !important;">Report</th>
                                        <th style="text-align: center !important;">Last Report Date</th>
                                        <th style="text-align: center !important;">Action</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <?php if (!empty($reports && $reports[0]->credit_report_path)):
                                        $srno = 0;

                                    ?>

                                        <?php foreach ($reports as $report):
                                            $srno++;
                                        ?>
                                            <tr>
                                                <td style="text-align: center !important;"><?php echo  $srno; ?></td>
                                                <td style="text-align: center !important;"><?php echo basename($reports[0]->credit_report_path); ?></td>
                                                <td style="text-align: center !important;"><?php echo $reports[0]->created_at; ?></td>
                                                <td style="text-align: center !important;">
                                                    <a href="<?php echo base_url('client/Client/view_credit_report/' . $reports[0]->userId . '/' . urlencode(basename($reports[0]->credit_report_path))); ?>" class="btn btn-secondary btn-view-report" style="color: white !important;">View</a>

                                                    <a href="<?php echo $reports[0]->credit_report_path; ?>" class="btn btn-primary btn-download-report" download>Download</a>
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

        </div>

    </div>

</div>

<!-- Modal for Viewing Report -->
<div class="modal fade" id="viewReportModal" tabindex="-1" role="dialog" aria-labelledby="viewReportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewReportLabel">View Credit Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="reportFrame" src="" width="100%" height="500px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="hidden_id" value="<?php echo $this->session->userdata('user_id'); ?>">
<div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>
<!-- Initialize DataTables -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#credit_report_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    $(document).on('click', '.btn-view-report', function(e) {
        e.preventDefault();
        var reportUrl = $(this).attr('href');
        $('#reportFrame').attr('src', reportUrl);
        $('#viewReportModal').modal('show');
    });

    $(document).on('click', '#get_new_report , .get_new_report', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to download the new report.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, download it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loader').show();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "creditheroscore/get_new_report"; ?>',
                    data: {

                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $('#loader').hide();
                        if (res.status === 'success') {
                            Swal.fire({
                                title: 'Success',
                                text: res.message,
                                icon: 'success',
                                showConfirmButton: true,
                            }).then(() => {
                                location.reload();
                            });
                        } else if (res.status === 'error') {

                            Swal.fire({
                                title: 'Error',
                                text: res.message,
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'There was an issue. Please try again.',
                            showConfirmButton: true,
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
</script>