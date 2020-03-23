<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_global extends CI_Model
{
	public function gen_uuid()
	{
		$data = openssl_random_pseudo_bytes(16);
		assert(strlen($data) == 16);

	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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

	public function get_data_single($select, $table, $where=FALSE, $join = array(), $order=FALSE, $limit=FALSE, $start=FALSE)
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
		return $query->row();
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

	public function cek_sesi_agen($kode_agen)
	{
		$this->db->select('*');
		$this->db->from('m_user');
		$this->db->where('kode_agen', $kode_agen);
		$query = $this->db->get();
		return $query->row();
	}

	public function getSelectedData($table,$datawhere,$data_like=null, $datawhere_or = null, $datawhere1=null,$wherein=null,$where_in=null,$in=null,$where_sekda=null,$datalike_or=null,$not_in=null,$not_like=null)
    {
        $this->db->select('*');
        if ($datawhere != null) {
            $this->db->where($datawhere);
        }
        if ($data_like != null) {
           $this->db->like($data_like,false,'after');
        }
        if ($datawhere_or != null) {
            $this->db->or_where($datawhere_or);
        }
        if ($datawhere1 != null) {
            $this->db->where($datawhere1);
        }
     //SEMENTARA UNTUK MENAMPILKAN KATEGORI SURAT YANG HANYA SUDAH ADA FORMNYA
        if ($wherein != null) {
            $this->db->where_in('id_kategori',$wherein);
        }

        if ($where_in != null) {
            $this->db->where_in('id_laporan',$where_in);
        }

        if ($in != null) {
            $this->db->where_in('id_detail',$in);
        }

        if ($where_sekda != null) {
            $this->db->where_in('id_jabatan',$where_sekda);
        }

        if ($datalike_or != null) {
            $this->db->or_like($datalike_or);
        }

        if($not_in != null){
            $this->db->where_not_in($not_in);
        }

        if($not_like != null){
            $this->db->not_like($not_like);
        }

        return $this->db->get($table);
	}
	
	function updateData($table,$data_where,$data, $data2=null)
    {
        if ($data2!=null){
            foreach ($data2 as $key => $value) {
                $this->db->set($key, $value, FALSE);
            }
        }
        $this->db->update($table,$data,$data_where);
        //return $this->db->affected_rows() > 0;

        // return $this->db->last_query();
    }
}
