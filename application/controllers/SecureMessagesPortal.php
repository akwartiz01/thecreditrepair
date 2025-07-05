<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SecureMessagesPortal extends CI_Controller
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

        // if ($this->session->userdata('user_type') == 'subscriber') {
        //     redirect(base_url('subscriber/dashboard'));
        //     exit;
        // }

        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->load->library('email');
    }

    public function send_secure_messages()
    {

        $this->data['page'] = 'messages/send_secure_messages';
        $this->data['theme']  = 'template';

        $uri_segment = $this->uri->segment(3);
        $client_id = get_dencoded_id($uri_segment);
        $this->data['clientid']   = $client_id;

        $clients_query = $this->User_model->query("SELECT * FROM `sq_clients` ORDER BY sq_client_id ASC");
        $clients_result = $clients_query->result();

        // $client_notes_query = $this->User_model->query("SELECT * FROM sq_client_notes WHERE client_id='$client_id'");
        $client_notes_query = $this->User_model->query("SELECT * FROM sq_quick_notes");
        $client_notes_result = $client_notes_query->result();

        $this->data['clients'] = $clients_result;
        $this->data['client_notes'] = $client_notes_result;
        $this->load->vars($this->data);

        $this->load->view('template');
    }

    public function send_new_messages()
    {

        $this->data['page'] = 'messages/send_secure_messages';
        $this->data['theme']  = 'template';

        $clients_query = $this->User_model->query("SELECT * FROM `sq_clients` ORDER BY sq_client_id ASC");
        $clients_result = $clients_query->result();

        $client_notes_query = $this->User_model->query("SELECT * FROM sq_quick_notes");
        $client_notes_result = $client_notes_query->result();

        $this->data['clients'] = $clients_result;
        $this->data['client_notes'] = $client_notes_result;
        $this->load->vars($this->data);

        $this->load->view('template');
    }


    public function send_message()
    {

        $user_id = $this->session->userdata('user_id');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $recipient_type = $this->input->post('recipient_type');
        $client_id = $this->input->post('client_id');
        $read_status = $this->input->post('read_status');

        if (!empty($_FILES['attachment']['name'])) {
            $upload_dir = FCPATH . 'upload/secure_messages_attachment/team_members/' . $user_id;
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
                $attachment = base_url() . 'upload/secure_messages_attachment/team_members/' . $user_id . '/' . $file_data['file_name'];
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
            'receiver_id' => $client_id,
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

    public function get_messages_list()
    {

        $this->data['page'] = 'messages/secure_message_history';
        $this->data['theme']  = 'template';

        $user_id = $this->session->userdata('user_id');
        if ($this->session->userdata('user_type') != 'client') {

            $messages_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE (`recipient_type` ='admin' OR `recipient_type` ='client') AND (`sender_id` = '$user_id' OR `receiver_id` = '$user_id')");
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

            $client_result = [];
            if (!empty($ids)) {
                $ids_str = implode(',', $ids);
                $client_query = $this->User_model->query("SELECT * FROM `sq_clients` WHERE `sq_client_id` IN ($ids_str)");
                $client_result = $client_query->result();
            }
        }

        $client_notes_query = $this->User_model->query("SELECT * FROM sq_quick_notes");
        $client_notes_result = $client_notes_query->result();

        $this->data['client_notes'] = $client_notes_result;
        $this->data['client_messages_list'] = $client_result;
        $this->load->vars($this->data);

        $this->load->view('template');
    }

    public function get_chat_history()
    {
        $user_id = $this->session->userdata('user_id');
        $client_id = $this->input->get('client_id');
        $read_status = $this->input->get('read_status');

        $chat_history = $this->getChatHistory($user_id, $client_id);

        if ($read_status == 1) {
            $update['read_status']    = 1;
            $where['receiver_id']    = $user_id;

            // $this->User_model->updatedata('sq_secure_messages', $where, $update);
            $this->User_model->query("UPDATE `sq_secure_messages` SET `read_status` = '1' WHERE `sender_id` = '$client_id' AND `receiver_id` = '$user_id'");
        }

        echo json_encode($chat_history);
    }

    public function getChatHistory($user_id, $client_id)
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

        if ($message && $message->recipient_type != 'admin') {

            $where['id'] = $message_id;
            $getData = $this->User_model->select_where('sq_secure_messages', $where);
            $result = $getData->row();

            if ($result && !empty($result->attachment)) {
                $existing_file_path = FCPATH . 'upload/secure_messages_attachment/team_members/' . $user_id . '/' . basename($result->attachment);
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

    public function check_client_messages()
    {
        $client_id = $this->input->post('clientId');
        $user_id = $this->session->userdata('user_id');

        $messages_query = $this->User_model->query("SELECT * FROM `sq_secure_messages` WHERE sender_id = '$user_id' AND receiver_id = '$client_id' OR sender_id = '$client_id' AND receiver_id = '$user_id'");
        $messages_list = $messages_query->result();

        if (empty($messages_list)) {
            echo json_encode(['status' => 'empty', 'message' => 'empty']);
        } else {
            echo json_encode(['status' => 'list', 'message' => 'list']);
        }
    }

    public function quick_notes()
    {

        $this->data['page'] = 'messages/quick_notes';
        $this->data['theme']  = 'template';

        $fetchdata = $this->User_model->query("SELECT * FROM sq_quick_notes");

        $this->data['Qnotes'] = $fetchdata->result();


        $this->load->vars($this->data);

        $this->load->view('template');
    }

    public function add_quick_notes()
    {

        $this->data['page'] = 'messages/add_quick_notes';
        $this->data['theme']  = 'template';

        if ($this->input->post()) {

            $title = $this->input->post('title');
            $message = $this->input->post('body');

            $data = [
                'title' => $title,
                'body' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insertdata('sq_quick_notes', $data);

            echo json_encode(['status' => 'success', 'message' => 'Quick note added successfully.']);
        } else {

            $this->load->vars($this->data);

            $this->load->view('template');
        }
    }

    public function edit_quick_notes()
    {
        $this->data['page'] = 'messages/edit_quick_notes';
        $this->data['theme']  = 'template';

        $url_data  = base64_decode(base64_decode($this->uri->segment(2)));
        $note = $this->User_model->query("SELECT * FROM sq_quick_notes WHERE id = '" . $url_data . "'");
        if ($note->num_rows() > 0) {
            $note_result = $note->result();
            $this->data['note_result'] = $note_result;
        } else {
            $this->data['note_result'] = [];
        }

        $this->load->vars($this->data);
        $this->load->view('template');
    }


    public function update_quick_note()
    {
        if ($this->input->post()) {

            $dataUpdate['title']   = $this->input->post('title');
            $dataUpdate['body']    = $this->input->post('body');
            $where['id']    = $this->input->post('hiddenRowId');

            $this->User_model->updatedata('sq_quick_notes', $where, $dataUpdate);

            echo json_encode(['status' => 'success', 'message' => 'Note updated successfully!']);
        }
    }


    public function deleteQuickNotes()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $deleteClient = $this->User_model->query("DELETE FROM sq_quick_notes where id = '" . $id . "' ");
            echo json_encode(['status' => 'success', 'message' => 'deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID is required']);
        }
    }
}
