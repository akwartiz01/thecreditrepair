<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<style>
    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #dee2e6;
    }

    .coming-soon h2 {
        animation: blink 1.5s step-end infinite;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">My Finances</h3>
                </div>
          
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="coming-soon">
                            <h2>Coming Soon</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="deletePopup" class="swal-overlay swal-overlay--show-modal" tabindex="-1" style="display: none;">
    <div id="deletePopupModal" class="swal-modal" role="dialog" aria-modal="true" style="display: none;">
        <input type="hidden" name="hiddenClientId" id="hiddenClientId" value="">
        <div class="swal-icon swal-icon--warning">
            <span class="swal-icon--warning__body">
                <span class="swal-icon--warning__dot"></span>
            </span>
        </div>
        <div class="swal-title" style="">Are you sure?</div>
        <div class="swal-text" style="">You won't be able to revert this!</div>
        <div class="swal-footer">
            <div class="swal-button-container">
                <button class="swal-button swal-button--cancel btn btn-danger" onclick="deleteCancel();">Cancel</button>
                <div class="swal-button__loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="swal-button-container">
                <button class="swal-button swal-button--confirm btn btn-primary" onclick="deleteClient();">OK</button>
                <div class="swal-button__loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Initialize DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#clients_table').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });

    function deleteClientPopUp(that, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url('deleteClient'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Client has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the client.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was a problem processing your request.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>