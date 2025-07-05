<?php
$path = "";

?>

<style>
    .chat_color {
        color: white !important;
    }

    .bg-yellow-chat {
        background: green !important;
        color: white !important;
    }

    .badge_chats {
        color: white !important;
    }

    .online-status {
        display: flex;
        align-items: center;
    }

    .online-status .status-icon {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .status-online {
        background-color: green;
    }

    .status-offline {
        background-color: red;
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Messages</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-sm-3 mb-md-0 contacts_card flex-fill chat-scroll">

                    <div class="card-header">
                        <form class="chat-search">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fa fa-search"></i>
                                </div>
                                <input type="text" placeholder="Search" name="search_chat_list" id="search_chat_list" class="form-control search-chat ">
                            </div>
                        </form>
                    </div>

                    <div class="card-body contacts_body">
                        <div class="">
                            <ul role="tablist" class="left_message contacts">
                                <?php
                                foreach ($chat_list as $key => $value) {

                                    if (!empty($value['profile_img'])) {
                                        $path = $value['profile_img'];
                                    } else {
                                        $path = base_url() . 'assets/img/user.jpg';
                                    }

                                    $class_names = 'badge_count' . $value['token'];
                                    if ($value['badge'] != 0) {
                                        $badge = "<span class='position-absolute chat_color badge_col badge-pill bg-yellow-chat chat-bg-yellow badge_count" . $value['token'] . "'>" . $value['badge'] . "</span>";
                                    } else {
                                        $badge = "<span class='position-absolute badge_col badge_chats badge-theme badge_count" . $value['token'] . "'></span>";
                                    }

                                    // Check user status for online/offline
                                    $status_class = $value['online_status'] === 'Login' ? 'status-online' : 'status-offline';
                                    $status_text = $value['online_status'] === 'Login' ? 'Online' : 'Offline';

                                ?>

                                    <li class="active history_append_fun" data-token="<?= $value['token']; ?>"> <a href="javascript:void(0);">
                                            <div class="d-flex bd-highlight">
                                                <div class="img_cont"><?= $badge; ?>

                                                    <img src="<?= $path; ?>" class="rounded-circle user_img">
                                                </div>
                                                <div class="user_info">


                                                    <span class="user-name"><?= $value['name']; ?></span><span class="float-right text-muted"></span>
                                                    <div class="online-status">
                                                        <span class="status-icon <?= $status_class; ?>"></span>
                                                        <span class="text-muted"><?= $status_text; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                <?php } ?>


                            </ul>
                        </div>



                    </div>
                    <div class="card-footer"></div>

                </div>
            </div>

            <div class="col-md-8 chat d-flex chat-scroll">
                <div class="card flex-fill mb-0 justify-content-center align-items-center" id="home_page">
                    <div class="no-messages">
                        <i class="far fa-comments"></i>
                    </div>
                </div>

                <!-- chat history -->
                <div class="card w-100 mb-0" id="history_page">


                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img id="receiver_image" src="" class="rounded-circle user_img">
                            </div>
                            <div class="user_info">
                                <span><strong id="receiver_name"></strong></span>
                                <p class="mb-0"><?php echo $value['name']; ?></p>
                            </div>

                            <!-- <div>
                                <a href="#" class="btn btn-sm bg-light mr-2 chat-options-dot" data-id=""> <i class="fas fa-ellipsis-h"></i>
                                    <div class="options_chat" id="options-menu-chat">
                                        <a href="#" id="delete-option" class="delete-option">Delete</a>
                                    </div>
                            </div> -->

                        </div>
                    </div>

                    <div class="card-body msg_card_body" id="chat_box">
                        <div id="load_div" class="text-center"></div>
                    </div>

                    <div class="card-footer">
                        <input type="hidden" name="chat-seft" id="fromToken" placeholder="" value="" class="" />
                        <input type="hidden" name="toToken" value="" id="toToken" placeholder="" class="" />
                        <input type="hidden" name="from_name" value="" id="from_name">
                        <input type="hidden" name="to_name" value="" id="to_name">
                        <div class="input-group">
                            <input name="" class="form-control type_msg mh-auto empty_check" id="chat-message" placeholder="Type your message..." maxlength="1000"></input>
                            <div class="input-group-append">
                                <button id="submit" class="btn btn-primary btn_send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<input type="hidden" name="user_address">
<input type="hidden" id="self_token" value="<?php echo $this->session->userdata('user_id'); ?>">
<input type="hidden" id="server_name" value="<?php echo $server_name . ':' . $port_no; ?>">
<input type="hidden" id="img" value="<?= base_url('assets/img/loader.gif'); ?>">
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title" id="acc_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p id="acc_msg"></p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-success chat_accept_confirm">Yes</a>
                <button type="button" class="btn btn-danger chat_accept_cancel" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>