<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TucTemplate extends CI_Controller {

	public function index() {
		$this->load->view("template_tuc");
	}
}
