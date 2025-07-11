(function ($) {
  "use strict";

  var base_url = $("#base_url").val();

  var BASE_URL = $("#base_url").val();
  var csrf_token = $("#csrf_token").val();
  var csrfName = $("#csrfName").val();
  var csrfHash = $("#csrfHash").val();
  var user_type = $("#user_type").val();
  var modules = $("#modules_page").val();
  var current_page = $("#current_page").val();
  var cookies_content = $("#cookies_showhide").val();
  var cookies_text = $("#cookies_content_text").val();

  $(document).ready(function () {
    var pageurl = $(location).attr("href"),
      parts = pageurl.split("/"),
      last_part = parts[parts.length - 1];

    $("#flash_succ_message2").hide();
    $("#flash_error_message1").hide();
    $("#otp_final_div").hide();
    $("#reason_div").hide();

    $(".error_rating").hide();
    $(".error_review").hide();
    $(".error_type").hide();

    $(".error_cancel").hide();
    $(".header-content-blk").hide();
    $("#contact_form")
      .bootstrapValidator({
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: "Please enter your name",
              },
            },
          },
          email: {
            validators: {
              notEmpty: {
                message: "Please enter your email",
              },
              emailAddress: {
                message: "The value is not a valid email address",
              },
            },
          },
          message: {
            validators: {
              notEmpty: {
                message: "Please enter your message",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        var name = $("#name").val();
        var email = $("#email").val();
        var message = $("#message").val();
        $.ajax({
          type: "POST",
          url: base_url + "user/contact/insert_contact",
          data: {
            name: name,
            email: email,
            csrf_token_name: csrf_token,
            message: message,
          },
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                title: "Message Send !",
                text: "Message Send Successfully....!",
                icon: "success",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false,
              }).then(function () {
                window.location.href = base_url + "contact";
              });
            } else {
              $("#flash_error_message1").show();
              $("#flash_error_message1").append("Wrong Credentials");
              return false;
            }
          },
        });
        return false;
      });

    $("#re_send_otp_user").on("click", function () {
      re_send_otp_user();
    });
    $(".isNumber").on("keypress", function () {
      var id = $(this).val();
      isNumber(id);
    });
    $(".chat_clear_all").on("click", function () {
      var id = $(this).attr("data-token");
      chat_clear_all(id);
    });
    $(".noty_clear").on("click", function () {
      var id = $(this).attr("data-token");
      noty_clear(id);
    });
    $("#rate_booking").on("click", function () {
      rate_booking();
    });
    $("#cancel_booking").on("click", function () {
      cancel_booking();
    });
    $("#provider_cancel_booking").on("click", function () {
      provider_cancel_booking();
    });

    //reschedule
    $("#user_reschedule_booking").on("click", function () {
      user_reschedule_booking();
    });

    //block by user
    $("#blockingProvider").on("click", function () {
      block_providers();
    });
    //block by provider
    $("#blockingUser").on("click", function () {
      block_users();
    });

    $("#go_user_settings").on("click", function () {
      window.location = base_url + "user-settings/";
    });
    $(".go_book_service").on("click", function () {
      var service_id = $(this).attr("data-id");
      window.location = base_url + "book-service/" + service_id;
    });
    $("#add_wallet_money").on("click", function () {
      var last_bookingpath = $(this).attr("data-url");
      add_wallet_money(last_bookingpath);
    });
    $(".reason_modal").on("click", function () {
      var id = $(this).attr("data-id");
      reason_modal(id);
    });
    $(".update_user_booking_status").on("click", function () {
      var id = $(this).attr("data-id");
      var status = $(this).attr("data-status");

      var rowid = $(this).attr("data-rowid");
      var review = $(this).attr("data-review");
      update_user_booking_status(id, status, rowid, review);
    });
    $(".update_pro_booking_status").on("click", function (e) {
      var id = $(this).attr("data-id");
      var status = $(this).attr("data-status");

      var rowid = $(this).attr("data-rowid");
      var review = $(this).attr("data-review");

      update_pro_booking_status(id, status, rowid, review);
    });
    $(".go_provider_availability").on("click", function () {
      window.location = base_url + "provider-availability";
    });
    $("#re_send_otp_provider").on("click", function () {
      re_send_otp_provider();
    });
    $(".get_pro_subscription").on("click", function () {
      get_pro_subscription();
    });
    $(".get_pro_appointment").on("click", function () {
      get_pro_appointment();
    });
    $(".get_admin_approval").on("click", function () {
      get_admin_approval();
    });
    $(".get_pro_availabilty").on("click", function () {
      get_pro_availabilty();
    });
    // $('.get_pro_availabilty').on('click', function () {
    //     get_pro_availabilty();
    // });
    $(".search_service").on("click", function () {
      $("#search_service").submit();
    });
    $(".check_user_reason").on("submit", function () {
      var result = check_user_reason();
      return result;
    });
    $(".user_update_status").on("click", function () {
      user_update_status(this);
    });
    $(".no_only").on("keyup", function (e) {
      $(this).val(
        $(this)
          .val()
          .replace(/[^\d].+/, "")
      );
      if (event.which < 48 || event.which > 57) {
        event.preventDefault();
      }
    });
    $(document).on("click", ".pagination_no", function () {
      var id = $(this).attr("data-id");
      getData(id);
    });

    $(".user_mobile").on("keyup keypress blur change", function (e) {
      //return false if not 0-9
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
      } else {
        //limit length but allow backspace so that you can still delete the numbers.
        if (
          $(this).val().length >= parseInt($(this).attr("maxlength")) &&
          e.which != 8 &&
          e.which != 0
        ) {
          return false;
        }
      }
    });

    //get amount while check additional service
    var totalAmount = 0;

    $(".addiservice").change(function () {
      var amount = parseFloat($(this).data("amountval"));
      var service_amount = $("#service_amount").val();
      var tot_service_amount = $("#service_amounts").val();
      var checked_total_tax = $("#changed_tot_tax").val();
      var currencySign = $("#currencySign").val();

      var service_with_additionals = $("#service_with_additional").val();
      var tax_settings_val = $("#tax_Settings_val").val();

      if (service_amount.indexOf("₹") !== -1) {
        var amountWithoutDollar = parseFloat(service_amount.replace("₹", ""));
        var totalAmountWithoutDollar = parseFloat(
          tot_service_amount.replace("₹", "")
        );
        var serviceWithAdditionals = parseFloat(
          service_with_additionals.replace("₹", "")
        );
      } else if (service_amount.indexOf("$") !== -1) {
        var amountWithoutDollar = parseFloat(service_amount.replace("$", ""));
        var totalAmountWithoutDollar = parseFloat(
          tot_service_amount.replace("$", "")
        );
        var serviceWithAdditionals = parseFloat(
          service_with_additionals.replace("$", "")
        );
      }

      if (isNaN(checked_total_tax)) {
        checked_total_tax = 0;
      }
      var checkedCount = $(".addiservice:checked").length;

      if (checkedCount == 1) {
        if (this.checked) {
          totalAmount = parseFloat(amountWithoutDollar) + parseFloat(amount);
        } else {
          totalAmount =
            parseFloat(totalAmountWithoutDollar) -
            parseFloat(amount) -
            checked_total_tax;
        }
      } else {
        if (this.checked) {
          totalAmount = parseFloat(serviceWithAdditionals) + parseFloat(amount);
        } else {
          totalAmount =
            parseFloat(totalAmountWithoutDollar) -
            parseFloat(amount) -
            checked_total_tax;
        }
      }

      var service_with_additional = $("#service_with_additional").val(
        totalAmount
      );
      if (tax_settings_val == 0) {
        var service_total_amount = totalAmount;
        var service_amount = $("#service_amounts").val(
          currencySign + service_total_amount
        );
      } else {
        var taxElements = document.getElementsByClassName("tax_amount");
        var taxAmount = 0;
        var service_total_amount = totalAmount;

        for (var i = 0; i < taxElements.length; i++) {
          var tax_id = taxElements[i].id.split("_")[2]; // Extract tax ID from the element ID
          var tax_percent = document.getElementById(
            "change_tax_percent_" + tax_id
          ).value; // Assuming you have an input for tax percent
          var tax_amount = (totalAmount * (tax_percent / 100)).toFixed(2);
          taxAmount += parseFloat(tax_amount);
          var service_total_amount = (totalAmount + taxAmount).toFixed(2);
          taxElements[i].value = currencySign + tax_amount;
        }

        var checkTotTax = taxAmount;

        var changed_tot_tax = $("#changed_tot_tax").val(checkTotTax);

        var service_amount = $("#service_amounts").val(
          currencySign + service_total_amount
        );
      }
    });

    $("#step1_footer").prop("disabled", true);

    if (
      last_part != "provider-dashboard" &&
      last_part.length != 0 &&
      last_part != "provider-settings" &&
      last_part != "payout-settings" &&
      last_part != "provider-wallet" &&
      last_part != "appointment-settings" &&
      last_part != "provider-availability" &&
      last_part != "provider-reviews" &&
      last_part != "provider-payment" &&
      last_part != "provider-change-password" &&
      last_part != "user-dashboard"
    ) {
      $.ajax({
        type: "GET",
        url: base_url + "user/service/get_category",
        data: { id: $(this).val(), csrf_token_name: csrf_token },
        beforeSend: function () {
          $("#categorys").find("option:eq(0)").html("Please wait..");
        },
        success: function (data) {
          $("#categorys").find("option:eq(0)").html("Select Category");

          var obj = jQuery.parseJSON(data);

          $(obj).each(function () {
            var option = $("<option />");
            option.attr("value", this.value).text(this.label);
            $("#categorys").append(option);
          });
        },
      });
    }
    $("#categorys").on("change", function () {
      if ($(this).val()) {
        $("#step1_footer").prop("disabled", false);
      } else {
        $("#step1_footer").prop("disabled", true);
      }

      $("#subcategorys").html('<option value="">Select subcategory</option>');
      if ($(this).val() != "") {
        $.ajax({
          type: "POST",
          url: base_url + "user/service/get_subcategory",
          data: { id: $(this).val(), csrf_token_name: csrf_token },
          beforeSend: function () {
            $("#subcategorys").find("option:eq(0)").html("Please wait..");
          },
          success: function (data) {
            $("#subcategorys").find("option:eq(0)").html("Select SubCategory");
            if (data) {
              var obj = jQuery.parseJSON(data);
              $(obj).each(function () {
                var option = $("<option />");
                option.attr("value", this.value).text(this.label);
                $("#subcategorys").append(option);
              });
            }
          },
        });
      }
    });
    $("#subcategorys").on("change", function () {
      if ($(this).val()) {
        $("#step3_footer").prop("disabled", false);
      } else {
        $("#step3_footer").prop("disabled", true);
      }
    });

    $("#categories").change(function () {
      $("#subcategories").val("default");
      $.ajax({
        type: "POST",
        url: base_url + "user/service/get_subcategory",
        data: { id: $(this).val(), csrf_token_name: csrf_token },
        beforeSend: function () {
          $("#subcategories option:gt(0)").remove();
          $("#subcategories").find("option:eq(0)").html("Please wait..");
        },
        success: function (data) {
          $("#subcategories").find("option:eq(0)").html("Select SubCategory");
          if (data) {
            var obj = jQuery.parseJSON(data);
            $(obj).each(function () {
              var option = $("<option />");
              option.attr("value", this.value).text(this.label);
              $("#subcategories").append(option);
            });
          }
        },
      });
    });

    $("#new_fourth_page")
      .bootstrapValidator({
        fields: {
          otp_number: {
            validators: {
              notEmpty: {
                message: "Please enter OTP",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        var otp = $("#otp_number").val();
        var userMobile = $("#userMobile").val();
        var password = $("#UserPassword").val();
        var categorys = $("#categorys").val();
        var subcategorys = $("#subcategorys").val();
        var userName = $("#userName").val();
        var userEmail = $("#userEmail").val();
        var country_code = $("#userMobile").intlTelInput(
          "getSelectedCountryData"
        ).dialCode;
        var is_agree = $("#agree_checkbox").val();
        $.ajax({
          type: "POST",
          url: base_url + "user/login/check_otp",
          data: {
            otp: otp,
            mobileno: userMobile,
            password: password,
            country_code: country_code,
            category: categorys,
            subcategory: subcategorys,
            name: userName,
            is_agree: is_agree,
            email: userEmail,
            csrf_token_name: csrf_token,
          },

          success: function (data) {
            var data = jQuery.parseJSON(data);
            if (data.response == "ok") {
              window.location.reload();
            } else if (data.response == "error") {
              $("#otp_error_msg").show();
              $("#otp_error_msg").text(data.msg);
              if (data.result == "otp_expired") {
                $("#registration_resend").show();
                $("#registration_final").addClass("invisible");

                $("#registration_resend").removeClass("invisible");
              }
            }
          },
        });
        return false;
      });

    $("#registration_resend").on("click", function () {
      sendEvent("#modal-wizard", 3);
      $("#otp_error_msg").text("");
      $("#registration_submit").prop("disabled", false);
      $("#otp_number").val("");
      $("#registration_resend").addClass("invisible");
      $("#registration_final").removeClass("invisible");
    });

    $("#new_third_pagelogin")
      .bootstrapValidator({
        fields: {
          userName: {
            validators: {
              notEmpty: {
                message: "Please enter your service title",
              },
            },
          },
          userEmail: {
            validators: {
              remote: {
                url: base_url + "user/login/email_chk",
                data: function (validator) {
                  return {
                    userEmail: validator.getFieldElements("userEmail").val(),
                    csrf_token_name: csrf_token,
                  };
                },
                message: "This email is already exist",
                type: "POST",
              },
              notEmpty: {
                message: "Please enter email address",
              },
            },
          },
          userMobile: {
            validators: {
              remote: {
                url: base_url + "user/login/mobileno_chk",
                data: function (validator) {
                  return {
                    userMobile: validator.getFieldElements("userMobile").val(),
                    countryCode: validator
                      .getFieldElements("countryCode")
                      .val(),
                    csrf_token_name: csrf_token,
                  };
                },
                message: "This mobile number is already exist",
                type: "POST",
              },
              notEmpty: {
                message: "Please enter mobile",
              },
              regexp: {
                regexp: /^\d{10}$/,
                message: "Please supply a valid phone number",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        var categorys = $("#categorys").val();
        var subcategorys = $("#subcategorys").val();
        var userName = $("#userName").val();
        var userEmail = $("#userEmail").val();
        var userMobile = $("#userMobile").val();
        var countryCode = $("#countryCode").val();

        $.ajax({
          type: "POST",
          url: base_url + "user/login/login",
          data: {
            category: categorys,
            subcategory: subcategorys,
            username: userName,
            email: userEmail,
            countryCode: countryCode,
            csrf_token_name: csrf_token,
            mobileno: userMobile,
          },
          success: function (data) {
            var obj = JSON.parse(data);

            if (obj.response == "ok") {
              sendEvent("#modal-wizard", 4);
            } else {
              $("#registration_submit").prop("disabled", false);
            }
          },
        });
        return false;
      });

    $("#new_third_page1")
      .bootstrapValidator({
        fields: {
          userName: {
            validators: {
              notEmpty: {
                message: "Please Enter your service title",
              },
            },
          },
          userEmail: {
            validators: {
              remote: {
                url: base_url + "user/login/email_chk",
                data: function (validator) {
                  return {
                    userEmail: validator.getFieldElements("userEmail").val(),
                    csrf_token_name: csrf_token,
                  };
                },
                message: "This email is already exist",
                type: "POST",
              },
              notEmpty: {
                message: "Please enter email address",
              },
            },
          },
          userMobile: {
            validators: {
              remote: {
                url: base_url + "user/login/mobileno_chk",
                data: function (validator) {
                  return {
                    userMobile: validator.getFieldElements("userMobile").val(),
                    csrf_token_name: csrf_token,
                    countryCode: validator
                      .getFieldElements("countryCode")
                      .val(),
                  };
                },
                message:
                  "This Mobile Number is already exist so Try Another Mobile No..!",
                type: "POST",
              },
              notEmpty: {
                message: "Please enter mobile No ...!",
              },
              regexp: {
                regexp: /^\d{10}$/,
                message: "Please supply a valid Phone Number",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        var userName = $("#userName").val();
        var userEmail = $("#userEmail").val();
        var userMobile = $("#userMobile").val();
        var countryCode = $("#userMobile").intlTelInput(
          "getSelectedCountryData"
        ).dialCode;

        $.ajax({
          type: "POST",
          url: base_url + "user/login/send_otp_request",
          data: {
            username: userName,
            email: userEmail,
            countryCode: countryCode,
            mobileno: userMobile,
            csrf_token_name: csrf_token,
          },
          success: function (data) {
            var obj = JSON.parse(data);
            if (obj.response == "ok") {
              sendEvent("#modal-wizard1", 2);
            } else {
              $("#registration_submit").prop("disabled", false);
            }
          },
        });
        return false;
      });

    //reschedule date
    $("#reschedule_booking_date").datepicker({
      dateFormat: "dd-mm-yy",
      minDate: new Date(),
      icons: {
        up: "fas fa-angle-up",
        down: "fas fa-angle-down",
        next: "fas fa-angle-right",
        previous: "fas fa-angle-left",
      },
      onSelect: function (dateText) {
        var date = dateText;
        var dataString = "date=" + date;

        var provider_id = $("#cancel_provider_id").val();
        var service_id = $("#cancel_service_id").val();

        $("#from_time").empty();
        $("#book_services").bootstrapValidator(
          "revalidateField",
          "booking_date"
        );

        if (date != "" && date != undefined) {
          $.ajax({
            url: base_url + "user/service/service_availability/",
            data: {
              date: date,
              provider_id: provider_id,
              service_id: service_id,
              csrf_token_name: csrf_token,
            },
            type: "POST",

            success: function (response) {
              $("#from_time").find("option:eq(0)").html("Select time slot");
              if (response != "") {
                var obj = jQuery.parseJSON(response);
                if (obj != "") {
                  $(obj).each(function () {
                    var option = $("<option />");
                    option
                      .attr("value", this.start_time + " - " + this.end_time)
                      .text(this.start_time + "-" + this.end_time);
                    $("#from_time").append(option);
                  });
                } else if (obj == "") {
                  Swal.fire({
                    title: "Availability Not Found !",
                    text: "Please check and select avilable date...!",
                    icon: "warning",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  });
                  var option = $("<option />");
                  option.attr("value", "").text("Availability not found.");
                  $("#from_time").append(option);
                }
              }
            },
          });
        }
      },
    });

    $("#booking_date").datepicker({
      dateFormat: "dd-mm-yy",
      minDate: new Date(),
      icons: {
        up: "fas fa-angle-up",
        down: "fas fa-angle-down",
        next: "fas fa-angle-right",
        previous: "fas fa-angle-left",
      },
      onSelect: function (dateText) {
        var date = dateText;
        var dataString = "date=" + date;
        var provider_id = $("#provider_id").val();
        var service_id = $("#service_id").val();

        $("#from_time").html("");

        $("#book_services").bootstrapValidator(
          "revalidateField",
          "booking_date"
        );

        if (date != "" && date != undefined) {
          $.ajax({
            url: base_url + "user/service/service_availability/",
            data: {
              date: date,
              provider_id: provider_id,
              service_id: service_id,
              csrf_token_name: csrf_token,
            },
            type: "POST",

            success: function (response) {
              $("#from_time").find("option:eq(0)").html("Select time slot");
              if (response != "") {
                var obj = jQuery.parseJSON(response);
                if (obj != "") {
                  $(obj).each(function () {
                    var option = $("<option />");
                    option
                      .attr("value", this.start_time + " - " + this.end_time)
                      .text(this.start_time + "-" + this.end_time);
                    $("#from_time").append(option);
                  });
                } else if (obj == "") {
                  Swal.fire({
                    title: "Availability Not Found !",
                    text: "Please check and select avilable date...!",
                    icon: "warning",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  });
                  var option = $("<option />");
                  option.attr("value", "").text("Availability not found.");
                  $("#from_time").append(option);
                }
              }
            },
          });
        }
      },
    });
    $(".close").on("click", function () {
      $(".user_mobile").val("");
      $(".countryCode").val("");
    });
    var url = $(location).attr("href"),
      parts = url.split("/"),
      last_part = parts[parts.length - 1];
    var moduleName = $("#modules_page").val();
    if (
      last_part == "user-wallet" ||
      last_part == "user-payment" ||
      last_part == "provider-wallet" ||
      last_part == "provider-payment"
    ) {
      $("#order-summary").DataTable();
      // Clear the search input field

      $("#order-summary_filter input").val("");
      // $('#order-summary').DataTable().search('').draw();
      $("#order-summary_filter input").attr("autocomplete", "off");
    }

    if ($(".days_check").is(":checked") == true) {
      $(".eachdays").removeAttr("style");
      $(".eachdayfromtime").removeAttr("style");
      $(".eachdaytotime").removeAttr("style");

      if ($(".daysfromtime_check").val() == "") {
        $(".daysfromtime_check").attr("style", "border-color:red");
        error = 1;
      } else {
        $(".daysfromtime_check").removeAttr("style");
      }
      if ($(".daystotime_check").val() == "") {
        error = 1;
        $(".daystotime_check").attr("style", "border-color:red");
      } else {
        $(".daystotime_check").removeAttr("style");
      }
    } else {
      var oneday = 0;
      $(".daysfromtime_check").removeAttr("style");
      $(".daystotime_check").removeAttr("style");

      $(".eachdays").each(function () {
        if ($(this).is(":checked") == true) {
          oneday = 1;
        }
      });
      if (oneday == 1) {
        $(".eachdays").removeAttr("style");
        $(".eachdayfromtime").removeAttr("style");
        $(".eachdaytotime").removeAttr("style");
      }

      $(".eachdays").each(function () {
        if ($(this).is(":checked") == true) {
          var val = $(this).val();
          val = parseInt(val);

          if ($(".eachdayfromtime" + val).val() == "") {
            error = 1;

            $(".eachdayfromtime" + val).attr("style", "border-color:red");
          } else {
            $(".eachdayfromtime" + val).removeAttr("style");
          }

          if ($(".eachdaytotime" + val).val() == "") {
            error = 1;
            $(".eachdaytotime" + val).attr("style", "border-color:red");
          } else {
            $(".eachdaytotime" + val).removeAttr("style");
          }
        }
      });
      if (oneday == 0) {
        $(".eachdays").attr("style", "opacity:unset;position:unset;");
        var error = 1;
      } else {
      }
    }

    $(document).on("click", ".days_check", function () {
      var from_time = "";
      var to_time = "";
      if ($(".daysfromtime_check").val()) {
        var from_time = $(".daysfromtime_check").val();
      }
      if ($(".daystotime_check").val()) {
        var to_time = $(".daystotime_check").val();
      }
      if ($(this).is(":checked") == true) {
        $(".daysfromtime_check").val(from_time);
        $(".daystotime_check").val(to_time);
        $(".eachdays").attr("disabled", "disabled");
        $(".eachdayfromtime").attr("disabled", "disabled");
        $(".eachdaytotime").attr("disabled", "disabled");
        $(".eachdayfromtime").val("");
        $(".eachdaytotime").val("");
        $(".eachdays").prop("checked", false);
        $(".eachdays").removeAttr("style");
        $(".eachdayfromtime").removeAttr("style");
        $(".eachdaytotime").removeAttr("style");
      } else {
        $(".eachdayfromtime").val("");
        $(".eachdaytotime").val("");
        $(".eachdays").attr("checked", false);

        $(".eachdays").removeAttr("disabled");
        $(".eachdayfromtime").removeAttr("disabled");
        $(".eachdaytotime").removeAttr("disabled");
        $(".daysfromtime_check").val("");
        $(".daystotime_check").val("");
        $(".daysfromtime_check").removeAttr("style");
        $(".daystotime_check").removeAttr("style");
      }
    });

    $("#loginsubmit").on("click", function () {
      $("#userSignIn").submit();
    });

    $("#userSignIn")
      .bootstrapValidator({
        fields: {
          user_mobile: {
            validators: {
              digits: {
                message: "Please enter valid Number",
              },
              notEmpty: {
                message: "Please enter your mobile number",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        var country_code = $("#direct_log_country_code").val();
        var mobile = $("#direct_log_mobile_no").val();
        $.ajax({
          type: "POST",
          url: base_url + "user/login/login",
          data: {
            mobile: mobile,
            country_code: country_code,
            csrf_token_name: csrf_token,
          },
          success: function (response) {
            if (response == 1) {
              window.location.reload();
            } else if (response == 2) {
              window.location.reload();
            } else {
              $("#flash_error_message1").show();
              $("#flash_error_message1").append("Wrong Credentials");

              return false;
            }
          },
        });
        return false;
      });
    //forgot password
    $("#new_password").on("input", function () {
      $("#update_user_pwd").bootstrapValidator(
        "revalidateField",
        "confirm_password"
      );
    });

    $("#update_user_pwd")
      .bootstrapValidator({
        fields: {
          current_password: {
            validators: {
              notEmpty: {
                message: "Please enter Current Password",
              },
              remote: {
                url: base_url + "user/dashboard/checkuserpassword",
                type: "POST",
                data: function (validator) {
                  return {
                    current_password: validator
                      .getFieldElements("current_password")
                      .val(),
                    csrf_token_name: csrf_token,
                  };
                },
                message: "Current Password is invalid",
              },
            },
          },
          new_password: {
            validators: {
              notEmpty: {
                message: "Please enter new Password",
              },
              regexp: {
                regexp:
                  /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[$@!%?&]).{8,30}$/,
                message:
                  "The password must be more than 8 and less than 30 characters long. The password should contain at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character",
              },
            },
          },
          confirm_password: {
            validators: {
              notEmpty: {
                message: "Please enter confirm Password",
              },
              identical: {
                field: "new_password",
                message: "The new password and its confirmation do not match",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        // return false;
      });

    $("#new_password").on("input", function () {
      $("#update_provider_pwd").bootstrapValidator(
        "revalidateField",
        "confirm_password"
      );
    });

    $("#update_provider_pwd")
      .bootstrapValidator({
        fields: {
          current_password: {
            validators: {
              notEmpty: {
                message: "Please Enter Current Password",
              },
              remote: {
                url: base_url + "user/dashboard/checkproviderpassword",
                type: "POST",
                data: function (validator) {
                  return {
                    current_password: validator
                      .getFieldElements("current_password")
                      .val(),
                    csrf_token_name: csrf_token,
                  };
                },
                message: "Current Password is invalid",
              },
            },
          },
          new_password: {
            validators: {
              notEmpty: {
                message: "Please Enter New Password",
              },
              regexp: {
                regexp:
                  /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[$@!%?&]).{8,30}$/,
                message:
                  "The password must be more than 8 and less than 30 characters long. The password should contain at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character",
              },
            },
          },
          confirm_password: {
            validators: {
              notEmpty: {
                message: "Please enter confirm Password",
              },
              identical: {
                field: "new_password",
                message: "New and Confirm password are mismatch",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        // return false;
      });

    $("#user_submit").on("click", function () {
      $("#reg_user").submit();
    });

    $("#reg_user")
      .bootstrapValidator({
        fields: {
          userName: {
            validators: {
              notEmpty: {
                message: "Please enter your Username",
              },
            },
          },
          userEmail: {
            validators: {
              notEmpty: {
                message: "Please enter your email",
              },
            },
          },
          userMobile: {
            validators: {
              notEmpty: {
                message: "Please enter your mobile number",
              },
            },
          },
          countryCode: {
            validators: {
              notEmpty: {
                message: "Please select your countryCode",
              },
            },
          },
        },
      })
      .on("success.form.bv", function (e) {
        var userName = $("#user_Name").val();
        var userEmail = $("#user_Email").val();
        var userMobile = $("#user_Mobile").val();
        var country_code = $("#countryCode").val();
        $.ajax({
          type: "POST",
          url: base_url + "user/login/insert_user",
          data: {
            username: userName,
            email: userEmail,
            mobile: userMobile,
            country_code: country_code,
            csrf_token_name: csrf_token,
          },
          success: function (response) {
            if (response == 1) {
              $("#flash_succ_message").show(1000);
              $("#flash_error_message").hide();
              $("#flash_succ_message").append("Registered Successfully");
            } else {
              $("#flash_succ_message").hide();
              $("#flash_error_message").show(1000);
              $("#flash_error_message").append(
                "Email id or mobileno already exists"
              );

              return false;
            }
          },
        });
        return false;
      });

    $(".rates").on("click", function () {
      $("#myInput").val($("input[name='rates']:checked").val());
    });
    $(".myReview").on("click", function () {
      $("#booking_id").val("");
      $("#provider_id").val("");
      $("#user_id").val("");
      $("#service_id").val("");
      var booking_id = $(this).attr("data-id");
      var provider_id = $(this).attr("data-providerid");
      var user_id = $(this).attr("data-userid");
      var service_id = $(this).attr("data-serviceid");

      $("#booking_id").val(function () {
        return this.value + booking_id;
      });
      $("#provider_id").val(function () {
        return this.value + provider_id;
      });
      $("#user_id").val(function () {
        return this.value + user_id;
      });
      $("#service_id").val(function () {
        return this.value + service_id;
      });
    });

    //reschedule
    // $('.reschedule').on('click', function () {
    //     function reschedulebooking(id, provider_id, service_id, user_id) {
    //         alert("comer")
    //     $('#cancel_review').val('');
    //     $('#booking_id').val('');
    //     $('#provider_id').val('');
    //     $('#user_id').val('');
    //     $('#service_id').val('');
    //     var booking_id = $(this).attr("data-id");
    //     var provider_id = $(this).attr("data-providerid");
    //     var user_id = $(this).attr("data-userid");
    //     var service_id = $(this).attr("data-serviceid");

    //     $("#cancel_booking_id").val(function () {
    //         return this.value + booking_id;
    //     });
    //     $("#cancel_provider_id").val(function () {
    //         return this.value + provider_id;
    //     });
    //     $("#cancel_user_id").val(function () {
    //         return this.value + user_id;
    //     });
    //     $("#cancel_service_id").val(function () {
    //         return this.value + service_id;
    //     });
    // }

    $(".myCancel").on("click", function () {
      $("#cancel_review").val("");
      $("#booking_id").val("");
      $("#provider_id").val("");
      $("#user_id").val("");
      $("#service_id").val("");
      $("#user_type").val("");

      var booking_id = $(this).attr("data-id");
      var provider_id = $(this).attr("data-providerid");
      var user_id = $(this).attr("data-userid");
      var service_id = $(this).attr("data-serviceid");
      var usertype = $(this).attr("data-usertype");

      $("#cancel_booking_id").val(function () {
        return this.value + booking_id;
      });
      $("#cancel_provider_id").val(function () {
        return this.value + provider_id;
      });
      $("#cancel_user_id").val(function () {
        return this.value + user_id;
      });
      $("#cancel_service_id").val(function () {
        return this.value + service_id;
      });

      $("#user_type").val(function () {
        return this.value + usertype;
      });
    });

    var timeout = 3000; // in miliseconds (3*1000)
    $("#flash_succ_message").delay(timeout).fadeOut(500);
    $("#flash_error_message").delay(timeout).fadeOut(500);

    var rating = "";
    var review = "";
    var booking_id = "";
    var provider_id = "";
    var user_id = "";
    var service_id = "";
    var type = "";

    if (modules == "home") {
      $(".common_search").autocomplete({
        source: "<?php echo site_url('home/get_common_search_value/?');?>",
      });
    }

    if (modules == "services" || modules == "service") {
      if (!$("#service_location").length) {
        // use this if you are using id to check
        $(".google_input").append(
          "<input type='hidden' id='service_location'>"
        );
      }
    }

    function date_handler(e) {
      var date = e.target.value;
      var dataString = "date=" + date;
      var provider_id = $("#provider_id").val();
      var service_id = $("#service_id").val();

      $.ajax({
        url: base_url + "user/service/service_availability/",
        data: {
          date: date,
          provider_id: provider_id,
          service_id: service_id,
          csrf_token_name: csrf_token,
        },
        type: "POST",

        success: function (response) {
          $("#from_time").find("option:eq(0)").html("Select time slot");
          var obj = jQuery.parseJSON(response);

          if (obj != "") {
            $(obj).each(function () {
              var option = $("<option />");
              option
                .attr("value", this.start_time + "-" + this.end_time)
                .text(this.start_time + "-" + this.end_time);
              $("#from_time").append(option);
            });
          } else if (obj == "") {
            var msg = "Availability not found";
            $("#from_time").append(msg);
          }

          $("#to_time").find("option:eq(0)").html("Select end time");
          var obj = jQuery.parseJSON(response);

          $(obj).each(function () {
            var option = $("<option />");
            option.attr("value", this.end_time).text(this.end_time);
            $("#to_time").append(option);
          });
        },
      });
    }

    function re_send_otp_user() {
      var mobile_no = $(".user_final_no").val();
      var country_code = $(".final_country_code").val();
      $.ajax({
        url: base_url + "user/login/re_send_otp_user",
        data: {
          mobile_no: mobile_no,
          country_code: country_code,
          csrf_token_name: csrf_token,
        },
        type: "POST",
        dataType: "JSON",
        success: function (response) {
          if (response == 2) {
            Swal.fire({
              title: "OTP Send !",
              text: "Some Things Went To Wrong....!",
              icon: "danger",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            });
            location.reload();
          } else {
            Swal.fire({
              title: "OTP Send !",
              text: "Your OTP Send to Registered Mobile No.....",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            });
          }
        },
      });
    }

    function plan_notification() {
      Swal.fire({
        title: " Plan warning..!",
        text: "Already subscribed to high range so choose higher plan!",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      });
    }

    function re_send_otp_provider() {
      var mobile_no = $(".provider_final_no").val();
      var country_code = $("#userMobile").intlTelInput(
        "getSelectedCountryData"
      ).dialCode;

      $.ajax({
        url: base_url + "user/login/re_send_otp_provider",
        data: {
          mobile_no: mobile_no,
          country_code: country_code,
          csrf_token_name: csrf_token,
        },
        type: "POST",
        dataType: "JSON",
        success: function (response) {
          if (response == 2) {
            Swal.fire({
              title: "OTP Send !",
              text: "Some Things Went To Wrong....!",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            });
            location.reload();
          } else {
            Swal.fire({
              title: "OTP Send !",
              text: "Your OTP Send to Registered Mobile No.....",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            });
          }
        },
      });
    }

    function withdraw_wallet_value(input) {
      $("#wallet_withdraw_amt").val(input);
    }

    function isNumber(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    }

    function add_wallet_money(last_bookingpath) {
      //store
      sessionStorage.setItem("bokRtrnUrl", last_bookingpath);
      // Retrieve
      Swal.fire({
        title: "Insufficient wallet amount !",
        text: "Please recharge your wallet after book this service....!",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      }).then(function () {
        window.location = base_url + "user-wallet";
      });
    }

    function user_update_status(e) {
      var user_status = $(e).val();
      if (user_status == 5) {
        $("#reason_div").show();
      } else {
        $("#reason_div").hide();
      }
    }

    function check_user_reason() {
      var sent = true;
      var status = $(".update_user_status").val();
      var reason = $("#reject_reason").val();
      if (status == 5) {
        if (reason == "") {
          Swal.fire({
            title: "Rejection reason.",
            text: "Please Enter Rejection Reason about this Service...",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false,
          }).then(function () {
            $("#reject_reason").focus();
          });

          sent = false;
        }
      }
      return sent;
    }

    //LOGIN
    function get_pro_subscription() {
      Swal.fire({
        title: "Please Subscribe to a Plan !",
        text: "Choose your plan to subscribe.....",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      }).then(function () {
        window.location.href = base_url + "provider-subscription";
      });
    }

    //Appointment Settings
    function get_pro_appointment() {
      Swal.fire({
        title: "Appointment Settings",
        text: "Please Update Appointment Settings!",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      }).then(function () {
        window.location.href = base_url + "appointment-settings";
      });
    }

    function get_admin_approval() {
      Swal.fire({
        title: "Please Wait For Admin Approval !",
        text: "Waiting For Admin Approval.....",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      }).then(function () {
        window.location.href = base_url + "provider-subscription";
      });
    }

    function get_pro_availabilty() {
      Swal.fire({
        title: "Please Select Availability !",
        text: "Choose your Service Available day.....",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      }).then(function () {
        window.location.href = base_url + "provider-availability";
      });
    }

    function get_pro_account() {
      Swal.fire({
        title: "Please Fill Account info !",
        text: "Please Fill Your Account Information for Feature Upgradation.....",
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false,
      }).then(function () {
        window.location.href = base_url + "provider-availability";
      });
    }

    function reason_modal(key) {
      $("#cancelModal").modal("show");
      var reason = $("#reason_" + key).val();
      $(".cancel_reason").text(reason);
    }

    //new
    function rate_booking(e) {
      rating = $("#myInput").val();
      review = $("#review").val();
      booking_id = $("#booking_id").val();
      provider_id = $("#provider_id").val();
      user_id = $("#user_id").val();
      service_id = $("#service_id").val();
      type = $("#type").val();

      if (rating == "") {
        $(".error_rating").show();
        return false;
      } else if (review == "") {
        $(".error_rating").hide();
        $(".error_review").show();
        return false;
      } else if (type == "") {
        $(".error_rating").hide();
        $(".error_review").hide();
        $(".error_type").show();
        return false;
      }

      $.ajax({
        url: base_url + "user/dashboard/rate_review_post/",
        data: {
          rating: rating,
          review: review,
          booking_id: booking_id,
          provider_id: provider_id,
          user_id: user_id,
          service_id: service_id,
          type: type,
          csrf_token_name: csrf_token,
        },
        type: "POST",
        dataType: "JSON",
        success: function (response) {
          Swal.fire({
            title: "Rating Updated..!",
            text: "Rating Updated SuccessFully..",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false,
          }).then(function () {
            window.location.href = base_url + "user-bookings";
          });
        },
        error: function (error) {
          Swal.fire({
            title: "Rating Not Updated..!",
            text: "Rating Not Update..",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false,
          }).then(function () {
            window.location.href = base_url + "user-bookings";
          });
        },
      });
    }

    function cancel_booking(e) {
      review = $("#cancel_review").val();
      booking_id = $("#cancel_booking_id").val();
      provider_id = $("#cancel_provider_id").val();
      user_id = $("#cancel_user_id").val();
      service_id = $("#cancel_service_id").val();
      if (review == "") {
        $(".error_cancel").show();
        return false;
      }
      update_user_booking_status(booking_id, 5, 0, review);
    }
    function isEmptyOrSpaces(str) {
      return str === null || str.match(/^ *$/) !== null;
    }

    function provider_cancel_booking(e) {
      review = $("#cancel_review").val();
      booking_id = $("#cancel_booking_id").val();
      provider_id = $("#cancel_provider_id").val();
      user_id = $("#cancel_user_id").val();
      service_id = $("#cancel_service_id").val();
      if (review == "" || isEmptyOrSpaces(review)) {
        $(".error_cancel").show();
        return false;
      }
      var user_type = $("#user_type").val();

      if (user_type == 2) {
        update_pro_cancel_booking_status(booking_id, 5, 0, review);
      } else {
        update_user_cancel_booking_status(booking_id, 7, 0, review);
      }
    }

    //appointment check by provider
    var appointmentCheck = $("#appointment-check").val();

    if (parseInt(appointmentCheck) < 1) {
      $(".chide").show().css({
        "background-color": "#ff0080",
        color: "white",
        width: "auto",
        height: "25px",
        "text-align": "center",
      });
    } else {
      $(".chide").hide();
    }

    //user reschedule booking
    function user_reschedule_booking(e) {
      var booking_date = $("#reschedule_booking_date").val();
      var booking_time = $("#from_time").val();

      booking_id = $("#cancel_booking_id").val();
      provider_id = $("#cancel_provider_id").val();
      user_id = $("#cancel_user_id").val();
      service_id = $("#cancel_service_id").val();

      var user_type = $("#user_type").val();
      bookingReschedule(
        booking_id,
        service_id,
        provider_id,
        booking_date,
        booking_time,
        user_id
      );
    }

    //booking rechedule add
    function bookingReschedule(
      booking_id,
      service_id,
      provider_id,
      booking_date,
      booking_time,
      user_id
    ) {
      $.confirm({
        title: "Confirmations..!",
        content: "Do you want continue on this process..",
        buttons: {
          confirm: function () {
            $.ajax({
              url: base_url + "bookingReschedule",
              data: {
                booking_id: booking_id,
                service_id: service_id,
                provider_id: provider_id,
                booking_date: booking_date,
                booking_time: booking_time,
                user_id: user_id,
                csrf_token_name: csrf_token,
              },
              type: "POST",
              dataType: "JSON",
              beforeSend: function () {
                reschedule_button_loading();
                $(".btn").removeAttr("onclick");
                $(".btn").removeAttr("data-target");
                $(".btn").removeAttr("href");
              },
              success: function (response) {
                $("#reschedule").modal("hide");

                if (response.status == "5") {
                  // session expiry
                  Swal.fire({
                    title: "Session was Expired... !",
                    text: "Session Was Expired ..",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
                if (response.status == "4") {
                  //not updated
                  Swal.fire({
                    title: "Something wrong !",
                    text: "Wallet Balance is Insufficient. Please Topup to book the service",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
                if (response.status == "3") {
                  //not updated
                  Swal.fire({
                    title: "Booking !",
                    text: "Booking Not Available",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
                if (response.status == "6") {
                  //not updated
                  Swal.fire({
                    title: "Something wrong !",
                    text: "Booking already exists on this time",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
                if (response.status == "2") {
                  //not updated
                  Swal.fire({
                    title: "Somethings wrong !",
                    text: "Somethings wents to wrongs",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
                if (response.status == "7") {
                  //not updated

                  Swal.fire({
                    title: "Failure!",
                    text: "Sorry! Reschedule for the appointment is not permitted",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: true,
                  }).then(function () {
                    window.location.reload();
                  });
                }
                if (response.status == "1") {
                  Swal.fire({
                    title: "Booking Reschedule !",
                    text: "Service is rescheduled successfully...",
                    icon: "success",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
              },
            });
          },
          cancel: function () {},
        },
      });
    }

    /*provider accept and reject scenarios*/

    function update_pro_booking_status(bookid, status, rowid, category) {
      $.confirm({
        title: "Confirmations..!",
        content: "Do you want continue on this process..",
        buttons: {
          confirm: function () {
            $.ajax({
              url: base_url + "update_bookingstatus",
              data: {
                booking_id: bookid,
                status: status,
                csrf_token_name: csrf_token,
              },
              type: "POST",
              dataType: "JSON",
              beforeSend: function () {
                $(".btn").removeAttr("onclick");
                $(".btn").removeAttr("data-target");
                $(".btn").removeAttr("href");
              },
              success: function (response) {
                if (response == "3") {
                  // session expiry
                  Swal.fire({
                    title: "Session was Expired... !",
                    text: "Session Was Expired ..",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }

                if (response == "2") {
                  //not updated
                  Swal.fire({
                    title: "Somethings wrong !",
                    text: "Somethings wents to wrongs",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }

                if (response == "1") {
                  Swal.fire({
                    title: "The booking status !",
                    text: "Service is Updated successfully...",
                    icon: "success",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    if (category == 1) {
                      $("#update_pending_div" + rowid).hide();
                    }
                    if (category == 2) {
                      $("#update_inprogress_div" + rowid).hide();
                    }
                    window.location.reload();
                  });
                }
                if (response == "6") {
                  Swal.fire({
                    title: "The booking status !",
                    text: "COD Payment Paid Successfully...",
                    icon: "success",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    if (category == 1) {
                      $("#update_pending_div" + rowid).hide();
                    }
                    if (category == 2) {
                      $("#update_inprogress_div" + rowid).hide();
                    }
                    window.location.reload();
                  });
                }
                if (response == "4") {
                  Swal.fire({
                    title: "Booking",
                    text: "'Send complete request to user' will be enabled on the booking date",
                    icon: "Failure",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }
              },
            });
          },
          cancel: function () {},
        },
      });
    }

    /*provider accept and reject scenarios*/

    function update_pro_cancel_booking_status(bookid, status, rowid, review) {
      $("#myCancel").modal("hide");

      $.ajax({
        url: base_url + "update_bookingstatus",
        data: {
          booking_id: bookid,
          status: status,
          review: review,
          csrf_token_name: csrf_token,
        },
        type: "POST",
        dataType: "JSON",
        beforeSend: function () {
          $(".myCancel").removeAttr("onclick");
          $(".myCancel").removeAttr("data-target");
          $(".myCancel").removeAttr("href");
        },
        success: function (response) {
          if (response == "3") {
            // session expiry
            Swal.fire({
              title: "Session was Expired... !",
              text: "Session Was Expired ..",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              window.location.reload();
            });
          }

          if (response == "2") {
            //not updated
            Swal.fire({
              title: "Somethings wrong !",
              text: "Somethings wents to wrongs",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              window.location.reload();
            });
          }

          if (response == "1") {
            //not updated
            Swal.fire({
              title: "The booking status !",
              text: "Service is Updated successfully...",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              window.location.reload();
            });
          }
          window.location.reload();
        },
      });
    }

    /*user update the status*/

    function update_user_booking_status(bookid, status, rowid, review) {
      if (status == 5 || status == 7) {
        $("#myCancel").modal("hide");
      }
      $.confirm({
        title: "Confirmations..!",
        content: "Do you want continue on this proccess..",
        buttons: {
          confirm: function () {
            $.ajax({
              url: base_url + "update_status_user",
              data: {
                booking_id: bookid,
                status: status,
                review: review,
                csrf_token_name: csrf_token,
              },
              type: "POST",
              dataType: "JSON",
              success: function (response) {
                if (response == "3") {
                  // session expiry
                  Swal.fire({
                    title: "Session was Expired... !",
                    text: "Session Was Expired ..",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }

                if (response == "2") {
                  //not updated
                  Swal.fire({
                    title: "Somethings wrong !",
                    text: "Somethings wents to wrongs",
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    window.location.reload();
                  });
                }

                if (response == "1") {
                  //not updated
                  Swal.fire({
                    title: "The booking status !",
                    text: "Service is Updated successfully...",
                    icon: "success",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                  }).then(function () {
                    $("#update_div" + rowid).hide();
                    window.location.reload();
                  });
                }
              },
            });
          },
          cancel: function () {},
        },
      });
    }

    function update_user_cancel_booking_status(bookid, status, rowid, review) {
      $(".myCancel").modal("hide");

      $.ajax({
        url: base_url + "update_status_user",
        data: {
          booking_id: bookid,
          status: status,
          review: review,
          csrf_token_name: csrf_token,
        },
        type: "POST",
        dataType: "JSON",
        beforeSend: function () {
          // cancel_button_loading(bookid);
          cancelservice_button_loading();
          $(".btn").removeAttr("onclick");
          $(".btn").removeAttr("data-target");
          $(".btn").removeAttr("href");
        },
        success: function (response) {
          button_unloading();

          if (response == "3") {
            // session expiry
            Swal.fire({
              title: "Session was Expired... !",
              text: "Session Was Expired ..",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              window.location.reload();
            });
          }

          if (response == "2") {
            //not updated
            Swal.fire({
              title: "Somethings wrong !",
              text: "Somethings wents to wrongs",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              window.location.reload();
            });
          }

          if (response == "1") {
            //not updated
            Swal.fire({
              title: "The booking status !",
              text: "Service is Updated successfully...",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              $("#update_div" + rowid).hide();
              window.location.reload();
            });
          }
          if (response == "6") {
            //not updated

            Swal.fire({
              title: "The booking status !",
              text: "COD Payment Paid successfully...",
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              $("#update_div" + rowid).hide();
              window.location.reload();
            });
          }
          if (response == "4") {
            //not updated
            Swal.fire({
              title: "Cancel!",
              text: "Sorry! Cancellation for the appointment is not permitted",
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              $("#update_div" + rowid).hide();
              window.location.reload();
            });
          }
        },
      });
    }

    function noty_clear(id) {
      if (id != "") {
        $.ajax({
          type: "post",
          url: base_url + "home/clear_all_noty",
          data: { csrf_token_name: csrf_token, id: id },
          dataType: "json",
          success: function (data) {
            if (data.success) {
              $(".notification-list li").remove();
              $(".bg-yellow").text(0);
            }
          },
        });
      }
    }

    function chat_clear_all(id) {
      if (id != "") {
        $.ajax({
          type: "post",
          url: base_url + "home/clear_all_chat",
          data: { csrf_token_name: csrf_token, id: id },
          dataType: "json",
          success: function (data) {
            if (data.success) {
              $(".chat-list li").remove();
              $(".chat-bg-yellow").text(0);
            }
          },
        });
      }
    }

    var locationType = $("#location_type").val();
    if (locationType == "live") {
      //location lat long
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else {
        }
      }

      function showPosition(position) {
        locations(position.coords.latitude, position.coords.longitude);
      }
      getLocation();

      function locations(lat, lng) {
        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({ location: latlng }, function (results, status) {
          if (status === "OK") {
            if (results[3]) {
              var location = results[3].formatted_address;

              $.ajax({
                type: "post",
                url: base_url + "home/current_location",
                data: { csrf_token_name: csrfHash, location: location },
                dataType: "json",
                success: function (data) {
                  if (data == 2) {
                    if (results[5]) {
                      var location = results[5].formatted_address;
                      $.ajax({
                        type: "post",
                        url: base_url + "home/current_location",
                        data: { csrf_token_name: csrfHash, location: location },
                        dataType: "json",
                        success: function (data) {},
                      });
                    }
                  }
                },
              });
            } else {
              if (results[5]) {
                var location = results[5].formatted_address;
                $.ajax({
                  type: "post",
                  url: base_url + "home/current_location",
                  data: { csrf_token_name: csrfHash, location: location },
                  dataType: "json",
                  success: function (data) {},
                });
              }
            }
          }
        });
      }
    }
    var modules = $("#modules_page").val();
    if (locationType == "live") {
      if (modules == "services" || modules == "service") {
        var placeSearch, autocomplete;

        function initialize() {
          // Create the autocomplete object, restricting the search
          // to geographical location types.
          autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */
            (document.getElementById("service_location")),
            {
              types: ["geocode"],
            }
          );

          google.maps.event.addDomListener(
            document.getElementById("service_location"),
            "focus",
            geolocate
          );
          autocomplete.addListener("place_changed", get_latitude_longitude);
        }

        function get_latitude_longitude() {
          // Get the place details from the autocomplete object.
          var place = autocomplete.getPlace();
          var key = $("#map_key").val();
          $.get(
            "https://maps.googleapis.com/maps/api/geocode/json",
            { address: place.formatted_address, key: key },
            function (data, status) {
              $(data.results).each(function (key, value) {
                $("#service_address").val(place.formatted_address);
                $("#service_latitude").val(value.geometry.location.lat);
                $("#service_longitude").val(value.geometry.location.lng);
              });
            }
          );
        }

        function geolocate() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
              var geolocation = new google.maps.LatLng(
                position.coords.latitude,
                position.coords.longitude
              );
              var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy,
              });
              autocomplete.setBounds(circle.getBounds());
            });
          }
        }
        initialize();
      }
    }

    if (modules == "home") {
      function search_service() {
        $("#search_service").submit();
      }
    }

    function toaster_msg(status, msg) {
      setTimeout(function () {
        Command: toastr[status](msg);

        toastr.options = {
          closeButton: false,
          debug: false,
          newestOnTop: false,
          progressBar: false,
          positionClass: "toast-top-right",
          preventDuplicates: false,
          onclick: null,
          showDuration: "3000",
          hideDuration: "5000",
          timeOut: "6000",
          extendedTimeOut: "1000",
          showEasing: "swing",
          hideEasing: "linear",
          showMethod: "fadeIn",
          hideMethod: "fadeOut",
        };
      }, 300);
    }

    function button_loading() {
      var $this = $(".btn");
      var loadingText =
        '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
      if ($this.html() !== loadingText) {
        $this.data("original-text", $this.html());
        $this.html(loadingText).prop("disabled", "true").bind("click", false);
      }
    }

    function reschedule_button_loading() {
      var $this = $(".reschedule_btn");
      var loadingText =
        '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
      if ($this.html() !== loadingText) {
        $this.data("original-text", $this.html());
        $this.html(loadingText).prop("disabled", "true").bind("click", false);
      }
    }

    function cancelservice_button_loading() {
      var $this = $(".can_btn");
      var loadingText =
        '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
      if ($this.html() !== loadingText) {
        $this.data("original-text", $this.html());
        $this.html(loadingText).prop("disabled", "true").bind("click", false);
      }
    }

    function cancel_button_loading(bookid) {
      var $this = $(".myCancel_" + bookid);

      var loadingText =
        '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
      if ($this.html() !== loadingText) {
        $this.data("original-text", $this.html());
        $this.html(loadingText).prop("disabled", "true").bind("click", false);
      }
    }

    function button_unloading() {
      var $this = $(".btn");
      $this.html($this.data("original-text")).prop("disabled", "false");
    }

    function getData(page) {
      var status = $("#status").val();
      var pagination_page = $("#pagination_current_page").val();
      var target = $("#target").val();
      var csrf_token = $("#csrf_token").val();
      if (modules == "chat" && current_page == "notification-list") {
        target = "#dataListnotify";
      }
      $.ajax({
        method: "POST",
        url: pagination_page + page,
        data: { page: page, csrf_token_name: csrf_token, status: status },

        success: function (data) {
          $(target).html(data);
          $(".pagination ul li").removeClass("active");
          $(".page_nos_" + page)
            .parent("li")
            .addClass("active");
        },
      });
    }

    function getService(page) {
      var pagination_page = $("#pagination_current_page").val();
      var target = $("#target").val();
      var price_range = $("#price_range").val();
      var sort_by = $("#sort_by").val();
      var common_search = $("#common_search").val();
      var categories = $("#categories").val();
      var service_latitude = $("#service_latitude").val();
      var service_longitude = $("#service_longitude").val();

      $.ajax({
        method: "POST",
        url: pagination_page + page,
        data: {
          page: page,
          price_range: price_range,
          sort_by: sort_by,
          common_search: common_search,
          categories: categories,
          service_latitude: service_latitude,
          service_longitude: service_longitude,
          csrf_token_name: csrf_token,
        },

        success: function (data) {
          var obj = jQuery.parseJSON(data);
          $("#service_count").html(obj.count);
          $(target).html(obj.service_details);
        },
      });
    }
  });

  //Favorites for users
  $("#ufav").on("click", function () {
    var rowId = $(this).attr("data-id");
    var userId = $(this).attr("data-userid");
    var favStatus = $(this).attr("data-favstatus");
    var providerId = $(this).attr("data-provid");
    var serviceId = $(this).attr("data-servid");
    var pageName = $(this).attr("data-pagename");

    if (favStatus && userId) {
      var url = base_url + "home/user_favorite_data";
      var data = {
        id: rowId,
        userid: userId,
        status: favStatus,
        provider: providerId,
        service: serviceId,
        csrf_token_name: csrf_token,
      };
      $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        success: function (response) {
          if (response.status) {
            Swal.fire({
              title: "Success",
              text: response.msg,
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.msg,
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              location.reload();
            });
          }
        },
      });
    } else {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "You should login first",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });

  //Blocked providers by users
  $(".blockingUserDDD").on("click", function () {
    var rowId = $("#block_row_id").val();
    var blockedById = $(this).attr("data-blockedbyid");
    var blockedStatus = $(this).attr("data-blockedstatus");
    var blockedId = $(this).attr("data-blockedid");
    var usertType = $(this).attr("data-usertype");

    if (blockedStatus && blockedById) {
      var url = base_url + "home/block_unblock_data";
      var data = {
        id: rowId,
        blockedById: blockedById,
        blockedStatus: blockedStatus,
        blockedId: blockedId,
        usertType: usertType,
        csrf_token_name: csrf_token,
      };
      $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        success: function (response) {
          if (response.status) {
            Swal.fire({
              title: "Success",
              text: response.msg,
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.msg,
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              location.reload();
            });
          }
        },
      });
    } else {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "You should login first",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });

  $(".myBlockReasonModal").on("click", function () {
    $("#myBlockReasonModal").modal("show");
    var row_id = $(this).attr("data-id");
    var user_id = $(this).attr("data-blockedbyid");
    var provider_id = $(this).attr("data-blockedid");
    var status = $(this).attr("data-blockedstatus");
    var usertype = $(this).attr("data-usertype");

    $("#block_row_id").val(function () {
      return this.value + row_id;
    });
    $("#block_blockedby_id").val(function () {
      return this.value + user_id;
    });
    $("#block_blocked_id").val(function () {
      return this.value + provider_id;
    });
    $("#block_blockedstatus").val(function () {
      return this.value + status;
    });
    $("#block_usertype").val(function () {
      return this.value + usertype;
    });
  });

  function block_providers(e) {
    var review = $("#block_review").val();
    var row_id = $("#block_row_id").val();
    var blocked_id = $("#block_blocked_id").val();
    var blockedby_id = $("#block_blockedby_id").val();
    var blockedstatus = $("#block_blockedstatus").val();
    var usertype = $("#block_usertype").val();
    if (review == "") {
      $(".error_cancel").show();
      return false;
    }
    blocked_providers_byUser(
      review,
      row_id,
      blocked_id,
      blockedby_id,
      blockedstatus,
      usertype
    );
  }

  function block_users(e) {
    var review = $("#block_review").val();
    var row_id = $("#block_row_id").val();
    var blocked_id = $("#block_blocked_id").val();
    var blockedby_id = $("#block_blockedby_id").val();
    var blockedstatus = $("#block_blockedstatus").val();
    var usertype = $("#block_usertype").val();
    if (review == "") {
      $(".error_cancel").show();
      return false;
    }
    blocked_providers_byUser(
      review,
      row_id,
      blocked_id,
      blockedby_id,
      blockedstatus,
      usertype
    );
  }

  //Blocked providers by users
  function blocked_providers_byUser(
    review,
    rowId,
    blockedId,
    blockedById,
    blockedStatus,
    userType
  ) {
    if (blockedStatus && blockedById) {
      $("#myBlockReasonModal").modal("hide");

      var url = base_url + "home/block_unblock_data";
      var data = {
        id: rowId,
        blockedById: blockedById,
        blockedStatus: blockedStatus,
        blockedId: blockedId,
        usertType: userType,
        reason: review,
        csrf_token_name: csrf_token,
      };
      $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        success: function (response) {
          if (response.status) {
            Swal.fire({
              title: "Success",
              text: response.msg,
              icon: "success",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.msg,
              icon: "error",
              button: "okay",
              closeOnEsc: false,
              closeOnClickOutside: false,
            }).then(function () {
              location.reload();
            });
          }
        },
      });
    } else {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "You should login first",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  }

  //service auto-complete

  $(document).ready(function () {
    $("#search-blk").keyup(function () {
      var service_name = $(this).val();

      if (service_name != "") {
        $.ajax({
          url: base_url + "home/ajaxSearch",
          type: "post",
          data: {
            service_title: service_name,
            csrf_token_name: csrf_token,
          },
          dataType: "json",
          success: function (response) {
            var len = JSON.parse(response.length);
            $("#searchResult").empty();
            for (var i = 0; i < len; i++) {
              var id = response[i]["id"];
              var name = response[i]["service_title"];

              $("#searchResult").append(
                "<li value='" + id + "'>" + name + "</li>"
              );
            }

            // binding click event to li
            $("#searchResult li").bind("click", function () {
              setText(this);
            });
          },
        });
      }
    });
  });

  // Set Text to search box and get details
  function setText(element) {
    var value = $(element).text();
    var userid = $(element).val();
    console.log(value);
    $("#search-blk").val(value);
    $("#searchResult").empty();
  }
  $(document).on("click", "#change_language", function () {
    var lang = $(this).attr("lang");
    var lang_tag = $(this).attr("lang_tag");
    change_language(lang, lang_tag);
  });

  function change_language(lang, lang_tag) {
    var lg = lang;
    var tag = lang_tag;

    var csrf_token = $("#csrf_lang").val();

    $.post(
      base_url + "admin/language/change_language",
      {
        lg: lg,
        tag: tag,
        csrf_token_name: csrf_token,
      },
      function (res) {
        location.reload();
      }
    );
  }

  $(document).on("change", "#user_currency", function () {
    var currency = $(this).val();
    user_currency(currency);
  });

  function user_currency(code) {
    if (code != "") {
      var csrf_token = $("#csrf_lang").val();
      $.ajax({
        type: "POST",
        url: base_url + "ajax/add_user_currency",
        data: { code: code, csrf_token_name: csrf_token },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            location.reload();
          }
        },
      });
    }
  }

  function getSubcategory() {
    var category_id = $("#categories").val();
    var csrf_token = $("#csrf_lang").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>user/service/get_subcategory",
      data: { id: category_id, csrf_token_name: csrf_token },
      beforeSend: function () {
        $("#subcategories option:gt(0)").remove();
        $("#subcategories").find("option:eq(0)").html("Please wait..");
      },
      success: function (data) {
        $("#subcategories").find("option:eq(0)").html("Select SubCategory");
        if (data) {
          var obj = jQuery.parseJSON(data);
          $(obj).each(function () {
            var option = $("<option />");
            option.attr("value", this.value).text(this.label);
            $("#subcategories").append(option);
          });
        }
      },
    });
  }

  $(".delete_img").on("click", function () {
    var img_id = $(this).attr("data-img_id");
    var service_id = $("#service_id").val();

    delete_img(img_id, service_id);
  });

  function delete_img(img_id, service_id) {
    var csrf_token = $("#csrf_token").val();

    $.ajax({
      type: "POST",
      url: base_url + "user/service/delete_service_img",
      data: {
        img_id: img_id,
        service_id: service_id,
        csrf_token_name: csrf_token,
      },
      success: function (data) {
        if (data == 0) {
          Swal.fire({
            title: "Edit Service",
            text: "Each Service Should have Atleast One Image",
            icon: "error",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false,
          }).then(function () {});
        } else {
          $("#service_img_" + img_id).remove();
        }
      },
    });
  }

  $(".delete_account").on("click", function () {
    var id = $(this).attr("data-id");
    var type = $(this).attr("data-type");
    if (type == "provider") {
      $("#deleteProviderAccount").modal("toggle");
    } else {
      $("#deleteUserAccount").modal("toggle");
    }

    $(document).on("click", ".delete_confirm", function () {
      var dataString =
        "id=" + id + "&csrf_token_name=" + csrf_token + "&type=" + type;
      var url = base_url + "user/dashboard/delete_account";
      $.ajax({
        url: url,
        data: { id: id, csrf_token_name: csrf_token, type: type },
        type: "POST",
        beforeSend: function () {
          if (type == "provider") {
            $("#deleteProviderAccount").modal("toggle");
          } else {
            $("#deleteUserAccount").modal("toggle");
          }
        },
        success: function (res) {
          if (res == 1) {
            window.location.reload();
          } else if (res == 2) {
            window.location.reload();
          }
        },
      });
    });
    $(document).on("click", ".delete_cancel", function () {});
  });

  $(document).ready(function () {
    var country_key = $("#country_code_key").val();
    var input = document.querySelector("#login_mobile");
    if (input) { 
    var iti = window.intlTelInput(input, {
      initialCountry: country_key,
      separateDialCode: true,
    });

    $("#login_mobile").on("input", function () {
      var dialCode = iti.getSelectedCountryData().dialCode;
      $("#login_countrycode").val(dialCode);
    });
  }

    var input1 = document.querySelector("#user_mobile");
    var iti = window.intlTelInput(input1, {
      initialCountry: country_key,
      separateDialCode: true,
    });
    $("#user_mobile").on("input", function () {
      var dialCode = iti.getSelectedCountryData().dialCode;
      $("#login_user_mobile_code").val(dialCode);
    });

    var input2 = document.querySelector("#userMobile");
    var iti = window.intlTelInput(input2, {
      initialCountry: country_key,
      separateDialCode: true,
    });
    $("#userMobile").on("input", function () {
      var dialCode = iti.getSelectedCountryData().dialCode;
      $("#login_userMobile_code").val(dialCode);
    });
  });

  if (cookies_content == 1) {
    $(document).herbyCookie({
      btnText: "Accept",
      policyText: "Cookie policy",
      text: cookies_text,
      scroll: false,
      expireDays: 30,
      link: base_url + "cookie-policy",
    });
  }

  $(document).on("click", ".delete_comments", function () {
    var id = $(this).attr("data-id");
    delete_comments(id);
  });

  function delete_comments(id) {
    if (confirm("Are you sure you want to delete this Comment...!?")) {
      $.post(
        base_url + "delete-comments",
        { comments_id: id, csrf_token_name: csrf_token },
        function (result) {
          if (result) {
            window.location.reload();
          }
        }
      );
    }
  }

  $(document).on("click", "#refund", function () {
    var id = $(this).attr("data-id");
    refund_modal_show(id);
  });
  $("#ref_modal").on("hidden.bs.modal", function (e) {
    $("#reason").val("");
  });
  function refund_modal_show(id) {
    $("#ref_modal").modal("show");
    $("#confirm_refund_ser").attr("data-id", id);
    $(".ref_reason_error").hide();
  }
  $("#confirm_refund_ser").on("click", function () {
    var id = $(this).attr("data-id");
    var reason = $("#reason").val();
    if (reason != "") {
      $(".ref_reason_error").hide();
    } else if (reason == "") {
      $(".ref_reason_error").show();
      return false;
    }
    confirm_refund(id, reason);
  });
  function confirm_refund(id, reason) {
    if (id != "") {
      $("#ref_modal").modal("hide");
      $.ajax({
        type: "POST",
        url: base_url + "user/booking/refund_request",
        data: { id: id, reason: reason, csrf_token_name: csrf_token },
        dataType: "json",
        success: function (response) {
          Swal.fire({
            title: "Success..!",
            text: "Requested SuccessFully",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false,
          }).then(function () {
            location.reload();
          });
        },
      });
    }
  }

  $("#pro_status_check").on("click", function () {
    Swal.fire({
      title: "The Provider/Service Not Available!",
      icon: "warning",
      button: "okay",
      closeOnEsc: false,
      closeOnClickOutside: false,
    }).then(function () {
      location.reload();
    });
  });
})(jQuery);

function reschedulebooking(id, provider_id, user_id, service_id) {
  $("#reschedule").modal("show");

  $("#cancel_review").val("");
  $("#booking_id").val("");
  $("#provider_id").val("");
  $("#user_id").val("");
  $("#service_id").val("");
  var booking_id = id;
  var provider_id = provider_id;
  var user_id = service_id;
  var service_id = user_id;

  $("#cancel_booking_id").val(function () {
    return booking_id;
  });
  $("#cancel_provider_id").val(function () {
    return provider_id;
  });
  $("#cancel_user_id").val(function () {
    return user_id;
  });
  $("#cancel_service_id").val(function () {
    return service_id;
  });
}

//chat options
document.addEventListener("DOMContentLoaded", function () {
  var menuIcon = document.querySelector(".chat-options-dot");
  var optionsMenu = document.getElementById("options-menu-chat");
  if (menuIcon) {
    menuIcon.addEventListener("click", function (e) {
      e.preventDefault();
      optionsMenu.style.display = "block";
    });
  }
});
