<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataBarang extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Barang_model');
		$this->load->model('Stasiun_model');
		$this->load->model('Jenis_barang_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='petugas') {
			show404();
		}
	}
	public function index()
	{
		$data['barang'] = $this->Barang_model->show_barang()->result();
		$data['stasiun'] = $this->Stasiun_model->show_stasiun()->result();
		$data['jenis_barang'] = $this->Jenis_barang_model->show_jenis()->result();
		$this->load->view('view_barang_petugas',$data);
	}

	public function insert()
	{
		// id	berat	panjang	lebar	tinggi	asal	tujuan	user_id
		$data = array(
			'berat'=>$this->input->post('berat',TRUE),
			'panjang'=>$this->input->post('panjang',TRUE),
			'lebar'=>$this->input->post('lebar',TRUE),
			'tinggi'=>$this->input->post('tinggi',TRUE),
			'id_jenis'=>$this->input->post('jenis',TRUE),
			'asal'=>$this->input->post('asal',TRUE),
			'tujuan'=>$this->input->post('tujuan',TRUE),
			'user_id'=>$this->session->userdata('id')
		);
		$this->Barang_model->insert_barang($data);
		redirect('DataBarang');
	}

	public function get_barang()
	{
		$id=$this->input->get('id');
		// $id=1;
		$barang=$this->Barang_model->get_barang($id)->result();
		foreach ($barang as $row) {
			$data = array (
				'id' => $row->id,
				'berat'=>$row->berat,
				'panjang'=>$row->panjang,
				'lebar'=>$row->lebar,
				'tinggi'=>$row->tinggi,
				'jenis'=>$row->id_jenis,
				'asal'=>$row->asal,
				'tujuan'=>$row->tujuan
			);
		}
		// var_dump($barang);
		echo json_encode($data);
	}

	public function update()
	{
		// id	berat	panjang	lebar	tinggi	asal	tujuan	user_id
		$data = array(
			'id' => $this->input->post('id_edit'),
			'berat' => $this->input->post('berat_edit'),
			'panjang' => $this->input->post('panjang_edit'),
			'lebar' => $this->input->post('lebar_edit'),
			'tinggi' => $this->input->post('tinggi_edit'),
			'asal' => $this->input->post('asal_edit'),
			'tujuan' => $this->input->post('tujuan_edit'),
	 );
	 $this->Barang_model->update_barang($data);
	 redirect('DataBarang');
	}
	public function delete()
	{
		$id = $this->input->get('id_hapus');
		$this->Barang_model->delete_barang($id);
		redirect('DataBarang');
	}
}
