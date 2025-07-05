<?php

$this->load->view($theme . '/include/header');

$this->load->view($theme . '/include/navbar');

$this->load->view($theme . '/include/sidebar');

$this->load->view($theme . '/' . $page);

$this->load->view($theme . '/include/footer');
