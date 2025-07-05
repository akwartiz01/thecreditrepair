<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
        error_reporting(0);

        if ($this->session->userdata('user_id') == '') {
            redirect(base_url());
            exit;
        }

        if ($this->session->userdata('user_type') == 'client') {
            redirect(base_url('client/dashboard'));
            exit;
        }

        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->load->library('TCPDF');
    }

    public function check_permisions($page, $action)
    {

        if (check_permisions($page, $action) == 1) {
            return 1;
        } else {
            $data = array();
            $data['content'] = $this->load->view('admin/permission_error', $data, true);
            $this->load->view('template/template', $data);
        }
    }

    public function invoices()
    {
        error_reporting(0);
        if ($this->check_permisions("invoice", "view") != 1) {
            return false;
        }

        if ($this->input->post('client_name') != '') {
            $condition = "WHERE si.client_id = '" . $this->input->post('client_name') . "'";
        } else {
            //$condition = "Where si.status = 'Pending'";
            $condition = "";
        }
        $data['client_names'] = $this->input->post('client_name');

        //download report
        if ($this->input->post('dreport') == 'filter') {

            $status = $this->input->post('status');
            if ($this->input->post('date') != '') {
                $date = $this->dateconvert($this->input->post('date'));
            } else {
                $date = '';
            }
        }


        $fetchinvoice = $this->User_model->query("SELECT * FROM sq_invoices as si JOIN sq_clients as sc ON si.client_id = sc.sq_client_id " . $condition . "");
        if ($fetchinvoice->num_rows() > 0) {
            $data['fetchinvoice'] = $fetchinvoice->result();
        }

        $fetchallClient = $this->fetchallClient();
        $data['fetchallClient'] = $fetchallClient;

        $fetchClientName = $this->fetchClientName();
        $data['fetchClientName'] = $fetchClientName;

        $data['total_invoiced'] = $this->total_invoiced();
        $data['total_received'] = $this->total_received();
        $data['amount_pay_in_last30day'] = $this->amount_pay_in_last30day();


        $data['ss'] = '';
        $data['content'] = $this->load->view('invoice/view', $data, true);
        $this->load->view('template/template', $data);
    }



    public function create()
    {

        if ($this->check_permisions("invoice", "add") != 1) {
            return false;
        }

        if (isset($_POST['new_invoice'])) {

            $reference = $this->input->post('reference');
            $client_name = $this->input->post('client_name');
            $terms = $this->input->post('terms');
            $invoice_date = $this->input->post('invoice_date');
            $due_date = $this->input->post('due_date');
            $description = $this->input->post('description');
            $for_fueture = $this->input->post('for_fueture');
            $price = $this->input->post('price');
            $invoid = $this->input->post('invoid');
            $initemid = $this->input->post('initemid');

            $get_client_infomm = $this->get_client_info($client_name);


            $data['ref_id']         = $reference;
            $data['client_id']      = $client_name;
            $data['term']           = $terms;
            $data['invoice_date']   = $this->dateconvert($invoice_date);
            $data['due_date']       = $this->dateconvert($due_date);
            $data['status']         = 'Pending';
            $data['type']           = 'Invoice';
            $data['added_by']       = $this->session->userdata('user_id');

            if ($invoid != '') {
                $where['id'] = $invoid;
                $this->User_model->updatedata('sq_invoices', $where, $data);
                $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') invoice updated successfully!'); //track activity
                $message = 'Invoice updated successfully!';
                $last_ID = $invoid;
                $last_ID_for_email = '';
            } else {

                $data['invoice_no']     = date('dhis');
                $this->User_model->insertdata('sq_invoices', $data);
                $last_ID = $this->db->insert_id();
                $last_ID_for_email = $last_ID;
                $message = 'Invoice created successfully!';
                $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') new invoice created successfully!'); //track activity
            }

            foreach ($description as $key => $value) {

                if ($value && $price[$key] != '') {

                    $checkitem = $this->User_model->query("SELECT * FROM sq_invoice_items WHERE id = '" . $initemid[$key] . "'");
                    if ($checkitem->num_rows() > 0) {

                        $this->User_model->query("UPDATE sq_invoice_items SET description = '" . $value . "', for_future = '" . $for_fueture[$key] . "', price = '" . $price[$key] . "' WHERE id = '" . $initemid[$key] . "' ");
                    } else {

                        $this->User_model->query("INSERT INTO `sq_invoice_items`(`invoice_id`, `description`, `for_future`, `price`) VALUES ('" . $last_ID . "', '" . $value . "', '" . $for_fueture[$key] . "', '" . $price[$key] . "')");
                    }
                }
            }

            if ($last_ID_for_email != '') {
                $this->send_invoice_email_to_client($last_ID_for_email);  //send invoice email
            }

            $this->session->set_flashdata('success', $message);
            redirect(base_url() . 'invoices');
        } else {
            $sq_client_id = $this->uri->segment(2);
            $data['sq_client_id'] = get_dencoded_id($sq_client_id);

            $fetchallClient = $this->fetchallClient();
            $data['fetchallClient'] = $fetchallClient;

            $data['totalPay'] = 0;
            $data['ss'] = '';
            $data['content'] = $this->load->view('invoice/index', $data, true);
            $this->load->view('template/template', $data);
        }
    }


    public function send_invoice_email_to_client($invoice_id)
    {
        $fetchinvoice = $this->fetchinvoicebyid($invoice_id);
        $client_id = $fetchinvoice[0]->client_id;
        $get_client_info = $this->get_client_info($client_id);
        $fetchinvoiceItems = $this->fetchinvoiceItems($invoice_id);

        $email = $get_client_info->sq_email;
        $logolink =  base_url() . 'assets/images/logo.png';
        $invoice_message = '';
        $invoice_message .= '<div class="table-responsive"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #ddd;background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px"> Invoice #' . $fetchinvoice[0]->invoice_no . '</td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width: 100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#000;float:right;">' . date('l M d, Y h:i a') . '</p></td></tr><tr><td style="border-radius: 0px;background: #fff;padding: 30px 60px 10px 60px;margin-top: 20px;display: block;"><table style="width:100%;"><tbody><tr style="border-bottom: 1px solid #ddd"><td style="padding-bottom: 15px;font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;" colspan="1"><b>Shipping To </b></td><td style="padding-bottom: 15px;font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;" colspan="1"><b>Billed To </b></td></tr> <tr style="border-bottom: 1px solid #ddd"><td colspan="1"><span style="display:block;max-width: 150px;font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"> CRX Credit Repair D-152 Street Mohali IN 94108 </span></td><td colspan="1"><span style="display:block;max-width: 150px;font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"> ' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . '<br>' . $get_client_info->sq_mailing_address . ' ' . $get_client_info->sq_city . ' ' . $get_client_info->sq_state . ' ' . $get_client_info->sq_zipcode . ' </span></td> </tr><tr><td colspan="2" style="padding-bottom:10px;"></td></tr><tr style="border-bottom: 1px solid #ddd"><td colspan="2" style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;">Status: ' . $fetchinvoice[0]->status . '<br>Invoice Date: ' . date('m/d/Y', strtotime($fetchinvoice[0]->invoice_date)) . '<br>Due Date: ' . date('m/d/Y', strtotime($fetchinvoice[0]->due_date)) . '</td></tr></tbody></table></td></tr><tr><td style="border-radius: 0px;background: #fff;padding: 10px 60px 20px 60px;display: block;"><table style="width: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:solid 1px #ddd;"> <td colspan="2" style="padding-bottom: 10px;font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"> <b>Invoice items list:</b></td></tr>';
        if (isset($fetchinvoiceItems) && is_array($fetchinvoiceItems)) {
            foreach ($fetchinvoiceItems as $valuess) {
                $invoice_message .= '<tr style="border-bottom:solid 1px #ddd;"> <td style="padding-bottom: 10px;font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"> ' . $valuess->description . '</td><td style="text-align: right;font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;text-align: left;color: #001737;">$' . number_format($valuess->price, 2) . '</td></tr>';
            }
        }

        $invoice_message .= '</tbody></table></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td> </tr></tbody></table></td></tr></tbody></table></div>';

        $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');
  
        $this->email->initialize($email_config);
        $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
        $this->email->to($email);
        $this->email->subject('New Invoice Created');
  
        $this->email->message($invoice_message);
        $this->email->send();

        $this->allActivity('Autometic invoice email sent to Client (' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . ')'); //track activity

        return;
    }


    public function edit()
    {

        if ($this->check_permisions("invoice", "edit") != 1) {
            return false;
        }

        $urisegment = $this->uri->segment(2);
        $checkID = base64_decode(urldecode($urisegment));
        $decodedID = number_format(($checkID * 12345) / 12345678);
        $invID = str_replace(',', '', $decodedID);

        //echo $invID;
        if ($invID != '') {

            $invoice_history = $this->User_model->query("SELECT * FROM sq_invoices WHERE id = '" . $invID . "'");
            if ($invoice_history->num_rows() > 0) {
                $invoices_historys = $invoice_history->result();
                $data['invoices_historys'] = $invoices_historys;
            }

            $fetch_preitem = $this->User_model->query("SELECT * FROM sq_invoice_items WHERE invoice_id = '" . $invID . "'");
            if ($fetch_preitem->num_rows() > 0) {
                $data['fetch_preitem'] = $fetch_preitem->result();
            }

            //invoice total payment...
            $fetchtotalpay = $this->User_model->query("SELECT SUM(pay_amount) as totalPay FROM sq_invoice_payment WHERE invoice_no = '" . $invoices_historys[0]->invoice_no . "'");
            if ($fetchtotalpay->num_rows() > 0) {
                $fetchtotalpay = $fetchtotalpay->result();
                $data['totalPay'] = $fetchtotalpay[0]->totalPay;
            } else {
                $data['totalPay'] = 0;
            }

            $fetchallClient = $this->fetchallClient();
            $data['fetchallClient'] = $fetchallClient;

            $data['ss'] = '';
            $data['content'] = $this->load->view('invoice/index', $data, true);
            $this->load->view('template/template', $data);
        }
    }

    public function client_invoices_history()
    {

        $urisegment = $this->uri->segment(2);
        $checkID = base64_decode(urldecode($urisegment));
        $decodedID = number_format(($checkID * 12345) / 12345678);
        $invID = str_replace(',', '', $decodedID);

        if ($invID != '') {

            $invoice_history = $this->User_model->query("SELECT * FROM sq_invoices WHERE id = '" . $invID . "'");
            if ($invoice_history->num_rows() > 0) {

                $invoices_historys = $invoice_history->result();
                foreach ($invoices_historys as $value) {

                    $invoiceID = $value->id;
                    $fetch_all_invoice_item = $this->User_model->query("SELECT SUM(price) as totalprice FROM sq_invoice_items WHERE invoice_id = '" . $invoiceID . "'");
                    $fetch_all_invoice_item = $fetch_all_invoice_item->result();
                    $totalprice = $fetch_all_invoice_item[0]->totalprice;

                    $fetchClientinfo = $this->User_model->select_where('sq_clients', array('sq_client_id' => $value->client_id));
                    if ($fetchClientinfo->num_rows() > 0) {
                        $fetchClientinfo = $fetchClientinfo->result();
                    }

                    //invoice total payment...
                    $fetchtotalpay = $this->User_model->query("SELECT * FROM sq_invoice_payment WHERE invoice_no = '" . $value->invoice_no . "' ORDER BY id DESC");
                    if ($fetchtotalpay->num_rows() > 0) {
                        $fetchtotalpay = $fetchtotalpay->result();
                    }


                    $History_array[] = array(
                        "invoice_id" => $value->id,
                        "invoice_no" => $value->invoice_no,
                        "ref_id" => $value->ref_id,
                        "client_id" => $value->client_id,
                        "term" => $value->term,
                        "invoice_date" => $value->invoice_date,
                        "due_date" => $value->due_date,
                        "status" => $value->status,
                        "type" => $value->type,
                        "added_by" => $value->added_by,
                        "totalprice" => $totalprice,
                    );


                    //for preview...
                    $fetch_all_invoice_preitem = $this->User_model->query("SELECT * FROM sq_invoice_items WHERE invoice_id = '" . $invoiceID . "'");
                    $fetch_all_invoice_preitem = $fetch_all_invoice_preitem->result();
                }

                $data['History_array'] = $History_array;
                $data['totalPay'] = $fetchtotalpay;
                $data['fetchClientinfo'] = $fetchClientinfo;
                $data['preHistory_array'] = $fetch_all_invoice_preitem;
            }

            $data['ss'] = '';
            $data['content'] = $this->load->view('invoice/history', $data, true);
            $this->load->view('template/template', $data);
        }
    }


    public function taskData()
    {
        $this->load->model('User_model');
        $response = ['status' => false, 'message' => ''];

        $task_type = $this->input->post('task_type');
        $subject = $this->input->post('subject');
        $due_date = $this->input->post('due_date');
        $due_time = $this->input->post('due_time');
        $clients = $this->input->post('clients');
        $team_member = $this->input->post('team_member');
        $notes = $this->input->post('notes');
        $sq_client_id = $this->input->post('sq_client_id');

        if (!$task_type || !$subject || !$due_date || !$due_time || !$clients || !$team_member || !$notes) {
            $response['message'] = 'All fields are required!';
            echo json_encode($response);
            return;
        }

        $data = [
            'task_type'        => $task_type,
            'task_status'      => 'Pending',
            'subject'          => $subject,
            'due_date'         => date("Y-m-d", strtotime($due_date)),
            'due_time'         => $due_time,
            'sq_client_id'     => $sq_client_id,
            'team_member_id'   => $team_member,
            'clients'          => $clients,
            'teams'            => $team_member,
            'notes'            => $notes,
            'added_by'         => $this->session->userdata('user_id'),
            'datetime'         => date('Y-m-d H:i:s')
        ];

        if ($this->User_model->insertdata('sq_task', $data)) {
            $this->allActivity('New task added successfully!');
            $response = ['status' => true, 'message' => 'Task added successfully!'];
        } else {
            $response['message'] = 'Failed to add the task.';
        }

        echo json_encode($response);
    }

    public function update_task_status()
    {
        $task_id = $this->input->post('task_id');
        $status = $this->input->post('status');

        if (!$task_id || !$status) {
            echo json_encode(['status' => false, 'message' => 'Invalid data']);
            return;
        }

        $updated_data = ['task_status' => $status];
        $this->db->where('id', $task_id);
        if ($this->db->update('sq_task', $updated_data)) {
            echo json_encode(['status' => true, 'message' => 'Task status updated successfully!']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update task status.']);
        }
    }


    public function getTaskData()
    {
        $task_id = $this->input->post('task_id');
        $query = $this->db->get_where('sq_task', ['id' => $task_id]);
        $task = $query->row_array();

        // echo "<pre>";
        // print_r($task);
        // echo "<pre>";
        // die('STOP');

        if ($task) {
            echo json_encode(['status' => true, 'data' => $task]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Task not found.']);
        }
    }

    public function editTask()
    {
        $task_id = $this->input->post('task_id');
        $task_data = [
            'task_type'  => $this->input->post('task_type'),
            'subject'    => $this->input->post('subject'),
            'due_date'   => date("Y-m-d", strtotime($this->input->post('due_date'))),
            'due_time'   => $this->input->post('due_time'),
            'clients'    => $this->input->post('clients'),
            'team_member_id' => $this->input->post('team_member'),
            'notes'      => $this->input->post('notes'),
        ];

        $this->db->where('id', $task_id);
        $update = $this->db->update('sq_task', $task_data);

        if ($update) {
            echo json_encode(['status' => true, 'message' => 'Task updated successfully!']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update task.']);
        }
    }

    public function deleteTask()
    {
        $task_id = $this->input->post('task_id');
        $this->db->where('id', $task_id);
        $delete = $this->db->delete('sq_task');

        if ($delete) {
            echo json_encode(['status' => true, 'message' => 'Task deleted successfully!']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to delete task.']);
        }
    }




    public function invoicePayment()
    {

        $invoice_no         = $this->input->post('invoice_no');
        $pay_date           = $this->dateconvert($this->input->post('pay_date'));
        $pay_amt            = $this->input->post('pay_amt');
        $pay_description    = $this->input->post('pay_description');
        $pay_total          = $this->input->post('pay_total');

        if (($pay_amt > 0) && ($pay_amt <= $pay_total)) {

            if ($pay_amt == $pay_total) {
                $inv_status = 'Paid';
            } else {
                $inv_status = 'Pending';
            }
            $this->User_model->updatedata('sq_invoices', array('invoice_no' => $invoice_no), array('status' => $inv_status));

            //for invoice payment table...
            $data['invoice_no'] = $invoice_no;
            $data['pay_date'] = $pay_date;
            $data['type'] = 'Payments received';
            $data['pay_amount'] = $pay_amt;
            $data['description'] = $pay_description;
            $data['date'] = date('Y-m-d');
            $this->User_model->insertdata('sq_invoice_payment', $data);
            $this->allActivity('Invoice (#' . $invoice_no . ') payment added successfully!'); //track activity
            echo '1';
        } else {
            echo '2';
        }
    }

    public function UpdateinvoicePayment()
    {

        $rowid              = $this->input->post('rowid');
        $invoice_no         = $this->input->post('invoice_no');
        $pay_date           = $this->dateconvert($this->input->post('pay_date'));
        $pay_amt            = $this->input->post('pay_amt');
        $pay_description    = $this->input->post('pay_description');
        $totalPrice         = $this->input->post('totalPrice');

        $fetchtoalinvoicepay = $this->User_model->query("SELECT SUM(pay_amount) as amount FROM sq_invoice_payment WHERE invoice_no = '" . $invoice_no . "' AND id != '" . $rowid . "'");
        if ($fetchtoalinvoicepay->num_rows() > 0) {
            $fetchtoalinvoicepay = $fetchtoalinvoicepay->result();
            $amountsss = $fetchtoalinvoicepay[0]->amount;
            $amountPAY = $amountsss + $pay_amt;
        } else {
            $amountPAY = $pay_amt;
        }

        if ($amountPAY > $totalPrice) {

            echo '2';
        } else {

            if ($amountPAY == $totalPrice) {
                $status = 'Paid';
            } else {
                $status = 'Pending';
            }

            $this->User_model->updatedata('sq_invoices', array('invoice_no' => $invoice_no), array('status' => $status));

            //for invoice payment table...
            $data['invoice_no'] = $invoice_no;
            $data['pay_date'] = $pay_date;
            $data['type'] = 'Payments received';
            $data['pay_amount'] = $pay_amt;
            $data['description'] = $pay_description;
            $where['id'] = $rowid;
            $this->User_model->updatedata('sq_invoice_payment', $where, $data);
            $this->allActivity('Invoice (#' . $invoice_no . ') payment updated successfully!'); //track activity
            echo '1';
        }
    }

    public function editinvoicePayment()
    {

        $id = $this->input->post('rowID');
        $fetchpayment = $this->User_model->select_where('sq_invoice_payment', array('id' => $id));
        $fetchpayment = $fetchpayment->row();

        echo json_encode($fetchpayment);
    }

    public function deleteInvoices()
    {

        $id = $this->input->post('id');
        if ($id != '') {
            $this->User_model->query("DELETE FROM sq_invoices where id = '" . $id . "' ");
            $this->User_model->query("DELETE FROM sq_invoice_items where invoice_id = '" . $id . "' ");
            $this->allActivity('Invoice removed successfully!'); //track activity
            echo '1';
        }
    }

    public function deleteItem()
    {

        $id = $this->input->post('id');
        if ($id != '') {
            $this->User_model->query("DELETE FROM sq_invoice_items where id = '" . $id . "' ");
            echo '1';
        }
    }


    public function invoice_pdf()
    {

        $urisegment = $this->uri->segment(3);
        $checkID = base64_decode(urldecode($urisegment));
        $decodedID = number_format(($checkID * 12345) / 12345678);
        $invID = str_replace(',', '', $decodedID);

        if ($invID != '') {

            $fetchinvoicebyid = $this->fetchinvoicebyid($invID);
            $fetchinvoiceItems = $this->fetchinvoiceItems($invID);
            $get_client_info = $this->get_client_info($fetchinvoicebyid[0]->client_id);
            $fetchinvoicepayments = $this->fetchinvoicepayments($fetchinvoicebyid[0]->invoice_no);

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetHeaderData("include/logo-sc.png", 20, '', '');
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10, 20, 10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
            $pdf->SetFont('times', '', 7);
            $pdf->AddPage('M', 'A4');


            $header = '<br>';
            $header .= '<div style="background-color:#336699;color:white;width:100%;font-size:15px;">&nbsp;<b>Invoice #: ' . $fetchinvoicebyid[0]->invoice_no . '</b><br></div>';
            $header .= '<br>';
            $header .= '<table border="0" cellpadding="2" cellspacing="2" style="font-size:13px;">
                         
                         <tr nobr="true">
                          <td align="left"><b>CRX Credit Repair</b></td>
                          <td align="right"><b>Invoice to</b></td>
                         </tr>
                         <tr nobr="true">
                          <td align="left">D-151</td>
                          <td align="right">' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . '</td>
                         </tr>
                         <tr nobr="true">
                          <td align="left">Phase-8</td>
                          <td align="right">' . $get_client_info->sq_mailing_address . '</td>
                         </tr>
                         <tr nobr="true">
                          <td align="left">Mohali, Punjab 160059</td>
                          <td align="right">' . $get_client_info->sq_city . ' ' . $get_client_info->sq_state . ' ' . $get_client_info->sq_zipcode . '</td>
                         </tr>
                         <tr nobr="true">
                          <td colspan="2"></td>
                         </tr>
                         <tr nobr="true">
                          <td colspan="2">Status: ' . $fetchinvoicebyid[0]->status . '</td>
                         </tr>
                         <tr nobr="true">
                          <td colspan="2">Invoice Date: ' . date('m/d/Y', strtotime($fetchinvoicebyid[0]->invoice_date)) . '<br>Due Date: ' . date('m/d/Y', strtotime($fetchinvoicebyid[0]->due_date)) . '</td>
                         </tr>
                        </table>';
            $header .= '<p><br></p>';
            $header .= '<table border="0" cellpadding="2" cellspacing="0" style="font-size:13px;">
                         <tr nobr="true" style="background-color:#336699;color:white;">
                          <td><b>Description</b></td>
                          <td><b>Invoiced</b></td>
                          <td><b>Paid</b></td>
                         </tr>';

            $totalitem = 0;
            if (isset($fetchinvoiceItems) && is_array($fetchinvoiceItems)) {
                foreach ($fetchinvoiceItems as $value) {

                    $totalitem += $value->price;

                    $header .=  '<tr nobr="true">
                                              <td>' . $value->description . '</td>
                                              <td>$' . $value->price . '</td>
                                              <td></td>
                                             </tr>';
                }
            }

            $totalpaid = 0;
            if (isset($fetchinvoicepayments) && is_array($fetchinvoicepayments)) {
                foreach ($fetchinvoicepayments as $value) {

                    $totalpaid += $value->pay_amount;

                    $header .=  '<tr nobr="true">
                                              <td>Paid on ' . date('m/d/Y', strtotime($value->pay_date)) . '</td>
                                              <td></td>
                                              <td>$' . $value->pay_amount . '</td>
                                             </tr>';
                }
            }

            $header .= '<tr nobr="true"><td colspan="3"></td></tr>';
            $header .= '<tr nobr="true"><td colspan="3"></td></tr>';

            $header .= '<tr nobr="true">
                          <td colspan="3" align="right;">Invoiced total amount: $' . number_format($totalitem) . '</td>
                        </tr>';
            $header .= '<tr nobr="true">
                          <td colspan="3" align="right;"><b>Paid total amount: $' . number_format($totalpaid) . '</b></td>
                        </tr>';

            $header .=  '</table>';

            $pdf->WriteHTML($header);
            $pdf->Output('invoice.pdf', 'D');
        }
    }

    public function fetchallClient()
    {

        $fetchClient = $this->User_model->select_star('sq_clients');
        if ($fetchClient->num_rows() > 0) {
            $fetchClients = $fetchClient->result();
            return $fetchClients;
        }
    }

    public function fetchClientName()
    {

        $fetchClient = $this->User_model->select_star('sq_clients');
        if ($fetchClient->num_rows() > 0) {
            $fetchClients = $fetchClient->result();
            foreach ($fetchClients as $value) {
                $allnames[$value->sq_client_id] = $value->sq_first_name . ' ' . $value->sq_last_name;
            }
            return $allnames;
        }
    }


    public function dateconvert($date)
    {

        return date('Y-m-d', strtotime($date));
    }
}
