<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExpTemplate extends CI_Controller {

	public function index() {
		$this->load->view("template_exp");
	}
}
