<?php

defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/phpmailer/src/Exception.php';
require FCPATH . 'vendor/phpmailer/src/PHPMailer.php';
require FCPATH . 'vendor/phpmailer/src/SMTP.php';

class Lob extends CI_Controller
{
    private $lobApiUrl = 'https://api.lob.com/v1';
    // private $apiKey = 'test_de4018cc5371bdc4e465441ba5c41727c44'; // Secret API Key
    private $apiKey = 'live_d877b5d83041c8417a55fbde521d6485c25'; // Secret API Key
    function __construct()
    {
   parent::__construct();

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
        $this->load->library('email');
    }
   public function dispute_send_letter(){
           $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $client_Id = $data['client_Id'];
        $client_address = $data['client_address'];
        $client_full_address = $data['client_full_address'];
        $client_name = $data['client_name'];
        $company_address = $data['company_address'];
        $company_full_address = $data['company_full_address'];
        $company_name = $data['company_name'];
        $dob = $data['dob'];
        $letter_name = $data['letter_name'];
        $signature_path = $data['signature_path'];
         $letters = $data['letters'];
         $selectedIds = $data['selectedIds'];
         $selectedbureau=$data['selectedbureau'];
         $selectedstatus = $data['selectedstatus'];
         
        $ssn = $data['ssn'];
           $this->db->select('*');
        $this->db->from('sq_clients');
        $this->db->where('sq_client_id', $client_Id);
        $query = $this->db->get();
        $client_data = $query->row_array();
       if (!empty($company_full_address)) {
    // First, explode on comma to separate city and the rest
    $parts = explode(',', $company_full_address);

    $city = isset($parts[0]) ? trim($parts[0]) : '';
 
    // Proceed if state and zip part exists
    if (isset($parts[1])) {
        $stateZip = preg_split('/\s+/', trim($parts[1])); // splits by space(s)
        $state = isset($stateZip[0]) ? $stateZip[0] : '';
        $zip   = isset($stateZip[1]) ? $stateZip[1] : '';
    } else {
        $state = '';
        $zip = '';
    }
} else {
    $city = '';
    $state = '';
    $zip = '';
}


           $addressData = [
            'primary_line' => $company_address,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip,
        ];
       
        // Step 1: Verify the address
        $validatedAddress = $this->validate_address($addressData);
        if (!$validatedAddress) {
            echo json_encode(['status' => 'error', 'message' => 'Address validation failed. Please check the address details and try again']);
            return;
        }

        if ($validatedAddress['deliverability'] !== 'deliverable') {
            echo json_encode(['status' => 'error', 'message' => 'The address is not deliverable. Please provide a valid address that can receive mail']);
            return;
        }
          // Replace with the validated address details
        $createAddressData = [
            'name' => $company_name,
            'address_line1' => $validatedAddress['primary_line'],
            'address_line2' => $validatedAddress['secondary_line'] ?? '',
            'address_city' => $validatedAddress['components']['city'],
            'address_state' => $validatedAddress['components']['state'],
            'address_zip' => $validatedAddress['components']['zip_code'],
            'address_country' => 'US',
        ];

        // Step 2: Create the address
        $addressResponse = $this->call_api('POST', '/addresses', $createAddressData);

        if (!$addressResponse['status']) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create the address.' . htmlspecialchars($addressResponse['error'])]);
            return;
        }

        $addressId = $addressResponse['data']['id'];
          $bureau_address = $company_name . '<br>' . $company_address . '<br>' . $city . ' ' . $state . ' ' . $zip;
        $personalized_template = str_replace(
            ['{bureau_address}'],
            [
                $bureau_address,

            ],
            $letters
        );
                // Step 3: Send the letter
        $letterData = [
            'description' => $letter_name,
            'to' => $addressId,
            'from' => [
                'name' => $client_data['sq_first_name'] . ' ' . $client_data['sq_last_name'],
                'address_line1' => $client_data['sq_mailing_address'],
                'address_city' => $client_data['sq_city'],
                'address_state' => $client_data['sq_state'],
                'address_zip' => $client_data['sq_zipcode'],
                'address_country' => 'US',
            ],
            'file' => $personalized_template,
            'color' => 'false',
            'address_placement' => 'insert_blank_page',

        ];

        $client_name = $client_data['sq_first_name'] . ' ' . $client_data['sq_last_name'];
        $sq_email = $client_data['sq_email'];
  
        $letterResponse = $this->call_api('POST', '/letters', $letterData);


        if ($letterResponse['status']) {

            $this->send_dispute_email_client($client_name, $sq_email);
foreach ($selectedIds as $index => $id) {
    $bureau = $selectedbureau[$index];
    $status = $selectedstatus[$index];
    $this->User_model->query("UPDATE sq_dispute_item SET `$bureau` = '2', `$status` = 'In Dispute' WHERE id = '" . $id . "'");
}
   $this->generate_pdf($letters,$client_Id);

            echo json_encode(['status' => 'success', 'message' => 'Letter sent successfully!','client_Id'=>$client_Id]);
            
        } else {
            // echo 'Error Sending Letter: ' . $letterResponse['error'];
            echo json_encode(['status' => 'error', 'message' => 'Failed to send the letter.' . htmlspecialchars($letterResponse['error'])]);
            return;
        }


     }
    public function create_and_send_letter()
    {

        $sub_category_name = $this->input->post('sub_category_name');
        $client_Id = $this->input->post('client_Id');
        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $zip = $this->input->post('zip');

        $message_content = $this->input->post('message_content');

        $this->db->select('*');
        $this->db->from('sq_clients');
        $this->db->where('sq_client_id', $client_Id);
        $query = $this->db->get();
        $client_data = $query->row_array();

        if (empty($client_data)) {
            die("Client data not found.");
        }
        $bureau_address = $name . '<br>' . $address . '<br>' . $city . ' ' . $state . ' ' . $zip;
        $personalized_template = str_replace(
            ['{bureau_address}'],
            [
                $bureau_address,

            ],
            $message_content
        );


        $addressData = [
            'primary_line' => $address,
            // 'primary_line' => 'deliverable', //for test account
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip,
            // 'zip_code' => '11111', //for test account
        ];


        // Step 1: Verify the address
        $validatedAddress = $this->validate_address($addressData);

        // if (!$validatedAddress || $validatedAddress['deliverability'] !== 'deliverable') {
        //     // echo 'Error: Address is not deliverable.';
        //     echo json_encode(['status' => 'error', 'message' => 'Address is not deliverable']);
        //     return;
        // }

        if (!$validatedAddress) {
            echo json_encode(['status' => 'error', 'message' => 'Address validation failed. Please check the address details and try again']);
            return;
        }

        if ($validatedAddress['deliverability'] !== 'deliverable') {
            echo json_encode(['status' => 'error', 'message' => 'The address is not deliverable. Please provide a valid address that can receive mail']);
            return;
        }


        // Replace with the validated address details
        $createAddressData = [
            'name' => $name,
            'address_line1' => $validatedAddress['primary_line'],
            'address_line2' => $validatedAddress['secondary_line'] ?? '',
            'address_city' => $validatedAddress['components']['city'],
            'address_state' => $validatedAddress['components']['state'],
            'address_zip' => $validatedAddress['components']['zip_code'],
            'address_country' => 'US',
        ];

        // Step 2: Create the address
        $addressResponse = $this->call_api('POST', '/addresses', $createAddressData);

        if (!$addressResponse['status']) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create the address.' . htmlspecialchars($addressResponse['error'])]);
            return;
        }

        $addressId = $addressResponse['data']['id'];
        // Step 3: Send the letter
        $letterData = [
            'description' => $sub_category_name,
            'to' => $addressId,
            'from' => [
                'name' => $client_data['sq_first_name'] . ' ' . $client_data['sq_last_name'],
                'address_line1' => $client_data['sq_mailing_address'],
                'address_city' => $client_data['sq_city'],
                'address_state' => $client_data['sq_state'],
                'address_zip' => $client_data['sq_zipcode'],
                'address_country' => $client_data['sq_country'],
            ],
            'file' => $personalized_template,
            'color' => 'false',
            'address_placement' => 'insert_blank_page',

        ];

        $client_name = $client_data['sq_first_name'] . ' ' . $client_data['sq_last_name'];
        $sq_email = $client_data['sq_email'];
        $letterResponse = $this->call_api('POST', '/letters', $letterData);


        if ($letterResponse['status']) {

            $this->send_dispute_email_client($client_name, $sq_email);
           
            echo json_encode(['status' => 'success', 'message' => 'Letter sent successfully!']);
        } else {
            // echo 'Error Sending Letter: ' . $letterResponse['error'];
            echo json_encode(['status' => 'error', 'message' => 'Failed to send the letter.' . htmlspecialchars($letterResponse['error'])]);
            return;
        }
    }

    private function validate_address($data)
    {
        $response = $this->call_api('POST', '/us_verifications', $data);

        if ($response['status']) {
            return $response['data'];
        } else {
            // echo 'Error Validating Address: ' . $response['error'];
            echo json_encode(['status' => 'error', 'message' => 'Error Validating Address: ' . $response['error']]);
            return false;
        }
    }

    private function call_api($method, $endpoint, $data)
    {
        $curl = curl_init();
        $url = $this->lobApiUrl . $endpoint;

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->apiKey . ':',
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ];

        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = http_build_query($data);
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode === 200 || $httpCode === 201) {
            return ['status' => true, 'data' => json_decode($response, true)];
        } else {
            $error = json_decode($response, true);
            return ['status' => false, 'error' => $error['error']['message'] ?? 'An error occurred'];
        }
    }

    public function send_dispute_email_client($name, $email_address)
    {


        $logolink    = base_url() . 'assets/images/logo.png';
        $site_link   = base_url('client-login');
        $date        = date('Y-m-d');

        $welcome_message = '<div class="table-responsive mb-4"><table style="background:#F2F2F2; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 20px;"><table style="width: 650px; text-align: justify;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 30px 20px 30px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($name) . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">With the help of The Federal Trade Commission enforcing The Fair Credit Reporting ACT(FCRA), which promotes the accuracy of information in the files of the nations credit reporting agencies, we have the power to challenge every questionable negative item on your behalf.<br><br>At your direction, here are the items we challenged on ' . $date . ':<br><br>Misc. letter<br><br>Responses typically take up to 60 days. Check your secureClientAccess.com account periodically for a complete view of updated information. In the event you receive any correspondence from the credit bureaus or one of your creditors, please forward copies to us right away so we can update our records.<br><br>If you have any questions, feel free to contact us at (856)515-6408, between the hours of 9 am to 5 pm. For your convenience, you can also email a member of your team at info@thecreditrepairxperts.com. We will respond within 1 business day.</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="text-align: center;"></td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060"></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br><br> Your Team at The Credit Repair Xperts</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

        $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');
  
        $this->email->initialize($email_config);
        $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
        $this->email->to($email_address);
        $this->email->subject('Challenges sent on your Behalf');
  
        $this->email->message($welcome_message);
        $this->email->send();

        return 1;
    }


    public function generate_pdf($letters,$client_id) {
        
    $this->load->library('m_pdf');
    $pdf = $this->m_pdf->load();
    $pdf->WriteHTML($letters);
    $pdf->Output('downloads/dispute_letter/credit_dispute_letter_' . $client_id . '.pdf', 'F');
    }


}
