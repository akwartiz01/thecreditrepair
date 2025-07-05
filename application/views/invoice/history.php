<?php
$totoalPayamt = 0;
if (isset($totalPay) && is_array($totalPay)) {
  foreach ($totalPay as $value) {
    $totoalPayamt += $value->pay_amount;
  }
}

?>
<style type="text/css">
  #previewModal .modal-dialog .modal-content .modal-body {
    padding: 0px 20px 0px 20px;
  }

  #EditModal .modal-dialog .modal-content .modal-body {
    padding: 0px 26px 0px 26px;
  }

  #previewModal .modal-dialog .modal-content .modal-header {
    padding: 15px 35px !important;
  }

  @media screen and (max-width: 767px) {
    #previewModal .modal-dialog {
      max-width: 100% !important;
    }
  }
</style>
<?php if ($this->session->flashdata('success')) { ?>
  <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
      <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
        <div class="swal-icon--success__ring"></div>
        <div class="swal-icon--success__hide-corners"></div>
      </div>
      <div class="swal-title" style="">Client added!</div>
      <div class="swal-text" style=""><?php echo $this->session->flashdata('success'); ?></div>
      <div class="swal-footer">
        <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button>
          <div class="swal-button__loader">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<div id="msgAppend1234"></div>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Invoices & Payments </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Payments</li>
          </ol>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-8">

            </div>

            <div class="col-4" style="text-align: right; margin-bottom: 24px;">
              <a href="<?php echo base_url(); ?>add">
                <button type="button" class="btn btn-gradient-primary btn-icon-text btn-sm"> <i class="mdi mdi-plus btn-icon-prepend"></i> Create Invoice </button>
              </a>
            </div>
          </div>

          <div class="row mt-4">

            <div class="col-md-4">
              <label>Client name: <?php echo $fetchClientinfo[0]->sq_first_name . ' ' . $fetchClientinfo[0]->sq_last_name; ?></label>
            </div>
            <div class="col-md-4">
              <label>Status: Client</label>
            </div>
            <div class="col-md-4">
              <!-- <label>Total outstanding: $0</label> -->
            </div>
            <div class="col-md-4 mt-2">
              <label>Phone: <?php echo $fetchClientinfo[0]->sq_phone_home; ?></label>
            </div>
            <div class="col-md-4 mt-2">
              <label>Email: <?php echo $fetchClientinfo[0]->sq_email; ?></label>
            </div>
            <div class="col-md-4 mt-2">
              <!-- <label>Past due: $0</label> -->
            </div>
            <div class="col-md-4 mt-2">
              <label>Referred by:</label>
            </div>
            <div class="col-md-4 mt-2">
              <label>Assigned to:</label>
            </div>
            <div class="col-md-4 mt-2">
              <!-- <label>Paid in last 30 days: $0</label> -->
            </div>

          </div>

          <div class="row mt-4">
            <div class="col-md-12 table-responsive">
              <table id="order-listing" class="table jsgrid">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Invoice No.</th>
                    <th>Type</th>
                    <th>Due Date</th>
                    <th>Balance</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!---------------- Invoice Payment rows ------------------->
                  <?php if (isset($totalPay) && is_array($totalPay)) {
                    foreach ($totalPay as $value) { ?>

                      <tr>
                        <td><?php echo date('m/d/Y', strtotime($value->pay_date)); ?></td>
                        <td><a class="text-success" href="#"><?php echo $value->invoice_no; ?></a></td>
                        <td><?php echo $value->type; ?></td>
                        <td></td>
                        <td></td>
                        <td>$<?php echo $value->pay_amount; ?></td>
                        <td></td>
                        <td>
                          <a onclick="editPayments(this,'<?php echo $value->id; ?>');" title="Edit Payment" class="mr-2">Edit</a>
                        </td>
                      </tr>

                  <?php }
                  } ?>
                  <!---------------- Invoice Payment rows end ------------------->
                  <?php if (isset($History_array) && is_array($History_array)) {
                    foreach ($History_array as $row) {

                      if ($row['status'] == 'Pending') {
                        $class = 'badge badge-gradient-danger';
                      } else {
                        $class = 'badge badge-gradient-success';
                      }

                  ?>
                      <tr>
                        <td><?php echo date('m/d/Y', strtotime($row['invoice_date'])); ?></td>
                        <td><a class="text-success" href="#"><?php echo $row['invoice_no']; ?></a></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo date('m/d/Y', strtotime($row['due_date'])); ?></td>
                        <td>$<?php echo $row['totalprice'] - $totoalPayamt; ?></td>
                        <td>$<?php echo $row['totalprice']; ?></td>
                        <td><span class="<?php echo $class; ?>"><?php echo $row['status']; ?></span></td>
                        <td>
                          <!-- <a href="#" title="Record Payment" class="mr-2">Record Payment</a> -->
                          <?php if ($row['status'] == 'Pending') { ?>
                            <a href="<?php echo base_url(); ?>edit/<?php echo base64_encode(urlencode(($row['invoice_id'] * 12345678) / 12345)); ?>" title="More Actions" class="mr-2">More Actions</a>
                          <?php } ?>
                          <a data-toggle="modal" data-target="#previewModal" data-whatever="@mdo" class="mr-2">Preview</a>
                        </td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="8">No invoice item found!</td>
                    </tr>
                  <?php } ?>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!------------------ previewModal --------------------->
    <div class="modal fade show" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" style="display: none;" aria-modal="true">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 65%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">View Invoice</h5>
            <button type="button" id="cltbtn" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="col-lg-3 pl-0">
                  <p class="mb-2"><b>Square One Credit</b></p>
                  <p>D-151,<br>Phase-8,<br>Mohali, Punjab 160059</p>
                </div>
                <div class="col-lg-3 pr-0">
                  <p class="mb-2 text-right"><b>Invoice to</b></p>
                  <p class="text-right"><?php echo $fetchClientinfo[0]->sq_first_name . ' ' . $fetchClientinfo[0]->sq_last_name; ?>,<br><?php echo $fetchClientinfo[0]->sq_mailing_address; ?>,<br><?php echo $fetchClientinfo[0]->sq_city . ' ' . $fetchClientinfo[0]->sq_state . ' ' . $fetchClientinfo[0]->sq_zipcode; ?></p>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div class="col-lg-3 pl-0">
                  <p class="mb-0 mt-3">Status: <?php echo $History_array[0]['status']; ?></p>
                  <p class="mb-0">Invoice Date: <?php echo date('m/d/Y', strtotime($History_array[0]['invoice_date'])); ?></p>
                  <p>Due Date: <?php echo date('m/d/Y', strtotime($History_array[0]['due_date'])); ?></p>
                </div>
              </div>
              <div class="mt-3 d-flex justify-content-center">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr class="bg-dark text-white">

                        <th>Description</th>
                        <th class="text-right">Invoiced</th>
                        <th class="text-right">Paid</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $totalpriceval = 0;
                      if (isset($preHistory_array) && is_array($preHistory_array)) {
                        foreach ($preHistory_array as $row) {
                          $totalpriceval += $row->price;
                      ?>
                          <tr class="text-right">
                            <td class="text-left"><?php echo $row->description; ?></td>
                            <td>$<?php echo number_format($row->price); ?></td>
                            <td></td>
                          </tr>
                      <?php }
                      } ?>

                      <!---------------- Invoice Payment rows ------------------->
                      <?php
                      $totalPayamts = 0;
                      if (isset($totalPay) && is_array($totalPay)) {
                        foreach ($totalPay as $value) {
                          $totalPayamts += $value->pay_amount;
                      ?>

                          <tr class="text-right">
                            <td class="text-left">Paid on <?php echo date('m/d/Y', strtotime($value->pay_date)); ?></td>
                            <td></td>
                            <td>$<?php echo number_format($value->pay_amount); ?></td>
                          </tr>

                      <?php }
                      } ?>
                      <!---------------- Invoice Payment rows end ------------------->

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="mt-3 w-100">
                <p class="text-right mb-2">Invoiced total amount: $<?php echo number_format($totalpriceval); ?></p>
                <!-- <p class="text-right">vat (10%) : $138</p> -->
                <h4 class="text-right mb-2">Paid total amount: $<?php echo number_format($totalPayamts); ?></h4>
              </div>
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" id="ptbtn" class="btn btn-success btn-sm print_button">Print</button>
            <a href="<?php echo base_url(); ?>Invoices/invoice_pdf/<?php echo $this->uri->segment(2); ?>" type="button" id="clbtn" class="btn btn-success btn-sm">PDF</a>
            <!-- <button type="button" class="btn btn-light" data-dismiss="modal">Close</button> -->
          </div>
        </div>
      </div>
    </div>
    <!---------------- previewModal ----------------------->

    <!---------------- payment edit Modal ----------------------->
    <div class="modal fade show" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" style="display: none;" aria-modal="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel"><b>Edit Payment</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

            <input type="hidden" id="rowid" value="">
            <input type="hidden" id="invoice_no1" value="">
            <input type="hidden" id="totalPrice" value="<?php echo $totalpriceval; ?>">
            <div class="row mb-1">
              <div class="col-4">
                <label>Invoice #:</label>
              </div>
              <div class="col-8">
                <span id="invoice_no" style="font-size: 14px;"></span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-4">
                <label>Date:</label>
              </div>
              <div class="col-8">
                <input type="text" id="pay_date" class="form-control datepicker" autocomplete="off" value="">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <label>Amount paid:</label>
              </div>
              <div class="col-8">
                <input type="text" id="pay_amt" class="form-control number_only amount" autocomplete="off" value="">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <label>Description:</label>
              </div>
              <div class="col-8">
                <textarea id="pay_description" class="form-control" rows="4"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="UpdatePayment(this);" class="btn btn-success btn-sm">Update</button>
            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!---------------- payment edit Modal ----------------------->
    <!-- content-wrapper ends -->
    <script type="text/javascript">
      $("body").on("click", ".print_button", function() {
        var prtContent = document.getElementById("previewModal");
        var style = document.getElementById("sqhead");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=570,toolbar=0,scrollbars=0,status=0');

        WinPrint.document.write(style.innerHTML + '<style>#ptbtn{display:none !important;}#clbtn{display:none !important;} #cltbtn{display:none !important;}</style> ' + prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.onafterprint = function() {
          WinPrint.close();
        }
      });



      function closeSuccessModal() {
        $('#pDsuccess').css('display', 'none');
        $('#pDMsuccess').css('display', 'none');

      }

      function editPayments(that, rowID) {

        $('html, body').animate({
          scrollTop: 0
        }, 'slow');

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Invoices/editinvoicePayment"; ?>',
          data: {
            'rowID': rowID
          },
          success: function(response) {

            var data = JSON.parse(response);

            var newdate = dateconvert(data.pay_date);

            $('#EditModal input#rowid').val(data.id);
            $('#EditModal span#invoice_no').text(data.invoice_no);
            $('#EditModal input#invoice_no1').val(data.invoice_no);
            $('#EditModal input#pay_date').val(newdate);
            $('#EditModal input#pay_amt').val(data.pay_amount);
            $('#EditModal textarea#pay_description').val(data.description);

            $('#EditModal').modal('show');
            //$( "#pay_date" ).datepicker({ dateFormat: 'mm-dd-yy' });
          }

        })
      }

      function dateconvert(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
          day = "0" + day;
        }
        if (month < 10) {
          month = "0" + month;
        }
        var date = month + "/" + day + "/" + year;

        return date;
      }

      function UpdatePayment(that) {

        var rowid = $('#EditModal input#rowid').val();
        var invoice_no = $('#EditModal input#invoice_no1').val();
        var pay_date = $('#EditModal input#pay_date').val();
        var pay_amt = $('#EditModal input#pay_amt').val();
        var pay_description = $('#EditModal textarea#pay_description').val();
        var totalPrice = $('#EditModal input#totalPrice').val();

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() . "Invoices/UpdateinvoicePayment"; ?>',
          data: {
            'rowid': rowid,
            'invoice_no': invoice_no,
            'pay_date': pay_date,
            'pay_amt': pay_amt,
            'pay_description': pay_description,
            'totalPrice': totalPrice
          },
          success: function(response) {

            if (response == '1') {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span><div class="swal-icon--success__ring"></div><div class="swal-icon--success__hide-corners"></div></div><div class="swal-title" style="">Invoice Payment!</div><div class="swal-text" style="">Invoice payment updated successfully</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNew11114();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend1234').after(succesMsg);

            } else {

              var succesMsg = '<div id="pDsuccess11" class="swal-overlay swal-overlay--show-modal" tabindex="-1"><div id="pDMsuccess11" class="swal-modal" role="dialog" aria-modal="true"><div class="swal-icon swal-icon--warning"><span class="swal-icon--warning__body"><span class="swal-icon--warning__dot"></span></span></div><div class="swal-title" style="">Invoice Payment Error!</div><div class="swal-text" style="">Something is wrong!</div><div class="swal-footer"><div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModalNew11114();">Close</button><div class="swal-button__loader"><div></div><div></div><div></div> </div></div></div></div></div>';

              $('#msgAppend1234').after(succesMsg);

            }

          }
        });
      }

      function closeSuccessModalNew11114() {
        $('#pDsuccess11').css('display', 'none');
        $('#pDMsuccess11').css('display', 'none');

        location.reload();
      }
    </script>