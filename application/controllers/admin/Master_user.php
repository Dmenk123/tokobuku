<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_user extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->library('enkripsi');
	}

	public function index()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif
		);

		$content = [
			'css' => false,
			'modal' => 'adm_view/modal/modalMasterUserAdm',
			'js'	=> 'adm_view/js/js_user',
			'view'	=> 'adm_view/master_user/v_master_user'
		];

		$this->template_view->load_view($content, $data);
	}

	public function list_user()
	{
		$list = $this->m_user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $listUser) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listUser->username;
			$row[] = $listUser->nama_lengkap_user;
			$row[] = $listUser->email;
			$row[] = $listUser->nama_level_user;
			if ($listUser->status == '1') {
				$row[] = "<span style='color:blue;'>aktif</span>";	
			}else{
				$row[] = "<span style='color:red;'>nonaktif</span>";
			}
			$row[] = $listUser->last_login;
			//add html for action button
			$row[] =
			'<a class="btn btn-sm btn-primary" href="'.base_url('admin/master_user/edit_user/').$listUser->id_user.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
			 <a class="btn btn-sm btn-success" href="'.base_url('admin/master_user/detail_user/').$listUser->id_user.'" title="Detail"><i class="glyphicon glyphicon-search"></i></a>';
				
							
			$data[] = $row;
		}//end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_user->count_all(),
			"recordsFiltered" => $this->m_user->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit_user($id)
	{
		// $arr_valid = $this->_validate();
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$isi_notif = [];

		$data_edit = $this->m_user->get_data_edit($id);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'hasil_data' => $data_edit
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_user',
			'modal' => false,
			'view'	=> 'adm_view/master_user/v_edit_user'
		];

		$this->template_view->load_view($content, $data);
	}

	public function detail_user($id)
	{
		// $arr_valid = $this->_validate();
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$isi_notif = [];

		$data_edit = $this->m_user->get_data_edit($id);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'hasil_data' => $data_edit
		);

		echo "<pre>";
		print_r ($data);
		echo "</pre>";
		exit;
		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_user',
			'modal' => false,
			'view'	=> 'adm_view/master_user/v_detail_user'
		];

		$this->template_view->load_view($content, $data);
	}	

	public function update_data()
	{
		$flag_ganti_pass = FALSE;
		$flag_reset_pass = FALSE;
		
		$arr_valid = $this->_validate();

		if ($arr_valid['status'] == FALSE) {
			echo json_encode(['status' => FALSE, 'inputerror' => $arr_valid['inputerror'], 'error_string' => $arr_valid['error_string']]);
			return;
		}

		$id = clean_string($this->input->post('id'));
		$password = clean_string($this->input->post('password'));
		$repassword = clean_string($this->input->post('repassword'));
		$passwordnew = clean_string($this->input->post('passwordnew'));
		$status = $this->input->post('status');

		$this->db->trans_begin();
		
		if ($this->input->post('ceklistpwd') != 'Y') {
			$flag_ganti_pass = TRUE;
			$hasil_password = $this->enkripsi->encrypt($passwordnew);

			if ($passwordnew != $repassword) {
				$this->session->set_flashdata('feedback_failed', 'Terdapat ketidak cocokan Password Baru');
				echo json_encode(['status' => false]);
				return;
			}
		}

		if ($this->input->post('resetpwd') == 'Y') {
			$flag_reset_pass = TRUE;
			$hasil_password = $this->enkripsi->encrypt('123456');
		}

		//data input array
		$input = [
			'updated_at' => date('Y-m-d H:i:s'),
			'status' => $status
		];
		
		if ($flag_ganti_pass) {
			$input['password'] = $hasil_password;
		}else if($flag_reset_pass) {
			$input['password'] = $hasil_password;
		}

        //update to db
        $this->m_global->updateData2('m_user',['id_user' => $id], $input);

        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status = FALSE;
		} else {
			$this->db->trans_commit();			
			$status = TRUE;
		}

		echo json_encode(['status'=>$status]);
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('ceklistpwd') != 'Y') {
			if ($this->input->post('password') == '') {
				$data['inputerror'][] = 'password';
				$data['error_string'][] = 'Wajib mengisi password';
				$data['status'] = FALSE;
			}

			if ($this->input->post('repassword') == null) {
				$data['inputerror'][] = 'repassword';
				$data['error_string'][] = 'Wajib mengisi ulang Password';
				$data['status'] = FALSE;
			}

			if ($this->input->post('passwordnew') == null) {
				$data['inputerror'][] = 'passwordnew';
				$data['error_string'][] = 'Wajib mengisi ulang Password Baru';
				$data['status'] = FALSE;
			}
		}

		if ($this->input->post('namalengkap') == '') {
			$data['inputerror'][] = 'namalengkap';
			$data['error_string'][] = 'Wajib mengisi namalengkap';
			$data['status'] = FALSE;
		}

		return $data;
	}	
}
