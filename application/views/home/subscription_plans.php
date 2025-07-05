<style>
    section#plans {
        margin-top: 120px !important;
    }
    .order-rm .col-xxl-3.col-lg-4.col-md-6
    {
        order:1;
    }
     .order-rm .col-xxl-3.col-lg-4.col-md-6:nth-child(3) {
    order:2;
}
 .order-rm .col-xxl-3.col-lg-4.col-md-6:nth-child(4) {
    order:3;
}
.order-rm .col-xxl-3.col-lg-4.col-md-6:nth-child(2) {
    order:4;
}
.order-rm .col-xxl-3.col-lg-4.col-md-6:nth-child(5) {
    order:5;
}
</style>
<section class="subscription bg-primary section-gap" id="plans">
    <div class="container">
        <div class="row mb-2 justify-content-center">
            <div class="col-xxl-9">
                <div class="title text-center mb-4">
                    <h2 class="mb-4">CRX Credit Repair Software</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center order-rm">

            <?php

            if (!empty($plans)) {

                foreach ($plans as $subscription) {
                    $subscription_amount = $subscription['price'];

                    // if ($subscription['subscription_duration'] == "3 Day Trial") {
                    //     $subscription_duration = '3 Days';
                    // } else {
                    //     $subscription_duration = $subscription['subscription_duration'];
                    // }

                    switch ($subscription['subscription_duration']) {
                        case "3 Days":
                            $subscription_duration = '3 Days';
                            $subscription_duration_text = '';
                            break;
                        case "1 Month":
                            $subscription_duration = 'Monthly';
                            $subscription_duration_text = '/month';
                            break;
                        case "3 Months":
                            $subscription_duration = 'Quarterly';
                            $subscription_duration_text = '/quarterly';
                            break;
                        case "6 Months":
                            $subscription_duration = 'Semi-Annual';
                            $subscription_duration_text = '/semi-annual';
                            break;
                        case "1 Year":
                            $subscription_duration = 'Annual';
                            $subscription_duration_text = '/annual';
                            break;
                    }
            ?>
                    <div class="col-xxl-3 col-lg-4 col-md-6">
                        <div class="card price-card shadow-none">
                            <div class="card-body">
                                <span class="price-badge bg-dark"><?php echo $subscription['subscription_name']; ?></span>
                                <span class="mb-4 f-w-600 p-price" style="font-size: 50px !important;"><?php echo '$' . $subscription_amount; ?><small class="text-sm"><?php echo $subscription_duration_text; ?></small></span>

                                <div class="form-check text-start" style="padding-left:0px">
                                    <label class="form-check-label" for="customCheckc1">
                                        <ul style="margin-bottom:0px">

                                            <li>
                                                <label class="form-check-label" for="customCheckc1" style="padding-left:0px">This is a <?php echo $subscription['subscription_name']; ?>.
                                                </label>
                                            </li>

                                            <li>
                                                <label class="form-check-label" for="customCheckc1" style="padding-left:0px">Team Members: <?php echo $subscription['team_permission']; ?>
                                                </label>
                                            </li>

                                            <li>
                                                <label class="form-check-label" for="customCheckc1" style="padding-left:0px">Clients: <?php echo $subscription['clients_permission']; ?>
                                                </label>
                                            </li>

                                            <li>

                                                <label class="form-check-label" for="customCheckc1" style="padding-left:0px">Subscription: <?php echo $subscription_duration; ?>
                                                </label>
                                            </li>

                                            <li>
                                                <label class="form-check-label" for="customCheckc1" style="padding-left:0px">Data Storage: Unlimited </label>
                                            </li>
                                        </ul>

                                    </label>

                                </div>

                                <div class="d-grid">
                                    <a class="btn btn-primary rounded-pill" style="color: white !important;" onclick="subscribe(<?php echo $subscription['id']; ?>,<?php echo $subscription['price']; ?>);">Subscribe<i data-feather="log-in" class="ms-2"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php }
            }
            ?>

        </div>
    </div>
</section>

<section class="faqs section-gap bg-gray-100" id="faq">
    <div class="container">
        <div class="row mb-2">
            <div class="col-xxl-12">
                <div class="title mb-4">
                    <!-- <span class="d-block mb-2 fw-bold text-uppercase">Faq</span> -->
                    <h2 class="mb-4">Frequently Asked Question</h2>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading0">
                            <button class="accordion-button collapsed fw-bold" type="button"
                                data-toggle="collapse" data-target="#flush-0"
                                aria-expanded="false" aria-controls="flush-collapse0">
                                How long will it take to repair my credit?
                            </button>
                        </h2>
                        <div id="flush-0" class="accordion-collapse collapse"
                            aria-labelledby="flush-heading0" data-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Each situation is different, but most of our customers see results within 60-90 days.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading2">
                            <button class="accordion-button collapsed fw-bold" type="button"
                                data-toggle="collapse" data-target="#flush-2"
                                aria-expanded="false" aria-controls="flush-collapse2">
                                How do you restore bad credits?
                            </button>
                        </h2>
                        <div id="flush-2" class="accordion-collapse collapse"
                            aria-labelledby="flush-heading2" data-parent="#accordionFlushExample">
                            <div class="accordion-body">
                            First, we will evaluate your credit history and dispute at any incorrect findings. Then, we will priotize the actions that will improve your credit score the fastest.
                            </div>
                        </div>
                    </div>
            

                </div>
            </div>
            <div class="col-md-6">
                <div class="accordion accordion-flush" id="accordionFlushExample2">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading3">
                            <button class="accordion-button collapsed fw-bold" type="button"
                                data-toggle="collapse" data-target="#flush-3"
                                aria-expanded="false" aria-controls="flush-collapse3">
                                How much will my score increase?
                            </button>
                        </h2>
                        <div id="flush-3" class="accordion-collapse collapse"
                            aria-labelledby="flush-heading3" data-parent="#accordionFlushExample2">
                            <div class="accordion-body">
                            No two credit histories are the same. That said, depending upon the situation, we have seen increases as large as 200+ points.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>