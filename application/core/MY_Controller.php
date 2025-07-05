<?php
defined('BASEPATH') or exit('No direct script access allowed');



class MY_Controller extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if ($this->session->userdata('user_id') == '') {
            redirect(base_url());
            exit;
        }

        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->load->library('email');
    }

    public function send_email_template($to, $from, $subject, $message, $bcc = 0)
    {
        $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');
  
        $this->email->initialize($email_config);
        $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
        $this->email->to($to);
        $this->email->subject($subject);
  
        $this->email->message($message);
        $this->email->send();


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

    public function get_login_user_info($loginID)
    {

        $fetch_user = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_id` = '" . $loginID . "'");
        $fetch_user = $fetch_user->row();
        return $fetch_user;
    }

    public function get_client_info($clientID)
    {

        $fetch_clients = $this->User_model->query("SELECT * FROM `sq_clients` WHERE `sq_client_id` = '" . $clientID . "'");
        $fetch_clients = $fetch_clients->row();
        return $fetch_clients;
    }

    public function GetAutoEmailTemp()
    {

        $data = array();
        $fetch_etemp = $this->User_model->select_star('sq_auto_email_templates');
        $fetch_etemp = $fetch_etemp->result();
        foreach ($fetch_etemp as $key => $value) {
            $data[$value->temp_for][] = $value;
        }
        return $data;
    }

    public function get_allclients_name()
    {

        $fetch_clients = $this->User_model->query("SELECT * FROM `sq_clients`");
        $fetch_clients = $fetch_clients->result();
        foreach ($fetch_clients as $value) {
            $datas[$value->sq_client_id] = $value->sq_first_name . ' ' . $value->sq_last_name;
        }
        return $datas;
    }

    public function get_allaffiliate_name()
    {
        $datas = array();
        $fetch_sq_affiliates = $this->User_model->query("SELECT * FROM `sq_affiliates`");
        $fetch_sq_affiliates = $fetch_sq_affiliates->result();
        foreach ($fetch_sq_affiliates as $value) {
            $datas[$value->sq_affiliates_id] = $value->sq_affiliates_first_name . ' ' . $value->sq_affiliates_last_name;
        }
        return $datas;
    }


    public function get_allaffiliate_company()
    {
        $datas = array();
        $fetch_sq_affiliates = $this->User_model->query("SELECT * FROM `sq_affiliates`");
        $fetch_sq_affiliates = $fetch_sq_affiliates->result();
        foreach ($fetch_sq_affiliates as $value) {
            $datas[$value->sq_affiliates_id] = $value->sq_affiliates_company;
        }
        return $datas;
    }



    public function get_affiliate_info($affid)
    {

        $fetch_sq_affiliates = $this->User_model->query("SELECT * FROM `sq_affiliates` WHERE sq_affiliates_id = '" . $affid . "'");
        $fetch_sq_affiliates = $fetch_sq_affiliates->result();

        return $fetch_sq_affiliates;
    }

    public function get_allusers_name()
    {

        $fetch_clients = $this->User_model->query("SELECT * FROM `sq_users`");
        $fetch_clients = $fetch_clients->result();
        foreach ($fetch_clients as $value) {
            $datas[$value->sq_u_id] = $value->sq_u_first_name . ' ' . $value->sq_u_last_name;
        }
        return $datas;
    }

    public function total_invoiced($clientID = "")
    {

        if ($clientID != '') {

            $fetchinvoice = $this->User_model->query("SELECT * FROM `sq_invoices` WHERE client_id = '" . $clientID . "'");
            if ($fetchinvoice->num_rows() > 0) {
                $fetchinvoice = $fetchinvoice->result();
                $invoiceID = $fetchinvoice[0]->id;

                $fetchtotal = $this->User_model->query("SELECT SUM(price) as total FROM `sq_invoice_items` WHERE invoice_id = '" . $invoiceID . "'");
                if ($fetchtotal->num_rows() > 0) {
                    $fetchtotal = $fetchtotal->result();
                    $total = $fetchtotal[0]->total;
                } else {
                    $total = 0;
                }
            } else {
                $total = 0;
            }

            return $total;
        } else { //main else part

            $fetchtotal = $this->User_model->query("SELECT SUM(price) as total FROM `sq_invoice_items`");
            if ($fetchtotal->num_rows() > 0) {
                $fetchtotal = $fetchtotal->result();
                $total = $fetchtotal[0]->total;
            } else {
                $total = 0;
            }
            return $total;
        }
    }

    public function total_received($clientID = "")
    {

        if ($clientID != '') {

            $fetchinvoice = $this->User_model->query("SELECT * FROM `sq_invoices` WHERE client_id = '" . $clientID . "'");
            if ($fetchinvoice->num_rows() > 0) {
                $fetchinvoice = $fetchinvoice->result();
                $invoice_no = $fetchinvoice[0]->invoice_no;

                $fetchreceived = $this->User_model->query("SELECT SUM(`pay_amount`) as totalamt FROM `sq_invoice_payment` WHERE invoice_no = '" . $invoice_no . "'");
                if ($fetchreceived->num_rows() > 0) {
                    $fetchreceived = $fetchreceived->result();
                    $totalamt = $fetchreceived[0]->totalamt;
                } else {
                    $totalamt = 0;
                }
                return $totalamt;
            } else {
                $totalamt = 0;
            }

            return $totalamt;
        } else { //main else part

            $fetchreceived = $this->User_model->query("SELECT SUM(`pay_amount`) as totalamt FROM `sq_invoice_payment`");
            if ($fetchreceived->num_rows() > 0) {
                $fetchreceived = $fetchreceived->result();
                $totalamt = $fetchreceived[0]->totalamt;
            } else {
                $totalamt = 0;
            }
            return $totalamt;
        }
    }

    public function amount_pay_in_last30day()
    {

        $currentdate = date('Y-m-d');
        $last30days = date('Y-m-d', strtotime('-30 days' . $currentdate));

        $fetchreceived = $this->User_model->query("SELECT SUM(`pay_amount`) as totalamt FROM `sq_invoice_payment` WHERE date BETWEEN '" . $last30days . "' AND '" . $currentdate . "'");
        if ($fetchreceived->num_rows() > 0) {
            $fetchreceived = $fetchreceived->result();
            $totalamt = $fetchreceived[0]->totalamt;
        } else {
            $totalamt = 0;
        }
        return $totalamt;
    }

    public function fetch_all_docName()
    {

        $fetchdoc = $this->User_model->select_star('sq_document');
        $fetchdoc = $fetchdoc->result();
        return $fetchdoc;
    }


    public function fetchinvoicebyid($invoiceID)
    {

        $invoice_history = $this->User_model->query("SELECT * FROM sq_invoices WHERE id = '" . $invoiceID . "'");
        $invoices_historys = $invoice_history->result();
        return $invoices_historys;
    }

    public function fetchinvoiceItems($invoiceID)
    {

        $invoice_historyi = $this->User_model->query("SELECT * FROM sq_invoice_items WHERE invoice_id = '" . $invoiceID . "'");
        $invoice_historyi = $invoice_historyi->result();
        return $invoice_historyi;
    }

    public function fetchinvoicepayments($invoiceNO)
    {

        $invoice_historyp = $this->User_model->query("SELECT * FROM sq_invoice_payment WHERE invoice_no = '" . $invoiceNO . "'");
        $invoice_historyp = $invoice_historyp->result();
        return $invoice_historyp;
    }


    public function fetchClientscore($clientID)
    {

        $fetchscore = $this->User_model->select_where('sq_score', array('client_id' => $clientID));
        if ($fetchscore->num_rows() > 0) {
            $fetchscore = $fetchscore->result();
            return $fetchscore;
        } else {
            return;
        }
    }

    public function getfurnisherNames()
    {

        $fetchdata = $this->User_model->select_star('sq_furnisher');
        if ($fetchdata->num_rows() > 0) {
            $fetchdata = $fetchdata->result();
            foreach ($fetchdata as $value) {

                $allname[$value->id] = $value->company_name;
            }
        }

        return $allname;
    }


    public function getallfurnisher()
    {

        $fetchdata = $this->User_model->select_star('sq_furnisher');
        if ($fetchdata->num_rows() > 0) {
            $fetchdata = $fetchdata->result();
        } else {
            $fetchdata = '';
        }

        return $fetchdata;
    }


    public function getalldisputeItem($clientID)
    {

        $fetchdata = $this->User_model->select_where('sq_dispute_item', array('client_id' => $clientID));
        if ($fetchdata->num_rows() > 0) {
            $fetchdata = $fetchdata->result();
        } else {
            $fetchdata = '';
        }

        return $fetchdata;
    }


    public function allActivity($msg)
    {

        $loginID = $this->session->userdata('user_id');
        $datetime = date('Y-m-d H:i:s a');

        $data['user_id']        = $loginID;
        $data['msg']            = $msg;
        $data['datetime']       = $datetime;
        $this->User_model->insertdata('sq_all_activity', $data);

        // New added 14-11-2024 s
        $fetch_users = $this->User_model->select_star('sq_users');

        if ($fetch_users->num_rows() > 0) {

            $fetch_users = $fetch_users->result();

            foreach ($fetch_users as $key => $value) {
                $datetime = date('Y-m-d H:i:s a');

                $notification_data['sender_id']        = $loginID;
                $notification_data['receiver_id']        = $value->sq_u_id;
                $notification_data['read_status']        = 0;
                $notification_data['msg']            = $msg;
                $notification_data['created_at']       = $datetime;

                $this->User_model->insertdata('notifications', $notification_data);
            }
        }
        // New added 14-11-2024 e

        return;
    }
}
