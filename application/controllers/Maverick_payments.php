<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maverick_payments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Maverick_payment_gateway');
    }

    public function index()
    {
        $amount = $this->input->post('amount');
        $ccnumber = $this->input->post('ccnumber');
        $ccexp = $this->input->post('ccexp');
        $cvv = $this->input->post('cvv');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        $result = $this->maverick_payment_gateway->doSale($amount, $ccnumber, $ccexp, $cvv);

        if ($result == APPROVED) {
            $response = ['success' => true, 'message' => 'Your payment was successful!'];
        } elseif ($result == DECLINED) {
            $response = ['success' => false, 'message' => 'Declined!'];
        } else {
            $response = ['success' => false, 'message' => 'Error!'];
        }

        echo json_encode($response);
    }

    public function index1()
    {
        $amount = $this->input->post('amount');
        $ccnumber = $this->input->post('ccnumber');
        $ccexp = $this->input->post('ccexp');
        $cvv = $this->input->post('cvv');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        // Example for Recurring Payment
        $result = $this->gwapi->doRecurring($amount, $ccnumber, $ccexp, $cvv);

        if ($result == APPROVED) {
            echo "Recurring Payment Approved!";
        } elseif ($result == DECLINED) {
            echo "Recurring Payment Declined!";
        } else {
            echo "Recurring Payment Error!";
        }
    }
}
