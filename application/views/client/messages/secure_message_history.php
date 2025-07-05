<?php
$user_id = $this->session->userdata('user_id');
$getData = $this->User_model->query("SELECT * FROM `sq_clients` WHERE `sq_client_id` = '$user_id'");
$fetch_result = $getData->result();
$client_image = !empty($fetch_result[0]->profile_img) ? $fetch_result[0]->profile_img : base_url('assets/img/user.jpg');
$admin_image = empty($get_user_list) ? base_url('assets/img/user.jpg') : '';

?>

<style>
    .message-sent {
        justify-content: flex-end;
        text-align: justify !important;
    }

    .message-received {
        justify-content: flex-start;
        text-align: justify !important;
    }

    .message-sent .message-content {

        background-color: #f1f1f1;
        color: #333;
    }

    .message-received .message-content {
        background-color: #f1f1f1;
        color: #333;
    }

    .message-content * {
        background-color: #f1f1f1 !important;
    }

    .card-footer .btn {
        float: right;
    }

    img.rounded-circle {
        width: 40px;
        height: 40px;
    }

    .selected-team-member {
        background-color: #3972FC !important;
        color: white;
    }

    .selected-team-member a {
        color: white;
    }

    .selected-team-member .badge {
        background-color: white;
        color: #007bff;
    }

    span.badge.badge-success {
        color: white !important;
    }

    span.badge.badge-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }
   .rounded-4 {
        border-radius: 1rem !important;
    }
    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }
    .fw-medium {
        font-weight: 500;
    }
    #attachment_preview img {
        max-width: 200px;
        margin-top: 10px;
    }

    span.count-symbol.notification-count {
        position: absolute !important;
        top: 5px !important;
        color: white !important;
        border-radius: 50% !important;
        padding: 4px 10px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <?php if ($this->session->userdata('user_type') == 'client'): ?>
            <!-- Page Header -->
            <div class="page-header">

                <div class="row">

                    <div class="col">

                        <h3 class="page-title">Messages</h3>

                    </div>

                    <div class="col-auto text-right">

                        <a href="<?php echo base_url(); ?>client/secure-messages" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

                        <a href="<?php echo base_url('client/send_new_messages'); ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>

                    </div>

                </div>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Team Member Messages</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="messages-list">
                            <?php

                            if (!empty($get_user_list)) {
                                foreach ($get_user_list as $list) {

                                    $f_name = $list->sq_u_first_name ?? '';
                                    $l_name = $list->sq_u_last_name ?? '';
                                    $name = trim("$f_name $l_name");

                                    $user_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE `read_status` = 0 AND `recipient_type` = 'client' AND `sender_id` ='$list->sq_u_id'");
                                    $unread_message_count = $user_query->num_rows();

                                    $online_status = $this->User_model->query("SELECT * FROM sq_activity WHERE `user_id` = $list->sq_u_id AND `user_status` IS NULL ORDER BY id DESC LIMIT 1");
                                    $online_status = $online_status->result();

                                    $is_online = !empty($online_status[0]->status) && $online_status[0]->status == 'Login' ? '<span class="badge badge-success">Online</span>' : '<span class="badge badge-secondary">Offline</span>';

                                    $admin_image = !empty($list->sq_u_profile_picture) ? $list->sq_u_profile_picture : base_url('assets/img/user.jpg');
                            ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between messages_list_item">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $admin_image ?>" alt="Profile Photo" class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                                            <a href="javascript:void(0);" class="team_member_list" data-id="<?php echo $list->sq_u_id; ?>">
                                                <?php echo $name; ?>
                                                <?php if ($unread_message_count > 0): ?>
                                                    <span class="count-symbol notification-count bg-danger"><?php echo $unread_message_count; ?></span>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <?= $is_online ?>
                                    </li>
                                <?php }
                            } else { ?>
                                <p class="text-muted">You haven't sent any messages yet</p>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Chat History -->
            <div class="col-md-7 chat_history_col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chat History</h4>
                    </div>
                    <div class="card-body" id="chat_history">
                        <p style="text-align: center !important;"><i class="mdi mdi-comment" style="font-size:25px !important;"></i></p>
                        <p style="text-align: center !important;" class="text-muted">No conversation selected</p>
                    </div>

                    <div class="card-footer" id="card_footer">
                        <form id="form_send_message" action="" method="POST" enctype="multipart/form-data" style="display: none;">
                            <input type="hidden" name="recipient_type" id="recipient_type" value="admin">
                            <input type="hidden" name="team_member_Id" id="team_member_Id">

                            <div class="form-group">
                                 <textarea id="tinymce_editor" class="form-control" name="message" rows="5"></textarea>
                                <!--<textarea id="message_input" class="form-control" name="message" rows="3" placeholder="Type your message..."></textarea>-->
                            </div>

                            <div class="form-group">
                                <label for="attachment">Attachment</label>
                                <input type="file" id="attachment" name="attachment" class="form-control-file" accept="image/*,.pdf">
                            </div>
                            <div id="attachment_preview" class="mt-2"></div>
                            <button type="submit" class="btn btn-primary float-right" value="true">Send</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    tinymce.init({
        selector: '#tinymce_editor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });

    document.getElementById('attachment').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('attachment_preview');

        preview.innerHTML = ''; // Clear previous content

        if (file && file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);
        } else {
            const text = document.createTextNode(`Selected file: ${file.name}`);
            preview.appendChild(text);
        }
    });


    $('.team_member_list').on('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the link

        $('.chat_history_col').css('display', 'block');

        // Remove active class from all list items
        $('.messages_list_item').removeClass('selected-team-member');

        $(this).closest('.messages_list_item').addClass('selected-team-member');

        let team_member_Id = $(this).data('id');
        let read_status = 1;
        $('#team_member_Id').val(team_member_Id);

        const queryString = `?search=${team_member_Id}`;
        window.history.pushState({}, '', queryString);

        if (team_member_Id) {
            $.ajax({
                url: '<?= base_url("client/get_messages_history") ?>',
                type: 'GET',
                data: {
                    team_member_Id: team_member_Id,
                    read_status: read_status
                },
              success: function(response) {
    const chatData = JSON.parse(response);
    $('#chat_history').empty();

    chatData.forEach(function(message) {
        const isSender = message.sender_id == '<?= $user_id ?>';
        const profileImage = isSender ? '<?= $client_image ?>' : '<?= $admin_image ?>';

        const messageBlock = `
        <div class="d-flex ${isSender ? 'justify-content-end' : 'justify-content-start'} mb-4">
            <div class="d-flex ${isSender ? 'flex-row-reverse' : ''} align-items-start" style="max-width: 80%;">
                <img src="${profileImage}" alt="Profile" class="rounded-circle shadow" style="width: 40px; height: 40px;">
                <div class="message-content bg-light p-3 rounded-3 shadow-sm mx-2" style="min-width: 100px;">
                    ${message.subject ? `<div class="fw-bold text-primary mb-1">${message.subject}</div>` : ''}
                    <div class="text-dark mb-2">${message.message}</div>
                    ${message.attachment ? `<a href="${message.attachment}" target="_blank" class="text-decoration-none text-info">📎 View Attachment</a><br>` : ''}
                    <small class="text-muted">${message.created_at}</small>
                </div>
                <button class="delete-message-btn btn btn-outline-danger btn-sm ms-2 mt-1" data-message-id="${message.id}" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>`;

        $('#chat_history').append(messageBlock);
    });

    $('#form_send_message').show();
    location.reload();
}

            });
        } else {
            console.error('Team Member ID is undefined');
        }
    });


    $('#form_send_message').on('submit', function(e) {
        e.preventDefault();
    const message = tinymce.get('tinymce_editor').getContent().trim();
        const sq_u_id = $('#team_member_Id').val();
        // const message = $('#message_input').val();
        let read_status = 2;
        const formData = new FormData(this);
        formData.append('sq_u_id', sq_u_id);
        formData.append('message', message);
        formData.append('read_status', read_status);

        if (!message) {

            Swal.fire('Error!', 'Message is required', 'error').then(() => {
                location.reload();
            });
            return false;
        }

        $.ajax({
            url: '<?= base_url("client/send_message") ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    const queryString = `?search=${encodeURIComponent(sq_u_id)}`;
                    window.history.pushState({}, '', queryString);

                    Swal.fire('Success!', res.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', res.message, 'error');
                }
            }
        });
    });


    $(document).ready(function() {
        // let selectedTeamMemberId = localStorage.getItem('selectedTeamMemberId');

        // Function to extract query parameters from URL
        function getQueryStringParams(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Get the client_id from the query string
        let selectedTeamMemberId = getQueryStringParams('search');

        if (selectedTeamMemberId) {
            // Decode the client ID (in case it was URL-encoded)
            selectedTeamMemberId = decodeURIComponent(selectedTeamMemberId);
            // Show the chat history column
            $('.chat_history_col').css('display', 'block');

            $('.messages_list_item').removeClass('selected-team-member');
            $(`.team_member_list[data-id="${selectedTeamMemberId}"]`).closest('.messages_list_item').addClass('selected-team-member');

            $('#team_member_Id').val(selectedTeamMemberId);
            let read_status = 1;

            $.ajax({
                url: '<?= base_url("client/get_messages_history") ?>',
                type: 'GET',
                data: {
                    team_member_Id: selectedTeamMemberId,
                    read_status: read_status
                },
                success: function(response) {
                    const chatData = JSON.parse(response);
                    $('#chat_history').empty();

                    chatData.forEach(function(message) {
                        const isSender = message.sender_id == '<?= $user_id ?>';

    const messageBlock = `
    <div class="message ${isSender ? 'message-sent' : 'message-received'} d-flex align-items-start mb-3">
        <img src="${isSender ? '<?= $client_image ?>' : '<?= $admin_image ?>'}" 
             alt="Profile Photo" 
             class="rounded-circle mr-2" 
             style="width: 40px; height: 40px; object-fit: cover;">

        <div>
            <div class="message-content p-3 rounded-4 shadow-sm position-relative" 
                 style="max-width: 80%; background-color: #f1f1f1; color: #333;">
                
                <!-- Delete icon in top-right -->
                <button class="delete-message-btn btn btn-link text-danger p-0 position-absolute" 
                        style="top: 8px; right: 8px;" 
                        data-message-id="${message.id}" 
                        title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>

                ${message.subject ? `
                    <div class="fw-semibold text-primary mb-1" style="font-size: 0.95rem;">
                        ${message.subject}
                    </div>` : ''}

                <div style="font-size: 0.95rem; line-height: 1.4;">
                    ${message.message}
                </div>

                ${message.attachment ? `
                    <div class="mt-2">
                        <a href="${message.attachment}" target="_blank" 
                           class="text-decoration-underline text-info fw-medium">
                            📎 View Attachment
                        </a>
                    </div>` : ''}
            </div>

            <!-- Date shown below the bubble -->
            <small class="text-muted d-block mt-1" style="font-size: 0.75rem; margin-left: 6px;">
                ${message.created_at}
            </small>
        </div>
    </div>`;


                        $('#chat_history').append(messageBlock);
                    });


                    $('#form_send_message').css('display', 'block');
                    // Optionally, clear the localStorage after reloading the chat
                    localStorage.removeItem('selectedTeamMemberId');
                }
            });
        }
    });

    $('#send_new_message').on('click', function() {

        window.location.href = '<?= base_url("client/send_new_messages") ?>';
    });

    // Handle the delete button click
    $(document).on('click', '.delete-message-btn', function() {
        const messageId = $(this).data('message-id');
        const $messageDiv = $(this).closest('.message'); // Get the closest message div

        let team_member_Id = $('#team_member_Id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete this message?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("client/delete_message") ?>',
                    type: 'POST',
                    data: {
                        message_id: messageId
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire('Deleted!', 'Your message has been deleted.', 'success');
                            $messageDiv.remove(); // Remove the message div from the DOM

                            $.ajax({
                                url: '<?= base_url("client/check_messages") ?>',
                                type: 'POST',
                                data: {
                                    team_member_Id: team_member_Id
                                },
                                success: function(response1) {
                                    const res1 = JSON.parse(response1);
                                    if (res1.status === 'empty') {
                                        localStorage.removeItem('selectedTeamMemberId');
                                        $('.messages_list_item').removeClass('selected-team-member');
                                        window.location.href = "<?php echo base_url('client/secure-messages') ?>";
                                    }
                                }
                            });
                        } else if (res.status === 'error') {
                            Swal.fire('Error!', res.message, 'error').then(() => {

                            });
                        } else {
                            Swal.fire('Error!', 'Unable to delete the message.', 'error');
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>