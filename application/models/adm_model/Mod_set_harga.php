<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mod_set_harga extends CI_Model
{
	var $column_search = array(
		'jenis',
		'harga_satuan',
		'diskon_agen',
		'harga_diskon_agen',
		'diskon_paket',
		'harga_diskon_paket',
		'tanggal_berlaku',
		null,
	);

	var $column_order = array(
		'jenis',
		'harga_satuan',
		'diskon_agen',
		'harga_diskon_agen',
		'diskon_paket',
		'harga_diskon_paket',
		'tanggal_berlaku',
		null,
	);

	var $order = array('tanggal_berlaku' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatable_query($term = '') //term is value of $_REQUEST['search']
	{
		$column = array(
			'jenis',
			'harga_satuan',
			'diskon_agen',
			'harga_diskon_agen',
			'diskon_paket',
			'harga_diskon_paket',
			'tanggal_berlaku',
			null,
		);

		$this->db->select('t_log_harga.*');
		$this->db->from('t_log_harga');
		$this->db->where('is_aktif', '1');

		$i = 0;
		// loop column 
		foreach ($this->column_search as $item) {
			// if datatable send POST for search
			if ($_POST['search']['value']) {
				// first loop
				if ($i === 0) {
					// open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				//last loop
				if (count($this->column_search) - 1 == $i) {
					$this->db->group_end(); //close bracket
				}
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

	function get_datatable()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_query($term);

		if ($_REQUEST['length'] != -1) {
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		}

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('t_log_harga');
		return $this->db->count_all_results();
	}
	//end datatable query 
	
	public function insert_data($data)
	{
		$this->db->insert('t_log_harga', $data);
	}

	public function update_data($where, $data)
	{
		$this->db->update('t_log_harga', $data, $where);
	}

	public function get_data_log_harga($id)
	{
		$this->db->select('*');
		$this->db->from('t_log_harga');
		$this->db->where('id', $id);
		$query = $this->db->get()->row();

		if ($query) {
			return $query;
		} else {
			return false;
		}
	}

}
