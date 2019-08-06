<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
    parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE){
      redirect('login');
  }
}
	public function index()
	{
		$this->load->view('view_dashboard_admin');
		// if($this->session->userdata('status')==='petugas'){
		// 	$this->load->view('view_dashboard_petugas');
    //   } elseif ($this->session->userdata('status')=='admin') {
		// 		$this->load->view('view_dashboard_admin');
    //   }
		// 	else{
    //       echo "Access Denied";
    //   }
	}
	public function data_kontainer()
	{
		$this->load->view('view_kontainer_admin');
	}

}
