 <?php
    // if (isset($this->session->userdata['user_id'])) {
    $this->load->view('subscriptions/include/header');
    $this->load->view('subscriptions/include/navbar');
    $this->load->view('subscriptions/include/sidebar');
    $this->load->view('subscriptions/subscriptions');
    $this->load->view('subscriptions/include/footer');
// } else {
//    redirect(base_url().'dashboard');
// }
