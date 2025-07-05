<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AffiliatesLogin extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        error_reporting(0);
           $this->load->model('User_model');
  $this->data['base_url'] = base_url();
        $this->load->library('session');
    }
    
public function login()
{
    if ($this->input->post()) {
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $encodedPass = base64_encode($pass); // Encode user input

        if (!empty($email) && !empty($pass)) {
            $where['sq_affiliates_email'] = $email;
            $query = $this->User_model->select_where('sq_affiliates', $where);

            if ($query->num_rows() > 0) {
                $user = $query->row();
         
                if (!empty($user->sq_affiliates_password) && $encodedPass === $user->sq_affiliates_password) {
                    $this->session->set_userdata('affiliates_user_id', $user->sq_affiliates_id);
                     $this->session->set_userdata('user_id', $user->sq_affiliates_id);
                    $this->session->set_userdata('user_name', $user->sq_affiliates_first_name . ' ' . $user->sq_affiliates_last_name);
                    $this->session->set_userdata('user_type', 'affiliate');
                    echo json_encode([
                        'status' => 'success',
                        'redirect_url' => base_url('affiliate/account')
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Email or Password is incorrect.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Email or Password is incorrect.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }
    } else {
        $data['user'] = 'login';
        $this->load->view('affiliates/login', $data);
    }
}


}