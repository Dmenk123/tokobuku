<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_penjualan_agen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_penjualan', 'm_jual');
	}

	private function arr_bulan()
	{
		$data = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		return $data;
	}

	public function index()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'arr_bulan' => $this->arr_bulan(),
			'cek_kunci' => FALSE
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_lap_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/laporan/v_lap_penjualan_agen'
		];

		$this->template_view->load_view($content, $data);
	}

	public function lap_detail()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$arr_bulan = $this->arr_bulan();

		$bulan = clean_string($this->input->get('bulan'));
		$tahun = clean_string($this->input->get('tahun'));
		$periode = $arr_bulan[$bulan].' '.$tahun;
		$saldo_awal = 0;
		$saldo_akhir = 0;
		$arr_data = [];

		$tanggal_awal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 00:00:00'));
		$tanggal_akhir = date('Y-m-t H:i:s', strtotime($tahun . '-' . $bulan . '-01 23:59:59'));

		$saldo_awal += $this->m_jual->get_saldo_awal_lap($tanggal_awal);
		$query_lap = $this->m_jual->get_detail_lap_agen($tanggal_awal, $tanggal_akhir);
		// echo $this->db->last_query();exit;
		if ($query_lap) {
			foreach ($query_lap as $key => $val) 
			{
				$arr_data[$key]['tanggal'] = date('d-m-Y', strtotime($val->created_at));
				$arr_data[$key]['kode_ref'] = $val->kode_ref;
				
				if ($val->jenis == 'affiliate') {
					$arr_data[$key]['keterangan'] = 'Pendaftaran Affiliate a/n : '.$val->nama_lengkap;
				}else{
					$arr_data[$key]['keterangan'] = 'Pendaftaran Member a/n : '.$val->nama_lengkap;
				}

				$arr_data[$key]['penerimaan'] = number_format($val->harga_total,2,",",".");
				$arr_data[$key]['laba_agen'] = number_format($val->laba_agen_total,2,",",".");

				//saldo
				$saldo_akhir += (int)$saldo_awal + (int)$val->harga_total - (int)$val->laba_agen_total;
				
				//set saldo awal to 0
				$saldo_awal = 0;
				$arr_data[$key+1]['saldo_akhir'] = (int)$saldo_akhir;
			}
		}

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'arr_bulan' => $this->arr_bulan(),
			'cek_kunci' => FALSE,
			'periode' => $periode,
			'hasil_data' => $arr_data,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'cek_status_kunci' => TRUE //sementara di set true, soalnya belum tau ada konsep kuncian atau tidak
		);

		$content = [
			'css' => false,
			'js'	=> 'adm_view/js/js_lap_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/laporan/v_lap_penjualan_agen_detail'
		];

		$this->template_view->load_view($content, $data);
	}

}//end of class penjualan.php
