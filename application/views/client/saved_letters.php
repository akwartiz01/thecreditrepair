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

</style>

<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">Saved Letters</h3>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table custom-table mb-0 w-100 save_letters" id="save_letters">

                                <thead>

                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Letter Name</th>
                                        <th class="text-center">Created Date</th>
                                        <th class="text-center">Action</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <?php
                                    $sr_no = 1;
                                    if (!empty($saved_letters)):
                                        foreach ($saved_letters as $key => $value): ?>
                                            <tr>
                                                <td class="text-center"><?php echo $sr_no++; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($value->letter_name); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($value->created_at); ?></td>
                                                <td class="text-center">
                                                    <a href="#" title="Preview" class="text-primary openPrintPreview"
                                                        data-toggle="modal" data-target="#printModal"
                                                        data-letter-content="<?php echo htmlspecialchars($value->client_letter); ?>" data-letter-date="<?php echo htmlspecialchars($value->created_at); ?>">
                                                        <!-- <i class="fas fa-eye"></i> -->
                                                        Preview
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Print Modal s -->

<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Preview letter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div id="print-content">
                    <div id="letter_content"></div>
                    <p>Date: <span id="modal-date"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printDiv('print-content')">Print</button>
            </div>
        </div>
    </div>
</div>
<!-- Print Modal e -->


<!-- Initialize DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.6/purify.min.js"></script>
<script>
    $(document).ready(function() {
        $('#save_letters').DataTable({
            "paging": true,
            "searching": true,
            "info": true
        });
    });
</script>

<script>
    var signatureUrl = "<?php echo $client_result->agreement_sign; ?>";

    $(document).on('click', '.openPrintPreview', function() {
        var letterContent = $(this).data('letter-content');
        var letterDate = $(this).data('letter-date');
        $('#modal-date').text(letterDate);
        var signatureBoxContent = "";

        // Check if there's a saved signature URL
        if (signatureUrl) {
            // Prepare signatureBox content
            signatureBoxContent = '<img src="' + signatureUrl + '" alt="Saved Signature" id="img-signature">';
            console.log()
        }

        // Replace `{client_signature}` in letterContent with signatureBoxContent
        if (letterContent.includes("{client_signature}")) {
            letterContent = letterContent.replace("{client_signature}", signatureBoxContent);
        }

        // Set the updated content to the preview container
        $('#letter_content').html(letterContent);
    });

    function printDiv(divId) {
        var divToPrint = document.getElementById(divId).innerHTML;
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + divToPrint + '</body></html>');
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 10);
    }
</script>