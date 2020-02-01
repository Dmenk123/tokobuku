<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model('mod_global');
	}

	public function index()
	{
		$produk = $this->mod_global->get_data('m_produk', ['is_aktif' => 1]);
		$kategori = $this->mod_global->get_data('m_kategori');

		$data_header = [
			'produk' => $produk,
			'kategori' => $kategori
		];

		$this->load->view('header', $data_header);
		$this->load->view('v_home');
		$this->load->view('footer');
	}

}
