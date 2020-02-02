<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_global extends CI_Model
{
	public function gen_uuid($value='')
	{
		$q = $this->db->query("SELECT uuid_v4() as uuid")->row();
		return $q->uuid;
	}

	public function get_data($select, $table, $where=FALSE, $join = array(), $order=FALSE, $limit=FALSE, $start=FALSE)
	{
		$this->db->select($select);
		$this->db->from($table);
		
		if ($where) {
			$this->db->where($where);
		}

		foreach($join as $j) :
			$this->db->join($j["table"], $j["on"],'left');
		endforeach;

		if ($order) {
			$this->db->order_by($order);
		}

		if ($limit) {
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
}