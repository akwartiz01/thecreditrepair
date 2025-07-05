<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Messages extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        error_reporting(0);

        $this->load->model('User_model');

        $this->load->library('session');

        $this->load->helper('url');

        $this->data['base_url'] = base_url();

        $this->data['user_id'] = $this->session->userdata('user_id');

        $this->data['type']  = $this->session->userdata('user_type');

        $this->load->model('AgreementModel');
        $this->load->library('TCPDF');

        if ($this->session->userdata('user_id') == '' || $this->session->userdata('user_type') != 'client' && $this->session->userdata('user_type') != 'super') {
            redirect(base_url());
            exit;
        }
    }

    public function get_messages_list()
    {

        $this->data['page'] = 'messages/secure_message_history';
        $this->data['theme']  = 'client';

        $user_id = $this->session->userdata('user_id');
        if ($this->session->userdata('user_type') == 'client' || $this->session->userdata('user_type') == 'super') {

            // Get messages involving the user (either as sender or receiver)
            $messages_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE (`recipient_type` ='admin' OR `recipient_type` ='client') AND (`sender_id` = '$user_id' OR `receiver_id` = '$user_id')");
            $messages_list = $messages_query->result();

            // Collect sender and receiver IDs
            $ids = [];
            foreach ($messages_list as $message) {
                if ($message->sender_id != $user_id) {
                    $ids[] = $message->sender_id; // Include sender if it's not the current user
                }
                if ($message->receiver_id != $user_id) {
                    $ids[] = $message->receiver_id; // Include receiver if it's not the current user
                }
            }

            // Get unique user IDs
            $ids = array_unique($ids);

            $user_result = [];
            if (!empty($ids)) {
                $ids_str = implode(',', $ids); // Convert IDs array to a comma-separated string
                $user_query = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_id` IN ($ids_str)");
                $user_result = $user_query->result();
            }
        }

        if ($this->session->userdata('user_type') == 'super') {

            $this->data['get_user_list'] = [];
        }
        $this->data['get_user_list'] = $user_result;
        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }



    public function send_new_messages()
    {
        $user_id = $this->session->userdata('user_id');
        $this->data['page'] = 'messages/send_secure_messages';
        $this->data['theme']  = 'client';
        $result = '';

        $fecth_data = $this->User_model->query("SELECT * FROM `sq_clients` WHERE `sq_client_id` = '$user_id'");
        $fetch_result = $fecth_data->result();

        $assigned_id = $fetch_result[0]->sq_assigned_to;

        if (!empty($assigned_id) && $assigned_id != 0) {

            $query = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_id` = '$assigned_id'");
            $result = $query->result();
        } else {
            $query = $this->User_model->query("SELECT * FROM `sq_users` WHERE `sq_u_type` = 'super' AND `sq_u_role` = '1'");
            $result = $query->result();
        }

        $this->data['team_member'] = $result;

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }


    public function send_message()
    {
        $user_id = $this->session->userdata('user_id');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $recipient_type = $this->input->post('recipient_type');
        $sq_u_id = $this->input->post('sq_u_id');
        $read_status = $this->input->post('read_status');

        // Handle profile image upload if a file is selected
        if (!empty($_FILES['attachment']['name'])) {
            $upload_dir = FCPATH . 'upload/secure_messages_attachment/client/' . $user_id;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|csv|xlsx';
            $config['max_size']      = 2048;
            $config['file_name']     = 'attachment_' . time();
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('attachment')) {
                $file_data = $this->upload->data();
                $attachment = base_url() . 'upload/secure_messages_attachment/client/' . $user_id . '/' . $file_data['file_name'];
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Unable to upload profile image. ' . $this->upload->display_errors()]);
                return;
            }
        }
        $data = [
            'subject' => $subject,
            'message' => $message,
            'recipient_type' => $recipient_type,
            'read_status' => 0,
            'sender_id' => $user_id,
            'receiver_id' => $sq_u_id,
            'attachment' => !empty($attachment) ? $attachment : NULL,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->User_model->insertdata('sq_secure_messages', $data);


        if ($read_status == 2) {
            $messages_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE (`recipient_type` = 'admin' OR `recipient_type` = 'client') AND (`sender_id` = '$user_id' OR `receiver_id` = '$user_id')");
            $messages_list = $messages_query->result();

            $ids = [];
            foreach ($messages_list as $message) {
                if ($message->sender_id != $user_id) {
                    $ids[] = $message->sender_id;
                }
                if ($message->receiver_id != $user_id) {
                    $ids[] = $message->receiver_id;
                }
            }

            $ids = array_unique($ids);

            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $this->User_model->query("UPDATE sq_secure_messages SET read_status = '1' WHERE sender_id = '$id'");
                }
            }
        }


        echo json_encode(['status' => 'success', 'message' => 'Your Message was sent.']);
    }


    public function get_messages_history()
    {
        $user_id = $this->session->userdata('user_id');
        $team_member_Id = $this->input->get('team_member_Id');
        $read_status = $this->input->get('read_status');

        $chat_history = $this->getMessagesHistory($user_id, $team_member_Id);

        if ($read_status == 1) {
            $update['read_status']    = 1;
            $where['receiver_id']    = $user_id;

            // $this->User_model->updatedata('sq_secure_messages', $where, $update);
            $this->User_model->query("UPDATE `sq_secure_messages` SET `read_status` = '1' WHERE `sender_id` = '$team_member_Id' AND `receiver_id` = '$user_id'");
        }

        echo json_encode($chat_history);
    }

    public function getMessagesHistory($user_id, $client_id)
    {
        $this->db->select('*');
        $this->db->from('sq_secure_messages');
        $this->db->where("(sender_id = $user_id AND receiver_id = $client_id) OR (sender_id = $client_id AND receiver_id = $user_id)");
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function delete_message()
    {
        $user_id = $this->session->userdata('user_id');
        $message_id = $this->input->post('message_id');

        $message = $this->get_message_by_id($message_id);

        if ($message && $message->recipient_type == 'admin') {

            $where['id'] = $message_id;
            $getData = $this->User_model->select_where('sq_secure_messages', $where);
            $result = $getData->row();

            if ($result && !empty($result->attachment)) {
                $existing_file_path = FCPATH . 'upload/secure_messages_attachment/client/' . $user_id . '/' . basename($result->attachment);
                if (file_exists($existing_file_path)) {

                    unlink($existing_file_path);
                }
            }

            $this->deleteMessage($message_id);
            echo json_encode(['status' => 'success', 'message' => 'Message deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'You are not authorized to delete this message']);
        }
    }

    public function get_message_by_id($message_id)
    {
        return $this->db->get_where('sq_secure_messages', ['id' => $message_id])->row();
    }

    public function deleteMessage($message_id)
    {
        $this->db->delete('sq_secure_messages', ['id' => $message_id]);
    }

    public function check_messages()
    {
        $team_member_Id = $this->input->post('team_member_Id');
        $user_id = $this->session->userdata('user_id');

        $messages_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE sender_id = '$user_id' AND receiver_id = '$team_member_Id' OR sender_id = '$team_member_Id' AND receiver_id = '$user_id'");
        $messages_list = $messages_query->result();

        if (empty($messages_list)) {
            echo json_encode(['status' => 'empty', 'message' => 'empty']);
        } else {
            echo json_encode(['status' => 'list', 'message' => 'list']);
        }
    }
}
