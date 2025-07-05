<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        error_reporting(0);

        $this->data['theme']  = 'client';

        $this->load->model('User_model');

        $this->load->library('session');

        $this->load->helper('url');

        $this->data['base_url'] = base_url();

        $this->data['user_id'] = $this->session->userdata('user_id');

        $this->data['type']  = $this->session->userdata('user_type');

        $this->load->model('AgreementModel');
        $this->load->library('TCPDF');
    }

    public function login()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $pass = $this->input->post('password');
            $remember = $this->input->post('remember');

            if ($email && $pass != '') {
                $where['sq_u_email_id'] = $email;
                $where['sq_u_password'] = md5($pass);

                $getUser = $this->User_model->select_where('sq_users', $where);
                if ($getUser->num_rows() > 0) {

                    $getUser = $getUser->result();
                    $email_id['sq_email'] = $email;
                    $get_payment_details = $this->User_model->select_where('sq_subscription_payment_details', $email_id);
                    $get_payment_details = $get_payment_details->result();

                    // if (is_null($getUser->subscriber_type) &&  is_null($getUser->added_by)) {

                    //     echo json_encode([
                    //         'status' => 'error',
                    //         'message' => 'Email or Password is incorrect.'
                    //     ]);
                    //     return false;
                    // }

                    // if (!empty($user->added_by)) {

                    //     $query = $this->db->get_where('sq_users', ['sq_u_id' => $getUser->added_by]);

                    //     if ($query->num_rows() > 0) {
                    //         $addedByUser = $query->row();

                    //         if (is_null($addedByUser->subscriber_type) && $addedByUser->subscriber_type != 1) {
                    //             echo json_encode([
                    //                 'status' => 'error',
                    //                 'message' => 'Email or Password is incorrect.'
                    //             ]);
                    //             return false;
                    //         }
                    //     }
                    // }

                    if (!empty($getUser[0]->sq_u_type || $getUser[0]->sq_u_type == 3) && $get_payment_details[0]->payment_status == 0) {

                        $subscriptionId = $get_payment_details[0]->subscription_id;
                        $price = $get_payment_details[0]->subscription_price;
                        $first_name = $getUser[0]->sq_u_first_name;
                        $last_name = $getUser[0]->sq_u_last_name;
                        $email = $getUser[0]->sq_u_email_id;

                        $this->session->set_userdata('subscription_id', $subscriptionId);
                        $this->session->set_userdata('subscription_price', $price);
                        $this->session->set_userdata('first_name', $first_name);
                        $this->session->set_userdata('last_name', $last_name);
                        $this->session->set_userdata('email', $email);

                        // echo json_encode([
                        //     'status' => 'unpaid',
                        //     'message' => 'Your payment is pending. Please complete your payment to continue using our services.'
                        // ]);

                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Email or Password is incorrect.'
                        ]);

                        return false;
                    }
                    // set session 
                    $this->session->set_userdata('user_id', $getUser[0]->sq_u_id);
                    $this->session->set_userdata('user_name', $getUser[0]->sq_u_first_name . ' ' . $getUser[0]->sq_u_last_name);
                    $this->session->set_userdata('user_type', 'subscriber');

                    // set cookie for remember me option 
                    if ($remember == 1) {

                        $cookie = array(
                            'name'   => 'email',
                            'value'  => $email,
                            'expire' => '604800',
                            'prefix' => ''
                        );

                        $this->input->set_cookie($cookie);

                        $cookie = array(
                            'name'   => 'password',
                            'value'  =>  $pass,
                            'expire' => '604800',
                            'prefix' => ''
                        );

                        $this->input->set_cookie($cookie);
                    }

                    $this->loginActivity('Login-Activity', 'Login');
                    $this->allActivityHome($getUser[0]->sq_u_first_name . ' ' . $getUser[0]->sq_u_last_name . ' sign-in in CRM successfully!');

                    echo json_encode([
                        'status' => 'success',
                         'redirect_url' => base_url() . 'subscriber/dashboard'
                        //'redirect_url' => base_url() . 'admin'
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
                    'message' => 'All fields are required.'
                ]);
            }
        } else {

            $data['user'] = 'login';
            $this->load->view('subscriber/login', $data);
        }
    }

    public function loginActivity($activity_type, $status)
    {
        $ip_address = $this->get_client_ip();
        $get_devices = $this->get_device();

        // Fetch location details
        $details = @json_decode(file_get_contents("http://ipinfo.io/{$ip_address}/json"));
        $location = (!empty($details->city) && !empty($details->country)) ? $details->country . ', ' . $details->city : 'Unknown';

        $data = [
            'activity_type' => $activity_type,
            'user_id'       => $this->session->userdata('user_id'),
            'user_status'   => $this->session->userdata('user_type'),
            'ip_address'    => $ip_address,
            'access_type'   => $get_devices,
            'status'        => $status,
            'datetime'      => date('Y-m-d H:i:s a'),
            'location'      => $location,
        ];

        $this->User_model->insertdata('sq_activity', $data);
    }


    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    public function get_device()
    {
        $tablet_browser = 0;
        $mobile_browser = 0;
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }
        $mobile_ua = strtolower(substr(self::get_user_agent(), 0, 4));
        $mobile_agents = array(
            'w3c ',
            'acs-',
            'alav',
            'alca',
            'amoi',
            'audi',
            'avan',
            'benq',
            'bird',
            'blac',
            'blaz',
            'brew',
            'cell',
            'cldc',
            'cmd-',
            'dang',
            'doco',
            'eric',
            'hipt',
            'inno',
            'ipaq',
            'java',
            'jigs',
            'kddi',
            'keji',
            'leno',
            'lg-c',
            'lg-d',
            'lg-g',
            'lge-',
            'maui',
            'maxo',
            'midp',
            'mits',
            'mmef',
            'mobi',
            'mot-',
            'moto',
            'mwbp',
            'nec-',
            'newt',
            'noki',
            'palm',
            'pana',
            'pant',
            'phil',
            'play',
            'port',
            'prox',
            'qwap',
            'sage',
            'sams',
            'sany',
            'sch-',
            'sec-',
            'send',
            'seri',
            'sgh-',
            'shar',
            'sie-',
            'siem',
            'smal',
            'smar',
            'sony',
            'sph-',
            'symb',
            't-mo',
            'teli',
            'tim-',
            'tosh',
            'tsm-',
            'upg1',
            'upsi',
            'vk-v',
            'voda',
            'wap-',
            'wapa',
            'wapi',
            'wapp',
            'wapr',
            'webc',
            'winw',
            'winw',
            'xda ',
            'xda-'
        );
        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }
        if (strpos(strtolower(self::get_user_agent()), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }
        if ($tablet_browser > 0) {
            // do something for tablet devices
            return 'Tablet';
        } else if ($mobile_browser > 0) {
            // do something for mobile devices
            return 'Mobile';
        } else {
            // do something for everything else
            return 'Computer';
        }
    }

    public function get_user_agent()
    {
        return  $_SERVER['HTTP_USER_AGENT'];
    }

    public function allActivityHome($msg)
    {

        $loginID = $this->session->userdata('user_id');
        $datetime = date('Y-m-d H:i:s a');

        $data['user_id']        = $loginID;
        $data['user_status']           = $this->session->userdata('user_type');
        $data['msg']            = $msg;
        $data['datetime']       = $datetime;
        $this->User_model->insertdata('sq_all_activity', $data);

        return;
    }
}
