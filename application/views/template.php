<?php

if (isset($this->session->userdata['user_type']) && $this->session->userdata['user_type'] == 'super' || $this->session->userdata['user_type'] == 'emp') {

    $this->load->view($theme . '/header');


    $this->load->view($page);

    $this->load->view($theme . '/footer');
} else {

    redirect(base_url());
}


