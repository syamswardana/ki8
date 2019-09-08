<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataStasiun extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Stasiun_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='admin') {
			show404();
		}
	}
	public function index()
	{
		$data['stasiun'] = $this->Stasiun_model->show_stasiun()->result();
		// $data['rutes'] = $this->Kontainer_model->get_rutes()->result();
		$this->load->view('view_stasiun_admin',$data);
		// var_dump($data['kontainer']);

	}

	public function insert()
	{
		$data = array(
			'nama_stasiun'=>$this->input->post('stasiun',TRUE),
			'kota'=>$this->input->post('kota',TRUE),
		);
		$this->Stasiun_model->insert_stasiun($data);
		redirect('DataStasiun');
	}

	public function get_stasiun()
	{
		$id=$this->input->get('id');
		$stasiun=$this->Stasiun_model->get_stasiun($id)->result();
		foreach ($stasiun as $row) {
			$data = array (
				'id' => $row->id,
				'stasiun'=>$row->nama_stasiun,
				'kota'=>$row->kota
			);
		}
		echo json_encode($data);
	}

	public function update()
	{
		// Rute 	Panjang (cm) 	Lebar (cm) 	Tinggi (cm) 	Berat Max (kg) 	Tgl digunakan
		$data = array(
			'id' => $this->input->post('id_edit'),
			'nama_stasiun' => $this->input->post('stasiun_edit'),
			'kota' => $this->input->post('kota_edit'),
	 );
	 $this->Stasiun_model->update_stasiun($data);
	 redirect('DataStasiun');
	}
	public function delete()
	{
		$id = $this->input->get('id_hapus');
		$this->Stasiun_model->delete_stasiun($id);
		// var_dump($id);
		redirect('DataStasiun');
	}
}
