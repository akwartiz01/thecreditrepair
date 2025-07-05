<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col">
                <!-- Page Header -->
                <div class="page-header my-3">
                    <div class="row">
                        <div class="col">
                            <h1>Edit Quick Note</h1>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-body">
                        <form id="edit_note" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="hiddenRowId" id="hiddenRowId" value="<?php echo isset($note_result[0]->id) ? $note_result[0]->id : ''; ?>">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="<?php echo isset($note_result[0]->title) ? $note_result[0]->title : ''; ?>">
                            </div>

                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea id="tinymce_editor" class="form-control" name="body" rows="5"><?php echo isset($note_result[0]->body) ? $note_result[0]->body : ''; ?></textarea>
                            </div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" onclick="edit_quick_note();">Update</button>
                                <a href="<?php echo base_url('quick_notes'); ?>" class="btn btn-link">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // Initialize TinyMCE Editor
    tinymce.init({
        selector: '#tinymce_editor',
        height: 300,
        menubar: false,
        plugins: 'lists link image charmap print preview',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat'
    });

    function edit_quick_note() {
        let hiddenRowId = $('#hiddenRowId').val();
        const title = $('#title').val().trim();
        const body = tinymce.get('tinymce_editor').getContent().trim();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('update_quick_note'); ?>',
            data: {
                'hiddenRowId': hiddenRowId,
                'title': title,
                'body': body
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'Continue'
                    }).then(() => {
                        window.location.href = "<?php echo base_url('quick_notes'); ?>";
                    });
                } else if (res.status == 'error') {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        confirmButtonText: 'Retry'
                    });
                }
            }
        });
    }
</script>