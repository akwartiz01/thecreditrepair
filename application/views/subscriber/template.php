<?php

if (isset($this->session->userdata['user_type']) && $this->session->userdata['user_type'] == 'subscriber') {

    $this->load->view($theme . '/include/header');

    $this->load->view($theme . '/include/navbar');

    $this->load->view($theme . '/include/sidebar');

    // $this->load->view($theme . '/' . $model . '/' . $page);
    $this->load->view($theme . '/' . $page);

    $this->load->view($theme . '/include/footer');
} else {

    redirect(base_url() . 'subscriber/login');
}
