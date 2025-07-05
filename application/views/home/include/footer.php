<footer class="site-footer bg-gray-100">
    <div class="container">
        <div class="py-4 row">
            <!-- Company Details Section -->
            <div class="col-md-5 col-sm-12 cmp-detail text-white mb-4 mb-md-0 offset-md-1">
                <div class="footer-logo mb-3">
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" class="w-40" style="filter: drop-shadow(2px 3px 7px #011C4B);">
                    </a>
                </div>
                <p>
                    CRX Credit Repair is dedicated to helping you improve your credit score and achieve financial freedom. Our team of experts works tirelessly to provide you with the best service and support.
                </p>
            </div>

            <!-- Contact Information Section -->
            <div class="col-md-5 col-sm-12 ftr-subscribe text-white offset-md-1">
                <h2 class="text-white my-4">Contact Us</h2>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>Call us: <strong>(856) 515-6408</strong></span>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Address: <strong>309 Fellowship Road Suite 200 - #693 Mt. Laurel, NJ 08054</strong></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>


  <div class="container-fluid text-center text-white">
    <span class="text-muted text-white"  style="color:#fff!important;">
      &copy; <?php echo date('Y'); ?> 
      <a href="<?php echo base_url(); ?>" class="text-decoration-non" target="_blank" style="color:#fff!important;">
        <b>CRX Credit Repair</b>
      </a>. All rights reserved.
    </span>
  </div>
</footer>

    <script src="<?php echo base_url(); ?>Landing_page/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/assets/js/plugins/feather.min.js"></script>

    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>Landing_page/public/custom/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener("scroll", function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector(".navbar").classList.add("top-nav-collapse");
            } else if (cOst > ost) {
                document.querySelector(".navbar").classList.add("top-nav-collapse");
                document.querySelector(".navbar").classList.remove("default");
            } else {
                document.querySelector(".navbar").classList.add("default");
                document
                    .querySelector(".navbar")
                    .classList.remove("top-nav-collapse");
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]

        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: "#navbar-example",
        });
        feather.replace();


        $(document).ready(function() {
            $('.tox-notifications-container').addClass('d-none')
        });
    </script>

    <script>
        function subscribe(subscriptionId, price) {
            $.ajax({
                url: "<?php echo base_url('subscribe'); ?>",
                type: "POST",
                data: {
                    id: subscriptionId,
                    price: price
                },
                success: function(response) {
                    window.location.href = "<?php echo base_url('registration'); ?>";
                },
                error: function(xhr, status, error) {
                    console.error("Subscription failed: " + error);
                }
            });
        }
    </script>

    </body>

    </html>