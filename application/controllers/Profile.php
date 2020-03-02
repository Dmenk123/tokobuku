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

	public function list_checkout_history()
	{
		$id_user = $this->session->userdata('id_user');

		//=================== cek expired =======================
		$cek_expired = $this->db->query("SELECT id, created_at from t_checkout where id_user = '".$id_user."'")->result();
		if ($cek_expired) {
			foreach ($cek_expired as $key => $cek) {
				//jika lebih dari 3 hari otomatis di nonaktifkan
				$exp =  date('Y-m-d H:i:s', strtotime($cek->created_at. '+ 3 days'));
				if (strtotime(date('Y-m-d H:i:s')) > strtotime($exp)) {
					$this->db->query("UPDATE t_checkout SET status = '0' WHERE id = '".$cek->id."' ");
				}
			}
		}
		//=================== end cek expired =======================
		
		$list = $this->mod_profile->get_data_checkout($id_user);
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listCheckout) {
			$link_detail = site_url('profil/checkout_detail/').$listCheckout->id;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = date('d-m-Y', strtotime($listCheckout->created_at));
			$row[] = "Rp. ".number_format($listCheckout->harga_total,0,",",".");
			$row[] = $listCheckout->kode_ref;
			$row[] = $listCheckout->jml;

			//add html for action button
			$row[] ='<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Checkout Detail" id="btn_detail" onclick=""><i class="fa fa-info-circle"></i> '.$listCheckout->jml.' Items</a>
					<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="nonaktif" onclick="nonaktifCheckout('."'".$listCheckout->id."'".')"><i class="fa fa-times"></i> Nonaktif</a>';

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

}
