<?php
$user_id = $this->session->userdata('user_id');
?>
<style>
    .tox.tox-tinymce {
        height: 400px !important;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header my-3">
            <div class="row">
                <div class="col">
                    <h1>Add Quick Note</h1>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <form id="form_quick_notes" action="" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
                            </div>

                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea id="tinymce_editor" class="form-control" name="body" rows="5"></textarea>
                            </div>

                            <div class="mt-4">
                                <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Submit</button>
                                <a href="<?php echo base_url('quick_notes'); ?>" class="btn btn-link">Cancel</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#tinymce_editor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });


    $(document).ready(function() {
        $('#form_quick_notes').on('submit', function(e) {
            e.preventDefault();

            const title = $('#title').val().trim();
            const message = tinymce.get('tinymce_editor').getContent().trim();

            // Create FormData object to include the form data and files
            const formData = new FormData(this);

            if (!title) {
                Swal.fire({
                    title: 'Error',
                    text: 'Title is required',
                    icon: 'error',
                    confirmButtonText: 'Close'
                });
                return false;
            }

            if (!message) {
                Swal.fire({
                    title: 'Error',
                    text: 'Message content is required',
                    icon: 'error',
                    confirmButtonText: 'Close'
                });
                return false;
            }

            formData.append('message', message);

            $.ajax({
                url: '<?= base_url("add_quick_notes") ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    let res = JSON.parse(response);

                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success'
                        }).then(() => {

                            window.location.href = "<?php echo base_url('quick_notes') ?>";
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
                    // Handle errors
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while submitting the message.',
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>