<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/phpmailer/src/Exception.php';
require FCPATH . 'vendor/phpmailer/src/PHPMailer.php';
require FCPATH . 'vendor/phpmailer/src/SMTP.php';

class Dashboard extends MY_Controller
{
  private $lobApiUrl = 'https://api.lob.com/v1';
  // private $apiKey = 'test_de4018cc5371bdc4e465441ba5c41727c44'; // Secret API Key
  private $apiKey = 'live_d877b5d83041c8417a55fbde521d6485c25'; // Secret API Key

  function __construct()
  {

    parent::__construct();

    // redirect to sigin page if not logged in 
    if ($this->session->userdata('user_id') == '') {
      redirect(base_url());
      exit;
    }

    if ($this->session->userdata('user_type') == 'client') {
      redirect(base_url('client/dashboard'));
      exit;
    }

    // if ($this->session->userdata('user_type') == 'subscriber') {
    //   redirect(base_url('subscriber/dashboard'));
    //   exit;
    // }

    //ini_set('post_max_size', '1200M');
    //ini_set('max_input_vars', '40000');

    ini_set('upload_max_size', '640M');
    ini_set('post_max_size', '640M');
    ini_set('max_execution_time', '300');


    $this->load->helper('url');
    $this->load->model('User_model');
    $this->load->library('encryption');
       $this->load->model('AgreementModel');

    $this->load->library('form_validation');
  }

  public function redirectToDashboard()
  {

    error_reporting(0);
    $urisegment = $this->uri->segment(2);
    $clientID = $urisegment;

    $where['sq_client_id'] = $clientID;
    $getClient = $this->User_model->select_where('sq_clients', $where);
    $client_result = $getClient->result();

    if (!$client_result) {

      show_error('Client information not found.', 404);
    }

    $email = $client_result[0]->crx_hero_user_name;
    $password = $client_result[0]->crx_hero_password;

    $this->session->set_userdata('admin_user_id', $client_result[0]->crx_hero_id);
    $this->session->set_userdata('admin_login', 'crxhs');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://crxhero.com/login");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
      'email' => $email,
      'password' => $password
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
      return;
    }

    redirect("https://crxhero.com/saved-reports");

    curl_close($ch);
  }

  public function dashboard()
  {
    // agreement_text1
    error_reporting(0);
    $urisegment = $this->uri->segment(2);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);

    /////////////////////////////////////////////////////////////////////////// New added s

    $userID = $clientID;

    $where['sq_client_id'] = $userID;
    $getClient = $this->User_model->select_where('sq_clients', $where);
    $client_result = $getClient->result();
    $this->data['getClient'] = $getClient->result();

    $d_where['client_id'] = $userID;
    // $d_where['document_type'] = 'agreement';
    $get_document = $this->User_model->select_where('sq_clients_documents', $d_where);
    $client_document_result = $get_document->result();
    $data['client_document'] = $client_document_result;

    $id_agreement['id'] = $client_result[0]->agreement_id;
    $agreement = $this->User_model->select_where('client_agreements', $id_agreement);
    $this->data['agreement'] = $agreement->result();
    $agreement_result = $agreement->result();

    if ($client_document_result) {
      $f_name = $client_result[0]->sq_first_name ?? '';
      $l_name = $client_result[0]->sq_last_name ?? '';
      $name = trim("$f_name $l_name");
      // Define the placeholders and their corresponding values
      $placeholders = ['{{name}}', '{{address}}', '{{state}}', '{{city}}', '{{zip}}', '{{dob}}', '{{date}}'];
      $replacements = [
        $name,
        $client_result[0]->sq_mailing_address,
        $client_result[0]->sq_state,
        $client_result[0]->sq_city,
        $client_result[0]->sq_zipcode,
         date('m/d/Y', strtotime($client_result[0]->sq_dob)),
          date('m/d/Y')  // Current date
      ];
  $agreement = $this->AgreementModel->get_default_agreement();

      $agreementText = str_replace($placeholders, $replacements, $agreement->agreement_text);
    } else {
      $agreementText = 'No agreement found.';
    }

    $data['agreement_text'] = $agreementText;
    $data['name'] = $name;

    /////////////////////////////////////////////////////////////////////////// New added e

    //echo $invID;
    if ($clientID != '') {

      $fetchClientinfo = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchClientinfo->num_rows() > 0) {
        $fetchClientinfo = $fetchClientinfo->result();
        $data['fetchClientinfo'] = $fetchClientinfo;
      }
 $fetchempinfo = $this->User_model->query("SELECT * FROM `sq_users`");
      if ($fetchempinfo->num_rows() > 0) {
      $data['fetchempinfo'] = $fetchempinfo->result();
      }

      // $fetchsq_task = $this->User_model->select_where('sq_task', array('clients' => $clientID, 'task_status' => 'Pending'));
      // if ($fetchsq_task->num_rows() > 0) {
      //   $data['fetchsq_task'] = $fetchsq_task->result();
      // }


      // // New added 13-02-2025 s
      // $where_t['sq_client_id'] = $clientID;
      // $where_t['task_status'] = 'Pending';
      // $team_member_task = $this->User_model->select_where('sq_task', $where_t);
      // if ($team_member_task->num_rows() > 0) {
      //   $data['team_member_task'] = $team_member_task->result();
      // }
      // // New added 13-02-2025 e+
       $where = ['sq_client_id' => $clientID];
 $fetchsq_task = $this->User_model->select_where('sq_task', $where);
      if ($fetchsq_task->num_rows() > 0) {
        $data['tasks'] = $fetchsq_task->result();
      }
      
      $where = ['clients' => $clientID, 'task_status' => 'Pending'];
      $fetchsq_task = $this->User_model->select_where('sq_task', $where);
      $data['fetchsq_task'] = $fetchsq_task->num_rows() > 0 ? $fetchsq_task->result() : [];

      $where_t = ['sq_client_id' => $clientID, 'task_status' => 'Pending'];
      $team_member_task = $this->User_model->select_where('sq_task', $where_t);
      $data['team_member_task'] = $team_member_task->num_rows() > 0 ? $team_member_task->result() : [];

      $wheret['teams'] = '0';
      $wheret['clients'] = '0';
      $wheret['task_status'] = 'Pending';
      $fetchsq_team = $this->User_model->select_where('sq_task', $wheret);
      if ($fetchsq_team->num_rows() > 0) {
        $data['fetchsq_team'] = $fetchsq_team->result();
      }

      $fetchsqtaskComle = $this->User_model->select_where('sq_task', array('clients' => $clientID, 'task_status' => 'Completed'));
      if ($fetchsqtaskComle->num_rows() > 0) {
        $data['fetchsqtaskComle'] = $fetchsqtaskComle->result();
      }

      $wheretc['teams'] = '0';
      $wheretc['clients'] = '0';
      $wheretc['task_status'] = 'Completed';
      $fetchsq_teamcc = $this->User_model->select_where('sq_task', $wheretc);
      if ($fetchsq_teamcc->num_rows() > 0) {
        $data['fetchsq_teamcc'] = $fetchsq_teamcc->result();
      }

      $fetchsq_document_receive = $this->User_model->select_where('sq_document_receive', array('client_id' => $clientID));
      if ($fetchsq_document_receive->num_rows() > 0) {
        $fetchsq_document_receive = $fetchsq_document_receive->result();
        foreach ($fetchsq_document_receive as $key => $value) {

          $data['document_id'][$value->document_id] = $value->document_id;
          $data['document_link'][$value->document_id] = $value->document_link;
          $data['status'][$value->document_id] = $value->status;
          $data['docreceid'][$value->document_id] = $value->id;
        }
      }

      //Fetch client sq_spouse...
      $fetchsq_spouse = $this->User_model->select_where('sq_spouse', array('client_id' => $clientID));
      if ($fetchsq_spouse->num_rows() > 0) {
        $fetchsq_spouse = $fetchsq_spouse->result();
        $data['clientspouse'] = $fetchsq_spouse;
      }

      //Fetch client memo...
      $fetchMemo = $this->User_model->select_where('sq_memo', array('client_id' => $clientID));
      if ($fetchMemo->num_rows() > 0) {
        $fetchMemo = $fetchMemo->result();
        $data['clientMemo'] = $fetchMemo[0]->memo_text;
      } else {
        $data['clientMemo'] = '';
      }


      //Fetch client programe...
      $fetchsq_program_type = $this->User_model->select_where('sq_program_type', array('client_id' => $clientID));
      if ($fetchsq_program_type->num_rows() > 0) {
        $fetchsq_program_type = $fetchsq_program_type->result();
        $data['fetchsq_program_type'] = $fetchsq_program_type[0]->program_type;
      } else {
        $data['fetchsq_program_type'] = '';
      }

      if ($fetchClientinfo[0]->sq_assigned_to != '') {
       $sq_assigned_to = $fetchClientinfo[0]->sq_assigned_to;

$where = [
    "CONCAT(sq_u_first_name, ' ', sq_u_last_name) =" => $sq_assigned_to
];

$this->db->where($where);
$data['get_login_user_info'] = $this->db->get('sq_users')->row();

  
      }

      $data['total_invoiced'] = $this->total_invoiced($clientID);
      $data['total_received'] = $this->total_received($clientID);
      $data['fetchClientscore'] = $this->fetchClientscore($clientID);
      $data['getalldisputeItem'] = $this->getalldisputeItem($clientID);
      $data['fetch_all_docName'] = $this->fetch_all_docName();

      $data['get_allaffiliate_name'] = $this->get_allaffiliate_name();

      $email = $client_result[0]->sq_email ?? '';
      $wherever['user_name'] = $email;
      $getCRXDetails = $this->User_model->select_where('crx_hero_registration', $wherever);

      $data['client_score'] = $getCRXDetails->result();

      $client_progress = $this->get_client_progress($clientID);
      $data['progress'] = $client_progress;

      $data['notes'] = $this->get_all_notesc($clientID);
        $disputestatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'In Dispute' THEN 1 END) AS in_dispute_equi,
        COUNT(CASE WHEN `exper_status` = 'In Dispute' THEN 1 END) AS in_dispute_exper,
        COUNT(CASE WHEN `tu_status` = 'In Dispute' THEN 1 END) AS in_dispute_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($disputestatusdata->num_rows() > 0) {
        $data['disputestatus'] = $disputestatusdata->result();
        } else {
        $data['disputestatus'] = [];
        }
         $negativestatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Negative' THEN 1 END) AS negative_equi,
        COUNT(CASE WHEN `exper_status` = 'Negative' THEN 1 END) AS negative_exper,
        COUNT(CASE WHEN `tu_status` = 'Negative' THEN 1 END) AS negative_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($negativestatusdata->num_rows() > 0) {
        $data['negativestatus'] = $negativestatusdata->result();
        } else {
        $data['negativestatus'] = [];
        }
        $Updatedstatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Updated' THEN 1 END) AS in_Updated_equi,
        COUNT(CASE WHEN `exper_status` = 'Updated' THEN 1 END) AS in_Updated_exper,
        COUNT(CASE WHEN `tu_status` = 'Updated' THEN 1 END) AS in_Updated_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($Updatedstatusdata->num_rows() > 0) {
        $data['Updatedstatus'] = $Updatedstatusdata->result();
        } else {
        $data['Updatedstatus'] = [];
        }
         $Deletedstatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Deleted' THEN 1 END) AS in_Deleted_equi,
        COUNT(CASE WHEN `exper_status` = 'Deleted' THEN 1 END) AS in_Deleted_exper,
        COUNT(CASE WHEN `tu_status` = 'Deleted' THEN 1 END) AS in_Deleted_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($Deletedstatusdata->num_rows() > 0) {
        $data['Deletedstatus'] = $Deletedstatusdata->result();
        } else {
        $data['Deletedstatus'] = [];
        }
         $Repairedstatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Repaired' THEN 1 END) AS in_Repaired_equi,
        COUNT(CASE WHEN `exper_status` = 'Repaired' THEN 1 END) AS in_Repaired_exper,
        COUNT(CASE WHEN `tu_status` = 'Repaired' THEN 1 END) AS in_Repaired_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($Repairedstatusdata->num_rows() > 0) {
        $data['Repairedstatus'] = $Repairedstatusdata->result();
        } else {
        $data['Repairedstatus'] = [];
        }
        $Unspecifiedstatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Unspecified' THEN 1 END) AS in_Unspecified_equi,
        COUNT(CASE WHEN `exper_status` = 'Unspecified' THEN 1 END) AS in_Unspecified_exper,
        COUNT(CASE WHEN `tu_status` = 'Unspecified' THEN 1 END) AS in_Unspecified_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($Unspecifiedstatusdata->num_rows() > 0) {
        $data['Unspecifiedstatus'] = $Unspecifiedstatusdata->result();
        } else {
        $data['Unspecifiedstatus'] = [];
        }
        $Verifiedstatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Verified' THEN 1 END) AS in_Verified_equi,
        COUNT(CASE WHEN `exper_status` = 'Verified' THEN 1 END) AS in_Verified_exper,
        COUNT(CASE WHEN `tu_status` = 'Verified' THEN 1 END) AS in_Verified_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($Verifiedstatusdata->num_rows() > 0) {
        $data['Verifiedstatus'] = $Verifiedstatusdata->result();
        } else {
        $data['Verifiedstatus'] = [];
        }
        $Positivestatusdata  = $this->User_model->query("SELECT 
        COUNT(CASE WHEN `equi_status` = 'Positive' THEN 1 END) AS in_Positive_equi,
        COUNT(CASE WHEN `exper_status` = 'Positive' THEN 1 END) AS in_Positive_exper,
        COUNT(CASE WHEN `tu_status` = 'Positive' THEN 1 END) AS in_Positive_tu
        FROM `sq_dispute_item`
        WHERE `client_id` = $clientID");
        if ($Positivestatusdata->num_rows() > 0) {
        $data['Positivestatus'] = $Positivestatusdata->result();
        } else {
        $data['Positivestatus'] = [];
        }
      $data['ss'] = '';
      $data['content'] = $this->load->view('dashboard/client_dashboard', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////

  public function save_notes()
  {
    try {
      // Prepare note data
      $note_data = [
        'note' => $this->input->post('note'),
        'is_pinned' => $this->input->post('is_pinned') ? 1 : 0,
           'client_id' => $this->input->post('client_id'),
        'created_at' => date('Y-m-d H:i:s')
      ];

      // Save the note and get the ID
      $note_id = $this->save_note($note_data);

      // Handle attachments
      if (!empty($_FILES['attachments']['name'][0])) {
        $this->save_attachments($note_id, $_FILES);
      }

      // Return success response for SweetAlert
      echo json_encode([
        'status' => 'success',
        'message' => 'Note saved successfully!'
      ]);
    } catch (Exception $e) {
      // Return error response for SweetAlert
      echo json_encode([
        'status' => 'error',
        'message' => 'Failed to save the note. Please try again later.'
      ]);
    }
  }

  public function save_note($data)
  {
    $this->db->insert('client_notes', $data);
    return $this->db->insert_id();
  }


  public function save_attachments($note_id, $files)
  {
    $upload_path = './uploads/notes/';
    if (!file_exists($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    foreach ($files['attachments']['name'] as $key => $filename) {
      $temp_name = $files['attachments']['tmp_name'][$key];
      $new_name = uniqid() . '_' . $filename;
      $path = base_url() . '/uploads/notes/' . $new_name;
      move_uploaded_file($temp_name, $upload_path . $new_name);

      $this->db->insert('note_attachments', [
        'note_id' => $note_id,
        'file_path' => $path
      ]);
    }
  }

  public function get_all_notes()
  {
    $this->db->order_by('is_pinned', 'DESC');
    $query = $this->db->get('client_notes');
    $notes = $query->result();

    // Fetch attachments for each note
    foreach ($notes as $note) {
      $note->attachments = $this->db->get_where('note_attachments', ['note_id' => $note->id])->result();
    }

    return $notes;
  }
  public function get_all_notesc($clientID)
  {
    $this->db->order_by('is_pinned', 'DESC');
    $this->db->order_by('id', 'DESC');
      $this->db->where('client_id', $clientID);
    $query = $this->db->get('client_notes');
    
    $notes = $query->result();
    // Fetch attachments for each note
    foreach ($notes as $note) {
      $note->attachments = $this->db->get_where('note_attachments', ['note_id' => $note->id])->result();
    }

    return $notes;
  }


  public function get_attachmentss($note_id)
  {
    $attachments = $this->get_attachments($note_id);
    echo json_encode($attachments);
  }

  public function delete_note()
  {
    $note_id = $this->input->post('note_id');
    $this->delete_note_and_attachments($note_id);
    echo json_encode(['status' => 'success']);
  }


  public function get_attachments($note_id)
  {
    $this->db->where('note_id', $note_id);
    $query = $this->db->get('note_attachments');
    return $query->result();
  }

  public function delete_note_and_attachments($note_id)
  {
    $this->db->delete('client_notes', ['id' => $note_id]);
    $this->db->delete('note_attachments', ['note_id' => $note_id]);
  }

  public function edit_note()
  {
    $note_id = $this->input->post('note_id');
    $note = $this->input->post('note');
    $is_pinned = $this->input->post('is_pinned') ? 1 : 0;

    if (empty($note)) {
      echo json_encode(['status' => 'error', 'message' => 'Note content cannot be empty.']);
      return;
    }

    $updated_data = [
      'note' => $note,
      'is_pinned' => $is_pinned,
      'created_at' => date('Y-m-d H:i:s')
    ];

    if ($this->update_note_data($note_id, $updated_data)) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update the note.']);
    }
  }

  public function update_note_data($note_id, $data)
  {
    $this->db->where('id', $note_id);
    return $this->db->update('client_notes', $data);
  }


  /////////////////////////////////////////////////////////////////////////////////////////////////////////////

  public function get_client_progress($clientID)
  {
    // Select only the required columns
    $this->db->select('login_detail_sent_date, last_login, agreement_signed, crx_hero_userId, crx_hero_report_path, letter_saved');
    $this->db->where('sq_client_id', $clientID);
    $query = $this->db->get('sq_clients');
    return $query->row_array();
  }


  public function array_api()
  {

    error_reporting(0);
    $urisegment = $this->uri->segment(2);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);

    if ($clientID != '') {

      $fetchClientinfo = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchClientinfo->num_rows() > 0) {
        $fetchClientinfo = $fetchClientinfo->result();
        $data['fetchClientinfo'] = $fetchClientinfo;
      }

      if ($fetchClientinfo[0]->sq_assigned_to != '') {
        $data['get_login_user_info'] = $this->get_login_user_info($fetchClientinfo[0]->sq_assigned_to);
      }


      $data['clientID'] = $clientID;
      $data['content'] = $this->load->view('dashboard/array_api', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function create_array_user()
  {

    error_reporting(0);
    $urisegment = $this->uri->segment(2);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox.array.io/api/user/v2',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
            "appKey":"3F03D20E-5311-43D8-8A76-E4B5D77793BD",
            "firstName":"DONALD",
            "lastName":"BLAIR",
            "dob":"1939-09-20",
            "ssn":"666285344",
            "address": {
              "street":"3627 W POPLAR ST",
              "city":"SAN ANTONIO",
              "state":"TX",
              "zip":"78228"
            }
          }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $datas = json_decode($response);

    $this->User_model->updatedata('sq_clients', array('sq_client_id' => $urisegment), array('array_clientkey' => $datas->clientKey));

    redirect(base_url() . 'array_api/' . get_encoded_id($urisegment));
  }

  public function submit_answer()
  {
    error_reporting(0);
    if (isset($_POST['submit'])) {

      $clientKey = $this->input->post('clientKey');
      $authToken = $this->input->post('authToken');
      $clientID = $this->input->post('clientID');

      unset($_POST['clientKey']);
      unset($_POST['authToken']);
      unset($_POST['clientID']);
      unset($_POST['submit']);

      $answers = '';
      $count = 1;
      foreach ($_POST as $key => $value) {
        if ($count <= 2) {
          $comma = ',';
        } else {
          $comma = '';
        }
        $answers .= ' "' . $key . '": "' . $value . '"' . $comma . '';
        $count++;
      }

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.array.io/api/authenticate/v2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
              "appKey": "3F03D20E-5311-43D8-8A76-E4B5D77793BD",
              "clientKey": "' . $clientKey . '",
              "authToken": "' . $authToken . '",
              "answers": { ' . $answers . ' },
              "ttlInMinutes": "15"
            }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Accept: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $datas = json_decode($response);

      $data['userToken'] = $datas->userToken;
      $data['clientKey'] = $clientKey;
      $data['clientID'] = $clientID;
      $data['content'] = $this->load->view('dashboard/array_userToken', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function get_json()
  {

    $reportKey = $this->input->post('reportKey');
    $displayToken = $this->input->post('displayToken');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox.array.io/api/report/v2?reportKey=' . $reportKey . '&displayToken=' . $displayToken . '',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $datas = json_decode($response);
  }

  public function replaceArrayKeys($array)
  {
    $replacedKeys = str_replace('@', 'CREDIT', array_keys($array));
    return array_combine($replacedKeys, $array);
  }
  public function get_html()
  {

    $reportKey = $this->input->post('reportKey');
    $displayToken = $this->input->post('displayToken');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox.array.io/api/report/v2/html?reportKey=' . $reportKey . '&displayToken=' . $displayToken . '',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
  }

  public function DeleteDocument()
  {

    $recID  = $this->input->post('recID');
    $this->User_model->delete('sq_document_receive', array('id' => $recID));
    $this->allActivity('Client document removed successfully!'); //track activity
    echo '1';
  }

  public function ReceivedDocumentdata()
  {

    $status = $this->input->post('status');
    $recID  = $this->input->post('recID');
    $this->User_model->updatedata('sq_document_receive', array('id' => $recID), array('status' => $status));

    if ($status == '1') {
      $res['msg'] = 'Document received successfully';
      $res['code'] = '1';
    } else {
      $res['msg'] = 'Document not received yet';
      $res['code'] = '1';
    }

    echo json_encode($res);
  }

  public function docupload()
  {

    $ClientID   = $this->input->post('ClientID');
    $docid      = $this->input->post('docid');

    $imgFile = $_FILES['fileupload']['name'];
    if ($imgFile != '') {

      $config['upload_path'] = './documents/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';

      $this->load->library('upload', $config);
      if (! $this->upload->do_upload('fileupload')) {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect(base_url() . 'dashboard/' . get_encoded_id($ClientID));
      } else {
        $imgdata = $this->upload->data();
        $profile_img = base_url() . 'documents/' . $imgdata['file_name'];


        $data['document_link']  = $profile_img;
        $data['status']         = '1';

        $checkdocs = $this->User_model->select_where('sq_document_receive', array('document_id' => $docid, 'client_id' => $ClientID));
        if ($checkdocs->num_rows() > 0) {

          $where['client_id']   = $ClientID;
          $where['document_id'] = $document_id;

          $this->User_model->updatedata('sq_document_receive', $where, $data);
        } else {

          $data['client_id']      = $ClientID;
          $data['document_id']    = $docid;

          $this->User_model->insertdata('sq_document_receive', $data);
        }

        $get_client_infomm = $this->get_client_info($ClientID);
        $this->session->set_flashdata('success', 'Document received successfully!');
        $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') documents received successfully!'); //track activity
        redirect(base_url() . 'dashboard/' . get_encoded_id($ClientID));
      }
    }
  }

  // *** NEW FUNCTION TO UPLOAD SIGNATURES ***
  public function signupload()
  {
    // Load necessary libraries
    $this->load->helper('file');
    $this->load->database();

    // Get the signature data from the form
    $signature = $this->input->post('signature');
    $clientID = $this->input->post('ClientID');

    // Decode the data URL
    $signature = str_replace('data:image/png;base64,', '', $signature);
    $signature = str_replace(' ', '+', $signature);
    $signatureData = base64_decode($signature);

    // Define the file path
    $fileName = 'signature_' . $clientID . '.png';
    $filePath = './signatures/' . $fileName;

    // Ensure the upload directory exists
    if (!is_dir('./signatures/')) {
      mkdir('./signatures/', 0755, true);
    }

    // Save the file
    if (write_file($filePath, $signatureData)) {
      // Save file path and client ID in the database
      $signature_path = base_url('signatures/' . $fileName);
      $data = array(
        'client_id' => $clientID,
        'signature' => $signature_path
      );
      $where['client_id'] = $clientID;
      $this->User_model->updatedata('sq_document_receive', $where, $data);
      $this->session->set_flashdata('success', 'Signature received successfully!');
      $this->allActivity('Signature received successfully!'); //track activity
      redirect(base_url() . 'dashboard/' . get_encoded_id($clientID));
    } else {
      echo 'Failed to save the signature.';
    }
  }

  // *** END NEW FUNCTION TO UPLOAD SIGNATURES ***

  public function SaveDocumentName()
  {

    $newitem = $this->input->post('newItem');
    $this->User_model->insertdata('sq_document', array('doc_name' => $newitem));
    $this->allActivity('New document name (' . $newitem . ') added successfully!'); //track activity
    echo '1';
  }


  public function updateTask()
  {

    $id = $this->input->post('id');
    $status = $this->input->post('status');

    if ($status == 'Pending') {
      $changeitto = 'Completed';
    } else {
      $changeitto = 'Pending';
    }

    $this->User_model->updatedata('sq_task', array('id' => $id), array('task_status' => $changeitto));
    $this->allActivity('Task status change to ' . $changeitto . ' successfully!'); //track activity
    $data['msg'] = 'Task added to ' . $changeitto . ' list successfully';
    $data['code'] = '1';
    echo json_encode($data);
  }

  public function delateTask()
  {

    $id = $this->input->post('id');
    $this->User_model->delete('sq_task', array('id' => $id));
    $this->allActivity('Task removed successfully!'); //track activity
    echo '1';
  }

  public function spousedatasave()
  {

    $data['client_id']  = $this->input->post('client_id');
    $data['sname']      = $this->input->post('sname');
    $data['sphone']     = $this->input->post('sphone');
    $data['semail']     = $this->input->post('semail');
    $data['ssocial']   = $this->input->post('ssocial');
    $data['sdob']   = $this->input->post('sdob');

    $this->User_model->insertdata('sq_spouse', $data);
    $res['msg'] = 'Spouse added successfully';
    $res['code'] = '1';
    echo json_encode($res);
  }


  public function SaveMemo()
  {

    $client_memo  = $this->input->post('client_memo');
    $clientID     = $this->input->post('clientID');
    $get_client_infomm = $this->get_client_info($clientID);

    $fetchMemo = $this->User_model->select_where('sq_memo', array('client_id' => $clientID));
    if ($fetchMemo->num_rows() > 0) {

      $this->User_model->updatedata('sq_memo', array('client_id' => $clientID), array('memo_text' => $client_memo));
      $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') memo updated successfully!'); //track activity
      $res['msg'] = 'Memo updated successfully';
      $res['code'] = '1';
      echo json_encode($res);
    } else {

      $this->User_model->insertdata('sq_memo', array('client_id' => $clientID, 'memo_text' => $client_memo));
      $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') memo added successfully!'); //track activity
      $res['msg'] = 'Memo added successfully';
      $res['code'] = '1';
      echo json_encode($res);
    }
  }


  public function edit_import()
  {

    $clientid   = get_dencoded_id($this->uri->segment(2));
    if ($clientid != '') {

      $fetchcheckcode = $this->User_model->select_where('sq_import_source_code', array('client_id' => $clientid));
      if ($fetchcheckcode->num_rows() > 0) {
        $data['source_codess'] = $fetchcheckcode->result();
      }

      $data['get_client_info'] = $this->get_client_info($clientid);
      $data['ss'] = '';
      $data['content'] = $this->load->view('dashboard/edit-import', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function removeimport()
  {

    $roeid = $this->input->post('rowid');
    $idiq = $this->input->post('idiq');
    $get_client_infomm = $this->get_client_info($roeid);
    $this->User_model->delete('sq_import_source_code', array('id' => $idiq));
    $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') source code removed successfully!'); //track activity
    echo '1';
  }

  public function import_source_code()
  {
    if (isset($_POST['submit'])) {

      $clientid   = get_dencoded_id($this->input->post('clientid'));
      $get_client_infomm = $this->get_client_info($clientid);
      $sourceCode = $this->input->post('sourceCode');

      $data['source_code']  = $sourceCode;
      $data['provider']     = 'IDIQ';
      $data['added_by']     = $this->session->userdata('user_id');
      $data['datetime']     = date('Y-m-d H:i:s a');


      $data['client_id']  = $clientid;
      $this->User_model->insertdata('sq_import_source_code', $data);
      $lastId = $this->db->insert_id();

      //=========== dispute item ===============//
      $html = explode('Account #:', $sourceCode);
      $a = 0;
      foreach ($html as $html_s) {
        $a++;
        if ($a > 2) {

          $html_r = explode('<td class="info"', $html_s);
          $datass['equi_ac']        = trim(str_replace('>', '', strip_tags($html_r[1])));
          $datass['exper_ac']       = trim(str_replace('ng-show="true">', '', strip_tags($html_r[2])));
          $datass['tu_ac']          = trim(str_replace('Account Type:', '', str_replace('ng-show="true">', '', strip_tags($html_r[3]))));
          $datass['equi_status']    = trim(str_replace('>', '', strip_tags($html_r[37])));
          $datass['exper_status']   = trim(str_replace('ng-show="true">', '', strip_tags($html_r[38])));
          $datass['tu_status']      = trim(str_replace('Last Reported:', '', str_replace('ng-show="true">', '', strip_tags($html_r[39]))));
          $datass['client_id']      = $clientid;
          $datass['added_date']     = date('Y-m-d');
          $datass['added_by']       = $this->session->userdata('user_id');

          $datass['equifax'] = 1;
          if ($datass['equi_ac'] == '') {
            $datass['equifax'] = 0;
          }

          $datass['experian'] = 2;
          if ($datass['exper_ac'] == '') {
            $datass['experian'] = 0;
          }

          $datass['transUnion'] = 3;
          if ($datass['tu_ac'] == '') {
            $datass['transUnion'] = 0;
          }

          //filter var again
          $datass['equi_ac']  = trim(str_replace('ng-show="true"', '', strip_tags($datass['equi_ac'])));
          $datass['exper_ac']  = trim(str_replace('>', '', strip_tags($datass['exper_ac'])));
          $datass['tu_ac']  = trim(str_replace('>', '', strip_tags($datass['tu_ac'])));
          $datass['equi_status']  = trim(str_replace('ng-show="true"', '', strip_tags($datass['equi_status'])));
          $datass['exper_status']  = trim(str_replace('>', '', strip_tags($datass['exper_status'])));
          $datass['tu_status']  = trim(str_replace('>', '', strip_tags($datass['tu_status'])));

          $this->User_model->insertdata('sq_dispute_item', $datass);
        }
      }
      //=========== dispute item ===============//

      $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') source code imported successfully!'); //track activity
      redirect(base_url() . 'preview_credit_report/' . get_encoded_id($clientid) . '/' . $lastId);
    }
  }

  public function SaveIDIQ()
  {

    $data['username']     = $this->input->post('username');
    $data['password']     = $this->input->post('passwd');
    $data['code']         = $this->input->post('code');
    $clientid             = get_dencoded_id($this->input->post('clientid'));

    $fetchcheck = $this->User_model->select_where('sq_IDIQ_details', array('client_id' => $clientid));
    if ($fetchcheck->num_rows() > 0) {
      $where['client_id'] = $clientid;
      $this->User_model->updatedata('sq_IDIQ_details', $where, $data);
    } else {
      $data['client_id']  = $clientid;
      $this->User_model->insertdata('sq_IDIQ_details', $data);
    }

    echo '1';
  }


  public function import_audit()
  {

    $urisegment = $this->uri->segment(2);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);

    //echo $invID;
    if ($clientID != '') {

      $get_client_info = $this->get_client_info($clientID);
      $data['get_client_info'] = $get_client_info;

      $wherever['user_name'] = $get_client_info->sq_email;
      $getCRXDetails = $this->User_model->select_where('crx_hero_registration', $wherever);

      $data['result'] = $getCRXDetails->result();

      $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchclients->num_rows() > 0) {
        $data['client'] = $fetchclients->result();
      } else {
        $data['client'] = [];
      }

      $data['content'] = $this->load->view('dashboard/reports', $data, true);
      $this->load->view('template/template', $data);
    }
  }

 public function pending_report()
  {

    $urisegment = $this->uri->segment(2);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);

    //echo $invID;
    if ($clientID != '') {

      $get_client_info = $this->get_client_info($clientID);
      $data['get_client_info'] = $get_client_info;

      $wherever['user_name'] = $get_client_info->sq_email;
      $getCRXDetails = $this->User_model->select_where('crx_hero_registration', $wherever);

      $data['result'] = $getCRXDetails->result();

      $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchclients->num_rows() > 0) {
        $data['client'] = $fetchclients->result();
      } else {
        $data['client'] = [];
      }
 $fetchreportLogs = $this->User_model->select_where('sq_import_source_code', array('client_id' => $clientID));
      if ($fetchreportLogs->num_rows() > 0) {
        $data['report_logs'] = $fetchreportLogs->result();
      } else {
        $data['report_logs'] = [];
      }
       $fetchpendingreportLogs = $this->User_model->select_where('pending_reports', array('client_id' => $clientID));
      if ($fetchpendingreportLogs->num_rows() > 0) {
        $data['pending_logs'] = $fetchpendingreportLogs->result();
      } else {
        $data['pending_logs'] = [];
      }
      $data['content'] = $this->load->view('dashboard/pending_report', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function preview_credit_report()
  {

    $urisegment = $this->uri->segment(2);
        $clientid   = get_dencoded_id($urisegment);
    $urisegment11 = $this->uri->segment(3);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);
 $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchclients->num_rows() > 0) {
        $data['client'] = $fetchclients->result();
      } else {
        $data['client'] = [];
      }
      $data['get_client_info'] = $this->get_client_info($clientid);
      
         $get_client_info = $this->get_client_info($clientID);
      $data['get_client_info'] = $get_client_info;

      $wherever['user_name'] = $get_client_info->sq_email;
      $getCRXDetails = $this->User_model->select_where('crx_hero_registration', $wherever);

      $result = $getCRXDetails->result();
     $userId =  $result[0]->userId;
       $fetchdata = $this->User_model->query("SELECT * FROM reports_data WHERE userId = '" . $userId . "' ORDER BY id DESC LIMIT 1");
    if ($fetchdata->num_rows() > 0) {

      $data['reports'] = $fetchdata->result();
    }
      $data['content'] = $this->load->view('dashboard/preview_credit_report', $data, true);
      $this->load->view('template/template', $data);
    
  }

  public function deleteNote()
  {

    $id = $this->input->post('id');
    $this->User_model->delete('sq_client_notes', array('id' => $id));
    $this->allActivity('Client notes removed successfully!'); //track activity
    echo '1';
  }

  public function editNote()
  {

    $id = $this->input->post('id');
    $notes = $this->User_model->select_where('sq_client_notes', array('id' => $id));
    $notes = $notes->row();
    echo json_encode($notes);
  }

  public function auto_emails_checker()
  {

    $urisegment = $this->uri->segment(2);
    $clientid   = get_dencoded_id($urisegment);

    if ($clientid != '') {

      $fetchtmp = $this->User_model->select_star_asc('sq_auto_email_templates', 'id');
      if ($fetchtmp->num_rows() > 0) {
        $data['GetAutoEmailTemp'] = $fetchtmp->result();
      }

      $fetchsenttmp = $this->User_model->select_where('sq_auto_email_sentto_client', array('client_id' => $clientid));
      if ($fetchsenttmp->num_rows() > 0) {
        $datafetchSentEmailTemp = $fetchsenttmp->result();
        $SentMAilTemp = array();
        foreach ($datafetchSentEmailTemp as $key => $value) {
          $SentMAilTemp[$value->template_id] = $value->status;
        }

        $data['fetchSentEmailTemp'] = $SentMAilTemp;
      }

      $data['get_client_info'] = $this->get_client_info($clientid);

      $data['clientid'] = $clientid;
      $data['content'] = $this->load->view('dashboard/auto_emails_checker', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function client_notes()
  {

    $urisegment = $this->uri->segment(2);
    $clientid   = get_dencoded_id($urisegment);

    if ($clientid != '') {

      $fetchnotes = $this->User_model->select_where('sq_client_notes', array('client_id' => $clientid));
      if ($fetchnotes->num_rows() > 0) {
        $data['fetchnotes'] = $fetchnotes->result();
      }

      $data['get_allusers_name'] = $this->get_allusers_name();
      $data['clientid'] = $clientid;
      $data['content'] = $this->load->view('dashboard/client_notes', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function notesData()
  {

    if (isset($_POST['sub_note'])) {

      $ClientID   = $this->input->post('clientid');
      $noteID     = $this->input->post('noteID');
      $notes      = $this->input->post('notes');
      $fileupload = $_FILES['fileupload']['name'];

      if ($fileupload != '') {

        $config['upload_path'] = './documents/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';

        $this->load->library('upload', $config);
        if (! $this->upload->do_upload('fileupload')) {
          $this->session->set_flashdata('error', $this->upload->display_errors());
          redirect(base_url() . 'client_notes/' . get_encoded_id($ClientID));
        } else {
          $imgdata = $this->upload->data();
          $profile_img = base_url() . 'documents/' . $imgdata['file_name'];

          $data['attachment']  = $profile_img;

          if ($noteID != '') {

            $where['id']   = $noteID;
            $data['notes'] = $notes;
            $this->User_model->updatedata('sq_client_notes', $where, $data);
          } else {

            $data['client_id'] = $ClientID;
            $data['notes'] = $notes;
            $data['date'] = date('Y-m-d');
            $data['added_by'] = $this->session->userdata('user_id');
            $this->User_model->insertdata('sq_client_notes', $data);
          }
        }
      } else { //no attachment added

        if ($noteID != '') {

          $where['id']   = $noteID;
          $data['notes'] = $notes;
          $this->User_model->updatedata('sq_client_notes', $where, $data);
        } else {

          $data['client_id'] = $ClientID;
          $data['notes'] = $notes;
          $data['date'] = date('Y-m-d');
          $data['added_by'] = $this->session->userdata('user_id');
          $this->User_model->insertdata('sq_client_notes', $data);
        }
      }

      // $get_client_infomm = $this->get_client_info($clientid);
      $get_client_infomm = $this->get_client_info($ClientID);
      $this->session->set_flashdata('success', 'Note Saved Successfully!');
      $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') note Saved Successfully!'); //track activity
      redirect(base_url() . 'client_notes/' . get_encoded_id($ClientID));
    }
  }


  public function addScore()
  {

    $data['client_id']        = $this->input->post('clientID');
    $data['date']             = date('Y-m-d', strtotime($this->input->post('dateadd')));
    $data['equifax']          = $this->input->post('equfaxScore');
    $data['experian']         = $this->input->post('experianScore');
    $data['transunion']       = $this->input->post('TUScore');

    $get_client_infomm = $this->get_client_info($this->input->post('clientID'));
    $this->User_model->insertdata('sq_score', $data);
    $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') score added successfully!'); //track activity
    echo '1';
  }

  public function UpdateScore()
  {

    $data['client_id']        = $this->input->post('clientID');
    $data['date']             = date('Y-m-d', strtotime($this->input->post('dateadd')));
    $data['equifax']          = $this->input->post('equfaxScore');
    $data['experian']         = $this->input->post('experianScore');
    $data['transunion']       = $this->input->post('TUScore');
    $where['id']              = $this->input->post('rowID');

    $get_client_infomm = $this->get_client_info($this->input->post('clientID'));
    $this->User_model->updatedata('sq_score', $where, $data);
    $this->allActivity('Client (' . $get_client_infomm->sq_first_name . ' ' . $get_client_infomm->sq_last_name . ') score updated successfully!'); //track activity
    echo '1';
  }

  public function RemoveScore()
  {

    $id = $this->input->post('rowID');
    $this->User_model->delete('sq_score', array('id' => $id));
    $this->allActivity('Client score removed successfully!'); //track activity
    echo '1';
  }

  public function deletedisItem()
  {

    $id = $this->input->post('id');
    $this->User_model->delete('sq_dispute_item', array('id' => $id));
    $this->allActivity('Dispute item removed successfully!'); //track activity
    echo '1';
  }

  public function editDisItem()
  {

    $id = $this->input->post('id');
    $dispute_item = $this->User_model->select_where('sq_dispute_item', array('id' => $id));
    $dispute_item = $dispute_item->row();

    $dispute_item->equi_ac  = trim(str_replace('ng-show="true"', '', strip_tags($dispute_item->equi_ac)));
    $dispute_item->exper_ac  = trim(str_replace('>', '', strip_tags($dispute_item->exper_ac)));
    $dispute_item->equi_status  = trim(str_replace('ng-show="true"', '', strip_tags($dispute_item->equi_status)));
    $dispute_item->exper_status  = trim(str_replace('>', '', strip_tags($dispute_item->exper_status)));


    echo json_encode($dispute_item);
  }

  public function dispute_item()
  {

    $urisegment = $this->uri->segment(2);
    $clientid   = get_dencoded_id($urisegment);

    if ($clientid != '') {

      $data['getallfurnisher'] = $this->getallfurnisher();
      $data['getfurnisherNames'] = $this->getfurnisherNames();
      $data['get_client_info'] = $this->get_client_info($clientid);
      $data['getalldisputeItem'] = $this->getalldisputeItem($clientid);
      $data['clientid'] = $clientid;
      $data['content'] = $this->load->view('dashboard/dispute_status', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  public function disStatusData()
  {
    error_reporting(0);
    if (isset($_POST['dis_status'])) {

      $diID               = $this->input->post('diID');
      $clientid           = $this->input->post('clientid');
      $credit_bureaus     = $this->input->post('credit_bureaus');
      $furnisher          = $this->input->post('furnisher');
      $account_number     = $this->input->post('account_number');
      $status             = $this->input->post('status');
      $reason             = $this->input->post('reason');
      $instruction        = $this->input->post('instruction');

      $data['furnisher']  = $furnisher;
      $data['reason']  = $reason;
      $data['instruction']  = $instruction;

      if ($credit_bureaus[0] != '') {

        $data['equifax']      = $credit_bureaus[0];
        $data['equi_ac']      = $account_number[0];
        $data['equi_status']  = $status[0];
      }

      if ($credit_bureaus[1] != '') {

        $data['experian']      = $credit_bureaus[1];
        $data['exper_ac']      = $account_number[1];
        $data['exper_status']  = $status[1];
      }

      if ($credit_bureaus[2] != '') {

        $data['transUnion']       = $credit_bureaus[2];
        $data['tu_ac']            = $account_number[2];
        $data['tu_status']        = $status[2];
      }


      if ($diID != '') {

        $where['id'] = $diID;
        $this->User_model->updatedata('sq_dispute_item', $where, $data);
        $this->allActivity('Dispute item updated successfully!'); //track activity
        $this->session->set_flashdata('success', 'Dispute item updated successfully!');
      } else {

        $data['client_id']  = $clientid;
        $data['added_date'] = date('Y-m-d');
        $data['added_by']   = $this->session->userdata('user_id');

        $this->User_model->insertdata('sq_dispute_item', $data);
        $this->allActivity('New Dispute item added successfully!'); //track activity
        $this->session->set_flashdata('success', 'Dispute item added successfully!');
      }

      redirect(base_url() . 'dispute_item/' . get_encoded_id($clientid));
    }
  }

  public function welcomeEmail()
  {
    $email = $this->input->post('email');
    $id = $this->input->post('id');

    $get_client_info = $this->get_client_info($id);

    $logolink = base_url() . '/assets/images/logo.png';
    $welcomeNote = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>We are glad you are here!</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 60px 20px 60px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' CRX Credit Repair. All rights reserved. </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </div>';

    $this->load->config('email_custom');
    $email_config = $this->config->item('email_config');

    $this->load->config('email_custom');
    $email_config = $this->config->item('email_config');

    $this->email->initialize($email_config);
    $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
    $this->email->to(array($email));
    $this->email->subject('Welcome E-mail');

    $this->email->message($welcomeNote);
    $this->email->send();

    $this->allActivity('Welcome email sent to client (' . $get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name . ') successfully!'); //track activity

    echo '1';
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
      $this->send_crx_hero_invite_email($name, $email, $security_code, $sq_client_id);

      $updation['security_code'] = $security_code;
      $updation['security_code_time'] = date('Y-m-d H:i:s');

      $where['sq_client_id'] = $sq_client_id;

      $this->User_model->updatedata('sq_clients', $where, $updation);

      echo json_encode(['status' => 'success', 'message' => 'Invited']);
    }
  }


  public function send_crx_hero_invite_email($name, $email, $security_code, $sq_client_id)
  {
    if ($email != '') {

      // $link        = base_url('credit_monitoring_payment_link/') . $security_code;
      $link        ="https://crxhero.com/sign-up?referral_code=$security_code";

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
      $this->email->subject('Invite for CRX Hero Signup');

      $this->email->message($message);
      $this->email->send();

      return '1';
    }
  }

  public function reset_agreement()
  {
    $sq_client_id = $this->input->post('sq_client_id');
    if (!empty($sq_client_id)) {

      $data = array(
        'agreement_signed'  => 0,
      );

      $this->User_model->updatedata('sq_clients', array("sq_client_id" => $sq_client_id), $data);

      echo json_encode(['status' => 'success', 'message' => 'The agreement has been successfully reset.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'There was an issue resetting the agreement. Please try again.']);
    }
  }

  public function save_photo_id()
  {
    $this->save_client_document('photo_id', 'photo_upload');
  }

  public function save_address_photo()
  {
    $this->save_client_document('address_photo', 'address_photo');
  }

  private function save_client_document($document_type, $upload_input_name)
  {
    $client_id = $this->input->post('client_id');
    $base_path = FCPATH . "upload/client_documents/{$document_type}/" . $client_id;

    // Create directory if it doesn't exist
    if (!is_dir($base_path)) {
      mkdir($base_path, 0755, true);
    }

    // Fetch existing document
    $where = ['client_id' => $client_id, 'document_type' => $document_type];
    $document_result = $this->User_model->select_where('sq_clients_documents', $where)->row();

    // Remove existing file
    if ($document_result && !empty($document_result->document_path)) {
      $existing_path = $base_path . '/' . basename($document_result->document_path);
      if (file_exists($existing_path)) {
        unlink($existing_path);
      }
    }

    // File upload configuration
    $this->load->library('upload');
    $config = [
      'upload_path'   => $base_path,
      'allowed_types' => 'jpg|jpeg|png',
      'max_size'      => 2048, // 2MB
    ];
    $this->upload->initialize($config);

    // File upload handling
    if (!$this->upload->do_upload($upload_input_name)) {
      echo json_encode(['status' => 'error', 'message' => 'Unable to save photo. ' . $this->upload->display_errors()]);
      return;
    }

    $file_data = $this->upload->data();
    $document_path = base_url("upload/client_documents/{$document_type}/" . $client_id . '/' . $file_data['file_name']);

    // Insert or update document record
    $data = [
      'document_type' => $document_type,
      'document_path' => $document_path,
      'updated_at'    => date('Y-m-d H:i:s'),
    ];

    if ($document_result) {
      $this->User_model->updatedata('sq_clients_documents', $where, $data);
    } else {
      $data['client_id'] = $client_id;
      $data['created_at'] = date('Y-m-d H:i:s');
      $this->User_model->insertdata('sq_clients_documents', $data);
    }

    echo json_encode(['status' => 'success', 'message' => 'Photo saved successfully.']);
  }


  public function delete_client_file()
  {
    $client_id = $this->input->post('client_id');
    $type = $this->input->post('type');

    // Define document type and folder path based on the file type
    $document_type = ($type === 'photo_upload') ? 'photo_id' : 'address_photo';
    $folder_name = ($type === 'photo_upload') ? 'photo_id' : 'address_photo';
    $client_photo_dir = FCPATH . 'upload/client_documents/' . $folder_name . '/' . $client_id;

    // Fetch the document details
    $where = ['client_id' => $client_id, 'document_type' => $document_type];
    $getClient_document = $this->User_model->select_where('sq_clients_documents', $where);
    $document_result = $getClient_document->row();

    if ($document_result) {
      // Get file path
      $parts = explode('/', $document_result->document_path);
      $file_name = end($parts);
      $file_path = $client_photo_dir . '/' . $file_name;

      // Delete the file
      if (file_exists($file_path)) {
        unlink($file_path);
      }

      // Remove record from the database
      $this->User_model->delete('sq_clients_documents', $where);

      echo json_encode(['status' => 'success', 'message' => 'File deleted successfully.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'File not found.']);
    }
  }

  public function generate_simple_audit()
  {
    $clientID = $this->input->post('client_id');
    $where['sq_client_id'] = $clientID;
    $client = $this->User_model->select_where('sq_clients', $where)->row();

    $client_name = trim(($client->sq_first_name ?? '') . ' ' . ($client->sq_last_name ?? ''));

    $where_team_id['sq_u_id'] = $this->session->userdata('user_id');
    $team_member = $this->User_model->select_where('sq_users', $where_team_id)->row();
    $team_member_name = trim(($team_member->sq_u_first_name ?? '') . ' ' . ($team_member->sq_u_last_name ?? ''));
    $company_name = 'CRX Credit Repair';
    $base_url = base_url();
    $page_break = '<div class="page-break"><hr style="color: #fcfcfc; width: 100%;"></div>';

    $template = $this->db->get_where('sq_simple_audit_template', ['id' => 1])->row();
    $audit_textarea = $template->audit_textarea;

    // Replace placeholders
    $audit_textarea = str_replace('{base_url}', $base_url, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY LOGO}', '<img src="' . base_url('assets/images/logo.png') . '" alt="Company Logo" id = "simple_audit_logo" style = "min-width:55px; height:55px;">', $audit_textarea);
    $audit_textarea = str_replace('{CLIENT NAME}', $client_name, $audit_textarea);
    $audit_textarea = str_replace('{TODAY\'S DATE}', date('Y-m-d'), $audit_textarea);
    $audit_textarea = str_replace('{TEAM MEMBER NAME}', $team_member_name, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY NAME}', $company_name, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY EMAIL}', $team_member->sq_u_email_id, $audit_textarea);
    $audit_textarea = str_replace('<p style="text-align: center;">{PAGE BREAK}</p>', $page_break, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY WEBSITE}', base_url(), $audit_textarea);

    echo $audit_textarea;
  }


  public function download_pdf()
  {
    $clientID = $this->input->get('client_id');
    $where['sq_client_id'] = $clientID;
    $client = $this->User_model->select_where('sq_clients', $where)->row();
    $client_name = trim(($client->sq_first_name ?? '') . ' ' . ($client->sq_last_name ?? ''));

    $where_team_id['sq_u_id'] = $this->session->userdata('user_id');
    $team_member = $this->User_model->select_where('sq_users', $where_team_id)->row();
    $team_member_name = trim(($team_member->sq_u_first_name ?? '') . ' ' . ($team_member->sq_u_last_name ?? ''));
    $company_name = 'CRX Credit Repair';
    $base_url = base_url();
    $page_break = '<div class="page-break"><hr style="color: #fcfcfc; width: 100%;"></div>';

    $template = $this->db->get_where('sq_simple_audit_template', ['id' => 1])->row();
    $audit_textarea = $template->audit_textarea;

    // Replace placeholders
    $audit_textarea = str_replace('{base_url}', $base_url, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY LOGO}', '<img src="' . base_url('assets/images/logo.png') . '" alt="Company Logo" id = "simple_audit_logo" style = "min-width:55px; height:55px;">', $audit_textarea);
    $audit_textarea = str_replace('{CLIENT NAME}', $client_name, $audit_textarea);
    $audit_textarea = str_replace('{TODAY\'S DATE}', date('Y-m-d'), $audit_textarea);
    $audit_textarea = str_replace('{TEAM MEMBER NAME}', $team_member_name, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY NAME}', $company_name, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY EMAIL}', $team_member->sq_u_email_id, $audit_textarea);
    $audit_textarea = str_replace('<p style="text-align: center;">{PAGE BREAK}</p>', $page_break, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY WEBSITE}', base_url(), $audit_textarea);

    // Generate PDF
    $this->load->library('m_pdf');
    $pdf = $this->m_pdf->load();
    $pdf->WriteHTML($audit_textarea);
    $pdf->Output('Simple_Audit.pdf', 'D');
  }

  public function update_crx_credentials()
  {
    $id = $this->input->post('crx_id');
    $phone = $this->input->post('phone');
    $security_word = $this->input->post('security_word');
    $s_password = $this->input->post('s_password');
    $notes = $this->input->post('notes');

    $updated_data = [
      'phone' => $phone,
      'security_word' => $security_word,
      's_password' => $s_password,
      'notes' => $notes
    ];

    $this->db->where('id', $id);
    $update = $this->db->update('crx_hero_registration', $updated_data);

    if ($update) {
      echo json_encode(['status' => 'success', 'message' => 'Details updated successfully!']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update details.']);
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

  public function get_all_letters()
  {
    // $endpoint = '/letters';
    // $response = $this->call_api('GET', $endpoint, []);
    // return $response;

    $endpoint = '/letters';
    $response = $this->call_api('GET', $endpoint, []);
    return $response['data']['data'] ?? [];
  }

  public function letters_status()
  {

    $urisegment = $this->uri->segment(2);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);
    if ($clientID != '') {
      $get_client_info = $this->get_client_info($clientID);
      $data['get_client_info'] = $get_client_info;

      $data['letters'] = $this->get_all_letters();

      $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchclients->num_rows() > 0) {
        $data['client'] = $fetchclients->result();
      } else {
        $data['client'] = [];
      }

      $data['content'] = $this->load->view('dashboard/letters_status', $data, true);
      $this->load->view('template/template', $data);
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
  
        public function auditEmailSendtoClient()
  {
    $clientID = $this->input->post('client_id');
    $where['sq_client_id'] = $clientID;
    $client = $this->User_model->select_where('sq_clients', $where)->row();

    $client_name = trim(($client->sq_first_name ?? '') . ' ' . ($client->sq_last_name ?? ''));

    $where_team_id['sq_u_id'] = $this->session->userdata('user_id');
    $team_member = $this->User_model->select_where('sq_users', $where_team_id)->row();
    $team_member_name = trim(($team_member->sq_u_first_name ?? '') . ' ' . ($team_member->sq_u_last_name ?? ''));
    $company_name = 'CRX Credit Repair';
    $base_url = base_url();
    $page_break = '<div class="page-break"><hr style="color: #fcfcfc; width: 100%;"></div>';

    $template = $this->db->get_where('sq_simple_audit_template', ['id' => 1])->row();
    $audit_textarea = $template->audit_textarea;

    // Replace placeholders
    $audit_textarea = str_replace('{base_url}', $base_url, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY LOGO}', '<img src="' . base_url('assets/images/logo.png') . '" alt="Company Logo" id = "simple_audit_logo" style = "min-width:55px; height:55px;">', $audit_textarea);
    $audit_textarea = str_replace('{CLIENT NAME}', $client_name, $audit_textarea);
    $audit_textarea = str_replace('{TODAY\'S DATE}', date('Y-m-d'), $audit_textarea);
    $audit_textarea = str_replace('{TEAM MEMBER NAME}', $team_member_name, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY NAME}', $company_name, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY EMAIL}', $team_member->sq_u_email_id, $audit_textarea);
    $audit_textarea = str_replace('<p style="text-align: center;">{PAGE BREAK}</p>', $page_break, $audit_textarea);
    $audit_textarea = str_replace('{COMPANY WEBSITE}', base_url(), $audit_textarea);
$this->email->set_mailtype('html');
    $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
    $this->email->to(array($client->sq_email));
    $this->email->subject('CRX Credit Repair');

    $this->email->message($audit_textarea);
    $this->email->send();
  }
  
// public function previewCR() {
//     $clientid = $this->input->post('client_id');  // Get the client_id from POST
//     $this->db->where('client_id', $clientid);     // Filter by client_id
//     $this->db->order_by('id', 'DESC');            // Order by 'id' in descending order
//     $data = $this->db->get('sq_import_source_code')->result();  // Get data

//     if (!empty($data)) {
//         // Send the redirect URL back to the client
//         $redirect_url = base_url() . 'preview_credit_report/' . get_encoded_id($clientid) . '/' . $data[0]->id;
//         echo json_encode(['redirect_url' => $redirect_url]);  // Return URL in JSON format
//     } else {
//         // Handle the case where no data is found
//         echo json_encode(['error' => 'No data found for the given client_id']);
//     }

// }


public function previewreport_data_save() {
    $clientID = $this->input->post('client_id');
    $pfullAddress = $this->input->post('pfullAddress');
    $fullAddress = $this->input->post('fullAddress');
    $names = $this->input->post('names');
    $dob = $this->input->post('dob');
    $instruction = $this->input->post('instruction');
        $reason = $this->input->post('reason');
    $today = date('Y-m-d');

    // Helper function to insert for each type
    function insertItems($type, $values, $clientID, $model, $today) {
        foreach ($values as $index => $value) {
            if (!empty($value)) {
                $equifax = $index === 0 ? 1 : 0;
                $experian = $index === 1 ? 1 : 0;
                $transunion = $index === 2 ? 1 : 0;

                $instruction = '';
                if ($type === 'dob') {
                    $instruction = "Date of Birth: $value";
                } elseif ($type === 'names') {
                    $instruction = "Name: $value";
                } elseif ($type === 'fullAddress') {
                    $instruction = "Current Address: $value";
                } elseif ($type === 'pfullAddress') {
                    $instruction = "Previous Address: $value";
                }

                $data = [
                    'reason' => 'The following personal information is incorrect',
                    'instruction' => $instruction,
                    'client_id' => $clientID,
                    'equifax' => $equifax,
                    'experian' => $experian,
                    'transunion' => $transunion,
                    'furnisher'=>'0',
                    'equi_status' => $equifax ? 'Negative' : NULL,
                    'exper_status' => $experian ? 'Negative' : NULL,
                    'tu_status' => $transunion ? 'Negative' : NULL,
                    'added_date' => $today
                ];

                $model->insertdata('sq_dispute_item', $data);
            }
        }
    }

    // Insert rows for each type of data
    insertItems('dob', $dob, $clientID, $this->User_model, $today);
    insertItems('names', $names, $clientID, $this->User_model, $today);
    insertItems('fullAddress', $fullAddress, $clientID, $this->User_model, $today);
    insertItems('pfullAddress', $pfullAddress, $clientID, $this->User_model, $today);

    echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
}

  public function save_item_dispute($data)
    {
        return $this->db->insert('sq_dispute_item', $data);
    }
    public function simple_audit()
  {

    $urisegment = $this->uri->segment(2);
    $checkID = base64_decode(urldecode($urisegment));
    $decodedID = number_format(($checkID * 12345) / 12345678);
    $clientID = str_replace(',', '', $decodedID);

    //echo $invID;
    if ($clientID != '') {

      $get_client_info = $this->get_client_info($clientID);
      $data['get_client_info'] = $get_client_info;

      $wherever['user_name'] = $get_client_info->sq_email;
      $getCRXDetails = $this->User_model->select_where('crx_hero_registration', $wherever);

      $data['result'] = $getCRXDetails->result();

      $fetchclients = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchclients->num_rows() > 0) {
        $data['client'] = $fetchclients->result();
      } else {
        $data['client'] = [];
      }
  $fetchClientinfo = $this->User_model->select_where('sq_clients', array('sq_client_id' => $clientID));
      if ($fetchClientinfo->num_rows() > 0) {
        $fetchClientinfo = $fetchClientinfo->result();
        $data['fetchClientinfo'] = $fetchClientinfo;
      }
      $data['content'] = $this->load->view('dashboard/simple_audit', $data, true);
      $this->load->view('template/template', $data);
    }
  }
 public function save_pending_report()
{
    $id = $this->uri->segment(2);

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Client ID is missing']);
        return;
    }

    $data = [
        'client_id' => $id,
        'date' => date('Y-m-d H:i:s'), 
        'added_by' => $this->session->userdata('user_id'),
    ];

    $this->db->insert('pending_reports', $data);

    if ($this->db->affected_rows() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert data']);
    }
}

public function delete_pending_report()
{
    $client_id = $this->uri->segment(2);

    if (!$client_id) {
        echo json_encode(['status' => 'error', 'message' => 'Client ID is missing']);
        return;
    }

    // Get the latest report ID for this client
    $this->db->select('id');
    $this->db->from('pending_reports');
    $this->db->where('client_id', $client_id);
    $this->db->order_by('date', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();

    $latest = $query->row();

    if ($latest) {
        $this->db->where('id', $latest->id);
        $this->db->delete('pending_reports');

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Latest report deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete report']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No report found to delete']);
    }
}


}
