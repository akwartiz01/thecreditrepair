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

$(document).on('click', '#mobile_btn', function() {
    $('.main-wrapper').toggleClass('slide-nav'); // Toggle sidebar
    $('#sidebar-overlay').toggleClass('opened'); // Optional: overlay for dim effect
    $('html').toggleClass('menu-opened'); // Prevent scroll
    return false;
});

$(document).mouseup(function(e) {
    const sidebar = $("#sidebar");
    const toggleBtn = $("#mobile_btn");

    if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 &&
        !toggleBtn.is(e.target) && toggleBtn.has(e.target).length === 0) {
        $('.main-wrapper').removeClass('slide-nav');
        $('#sidebar-overlay').removeClass('opened');
        $('html').removeClass('menu-opened');
    }
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

    $(document).ready(function() {
        // Event listener for Profile tab click
        $('#profile_li a').on('click', function(e) {
            e.preventDefault();
            // Show the Profile tab
            $(this).tab('show');
            // Remove 'tab' parameter from the URL
            updateUrlParam('tab', 'profile');
        });

        // Event listener for Password tab click
        $('#password_li a').on('click', function(e) {
            e.preventDefault();
            // Show the Password tab
            $(this).tab('show');
            // Add 'tab=password' to the URL
            updateUrlParam('tab', 'password');
        });

        // Function to update the URL without reloading the page
        function updateUrlParam(key, value) {
            var url = new URL(window.location.href);
            if (value) {
                // Add or update the 'tab' parameter
                url.searchParams.set(key, value);
            } else {
                // Remove the 'tab' parameter
                url.searchParams.delete(key);
            }
            // Update the URL without reloading the page
            window.history.replaceState({}, '', url);
        }

        // On page load, check if the 'tab' parameter is in the URL
        var urlParams = new URLSearchParams(window.location.search);
        var activeTab = urlParams.get('tab');

        // Activate the tab based on the 'tab' parameter value
        if (activeTab === 'profile') {
            $('#profile_li a').tab('show');
        } else if (activeTab === 'password') {
            $('#password_li a').tab('show');
        }
    });

    // Sidebar
    var Sidemenu = function() {
        this.$menuItem = $('#sidebar-menu a');
    };

    function init() {
        var $this = Sidemenu;
        $('#sidebar-menu a').on('click', function(e) {
            if ($(this).parent().hasClass('submenu')) {
                e.preventDefault();
            }
            if (!$(this).hasClass('subdrop')) {
                $('ul', $(this).parents('ul:first')).slideUp(350);
                $('a', $(this).parents('ul:first')).removeClass('subdrop');
                $(this).next('ul').slideDown(350);
                $(this).addClass('subdrop');
            } else if ($(this).hasClass('subdrop')) {
                $(this).removeClass('subdrop');
                $(this).next('ul').slideUp(350);
            }
        });
        $('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
    }

    // Sidebar Initiate
    init();
</script>

</body>

</html>