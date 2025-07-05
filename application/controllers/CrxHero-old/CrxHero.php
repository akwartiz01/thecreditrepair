<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/phpmailer/src/Exception.php';
require FCPATH . 'vendor/phpmailer/src/PHPMailer.php';
require FCPATH . 'vendor/phpmailer/src/SMTP.php';
class CrxHero extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        error_reporting(0);

        $this->data['theme']  = 'client';

        $this->load->model('User_model');

        $this->load->library('session');

        $this->load->helper('url');

        $this->load->library('TCPDF');

        $this->load->library('Maverick_payment_gateway');
    }

    public function creditheroscore()
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {
            redirect(base_url('creditheroscore/saved-reports'));
            exit;
        }

        $this->load->view('crx_hero/creditheroscore');
    }

    public function creditherologin()
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {
            redirect(base_url('creditheroscore/saved-reports'));
            exit;
        }

        if ($this->input->post() || $this->session->userdata('admin_login') == 'crxhs') {

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($email && $password != '') {
                $where['user_name'] = $email;
                $where['password'] = md5($password);

                $getUser = $this->User_model->select_where('crx_hero_registration', $where);
                $email = $this->db->escape($email);
                $query = $this->User_model->query("SELECT * FROM `crx_hero_payments` WHERE `email` = $email");
                $getPaymentDetails = $query->result();
                $payment_status = $getPaymentDetails[0]->payment_status;
                $subscription_end_date = $getPaymentDetails[0]->subscription_end_date;
                $current_date = date('Y-m-d');

                if ($getUser->num_rows() > 0 && $payment_status == 1 && strtotime($subscription_end_date) > strtotime($current_date)) {

                    $getUser = $getUser->result();

                    // set session 
                    if (!empty($this->session->userdata('admin_login') == 'crxhs')) {

                        $this->session->set_userdata('user_name', $getUser[0]->first_name . ' ' . $getUser[0]->last_name);
                        $this->session->set_userdata('user_type', 'crxhs');
                    } else {

                        $this->session->set_userdata('user_id', $getUser[0]->id);
                        $this->session->set_userdata('user_name', $getUser[0]->first_name . ' ' . $getUser[0]->last_name);
                        $this->session->set_userdata('user_type', 'crxhs');
                    }

                    echo json_encode([
                        'status' => 'success',
                        'redirect_url' => base_url() . 'creditheroscore/saved-reports'
                    ]);
                } elseif ($payment_status != 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your payment is currently pending. Please complete your payment to proceed.'
                    ]);
                } elseif (strtotime($subscription_end_date) < strtotime($current_date)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Please renew your subscription to continue using our services.'
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


            $this->load->view('crx_hero/login');
        }
    }

    public function credit_reports()
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {

            $user_id = '';
            $this->data['theme'] = 'crx_hero';
            $this->data['page'] = 'credit_reports';
            if (!empty($this->session->userdata('admin_login'))) {

                $user_id = $this->session->userdata('admin_user_id');
            } else {
                $user_id = $this->session->userdata('user_id');
            }

            $where['id'] = $user_id;

            $getUser = $this->User_model->select_where('crx_hero_registration', $where);

            $this->data['reports'] = $getUser->result();

            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');
        } else {
            redirect(base_url());
            exit;
        }
    }

    public function saved_reports()
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {

            $user_id = '';
            $this->data['theme'] = 'crx_hero';
            $this->data['page'] = 'saved_reports';
            if (!empty($this->session->userdata('admin_login'))) {

                $user_id = $this->session->userdata('admin_user_id');
            } else {
                $user_id = $this->session->userdata('user_id');
            }

            $where['id'] = $user_id;

            $getUser = $this->User_model->select_where('crx_hero_registration', $where);

            $this->data['reports'] = $getUser->result();

            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');
        } else {
            redirect(base_url());
            exit;
        }
    }

    public function my_account()
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {

            $this->data['theme'] = 'crx_hero';
            $this->data['page'] = 'my_account';

            $user_id = $this->session->userdata('user_id');
            $where['id'] = $user_id;

            $getUser = $this->User_model->select_where('crx_hero_registration', $where);

            $this->data['reports'] = $getUser->result();

            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');
        } else {
            redirect(base_url());
            exit;
        }
    }

    public function signout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_type');
        redirect(base_url('creditheroscore/login'));
    }

    public function view_credit_report($userId, $report_name)
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {

            $file_path = FCPATH . 'upload/Credit_Reports/' . $userId . '/' . $report_name;

            if (file_exists($file_path)) {

                ob_clean();
                flush();

                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $report_name . '"');
                header('Content-Length: ' . filesize($file_path));

                readfile($file_path);

                exit;
            } else {
                show_404();
            }
        } else {
            redirect(base_url());
            exit;
        }
    }

    public function get_new_report()
    {
        $id = $this->session->userdata('user_id');
        if (!empty($id)) {
            $where['id'] = $id;

            $getUser = $this->User_model->select_where('crx_hero_registration', $where);
            $user_result = $getUser->row();
            $userId = $user_result->userId;

            $current_date_time = strtotime(date("Y-m-d h:i:sa"));
            $next_report_date_time = strtotime($user_result->next_available_report_at);

            if ($current_date_time < $next_report_date_time) {
                echo json_encode([
                    'status' => 'no_report',
                    'message' => 'The next report will be available on ' . $user_result->next_available_report_at
                ]);
                return;
            }


            $login = $this->login();
            $token = $login['token'];

            $direct_preauth = $this->preauth_token_by_user($userId, $token);
            $paToken = $direct_preauth['token'];

            $user_preauth = $this->preauth_token_by_pa_token($paToken);
            $uToken = $user_preauth['token'];

            $efx_config = $this->efx_config($uToken);

            $id = $efx_config['id'];
            $secret = $efx_config['secret'];
            $url = $efx_config['url'];

            $efx_oauth_token = $this->efx_oauth_token($url, $id, $secret);
            $access_token = $efx_oauth_token['access_token'];
            $credit_report = $this->get_equifax_credit_report($access_token);

            $credit_report_id = $credit_report[0]['id'];
            $full_credit_report = $this->get_full_credit_report($credit_report_id, $access_token, $userId);

            $credit_report_data = json_decode($full_credit_report, true);

            $print_credit_report = $this->get_equifax_full_credit_report_print($credit_report_id, $access_token, $userId);

            $added_date = date("m/d/Y");
            $scores = [
                'added_date' => $added_date,
                'providers' => [],
                'report_path' => $print_credit_report,
            ];

            if (isset($credit_report_data['providerViews'])) {
                foreach ($credit_report_data['providerViews'] as $providerView) {
                    $provider = $providerView['provider'];
                    $score = $providerView['summary']['creditScore']['score'];
                    $scores['providers'][$provider] = $score;
                }
            }

            $existing_scores = unserialize($user_result->scores) ?: [];
            $existing_scores[] = $scores; // Add the new record to the array

            $existing_reports = unserialize($user_result->reports) ?: [];
            $existing_reports[] = [
                'added_date' => $added_date,
                'report_path' => $print_credit_report,
            ];

            $update = [
                'scores' => serialize($existing_scores),
                'credit_report_path' => $print_credit_report,
                // 'updated_at' => date("Y-m-d h:i:sa"),
                'created_at' => date("Y-m-d h:i:sa"),
                'reports' => serialize($existing_reports),
            ];

            $this->User_model->updatedata('crx_hero_registration', ['userId' => $userId], $update);

            $data2 = [
                'crx_hero_report_path' => $print_credit_report,
                'created_at' => date("Y-m-d h:i:sa"),
            ];

            $this->User_model->updatedata('sq_clients', ['crx_hero_userId' => $userId], $data2);

            echo json_encode(['status' => 'success', 'message' => 'Your updated credit score is now available!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'We were unable to retrieve your credit score at this time. Please try again later.']);
        }
    }


    public function creditherosignUp()
    {
        if ($this->session->userdata('user_type') == 'crxhs' || $this->session->userdata('admin_login') == 'crxhs') {
            redirect(base_url('creditheroscore/saved-reports'));
            exit;
        }
        $this->load->view('crx_hero/sign_up');
    }
    public function CrxRegistration()
    {
        $this->load->view('crx_hero/registration');
    }
    public function payment_page()
    {
        $this->load->view('crx_hero/payment');
    }

    public function CrxHeroScoreRegistration()
    {
        if ($this->input->post()) {
            // Retrieve form input
            $user_name    = $this->input->post('user_name');
            $first_name   = $this->input->post('first_name');
            $last_name    = $this->input->post('last_name');
            $address      = $this->input->post('address');
            $city         = $this->input->post('city');
            $state        = $this->input->post('state');
            $zip          = $this->input->post('zip');
            $phone        = $this->input->post('phone');
            $ssn          = $this->input->post('ssn');
            $dob          = $this->input->post('dob');
            $password     = $this->input->post('password');
            $added_date   = date("m/d/Y");
            $current_date_time = date("Y-m-d h:i:sa");

            $data = [
                'user_name'   => $user_name,
                'first_name'  => $first_name,
                'last_name'   => $last_name,
                'address'     => $address,
                'city'        => $city,
                'state'       => $state,
                'zip'         => $zip,
                'phone'       => $phone,
                'ssn'         => $ssn,
                'dob'         => $dob,
                's_password'  => $password,
                'password'    => md5($password),
                'created_at'  => $current_date_time,
            ];

            // Check for existing user
            $existingCrxHeroUser = $this->User_model->select_where('crx_hero_registration', ['user_name' => $user_name])->row();
            if ($existingCrxHeroUser) {
                echo json_encode(['status' => 'error', 'message' => 'This email address is already in use.']);
                return;
            }

            // // Check for associated client
            // $existingClient = $this->User_model->select_where('sq_clients', ['sq_email' => $user_name])->row();
            // if (!$existingClient) {
            //     echo json_encode(['status' => 'error', 'message' => 'Please enter the email address associated with your account at The Credit Repair Xperts.']);
            //     return;
            // }

            // API calls for registration and verification
            $login = $this->login();
            $token = $login['token'];

            $user_reg = $this->user_registration($token, $user_name, $first_name, $last_name, $phone);
            $userId = $user_reg['userId'];
            $data['userId'] = $userId;

            $direct_preauth = $this->preauth_token_by_user($userId, $token);
            $paToken = $direct_preauth['token'];

            $user_preauth = $this->preauth_token_by_pa_token($paToken);
            $uToken = $user_preauth['token'];

            $dit_identity = $this->submit_identity($uToken, $user_name, $first_name, $last_name, $address, $city, $zip, $phone, $ssn, $state, $dob);

            $mToken = $dit_identity['token'];
            $send_verification_link = $this->send_mfa_link($mToken, $uToken);

            preg_match('/https:\/\/[^\s]+/', $send_verification_link['smsMessage'], $matches);
            $auth_link = $matches[0];

            $smfaToken = $send_verification_link['token'];
            $this->sms_link_verification($auth_link);

            $this->smfa_verify_status($smfaToken, $uToken);

            // Fetch credit report details
            $efx_config = $this->efx_config($uToken);
            $efx_oauth_token = $this->efx_oauth_token($efx_config['url'], $efx_config['id'], $efx_config['secret']);
            $access_token = $efx_oauth_token['access_token'];
            $credit_report = $this->get_equifax_credit_report($access_token);

            $credit_report_id = $credit_report[0]['id'];
            $full_credit_report = $this->get_full_credit_report($credit_report_id, $access_token, $userId);

            $credit_report_data = json_decode($full_credit_report, true);

            // Process report path
            $print_credit_report = $this->get_equifax_full_credit_report_print($credit_report_id, $access_token, $userId);
            $data['credit_report_path'] = $print_credit_report;

            // Process scores
            $scores = [
                [
                    'added_date' => $added_date,
                    'providers' => [],
                    'report_path' => $print_credit_report,
                ]
            ];

            if (isset($credit_report_data['providerViews'])) {
                foreach ($credit_report_data['providerViews'] as $providerView) {
                    $provider = $providerView['provider'];
                    $score = $providerView['summary']['creditScore']['score'] ?? 'N/A';
                    $scores[0]['providers'][$provider] = $score;
                }
            }

            $reports = [
                [
                    'added_date' => $added_date,
                    'report_path' => $print_credit_report,
                ]
            ];

            // Serialize scores and reports
            $data['scores'] = serialize($scores);
            $data['reports'] = serialize($reports);
            $data['next_available_report_at']  = date($current_date_time, strtotime("+30 days"));

            // Insert into `crx_hero_registration`
            $this->User_model->insertdata('crx_hero_registration', $data);

            // Update `sq_clients`
            $data2 = [
                'crx_hero_userId'       => $userId,
                'crx_hero_user_name'    => $user_name,
                'crx_hero_ssn'          => $ssn,
                'crx_hero_password'     => $password,
                'crx_hero_report_path'  => $print_credit_report,
                'created_at'            => date("Y-m-d h:i:sa"),
            ];
            $this->User_model->updatedata('sq_clients', ['sq_email' => $user_name], $data2);

            echo json_encode(['status' => 'success', 'message' => 'Your data has been successfully submitted.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'We were unable to process your request. Please verify the form details and try again.']);
        }
    }




    // 1
    public function login()
    {
        $url = "https://efx-dev.stitchcredit.com/api/direct/login";

        $data = array(
            "secret" => "1e662220-5dcf-47eb-9696-7bda7f2f28a0",
            "apikey" => "6a405259-4075-45cc-8455-2b60d213a9fe"
        );

        $response = $this->send_post_request($url, $data);

        return json_decode($response, true);
    }

    // 2
    public function user_registration($token, $email, $fname, $lname, $phone)
    {
        $url = "https://efx-dev.stitchcredit.com/api/direct/user-reg";

        $data = array(
            "email" => $email,
            "fname" => $fname,
            "lname" => $lname,
            "mobile" => $phone
        );

        $bearer_token = $token;
        $response = $this->send_post_request($url, $data, $bearer_token);

        return json_decode($response, true);
    }

    // 3
    public function preauth_token_by_user($userId, $token)
    {
        $url = "https://efx-dev.stitchcredit.com/api/direct/preauth-token/$userId";

        $bearer_token = $token;
        $response = $this->send_get_request($url, $bearer_token);

        return json_decode($response, true);
    }


    // 4
    public function preauth_token_by_pa_token($paToken)
    {
        $url = "https://efx-dev.stitchcredit.com/api/users/preauth-token/$paToken";

        $bearer_token = '';
        $response = $this->send_get_request($url, $bearer_token);

        return json_decode($response, true);
    }

    // 5
    public function submit_identity($uToken, $user_name, $first_name, $last_name, $address, $city, $zip, $phone, $ssn, $state, $dob)
    {
        $url = "https://efx-dev.stitchcredit.com/api/users/dit-identity";

        $data1 = array(
            "fname" => "GERTRUDE",
            "lname" => "HARKENREADEO",
            "mobile" => 5555551222,
            "ssn" => 666458856,
            "dob" => "1967-06-08",
            "street1" => "305 LINDEN AV",
            "street2" => "KK",
            "city" => "ATLANTA",
            "state" => "GA",
            "zip" => "30316"
        );

        $data = array(
            "fname"     => $first_name,
            "lname"     => $last_name,
            "mobile"    => $phone,
            "ssn"       => $ssn,
            "dob"       => "1967-06-08",
            "street1"   => $address,
            "street2"   => "",
            "city"      => $city,
            "state"     => $state,
            "zip"       => $zip
        );

        $response = $this->send_post_request($url, $data, $uToken);

        return json_decode($response, true);
    }

    // 6
    public function send_mfa_link($mtoken, $uToken)
    {
        $url = "https://efx-dev.stitchcredit.com/api/users/smfa-send-link/$mtoken";

        $response = $this->send_post_request($url, '', $uToken);
        return json_decode($response, true);
    }

    // 7
    public function sms_link_verification($smsMessageLink)
    {
        $url = "$smsMessageLink";

        $response = $this->send_get_request($url, '');

        return json_decode($response, true);
    }

    // 8
    public function smfa_verify_status($smfaToken, $uToken)
    {
        $url = "https://efx-dev.stitchcredit.com/api/users/smfa-verify-status/$smfaToken";

        $response = $this->send_post_request($url, '', $uToken);
        return json_decode($response, true);
    }

    // 9
    public function efx_config($uToken)
    {
        $url = "https://efx-dev.stitchcredit.com/api/users/efx-config";

        $response = $this->send_get_request($url, $uToken);
        return json_decode($response, true);
    }

    // 10
    public function efx_oauth_token($oauth_url, $id, $secret)
    {
        $url = "$oauth_url/oauth/token";

        // Data formatted as key-value pairs for x-www-form-urlencoded
        $data = http_build_query(array(
            "scope" => "delivery",
            "grant_type" => "jwt-bearer",
            "api_key" => $id,
            "client_assertion" => $secret
        ));

        $response = $this->send_post_request_urlencoded($url, $data, null);
        return json_decode($response, true);
    }

    // 11
    public function get_equifax_credit_report($access_token)
    {
        $url = "https://api.uat.equifax.com/personal/consumer-data-suite/v1/creditReport?format=json";

        $bearer_token = $access_token;

        $response = $this->send_get_request($url, $bearer_token);

        return json_decode($response, true);
    }

    // 12
    public function get_equifax_full_credit_report($credit_report_id, $access_token)
    {
        $url = "https://api.uat.equifax.com/personal/consumer-data-suite/v1/creditReport/$credit_report_id?format=json";

        $bearer_token = $access_token;

        $response = $this->send_get_request($url, $bearer_token);

        return json_decode($response, true);
    }

    // 13

    public function get_equifax_full_credit_report_print($credit_report_id, $access_token, $userId)
    {

        $url = "https://api.uat.equifax.com/personal/consumer-data-suite/v1/creditReport/$credit_report_id/print?access_token=$access_token";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers($access_token));

        $response = curl_exec($ch);

        // Get response content type
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        // Check if the content type is PDF and save it
        if (strpos($content_type, 'application/pdf') !== false) {
            // Define the file path (make sure the Credit_Reports directory exists in FCPATH)
            $upload_dir = FCPATH . 'upload/Credit_Reports/' . $userId;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $file_path = FCPATH . 'upload/Credit_Reports/' . $userId . '/' .  'Credit_Report_' .  time() . '.pdf';

            // Check if an existing file needs to be deleted
            $where['userId'] = $userId;
            $getData = $this->User_model->select_where('crx_hero_registration', $where);
            $result = $getData->row();
            if ($result && !empty($result->credit_report_path)) {
                $existing_path = FCPATH . 'upload/Credit_Reports/' . $userId . '/' . basename($result->credit_report_path);
                if (file_exists($existing_path)) {
                    unlink($existing_path);
                }
            }
            $credit_report_path = base_url() . 'upload/Credit_Reports/' . $userId . '/' .  'Credit_Report_' .  time() . '.pdf';
            // Save the report as a PDF file
            file_put_contents($file_path, $response);

            // Return the file path or success message
            return $credit_report_path;
        } else {
            // Handle non-PDF responses (e.g., error messages or JSON)
            return json_decode($response, true);
        }
    }


    public function get_full_credit_report($credit_report_id, $access_token, $userId)
    {

        $url = "https://api.uat.equifax.com/personal/consumer-data-suite/v1/creditReport/$credit_report_id/?format=json";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers($access_token));

        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

    public function send_post_request_urlencoded($url, $data, $bearer_token = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers_urlencoded($bearer_token));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Sending the key-value formatted data
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function get_headers_urlencoded($bearer_token = null)
    {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        );
        if ($bearer_token) {
            $headers[] = 'Authorization: Bearer ' . $bearer_token;
        }
        return $headers;
    }

    public function efx_score_history($bearer_token)
    {
        $url = "https://efx-dev.stitchcredit.com/api/users/efx-score-history";

        $response = $this->send_get_request($url, $bearer_token);

        return json_decode($response, true);
    }


    public function send_get_request($url, $bearer_token)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers($bearer_token));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function send_post_request($url, $data, $bearer_token = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers($bearer_token));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function get_headers($bearer_token = null)
    {
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json'
        );
        if ($bearer_token) {
            $headers[] = 'Authorization: Bearer ' . $bearer_token;
        }
        return $headers;
    }

    public function get_bearer_token()
    {
        $login_response = $this->login();
        return $login_response['token'];
    }

    function generate_code_crx_hero($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

    public function crxHeroInvite()
    {
        $sq_client_id = $this->input->post('sq_client_id');

        $fetchdata = $this->User_model->query("SELECT * FROM sq_clients WHERE `sq_client_id` = '" . $sq_client_id . "'");

        if ($fetchdata->num_rows() > 0) {

            $fetchdata = $fetchdata->result();
            $name = $fetchdata[0]->sq_first_name . ' ' . $fetchdata[0]->sq_last_name;
            $email = $fetchdata[0]->sq_email;
            $security_code = $this->generate_code_crx_hero(16);
            $this->send_crx_hero_welcome_email($name, $email, $security_code);

            $updation['security_code'] = $security_code;
            $updation['security_code_time'] = date('Y-m-d H:i:s');

            $where['sq_client_id'] = $sq_client_id;

            $this->User_model->updatedata('sq_clients', $where, $updation);

            echo json_encode(['status' => 'success', 'message' => 'CRX Hero invitation has been successfully sent.']);
        }
    }


    public function send_crx_hero_welcome_email($name, $email, $security_code)
    {
        if ($email != '') {

            // $link        = base_url('credit_monitoring_payment_link/') . $security_code;
            $link        = base_url('creditheroscore/sign-up');

            $message = '
                    <table style="width:100%; background-color:#F2F2F2; border:0; cellpadding:0; cellspacing:0;">
                        <tbody>
                            <tr>
                                <td align="center" valign="top">
                                    <br>
                                    <table style="width:600px; margin:0 auto; border:0; cellpadding:0; cellspacing:0;">
                                        <tbody>
                                            <tr>
                                                <td style="background-color:#fff; border:1px solid #f2f2f2; border-top:0; padding:20px; font-family:Helvetica,Arial,sans-serif; font-size:15px; color:#606060; line-height:22px;" align="left" valign="top">
                                                    <p style="font-family:Helvetica,Arial,sans-serif; font-size:18px; color:#606060;"><b>Dear ' . ucwords($name) . ',</b></p>
                                                    <p style="font-family:Google Sans; font-size:16px; color:#606060;">Welcome to The Credit Repair Xperts, glad to meet you!</p><p style="font-family:Helvetica,Arial,sans-serif; font-size:15px; color:#606060;">To get started on your credit repair journey, we need to access your reports and scores from all 3 bureaus. It\'ll only take two minutes of your time.</p><p>So let\'s get you set up for credit monitoring!</p><br><div style="text-align:center;"><a href="' . $link . '" style="background-color:#0558b5; color:#fff; border:none; padding:10px 10px; font-size:15px; cursor:pointer; border-radius: 4px; text-decoration: none">Get Started</a></div><p style="font-family:Helvetica,Arial,sans-serif; font-size:15px; color:#606060;">This message was sent by The Credit Repair Xperts | (856) 515-6408</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>';

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->Username = 'ajay.wartiz07@gmail.com';
            $mail->Password = 'zgqp xafm onct wzyf';
            $mail->setFrom('ajay.wartiz07@gmail.com', 'The Credit Repair Xpert');
            $mail->addAddress($email);
            $mail->IsHTML(true);
            $mail->Subject = 'Invite for CRX Hero Signup';
            $mail->Body = $message;
            $mail->send();
            return '1';
        }
    }

    public function submit_payment()
    {
        // Load parameters from URL
        $subscription_id = $this->input->get('p_subscription_id', TRUE);
        $first_name = $this->input->get('p_first_name', TRUE);
        $last_name = $this->input->get('p_last_name', TRUE);
        $email = $this->input->get('p_email', TRUE);
        $amount = $this->input->get('p_amount', TRUE);
        $payment_token = $this->input->get('payment_token', TRUE);

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        $result = $this->maverick_payment_gateway->doSale1($amount, $payment_token);

        $plan_details = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE `id` = $subscription_id");
        $plan_details = $plan_details->result();

        $subscription_name = $plan_details[0]->subscription_name;
        $duration = $plan_details[0]->subscription_duration;
        $subscription_start_date = date("Y-m-d");
        $subscription_end_date = date("Y-m-d", strtotime("+$duration"));

        if ($result == APPROVED) {

            $data = array(
                'payment_status' => 1,
                'payment_token' => $payment_token,
                'subscription_id' => $subscription_id,
                'subscription_start_date' => $subscription_start_date,
                'subscription_end_date' => $subscription_end_date

            );
            $this->User_model->updatedata('sq_subscription_payment_details', array('sq_email' => $email), $data);
            $this->send_subscription_email($email, $amount, $subscription_name);

            $this->session->set_flashdata('payment_status', 'success');
            $this->session->set_flashdata('message', 'Your payment was successful!');
            redirect(base_url('subscriber/login'));
        } elseif ($result == DECLINED) {
            $this->session->set_flashdata('payment_status', 'declined');
            $this->session->set_flashdata('message', 'Your payment was declined. Please check your details or use a different card.');
            redirect(base_url('subscriber/login'));
        } else {
            $this->session->set_flashdata('payment_status', 'error');
            $this->session->set_flashdata('message', 'An error occurred while processing your payment. Please try again later.');
            redirect(base_url('subscriber/login'));
        }
    }

    public function submit_crx_hero_payment()
    {
        $first_name = $this->input->get('p_first_name', TRUE);
        $last_name = $this->input->get('p_last_name', TRUE);
        $email = $this->input->get('p_user_name', TRUE);
        $amount = $this->input->get('p_amount', TRUE);
        $payment_token = $this->input->get('payment_token', TRUE);

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        $result = $this->maverick_payment_gateway->doSale1($amount, $payment_token);

        $subscription_start_date = date("Y-m-d");
        $subscription_end_date = date("Y-m-d", strtotime("+30 days"));

        $user_name = $this->db->escape($email); // Escaping input to prevent SQL injection
        $query = $this->User_model->query("SELECT * FROM `crx_hero_registration` WHERE `user_name` = $user_name");
        $getData = $query->result();

        $userId = $getData[0]->userId;

        if ($result == APPROVED) {

            $data = array(
                'payment_status' => 1,
                'payment_token' => $payment_token,
                'user_id' => $userId,
                'email' => $email,
                'subscription_start_date' => $subscription_start_date,
                'subscription_end_date' => $subscription_end_date

            );
            $this->User_model->insertdata('crx_hero_payments', $data);
            // $this->send_subscription_email($email, $amount, 'CRX Hero');

            $this->session->set_flashdata('payment_status', 'success');
            $this->session->set_flashdata('message', 'Your payment was successful!');
            redirect(base_url('creditheroscore/sign-up'));
        } elseif ($result == DECLINED) {
            $this->session->set_flashdata('payment_status', 'declined');
            $this->session->set_flashdata('message', 'Your payment was declined. Please check your details or use a different card.');
            redirect(base_url('creditheroscore/sign-up'));
        } else {
            $this->session->set_flashdata('payment_status', 'error');
            $this->session->set_flashdata('message', 'An error occurred while processing your payment. Please try again later.');
            redirect(base_url('creditheroscore/sign-up'));
        }
    }

    public function send_subscription_email($email, $amount, $subscription_name)
    {
        if ($email != '') {

            $where['sq_u_email_id'] = $email;

            $check_useremail =  $this->User_model->select_where('sq_users', $where);
            if ($check_useremail->num_rows() > 0) {

                $check_useremail = $check_useremail->result();

                $email_address   = $check_useremail[0]->sq_u_email_id;
                $fname           = $check_useremail[0]->sq_u_first_name;
                $lname           = $check_useremail[0]->sq_u_last_name;
                $username        = $check_useremail[0]->sq_u_user_id;
                $password        = $check_useremail[0]->sq_u_apassword;

                $logolink        = base_url() . 'assets/images/logo.png';
                $site_link        = base_url('sign-in');

                $password_message = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #3972FC;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Subscription Payment</b></td></tr><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p>
                </td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 50px 20px 50px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($fname) . ' ' . $lname . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">We are excited to let you know that your subscription of <b>$' . $amount . '</b> for <b>' . $subscription_name . '</b> has been successfully done!</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Here are your login details for The Credit Repair Xperts:</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $username . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $password . '</td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely, and monitor your overall progress.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->Username = 'ajay.wartiz07@gmail.com';
                $mail->Password = 'zgqp xafm onct wzyf';
                $mail->setFrom('ajay.wartiz07@gmail.com', 'The Credit Repair Xperts');
                $mail->addAddress($email_address);
                $mail->IsHTML(true);
                $mail->Subject = 'Registration';
                $mail->Body = $password_message;
                $mail->send();

                return '1';
            } else {

                echo 'This email is not associated with any account!';
            }
        } else {
            echo 'Email field required!';
        }
    }
}
