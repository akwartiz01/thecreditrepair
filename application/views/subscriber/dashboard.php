<?php $base_url = base_url(); ?>
<style>
    .card.active {
        border: 2px solid green;
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0% {
            box-shadow: 0 0 5px green;
        }

        50% {
            box-shadow: 0 0 20px green;
        }

        100% {
            box-shadow: 0 0 5px green;
        }
    }

    .card.active .btn {
        background-color: green;
        color: white;
        cursor: default;
    }

    .card .btn {
        transition: background-color 0.3s;
    }

    .card .btn:hover {
        background-color: #0056b3;
        /* background-color: #1d2124; */
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


    .cancelSubscription:hover {
        border-color: #0056b3 !important;
    }

    @keyframes shake {
        0% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        50% {
            transform: translateX(5px);
        }

        75% {
            transform: translateX(-5px);
        }

        100% {
            transform: translateX(0);
        }
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
        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">Subscriptions</h3>

                </div>

            </div>

        </div>

        <div class="row pricing-box">


            <?php

            if (!empty($plans)) {
                $current_subscription_id = $plan_id;
                foreach ($plans as $subscription) {


                    if (!empty($subscription['subscription_duration'])) {
                        $str = $subscription['subscription_duration'];

                        $description = (explode(" ", $str));

                        $description = isset($description[1]) ? $description[1] : '';
                        $days = $str;
                    } else {
                        $description = '';
                        $days = '';
                    }
                    if ($subscription['subscription_duration'] == "3 Day Trial") {
                        $subscription_duration = '3 Days';
                    } else {
                        $subscription_duration = $subscription['subscription_duration'];
                    }
                    $subscription_amount = $subscription['price'];

                    switch ($description) {

                        case "Day":

                            $drt = $days;

                            break;

                        case "Days":

                            $drt = $days;

                            break;

                        case "Month":

                            $drt = "Monthly";

                            break;

                        case "Months":

                            $drt = "Monthly";

                            break;

                        case "Year":

                            $drt = "Yearly";

                            break;

                        case "Years":

                            $drt = "Yearly";

                            break;

                        default:

                            $drt = "Monthly";
                    }

            ?>

                    <div class="col-md-6 col-lg-4 col-xl-3">

                        <div class="card <?php echo ($subscription['id'] == $current_subscription_id) ? 'active' : ''; ?>">

                            <div class="card-body">

                                <div class="pricing-header">

                                    <h2><?php echo $subscription['subscription_name']; ?></h2>

                                    <p><?php echo $drt; ?> Price</p>

                                </div>

                                <div class="pricing-card-price">

                                    <h3 class="heading2 price">

                                        <?php echo '$' . $subscription_amount; ?>

                                    </h3>

                                    <p>Duration: <span><?php echo $subscription['subscription_duration']; ?></span></p>

                                </div>

                                <ul class="pricing-options">

                                    <!-- <li>

                                        <i class="far fa-check-circle"></i> One listing submission

                                    </li> -->

                                    <li>

                                        <i class="far fa-check-circle"></i> Team Members: <?php echo $subscription['team_permission']; ?>

                                    </li>

                                    <li>

                                        <i class="far fa-check-circle"></i> Client: <?php echo $subscription['clients_permission']; ?>

                                    </li>

                                    <li>


                                        <i class="far fa-check-circle"></i> <?php echo $subscription_duration; ?> expiration

                                    </li>

                                </ul>

                                <?php if ($subscription['id'] == $current_subscription_id) { ?>
                                    <button class="btn btn-success btn-block" disabled>Current Plan</button>
                                <?php } else { ?>
                                    <a class="btn btn-primary btn-block" onclick="uprade_plan(<?php echo $subscription['id']; ?>,<?php echo $subscription['price']; ?>);">Upgrade</a>
                                <?php } ?>

                            </div>

                        </div>

                    </div>

            <?php

                }
            } else {

                echo '<tr><td colspan="4"><div class="text-center text-muted">No records found</div></td></tr>';
            }

            ?>

        </div>

    </div>

</div>


<!-- The Modal -->
<div class="modal" id="subscription_modal_payment">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Payment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="form-sample" id="addTeamMemberForm" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input type='hidden' name="amount" id="amount" class='form-control card-amount'>
                    <input type="hidden" name="user_id" id="user_id" value="<?=$subscriber_id;?>"/>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Name on Card:</label>
                            <input type='text' name="ccname" id="ccname" class='form-control' size='4'>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Card Number:</label>
                            <input type='text' name="ccnumber" id="ccnumber" autocomplete='off' class='form-control card-number' size='20'>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Expiration Date:</label>
                            <input type='text' name="ccexp" id="ccexp" class='form-control card-expiry-month' placeholder='MMYY' size='4'>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>CVC:</label>
                            <input type='text' name="cvv" id="cvv" autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4'>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="save_card" name="save_card" checked>
                                <label class="form-check-label" for="save_card" style="margin-left: 0px !important;">
                                    Save Card for Auto-Renew Subscription
                                </label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-danger" id="total_amount" onclick="pay_now();"></button>
            </div>

        </div>
    </div>
</div>

<input type="hidden" name="subscription_id" id="subscription_id">
<input type="hidden" name="subscription_price" id="subscription_price">


<div id="loader">
    <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>

<script>

    function uprade_plan(subscription_id, price) {
        $('#subscription_id').val(subscription_id);
        $('#subscription_modal_payment').modal('show');
        $('#amount').val(price);
        $('#total_amount').text('Pay $' + price + '.00');
    }

    function pay_now() {
        let user_id = $('#user_id').val();
        let ccname = $('#ccname').val();
        let ccnumber = $('#ccnumber').val();
        let ccexp = $('#ccexp').val();
        let cvv = $('#cvv').val();
        let amount = $('#amount').val();
        let save_card = $('#save_card').is(':checked') ? '1' : '0';
        let subscription_id = $('#subscription_id').val();


        if (ccname == "" || ccnumber == '' || ccexp == '' || cvv == '' || amount == '') {
            toastr.error("Please provide all mandatory fields!");
            return false;
        } else {
            $('#loader').show();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('upgrade_subscription'); ?>',
                data: {
                    'user_id': user_id,
                    'ccname': ccname,
                    'ccnumber': ccnumber,
                    'ccexp': ccexp,
                    'cvv': cvv,
                    'amount': amount,
                    'save_card': save_card,
                    'subscription_id': subscription_id
                },
                success: function(response) {
                    $('#loader').hide();
                    var data = JSON.parse(response);
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function() {
                    $('#loader').hide();
                    toastr.error('An error occurred while processing your request.');
                }
            });
        }
    }
</script>