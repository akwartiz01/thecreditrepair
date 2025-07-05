<?php
$user_id = $this->session->userdata('user_id');
$user_query = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_id` = '$user_id'");
$user_result = $user_query->result();
$user_profile_photo = !empty($user_result[0]->sq_u_profile_picture) ? $user_result[0]->sq_u_profile_picture : base_url('assets/img/user.jpg');
$client_image = empty($client_messages_list) ? base_url('assets/img/user.jpg') : '';

?>
<style>
    .message-sent {
        justify-content: flex-end;
        text-align: justify !important;
    }
span.badge.badge-success {
   background-color: #007bff !important;
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

    .selected-client {
        background-color: #3972FC !important;
        color: white;
    }

    .selected-client a {
        color: white;
    }

    .selected-client .badge {
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

    #attachment_preview img {
        max-width: 200px;
        margin-top: 10px;
    }

    span.select2-selection.select2-selection--single {
        height: unset !important;
    }

    .select2-container {
        z-index: unset !important;
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
       .rounded-4 {
        border-radius: 1rem !important;
    }
    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }
    .fw-medium {
        font-weight: 500;
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header mt-3">

            <div class="row">

                <div class="col">

                    <h1>Messages</h1>

                </div>

                <div class="col-auto text-right">

                    <a href="<?php echo base_url(); ?>secure-messages" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

                    <a href="<?php echo base_url('send_new_messages'); ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>

                </div>

            </div>

        </div>


        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Client Messages</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="client-list">
                            <?php

                            if (!empty($client_messages_list)) {
                                foreach ($client_messages_list as $client_list) {

                                    $f_name = $client_list->sq_first_name ?? '';
                                    $l_name = $client_list->sq_last_name ?? '';
                                    $name = trim("$f_name $l_name");

                                    $query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE `read_status` = 0 AND `recipient_type` = 'admin' AND `sender_id` ='$client_list->sq_client_id'");
                                    $unread_message_count = $query->num_rows();

                                    $online_status = $this->User_model->query("SELECT * FROM sq_activity WHERE `user_id` = $client_list->sq_client_id AND `user_status` = 'client' ORDER BY id DESC LIMIT 1");
                                    $online_status = $online_status->result();

                                    $is_online = !empty($online_status[0]->status) && $online_status[0]->status == 'Login' ? '<span class="badge badge-success">Online</span>' : '<span class="badge badge-secondary">Offline</span>';

                                    $client_image = !empty($client_list->profile_img) ? $client_list->profile_img : base_url('assets/img/user.jpg');
                            ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between client_list_item">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $client_image ?>" alt="Profile Photo" class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                                            <a href="javascript:void(0);" class="client_list" data-id="<?php echo $client_list->sq_client_id; ?>">
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
                            <input type="hidden" name="recipient_type" id="client" value="client">
                            <input type="hidden" name="client_id" id="client_id">

                            <div class="form-group">
                                <label>Add a quick note</label>

                                <select class="form-control" id="client_notes" name="client_notes">
                                    <option value="0">Choose Quick Notes</option>
                                    <?php foreach ($client_notes as $key_notes => $value_notes) { ?>

                                        <option value="<?php echo $value_notes->id; ?>" data-body="<?php echo htmlspecialchars($value_notes->body); ?>">
                                            <?php echo $value_notes->title; ?>
                                        </option>

                                    <?php }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <!-- <textarea id="message_input" class="form-control" name="message" rows="3" placeholder="Type your message..."></textarea> -->
                                <textarea id="tinymce_editor" class="form-control" name="message" rows="5"></textarea>
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

<!-- Include select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->

<?php if (!empty($_GET['search'])): ?>
<script>
    var clientIds = <?= json_encode($_GET['search']); ?>;
    console.log(clientIds);
    $(document).ready(function() {

    setInterval(function () {
        if (clientIds) {
            loadmessage(clientIds);
        }
    }, 5000);
    });
</script>
<?php endif; ?>

<script>
document.getElementById('client_notes').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const noteBody = selectedOption.getAttribute('data-body');

        if (noteBody) {
            tinymce.get('tinymce_editor').setContent('');

            let selectedOption = $(this).find(':selected');
            console.log(selectedOption);
            let noteText = selectedOption.data('body');
            const client_notes = $(this).val();

            if (client_notes != 0 && noteText) {
                // Replace multiple spaces with a single space and reduce newlines
                noteText = noteText.replace(/\s+/g, ' ').trim(); // Removes extra spaces
                const formattedNoteText = noteText.replace(/\n/g, '<br>'); // Converts \n to <br> for TinyMCE

                // Insert cleaned content into TinyMCE
                tinymce.get('tinymce_editor').execCommand('mceInsertContent', false, formattedNoteText);
            }
        }
    });
    tinymce.init({
        selector: '#tinymce_editor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });

    $(document).ready(function() {

        $('#client_notes').select2({
            placeholder: 'Choose Quick Notes',
            allowClear: true,
            width: '100%'
        }).on("select2:select", function(e) {

            tinymce.get('tinymce_editor').setContent('');

            let selectedOption = $(this).find(':selected');
            let noteText = selectedOption.data('body');
            const client_notes = $(this).val();

            if (client_notes != 0 && noteText) {
                noteText = noteText.replace(/\s+/g, ' ').trim();
                const formattedNoteText = noteText.replace(/\n/g, '<br>');
                tinymce.get('tinymce_editor').execCommand('mceInsertContent', false, formattedNoteText);
            }


        });

        $('.select2-selection').addClass('form-control');

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



    $('.client_list').on('click', function(event) {
        event.preventDefault();

        $('.chat_history_col').css('display', 'block');

        $('.client_list_item').removeClass('selected-client');

        $(this).closest('.client_list_item').addClass('selected-client');

        let clientId = $(this).data('id');
        $('#client_id').val(clientId);
        let read_status = 1;

        // const queryString = `?search=${encodeURIComponent(client_id)}`;
        const queryString = `?search=${clientId}`;
        window.history.pushState({}, '', queryString);

       loadmessage(clientId);
    });
function loadmessage(clientId){
       let read_status = 1;
     if (clientId) {
            $.ajax({
                url: '<?= base_url("get_chat_history") ?>',
                type: 'GET',
                data: {
                    client_id: clientId,
                    read_status: read_status
                },
                success: function(response) {
                    const chatData = JSON.parse(response);
                    $('#chat_history').empty();

                    chatData.forEach(function(message) {
                        const isSender = message.sender_id == '<?= $user_id ?>';

                        const messageBlock = `
                    <div class="message ${isSender ? 'message-sent' : 'message-received'} d-flex align-items-start mb-3">
                        <img src="${isSender ? '<?= $user_profile_photo ?>' : '<?= $client_image ?>'}" alt="Profile Photo" class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                        <div class="message-content p-3 rounded" style="max-width: 80%;">
                            ${message.subject ? ` <p style = "color:#4a4a4a;"><strong>${message.subject}</strong></p>`:''}
                            <p style = "color:#4a4a4a;">${message.message}</p>
                            ${message.attachment ? `<a href="${message.attachment}" target="_blank">View Attachment</a>` : ''}
                            <small class="text-muted d-block">${message.created_at}</small>
                        </div>
                           <button class="delete-message-btn btn btn-danger btn-sm ml-2" data-message-id="${message.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                    </div>`;

                        $('#chat_history').append(messageBlock);
                    });

                    $('#form_send_message').css('display', 'block');
                    // location.reload();
                }
            });
        } else {
            console.error('Client ID is undefined');
        }
}

    $('#form_send_message').on('submit', function(e) {
        e.preventDefault();

        const message = tinymce.get('tinymce_editor').getContent().trim();
        const client_id = $('#client_id').val();
        let read_status = 2;
        const formData = new FormData(this);
        formData.append('client_id', client_id);
        formData.append('message', message);
        formData.append('read_status', read_status);

        if (!message) {
            Swal.fire('Error!', 'Message is required', 'error').then(() => {
                location.reload();
            });
            return false;
        }

        $.ajax({
            url: '<?= base_url("send_message") ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    const queryString = `?search=${encodeURIComponent(client_id)}`;
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
        // Function to extract query parameters from URL
        function getQueryStringParams(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Get the client_id from the query string
        let selectedClientId = getQueryStringParams('search');

        if (selectedClientId) {
            // Decode the client ID (in case it was URL-encoded)
            selectedClientId = decodeURIComponent(selectedClientId);

            $('.chat_history_col').css('display', 'block');

            $('.client_list_item').removeClass('selected-client');
            $(`.client_list[data-id="${selectedClientId}"]`).closest('.client_list_item').addClass('selected-client');

            $('#client_id').val(selectedClientId);
            let read_status = 1;

            $.ajax({
                url: '<?= base_url("get_chat_history") ?>',
                type: 'GET',
                data: {
                    client_id: selectedClientId,
                    read_status: read_status
                },
                success: function(response) {
                    const chatData = JSON.parse(response);
                    $('#chat_history').empty();

                    chatData.forEach(function(message) {
                        const isSender = message.sender_id == '<?= $user_id ?>';

                    const messageBlock = `
    <div class="message ${isSender ? 'message-sent' : 'message-received'} d-flex align-items-start mb-3">
        <img src="${isSender ? '<?= $user_profile_photo ?>' : '<?= $client_image ?>'}" 
             alt="Profile Photo" 
             class="rounded-circle me-2" 
             style="width: 40px; height: 40px; object-fit: cover;">

        <div>
            <div class="message-content p-3 rounded-4 shadow-sm position-relative" 
                 style="max-width: 80%; background-color: #f1f1f1; color: #333;">
                 
                <!-- Delete icon inside bubble top-right -->
                <button class="delete-message-btn btn btn-link text-danger p-0 position-absolute" 
                        style="top: 6px; right: 6px;" 
                        data-message-id="${message.id}" 
                        title="Delete">
                    <i class="fas fa-trash"></i>
                </button>

                ${message.subject ? `
                    <div class="fw-semibold text-primary mb-1" style="font-size: 0.95rem;">
                        ${message.subject}
                    </div>` : ''}

                <div style="font-size: 0.95rem; line-height: 1.5;">
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
            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                ${message.created_at}
            </small>
        </div>
    </div>`;


                        $('#chat_history').append(messageBlock);
                    });

                    $('#form_send_message').css('display', 'block');
                }
            });
        }
    });

    $('#send_new_message').on('click', function() {

        window.location.href = '<?= base_url("send_new_messages") ?>';
    });

    $(document).on('click', '.delete-message-btn', function() {
        const messageId = $(this).data('message-id');
        const $messageDiv = $(this).closest('.message');

        let clientId = $('#client_id').val();

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
                    url: '<?= base_url("delete_secure_messages") ?>',
                    type: 'POST',
                    data: {
                        message_id: messageId
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire('Deleted!', 'Your message has been deleted.', 'success');
                            $messageDiv.remove();

                            $.ajax({
                                url: '<?= base_url("check_client_messages") ?>',
                                type: 'POST',
                                data: {
                                    clientId: clientId
                                },
                                success: function(response1) {
                                    const res1 = JSON.parse(response1);
                                    if (res1.status === 'empty') {
                                        localStorage.removeItem('selectedClientId');
                                        $('.client_list_item').removeClass('selected-client');
                                        window.location.href = "<?php echo base_url('secure-messages') ?>";
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