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

	function getKodeUser(){
	    $q = $this->db->query("select MAX(RIGHT(id_user,5)) as kode_max from m_user");
	    $kd = "";
	    if($q->num_rows()>0){
	        foreach($q->result() as $k){
	            $tmp = ((int)$k->kode_max)+1;
	            $kd = sprintf("%05s", $tmp);
	        }
	    }else{
	        $kd = "00001";
	    }
	    return "USR".$kd;
    }

    public function insert_data($table, $data)
    {
    	$this->db->insert($table, $data);
    }

    public function login($data){
		$this->db->select('*');
		$this->db->from('m_user');
		$this->db->where('username', $data['data_username']);
		$this->db->where('password', $data['data_password']);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function set_lastlogin($id){
		$this->db->where('id_user',$id)
				->update('m_user',array('last_login'=>date('Y-m-d H:i:s')));			
	}
}