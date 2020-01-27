<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_master_produk_adm extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
			'm_produk.id_produk',
			'm_kategori.nama_kategori',
			'tbl_sub_kategori_produk.nama_sub_kategori',
			'm_produk.nama_produk',
			'm_produk.harga',
			'tbl_satuan.nama_satuan',
			'm_produk.bahan_produk',
		);

	var $column_order = array(
			null,
			'm_produk.id_produk',
			'm_produk.nama_produk',
			'm_kategori.nama_kategori',
			'tbl_sub_kategori_produk.nama_sub_kategori',
			'm_produk.harga',
			'tbl_satuan.nama_satuan',
			'm_produk.bahan_produk',
		);

	var $order = array('m_produk.nama_produk' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	//for all data master produk
	private function _get_data_produk_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'tbl_gambar_produk.nama_gambar',
				'm_produk.id_produk',
				'm_kategori.nama_kategori',
				'tbl_sub_kategori_produk.nama_sub_kategori',
				'm_produk.nama_produk',
				'm_produk.harga',
				'tbl_satuan.nama_satuan',
				'm_produk.bahan_produk',
				null,
			);

		$this->db->select('
				tbl_gambar_produk.nama_gambar,
				m_produk.id_produk,
				m_kategori.nama_kategori,
				tbl_sub_kategori_produk.nama_sub_kategori,
				m_produk.nama_produk,
				m_produk.harga,
				tbl_satuan.nama_satuan,
				m_produk.bahan_produk,
				m_produk.status,
			');

		$this->db->from('m_produk');
		$this->db->join('tbl_gambar_produk', 'm_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->join('m_kategori', 'm_produk.id_kategori = m_kategori.id_kategori', 'left');
		$this->db->join('tbl_sub_kategori_produk', 'm_produk.id_sub_kategori = tbl_sub_kategori_produk.id_sub_kategori', 'left');
		$this->db->join('tbl_satuan', 'm_produk.id_satuan = tbl_satuan.id_satuan', 'left');
		//$this->db->where('m_produk.status', '1');
		$this->db->where('tbl_gambar_produk.jenis_gambar', 'display');
		
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
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatable_produk()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_produk_query($term);
		
		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_produk()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_produk_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_produk()
	{
		$this->db->from('m_produk');
		return $this->db->count_all_results();
	}
	//end datatable query master produk
	
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

	
	public function get_data_sub_kategori($id_kategori)
	{
		$this->db->select('id_sub_kategori, nama_sub_kategori');
		$this->db->from('tbl_sub_kategori_produk');
		$this->db->where('id_kategori', $id_kategori);
		$query = $this->db->get();
		return $query->result();
	}




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


    public function update_data_produk($where, $data)
	{
		$this->db->update('m_produk', $data, $where);
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

		if ($query->num_rows() > 0)
		{
			$hasil = $query->row();
            return $hasil->ukuran_produk;
        }
        else
        {
        	return "Ukuran Belum Ada";
        }
    }
	
	public function get_data_produk($id_produk)
	{
		$this->db->select('
			tbl_gambar_produk.id_gambar,
			tbl_gambar_produk.nama_gambar,
			m_produk.id_produk,
			m_kategori.id_kategori,
			m_kategori.nama_kategori,
			tbl_sub_kategori_produk.id_sub_kategori,
			tbl_sub_kategori_produk.nama_sub_kategori,
			m_produk.nama_produk,
			m_produk.keterangan_produk,
			m_produk.harga,
			tbl_satuan.id_satuan,
			tbl_satuan.nama_satuan,
			m_produk.bahan_produk,
		');
		$this->db->from('m_produk');
		$this->db->join('tbl_gambar_produk', 'm_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->join('m_kategori', 'm_produk.id_kategori = m_kategori.id_kategori', 'left');
		$this->db->join('tbl_sub_kategori_produk', 'm_produk.id_sub_kategori = tbl_sub_kategori_produk.id_sub_kategori', 'left');
		$this->db->join('tbl_satuan', 'm_produk.id_satuan = tbl_satuan.id_satuan', 'left');
		$this->db->where('m_produk.status', '1');
		$this->db->where('tbl_gambar_produk.jenis_gambar', 'display');
		$this->db->where('m_produk.id_produk', $id_produk);

		$query = $this->db->get();
		return $query->row();
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
