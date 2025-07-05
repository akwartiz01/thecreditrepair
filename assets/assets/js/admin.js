(function ($) {
  "use strict";
  var csrf_token = $('#admin_csrf').val();
  var base_url = $('#base_url').val();


  // Variables declarations

  var $wrapper = $('.main-change_languagewrapper');
  var $wrapper1 = $('.main-wrapper');
  var $pageWrapper = $('.page-wrapper');
  var $slimScrolls = $('.slimscroll');

  var data = window.location.href;
  var current_page = data.substring(data.lastIndexOf('/') + 1);
  var segments = data.split('/');
  var current_segments = segments.slice(-2);
  var current_pagename = current_segments[0];

  $(document).ready(function () {
    $('#save_profile_change').on('click', function () {
      changeAdminProfile();
    });

    $('#adminmail').on('blur', function () {
      var email = $('#adminmail').val();
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/profile/check_admin_mail',
        data: { email: email, csrf_token_name: csrf_token },
        success: function (response) {
          if (response == 1) {

            $("#email_error").html("Email ID already exist...!");
            $("#save_profile_change").prop("disabled", true);
          }
          else {
            $("#email_error").html("");
            $("#save_profile_change").prop("disabled", false);
          }
        }
      });
    });


    $('#upload_images').on('click', function () {
      upload_images();
    });
  });

  $(document).on('change', '.change_auto_approval_status', function () {
    var approveStatus = $('#auto_approval').prop('checked');
    if (approveStatus == true) {
      var status = 1;
    }
    else {
      var status = 0;
    }
    $.post(base_url + 'admin/service/changeAutoApprovalStatus', { status: status, csrf_token_name: csrf_token }, function (data) {
      if (data == "1") {
        Swal.fire({
          title: "Service Status",
          text: "Service Status Changed SuccessFully....!",
          icon: "success",
          button: "okay",
          closeOnEsc: false,
          closeOnClickOutside: false
        }).then(function () {
          location.reload();
        });
      } else if (data == "2") {
        Swal.fire({
          title: "Service Status",
          text: "Unable to change the status in Demo mode",
          icon: "failure",
          button: "okay",
          closeOnEsc: false,
          closeOnClickOutside: false
        }).then(function () {
          location.reload();
        });
      } else {
        Swal.fire({
          title: "Service Status",
          text: "Something went wrong, Try again later!!",
          icon: "failure",
          button: "okay",
          closeOnEsc: false,
          closeOnClickOutside: false
        }).then(function () {
          location.reload();
        });
      }

    });
  });
  // editor
  if ($('#editor').length > 0) {
    ClassicEditor.create(document.querySelector('#editor'), {
      toolbar: {
        items: [
          'heading', '|',
          'fontfamily', 'fontsize', '|',
          'alignment', '|',
          'fontColor', 'fontBackgroundColor', '|',
          'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
          'link', '|',
          'outdent', 'indent', '|',
          'bulletedList', 'numberedList', 'todoList', '|',
          'code', 'codeBlock', '|',
          'insertTable', '|',
          'uploadImage', 'blockQuote', '|',
          'undo', 'redo'
        ],
        shouldNotGroupWhenFull: true
      }
    })
      .then(editor => {
        window.editor = editor;
        editor.model.document.on('change:data', () => {  
          // Enable the submit button whenever there's a change in the content
          
          if (current_pagename != 'privacy-policy' && current_pagename != 'terms-service'   && current_pagename  != 'cookie-policy' && current_page == 'add-service' && current_pagename == 'edit-service') {
            document.querySelector('#blog_submit_btn').disabled = false;
            $(".blog_content_emp").removeClass('d-block');
            $(".blog_content_emp").addClass('d-none');
          }
        });
      })
      .catch(err => {
        console.error(err.stack);
      });
  }
  if ($('#editor28').length > 0) {
    ClassicEditor.create(document.querySelector('#editor'), {
      toolbar: {
        items: [
          'heading', '|',
          'fontfamily', 'fontsize', '|',
          'alignment', '|',
          'fontColor', 'fontBackgroundColor', '|',
          'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
          'link', '|',
          'outdent', 'indent', '|',
          'bulletedList', 'numberedList', 'todoList', '|',
          'code', 'codeBlock', '|',
          'insertTable', '|',
          'uploadImage', 'blockQuote', '|',
          'undo', 'redo'
        ],
        shouldNotGroupWhenFull: true
      }
    })
      .then(editor => {
        window.editor = editor;
      })
      .catch(err => {
        console.error(err.stack);
      });

    $(".lang_editor").each(function (index) {
      ClassicEditor.create(document.querySelector('#editor' + $(this).attr('data-id')), {
        toolbar: {
          items: [
            'heading', '|',
            'fontfamily', 'fontsize', '|',
            'alignment', '|',
            'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
            'link', '|',
            'outdent', 'indent', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'code', 'codeBlock', '|',
            'insertTable', '|',
            'uploadImage', 'blockQuote', '|',
            'undo', 'redo'
          ],
          shouldNotGroupWhenFull: true
        }
      })
        .then(editor => {
          window.editor = editor;

        })
        .catch(err => {
          console.error(err.stack);
        });
    });
  }
  // Sidebar
  var Sidemenu = function () {
    this.$menuItem = $('#sidebar-menu a');
  };

  function init() {
    var $this = Sidemenu;
    $('#sidebar-menu a').on('click', function (e) {
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

  // Mobile menu sidebar overlay

  $('body').append('<div class="sidebar-overlay"></div>');
  $(document).on('click', '#mobile_btn', function () {
    $wrapper1.toggleClass('slide-nav');
    $('.sidebar-overlay').toggleClass('opened');
    $('html').addClass('menu-opened');
    return false;
  });

  // Sidebar overlay

  $(".sidebar-overlay").on("click", function () {
    $wrapper1.removeClass('slide-nav');
    $(".sidebar-overlay").removeClass("opened");
    $('html').removeClass('menu-opened');
  });

  // Select 2

  if ($('.select').length > 0) {
    $('.select').select2({
      minimumResultsForSearch: -1,
      width: '100%'
    });
  }

  $(document).on('click', '#filter_search', function () {
    $('#filter_inputs').slideToggle("slow");
  });

  // Datetimepicker

  if ($('.datetimepicker').length > 0) {
    $('.datetimepicker').datetimepicker({
      format: 'DD-MM-YYYY',
      icons: {
        up: "fas fa-angle-up",
        down: "fas fa-angle-down",
        next: 'fas fa-angle-right',
        previous: 'fas fa-angle-left'
      }
    });
    $('.datetimepicker').on('dp.show', function () {
      $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
    }).on('dp.hide', function () {
      $(this).closest('.temp').addClass('table-responsive').removeClass('temp')
    });
  }
  $('.start_date').datetimepicker({
    format: 'DD-MM-YYYY',
    icons: {
      up: "fas fa-angle-up",
      down: "fas fa-angle-down",
      next: 'fas fa-angle-right',
      previous: 'fas fa-angle-left'
    }
  });
  $('.start_date').on('dp.show', function () {
    $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
  }).on('dp.hide', function (e) {
    $('.end_date').data("DateTimePicker").minDate(e.date)
    $(this).closest('.temp').addClass('table-responsive').removeClass('temp')
  });
  $('.end_date').datetimepicker({
    format: 'DD-MM-YYYY',
    icons: {
      up: "fas fa-angle-up",
      down: "fas fa-angle-down",
      next: 'fas fa-angle-right',
      previous: 'fas fa-angle-left'
    }
  });
  $('.end_date').on('dp.show', function () {
    $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
  }).on('dp.hide', function () {
    $(this).closest('.temp').addClass('table-responsive').removeClass('temp')
  });



  $('#reschedule_booking_date').datetimepicker({
    format: 'DD-MM-YYYY',
    minDate: new Date(),
    icons: {
      up: "fas fa-angle-up",
      down: "fas fa-angle-down",
      next: 'fas fa-angle-right',
      previous: 'fas fa-angle-left'
    }
  });
  $('#reschedule_booking_date').on('dp.change', function () {

    var dateText = $(this).val();
    var date = dateText;

    var provider_id = $('#b_providerid').val();
    var service_id = $('#b_serviceid').val();

    $('#from_time').empty();
    $('#book_services').bootstrapValidator('revalidateField', 'booking_date');

    if (date != "" && date != undefined) {

      $.ajax({
        url: base_url + "user/service/service_availability/",
        data: { date: date, provider_id: provider_id, service_id: service_id, csrf_token_name: csrf_token },
        type: "POST",

        success: function (response) {
          $('#from_time').find("option:eq(0)").html("Select time slot");
          if (response != '') {
            var obj = jQuery.parseJSON(response);
            if (obj != '') {
              $(obj).each(function () {
                var option = $('<option />');
                option.attr('value', this.start_time + ' - ' + this.end_time).text(this.start_time + '-' + this.end_time);
                $('#from_time').append(option);
              });
            } else if (obj == '') {
              Swal.fire({
                title: "Availability Not Found !",
                text: "Please check and select avilable date...!",
                icon: "warning",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
              });
              var option = $('<option />');
              option.attr('value', '').text("Availability not found.");
              $('#from_time').append(option);
            }

          }
        }

      });
    }

    // Rest of your code for date selection
  });


  //reschedule
  $('.reschedule').on('click', function () {
    $('#b_rowid').val('');
    $('#b_userid').val('');
    $('#b_providerid').val('');
    $('#b_serviceid').val('');

    var booking_id = $(this).attr("data-b_rowid");
    var provider_id = $(this).attr("data-b_providerid");
    var user_id = $(this).attr("data-b_userid");
    var service_id = $(this).attr("data-b_serviceid");

    $("#b_rowid").val(function () {
      return this.value + booking_id;
    });
    $("#b_providerid").val(function () {
      return this.value + provider_id;
    });
    $("#b_userid").val(function () {
      return this.value + user_id;
    });
    $("#b_serviced").val(function () {
      return this.value + service_id;
    });
  });

  // Tooltip

  if ($('[data-toggle="tooltip"]').length > 0) {
    $('[data-toggle="tooltip"]').tooltip();
  }

  // Datatable

  if ($('.datatable').length > 0) {
    $('.datatable').DataTable({
      "bFilter": false,
      columnDefs: [{ orderable: false, "targets": -1 }] /* -1 = 1st colomn, starting from the right */

    });
  }
  $('.revenue_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });
  $('.language_table').DataTable();
  $('.completed_payout').DataTable();


  $('.categories_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });

  $('.taxes_table').DataTable({
    columnDefs: [
      { orderable: false, targets: [-2, -1] }
    ]
  });

  $('.ratingstype_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });
  $('.service_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });
  if (current_page != 'review-reports') {
    $('.payment_table').DataTable({

    });
  }
  $('.earnings_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });
  $('.weblanguages').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });
  $('.blogcategories_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });
  $('.blogcomments_table').DataTable({
    columnDefs: [
      { orderable: false, targets: -1 }
    ]
  });




  // Owl Carousel

  if ($('.images-carousel').length > 0) {
    $('.images-carousel').owlCarousel({
      loop: true,
      center: true,
      margin: 10,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          items: 1,
          loop: false,
          margin: 20
        }
      }
    });
  }

  // Sidebar Slimscroll

  if ($slimScrolls.length > 0) {
    $slimScrolls.slimScroll({
      height: 'auto',
      width: '100%',
      position: 'right',
      size: '7px',
      color: '#ccc',
      allowPageScroll: false,
      wheelStep: 10,
      touchScrollStep: 100
    });
    var wHeight = $(window).height() - 60;
    $slimScrolls.height(wHeight);
    $('.sidebar .slimScrollDiv').height(wHeight);
    $(window).resize(function () {
      var rHeight = $(window).height() - 60;
      $slimScrolls.height(rHeight);
      $('.sidebar .slimScrollDiv').height(rHeight);
    });
  }

  // Small Sidebar

  $(document).on('click', '#toggle_btn', function () {
    if ($('body').hasClass('mini-sidebar')) {
      $('body').removeClass('mini-sidebar');
      $('.subdrop + ul').slideDown();
    } else {
      $('body').addClass('mini-sidebar');
      $('.subdrop + ul').slideUp();
    }
    setTimeout(function () {
      // mA.redraw();
      //mL.redraw();
    }, 300);
    return false;
  });

  $(document).on('mouseover', function (e) {
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

    $(window).scroll(function () {
      if ($(window).scrollTop() >= 30) {
        $('.header').addClass('fixed-header');
      } else {
        $('.header').removeClass('fixed-header');
      }
    });

  });

  $(document).on('click', '#loginSubmit', function () {
    $("#adminSignIn").submit();
  });

  $('#adminSignIn').bootstrapValidator({
    fields: {
      username: {
        validators: {
          notEmpty: {
            message: 'Please enter your Username'
          }
        }
      },
      password: {
        validators: {
          notEmpty: {
            message: 'Please enter your Password'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {

    var username = $('#username').val();
    var password = $('#password').val();
    $.ajax({
      type: 'POST',
      url: base_url + 'admin/login/is_valid_login',
      data: $('#adminSignIn').serialize(),
      success: function (response) {
        if (response == 1) {
          window.location = base_url + 'dashboard';
        }
        else {
          Swal.fire({
            title: "Wrong Credentials..!",
            text: "Invalid login credentials..",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      }
    });
    return false;
  });

  $('#add_payout').bootstrapValidator({
    fields: {
      provider_id: {
        validators: {
          notEmpty: {
            message: 'Please select any one provider'
          }
        }
      },
      payout_method: {
        validators: {
          notEmpty: {
            message: 'Please select any one payment option'
          }
        }
      },
      payout_amount: {
        validators: {
          notEmpty: {
            message: 'Please enter amount'
          }
        }
      },
      payout_amount: {
        validators: {
          remote: {
            url: base_url + 'admin/payouts/walletAmtCheck',
            data: function (validator) {
              return {
                payout_amount: validator.getFieldElements('payout_amount').val(),
                provider_id: validator.getFieldElements('provider_id').val(),
                csrf_token_name: csrf_token
              };
            },
            message: 'Insufficient wallet amount',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter amount'

          }
        }
      },
      payout_status: {
        validators: {
          notEmpty: {
            message: 'Please select payment status'
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  //forgotpassword

  $('#forgotpwdadmin').on('click', function () {

    var email = $("#email").val();
    $("#err_frpwd").text('');
    if (email == '') {

      $("#err_frpwd").show();
      $("#err_frpwd").text('Please enter your email...!').css("color", "red");
      return false;
    }
    forgotpwd_function();
  });

  // $('#forgotpwdadmin').bootstrapValidator({
  //   fields: {
  //     email:   {
  //       validators:          {
  //         notEmpty:              {
  //           message: 'Please enter your Email ID'
  //         }
  //       }
  //     }
  //   }
  // }).on('success.form.bv', function(e) {
  function forgotpwd_function() {
    var email = $('#email').val();

    // Clear any existing error messages

    $.ajax({
      type: 'POST',
      url: base_url + 'admin/login/check_forgot_pwd',
      data: $('#forgotpwdadmin').serialize(),
      beforeSend: function () {

        var $this = $('#forgetpwdSubmit');
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
        if ($this.html() !== loadingText) {
          $this.data('original-text', $this.html());
          $this.html(loadingText).prop('disabled', 'true').bind('click', false);
          $this.css('pointer-events', 'none');
        }
      },
      success: function (response) {
        var $this = $('#forgetpwdSubmit');
        $this.html($this.data('original-text')).prop('disabled', 'false');
        $this.css('pointer-events', 'visible');
        if (response == 1) {
          $("#err_frpwd").html("Reset link has been sent to your mail ID, Check your mail.").css("color", "green");
        }
        else {
          $("#err_frpwd").html("Email ID does not exist...!").css("color", "red");
          return false;
        }

      }
    });

  }



  $('#resetpwdadmin').bootstrapValidator({
    fields: {
      new_password: {
        validators: {
          notEmpty: {
            message: 'Please enter your New Password'
          }
        }
      },

      confirm_password: {
        validators: {
          notEmpty: {
            message: 'Please enter your Confirm Password'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {

    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();

    if (new_password == confirm_password) {
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/login/save_reset_password',
        data: $('#resetpwdadmin').serialize(),
        success: function (response) {
          if (response == 1) {
            $("#err_respwd").html("Password Changed SuccessFully...!").css("color", "green");
            window.location = base_url + 'admin';
          }
          else {
            $("#err_respwd").html("Something went wrong...!").css("color", "red");
          }
        }
      });
    }
    else {
      $("#err_respwd").html("Password Mismatch...!").css("color", "red");

    }

    return false;
  });


  $('#addSubscription').bootstrapValidator({
    fields: {
      subscription_name_28: {
        validators: {
          remote: {
            url: base_url + 'service/check_subscription_name',
            data: function (validator) {
              return {
                subscription_name_28: validator.getFieldElements('subscription_name_28').val(),
                csrf_token_name: csrf_token
              };
            },
            message: 'This subscription name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter subscription name'

          }
        }
      },
      amount: {
        validators: {
          notEmpty: {
            message: 'Please enter subscription amount'
          }
        }
      },
      duration: {
        validators: {
          notEmpty: {
            message: 'Please select subscription duration'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#add_app_keywords').bootstrapValidator({
    fields: {
      page_name: {
        validators: {
          notEmpty: {
            message: 'Please enter page name'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  // var language_title = '';
  // $('#default_nav_lang').each(function() {

  //   var optionValue = $(this).val(); // Get the value of the option
  //   var optionText = $(this).text(); // Get the text of the option

  //   // Do something with the option value and text
  //   console.log("Value: " + optionValue + ", Text: " + optionText);
  //   language_title += `service_title_${optionValue}:           {
  //     validators:           {
  //       notEmpty:               {
  //         message: 'Please select Service Provider'
  //       }
  //     }
  //   },`;
  // });
  function service_title_validate() {
    var isValid = true;
    $(".admin_add_service_title").each(function () {
      // Get the value of the input field
      var inputValue = $(this).val();
      var langId = $(this).attr('name').split('_')[2];
      var langName = $(this).attr('data-lang');
      // Check if the input is empty
      if (inputValue.trim() === "") {
        $(".err_service_title_" + langId).text("Please Enter " + langName + " Service Title.");
        isValid = false;
      }
      else {
        $(".err_service_title_" + langId).text("");
      }
    });
    if (isValid) {
      $('#admin_service_submit_btn').prop('disabled', false);
    } else {
      $('#admin_service_submit_btn').prop('disabled', true);
    }

    return isValid;
  }
  $(document).on("change", ".admin_add_service_title", function () {
    service_title_validate();
  });
  //service-title validation
  $("#add_service,#update_service").on("submit", function (event) {
    service_title_validate();
  });

  $('#add_service').bootstrapValidator({
    fields: {
      // fields:language_title,
      username: {
        validators: {
          notEmpty: {
            message: 'Please select Provider'
          }
        }
      },
      country_id: {
        validators: {
          notEmpty: {
            message: 'Please select Country'
          }
        }
      },
      state_id: {
        validators: {
          notEmpty: {
            message: 'Please select State'
          }
        }
      },
      city_id: {
        validators: {
          notEmpty: {
            message: 'Please select City'
          }
        }
      },
      service_title: {
        validators: {
          remote: {
            url: base_url + 'user/service/check_service_title',
            data: function (validator) {
              return {
                service_title: validator.getFieldElements('service_title').val(),
                'csrf_token_name': $('#login_csrf').val()
              };
            },
            message: 'This Service is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please Enter your service title'
          }
        }
      },
      service_sub_title: {
        validators: {
          notEmpty: {
            message: 'Please Enter service sub title'
          }
        }
      },
      category: {
        validators: {
          notEmpty: {
            message: 'Please select category...'
          }
        }
      },
      // subcategory: {
      //     validators: {
      //         notEmpty: {
      //             message: 'Please select subcategory...'
      //         }
      //     }
      // },

      service_amount: {
        validators: {
          digits: {
            message: 'Please Enter valid service amount and not user in special characters...'
          },
          notEmpty: {
            message: 'Please Enter service amount...'
          }
        }
      },

      'images[]': {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,png files'
          },
          // notEmpty: {
          //     message: 'Please upload Service image...'
          // }
        }
      },
      service_country: {
        validators: {
          notEmpty: {
            message: 'Please Enter service country'
          }
        }
      },
      service_city: {
        validators: {
          notEmpty: {
            message: 'Please Enter service city'
          }
        }
      },
      service_state: {
        validators: {
          notEmpty: {
            message: 'Please Enter service state'
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    var imgCount = $("#imgList li").find('img').length;
    if (imgCount == 0) {
      $("#lbl_img_not_added").text('Please upload service image');
      return false;
    }
    else {
      $("#lbl_img_not_added").text('');
    }

    return service_title_validate();
  });

  //update service

  $('#update_service').bootstrapValidator({
    fields: {
      username: {
        validators: {
          notEmpty: {
            message: 'Please select Provider'
          }
        }
      },
      // service_title: {
      //     validators: {
      //         remote: {
      //             url: base_url + 'user/service/check_service_title',
      //             data: function(validator) {
      //                 return {
      //                     service_title: validator.getFieldElements('service_title').val(),
      //                     service_id: validator.getFieldElements('service_id').val(),
      //                     'csrf_token_name': $('#login_csrf').val()
      //                 };
      //             },
      //             message: 'This Service is already exist',
      //             type: 'POST'
      //         },
      //         notEmpty: {
      //             message: 'Please Enter your service title'
      //         }
      //     }
      // },
      service_sub_title: {
        validators: {
          notEmpty: {
            message: 'Please Enter service sub title'
          }
        }
      },
      category: {
        validators: {
          notEmpty: {
            message: 'Please select category...'
          }
        }
      },
      // subcategory: {
      //     validators: {
      //         notEmpty: {
      //             message: 'Please select subcategory...'
      //         }
      //     }
      // },
      service_location: {
        validators: {
          notEmpty: {
            message: 'Please Enter service location...'
          }
        }
      },
      service_amount: {
        validators: {
          digits: {
            message: 'Please Enter valid service amount and not user in special characters...'
          },
          notEmpty: {
            message: 'Please Enter service amount...'
          }
        }
      }, 'images2[]': {
        validators: {
          // notEmpty: {

          //     message: 'Please upload Service image...'
          // },
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,png files'
          },

        }
      },
      // 'service_offered[]': {
      //     validators: {
      //         notEmpty: {
      //             message: 'Please Enter service offered'
      //         }
      //     }
      // },
    }
  }).on('success.form.bv', function (e) {
    var imgListold = $('#imgListold');
    var imgList = $('#imgList');
    var messageBox = $('#messageBox');
    if (imgList.children().length === 0 && imgListold.children().length === 0) {
      // Handle the case where imgList is empty
      messageBox.html('<div class="alert alert-danger">Please upload at least one image.</div>');
      e.preventDefault(); // Prevent form submission
      return false;
    }
    return service_title_validate();
  });


  $('#add_language').bootstrapValidator({
    fields: {
      language_name: {
        validators: {
          notEmpty: {
            message: 'Please enter language name'

          }
        }
      },
      language_value: {
        validators: {
          notEmpty: {
            message: 'Please enter language value'

          }
        }
      },
      language_type: {
        validators: {
          notEmpty: {
            message: 'Please enter language type'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#admin_settings').bootstrapValidator({
    fields: {
      website_name: {
        validators: {
          notEmpty: {
            message: 'Please enter website name'

          }
        }
      },
      contact_details: {
        validators: {
          notEmpty: {
            message: 'Please enter contact details'

          }
        }
      },
      mobile_number: {
        validators: {
          notEmpty: {
            message: 'Please enter mobile number'

          }
        }
      },
      currency_option: {
        validators: {
          notEmpty: {
            message: 'Please select currency'

          }
        }
      },
      commission: {
        validators: {
          notEmpty: {
            message: 'Please enter commission amount'

          }
        }
      },

      login_type: {
        validators: {
          notEmpty: {
            message: 'Please select Login type'

          }
        }
      },
      paypal_gateway: {
        validators: {
          notEmpty: {
            message: 'Please enter paypal gateway'

          }
        }
      },
      braintree_key: {
        validators: {
          notEmpty: {
            message: 'Please enter braintree key'

          }
        }
      },
      site_logo: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          }
        }
      },
      favicon: {
        validators: {
          file: {
            extension: 'png,ico',
            type: 'image/png,image/ico',
            message: 'The selected file is not valid. Only allowed ico,png files'
          }

        }
      },
    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#map_settings').bootstrapValidator({
    fields: {
      map_key: {
        validators: {
          notEmpty: {
            message: 'Please enter google map API key'
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#apikey_settings').bootstrapValidator({
    fields: {
      firebase_server_key: {
        validators: {
          notEmpty: {
            message: 'Please enter Firebase server key'
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#social_settings').bootstrapValidator({
    fields: {
      login_type: {
        validators: {
          notEmpty: {
            message: 'Please select any one option'
          }
        }
      },
      otp_by: {
        validators: {
          notEmpty: {
            message: 'Please select any one option'
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#general_settings').bootstrapValidator({
    fields: {
      website_name: {
        validators: {
          notEmpty: {
            message: 'Please enter website name'
          }
        }
      },
      contact_details: {
        validators: {
          notEmpty: {
            message: 'Please enter contact details'
          }
        }
      },
      mobile_number: {
        validators: {
          notEmpty: {
            message: 'Please enter mobile number'
          }
        }
      },
      language: {
        validators: {
          notEmpty: {
            message: 'Please select one language'
          }
        }
      },
      currency_option: {
        validators: {
          notEmpty: {
            message: 'Please select one option'
          }
        }
      },
      radius: {
        validators: {
          notEmpty: {
            message: 'Please select range of radius'
          }
        }
      },
      location_type: {
        validators: {
          notEmpty: {
            message: 'Please select language type'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#seo_settings').bootstrapValidator({
    fields: {
      meta_title: {
        validators: {
          notEmpty: {
            message: 'Please enter Meta Title '
          }
        }
      },
      meta_desc: {
        validators: {
          notEmpty: {
            message: 'Please enter Meta Description '
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#image_settings').bootstrapValidator({
    fields: {
      logo_front: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          },
        }
      },
      favicon: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          },
        }
      },
      header_icon: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          },
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#placeholder_settings').bootstrapValidator({
    fields: {
      service_placeholder_image: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          },

        }
      },
      profile_placeholder_image: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          },

        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  //language module
  $('#add_language_module').bootstrapValidator({
    fields: {
      module_name: {
        validators: {
          notEmpty: {
            message: 'Please enter module name'
          },
          regexp: {
            regexp: /^[A-Za-z\s]+$/,
            message: 'Please enter only capital alphabets'
          },

        }
      },

    }
  }).on('success.form.bv', function (e) {

    return true;
  });

  //language module
  $('#edit_language_module').bootstrapValidator({
    fields: {
      module_name: {
        validators: {
          notEmpty: {
            message: 'Please enter module name'
          },
          regexp: {
            regexp: /^[A-Za-z\s]+$/,
            message: 'Please enter only capital alphabets'
          }
        }
      },

    }
  }).on('success.form.bv', function (e) {

    return true;
  });

  //language keywords module
  $('#add_language_keywords').bootstrapValidator({
    fields: {
      lang_key: {
        validators: {
          notEmpty: {
            message: 'Please enter language key'
          },
          regexp: {
            regexp: /^[A-Za-z_\s]+$/,
            message: 'Please enter only alphabets'
          }
        }
      },
      lang_value: {
        validators: {
          notEmpty: {
            message: 'Please enter language value'
          },
          regexp: {
            regexp: /^[A-Za-z\s]+$/,
            message: 'Please enter only alphabets'
          }
        }
      },

    }
  }).on('success.form.bv', function (e) {

    return true;
  });


  //language keywords module
  $('#edit_language_keywords').bootstrapValidator({
    fields: {

      lang_value: {
        validators: {
          notEmpty: {
            message: 'Please enter language value'
          },
          regexp: {
            regexp: /^[A-Za-z\s]+$/,
            message: 'Please enter only alphabets'
          }
        }
      },

    }
  }).on('success.form.bv', function (e) {

    return true;
  });


  //tax
  $('#add_tax').bootstrapValidator({
    fields: {
      tax_name_28: {
        validators: {
          notEmpty: {
            message: 'Please enter tax name'
          },
          // regexp: {
          //     regexp: /^[A-Z]+$/,
          //     message: 'Please enter only capital alphabets'
          // }
        }
      },
      tax_percent: {
        validators: {
          notEmpty: {
            message: 'Please enter tax percent'

          },
          regexp: {
            regexp: /^\d+(\.\d{2})?$/,
            message: 'Please enter a valid numeric value with exactly two decimal points'
          },
          callback: {
            callback: function (value, validator, $field) {
              // Check if the value is not equal to 0
              if (parseFloat(value) === 0) {
                return {
                  valid: false,
                  message: 'Value must be greater than 0'
                };
              }
              return true;
            }
          }
        }
      },

    }
  }).on('success.form.bv', function (e) {

    return true;
  });


  $('#update_tax').bootstrapValidator({
    fields: {
      tax_name_28: {
        validators: {
          notEmpty: {
            message: 'Please enter tax name'
          },
          // regexp: {
          //     regexp: /^[A-Z]+$/,
          //     message: 'Please enter only capital alphabets'
          // }
        }
      },
      tax_percent: {
        validators: {
          notEmpty: {
            message: 'Please enter tax percent'

          },
          regexp: {
            regexp: /^\d+(\.\d{2})?$/,
            message: 'Please enter a valid value with exactly two decimal points'
          },
          callback: {
            callback: function (value, validator, $field) {
              // Check if the value is not equal to 0
              if (parseFloat(value) === 0) {
                return {
                  valid: false,
                  message: 'Value must be greater than 0'
                };
              }
              return true;
            }
          }
        }
      },

    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#add_category').bootstrapValidator({
    fields: {
      category_name: {
        validators: {
          remote: {
            url: base_url + 'categories/check_category_name',
            data: function (validator) {
              return {
                category_name: validator.getFieldElements('category_name').val(),
                csrf_token_name: csrf_token
              };
            },
            message: 'This category name is already exist',
            type: 'POST'
          },
          stringLength: {
            min: 1,
            max: 100,
            message: "Category name must be between 1 and 100 characters long"
          },
          notEmpty: {
            message: 'Please enter category name'

          }
        }
      },
      category_slug: {
        validators: {
          notEmpty: {
            message: 'Please enter category slug'

          }
        }
      },
      category_image: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          },
          notEmpty: {
            message: 'Please upload category image'
          }
        }
      },
      category_mobile_icon: {
        validators: {
          file: {
            extension: 'jpeg,png',
            type: 'image/jpeg,image/png',
            message: 'The selected file is not valid. Only allowed jpeg,png files'
          },

          notEmpty: {
            message: 'Please upload category mobile icon'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#update_category').bootstrapValidator({
    fields: {
      category_name: {
        validators: {
          remote: {
            url: base_url + 'categories/check_category_name',
            data: function (validator) {
              return {
                category_name: validator.getFieldElements('category_name').val(),
                csrf_token_name: csrf_token,
                category_id: validator.getFieldElements('category_id').val()
              };
            },
            message: 'This category name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter category name'

          }
        }
      },
      category_slug: {
        validators: {
          notEmpty: {
            message: 'Please enter category slug'

          }
        }
      },
      category_image: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          }
        }
      },

    }
  }).on('success.form.bv', function (e) {


    return true;
  });
  $('#add_blog_category').bootstrapValidator({
    fields: {
      name: {
        validators: {
          remote: {
            url: base_url + 'blog_categories/check_category_name',
            data: function (validator) {
              return {
                category_name: validator.getFieldElements('name').val(),
                csrf_token_name: csrf_token
              };
            },
            message: 'This category name is already exist',
            type: 'POST'
          },
          stringLength: {
            min: 1,
            max: 100,
            message: "Category name must be between 1 and 100 characters long"
          },
          notEmpty: {
            message: 'Please enter category name'

          }
        }
      },
      category_order: {
        validators: {
          notEmpty: {
            message: 'Please enter category order'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#update_blog_category').bootstrapValidator({
    fields: {
      name: {
        validators: {
          remote: {
            url: base_url + 'blog_categories/check_category_name',
            data: function (validator) {
              return {
                category_id: validator.getFieldElements('category_id').val(),
                category_name: validator.getFieldElements('name').val(),
                csrf_token_name: csrf_token
              };
            },
            message: 'This category name is already exist',
            type: 'POST'
          },
          stringLength: {
            min: 1,
            max: 100,
            message: "Category name must be between 1 and 100 characters long"
          },
          notEmpty: {
            message: 'Please enter category name'

          }
        }
      },
      category_order: {
        validators: {
          notEmpty: {
            message: 'Please enter category order'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {


    return true;
  });


  $('#add_blog').bootstrapValidator({
    fields: {
      title: {
        validators: {
          notEmpty: {
            message: 'Please enter Blog Title'

          }
        }
      },
      lang_id: {
        validators: {
          notEmpty: {
            message: 'Please enter category order'
          }
        }
      },
      category_id: {
        validators: {
          notEmpty: {
            message: 'Please Select Blog Category'
          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    if ($("#editor").val() == "") {
      $(".blog_content_emp").removeClass('d-none');
      $(".blog_content_emp").addClass('d-block');
      return false;
    } else {
      return true;
    }
  });


  $("#editor").on("change", function () {
    alert();
  });

  $('#update_blog').bootstrapValidator({
    fields: {
      title: {
        validators: {
          notEmpty: {
            message: 'Please enter Blog Title'

          }
        }
      },
      lang_id: {
        validators: {
          notEmpty: {
            message: 'Please enter category order'
          }
        }
      },
      category_id: {
        validators: {
          notEmpty: {
            message: 'Please Select Blog Category'
          }
        }
      },
      // content:           {
      //   validators:           {
      //     notEmpty:               {
      //       message: 'Please enter content'
      //     }
      //   }
      // }             
    }
  }).on('success.form.bv', function (e) {
    if ($("#editor").val() == "") {
      $(".blog_content_emp").removeClass('d-none');
      $(".blog_content_emp").addClass('d-block');
      return false;
    } else {
      return true;
    }
  });

  $('#update_banner').bootstrapValidator({
    fields: {
      banner_content: {
        validators: {
          notEmpty: {
            message: 'Content is required'

          },
        }
      },
      banner_sub_content: {
        validators: {
          notEmpty: {
            message: 'Sub content is required'

          },
        }
      },

    }
  }).on('success.form.bv', function (e) {
    var img_err = $('.img_err').text();
    if (img_err == '') {
      return true;
    } else {
      return false;
    }

  });

  $('#add_subcategory').bootstrapValidator({
    fields: {
      subcategory_name: {
        validators: {
          remote: {
            url: base_url + 'categories/check_subcategory_name',
            data: function (validator) {
              return {
                category: validator.getFieldElements('category').val(),
                csrf_token_name: csrf_token,
                subcategory_name: validator.getFieldElements('subcategory_name').val()
              };
            },
            message: 'This sub category name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter sub category name'

          }
        }
      },
      subcategory_slug: {
        validators: {
          notEmpty: {
            message: 'Please enter category slug'

          }
        }
      },
      category: {
        validators: {
          notEmpty: {
            message: 'Please select category'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {


    return true;
  });



  $('#update_subcategory').bootstrapValidator({
    fields: {
      subcategory_name: {
        validators: {
          remote: {
            url: base_url + 'categories/check_subcategory_name',
            data: function (validator) {
              return {
                category: validator.getFieldElements('category').val(),
                subcategory_name: validator.getFieldElements('subcategory_name').val(),
                csrf_token_name: csrf_token,
                subcategory_id: validator.getFieldElements('subcategory_id').val()
              };
            },
            message: 'This sub category name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter sub category name'

          }
        }
      },
      subcategory_slug: {
        validators: {
          notEmpty: {
            message: 'Please enter category slug'

          }
        }
      },
      subcategory_image: {
        validators: {
          file: {
            extension: 'jpeg,png,jpg',
            type: 'image/jpeg,image/png,image/jpg',
            message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
          }
        }
      },
      category: {
        validators: {
          notEmpty: {
            message: 'Please select category'
          }
        }
      }

    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#add_ratingstype').bootstrapValidator({
    fields: {
      name_: {
        validators: {
          remote: {
            url: base_url + 'admin/ratingstype/check_ratingstype_name',
            data: function (validator) {
              return {
                name: validator.getFieldElements('name_28').val(),
                csrf_token_name: csrf_token,
              };
            },
            message: 'This Rating type name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter rating type name'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {


    return true;
  });

  $('#update_ratingstype').bootstrapValidator({
    fields: {
      name_: {
        validators: {
          remote: {
            url: base_url + 'ratingstype/check_ratingstype_name',
            data: function (validator) {
              return {
                name: validator.getFieldElements('name').val(),
                csrf_token_name: csrf_token,
                id: validator.getFieldElements('id').val()
              };
            },
            message: 'This rating type name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter rating type name'

          }
        }
      },

    }
  }).on('success.form.bv', function (e) {


    return true;
  });


  $("#amount").on("change", function () {
    var amount = $('#amount').val();

    if ((amount) == 0) {
      $(".duration").val('0').trigger('change')
      $(".duration").attr("disabled", true);
    } else {
      $(".duration").val('').trigger('change')
      $(".duration").attr("disabled", false);
    }
  })

  $(".duration").on("change", function () {
    var description = $(".duration option:selected").text();
    $("#subscription_description").val(description);
  })

  $('#editSubscription').bootstrapValidator({
    fields: {
      subscription_name: {
        validators: {
          remote: {
            url: base_url + 'service/check_subscription_name',
            data: function (validator) {
              return {
                subscription_name: validator.getFieldElements('subscription_name').val(),
                csrf_token_name: csrf_token,
                subscription_id: validator.getFieldElements('subscription_id').val()
              };
            },
            message: 'This subscription name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter subscription name'

          }
        }
      },
      amount: {
        validators: {
          notEmpty: {
            message: 'Please enter subscription amount'
          }
        }
      },
      duration: {
        validators: {
          notEmpty: {
            message: 'Please select subscription duration'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {

    return true;
  });

  $('#addKeyword').bootstrapValidator({
    fields: {
      multiple_key: {
        validators: {
          notEmpty: {
            message: 'Please enter keyword'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {

    var page_key = $('#page_key').val();
    var multiple_key = $('#multiple_key').val();
    $.ajax({
      type: 'POST',
      url: base_url + 'admin/language/save_keywords',
      data: { page_key: page_key, multiple_key: multiple_key },
      success: function (response) {
        if (response == 1) {
          window.location = base_url + 'language/' + page_key;
        }
      }
    });
    return false;
  });

  $('#image_upload_error').hide();
  $('#image_error').hide();


  var csrf_toiken = $('#admin_csrf').val();
  var url = base_url + 'admin/profile/check_password';

  $('#change_password_form').bootstrapValidator({
    fields: {
      current_password: {
        validators: {
          remote: {
            url: url,
            data: function (validator) {
              return {
                current_password: validator.getFieldElements('current_password').val(),
                'csrf_token_name': csrf_token
              };
            },
            message: 'Current Password is Not Valid',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please Enter Current Password'
          }
        }
      },

      new_password: {
        validators: {
          stringLength: {
            min: 4,
            message: 'The full name must be less than 4 characters'
          },
          different: {
            field: 'current_password',
            message: 'The username and password cannot be the same as each other'
          },
          notEmpty: {
            message: 'Please Enter Password...'
          }
        }
      },
      confirm_password: {
        validators: {
          identical: {
            field: 'new_password',
            message: 'New and Repeat password are mismatch'
          },
          notEmpty: {
            message: 'Please Enter Password...'
          }
        }
      }
    }
  }).on('success.form.bv', function (e) {
    e.preventDefault();
    $.ajax({
      url: base_url + 'admin/profile/change_password',
      type: "post",
      data: $('#change_password_form').serialize(),
      success: function (response) {
        if (response == 1) {
          Swal.fire({
            title: "Password Updated..!",
            text: "Password Updated SuccessFully..",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        } else if (response == 3) {
          Swal.fire({
            title: "Password Updated..!",
            text: "Unable to access this feature in Demo mode",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: "Something went wrong, Try again!",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      }

    })

  });

  function update_language(lang_key, lang, page_key) {
    var cur_val = $('input[name="' + lang_key + '[' + lang + ']"]').val();
    var prev_val = $('input[name="prev_' + lang_key + '[' + lang + ']"]').val();

    $.post(base_url + 'admin/language/update_language', { lang_key: lang_key, lang: lang, cur_val: cur_val, page_key: page_key }, function (data) {
      if (data == 1) {
        $("#flash_success_message").show();
      }
      else if (data == 0) {
        $('input[name="' + lang_key + '[' + lang + ']"]').val(prev_val);
        $("#flash_error_message").html('Sorry, This keyword already exist!');
        $("#flash_error_message").show();
      }
      else if (data == 2) {
        $('input[name="' + lang_key + '[' + lang + ']"]').val(prev_val);
        $("#flash_error_message").html('Sorry, This field should not be empty!');
        $("#flash_error_message").show();
      }
    });
  }

  function upload_images() {
    var img = $('.avatar-input').val();
    if (img != '') {
      $('#image_upload_error').hide();
      return true;
    } else {
      $('#image_upload_error').text('Please Upload an Image . ');
      $('#image_upload_error').show();
      return false;
    }
  }

  function changeAdminProfile() {
    $('#image_error').hide();
    var profile_img = $('#crop_prof_img').val();
    var adminmail = $('#adminmail').val();

    var error = 0;


    if (error == 0) {
      var url = base_url + 'admin/profile/update_profile';
      //fetch file
      var formData = new FormData();
      formData.append('profile_img', profile_img);
      formData.append('adminmail', adminmail);
      formData.append('csrf_token_name', csrf_token);
      $.ajax({
        url: url,
        type: "POST",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        context: this,
        success: function (res) {
          window.location.href = base_url + 'admin-profile';
        }
      });
    }
  }

  function delete_category(id) {
    $('#delete_category').modal('show');
    $('#category_id').val(id);
  }

  function delete_subcategory(id) {
    $('#delete_subcategory').modal('show');
    $('#subcategory_id').val(id);
  }

  function delete_ratings_type(id) {
    $('#delete_ratings_type').modal('show');
    $('#id').val(id);
  }


  $(document).on("click", ".delete_show", function () {
    var id = $(this).attr('data-id');
    admin_delete_modal_show(id);
  });

  $(document).on("click", "#chkdel_subcribe", function () {
    var id = $(this).attr('sid');
    subdelete_modal_show(id);
  });
  function subdelete_modal_show(id) {
    $('#sub_delete_modal').modal('show');
    $('#confirm_delete_sub1').attr('data-id', id);
  }
  $('#confirm_delete_sub1').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_subcriptions(id);
  });
  function confirm_delete_subcriptions(id) {
    if (id != '') {
      $('#sub_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/service/delete_subsciption',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          if (response == 'success') {
            Swal.fire({
              title: "Success..!",
              text: "Deleted SuccessFully",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Failure..!",
              text: "Unable to access this feature in Demo mode",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          }

        }
      });
    }
  }

  function admin_delete_modal_show(id) {
    $('#delete_modal').modal('show');
    $('#confirm_btn').attr('data-id', id);
    $('#confirm_delete_pro').attr('data-id', id);
    $('#confirm_btn_admin').attr('data-id', id);
  }
  $('#confirm_btn_admin').on('click', function () {
    var id = $(this).attr('data-id');
    var url = base_url + "admin/dashboard/adminuser_delete";
    delete_confirm(id, url);
  });
  function delete_confirm(id, url) {
    if (id != '') {
      $('#delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: url,
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          if (response.status) {
            Swal.fire({
              title: "Success..!",
              text: response.msg,
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });

          }
          else {
            Swal.fire({
              title: "Error..!",
              text: response.msg,
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          }
        }
      });
    }
  }

  /*Footer submenu*/
  $(document).ready(function () {
    if ($("#main_menu option:selected").text() == "category") {
      $("#category").show();
      $('#category_count').attr('required', '');
      $('#category_count').attr('data-error', 'This field is required.');
      $("#hidey").hide();
      $("#quick_link").hide();
      $("#contact_us").hide();
      $("#follow_us").hide();
    } else if ($("#main_menu option:selected").text() == "Quick Link") {
      $("#quick_link").show();
      $('#footer_submenu').attr('required', '');
      $('#link').attr('required', '');
      $("#category").hide();
      $("#hidey").hide();
      $("#contact_us").hide();
      $("#follow_us").hide();
    } else if ($("#main_menu option:selected").text() == "Follow Us") {
      $("#follow_us").show();
      $("#category").hide();
      $("#quick_link").hide();
      $("#contact_us").hide();
      $("#hidey").hide();
    } else if ($("#main_menu option:selected").text() == "Contact Us") {
      $("#contact_us").show();
      $('#address').attr('required', '');
      $('#phone').attr('required', '');
      $('#email').attr('required', '');
      $("#category").hide();
      $("#hidey").hide();
      $("#quick_link").hide();
      $("#follow_us").hide();
    } else {
      $("#category").hide();
      $('#category_count').removeAttr('required');
      $('#category_count').removeAttr('data-error');
    }
  });

  $("#main_menu").change(function () {
    if ($("#main_menu option:selected").text() == "category") {
      $("#category").show();
      $('#category_count').attr('required', '');
      $('#category_count').attr('data-error', 'This field is required.');
      $("#hidey").hide();
      $("#quick_link").hide();
      $("#contact_us").hide();
      $("#follow_us").hide();
      $("#category_check").hide();
    } else {
      $("#category").hide();
      $("#category_check").hide();
      $('#category_count').removeAttr('required');
      $('#category_count').removeAttr('data-error');
    }
    if ($("#main_menu option:selected").text() == "Follow Us") {
      $("#follow_us").show();
      $("#category").hide();
      $("#quick_link").hide();
      $("#contact_us").hide();
      $("#hidey").hide();
    } else {
      $("#follow_us").hide();
    }
    if ($("#main_menu option:selected").text() == "Contact Us") {
      $("#contact_us").show();
      $('#address').attr('required', '');
      $('#phone').attr('required', '');
      $('#email').attr('required', '');
      $("#category").hide();
      $("#hidey").hide();
      $("#quick_link").hide();
      $("#follow_us").hide();
    } else {
      $("#contact_us").hide();
      $('#address').removeAttr('required', '');
      $('#phone').removeAttr('required', '');
      $('#email').removeAttr('required', '');
    }
    if ($("#main_menu option:selected").text() == "Quick Link") {
      $("#quick_link").show();
      $('#footer_submenu').attr('required', '');
      $('#link').attr('required', '');
      $("#category").hide();
      $("#hidey").hide();
      $("#contact_us").hide();
      $("#follow_us").hide();
    } else {
      $("#quick_link").hide();
      $('#footer_submenu').removeAttr('required', '');
      $('#link').removeAttr('required', '');
    }
  });

  $(document).ready(function () {
    var but = $('#quick_link').val();
    var max = 4;
    var x = 1;
    $("#btn1").click(function () {
      if (x <= max) {
        $("#quick_link").append('<div class="form-group" id="quick_link"><div class="row"><div class="col-sm-6"> <div class="form-group sub_menu ml-3"><div class="row"><label class="col-sm-3 control-label mt-2">Label</label><div class="col-sm-9"><input type="text" class="form-control" name="label[]" attr="label" id="label" value=""></div></div></div></div><div class="col-sm-6"><div class="form-group sub_menu"><div class="row"><label class="col-sm-3 control-label mt-2">Link</label><div class="col-sm-9"><input type="text" class="form-control" name="link[]" attr="link" id="link" value="" required></div></div></div></div></div></div>');
        x++;
      } else {
        alert('Allowing 5 links only');
      }
    });
  });

  /*appsection*/
  $('#appsection_showhide').on('click', function () {
    if ($('#appsection_showhide').prop("checked") == true) {
      $('#store_links').show();
    } else {
      $('#store_links').hide();
    }
  });
  $(document).ready(function () {
    if ($('#appsection_showhide').prop("checked") == true) {
      $('#store_links').show();
    } else {
      $('#store_links').hide();
    }
  });

  /*sms gateway*/
  $(document).ready(function () {
    $("#2factor_div").css({ "display": "none" });
    $("#twilio_div").css({ "display": "none" });

    $("ul li").click(function () {
      if ($(this).attr("data-id") == "nexmo") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#nexmo_div").css({ "display": "" });

        $("#2factor_div").css({ "display": "none" });
        $("#twilio_div").css({ "display": "none" });
      }

      if ($(this).attr("data-id") == "2factor") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#2factor_div").css({ "display": "" });

        $("#twilio_div").css({ "display": "none" });
        $("#nexmo_div").css({ "display": "none" });
      }

      if ($(this).attr("data-id") == "twilio") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#twilio_div").css({ "display": "" });

        $("#2factor_div").css({ "display": "none" });
        $("#nexmo_div").css({ "display": "none" });
      }
    });
  });

  $(document).ready(function () {
    $(".sms_option").click(function () {
      var clickedByme = $(this).val();

      $('.sms_option').each(function () {
        if (clickedByme != this.value) {
          $(this).prop('checked', false);
        }
      });
    });
  });

  $(document).on("click", ".addfaq", function () {
    var experiencecontent = '<div class="row counts-list" id="faq_content">' +
      '<div class="col-md-11">' +
      '<div class="cards">' +
      '<div class="form-group">' +
      '<label>Title</label>' +
      '<input type="text" class="form-control" name="page_title[]" style="text-transform: capitalize;" required>' +
      '</div>' +
      '<div class="form-group mb-0">' +
      '<label>Page Content</label>' +
      ' <textarea class="form-control content-textarea" id="ck_editor_textarea_id"  name="page_content[]"></textarea>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '<div class="col-md-1">' +
      '<a href="#" class="btn btn-sm bg-danger-light delete_faq">' +
      '<i class="far fa-trash-alt "></i> ' +
      '</a>' +
      '</div>' +
      '</div> ';

    $(".faq").append(experiencecontent);
    return false;
  });


  function faq_delete(id) {
    var r = confirm("Deleting FAQ will also delete its related all datas!! ");
    if (r == true) {

      var csrf_token = $('#active_csrf').val();
      $.ajax({
        type: 'POST',
        url: base_url + "admin/settings/faq_delete",
        data: {
          id: id,
          csrf_token_name: csrf_token
        },
        success: function (response) {

          if (response == 'success') {
            window.location = base_url + 'admin/settings/faq_delete';
          } else {

            window.location = base_url + 'admin/settings/faq_delete';
          }
        }
      });

    } else {
      return false;
    }


  }
  $(document).ready(function () {
    $(document).on("click", ".faq_delete", function () {
      var id = $(this).attr('data-id');
      faq_delete(id);
    });
  });

  function getcurrencysymbol(currencies) {
    var csrf_toiken = $('#admin_csrf').val();
    $.ajax({
      type: "POST",
      url: base_url + "admin/settings/get_currnecy_symbol",
      data: {
        id: currencies,
        'csrf_token_name': csrf_token,
      },

      success: function (data) {
        $('#currency_symbol').val(data);
      }
    });
  }
  $(document).ready(function () {
    $(document).on("change", ".currency_code", function () {
      var currencies = $('#currency_option option:selected').text();
      getcurrencysymbol(currencies);
    });

    $(document).on("change", ".countryCode", function () {
      var countryKey = $(this).find(':selected').attr('data-key');
      $('#country_code_key').val(countryKey);
    });
  });

  $(document).on("click", ".addquicklinknew", function () {
    var len = $('.links-cont').length + 1;
    if (len <= 6) {
      var experiencecontent = '<div class="form-group links-cont">' +
        '<div class="row align-items-center">' +
        '<div class="col-lg-3 col-12">' +
        '<input type="text" class="form-control" name="label[]" attr="label" id="label" value="">' +
        '</div>' +
        '<div class="col-lg-7 col-12">' +
        '<input type="text" class="form-control" name="link[]" attr="link" id="link" value="' + base_url + '">' +
        '</div>' +
        '<div class="col-lg-1 col-12">' +
        '<a href="#" class="btn btn-sm bg-danger-light delete_links">' +
        '<i class="far fa-trash-alt "></i> ' +
        '</a>' +
        '</div>' +
        '</div>' +
        '</div>';
      $(".links-forms").append(experiencecontent);
    } else {
      $('.addlinknew').hide();
      alert('Allow 6 links only');
    }
    return false;
  });

  $(document).on("click", ".addlinknew", function () {
    var len = $('.links-cont').length + 1;
    if (len <= 6) { 
      var clone = $(".links-cont:first").clone();
      $(clone).attr('id', 'link_'+(len-1)); //change cloned element id attribute      
      $(clone).find('input[type="text"]').attr('value','');
      $(clone).insertAfter( ".links-cont:last" );
    } else {
      $('.addlinknew').hide();
      alert('Allow 6 links only');
    }
    return false;
  });

  //Remove updated Links menus
  $(document).on("click", ".delete_links", function () {
    var id = $(this).attr('data-id');
    $('#link_' + id).remove();
    return false;
  });

  //Remove new Links menus
  $(document).on("click", ".delete_links", function () {
    $(this).closest('.links-cont').remove();
    return false;
  });

  $(document).on("click", ".addsocail", function () {
    var experiencecontent = '<div class="form-group countset">' +
      '<div class="row align-items-center">' +
      '<div class="col-lg-2 col-12">' +
      '<div class="socail-links-set">' +
      '<ul>' +
      '<li class=" dropdown has-arrow main-drop">' +
      '<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">' +
      '<span class="user-img">' +
      '<i class="fab fa-github me-2"></i>' +
      '</span>' +
      '</a>' +
      '<div class="dropdown-menu">' +
      '<a class="dropdown-item" href="#"><i class="fab fa-facebook-f me-2"></i>Facebook</a>' +
      '<a class="dropdown-item" href="#"><i class="fab fa-twitter me-2"></i>twitter</a>' +
      '<a class="dropdown-item" href="#"><i class="fab fa-youtube me-2"></i> Youtube</a>' +
      '</div>' +
      '</li>' +
      '</ul>' +
      '</div>' +
      '</div>' +
      '<div class="col-lg-9 col-12">' +
      '<input type="text" class="form-control" name="snapchat" attr="snapchat" id="facebook" value="">' +
      '</div>' +
      '<div class="col-lg-1 col-12">' +
      '<a href="#" class="btn btn-sm bg-danger-light  delete_review_comment">' +
      '<i class="far fa-trash-alt "></i> ' +
      '</a>' +
      '</div>' +
      '</div> ' +
      '</div> ';

    $(".setings").append(experiencecontent);
    return false;
  });

  $(".setings").on('click', '.delete_review_comment', function () {
    $(this).closest('.countset').remove();
    return false;
  });

  $(document).on("click", ".addnewlinks", function () {

    var len = $('.copyright_content').length + 1;
    if (len <= 3) {
      var experiencecontent = '<div class="form-group links-conts copyright_content">' +
        '<div class="row align-items-center">' +
        '<div class="col-lg-3 col-12">' +
        '<input type="text" class="form-control" value="" name="label1[]">' +
        '</div>' +
        '<div class="col-lg-6 col-12">' +
        '<input type="text" class="form-control" value="' + base_url + '" name="link1[]">' +
        '</div>' +
        '<div class="col-lg-1 col-12">' +
        '<a href="#" class="btn btn-sm bg-danger-light delete_copyright">' +
        '<i class="far fa-trash-alt "></i> ' +
        '</a>' +
        '</div>' +
        '</div>' +
        '</div>';
      $(".settingset").append(experiencecontent);
    } else {
      $('.add-addnewlinks').hide();
      alert('Allow 3 links only');
    }
    return false;

  });

  //Remove updated copyright menus
  $(document).on("click", ".delete_copyright", function () {
    var id = $(this).attr('data-id');
    $('#link1_' + id).remove();
    return false;
  });

  //Remove new copyright menus
  $(document).on("click", ".delete_copyright", function () {
    $(this).closest('.copyright_content').remove();
    return false;
  });

  $(document).ready(function () {
    $("#2factor_div").css({ "display": "none" });
    $("#twilio_div").css({ "display": "none" });

    $("ul li").click(function () {
      if ($(this).attr("data-id") == "nexmo") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#nexmo_div").css({ "display": "" });

        $("#2factor_div").css({ "display": "none" });
        $("#twilio_div").css({ "display": "none" });
      }

      if ($(this).attr("data-id") == "2factor") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#2factor_div").css({ "display": "" });

        $("#twilio_div").css({ "display": "none" });
        $("#nexmo_div").css({ "display": "none" });
      }

      if ($(this).attr("data-id") == "twilio") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#twilio_div").css({ "display": "" });

        $("#2factor_div").css({ "display": "none" });
        $("#nexmo_div").css({ "display": "none" });
      }
    });
  });

  $(document).ready(function () {
    $(".sms_option").click(function () {
      var clickedByme = $(this).val();

      $('.sms_option').each(function () {
        if (clickedByme != this.value) {
          $(this).prop('checked', false);
        }
      });
    });
  });

  $('.noty_clear').on('click', function () {
    var id = $(this).attr('data-token');
    noty_clear(id);
  });
  function noty_clear(id) {
    if (id != '') {
      $.ajax({
        type: "post",
        url: base_url + "home/clear_all_noty",
        data: { csrf_token_name: csrf_token, id: id },
        dataType: 'json',
        success: function (data) {


          if (data.success) {
            $('.notification-list li').remove();
            $('.bg-yellow').text(0);
          }
        }

      });
    }
  }

  $(document).ready(function () {
    $("#selectallad1").change(function () {
      if (this.checked) {
        $(".checkboxad").each(function () {
          this.checked = true;
        })
      } else {
        $(".checkboxad").each(function () {
          this.checked = false;
        })
      }
    });

    $(".checkboxad").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;
        $(".checkboxad").each(function () {
          if (!this.checked)
            isAllChecked = 1;
        })
        if (isAllChecked == 0) { $("#selectallad1").prop("checked", true); }
      } else {
        $("#selectallad1").prop("checked", false);
      }
    });

    if ($(".checkboxad").is(":checked")) {
      var isAllChecked = 0;
      $(".checkboxad").each(function () {
        if (!this.checked)
          isAllChecked = 1;
      })
      if (isAllChecked == 0) { $("#selectallad1").prop("checked", true); }
    } else {
      $("#selectallad1").prop("checked", false);
    }
  });

  $(document).ready(function () {
    var loginemail = $('.loginemail').val()
    if (loginemail == 'email') {
      $("#otp_by").hide();
    }
    $('#chkYes').on('change', function () {
      $("#otp_by").hide();
    });
    $('#phpmail').on('change', function () {
      $("#otp_by").show();
    });
  });

  $(document).ready(function () {
    var chat_type = $('.chatype').val()
    if (chat_type == 'php_chat') {
      $("#websocket_details").hide();
    }
    $('#php_chat').on('change', function () {
      $("#websocket_details").hide();
    });
    $('#websocket').on('change', function () {
      $("#websocket_details").show();
    });
  });

  $('.lang_code').on('click', function () {
    var lang_code = $(this).attr('data-lang');
    $('#code_value').val(lang_code);
  });

  $('.lang_app_code').on('click', function () {
    var lang_code = $(this).attr('data-lang');
    $('#code_app_value').val(lang_code);
  });

  $(document).on("click", "#not_del", function () {
    var id = $(this).attr('data-id');
    delete_modal_show(id);
  });
  function delete_modal_show(id) {
    $('#not_delete_modal').modal('show');
    $('#confirm_delete_sub').attr('data-id', id);
  }
  $('#confirm_delete_sub').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_subcription(id);
  });
  function confirm_delete_subcription(id) {
    if (id != '') {
      $('#not_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'user/service/pro_not_del',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          Swal.fire({
            title: "Success..!",
            text: "Deleted SuccessFully",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      });
    }
  }

  $(document).on("click", "#not_del_all", function () {
    var id = $(this).attr('data-id');
    alldelete_modal_show(id);
  });
  function alldelete_modal_show(id) {
    $('#notall_delete_modal').modal('show');
    $('#confirm_deleteall_sub').attr('data-id', id);
  }
  $('#confirm_deleteall_sub').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_deleteall_subcription(id);
  });
  function confirm_deleteall_subcription(id) {
    if (id == '') {
      $('#notall_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'user/service/pro_not_del',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          Swal.fire({
            title: "Success..!",
            text: "Deleted SuccessFully",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      });
    }
  }

  $('#currency_add').bootstrapValidator({
    fields: {
      currency_name: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency name'

          }
        }
      },
      currency_symbol: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency Symbol'

          }
        }
      },
      currency_code: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency Code'

          }
        }
      },
      rate: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency Rate'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#currency_edit').bootstrapValidator({
    fields: {
      currency_name: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency name'

          }
        }
      },
      currency_symbol: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency Symbol'

          }
        }
      },
      currency_code: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency Code'

          }
        }
      },
      rate: {
        validators: {
          notEmpty: {
            message: 'Please enter Currency Rate'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $(document).on("click", "#cur_del", function () {
    var id = $(this).attr('data-id');
    alldelete_modal_show(id);
  });
  function alldelete_modal_show(id) {
    $('#cur_delete_modal').modal('show');
    $('#confirm_delete_cur').attr('data-id', id);
  }
  $('#confirm_delete_cur').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_currency(id);
  });
  function confirm_delete_currency(id) {
    if (id != '') {
      $('#cur_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/settings/cur_delete',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          Swal.fire({
            title: "Success..!",
            text: "Deleted SuccessFully",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      });
    }
  }

  $('.pages_list_status').on('click', function () {
    var id = $(this).attr('data-id');
    pages_list_status(id);
  });
  function pages_list_status(id) {
    var stat = $('#pages_list_status' + id).prop('checked');
    if (stat == true) {
      var status = 1;
    }
    else {
      var status = 2;
    }
    var url = base_url + 'admin/settings/page_list_status';
    var status_id = id;
    var status = status;
    var data = {
      status_id: status_id,
      status: status,
      csrf_token_name: csrf_token
    };
    $.ajax({
      url: url,
      data: data,
      type: "POST",
      success: function (data) {
        console.log(data);
        if (data.trim() == "success") {
          Swal.fire({
            title: "Pages",
            text: "Status Changed SuccessFully....!",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          });
        } else if (data == "failure") {
          Swal.fire({
            title: "Pages",
            text: "Unable to access this feature in Demo mode",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          });
        } else {
          Swal.fire({
            title: "Pages",
            text: "Something went wrong, Try again later!",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          });
        }
      }
    });
  }

  $('.refundstatus').on('change', function () {
    var id = $(this).attr('data-id');
    var payId = $(this).attr('data-pay');

    var statusId = $(this).val();
    var subDetailId = $(this).attr('data-detail-id');
    if (statusId) {
      var url = base_url + 'admin/settings/offline_status';
      var status_id = id;
      var detail_id = subDetailId;
      var status = status;
      var payId = payId;
      var data = {
        status_id: status_id,
        status: statusId,
        detailId: detail_id,
        payId: payId,
        csrf_token_name: csrf_token
      };

      $.ajax({

        url: url,
        data: data,
        type: "POST",
        success: function (data) {
          console.log(data);
          if (data == 1) {
            Swal.fire({
              title: "offline Payment",
              text: "Status Changed SuccessFully....!",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          } else if (data == "2") {
            Swal.fire({
              title: "Faliure",
              text: "Unable to change status in Demo mode",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          }
        }
      });
    } else {
      return false;
    }
  });

  $(document).on("click", "#pages_del", function () {
    var id = $(this).attr('data-id');
    pagesdelete_modal_show(id);
  });
  function pagesdelete_modal_show(id) {
    $('#pages_delete_modal').modal('show');
    $('#confirm_delete_pages').attr('data-id', id);
  }
  $('#confirm_delete_pages').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_pages(id);
  });
  function confirm_delete_pages(id) {
    if (id != '') {
      $('#pages_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/settings/pages_delete',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          if (response == 'success') {
            Swal.fire({
              title: "Success..!",
              text: "Deleted SuccessFully",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          } else if (response == 'failure') {
            Swal.fire({
              title: "Failure",
              text: "Unable to add pages in Demo mode",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Failure",
              text: "Something went wrong, Try again!",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          }
        }
      });
    }
  }

  $(document).ready(function () {
    $('.select').selectpicker();

    //location
    $("#category1,#subcategory").selectpicker();

    $.ajax({

      type: "GET",
      url: base_url + "admin/service/get_category",
      data: { id: $(this).val(), 'csrf_token_name': csrf_token },
      beforeSend: function () {
        $("#category option:gt(0)").remove();
        $('#category').selectpicker('refresh');
        $("#category").selectpicker();
        $('#category').find("option:eq(0)").html("Select Category..");
        $('#category').selectpicker('refresh');
        $("#category").selectpicker();
      },
      success: function (data) {
        $('#category').selectpicker('refresh');
        $("#category").selectpicker();
        $('#category').find("option:eq(0)").html("Select Category");
        $('#category').selectpicker('refresh');
        $("#category").selectpicker();
        var obj = jQuery.parseJSON(data);
        $('#category').selectpicker('refresh');
        $("#category").selectpicker();
        $(obj).each(function () {
          var option = $('<option />');
          option.attr('value', this.value).text(this.label);
          $('#category').append(option);
        });
        $('#category').selectpicker('refresh');
        $("#category").selectpicker();
        $("#category").val($("#hid_category").val());
      }
    });


    //jaya
    $('#category').on('change', function () {

      // $("#subcategory").selectpicker();
      if ($(this).val()) {
        $('#step1_footer').prop("disabled", false);
      } else {
        $('#step1_footer').prop("disabled", true);
      }

      $('#subcategory').html('<option value="">Select subcategory</option>');

      if ($(this).val() != '') {
        $.ajax({
          type: "POST",
          url: base_url + "user/service/get_subcategory",
          data: { id: $(this).val(), 'csrf_token_name': csrf_token },
          beforeSend: function() {
            $("#subcategory option:gt(0)").remove();
            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
            $('#subcategory').find("option:eq(0)").html("Please wait..");
            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
        },
        success: function(data) {
            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
            $('#subcategory').find("option:eq(0)").html("Select SubCategory");
            $('#subcategory').selectpicker('refresh');

            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
            if (data) {
                var obj = jQuery.parseJSON(data);
                $(obj).each(function() {
                    var option = $('<option />');
                    option.attr('value', this.value).text(this.label);
                    $('#subcategory').append(option);
                });
            }

            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
        }
        });
      }
    });
    $('#category1').on('change', function () {

      $("#subcategory").selectpicker();
      if ($(this).val()) {
        $('#step1_footer').prop("disabled", false);
      } else {
        $('#step1_footer').prop("disabled", true);
      }

      $('#subcategory').html('<option value="">Select subcategory</option>');

      if ($(this).val() != '') {
        $.ajax({
          type: "POST",
          url: base_url + "user/service/get_subcategory",
          data: { id: $(this).val(), 'csrf_token_name': csrf_token },
          beforeSend: function () {
            $("#subcategory option:gt(0)").remove();
            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
            $('#subcategory').find("option:eq(0)").html("Please wait..");
            $('#subcategory').selectpicker('refresh');
            $("#subcategory").selectpicker();
          },
          success: function (data) {
              $('#subcategory').selectpicker('refresh');
              $("#subcategory").selectpicker();
              $('#subcategory').find("option:eq(0)").html("Select SubCategory");
              $('#subcategory').selectpicker('refresh');

              $('#subcategory').selectpicker('refresh');
              $("#subcategory").selectpicker();
              if (data) {
                  var obj = jQuery.parseJSON(data);
                  $(obj).each(function() {
                      var option = $('<option />');
                      option.attr('value', this.value).text(this.label);
                      $('#subcategory').append(option);
                  });
              }

              $('#subcategory').selectpicker('refresh');
              $("#subcategory").selectpicker();

          }
        });
      }
    });


    function chknum() {
      $('.onlynumber').keyup(function (e) {
        if (/\D/g.test(this.value)) {
          this.value = this.value.replace(/\D/g, '');
        }
      });
    }
    //additional service
    $(".add-additional").on('click', function () {
      $(".additional-cont-label").removeClass("d-none");
      var durintxt = $("#durintxt").val();
      var membershipcontent = '<div class="row form-row additional-cont">' +

        '<div class="col-12 col-md-10 col-lg-4">' +
        '<div class="form-group">' +
        '<input class="form-control addicls" type="text" name="addi_servicename[]" id="addi_name" />' +
        '</div>' +
        '</div>' +

        '<div class="col-12 col-md-10 col-lg-3">' +
        '<div class="form-group">' +
        '<input class="form-control addicls onlynumber" type="text" name="addi_serviceamnt[]" id="addi_amnt" />' +
        '</div>' +
        '</div>' +

        '<div class="col-12 col-md-10 col-lg-3">' +
        '<div class="form-group">' +
        '<div class="input-group">  ' +
        '<input type="text" class="form-control addicls onlynumber" name="addi_servicedura[]" id="addi_dura" />' +
        '<div class="input-group-append">' +
        '<span class="input-group-text" id="basic-addon2">' + durintxt + '</span>' +
        '</div>     ' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="col-12 col-md-2 col-lg-2">' +
        '<a href="#" class="btn btn-danger trash"><i class="far fa-times-circle"></i></a>' +
        '</div>' +

        '</div>';
      $(".additional-info").append(membershipcontent);
      chknum();
      return false;
    });
    $(".additional-info").on('click', '.additional-cont .trash-alert', function () {
      var tit = $(this).attr('data-addialerttxt');
      var txt = $(this).attr('data-addialertmsg');
      swal({
        title: tit,
        text: txt,
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false
      }).then(function () {

      });
    });


    $(".additional-info").on('click', '.additional-cont .trash', function () {
      $(this).closest('.additional-cont').remove();
      var divCount = $('.additional-cont').length;
      if (divCount == 0) {
        $(".additional-cont-label").addClass("d-none");
      }
      return false;
    });


    // Membership Add More

    $(".membership-info").on('click', '.trash', function () {
      $(this).closest('.membership-cont').remove();
      $(".add-membership").css("display", "");
      return false;
    });

    $(".add-membership").on('click', function () {
      var len = $('.membership-cont').length + 1;
      if (len <= 4) {
        var membershipcontent = '<div class="row form-row membership-cont">' +
          '<div class="col-12 col-md-10">' +
          '<div class="form-group">' +
          '<input type="text" class="form-control" name="service_offered[]" id="field1">' +
          '</div>' +
          '</div>' +
          '<div class="col-12 col-md-2">' +
          '<a href="#" class="btn btn-danger trash"><i class="far fa-times-circle"></i></a>' +
          '</div>' +
          '</div>';
        $(".membership-info").append(membershipcontent);
      } else {
        $('.add-membership').hide();
        alert('Allow 4 links only');
      }
      return false;
    });

    $('.delete_img').on('click', function () {
      var img_id = $(this).attr('data-img_id');
      var service_id = $('#service_id').val();

      delete_img(img_id, service_id);
    });

    function delete_img(img_id, service_id) {

      $.ajax({
        type: "POST",
        url: base_url + 'user/service/delete_service_img',
        data: { img_id: img_id, service_id: service_id, csrf_token_name: csrf_token },
        success: function (data) {
          if (data == 0) {
            Swal.fire({
              title: "Edit Service",
              text: "Each Service Should have Atleast One Image",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
            });
          } else {
            $('#service_img_' + img_id).remove();
          }

        }
      });
    }
  });

  $(document).on("click", "#ear_del", function () {
    var id = $(this).attr('data-id');
    alldelete_modal_show(id);
  });
  function alldelete_modal_show(id) {
    $('#ear_delete_modal').modal('show');
    $('#confirm_delete_ear').attr('data-id', id);
  }
  $('#confirm_delete_ear').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_earnings(id);
  });
  function confirm_delete_earnings(id) {
    if (id != '') {
      $('#ear_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/payments/ear_delete',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          Swal.fire({
            title: "Success..!",
            text: "Deleted SuccessFully",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      });
    }
  }

  $(document).on("click", "#state_del", function () {
    var id = $(this).attr('data-id');
    state_delete_modal_show(id);
  });
  function state_delete_modal_show(id) {
    $('#state_delete_modal').modal('show');
    $('#confirm_delete_state').attr('data-id', id);
  }
  $('#confirm_delete_state').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_state(id);
  });
  function confirm_delete_state(id) {
    if (id != '') {
      $('#state_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/dashboard/state_delete',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          if (response == 'failure') {
            Swal.fire({
              title: "Failure..!",
              text: "Unable to add payouts in Demo mode",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Success",
              text: "State Deleted SuccessFully",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          }

        }
      });
    }
  }
  $(document).on("click", "#country_del", function () {
    var id = $(this).attr('data-id');
    country_delete_modal_show(id);
  });
  function country_delete_modal_show(id) {
    $('#country_delete_modal').modal('show');
    $('#confirm_delete_country').attr('data-id', id);
  }
  $('#confirm_delete_country').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_country(id);
  });
  function confirm_delete_country(id) {
    if (id != '') {
      $('#country_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/dashboard/country_delete',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          if (response == 'failure') {
            Swal.fire({
              title: "Failure..!",
              text: "Unable to add payouts in Demo mode",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Success",
              text: "country Deleted SuccessFully",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false
            }).then(function () {
              location.reload();
            });
          }

        }
      });
    }
  }


  $(document).on("click", "#city_del", function () {
    var id = $(this).attr('data-id');
    city_delete_modal_show(id);
  });
  function city_delete_modal_show(id) {
    $('#city_delete_modal').modal('show');
    $('#confirm_delete_city').attr('data-id', id);
  }
  $('#confirm_delete_city').on('click', function () {
    var id = $(this).attr('data-id');
    confirm_delete_city(id);
  });
  function confirm_delete_city(id) {
    if (id != '') {
      $('#city_delete_modal').modal('hide');
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/dashboard/city_delete',
        data: { id: id, csrf_token_name: csrf_token },
        dataType: 'json',
        success: function (response) {
          Swal.fire({
            title: "Success..!",
            text: "Deleted SuccessFully",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function () {
            location.reload();
          });
        }
      });
    }
  }

  $('#edit_country').bootstrapValidator({
    fields: {
      country_code: {
        validators: {
          notEmpty: {
            message: 'Please enter Country Code'

          }
        }
      },
      country_id: {
        validators: {
          notEmpty: {
            message: 'Please enter Country ID'

          }
        }
      },
      country_name: {
        validators: {
          notEmpty: {
            message: 'Please enter Country Name'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  if (current_page != 'paysolution-payment-gateway' && current_page != 'iyzico-payment-gateway') {

    var country_id = $('#country_id_value').val();
    var state_id = $('#state_id_value').val();
    var city_id = $('#city_id_value').val();
    $(document).ready(function () {
      country_changes(country_id);
      state_changes(state_id);

      $('#country_id').on('change', function () {
        var id = $(this).val();
        country_changes(id);
      }); $('#state_id').on('change', function () {
        var id = $(this).val();
        state_changes(id);
      });
    });
    function country_changes(id) {
      var country_id = $('#country_id_value').val();
      var state_id = $('#state_id_value').val();
      var city_id = $('#city_id_value').val();
      if (id != '') {
        $.ajax({
          type: "POST",
          url: base_url + "user/service/get_state_details",
          data: { id: id, csrf_token_name: csrf_token },
          dataType: 'json',
          beforeSend: function () {
            $('#state_id').find("option:eq(0)").html("Please wait..");
          },
          success: function (data) {
            $('#state_id option').remove();
            if (data != '') {
              var add = '';
              add += '<option value="">Select State</option>';
              $(data).each(function (index, value) {
                add += '<option value=' + value.id + '>' + value.name + '</option>';
              });
              $('#state_id').append(add);

              if (state_id != '') {
                $('#state_id option[value=' + state_id + ']').attr('selected', 'selected');
              }

            }
          }
        });
      }
    }
    function state_changes(id) {
      var country_id = $('#country_id_value').val();
      var state_id = $('#state_id_value').val();
      var city_id = $('#city_id_value').val();
      if (id != '') {
        $.ajax({
          type: "POST",
          url: base_url + "user/service/get_city_details",
          data: { id: id, csrf_token_name: csrf_token },
          dataType: 'json',
          beforeSend: function () {
            $('#city_id').find("option:eq(0)").html("Please wait..");
          },
          success: function (data) {
            $('#city_id option').remove();
            if (data != '') {
              var add = '';
              add += '<option value="">Select City</option>';
              $(data).each(function (index, value) {
                add += '<option value=' + value.id + '>' + value.name + '</option>';
              });
              $('#city_id').append(add);
              if (city_id != '') {
                $('#city_id option[value=' + city_id + ']').attr('selected', 'selected');
              }
            }
          }
        });
      }
    }
  }

  $('#add_state').bootstrapValidator({
    fields: {
      countryid: {
        validators: {
          notEmpty: {
            message: 'Please enter Select Country'

          }
        }
      },
      state_name: {
        validators: {
          notEmpty: {
            message: 'Please enter State Name'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#add_city_code_config').bootstrapValidator({
    fields: {
      state_id: {
        validators: {
          notEmpty: {
            message: 'Please enter Select State'

          }
        }
      },
      city_name: {
        validators: {
          notEmpty: {
            message: 'Please enter City Name'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  $('#edit_state').bootstrapValidator({
    fields: {
      countryid: {
        validators: {
          notEmpty: {
            message: 'Please enter Select Country'

          }
        }
      },
      state_name: {
        validators: {
          notEmpty: {
            message: 'Please enter State Name'

          }
        }
      },
    }
  }).on('success.form.bv', function (e) {
    return true;
  });

  
  
  if(current_page == 'add-service' || current_pagename == 'edit-service') {
    var autocomplete;
    var locationType = $('#location_type').val(); 
    locationType = true;
    if (locationType == true) {
    function initialize() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        var  autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */
            (document.getElementById('service_location')), {
                types: ['geocode']
            });

        google.maps.event.addDomListener(document.getElementById('service_location'), 'focus', geolocate);
        autocomplete.addListener('place_changed', get_latitude_longitude);
    }

    function get_latitude_longitude() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var key = $("#map_key").val();
        $.get('https://maps.googleapis.com/maps/api/geocode/json', { address: place.formatted_address, key: key }, function(data, status) {

            $(data.results).each(function(key, value) {

                $('#service_address').val(place.formatted_address);
                $('#service_latitude').val(value.geometry.location.lat);
                $('#service_longitude').val(value.geometry.location.lng);
            });
        });
    }

    function geolocate() {

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {

                var geolocation = new google.maps.LatLng(
                    position.coords.latitude, position.coords.longitude);
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());

            });
        }
    }
    initialize();
}
  }
  /* Image Upload */
  if ($('#add_service,  #update_service').length > 0) {
    document.addEventListener("DOMContentLoaded", init, false);

    //To save an array of attachments 
    var AttachmentArray = [];

    //counter for attachment array
    var arrCounter = 0;

    //to make sure the error message for number of files will be shown only one time.
    var filesCounterAlertStatus = false;

    //un ordered list to keep attachments thumbnails
    var ul = document.createElement('ul');
    ul.className = ("upload-wrap");
    ul.id = "imgList";

    function init() {
      //add javascript handlers for the file upload event

      document.querySelector('#images').addEventListener('change', handleFileSelect, false);
    }

    //the handler for file upload event
    function handleFileSelect(e) {
      //to make sure the user select file/files
      if (!e.target.files) return;

      //To obtaine a File reference
      var files = e.target.files;

      // Loop through the FileList and then to render image files as thumbnails.
      for (var i = 0, f; f = files[i]; i++) {

        //instantiate a FileReader object to read its contents into memory
        var fileReader = new FileReader();

        // Closure to capture the file information and apply validation.
        fileReader.onload = (function (readerEvt) {
          return function (e) {

            //Apply the validation rules for attachments upload
            ApplyFileValidationRules(e, readerEvt)

            //Render attachments thumbnails.
            RenderThumbnail(e, readerEvt);

            //Fill the array of attachment
            FillAttachmentArray(e, readerEvt)
          };
        })(f);
        fileReader.readAsDataURL(f);
      }
      $("#lbl_img_not_added").text('');
      $("#imgList li").each(function () {
        if ($(this).find('img').length === 0) {
          $(this).remove();
        }
      });
      document.getElementById('images').addEventListener('change', handleFileSelect, false);
    }

    //To remove attachment once user click on x button
    jQuery(function ($) {
      $('div').on('click', '.upload-images .file_close', function () {
        var id = $(this).closest('.upload-images').find('img').data('id');
        //to remove the deleted item from array
        var elementPos = AttachmentArray.map(function (x) { return x.FileName; }).indexOf(id);

        if (elementPos !== -1) {
          AttachmentArray.pop(elementPos, 1);
        }

        //to remove image tag
        $(this).parent().find('img').not().remove();

        //to remove div tag that contain the image
        $(this).parent().find('div').not().remove();

        //to remove div tag that contain caption name
        $(this).parent().parent().find('div').not().remove();

        //to remove li tag
        var lis = document.querySelectorAll('#imgList ul li');

        for (var i = 0; i = lis[i]; i++) {
          if (i.innerHTML == "") {
            i.parentNode.removeChild(lis);
          }
        }
      });
    });

    //Apply the validation rules for attachments upload
    function ApplyFileValidationRules(e, readerEvt) {
      //To check file type according to upload conditions
      if (CheckFileType(readerEvt.type) == false) {
        alert("The file (" + readerEvt.name + ") does not match the upload conditions, You can only upload jpg/png/gif files");
        e.preventDefault();
        return;
      }

      //To check files count according to upload conditions
      if (CheckFilesCount(AttachmentArray) == false) {
        if (!filesCounterAlertStatus) {
          filesCounterAlertStatus = true;
          alert("You have added more than 10 files. According to upload conditions you can upload 10 files maximum");
        }
        e.preventDefault();
        return;
      }
    }

    //To check file type according to upload conditions
    function CheckFileType(fileType) {
      if (fileType == "image/jpeg") {
        return true;
      } else if (fileType == "image/png") {
        return true;
      } else if (fileType == "image/gif") {
        return true;
      } else {
        return false;
      }
      return true;
    }

    //To check file Size according to upload conditions
    function CheckFileSize(fileSize) {
      if (fileSize < 300000) {
        return true;
      } else {
        return false;
      }
      return true;
    }

    //To check files count according to upload conditions
    function CheckFilesCount(AttachmentArray) {
      //Since AttachmentArray.length return the next available index in the array, 
      //I have used the loop to get the real length
      var len = 0;
      for (var i = 0; i < AttachmentArray.length; i++) {
        if (AttachmentArray[i] !== undefined) {
          len++;
        }
      }
      //To check the length does not exceed 10 files maximum
      if (len > 9) {
        $("#images").val('');
        $('.submit_status').val(1);
        return false;
      } else {
        $('.submit_status').val(0);
        return true;
      }
    }

    //Render attachments thumbnails.
    function RenderThumbnail(e, readerEvt) {

      var ul = document.getElementById('imgList');
      var li = document.createElement('li');

      ul.appendChild(li);
      li.innerHTML = ['<div class="upload-images"> ' +
        '<a style="display:block;" href="javascript:void(0);" class="file_close btn btn-icon btn-danger btn-sm">X</a><img class="thumb" src="', e.target.result, '" title="', escape(readerEvt.name), '" data-id="',
      readerEvt.name, '"/>' + '</div>'
      ].join('');
      var div = document.createElement('div');
      div.className = "FileNameCaptionStyle d-none";
      li.appendChild(div);
      div.innerHTML = [readerEvt.name].join('');
      document.getElementById('uploadPreview').insertBefore(ul, null);
    }

    //Fill the array of attachment
    function FillAttachmentArray(e, readerEvt) {
      AttachmentArray[arrCounter] = {
        AttachmentType: 1,
        ObjectType: 1,
        FileName: readerEvt.name,
        FileDescription: "Attachment",
        NoteText: "",
        MimeType: readerEvt.type,
        Content: e.target.result.split("base64,")[1],
        FileSizeInBytes: readerEvt.size,
        file: readerEvt,
      };
      arrCounter = arrCounter + 1;
    }
  }

})(jQuery);

function export_language() {

  $('#exportModal').modal('show');
}

function excel_design_attendance() {
  //  alert("hi");
  // var attendance_month = $('#attendance_month').val();
  // var attendance_year = $('#attendance_year').val();
  // var employee_name = $('#employee_name').val();
  // var attendance_date = $('#attendance_date').val();

  $.ajax({
    url: "http://localhost/ci-3/truelysell-new/admin/language_new/sample_csv",
    type: 'POST',
    data: { csrf_token_name: $('#admin_csrf').val() },
    success: function (data) {
      var htmls = "";
      var uri = 'data:application/vnd.ms-excel;base64,';
      var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
      var base64 = function (s) {
        return window.btoa(unescape(encodeURIComponent(s)))
      };

      var format = function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
          return c[p];
        })
      };
      // var tab_text="<table border='2px'><tr bgcolor='#1eb53a'>";
      var textRange; var j = 0;
      var tab_text = data;

      tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
      tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
      tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, "");

      var ctx = {
        worksheet: name,
        table: tab_text
      }
      var link = document.createElement("a");
      link.download = name + ".xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
    }
  });
}
