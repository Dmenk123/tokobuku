<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global', 'mod_profile']);
	}

	public function index()
	{
		$arr_komisi = [];
		$arr_batine_agen = [];
		$id_user = clean_string($this->session->userdata('id_user'));
		
		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);
		
		$userdata = $this->mod_global->get_data($select, 'm_user', ['m_user.status' => 1 , 'm_user.id_user' => $id_user] , $join);

		// var_dump($userdata);exit;
		if ($this->session->userdata('id_level_user') == '2') {
			$id_agen = $this->mod_profile->get_id_agen($id_user);
			$arr_komisi = $this->list_komisi_history($id_agen);

			$q = $this->mod_profile->get_komisi_belum_tarik($id_agen);
			$qq = $this->mod_profile->get_komisi_sudah_tarik($id_agen);
			
			$arr_batine_agen = [
				'komisi_belum' => $q->total_laba,
				'komisi_sudah' => $qq->total_laba
			];
		}

		$data = [
			'data_user' => $userdata,
			'data_komisi' => $arr_komisi,
			'data_laba_agen' => $arr_batine_agen
		];

		$this->load->view('v_navbar');
		$this->load->view('v_profile', $data);
		$this->load->view('footer');
	}

	public function list_komisi_history($id_agen)
	{
		$id_user = clean_string($this->session->userdata('id_user'));
		$id_agen = $this->mod_profile->get_id_agen($id_user);
		$list = $this->mod_profile->get_data_komisi($id_agen);
		
		$data = array();
		$no = 0;
		foreach ($list as $datalist) {
			$link_detail = site_url('profile/komisi_detail/') . $datalist->id;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $no;
			$row[] = date('d-m-Y H:i', strtotime($datalist->created_at));
			$row[] = "Rp. ".number_format($datalist->laba_agen_total,0,",",".");
			$row[] = $datalist->kode_ref;
			$data[] = $row;
		} //end loop

		return $data;
	}

	public function tarik_komisi()
	{
		$id_user = clean_string($this->session->userdata('id_user'));
		$id_agen = $this->mod_profile->get_id_agen($id_user);

		$q = $this->mod_profile->get_komisi_belum_tarik($id_agen);
		$qq = $this->mod_profile->get_komisi_sudah_tarik($id_agen);
		
		$this->db->trans_begin();
		$id = $this->mod_global->gen_uuid();
		$kode_klaim = $this->string_unik();
		//update flag is tarik
		$update_flag_tarik = $this->mod_profile->set_komisi_sudah_tarik($id_agen);
		
		//catat ke t_klaim_agen
		if ($qq->total_laba) {
			$saldo_sebelum = $qq->total_laba; 
		}else{
			$saldo_sebelum = 0;
		}
		$data = array(
			'id' => $id,
			'id_agen' => $id_agen,
			'saldo_sebelum' => $saldo_sebelum,
			'jumlah_klaim' => (int)$q->total_laba,
			'saldo_sesudah' => (int)$qq->total_laba + (int)$q->total_laba,
			'datetime_klaim' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s'),
			'kode_klaim' => $kode_klaim
		);

		$insert = $this->mod_global->insert_data('t_klaim_agen', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status = FALSE;
		} else {
			$this->db->trans_commit();			
			$status = TRUE;
		}

		echo json_encode([
			'status' => $status,
			'kode_klaim' => $kode_klaim
		]);
	}

	public function checkout_detail($id)
	{
		$id_user = $this->session->userdata('id_user');
		
		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);

		//data user
		$userdata = $this->mod_global->get_data($select, 'm_user', ['m_user.status' => 1, 'm_user.id_user' => $id_user], $join);
		//data checkout
		$ckt_detail = $this->mod_profile->get_data_checkout_det($id);

		$data = [
			'data_user' => $userdata,
			'data_checkout' => $ckt_detail
		];

		$this->load->view('v_navbar');
		$this->load->view('v_checkout_detail', $data);
		$this->load->view('footer');
	}

	public function komisi_detail($id_checkout)
	{
		$id_user = clean_string($this->session->userdata('id_user'));
		$id_agen = $this->mod_profile->get_id_agen($id_user);

		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);

		//data user
		$userdata = $this->mod_global->get_data($select, 'm_user', ['m_user.status' => 1, 'm_user.id_user' => $id_user], $join);
		//data komisi
		$komisi_detail = $this->mod_profile->get_data_komisi_detail($id_checkout, $id_agen);
				
		$data = [
			'data_user' => $userdata,
			'data_komisi' => $komisi_detail
		];

		$this->load->view('v_navbar');
		$this->load->view('v_komisi_detail', $data);
		$this->load->view('footer');
	}

	private function string_unik($tokenLength = 5){
	    $token = "C-";
	    //Combination of character, number and special character...
	    $combinationString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	    for($i=0;$i<$tokenLength;$i++){
	        $token .= $combinationString[uniqueSecureHelper(0,strlen($combinationString))];
	    }
	    return $token;
	}


}
