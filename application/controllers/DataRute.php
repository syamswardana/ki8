<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataRute extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Rute_model');
		$this->load->model('Stasiun_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='admin') {
			show404();
		}
	}
	public function index()
	{
		$data['rute'] = $this->Rute_model->show_rute()->result();
		$data['stasiun'] = $this->Stasiun_model->show_stasiun()->result();
		// $data['rutes'] = $this->Kontainer_model->get_rutes()->result();
		$this->load->view('view_rute_admin',$data);
		// var_dump($data['kontainer']);

	}

	public function insert()
	{
		$data = array(
			'nama_rute'=>$this->input->post('rute',TRUE),
		);
		$this->Rute_model->insert_rute($data);
		redirect('DataRute');
	}

	public function get_rute()
	{
		$id=$this->input->get('id');
		$rute=$this->Rute_model->get_rute($id)->result();
		foreach ($rute as $row) {
			$data = array (
				'id' => $row->id,
				'rute'=>$row->nama_rute
			);
		}
		echo json_encode($data);
	}

	public function update()
	{
		$data = array(
			'id' => $this->input->post('id_edit'),
			'nama_rute' => $this->input->post('rute_edit')
	 );
	 $this->Rute_model->update_rute($data);
	 redirect('DataRute');
	}
	public function delete()
	{
		$id = $this->input->get('id_hapus');
		$this->Rute_model->delete_rute($id);
		// var_dump($id);
		redirect('DataRute');
	}
	public function get_detail_rute()
	{
		$id = $this->input->get('id');
		$detail_rute = $this->Rute_model->get_detail($id)->result();
		// var_dump($detail_rute);
		$data = array();
		foreach ($detail_rute as $row) {
			$data[] = array (
				'id' => $row->id,
				'id_stasiun' => $row->id_stasiun,
				'nama_stasiun' => $row->nama_stasiun,
				'kota_stasiun' => $row->kota
			);
		}
		echo json_encode($data);

	}
}
