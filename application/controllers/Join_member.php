<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join_member extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email', 'pagination', 'enkripsi'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global']);
	}

	/*public function index()
	{
		//captcha	
		$imgCaptcha = $this->buat_captcha();

		$data = array(
			'img' => $imgCaptcha,
		);

		$this->load->view('v_navbar');
		$this->load->view('v_register', $data);
		$this->load->view('footer');
	}*/

	public function index()
	{
		
		$this->load->view('v_navbar');
		$this->load->view('v_join_member');
		$this->load->view('footer');
	}

	public function proses_data()
	{
		$token = $this->input->post('token');
		$cek_captcha = $this->get_recaptcha($token);

		if ($cek_captcha === FALSE) {
			return redirect('join_member','refresh');
		}

		$arr_valid = $this->_validate();
		$fname = clean_string($this->input->post('fname'));
		$lname = clean_string($this->input->post('lname'));
		$email = clean_string($this->input->post('email'));
		$telp = clean_string($this->input->post('telp'));
		$password = clean_string($this->input->post('password'));
		$re_password = clean_string($this->input->post('re_password'));

		if ($arr_valid['status'] == FALSE) {
			// echo json_encode($arr_valid);
			// return;
			$this->session->set_flashdata('feedback_failed','Gagal menyimpan Data, pastikan telah mengisi semua inputan.'); 
			redirect('join_member');
		}

		//load konfig upload
		$this->konfigurasi_upload_bukti($namafileseo);
		$path = $_FILES['bukti']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		if ($this->bukti_tf->do_upload('bukti')) {
			$gbr = $this->bukti_tf->data(); //get file upload data
			$this->konfigurasi_image_bukti($gbr['file_name'], $namafileseo, $ext);
			$arr_gambar = ['nama_gambar' => $namafileseo . "." . $ext];

			//clear img lib after resize
			$this->image_lib->clear();

			//unlink file upload, just image processed file only saved in server
			$ifile = '/bookstore/assets/img/bukti_transfer/' . $namafileseo . '.' . $ext;
			unlink($_SERVER['DOCUMENT_ROOT'] . $ifile); // use server document root

		} else {
			$this->session->set_flashdata('feedback_failed','Gagal menyimpan Data, pastikan telah Upload Bukti Transfer.'); 
			redirect('join_member');
		}
	}

	private function get_recaptcha($token)
	{
		$genCaptcha = $this->recaptcha->generate();
		
		$resp = $genCaptcha->setExpectedHostname('localhost')
                  ->setExpectedAction('get_recaptcha')
                  ->setScoreThreshold(0.5)
                  ->verify($token);

        if ($resp->isSuccess()) {
		    return TRUE;
		} else {
		    //$errors = $resp->getErrorCodes();
		    return FALSE;
		}
	}

	private function konfigurasi_upload_bukti($nmfile)
	{
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/bukti_transfer/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000'; //in KB (4MB)
		$config['max_width']  = '0'; //zero for no limit 
		$config['max_height']  = '0'; //zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'bukti_tf');
		$this->bukti_tf->initialize($config);
	}

	private function konfigurasi_image_bukti($filename, $newname, $ext)
	{
		//konfigurasi image lib
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/bukti_transfer/' . $filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['new_image'] = './assets/img/bukti_transfer/' . $newname .  "." . $ext;
		$config['overwrite'] = TRUE;
		$config['width'] = 450; //resize
		$config['height'] = 500; //resize
		$this->load->library('image_lib', $config); //load image library
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('fname') == '') {
			$data['inputerror'][] = 'fname';
			$data['error_string'][] = 'Wajib mengisi Nama Depan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Wajib mengisi Email';
			$data['status'] = FALSE;
		}

		if ($this->input->post('telp') == '') {
			$data['inputerror'][] = 'telp';
			$data['error_string'][] = 'Wajib mengisi nomor telepon';
			$data['status'] = FALSE;
		}

		if ($this->input->post('password') == '') {
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Wajib mengisi password';
			$data['status'] = FALSE;
		}

		if ($this->input->post('re_password') == '') {
			$data['inputerror'][] = 're_password';
			$data['error_string'][] = 'Wajib mengisi re_password';
			$data['status'] = FALSE;
		}

		return $data;
	}

	public function add_register()
	{
		$username = clean_string($this->input->post('reg_username')); 
		$nama = clean_string($this->input->post('reg_nama')); 
		$nama_blkg = clean_string($this->input->post('reg_nama_blkg')); 
		$telp = clean_string($this->input->post('reg_telp')); 
		$email = clean_string($this->input->post('reg_email')); 
		$password = clean_string($this->input->post('reg_password')); 
		$re_password = clean_string($this->input->post('reg_re_password')); 
		$hash_password = $this->enkripsi->encrypt($password);
		
		$arr_valid = $this->_validate();
		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		if ($this->input->post('reg_captcha') != $this->session->userdata('captchaCode')) 
		{
			echo json_encode(array(
				"status" => FALSE,
				'pesan' => 'Maaf terjadi kesalahan pada penulisan captcha',
				'flag_captcha' => TRUE
			));
			return;
		}

		if ($password != $re_password) {
			echo json_encode(array(
				"status" => FALSE,
				'pesan' => 'Maaf Password harus Sama',
				'flag_captcha' => TRUE
			));
			return;
		}

		$id_user = $this->mod_global->getKodeUser();

		//data input array
		$input = array(
			'id_user' => $id_user,
			'username' => $username,
			'password' => $hash_password,
			'id_level_user' => '3',
			'status' => '1',
			'created_at' => date('Y-m-d H:i:s')
		);

        //save to db
        $this->mod_global->insert_data('m_user', $input);

        $detail = array(
			'id_user'=> $id_user,
			'nama_lengkap_user'=> $nama.','.$nama_blkg,
			'no_telp_user' => $telp,
			'email' => $email
		);
		//save to db
        $this->mod_global->insert_data('m_user_detail', $detail);

        //login
        $data_login = [
        	'data_username' => $username,
        	'data_password' => $hash_password
        ];

		$result = $this->mod_global->login($data_login);

		if ($login = $result[0]) 
		{
			$this->session->set_userdata(
				array(
					'id_user' => $login['id_user'],
					'username' => $login['username'],
					'password' => $login['password'],
					'id_level_user' => $login['id_level_user'],
					'logged_in' => true,
				)
			);
			$this->mod_global->set_lastlogin($login['id_user']);
			echo json_encode(array(
				"status" => TRUE,
				"pesan" => 'Selamat datang '.$login['username'].' Akun anda berhasil dibuat'
			));
		}
	}

	

}
