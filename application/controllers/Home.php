<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  function __construct()
  {

    parent::__construct();
    error_reporting(0);
    $this->load->helper('url');
    $this->load->model('User_model');
    $this->load->library('email');
    $this->load->library('form_validation');
 $this->load->library('Maverick_payment_gateway');
    $this->data['theme'] = 'home';
  }

  public function index()
  {
    $userID = $this->session->userdata('user_id');
    $this->data['page'] = 'index';

    if (isset($userID)) {

      $where['sq_u_id'] = $userID;
      $getUser = $this->User_model->select_where('sq_users', $where);
      $getUser = $getUser->result();

      if (!empty($userID) && $getUser[0]->sq_u_type == 'super' || $getUser[0]->sq_u_type == 'emp') {
        redirect(base_url() . 'admin');
      } elseif ($this->session->userdata('user_type') == 'client') {
        redirect(base_url('client/dashboard'));
      }
    } else {

      $this->data['plans'] = $this->db->where("status", 1)->get('sq_subscription_plans')->result_array();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    }
  }

  public function subscription_plans()
  {
    $userID = $this->session->userdata('user_id');
    $this->data['page'] = 'subscription_plans';

    if (isset($userID)) {

      $where['sq_u_id'] = $userID;
      $getUser = $this->User_model->select_where('sq_users', $where);
      $getUser = $getUser->result();

      if (!empty($userID) && $getUser[0]->sq_u_type == 'super' || $getUser[0]->sq_u_type == 'emp') {
        redirect(base_url() . 'admin');
      } elseif ($this->session->userdata('user_type') == 'client') {
        redirect(base_url('client/dashboard'));
      }
    } else {

      $this->data['plans'] = $this->db->where("status", 1) ->order_by('sort_order', 'ASC')->get('sq_subscription_plans')->result_array();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template');
    }
  }



  public function signin()
  {
    if ($this->input->post()) {
      $email = $this->input->post('email');
      $pass = $this->input->post('password');
      $response = ['status' => 'error'];

      if (empty($email)) {
        $response['emailError'] = "Email is required";
      }
      if (empty($pass)) {
        $response['passwordError'] = "Password is required";
      }
     
      if (!empty($email) && !empty($pass)) {
          
        $where = ['sq_u_email_id' => $email, 'sq_u_password' => md5($pass)];
      //  print_r($where);
        $getUser = $this->User_model->select_where('sq_users', $where);

        if ($getUser->num_rows() > 0) {
          $user = $getUser->row();

          if ($user->subscriber_type == 1 &&  is_null($user->added_by)) {

            $response['emailError'] = "Incorrect email";
            $response['passwordError'] = "Incorrect password";
            echo json_encode($response);
            exit;
          }

          if (!empty($user->added_by)) {

            $query = $this->db->get_where('sq_users', ['sq_u_id' => $user->added_by]);

            if ($query->num_rows() > 0) {
              $addedByUser = $query->row();

              if (!empty($addedByUser->subscriber_type) && $addedByUser->subscriber_type == 1) {
                $response['emailError'] = "Incorrect email";
                $response['passwordError'] = "Incorrect password";
                echo json_encode($response);
                exit;
              }
            }
          }


          // Set session
          $this->session->set_userdata('user_id', $user->sq_u_id);
          $this->session->set_userdata('user_name', $user->sq_u_first_name . ' ' . $user->sq_u_last_name);
          $this->session->set_userdata('user_type', $user->sq_u_type);

          // Set cookies for remember me
          if ($this->input->post('remember')) {
            set_cookie('email', $email, 604800);
            set_cookie('password', $pass, 604800);
          }

          // Redirect URL
          $response = [
            'status' => 'success',
            'redirect_url' => ($user->sq_u_type == 'super' || $user->sq_u_type == 'emp') ? base_url('admin') : base_url()
          ];
        } else {
          $response['emailError'] = "Incorrect email";
          $response['passwordError'] = "Incorrect password";
        }
      }

      echo json_encode($response);
      exit;
    } else {
      $this->load->view('home/login');
    }
  }


  public function lost_password()
  {
       $data['type'] = $this->uri->segment(2);

    $this->load->view('home/lost_password',$data);
  }

  public function forgot_password()
  {
    $this->load->view('home/forgot_password');
  }

  public function fetchLoginDetails()
  {

    $fetchdata = $this->User_model->query("SELECT * FROM sq_activity as sa JOIN sq_users as su ON sa.user_id = su.sq_u_id WHERE sa.activity_type = 'Login-Activity' ORDER BY id DESC");
    $fetchdata = $fetchdata->result();
    return $fetchdata;
  }

  public function dashboard_view()
  {

    $userID = $this->session->userdata('user_id');

    if ($this->session->userdata('user_type') == 'client') {
      redirect(base_url('client/dashboard'));
      exit;
    }

    // if ($this->session->userdata('user_type') == 'subscriber') {
    //   redirect(base_url('subscriber/dashboard'));
    //   exit;
    // }

    if (isset($userID)) {

      $data['fetchLoginDetails'] = $this->fetchLoginDetails();

      $data['dashboardinfo'] = 'dashboardinfo';
          $fetchClientdata = $this->User_model->query("SELECT * FROM sq_clients ORDER BY sq_client_id DESC");
          
    $data['client_data']  = $fetchClientdata->result();
      $data['content'] = $this->load->view('home/dashboard', $data, true);
      $this->load->view('template/template', $data);
    } else {

      // $this->signin();
      redirect(base_url());
    }
  }

  public function GetAllEmailTemp()
  {

    $fetch_etemp = $this->User_model->select_star('sq_auto_email_templates');
    $fetch_etemp = $fetch_etemp->result();
    return $fetch_etemp;
  }

  public function getEmailtemplate()
  {
    $tempid = $this->input->post('id');
    $fetch_etemp = $this->User_model->select_where('sq_auto_email_templates', array('id' => $tempid));
    $fetch_etemp = $fetch_etemp->row();
    echo json_encode($fetch_etemp);
  }

  public function auto_email_templates()
  {

    // redirect to dashboard if logged in else redirect to sigin page  
    $userID = $this->session->userdata('user_id');

    if ($this->session->userdata('user_type') == 'client') {
      redirect(base_url('client/dashboard'));
      exit;
    }

    // if ($this->session->userdata('user_type') == 'subscriber') {
    //   redirect(base_url('subscriber/dashboard'));
    //   exit;
    // }

    if (isset($userID)) {

      if (isset($_POST['save'])) {

        $tempid = $this->input->post('temid');
        $data1['temp_name'] = $this->input->post('temp_name');
        $data1['temp_for'] = $this->input->post('temp_for');
        $data1['temp_text'] = $this->input->post('temp_msg');

        $checkTEmp = $this->User_model->select_where('sq_auto_email_templates', array('id' => $tempid));
        if ($checkTEmp->num_rows() > 0) {

          $this->User_model->updatedata('sq_auto_email_templates', array('id' => $tempid), $data1);
          $this->session->set_flashdata('success', 'E-mail template update successfully!');
        } else {
          $this->User_model->insertdata('sq_auto_email_templates', $data1);
          $this->session->set_flashdata('success', 'E-mail template added successfully!');
        }

        redirect(base_url() . 'email_templates');
      }

      $data['fetchLoginDetails'] = $this->fetchLoginDetails();
      $data['GetAllEmailTemp']  = $this->GetAllEmailTemp();

      $data['dashboardinfo'] = 'dashboardinfo';
      $data['content'] = $this->load->view('home/email_templates', $data, true);
      $this->load->view('template/template', $data);
    } else {
      $this->signin();
    }
  }

  public function get_loginUser_info($loginID)
  {

    $fetch_user = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_id` = '" . $loginID . "'");
    $fetch_user = $fetch_user->row();
    return $fetch_user;
  }


  public function Userprofile()
  {

    $userID = $this->session->userdata('user_id');

    if ($this->session->userdata('user_type') == 'client') {
      redirect(base_url('client/dashboard'));
      exit;
    }

    // if ($this->session->userdata('user_type') == 'subscriber') {
    //   redirect(base_url('subscriber/dashboard'));
    //   exit;
    // }

    if ($userID != '') {

      if (isset($_POST['update'])) {

        $data['sq_u_first_name']      = $this->input->post('fname');
        $data['sq_u_last_name']       = $this->input->post('lname');
        $data['sq_u_address']         = $this->input->post('address');
        $data['sq_u_phone']           = $this->input->post('phone');
        $data['sq_u_mobile']          = $this->input->post('mobile');
        $data['sq_u_fax']             = $this->input->post('fax');


        if ($_FILES['file']['name'] != '') {

          $config['upload_path'] = 'assets/upload/profile_pictures';
          $config['allowed_types'] = 'jpg|jpeg|png';
          $config['file_name'] = $_FILES['file']['name'];

          $this->load->library('upload', $config);
          if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url() . 'profile');
          } else {
            $imgdata = $this->upload->data();
            $picture = base_url() . 'assets/upload/profile_pictures/' . $imgdata['file_name'];

            $where['sq_u_id'] = $userID;
            $data['sq_u_profile_picture'] = $picture;
            $this->User_model->updatedata('sq_users', $where, $data);
            $this->session->set_flashdata('success', 'Profile updated successfully!');
          }
        } else {

          $where['sq_u_id'] = $userID;
          $this->User_model->updatedata('sq_users', $where, $data);
          $this->session->set_flashdata('success', 'Profile updated successfully!');
        }

        $this->allActivityHome('User (' . $this->input->post('fname') . ' ' . $this->input->post('lname') . ') updated his/her profile successfully!'); //track activity
        redirect(base_url() . 'profile');
      } else {

        $data['get_loginUser_info'] = $this->get_loginUser_info($userID);

        $data['dashboardinfo'] = 'dashboardinfo';
        $data['content'] = $this->load->view('home/user_profile', $data, true);
        $this->load->view('template/template', $data);
      }
    } else {
      redirect(base_url());
    }
  }



  public function loginActivity($activity_type, $status)
  {

    $ip_address     = $this->get_client_ip();
    $get_devices    = $this->get_device();

    $details        = json_decode(file_get_contents("http://ipinfo.io/{$ip_address}/json"));
    $location       = $details->country . ', ' . $details->city;

    $data['activity_type']  = $activity_type;
    $data['user_id']        = $this->session->userdata('user_id');
    $data['ip_address']     = $ip_address;
    $data['access_type']    = $get_devices;
    $data['status']         = $status;
    $data['datetime']       = date('Y-m-d H:i:s a');
    $data['location']       = $location;

    $this->User_model->insertdata('sq_activity', $data);
    return;
  }

  public function signout()
  {

    $this->loginActivity('Login-Activity', 'Logout');
    $this->allActivityHome($this->session->userdata('user_name') . ' sign-out from CRM successfully!'); //track activity
    // clear the session and redirect to sigin page 
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('user_name');
    $this->session->unset_userdata('user_type');
    redirect(base_url());
  }

  public function generate_pwd($length)
  {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
  }

  public function reset_password()
  {
    $email = $this->input->post('email');
    if ($email != '') {

      $where['sq_u_email_id'] = $email;


      $check_useremail =  $this->User_model->select_where('sq_users', $where);
      if ($check_useremail->num_rows() > 0) {

        $check_useremail = $check_useremail->result();

        $ids            = $check_useremail[0]->sq_u_id;
        $email_address  = $check_useremail[0]->sq_u_email_id;
        $fullname       = $check_useremail[0]->sq_u_first_name;

        $security   = $this->generate_pwd(16);
        $reset_link = base_url() . 'forget_password_secure/' . $security;

        $updation['sq_forget_pass_time']       = date('Y-m-d h:i:s');
        $updation['sq_pass_security']          = $security;
        $where['sq_u_id']                        = $ids;

        $this->User_model->updatedata('sq_users', $where, $updation);

        $logolink = base_url() . 'assets/images/logo.png';
        $password_message = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #3972FC;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Forgot Password</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 60px 20px 60px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $fullname . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"> Click on the link blow to reset your password.</p><a href="' . $reset_link . '" style="background:#3972FC;border: none;color: #fff;padding: 8px 20px;border-radius: 4px;display: inline-block;margin-bottom: 20px;text-decoration: none;cursor: pointer;">RESET PASSWORD</a><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"> If you did not make this request, please contact us or ignore this message.</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';


        $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');

        $this->email->initialize($email_config);
        $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
        $this->email->to($email_address);
        $this->email->subject('Password Recovery');

        $this->email->message($password_message);
        $this->email->send();

        echo '1';
      } else {

        echo 'This email is not associated with any account!';
      }
    } else {
      echo 'Email field required!';
    }
  }

  public function allActivityHome($msg)
  {

    $loginID = $this->session->userdata('user_id');
    $datetime = date('Y-m-d H:i:s a');

    $data['user_id']        = $loginID;
    $data['msg']            = $msg;
    $data['datetime']       = $datetime;
    $this->User_model->insertdata('sq_all_activity', $data);

    // New added 14-11-2024 s
    $fetch_users = $this->User_model->select_star('sq_users');

    if ($fetch_users->num_rows() > 0) {

      $fetch_users = $fetch_users->result();

      foreach ($fetch_users as $key => $value) {
        $datetime = date('Y-m-d H:i:s a');

        $notification_data['sender_id']        = $loginID;
        $notification_data['receiver_id']        = $value->sq_u_id;
        $notification_data['read_status']        = 0;
        $notification_data['msg']            = $msg;
        $notification_data['created_at']       = $datetime;

        $this->User_model->insertdata('notifications', $notification_data);
      }
    }
    // New added 14-11-2024 e

    return;
  }

  public function forget_password_secure()
  {
    $data['status2'] = $data['msg2'] = '';
    $url_data   = $this->uri->segment(2);

    if ($this->input->post() || $url_data != '') {

      $user['sq_pass_security']  = $url_data;

      $fetch_user_data  = $this->User_model->select_where('sq_users', $user);
      if ($fetch_user_data->num_rows() > 0) {
        $fetch_user_data    = $fetch_user_data->result();
        $id               = $fetch_user_data[0]->sq_u_id;
        $forget_pass_time   = $fetch_user_data[0]->sq_forget_pass_time;

        $current_time       =  date('Y-m-d H:i:s');
        $forget_time        =  strtotime($forget_pass_time);
        $now_time         =  strtotime($current_time);

        $check_forget_pass_time = round(abs($forget_time - $now_time) / 60, 2);

        if ($check_forget_pass_time < 1440) {


          $data['id'] = $id;

          $data['msgerror'] = '';

          //////////////////////////////////////////////////////////////////////////////////
          $UserId = $this->input->post('UserId');
          $new_password = $this->input->post("new_password");
          $re_password = $this->input->post("re_password");
          $this->form_validation->set_rules('new_password', 'Password', 'required');
          $this->form_validation->set_rules('re_password', 'Confirm Password', 'required|matches[new_password]');
          if ($this->form_validation->run() != FALSE) {

            $data_d['sq_u_apassword']         = $new_password;
            $data_d['sq_u_password']         = md5($new_password);
            $data_d['sq_forget_pass_time']     = NULL;
            $data_d['sq_pass_security']      = NULL;
            $where['sq_u_id']              = $UserId;

            $data['status2'] = 'true';
            if (!empty($UserId)) {
              $data['msg2'] = 'Password updated successfully.';
              $this->User_model->updatedata('sq_users', $where, $data_d);
            } else {
              $data['msg2'] = 'Something is wrong please try again.';
            }
          }
          //////////////////////////////////////////////////////////////////////////////////

          $this->load->view('home/new_password', $data);
        } else {

          $data['status'] = 'false';
          $data['msg'] = 'Link expire. Time out!';
          $data['id'] = '';
          $this->load->view('home/new_password', $data);
        }
      } else {


        $data['status'] = 'false';
        $data['msg'] = 'Link not valid!';
        $data['id'] = '';
        $this->load->view('home/new_password', $data);
      }
    } else {
      $data['status'] = 'false';
      $data['msg'] = 'Link not valid!';
      $data['id'] = '';
      $this->load->view('Home/new_password', $data);
    }
  }

  public function newPassword()
  {

    $input = $this->input->post();

    if ($input['UserId'] && $input['new_password'] && $input['re_password'] != '') {

      if ($input['new_password'] == $input['re_password']) {

        $password                 = $input['new_password'];
        $data['sq_u_apassword']         = $password;
        $data['sq_u_password']         = md5($password);
        $data['sq_forget_pass_time']     = NULL;
        $data['sq_pass_security']      = NULL;
        $where['sq_u_id']              = $input['UserId'];

        $this->User_model->updatedata('sq_users', $where, $data);

        $data['status'] = 'true';
        $data['id'] = $input['UserId'];
        $data['msg'] = 'Password updated successfully';
        $data['msgerror'] = '';
        $this->load->view('home/login', $data);
      } else {

        $data['status'] = 'true';
        $data['msgerror'] = 'Password not match';
        $data['msg'] = '';
        $data['id'] = $input['UserId'];
        $this->load->view('home/login', $data);
      }
    } else {

      $data['status'] = 'true';
      $data['msgerror'] = 'All fields required';
      $data['msg'] = '';
      $data['id'] = $input['UserId'];
      $this->load->view('home/login', $data);
    }
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

  public function submit_consultation1()
  {
    $data = [
      'name'    => $this->input->post('name'),
      'phone'   => $this->input->post('phone'),
      'email'   => $this->input->post('email'),
      'message' => $this->input->post('message')
    ];

    if ($this->check_email_exists($data['email'])) {
      echo json_encode(['status' => 'error', 'message' => 'Email already exists!']);
      return;
    }

    $insert = $this->save($data);
    echo json_encode([
      'status' => $insert ? 'success' : 'error',
      'message' => $insert ? 'Form submitted successfully!' : 'Something went wrong!'
    ]);
  }

  public function submit_consultation()
  {
    $data = [
      'name'    => $this->input->post('name'),
      'phone'   => $this->input->post('phone'),
      'email'   => $this->input->post('email'),
      'message' => $this->input->post('message')
    ];

    if ($this->check_email_exists($data['email'])) {
      echo json_encode(['status' => 'error', 'message' => 'Email already exists!']);
      return;
    }

    $insert = $this->save($data);

    if ($insert) {
      // Send confirmation or notification email
      $this->send_email_notification($data);
    }

    echo json_encode([
      'status' => $insert ? 'success' : 'error',
      'message' => $insert ? 'Form submitted successfully!' : 'Something went wrong!'
    ]);
  }


  private function send_email_notification($data)
  {
    $this->load->config('email_custom');

    $email_config = $this->config->item('email_config');

    /** Send to user **/
    $this->email->initialize($email_config);
    $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
    $this->email->to($data['email']);
    $this->email->subject('Your Free Consultation Request');

    $logolink        = base_url() . 'assets/images/logo.png';
    $site_link        = base_url();
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $message = $data['message'];

    $user_message = '<div class="table-responsive mb-4"><table style="background:#e9f7ef; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 20px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 30px 20px 30px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($name) . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Thank you for signing up for a free consultation! We have received your message and will get back to you as soon as possible.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060"><b>Summary of Your Request:</b></p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Name:</b></td><td>' . $name . '</td></tr><tr><td style="padding-right: 10px;"><b>Email:</b></td><td>' . $email . '</td></tr><tr><td style="padding-right: 10px;"><b>Phone:</b></td><td>' . $phone . '</td></tr><tr><td style="padding-right: 10px;"><b>Message:</b></td><td>' . $message . '</td></tr> </table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

    $this->email->message($user_message);
    $this->email->send();

    $this->email->clear(true); // full reset
    $this->email->initialize($email_config);
    $this->email->from('noreply@thecreditrepairxperts.com', 'Website Notification');
    $this->email->to('admin.crx@gmail.com');
    $this->email->subject('New Consultation Request Received');


    $admin_message = '<div class="table-responsive mb-4"><table style="background:#e9f7ef; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 20px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 30px 20px 30px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear Admin,</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">New consultation request received via the website.</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Name:</b></td><td>' . $name . '</td></tr><tr><td style="padding-right: 10px;"><b>Email:</b></td><td>' . $email . '</td></tr><tr><td style="padding-right: 10px;"><b>Phone:</b></td><td>' . $phone . '</td></tr><tr><td style="padding-right: 10px;"><b>Message:</b></td><td>' . $message . '</td></tr> </table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

    $this->email->message($admin_message);
    $this->email->send();
  }

  public function save($data)
  {
    return $this->db->insert('consultations', $data);
  }

  public function check_email()
  {
    $email = $this->input->post('email');
    echo json_encode(['exists' => $this->check_email_exists($email)]);
  }

  private function check_email_exists($email)
  {
    return $this->db->where('email', $email)->get('consultations')->num_rows() > 0;
  }

  public function reset_password1()
  {
    $email = $this->input->post('email');
     $type = $this->input->post('type');
    $response = ['status' => false, 'messages' => []];

    if (empty($email)) {
      $response['messages']['email'] = 'Email is required';
    } else {
      if (empty($email)) {
    $response['messages']['email'] = 'Email is required';
} else {
    switch ($type) {
        case 'admin':
            $where['sq_u_email_id'] = $email;
            $check_user = $this->User_model->select_where('sq_users', $where);

            if ($check_user->num_rows() > 0) {
                $user = $check_user->row();
                $full_name = $user->sq_u_first_name . ' ' . $user->sq_u_last_name;
                $security = $this->generate_unique_key(16);
                $reset_link = base_url('forget-password/secure/admin/' . $user->sq_u_id);

                $this->User_model->updatedata('sq_users', ['sq_u_id' => $user->sq_u_id], [
                    'sq_forget_pass_time' => date('Y-m-d H:i:s'),
                    'sq_pass_security' => $security
                ]);

                $this->send_reset_password_email($user->sq_u_user_id, $full_name, $reset_link);

                $response['status'] = true;
                $response['message'] = 'A password reset link has been sent to your email.';
            } else {
                $response['messages']['email'] = 'Email not found.';
            }
            break;

        case 'client':
            $where['sq_email'] = $email;
            $check_user = $this->User_model->select_where('sq_clients', $where);

            if ($check_user->num_rows() > 0) {
                $user = $check_user->row();
                $full_name = $user->sq_first_name . ' ' . $user->sq_last_name;
                $security = $this->generate_unique_key(16);
                $reset_link = base_url('forget-password/secure/client/' . $user->sq_client_id);

                $this->send_reset_password_email($user->sq_email, $full_name, $reset_link);

                $response['status'] = true;
                $response['message'] = 'A password reset link has been sent to your email.';
            } else {
                $response['messages']['email'] = 'Email not found.';
            }
            break;

        case 'subscription':
            $where['sq_u_email_id'] = $email;
            $where['sq_u_type'] = '3';
            $check_user = $this->User_model->select_where('sq_users', $where);

            if ($check_user->num_rows() > 0) {
                $user = $check_user->row();
                $full_name = $user->sq_u_first_name . ' ' . $user->sq_u_last_name;
                $security = $this->generate_unique_key(16);
                $reset_link = base_url('forget-password/secure/subscription/' . $user->sq_u_id);

                $this->User_model->updatedata('sq_users', ['sq_u_id' => $user->sq_u_id], [
                    'sq_forget_pass_time' => date('Y-m-d H:i:s'),
                    'sq_pass_security' => $security
                ]);

                $this->send_reset_password_email($user->sq_u_user_id, $full_name, $reset_link);

                $response['status'] = true;
                $response['message'] = 'A password reset link has been sent to your email.';
            } else {
                $response['messages']['email'] = 'Email not found.';
            }
            break;

        case 'affiliate':
            $where['sq_affiliates_email'] = $email;
            $check_user = $this->User_model->select_where('sq_affiliates', $where);

            if ($check_user->num_rows() > 0) {
                $user = $check_user->row();
                $full_name = $user->sq_affiliates_first_name . ' ' . $user->sq_affiliates_last_name;
                $security = $this->generate_unique_key(16);
                $reset_link = base_url('forget-password/secure/affiliate/' . $user->sq_affiliates_id );

                $this->send_reset_password_email($user->sq_affiliates_email, $full_name, $reset_link);

                $response['status'] = true;
                $response['message'] = 'A password reset link has been sent to your email.';
            } else {
                $response['messages']['email'] = 'Email not found.';
            }
            break;

        default:
            $response['messages']['type'] = 'Invalid user type provided.';
            break;
    }
}

    }

    echo json_encode($response);
  }

  public function forget_password_secure1($type,$id)
  {
    // $user = $this->User_model->select_where('crx_hero_registration', ['pass_security' => $token]);
    // $data = ['user_id' => '', 'status' => 'false', 'msg' => 'Invalid or expired link'];

    // if ($user->num_rows() > 0) {
    //   $user = $user->row();
    //   $expireTime = strtotime($user->forget_pass_time) + (60 * 60 * 24); // 24 hrs
    //   if (time() < $expireTime) {
    //     $data = ['user_id' => $user->id, 'status' => 'true'];
    //   } else {
    //     $data['msg'] = 'Link expired.';
    //   }
    // }
$data['type']=$this->uri->segment(3);
$data['id']=$this->uri->segment(4);

     $this->load->view('home/new_password',$data);
  }
public function resetPassword()
{
    $response = ['status' => false, 'messages' => []];
    $input = $this->input->post();
    log_message('debug', 'Reset Password Input: ' . json_encode($input));

    if (empty($input['new_password'])) {
        $response['messages']['new_password'] = 'New password is required';
    }

    if (empty($input['confirm_password'])) {
        $response['messages']['confirm_password'] = 'Please confirm your password';
    }

    if (!empty($input['new_password']) && !empty($input['confirm_password'])) {
        if ($input['new_password'] !== $input['confirm_password']) {
            $response['messages']['confirm_password'] = 'Passwords do not match';
        }
    }

    if (empty($response['messages'])) {
        $id = $input['UserId'];
        $type = $input['type'];
        $hashed_password = $input['new_password']; // secure hash

    switch ($type) {
    case 'admin':
        $this->db->where('sq_u_id', $id);
        $this->db->update('sq_users', ['sq_u_apassword' => $hashed_password]);
        $response['debug'] = 'admin case executed';
        break;
    case 'client':
        $this->db->where('sq_client_id', $id);
        $this->db->update('sq_clients', ['password' => md5($hashed_password),'s_password' => $hashed_password]);
        $response['debug'] = 'client case executed';
        break;
    case 'subscription':
        $this->db->where('sq_u_id', $id);
        $this->db->update('sq_users', ['sq_u_apassword' => $hashed_password]);
        $response['debug'] = 'subscriber case executed';
        break;
    case 'affiliate':
        $this->db->where('sq_affiliates_id', $id);
        $this->db->update('sq_affiliates', ['sq_affiliates_password' => base64_encode($hashed_password)]);
        $response['debug'] = 'affiliate case executed';
        break;
    default:
        $response['debug'] = 'Unknown type: ' . $type;
}


        $response['status'] = true;
        $response['message'] = 'Your password has been updated successfully.';
    }

    echo json_encode($response);
}

  public function new_password1()
  {
    $input = $this->input->post();
    $response = ['status' => false, 'messages' => []];

    if (empty($input['new_password'])) {
      $response['messages']['new_password'] = 'New password is required';
    }

    if (empty($input['confirm_password'])) {
      $response['messages']['confirm_password'] = 'Please confirm your password';
    }

    if (!empty($input['new_password']) && !empty($input['confirm_password'])) {
      if ($input['new_password'] !== $input['confirm_password']) {
        $response['messages']['confirm_password'] = 'Passwords do not match';
      }
    }

    if (empty($response['messages'])) {
      $this->User_model->updatedata('crx_hero_registration', ['id' => $input['UserId']], [
        'password' => md5($input['new_password']),
        's_password' => $input['new_password'],
        'pass_security' => NULL,
        'forget_pass_time' => NULL
      ]);
      $response['status'] = true;
      $response['message'] = 'Your password has been updated successfully.';
    }

    echo json_encode($response);
  }



  public function generate_unique_key($length)
  {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
  }



  public function send_reset_password_email($email_address, $fullname, $reset_link)
  {

    if ($email_address != '') {

      $logolink        = base_url() . 'assets/images/logo.png';
      $site_link        = base_url('sign-in');

      $message = '<table style="width:100%" bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" valign="top"><br><table style="width:600px" align="center" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background:#fff;border:#f2f2f2 solid 1px;border-top:0px;padding:20px;font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;line-height:22px" align="left" valign="top"><p style="font-family:Helvetica,Arial,sans-serif;font-size:18px;color:#606060"><b>Dear ' . ucwords($fullname) . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">We received a request to reset your password. Click the link below to choose a new one.</p><div style="text-align:left;"><a href="' . $reset_link . '" style="background-color:#0558b5; color:#fff; border:none; padding:8px 8px; font-size:15px; cursor:pointer; border-radius: 4px; text-decoration: none">Reset Your Password</a></div></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table>&nbsp;</td></tr></tbody></table>';
      
             $this->load->config('email_custom');
        $email_config = $this->config->item('email_config');

        $this->email->initialize($email_config);
            $this->email->set_mailtype("html");
        $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
$this->email->to($email_address);
// $this->email->to("ak413683@gmail.com");
        $this->email->subject('Forget Password');

        $this->email->message($message);
        $this->email->send();
      return '1';
    }
  }

// delte template 16 aprl ashok
 public function deleteTemplate()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $deleteTemplate = $this->User_model->query("DELETE FROM sq_auto_email_templates where id = '" . $id . "' ");
            echo json_encode('deleted');
        }
    }

public function RecurringPayment()
{
    $key = $this->input->get('key');
    if ($key !== 'MySecret123') {
        show_404(); // Block access
        return;
    }

    $this->recurringPayments(); 
}
public function recurringPayments()
{
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d');

    // Get users whose subscription ends today and are active
    $query = $this->User_model->query("SELECT * FROM `sq_subscription_payment_details` WHERE DATE(subscription_end_date) = '$today' AND payment_status = '1'");
    $users = $query->result();
    foreach ($users as $user) {
        $payment_token = $user->payment_token;
        $amount        = $user->subscription_price;
        $user_id       = $user->sq_u_id_subscriber;
        $email         = $user->sq_email;
    $subscription_id         = $user->subscription_id;
        $querys = $this->User_model->query("SELECT * FROM `sq_subscription_plans` WHERE id = $subscription_id");
    $plans  = $querys->row();
    if (!$plans) {
        continue;
    }
    $plan_name         = $plans->subscription_name;
    $duration_string   = $plans->subscription_duration;
    preg_match('/(\d+)\s*(\w+)/', $duration_string, $matches);
    $interval = isset($matches[1]) ? (int)$matches[1] : 1;
    $unit     = isset($matches[2]) ? strtolower($matches[2]) : 'month';

    // Convert to days for recurring frequency
    switch ($unit) {
        case 'day':
        case 'days':
            $day_frequency = $interval;
            break;
        case 'week':
        case 'weeks':
            $day_frequency = $interval * 7;
            break;
        case 'month':
        case 'months':
            $day_frequency = $interval * 30;
            break;
        case 'year':
        case 'years':
            $day_frequency = $interval * 365;
            break;
        default:
            $day_frequency = 30; // fallback to 1 month
            break;
    }
  
        $recurring_billing = '1';
        $plan_amount       = $amount;
        $plan_payments     = '0'; // Infinite
        $plan_name         = $plan_name;
        $day_frequency     = $day_frequency;
 $card_number         = $user->card_number;
$exp_date = $user->exp_date; 
   $cvc         = $user->cvc;
  
 $regQuery = $this->User_model->query("SELECT sq_u_first_name, sq_u_last_name FROM `sq_users` WHERE sq_u_id = $user_id");
        $regData  = $regQuery->row();

        $first_name = $regData->sq_u_first_name ?? '';
        $last_name  = $regData->sq_u_last_name ?? '';

   $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);
 $result = $this->maverick_payment_gateway->doSale2($amount, $card_number, $exp_date, $cvc);



      // Evaluate response
         if (is_array($result) && $result['status'] == 'APPROVED') {
            $status = 'success';
            $message = 'Recurring payment approved.';
        } elseif ($result === DECLINED) {
            $status = 'failed';
            $message = 'Recurring payment declined.';
        } else {
            $status = 'failed';
            $message = 'Recurring payment failed (gateway error).';
        }

        // Log result
        log_message('error', "Recurring payment response for user_id $user_id: $message");

        // Save in payment history
        $this->User_model->insertdata('payment_history', [
            'user_id'       => $user_id,
            'email'         => $email,
            'payment_token' => $payment_token,
            'amount'        => $amount,
            'status'        => $status,
            'response'      => $message
        ]);

        // Update subscription
        if ($status === 'success') {
           $next_due_date = date('Y-m-d', strtotime("+$day_frequency days", strtotime($user->subscription_end_date)));
            $this->User_model->updatedata('sq_subscription_payment_details', ['sq_u_id_subscriber' => $user_id], [
                'subscription_start_date' => $user->subscription_end_date,
                'subscription_end_date'   => $next_due_date,
                'payment_status'          => '1',
                'response'=>json_encode($result['data'])
            ]);
        } else {
            // You may set to '0' here if you want to deactivate on failure
            $this->User_model->updatedata('sq_subscription_payment_details', ['sq_u_id_subscriber' => $user_id], [
                'payment_status' => '0',
                'response'=>json_encode($result['data'])
            ]);
        }
    }

  file_put_contents(FCPATH . 'cron_creditrepair_log.txt', date('Y-m-d H:i:s') . " - Cron ran\n", FILE_APPEND);

    echo "Recurring payment processing completed.";
}



}
