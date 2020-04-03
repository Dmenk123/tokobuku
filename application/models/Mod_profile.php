<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_profile extends CI_Model
{
	var $column_search = array(
		't_checkout.created_at',
		't_checkout.harga_total',
		't_checkout.kode_ref',
		't_checkout.status'
	);

	private function _get_data_checkout_query($term='', $id_user) //term is value of $_REQUEST['search']
	{
		$column = array(
			't_checkout.created_at',
			't_checkout.harga_total',
			't_checkout.kode_ref',
			't_checkout.status',
			null,
		);

		$this->db->select('
			t_checkout.*,
			COUNT(t_checkout_detail.id_checkout) AS jml
		');

		$this->db->from('t_checkout');
		// $this->db->where('t_checkout.status', "1");
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
			t_checkout.*, m_user_detail.nama_lengkap_user
		');

		$this->db->from('t_checkout');
		$this->db->join('m_user_detail', 't_checkout.id_user = m_user_detail.id_user', 'left');
		//$this->db->where('t_checkout.status', "1");
		$this->db->where('t_checkout.id', $id);
		
		$query = $this->db->get();
		return $query->result();
	}

	/////////////////////////////////////////////// komisi //////////////////////////////////////////////////////

	private function _get_data_komisi_query($id_agen) //term is value of $_REQUEST['search']
	{
		$this->db->select('*');

		$this->db->from('t_checkout');
		$this->db->where('t_checkout.kode_agen', $id_agen);
		$this->db->where('t_checkout.status', '0'); //status transaksi sudah selesai
		$this->db->where('t_checkout.is_konfirm', '1'); //sudah dikonfirmasi bahwa transaksi selesai
		$this->db->where('is_agen_klaim', '0'); //belum di klaim
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

	public function get_data_komisi_detail($id_checkout, $id_agen)
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
			m_user_detail.nama_lengkap_user,
			(sum(harga_subtotal) * t_log_harga.potongan / 100) as laba_agen
		');

		$this->db->from('t_checkout');
		$this->db->join('t_checkout_detail', 't_checkout.id = t_checkout_detail.id_checkout', 'left');
		$this->db->join('m_produk', 't_checkout_detail.id_produk = m_produk.id', 'left');
		$this->db->join('m_satuan', 't_checkout_detail.id_satuan = m_satuan.id', 'left');
		$this->db->join('m_user_detail', 't_checkout.id_user = m_user_detail.id_user', 'left');
		$this->db->join('t_log_harga', 't_checkout_detail.id_produk = t_log_harga.id_produk and DATE(t_checkout.created_at) >= DATE(t_log_harga.created_at)', 'left');
		$this->db->where('t_checkout.status', "0");
		$this->db->where('t_checkout.id', $id_checkout);
		$this->db->where('t_checkout_detail.id_agen', $id_agen);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function get_komisi_belum_tarik($id_agen)
	{
		$this->db->select('(sum(laba_agen_total)) as total_laba');
		$this->db->from('t_checkout');
		$this->db->where('kode_agen', $id_agen);
		$this->db->where('is_konfirm', '1');
		$this->db->where('status', '0');
		$this->db->where('is_agen_klaim', '0');
		$q = $this->db->get();
		return $q->row();
	}

	public function get_komisi_pending_tarik($id_agen)
	{
		$this->db->select('(sum(laba_agen_total)) as total_laba');
		$this->db->from('t_checkout');
		$this->db->where('kode_agen', $id_agen);
		$this->db->where('is_konfirm', '1');
		$this->db->where('status', '0');
		$this->db->where('is_agen_klaim', '1');
		$this->db->where('is_verify_klaim', '0');
		$q = $this->db->get();
		return $q->row();
	}

	public function get_komisi_sudah_tarik($id_agen)
	{
		$this->db->select('(sum(laba_agen_total)) as total_laba');
		$this->db->from('t_checkout');
		$this->db->where('kode_agen', $id_agen);
		$this->db->where('is_konfirm', '1');
		$this->db->where('status', '0');
		$this->db->where('is_agen_klaim', '1');
		$this->db->where('is_verify_klaim', '1');
		$q = $this->db->get();
		return $q->row();
	}

	public function set_komisi_sudah_klaim($id_agen, $id_klaim)
	{
		$this->db->update(
			't_checkout', 
			['is_agen_klaim' => 1, 'id_klaim_agen' => $id_klaim], 
			[ 'kode_agen' => $id_agen, 'is_konfirm' => '1', 'status' => '0', 'is_agen_klaim' => '0']
		);

        if ($this->db->affected_rows() > 0) {
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	
}
