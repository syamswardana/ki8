<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visual3d extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Barang_model');
		$this->load->model('Kontainer_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='petugas') {
			show404();
		}
	}
	public function index()
	{
		$this->load->view('view_3d_petugas');

	}
	public function visual()
	{
		$this->load->view('visual');
	}

	public function barang()
	{
		$data = $this->Barang_model->show_barang()->result();
		echo json_encode($data);
	}

	public function kontainer()
	{
		$data = $this->Kontainer_model->show_barang()->result();
		echo json_encode($data);
	}
}
