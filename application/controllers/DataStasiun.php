<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataKontainer extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Kontainer_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='admin') {
			show404();
		}
	}
	public function index()
	{
		// $data['kontainer'] = $this->Kontainer_model->show_kontainer()->result();
		// $data['rutes'] = $this->Kontainer_model->get_rutes()->result();
		$this->load->view('view_stasiun_admin');
		// var_dump($data['kontainer']);

	}

	public function insert()
	{
		$data = array(
			'rute_id'=>$this->input->post('rute',TRUE),
			'panjang'=>$this->input->post('panjang',TRUE),
			'lebar'=>$this->input->post('lebar',TRUE),
			'tinggi'=> $this->input->post('tinggi',TRUE),
			'berat_maksimal'=> $this->input->post('berat',TRUE),
			'tanggal_digunakan'=> $this->input->post('tanggal',TRUE)
		);
		$this->Kontainer_model->insert_kontainer($data);
		redirect('DataKontainer');
	}

	public function get_kontainer()
	{
		$id=$this->input->get('id');
		$kontainer=$this->Kontainer_model->get_kontainer($id)->result();

		foreach ($kontainer as $row) {
			$data = array (
				'id' => $row->id,
				'rute_id'=>$row->rute_id,
				'panjang'=>$row->panjang,
				'lebar'=>$row->lebar,
				'tinggi'=> $row->tinggi,
				'berat_maksimal'=> $row->berat_maksimal,
				'tanggal_digunakan'=> $row->tanggal_digunakan
			);
		}
		echo json_encode($data);
	}

	public function update()
	{
		// Rute 	Panjang (cm) 	Lebar (cm) 	Tinggi (cm) 	Berat Max (kg) 	Tgl digunakan
		$data = array(
			'id' => $this->input->post('id_edit'),
			'rute' => $this->input->post('rute_edit'),
			'panjang' => $this->input->post('panjang_edit'),
			'lebar' => $this->input->post('lebar_edit'),
			'tinggi' => $this->input->post('tinggi_edit'),
			'berat' => $this->input->post('berat_edit'),
			'tanggal' => $this->input->post('tanggal_edit')

	 );
	 $this->Kontainer_model->update_kontainer($data);
	 redirect('DataKontainer');
	}
	public function delete()
	{
		$id = $this->input->get('id_hapus');
		$this->Kontainer_model->delete_kontainer($id);
		// var_dump($id);
		redirect('DataKontainer');
	}
}
