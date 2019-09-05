<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataPetugas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Users_model');
		if($this->session->userdata('logged_in') != TRUE){
			redirect('login');
		} elseif ($this->session->userdata('status')!='admin') {
			show404();
		}
	}
	public function index()
	{
		$data['users'] = $this->Users_model->show_users()->result();
		$this->load->view('view_petugas_admin',$data);

	}

	public function insert()
	{
		$data = array(
			'username'=>$this->input->post('username',TRUE),
			'nama'=>$this->input->post('nama',TRUE),
			'stasiun'=>$this->input->post('stasiun',TRUE),
			'password'=> $this->input->post('password',TRUE),
		);
		$this->Users_model->insert_user($data);
		redirect('DataPetugas');
	}

	public function get_user()
	{
		$id=$this->input->get('id');
		$user=$this->Users_model->get_user($id)->result();

		foreach ($user as $row) {
			$data = array (
				'id' => $row->id,
				'username' => $row->username,
				'nama' => $row->nama,
				'stasiun' => $row->stasiun,
				'password' => $row->password
			);
		}
		echo json_encode($data);
	}

	public function update()
	{
		$data = array(
			'id' => $this->input->post('id_edit'),
			'username' => $this->input->post('username_edit'),
			'nama' => $this->input->post('nama_edit'),
			'stasiun' => $this->input->post('stasiun_edit'),
			'password' => $this->input->post('password_edit')

	 );
	 $this->Users_model->update_user($data);
	 redirect('DataPetugas');
	}
	public function delete()
	{
		$id = $this->input->get('id_hapus');
		$this->Users_model->delete_user($id);
		redirect('DataPetugas');
	}
}
