<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_listing extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email', 'pagination'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global', 'mod_produk']);

	}

	public function index()
	{	
		if (!isset($per_page)) {
			$per_page = 2; //default per page
		}else{
			$per_page = $this->input->get('per_page');
		}

		$total_row = $this->mod_produk->total_records();
		
		$this->paging_config($per_page, $total_row);
		$str_links = $this->pagination->create_links();
		$arr_links = explode('&nbsp', $str_links);
		$page = $this->uri->segment(4);

		if ($this->input->get('sort')) {
			$sort = $this->db->escape_str($this->input->get('sort'));
			$arr_sort = explode('_', $sort);
			if ($arr_sort[0] == 'harga') {
				$flag_str = 'harga_satuan';
			}else{
				$flag_str = 'nama';
			}
			$order = $flag_str.' '.$arr_sort[1];
		}else{
			$order = 'created_at DESC';
		}
		
		$select = "m_produk.*, m_kategori.nama as nama_kategori, m_satuan.nama as nama_satuan, t_log_harga.harga_satuan, t_log_harga.potongan";
		$join = array(
			["table" => "m_kategori", "on" => "m_produk.id_kategori = m_kategori.id"],
			["table" => "m_satuan", "on"  => "m_produk.id_satuan = m_satuan.id"],
			["table" => "t_log_harga", "on" => "m_produk.id = t_log_harga.id_produk"]
		);
		$produk = $this->mod_global->get_data($select, 'm_produk', ['m_produk.is_aktif' => 1], $join, $order, $per_page, $page);
		
		/*echo "<pre>";
		print_r ($str_links);
		echo "</pre>";
		exit;
	*/	
		$data = [
			'produk' => $produk,
			'links' => explode('&nbsp', $str_links),
			'total_baris' => $total_row,
		];

		$this->load->view('v_navbar', $data);
		// $this->load->view('header');
		$this->load->view('v_listing', $data);
		$this->load->view('footer');
	}

	public function paging_config($per_page, $total_row)
	{
		//set array for pagination library
		$config = array();
		$config["base_url"] = base_url() . "product_listing/index/";
        $config["total_rows"] = $total_row;
        $config["per_page"] = $per_page;
        //beri tambahan path ketika next page
        $config['prefix'] = '/page/';
        //tampilkan url string pada next page
        $config['reuse_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp <a class="current">';
        $config['cur_tag_close'] = '</a> &nbsp ';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $this->pagination->initialize($config);
	}

}
