<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{	
		if ($this->session->userdata('username') !== null) {
			redirect('admin/dashboard');
		}
		$this->load->view('adm_view/v_login');
	}

	public function proc()
	{
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->library('Enkripsi');

		$pass_string = clean_string($this->db->escape_str($this->input->post('password')));
		$username_string = clean_string($this->db->escape_str($this->input->post('username')));
		$hasil_password = $this->enkripsi->encrypt($pass_string);
				
		$data_input = array(
			'data_user'=> $username_string,
			'data_password'=>$hasil_password,
		);
		
		$result = $this->m_user->login($data_input);
		
		if ($data = $result[0]) {
			$this->m_user->set_lastlogin($data['id_user']);
			$this->session->set_userdata(
				array(
					'username' => $data['username'],
					'id_user' => $data['id_user'],
					'last_login' => $data['last_login'],
					'id_level_user' => $data['id_level_user'],
					'logged_in' => true,
				));
				redirect('admin/dashboard');
		}else{
			$this->session->set_flashdata('message', 'Kombinasi Username & Password Salah, Mohon di cek ulang');
			redirect('admin/login');
		}
	}

	public function logout_proc()
	{
		if ($this->session->userdata('logged_in')) 
		{
			//$this->session->sess_destroy();
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('id_user');
			$this->session->unset_userdata('id_level_user');
			$this->session->unset_userdata('kode_agen');
			$this->session->set_userdata(array('logged_in' => false));
		}
		
		echo json_encode(['status' => 'success']);
	}

	public function lihat_pass($username)
	{
		$this->load->library('Enkripsi');
		$data = $this->db->query("select password from m_user where username = '$username'")->row();
		$str_dec = $this->enkripsi->decrypt($data->password);
		echo $str_dec;
	}

	public function dekrip($value)
	{
		$this->load->library('Enkripsi');
		// $val = 'uLDa2OXihpeB';
		$str = $this->enkripsi->decrypt($value);
		echo $str;
	}
	
}
