<?php
$client_status = $this->config->item('client_status');

?>

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
</style>
<div class="page-wrapper">

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">My Clients</h3>

                </div>

                <div class="col-auto text-right">

                    <a href="<?php echo base_url(); ?>clients_list" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

                    <a class="btn btn-white filter-btn mr-2" href="javascript:void(0);" id="filter_search">

                        <i class="fas fa-filter"></i>

                    </a>

                    <a href="<?php echo base_url('add_client'); ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>

                </div>

            </div>

        </div>

        <!-- /Page Header -->

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
                                        <th>Added</th>
                                        <th>Client Status</th>
                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    if (!empty($lists)) {

                                        $i = 1;

                                        foreach ($lists as $rows) {

                                            if ($rows->sq_status == 0) {
                                                $rows->sq_status = '';
                                            }

                                            if ($rows->status == 1) {

                                                $val = 'checked';

                                                $tag = 'data-toggle="tooltip" title="Click to Deactivate Provider ..!"';
                                            } else {

                                                $val = '';

                                                $tag = 'data-toggle="tooltip" title="Click to Activate Provider ..!"';
                                            }

                                            $profile_img = $rows->profile_img;



                                            if (empty($profile_img)) {

                                                $profile_img = base_url() . 'assets/assets/img/user.jpg';
                                            }

                                            if (!empty($rows->created_at)) {

                                                $date = date(settingValue('date_format'), strtotime($rows->created_at));
                                            } else {

                                                $date = '-';
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
                                                <td><?php echo date('y/m/d', strtotime($rows->sq_client_added)); ?></td>
                                                <td><?php if (isset($client_status[$rows->sq_status])) {
                                                        echo $client_status[$rows->sq_status];
                                                    } ?></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>edit_client/<?php echo base64_encode(base64_encode($rows->sq_client_id)); ?>" class="btn btn-sm bg-success-light mr-2"><i class="far fa-edit mr-1"></i></a>
                                                    <a class="btn btn-sm bg-danger-light mr-2" onclick="deleteClientPopUp(this,<?php echo $rows->sq_client_id ?>);"><i class="far fa-trash-alt mr-1"></i></a>
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

<!-- Initialize DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#clients_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    function deleteClientPopUp(that, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url('deleteClient'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Client has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the client.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
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