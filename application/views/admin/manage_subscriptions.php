<?php
$client_status = $this->config->item('client_status');

?>
<style type="text/css">
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


  /* Loader CSS e*/


  .cancelSubscription:hover {
    /* background-color: #f05050 !important; */
    border-color: #0056b3 !important;
  }
</style>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Manage Subscription </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Subscription</li>
          </ol>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">


          <div class="row">
            <div class="col-md-12">

              <?php
              $subscriber_id = $this->session->userdata('user_id');
              $this->db->where('sq_u_id_subscriber', $subscriber_id);
              $payment_details = $this->db->get('sq_subscription_payment_details')->row_array();
              $subscription_id = $payment_details['subscription_id'];
              $this->db->where('id', $subscription_id);
              $subscription_details = $this->db->get('sq_subscription_plans')->row_array();
              ?>

              <div class="card shadow">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><strong>Subscription Details</strong></h5>
                    <div class="dropdown">
                      <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="subscriptionActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="subscriptionActions">
                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="cancelSubscription()">Cancel Subscription</a>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Plan Name:</strong>
                        <?php if (!empty($subscription_details['subscription_name'])) { ?>
                          <?php echo $subscription_details['subscription_name']; ?>
                          <span class="badge badge-success">Active</span>
                        <?php } else { ?>
                          <span class="badge badge-danger">Expired</span>
                        <?php } ?>
                      </p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Next Billing on:</strong> <?php echo $payment_details['subscription_end_date']; ?></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Start Date:</strong> <?php echo $payment_details['subscription_start_date']; ?></p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Last Payment Date:</strong> <?php echo $payment_details['subscription_start_date']; ?></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Subscription Amount:</strong> $<?php echo $subscription_details['price']; ?></p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Duration:</strong> <?php echo $subscription_details['subscription_duration']; ?></p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">

    <div id="loader">
      <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
    </div>

    <script>
      function cancelSubscription() {

        let subscriberId = $('#user_id').val();

        if (subscriberId != '') {

          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel subscription!',
            allowOutsideClick: false,
            didOpen: () => {
              // Add event listener for clicking outside
              $('.swal2-container').on('click', function(event) {
                if (!Swal.getPopup().contains(event.target)) {
                  let popup = Swal.getPopup();
                  $(popup).css('animation', 'shake 0.5s');

                  setTimeout(() => {
                    $(popup).css('animation', '');
                  }, 500);
                }
              });
            }
          }).then((result) => {
            if (result.isConfirmed) {

              $('#loader').show();

              $.ajax({
                url: '<?php echo base_url('subscriber/cancel_subscription'); ?>',
                type: 'POST',
                data: {
                  subscriberId: subscriberId
                },
                success: function(response) {
                  $('#loader').hide();
                  let res = JSON.parse(response);
                  if (res.status === 'success') {
                    Swal.fire(
                      'Success!',
                      'Subscription cancelled successfully!',
                      'info'
                    ).then(() => {
                      window.location.href = '<?php echo base_url(); ?>sign-out';
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

      }
    </script>