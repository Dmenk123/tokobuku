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

	public function index()
	{
		$this->load->view('v_navbar');
		$this->load->view('v_join_member');
		$this->load->view('footer');
	}

	public function result_page()
	{
		$flag_sesi = FALSE;
		if ($this->session->flashdata('feedback_success')) {
			$flag_sesi = TRUE;
		}

		if ($this->session->flashdata('feedback_failed')) {
			$flag_sesi = TRUE;
		}

		if ($flag_sesi === FALSE) {
			return redirect('home','refresh');
		}

		$this->load->view('v_navbar');
		$this->load->view('v_result_member');
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
		$email = clean_string($this->input->post('email'));
		$telp = clean_string($this->input->post('telp'));
		$namafileseo = $this->seoUrl('Bukti-'.$fname.' '.time());

		if ($arr_valid['status'] == FALSE) {
			$str_flash = 'Gagal menyimpan Data, pastikan telah mengisi semua inputan.';
			$str_flash .= '<hr>';
			foreach ($arr_valid['error_string'] as $key => $val) {
				$str_flash .= '<li>'.$val.'</li>';
			}
			$this->session->set_flashdata('feedback_failed', $str_flash); 
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
			//$ifile = '/bookstore/assets/img/bukti_transfer/' . $namafileseo . '.' . $ext;
			//unlink($_SERVER['DOCUMENT_ROOT'] . $ifile); // use server document root

		} else {
			$this->session->set_flashdata('feedback_failed','Gagal menyimpan Data, pastikan telah Upload Bukti Transfer.'); 
			redirect('join_member');
		}

		$this->db->trans_begin();
		$id = $this->mod_global->gen_uuid();
		$kode_ref = $this->incrementalHash();

		$select = "*";
		$where = ['tanggal_berlaku' < date('Y-m-d H:i:s'), 'jenis' => 'paket'];
		$order = 'tanggal_berlaku DESC';
		$harga = $this->mod_global->get_data_single($select, 't_log_harga', $where, null, $order);

		if ((int)$harga->diskon_paket != 0) {
			$harga_total = $harga->harga_diskon_paket;
			$diskon_total = (int)$harga->harga_satuan - (int)$harga->harga_diskon_paket;
		}else{
			$harga_total = $harga->harga_satuan;
			$diskon_total = 0;
		}

		if ($this->session->userdata('kode_agen') != null) {
			$kode_agen = $this->session->userdata('kode_agen');
			$laba_agen = $harga->harga_diskon_agen;
		}else{
			$kode_agen = null;
			$laba_agen = 0;
		}

		$data = array(
			'id' => $id,
			'id_user' => null,
			'harga_total' => $harga_total,
			'laba_agen_total' => $laba_agen,
			'diskon_total' => $diskon_total,
			'is_konfirm' => 0,
			'nama_depan' => $fname,
			'email' => $email,
			'telepon' => $telp,
			'bukti' => $arr_gambar['nama_gambar'],
			'created_at' => date('Y-m-d H:i:s'),
			'kode_ref' => $kode_ref,
			'kode_agen' => $kode_agen
		);

		$insert = $this->mod_global->insert_data('t_checkout', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('feedback_failed', 'Gagal Melakukan Pendaftaran.');
			redirect('join_member/result_page');
		} else {
			$this->db->trans_commit();		
			
			if ($this->session->userdata('kode_agen') != null) {
				$this->session->unset_userdata('kode_agen');
			}
			
			$this->session->set_flashdata('feedback_success', $kode_ref);
			redirect('join_member/result_page');
		}
	}

	private function get_recaptcha($token)
	{
		$genCaptcha = $this->recaptcha->generate();
		
		$resp = $genCaptcha->setExpectedHostname('majangdapatuang.com')
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

		return $data;
	}

	private function seoUrl($string)
	{
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

	public function incrementalHash($len = 5)
	{
		$charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$base = strlen($charset);
		$result = '';

		$now = explode(' ', microtime())[1];
		while ($now >= $base) {
			$i = $now % $base;
			$result = $charset[$i] . $result;
			$now /= $base;
		}

		return substr($result, -5);
	}	

}
