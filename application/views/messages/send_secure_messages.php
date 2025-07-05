<?php
$user_id = $this->session->userdata('user_id');
?>

<style>
    .form-check-inline {
        margin-right: 20px;
    }
.custom_label{
    display:unset !important;
     margin-left: unset !important;
     line-height: unset !important;
}
    #attachment_preview img {
        max-width: 200px;
        margin-top: 10px;
    }

    .form-group.quick_notes {
        margin-bottom: 0px !important;
        color: #3972FC !important;
    }

    a.quick_notes_a {
        color: #3972FC !important;
    }

    .form-group.quick_notes:hover {
        text-decoration: underline !important;
        text-decoration-color: #3972FC !important;
    }

    .tox.tox-tinymce {
        height: 500px !important;
    }

    span.select2-selection.select2-selection--single {
        height: unset !important;
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header mt-3">
            <div class="row">
                <div class="col">
                    <h1>Send Message</h1>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <form id="form_secure_message" action="" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs menu-tabs">
                                <li data-id="all_messages" class="nav-item">
                                    <a href="<?php echo base_url('secure-messages'); ?>" class="nav-link">All Messages</a>
                                </li>
                                <li data-id="client_messages" class="nav-item">
                                    <a href="<?php echo base_url('secure-messages'); ?>" class="nav-link">Client Messages</a>
                                </li>

                                <!-- <li data-id="affiliate_messages" class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">Affiliate Messages</a>
                                </li>

                                <li data-id="team_member_messages" class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">Team Member Messages</a>
                                </li> -->

                                <li data-id="send_new_messages" class="nav-item active">
                                    <a href="javascript:void(0);" class="nav-link">Send New Messages</a>
                                </li>

                            </ul>

                            <!-- Info Box -->
                            <div class="alert alert-info mt-3" role="alert">
                                <i class="fas fa-info-circle"></i> Secure message do not send anywhere. That’s why they are secure. An automated notification is sent by email, asking the recipients to “log in” to see the secure message or document. This is the same way your bank will communicate with you. No sensitive data is ever sent by email. It remains safely encrypted on our secure server for your client to see or download. For frequently used messages, use the Quick Notes option.
                            </div>

                            <div id="user-type">
                                <div class="form-group">
                                    <label>To:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="recipient_type" id="client" value="client" checked>
                                        <label class="form-check-label custom_label" for="client">Client</label>
                                    </div>
                                    <!-- <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="recipient_type" id="affiliate" value="Affiliate">
                                        <label class="form-check-label" for="affiliate">Affiliate</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="recipient_type" id="team_member" value="Team Member">
                                        <label class="form-check-label" for="team_member">Team Member</label>
                                    </div> -->
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Client</label>
                                            <select class="form-control" id="client_id" name="client_id">
                                                <option value="0">Choose Client</option>
                                                <?php foreach ($clients as $key => $value) {
                                                    $f_name = $value->sq_first_name ?? '';
                                                    $l_name = $value->sq_last_name ?? '';
                                                    $name = trim("$f_name $l_name");
                                                ?>
                                                    <option value="<?php echo $value->sq_client_id; ?>" <?php if (!empty($clientid) && $clientid == $value->sq_client_id) echo 'selected'; ?>>
                                                        <?php echo $name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-6">
                                            <label>Add a quick note</label>

                                            <select class="form-control" id="client_notes" name="client_notes">
                                                <option value="0">Choose Quick Notes</option>
                                                <?php foreach ($client_notes as $key_notes => $value_notes) { ?>
                                                    <option value="<?php echo $value_notes->id; ?>" data-body="<?php echo htmlspecialchars($value_notes->body); ?>">
                                                        <?php echo $value_notes->title; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group quick_notes">
                                    <div class="row">
                                        <div class="col-6"></div>

                                        <div class="col-6">
                                            <a href="<?php echo base_url('quick_notes'); ?>" class="quick_notes_a">Manage Quick Notes</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="subject">Title/Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Title/Subject">
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="tinymce_editor" class="form-control" name="message" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control-file" id="attachment" name="attachment" accept="image/*, .pdf">
                                </div>

                                <!-- Display Selected File -->
                                <div id="attachment_preview" class="mt-2"></div>

                                <div class="mt-4">
                                    <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Submit</button>
                                </div>

                                <!-- Info Box -->
                                <div class="alert alert-info mt-3" role="alert">
                                    <i class="fas fa-info-circle"></i>
                                    Secure messages are not intended to replace your own email system. If you wish to send mass emails or marketing emails, please use your own email system or a 3rd party email broadcasting service like “ActiveCampaign, StreamSend or Constant Contact.”
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include select2 CSS -->
<!-- jQuery (required) -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
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
    $(document).ready(function() {

        $('#client_id').select2({
            placeholder: 'Choose Client',
            allowClear: true,
            width: '100%'
        });

        // .on("select2:select", function(e) {
        //     const client_id = $('#client_id').find(":selected").val();
        //     const queryString = `?search=${encodeURIComponent(client_id)}`;
        //     window.history.pushState({}, '', queryString);

        // });

        $('#client_notes').select2({
            placeholder: 'Choose Quick Notes',
            allowClear: true,
            width: '100%'
        }).on("select2:select", function(e) {

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


        });

        $('.select2-selection').addClass('form-control');

    });


    tinymce.init({
        selector: '#tinymce_editor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });

    document.getElementById('attachment').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('attachment_preview');

        preview.innerHTML = '';

        if (file && file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);
        } else {
            const text = document.createTextNode(`Selected file: ${file.name}`);
            preview.appendChild(text);
        }
    });

    function validateFieldsOnKeyup() {
        $('#client_id, #subject,#tinymce_editor').on('keyup change', function() {
            validateField($(this));
        });
    }

    function validateField($field) {
        let id = $field.attr('id');
        let value = $field.val();

        switch (id) {
            case 'client_id':
                if (value === "0" || value === "") {
                    handleFieldValidation($field, "Client is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
            case 'subject':
                if (value === "") {
                    handleFieldValidation($field, "Subject is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;

            case 'tinymce_editor':
                if (value === "") {
                    handleFieldValidation($field, "Message is required.");
                } else {
                    clearFieldValidation($field);
                }
                break;
        }
    }

    function handleFieldValidation($field, message) {
        $field.addClass('is-invalid');
        if (!$field.next('.invalid-feedback').length) {
            $field.after('<div class="invalid-feedback"><strong>' + message + '</strong></div>');
        }
    }

    function clearFieldValidation($field) {
        $field.removeClass('is-invalid');
        $field.next('.invalid-feedback').remove();
    }

    validateFieldsOnKeyup();


    $(document).ready(function() {
        $('#form_secure_message').on('submit', function(e) {
            e.preventDefault();

            let isValid = true;

            clearFieldValidation($('#client_id'));
            clearFieldValidation($('#subject'));
            clearFieldValidation($('#tinymce_editor'));

            const client_id = $('#client_id').find(":selected").val();
            const subject = $('#subject').val().trim();
            const message = tinymce.get('tinymce_editor').getContent().trim();


            if (client_id == "0" || client_id === "") {
                handleFieldValidation($('#client_id'), "Client is required.");
                isValid = false;
            }


            if (subject == '') {
                handleFieldValidation($('#subject'), "Subject is required.");
                isValid = false;
            }


            if (message == '') {
                handleFieldValidation($('#tinymce_editor'), "Message is required.");
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    title: 'Error',
                    text: 'Please provide all mandatory fields!',
                    icon: 'error',
                    confirmButtonText: 'Retry'
                });

                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 50
                }, 500);

            } else {
                $('#loader').show();

                const formData = new FormData(this);
                formData.append('client_id', client_id);
                formData.append('subject', subject);
                formData.append('message', message);

                $.ajax({
                    url: '<?= base_url("send_message") ?>',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $('#loader').hide();
                        if (res.status === 'success') {

                            Swal.fire({
                                title: 'Success!',
                                text: res.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.href = "<?php echo base_url('secure-messages?search='); ?>" + client_id;
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: res.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {

                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while submitting the message.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
</script>