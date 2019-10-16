<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
    parent::__construct();
    $this->load->model('Users_model');
  }
	public function index()
	{
		$this->load->view('view_login');
	}

	public function auth()
	{
		$username = $this->input->post('username',TRUE);
    $password = $this->input->post('password',TRUE);
		if ($username==null||password==null) {
			echo $this->session->set_flashdata('msg','username/password tidak boleh kosong');
			redirect('login');
		}
    $validate = $this->Users_model->validate($username,$password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
				$id = $data['id'];
        $name  = $data['nama'];
        $username = $data['username'];
        $status = $data['status'];
        $sesdata = array(
            'id'  => $id,
            'name'  => $name,
            'username'     => $username,
            'status'     => $status,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);

				if ($this->session->userdata('status')=='admin') {
					redirect('DataPetugas');
				} else {
					redirect('DataBarang');
				}
    }else{
        echo $this->session->set_flashdata('msg','Username atau Password salah');
        redirect('login');
    }
	}

	public function logout()
	{
		$this->session->sess_destroy();
      redirect('login');
	}
	public function test()
	{
		echo "string";
	}
}
