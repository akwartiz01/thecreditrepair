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
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        padding:0!important;
    }
</style>
<div class="page-wrapper">

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header my-3">

            <div class="row">

                <div class="col">

                    <h1>Quick Notes</h1>

                </div>

                <div class="col-auto text-right">

                    <a href="<?php echo base_url(); ?>quick_notes" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

                    <a href="<?php echo base_url('add_quick_notes'); ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>

                </div>

            </div>

        </div>

        <!-- /Page Header -->

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                             <table id="order-listing" class="table jsgrid datatable">

                                <thead>

                                    <tr>

                                  
                                        <th style="text-align: left !important;">Date Created</th>
                                        <th style="text-align: left !important;">Titile</th>
                                        <th style="text-align: left !important;">Body</th>
                                        <th style="text-align: left !important;">Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    if (!empty($Qnotes)) {

                                        $sr_no = 0;

                                        foreach ($Qnotes as $rows) {
                                            $sr_no++;
                                    ?>
                                            <tr>
                                         

                                                <td style="text-align: left !important;">   <?php echo date('m/d/Y', strtotime($rows->created_at)); ?></td>
                                                <td style="text-align: left !important;"><?php echo $rows->title; ?></td>
                                                <!-- <td style="text-align: left !important;"><?php echo $rows->body; ?></td> -->
                                                <td style="text-align: left !important;">
                                                    <?php
                                                    $trimmed_body = strip_tags($rows->body); // To remove HTML tags, if any
                                                    echo (strlen($trimmed_body) > 100) ? substr($trimmed_body, 0, 100) . '...' : $trimmed_body;
                                                    ?>
                                                </td>

                                                <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center">
                                                    <a href="<?php echo base_url(); ?>edit_quick_notes/<?php echo base64_encode(base64_encode($rows->id)); ?>"><i class="far fa-edit mr-1"></i></a>
                                                    <a class="" onclick="deleteQuickNotes(this,<?php echo $rows->id ?>);"><i class="far fa-trash-alt mr-1"></i></a>
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
        $('#quick_notes_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    function deleteQuickNotes(that, id) {
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
                    url: '<?php echo base_url('deleteQuickNotes'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Note has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the note.',
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