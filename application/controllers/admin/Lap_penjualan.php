<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_penjualan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_penjualan', 'm_jual');
		
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
			'view'	=> 'adm_view/laporan/v_lap_penjualan'
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

		//assign satu row array untuk saldo awal
		$arr_data[0]['tanggal'] = date('d-m-Y', strtotime($tahun .'-'. $bulan.'-01'));
		$arr_data[0]['kode_ref'] = '-';
		$arr_data[0]['keterangan'] = 'Saldo Awal';
		$arr_data[0]['penerimaan'] = '-';
		$arr_data[0]['laba_agen'] = '-';
		$arr_data[0]['penerimaan_raw'] = 0;
		$arr_data[0]['laba_agen_raw'] = 0;
		$arr_data[0]['saldo_akhir'] = $saldo_awal;

		$query_lap = $this->m_jual->get_detail_lap($tanggal_awal, $tanggal_akhir);
		if ($query_lap) {
			foreach ($query_lap as $key => $val) 
			{
				$arr_data[$key+1]['tanggal'] = date('d-m-Y', strtotime($val->created_at));
				$arr_data[$key+1]['kode_ref'] = $val->kode_ref;
				
				if ($val->jenis == 'affiliate') {
					$arr_data[$key+1]['keterangan'] = 'Pendaftaran Affiliate a/n : '.$val->nama_lengkap;
				}else{
					$arr_data[$key+1]['keterangan'] = 'Pendaftaran Member a/n : '.$val->nama_lengkap;
				}

				$arr_data[$key+1]['penerimaan'] = number_format($val->harga_total,2,",",".");
				$arr_data[$key+1]['penerimaan_raw'] = $val->harga_total;
				$arr_data[$key+1]['laba_agen'] = number_format($val->laba_agen_total,2,",",".");
				$arr_data[$key+1]['laba_agen_raw'] = $val->laba_agen_total;

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
			'view'	=> 'adm_view/laporan/v_lap_penjualan_detail'
		];

		$this->template_view->load_view($content, $data);
	}

	public function cetak_report($bulan, $tahun)
	{
		// $this->load->library('Pdf_gen');
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$arr_bulan = $this->arr_bulan();

		$periode = $arr_bulan[$bulan].' '.$tahun;
		$saldo_awal = 0;
		$saldo_akhir = 0;
		$arr_data = [];

		$tanggal_awal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 00:00:00'));
		$tanggal_akhir = date('Y-m-t H:i:s', strtotime($tahun . '-' . $bulan . '-01 23:59:59'));

		$saldo_awal += $this->m_jual->get_saldo_awal_lap($tanggal_awal);

		//assign satu row array untuk saldo awal
		$arr_data[0]['tanggal'] = date('d-m-Y', strtotime($tahun .'-'. $bulan.'-01'));
		$arr_data[0]['kode_ref'] = '-';
		$arr_data[0]['keterangan'] = 'Saldo Awal';
		$arr_data[0]['penerimaan'] = '-';
		$arr_data[0]['laba_agen'] = '-';
		$arr_data[0]['penerimaan_raw'] = 0;
		$arr_data[0]['laba_agen_raw'] = 0;
		$arr_data[0]['saldo_akhir'] = $saldo_awal;

		$query_lap = $this->m_jual->get_detail_lap($tanggal_awal, $tanggal_akhir);
		if ($query_lap) {
			foreach ($query_lap as $key => $val) 
			{
				$arr_data[$key+1]['tanggal'] = date('d-m-Y', strtotime($val->created_at));
				$arr_data[$key+1]['kode_ref'] = $val->kode_ref;
				
				if ($val->jenis == 'affiliate') {
					$arr_data[$key+1]['keterangan'] = 'Pendaftaran Affiliate a/n : '.$val->nama_lengkap;
				}else{
					$arr_data[$key+1]['keterangan'] = 'Pendaftaran Member a/n : '.$val->nama_lengkap;
				}

				$arr_data[$key+1]['penerimaan'] = number_format($val->harga_total,2,",",".");
				$arr_data[$key+1]['penerimaan_raw'] = $val->harga_total;
				$arr_data[$key+1]['laba_agen'] = number_format($val->laba_agen_total,2,",",".");
				$arr_data[$key+1]['laba_agen_raw'] = $val->laba_agen_total;

				//saldo
				$saldo_akhir += (int)$saldo_awal + (int)$val->harga_total - (int)$val->laba_agen_total;
				
				//set saldo awal to 0
				$saldo_awal = 0;
				$arr_data[$key+1]['saldo_akhir'] = (int)$saldo_akhir;
			}
		}

		$data = array(
			'data_user' => $data_user,
			'arr_bulan' => $this->arr_bulan(),
			'periode' => $periode,
			'hasil_data' => $arr_data,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'title' => 'Laporan Penjualan'
		);
	    
	    $this->load->view('adm_view/laporan/v_lap_penjualan_cetak', $data);
	    
	    // $html = $this->load->view('adm_view/laporan/v_lap_penjualan_agen_cetak', $data, true);
	    // $filename = 'laporan_komisi_agen_'.time();
	    // $this->pdf_gen->generate($html, $filename, true, 'A4', 'landscape');
	}

}//end of class penjualan.php
