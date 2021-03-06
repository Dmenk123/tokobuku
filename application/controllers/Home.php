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
	
	public function err_404()
	{
		return redirect('home');
	}

	public function index()
	{
		/* $cek_agen = $this->pengecekan_agen($uri);

		if ($cek_agen) {
			return redirect('home','refresh');
		} */
		
		$data = [];

		$this->load->view('v_navbar');
		$this->load->view('header');
		$this->load->view('v_home', $data);
		$this->load->view('footer');
	}

	public function aff($uri='')
	{
		$cek_agen = $this->pengecekan_agen($uri);
		if ($cek_agen) {
			return redirect('home', 'refresh');
		}
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
