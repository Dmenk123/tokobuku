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

	public function index($uri='')
	{
		$cek_agen = $this->pengecekan_agen($uri);

		if ($cek_agen) {
			return redirect('home','refresh');
		}

		$select = "m_produk.*, m_kategori.nama as nama_kategori, m_satuan.nama as nama_satuan, t_log_harga.harga_satuan, t_log_harga.potongan";
		$join = array(
			["table" => "m_kategori", "on" => "m_produk.id_kategori = m_kategori.id"],
			["table" => "m_satuan", "on"  => "m_produk.id_satuan = m_satuan.id"],
			["table" => "t_log_harga", "on" => "m_produk.id = t_log_harga.id_produk and t_log_harga.is_aktif = '1'"]
		);
		$produk = $this->mod_global->get_data($select, 'm_produk', ['m_produk.is_aktif' => 1], $join);
		
		$data = [
			'produk' => $produk,
			//'kategori' => $kategori
		];

		$this->load->view('v_navbar');
		$this->load->view('header');
		$this->load->view('v_home', $data);
		$this->load->view('footer');
	}

	public function pengecekan_agen($uri)
	{
		/*
		* cek ada tidaknya sesi level
		* ketika tidak ada maka dibuatkan sesi agen
		* ketika ada, dicek levelnya jika bukan customer maka akan di unset
		* ada return value, sebagai flag untuk redirect
		*/
	
		$retval = FALSE;

		if ($this->session->userdata('id_level_user') == null) 
		{
			$param_sess = $uri;
			$cek_sess = $this->mod_global->cek_sesi_agen($param_sess);
			if ($cek_sess) {
				$this->session->unset_userdata('kode_agen');
				$this->session->set_userdata(
					array(
						'kode_agen' => $cek_sess->kode_agen
					)
				);

				$retval = TRUE;
			}
		}
		else
		{
			if ((int)$this->session->userdata('id_level_user') > 2) {
				if ($uri != '') {
					$param_sess = $uri;
					$cek_sess = $this->mod_global->cek_sesi_agen($param_sess);
					
					if ($cek_sess) {
						$this->session->unset_userdata('kode_agen');
						$this->session->set_userdata(
							array(
								'kode_agen' => $cek_sess->kode_agen
							)
						);

						$retval = TRUE;
					}
				}
			}else{
				if ($this->session->userdata('kode_agen') != null) {
					$this->session->unset_userdata('kode_agen');
				}
			}
		}

		return $retval;
	}

}
