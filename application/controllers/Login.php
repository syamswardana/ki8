<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
    parent::__construct();
    $this->load->model('login_model');
  }
	public function index()
	{
		$this->load->view('view_login');
	}

	public function auth()
	{
		$username = $this->input->post('username',TRUE);
    $password = md5($this->input->post('password',TRUE));
		// echo $this->input->post('password',TRUE);
    $validate = $this->login_model->validate($username,$password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $name  = $data['nama'];
        $username = $data['username'];
        $status = $data['status'];
        $sesdata = array(
            'name'  => $name,
            'username'     => $username,
            'status'     => $status,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);

				redirect('dashboard');
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
