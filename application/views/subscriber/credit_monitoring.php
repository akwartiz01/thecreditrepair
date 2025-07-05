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

    /* Loader CSS */
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
</style>
<div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>


<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Credit Monitoring</h3>
                </div>
                <div class="col-auto text-right">
                    <a href="<?php echo base_url('credit-monitoring'); ?>" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>
                    <a class="btn btn-white filter-btn mr-2" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                    <!-- <a href="" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a> -->
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="coming-soon">
                            <h2>Coming Soon</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table custom-table mb-0 w-100 clients_table" id="clients_table">

                                <thead>

                                    <tr>

                                        <th>#</th>

                                        <th>Name</th>

                                        <th>Email</th>
                                        <th style="text-align: left !important;">Contact No</th>
                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    if (!empty($client_list)) {

                                        $i = 1;

                                        foreach ($client_list as $rows) {


                                            $profile_img = $rows->profile_img;



                                            if (empty($profile_img)) {

                                                $profile_img = base_url() . 'assets/assets/img/user.jpg';
                                            } ?>

                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="" class="avatar avatar-sm mr-2">
                                                            <img class="avatar-img rounded-circle" src="<?php echo $profile_img; ?>">
                                                        </a>
                                                        <a href=""><?php echo $rows->sq_first_name . ' ' . $rows->sq_last_name; ?></a>
                                                    </h2>
                                                </td>
                                                <td><?php echo $rows->sq_email; ?></td>
                                                <td style="text-align: left !important;"><?php echo $rows->sq_phone_mobile; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-success" onclick="send_invite(<?php echo $rows->sq_client_id ?>);">Send Invite</button>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#clients_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    function send_invite(sq_client_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send invite!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loader
                $('#loader').show();

                $.ajax({
                    url: '<?php echo base_url('credit_monitoring_invite'); ?>',
                    type: 'POST',
                    data: {
                        sq_client_id: sq_client_id
                    },
                    success: function(response) {
                        $('#loader').hide();
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Invited!',
                                'Invitation has been sent successfully.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem inviting the client.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loader').hide();
                        Swal.fire(
                            'Error!',
                            'There was a problem processing your request.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>