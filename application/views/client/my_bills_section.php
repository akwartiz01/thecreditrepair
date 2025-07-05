<?php
$totoalPayamt = 0;
if (isset($totalPay) && is_array($totalPay)) {
    foreach ($totalPay as $value) {
        $totoalPayamt += $value[0]->pay_amount;
        // echo "<pre>";
        // print_r($value);
        // echo "</pre>";
    }
}

// die('STOP');
?>

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

    /* Pending status: Red background */
    .status-pending {
        background-color: #dc3545;
        /* background: linear-gradient(to right, #ffbf96, #fe7096); */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    /* Paid status: Green background */
    .status-paid {
        background-color: #28a745;
        /* background: linear-gradient(to right, #84d9d2, #07cdae); */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    /* Default status: Grey background (for other statuses) */
    .status-default {
        background-color: #6c757d;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    td a.text-primary:hover {
        text-decoration: underline !important;
        cursor: pointer;
    }

    td a.preview_invoice:hover {
        text-decoration: underline !important;
        cursor: pointer;
    }

    #previewModal .table thead th {
        color: white !important;
    }

    .text-danger:hover {
        cursor: pointer;
    }
</style>

<div class="page-wrapper">

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">My Bills</h3>

                </div>

            </div>

        </div>

        <!-- /Page Header -->

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">


                        <?php if ($this->session->userdata('user_type') == 'client'): ?>

                            <div class="form-group" style="float: right;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" id="add_bills" class="btn btn-primary">Add Bills</button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">

                            <table class="table custom-table mb-0" id="billsTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Bill Name</th>
                                        <th class="text-center">Due Date</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Add Bills Modal -->
<div class="modal fade" id="myBillsModal" tabindex="-1" role="dialog" aria-labelledby="myBillsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="myBillsModalLabel">Add Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addBillForm">
                    <div class="form-group">
                        <label>Name of Bill <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="bill_name" name="bill_name">
                    </div>
                    <div class="form-group">
                        <label>Due Date <span class="text-danger">*</span></label>
                        <input class="form-control datepicker" type="text" id="due_date" name="due_date">
                    </div>
                    <div class="form-group">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="amount" name="amount">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addOrUpdateBill('add')">Add Bill</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Bills Modal -->
<div class="modal fade" id="billsEditModal" tabindex="-1" role="dialog" aria-labelledby="billsEditModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="billsEditModalLabel">Edit Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBillForm">
                    <input type="hidden" id="edit_bill_id" name="bill_id">
                    <div class="form-group">
                        <label>Name of Bill <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="edit_bill_name" name="bill_name">
                    </div>
                    <div class="form-group">
                        <label>Due Date <span class="text-danger">*</span></label>
                        <input class="form-control datepicker" type="text" id="edit_due_date" name="due_date">
                    </div>
                    <div class="form-group">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="edit_amount" name="amount">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addOrUpdateBill('edit')">Update Bill</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBillModal" tabindex="-1" role="dialog" aria-labelledby="deleteBillModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteBillModalLabel">Delete Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this bill?</p>
                <input type="hidden" id="delete_bill_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="deleteBill()">Delete</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- Initialize DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.6/purify.min.js"></script>
<script>
    $(document).ready(function() {
        $('#billsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });


    $('#add_bills').click(function() {
        $('#myBillsModal').modal('show');
        $("#addBillForm").trigger('reset');
          $("#addBillForm").find('input').each(function() {
            validateField($(this));
          $(this).removeClass('is-invalid');
        });

    });


    $(function() {
        $('.datepicker').datetimepicker({

            format: 'YYYY/MM/DD',
            viewMode: 'years',
            icons: {
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
            }
        });
    });


    function deleteBill(that, sq_client_id) {
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
                    url: '<?php echo base_url('client/delete-bill'); ?>',
                    type: 'POST',
                    data: {
                        sq_client_id: sq_client_id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Bill has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the bill.',
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

    $(document).ready(function() {
        loadBills(); // Load bills on page load

        $('#bill_name, #due_date, #amount, #edit_bill_name, #edit_due_date, #edit_amount').on('input', function() {
            validateField($(this));
        });
    });

    function validateField($field) {
        if (!$field.val().trim()) {
            $field.addClass('is-invalid').removeClass('is-valid');
        } else {
            $field.addClass('is-valid').removeClass('is-invalid');
        }
    }

    function loadBills() {
        $.ajax({
            url: '<?php echo base_url("client/Client/get_bills"); ?>',
            method: 'GET',
            success: function(response) {
                const bills = JSON.parse(response);
                const tbody = $('#billsTable tbody').empty();
                bills.forEach((bill, index) => {
                    tbody.append(`
                    <tr id="${bill.id}">
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${bill.bill_name}</td>
                        <td class="text-center">${bill.due_date}</td>
                        <td class="text-center">${bill.amount}</td>
                        <td class="text-center">
                            <a href="#" onclick="openEditModal(${bill.id})" class="text-success mx-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="openDeleteModal(${bill.id})" class="text-danger mx-2">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `);
                });
            }
        });
    }

    function addOrUpdateBill(action) {
        const form = action === 'add' ? $('#addBillForm') : $('#editBillForm');
        const modal = action === 'add' ? '#myBillsModal' : '#billsEditModal';
        let isValid = true;

        form.find('input').each(function() {
            validateField($(this));
            if ($(this).hasClass('is-invalid')) isValid = false;
        });

        if (!isValid) return;

        const data = form.serialize();
        const url = action === 'add' ?
            '<?php echo base_url("client/Client/add_new_bill"); ?>' :
            '<?php echo base_url("client/Client/edit_bill"); ?>';

        $.post(url, data, function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire('Success', res.message, 'success').then(() => {
                    $(modal).modal('hide');
                    loadBills();
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        });
    }

    function openEditModal(id) {
        $.get(`<?php echo base_url("client/Client/get_bill/"); ?>${id}`, function(response) {
            const bill = JSON.parse(response);

            $('#edit_bill_id').val(bill[0].id);
            $('#edit_bill_name').val(bill[0].bill_name);
            $('#edit_due_date').val(bill[0].due_date);
            $('#edit_amount').val(bill[0].amount);
            $('#billsEditModal').modal('show');
        });
    }

    function openDeleteModal(id) {
        $('#delete_bill_id').val(id);
        $('#deleteBillModal').modal('show');
    }


    function deleteBill() {
        const billId = $('#delete_bill_id').val();

        $.ajax({
            url: `<?php echo base_url("client/Client/delete_bill/"); ?>${billId}`,
            method: 'POST',
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire('Deleted', res.message, 'success').then(() => {
                        $('#deleteBillModal').modal('hide');
                        loadBills();
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    }
</script>