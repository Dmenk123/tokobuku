<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_user extends CI_Model
{
	var $table = 'm_user';
	var $column_order = array('username','password',null,'status','last_login',null);
	var $column_search = array('username','status');
	var $order = array('id_user' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) 
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);

		$this->db->select('id_user,username,password,level_user,status,last_login');
		$this->db->from('tbl_level_user');
		$this->db->where('m_user.id_level_user = tbl_level_user.id_level_user');

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_detail_user($id_user)
	{
		$this->db->select('*');
		$this->db->from('m_user_detail');
		$this->db->where('id_user', $id_user);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}
	
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_user',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data_user, $data_user_detail)
	{
		$this->db->insert('m_user',$data_user); 
		$this->db->insert('m_user_detail',$data_user_detail);
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete('m_user');

		$this->db->where('id_user', $id);
		$this->db->delete('m_user_detail');
	}

	//dibutuhkan di contoller login untuk ambil data user
	function login($data){
		return $this->db->select('username,password,last_login,id_user,id_level_user,status')
			->where('username',$data['data_user'])
			->where('password',$data['data_password'])
			->where('status', 1 )
			->get('m_user')->result_array();
	}

	//dibutuhkan di contoller login untuk set last login
	function set_lastlogin($id){
		$this->db->where('id_user',$id)
				->update('m_user',array('last_login'=>date('Y-m-d H:i:s')));			
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

    public function get_datalogin_pegawai($nip)
    {
    	$q = $this->db->query("SELECT * FROM tbl_guru where nip = '".$nip."'");
    	if($q->num_rows() > 0)
    	{
    		return $q->row();
    	}else{
    		return FALSE;
    	}
    }
}
