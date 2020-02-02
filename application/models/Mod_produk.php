<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_produk extends CI_Model
{
	public function total_records()
	{
		$this->db->select('*');
		$this->db->from('m_produk');
		$this->db->where('is_aktif', '1');
		$this->db->where('is_posting', '1');
		$query = $this->db->get()->num_rows();
		return $query;
	}
}