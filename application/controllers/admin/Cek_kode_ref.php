<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cek_kode_ref extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		
		if (!$this->session->userdata('id_user')) {
			return redirect('admin/login','refresh');
		}
	}

	private function arr_bulan()
	{
		$data = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		return $data;
	}

	public function index()
	{
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'data_user' => $data_user,
			'arr_bulan' => $this->arr_bulan(),
			'cek_kunci' => FALSE
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> false,
			'modal' => false,
			'view'	=> 'adm_view/cek_kode_ref/v_cek_kode_ref'
		];

		$this->template_view->load_view($content, $data);
	}

	public function detail()
	{
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$tipe = clean_string($this->input->get('tipe'));
		$koderef = clean_string($this->input->get('koderef'));
		
		if ($tipe == '' || $koderef == '') {
			return redirect('admin/cek_kode_ref','refresh');
		}

		if ($tipe == 'TRANS') {
			$q = $this->db->query("
				SELECT t_checkout.*, m_user_detail.nama_lengkap_user as nama_agen
				FROM t_checkout 
				LEFT JOIN m_user on t_checkout.kode_agen = m_user.kode_agen
				LEFT JOIN m_user_detail on m_user.id_user = m_user_detail.id_user
				WHERE t_checkout.kode_ref like '%".$koderef."%'"
			)->result();
		}else{
			$q = $this->db->query("
				SELECT t_klaim_agen.*, m_user.username, m_user_detail.nama_lengkap_user, m_user_detail.rekening, m_user_detail.no_telp_user, m_user_detail.email, m_user_detail.bank
				FROM t_klaim_agen 
				LEFT JOIN m_user on t_klaim_agen.id_agen = m_user.kode_agen
				LEFT JOIN m_user_detail on m_user.id_user = m_user_detail.id_user 
				WHERE kode_klaim like '%".$koderef."%'")->result();
		}

		$retval = [];
		foreach ($q as $key => $value) {
			$retval[$key]['no'] = $key += 1;
			if ($tipe == 'TRANS') {
				$retval[$key]['nama_lengkap'] = $value->nama_depan;
				$retval[$key]['kode_ref'] = $value->kode_ref;
				$retval[$key]['telepon'] = $value->telepon;
				$retval[$key]['nilai'] = "Rp. " . number_format($value->harga_total, 0, ",", ".");
				if ($value->nama_agen) {
					$retval[$key]['keterangan'] = "Agen : ".$value->nama_agen." | Laba : "."Rp. " . number_format($value->laba_agen_total, 0, ",", ".");
				}else{
					$retval[$key]['keterangan'] = ' - ';
				}
				
			}else{
				$retval[$key]['nama_lengkap'] = $value->nama_lengkap_user;
				$retval[$key]['kode_ref'] = $value->kode_klaim;
				$retval[$key]['telepon'] = $value->no_telp_user;
				$retval[$key]['nilai'] = "Rp. " . number_format($value->jumlah_klaim, 0, ",", ".");
				$retval[$key]['keterangan'] = "Rekening : ".$value->rekening." | Bank : ".$value->bank;
			}
			
			$retval[$key]['email'] = $value->email;
			$retval[$key]['tanggal'] = date('d-m-Y H:i:s', strtotime($value->created_at));
		}

		$data = array(
			'hasil_data' 	=> $retval,
			'data_user' 	=> $data_user,
			'arr_bulan' 	=> $this->arr_bulan(),
			'cek_kunci' 	=> FALSE
		);

		$content = [
			'css' 	=> false,
			'js'	=> false,
			'modal' => false,
			'view'	=> 'adm_view/cek_kode_ref/v_cek_kode_ref'
		];

		$this->template_view->load_view($content, $data);
	}
	
}//end of class penjualan.php
