<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressHistoryTemplate extends CI_Controller {

	public function index() {
		$this->load->view("address_history");
	}
}
