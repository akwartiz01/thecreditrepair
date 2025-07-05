<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auto_email_cronjob extends CI_Controller
{

    function __construct()
    {

        parent::__construct();

        if ($this->session->userdata('user_type') == 'client') {
            redirect(base_url('client/dashboard'));
            exit;
        }

        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('email');
    }

    public function Sent_auto_email_to_clients()
    {

        $CronTemp = $this->CronAutoEmailTempss();

        $where['sq_status'] = 4;
        $fetchClients = $this->User_model->select_where('sq_clients', $where);
        if ($fetchClients->num_rows() > 0) {
            $fetchClients = $fetchClients->result();
            foreach ($fetchClients as $key => $value) {

                $ClientStartDate = $value->sq_date_of_start;
                $CurrentDate = date('Y-m-d');

                $afterTenDays = date('Y-m-d', strtotime($ClientStartDate . ' +10 day'));
                if (strtotime($CurrentDate) == strtotime($afterTenDays)) {

                    $getSentTemplate = $this->getSentTemplate();
                    if (isset($getSentTemplate[5][$value->sq_client_id]) != 1) {

                        foreach ($CronTemp[1] as $k => $v) {

                            if ($v->id == 5) {

                                $logolink = base_url() . 'assets/images/logo.png';
                                $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                $this->load->config('email_custom');
                                $email_config = $this->config->item('email_config');

                                $this->email->initialize($email_config);
                                $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                $this->email->to(array($value->sq_email));
                                $this->email->subject($v->temp_name);

                                $this->email->message($emailtemp);
                                $this->email->send();

                                $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                            }
                        }
                    }
                }
                //=========== 10 Days email Phase 1 ===============//

                //=========== 20 Days email Phase 1 ===============//
                $afterTwentyDays = date('Y-m-d', strtotime($ClientStartDate . ' +20 day'));
                if (strtotime($CurrentDate) == strtotime($afterTwentyDays)) {

                    $getSentTemplate = $this->getSentTemplate();
                    if (isset($getSentTemplate[4][$value->sq_client_id]) != 1) {  //20 days temp sent or not...

                        foreach ($CronTemp[1] as $k => $v) {
                            //sent 20 days phase 1 email to client
                            if ($v->id == 4) {

                                //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                $logolink = base_url() . 'assets/images/logo.png';
                                $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                $this->load->config('email_custom');
                                $email_config = $this->config->item('email_config');

                                $this->email->initialize($email_config);
                                $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                $this->email->to(array($value->sq_email));
                                $this->email->subject($v->temp_name);

                                $this->email->message($emailtemp);
                                $this->email->send();


                                $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                            }
                        }
                    }
                }
                //=========== 20 Days email Phase 1 ===============//

                //=========== 30 Days email Phase 1 ===============//
                $afterThirtyDays = date('Y-m-d', strtotime($ClientStartDate . ' +30 day'));
                if (strtotime($CurrentDate) == strtotime($afterThirtyDays)) {

                    $getSentTemplate = $this->getSentTemplate();
                    if (isset($getSentTemplate[6][$value->sq_client_id]) != 1) {  //30 days temp sent or not...

                        foreach ($CronTemp[1] as $k => $v) {
                            //sent 30 days phase 1 email to client
                            if ($v->id == 6) {

                                //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                $logolink = base_url() . 'assets/images/logo.png';
                                $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';


                                $this->load->config('email_custom');
                                $email_config = $this->config->item('email_config');

                                $this->email->initialize($email_config);
                                $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                $this->email->to(array($value->sq_email));
                                $this->email->subject($v->temp_name);

                                $this->email->message($emailtemp);
                                $this->email->send();

                                $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                            }
                        }
                    }
                }
                //=========== 30 Days email Phase 1 ===============//

                //=========== 10 Days email Phase 2 ===============//
                $afterTenDayst = date('Y-m-d', strtotime($ClientStartDate . ' +41 day'));
                if (strtotime($CurrentDate) == strtotime($afterTenDayst)) {

                    $getSentTemplate = $this->getSentTemplate();
                    if (isset($getSentTemplate[7][$value->sq_client_id]) != 1) {  //10 days temp sent or not...

                        foreach ($CronTemp[1] as $k => $v) {
                            //sent 10 days phase 2 email to client
                            if ($v->id == 7) {

                                //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                $logolink = base_url() . 'assets/images/logo.png';
                                $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                $this->load->config('email_custom');
                                $email_config = $this->config->item('email_config');

                                $this->email->initialize($email_config);
                                $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                $this->email->to(array($value->sq_email));
                                $this->email->subject($v->temp_name);

                                $this->email->message($emailtemp);
                                $this->email->send();

                                $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                            }
                        }
                    }
                }
                //=========== 10 Days email Phase 2 ===============//

                //=========== 20 Days email Phase 2 ===============//
                $afterTwentyDayst = date('Y-m-d', strtotime($ClientStartDate . ' +51 day'));
                if (strtotime($CurrentDate) == strtotime($afterTwentyDayst)) {

                    $getSentTemplate = $this->getSentTemplate();
                    if (isset($getSentTemplate[9][$value->sq_client_id]) != 1) {  //20 days temp sent or not...

                        foreach ($CronTemp[1] as $k => $v) {
                            //sent 20 days phase 2 email to client
                            if ($v->id == 9) {

                                //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                $logolink = base_url() . 'assets/images/logo.png';
                                $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                $this->load->config('email_custom');
                                $email_config = $this->config->item('email_config');

                                $this->email->initialize($email_config);
                                $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                $this->email->to(array($value->sq_email));
                                $this->email->subject($v->temp_name);
                                $this->email->message($emailtemp);
                                $this->email->send();

                                $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                            }
                        }
                    }
                }
                //=========== 20 Days email Phase 2 ===============//

                //=========== 30 Days email Phase 2 ===============//
                $afterThirtyDayst = date('Y-m-d', strtotime($ClientStartDate . ' +61 day'));
                if (strtotime($CurrentDate) == strtotime($afterThirtyDayst)) {

                    $getSentTemplate = $this->getSentTemplate();
                    if (isset($getSentTemplate[8][$value->sq_client_id]) != 1) {  //30 days temp sent or not...

                        foreach ($CronTemp[1] as $k => $v) {
                            //sent 30 days phase 2 email to client
                            if ($v->id == 8) {

                                //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                $logolink = base_url() . 'assets/images/logo.png';
                                $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                $this->load->config('email_custom');
                                $email_config = $this->config->item('email_config');

                                $this->email->initialize($email_config);
                                $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                $this->email->to(array($value->sq_email));
                                $this->email->subject($v->temp_name);

                                $this->email->message($emailtemp);
                                $this->email->send();

                                //mark as sent
                                $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                            }
                        }
                    }
                }
                //=========== 30 Days email Phase 2 ===============//

                //check client those are only in 90 days...
                //send more auto email if 180 days or month to month...
                if ($value->client_days == 1) {
                    //nothing to do...
                } else {

                    //=========== 10 Days email Phase 3 ===============//
                    $afterTenDaystt = date('Y-m-d', strtotime($ClientStartDate . ' +71 day'));
                    if (strtotime($CurrentDate) == strtotime($afterTenDaystt)) {

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[14][$value->sq_client_id]) != 1) {  //10 days temp sent or not...

                            foreach ($CronTemp[1] as $k => $v) {
                                //sent 10 days phase 3 email to client
                                if ($v->id == 14) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 10 Days email Phase 3 ===============//

                    //=========== 20 Days email Phase 3 ===============//
                    $afterTwentyDaystt = date('Y-m-d', strtotime($ClientStartDate . ' +81 day'));
                    if (strtotime($CurrentDate) == strtotime($afterTwentyDaystt)) {

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[16][$value->sq_client_id]) != 1) {  //20 days temp sent or not...

                            foreach ($CronTemp[1] as $k => $v) {
                                //sent 20 days phase 3 email to client
                                if ($v->id == 16) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 20 Days email Phase 3 ===============//

                    //=========== 30 Days email Phase 3 ===============//
                    $afterThirtyDaystt = date('Y-m-d', strtotime($ClientStartDate . ' +91 day'));
                    if (strtotime($CurrentDate) == strtotime($afterThirtyDaystt)) {

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[18][$value->sq_client_id]) != 1) {  //30 days temp sent or not...

                            foreach ($CronTemp[1] as $k => $v) {
                                //sent 30 days phase 3 email to client
                                if ($v->id == 18) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 30 Days email Phase 3 ===============//

                    //=========== 10 Days email Phase 4 ===============//
                    $afterTenDaysttt = date('Y-m-d', strtotime($ClientStartDate . ' +101 day'));
                    if (strtotime($CurrentDate) == strtotime($afterTenDaysttt)) {

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[15][$value->sq_client_id]) != 1) {  //10 days temp sent or not...

                            foreach ($CronTemp[1] as $k => $v) {
                                //sent 10 days phase 4 email to client
                                if ($v->id == 15) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 10 Days email Phase 4 ===============//

                    //=========== 20 Days email Phase 4 ===============//
                    $afterTwentyDaysttt = date('Y-m-d', strtotime($ClientStartDate . ' +111 day'));
                    if (strtotime($CurrentDate) == strtotime($afterTwentyDaysttt)) {

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[17][$value->sq_client_id]) != 1) {  //20 days temp sent or not...

                            foreach ($CronTemp[1] as $k => $v) {
                                //sent 20 days phase 4 email to client
                                if ($v->id == 17) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 20 Days email Phase 4 ===============//

                    //=========== 30 Days email Phase 4 ===============//
                    $afterThirtyDaysttt = date('Y-m-d', strtotime($ClientStartDate . ' +121 day'));
                    if (strtotime($CurrentDate) == strtotime($afterThirtyDaysttt)) {

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[19][$value->sq_client_id]) != 1) {  //30 days temp sent or not...

                            foreach ($CronTemp[1] as $k => $v) {
                                //sent 30 days phase 4 email to client
                                if ($v->id == 19) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $value->sq_first_name . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . nl2br($v->temp_text) . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 30 Days email Phase 4 ===============//

                } //end else part

            }
        }
    }


    //curl --silent https://creditfortress.org/Auto_email_cronjob/Sent_auto_email_to_affiliates

    public function Sent_auto_email_to_affiliates()
    {

        $CronTemp = $this->CronAutoEmailTempss();
        $affiliate_email = $this->get_allaffiliate_Email();
        $affiliate_name = $this->get_allaffiliate_name();

        $where['sq_status'] = 4;
        $fetchClients = $this->User_model->select_where('sq_clients', $where);
        if ($fetchClients->num_rows() > 0) {
            $fetchClients = $fetchClients->result();

            foreach ($fetchClients as $key => $value) {

                $clientname = $value->sq_first_name . ' ' . $value->sq_last_name;

                $ClientStartDate = $value->sq_date_of_start;
                $CurrentDate = date('Y-m-d');

                $sq_referred_by = $value->sq_referred_by;
                if ($sq_referred_by > 0) {

                    $emailSentto = $affiliate_email[$sq_referred_by];
                    $affiliateName = $affiliate_name[$sq_referred_by];
                    //echo $emailSentto.'<br>';

                    //=========== 15 Days email ===============//
                    $afterFifteenDays = date('Y-m-d', strtotime($ClientStartDate . ' +15 day'));
                    if (strtotime($CurrentDate) == strtotime($afterFifteenDays)) {

                        //echo $emailSentto.' 15';

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[10][$value->sq_client_id]) != 1) {  //10 days temp sent or not...

                            foreach ($CronTemp[2] as $k => $v) {
                                //sent 10 days email to client
                                if ($v->id == 10) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $replaceContent15 = str_replace('{Client_name}', $clientname, nl2br($v->temp_text));

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $affiliateName . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . $replaceContent15 . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 15 Days email ===============//

                    //=========== 30 Days email ===============//
                    $afterThirtyDays = date('Y-m-d', strtotime($ClientStartDate . ' +30 day'));
                    if (strtotime($CurrentDate) == strtotime($afterThirtyDays)) {

                        //echo $emailSentto.' 30';

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[12][$value->sq_client_id]) != 1) {  //30 days temp sent or not...

                            foreach ($CronTemp[2] as $k => $v) {
                                //sent 30 days email to client
                                if ($v->id == 12) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';

                                    $replaceContent30 = str_replace('{Client_name}', $clientname, nl2br($v->temp_text));

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $affiliateName . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . $replaceContent30 . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 30 Days email ===============//

                    //=========== 15 Days email Phase 2 ===============//
                    $afterFifteenDayst = date('Y-m-d', strtotime($ClientStartDate . ' +45 day'));
                    if (strtotime($CurrentDate) == strtotime($afterFifteenDayst)) {

                        //echo $emailSentto.' 45';

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[11][$value->sq_client_id]) != 1) {  //15 days temp sent or not...

                            foreach ($CronTemp[2] as $k => $v) {
                                //sent 15 days phase 2 email to client
                                if ($v->id == 11) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';
                                    $replaceContent152 = str_replace('{Client_name}', $clientname, nl2br($v->temp_text));

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $affiliateName . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . $replaceContent152 . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 15 Days email Phase 2 ===============//

                    //=========== 30 Days email Phase 2 ===============//
                    $afterThirtyDaysta = date('Y-m-d', strtotime($ClientStartDate . ' +60 day'));
                    if (strtotime($CurrentDate) == strtotime($afterThirtyDaysta)) {

                        //echo $emailSentto.' 60';

                        $getSentTemplate = $this->getSentTemplate();
                        if (isset($getSentTemplate[13][$value->sq_client_id]) != 1) {  //30 days temp sent or not...

                            foreach ($CronTemp[2] as $k => $v) {
                                //sent 30 days Phase 2 email to client
                                if ($v->id == 13) {

                                    //echo $value->sq_client_id.' = '.$v->id.'<br>';
                                    $replaceContent302 = str_replace('{Client_name}', $clientname, nl2br($v->temp_text));

                                    $logolink = base_url() . 'assets/images/logo.png';
                                    $emailtemp = '<div class="table-responsive mb-4"><table style="background:#f3f3f3; width:100%;height: 100%;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding: 50px;"><table style="width: 680px;margin: 0 auto" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="border-bottom:1px dashed #000; background: #ed1c24;"><td style="width: 175px;height: 20px;font-family: Roboto;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 1.11;letter-spacing: normal;text-align: center;color: #fff;padding: 10px;"><b>' . $v->temp_name . '</b></td></tr><tr><td style="padding-top: 20px;"><img style="float:left;width:100px;" src="' . $logolink . '" alt="Logo"><p style="font-family: Roboto;font-size: 13px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color:#bbb;float:right;margin-top: 10px;">&nbsp;</p></td></tr><tr><td style="background: #f3f3f3;padding: 10px 40px 20px 40px;margin-top: 10px;display: block;"><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 10px;"> Hi ' . $affiliateName . ',</p><p style="font-family: Roboto;font-size: 14px;font-weight: normal;font-style:normal;font-stretch: normal;line-height: 1.71;letter-spacing: normal;color: #001737;margin-bottom: 0px;">' . $replaceContent302 . '</p><p style="font-family: Roboto;font-size: 14px;font-weight: 500;font-style: normal;font-stretch: normal;line-height: 2.5;letter-spacing: normal;color: #001737;margin-bottom: 0px;"> The Credit Repair Xperts Team</p></td></tr></tbody></table><table style="margin: 20px auto 10px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Roboto;font-size: 12px;font-weight: normal;font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;color: #001737;"> Copyright © ' . date('Y') . ' The Credit Repair Xperts. All rights reserved.</td></tr></tbody></table></td></tr></tbody></table></div>';

                                    $this->load->config('email_custom');
                                    $email_config = $this->config->item('email_config');

                                    $this->email->initialize($email_config);
                                    $this->email->from('noreply@thecreditrepairxperts.com', 'The Credit Repair Xperts');
                                    $this->email->to(array($value->sq_email));
                                    $this->email->subject($v->temp_name);

                                    $this->email->message($emailtemp);
                                    $this->email->send();

                                    //mark as sent
                                    $this->User_model->query("INSERT INTO sq_auto_email_sentto_client (client_id, template_id, status, `datetime`) VALUES ('" . $value->sq_client_id . "', '" . $v->id . "', '1', '" . date('Y-m-d H:i:s') . "')");
                                }
                            }
                        }
                    }
                    //=========== 30 Days email Phase 2 ===============//

                }
            }
        }
    }

    //curl --silent https://creditfortress.org/Auto_email_cronjob/testEmail
    public function testEmail()
    {

        $this->email->from(auto_email_from(), 'creditfortress.org');
        $this->email->to('pankaj.wartiz@gmail.com');
        $this->email->subject('Forgot Password');
        $this->email->message('<p>this is email test</p><h1>test</h1>');
        $this->email->set_mailtype('html');
        $this->email->send();
    }


    //================ Common functions ==============//
    public function CronAutoEmailTempss()
    {

        $data = array();
        $fetch_etemp = $this->User_model->select_star('sq_auto_email_templates');
        $fetch_etemp = $fetch_etemp->result();
        foreach ($fetch_etemp as $key => $value) {
            $data[$value->temp_for][] = $value;
        }
        return $data;
    }

    public function getSentTemplate()
    {

        $data = array();
        $fetch_senttemp = $this->User_model->select_star('sq_auto_email_sentto_client');
        $fetch_senttemp = $fetch_senttemp->result();
        foreach ($fetch_senttemp as $key => $value) {
            $data[$value->template_id][$value->client_id] = $value->status;
        }
        return $data;
    }

    public function get_allaffiliate_Email()
    {
        $datas = array();
        $fetch_sq_affiliates = $this->User_model->query("SELECT * FROM `sq_affiliates` WHERE sq_affiliates_status = '1'");
        $fetch_sq_affiliates = $fetch_sq_affiliates->result();
        foreach ($fetch_sq_affiliates as $value) {
            $datas[$value->sq_affiliates_id] = $value->sq_affiliates_email;
        }
        return $datas;
    }

    public function get_allaffiliate_name()
    {
        $datas = array();
        $fetch_sq_affiliates = $this->User_model->query("SELECT * FROM `sq_affiliates`");
        $fetch_sq_affiliates = $fetch_sq_affiliates->result();
        foreach ($fetch_sq_affiliates as $value) {
            $datas[$value->sq_affiliates_id] = $value->sq_affiliates_first_name;
        }
        return $datas;
    }

    //================ Common functions ==============//

}
