<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('adm_model/Mod_dashboard_adm','m_dasbor');
		$this->load->model('adm_model/Mod_user','m_user');
		$this->load->model('mod_global', 'm_global');
		// $this->load->library('flashdata_stokmin');
		
		if ($this->session->userdata('logged_in') != true) {
			redirect('admin/login');
		}
	}

	public function index()
	{
		$bln_now = date('m');
		$thn_now = date('Y');
		$tanggal_awal = $thn_now.'-'.$bln_now.'-01';
		$tanggal_akhir = date('Y-m-t', strtotime($tanggal_awal));
		
		$id_user = $this->session->userdata('id_user');
		$query = $this->m_user->get_detail_user($id_user);

		$data_dashboard = [];
		/* $where_notif = 'datetime_verify is not null';
		$query_notif = $this->m_global->get_data('*', 't_klaim_agen', $where = $where_notif, $join = array(), $order = FALSE, $limit = FALSE, $start = FALSE);
		
		$isi_notif = $query_notif;
		$qty_notif = count($query_notif); */

		$data = [
			'data_user' => $query,
			// 'isi_notif' => $isi_notif,
			// 'qty_notif' => $qty_notif
		];

		$content = [
			'modal' => false,
			// 'js'	=> 'jsDashboardAdm',
			'js' => false,
			'css'	=> false,
			'view'	=> 'adm_view/v_dashboard_adm'
		];
		
		$this->template_view->load_view($content, $data);
	}

	/* public function get_id_vendor($value='')
	{
		$id_user = $this->session->userdata('id_user'); 
		$where_user = ['id_user' => $id_user];
		$d_vendor = $this->m_jual->get_by_id_advanced(false, 'tbl_vendor', $where_user, false, false, true);
		$id_vendor = $d_vendor['id_vendor'];
		return $id_vendor;
	} */

	public function bulan_indo($bulan)
	{
		$arr = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];

		return $arr[$bulan];
	}

}
