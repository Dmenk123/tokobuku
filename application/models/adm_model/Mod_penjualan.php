<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mod_penjualan extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
		"tc.created_at",
		"mud.nama_lengkap_user",
		"mud.email",
		"tc.harga_total",
	);

	var $column_order = array(
		"tc.created_at",
		"mud.nama_lengkap_user",
		"mud.email",
		"tc.harga_total",
		"tc.status",
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
			"tc.created_at",
			"mud.nama_lengkap_user",
			"mud.email",
			"tc.harga_total",
			"tc.status",
			null,
		);

		$this->db->select("
			tc.*,
			mud.nama_lengkap_user,
			mud.email
		");
		
		$this->db->from('t_checkout as tc');
		$this->db->join('m_user_detail as mud', 'tc.id_user = mud.id_user', 'left');
		$this->db->where('tc.status', $status);
		$this->db->where("tc.created_at between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "'");

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

	function get_datatables($status = 0, $tanggal_awal, $tanggal_akhir)
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
		$this->db->select("
			tc.*,
			mud.nama_lengkap_user,
			mud.email
		");

		$this->db->from('t_checkout as tc');
		$this->db->join('m_user_detail as mud', 'tc.id_user = mud.id_user', 'left');
		$this->db->where('tc.status', $status);
		$this->db->where("tc.created_at between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "'");
		
		return $this->db->count_all_results();
	}
	//end datatable query master produk

	public function get_detail_header($id, $status)
	{
		$this->db->select('tc.*,mud.nama_lengkap_user,mud.email');
		$this->db->from('t_checkout as tc');
		$this->db->join('m_user_detail as mud', 'tc.id_user = mud.id_user', 'left');
		$this->db->where('tc.id', $id);
		$this->db->where('tc.status', $status);
		
		$query = $this->db->get()->row();
		return $query;
	}

	public function get_detail($id, $status)
	{
		$this->db->select('tcd.*, mp.kode as kode_produk,mp.nama as nama_produk, ms.nama as nama_satuan, mp.gambar_1');
		$this->db->from('t_checkout_detail tcd');
		$this->db->join('t_checkout tc', 'tcd.id_checkout = tc.id', 'left');
		$this->db->join('m_produk mp', 'tcd.id_produk = mp.id', 'left');
		$this->db->join('m_satuan ms', 'tcd.id_satuan = ms.id', 'left');
		
		$this->db->where('tcd.id_checkout', $id);
		$this->db->where('tc.status', $status);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	//=================================================================================================================================================

	public function get_data_satuan()
	{
		$query = $this->db->get('m_satuan');
		return $query->result();
	}

	public function get_data_kategori()
	{
		$query = $this->db->get('m_kategori');
		return $query->result();
	}

	public function get_akronim_kategori($id_kategori)
	{
		$this->db->select('akronim');
		$this->db->from('m_kategori');
		$this->db->where('id', $id_kategori);
		$query = $this->db->get();

		$hasil = $query->row();
		return $hasil->akronim;
	}

	public function get_kode_produk($akronim)
	{
		$q = $this->db->query("select MAX(RIGHT(kode,5)) as kode_max from m_produk where kode like '%$akronim%'");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $hasil) {
				$tmp = ((int) $hasil->kode_max) + 1;
				$kd = sprintf("%05s", $tmp);
			}
		} else {
			$kd = "00001";
		}
		return "$akronim" . $kd;
	}

	public function insert_data_produk($data)
	{
		$this->db->insert('m_produk', $data);
	}

	public function insert_data_harga($data)
	{
		$this->db->insert('t_log_harga', $data);
	}

	public function update_data_produk($where, $data)
	{
		$this->db->update('m_produk', $data, $where);
	}

	public function update_data_harga($where, $data)
	{
		$this->db->update('t_log_harga', $data, $where);
	}




	public function get_detail_produk_header($id_produk)
	{
		$this->db->select('
				tbl_gambar_produk.nama_gambar,
				m_produk.id_produk,
				m_produk.nama_produk,
			');

		$this->db->from('m_produk');
		$this->db->join('tbl_gambar_produk', 'm_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->where('m_produk.id_produk', $id_produk);
		$this->db->group_by('tbl_gambar_produk.id_produk');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function insert_data_gambar($data)
	{
		$this->db->insert('tbl_gambar_produk', $data);
	}

	public function update_data_gambar($where, $data)
	{
		$this->db->update('tbl_gambar_produk', $data, $where);
	}

	public function insert_data_produk_detail($data)
	{
		$this->db->insert('tbl_stok', $data);
	}

	public function update_data_produk_detail($where, $data)
	{
		$this->db->update('tbl_stok', $data, $where);
	}

	public function cek_size_produk($size, $id_produk)
	{
		$this->db->select('ukuran_produk');
		$this->db->from('tbl_stok');
		$this->db->where('id_produk', $id_produk);
		$this->db->where('ukuran_produk', $size);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$hasil = $query->row();
			return $hasil->ukuran_produk;
		} else {
			return "Ukuran Belum Ada";
		}
	}



	public function get_data_gbr_detail($id_produk)
	{
		$this->db->select('id_gambar, nama_gambar, id_produk');
		$this->db->from('tbl_gambar_produk');
		$this->db->where('id_produk', $id_produk);
		$this->db->where('jenis_gambar', 'detail');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function update_status_produk($where, $data)
	{
		$this->db->update("m_produk", $data, $where);
	}

	public function update_status_produk_detail($where, $data)
	{
		$this->db->update("tbl_stok", $data, $where);
	}

	public function get_data_produk_detail($id_stok)
	{
		$this->db->select('id_stok, ukuran_produk, berat_satuan, stok_awal, stok_minimum');
		$this->db->from('tbl_stok');
		$this->db->where('id_stok', $id_stok);
		$query = $this->db->get();
		return $query->row();
	}
}
