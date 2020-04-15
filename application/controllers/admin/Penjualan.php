<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
			'js'	=> 'adm_view/js/js_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/penjualan/v_penjualan'
		];

		$this->template_view->load_view($content, $data);
	}

	public function list_penjualan($status = 0, $bulan, $tahun)
	{
		$tanggal_awal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 00:00:00'));
		$tanggal_akhir = date('Y-m-t H:i:s', strtotime($tahun . '-' . $bulan . '-01 23:59:59'));
		$list = $this->m_jual->get_datatables($status, $tanggal_awal, $tanggal_akhir);
		
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $datalist) 
		{
			$link_edit = site_url('admin/penjualan/penjualan_edit/') . $datalist->id;
			$no++;
			$row = array();
			// $row[] = $datalist->id;
			$row[] = date('d-m-Y', strtotime($datalist->created_at));
			$row[] = $datalist->nama_lengkap;
			$row[] = $datalist->email;
			$row[] = "Rp. " . number_format($datalist->harga_total, 0, ",", ".");
			if ($datalist->status == 1) {
				$row[] = '<span style="color:red">Belum Di Verifikasi</span>';
			} else {
				$row[] = '<span style="color:green">Sudah Di Verifikasi</span>';
			}
			//cek kuncian
			//$cek_kunci = $this->cek_status_kuncian(date('m', strtotime($datalist->tanggal)), date('Y', strtotime($datalist->tanggal)));
			$cek_kunci = FALSE;

			if ($cek_kunci) {
				$link_detail = site_url('admin/penjualan/penjualan_detail/') . $datalist->id.'/'.$status.'/'.$bulan.'/'.$tahun;
				$row[] = '<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>';
			} else {
				if ($datalist->status == 1) {
					$link_detail = site_url('admin/penjualan/penjualan_detail/') . $datalist->id.'/'.$status.'/'.$bulan.'/'.$tahun;
					$row[] = '
						<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>
						<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Batalkan Transaksi" onclick="batalkanPenjualan(' . "'" . $datalist->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i></a>
					';
				}else{
					$link_detail = site_url('admin/penjualan/penjualan_detail/') . $datalist->id.'/'.$status.'/'.$bulan.'/'.$tahun;
					$row[] = '
						<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>
						<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Batalkan" onclick="batalkanVerify(' . "'" . $datalist->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i></a>
					';
				}
				
			}

			$data[] = $row;
		} //end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_jual->count_all($status, $tanggal_awal, $tanggal_akhir),
			"recordsFiltered" => $this->m_jual->count_filtered($status, $tanggal_awal, $tanggal_akhir),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function penjualan_detail($id, $status, $bulan, $tahun)
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$query_user = $this->m_user->get_detail_user($id_user);

		$query = $this->m_jual->get_detail($id, $status);

		$data = array(
			'isi_notif' => $isi_notif,
			'data_user' => $query_user,
			'hasil_data' => $query,
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$content = [
			'css' 	=> null,
			'js'	=> 'adm_view/js/js_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/penjualan/v_detail_penjualan'
		];

		$this->template_view->load_view($content, $data);
	}

	public function konfirmasi_penjualan($id, $bulan, $tahun)
	{
		$table = 't_checkout';
		$data = [
			'status' => 0,
			'is_konfirm' => 1
		];
		$data_where = ['id' => $id];
		$query = $this->m_global->updateData2($table,$data_where,$data);

		if ($query) {
			$status = TRUE;
		}else{
			$status = FALSE;
		}

		echo json_encode([
			'status' => $status,
			'bulan' => $bulan,
			'tahun' => $tahun
		]);
	}

	public function batal_penjualan($id, $bulan, $tahun)
	{
		$table = 't_checkout';
		$data = [
			'status' => 2,
			'is_konfirm' => 0
		];
		$data_where = ['id' => $id];
		$query = $this->m_global->updateData2($table,$data_where,$data);

		if ($query) {
			$status = TRUE;
		}else{
			$status = FALSE;
		}
		
		//cek data di user jika daftar affiliate
		$select = "*";
		$where = ['id' => $id];
		$ckt = $this->m_global->get_data_single($select, 't_checkout', $where, null, null);
		$email = $ckt->email;

		$select2 = "*";
		$where2 = ['email' => $email];
		$user_det = $this->m_global->get_data_single($select2, 'm_user_detail', $where2, null, null);
		if ($user_det) {
			$upd_user = $this->m_global->updateData2('m_user', ['id_user' => $user_det->id_user], ['status' => 0]);
			if ($upd_user) {
				$status = TRUE;
			}
		}

		echo json_encode([
			'status' => $status,
			'bulan' => $bulan,
			'tahun' => $tahun
		]);
	}

	public function batal_verify($id, $bulan, $tahun)
	{
		$table = 't_checkout';
		$data = [
			'status' => 1,
			'is_konfirm' => 0
		];
		$data_where = ['id' => $id];
		$query = $this->m_global->updateData2($table,$data_where,$data);

		if ($query) {
			$status = TRUE;
		}else{
			$status = FALSE;
		}

		echo json_encode([
			'status' => $status,
			'bulan' => $bulan,
			'tahun' => $tahun
		]);
	}
	
}//end of class penjualan.php

