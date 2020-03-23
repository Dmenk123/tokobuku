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
		$id_user = clean_string($this->session->userdata('id_user'));
		
		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);
		
		$userdata = $this->mod_global->get_data($select, 'm_user', ['m_user.status' => 1 , 'm_user.id_user' => $id_user] , $join);

		if ($this->session->userdata('id_level_user') == '2') {
			$id_agen = $this->mod_profile->get_id_agen($id_user);
			$arr_komisi = $this->list_komisi_history($id_agen);
		}

		$data = [
			'data_user' => $userdata,
			'data_komisi' => $arr_komisi
		];

		$this->load->view('v_navbar');
		//$this->load->view('header');
		$this->load->view('v_profile', $data);
		$this->load->view('footer');
	}

	public function list_checkout_history()
	{
		$id_user = $this->session->userdata('id_user');

		//=================== cek expired =======================
		$cek_expired = $this->db->query("SELECT id, status, created_at from t_checkout where id_user = '".$id_user."'")->result();
		if ($cek_expired) {
			foreach ($cek_expired as $key => $cek) {
				//jika statusnya masih aktif
				if ($cek->status == '1') {
					//jika lebih dari 3 hari otomatis di nonaktifkan
					$exp =  date('Y-m-d H:i:s', strtotime($cek->created_at . '+ 3 days'));
					if (strtotime(date('Y-m-d H:i:s')) > strtotime($exp)) {
						$this->db->query("UPDATE t_checkout SET status = '2' WHERE id = '" . $cek->id . "' ");
					}
				}
			}
		}
		//=================== end cek expired =======================
		
		$list = $this->mod_profile->get_data_checkout($id_user);
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listCheckout) {
			$link_detail = site_url('profile/checkout_detail/').$listCheckout->id;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = date('d-m-Y', strtotime($listCheckout->created_at));
			$row[] = "Rp. ".number_format($listCheckout->harga_total,0,",",".");
			$row[] = $listCheckout->kode_ref;
			$row[] = $listCheckout->jml;

			//add html for action button
			$row[] ='
				<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Checkout Detail" id="btn_detail" onclick=""><i class="fa fa-info-circle"></i> '.$listCheckout->jml.' Items</a>';

			$data[] = $row;
		}//end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->mod_profile->count_all($id_user),
			"recordsFiltered" => $this->mod_profile->count_filtered($id_user),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
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
			$row[] = date('d-m-Y', strtotime($datalist->tanggal));
			$row[] = "Rp. ".number_format($datalist->harga_subtotal,0,",",".");
			$row[] = "Rp. ".number_format($datalist->laba_agen,0,",",".");
			$row[] = $datalist->kode_ref;

			//add html for action button
			$row[] = '
				<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Komisi Detail" id="btn_detail_komisi" onclick=""><i class="fa fa-info-circle"></i> ' . $datalist->jml_trans . ' Items</a>';

			$data[] = $row;
		} //end loop

		return $data;
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

}
