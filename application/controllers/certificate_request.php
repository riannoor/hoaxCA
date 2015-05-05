<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class certificate_request extends CI_Controller {

	function __construct()
		{
			parent::__construct();
			$this->load->model('cert_model');
		}
	
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			// $session_data = $this->session->userdata('logged_in');
			// $data['username'] = $session_data['username'];
			$this->load->view('certificate_request');
		}
		else
		{
			//Jika tidak ada session di kembalikan ke halaman login
			redirect('welcome', 'refresh');
		}
	}


	public function request(){
		$userdata['namaOrganisasi'] = $this->input->post('namaOrganisasi');
		$userdata['unitOrganisasi'] = $this->input->post('unitOrganisasi');
		$userdata['kota'] = $this->input->post('kota');
		$userdata['prov'] = $this->input->post('prov');
		$userdata['validTime'] = $this->input->post('validTime');

		$res = $this->cert_model->request($userdata);

		foreach ($res->result_array() as $row)
				{
				}

		if ($row['statuscode']==0) {
			$this->load->view('sukses');
		}
		else{
			echo $row['statusmsg'];
		}
	}

	public function view(){
		$res = $this->cert_model->view();

		foreach ($res->result_array() as $row)
				{
				}

		$data['certreq']=$res->result_array();
		if ($res->num_rows() > 0){
			if ($row['statuscode']==0) {
				$this->load->view('certificate_request_view', $data);
			}
			else{
				echo $row['statusmsg'];
			}
		}
		else
			echo "NOT FOUND!";
	}

}
