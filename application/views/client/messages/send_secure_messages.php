<?php
$user_id = $this->session->userdata('user_id');
?>
<style>
    .form-check-inline {
        margin-right: 20px;
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
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Send Message</h3>
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
                                    <a href="<?php echo base_url('client/secure-messages'); ?>" class="nav-link">All Messages</a>
                                </li>

                                <li data-id="send_new_messages" class="nav-item active">
                                    <a href="javascript:void(0);" class="nav-link">Send New Messages</a>
                                </li>

                            </ul>


                            <div id="user-type">
                                <div class="form-group">
                                    <label>To:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="recipient_type" id="recipient_type" value="admin" checked>
                                        <label class="form-check-label" for="recipient_type">Team member</label>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">


                                            <label>Team Member</label>

                                            <select class="form-control" id="sq_u_id" name="sq_u_id">
                                                <option value="0">Choose Team Member</option>
                                                <?php foreach ($team_member as $key => $value) {

                                                    $f_name = $value->sq_u_first_name ?? '';
                                                    $l_name = $value->sq_u_last_name ?? '';
                                                    $name = trim("$f_name $l_name");

                                                ?>
                                                    <option value="<?php echo $value->sq_u_id; ?>"><?php echo $name; ?></option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>


                                        <div class="col-6">
                                            <label for="subject">Title/Subject</label>
                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Title/Subject">
                                        </div>
                                    </div>
                                </div>



                                <!-- TinyMCE Editor -->
                                <div class="form-group">
                                    <label for="message">Wite a message</label>
                                    <textarea id="tinymce_editor" class="form-control" name="message" rows="5"></textarea>
                                </div>

                                <!-- Attachment Upload -->
                                <div class="form-group">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control-file" id="attachment" name="attachment" accept="image/*, .pdf">
                                </div>

                                <!-- Display Selected File -->
                                <div id="attachment_preview" class="mt-2"></div>

                                <div class="mt-4">
                                    <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Submit</button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include jQuery (if not already included) -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- Include select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
<script>
    tinymce.init({
        selector: '#tinymce_editor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });

    $(document).ready(function() {

        $('#sq_u_id').select2({
            placeholder: 'Choose Team Member',
            allowClear: true,
            width: '100%'
        });


        $('.select2-selection').addClass('form-control');

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
        $('#sq_u_id, #subject,#tinymce_editor').on('keyup change', function() {
            validateField($(this));
        });
    }

    function validateField($field) {
        let id = $field.attr('id');
        let value = $field.val();

        switch (id) {
            case 'sq_u_id':
                if (value === "0" || value === "") {
                    handleFieldValidation($field, "Team Member is required.");
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

            clearFieldValidation($('#sq_u_id'));
            clearFieldValidation($('#subject'));
            clearFieldValidation($('#tinymce_editor'));

            const sq_u_id = $('#sq_u_id').find(":selected").val();
            const subject = $('#subject').val().trim();
            const recipient_type = $('#recipient_type').val();
            const message = tinymce.get('tinymce_editor').getContent().trim();


            if (sq_u_id == "0" || sq_u_id === "") {
                handleFieldValidation($('#sq_u_id'), "Team Member is required.");
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
                formData.append('sq_u_id', sq_u_id);
                formData.append('subject', subject);
                formData.append('message', message);

                $.ajax({
                    url: '<?= base_url("client/send_message") ?>',
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
                                window.location.href = "<?php echo base_url('client/secure-messages?search='); ?>" + sq_u_id;
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