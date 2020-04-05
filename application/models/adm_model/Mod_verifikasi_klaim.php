<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mod_verifikasi_klaim extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
		"tka.created_at",
		"mud.nama_lengkap_user",
		"mud.email",
		"tka.jumlah_klaim",
		null
	);

	var $column_order = array(
		"tka.created_at",
		"mud.nama_lengkap_user",
		"mud.email",
		"tka.jumlah_klaim",
		null,
		null,
	);

	var $order = array('tr.id_pembelian' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($term = '', $status, $tanggal_awal, $tanggal_akhir)
	{
		
		$column = array(
			"tka.created_at",
			"mud.nama_lengkap_user",
			"mud.email",
			"tka.jumlah_klaim",
			null,
			null,
		);

		$this->db->select("tka.*, mud.nama_lengkap_user, mud.email");
		$this->db->from('t_klaim_agen as tka');
		$this->db->join('m_user mu', 'tka.id_agen = mu.kode_agen', 'left');
		$this->db->join('m_user_detail mud', 'mu.id_user = mud.id_user', 'left');
		if ($status == 'null') {
			$this->db->where("tka.id_user_verify is null");
		}else{
			$this->db->where('tka.id_user_verify', $status);	
		}
		
		$this->db->where("tka.created_at between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "'");

		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i)
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($status, $tanggal_awal, $tanggal_akhir)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatables_query($term, $status, $tanggal_awal, $tanggal_akhir);

		if ($_REQUEST['length'] != -1)
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($status, $tanggal_awal, $tanggal_akhir)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatables_query($term, $status, $tanggal_awal, $tanggal_akhir);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($status, $tanggal_awal, $tanggal_akhir)
	{
		$this->db->select("tka.*, mud.nama_lengkap_user");
		$this->db->from('t_klaim_agen as tka');
		$this->db->join('m_user mu', 'tka.id_agen = mu.kode_agen', 'left');
		$this->db->join('m_user_detail mud', 'mu.id_user = mud.id_user', 'left');
		if ($status == 'null') {
			$this->db->where("tka.id_user_verify is null");
		}else{
			$this->db->where('tka.id_user_verify', $status);	
		}
		$this->db->where("tka.created_at between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "'");
		
		return $this->db->count_all_results();
	}
	//end datatable query master produk

	public function get_detail($id)
	{
		$this->db->select("tc.*, CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap, mu.username as username_agen, mud.nama_lengkap_user, mud.bank, mud.rekening, mud.email, mud.no_telp_user, tka.created_at as tgl_klaim, tka.kode_klaim");
		$this->db->from('t_checkout as tc');
		$this->db->join('t_klaim_agen tka', 'tc.id_klaim_agen = tka.id', 'left');
		$this->db->join('m_user mu', 'tc.kode_agen = mu.kode_agen', 'left');
		$this->db->join('m_user_detail mud', 'mu.id_user = mud.id_user', 'left');
		$this->db->where("tc.id_klaim_agen = '".$id."'");
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function get_saldo_awal_lap($datetime)
	{
		$q = $this->db->query("SELECT (sum(harga_total) - sum(laba_agen_total)) as saldo_awal FROM t_checkout where status = 0 and is_konfirm = 1 and created_at <= '".$datetime."'")->row();
		if ($q) {
			return $q->saldo_awal;
		}else{
			return 0;
		}
	}

	public function get_detail_lap($datetime_awal, $datetime_akhir)
	{
		$this->db->select("tc.*, CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap, mu.username as username_agen, mud.nama_lengkap_user");
		$this->db->from('t_checkout as tc');
		$this->db->join('m_user mu', 'tc.kode_agen = mu.kode_agen', 'left');
		$this->db->join('m_user_detail mud', 'mu.id_user = mud.id_user', 'left');
		$this->db->where('tc.status', 0);
		$this->db->where('tc.is_konfirm', 1);
		$this->db->where("tc.created_at between '" . $datetime_awal . "' and '" . $datetime_akhir . "'");
		$this->db->order_by('tc.created_at', 'asc');
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	//=================================================================================================================================================
}
