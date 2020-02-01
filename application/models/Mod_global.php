<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_global extends CI_Model
{
	public function gen_uuid($value='')
	{
		$q = $this->db->query("SELECT uuid_v4() as uuid")->row();
		return $q->uuid;
	}

	public function get_data($table, $where=FALSE)
	{
		$this->db->select('*');
		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
}