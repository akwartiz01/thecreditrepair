<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/phpmailer/src/Exception.php';
require FCPATH . 'vendor/phpmailer/src/PHPMailer.php';
require FCPATH . 'vendor/phpmailer/src/SMTP.php';
class Credit_report extends CI_Controller
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

    public function reimportCreditReport()
    {
        $id = $this->input->post('id');
        if (!empty($id)) {
            $where['id'] = $id;

            $getUser = $this->User_model->select_where('crx_hero_registration', $where);
            $user_result = $getUser->row();
            $userId = $user_result->userId;

            // echo "<pre>";
            // print_r($user_result);
            // echo "</pre>";
            // die('STOP');

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

            $update_sq_clients = [
                'crx_hero_report_path' => $print_credit_report,
                'created_at' => date("Y-m-d h:i:sa"),
            ];
$report_id = isset($credit_report_data['id']) ? $credit_report_data['id'] : null;

$datas = [
    'userId'    => $userId,
    'report_id' => $report_id,
    'report'    => json_encode($credit_report_data), // <-- Convert array to JSON
];

$this->User_model->insertdata('reports_data', $datas);

            $this->User_model->updatedata('sq_clients', ['crx_hero_userId' => $userId], $update_sq_clients);

            echo json_encode(['status' => 'success', 'message' => 'Your updated credit score is now available!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'We were unable to retrieve your credit score at this time. Please try again later.']);
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

    public function send_get_request($url, $bearer_token)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers($bearer_token));
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
}
