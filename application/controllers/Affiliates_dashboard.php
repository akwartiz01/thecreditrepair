<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Affiliates_dashboard extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
   $this->load->library('upload');
      $this->load->model('User_model');



        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
    }

    public function account()
    {
   
        $data['theme'] = 'affiliates';
        $this->data['page'] = 'dashboard/account';
        $userID = $this->session->userdata('affiliates_user_id');
 
          $where['sq_affiliates_id'] = $userID;
      $getAffiliate = $this->User_model->select_where('sq_affiliates', $where);
      $client_result = $getAffiliate->result();
          if ($getAffiliate->num_rows() > 0) {
        $data['client_result'] = $getAffiliate->result();
      }
      $this->data['getAffiliate'] = $getAffiliate->result();

        $this->load->vars($this->data);
         $this->load->view('affiliates/template', $data);
    
    }
    
     public function sendreferral()
    {
        $data['theme'] = 'affiliates';
        $this->data['page'] = 'sendreferral';
        $userID = $this->session->userdata('affiliates_user_id');
        $this->load->vars($this->data);
         $this->load->view('affiliates/template', $data);
 
    }
    public function myreferrals()
    {
        $data['theme'] = 'affiliates';
        $this->data['page'] = 'myreferrals';
        $userID = $this->session->userdata('affiliates_user_id');
        $this->load->vars($this->data);
         $this->load->view('affiliates/template', $data);
 
    }
    public function webleadform()
    {
        $data['theme'] = 'affiliates';
        $this->data['page'] = 'webleadform';
        $userID = $this->session->userdata('affiliates_user_id');
        $this->load->vars($this->data);
         $this->load->view('affiliates/template', $data);
 
    }
    public function creditinfo()
    {
        $data['theme'] = 'affiliates';
        $this->data['page'] = 'creditinfo';
        $userID = $this->session->userdata('affiliates_user_id');
        $this->load->vars($this->data);
         $this->load->view('affiliates/template', $data);
 
    }
    public function resources()
    {
        $data['theme'] = 'affiliates';
        $this->data['page'] = 'resources';
        $this->load->vars($this->data);
         $this->load->view('affiliates/template', $data);
 
    }
    public function messages()
    {
      $this->data['page'] = 'messages';
       $data['theme'] = 'affiliates';
      $this->load->vars($this->data);
      $this->load->view('affiliates/template',$data);
 
    }
     public function saveClient() {
        // Get the post data
        $firstName = $this->input->post('firstName');
        $lastName = $this->input->post('lastName');
        $email = $this->input->post('email');
        $noEmail = $this->input->post('noEmail');
        $dob = $this->input->post('dob');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $county = $this->input->post('county');
        $zip = $this->input->post('zip');
        $memo = $this->input->post('memo');
        $filePath = null;

// if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != '') {
//     $config['upload_path'] = './uploads/';
//     $config['allowed_types'] = 'jpg|jpeg|png|pdf|docx';
//     $config['max_size'] = 1024 * 5;

//     $this->upload->initialize($config);

//     if (!$this->upload->do_upload('filePath')) {
//         echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
//         return;
//     } else {
//         $uploadData = $this->upload->data();
//         $filePath = $uploadData['file_name'];
//     }
// }


if(!empty($email)){
// Check if email already exists
$this->db->where('sq_email', $email);
$exists = $this->db->get('sq_clients')->row();

if ($exists) {
    echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
    return;
}
}
 $userID = $this->session->userdata('affiliates_user_id');
// Data array
$clientData = [
    'sq_u_id' => 1,
    'sq_first_name' => $firstName,
    'sq_last_name' => $lastName,
    'sq_email' => $email,
    'sq_dob' => $dob,
    'sq_mailing_address' => $address,
    'sq_city' => $city,
    'sq_state' => $state,
    'sq_country' => $county,
    'sq_zipcode' => $zip,
    'memo' => $memo,
    'sq_referred_by'=>$userID,
    'profile_img' => $filePath,
];

// Insert into DB
$this->db->insert('sq_clients', $clientData);

if ($this->db->affected_rows() > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Client information saved successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save client information.']);
}


    }
    
    public function updateProfile()
{
    $postData = $this->input->post();

    $data = [
        'sq_affiliates_first_name'   => $postData['first_name'] ?? '',
        'sq_affiliates_last_name'    => $postData['last_name'] ?? '',
        'sq_affiliates_gender'                     => $postData['gender'] ?? '',
        'sq_affiliates_company'      => $postData['company'] ?? '',
        'sq_affiliates_website_url'  => $postData['website'] ?? '',
        'sq_affiliates_phone'        => $postData['phone'] ?? '',
        'sq_affiliates_alternate_phone' => $postData['alt_phone'] ?? '',
        'sq_affiliates_fax'          => $postData['fax'] ?? '',
    ];

    $email = $postData['email'] ?? '';

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
        return;
    }

    $this->db->where('sq_affiliates_email', $email);
    $updated = $this->db->update('sq_affiliates', $data);

    if ($updated) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No changes were made or update failed.']);
    }
}

public function profile_setting()
{
    $currentPassword = $this->input->post('current_password');
    $newPassword = $this->input->post('new_password');
    $confirmPassword = $this->input->post('confirm_password');

    $id = $this->session->userdata('affiliates_user_id'); // Adjust based on your session key

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
        return;
    }

    // Get current password from DB
    $user = $this->db->get_where('sq_affiliates', ['sq_affiliates_id' => $id])->row();

    // if (!$user || !password_verify($currentPassword, $user->sq_affiliates_password)) {
    //     echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
    //     return;
    // }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'New password and confirmation do not match.']);
        return;
    }

    $hashedPassword = base64_encode($newPassword);
    $this->db->where('sq_affiliates_id', $id);
    $updated = $this->db->update('sq_affiliates', ['sq_affiliates_password' => $hashedPassword]);

    if ($updated) {
        echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password update failed.']);
    }
}
public function verify_current_password()
{
    $currentPassword = $this->input->post('current_password');
    $id = $this->session->userdata('affiliates_user_id'); // Replace with your actual session key

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        return;
    }

    $user = $this->db->get_where('sq_affiliates', ['sq_affiliates_id ' => $id])->row();

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        return;
    }
  
if ($currentPassword === base64_decode($user->sq_affiliates_password)) {
    echo json_encode(['status' => 'correct', 'message' => 'Password verified']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
}

}


public function search_clients()
{
    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $status = $this->input->post('status');
 $userID = $this->session->userdata('affiliates_user_id');

    $this->db->select('sq_first_name, sq_email, status');
    $this->db->from('sq_clients');

    if (!empty($name)) {
        $this->db->like('sq_first_name', $name);
    }

    if (!empty($email)) {
        $this->db->like('sq_email', $email);
    }

    if (!empty($status)) {
        $this->db->where('status', $status);
    }
$this->db->where('sq_referred_by', $userID); 
    $query = $this->db->get();
    $clients = $query->result();

    echo json_encode(['status' => 'success', 'clients' => $clients]);
}
 
}
