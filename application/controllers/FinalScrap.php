<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinalScrap extends CI_Controller
{

	public function index()
	{
		$report_html = $this->input->post("report_html");
		$client_id = $this->input->post("client_id");
		$data["res"]["report_html"] = $report_html;
		$data["res"]["client_id"] = $client_id;
		$this->load->view("final_scrap", $data);
	}
}
