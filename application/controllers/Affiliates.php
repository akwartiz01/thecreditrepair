<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Affiliates extends MY_Controller
{

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

    $this->load->helper('url');
    $this->load->model('User_model');
    $this->load->library('encryption');
    $this->load->library('email');
    $this->load->library('form_validation');
  }

  public function removedata()
  {

    $id = $this->input->post('id');
    $where['sq_affiliates_id'] = $id;
    $this->User_model->delete('sq_affiliates', $where);
    echo '1';
  }

  public function affiliates()
  {
    error_reporting(0);
    if ($this->check_permisions("affiliate", "view") != 1) {
      return false;
    }
    $search = '';
    if ($this->input->get()) {
      if (!empty($this->input->get("aname"))) {
        $aname = $this->input->get("aname");
        $search .= " AND (sq_affiliates_first_name LIKE '%" . $aname . "%' OR sq_affiliates_last_name LIKE '%" . $aname . "%')";
      }
      if (!empty($this->input->get("aemail"))) {
        $aemail = $this->input->get("aemail");
        $search .= " AND sq_affiliates_email LIKE '%" . $aemail . "%'";
      }
      if (!empty($this->input->get("acompany"))) {
        $acompany = $this->input->get("acompany");
        $search .= " AND sq_affiliates_company LIKE '%" . $acompany . "%'";
      }
      if (!empty($this->input->get("qf")) || $this->input->get("qf") != '') {
        $qf = $this->input->get("qf");
        $search .= " AND sq_affiliates_status = '$qf'";
      }
    }

    $fetch_affiliates_data = $this->User_model->query("SELECT * FROM sq_affiliates WHERE sq_affiliates_email !='' $search");
    if ($fetch_affiliates_data->num_rows() > 0) {
      $data['affilates_data'] = $fetch_affiliates_data->result();
    } else {
      $data['affilates_data'] = '';
    }

    $data['myaffiliates'] = 'myaffiliates';
    $data['content'] = $this->load->view('affiliates/affiliates', $data, true);
    $this->load->view('template/template', $data);
  }

  public function get_all_affiliate_to_print()
  {
    $data = array();
    $html = '';
    $fetch_affiliates_data = $this->User_model->query("SELECT * FROM sq_affiliates");
    if ($fetch_affiliates_data->num_rows() > 0) {
      $data = $fetch_affiliates_data->result();
      $status = array(1 => "Active", 0 => "Inactive", 2 => "Pending");
      $html = '<table cellspacing="0" cellpadding="4" border="1" align="center" width="100%" id="printdata"> <tr>
        <th align="left" valign="middle">Affiliate Name</th>
        <th align="left" valign="middle">Company</th>
        <th align="left" valign="middle">Clients Referred</th>
        <th align="left" valign="middle">Email</th>
        <th align="left" valign="middle">Phone</th>
        <th align="left" valign="middle">Status</th>
    </tr>';
      foreach ($data as $data) {
        $name = ucwords($data->sq_affiliates_first_name) . " " . $data->sq_affiliates_last_name;
        $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $data->sq_affiliates_phone);
        $assigned_to_count = 0;
        if (isset($data->sq_affiliates_assigned_to)) {
          $assigned_to = unserialize($data->sq_affiliates_assigned_to);
          if (is_array($assigned_to)) {
            $assigned_to_count = count($assigned_to);
          }
        }

        // $html .= '<tr> 
        // <td align="left" valign="top">' . $name . ' developer</td>
        // <td align="left" valign="top">' . $data->sq_affiliates_company . '</td>
        // <td align="left" valign="top">' . $assigned_to_count . '</td>
        // <td align="left" valign="top">' . $data->sq_affiliates_email . '</td>
        // <td align="left" valign="top">' . $phone . '</td>
        // <td align="left" valign="top">' . $status[$data->sq_affiliates_status] . '</td></tr>';
        
        // ashok 
        $html .= '<tr> 
    <td align="left" valign="top">' . htmlspecialchars($name) . ' developer</td>
    <td align="left" valign="top">' . htmlspecialchars($data->sq_affiliates_company ?? 'N/A') . '</td>
    <td align="left" valign="top">' . htmlspecialchars($assigned_to_count) . '</td>
    <td align="left" valign="top">' . htmlspecialchars($data->sq_affiliates_email ?? 'N/A') . '</td>
    <td align="left" valign="top">' . htmlspecialchars($phone) . '</td>
    <td align="left" valign="top">' . 
        (isset($status[$data->sq_affiliates_status]) ? htmlspecialchars($status[$data->sq_affiliates_status]) : 'N/A') . 
    '</td>
</tr>';

      }
      $html .= "</table>";
    }
    echo $html;
  }

  public function import_affiliate_csv_from_anywhere()
  {
    if (isset($_POST['submit'])) {
      if ($_FILES['upload_csv']['name'] != '') {
        $filename = time() . ".csv";
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext == 'csv' || $ext == 'mer' || $ext == 'txt') {

          $path = 'affiliate/' . $filename;

          if (move_uploaded_file($_FILES['upload_csv']['tmp_name'], $path)) {
            $fileNames = base_url() . 'affiliate/' . $filename;
            $file = fopen($fileNames, "r");
            $count = 0;
            while (($milestone = fgetcsv($file, 10000, ",")) !== FALSE) {
              $count++;
              if ($count > 1) {
                if ($milestone[9] == 'Active') {
                  $status = 1;
                } elseif ($milestone[8] == "Pending") {
                  $status = 2;
                } else {
                  $status = 0;
                }
                $email = $milestone[3];
                $affiliates_data = array(
                  'sq_affiliates_first_name'                 =>   $milestone[0],
                  'sq_affiliates_last_name'                  =>   $milestone[1],
                  'sq_affiliates_company'                    =>   $milestone[2],
                  'sq_affiliates_email'                      =>   $email,
                  'sq_affiliates_phone'                      =>   $milestone[4],
                  'sq_affiliates_phone_ext'                  =>   $milestone[5],
                  'sq_affiliates_alternate_phone'            =>   $milestone[6],
                  'sq_affiliates_fax'                        =>   $milestone[7],
                  'sq_affiliates_gender'                     =>   $milestone[8] == "Female" ? 1 : 2,
                  'sq_affiliates_status'                     =>   $status,
                  'sq_affiliates_notes'                      =>   $milestone[11],
                  'sq_affiliates_mailing_address'            =>   $milestone[12],
                  'sq_affiliates_city'                       =>   $milestone[13],
                  'sq_affiliates_state'                      =>   $milestone[14],
                  'sq_affiliates_zip_code'                   =>   $milestone[15],
                  'sq_affiliates_country'                    =>   $milestone[16],
                  'sq_affiliates_website_url'                =>   $milestone[17],
                );


                $fetch_affiliates_data = $this->User_model->query("SELECT * FROM sq_affiliates WHERE sq_affiliates_email='$email'");
                if ($fetch_affiliates_data->num_rows() > 0) {
                  $this->User_model->updatedata('sq_affiliates', array('sq_affiliates_email' => $email), $affiliates_data);
                } else {
                  $this->User_model->insertdata('sq_affiliates', $affiliates_data);
                }
              }
            }
            $this->session->set_flashdata('success', 'All records Successfully uploaded.');
            redirect(base_url() . 'affiliates');
          }
        } else {
          $this->session->set_flashdata('error', 'Upload only csv files.');
          redirect(base_url() . 'affiliates');
        }
      }
    }
  }


//   public function export_affiliate_csv()
//   {
//     $records_list = '';
//     $fetch_affiliates_data = $this->User_model->query("SELECT * FROM sq_affiliates");
//     if ($fetch_affiliates_data->num_rows() > 0) {
//       $records = $fetch_affiliates_data->result();
//       foreach ($records as $record) {
//         $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $record->sq_affiliates_phone);
//         $alternate_phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $record->sq_affiliates_alternate_phone);
//         $created_at = date("d/m/Y", strtotime($record->sq_affiliates_created_at));
//         $gender = $record->sq_affiliates_gender == 1 ? "Female" : "Male";
//         $status = array(1 => "Active", 0 => "Inactive", 2 => "Pending");

//         $data[] = ucwords($record->sq_affiliates_first_name) . "," . ucwords($record->sq_affiliates_last_name) . "," .
//           ucwords($record->sq_affiliates_company) . "," .
//           $record->sq_affiliates_email . "," .
//           $phone . "," .
//           $record->sq_affiliates_phone_ext . "," .
//           $alternate_phone . "," .
//           $record->sq_affiliates_fax . "," .
//           ucwords($gender) . "," .
//           $status[$record->sq_affiliates_status] . "," .
//           $created_at . "," .
//           $record->sq_affiliates_notes . "," .
//           $record->sq_affiliates_mailing_address . "," .
//           $record->sq_affiliates_city . "," .
//           $record->sq_affiliates_state . "," .
//           $record->sq_affiliates_zip_code . "," .
//           $record->sq_affiliates_country . "," .
//           $record->sq_affiliates_website_url;
//       }
//       $records_list .= implode("\n", $data);
//     }

//     header('Content-type: text/csv');
//     header('Content-disposition: attachment;filename=my_affiliates_' . date("d-m-Y") . '.csv');
//     echo "First Name,Last Name,Company,Email,Phone,PhoneExt,Alternate Phone,Fax,Gender,Status,Register Date,Internal Note,Mailing Address,Mailing City,Mailing State,Mailing Zip,Mailing Country,Website URL" . PHP_EOL;

//     echo $records_list . PHP_EOL;
//   }

  public function export_affiliate_csv()
  {
    $records_list = '';
    $fetch_affiliates_data = $this->User_model->query("SELECT * FROM sq_affiliates");
    if ($fetch_affiliates_data->num_rows() > 0) {
      $records = $fetch_affiliates_data->result();
      foreach ($records as $record) {
        $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $record->sq_affiliates_phone);
        $alternate_phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $record->sq_affiliates_alternate_phone);
        $created_at = date("d/m/Y", strtotime($record->sq_affiliates_created_at));
        $gender = $record->sq_affiliates_gender == 1 ? "Female" : "Male";
        $status = array(1 => "Active", 0 => "Inactive", 2 => "Pending");
 $status_value = isset($status[$record->sq_affiliates_status]) ? $status[$record->sq_affiliates_status] : "Unknown";
        $data[] = ucwords($record->sq_affiliates_first_name) . "," . ucwords($record->sq_affiliates_last_name) . "," .
          ucwords($record->sq_affiliates_company) . "," .
          $record->sq_affiliates_email . "," .
          $phone . "," .
          $record->sq_affiliates_phone_ext . "," .
          $alternate_phone . "," .
          $record->sq_affiliates_fax . "," .
          ucwords($gender) . "," .
          $status_value . "," .     
          $record->sq_affiliates_mailing_address . "," .
          $record->sq_affiliates_city . "," .
          $record->sq_affiliates_state . "," .
          $record->sq_affiliates_zip_code . "," .
          $record->sq_affiliates_country . "," .
          $record->sq_affiliates_website_url;
      }


      $records_list .= implode("\n", $data);
    }

    header('Content-type: text/csv');
    header('Content-disposition: attachment;filename=my_affiliates_' . date("d-m-Y") . '.csv');
    echo "First Name,Last Name,Company,Email,Phone,PhoneExt,Alternate Phone,Fax,Gender,Status,Register Date,Internal Note,Mailing Address,Mailing City,Mailing State,Mailing Zip,Mailing Country,Website URL" . PHP_EOL;

    echo $records_list . PHP_EOL;
  }

  public function add_edit_affiliate_form($affiliate_id = '')
  {
    if (isset($_POST['affiliatesSubmitButton'])) {

      ////////////////////////   UPLOAD PROFILE PICTURE /////////////////////
      if ($_FILES['myfile']['name'] != '') {
        $config['upload_path'] = 'assets/upload/affiliates_pictures';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name'] = $_FILES['myfile']['name'];
        //Load upload library and initialize configuration
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('myfile')) {
          $current_date = date('Y-m-d H:i:s');
          $uploadData = $this->upload->data();
          $picture = base_url() . 'assets/upload/affiliates_pictures/' . $uploadData['file_name'];
        } else {
          $picture = '';
        }
      } else {
        $picture = '';
      }

      //////////////////////////UPLOAD AFFILIATES PICTURE ENDS///////////////////

      $portal = $this->input->post('portal_access');
      $email = $this->input->post('email');
      $firstname= $this->input->post('first_name');
          $first_letters = substr($firstname, 0, 3);
    $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
    $password_plain = $first_letters . $random_string;
    $encoded_password = base64_encode($password_plain);
      $affiliates_data = array(
        'sq_affiliates_first_name'                 =>   $this->input->post('first_name'),
        'sq_affiliates_last_name'                  =>   $this->input->post('last_name'),
        'sq_affiliates_gender'                     =>   $this->input->post('gender'),
        'sq_affiliates_company'                    =>   $this->input->post('company'),
        'sq_affiliates_website_url'                =>   $this->input->post('website_url'),
        'sq_affiliates_email'                      =>   $email,
        'sq_affiliates_password'                      =>   $encoded_password,
        'sq_affiliates_phone'                      =>   $this->input->post('phone'),
        'sq_affiliates_phone_ext'                      =>   $this->input->post('phone_ext'),
        'sq_affiliates_alternate_phone'            =>   $this->input->post('alternate_phone'),
        'sq_affiliates_fax'                        =>   $this->input->post('fax'),
        'sq_affiliates_mailing_address'            =>   $this->input->post('mailing_address'),
        'sq_affiliates_city'                       =>   $this->input->post('city'),
        'sq_affiliates_state'                      =>   $this->input->post('state'),
        'sq_affiliates_country'                    =>   $this->input->post('country'),
        'sq_affiliates_zip_code'                   =>   $this->input->post('zip_code'),
        'sq_affiliates_status'                     =>   $this->input->post('status'),
        'sq_affiliates_notes'                      =>   $this->input->post('notes'),
        'sq_affiliates_status'                     =>   $this->input->post('status'),
        'sq_affiliates_assigned_to'                =>   serialize($this->input->post('assigned_to')),
        'sq_affiliates_master_contact_list' =>   $this->input->post('master_contact_list'),
        'sq_affiliates_portal'                     =>   $portal,
      );

      if ($picture != '') {
        $affiliates_data['sq_affiliates_photo_url'] = $picture;
      }

      if (!empty($affiliate_id)) {
        $insertCompanyInfo = $this->User_model->updatedata('sq_affiliates', array('sq_affiliates_id' => $affiliate_id), $affiliates_data);
        $msg = 'Records Updated Successfully.';
      } else {
        $in = $this->User_model->query("SELECT * from sq_affiliates WHERE sq_affiliates_email='$email' LIMIT 1");
        if ($in->num_rows() > 0) {
          $this->session->set_flashdata('aff-insertion-error', "Email address already exists please try again.");
          redirect(base_url("new-affiliates"));
        }

        $insertCompanyInfo = $this->User_model->insertdata('sq_affiliates', $affiliates_data);
        $last_id = $this->db->insert_id();
        $msg = 'Records Added Successfully.';
      }

      if ($portal == 1 && $affiliate_id == '') {
        $this->send_login_email($last_id);
        $msg = 'Records Added Successfully and Login details sent.';
      }

      $this->session->set_flashdata('aff-insertion-success', $msg);
      $this->allActivity($msg); //track activity
    }
  }

  public function new_affiliates()
  {
    if ($this->check_permisions("affiliate", "add") != 1) {
      return false;
    }
    $this->add_edit_affiliate_form();
    $in = $this->User_model->query("SELECT sq_client_id,sq_first_name,sq_last_name from sq_clients");
    if ($in->num_rows() > 0) {
      $data['clients'] = $in->result();
    }

    $data['title'] = 'Add';
    $data['content'] = $this->load->view('affiliates/add_edit_affiliates', $data, true);
    $this->load->view('template/template', $data);
  }

  function edit_affiliates()
  {
    if ($this->check_permisions("affiliate", "edit") != 1) {
      return false;
    }
    $id = $this->uri->segment(2);
    $this->add_edit_affiliate_form($id);

    $in = $this->User_model->query("SELECT * from sq_affiliates WHERE sq_affiliates_id='$id' LIMIT 1");
    if ($in->num_rows() > 0) {
      $records = $in->result();
      $data['affiliate'] = $records[0];
      $data['title'] = 'Edit';
      $in = $this->User_model->query("SELECT sq_client_id,sq_first_name,sq_last_name from sq_clients");
      if ($in->num_rows() > 0) {
        $data['clients'] = $in->result();
      }
      $data['content'] = $this->load->view('affiliates/add_edit_affiliates', $data, true);
      $this->load->view('template/template', $data);
    }
  }

  function send_login_email($last_id)
  {
    $in = $this->User_model->query("SELECT * from sq_affiliates WHERE sq_affiliates_id='$last_id' LIMIT 1");
    if ($in->num_rows() > 0) {
      $records = $in->result();
      $id = $records[0]->sq_affiliates_id;
      $fname = $records[0]->sq_affiliates_first_name;
      $email = $records[0]->sq_affiliates_email;
      $password = $records[0]->sq_affiliates_password;

      $url = base_url("affiliates-password/" . get_encoded_id($id));
$logolink        = base_url() . 'assets/images/logo.png';
     
      if (!empty($password)) {
        $password = base64_decode($password);
        $msg = '<p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Visit: <a href="' . base_url("affiliate-login") . '" style="color:#0099ff" target="_blank">' . base_url("affiliate/login") . '</a>
                <br>User ID: <span style="color:#0099ff">' . $email . '</span>
                <br>Password: <span style="color:#0099ff">' . $password . '</span></p>';
      } else {
        $msg = ' <p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060"><a href="' . $url . '" style="background-color:#00a264;color:#ffffff;display:block;font-size:22px;padding:10px 40px;text-align:center;text-decoration:none;margin:20px 0;width:50%" target="_blank"><b>LOGIN NOW</b></a>';
      }

      $message = '<table style="width:100%" bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <br>
                <table style="width:600px" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="background:#fff;border:#f2f2f2 solid 1px;border-top:0px;padding:20px;font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;line-height:22px" align="left" valign="top">
                                <a href = "' . $url . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><br/><br><p style="font-family:Helvetica,Arial,sans-serif;font-size:18px;color:#606060"><b>Dear ' . ucwords($fname) . ',</b>
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
      $this->email->to(array($email));
      $this->email->subject('Login Credentials for Secure Affiliate Access');

      $this->email->message($message);
      $this->email->send();
    }
  }

  public function affiliates_password()
  {

    $id = $this->uri->segment(2);

    $data['affiliates'] = '';
    if (!empty($id)) {
      $ids = get_dencoded_id($id);
      $in = $this->User_model->query("SELECT * from sq_affiliates WHERE sq_affiliates_id='$ids' LIMIT 1");
      if ($in->num_rows() > 0) {
        $records = $in->result();
        $data['affiliates'] = $records[0];
        if ($this->input->post()) {
          $email = $this->input->post("email");
          $password = $this->input->post("password");
          $cpassword = $this->input->post("cpassword");
          $this->form_validation->set_rules('password', 'Password', 'required');
          $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
          if ($this->form_validation->run() != FALSE) {
            $password = base64_encode($password);
            //password_verify($password, $passwords);
            $update['sq_affiliates_password'] = $password;
            $this->User_model->updatedata('sq_affiliates', array('sq_affiliates_id' => $ids), $update);
            $this->session->set_userdata('affiliates_user_id', $ids);
            $this->session->set_userdata('affiliates_email', $records[0]->sq_affiliates_email);
            $this->session->set_userdata('affiliates_fname', $records[0]->sq_affiliates_first_name);
            redirect(base_url('affiliate/account'));
          }
        }
      }
    }
    $this->load->view('affiliates/affiliates_password', $data);
  }


  public function sendemailNotificationaff()
  {
    if (isset($_POST['send'])) {

      $affID   = $this->input->post('affID');
      $get_affiliate_info = $this->get_affiliate_info($affID);
      $subject    = $this->input->post('subject');
      $msg        = $this->input->post('msg');
      $email      = $get_affiliate_info[0]->sq_affiliates_email;

      $logolink =  base_url() . 'assets/images/logo.png';
      $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Email Notification</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 60px 20px 60px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $get_affiliate_info[0]->sq_affiliates_first_name . ' ' . $get_affiliate_info[0]->sq_affiliates_last_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;"><b>Subject:</b> ' . $subject . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;"><b>Message:</b> ' . $msg . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';


      $this->load->config('email_custom');
      $email_config = $this->config->item('email_config');

      $this->email->initialize($email_config);
      $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
      $this->email->to(array($email));
      $this->email->subject('Email Notification');

      $this->email->message($emailtemp);
      $this->email->send();

      $this->session->set_flashdata('successemail', 'Email Notification send to affiliates successfully');
      $this->allActivity('Email Notification send to Affiliates (' . $get_affiliate_info[0]->sq_affiliates_first_name . ' ' . $get_affiliate_info[0]->sq_affiliates_last_name . ') successfully!'); //track activity
      redirect(base_url() . 'affiliates');
    }
  }
  

}
