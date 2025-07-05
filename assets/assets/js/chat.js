(function ($) {
  "use strict";

  var base_url = $("#base_url").val();

  var BASE_URL = $("#base_url").val();

  var csrf_token = $("#csrf_token").val();

  var csrfName = $("#csrfName").val();

  var csrfHash = $("#csrfHash").val();

  var showBadge = 1;

  $(document).ready(function () {
    $("#history_page").hide();

    $("#home_page").show();

    $(".history_append_fun").on("click", function () {
      var id = $(this).attr("data-token");

      showBadge = 0;

      history_append_fun(id);
    });

    $(".btn_send").on("click", function () {
      btn_send();
    });

    $("#chat-message").keypress(function (event) {
      var keycode = event.keyCode ? event.keyCode : event.which;

      if (keycode == "13") {
        btn_send();
      }
    });

    empty_check();

    $(".empty_check").on("keyup", function () {
      empty_check();
    });

    $(".search-chat").on("keyup", function () {
      filter(this);
    });
  });

  var self_token = $("#self_token").val();

  var server_name = $("#server_name").val();

  var img = $("#img").val();

  window.filter = function (element) {
    var value = $(element).val().toUpperCase();

    $(".left_message > li").each(function () {
      if ($(this).text().toUpperCase().search(value) > -1) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  };

  function empty_check() {
    var text = $("#chat-message").val();

    if (text == "") {
      $("#submit").attr("disabled", true);
    } else {
      $("#submit").attr("disabled", false);
    }
  }

  function chat_clear() {
    var fromToken = $("#fromToken").val();

    var toToken = $("#toToken").val();

    $.ajax({
      url: base_url + "client/Client/clear_history",

      type: "post",

      data: {
        partner_token: toToken,
        self_token: fromToken,
        csrf_token_name: csrf_token,
      },

      async: false,

      success: function (data) {

        return false;

        if (data == 1) {
          history_append_fun(toToken);
        } else {
          alert("Please Try Some TIme....");
        }
      },
    });
  }

  function get_user_chat_lists() {
    $.ajax({
      url: base_url + "client/Client/get_user_chat_lists",

      type: "post",

      data: { csrf_token_name: csrf_token },

      async: false,

      success: function (data) {
        if (data != "") {
          var res = JSON.parse(data);

          $(".left_message li").remove();

          var add = "";

          var path = "";

          var badge = "";

          var message = "";

          var toTokens = "";

          var newmessage = "";

          $(res.chat_list).each(function (index, value) {
           
            if (value.profile_img != "") {
              path = value.profile_img;
            } else {
              path = base_url + "assets/img/user.jpg";
            }

            // if (value.badge != 0) {
            // newmessage = 1;

            //   badge =
            //     "<span  class='position-absolute badge badge-theme '>" +
            //     value.badge +
            //     "</span>";
            // } else {
            //   newmessage = 0;

            //   badge =
            //     "<span  class='position-absolute badge badge-theme '></span>";
            // }

            var status_class =
              value.online_status === "Login"
                ? "status-online"
                : "status-offline";
            var status_text =
              value.online_status === "Login" ? "Online" : "Offline";

            if (value.badge != 0) {
              if (showBadge == 1) {
                badge =
                  "<span  class='position-absolute badge_col badge-pill bg-yellow-chat chat-bg-yellow '>" +
                  value.badge +
                  "</span>";
              } else {
                badge =
                  "<span  class='position-absolute badge badge-theme '></span>";
              }
            } else {
              badge =
                "<span  class='position-absolute badge badge-theme '></span>";
            }

            add +=
              '<li class="active history_append_fun" data-token="' +
              value.token +
              '"> <a href="javascript:void(0);"><div class="d-flex bd-highlight">';

            add +=
              '<div class="img_cont">' +
              badge +
              '<img src="' +
              path +
              '" class="rounded-circle user_img"></div>';

            add +=
              '<div class="user_info"><span class="user-name">' +
              value.name +
              '</span><span class="float-right text-muted"></span><div class="online-status"><span class="status-icon  ' +
              status_class +
              '"></span><span class="text-muted">' +
              status_text +
              "</span></div></div></div></a></li>";

            toTokens = value.token;
          });

          $(".left_message").append(add);

          $(".history_append_fun").removeClass("marking");

          var token = $("#toToken").val();

          $('.history_append_fun[data-token="' + token + '"]').addClass(
            "marking"
          );

          $(".history_append_fun").on("click", function () {
            var id = $(this).attr("data-token");

            history_append_fun(id);
          });

          var totoken = $("#toToken").val();

          var litoken = $(".history_append_fun:first-child").attr("data-token");

          if (litoken == totoken) {
            history_append_fun(litoken);
          }

          if (newmessage == 1) {
            history_append_fun(toTokens);
          }
        }
      },
    });
  }

  function history_append_fun(token) {
    // alert(token);
    $("#home_page").hide();

    $(".badge_count" + token).hide();

    var img = $("#img").val();

    $("#history_page").show();

    $("#load_div").html("<img src=" + img + ' alt="" />');

    $("#load_div").show();

    var self_token = $("#self_token").val();

    /*change to read status*/

    $.ajax({
      url: base_url + "client/Client/changeToRead_ctrl",

      type: "post",

      data: {
        partner_token: token,
        self_token: self_token,
        csrf_token_name: csrf_token,
      },

      async: false,

      success: function (data) {
        if (data == 1) {
          console.log("updated");
        } else {
          console.log("update not updated");
        }
      },
    });

    $.ajax({
      url: base_url + "client/Client/get_chat_history",

      type: "post",

      data: {
        partner_token: token,
        self_token: self_token,
        csrf_token_name: csrf_token,
      },

      async: false,

      success: function (data) {
        $.ajax({
          url: base_url + "client/Client/get_token_informations",

          type: "post",

          data: {
            partner_token: token,
            self_token: self_token,
            csrf_token_name: csrf_token,
          },

          async: false,

          success: function (fetch) {
            var Data = JSON.parse(fetch);

            // $('#from_name').val(Data.self_info.name);

            // $('#fromToken').val(Data.self_info.token);

            // $('#to_name').val(Data.partner_info.name);

            // $('#toToken').val(Data.partner_info.token);

            // $('#receiver_name').text(Data.partner_info.name);

            $("#from_name").val(
              Data.self_info.sq_first_name + " " + Data.self_info.sq_last_name
            );

            $("#fromToken").val(Data.self_info.sq_client_id);

            $("#to_name").val(
              Data.partner_info.sq_u_first_name +
                " " +
                Data.partner_info.sq_u_last_name
            );

            $("#toToken").val(0);

            $("#receiver_name").text(
              Data.partner_info.sq_u_first_name +
                " " +
                Data.partner_info.sq_u_last_name
            );

            $("#receiver_image").removeAttr("src");

            if (Data.partner_info.sq_u_profile_picture != "") {
              var img = ("src", Data.partner_info.sq_u_profile_picture);
            } else {
              var img = ("src", base_url + "assets/img/user.jpg");
            }

            $("#receiver_image").attr("src", img);
          },
        });

        $("#chat_box").empty().append(data);
      },

      complete: function () {
        $("#load_div").show();
      },
    });
  }

  function formatAMPM(date) {
    var hours = date.getHours();

    var minutes = date.getMinutes();

    var ampm = hours >= 12 ? "pm" : "am";

    hours = hours % 12;

    hours = hours ? hours : 12; // the hour '0' should be '12'

    minutes = minutes < 10 ? "0" + minutes : minutes;

    var strTime = hours + ":" + minutes + " " + ampm;

    return strTime;
  }

  function showMessage(messageHTML) {
    $("#chat_box").append(messageHTML);

    console.log(messageHTML);
  }

  function btn_send() {
    var messageJSON = {
      toToken: $("#toToken").val(),

      fromToken: $("#fromToken").val(),

      content: $("#chat-message").val(),

      fromName: $("#from_name").val(),

      toName: $("#to_name").val(),
    };

    if ($("#chat-message").val() != "") {
      $.post(
        base_url + "client/Client/insert_message",
        {
          fromToken: $("#fromToken").val(),
          toToken: $("#toToken").val(),
          content: $("#chat-message").val(),
          csrf_token_name: csrf_token,
        },

        function (response) {
          var res = JSON.parse(response);

          if (res.success) {
            history_append_fun($("#toToken").val());

            $("#chat-message").val("");

            $("#submit").prop("disabled", false);
          }
        }
      );
    }

    /*disabled submit*/

    $("#submit").attr("disabled", true);
  }

  const chatAppTarget = $(".pbox");

  var pageurl = $(location).attr("href"),
    parts = pageurl.split("/"),
    last_part = parts[parts.length - 1];

  // Extract the part before the query string

  var part_before_query = last_part.split("?")[0];

  if (part_before_query != "booking-new-chat") {
    setInterval(function () {
      get_user_chat_lists();
    }, 5000);
  }

  if ($(window).width() > 991) chatAppTarget.removeClass("chat-slide");

  $(document).on("click", ".pbox .left-message li", function () {
    if ($(window).width() <= 991) {
      chatAppTarget.addClass("chat-slide");
    }

    return false;
  });

  $(document).on("click", "#back_user_list", function () {
    if ($(window).width() <= 991) {
      chatAppTarget.removeClass("chat-slide");
    }

    return false;
  });

  var delete_title = "Delete Chat";

  var delete_msg = "Are you sure want to delete Chat?";

  var delete_text = "Your chat has been deleted";

  //new chat delete

  $(document).on("click", "#delete-options", function () {
    $("#deleteConfirmModal").modal("toggle");

    $("#acc_title").html("<i>" + delete_title + "</i>");

    $("#acc_msg").html(delete_msg);

    $(document).on("click", ".chat_accept_confirm", function () {
      var fromToken = $("#fromToken").val();

      var toToken = $("#toToken").val();

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: base_url + "client/Client/delete_chat",

            type: "post",

            data: {
              partner_token: toToken,
              self_token: fromToken,
              csrf_token_name: csrf_token,
            },

            async: false,

            //  beforeSend:function(){

            //   $('#deleteConfirmModal').modal('toggle');

            // },

            success: function (data) {
            
              if (data == 1) {
                Swal.fire({
                  title: "Deleted",
                  text: "Chat deleted successfully!",
                  icon: "success",
                  confirmButtonText: "Continue",
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  title: "Chat!",

                  text: "Chat Not Deleted ....!",

                  icon: "failure",

                  button: "okay",

                  closeOnEsc: false,

                  closeOnClickOutside: false,
                });

                location.reload();
              }
            },
          });
        }
      });
    });

    $(document).on("click", ".chat_accept_cancel", function () {});
  });
})(jQuery);
