(function ($) {
  "use strict";

  var base_url = $("#base_url").val();

  var BASE_URL = $("#base_url").val();

  var csrf_token = $("#csrf_token").val();

  var csrfName = $("#csrfName").val();

  var csrfHash = $("#csrfHash").val();

  var csrf_token = $("#admin_csrf").val();

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
      url: base_url + "admin/Chat/clear_history",

      type: "post",

      data: {
        partner_token: toToken,
        self_token: fromToken,
        csrf_token_name: csrf_token,
      },

      async: false,

      success: function (data) {
        console.log(data);

        return false;

        if (data == 1) {
          history_append_fun(toToken);
        } else {
          alert("Please Try Some TIme....");

          console.log(data);
        }
      },
    });
  }

  function get_user_chat_lists() {
    $.ajax({
      url: base_url + "admin/Chat/get_user_chat_lists",

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

          $(res.chat_list).each(function (index, value) {
            if (value.name !== null) {
              if (value.profile_img != "") {
                path = base_url + value.profile_img;

                var check_file_exists = fileExists(path);

                if (check_file_exists == false) {
                  path = base_url + value.profile_img;
                }
              } else {
                path = base_url + "assets/img/user.jpg";
              }

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
                '</span><span class="float-right text-muted"></span></div></div></a></li>';
            }
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
        }
      },
    });
  }

  function fileExists(url) {
    if (url) {
      var req = new XMLHttpRequest();

      req.open("GET", url, false);

      req.send();

      return req.status == 200;
    } else {
      return false;
    }
  }

  function history_append_fun(token) {
    $("#home_page").hide();

    $(".badge_count" + token).hide();

    var img = $("#img").val();

    $("#history_page").show();

    $("#load_div").html("<img src=" + img + ' alt="" />');

    $("#load_div").show();

    var self_token = $("#self_token").val();

    /*change to read status*/

    $.ajax({
      url: base_url + "admin/Chat/changeToRead_ctrl",

      type: "post",

      data: {
        partner_token: token,
        self_token: self_token,
        csrf_token_name: csrf_token,
      },

      async: false,

      success: function (data) {
        $(".history_append_fun").removeClass("marking");

        $('.history_append_fun[data-token="' + token + '"]').addClass(
          "marking"
        );

        if ($("#chat_box").length > 0) {
          document.getElementById("chat_box").scrollTop = 9999999;
        }
      },
    });

    $.ajax({
      url: base_url + "admin/Chat/get_chat_history",

      type: "post",

      data: {
        partner_token: token,
        self_token: self_token,
        csrf_token_name: csrf_token,
      },

      async: false,

      success: function (data) {
        $.ajax({
          url: base_url + "admin/Chat/get_token_informations",

          type: "post",

          data: {
            partner_token: token,
            self_token: self_token,
            csrf_token_name: csrf_token,
          },

          async: false,

          success: function (fetch) {
            var Data = JSON.parse(fetch);

            $("#from_name").val(Data.self_info.name);

            $("#fromToken").val(Data.self_info.token);

            if (Object.keys(Data).length > 0) {
              if (Data.partner_info != null) {
                $("#to_name").val(Data.partner_info.name);

                $("#receiver_name").text(Data.partner_info.name);

                $("#toToken").val(Data.partner_info.token);

                $("#receiver_image").removeAttr("src");
              }

              if (Data.partner_info != null) {
                var img = ("src", base_url + Data.partner_info.profile_img);

                var check_file_exists = fileExists(img);

                if (check_file_exists == false) {
                  img = base_url + "assets/img/user.jpg";
                }
              } else {
                var img = ("src", base_url + "assets/img/user.jpg");
              }
            }

            $("#receiver_image").attr("src", img);
          },
        });

        if ($("#chat_box").length > 0) {
          $("#chat_box").empty().append(data);

          document.getElementById("chat_box").scrollTop = 9999999;
        }
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
  }

  function btn_send() {
    var val = $("#chat-message").val();

    if (val == undefined || val == "") {
      alert("Please Enter Value");

      return false;
    } else {
      $("#chat-message").val("");

      sendMessage(val);
    }
  }

  const chatAppTarget = $(".pbox");

  setInterval(function () {
    get_user_chat_lists();
  }, 30000);

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
})(jQuery);
