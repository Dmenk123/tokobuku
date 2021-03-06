<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_detail extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model('mod_global');
	}

	public function detail($id_produk)
	{
		$select = "m_produk.*, m_kategori.nama as nama_kategori, m_satuan.nama as nama_satuan, t_log_harga.harga_satuan, t_log_harga.potongan";
		$join = array(
			["table" => "m_kategori", "on" => "m_produk.id_kategori = m_kategori.id"],
			["table" => "m_satuan", "on"  => "m_produk.id_satuan = m_satuan.id"],
			["table" => "t_log_harga", "on" => "m_produk.id = t_log_harga.id_produk"]
		);
		
		$produk = $this->mod_global->get_data($select, 'm_produk', ['m_produk.is_aktif' => 1 , 'm_produk.id' => $id_produk] , $join);

		
		$data = [
			'produk_data' => $produk
		];

		$this->load->view('v_navbar');
		//$this->load->view('header');
		$this->load->view('v_detail', $data);
		$this->load->view('footer');
	}

}
