<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
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


  public function signin()
  {
    if ($this->input->post()) {
      $email = $this->input->post('email');
      $pass = $this->input->post('password');

      if ($email && $pass != '') {
        $where['sq_email'] = $email;
        $where['password'] = md5($pass);

        $getUser = $this->User_model->select_where('sq_clients', $where);

        if ($getUser->num_rows() > 0) {
          $getUser = $getUser->result();

          if ($getUser[0]->sq_portal_access == 0 || empty($getUser[0]->sq_portal_access || empty($getUser[0]->password))) {

            echo json_encode([
              'status' => 'error',
              'message' => 'Your portal access is turned off. Please contact the administrator.'
            ]);
          } elseif ($getUser[0]->agreement_signed == 0 || empty($getUser[0]->agreement_signed)) {

            $this->session->set_userdata('user_id', $getUser[0]->sq_client_id);
            $this->session->set_userdata('user_name', $getUser[0]->sq_first_name . ' ' . $getUser[0]->sq_last_name);
            $this->session->set_userdata('user_type', 'client');

            echo json_encode([
              'status' => 'agreement_needed',
              'message' => 'Please sign the agreement.'
            ]);
          } else {

            $this->session->set_userdata('user_id', $getUser[0]->sq_client_id);
            $this->session->set_userdata('user_name', $getUser[0]->sq_first_name . ' ' . $getUser[0]->sq_last_name);
            $this->session->set_userdata('user_type', 'client');

            $this->loginActivity('Login-Activity', 'Login');

            $update_client_data = array(
              "last_login" => date('Y-m-d H:i A')
            );

            $this->User_model->updatedata('sq_clients', array("sq_client_id" => $getUser[0]->sq_client_id), $update_client_data);

            echo json_encode([
              'status' => 'success',
              'redirect_url' => base_url() . 'client/dashboard'
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

      if ($this->session->userdata('user_type') == 'client') {
        $this->loginActivity('Login-Activity', 'Login');
        redirect(base_url('client/dashboard'));
      } else {

        $data['user'] = 'login';
        $this->load->view('client/login', $data);
      }
    }
  }


  public function client_agreement()
  {

    if ($this->session->userdata('user_type') == 'client') {
      $user_id = $this->session->userdata('user_id');
      $where['sq_client_id'] = $user_id;

      $getClient = $this->User_model->select_where('sq_clients', $where);

      if ($getClient->num_rows() > 0) {
        $getClient = $getClient->row();  // Fetch single client row
      } else {
        $getClient = null;
      }


      if ($getClient) {
        $f_name = $getClient->sq_first_name ?? '';
        $l_name = $getClient->sq_last_name ?? '';
        $name = trim("$f_name $l_name");
        // Define the placeholders and their corresponding values
        $placeholders = ['{{name}}', '{{address}}', '{{state}}', '{{city}}', '{{zip}}', '{{dob}}', '{{date}}'];
        $replacements = [
          $name,
          $getClient->sq_mailing_address,
          $getClient->sq_state,
          $getClient->sq_city,
          $getClient->sq_zipcode,
          date('m/d/Y', strtotime($getClient->sq_dob)),
          date('m/d/Y')  // Current date
        ];

        // Get the default agreement and replace the placeholders
        $agreement = $this->AgreementModel->get_default_agreement();
        $agreementText = str_replace($placeholders, $replacements, $agreement->agreement_text);
      } else {
        $agreementText = 'No agreement found.';
      }

      $data['client'] = $getClient;
      $data['agreement_text'] = $agreementText;
      $data['agreement'] = $agreement;

      $this->load->view('client/agreement/sign_agreement', $data);
    } else {
      redirect(base_url());
    }
  }
  public function signout()
  {
    $this->loginActivity('Login-Activity', 'Logout');
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('user_name');
    $this->session->unset_userdata('user_type');
    redirect(base_url());
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


  public function client_dashboard()
  {
    if ($this->session->userdata('user_type') == 'client' || ($this->session->userdata('user_type') == 'super')) {
  
      $userID = $this->session->userdata('user_id');

      $where['sq_client_id'] = $userID;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->result();
      $this->data['getClient'] = $getClient->result();

      $d_where['client_id'] = $userID;
      // $d_where['document_type'] = 'agreement';
      $get_document = $this->User_model->select_where('sq_clients_documents', $d_where);
      $client_document_result = $get_document->result();
      $this->data['client_document'] = $client_document_result;

      $id_agreement['id'] = $client_result[0]->agreement_id;
    //   $agreement = $this->User_model->select_where('client_agreements', $id_agreement);

    //   $this->data['agreement'] = $agreement->result();
    //   $agreement_result = $agreement->result();

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
          $client_result[0]->sq_dob,
          date('Y-m-d')  // Current date
        ];
  $agreement = $this->AgreementModel->get_default_agreement();
        $agreementText = str_replace($placeholders, $replacements, $agreement->agreement_text);
      } else {
        $agreementText = 'No agreement found.';
      }

      $this->data['agreement_text'] = $agreementText;


      $affiliates = $this->User_model->query("SELECT * FROM sq_affiliates");
      $this->data['sq_affiliates'] = $affiliates->result();

      $wherever['user_name'] = $client_result[0]->sq_email;
      $getCRXDetails = $this->User_model->select_where('crx_hero_registration', $wherever);

      $this->data['result'] = $getCRXDetails->result();

      $this->data['page'] = 'home';

      if (($this->session->userdata('user_type') == 'super')) {
        $this->data['getClient'] = [];
        $this->data['client_document'] = [];
        $this->data['agreement'] = [];
        $this->data['agreement_text'] = [];
        $this->data['sq_affiliates'] = [];
        $this->data['result'] = [];
      }
  
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }

  public function settings()
  {
    if ($this->session->userdata('user_type') == 'client') {

      $userID = $this->session->userdata('user_id');

      $where['sq_client_id'] = $userID;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->result();
      $this->data['getClient'] = $getClient->result();

      $this->data['page'] = 'settings';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }

  public function dispute_details()
  {
    if ($this->session->userdata('user_type') == 'client') {

      $this->data['page'] = 'dispute_details';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }



  public function saved_letters()
  {
    if ($this->session->userdata('user_type') == 'client' || ($this->session->userdata('user_type') == 'super')) {

      $this->data['page'] = 'saved_letters';
      $client_id = $this->session->userdata('user_id');

      $getData = $this->User_model->query("SELECT * FROM client_saved_letters WHERE client_id = '" . $client_id . "'");
      $saved_letters = $getData->result();

      $where['sq_client_id'] = $client_id;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->row();

      $this->data['saved_letters'] = $saved_letters;
      $this->data['client_result'] = $client_result;
      if (($this->session->userdata('user_type') == 'super')) {
        $this->data['saved_letters'] = [];
        $this->data['client_result'] = [];
      }
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }

  public function finances()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $this->data['page'] = 'finances';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }

  public function resources()
  {
    if ($this->session->userdata('user_type') == 'client' || ($this->session->userdata('user_type') == 'super')) {

      $this->data['page'] = 'resources';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }

  public function credit_info()
  {
    if ($this->session->userdata('user_type') == 'client' || ($this->session->userdata('user_type') == 'super')) {
      $this->data['page'] = 'credit_info';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }


  public function profile_setting()
  {
    if ($this->session->userdata('user_type') == 'client') {

      $client_id = $this->session->userdata('user_id');
      $user_type = $this->session->userdata('user_type');

      $where['sq_client_id'] = $client_id;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->row();


      if ($this->input->post()) {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if ($new_password !== $confirm_password) {
          echo json_encode(['status' => 'error', 'message' => 'New password and confirmation password do not match.']);
          return;
        }


        if ($current_password != $client_result->s_password) {
          echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
          return;
        }

        $new_password_md5 = md5($new_password);

        $update = array(
          "password" => $new_password_md5,
          "s_password" => $new_password
        );

        if (!empty($client_id) && $user_type == 'client') {
          $this->User_model->updatedata('sq_clients', array("sq_client_id" => $client_id), $update);
          echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
        }
      } else {
        $this->data['page'] = 'profile_setting';
        $this->data['client_result'] = $client_result;
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
      }
    } else {
      redirect(base_url());
    }
  }


  public function update_profile()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $client_id = $this->session->userdata('user_id');

      // Define client images directory
      $client_images_dir = FCPATH . 'upload/client_documents/client_profile_pictures/' . $client_id;

      // Create directory if it doesn't exist
      if (!is_dir($client_images_dir)) {
        mkdir($client_images_dir, 0755, true);
      }

      // Get the current client profile image from the database
      $where['sq_client_id'] = $client_id;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->row();

      $profile_img_url = $client_result->profile_img;
      $parts = explode('/', $profile_img_url);

      // The last part will be the file name
      $profile_img = end($parts);

      // Check if there is an existing profile image
      if (!empty($client_result->profile_img)) {
        $existing_image_path = $client_images_dir . '/' . $profile_img;

        // Delete the previous profile image if it exists
        if (file_exists($existing_image_path)) {
          unlink($existing_image_path);
        }
      }

      // Set up file upload configuration
      $config['upload_path'] = $client_images_dir;
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
        $image_path = base_url() . 'upload/client_documents/client_profile_pictures/' . $client_id . '/' . $imgupload;
        // Update profile image in the database
        $update = array(
          "profile_img" => $image_path
        );
        $this->User_model->updatedata('sq_clients', array("sq_client_id" => $client_id), $update);

        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
      }
    } else {
      redirect(base_url());
    }
  }

  public function save_photo_id()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $client_id = $this->session->userdata('user_id');

      $client_photo_dir = FCPATH . 'upload/client_documents/photo_id/' . $client_id;

      if (!is_dir($client_photo_dir)) {
        mkdir($client_photo_dir, 0755, true);
      }

      $where['client_id'] = $client_id;
      $where['document_type'] = 'photo_id';
      $getClient_document = $this->User_model->select_where('sq_clients_documents', $where);
      $document_result = $getClient_document->row();
      $photo_url = $document_result->document_path;
      $parts = explode('/', $photo_url);
      $photo_id = end($parts);

      if (!empty($document_result->document_path)) {
        $existing_photo_path = $client_photo_dir . '/' . $photo_id;

        if (file_exists($existing_photo_path)) {
          unlink($existing_photo_path);
        }
      }

      $config['upload_path'] = $client_photo_dir;
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['max_size'] = 2048;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('photo_upload')) {
        $error = $this->upload->display_errors();
        echo json_encode(['status' => 'error', 'message' => 'Unable to save photo. ' . $error]);
        return;
      } else {
        $file_data = $this->upload->data();
        $photo_upload = $file_data['file_name'];
        $photo_path = base_url() . 'upload/client_documents/photo_id/' . $client_id . '/' . $photo_upload;

        if ($getClient_document->num_rows() > 0) {
          $update_document_data = [
            'document_type'   => 'photo_id',
            'document_path'   => $photo_path,
            'updated_at'      => date('Y-m-d H:i:s a')
          ];

          $this->User_model->updatedata('sq_clients_documents', array("client_id" => $client_id, "document_type" => 'photo_id'), $update_document_data);
        } else {
          $document_data = [
            'client_id'       => $client_id,
            'document_type'   => 'photo_id',
            'document_path'   => $photo_path,
            'created_at'      => date('Y-m-d H:i:s a')
          ];

          $this->User_model->insertdata('sq_clients_documents', $document_data);
        }

        echo json_encode(['status' => 'success', 'message' => 'Photo saved successfully.']);
      }
    } else {
      redirect(base_url());
    }
  }

  public function save_address_photo()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $client_id = $this->session->userdata('user_id');

      $client_photo_dir = FCPATH . 'upload/client_documents/address_photo/' . $client_id;

      if (!is_dir($client_photo_dir)) {
        mkdir($client_photo_dir, 0755, true);
      }

      $where['client_id'] = $client_id;
      $where['document_type'] = 'address_photo';
      $getClient_document = $this->User_model->select_where('sq_clients_documents', $where);
      $document_result = $getClient_document->row();


      $photo_url = $document_result->document_path;

      $parts = explode('/', $photo_url);

      $address_photo = end($parts);

      if (!empty($document_result->document_path)) {
        $existing_photo_path = $client_photo_dir . '/' . $address_photo;

        if (file_exists($existing_photo_path)) {
          unlink($existing_photo_path);
        }
      }

      $config['upload_path'] = $client_photo_dir;
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['max_size'] = 2048;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('address_photo')) {
        $error = $this->upload->display_errors();
        echo json_encode(['status' => 'error', 'message' => 'Unable to save photo. ' . $error]);
        return;
      } else {
        $file_data = $this->upload->data();
        $address_photo = $file_data['file_name'];
        $photo_path = base_url() . 'upload/client_documents/address_photo/' . $client_id . '/' . $address_photo;

        if ($getClient_document->num_rows() > 0) {
          $update_document_data = [
            'document_type'   => 'address_photo',
            'document_path'   => $photo_path,
            'updated_at'      => date('Y-m-d H:i:s a')
          ];

          $this->User_model->updatedata('sq_clients_documents', array("client_id" => $client_id, "document_type" => 'address_photo'), $update_document_data);
        } else {
          $document_data = [
            'client_id'       => $client_id,
            'document_type'   => 'address_photo',
            'document_path'   => $photo_path,
            'created_at'      => date('Y-m-d H:i:s a')
          ];

          $this->User_model->insertdata('sq_clients_documents', $document_data);
        }


        echo json_encode(['status' => 'success', 'message' => 'Address saved successfully.']);
      }
    } else {
      redirect(base_url());
    }
  }

  public function save_agreement()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $client_id = $this->session->userdata('user_id');
      $client_type = $this->session->userdata('user_type');
      $signature = $this->input->post('signature');
      $agreement_id = $this->input->post('agreement_id');
      $agreement_text = $this->input->post('agreement_text'); // Pass agreement text from frontend

      // Remove <br> tags and replace multiple spaces with a single space
      $agreement_text = preg_replace('/<br\s*\/?>/i', '', $agreement_text); // Remove <br> tags
      $agreement_text = preg_replace('/\s+/', ' ', $agreement_text); // Replace multiple spaces with a single space

      // Optionally, trim leading and trailing spaces
      $agreement_text = trim($agreement_text);

      // Proceed with further processing or saving the agreement text


      $where['client_id'] = $client_id;
      $where['document_type'] = 'agreement';
      $getClient_document = $this->User_model->select_where('sq_clients_documents', $where);
      $document_result = $getClient_document->row();

      // Decode base64 signature
      $signature = str_replace('data:image/png;base64,', '', $signature);
      $signature = str_replace(' ', '+', $signature);
      $signatureData = base64_decode($signature);
      $fileName = 'sign_' . time() . '.png';

      $client_sign_dir = FCPATH . 'upload/client_documents/agreement_sign/' . $client_id;
      if (!is_dir($client_sign_dir)) {
        mkdir($client_sign_dir, 0755, true);
      }

      $filePath = $client_sign_dir . '/' . $fileName;


      $sign_url = $document_result->document_path;

      $parts = explode('/', $sign_url);

      // The last part will be the file name
      $sign_img = end($parts);

      if (!empty($document_result->document_path)) {
        $existing_photo_path = $client_sign_dir . '/' . $sign_img;

        if (file_exists($existing_photo_path)) {
          unlink($existing_photo_path);
        }
      }

      // Save the signature as a PNG file
      if (file_put_contents($filePath, $signatureData)) {
        $signature_url = base_url('upload/client_documents/agreement_sign/' . $client_id . '/' . $fileName);

        // Generate PDF with TCPDF
        $this->load->library('tcpdf');

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company Name');
        $pdf->SetTitle('Signed Agreement');
        $pdf->SetSubject('Agreement with Digital Signature');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Add Agreement Text
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML('<h1>Agreement</h1><p>' . nl2br($agreement_text) . '</p>', true, false, true, false, '');

        // Add Signature Image
        $pdf->Image($filePath, 15, $pdf->GetY() + 10, 50, 20, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);
        $pdf->Ln(30);
        $pdf->Cell(0, 10, 'Signed by: ' . $this->session->userdata('user_name'), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s A'), 0, 1, 'L');

        // Output PDF
        $pdfFileName = 'agreement_' . time() . '.pdf';
        $pdfPath = $client_sign_dir . '/' . $pdfFileName;
        $pdf->Output($pdfPath, 'F');

        // Save paths to the database
        $signature_url = base_url('upload/client_documents/agreement_sign/' . $client_id . '/' . $fileName);
        $pdf_url = base_url('upload/client_documents/agreement_sign/' . $client_id . '/' . $pdfFileName);

        $update = array(
          "agreement_signed"      => 1,
          "agreement_id"          => $agreement_id,
          "agreement_sign"        => $signature_url,
          "agreement_pdf_path"    => $pdf_url,
          "agreement_sign_date"   => date("Y-m-d h:i:s A")
        );

        if (!empty($client_id) && $client_type == 'client') {
          $this->User_model->updatedata('sq_clients', array("sq_client_id" => $client_id), $update);
        }

        if ($getClient_document->num_rows() > 0) {
          $update_document_data = [
            'document_type'   => 'agreement',
            'document_path'   => $signature_url,
            'agreement_pdf'   => $pdf_url,
            'updated_at'      => date('Y-m-d H:i:s A')
          ];

          $this->User_model->updatedata('sq_clients_documents', array("client_id" => $client_id, "document_type" => 'agreement'), $update_document_data);
        } else {
          $document_data = [
            'client_id'       => $client_id,
            'document_type'   => 'agreement',
            'document_path'   => $signature_url,
            'agreement_pdf'   => $pdf_url,
            'created_at'      => date('Y-m-d H:i:s A')
          ];

          $this->User_model->insertdata('sq_clients_documents', $document_data);
        }
        $update_client_data = [
          'agreement_path'   => $signature_url
        ];
        $this->User_model->updatedata('sq_clients', array("sq_client_id" => $client_id), $update_client_data);

        echo json_encode(['status' => 'success', 'pdf_url' => $pdf_url]);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save signature.']);
      }
    } else {
      redirect(base_url());
    }
  }

  public function save_digital_signature()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $client_id = $this->session->userdata('user_id');
      $name = $this->input->post('name');
      $font = $this->input->post('font');
      $signature_image = $this->input->post('signature_image'); // Base64 image string

      // Decode base64 image
      list($type, $signature_image) = explode(';', $signature_image);
      list(, $signature_image)      = explode(',', $signature_image);
      $signature_image = base64_decode($signature_image);

      // Define file path to save the image
      $upload_path_dir = FCPATH . 'upload/client_documents/digital_signature/' . $client_id;
      if (!is_dir($upload_path_dir)) {
        mkdir($upload_path_dir, 0755, true);
      }

      $where['client_id'] = $client_id;
      $where['document_type'] = 'digital_signature';
      $get_document = $this->User_model->select_where('sq_clients_documents', $where);
      $document_result = $get_document->row();
      $signature_url = $document_result->document_path;
      $parts = explode('/', $signature_url);
      $digital_signature_url = end($parts);

      if (!empty($document_result->document_path)) {
        $existing_signature_path = $upload_path_dir . '/' . $digital_signature_url;

        if (file_exists($existing_signature_path)) {
          unlink($existing_signature_path);
        }
      }


      $file_name = uniqid() . '.png';
      $upload_path = FCPATH . 'upload/client_documents/digital_signature/' . $client_id . '/' . $file_name;

      if (file_put_contents($upload_path, $signature_image)) {
        $signature_path = base_url() . 'upload/client_documents/digital_signature/' . $client_id . '/' . $file_name;
        if ($get_document->num_rows() > 0) {
          $update_document_data = [
            'document_type'   => 'digital_signature',
            'document_path'   => $signature_path,
            'updated_at'      => date('Y-m-d H:i:s a')
          ];

          $this->User_model->updatedata('sq_clients_documents', array("client_id" => $client_id, "document_type" => 'digital_signature'), $update_document_data);
        } else {
          $document_data = array(

            'client_id'       => $client_id,
            'document_type'   => 'digital_signature',
            'document_path'   => $signature_path,
            'created_at'      => date('Y-m-d H:i:s a')
          );

          $this->User_model->insertdata('sq_clients_documents', $document_data);
        }

        echo json_encode(array('status' => 'success'));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to save signature.'));
      }
    } else {
      redirect(base_url());
    }
  }

  public function verify_current_password()
  {
    if ($this->session->userdata('user_type') == 'client') {
      $client_id = $this->session->userdata('user_id');
      $current_password = $this->input->post('current_password');

      $where['sq_client_id'] = $client_id;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->row();

      if ($current_password == $client_result->s_password) {
        echo json_encode(['status' => 'correct']);
      } else {
        echo json_encode(['status' => 'incorrect']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    }
  }

  public function get_invoice_data()
  {
    $invoice_no = $this->input->post('invoice_no');

    // Fetch invoice details
    $invoice_data = $this->get_invoice_by_number($invoice_no);
    if (!$invoice_data) {
      echo json_encode(array('status' => 'error', 'message' => 'Invoice not found'));
      return;
    }

    // Fetch invoice items
    $invoice_items = $this->get_invoice_items($invoice_data->id);

    // Fetch invoice payments
    $invoice_payments = $this->get_invoice_payments($invoice_no);

    // Calculate the total payments
    $total_paid = $this->get_total_payments($invoice_no);

    // Respond with the invoice data
    $response = array(
      'status' => 'success',
      'data' => array(
        'invoice_no' => $invoice_data->invoice_no,
        'client_name' => $invoice_data->client_name,
        'client_address' => $invoice_data->client_address,
        'company_name' => 'The Credit Repair Xperts',
        'company_address' => '309 Fellowship Road Suite 200,<br>#693 Mt. Laurel,<br>NJ 08054',
        'status' => $invoice_data->status,
        'invoice_date' => date('m/d/Y', strtotime($invoice_data->invoice_date)),
        'due_date' => date('m/d/Y', strtotime($invoice_data->due_date)),
        'items' => $invoice_items,
        'payments' => $invoice_payments,
        'total_invoiced' => $invoice_items->price,
        'total_paid' => $total_paid
      )
    );

    echo json_encode($response);
  }

  public function get_invoice_by_number($invoice_no)
  {
    // Fetch the invoice details based on the invoice number
    $this->db->select('*');
    $this->db->from('sq_invoices');
    $this->db->where('invoice_no', $invoice_no);
    $query = $this->db->get();

    // Check if any result exists
    if ($query->num_rows() > 0) {
      return $query->row(); // Return the invoice data as an object
    } else {
      return false; // Return false if no invoice found
    }
  }


  public function get_invoice_items($invoice_id)
  {
    // Fetch all items related to the specific invoice
    $this->db->select('description, price');
    $this->db->from('sq_invoice_items');
    $this->db->where('invoice_id', $invoice_id);
    $query = $this->db->get();

    // Check if any result exists
    if ($query->num_rows() > 0) {
      return $query->result(); // Return the list of items as an array of objects
    } else {
      return array(); // Return an empty array if no items found
    }
  }


  public function get_invoice_payments($invoice_no)
  {
    // Fetch all payments related to the specific invoice number
    $this->db->select('pay_date, pay_amount');
    $this->db->from('sq_invoice_payment');
    $this->db->where('invoice_no', $invoice_no);
    $this->db->order_by('id', 'DESC'); // You can order payments by the most recent first
    $query = $this->db->get();

    // Check if any result exists
    if ($query->num_rows() > 0) {
      return $query->result(); // Return the list of payments as an array of objects
    } else {
      return array(); // Return an empty array if no payments found
    }
  }

  public function get_total_payments($invoice_no)
  {
    // Calculate the total amount paid for the specific invoice number
    $this->db->select_sum('pay_amount');
    $this->db->from('sq_invoice_payment');
    $this->db->where('invoice_no', $invoice_no);
    $query = $this->db->get();

    // Return the total amount or 0 if no payments found
    if ($query->num_rows() > 0) {
      return $query->row()->pay_amount; // Return the total amount paid
    } else {
      return 0; // Return 0 if no payments found
    }
  }

  public function saved_reports()
  {
    if ($this->session->userdata('user_type') == 'client' || ($this->session->userdata('user_type') == 'super')) {

      $this->data['page'] = 'saved_reports';
      $user_id = $this->session->userdata('user_id');

      $where['sq_client_id'] = $user_id;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->result();

      $wherever['id'] = $client_result[0]->crx_hero_id;

      $getUser = $this->User_model->select_where('crx_hero_registration', $wherever);

      $this->data['reports'] = $getUser->result();

      if (($this->session->userdata('user_type') == 'super')) {
        $this->data['reports'] = [];
      }

      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
      exit;
    }
  }

  public function credit_reports()
  {
    if ($this->session->userdata('user_type') == 'client' || ($this->session->userdata('user_type') == 'super')) {

      $this->data['page'] = 'credit_reports';
      $user_id = $this->session->userdata('user_id');

      $where['sq_client_id'] = $user_id;
      $getClient = $this->User_model->select_where('sq_clients', $where);
      $client_result = $getClient->result();

      $wherever['id'] = $client_result[0]->crx_hero_id;

      $getUser = $this->User_model->select_where('crx_hero_registration', $wherever);

      $this->data['reports'] = $getUser->result();
    $userId = $this->data['reports'][0]->userId;
         $login = $this->login();
         $access_token =  $login['token'];
         $direct_preauth = $this->preauth_token_by_user($userId, $access_token);
           $this->data['paToken'] = $direct_preauth['token'];
      if (($this->session->userdata('user_type') == 'super')) {
        $this->data['reports'] = [];
      }

      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
      exit;
    }
  }

  public function view_credit_report($userId, $report_name)
  {
    if ($this->session->userdata('user_type') == 'client') {

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


  public function myBillsSection()
  {
    if ($this->session->userdata('user_type') == 'client' || $this->session->userdata('user_type') == 'super') {

      $this->data['page'] = 'my_bills_section';
      $sq_client_id = $this->session->userdata('user_id');

      $fetch_bills = $this->User_model->query("SELECT * FROM sq_my_bills WHERE sq_client_id = '" . $sq_client_id . "'");
      $fetch_bills = $fetch_bills->result();

      $this->data['fetch_bills'] = $fetch_bills;

      if ($this->session->userdata('user_type') == 'super') {
        $this->data['fetch_bills'] = [];
      }
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    } else {
      redirect(base_url());
    }
  }

  public function delete_bill1()
  {
    $sq_client_id = $this->input->post('sq_client_id');
    if ($sq_client_id != '') {
      $this->User_model->query("DELETE FROM sq_my_bills where sq_client_id = '" . $sq_client_id . "' ");

      echo json_encode(['status' => 'success', 'message' => 'deleted']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'ID is required']);
    }
  }


  public function get_bills()
  {
    $userId = $this->session->userdata('user_id');

    $where['sq_client_id'] = $userId;

    $bills = $this->User_model->select_where('sq_my_bills', $where);
    $bills = $bills->result();

    echo json_encode($bills);
  }

  public function get_bill($id)
  {

    $where['id'] = $id;

    $bills = $this->User_model->select_where('sq_my_bills', $where);
    $bill = $bills->result();

    echo json_encode($bill);
  }

  public function add_new_bill()
  {
    $data = $this->input->post();
    $data['sq_client_id'] = $this->session->userdata('user_id');
    $this->User_model->insertdata('sq_my_bills', $data);
    echo json_encode(['status' => 'success', 'message' => 'Bill added successfully!']);
  }


  public function edit_bill()
  {
    $data = $this->input->post();

    $id = $data['bill_id'];
    unset($data['bill_id']);

    $this->User_model->updatedata('sq_my_bills', array("id" => $id), $data);
    echo json_encode(['status' => 'success', 'message' => 'Bill updated successfully!']);
  }

  public function delete_bill($id)
  {
    if (!empty($id)) {
      $result =  $this->User_model->query("DELETE FROM sq_my_bills where id = '" . $id . "' ");
      echo json_encode(['status' => 'success', 'message' => 'Bill deleted successfully!']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete the bill.']);
    }
  }

public function ImportData()
{
     $userId = $this->session->userdata('user_id');
  if (isset($_POST['submit'])) {
    if ($_FILES['upload_csv']['name'] != '') {

      $ext = pathinfo($_FILES['upload_csv']['name'], PATHINFO_EXTENSION);

      if ($ext == 'csv' || $ext == 'mer' || $ext == 'txt') {

        $tmpFile = $_FILES['upload_csv']['tmp_name'];

        $file = fopen($tmpFile, "r");
        if (!$file) {
          $this->session->set_flashdata('error', 'Unable to read uploaded file.');
          redirect(base_url() . 'clients');
        }

        $count = 0;
        while (($milestone = fgetcsv($file, 10000, ",")) !== FALSE) {
          $count++;
          if ($count == 1) continue; // Skip header

          if (count($milestone) < 30) continue; // Skip invalid rows

          $email = $milestone[4];

          $client_data = array(
              'sq_u_id' => $userId,
            'sq_first_name'        => $milestone[0],
            'sq_middle_name'       => $milestone[1],
            'sq_last_name'         => $milestone[2],
            'sq_suffix'            => $milestone[3],
            'sq_email'             => $milestone[4],
            'sq_dob'               => $milestone[5],
            'sq_status'            => $milestone[6],
            'sq_ssn'               => $milestone[7],
            'sq_phone_work'        => $milestone[8],
            'sq_mailing_address'   => $milestone[9],
            'sq_city'              => $milestone[10],
            'sq_state'             => $milestone[11],
            'sq_zipcode'           => $milestone[12],
            'sq_p_mailing_address' => $milestone[13],
            'sq_p_city'            => $milestone[14],
            'sq_p_state'           => $milestone[15],
            'sq_p_zipcode'         => $milestone[16],
            'sq_phone_mobile'      => $milestone[17],
            'sq_date_of_start'     => $milestone[18],
            'sq_client_added'      => $milestone[19],
            'sq_phone_home'        => $milestone[20],
            'phone_ext'            => $milestone[21],
            'sq_fax'               => $milestone[22],
            'sq_country'           => $milestone[23],
            'sq_p_country'         => $milestone[24],
            'country_code'         => $milestone[25],
            'sq_referred_by'       => $milestone[26],
            'affiliate_compmany'   => $milestone[27],
            'sq_assigned_to'       => $milestone[28],
            'memo'                 => $milestone[29],
          );

          $fetch_client_data = $this->User_model->query("SELECT * FROM sq_clients WHERE sq_email='$email'");
          if ($fetch_client_data->num_rows() > 0) {
            $this->User_model->updatedata('sq_clients', array('sq_email' => $email), $client_data);
          } else {
            $this->User_model->insertdata('sq_clients', $client_data);
          }
        }

        fclose($file);

        $this->session->set_flashdata('success', 'All records successfully uploaded.');
        redirect(base_url() . 'clients');

      } else {
        $this->session->set_flashdata('error', 'Only CSV/mer/txt files allowed.');
        redirect(base_url() . 'clients');
      }

    } else {
      $this->session->set_flashdata('error', 'No file selected.');
      redirect(base_url() . 'clients');
    }
  }
}
public function export_csv()
{
    // Load download helper
    $this->load->helper('download');
    $this->load->dbutil(); // Required for csv_from_result()

    // Fetch data
    $query = $this->db->query("SELECT * FROM sq_clients");

    // Generate CSV
    $delimiter = ",";
    $newline = "\r\n";
    $csv_data = $this->dbutil->csv_from_result($query, $delimiter, $newline);

    // Download CSV
    $filename = "clients_export_" . date("Ymd_His") . ".csv";
    force_download($filename, $csv_data);
}
public function update_task() {
    $id = $this->input->post('id');
    $data = [
        'task_type'   => $this->input->post('taskType'),
        'subject'     => $this->input->post('subject'),
        'due_date'    => $this->input->post('dueDate'),
        'due_time'        => $this->input->post('time'),
        'team_member_id' => $this->input->post('teamMember'),
        'notes'       => $this->input->post('notes'),
          'datetime'  => date('Y-m-d H:i:s')
    ];

    $this->db->where('id', $id);
    $updated = $this->db->update('sq_task', $data);
$due_date = $this->input->post('dueDate'); // e.g. 2025-06-12
$due_time = $this->input->post('time');    // e.g. 14:30

// Combine date and time
$combined = $due_date . ' ' . $due_time;

// Format to: Y-m-d h:i A
$end = date('Y-m-d h:i A', strtotime($combined));


    $data = [
        'event_type'   => $this->input->post('taskType'),
        'title'     => $this->input->post('subject'),
         'event_subject'     => $this->input->post('subject'),
        'end'    => $end,
        'user_id' => $this->input->post('teamMemberid'),
        'description'       => $this->input->post('notes'),
    ];
    
       $this->db->where('task_id', $id);
    $updated = $this->db->update('sq_calender', $data);
    
    echo json_encode([
        'status' => $updated ? 'success' : 'error',
        'message' => $updated ? 'Updated' : 'Failed'
    ]);
}

public function taskSave() {
    // Load database if not autoloaded
    $this->load->database();

    // Get POST data
    $taskType = $this->input->post('taskType');
    $subject = $this->input->post('subject');
    $dueDate = $this->input->post('dueDate');
    $time = $this->input->post('time');
    $teamMember = $this->input->post('teamMember');
    $notes = $this->input->post('notes');
    $client_id = $this->input->post('client_id');
       $teamMemberid = $this->input->post('teamMemberid');

    // Simple validation (optional but recommended)
    if (!$taskType || !$subject || !$dueDate) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields missing']);
        return;
    }

    $data = [
        'task_type'   => $taskType,
        'sq_client_id'=>$client_id,
        'subject'     => $subject,
        'due_date'    => $dueDate,
        'due_time'        => $time,
        'team_member_id' => $teamMember,
        'notes'       => $notes,
        'datetime'  => date('Y-m-d H:i:s')
    ];

    $insert = $this->db->insert('sq_task', $data);
    $task_id = $this->db->insert_id(); // get inserted task ID
    $start = date('Y-m-d h:i A'); // current date and time in desired format
$end = date('Y-m-d h:i A', strtotime($dueDate)); // format due date
        $datas = [
        'event_type'   => $taskType,
        'event_clients'=>$client_id,
        'title'     => $subject,
        'event_subject'     => $subject,
        'start'    => $start,
         'end'    => $end,
        'user_id' => $teamMemberid,
        'description'       => $notes,
        'task_id'        => $task_id
    ];
 $this->db->insert('sq_calender', $datas);
    if ($insert) {
        echo json_encode(['status' => 'success', 'message' => 'Task saved']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
}
 public function delete_task()
  {
    $task_id = $this->input->post('task_id');
     $this->db->delete('sq_task', ['id' => $task_id]);
    echo json_encode(['status' => 'success']);
  }
public function filter_by_team_member_ajax()
{
    $full_name = $this->input->post('full_name');

    if (!empty($full_name)) {
        $task = $this->User_model->query("
    SELECT t.*, c.sq_first_name, c.sq_last_name
    FROM sq_task t
    LEFT JOIN sq_clients c ON t.sq_client_id = c.sq_client_id
    WHERE t.task_status = 0 AND t.team_member_id = '$full_name'
");
    } else {
       $task = $this->User_model->query("
    SELECT t.*, c.sq_first_name, c.sq_last_name
    FROM sq_task t
    LEFT JOIN sq_clients c ON t.sq_client_id = c.sq_client_id
    WHERE t.task_status = 0
");
    }

if ($task->num_rows() > 0) {
    $data['tasks_current'] = $task->result();
}

    // Return only <tr> rows
    $this->load->view('task/ajax_task_rows', $data);
}

 public function taskstatusUpdate()
{
    $task_id = $this->input->post('task_id');
    $status = $this->input->post('task_status');

    $this->db->where('id', $task_id);
    $this->db->update('sq_task', ['task_status' => $status]);

    echo json_encode(['success' => true,'status'=>$status]);
}

    public function login()
    {
        $url = "https://efx-wgt.stitchcredit.com:443/api/direct/login";
//live mode
   $data = array(
            "apikey" => "0f55847b-3d2f-483d-b387-82dc4c0847cc",
            "secret" => "05e510b3-e6d3-4f89-9cc1-2ab2e3a6a127"
        );

        $response = $this->send_post_request($url, $data);

        return json_decode($response, true);
    }
    public function preauth_token_by_user($userId, $token)
    {
        $url = "https://efx-wgt.stitchcredit.com:443/api/direct/preauth-token/$userId";

        $bearer_token = $token;
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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Keep true in production
curl_setopt($ch, CURLOPT_VERBOSE, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function get_headers($bearer_token = null)
    {
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'
        );
        if ($bearer_token) {
            $headers[] = 'Authorization: Bearer ' . $bearer_token;
        }
        return $headers;
    }


}
