<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataJenisBarang extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Jenis_barang_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='admin') {
			show404();
		}
	}
	public function index()
	{
		$data['jenis_barang'] = $this->Jenis_barang_model->show_jenis()->result();
		$this->load->view('view_jenis_barang_admin',$data);
	}

	public function insert()
	{
		$data = array(
			'jenis_barang'=>$this->input->post('jenis_barang',TRUE),
		);
		$this->Jenis_barang_model->insert_jenis($data);
		redirect('DataJenisBarang');
	}

	public function get_jenis()
	{
		$id=$this->input->get('id');
		$jenis=$this->Jenis_barang_model->get_jenis($id)->result();
		foreach ($jenis as $row) {
			$data = array (
				'id' => $row->id,
				'jenis_barang'=>$row->jenis_barang
			);
		}
		echo json_encode($data);
	}

	public function update()
	{
		$data = array(
			'id' => $this->input->post('id_edit'),
			'jenis_edit' => $this->input->post('jenis_edit')
	 );
	 $this->Jenis_barang_model->update_jenis($data);
	 redirect('DataJenisBarang');
	}
	public function delete()
	{
		$id = $this->input->get('id_hapus');
		$this->Jenis_barang_model->delete_jenis($id);
		redirect('DataJenisBarang');
	}
}
