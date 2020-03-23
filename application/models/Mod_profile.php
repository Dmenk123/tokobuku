<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_profile extends CI_Model
{
	var $column_search = array(
		't_checkout.created_at',
		't_checkout.harga_total',
		't_checkout.kode_ref',
		'COUNT(t_checkout_detail.id_checkout)'
	);

	private function _get_data_checkout_query($term='', $id_user) //term is value of $_REQUEST['search']
	{
		$column = array(
			't_checkout.created_at',
			't_checkout.harga_total',
			't_checkout.kode_ref',
			'COUNT(t_checkout_detail.id_checkout)',
			null,
		);

		$this->db->select('
			t_checkout.*,
			t_checkout_detail.id as ckt_id_det,
			t_checkout_detail.harga_satuan,
			t_checkout_detail.harga_subtotal,
			m_produk.nama as nama_produk,
			m_satuan.nama as nama_satuan,
			COUNT(t_checkout_detail.id_checkout) AS jml
		');

		$this->db->from('t_checkout');
		$this->db->join('t_checkout_detail','t_checkout.id = t_checkout_detail.id_checkout','left');
		$this->db->join('m_produk','t_checkout_detail.id_produk = m_produk.id','left');
		$this->db->join('m_satuan','t_checkout_detail.id_satuan = m_satuan.id','left');
		$this->db->where('t_checkout.status', "1");
		$this->db->where('t_checkout.id_user', $id_user);
		$this->db->group_by('t_checkout.id');
		
		$i = 0;
		// loop column 
		foreach ($this->column_search as $item) 
		{
			// if datatable send POST for search
			if($_POST['search']['value']) 
			{
				// first loop
				if($i===0) 
				{
					// open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				//last loop
				if(count($this->column_search) - 1 == $i) 
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_data_checkout($id_user)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_checkout_query($term, $id_user);
		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_user)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_checkout_query($term, $id_user);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id_user)
	{
		$this->db->from('t_checkout');
		$this->db->where('id_user', $id_user);
		return $this->db->count_all_results();
	}


	public function get_data_checkout_det($id)
	{
		$this->db->select('
			t_checkout.*,
			t_checkout_detail.id,
			t_checkout_detail.harga_satuan,
			t_checkout_detail.harga_subtotal,
			t_checkout_detail.qty,
			m_produk.nama as nama_produk,
			m_produk.kode as kode_produk,
			m_satuan.nama as nama_satuan,
			m_user_detail.nama_lengkap_user
		');

		$this->db->from('t_checkout');
		$this->db->join('t_checkout_detail', 't_checkout.id = t_checkout_detail.id_checkout', 'left');
		$this->db->join('m_produk', 't_checkout_detail.id_produk = m_produk.id', 'left');
		$this->db->join('m_satuan', 't_checkout_detail.id_satuan = m_satuan.id', 'left');
		$this->db->join('m_user_detail', 't_checkout.id_user = m_user_detail.id_user', 'left');
		$this->db->where('t_checkout.status', "1");
		$this->db->where('t_checkout.id', $id);
		
		$query = $this->db->get();
		return $query->result();
	}

	/////////////////////////////////////////////// komisi //////////////////////////////////////////////////////

	private function _get_data_komisi_query($id_agen) //term is value of $_REQUEST['search']
	{
		$this->db->select('
			t_checkout.id,
			t_checkout.kode_ref,
			DATE(t_checkout.created_at) as tanggal,
			COUNT(t_checkout_detail.id_checkout) AS jml_trans,
			sum(harga_subtotal) as harga_subtotal,
			(sum(harga_subtotal) * t_log_harga.potongan / 100) as laba_agen
		');

		$this->db->from('t_checkout_detail');
		$this->db->join('t_checkout', 't_checkout_detail.id_checkout = t_checkout.id', 'left');
		$this->db->join('t_log_harga', 't_checkout_detail.id_produk = t_log_harga.id_produk and DATE(t_checkout.created_at) >= DATE(t_log_harga.created_at)', 'left');
		$this->db->where('t_checkout_detail.id_agen', $id_agen);
		$this->db->group_by('t_checkout_detail.id_checkout');
		$this->db->order_by('DATE(t_checkout.created_at)', 'desc');
	}

	function get_data_komisi($id_agen)
	{
		$this->_get_data_komisi_query($id_agen);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_id_agen($id_user)
	{
		$this->db->select('kode_agen');
		$this->db->from('m_user');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get()->row();
		return $query->kode_agen;
	}
	
}
