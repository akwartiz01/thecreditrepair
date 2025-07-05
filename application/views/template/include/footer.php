</div>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

<script src="<?php echo base_url(); ?>assets/assets/js/jquery-3.7.1.min.js"></script>
<!--  validation script  -->
<script src="<?php echo base_url(); ?>assets/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/plugins/owlcarousel/owl.carousel.min.js"></script>

<!-- Slimscroll JS -->
<script src="<?php echo base_url(); ?>assets/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/js/bootstrapValidator.min.js"></script>

<!-- Datatables JS -->
<script src="<?php echo base_url(); ?>assets/assets/plugins/datatables/datatables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/js/bootstrap-notify.min.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/js/sweetalert2.all.min.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/js/bootstrap-select.min.js"></script>

<?php

$user_type = $this->session->userdata('user_type');

?>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 30) {
            $('.header').addClass('fixed-header');
        } else {
            $('.header').removeClass('fixed-header');
        }
    });

    // Small Sidebar

    $(document).on('click', '#toggle_btn', function() {
        if ($('body').hasClass('mini-sidebar')) {
            $('body').removeClass('mini-sidebar');
            $('.subdrop + ul').slideDown();
        } else {
            $('body').addClass('mini-sidebar');
            $('.subdrop + ul').slideUp();
        }
        return false;
    });


    $(document).on('mouseover', function(e) {
        e.stopPropagation();
        if ($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
            var targ = $(e.target).closest('.sidebar').length;
            if (targ) {
                $('body').addClass('expand-menu');
                $('.subdrop + ul').slideDown();
            } else {
                $('body').removeClass('expand-menu');
                $('.subdrop + ul').slideUp();
            }
            return false;
        }
    });

    // fade in scroll 

    if ($('.main-wrapper .aos').length > 0) {
        AOS.init({
            duration: 1200,
            once: true
        });
    }

</script>

<style>
    .toast-info,
    .toast-success,
    .toast-warning,
    .toast-error {
        background-color: #3972FC !important;
        color: #ffffff !important;
    }

    .toast-info .toast-progress,
    .toast-success .toast-progress,
    .toast-warning .toast-progress,
    .toast-error .toast-progress {
        background-color: #ffffff !important;
    }
</style>


</body>

</html>