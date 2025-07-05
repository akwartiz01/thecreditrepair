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
        <?php
$subscriber_id = $this->session->userdata('user_id');
$this->db->where('sq_u_id_subscriber', $subscriber_id);
$payment_details = $this->db->get('sq_subscription_payment_details')->row_array();
if (!empty($payment_details['subscription_end_date'])) {
    $end_date = strtotime($payment_details['subscription_end_date']);
    $today = strtotime(date('d-m-Y'));

    if ($end_date < $today) {
        // Subscription is expired
        echo '<div class="alert alert-danger">Your subscription has expired.</div>';
    }
}
?>

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">My Team Members</h3>

                </div>

                <div class="col-auto text-right">

                    <a href="<?php echo base_url(); ?>team-members" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

                    <a class="btn btn-white filter-btn mr-2" href="javascript:void(0);" id="filter_search">

                        <i class="fas fa-filter"></i>

                    </a>

                    <a href="<?php echo base_url('add_team_member'); ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>

                </div>

            </div>

        </div>


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

                                    if (!empty($team_member_list)) {

                                        $i = 1;

                                        foreach ($team_member_list as $rows) {


                                            $profile_img = $rows->sq_u_profile_picture;

                                            $empId = $rows->sq_u_id;
                                            $encode = base64_encode(urlencode($empId * 12345678) / 12345);

                                            if (empty($profile_img)) {

                                                $profile_img = 'assets/assets/img/user.jpg';
                                            } ?>

                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="" class="avatar avatar-sm mr-2">
                                                            <img class="avatar-img rounded-circle" src="<?php echo $profile_img; ?>">
                                                        </a>
                                                        <a href=""><?php echo $rows->sq_u_first_name . ' ' . $rows->sq_u_last_name; ?></a>
                                                    </h2>
                                                </td>
                                                <td><?php echo $rows->sq_u_email_id; ?></td>
                                                <td style="text-align: left !important;"><?php echo $rows->sq_u_phone; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>edit_team_member/<?php echo $encode; ?>" class="btn btn-sm bg-success-light mr-2"><i class="far fa-edit mr-1"></i></a>
                                                    <a class="btn btn-sm bg-danger-light mr-2" onclick="deleteTeam_member(this,<?php echo $rows->sq_u_id ?>);"><i class="far fa-trash-alt mr-1"></i></a>
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

    function deleteTeam_member(that, id) {
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
                    url: '<?php echo base_url('deleteTeam_Member'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Team member has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the team member.',
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