<?php

$firstname = $client[0]->sq_first_name;
$lastname  = $client[0]->sq_last_name;
$fullname  = strtoupper($firstname . ' ' . $lastname);

?>
<style type="text/css">
    #order-listing {
        border-collapse: collapse;
    }

    /*#order-listing thead th {*/
    /*    background-color: #3972fc;*/
    /*    color: #fff;*/
    /*    font-size: 0.9rem;*/
    /*    font-weight: bold;*/
    /*    border-color: white !important;*/
    /*}*/

    #order-listing tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    #order-listing tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    #order-listing tbody tr:hover {
        background-color: #f1f1f1;
    }

    #order-listing td,
    #order-listing th {
        padding: 12px;
        text-align: center;
        vertical-align: middle;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 0.8rem;
    }

    span#search {
        background-color: transparent !important;
    }

    /*.navigation_mini .btn {*/
    /*    padding: 10px 38px !important;*/
    /*}*/

    .text-success {
        color: #3972fc !important;
    }
</style>

<div id="msgAppend1234"></div>

<div class="container-fluid page-body-wrapper">
    <div class="main-panel pnel">
        <div class="content-wrapper">
<div class="step-navigation border rounded-lg p-2 px-3 mb-3">
  <div class="d-flex flex-wrap justify-content-center gap-2">

    <a href="<?= base_url(); ?>dashboard/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      Dashboard
    </a>

    <a href="<?= base_url(); ?>import_audit/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">1</span> Import / Audit
    </a>

    <a href="<?= base_url(); ?>pending_report/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">2</span> Tag Pending Report
    </a>

    <a href="<?= base_url(); ?>generate-letters/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">3</span> Generate Letters
    </a>

    <a href="<?= base_url(); ?>send_letter/<?= get_encoded_id($client[0]->sq_client_id); ?>" class="step-link">
      <span class="step-num">4</span> Send Letters
    </a>

    <a href="<?= base_url('letters-status/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link active">
      Letters & Status
    </a>

    <a href="<?= base_url('dispute_items/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Dispute Items
    </a>

    <a href="<?= base_url('messages/send/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="step-link">
      Messages
    </a>

  </div>
</div>
          


            <div class="row">
                <div class="col-md-12" id="formobile">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">


                                <div class="col-12">
<div class="table-responsive">
                                    <table id="order-listing" class="table table-bordered table-hover jsgrid">
                                        <thead class="thead-dark">
                                            <tr class="text-uppercase text-center">
                                                <th>#</th>
                                                <th>Description</th>
                                                <!-- <th>Status</th> -->
                                                <th>Send Date</th>
                                                <th>Tracking Status</th>
                                                <th>Expected Delivery</th>
                                                <th>To</th>
                                                <th>From</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            if (!empty($letters)):

                                                $sr_no = '';
                                            ?>
                                                <?php foreach ($letters as $letter): 
    if ($fullname === $letter['from']['name']): 
        $sr_no++;
?>

                                                    <tr>
                                                        <td><?= $sr_no ?></td>
                                                        <td><?= htmlspecialchars($letter['description'] ?? 'N/A') ?></td>
                                                        <!-- <td><?= htmlspecialchars($letter['status'] ?? 'Unknown') ?></td> -->

                                                        <!-- Send Date (Formatted) -->
                                                        <td>
                                                            <?php
                                                            if (!empty($letter['send_date'])) {
                                                                try {
                                                                    $send_date = new DateTime($letter['send_date'], new DateTimeZone('UTC'));
                                                                    echo htmlspecialchars($send_date->format('Y-m-d H:i:s'));
                                                                } catch (Exception $e) {
                                                                    echo 'Invalid Date';
                                                                }
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            ?>
                                                        </td>


                                                        <!-- Tracking Status -->
                                                        <td>
                                                      <?php
                                                        if (!empty($letter['tracking_events'])) {
                                                            $latest_event = end($letter['tracking_events']);
                                                            echo isset($latest_event['status']) ? htmlspecialchars($latest_event['status']) : 'Status not available';
                                                        } else {
                                                            echo 'No tracking available';
                                                        }
                                                        ?>

                                                        </td>
                                                        <!-- Expected Delivery Date -->
                                                        <td>
                                                            <?= !empty($letter['expected_delivery_date']) ? htmlspecialchars($letter['expected_delivery_date']) : 'N/A'; ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($letter['to']['name'] ?? 'N/A') ?></td>
                                                        <td><?= htmlspecialchars($letter['from']['name'] ?? 'N/A') ?></td>
                                                    </tr>
                                                <?php endif;   endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan='5'>No letters found.</td>
                                                </tr>
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

        </div>
    </div>
</div>