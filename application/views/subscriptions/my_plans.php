<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<style type="text/css">
    .modal .modal-dialog .modal-content .modal-body {
        padding: 0px 26px 0px 26px !important;
    }

    .modal .modal-dialog .modal-content .modal-header {
        padding: 12px 26px;
    }

    label {
        font-weight: 600;
    }

    i.mdi {
        font-size: 18px;
    }

    /* start */
    .container_plan {
        margin: auto;
        overflow: hidden;
    }

    .container_plan h1 {
        text-align: center;
        margin: 20px 0;
    }

    .container_plan .plans {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .container_plan .plan {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 10px;
        text-align: center;
        width: 300px;
        transition: transform 0.3s ease-in-out;
    }

    .container_plan .plan:hover {
        /*transform: scale(1.05);*/
        transform: scale(1);
        border: 1px solid #28a745;
        background: ghostwhite;
    }

    .container_plan h2 {
        color: #333;
    }

    .container_plan .rate {
        font-size: 24px;
        margin: 10px 0;
    }

    .container_plan ul {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .container_plan li {
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .container_plan .subscribe {
        background: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease-in-out;
    }

    .container_plan .subscribe:hover {
        background: #218838;
    }

    .container_plan .btn-group {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .container_plan .btn-edit,
    .btn-delete {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        border: none;
        border-radius: 24px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .container_plan .btn-edit {
        background-color: #28a745;
    }

    .container_plan .btn-edit:hover {
        /*background-color: #218838;*/
        text-decoration: underline;
        color: white;

    }

    .container_plan .btn-delete {
        background-color: #dc3545;
    }

    .container_plan .btn-delete:hover {
        background-color: #c82333;
        text-decoration: underline;
    }

    .swal-button:hover {
        background-color: #218838 !important;
        border-color: #218838 !important;
    }

    /* end */
</style>
<?php
$client_status = $this->config->item('client_status');

?>
<style type="text/css">
    .modal .modal-dialog .modal-content .modal-body {
        padding: 0px 26px 0px 26px;
    }
</style>
<div id="deletePopup" class="swal-overlay swal-overlay--show-modal" tabindex="-1" style="display: none;">
    <div id="deletePopupModal" class="swal-modal" role="dialog" aria-modal="true" style="display: none;">
        <input type="hidden" name="hiddenClientId" id="hiddenClientId" value="">
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

<div id="msgAppend">
</div>

<?php if ($this->session->flashdata('success')) { ?>
    <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
        <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
            <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
                <div class="swal-icon--success__ring"></div>
                <div class="swal-icon--success__hide-corners"></div>
            </div>
            <div class="swal-title" style="">Email Notification!</div>
            <div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div>
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
<?php if ($this->session->flashdata('plan_success')) { ?>
    <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
        <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
            <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
                <div class="swal-icon--success__ring"></div>
                <div class="swal-icon--success__hide-corners"></div>
            </div>
            <div class="swal-title" style="">Plan Notification!</div>
            <div class="swal-text" style=""><?php echo $this->session->flashdata('plan_success'); ?></div>
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
<!-- create a card like plans in html show price and name of the plan. mention team member limit and client member limit on the card -->
<!-- partial -->
<div class="container-fluid page-body-wrapper" style="background-color: #f4f4f4 !important;">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header mb-0">
                  <div class="page-header mb-4">
          <h1> My Plans </h1>
          </div>
                <!--<h3 class="page-title">My Plans</h3>-->
                <!--<nav aria-label="breadcrumb">-->
                <!--    <ol class="breadcrumb">-->
                <!--        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>-->
                <!--        <li class="breadcrumb-item active" aria-current="page">My Plans</li>-->
                <!--    </ol>-->
                <!--</nav>-->
            </div>
            <div class="card mb-2" style="background-color: #f4f4f4;">
                <div class="col-12" style="float: right!important;padding-right: 0px;">
                    <button type="button" class="btn btn-success btn-sm float-right" onclick="createPlan();"><i class="fa fa-plus"></i> Add Plan</button>
                </div>
            </div>

            <div class="container_plan">
                <?php
                if (!empty($plans)) { ?>

                   <div class="plans" id="plansSortable">
    <?php foreach ($plans as $key => $value): 
        $duration = $value->subscription_duration;
        if ($duration == '3-day Trial') $duration = '3 Day';
        elseif ($duration == '1 Month') $duration = 'Monthly';
        elseif ($duration == '3 Month') $duration = 'Quarterly';
        elseif ($duration == '6 Month') $duration = 'Half-Yearly';
        elseif ($duration == '1 Year') $duration = 'Yearly';
    ?>
        <div class="plan" data-id="<?php echo $value->id; ?>">
            <h2><?php echo $value->subscription_name ?></h2>
          <p class="rate">$<?php echo $value->price; ?></p>

            <ul>
                <li>Duration: <?php echo $duration; ?></li>
                <li>Team Members: <?php echo $value->team_permission ?></li>
                <li>Clients: <?php echo $value->clients_permission ?></li>
                <li>Data Storage: Unlimited</li>
            </ul>

            <div class="btn-group">
                <a onclick="editPlans(<?php echo $value->id ?>)" class="btn-edit">Edit</a>
                <a onclick="removePlan(<?php echo $value->id ?>)" class="btn-delete" style="color:white;">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
                <?php } else {

                    echo '<tr><td colspan="4"><div class="text-center text-muted">No records found</div></td></tr>';
                }
                ?>

            </div>
            <!--  -->

        </div>

        <!------------------------------>
        <div class="modal fade" id="plansModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: white;">
                    <form method="post" action="<?php echo base_url('addNewPlan'); ?>" enctype="Multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Add Plan</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="planID">
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label>Name:</label>
                                    <input type="text" name="subscription_name" class="form-control" id="subscription_name" placeholder="Enter plan name">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label>Price:</label>
                                    <input type="number" name="price" class="form-control" id="price" placeholder="Enter price">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label>Subscription Durations:</label>

                                    <select class="form-select form-control" id="subscription_duration" name="subscription_duration" style="outline: 1px solid #d0d0d0 !important;">
                                        <option selected value="0">Select</option>
                                        <option value="3 Days">3-day Trial</option>
                                        <option value="1 Month">1 Month</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="6 Months">6 Months</option>
                                        <option value="1 Year">1 Year</option>
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label>Team Permission:</label>
                                    <input type="text" name="team_permission" class="form-control" id="team_permission" placeholder="Enter team permission">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label>Client's Permission:</label>
                                    <input type="text" name="clients_permission" class="form-control" id="clients_permission" placeholder="Enter client's permission">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" name="sub_note" class="btn btn-primary btn-sm" id="save_plan">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!------------------------------>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript">
            $("#save_plan").click(function() {
                let price = $("#price").val();
                if (price < 1) {
                    toastr.error('Please enter price greater than 0.');
                    $('#price').focus();
                    $('#price').css('border-color', 'red');
                    return false;
                }
            });

            function closeSuccessModal() {
                $('#pDsuccess').css('display', 'none');
                $('#pDMsuccess').css('display', 'none');

                location.reload();
            }

            function createPlan() {

                $('#plansModal input[name="subscription_name"]').val('');
                $('#plansModal input[name="price"]').val('');
                $('#plansModal input[name="subscription_duration"]').val('');
                $('#plansModal input[name="team_permission"]').val('');
                $('#plansModal input[name="clients_permission"]').val('');
                $('#plansModal').modal('show');
            }

            function editPlans(rowID) {

                if (rowID != '') {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('editPlan'); ?>',
                        data: {
                            'id': rowID
                        },
                        success: function(response) {

                            var data = JSON.parse(response);

                            $('#plansModal input[name="planID"]').val(data.id);
                            $('#plansModal input[name="subscription_name"]').val(data.subscription_name);
                            $('#plansModal input[name="price"]').val(data.price);
                            $('#plansModal select').val(data.subscription_duration);
                            $('#plansModal input[name="team_permission"]').val(data.team_permission);
                            $('#plansModal input[name="clients_permission"]').val(data.clients_permission);

                            $('#plansModal').modal('show');
                        }
                    });
                }
            }

            function removePlan(rowID) {

                if (rowID != '') {
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
                                type: 'POST',
                                url: '<?php echo base_url('deletePlan'); ?>',
                                data: {
                                    'id': rowID
                                },
                                success: function(response) {

                                    if (response == '1') {

                                        var succesMsg = '<div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Plan Deleted!</div><div class="swal-text" style="">Plan deleted successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

                                        $('#msgAppend').after(succesMsg);

                                    }
                                }
                            });
                        }
                    });
                }
            }
        </script>
        <script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('plansSortable');
    new Sortable(el, {
        animation: 150,
        onEnd: function (evt) {
            let order = [];
            document.querySelectorAll('#plansSortable .plan').forEach((el) => {
                order.push(el.getAttribute('data-id'));
            });

            // Send new order to server
            fetch('<?php echo base_url(); ?>save_plan_order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({order: order})
            }).then(response => response.json())
.then(res => {
    if (res.status === 'success') {
        Swal.fire({
            title: 'Success',
            text: res.message,
            icon: 'success'
        });
    } else {
        Swal.fire({
            title: 'Error',
            text: res.message || 'Something went wrong',
            icon: 'error'
        });
    }
});
        }
    });
});
</script>
