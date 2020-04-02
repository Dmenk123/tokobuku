<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global', 'mod_profile']);
        if (!$this->session->userdata('logged_in')) {
        	redirect('home');
        }
	}

	public function index()
	{
		$arr_komisi = [];
		$arr_batine_agen = [];
		$id_user = clean_string($this->session->userdata('id_user'));
		
		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user, m_user_detail.rekening, m_user_detail.bank";
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

	public function edit_profil()
	{
		$id_user = clean_string($this->session->userdata('id_user'));

		//userdata
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.alamat_user, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.gambar_user, m_user_detail.rekening, m_user_detail.bank";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);

		$userdata = $this->mod_global->get_data($select, 'm_user', ['m_user.status' => 1, 'm_user.id_user' => $id_user], $join);

		$data = ['hasil_data' => $userdata];

		$this->load->view('v_navbar');
		$this->load->view('v_profile_edit', $data);
		$this->load->view('footer');
	}

	public function update_profil()
	{
		$flag_upload_foto = FALSE;
		$flag_ganti_pass = FALSE;
		
		$arr_valid = $this->_validate();

		if ($arr_valid['status'] == FALSE) {
			echo json_encode(['status' => FALSE, 'inputerror' => $arr_valid['inputerror'], 'error_string' => $arr_valid['error_string']]);
			return;
		}

		$id_user = clean_string($this->session->userdata('id_user'));
		$password = clean_string($this->input->post('password'));
		$repassword = clean_string($this->input->post('repassword'));
		$passwordnew = clean_string($this->input->post('passwordnew'));
		$telp = clean_string($this->input->post('telp'));
		$email = clean_string($this->input->post('email'));
		$rekening = clean_string($this->input->post('rekening'));
		$bank = clean_string($this->input->post('bank'));
		$arr_namalengkap = explode(' ', clean_string($this->input->post('namalengkap')));
		$namafileseo = $this->seoUrl($arr_namalengkap[0].' '.time());

		if (count($arr_namalengkap) == 2) {
			$nama_lengkap = $arr_namalengkap[0].','.$arr_namalengkap[1];
		}else if(count($arr_namalengkap) == 3){
			$nama_lengkap = $arr_namalengkap[0].','.$arr_namalengkap[1].','.$arr_namalengkap[2];
		}else if(count($arr_namalengkap) == 4){
			$nama_lengkap = $arr_namalengkap[0].','.$arr_namalengkap[1].','.$arr_namalengkap[2].','.$arr_namalengkap[3];
		}else{
			$nama_lengkap = $arr_namalengkap[0];
		}

		$this->db->trans_begin();
		
		if ($this->input->post('ceklistpwd') != 'Y') {
			$flag_ganti_pass = TRUE;
			$hasil_password = $this->enkripsi->encrypt($passwordnew);

			if ($passwordnew != $repassword) {
				$this->session->set_flashdata('feedback_failed', 'Terdapat ketidak cocokan Password Baru');
				echo json_encode(['status' => false]);
				return;
			}
		}

		if(!empty($_FILES['gambar']['name']))
		{
			$this->konfigurasi_upload_bukti($namafileseo);
			//get detail extension
			$pathDet = $_FILES['gambar']['name'];
			$extDet = pathinfo($pathDet, PATHINFO_EXTENSION);
			if ($this->gbr_bukti->do_upload('gambar')) 
			{
				$flag_upload_foto = TRUE;
				$gbrBukti = $this->gbr_bukti->data();
				//inisiasi variabel u/ digunakan pada fungsi config img bukti
				$nama_file_foto = $gbrBukti['file_name'];
				//load config img
				$this->konfigurasi_image_resize($nama_file_foto);
				//clear img lib after resize
				$this->image_lib->clear();
			} //end
		}

		//data input array
		$input = ['updated_at' => date('Y-m-d H:i:s')];

		if ($flag_ganti_pass) {
			$input['password'] = $hasil_password;
		}

        //update to db
        $this->mod_global->updateData2('m_user',['id_user' => $id_user], $input);

        $detail = array(
			'nama_lengkap_user'=> $nama_lengkap,
			'no_telp_user' => $telp,
			'email' => $email,
			'bank' => $bank,
			'rekening' => $rekening
		);

		if ($flag_upload_foto) {
			$detail['gambar_user'] = $nama_file_foto;
		}

		//save to db
        $this->mod_global->updateData2('m_user_detail', ['id_user' => $id_user], $detail);

        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status = FALSE;
		} else {
			$this->db->trans_commit();			
			$status = TRUE;
		}

		echo json_encode(['status'=>$status]);
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('ceklistpwd') != 'Y') {
			if ($this->input->post('password') == '') {
				$data['inputerror'][] = 'password';
				$data['error_string'][] = 'Wajib mengisi password';
				$data['status'] = FALSE;
			}

			if ($this->input->post('repassword') == null) {
				$data['inputerror'][] = 'repassword';
				$data['error_string'][] = 'Wajib mengisi ulang Password';
				$data['status'] = FALSE;
			}

			if ($this->input->post('passwordnew') == null) {
				$data['inputerror'][] = 'passwordnew';
				$data['error_string'][] = 'Wajib mengisi ulang Password Baru';
				$data['status'] = FALSE;
			}
		}

		if ($this->input->post('namalengkap') == '') {
			$data['inputerror'][] = 'namalengkap';
			$data['error_string'][] = 'Wajib mengisi namalengkap';
			$data['status'] = FALSE;
		}

		
		if ($this->input->post('telp') == '') {
				$data['inputerror'][] = 'telp';
				$data['error_string'][] = 'Wajib mengisi Nomor Telepon';
				$data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
				$data['inputerror'][] = 'email';
				$data['error_string'][] = 'Wajib mengisi Email';
				$data['status'] = FALSE;
		}

		if ($this->input->post('rekening') == '') {
				$data['inputerror'][] = 'rekening';
				$data['error_string'][] = 'Wajib mengisi Rekening';
				$data['status'] = FALSE;
		}

		if ($this->input->post('bank') == '') {
				$data['inputerror'][] = 'bank';
				$data['error_string'][] = 'Wajib mengisi Bank';
				$data['status'] = FALSE;
		}

		return $data;
	}

	public function konfigurasi_upload_bukti($nmfile)
	{ 
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/foto_profil/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000';//in KB (4MB)
		$config['max_width']  = '0';//zero for no limit 
		$config['max_height']  = '0';//zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'gbr_bukti');
		$this->gbr_bukti->initialize($config);
	}

	public function konfigurasi_image_resize($filename)
	{
		//konfigurasi image lib
	    $config['image_library'] = 'gd2';
	    $config['source_image'] = './assets/img/foto_profil/'.$filename;
	    $config['create_thumb'] = FALSE;
	    $config['maintain_ratio'] = FALSE;
	    $config['new_image'] = './assets/img/foto_profil/'.$filename;
	    $config['overwrite'] = TRUE;
	    $config['width'] = 450; //resize
	    $config['height'] = 500; //resize
	    $this->load->library('image_lib',$config); //load image library
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();
	}

	private function seoUrl($string) {
	    //Lower case everything
	    $string = strtolower($string);
	    //Make alphanumeric (removes all other characters)
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    //Clean up multiple dashes or whitespaces
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    //Convert whitespaces and underscore to dash
	    $string = preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}
}
