<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Set_harga extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_set_harga', 'm_sh');

		/* //pesan stok minimum
		$produk = $this->m_user->get_produk();
		$link_notif = site_url('laporan_stok');
		foreach ($produk as $val) {
			if ($val->stok_sisa <= $val->stok_minimum) {
				$this->session->set_flashdata('cek_stok', 'Terdapat Stok produk dibawah nilai minimum, Mohon di cek ulang <a href="'.$link_notif.'">disini</a>');
			}
		} */
	}

	public function index()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_set_harga',
			'modal' => false,
			'view'	=> 'adm_view/set_harga/v_set_harga'
		];

		$this->template_view->load_view($content, $data);
	}

	public function add()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_set_harga',
			'modal' => false,
			'view'	=> 'adm_view/set_harga/v_add_set_harga'
		];

		$this->template_view->load_view($content, $data);
	}

	public function add_data()
	{
		$arr_valid = $this->_validate();
		$kategori = trim(clean_string($this->input->post('kategori')));
		$harga = trim(clean_string($this->input->post('harga')));
		$harga_raw = trim(clean_string($this->input->post('harga_raw')));
		$potongan = trim(clean_string($this->input->post('potongan')));
		$potongan_agen = trim(clean_string($this->input->post('potongan_agen')));
		$tanggal_aktif = date('Y-m-d h:i:s', strtotime(trim(clean_string($this->input->post('tanggal_aktif').' 00:00:00'))));
		
		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		$this->db->trans_begin();
		$harga_diskon = (int)$harga_raw * (int)$potongan / 100;
		$harga_nett = (int)$harga_raw - (int)$harga_diskon;
		$harga_diskon_agen = (int)$harga_nett * (int)$potongan_agen / 100;

		$id = $this->m_global->gen_uuid();
		
		$data = array(
			'id' => $id,
			'harga_satuan' => $harga_raw,
			'created_at' => date('Y-m-d H:i:s'),
			'diskon_agen' => $potongan_agen,
			'harga_diskon_agen' => $harga_diskon_agen,
			'is_aktif' => 1,
			'diskon_paket' => $potongan,
			'harga_diskon_paket' => $harga_nett,
			'tanggal_berlaku' => $tanggal_aktif,
			'jenis' => $kategori
		);

		//insert produk
		$insert = $this->m_sh->insert_data($data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('feedback_failed', 'Gagal Buat Set Harga.');
			$status = FALSE;
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('feedback_success', 'Berhasil Buat Set Harga');
			$status = TRUE;
		}

		echo json_encode(array(
			"status" => $status
		));
	}

	public function edit($id)
	{
		// $arr_valid = $this->_validate();
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$isi_notif = [];

		$harga = $this->m_sh->get_data_log_harga($id);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'data_harga' => $harga
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_set_harga',
			'modal' => false,
			'view'	=> 'adm_view/set_harga/v_edit_set_harga'
		];

		$this->template_view->load_view($content, $data);
	}

	public function update_data()
	{
		$arr_valid = $this->_validate();
		$id = clean_string($this->input->post('id'));
		$kategori = trim(clean_string($this->input->post('kategori')));
		$harga = trim(clean_string($this->input->post('harga')));
		$harga_raw = trim(clean_string($this->input->post('harga_raw')));
		$potongan = trim(clean_string($this->input->post('potongan')));
		$potongan_agen = trim(clean_string($this->input->post('potongan_agen')));
		$sts_aktif = trim(clean_string($this->input->post('sts_aktif')));
		$tanggal_aktif = date('Y-m-d h:i:s', strtotime(trim(clean_string($this->input->post('tanggal_aktif').' 00:00:00'))));

		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		$this->db->trans_begin();
		$harga_diskon = (int)$harga_raw * (int)$potongan / 100;
		$harga_nett = (int)$harga_raw - (int)$harga_diskon;
		$harga_diskon_agen = (int)$harga_nett * (int)$potongan_agen / 100;

		$data['harga_satuan'] = $harga_raw;
		$data['diskon_agen'] = $potongan_agen;
		$data['harga_diskon_agen'] = $harga_diskon_agen;
		$data['is_aktif'] = $sts_aktif;
		$data['diskon_paket'] = $potongan;
		$data['harga_diskon_paket'] = $harga_nett;
		$data['tanggal_berlaku'] = $tanggal_aktif;
		$data['jenis'] = $kategori;
		
		//update data
		$this->m_sh->update_data(array('id' => $id), $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('feedback_failed', 'Gagal Update Set Harga.');
			$status = FALSE;
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('feedback_success', 'Berhasil Update Set Harga');
			$status = TRUE;
		}

		echo json_encode(array(
			"status" => $status
		));
	}

	public function list_data()
	{
		$list = $this->m_sh->get_datatable();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $datalist) {
			$no++;
			$link_edit = site_url('admin/set_harga/edit/') . $datalist->id;
			$row = array();
			$row[] = $datalist->jenis;
			$row[] = "Rp. " . number_format($datalist->harga_satuan, 0, ",", ".");
			$row[] = $datalist->diskon_agen.' %';
			$row[] = "Rp. " . number_format($datalist->harga_diskon_agen, 0, ",", ".");
			$row[] = $datalist->diskon_paket.' %';
			$row[] = "Rp. " . number_format($datalist->harga_diskon_paket, 0, ",", ".");
			$row[] = date('d-m-Y H:i', strtotime($datalist->tanggal_berlaku));
			//add html for action button
			
			// $strVal = $this->template_view->returnGetDetailButton($link_detail);
			$strVal = $this->template_view->returnGetEditButton($link_edit);
			// $strVal .= '<a class="btn btn-sm btn-success btn_edit_status" href="javascript:void(0)" title="aktif" id="' . $datalist->id . '"><i class="fa fa-check"></i> Aktif</a>';
			$row[] = $strVal;

			$data[] = $row;
		} //end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_sh->count_all(),
			"recordsFiltered" => $this->m_sh->count_filtered(),
			"data" => $data,
		);
		
		echo json_encode($output);
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('harga_raw') == '' || $this->input->post('harga_raw') == '0') {
			$data['inputerror'][] = 'harga';
			$data['error_string'][] = 'Wajib mengisi Harga';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tanggal_aktif') == '') {
			$data['inputerror'][] = 'tanggal_aktif';
			$data['error_string'][] = 'Wajib mengisi Tanggal Aktif';
			$data['status'] = FALSE;
		}

		return $data;
	}


	// =========================================================================================================================
	
}//end of class Master_produk_admp.php
