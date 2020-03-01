<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model('mod_global');
	}

	public function index()
	{
		$id_user = $this->session->userdata('id_user');

		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);
		
		$userdata = $this->mod_global->get_data($select, 'm_user', ['m_user.status' => 1 , 'm_user.id_user' => $id_user] , $join);
		
		$data = [
			'data_user' => $userdata
		];

		$this->load->view('v_navbar');
		//$this->load->view('header');
		$this->load->view('v_profile', $data);
		$this->load->view('footer');
	}

}
