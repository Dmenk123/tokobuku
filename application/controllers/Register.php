<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email', 'pagination'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global']);
	}

	public function index()
	{	
		//captcha	
		$imgCaptcha = $this->buat_captcha();

		$data = array(
			'img' => $imgCaptcha,
		);

		$this->load->view('v_navbar');
		$this->load->view('v_register', $data);
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
        // Captcha configuration
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

	public function add_register()
	{
		if ($this->input->post('reg_captcha') == $this->session->userdata('captchaCode')) 
		{
			$username = $this->input->post('reg_username'); 
			$nama = $this->input->post('reg_nama'); 
			$nama_blkg = $this->input->post('reg_nama_blkg'); 
			$telp = $this->input->post('reg_telp'); 
			$email = $this->input->post('reg_email'); 
			$password = $this->input->post('reg_password'); 
			$re_password = $this->input->post('reg_re_password'); 
			$captcha = $this->input->post('reg_captcha'); 

			//data input array
			$input = array(
				'id_user' => $this->m_reg->getKodeUser(),
				'email' => trim($this->input->post('reg_email')),
				'password' => $password,
				'fname_user' => trim(strtoupper($this->input->post('reg_nama'))),
				'lname_user' => trim(strtoupper($this->input->post('reg_nama_blkg'))),
				'alamat_user' => trim(strtoupper($this->input->post('reg_alamat'))),
				'tgl_lahir_user' => $tgl_lahir,
				'no_telp_user' => trim(strtoupper($this->input->post('reg_telp'))),
				'id_provinsi' => $this->input->post('reg_provinsi'),
				'id_kota' => $this->input->post('reg_kota'),
				'id_kecamatan' => $this->input->post('reg_kecamatan'),
				'id_kelurahan' => $this->input->post('reg_kelurahan'),
				'kode_pos' => trim(strtoupper($this->input->post('reg_kode_pos'))),
				'id_level_user' => 2,
				'foto_user' => $gbr['file_name'],
				'timestamp' => $timestamp 
			);

            //save to db
	        $this->m_reg->add_data_register($input);

	        $data_login = array(
				'data_email'=> trim($this->input->post('reg_email')),
				'data_password'=>$password,
			);
			$result = $this->m_log->login($data_login);

			if ($login = $result[0]) 
			{
				$this->session->set_userdata(
					array(
						'id_user' => $login['id_user'],
						'email' => $login['email'],
						'password' => $login['password'],
						'id_level_user' => $login['id_level_user'],
						'fname_user' => $login['fname_user'],
						'logged_in' => true,
					));
				$this->m_log->set_lastlogin($login['id_user']);
				echo json_encode(array(
					"status" => TRUE,
					"pesan" => 'Selamat datang '.$login['fname_user'].' Akun anda berhasil dibuat'
				));
			}	
		} else {
			echo json_encode(array(
				"status" => FALSE,
				'pesan' => 'Maaf terjadi kesalahan pada penulisan captcha'
			));
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

		return $data;
	}

}
