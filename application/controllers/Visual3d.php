<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visual3d extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Barang_model');
		$this->load->model('Barang_model');
		$this->load->model('Stasiun_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='petugas') {
			show404();
		}
	}
	public function index()
	{
		$data['barang'] = $this->Barang_model->show_barang()->result();
		$this->load->view('view_pilih_barang_petugas' ,$data);

	}

	public function visual()
	{
		$barang = $this->input->post('barang');
		$panjang = $this->input->post('panjang');
		$lebar = $this->input->post('lebar');
		$tinggi = $this->input->post('tinggi');
		$berat = $this->input->post('berat');
		$kontainer = [$panjang,$lebar,$tinggi,$berat];
		set_cookie('kontainer', json_encode($kontainer) ,'3600');
		set_cookie('barang', json_encode($barang) ,'3600');

		$this->load->view('view_3d_petugas');
	}

	public function canvas()
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
