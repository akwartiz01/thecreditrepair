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

<!-- <script src="<?php //echo base_url(); ?>assets/assets/js/admin_normal_chat.js"></script> -->

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

    <?php

    if ($user_type == 'super') { ?>
        // $(document).ready(function() {

        //     var notifiedMessages = {};

        //     function checkNewMessages() {

        //         $.ajax({
        //             url: '<?= base_url("chat/check_new_messages"); ?>',
        //             method: 'GET',
        //             dataType: 'json',
        //             success: function(response) {
        //                 if (response.success) {
        //                     updateBadgeCount(response.data);

        //                     showNewMessageNotifications(response.data);

        //                     $('li.active.history_append_fun').each(function() {
        //                         if ($(this).hasClass('marking')) {

        //                             $(this).click();
        //                         }
        //                     });

        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('Error checking messages:', error);
        //             }
        //         });
        //     }

        //     function updateBadgeCount(data) {
        //         $.each(data, function(key, value) {

        //             var badgeElement = $('.badge_count' + value.chat_token);

        //             if (value.badge > 0) {
        //                 badgeElement.html(value.badge).addClass('bg-yellow-chat chat-bg-yellow');
        //             } else {
        //                 badgeElement.html('').removeClass('bg-yellow-chat chat-bg-yellow');
        //             }
        //         });
        //     }

        //     function showNewMessageNotifications(data) {
        //         $.each(data, function(key, value) {

        //             if (!notifiedMessages[value.chat_token] || notifiedMessages[value.chat_token] < value.badge) {

        //                 if (value.badge > 0) {
        //                     toastr.info('You have ' + value.badge + ' new messages from ' + value.sq_first_name + ' ' + value.sq_last_name, 'New Message');
        //                 }

        //                 notifiedMessages[value.chat_token] = value.badge;
        //             }
        //         });
        //     }

        //     setInterval(checkNewMessages, 5000);
        // });
    <?php } ?>
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