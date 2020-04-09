<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliate extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email', 'pagination', 'enkripsi'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
		$this->load->model(['mod_global']);
		
		if ($this->session->userdata('logged_in')) {
			return redirect('home','refresh');
		}
	}

	public function index()
	{	
		//captcha	
		$imgCaptcha = $this->buat_captcha();

		$data = array(
			'img' => $imgCaptcha,
		);

        $this->load->view('v_navbar');
        if (!empty($this->session->userdata('kode_agen'))) {
            $this->load->view('v_kode', $data);
        }else{
            $this->load->view('v_affiliate', $data);
        }
		$this->load->view('footer');
	}

	public function buat_captcha()
	{
		$options = array(
			'img_path' => 'assets/img/captcha_img/',
			'img_url' => base_url().'assets/img/captcha_img/',
			'img_width' => '200',
			'img_height' => '50',
			'word_length'   => 5,
			'font_size' => 20,
			'expiration' => 7200,
			'font_path' => FCPATH.'assets/css/fonts/E004007T.ttf',
			'show_grid' => false,
			'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            ),
		);
		$cap = create_captcha($options);
		// Unset previous captcha and store new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode', $cap['word']);

		$image = $cap['image'];
		return $image;
	}

	public function refresh_captcha() 
	{
        $options = array(
			'img_path' => 'assets/img/captcha_img/',
			'img_url' => base_url().'assets/img/captcha_img/',
			'img_width' => '200',
			'img_height' => '50',
			'word_length'   => 5,
			'font_size' => 16,
			'expiration' => 7200,
			'font_path' => FCPATH.'assets/css/fonts/E004007T.ttf',
			'show_grid' => false,
			'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            ),
		);
        $captcha = create_captcha($options);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }

	public function check_captcha()
	{
		if ($this->input->post('captcha') == $this->session->userdata('captchaCode')) 
		{
			return true;
		}
		else
		{
			echo json_encode(array('pesan_error' => 'Maaf terjadi kesalahan pada penulisan captcha'));
			return false;
		}
	}

	public function register()
	{
		//captcha	
		$imgCaptcha = $this->buat_captcha();

		$data = array(
			'img' => $imgCaptcha,
		);

		$this->load->view('v_navbar');
		if (!empty($this->session->userdata('kode_agen'))) {
			$this->load->view('v_kode', $data);
		} else {
			$this->load->view('v_register_affiliate', $data);
		}
		$this->load->view('footer');
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
		$bank = clean_string($this->input->post('reg_bank'));
		$rekening = clean_string($this->input->post('reg_rekening'));

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
        $kode    = $this->kode_affiliate();
		//data input array
		$input = array(
			'id_user' => $id_user,
			'username' => $username,
			'password' => $hash_password,
			'id_level_user' => '2',
            'status' => '1',
            'kode_agen' => $kode,
			'created_at' => date('Y-m-d H:i:s')
		);

        //save to db
        $this->mod_global->insert_data('m_user', $input);

        $detail = array(
			'id_user'=> $id_user,
			'nama_lengkap_user'=> $nama.','.$nama_blkg,
			'no_telp_user' => $telp,
			'email' => $email,
			'bank' => $bank,
			'rekening' => $rekening
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
                    'kode_agen'  => $login['kode_agen'],
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

	public function login()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$username = clean_string($this->input->post('username_login')); 
		$password = clean_string($this->input->post('password_login'));

		if ($this->input->post('username_login') == '') {
			$data['inputerror'][] = 'username_login';
			$data['error_string'][] = 'Wajib mengisi username';
			$data['status'] = FALSE;
		}

		if ($this->input->post('password_login') == '') {
			$data['inputerror'][] = 'password_login';
			$data['error_string'][] = 'Wajib mengisi password';
			$data['status'] = FALSE;
		}

		if ($data['status'] == FALSE) {
			echo json_encode($data);
			return;
		}else{
			$hash_password = $this->enkripsi->encrypt($password);

			//login
	        $data_login = [
	        	'data_username' => $username,
	        	'data_password' => $hash_password
	        ];

			$result = $this->mod_global->login($data_login);

			if ($result) 
			{
				$login = $result[0];
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
					"pesan" => 'Selamat datang '.$login['username']
				));
			}else{
				echo json_encode(array(
					"status" => FALSE,
					"pesan" => 'Username / Password Anda Salah',
					'flag_alert'=> TRUE
				));
			}
		}
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('reg_username') == '') {
			$data['inputerror'][] = 'reg_username';
			$data['error_string'][] = 'Wajib mengisi username';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_nama') == '') {
			$data['inputerror'][] = 'reg_nama';
			$data['error_string'][] = 'Wajib mengisi nama';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_telp') == '') {
			$data['inputerror'][] = 'reg_telp';
			$data['error_string'][] = 'Wajib mengisi nomor telepon';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_email') == '') {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Wajib mengisi email';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_password') == '') {
			$data['inputerror'][] = 'reg_password';
			$data['error_string'][] = 'Wajib mengisi Password';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_re_password') == '') {
			$data['inputerror'][] = 'reg_re_password';
			$data['error_string'][] = 'Wajib mengisi jumlah Re-Password';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_captcha') == '') {
			$data['inputerror'][] = 'reg_captcha';
			$data['error_string'][] = 'Wajib mengisi Captcha';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_bank') == '') {
			$data['inputerror'][] = 'reg_bank';
			$data['error_string'][] = 'Wajib mengisi Nama Bank';
			$data['status'] = FALSE;
		}

		if ($this->input->post('reg_rekening') == '') {
			$data['inputerror'][] = 'reg_rekening';
			$data['error_string'][] = 'Wajib mengisi Nomor Rekening';
			$data['status'] = FALSE;
		}

		return $data;
    }
    
    function kode_affiliate(){
        $arr = array("A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z");
        $kode = $arr[mt_rand(0,23)].mt_rand(0,9).$arr[mt_rand(0,23)].mt_rand(0,100).$arr[mt_rand(0,23)].mt_rand(0,9);
        return $kode;
    }


}
