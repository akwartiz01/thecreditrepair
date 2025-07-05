<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/phpmailer/src/Exception.php';
require FCPATH . 'vendor/phpmailer/src/PHPMailer.php';
require FCPATH . 'vendor/phpmailer/src/SMTP.php';

class Subscriber extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('user_type') == 'client') {
            redirect(base_url('client/dashboard'));
            exit;
        }

        $this->load->model('User_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->load->library('Maverick_payment_gateway');

        $this->data['theme'] = 'subscriber';

        if ($this->session->userdata('user_id') == '') {
            redirect(base_url());
            exit;
        }
    }

    public function index()
    {
        if (isset($userID)) {

            $where['sq_u_id'] = $userID;
            $getUser = $this->User_model->select_where('sq_users', $where);
            $getUser = $getUser->result();

            if ($getUser[0]->sq_u_type == 3) {
                redirect(base_url() . 'subscriber/dashboard');
            } else {
                redirect(base_url() . 'admin');
            }
        } else {

            $this->signin();
        }
    }



    public function dashboard()
    {

        $this->data['page'] = 'dashboard';
        $user_id = $this->session->userdata('user_id');

        $fetchdata = $this->User_model->query("SELECT * FROM sq_subscription_payment_details WHERE sq_u_id_subscriber = $user_id");
        $fetchdata = $fetchdata->result();

        $this->data['plan_id'] = $fetchdata[0]->subscription_id;
        $this->data['user_id'] = $user_id;

        $this->data['plans'] = $this->db->where("status", 1)->order_by('sort_order', 'ASC')->get('sq_subscription_plans')->result_array();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function subscription()
    {

        $this->data['page'] = 'subscription';
        $user_id = $this->session->userdata('user_id');

        $fetchdata = $this->User_model->query("SELECT * FROM sq_subscription_payment_details WHERE sq_u_id_subscriber = $user_id");
        $fetchdata = $fetchdata->result();

        $this->data['plan_id'] = $fetchdata[0]->subscription_id;
        $this->data['user_id'] = $user_id;

        $this->data['plans'] = $this->db->where("status", 1)->get('sq_subscription_plans')->result_array();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function clients_list()
    {
        $user_id = $this->session->userdata('user_id');

        $fetchdata = $this->User_model->query("SELECT * FROM sq_subscriber_clients WHERE sq_u_id_subscriber = $user_id");

        $this->data['lists'] = $fetchdata->result();

        $this->data['page'] = 'clients';
        $this->data['get_allusers_name'] = $this->get_allusers_name();
        $this->data['get_allaffiliate_name'] = $this->get_allaffiliate_name();
        $this->data['get_allaffiliate_company'] = $this->get_allaffiliate_company();

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
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

    public function add_client()
    {
        $this->data['page'] = 'add_client';
        $this->data['get_allusers_name'] = $this->get_allusers_name();
        $this->data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_new_client()
    {
        $user_id = $this->session->userdata('user_id');

        $payment_details = $this->User_model->query("SELECT * FROM sq_subscription_payment_details WHERE sq_u_id_subscriber = $user_id");
        $payment_details = $payment_details->result();

        $client_details = $this->User_model->query("SELECT * FROM sq_subscriber_clients WHERE sq_u_id_subscriber = $user_id");
        $client_details = $client_details->result();
        $clients_permission = $payment_details[0]->clients_permission;

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $this->db->where('sq_email', $email);
            $existingClient = $this->db->get('sq_subscriber_clients')->row();

            if ($existingClient) {
                echo json_encode(['status' => 'error', 'message' => 'Client already exists.']);
                return;
            }
            if (count($client_details) >= $clients_permission) {
                echo json_encode(['status' => 'error', 'message' => 'You have reached the limit of ' . $clients_permission . ' clients. Please upgrade your plan to add more clients.']);
                return;
            } else {
                $insertData = array(
                    'sq_u_id_subscriber'    => $user_id,
                    'sq_first_name'         => $this->input->post('first_name'),
                    'sq_middle_name'        => $this->input->post('middle_name'),
                    'sq_last_name'          => $this->input->post('last_name'),
                    'sq_suffix'             => $this->input->post('suffix'),
                    'sq_email'              => $email,
                    'sq_ssn'                => $this->input->post('ssn'),
                    'sq_phone_home'         => $this->input->post('phone_home'),
                    'sq_phone_work'         => $this->input->post('phone_work'),
                    'sq_phone_mobile'       => $this->input->post('phone_mobile'),
                    'sq_fax'                => $this->input->post('fax'),
                    'sq_mailing_address'    => $this->input->post('mailing_address'),
                    'sq_city'               => $this->input->post('city'),
                    'sq_state'              => $this->input->post('state'),
                    'sq_zipcode'            => $this->input->post('zipcode'),
                    'sq_country'            => $this->input->post('country'),
                    'sq_status'             => $this->input->post('status'),
                    'sq_assigned_to'        => $this->input->post('assigned'),
                    'sq_referred_by'        => $this->input->post('referred'),
                    'sq_date_of_start'      => date('Y-m-d', strtotime($this->input->post('date_of_start'))),
                    'sq_dob'                => date('Y-m-d', strtotime($this->input->post('dob'))),
                    'sq_portal_access'      => $this->input->post('portalAccess'),
                    'client_days'           => $this->input->post('client_days')
                );

                $this->User_model->insertdata('sq_subscriber_clients', $insertData);
                $lastid = $this->db->insert_id();

                ///////////////////////////////////Profile Image s/////////////////////////////////////

                $sq_client_id = $lastid;

                if (!empty($_FILES['imgupload']['name'])) {

                    $upload_dir = FCPATH . 'upload/subscriber/client-profile-image/' . $sq_client_id;

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    // Check if an existing profile image needs to be deleted
                    $where['sq_client_id'] = $sq_client_id;
                    $getData = $this->User_model->select_where('sq_subscriber_clients', $where);
                    $result = $getData->row();
                    if ($result && !empty($result->profile_img)) {
                        $existing_image_path = FCPATH . 'upload/subscriber/client-profile-image/' . $sq_client_id . '/' . basename($result->profile_img);
                        if (file_exists($existing_image_path)) {
                            unlink($existing_image_path); // Delete the old image
                        }
                    }

                    // File upload configuration
                    $config['upload_path']   = $upload_dir;
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size']      = 2048;
                    $config['file_name']     = 'profile_' . time(); // Rename the uploaded file
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('imgupload')) {
                        // Update the new image path
                        $file_data = $this->upload->data();
                        $update['profile_img'] = base_url() . 'upload/subscriber/client-profile-image/' . $sq_client_id . '/' . $file_data['file_name'];
                        $this->User_model->updatedata('sq_subscriber_clients', array("sq_client_id" => $sq_client_id), $update);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()]);
                        return;
                    }
                }

                ///////////////////////////////////Profile Image e/////////////////////////////////////

                $data['client_id']  = $lastid;
                $data['sname']      = $this->input->post('sname');
                $data['sphone']     = $this->input->post('sphone');
                $data['semail']     = $this->input->post('semail');
                $data['ssocial']    = $this->input->post('ssocial');
                $data['sdob']       = $this->input->post('sdob');

                $this->User_model->insertdata('sq_spouse', $data);

                $this->allActivity('Client (' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ') added successfully!');

                echo json_encode(['status' => 'success', 'message' => 'Client added successfully!']);
            }
        }
    }

    public function edit_client()
    {

        $url_data  = base64_decode(base64_decode($this->uri->segment(2)));
        $myClientFetch = $this->User_model->query("SELECT * FROM sq_subscriber_clients WHERE sq_client_id = '" . $url_data . "'");
        if ($myClientFetch->num_rows() > 0) {
            $resultMyClients = $myClientFetch->result();
            $this->data['resultMyClients'] = $resultMyClients;
        } else {
            $this->data['resultMyClients'] = '';
        }

        $this->data['page'] = 'edit_client';
        $this->data['get_allusers_name'] = $this->get_allusers_name();
        $this->data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function update_client()
    {
        if ($this->input->post()) {

            $data['sq_first_name']          =  $this->input->post('first_name');
            $data['sq_middle_name']         =  $this->input->post('middle_name');
            $data['sq_last_name']           =  $this->input->post('last_name');
            $data['sq_suffix']              =  $this->input->post('suffix');
            $data['sq_email']               =  $this->input->post('email');
            $data['sq_ssn']                 =  $this->input->post('ssn');
            $data['sq_phone_home']          =  $this->input->post('phone_home');
            $data['sq_phone_work']          =  $this->input->post('phone_work');
            $data['sq_phone_mobile']        =   $this->input->post('phone_mobile');
            $data['sq_fax']                 =  $this->input->post('fax');
            $data['sq_mailing_address']     =  $this->input->post('mailing_address');
            $data['sq_city']                =  $this->input->post('city');
            $data['sq_state']               =  $this->input->post('state');
            $data['sq_zipcode']             =  $this->input->post('zipcode');
            $data['sq_country']             =  $this->input->post('country');
            $data['sq_status']              =  $this->input->post('status');
            $data['sq_assigned_to']         =  $this->input->post('assigned');
            $data['sq_referred_by']         =  $this->input->post('referred');
            $data['sq_date_of_start']       =  date('Y-m-d', strtotime($this->input->post('date_of_start')));
            $data['sq_dob']                 =  date('Y-m-d', strtotime($this->input->post('dob')));
            $data['sq_portal_access']       =  $this->input->post('portalAccess');
            $data['client_days']            =  $this->input->post('client_days');
            $data['sq_email_check']         =  $this->input->post('sq_email_check');

            $sq_client_id = $this->input->post('hiddenRowId');

            if (!empty($_FILES['imgupload']['name'])) {

                $upload_dir = FCPATH . 'upload/subscriber/client-profile-image/' . $sq_client_id;

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Check if an existing profile image needs to be deleted
                $where['sq_client_id'] = $sq_client_id;
                $getData = $this->User_model->select_where('sq_subscriber_clients', $where);
                $result = $getData->row();
                if ($result && !empty($result->profile_img)) {
                    $existing_image_path = FCPATH . 'upload/subscriber/client-profile-image/' . $sq_client_id . '/' . basename($result->profile_img);
                    if (file_exists($existing_image_path)) {
                        unlink($existing_image_path); // Delete the old image
                    }
                }

                // File upload configuration
                $config['upload_path']   = $upload_dir;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['file_name']     = 'profile_' . time(); // Rename the uploaded file
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('imgupload')) {
                    // Update the new image path
                    $file_data = $this->upload->data();
                    $data['profile_img'] = base_url() . 'upload/subscriber/client-profile-image/' . $sq_client_id . '/' . $file_data['file_name'];
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()]);
                    return;
                }
            }

            $where['sq_client_id']      = $this->input->post('hiddenRowId');
            $this->User_model->updatedata('sq_subscriber_clients', $where, $data);
            $this->allActivity('Client (' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ') updated successfully!');
            // redirect(base_url() . 'dashboard/' . get_encoded_id($this->input->post('hiddenRowId')));

            echo json_encode(['status' => 'success', 'message' => 'Client updated successfully!']);
        }
    }

    public function deleteClient()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $deleteClient = $this->User_model->query("DELETE FROM sq_subscriber_clients where sq_client_id = '" . $id . "' ");
            $this->allActivity('client removed successfully!');
            echo json_encode(['status' => 'success', 'message' => 'deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID is required']);
        }
    }

    public function upgrade_subscription()
    {
        $user_id = $this->input->post('user_id');
        $amount = $this->input->post('amount');
        $ccnumber = $this->input->post('ccnumber');
        $ccexp = $this->input->post('ccexp');
        $cvv = $this->input->post('cvv');
        $save_card = $this->input->post('save_card');
        $subscription_id = $this->input->post('subscription_id');

        $fetchdata = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id = $user_id");
        $fetchdata = $fetchdata->result();

        $first_name = $fetchdata[0]->sq_u_first_name;
        $last_name = $fetchdata[0]->sq_u_last_name;
        $email = $fetchdata[0]->sq_u_email_id;

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        $plan_details = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE `id` = $subscription_id");
        $plan_details = $plan_details->result();

        $subscription_name = $plan_details[0]->subscription_name;
        $duration = $plan_details[0]->subscription_duration;
        $team_permission = $plan_details[0]->team_permission;
        $clients_permission = $plan_details[0]->clients_permission;
        $subscription_price = $plan_details[0]->price;
        $storage_permission = $plan_details[0]->storage_permission;
        $subscription_start_date = date("Y-m-d");
        $subscription_end_date = date("Y-m-d", strtotime("+$duration"));

        $result = $this->maverick_payment_gateway->doSale($amount, $ccnumber, $ccexp, $cvv);

        if ($result == APPROVED) {
            $data = array(
                'payment_status' => 1,
                'card_number' => $ccnumber,
                'exp_date' => $ccexp,
                'cvc' => $cvv,
                'save_card' => $save_card,
                'subscription_id' => $subscription_id,
                'team_permission' => $team_permission,
                'clients_permission' => $clients_permission,
                'subscription_price' => $subscription_price,
                'storage_permission' => $storage_permission,
                'subscription_start_date' => $subscription_start_date,
                'subscription_end_date' => $subscription_end_date

            );
          
            $this->User_model->updatedata('sq_subscription_payment_details', array('sq_email' => $email), $data);
            $this->send_subscription_email($email, $amount, $subscription_name);
            $response = ['success' => true, 'message' => 'Your payment was successful!'];
        } elseif ($result == DECLINED) {
            $response = ['success' => false, 'message' => 'Declined!'];
        } else {
            $response = ['success' => false, 'message' => 'Error!'];
        }

        echo json_encode($response);
    }

    public function team_member_list()
    {

        $user_id = $this->session->userdata('user_id');

       //$fetchdata = $this->User_model->query("SELECT * FROM sq_users WHERE `user_id` = '" . $user_id . "'");
        $fetchdata = $this->User_model->query("SELECT * FROM sq_users WHERE `added_by` = '" . $user_id . "'");
        $this->data['team_member_list'] = $fetchdata->result();

        $this->data['page'] = 'team_member_list';
        $this->data['get_allusers_name'] = $this->get_allusers_name();
        $this->data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function add_team_member()
    {

        $this->data['page'] = 'add_team_member';
        $this->data['get_allusers_name'] = $this->get_allusers_name();
        $this->data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_new_team_member()
    {
        $user_id = $this->session->userdata('user_id');


        // Fetch payment and team member details
        $payment_details = $this->User_model->select_where('sq_subscription_payment_details', ['sq_u_id_subscriber' => $user_id])->result();
        $team_member_details = $this->User_model->select_where('sq_users', ['added_by' => $user_id])->result();
        $team_permission = $payment_details[0]->team_permission;

        if ($this->input->post()) {
            $email = $this->input->post('email');

            // Check if team member already exists
            $existingTeamMember = $this->User_model->select_where('sq_users', ['sq_u_email_id' => $email])->row();
            if ($existingTeamMember) {
                echo json_encode(['status' => 'error', 'message' => 'Team member already exists.']);
                return;
            }

            // Check team member limit
            if (count($team_member_details) >= $team_permission) {
                echo json_encode(['status' => 'error', 'message' => 'You have reached the limit of ' . $team_permission . ' team members. Please upgrade your plan to add more team members.']);
                return;
            }

            // Prepare team member data
            $employee_data = [
                'sq_u_first_name' => $this->input->post('first_name'),
                'sq_u_last_name' => $this->input->post('last_name'),
                'sq_u_email_id' => $email,
                'sq_u_user_id' => $this->input->post('user_id'),
                'sq_u_type' => 3,
                'sq_u_phone' => $this->input->post('phone'),
                'sq_u_mobile' => $this->input->post('mobile'),
                'sq_u_title' => $this->input->post('title_for_portal'),
                'sq_u_fax' => $this->input->post('fax'),
                'sq_u_address' => $this->input->post('address'),
                'sq_u_apassword' => $this->input->post('password'),
                'sq_u_password' => md5($this->input->post('password')),
                'sq_u_gender' => $this->input->post('gender'),
                'sq_u_sys_login' => $this->input->post('send_login_info'),
                'added_by'=>$user_id
            ];

            // Send login information if needed
            if ($this->input->post("send_login_info") == 1) {
                $this->send_login_email($employee_data['sq_u_first_name'], $employee_data['sq_u_last_name'], $employee_data['sq_u_email_id'], $employee_data['sq_u_apassword']);
            }

            // Insert team member data
            $this->User_model->insertdata('sq_users', $employee_data);
            $lastid = $this->db->insert_id();
            $this->allActivity('Team member (' . $employee_data['sq_u_first_name'] . ' ' . $employee_data['sq_u_last_name'] . ') added successfully!');

            // Handle profile image upload
            $upload_dir = FCPATH . 'upload/subscriber/team-member-profile-image/' . $lastid;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $where['sq_u_id'] = $lastid;
            $getData = $this->User_model->select_where('sq_users', $where);
            $_result = $getData->row();

            $profile_img_url = $_result->sq_u_profile_picture;

            if (!empty($profile_img_url)) {

                $parts = explode('/', $profile_img_url);

                $profile_img = end($parts);

                if (!empty($_result->sq_u_profile_picture)) {
                    $existing_image_path = $upload_dir . '/' . $profile_img;

                    if (file_exists($existing_image_path)) {
                        unlink($existing_image_path);
                    }
                }
            }

            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'profile_' . time();  // Rename the uploaded file
            $this->load->library('upload', $config);
if (!empty($_FILES['imgupload']['name'])) {
    if (!$this->upload->do_upload('imgupload')) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()
        ]);
        return;
    }

    // Update profile picture in the database
    $file_data = $this->upload->data();
    $image_path = base_url() . 'upload/subscriber/team-member-profile-image/' . $lastid . '/' . $file_data['file_name'];
    $this->User_model->updatedata('sq_users', ['sq_u_id' => $lastid], ['sq_u_profile_picture' => $image_path]);
}

            // Final success message
            echo json_encode(['status' => 'success', 'message' => 'Team member added successfully!']);
        }
    }


    public function edit_team_member()
    {

        $urisegment = $this->uri->segment(2);
        $checkID = base64_decode(urldecode($urisegment));
        $decodedID = number_format(($checkID * 12345) / 12345678);

        $empID = str_replace(',', '', $decodedID);

        $this->data['empID'] =  $empID;

        $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id = '" . $empID . "'");
        if ($myEmpFetch->num_rows() > 0) {
            $resultMyEmp = $myEmpFetch->result();
            $this->data['resultMyEmp'] = $resultMyEmp;
        } else {
            $this->data['resultMyEmp'] = '';
        }

        $this->data['page'] = 'edit_team_member';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function update_team_member()
    {
        if ($this->input->post()) {
            $sq_u_id = $this->input->post('hidEmpId');

            // Prepare data for update
            $data = [
                'sq_u_first_name'  => $this->input->post('first_name'),
                'sq_u_last_name'   => $this->input->post('last_name'),
                'sq_u_email_id'    => $this->input->post('email'),
                'sq_u_phone'       => $this->input->post('phone'),
                'sq_u_mobile'      => $this->input->post('mobile'),
                'sq_u_title'       => $this->input->post('title_for_portal'),
                'sq_u_fax'         => $this->input->post('fax'),
                'sq_u_address'     => $this->input->post('address'),
                'sq_u_gender'      => $this->input->post('gender'),
                'sq_u_sys_login'   => $this->input->post('send_login'),
                'sq_u_apassword'   => $this->input->post('password'),
                'sq_u_password'    => md5($this->input->post('password')),
            ];

            // Handle profile image upload if a file is selected
            if (!empty($_FILES['imgupload']['name'])) {
                $upload_dir = FCPATH . 'upload/subscriber/team-member-profile-image/' . $sq_u_id;
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Check if an existing profile image needs to be deleted
                $where['sq_u_id'] = $sq_u_id;
                $getData = $this->User_model->select_where('sq_users', $where);
                $_result = $getData->row();
                if ($_result && !empty($_result->sq_u_profile_picture)) {
                    $existing_image_path = FCPATH . 'upload/subscriber/team-member-profile-image/' . $sq_u_id . '/' . basename($_result->sq_u_profile_picture);
                    if (file_exists($existing_image_path)) {
                        unlink($existing_image_path); // Delete the old image
                    }
                }

                // File upload configuration
                $config['upload_path']   = $upload_dir;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['file_name']     = 'profile_' . time(); // Rename the uploaded file
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('imgupload')) {
                    // Update the new image path
                    $file_data = $this->upload->data();
                    $data['sq_u_profile_picture'] = base_url() . 'upload/subscriber/team-member-profile-image/' . $sq_u_id . '/' . $file_data['file_name'];
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()]);
                    return;
                }
            }

            // Update team member data in the database
            $this->User_model->updatedata('sq_users', ['sq_u_id' => $sq_u_id], $data);

            // Send login email if required
            if ($this->input->post("send_login") == 1) {
                $this->send_login_email($data['sq_u_first_name'], $data['sq_u_last_name'], $data['sq_u_email_id'], $this->input->post('user_id'), $data['sq_u_apassword']);
            }

            // Log activity and return success response
            $this->allActivity('Team member (' . $data['sq_u_first_name'] . ' ' . $data['sq_u_last_name'] . ') profile information saved successfully!');
            echo json_encode(['status' => 'success', 'message' => 'Team member updated successfully!']);
        }
    }



    public function deleteTeam_Member()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $deleteClient = $this->User_model->query("DELETE FROM sq_users where sq_u_id = '" . $id . "' ");
            $this->allActivity('tean member removed successfully!');
            echo json_encode(['status' => 'success', 'message' => 'deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID is required']);
        }
    }

    public function my_company()
    {

        $this->data['page'] = 'my_company';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function credit_monitoring()
    {
        $user_id = $this->session->userdata('user_id');
        $fetchdata = $this->User_model->query("SELECT * FROM sq_subscriber_clients WHERE `sq_u_id_subscriber` = '" . $user_id . "'");
        $this->data['client_list'] = $fetchdata->result();

        $this->data['user_id'] = $user_id;
        $this->data['page'] = 'credit_monitoring';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function crx_hero_invite()
    {
        $sq_client_id = $this->input->post('sq_client_id');
        $client_table = $this->input->post('client_table');
        if (!empty($client_table)) {

            $fetchdata = $this->User_model->query("SELECT * FROM sq_clients WHERE `sq_client_id` = '" . $sq_client_id . "'");
        } else {
            $fetchdata = $this->User_model->query("SELECT * FROM sq_subscriber_clients WHERE `sq_client_id` = '" . $sq_client_id . "'");
        }
        if ($fetchdata->num_rows() > 0) {

            $fetchdata = $fetchdata->result();
            $name = $fetchdata[0]->sq_first_name . ' ' . $fetchdata[0]->sq_last_name;
            $email = $fetchdata[0]->sq_email;
            $security_code = $this->generate_code(16);
            $this->send_crx_hero_invite_email($name, $email, $security_code);

            $updation['security_code'] = $security_code;
            $updation['security_code_time'] = date('Y-m-d H:i:s');

            $where['sq_client_id'] = $sq_client_id;
            if (!empty($client_table)) {
                $this->User_model->updatedata('sq_clients', $where, $updation);
            } else {

                $this->User_model->updatedata('sq_subscriber_clients', $where, $updation);
            }
            echo json_encode(['status' => 'success', 'message' => 'Invited']);
        }
    }


    public function send_crx_hero_invite_email($name, $email, $security_code)
    {
        if ($email != '') {

            $link        = "https://crxhero.com/sign-up";

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
                                                    <p style="font-family:Google Sans; font-size:16px; color:#606060;">Welcome to CRX Credit Repair, glad to meet you!</p><p style="font-family:Helvetica,Arial,sans-serif; font-size:15px; color:#606060;">To get started on your credit repair journey, we need to access your reports and scores from all 3 bureaus. It\'ll only take two minutes of your time.</p><p>So let\'s get you set up for credit monitoring!</p><br><div style="text-align:center;"><a href="' . $link . '" style="background-color:#0558b5; color:#fff; border:none; padding:10px 10px; font-size:15px; cursor:pointer; border-radius: 4px; text-decoration: none">Get Started</a></div><p style="font-family:Helvetica,Arial,sans-serif; font-size:15px; color:#606060;">This message was sent by CRX Credit Repair | (856) 515-6408</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>';

   
            $this->load->config('email_custom');
            $email_config = $this->config->item('email_config');
      
            $this->email->initialize($email_config);
            $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
            $this->email->to($email);
            $this->email->subject('Invite for Credit Hero Score Signup');
      
            $this->email->message($message);
            $this->email->send();

            return '1';
        }
    }

    function generate_code($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
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
                </td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 50px 20px 50px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($fname) . ' ' . $lname . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">We are excited to inform you that your subscription has been successfully upgraded to the <b>' . $subscription_name . '</b> of <b>$' . $amount . '</b>.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Here are your login details for CRX Credit Repair:</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $username . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $password . '</td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely, and monitor your overall progress.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                $this->load->config('email_custom');
                $email_config = $this->config->item('email_config');
          
                $this->email->initialize($email_config);
                $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
                $this->email->to($email_address);
                $this->email->subject('our Subscription Has Been Successfully Upgraded!');
          
                $this->email->message($password_message);
                $this->email->send();

                return '1';
            } else {

                echo 'This email is not associated with any account!';
            }
        } else {
            echo 'Email field required!';
        }
    }

    public function allActivity($msg)
    {

        $loginID = $this->session->userdata('user_id');
        $datetime = date('Y-m-d H:i:s a');

        $data['user_id']        = $loginID;
        $data['msg']            = $msg;
        $data['datetime']       = $datetime;
        $this->User_model->insertdata('sq_all_activity', $data);

        return;
    }

    public function profile_setting()
    {
        if ($this->session->userdata('user_type') == 'subscriber') {

            $sq_u_id = $this->session->userdata('user_id');
            $user_type = $this->session->userdata('user_type');

            $where['sq_u_id'] = $sq_u_id;
            $getSubscriber = $this->User_model->select_where('sq_users', $where);
            $subscriber_result = $getSubscriber->row();


            if ($this->input->post()) {
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');

                if ($new_password !== $confirm_password) {
                    echo json_encode(['status' => 'error', 'message' => 'New password and confirmation password do not match.']);
                    return;
                }


                if ($current_password != $subscriber_result->sq_u_apassword) {
                    echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
                    return;
                }

                $new_password_md5 = md5($new_password);

                $update = array(
                    "sq_u_password" => $new_password_md5,
                    "sq_u_apassword" => $new_password
                );

                if (!empty($sq_u_id) && $user_type == 'subscriber') {
                    $this->User_model->updatedata('sq_users', array("sq_u_id" => $sq_u_id), $update);
                    echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
                }
            } else {
                $this->data['page'] = 'subscriber_profile_setting';
                $this->data['subscriber_result'] = $subscriber_result;
                $this->load->vars($this->data);
                $this->load->view($this->data['theme'] . '/template');
            }
        } else {
            redirect(base_url('subscriber/login'));
        }
    }

    public function verify_current_password()
    {
        if ($this->session->userdata('user_type') == 'subscriber') {
            $sq_u_id = $this->session->userdata('user_id');
            $current_password = $this->input->post('current_password');

            $where['sq_u_id'] = $sq_u_id;
            $getSubscriber = $this->User_model->select_where('sq_users', $where);
            $subscriber_result = $getSubscriber->row();

            if ($current_password == $subscriber_result->sq_u_apassword) {
                echo json_encode(['status' => 'correct']);
            } else {
                echo json_encode(['status' => 'incorrect']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        }
    }

    public function update_profile()
    {
        if ($this->session->userdata('user_type') == 'subscriber') {
            $sq_u_id = $this->session->userdata('user_id');

            // Define client images directory
            $subscriber_images_dir = FCPATH . 'upload/subscriber/profile-image/' . $sq_u_id;


            // Create directory if it doesn't exist
            if (!is_dir($subscriber_images_dir)) {
                mkdir($subscriber_images_dir, 0755, true);
            }

            // Get the current client profile image from the database
            $where['sq_u_id'] = $sq_u_id;
            $getSubscriber = $this->User_model->select_where('sq_users', $where);
            $subscriber_result = $getSubscriber->row();


            $profile_img_url = $subscriber_result->sq_u_profile_picture;

            $parts = explode('/', $profile_img_url);

            // The last part will be the file name
            $profile_img = end($parts);


            // Check if there is an existing profile image
            if (!empty($subscriber_result->sq_u_profile_picture)) {
                $existing_image_path = $subscriber_images_dir . '/' . $profile_img;

                // Delete the previous profile image if it exists
                if (file_exists($existing_image_path)) {
                    unlink($existing_image_path);
                }
            }

            // Set up file upload configuration
            $config['upload_path'] = $subscriber_images_dir;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload new profile picture
            if (!$this->upload->do_upload('imgupload')) {
                $error = $this->upload->display_errors();
                echo json_encode(['status' => 'error', 'message' => 'Unable to update profile. ' . $error]);
                return;
            } else {
                $file_data = $this->upload->data();
                $imgupload = $file_data['file_name'];
                $image_path = base_url() . 'upload/subscriber/profile-image/' . $sq_u_id . '/' . $imgupload;
                // Update profile image in the database
                $update = array(
                    "sq_u_profile_picture" => $image_path
                );
                $this->User_model->updatedata('sq_users', array("sq_u_id" => $sq_u_id), $update);

                echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
            }
        } else {
            redirect(base_url('subscriber/login'));
        }
    }

    public function cancel_subscription()
    {
        $subscriberId = $this->input->post('subscriberId');

        $fetchdata = $this->User_model->query("SELECT * FROM sq_subscription_payment_details WHERE `sq_u_id_subscriber` = '" . $subscriberId . "'");

        if ($fetchdata->num_rows() > 0) {

            $fetchdata = $fetchdata->result();

            $updation['payment_status'] = 0;
            $updation['card_number'] = null;
            $updation['subscription_start_date'] = null;
            $updation['subscription_end_date'] = null;
            $updation['exp_date'] = null;
            $updation['cvc'] = null;
            $updation['save_card'] = null;

            $where['sq_u_id_subscriber'] = $subscriberId;

            $this->User_model->updatedata('sq_subscription_payment_details', $where, $updation);

            echo json_encode(['status' => 'success', 'message' => 'Subscription cancelled successfully!']);
        }
    }


    public function subscriber_company()
    {

        $user_id = $this->session->userdata('user_id');

        $this->data['page'] = 'subscriber_company';

        //get data of the employee  
        $user_idd = $this->session->userdata('user_id');
        $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id != '$user_idd'");
        if ($myEmpFetch->num_rows() > 0) {
            $resultMyEmp = $myEmpFetch->result();
            $this->data['resultMyEmp'] = $resultMyEmp;
        } else {
            $this->data['resultMyEmp'] = '';
        }

        //get data of the company  
        $myCompFetch = $this->User_model->query("SELECT * FROM sq_company WHERE subscriber_id = '$user_id'");
        if ($myCompFetch->num_rows() > 0) {
            $resultMyComp = $myCompFetch->result();
            $this->data['resultMyComp'] = $resultMyComp;
        } else {
            $this->data['resultMyComp'] = '';
        }

        // Get role data from role table 


        $myRoleFetch = $this->User_model->query("SELECT * FROM sq_roles ");
        if ($myRoleFetch->num_rows() > 0) {
            $resultMyRole = $myRoleFetch->result();
            $this->data['resultMyRole'] = $resultMyRole;
        } else {
            $this->data['resultMyRole'] = '';
        }


        $simple_audits = $this->User_model->query("SELECT * FROM sq_simple_audit_template ");
        if ($simple_audits->num_rows() > 0) {
            $simple_audits = $simple_audits->result();
            $this->data['simple_audits'] = $simple_audits;
        } else {
            $this->data['simple_audits'] = '';
        }

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_company()
    {
        $user_id = $this->session->userdata('user_id');
        $sq_company_id  = $this->input->post('sq_company_id');

        if ($this->input->post()) {
            $email = $this->input->post('sender_email');

            if (empty($sq_company_id)) {
                $this->db->where('sq_company_sender_email', $email);
                $existingClient = $this->db->get('sq_company')->row();
            } else {

                $this->db->where('sq_company_sender_email', $email);
                $this->db->where('sq_company_id !=', $sq_company_id);
                $existingClient = $this->db->get('sq_company')->row();
            }

            if ($existingClient) {
                echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
                return;
            }

            $data['sq_company_name']             =   $this->input->post('company_name');
            $data['sq_company_url']              =   $this->input->post('website_url');
            $data['sq_company_address']          =   $this->input->post('address');
            $data['sq_company_city']             =   $this->input->post('city');
            $data['sq_company_state']            =   $this->input->post('state');
            $data['sq_company_zip']              =   $this->input->post('zip');
            $data['sq_company_country']          =   $this->input->post('country');
            $data['sq_company_time_zone']        =   $this->input->post('time_zone');
            $data['sq_company_fax']              =   $this->input->post('fax');
            $data['sq_company_contact_no']       =   $this->input->post('phone');
            $data['sq_company_sender_name']      =   $this->input->post('sender_name');
            $data['sq_company_sender_email']     =   $this->input->post('sender_email');
            $data['sq_company_payable_company']  =   $this->input->post('payable_company');

            if (!empty($sq_company_id)) {
                $where['sq_company_id'] = $sq_company_id;
                $this->User_model->updatedata('sq_company', $where, $data);
                echo json_encode(['status' => 'success', 'message' => 'Company updated successfully!']);
            } else {
                $data['subscriber_id']               =   $user_id;
                $data['subscription_type']           =   'subscriber';
                $this->User_model->insertdata('sq_company', $data);
                echo json_encode(['status' => 'success', 'message' => 'Company added successfully!']);
            }
        }
    }

    public function send_login_email($sq_u_first_name, $sq_u_last_name, $email, $sq_u_apassword)
    {

        if ($email != '') {

            $logolink        = base_url() . 'assets/images/logo.png';
            $site_link        = base_url('sign-in');

            $password_message = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #3972FC;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Login Details</b></td></tr><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 50px 20px 50px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($sq_u_first_name) . ' ' . $sq_u_last_name . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Welcome to CRX Credit Repair</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Here are your login details for immediate access.:</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $email . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $sq_u_apassword . '</td></tr><br><tr><td> <a href="' . $site_link . '" style="background-color:#0558b5; color:#fff; border:none; padding:10px 10px; font-size:15px; cursor:pointer; border-radius: 4px; text-decoration: none">Get Started</a></td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

            $this->load->config('email_custom');
            $email_config = $this->config->item('email_config');
      
            $this->email->initialize($email_config);
            $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
            $this->email->to($email);
            $this->email->subject('Registration');
      
            $this->email->message($password_message);
            $this->email->send();

            return '1';
        } else {
            echo 'Email field required!';
        }
    }

    public function roles()
    {
        $this->data['page'] = 'roles/index';
        // $this->data['roles'] = $this->db->where("status", 1)->get('sq_subscription_plans')->result_array();
        $this->data['roles'] = $this->db->get('sq_roles')->result_array();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_roles()
    {
        $this->data['page'] = 'roles/add_roles';
        $data['role_type'] = $this->uri->segment(2);
        $data['permissions'] = 'permissions';

        $permissions_list = $this->User_model->query("SELECT * FROM sq_permission WHERE sq_p_rolename='" . $data['role_type'] . "'");
        if ($permissions_list->num_rows() > 0) {
            $data['permissions_list'] = $permissions_list->result();
        } else {
            $data['permissions_list'] = '';
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_new_role()
    {
        if ($this->input->post()) {
            $role_p_name = strtolower($this->input->post('role_name'));
            $role_name = ucfirst($this->input->post('role_name'));

            // Check if the role already exists (group by sq_p_rolename to check uniqueness)
            $this->db->select('sq_p_rolename');
            $this->db->where('sq_p_rolename', $role_name);
            $this->db->group_by('sq_p_rolename');
            $existingRole = $this->db->get('sq_permission')->row();

            if ($existingRole) {
                echo json_encode(['status' => 'error', 'message' => 'Role already exists.']);
                return;
            }

            // Add role data in permission table
            $tabname = $this->config->item('tabname');

            foreach ($tabname as $key => $tabRow) {
                $this->db->query("INSERT INTO sq_permission (`sq_p_rolename`,`sq_p_tabname`,`sq_p_add`,`sq_p_edit`,`sq_p_view`,`user_status`) VALUES('" . $role_p_name . "','" . $tabRow . "','0','0','0','subscriber')");
            }

            $data['sq_role_name']  = $role_name;
            $data['user_status']    = 'subscriber';
            $this->User_model->insertdata('sq_roles', $data);

            echo json_encode(['status' => 'success', 'message' => 'Role added successfully!']);
        }
    }
}
