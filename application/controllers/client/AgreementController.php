<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AgreementController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AgreementModel');
    }

    // Show agreement form
    public function index()
    {
        $this->load->view('client/agreement/agreement_form');
    }

    // Admin side - add new agreement with TinyMCE
    public function add_agreement()
    {
        $this->load->view('client/agreement/admin_add_agreement');
    }

    // Save the agreement (Admin)
    public function save_agreement()
    {
        $is_default = $this->input->post('is_default') ? 1 : 0;

        // If this is set as default, remove previous default agreements
        if ($is_default) {
            $this->AgreementModel->unset_default_agreements();
        }

        $data = array(
            // 'client_name' => '', // Admin doesn't need client name
            'agreement_text' => $this->input->post('agreement_text'),
            'is_default' => $is_default,
            // 'signature' => '' // No signature needed for default agreement
        );

        $this->AgreementModel->save_agreement($data);
        redirect('client/AgreementController/view_agreements');
    }

    // Client dashboard - show the default agreement
    public function client_dashboard()
    {
        $data['agreement'] = $this->AgreementModel->get_default_agreement();
        $this->load->view('client/agreement/client_dashboard', $data);
    }

    // Submit agreement
    public function submit()
    {
        $signature = $this->input->post('signature');
        $data = array(
            'client_name' => $this->input->post('client_name'),
            'agreement_text' => $this->input->post('agreement_text'),
            'signature' => $signature
        );
        $this->AgreementModel->save_agreement($data);
        redirect('client/AgreementController/view_agreements');
    }

    public function view_agreements()
    {
        $data['agreements'] = $this->AgreementModel->get_all_agreements();
        $this->load->view('client/agreement/view_agreements', $data);
    }

    public function save_signature()
    {
        $signature = $this->input->post('signature');
        $agreement_id = $this->input->post('agreement_id');

        // Update the agreement with the saved signature
        $data = array(
            'signature' => $signature
        );

        $this->AgreementModel->update_agreement($agreement_id, $data);
        echo json_encode(array('status' => 'success'));
    }
}
