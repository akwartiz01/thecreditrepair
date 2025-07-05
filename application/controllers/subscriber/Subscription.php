<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/phpmailer/src/Exception.php';
require FCPATH . 'vendor/phpmailer/src/PHPMailer.php';
require FCPATH . 'vendor/phpmailer/src/SMTP.php';

class Subscription extends CI_Controller
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
    }

    public function main_page_test()
    {
        $data['plans'] = $this->db->where("status", 1)->get('sq_subscription_plans')->result_array();
        $this->load->view('main_page_test', $data);
    }

    public function registration()
    {
        $subscriptionId = $this->session->userdata('subscription_id');
        $price = $this->session->userdata('subscription_price');

        if ($subscriptionId && $price == '') {

            redirect(base_url());
        } else {

            $data['subscription_id'] = $subscriptionId;
            $data['subscription_price'] = $price;

            $data['plans'] = 'Testing';
            $this->load->view('home/registration', $data);
        }
    }

    public function subscribe()
    {
        $subscriptionId = $this->input->post('id');
        $price = $this->input->post('price');

        $this->session->set_userdata('subscription_id', $subscriptionId);
        $this->session->set_userdata('subscription_price', $price);

        echo json_encode(['status' => 'success']);
    }

    public function addSubscriber()
    {

        if ($this->input->post()) {
            $subscription_name = $this->input->post('subscription_name');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $subscription_duration = $this->input->post('subscription_duration');
            $subscription_price = $this->input->post('subscription_price');
            $team_member_permission = $this->input->post('team_member_permission');
            $clients_permission = $this->input->post('clients_permission');
            $data_storage = $this->input->post('data_storage');
            $payment_type = $this->input->post('payment_type');

            $data = [
                'subscription_name' => $subscription_name,
                'name' => $name,
                'email' => $email,
                'subscription_duration' => $subscription_duration,
                'subscription_price' => $subscription_price,
                'team_member_permission' => $team_member_permission,
                'clients_permission' => $clients_permission,
                'data_storage' => $data_storage,
                'payment_type' => $payment_type,
            ];

            $this->User_model->insertdata('sq_subscription', $data);
        }
    }

    public function get_user_details($email)
    {
        $fetch_email = $this->User_model->select_where('sq_users', array('sq_u_email_id' => $email));
        if ($fetch_email->num_rows() > 0) {
            $fetch_result = $fetch_email->result();
            return $fetch_result;
        }
        return null;
    }

    public function get_subscription_details($subscription_id)
    {
        $fetch_plans = $this->User_model->select_where('sq_subscription_plans', array('id' => $subscription_id));
        if ($fetch_plans->num_rows() > 0) {
            $fetch_result = $fetch_plans->result();
            return $fetch_result;
        }
        return null;
    }

    public function get_payment_details($email)
    {
        $fetch_plans = $this->User_model->select_where('sq_subscription_payment_details', array('sq_email' => $email));
        if ($fetch_plans->num_rows() > 0) {
            $fetch_result = $fetch_plans->result();
            return $fetch_result;
        }
        return null;
    }


    public function create_subscription()
    {
        $email = $this->input->post('email');
        $subscription_id = $this->input->post('subscription_id');

        $get_user = $this->get_user_details($email);
        $get_subscription_details = $this->get_subscription_details($subscription_id);
        $get_payment_details = $this->get_payment_details($email);

        if (!empty($get_user) && $get_payment_details[0]->payment_status == 1) {

            echo json_encode(array('subscribed' => 'You have already purchased a subscription.'));
        } else {
            $data = array(
                'sq_u_first_name' => $this->input->post('first_name'),
                'sq_u_last_name' => $this->input->post('last_name'),
                'subscriber_type' => 1,
                'sq_u_email_id' => $email,
                'sq_u_user_id' => $email,
                'sq_u_apassword' => $this->input->post('password'),
                'sq_u_password' => md5($this->input->post('password')),
                'sq_u_country' => $this->input->post('country'),
                'sq_u_subscription_plan_ID' => $subscription_id,
                'sq_u_type' => 3
            );

            if (!empty($get_user && $get_payment_details[0]->payment_status == 0)) {
                $subscription_data = array(
                    'sq_email' => $email,
                    'subscription_id' => $get_subscription_details[0]->id,
                    'team_permission' => $get_subscription_details[0]->team_permission,
                    'clients_permission' => $get_subscription_details[0]->clients_permission,
                    'subscription_price' => $get_subscription_details[0]->price,
                    'storage_permission' => 'Unlimited',
                    'payment_status' => 0,
                    'save_card' => 0
                );
                $this->User_model->updatedata('sq_users', array('sq_u_email_id' => $email), $data);
                $this->User_model->updatedata('sq_subscription_payment_details', array('sq_email' => $email), $subscription_data);
                echo json_encode(array('success' => 'This email is already exists.'));
            } else {
                $this->User_model->insertdata('sq_users', $data);
                $lastID = $this->db->insert_id();
                $subscription_data = array(
                    'sq_u_id_subscriber' => $lastID,
                    'sq_email' => $email,
                    'subscription_id' => $get_subscription_details[0]->id,
                    'team_permission' => $get_subscription_details[0]->team_permission,
                    'clients_permission' => $get_subscription_details[0]->clients_permission,
                    'subscription_price' => $get_subscription_details[0]->price,
                    'storage_permission' => 'Unlimited',
                    'payment_status' => 0,
                    'save_card' => 0
                );

                $this->User_model->insertdata('sq_subscription_payment_details', $subscription_data);
                if ($lastID) {
                    echo json_encode(array('success' => 'Registration completed successfully!', 'Success'));
                } else {
                    log_message('error', 'Database insert error: ' . $this->db->last_query());
                    echo json_encode(array('error' => 'Failed to add member.'));
                }
            }
        }
    }

    public function pay_now()
    {
        $amount = $this->input->post('amount');
        $ccnumber = $this->input->post('ccnumber');
        $ccexp = $this->input->post('ccexp');
        $cvv = $this->input->post('cvv');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $save_card = $this->input->post('save_card');
        $subscription_id = $this->input->post('subscription_id');

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        $plan_details = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE `id` = $subscription_id");
        $plan_details = $plan_details->result();

        $subscription_name = $plan_details[0]->subscription_name;
        $duration = $plan_details[0]->subscription_duration;
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
                'subscription_start_date' => $subscription_start_date,
                'subscription_end_date' => $subscription_end_date

            );
            $this->User_model->updatedata('sq_subscription_payment_details', array('sq_email' => $email), $data);
            $this->send_subscription_email($email, $amount, $subscription_name);
            $response = ['success' => true, 'message' => 'Your payment was successful!'];
        } elseif ($result == DECLINED) {
            $response = ['success' => false, 'message' => 'Your payment was declined. Please check your details or use a different card.'];
        } else {
            $response = ['success' => false, 'message' => 'An error occurred while processing your payment. Please try again later.'];
        }

        echo json_encode($response);
    }

    public function reccuring_payment()
    {
        $payment_details = $this->User_model->query("SELECT * FROM sq_subscription_payment_details");

        $details = $payment_details->result();

        $date = date("Y-m-d");
        $today_date = strtotime($date);

        if ($payment_details->num_rows() > 0) {

            foreach ($details as $key => $value) {

                if (!empty($value->subscription_start_date && $value->subscription_end_date)) {

                    $subscription_end_date = strtotime($value->subscription_end_date);
                    if ($today_date > $subscription_end_date) {

                        $plan_details_query = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE `id` = $value->subscription_id   AND `status` = 1");

                        $plan_details = $plan_details_query->result();

                        if ($plan_details_query->num_rows() > 0) {
                            $user_details = $this->User_model->query("SELECT * FROM sq_users WHERE `sq_u_email_id` = '" . $value->sq_email . "'");

                            $user_details = $user_details->result();

                            if ($plan_details[0]->fee_description == 'Trial') {

                                $query = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE (fee_description != 'Trial' OR fee_description IS NULL) ORDER BY id ASC LIMIT 1");
                                $personal_plan = $query->result();

                                $subscription_id = $personal_plan[0]->id;

                                $trial_to_personal = $this->User_model->query("SELECT * FROM sq_subscription_plans WHERE `id` = $subscription_id AND `status` = 1");

                                $trial_to_personal = $trial_to_personal->result();
                                $subscription_name = $trial_to_personal[0]->subscription_name;
                                $amount = $trial_to_personal[0]->price;
                                $duration = $trial_to_personal[0]->subscription_duration;
                                $subscription_Id = $trial_to_personal[0]->id;
                                $team_permission = $trial_to_personal[0]->team_permission;
                                $clients_permission = $trial_to_personal[0]->clients_permission;
                                $subscription_price = $trial_to_personal[0]->price;
                            } else {

                                $subscription_name = $plan_details[0]->subscription_name;
                                $amount = $plan_details[0]->price;
                                $duration = $plan_details[0]->subscription_duration;
                                $subscription_Id = $value->subscription_id;
                                $team_permission = $plan_details[0]->team_permission;
                                $clients_permission = $plan_details[0]->clients_permission;
                                $subscription_price = $plan_details[0]->price;
                            }
                            $ccnumber = $value->card_number;
                            $ccexp = $value->exp_date;
                            $cvv = $value->cvc;
                            $save_card = $value->save_card;
                            $first_name = $user_details[0]->sq_u_first_name;
                            $last_name = $user_details[0]->sq_u_last_name;
                            $email = $user_details[0]->sq_u_email_id;

                            $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
                            $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
                            $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

                            // $result = $this->gwapi->doRecurring(1.00,"4111111111111111","1025","999","add_subscription",1.00,12,"Monthly Plan",30);

                            $result = $this->maverick_payment_gateway->doRecurring($amount, $ccnumber, $ccexp, $cvv, "add_subscription", $amount, 12, "Monthly Plan", 30);

                            $subscription_start_date = date("Y-m-d");
                            $subscription_end_date = date("Y-m-d", strtotime("+$duration"));

                            if ($result == APPROVED) {
                                $data = array(
                                    'payment_status' => 1,
                                    'card_number' => $ccnumber,
                                    'exp_date' => $ccexp,
                                    'cvc' => $cvv,
                                    'save_card' => $save_card,
                                    'subscription_id' => $subscription_Id,
                                    'team_permission' => $team_permission,
                                    'clients_permission' => $clients_permission,
                                    'subscription_price' => $subscription_price,
                                    'subscription_start_date' => $subscription_start_date,
                                    'subscription_end_date' => $subscription_end_date
                                );
                                $this->User_model->updatedata('sq_subscription_payment_details', array('sq_email' => $email), $data);
                                $this->send_reccuring_email($email, $amount, $subscription_name);
                                $response = ['success' => true, 'message' => 'Your payment was successful!'];
                            } elseif ($result == DECLINED) {

                                $data = array(
                                    'payment_status' => 0,
                                );

                                $this->User_model->updatedata('sq_subscription_payment_details', array('sq_email' => $email), $data);
                                $response = ['success' => false, 'message' => 'Declined!'];
                            } else {
                                $response = ['success' => false, 'message' => 'Error!'];
                            }
                        }
                        echo json_encode($response);
                    }
                }
            }
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
                </td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 50px 20px 50px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($fname) . ' ' . $lname . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">We are excited to let you know that your subscription of <b>$' . $amount . '</b> for <b>' . $subscription_name . '</b> has been successfully done!</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Here are your login details for CRX Credit Repair:</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $username . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $password . '</td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely, and monitor your overall progress.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                $this->load->config('email_custom');
                $email_config = $this->config->item('email_config');
          
                $this->email->initialize($email_config);
                $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
                $this->email->to($email_address);
                $this->email->subject('Registration');
          
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
    public function send_reccuring_email($email, $amount, $subscription_name)
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
                $site_link       = base_url('sign-in');

                $password_message = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 550px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #3972FC;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>Recurring Payment</b></td></tr><tr><td style="padding-top: 20px;"><a href = "' . $site_link . '"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"></a><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="border-radius: 10px;background: #fff;padding: 30px 50px 20px 50px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"><b>Dear ' . ucwords($fname) . ' ' . $lname . ',</b></p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">We are excited to let you know that your subscription of <b>$' . $amount . '</b> for <b>' . $subscription_name . '</b> has been successfully renewed!</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Here are your login details for CRX Credit Repair:</p><table style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060;margin-top:10px;"><tr><td style="padding-right: 10px;"><b>Username:</b></td><td>' . $username . '</td></tr><tr><td style="padding-right: 10px;"><b>Password:</b></td><td>' . $password . '</td></tr></table><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">From there, you can access your account, review activity, exchange documents securely, and monitor your overall progress.</p><p style="font-family:Helvetica,Arial,sans-serif;font-size:15px;color:#606060">Sincerely,<br> CRX Credit Repair Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;">Copyright &copy; ' . date('Y') . ' CRX Credit Repair. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';


                $this->load->config('email_custom');
                $email_config = $this->config->item('email_config');
          
                $this->email->initialize($email_config);
                $this->email->from('noreply@thecreditrepairxperts.com', 'CRX Credit Repair');
                $this->email->to($email_address);
                $this->email->subject('Reccuring Payment');
          
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

    function get_date()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $timestamp = $date->format('Y-m-d H:i:s');
        return $timestamp;
    }

    function credit_monitoring_payment_link()
    {
        $url_data = $this->uri->segment(2);

        if ($url_data != '') {
            $security_code['security_code'] = $url_data;
            $fetch_client_data = $this->User_model->select_where('sq_subscriber_clients', $security_code);
            if ($fetch_client_data->num_rows() > 0) {

                $fetch_client_data = $fetch_client_data->result();
                $sq_client_id  = $fetch_client_data[0]->sq_client_id;

                $data['sq_first_name']  = $fetch_client_data[0]->sq_first_name;
                $data['sq_last_name']  = $fetch_client_data[0]->sq_last_name;
                $data['sq_email']  = $fetch_client_data[0]->sq_email;

                $security_code_time = $fetch_client_data[0]->security_code_time;
                // $current_time =  $this->get_date();
                $current_time =  date('Y-m-d H:i:s');
                $code_time = strtotime($security_code_time);
                $now_time = strtotime($current_time);
                $check_security_code_time = round(abs($code_time - $now_time) / 60, 2);

                if ($check_security_code_time < 10) {
                    $data['sq_client_id'] = $sq_client_id;
                    $this->load->view('subscriber/credit_monitoring_payment/credit_monitoring_payment', $data);
                } else {
                    $this->session->set_flashdata('error', 'Link expired.');
                    $data['sq_client_id'] = "";
                    redirect(base_url());
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid security code.');
                $data['sq_client_id'] = "";
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('error', 'No security code provided.');
            $data['sq_client_id'] = "";
            redirect(base_url());
        }
    }

    public function credit_monitoring_payment()
    {
        $amount = $this->input->post('amount');
        $ccnumber = $this->input->post('ccnumber');
        $ccexp = $this->input->post('ccexp');
        $cvv = $this->input->post('cvv');
        // $save_card = $this->input->post('save_card');
        $save_card = 1;

        $first_name = $this->input->post('sq_first_name');
        $last_name = $this->input->post('sq_last_name');
        $email = $this->input->post('sq_email');

        $this->maverick_payment_gateway->setLogin("62tn2HhS7vH8FyW3Jb7YhjvjdGjQ6T7p");
        $this->maverick_payment_gateway->setBilling($first_name, $last_name, $email);
        $this->maverick_payment_gateway->setShipping($first_name, $last_name, $email);

        $subscription_name = 'Credit Monitoring';
        $duration = '1 Month';
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
                'sq_email' => $email,
                'subscription_price' => $amount,
                'subscription_start_date' => $subscription_start_date,
                'subscription_end_date' => $subscription_end_date

            );
            $this->User_model->insertdata('sq_subscription_payment_details', $data);
            // $this->send_subscription_email($email, $amount, $subscription_name);
            $response = ['success' => true, 'message' => 'Your payment was successful!'];
        } elseif ($result == DECLINED) {
            $response = ['success' => false, 'message' => 'Declined!'];
        } else {
            $response = ['success' => false, 'message' => 'Error!'];
        }

        echo json_encode($response);
    }

    public function get_letters()
    {

        // $trial_to_personal = $this->User_model->query("SELECT * FROM sq_letters WHERE `id` = $subscription_id AND `status` = 1");
        $letters = $this->User_model->query("SELECT * FROM sq_letters");

        $letters = $letters->result();

        echo "<pre>";
        print_r($letters);
        echo "</pre>";
        die('STOP');
    }
}
