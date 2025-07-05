<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{

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

    public function updateRoles()
    {
        $role_type = $this->input->post("role_type");
        $updates = $this->input->post('updates');

        if (empty($role_type) || empty($updates)) {

            echo json_encode(['status' => 'error', 'message' => 'Role type or updates missing']);
            return;
        }

        foreach ($updates as $update) {
            if (!isset($update['role']) || !isset($update['tabname'])) {
                continue;
            }

            $checked = $update['checked'];
            $role = "sq_p_" . $update['role'];
            $tabname = $update['tabname'];

            $mypermissionFetch = $this->User_model->query("SELECT * FROM sq_permission WHERE sq_p_rolename='$role_type' AND sq_p_tabname='$tabname'");
            if ($mypermissionFetch->num_rows() > 0) {
                $dataUpdate[$role] = $checked;
                $where['sq_p_rolename'] = $role_type;
                $where['sq_p_tabname'] = $tabname;
                $this->User_model->updatedata('sq_permission', $where, $dataUpdate);
            } else {
                $dataUpdate[$role] = $checked;
                $dataUpdate['sq_p_rolename'] = $role_type;
                $dataUpdate['sq_p_tabname'] = $tabname;
                $this->User_model->insertdata('sq_permission', $dataUpdate);
            }
        }

        $this->allActivity('Roles/Permissions updated successfully!');

        echo json_encode(['status' => 'success', 'message' => 'Roles updated successfully']);
    }


    public function edit_template()
    {
        if ($this->check_permisions("library", "edit") != 1) {
            return false;
        }
        $id = $this->uri->segment(2);

        if ($this->input->post()) {
            $id = $this->input->post("id");
            $category = $this->input->post("category");
            $status = $this->input->post("status");
            $letter_title = $this->input->post("letter_title");
            $content = $this->input->post("content");
            $update = array(
                'category' => $category,
                'status' => $status,
                'letter_title' => $letter_title,
                'content' => $content
            );
            $this->User_model->updatedata('sq_letters', array("id" => $id), $update);
            $this->session->set_flashdata('success', 'A template updated successfully');
            $this->allActivity('Template updated successfully!'); //track activity
            redirect(base_url() . 'templates');
        }

        $data['templates'] = $data['templates_category'] = '';

        $sq_letters = $this->User_model->query("SELECT * FROM sq_letters WHERE id=" . $id);
        if ($sq_letters->num_rows() > 0) {
            $sq_letters = $sq_letters->result();
            $data['templates'] = $sq_letters[0];
        }

        $sq_template_category = $this->User_model->query("SELECT * FROM sq_template_category");
        if ($sq_template_category->num_rows() > 0) {
            $sq_template_category = $sq_template_category->result();
            $data['templates_category'] = $sq_template_category;
        }

        $data['content'] = $this->load->view('admin/edit_template', $data, true);
        $this->load->view('template/template', $data);
    }

    public function add_template()
    {
        if ($this->check_permisions("library", "add") != 1) {
            return false;
        }
        if ($this->input->post()) {
            $category = $this->input->post("category");
            $status = $this->input->post("status");
            $letter_title = $this->input->post("letter_title");
            $content = $this->input->post("content");
            $insert = array(
                'category' => $category,
                'status' => $status,
                'letter_title' => $letter_title,
                'content' => $content
            );
            $this->User_model->insertdata('sq_letters', $insert);
            $this->session->set_flashdata('success', 'A template added successfully');
            $this->allActivity('New template added successfully!'); //track activity
            redirect(base_url() . 'templates');
        }

        $data['templates_category'] = '';

        $sq_template_category = $this->User_model->query("SELECT * FROM sq_template_category");
        if ($sq_template_category->num_rows() > 0) {
            $sq_template_category = $sq_template_category->result();
            $data['templates_category'] = $sq_template_category;
        }

        $data['content'] = $this->load->view('admin/add_template', $data, true);
        $this->load->view('template/template', $data);
    }

    public function send_subscription_email($subject, $email, $message)
    {

        if ($email != '') {

            $logolink        = base_url() . 'assets/images/logo.png';
            $site_link        = base_url('sign-in');

            $password_message = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #3972FC;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Letter</b></td></tr><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 30px 20px 30px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;">' . $message . '</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

            $this->load->config('email_custom');
            $email_config = $this->config->item('email_config');

            $this->email->initialize($email_config);
            $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
            $this->email->to($email);
            $this->email->subject($subject);

            $this->email->message($password_message);
            $this->email->send();

            return '1';
        }
    }

    public function send_letter()
    {
        $clientid   = get_dencoded_id($this->uri->segment(2));
        if ($clientid != '') {
            $data['templates_category'] = '';

            $sq_template_category = $this->User_model->query("SELECT * FROM sq_template_category");
            if ($sq_template_category->num_rows() > 0) {
                $sq_template_category = $sq_template_category->result();
                $data['templates_category'] = $sq_template_category;
            }
            $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientid));
            if ($fetchclients->num_rows() > 0) {
                $data['client'] = $fetchclients->result();
            } else {
                $data['client'] = [];
            }
             $fetchClientDocuments = $this->User_model->select_where('sq_clients_documents', array('client_id' => $clientid));
                if ($fetchClientDocuments->num_rows() > 0) {
                    $data['client_docs'] = $fetchClientDocuments->result();
                } else {
                    $data['client_docs'] = [];
                }
        $fetchclientSaveLatter = $this->User_model->query("SELECT * FROM client_saved_letters WHERE (`client_id` = $clientid) ORDER BY created_at DESC");

                    if ($fetchclientSaveLatter->num_rows() > 0) {
                        $data['clientSaveLatter'] = $fetchclientSaveLatter->result();
                        $dispute_ids = $data['clientSaveLatter'][0]->dispute_item_id; 
                        $id_array = array_map('intval', explode(',', $dispute_ids)); // Ensure all are integers
                        $ids_string = implode(',', $id_array); 
                        $sql = "SELECT * FROM sq_dispute_item WHERE id IN ($ids_string)";
                        $query = $this->User_model->query($sql); 
                        if ($query->num_rows() > 0) {
                            $data['disputeItems'] = $query->result();
                        } else {
                            $data['disputeItems'] = [];
                        }

                    } else {
                        $data['clientSaveLatter'] = [];
                    }
                      $sqls = "SELECT * FROM sq_dispute_item WHERE client_id = $clientid";
                        $querys = $this->User_model->query($sqls); 
                        if ($querys->num_rows() > 0) {
                            $data['alldisputeItems'] = $querys->result();
                        } else {
                            $data['alldisputeItems'] = [];
                        }

        }
        $data['content'] = $this->load->view('admin/send_letters', $data, true);
        $this->load->view('template/template', $data);
    }

    public function generate_letters()
    {
          if ($this->check_permisions("client", "view") != 1) {
            return false;
        }
        $clientid   = get_dencoded_id($this->uri->segment(2));
        if ($clientid != '') {
            $data['templates_category'] = '';

            $sq_template_category = $this->User_model->query("SELECT * FROM sq_template_category");
            if ($sq_template_category->num_rows() > 0) {
                $sq_template_category = $sq_template_category->result();
                $data['templates_category'] = $sq_template_category;
            }
            $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientid));
            if ($fetchclients->num_rows() > 0) {
                $data['client'] = $fetchclients->result();
            } else {
                $data['client'] = [];
            }
        }
        $fetchDisputes = $this->User_model->select_where('sq_dispute_item', array('client_id' => $clientid));
        if ($fetchDisputes->num_rows() > 0) {
            $data['dispute_items'] = $fetchDisputes->result();
        } else {
            $data['dispute_items'] = [];
        }
        $fetchClientDocuments = $this->User_model->select_where('sq_clients_documents', array('client_id' => $clientid));
        if ($fetchClientDocuments->num_rows() > 0) {
            $data['client_docs'] = $fetchClientDocuments->result();
        } else {
            $data['client_docs'] = [];
        }
        $fetchFurnishers = $this->User_model->query('SELECT * FROM sq_furnisher');
    if ($fetchFurnishers->num_rows() > 0) {
        $data['furnishers'] = $fetchFurnishers->result();
    } else {
        $data['furnishers'] = [];
    }
        $data['content'] = $this->load->view('admin/generate_letters', $data, true);
        $this->load->view('template/template', $data);
    }

    public function dispute_items()
    {

        $clientid   = get_dencoded_id($this->uri->segment(2));
        if ($clientid != '') {
            $data['templates_category'] = '';

            $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientid));
            if ($fetchclients->num_rows() > 0) {
                $data['client'] = $fetchclients->result();
            } else {
                $data['client'] = [];
            }
        }
 $fetchDisputes = $this->User_model->select_where('sq_dispute_item', array('client_id' => $clientid));
        if ($fetchDisputes->num_rows() > 0) {
            $data['dispute_items'] = $fetchDisputes->result();
        } else {
            $data['dispute_items'] = [];
        }
        $data['dispute'] = 'Dispute Items';
        $data['content'] = $this->load->view('admin/dispute_items', $data, true);
        $this->load->view('template/template', $data);
    }

//Ashok code  dispute
public function dispute_items_add()
    {

        $clientid   = get_dencoded_id($this->uri->segment(2));
        if ($clientid != '') {
            $data['templates_category'] = '';

            $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientid));
            
            if ($fetchclients->num_rows() > 0) {
                $data['client'] = $fetchclients->result();
            } else {
                $data['client'] = [];
            }
        }
  $fetchFurnishers = $this->User_model->query('SELECT * FROM sq_furnisher');
    if ($fetchFurnishers->num_rows() > 0) {
        $data['furnishers'] = $fetchFurnishers->result();
    } else {
        $data['furnishers'] = [];
    }
        $data['dispute'] = 'Dispute Items';
        $data['content'] = $this->load->view('admin/dispute_items_add', $data, true);
        $this->load->view('template/template', $data);
    }
    //

    public function get_subcategories()
    {
        $category_id = $this->input->post('category_id');
        $subcategories = $this->User_model->query("SELECT * FROM sq_letters WHERE category = $category_id", array($category_id))->result();

        echo json_encode($subcategories);
    }

    public function get_subcategories_content()
    {
        $client_id = $this->input->post('client_Id');
        $subcategoryId = $this->input->post('subcategoryId');
        if (empty($client_id) || empty($subcategoryId)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
            return;
        }

        $this->db->select('content');
        $this->db->from('sq_letters');
        $this->db->where('id', $subcategoryId);
        $query = $this->db->get();
        $subcategories_content_row = $query->row_array();

        if (empty($subcategories_content_row)) {
            echo json_encode(['status' => 'error', 'message' => 'Subcategory content not found.']);
            return;
        }

        $subcategories_contents = $subcategories_content_row['content'];

        // Fetch client data
        $this->db->select('*');
        $this->db->from('sq_clients');
        $this->db->where('sq_client_id', $client_id);
        $query = $this->db->get();
        $client_data = $query->row_array();

        if (empty($client_data)) {
            echo json_encode(['status' => 'error', 'message' => 'Client data not found.']);
            return;
        }

        $subcategories_content = str_replace(
            ['{client_first_name}', '{client_last_name}', '{client_address}', '{bdate}', '{ss_number}', '{bureau_address}', '{curr_date}', '{dispute_item_and_explanation}'],
            [
                $client_data['sq_first_name'],
                $client_data['sq_last_name'],
                $client_data['sq_mailing_address'],
                $client_data['sq_dob'],
                $client_data['sq_ssn'],
                '{bureau_address}',
                date('Y-m-d'),
                ''
            ],
            $subcategories_contents
        );

        // echo json_encode(['status' => 'success', 'content' => $subcategories_content]);
        echo json_encode([
            'status' => 'success',
            'content' => $subcategories_content,
            'client_data' => $client_data
        ]);
    }


    public function templates()
    {
        if ($this->check_permisions("library", "view") != 1) {
            return false;
        }
        $data['srch_title'] = $data['category'] = $data['qfilter'] = $data['templates'] = $data['templates_category'] = '';
        $search = '';
        if ($this->input->get('srch_title')) {
            $letter_title = $this->input->get('srch_title');
            $search .= " AND letter_title LIKE '%" . $letter_title . "%'";
            $data['srch_title'] = $letter_title;
        }

        if ($this->input->get('category')) {
            $category = $this->input->get('category');
            $search .= " AND category = " . $category;
            $data['category'] = $category;
        }

        if ($this->input->get('qfilter') || ($this->input->get('qfilter') != '')) {
            $status = $this->input->get('qfilter');
            $search .= " AND status = " . $status;
            $data['qfilter'] = $status;
        }

        $sq_letters = $this->User_model->query("SELECT * FROM sq_letters WHERE letter_title!='' $search");

        if ($sq_letters->num_rows() > 0) {
            $sq_letters = $sq_letters->result();
            $data['templates'] = $sq_letters;
        }

        $sq_template_category = $this->User_model->query("SELECT * FROM sq_template_category");
        if ($sq_template_category->num_rows() > 0) {
            $sq_template_category = $sq_template_category->result();
            $data['templates_category'] = $sq_template_category;
        }

        $data['content'] = $this->load->view('admin/templates', $data, true);
        $this->load->view('template/template', $data);
    }

    public function add_template_category()
    {

        $category = $this->input->post("category_name");

        $data['category_name'] = $category;
        $data['status']  = 1;

        $this->User_model->insertdata('sq_template_category', $data);
        $this->session->set_flashdata('success', 'A category added successfully');
        $this->allActivity('New category added successfully!'); //track activity
        redirect(base_url() . 'templates');
    }

    public function delete_template_category()
    {
        /* Our calendar data */
        $id = $this->uri->segment(3);
        $this->User_model->query("DELETE FROM sq_template_category where id = '" . $id . "' ");
        $this->session->set_flashdata('success', 'A category deleted successfully');
        $this->allActivity('Template category removed successfully!'); //track activity
        redirect(base_url() . 'templates');
    }

    public function delete_template()
    {

        /* Our calendar data */
        $id = $this->uri->segment(3);
        $this->User_model->query("DELETE FROM sq_letters where id = '" . $id . "' ");
        $this->session->set_flashdata('success', 'A template deleted successfully');
        $this->allActivity('Template removed successfully!'); //track activity
        redirect(base_url() . 'templates');
    }



    ///////////////////////// HOME PAGE //////////////////////////////////////////////////
    public function add_client()
    {
        if ($this->check_permisions("client", "add") != 1) {
            return false;
        }

        if ($this->input->post()) {

            $first_name = $this->input->post('first_name');
            $first_letters = substr($first_name, 0, 3);
            $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);

            $raw_password = $first_letters . $random_string;

            $hashed_password = md5($raw_password);

            $checked = (isset($_POST['portalAccess'])) ? true : false;

            $email = $this->input->post('email');
            $user_type  = $this->session->userdata('user_type');
            $user_id  = $this->session->userdata('user_id');
            $subscriber_type = 0;
            if ($user_type = 'subscriber') {
                $subscriber_type = 1;
            }


            $this->db->select('added_by');
            $this->db->from('sq_users');
            $this->db->where('sq_u_id', $user_id);

            $query = $this->db->get();
            $result = $query->row(); // Fetch a single row

            $userID = (!empty($result->added_by)) ? $result->added_by : $user_id;

            $insertData = array(
                'sq_u_id'               => $userID,
                'subscriber_type'       => $subscriber_type,
                'sq_first_name'         => $this->input->post('first_name'),
                'sq_middle_name'        => $this->input->post('middle_name'),
                'sq_last_name'          => $this->input->post('last_name'),
                'sq_suffix'             => $this->input->post('suffix'),
                'sq_email'              => $this->input->post('email'),
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
                'sq_client_added'       => date('Y-m-d'),
                'sq_date_of_start'      => date('Y-m-d', strtotime($this->input->post('date_of_start'))),
                'sq_dob'                => date('Y-m-d', strtotime($this->input->post('dob'))),
                'sq_p_mailing_address'  => $this->input->post('p_mailing_address'),
                'sq_p_city'             => $this->input->post('p_city'),
                'sq_p_state'            => $this->input->post('p_state'),
                'sq_p_zipcode'          => $this->input->post('p_zipcode'),
                'sq_p_country'          => $this->input->post('p_country'),
                'sq_portal_access'      => $checked,
                'client_days'           => $this->input->post('client_days'),
                's_password'            => $raw_password,
                'password'              => $hashed_password,
                'agreement_signed'      => 0,
            );

            $insertTier = $this->User_model->insertdata('sq_clients', $insertData);
            $lastid = $this->db->insert_id();

            //05-04-2023 start
            $data['client_id']  = $lastid;
            $data['sname']      = $this->input->post('sname');
            $data['sphone']     = $this->input->post('sphone');
            $data['semail']     = $this->input->post('semail');
            $data['ssocial']    = $this->input->post('ssocial');
            $data['sdob']       = $this->input->post('sdob');

            $this->User_model->insertdata('sq_spouse', $data);
            //05-04-2023 end

            $this->allActivity('Client (' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ') added successfully!'); //track activity
            $client_name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
            /************ Send auto email ***************/
            $status = $this->input->post('status');
            if (!empty($email)) {
if($status == 4){
                $email_sent = $this->send_welcome_email_client($client_name, $email, $raw_password);
}
            }
            /*************Send auto email **************/

            if ($email_sent == 1) {
                $update_client_data = array(
                    "login_detail_sent_date" => date('Y-m-d H:i A')
                );

                $this->User_model->updatedata('sq_clients', array("sq_client_id" => $lastid), $update_client_data);
            }

            $this->session->set_flashdata('success', 'Client added successfully!');
            redirect(base_url() . 'dashboard/' . get_encoded_id($lastid));
        }

        $data['get_allusers_name'] = $this->get_allusers_name();
        $data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

        $data['addclient'] = 'addclient';
        $data['content'] = $this->load->view('admin/add_client', $data, true);
        $this->load->view('template/template', $data);
    }


    public function check_client()
    {
        $email = $this->input->post('email');
$noEmail = $this->input->post('noEmail');

if($noEmail == 0){
        if (!empty($email)) {
            $this->db->where('sq_email', $email);
            $query1 = $this->db->get('sq_clients');

            $this->db->where('sq_u_email_id', $email);
            $query2 = $this->db->get('sq_users');

            $this->db->where('sq_u_user_id', $email);
            $query3 = $this->db->get('sq_users');

            if ($query1->num_rows() > 0 || $query2->num_rows() > 0 || $query3->num_rows() > 0) {
                echo json_encode(['status' => 'error', 'message' => 'This email address is already in use.']);
            } else {
                echo json_encode(['status' => 'success']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email is required']);
        }
}
else{
   echo json_encode(['status' => 'success']); 
}
    }


    // public function check_client()
    // {
    //     $email = $this->input->post('email');

    //     if (!empty($email)) {
    //         $this->db->where("(sq_email = '$email' OR sq_u_email_id = '$email' OR sq_u_user_id = '$email')");
    //         $this->db->from('sq_clients');
    //         $this->db->join('sq_users', "sq_clients.sq_email = '$email' OR sq_users.sq_u_email_id = '$email' OR sq_users.sq_u_user_id = '$email'", 'left');
    //         $query = $this->db->count_all_results();

    //         if ($query > 0) {
    //             echo json_encode(['status' => 'error', 'message' => 'This email address is already in use.']);
    //         } else {
    //             echo json_encode(['status' => 'success']);
    //         }
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Email is required']);
    //     }
    // }


    public function my_clients()
    {
          if ($this->check_permisions("client", "view") != 1) {
            return false;
        }
$fetch_clients_data = $this->User_model->query("SELECT * FROM sq_clients ORDER BY sq_client_id DESC");
    if ($fetch_clients_data->num_rows() > 0) {
      $data['clients_data'] = $fetch_clients_data->result();
    } else {
      $data['clients_data'] = '';
    }

        $data['myclient'] = 'myclient';
        $data['content'] = $this->load->view('admin/my_clients', $data, true);
        $this->load->view('template/template', $data);
    }

    public function manage_subscriptions()
    {
        $data['manageSubscriptions'] = 'manageSubscriptions';
        $data['content'] = $this->load->view('admin/manage_subscriptions', $data, true);
        $this->load->view('template/template', $data);
    }

    public function fetch_clients()
    {

        $sq_u_id = $this->session->userdata('user_id');

        $this->db->select('added_by');
        $this->db->from('sq_users');
        $this->db->where('sq_u_id', $sq_u_id);

        $query = $this->db->get();
        $result = $query->row(); // Fetch a single row

        $userID = (!empty($result->added_by)) ? $result->added_by : $sq_u_id;


        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search_value = $this->input->post('search')['value'];

        $clients_data = $this->User_model->get_filtered_clients($userID, $start, $length, $search_value);
        $total_clients = $this->User_model->get_total_clients($userID);
        $filtered_clients = $this->User_model->get_total_filtered_clients($userID, $search_value);

        $get_allusers_name = $this->get_allusers_name();
        $get_allaffiliate_name = $this->get_allaffiliate_name();
        $get_allaffiliate_company = $this->get_allaffiliate_company();

        $data = array();
        foreach ($clients_data as $row) {

            if ($row->agreement_signed == '0') {
                $onboarding_stage = '<p style = "text-align:center;"><span id = "onboarding_stage_login">Login Details Sent</span>' . '<br><span id = "onboarding_date">' . $row->login_detail_sent_date . '</span></p>';
            } elseif ($row->agreement_signed == '1') {
                $onboarding_stage = '<p style = "text-align:center;"><span id = "onboarding_stage_agreement"><a title="Name" class="text-success" href="' . $row->agreement_pdf_path . '" target = "_blank">Agreement Signed<br></a></span><span style id = "onboarding_date">' . $row->agreement_sign_date . '</span></p>';
            } else {

                $onboarding_stage = '';
            }

            $data[] = array(
                'sq_first_name' => '<a title="Name" class="text-success" href="' . base_url() . 'dashboard/' . get_encoded_id($row->sq_client_id) . '">' . ucwords($row->sq_first_name . ' ' . $row->sq_last_name) . '</a>',
                'sq_email' => $row->sq_email,
                'sq_phone_work' => $row->sq_phone_work,
                'assigned_to' => isset($get_allusers_name[$row->sq_assigned_to]) ? $get_allusers_name[$row->sq_assigned_to] : '',
                'referred_by' => isset($get_allaffiliate_name[$row->sq_referred_by]) ? $get_allaffiliate_name[$row->sq_referred_by] : '',
                'added_date' => $row->sq_client_added,
                'start_date' => $row->sq_date_of_start,
                'last_login' => $row->last_login,
                'onboarding_stage' => $onboarding_stage,
                'company' => isset($get_allaffiliate_company[$row->sq_referred_by]) ? $get_allaffiliate_company[$row->sq_referred_by] : '',
                'status' => !empty($row->sq_status) ? [
                    1 => "Lead",
                    2 => "Prospect",
                    3 => "Lead/Inactive",
                    4 => "Client",
                    5 => "Inactive",
                    6 => "Suspended"
                ][$row->sq_status] ?? "" : "",
                'actions' => '<a title="Edit" class="text-success s_icon" href="' . base_url() . 'edit-client/' . base64_encode(base64_encode($row->sq_client_id)) . '"><i class="mdi mdi-pencil"></i></a>
                              <a title="Delete" class="text-success s_icon" onclick="deleteClientPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-delete"></i></a>
                              <a title="Send Email" class="text-success s_icon" onclick="sendEmailPopUp(this,' . $row->sq_client_id . ');"><i class="mdi mdi-email"></i></a>'
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_clients,
            "recordsFiltered" => $filtered_clients,
            "data" => $data
        );

        echo json_encode($output);
    }

    public function getAllClients()
    {

        $myClientFetch = $this->User_model->query("SELECT * FROM sq_clients");
        if ($myClientFetch->num_rows() > 0) {
            $resultMyClients = $myClientFetch->result();
            return $resultMyClients;
        }
    }

    public function add_event()
    {

        $name = $this->input->post("title", TRUE);
        $select = $this->input->post("select", TRUE);
        $start_date = $this->input->post("start", TRUE);
        $end_date = $this->input->post("end", TRUE);

        if (!empty($start_date)) {
            $start_date = date('Y-m-d H:i:s', strtotime($start_date));
        } else {
            $start_date = date("Y-m-d H:i:s", time());
        }

        if (!empty($end_date)) {
            $end_date = date('Y-m-d H:i:s', strtotime($end_date));
        } else {
            $end_date = date("Y-m-d H:i:s", time());
        }

        $insert = array(
            "title" => $name,
            "start" => $start_date,
            "end" => $end_date,
            "user_id" => $select
        );

        $insertTier = $this->User_model->insertdata('sq_calender', $insert);
        $this->allActivity('New event added successfully!');
        redirect(base_url("schedule"));
    }

    public function create_new_event()
    {
        $select = $this->input->post('select');
        $event_type = $this->input->post('event_type');
        $event_subject = $this->input->post('event_subject');
        $event_title = $this->input->post('event_title');
        $eventStartDateTime = $this->input->post('eventStartDateTime');
        $eventEndDateTime = $this->input->post('eventEndDateTime');
        $event_clients = $this->input->post('event_clients');
        $event_location = $this->input->post('event_location');
        $event_remarks = $this->input->post('event_remarks');

        $insert = array(
            "user_id" => $this->session->userdata('user_id'),
            "event_type" => $event_type,
            "event_subject" => $event_subject,
            "title" => $event_title,
            "start" => $eventStartDateTime,
            "end" => $eventEndDateTime,
            "event_clients" => $event_clients,
            "event_location" => $event_location,
            "description" => $event_remarks,
        );

        $insertTier = $this->User_model->insertdata('sq_calender', $insert);
        $lastID = $this->db->insert_id();

        if (!empty($lastID)) {

            // $response = ['success' => true, 'message' => 'Event added successfully!'];
            echo json_encode(['status' => 'success', 'message' => 'Event added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error!']);
            // $response = ['error' => true, 'message' => 'Error!'];
        }
        // echo json_encode($response);
    }

    public function edit_event()
    {
        /* Our calendar data */
        $name = $this->input->post("title", TRUE);
        $start_date = $this->input->post("start", TRUE);
        $end_date = $this->input->post("end", TRUE);
        $id = $this->input->post("id", TRUE);

        $insert = array(
            "title" => $name,
            "start" => $start_date,
            "end" => $end_date
        );

        $insertTier = $this->User_model->updatedata('sq_calender', array("id" => $id), $insert);
    }

    public function delete_event()
    {
        /* Our calendar data */
        $id = $this->input->post("id");
        $deleteClient = $this->User_model->query("DELETE FROM sq_calender where id = '" . $id . "' ");
        $this->allActivity('Event removed successfully!'); //track activity
        echo '1';
    }
    
    
    public function loadEventData()
{
    date_default_timezone_set('Asia/Kolkata'); 
    $json = array();
$select = $this->input->post("select");

$this->db->select('id,task_id, event_clients, title, start, end');
$this->db->from('sq_calender');

if (!empty($select)) {
    $this->db->where('user_id', $select);
}

$dataInfo = $this->db->get();

if ($dataInfo->num_rows() > 0) {
    foreach ($dataInfo->result() as $row) {
            $clientId = $row->event_clients;
          $clientName = '';
            if ($clientId) {
                $clientQuery = $this->User_model->query("SELECT * FROM sq_clients WHERE sq_client_id = '$clientId'");
                if ($clientQuery->num_rows() > 0) {
                    $clientName = $clientQuery->row()->sq_first_name . ' ' . $clientQuery->row()->sq_last_name;
                }
            }
            
            $json[] = array(
                "id" => $row->id,
                  'task_id'=>$row->task_id,
                'client_name'=>$clientName,
                'client_id'=>get_encoded_id($clientId),
                "title" => $row->title,
                "start" => date("Y-m-d\TH:i:s", strtotime($row->start)), 
                "end" => date("Y-m-d\TH:i:s", strtotime($row->end)),
            );
        }
    }

    echo json_encode($json);
    exit();
}


    // public function loadEventData()
    // {

    //     $json = array();
    //     $select = '-1';

    //     if ($this->input->post()) {
    //         $select = $this->input->post("select");
    //     }
    //     if ($select != '-1') {
    //         $dataInfo = $this->User_model->query("SELECT * FROM sq_calender WHERE user_id='$select'");
    //     } else {

    //         $dataInfo = $this->User_model->query("SELECT * FROM sq_calender");
    //     }
    //     if ($dataInfo->num_rows() > 0) {
    //         $json = $dataInfo->result();
    //     }

    //     echo json_encode($json);
    //     exit();
    // }

    public function deleteClient()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $deleteClient = $this->User_model->query("DELETE FROM sq_clients where sq_client_id = '" . $id . "' ");
            $this->allActivity('client removed successfully!'); 
            echo json_encode('deleted');
        }
    }


    public function edit_client()
    {
        if ($this->check_permisions("client", "edit") != 1) {
            return false;
        }
        $url_data       = base64_decode(base64_decode($this->uri->segment(2)));                   // FETCHING VALUE FROM URL 


        //get data of the selected client 
        $myClientFetch = $this->User_model->query("SELECT * FROM sq_clients WHERE sq_client_id = '" . $url_data . "'");
        if ($myClientFetch->num_rows() > 0) {
            $resultMyClients = $myClientFetch->result();
            $data['resultMyClients'] = $resultMyClients;
        } else {
            $data['resultMyClients'] = '';
        }



        if (isset($_POST['btn_client'])) {

            $checked = (isset($_POST['portalAccess'])) ? true : false;

            $dataUpdate['sq_first_name']          =  $this->input->post('first_name');
            $dataUpdate['sq_middle_name']         =  $this->input->post('middle_name');
            $dataUpdate['sq_last_name']           =  $this->input->post('last_name');
            $dataUpdate['sq_suffix']              =  $this->input->post('suffix');
            $dataUpdate['sq_email']               =  $this->input->post('email');
            $dataUpdate['sq_ssn']                 =  $this->input->post('ssn');
            $dataUpdate['sq_phone_home']          =  $this->input->post('phone_home');
            $dataUpdate['sq_phone_work']          =  $this->input->post('phone_work');
            $dataUpdate['sq_phone_mobile']        =   $this->input->post('phone_mobile');
            $dataUpdate['sq_fax']                 =  $this->input->post('fax');
            $dataUpdate['sq_mailing_address']     =  $this->input->post('mailing_address');
            $dataUpdate['sq_city']                =  $this->input->post('city');
            $dataUpdate['sq_state']               =  $this->input->post('state');
            $dataUpdate['sq_zipcode']             =  $this->input->post('zipcode');
            $dataUpdate['sq_country']             =  $this->input->post('country');
            $dataUpdate['sq_status']              =  $this->input->post('status');
            $dataUpdate['sq_assigned_to']         =  $this->input->post('assigned');
            $dataUpdate['sq_referred_by']         =  $this->input->post('referred');
            $dataUpdate['sq_date_of_start']       =  date('Y-m-d', strtotime($this->input->post('date_of_start')));
            $dataUpdate['sq_dob']                 =  date('Y-m-d', strtotime($this->input->post('dob')));
            $dataUpdate['sq_p_mailing_address']   =  $this->input->post('p_mailing_address');
            $dataUpdate['sq_p_city']              =  $this->input->post('p_city');
            $dataUpdate['sq_p_state']             =  $this->input->post('p_state');
            $dataUpdate['sq_p_zipcode']           =  $this->input->post('sq_p_zipcode');
            $dataUpdate['sq_p_country']           =  $this->input->post('p_country');
            $dataUpdate['sq_portal_access']       =  $checked;
            $dataUpdate['client_days']            =  $this->input->post('client_days');
            $dataUpdate['sq_email_check']         =  $this->input->post('sq_email_check');
 $dataUpdate['memo']         =  $this->input->post('memo');


            $where['sq_client_id']      = $this->input->post('hiddenRowId');
            $this->User_model->updatedata('sq_clients', $where, $dataUpdate);
            $this->allActivity('Client (' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ') updated successfully!'); //track activity
            $this->session->set_flashdata('success', 'Client updated successfully!');

            //redirect(base_url().'dashboard/'.base64_encode(base64_encode($this->input->post('hiddenRowId'))));
            redirect(base_url() . 'dashboard/' . get_encoded_id($this->input->post('hiddenRowId')));
        }

        $data['get_allusers_name'] = $this->get_allusers_name();
        $data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

        $data['editclient'] = 'editclient';
        $data['content'] = $this->load->view('admin/edit_client', $data, true);
        $this->load->view('template/template', $data);
    }

    public function my_schedule()
    {

        if ($this->check_permisions("schedule", "view") != 1) {
            return false;
        }

        $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users");
        if ($myEmpFetch->num_rows() > 0) {
            $data['team_members'] = $myEmpFetch->result();
        }

        $clients = $this->User_model->query("SELECT * FROM sq_clients");
        if ($myEmpFetch->num_rows() > 0) {
            $data['clients'] = $clients->result();
        }
        
$task = $this->User_model->query("
    SELECT t.*, c.sq_first_name, c.sq_last_name
    FROM sq_task t
    LEFT JOIN sq_clients c ON t.sq_client_id = c.sq_client_id
    WHERE t.task_status = 0
");
if ($task->num_rows() > 0) {
    $data['tasks_current'] = $task->result();
}
$taskcomplete = $this->User_model->query("
    SELECT t.*, c.sq_first_name, c.sq_last_name
    FROM sq_task t
    LEFT JOIN sq_clients c ON t.sq_client_id = c.sq_client_id
    WHERE t.task_status = 1
");
if ($taskcomplete->num_rows() > 0) {
    $data['tasks_complete'] = $taskcomplete->result();
}


        $data['myschedule'] = 'myschedule';

        $data['content'] = $this->load->view('admin/my_schedule', $data, true);
        $this->load->view('template/template', $data);
    }

public function task_current()
{
      $id = $this->input->post('id');
      $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id = $id");

if ($myEmpFetch->num_rows() > 0) {
    $user = $myEmpFetch->row(); // fetch single row as object
    $full_name = $user->sq_u_first_name . ' ' . $user->sq_u_last_name;
} else {
    $full_name = '';
}

 $task = $this->User_model->query("
    SELECT t.*, c.sq_first_name, c.sq_last_name
    FROM sq_task t
    LEFT JOIN sq_clients c ON t.sq_client_id = c.sq_client_id
    WHERE t.task_status = 0 AND t.team_member_id = '$full_name'
     ORDER BY t.id DESC
");
if ($task->num_rows() > 0) {
    $data['tasks_current'] = $task->result();
}
    $this->load->view('task/ajax_task_rows', $data);
}
public function task_complete()
{
//      $id = $this->input->post('id');
//      $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id = $id");

// if ($myEmpFetch->num_rows() > 0) {
//     $user = $myEmpFetch->row(); // fetch single row as object
//     $full_name = $user->sq_u_first_name . ' ' . $user->sq_u_last_name;
// } else {
//     $full_name = '';
// }

 $task = $this->User_model->query("
    SELECT t.*, c.sq_first_name, c.sq_last_name
    FROM sq_task t
    LEFT JOIN sq_clients c ON t.sq_client_id = c.sq_client_id
    WHERE t.task_status = 1
     ORDER BY t.id DESC
");
if ($task->num_rows() > 0) {
    $data['tasks_current'] = $task->result();
}
    $this->load->view('task/ajax_task_rows_com', $data);
}

    public function my_company()
    {
        if (isset($_POST['addCompanyButton'])) {
            $this->form_validation->set_rules('company_name', 'Company Name', 'required');
            // $this->form_validation->set_rules('website_url', 'Website Url', 'required');
            $this->form_validation->set_rules('address', 'Company Address', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('zip', 'Zip code', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('time_zone', 'Time zone', 'required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
            // $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
            // $this->form_validation->set_rules('sender_email', 'Sender Email', 'required|valid_email');
            // $this->form_validation->set_rules('payable_company', 'Invoice Payable', 'required');
            $this->form_validation->set_error_delimiters('<span class="text-danger" >', '</span>');
            if ($this->form_validation->run() == TRUE) {

                $data['sq_company_name']            =   $this->input->post('company_name');
                $data['sq_company_url']            =    $this->input->post('website_url');
                $data['sq_company_address']        =   $this->input->post('address');
                $data['sq_company_city']            =   $this->input->post('city');
                $data['sq_company_state']           =   $this->input->post('state');
                $data['sq_company_zip']             =   $this->input->post('zip');
                $data['sq_company_country']        =   $this->input->post('country');
                $data['sq_company_time_zone']       =   $this->input->post('time_zone');
                $data['sq_company_fax']             =   $this->input->post('fax');
                $data['sq_company_contact_no']      =   $this->input->post('phone');
                $data['sq_company_sender_name']     =   $this->input->post('sender_name');
                $data['sq_company_sender_email']    =   $this->input->post('sender_email');
                $data['sq_company_payable_company'] =   $this->input->post('payable_company');

                $myEmpFetch = $this->User_model->query("SELECT * FROM sq_company WHERE sq_company_id = '1'");
                if ($myEmpFetch->num_rows() > 0) {
                    $UpdateQuery = $this->User_model->updatedata("sq_company", array("sq_company_id" => 1), $data);
                } else {
                    $data['sq_company_id'] = 1;
                    $UpdateQuery = $this->User_model->insertdata("sq_company", $data);
                }
                $this->session->set_flashdata('insertion-success', 'Company Profile Information Saved Successfully');
                $this->allActivity('Company (' . $this->input->post('company_name') . ') information saved successfully!'); //track activity
                redirect(base_url() . 'my-company');
            }
        }


        //get data of the employee  
        // $user_idd = $this->session->userdata('user_id');
        // $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id != '$user_idd' AND added_by = '$user_idd'");
        // if ($myEmpFetch->num_rows() > 0) {
        //     $resultMyEmp = $myEmpFetch->result();
        //     $data['resultMyEmp'] = $resultMyEmp;
        // } else {
        //     $data['resultMyEmp'] = '';
        // }

         $user_idd = $this->session->userdata('user_id');
  $myEmpFetch = $this->db->query("SELECT * FROM sq_users WHERE sq_u_role != 1 AND (sq_u_type = 'emp' OR sq_u_type = 'super')");


        if ($myEmpFetch->num_rows() > 0) {
            $data['resultMyEmp'] = $myEmpFetch->result();
        } else {
            $data['resultMyEmp'] = [];
        }


        //get data of the company  
        $myCompFetch = $this->User_model->query("SELECT * FROM sq_company WHERE sq_company_id = '1'");
        if ($myCompFetch->num_rows() > 0) {
            $resultMyComp = $myCompFetch->result();
            $data['resultMyComp'] = $resultMyComp;
        } else {
            $data['resultMyComp'] = '';
        }



        // Add new role in to the roles table 


        if (isset($_POST['addRoleBtn'])) {

            $this->form_validation->set_rules('addrole', 'Role', 'required');
            $this->form_validation->set_error_delimiters('<span class="text-danger" >', '</span>');


            if ($this->form_validation->run() == TRUE) {

                $roles_data = array(
                    'sq_role_name'            =>   $this->input->post('addrole'),
                );



                $insertCompanyInfo = $this->User_model->insertdata('sq_roles', $roles_data);


                // Add role data in permission table 

                $tabname  = $this->config->item('tabname');

                foreach ($tabname as $key => $tabRow) {

                    $this->db->query("INSERT INTO sq_permission (`sq_p_rolename`,`sq_p_tabname`,`sq_p_add`,`sq_p_edit`,`sq_p_view`) VALUES('" . strtolower($this->input->post('addrole')) . "','" . $tabRow . "','0','0','0')");
                }




                $this->session->set_flashdata('emp-insertion-success', 'New Role Added Successfully');
                $this->allActivity('New role added successfully!'); //track activity
                redirect(base_url() . 'my-company');
            }
        }



        // Get role data from role table 


        $myRoleFetch = $this->User_model->query("SELECT * FROM sq_roles ");
        if ($myRoleFetch->num_rows() > 0) {
            $resultMyRole = $myRoleFetch->result();
            $data['resultMyRole'] = $resultMyRole;
        } else {
            $data['resultMyRole'] = '';
        }


        $simple_audits = $this->User_model->query("SELECT * FROM sq_simple_audit_template ");
        if ($simple_audits->num_rows() > 0) {
            $simple_audits = $simple_audits->result();
            $data['simple_audits'] = $simple_audits;
        } else {
            $data['simple_audits'] = '';
        }


        $data['mycompany'] = 'mycompany';
        $data['content'] = $this->load->view('admin/my_company', $data, true);
        $this->load->view('template/template', $data);
    }

    function generate_password($first_name, $last_name)
    {
        // Ensure the first name has at least 4 characters; if not, pad it with random letters
        $adjusted_first_name = str_pad(substr($first_name, 0, 4), 4, chr(rand(65, 90))); // Pad with random uppercase letters if less than 4

        // Add "@" and a random special character
        $special_characters = '!@#$%^&*';
        $password = $adjusted_first_name . '@' . $special_characters[rand(0, strlen($special_characters) - 1)];

        // Add random characters if the password is less than 8 characters, or truncate if it exceeds 10
        if (strlen($password) < 8) {
            $extra_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $password .= substr(str_shuffle($extra_chars), 0, 8 - strlen($password));
        } elseif (strlen($password) > 10) {
            $password = substr($password, 0, 10);
        }

        return $password;
    }

    public function add_new_team_member()
    {

            $sq_u_id = $this->session->userdata('user_id');

        if ($this->input->post()) {

            ////////////////////////   UPLOAD PROFILE PICTURE /////////////////////

            $password = '';
            if ($this->input->post('send_system_gen_password') == 1) {
                $password = $this->generate_password($this->input->post('first_name'), $this->input->post('last_name'));
            } else {
                $password = $this->input->post('password');
            }


            $this->db->select('added_by');
            $this->db->from('sq_users');
            $this->db->where('sq_u_id', $sq_u_id);

            $query = $this->db->get();
            $result = $query->row(); // Fetch a single row

            $user_id = (!empty($result->added_by)) ? $result->added_by : $sq_u_id;

            $role = $this->input->post('role');
            $employee_data = array(
                'added_by'                   =>   $sq_u_id,
                'sq_u_first_name'            =>   $this->input->post('first_name'),
                'sq_u_last_name'             =>   $this->input->post('last_name'),
                'sq_u_email_id'              =>   $this->input->post('email'),
                'sq_u_user_id'               =>   $this->input->post('email'),
                'sq_u_type'                  =>   $role,
                'sq_u_phone'                 =>   $this->input->post('phone'),
                'sq_u_mobile'                =>   $this->input->post('mobile'),
                'sq_u_title'                 =>   $this->input->post('title_for_portal'),
                'sq_u_fax'                   =>   $this->input->post('fax'),
                'sq_u_address'               =>   $this->input->post('address'),
                'sq_u_apassword'              =>  $password,
                'sq_u_password'              =>   md5($password),
                'sq_u_gender'                =>   $this->input->post('gender'),
                'sq_u_sys_login'             =>   $this->input->post('send_system_gen_password'),


            );

            if ($role == 'super') {
                $employee_data['sq_u_role'] = "admin";
            } else {
                $employee_data['sq_u_role'] = "employee";
            }
            if ($this->input->post("send_login_info") == 1) {
                $this->send_login_email($employee_data['sq_u_first_name'], $employee_data['sq_u_last_name'], $employee_data['sq_u_email_id'], $employee_data['sq_u_user_id'], $employee_data['sq_u_apassword'],$role);
            }

            $insertCompanyInfo = $this->User_model->insertdata('sq_users', $employee_data);
            $lastid = $this->db->insert_id();
            $this->allActivity('Team member (' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ') added successfully!'); //track activity

            if (!empty($_FILES['myfile']['name'])) {
                // Handle profile image upload
                $upload_dir = FCPATH . 'upload/team_members/profile_image/' . $lastid;
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

                if ($this->upload->do_upload('myfile')) {
                    // Update profile picture in the database
                    $file_data = $this->upload->data();
                    $image_path = base_url() . 'upload/team_members/profile_image/' . $lastid . '/' . $file_data['file_name'];
                    $this->User_model->updatedata('sq_users', ['sq_u_id' => $lastid], ['sq_u_profile_picture' => $image_path]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()]);
                    return;
                }
              
            }
            

if (!empty($_FILES['addressfile']['name'])) {
 
      // Handle profile image upload
      $upload_dir = FCPATH . 'upload/team_members/address_proof/' . $lastid;
      if (!is_dir($upload_dir)) {
          mkdir($upload_dir, 0755, true);
      }

                $where['sq_u_id'] = $lastid;
                $getData = $this->User_model->select_where('sq_users', $where);
                $_result = $getData->row();

                $address_proof_url = $_result->sq_u_address_proof;

                if (!empty($address_proof_url)) {

                    $parts = explode('/', $address_proof_url);

                    $profile_img = end($parts);

                    if (!empty($_result->sq_u_address_proof)) {
                        $existing_adress_path = $upload_dir . '/' . $profile_img;

                        if (file_exists($existing_adress_path)) {
                            unlink($existing_adress_path);
                        }
                    }
                }

                $config['upload_path'] = $upload_dir;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'address_proof_' . time();  // Rename the uploaded file
                $this->load->library('upload', $config);

         if ($this->upload->do_upload('addressfile')) {
          // Update profile picture in the database
          $file_data = $this->upload->data();
          $image_path = base_url() . 'upload/team_members/address_proof/' . $lastid . '/' . $file_data['file_name'];
          $this->User_model->updatedata('sq_users', ['sq_u_id' => $lastid], ['sq_u_address_proof' => $image_path]);
      } else {
          echo json_encode(['status' => 'error', 'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()]);
          return;
      }
}

            // Final success message
            echo json_encode(['status' => 'success', 'message' => 'Employee Added Successfully']);

            //////////////////////////UPLOAD PROFILE PICTURE ENDS////////////////////

        } else {

            $data['newteam'] = 'newteam';
            $data['content'] = $this->load->view('admin/team_members/add_new_team_members', $data, true);
            $this->load->view('template/template', $data);
        }
    }

  public function delete_employee()
    {
          $id = $this->uri->segment(2);
     
    $result =  $this->User_model->query("DELETE FROM sq_users where sq_u_id = '" . $id . "' ");

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    }
    public function edit_employee()
    {

        // Decode ID from url 
        $urisegment = $this->uri->segment(2);
        $checkID = base64_decode(urldecode($urisegment));
        $decodedID = number_format(($checkID * 12345) / 12345678);

        $empID = str_replace(',', '', $decodedID);

        $data['empID'] =  $empID;

        //get data of the employee  
        $myEmpFetch = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id = '" . $empID . "'");
        if ($myEmpFetch->num_rows() > 0) {
            $resultMyEmp = $myEmpFetch->result();
            $data['resultMyEmp'] = $resultMyEmp;
        } else {
            $data['resultMyEmp'] = '';
        }
 $data['user_id'] = $this->session->userdata('user_id');
        if (isset($_POST['btnEmpSubmit'])) {

            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('user_id', 'User ID', 'required|valid_email');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            //$this->form_validation->set_rules('mobile', 'Mobile', 'required');
            $this->form_validation->set_rules('fax', 'Fax', 'required');
            $this->form_validation->set_rules('title_for_portal', 'Title For Portal', 'required');
            //$this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');

            $this->form_validation->set_error_delimiters('<span class="text-danger" >', '</span>');

            if ($this->form_validation->run() == TRUE) {

         


                //////////////////////////UPLOAD PROFILE PICTURE ENDS////////////////////



                $sq_u_first_name            =   $this->input->post('first_name');
                $sq_u_last_name             =   $this->input->post('last_name');
                $sq_u_email_id              =   $this->input->post('email');
                 $status            =   $this->input->post('sq_u_status');
                $sq_u_phone                 =   $this->db->escape($this->input->post('phone'));
                $sq_u_mobile                =   $this->db->escape($this->input->post('mobile'));
                $sq_u_title                 =   $this->db->escape($this->input->post('title_for_portal'));
                $sq_u_fax                   =   $this->db->escape($this->input->post('fax'));
                $sq_u_address               =   $this->db->escape($this->input->post('address'));
                $sq_u_apassword = '';
                if ($this->input->post('password') != '') {
                    $sq_u_apassword              =  $this->input->post('password');
                    $sq_u_password              =   md5($this->input->post('password'));
                    $password                   = ",sq_u_password = '" . $sq_u_password . "',sq_u_apassword = '" . $sq_u_apassword . "'";
                } else {
                    $password                   = '';
                }


                $sq_u_type = $this->input->post('role');

                if ($sq_u_type == 'super') {
                    $sq_u_role = "admin";
                } else {
                    $sq_u_role = "employee";
                }


                $sq_u_gender                =   $this->db->escape($this->input->post('gender1'));
                $sq_u_sys_login             =   $this->db->escape($this->input->post('send_login1'));
             
                $sq_u_user_id               =   $this->input->post('email');



     $UpdateQuery = $this->User_model->query("UPDATE sq_users SET  sq_u_status='". $status ."', sq_u_first_name ='" . $sq_u_first_name . "',sq_u_last_name ='" . $sq_u_last_name . "',sq_u_email_id ='" . $sq_u_email_id . "',sq_u_phone =" . $sq_u_phone . ",sq_u_mobile =" . $sq_u_mobile . ",sq_u_title =" . $sq_u_title . ",sq_u_fax =" . $sq_u_fax . ",sq_u_address =" . $sq_u_address . ",sq_u_role ='" . $sq_u_role . "',sq_u_type ='" . $sq_u_type . "' ,sq_u_gender =" . $sq_u_gender . ",sq_u_sys_login =" . $sq_u_sys_login . ",sq_u_user_id ='" . $sq_u_user_id . "' " . $password . " WHERE sq_u_id = '" . $this->input->post('hidEmpId') . "'");



      // Load upload library only once at the top
$this->load->library('upload');

// PROFILE PICTURE UPLOAD
if ($_FILES['myfile']['name'] != '') {
    echo $_FILES['myfile']['name'];
    $config['upload_path'] = 'assets/upload/profile_pictures';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = $_FILES['myfile']['name'];

    $this->upload->initialize($config);

    if ($this->upload->do_upload('myfile')) {
        $uploadData = $this->upload->data();
        $picture = base_url('assets/upload/profile_pictures/' . $uploadData['file_name']);

        // Delete old profile picture
        $result = $this->User_model->query("SELECT sq_u_profile_picture FROM sq_users WHERE sq_u_id = '$empID'")->row();
        if ($result && !empty($result->sq_u_profile_picture)) {
            $imgArray = explode('profile_pictures/', $result->sq_u_profile_picture);
            if (isset($imgArray[1])) {
                $imgPath = 'assets/upload/profile_pictures/' . $imgArray[1];
                if (file_exists($imgPath)) unlink($imgPath);
            }
        }

        // Update
        $this->User_model->query("UPDATE sq_users SET sq_u_profile_picture = '$picture' $password WHERE sq_u_id = '" . $this->input->post('hidEmpId') . "'");
    } else {
        log_message('error', $this->upload->display_errors());
    }
}
if ($_FILES['addressfile']['name'] != '') {
    $lastid = $this->input->post('hidEmpId'); // or $empID

    // Create dynamic upload path
    $upload_dir = FCPATH . 'upload/team_members/address_proof/' . $lastid;
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $config['upload_path'] = $upload_dir;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name'] = $_FILES['addressfile']['name'];

    $this->load->library('upload');
    $this->upload->initialize($config);

    if ($this->upload->do_upload('addressfile')) {
        $uploadData = $this->upload->data();

        // Public URL path (base_url)
        $relative_path = 'upload/team_members/address_proof/' . $lastid . '/' . $uploadData['file_name'];
        $proofpicture = base_url($relative_path);

        // Delete old file if needed
        $result = $this->User_model->query("SELECT sq_u_address_proof FROM sq_users WHERE sq_u_id = '$lastid'")->row();
        if ($result && !empty($result->sq_u_address_proof)) {
            $oldPath = FCPATH . str_replace(base_url(), '', $result->sq_u_address_proof);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Update database
        $this->User_model->query("UPDATE sq_users SET sq_u_address_proof = '$proofpicture' $password WHERE sq_u_id = '$lastid'");

    } else {
        echo '<b>Upload Error:</b><br>';
        echo $this->upload->display_errors();
    }
}


                if ($this->input->post("send_login1") == 1) {
                    $this->send_login_email($sq_u_first_name, $sq_u_last_name, $sq_u_email_id, $sq_u_user_id, $sq_u_apassword,$sq_u_type);
                }

                $this->session->set_flashdata('emp-insertion-success', 'Employee Profile Information Saved Successfully');
                $encode = base64_encode(urlencode($this->input->post('hidEmpId') * 12345678) / 12345);

                $this->allActivity('Team member (' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ') profile information saved successfully!'); //track activity
                redirect(base_url() . 'edit-employee/' . $encode);
            }
        }

        $data['editemp'] = 'editemp';
        $data['content'] = $this->load->view('admin/team_members/edit_employee', $data, true);
        $this->load->view('template/template', $data);
    }


    function send_login_email($fname, $lname, $email, $username, $password,$sq_u_type)
    {

                if ($sq_u_type == 'super') {
                    $subject = "Login Credentials for Secure Admin Access";
                } else {
                    $subject = "Login Credentials for Secure Employee Access";
                }
        $msg = 'User ID: <span style="color:#0558b5">' . $username . '</span>
                <br>Password: <span style="color:#0558b5">' . $password . '</span></p><br><br>
        <div style="text-align:left;"><a href="' . base_url('sign-in') . '" style="background-color:#0558b5; color:#fff; border:none; padding:8px 8px; font-size:15px; cursor:pointer; border-radius: 4px; text-decoration: none">Get Started</a></div>
            ';
        $message = '<table style="width:100%" bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <br>
                                        <table style="width:600px" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="background:#fff;border:#f2f2f2 solid 1px;border-top:0px;padding:20px;font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;line-height:22px" align="left" valign="top">
                                                        <p style="font-family:Helvetica,Arial,sans-serif;font-size:18px;color:#606060"><b>Dear ' . ucwords($fname) . ' ' . $lname . ',</b>
                                                        </p>
                                                        <p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Here are your login details for CRX Credit Repair</p>
                                                    ' . $msg . '
                                                        </p>
                                                        <p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;</td>
                                </tr>
                            </tbody>
                    </table>';

        $this->send_email_template($email, "", $subject, $message);
    }
    public function permissions()
    {
        $data['role_type'] = $this->uri->segment(2);
        $data['permissions'] = 'permissions';

        $permissions_list = $this->User_model->query("SELECT * FROM sq_permission WHERE sq_p_rolename='" . $data['role_type'] . "'");
        if ($permissions_list->num_rows() > 0) {
            $data['permissions_list'] = $permissions_list->result();
        } else {
            $data['permissions_list'] = '';
        }

        $data['content'] = $this->load->view('admin/permissions/permissions', $data, true);
        $this->load->view('template/template', $data);
    }

    public function sendemailNotification()
    {

        if (isset($_POST['send'])) {

            $clientid   = $this->input->post('clientID');
            $get_client_info = $this->get_client_info($clientid);
            $subject    = $this->input->post('subject');
            $msg        = $this->input->post('msg');
            $email      = $get_client_info->sq_email;

            $logolink =  base_url() . 'assets/images/logo.png';
            $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Email Notification</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 60px 20px 60px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"><b>Subject:</b> ' . $subject . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;"><b>Message:</b> ' . $msg . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

            $this->send_email_template($email, "Email Notification", "Email Notification", $emailtemp, 1);

            $this->session->set_flashdata('successs', 'Email Notification send to client successfully');
            $this->allActivity('Email notification send to client (' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . ') successfully!'); //track activity
            redirect(base_url() . 'clients');
        }
    }


    public function allactivities()
    {

        $teamid = $this->input->post('teamid');
        if ($teamid != '') {
            $condition = "WHERE user_id = '" . $teamid . "'";
        } else {
            $condition = '';
        }

        $data['teamid'] = $teamid;

        $fetchactivity = $this->User_model->query("SELECT * FROM sq_all_activity " . $condition . " ORDER BY id desc");
        if ($fetchactivity->num_rows() > 0) {
            $fetchactivity = $fetchactivity->result();

            foreach ($fetchactivity as $value) {

                $fetchuserinfo = $this->User_model->query("SELECT `sq_u_first_name`, `sq_u_last_name`, `sq_u_profile_picture` FROM `sq_users` WHERE `sq_u_id` = '" . $value->user_id . "'");
                $fetchuserinfo = $fetchuserinfo->row();

                $f_name = $fetchuserinfo->sq_u_first_name ?? '';
                $l_name = $fetchuserinfo->sq_u_last_name ?? '';
                $fullname = trim("$f_name $l_name");

                $userprofileimg = !empty($fetchuserinfo->sq_u_profile_picture) ? $fetchuserinfo->sq_u_profile_picture : base_url() . 'assets/img/user.jpg';

                $alluserarray[] = array(
                    "fullname" => $fullname,
                    "userprofileimg" => $userprofileimg,
                    "message" => $value->msg,
                    "datetime" => $value->datetime,
                );
            }
        } else {
            $alluserarray = '';
        }
        $data['fetchactivity'] = $alluserarray;
        $data['get_allusers_name'] = $this->get_allusers_name();
        $data['ss'] = '1';
        $data['content'] = $this->load->view('admin/allactivity', $data, true);
        $this->load->view('template/template', $data);
    }

    public function search()
    {
        $query = $this->input->post('query');
        $result = $this->User_model->searchClient($query);

        $status_labels = [
            1 => ' (Lead)',
            2 => ' (Prospect)',
            3 => ' (Lead/Inactive)',
            4 => ' (Client)',
            5 => ' (Inactive)',
            6 => ' (Suspended)'
        ];

        $output = '<ul class="list-unstyled">';
        foreach ($result as $row) {

            $sq_status = $status_labels[$row->sq_status] ?? '';

            $output .= '<li class="client-item"><a href="' . base_url() . 'dashboard/' . get_encoded_id($row->sq_client_id) . '">' .
                $row->sq_first_name . ' ' . $row->sq_last_name . $sq_status .
                '</a></li>';
        }

        if (empty($result)) {
            $output .= '<li class="no-clients">No clients found</li>';
        }
        $output .= '</ul>';

        echo $output;
    }

    public function add_edit_audit_template()
    {
        $template_id = $this->input->post('template_id');
        $edit_template = $this->input->post('edit_template');

        $audit_name = $this->input->post('audit_name');
        $include_page_number = $this->input->post('include_page_number');
        $default_audit = $this->input->post('default_audit');
        $audit_textarea = $this->input->post('audit_textarea');

        $data = array(
            'audit_name' => $audit_name,
            'include_page_number' => $include_page_number,
            'default_audit' => $default_audit,
            'audit_textarea' => $audit_textarea,
        );

        if ($edit_template == 1 && !empty($template_id)) {

            $where['id']      = $template_id;

            $this->User_model->updatedata('sq_simple_audit_template', $where, $data);
            if ($default_audit == 1) {
                $this->User_model->query("UPDATE sq_simple_audit_template SET default_audit ='0' WHERE id != '" . $template_id . "'");
            }
            $response = ['success' => true, 'message' => 'Template updated successfully'];
        } else {

            $this->User_model->insertdata('sq_simple_audit_template', $data);
            $lastID = $this->db->insert_id();


            if ($default_audit == 1) {
                $this->User_model->query("UPDATE sq_simple_audit_template SET default_audit ='0' WHERE id != '" . $lastID . "'");
            }

            if ($lastID) {
                $response = ['success' => true, 'message' => 'Template added successfully'];
            } else {

                $response = ['success' => false, 'message' => 'Template added successfully'];
            }
        }

        echo json_encode($response);
    }

    public function delete_audit_template()
    {
        $id = $this->input->post('id');

        if (!empty($id)) {
            $this->User_model->query("DELETE FROM sq_simple_audit_template where id = '" . $id . "' ");

            echo json_encode(array('success' => 'Template deleted successfully!', 'Success'));
        } else {

            echo json_encode(array('error' => 'Failed to delete template.'));
        }
    }

    public function send_welcome_email_client($name, $email_address, $password)
    {
        $logolink        = base_url() . 'assets/images/logo.png';
        $site_link        = base_url('client-login');

        $welcome_message = '<div class="table-responsive mb-4"><table style="background:#e9f7ef; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 20px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 30px 20px 30px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($name) . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Welcome to CRX Credit Repair. To access your account, please login into our secure portal and enter your credentials.</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $email_address . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $password . '</td></tr> <tr><td style="text-align: center;"><a href="' . $site_link . '" style="background-color: #28a745; color: #fff; padding: 7px 20px; font-family: Roboto, Arial, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 5px; display: inline-block;">Login Now</a></td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely, and monitor your overall progress.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

        $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');

        $this->email->initialize($email_config);
        $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
        $this->email->to($email_address);
        $this->email->subject('Login Credentials for Secure Client Access');

        $this->email->message($welcome_message);
        $this->email->send();

        return 1;
    }
    
    
    
    

    // My plans s
    public function AllPlans()
    {
        if ($this->session->userdata('user_type') == 'subscriber') {
            redirect(base_url('admin'));
            exit;
        }
        $fetchdata = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE status = 1 ORDER BY sort_order ASC");

        if ($fetchdata->num_rows() > 0) {
            $data['plans'] = $fetchdata->result();
        } else {
            $data['plans'] = [];
        }

        $data['content'] = $this->load->view('subscriptions/my_plans', $data, true);
        $this->load->view('template/template', $data);
    }

public function save_plan_order() {
    // Get JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Check if 'order' exists and is an array
    if (isset($data['order']) && is_array($data['order'])) {
        $order = $data['order'];

        foreach ($order as $position => $id) {
            // Update sort_order for each plan
            $this->db->where('id', $id);
            $this->db->update('sq_subscription_plans', ['sort_order' => $position]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Plan order updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
}

public function addNewPlan()
{
    if ($this->input->post()) {
        $id = $this->input->post('planID');
        $subscription_name = $this->input->post('subscription_name');
        $price = $this->input->post('price');
        $subscription_duration = $this->input->post('subscription_duration');
        $team_permission = $this->input->post('team_permission');
        $clients_permission = $this->input->post('clients_permission');
        $storage_permission = 'Unlimited';
//+ ($price * 0.06625)
        $data = [
            'subscription_name' => $subscription_name,
            'price' => $price ,
            'subscription_duration' => $subscription_duration,
            'team_permission' => $team_permission,
            'clients_permission' => $clients_permission,
            'storage_permission' => $storage_permission,
            'status' => 1,
        ];

        $fetch_plans = $this->User_model->select_where('sq_subscription_plans', array('id' => $id));
        if ($fetch_plans->num_rows() > 0) {
            // UPDATE
            $this->User_model->updatedata('sq_subscription_plans', array('id' => $id), $data);
            $this->session->set_flashdata('plan_success', 'Plan edited successfully!');
        } else {

            $this->db->select_max('sort_order');
            $query = $this->db->get('sq_subscription_plans');
            $maxSortOrder = $query->row()->sort_order;
            $nextSortOrder = is_null($maxSortOrder) ? 0 : $maxSortOrder + 1;

            $data['sort_order'] = $nextSortOrder; // Add sort_order to data

            $this->User_model->insertdata('sq_subscription_plans', $data);
            $this->session->set_flashdata('plan_success', 'Plan added successfully!');
        }

        redirect(base_url('plans'));
    }
}

    public function editPlan()
    {
        $id = $this->input->post('id');
        $plans = $this->User_model->select_where('sq_subscription_plans', array('id' => $id));
        $plans = $plans->row();
        echo json_encode($plans);
    }
public function deletePlan()
{
    $id = $this->input->post('id');

    // Step 1: Get the sort_order of the plan to be deleted
    $this->db->select('sort_order');
    $this->db->where('id', $id);
    $plan = $this->db->get('sq_subscription_plans')->row();

    if ($plan) {
        $deletedSortOrder = $plan->sort_order;

        // Step 2: Delete the plan
        $this->User_model->delete('sq_subscription_plans', ['id' => $id]);

        // Step 3: Update sort_order of plans that were after the deleted one
        $this->db->set('sort_order', 'sort_order - 1', FALSE);
        $this->db->where('sort_order >', $deletedSortOrder);
        $this->db->update('sq_subscription_plans');

        echo '1';
    } else {
        // Plan not found
        echo '0';
    }
}

    // My plans e

    public function save_client_letter()
    {

        $user_id = $this->session->userdata('user_id');
        $client_id = $this->input->post('client_id');
        $letter_name = $this->input->post('letter_name');
        $category = $this->input->post('category');
        $subcategory = $this->input->post('subcategory');
        $client_letter = $this->input->post('client_letter');

        $data = [
            'client_id' => $client_id,
            'letter_name' => $letter_name,
            'category' => $category,
            'subcategory' => $subcategory,
            'client_letter' => $client_letter,
            'created_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->User_model->insertdata('client_saved_letters', $data);

        echo json_encode(['status' => 'success', 'message' => 'Client letter saved successfully.']);
    }


    public function save_client_letters()
    {

        $user_id = $this->session->userdata('user_id');
        $client_id = $this->input->post('client_id');
        $letter_name = $this->input->post('letter_name');
        $client_letter = $this->input->post('client_letter');
         $abbrevation = $this->input->post('abbrevation');
         $follow_up = $this->input->post('follow_up');
         $round = $this->input->post('round');
           $dispute_item_id = $this->input->post('dispute_item_id');
             $letter_formate = $this->input->post('letter_formate');

        $data = [
            'client_id' => $client_id,
            'letter_name' => $letter_name,
            'client_letter' => $client_letter,
            'created_by' => $user_id,
             'abbrevation' => $abbrevation,
              'follow_up' => $follow_up,
               'round' => $round,
               'dispute_item_id'=>$dispute_item_id,
              'letter_formate' => isset($letter_formate) ? $letter_formate : 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->User_model->insertdata('client_saved_letters', $data);
 $this->User_model->query("UPDATE sq_clients SET letter_saved = '1' WHERE sq_client_id = '" . $client_id . "'");

        echo json_encode(['status' => 'success', 'message' => 'Client letter saved successfully.']);
    }
    public function update_client_letter()
{
    $user_id = $this->session->userdata('user_id');
    $client_id = $this->input->post('id');
    $client_letter = $this->input->post('client_letter');
 $this->User_model->query("UPDATE client_saved_letters SET client_letter = '$client_letter' WHERE id = '" . $client_id . "'");

    echo json_encode(['status' => 'success', 'message' => 'Client letter updated successfully.']);
}

     public function client_dispute_item_bureau_remove(){
             $user_id = $this->session->userdata('user_id');
          $id = $this->input->post('id');
        $bureau = $this->input->post('bureau');
        $this->User_model->query("UPDATE sq_dispute_item SET $bureau ='0' WHERE id = '" . $id . "'");
        echo json_encode(['status' => 'success']);
     }
    public function get_unread_notifications()
    {
        $user_id = $this->session->userdata('user_id');
        $unread_notifications = $this->User_model->query("SELECT * FROM notifications WHERE (`sender_id` != $user_id AND `receiver_id` = $user_id) AND `read_status` = 0 ORDER BY created_at DESC")->result();

        echo json_encode(['notifications' => $unread_notifications]);
    }


    public function mark_all_read()
    {
        $user_id = $this->session->userdata('user_id');
        // $this->User_model->updatedata('notifications', ['read_status' => 1], ['receiver_id' => $user_id]);
        $this->User_model->query("UPDATE notifications SET read_status ='1' WHERE receiver_id = '" . $user_id . "'");
        echo json_encode(['status' => 'success']);
    }


    public function mark_as_read()
    {
        $notification_id = $this->input->post('notification_id');
        // $this->User_model->updatedata('notifications', ['read_status' => 1], ['id' => $notification_id]);
        $this->User_model->query("UPDATE notifications SET read_status ='1' WHERE id = '" . $notification_id . "'");
        echo json_encode(['status' => 'success']);
    }

    public function saved_letters()
    {

        $client_id   = get_dencoded_id($this->uri->segment(2));

        $getData = $this->User_model->query("SELECT * FROM client_saved_letters WHERE client_id = '" . $client_id . "'");
        $saved_letters = $getData->result();

        $where['sq_client_id'] = $client_id;
        $getClient = $this->User_model->select_where('sq_clients', $where);
        $client_result = $getClient->row();

        $data['saved_letters'] = $saved_letters;
        $data['client_result'] = $client_result;

        $data['content'] = $this->load->view('admin/client_saved_letter', $data, true);
        $this->load->view('template/template', $data);
    }

    public function save_dispute_item()
    {
        $post = $this->input->post();

        $data = [
            'creditor_furnisher' => $post['creditor_furnisher'],
            'dispute_reason' => $post['dispute_reason'],
            'dispute_instruction' => $post['dispute_instruction'],
            'account_mode' => $post['account_mode'],
            'account_number_all' => $post['account_number_all'],
            'equifax_account' => $post['equifax_account'],
            'experian_account' => $post['experian_account'],
            'transunion_account' => $post['transunion_account'],
            'equifax' => $post['bureaus']['equifax'] ?? 0,
            'experian' => $post['bureaus']['experian'] ?? 0,
            'transunion' => $post['bureaus']['transunion'] ?? 0,
        ];

        $saved = $this->save_item($data);
        if ($saved) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save item']);
        }
    }

public function save_dispute_item_client(){
    $post = $this->input->post();
 
        $data = [
            'furnisher' => $post['furnisher'],
            'reason' => $post['reason'],
            'instruction' => $post['instruction'],
            'equifax' => $post['equifax'] ?? 0,
            'experian' => $post['experian'] ?? 0,
            'transunion' => $post['transunion'] ?? 0,
            'client_id' => $post['id'],
    'equi_status'  => ($post['equifax'] ?? '0') === '1' ? 'Negative' : NULL,
    'exper_status' => ($post['experian'] ?? '0') === '1' ? 'Negative' : NULL,
    'tu_status'    => ($post['transunion'] ?? '0') === '1' ? 'Negative' : NULL,
  'added_date'   => date('Y-m-d'),
   'tu_ac' => $post['transunion_account'],
    'exper_ac' => $post['experian_account'],
     'equi_ac' => $post['equifax_account'],
        ];

        $saved = $this->save_item_dispute($data);
        
        if ($saved) {
            $sql = "SELECT * FROM sq_dispute_item ORDER BY id DESC LIMIT 1";
            $query = $this->User_model->query($sql);
            $result = $query->row();
            $last_id = $result->id;
            echo json_encode(['status' => 'success','data'=>$result]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save item']);
        }
}
    public function save_item($data)
    {
        return $this->db->insert('dispute_items', $data);
    }
    
     public function save_item_dispute($data)
    {
        return $this->db->insert('sq_dispute_item', $data);
    }
    
    public function edit_dispute_item()
    {
        $id   = $this->uri->segment(2);
           $getData = $this->User_model->query("SELECT * FROM sq_dispute_item WHERE id = '" . $id . "'");
        $data = $getData->result();
                $fetchFurnishers = $this->User_model->query('SELECT * FROM sq_furnisher');
    if ($fetchFurnishers->num_rows() > 0) {
        $data['furnishers'] = $fetchFurnishers->result();
    } else {
        $data['furnishers'] = [];
    }
            echo json_encode(['status' => 'success','data'=>$data]);
  
    }
  public function update_dispute_item()
{
    $id = $this->uri->segment(2); // URI: /update-dispute-item/{id}

    // Get raw POST data (make sure POST method is used)
    $data = [
        'added_date'         => $this->input->post('added_date'),
        'furnisher' => $this->input->post('creditor_furnisher'),
        'reason'     => $this->input->post('dispute_reason'),
        'instruction'=> $this->input->post('dispute_instruction'),
        'equifax'            => $this->input->post('equifax'),
        'equi_status'        => $this->input->post('equi_status') ?: null,
        'experian'           => $this->input->post('experian'),
      'exper_status' => $this->input->post('exper_status') ?: null,
        'transUnion'         => $this->input->post('transUnion'),
        'tu_status'          => $this->input->post('tu_status') ?: null,
    ];

    // Optional: validate ID and required fields
    if (!$id || empty($data['added_date'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        return;
    }

    // Run update query
    $this->db->where('id', $id);
    $this->db->update('sq_dispute_item', $data);

    if ($this->db->affected_rows() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Dispute item updated successfully.']);
    } else {
        echo json_encode(['status' => 'warning', 'message' => 'No changes were made or invalid ID.']);
    }
}
  public function delete_dispute_item()
{
    $id = $this->uri->segment(2); 
     $this->User_model->query("DELETE FROM sq_dispute_item where id = '" . $id . "' ");
         echo json_encode([
            'status' => 'success',
            'message' => 'Item deleted successfully'
        ]);
}


    public function sendWelcomeMail()
    {
         $post = $this->input->post();
             $type = $post['type'];
                  $logolink        = base_url() . 'assets/images/logo.png';
         if($post['type'] == 'client'){
             $clientId = $post['id'];
             $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientId));
            if ($fetchclients->num_rows() > 0) {
                $data = $fetchclients->result();
            } else {
                $data = [];
            }
          
            $email_address= $data[0]->sq_email;
            $first_name = $data[0]->sq_first_name;
            $first_letters = substr($first_name, 0, 3);
            $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);
            $password = $first_letters . $random_string;
            $hashed_password = md5($password);
            $name =  $first_name . ' ' . $data[0]->sq_last_name;
             $update_client_data = array(
                    "login_detail_sent_date" => date('Y-m-d H:i A'),
                    "s_password"=>$password,
                    "password"=>$hashed_password
                );

                $this->User_model->updatedata('sq_clients', array("sq_client_id" => $clientId), $update_client_data);

   
        $site_link        = base_url('client-login');

        $welcome_message = '<div class="table-responsive mb-4"><table style="background:#e9f7ef; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 20px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 30px 20px 30px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($name) . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Welcome to CRX Credit Repair. To access your account, please login into our secure portal and enter your credentials.</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $email_address . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $password . '</td></tr> <tr><td style="text-align: center;"><a href="' . $site_link . '" style="background-color: #28a745; color: #fff; padding: 7px 20px; font-family: Roboto, Arial, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 5px; display: inline-block;">Login Now</a></td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely, and monitor your overall progress.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

        $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');

        $this->email->initialize($email_config);
        $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
        $this->email->to($email_address);
        $this->email->subject('Login Credentials for Secure Client Access');

        $this->email->message($welcome_message);
        
        if (!$this->email->send()) {
            $debug_info = $this->email->print_debugger(['headers']);
        
            if (strpos($debug_info, '250 OK') !== false) {
                log_message('info', 'Email sent to: ' . $email_address); // false error but actually sent
            } else {
                log_message('error', 'Email failed to: ' . $email_address);
            }
        } else {
            log_message('info', 'Email sent to: ' . $email_address);
        }


        return 1;
         }
         else{
   $affiliatesId = $post['id'];
$query = $this->User_model->query("SELECT * FROM sq_affiliates WHERE sq_affiliates_id = '$affiliatesId'");

if ($query->num_rows() > 0) {
     $site_link        = base_url('affiliate-login');
    $row = $query->row(); 
    $name = $row->sq_affiliates_first_name . ' ' . $row->sq_affiliates_last_name;
    $email = $row->sq_affiliates_email;
    $first_letters = substr($row->sq_affiliates_first_name, 0, 3);
    $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
    $password_plain = $first_letters . $random_string;
    $encoded_password = base64_encode($password_plain);

    $update_data = array(
        "sq_affiliates_password" => $encoded_password
    );
    $this->User_model->updatedata('sq_affiliates', array("sq_affiliates_id" => $affiliatesId), $update_data);
      $msg = '<p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Visit: <a href="' . $site_link . '" style="color:#0099ff" target="_blank">' . base_url("affiliate-login") . '</a>
                 <br/><br>User ID: <span style="color:#0099ff">' . $email . '</span>
                <br>Password: <span style="color:#0099ff">' . $password_plain . '</span></p>';
   $message = '<table style="width:100%" bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <br>
                <table style="width:600px" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="background:#fff;border:#f2f2f2 solid 1px;border-top:0px;padding:20px;font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;line-height:22px" align="left" valign="top">
                                <a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><br/><br/><br/><p style="font-family:Helvetica,Arial,sans-serif;font-size:18px;color:#606060"><b>Dear ' . ucwords($name) . ',</b>
                                </p>
                                <p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Welcome to CRX Credit Repair. To access your account, please log into our secure portal and enter your credentials:</p>
                               ' . $msg . '
                                </p>
                                <p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely and monitor your overall progress.</p>
                                <p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                &nbsp;</td>
        </tr>
    </tbody>
</table>';
      $this->load->config('email_custom');
      $email_config = $this->config->item('email_config');

      $this->email->initialize($email_config);
      $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
      $this->email->to($email);
      $this->email->subject('Login Credentials for Secure Affiliate Access');

      $this->email->message($message);
        if (!$this->email->send()) {
            $debug_info = $this->email->print_debugger(['headers']);
        
            if (strpos($debug_info, '250 OK') !== false) {
                log_message('info', 'Email sent to: ' . $email); // false error but actually sent
            } else {
                log_message('error', 'Email failed to: ' . $email);
            }
        } else {
            log_message('info', 'Email sent to: ' . $email);
        }

       return 1;
}



         }
    }
    
public function get_letters_by_category() {
    $category_id = $this->input->post('category_id');

    if ($category_id != 0) {
        $this->db->where('category', $category_id);
    }

    $letters = $this->db->get('sq_letters')->result();

    $options = '<option value="">Select a Letter</option>';
    foreach ($letters as $letter) {
        // Safely escape content and title
        $letter_content = htmlspecialchars($letter->content, ENT_QUOTES, 'UTF-8');
        $letter_title = htmlspecialchars($letter->letter_title, ENT_QUOTES, 'UTF-8');

        $options .= '<option value="' . $letter->id . '" data-content="' . $letter_content . '">' . $letter_title . '</option>';
    }

    echo $options;
}

   public function my_task()
  {
    $user= $this->session->userdata('user_id');
          $fetch_bills = $this->User_model->query("SELECT * FROM sq_users WHERE sq_u_id  = '" . $user . "'");
      $fetch = $fetch_bills->result();
$name= $fetch[0]->sq_u_first_name.' '.$fetch[0]->sq_u_last_name;

  $tasks = $this->User_model->query("SELECT * FROM sq_task WHERE team_member_id LIKE '%" . $name . "%'");

 $data['tasks_data'] = $tasks->result();

              $data['content'] = $this->load->view('admin/my_task', $data, true);
        $this->load->view('template/template', $data);
        
  }
 public function letter_get()
{
    $client_id = $this->input->post('id');
    $created = $this->input->post('created');
    $itemId = $this->input->post('itemId');
    $query = $this->User_model->query("
        SELECT * FROM client_saved_letters 
        WHERE client_id = '" . $client_id . "' 
        AND created_at = '" . $created . "' 
        AND dispute_item_id = '" . $itemId . "'
    ");
     $result = $query->result(); 
    echo json_encode($result[0]);
}
public function resend_payment_link()
{
    $client_id = $this->input->post('client_id');

    if ($client_id) {
          $where['sq_client_id'] = $client_id;
        $getClient = $this->User_model->select_where('sq_clients', $where)->result_array();
$crxid = $getClient[0]['crx_hero_userId']; 
  $to = $getClient[0]['sq_email'];
    $name = $getClient[0]['sq_first_name'] . ' ' . $getClient[0]['sq_last_name'];
    $payment_link = "https://crxhero.com/payment?id=$crxid";
    $this->send_payment_email($to, $name, $payment_link);
  echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Client ID missing']);
    }
}

public function send_payment_email($to_email, $client_name, $payment_link)
{
  $logolink   = 'https://thecreditrepairxperts.com/assets/images/logo.png';
$site_link  = 'https://crxhero.com';

$message = "
    <div style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>
        <div style='text-align: center; margin-bottom: 20px;'>
            <a href='{$site_link}' target='_blank'>
                <img src='{$logolink}' alt='CRX Hero' style='max-width: 200px;'>
            </a>
        </div>

        <p>Dear {$client_name},</p>

        <p>Please use the link below to complete your payment:</p>

        <p>
            <a href='{$payment_link}' target='_blank' style='color: #007bff; text-decoration: none;'>
                {$payment_link}
            </a>
        </p>

        <p>Thank you!</p>

        <hr style='margin: 30px 0; border: none; border-top: 1px solid #ddd;'>

        <p style='font-size: 12px; text-align: center; color: #777;'>
            &copy; " . date('Y') . " The Credit Repair. All rights reserved.
        </p>
    </div>
";



            $this->load->config('email_custom');
            $email_config = $this->config->item('email_config');

            $this->email->initialize($email_config);
            $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
             
                 $this->email->to($to_email);
                 $this->email->subject('CRX HERO Payment Link - ' . $client_name);
                $this->email->message($message);

    // Send email
    if ($this->email->send()) {
        return 1;
    } else {
        log_message('error', $this->email->print_debugger()); // for debugging
        return false;
    }
}

}
