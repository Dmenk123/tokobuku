<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasi_klaim extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_verifikasi_klaim', 'm_vk');
	}

	private function arr_bulan()
	{
		$data = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		return $data;
	}

	public function index()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'arr_bulan' => $this->arr_bulan(),
			'cek_kunci' => FALSE
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_verifikasi_klaim',
			'modal' => false,
			'view'	=> 'adm_view/verifikasi_klaim/v_verifikasi_klaim'
		];

		$this->template_view->load_view($content, $data);
	}

	public function list_klaim()
	{
		$status = ($this->input->post('status') == '') ? 'null' : $this->session->userdata('id_user');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		$tanggal_awal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 00:00:00'));
		$tanggal_akhir = date('Y-m-t H:i:s', strtotime($tahun . '-' . $bulan . '-01 23:59:59'));
		
		$list = $this->m_vk->get_datatables($status, $tanggal_awal, $tanggal_akhir);
		
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $datalist) 
		{
			$link_edit = site_url('admin/verifikasi_klaim/verifikasi_edit/') . $datalist->id;
			
			$arr_nama = explode(',', $datalist->nama_lengkap_user);
			if (count($arr_nama) == 2) {
				$nama_lengkap = $arr_nama[0].' '.$arr_nama[1];
			}else if(count($arr_nama) == 3){
				$nama_lengkap = $arr_nama[0].' '.$arr_nama[1].' '.$arr_nama[2];
			}else if(count($arr_nama) == 4){
				$nama_lengkap = $arr_nama[0].' '.$arr_nama[1].' '.$arr_nama[2].' '.$arr_nama[3];
			}else{
				$nama_lengkap = $arr_nama[0];
			}

			$no++;
			$row = array();
			// $row[] = $datalist->id;
			$row[] = date('d-m-Y', strtotime($datalist->created_at));
			$row[] = $nama_lengkap;
			$row[] = $datalist->email;
			$row[] = "Rp. " . number_format($datalist->jumlah_klaim, 0, ",", ".");

			if ($status != 'null') {
				$row[] = '<span style="color:green">Sudah Di Verifikasi</span>';
			}else{
				$row[] = '<span style="color:red">Belum Di Verifikasi</span>';
			}
			
			$cek_kunci = FALSE;

			if ($cek_kunci) {
				$link_detail = site_url('admin/verifikasi_klaim/verifikasi_detail/') . $datalist->id.'/'.$bulan.'/'.$tahun;
				$row[] = '<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>';
			} else {
			
				$link_detail = site_url('admin/verifikasi_klaim/verifikasi_detail/') . $datalist->id.'/'.$bulan.'/'.$tahun;
				$link_detail_finish = site_url('admin/verifikasi_klaim/verifikasi_detail_finish/') . $datalist->id.'/'.$bulan.'/'.$tahun;
				if ($status != 'null') {
					$row[] = '
						<a class="btn btn-sm btn-success" href="' . $link_detail_finish . '" title="Detail" id="btn_detail_finish" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>
						<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Batalkan" onclick="batalkanVerify(' . "'" . $datalist->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i></a>
					';
				}else{
					$row[] = '
						<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>
					';
				}
				
			}

			$data[] = $row;
		} //end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_vk->count_all($status, $tanggal_awal, $tanggal_akhir),
			"recordsFiltered" => $this->m_vk->count_filtered($status, $tanggal_awal, $tanggal_akhir),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function verifikasi_detail($id, $bulan, $tahun)
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$query_user = $this->m_user->get_detail_user($id_user);

		$query = $this->m_vk->get_detail($id);

		$data = array(
			'isi_notif' => $isi_notif,
			'data_user' => $query_user,
			'hasil_data' => $query,
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$content = [
			'css' 	=> null,
			'js'	=> 'adm_view/js/js_verifikasi_klaim',
			'modal' => false,
			'view'	=> 'adm_view/verifikasi_klaim/v_detail_vk'
		];

		$this->template_view->load_view($content, $data);
	}

	public function verifikasi_detail_finish($id, $bulan, $tahun)
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$query_user = $this->m_user->get_detail_user($id_user);

		$query = $this->m_vk->get_detail($id);
		$gambar = $this->db->query("select bukti from t_klaim_verify where id_klaim_agen = '".$query[0]->id_klaim_agen."'")->row();
		$data = array(
			'isi_notif' => $isi_notif,
			'data_user' => $query_user,
			'hasil_data' => $query,
			'gambar' => $gambar->bukti,
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$content = [
			'css' 	=> null,
			'js'	=> 'adm_view/js/js_verifikasi_klaim',
			'modal' => false,
			'view'	=> 'adm_view/verifikasi_klaim/v_detail_vk_finish'
		];

		$this->template_view->load_view($content, $data);
	}

	public function konfirmasi($bulan, $tahun)
	{
		$id_klaim = $this->input->post('id_klaim');
		$id_user = $this->session->userdata('id_user');
		$nama_agen = $this->input->post('nama_agen');
		$nilaitotal = $this->input->post('nilaitotal');
		$bank = $this->input->post('bank');
		$rekening = $this->input->post('rekening');
		$email = $this->input->post('email');
		$telp = $this->input->post('telp');
		
		$namafileseo = $this->seoUrl('Bukti-'.$nama_agen.' '.time());

		//load konfig upload
		$this->konfigurasi_upload_bukti($namafileseo);
		$path = $_FILES['bukti']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		if ($this->bukti_tf->do_upload('bukti')) {
			$gbr = $this->bukti_tf->data(); //get file upload data
			$this->konfigurasi_image_bukti($gbr['file_name'], $namafileseo, $ext);
			$arr_gambar = ['nama_gambar' => $namafileseo . "." . $ext];

			//clear img lib after resize
			$this->image_lib->clear();

		} else {
			$status = FALSE;
			echo json_encode([
				'status' => $status,
				'bulan' => $bulan,
				'tahun' => $tahun
			]);
			return;
		}

		$this->db->trans_begin();
		$id = $this->m_global->gen_uuid();
		$update1 = $this->m_global->updateData2('t_checkout', ['id_klaim_agen' => $id_klaim], ['is_verify_klaim' => 1]);
		$update2 = $this->m_global->updateData2(
			't_klaim_agen', 
			['id' => $id_klaim], 
			['id_user_verify' => $id_user, 'datetime_verify' => date("Y-m-d H:i:s")]
		);

		$dataIns = array(
			'id' => $id,
			'id_klaim_agen' => $id_klaim,
			'id_user' => $id_user,
			'tanggal_verify' => date('Y-m-d H:i:s'),
			'bank' => $bank,
			'rekening' => $rekening,
			'bukti' => $arr_gambar['nama_gambar'],
			'nilai_transfer' => (int)$nilaitotal
		);

		$insert = $this->m_global->insert_data('t_klaim_verify', $dataIns);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status = FALSE;
		} else {
			$this->db->trans_commit();			
			$status = TRUE;
		}

		echo json_encode([
			'status' => $status,
			'bulan' => $bulan,
			'tahun' => $tahun
		]);
	}

	private function konfigurasi_upload_bukti($nmfile)
	{
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/bukti_verifikasi/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000'; //in KB (4MB)
		$config['max_width']  = '0'; //zero for no limit 
		$config['max_height']  = '0'; //zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'bukti_tf');
		$this->bukti_tf->initialize($config);
	}

	private function konfigurasi_image_bukti($filename, $newname, $ext)
	{
		//konfigurasi image lib
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/bukti_verifikasi/' . $filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['new_image'] = './assets/img/bukti_verifikasi/' . $newname .  "." . $ext;
		$config['overwrite'] = TRUE;
		$config['width'] = 450; //resize
		$config['height'] = 500; //resize
		$this->load->library('image_lib', $config); //load image library
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	private function seoUrl($string)
	{
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}

	public function batal_verify($id, $bulan, $tahun)
	{
		$table = 't_checkout';
		$data = [
			'status' => 1,
			'is_konfirm' => 0
		];
		$data_where = ['id' => $id];
		$query = $this->m_global->updateData2($table,$data_where,$data);

		if ($query) {
			$status = TRUE;
		}else{
			$status = FALSE;
		}

		echo json_encode([
			'status' => $status,
			'bulan' => $bulan,
			'tahun' => $tahun
		]);
	}
	
}//end of class penjualan.php
