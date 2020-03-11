<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_penjualan', 'm_jual');
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
			'js'	=> 'adm_view/js/js_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/penjualan/v_penjualan'
		];

		$this->template_view->load_view($content, $data);
	}

	public function list_penjualan($status = 0, $bulan, $tahun)
	{
		$tanggal_awal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-01'));
		$tanggal_akhir = date('Y-m-t', strtotime($tahun . '-' . $bulan . '-01'));
		$list = $this->m_jual->get_datatables($status, $tanggal_awal, $tanggal_akhir);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $datalist) {
			$nm = explode(',', $datalist->nama_lengkap_user);
			$link_edit = site_url('penjualan/penjualan_edit/') . $datalist->id;
			$no++;
			$row = array();
			// $row[] = $datalist->id;
			$row[] = date('d-m-Y', strtotime($datalist->created_at));
			$row[] = $nm[0] . ' ' . $nm[1];
			$row[] = $datalist->email;
			$row[] = "Rp. " . number_format($datalist->harga_total, 0, ",", ".");
			if ($datalist->status == 0) {
				$row[] = '<span style="color:red">Belum Di Verifikasi</span>';
			} else {
				$row[] = '<span style="color:green">Sudah Di Verifikasi</span>';
			}
			//cek kuncian
			//$cek_kunci = $this->cek_status_kuncian(date('m', strtotime($datalist->tanggal)), date('Y', strtotime($datalist->tanggal)));
			$cek_kunci = FALSE;

			if ($cek_kunci) {
				$link_detail = site_url('penjualan/penjualan_detail/') . $datalist->id.'/'.$status;
				$row[] = '<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>';
			} else {
				$link_detail = site_url('penjualan/penjualan_detail/') . $datalist->id.'/'.$status;
				$row[] = '
							<a class="btn btn-sm btn-success" href="' . $link_detail . '" title="Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i></a>
							<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deletePenerimaan(' . "'" . $datalist->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i></a>
						';
			}

			$data[] = $row;
		} //end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_jual->count_all($status, $tanggal_awal, $tanggal_akhir),
			"recordsFiltered" => $this->m_jual->count_filtered($status, $tanggal_awal, $tanggal_akhir),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function penjualan_detail($id, $status)
	{
		$id_user = $this->session->userdata('id_user');
		$query_user = $this->prof->get_detail_pengguna($id_user);

		$query_header = $this->m_jual->get_detail_header($id, $status);
		$query = $this->m_jual->get_detail($id, $status);
		
		$data = array(
			'data_user' => $query_user,
			'hasil_header' => $query_header,
			'hasil_data' => $query
		);

		$content = [
			'css' 	=> null,
			'js'	=> 'adm_view/js/js_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/penjualan/v_detail_penjualan'
		];

		$this->template_view->load_view($content, $data);
	}

	//=================================================================================================================================

	private function konfigurasi_upload_produk($nmfile)
	{
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/produk/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000'; //in KB (4MB)
		$config['max_width']  = '0'; //zero for no limit 
		$config['max_height']  = '0'; //zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'gbr_produk');
		$this->gbr_produk->initialize($config);
	}

	private function konfigurasi_image_produk($filename, $newname, $ext, $urut)
	{
		//konfigurasi image lib
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/produk/' . $filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['new_image'] = './assets/img/produk/' . $newname . "-" . $urut . "." . $ext;
		$config['overwrite'] = TRUE;
		$config['width'] = 450; //resize
		$config['height'] = 500; //resize
		$this->load->library('image_lib', $config); //load image library
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	public function add()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$data_kategori = $this->m_prod->get_data_kategori();
		$data_satuan = $this->m_prod->get_data_satuan();

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'data_satuan' => $data_satuan,
			'data_kategori' => $data_kategori
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_produk_adm',
			'modal' => false,
			'view'	=> 'adm_view/produk/v_add_master_produk'
		];

		$this->template_view->load_view($content, $data);
	}

	public function add_data()
	{
		$arr_valid = $this->_validate();
		$nama = trim(strtoupper(clean_string($this->input->post('nama'))));
		$kategori = trim(clean_string($this->input->post('kategori')));
		$satuan = trim(clean_string($this->input->post('satuan')));
		$keterangan = trim(clean_string($this->input->post('keterangan')));
		$panjang = clean_string($this->input->post('panjang'));
		$lebar = clean_string($this->input->post('lebar'));
		$jumlah_halaman = clean_string($this->input->post('jumlah_halaman'));
		$penerbit = trim(clean_string($this->input->post('penerbit')));
		$tahun = clean_string($this->input->post('tahun'));
		$aktif = trim(clean_string($this->input->post('aktif')));
		$posting = clean_string($this->input->post('posting'));
		$harga = clean_string($this->input->post('harga_raw'));
		$potongan = clean_string($this->input->post('potongan'));


		$namafileseo = $this->seoUrl($nama . ' ' . time());


		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		$this->db->trans_begin();
		$id = $this->m_global->gen_uuid();
		$akronim = $this->m_prod->get_akronim_kategori($kategori);
		$kode = $this->m_prod->get_kode_produk($akronim);

		//loop 3x berdasarkan upload field
		for ($i = 0; $i <= 2; $i++) {

			//load konfig upload
			$this->konfigurasi_upload_produk($namafileseo);
			$path = $_FILES['gambar' . $i]['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			//jika melakukan upload foto
			if ($this->gbr_produk->do_upload('gambar' . $i)) {
				$gbr = $this->gbr_produk->data(); //get file upload data
				$this->konfigurasi_image_produk($gbr['file_name'], $namafileseo, $ext, $i);
				$arr_gambar[] = ['nama_gambar' => $namafileseo . "-" . $i . "." . $ext];

				//clear img lib after resize
				$this->image_lib->clear();

				//unlink file upload, just image processed file only saved in server
				$ifile = '/bookstore/assets/img/produk/' . $namafileseo . '.' . $ext;
				unlink($_SERVER['DOCUMENT_ROOT'] . $ifile); // use server document root

			} else {
				//jika tidak ada file diupload, maka duplicate upload file pertama tiap loop
				$this->konfigurasi_upload_produk($namafileseo);
				$path = $_FILES['gambar0']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$this->gbr_produk->do_upload('gambar0');
				$gbr = $this->gbr_produk->data();

				//konfigurasi image lib
				$this->konfigurasi_image_produk($gbr['file_name'], $namafileseo, $ext, $i);
				$arr_gambar[] = ['nama_gambar' => $namafileseo . "-" . $i . "." . $ext];

				//clear img lib after resize
				$this->image_lib->clear();

				$ifile = '/bookstore/assets/img/produk/' . $namafileseo . '.' . $ext;
				unlink($_SERVER['DOCUMENT_ROOT'] . $ifile); // use server document root
			}
		} //end loop

		$data = array(
			'id' => $id,
			'id_kategori' => $kategori,
			'id_satuan' => $satuan,
			'kode' => $kode,
			'nama' => $nama,
			'keterangan' => $keterangan,
			'dimensi_panjang' => $panjang,
			'dimensi_lebar' => $lebar,
			'jumlah_halaman' => $jumlah_halaman,
			'penerbit' => $penerbit,
			'tahun' => $tahun,
			'created_at' => date('Y-m-d H:i:s'),
			'is_aktif' => $aktif,
			'is_posting' => $posting,
			'gambar_1' => $arr_gambar[0]['nama_gambar'],
			'gambar_2' => $arr_gambar[1]['nama_gambar'],
			'gambar_3' => $arr_gambar[2]['nama_gambar']
		);

		$harga_potongan = (int) $harga * $potongan / 100;
		$data_harga = [
			'id_produk' => $id,
			'harga_satuan' => $harga,
			'created_at' => date('Y-m-d H:i:s'),
			'potongan' => $potongan,
			'harga_potongan' => $harga_potongan
		];

		//insert produk
		$insert = $this->m_prod->insert_data_produk($data);
		//insert harga
		$insert_harga = $this->m_prod->insert_data_harga($data_harga);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('feedback_failed', 'Gagal Buat Master Produk.');
			$status = FALSE;
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('feedback_success', 'Berhasil Buat Master Produk');
			$status = TRUE;
		}

		echo json_encode(array(
			"status" => $status
		));
	}

	public function detail($id_produk)
	{
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$isi_notif = [];

		$produk = $this->m_prod->get_data_produk($id_produk);
		
		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'data_produk' => $produk
		);

		$content = [
			'css' => false,
			'js'	=> 'adm_view/js/js_produk_adm',
			'modal' => false,
			'view'	=> 'adm_view/produk/v_master_produk_detail'
		];

		$this->template_view->load_view($content, $data);
	}

	public function edit($id_produk)
	{
		// $arr_valid = $this->_validate();
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$isi_notif = [];

		$produk = $this->m_prod->get_data_produk($id_produk);
		$data_kategori = $this->m_prod->get_data_kategori();
		$data_satuan = $this->m_prod->get_data_satuan();

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'data_satuan' => $data_satuan,
			'data_kategori' => $data_kategori,
			'data_produk' => $produk
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_produk_adm',
			'modal' => false,
			'view'	=> 'adm_view/produk/v_edit_master_produk'
		];

		$this->template_view->load_view($content, $data);
	}

	public function update_data()
	{
		$arr_valid = $this->_validate();
		$nama = trim(strtoupper(clean_string($this->input->post('nama'))));
		$kategori = trim(clean_string($this->input->post('kategori')));
		$satuan = trim(clean_string($this->input->post('satuan')));
		$keterangan = trim(clean_string($this->input->post('keterangan')));
		$panjang = clean_string($this->input->post('panjang'));
		$lebar = clean_string($this->input->post('lebar'));
		$jumlah_halaman = clean_string($this->input->post('jumlah_halaman'));
		$penerbit = trim(clean_string($this->input->post('penerbit')));
		$tahun = clean_string($this->input->post('tahun'));
		$aktif = trim(clean_string($this->input->post('aktif')));
		$posting = clean_string($this->input->post('posting'));
		$harga = clean_string($this->input->post('harga_raw'));
		$potongan = clean_string($this->input->post('potongan'));
		$id_produk = clean_string($this->input->post('id'));

		$namafileseo = $this->seoUrl($nama . ' ' . time());

		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		$this->db->trans_begin();

		for ($i = 0; $i <= 2; $i++) {
			if (!empty($_FILES['gambar' . $i]['name'])) {
				//load konfig upload
				$this->konfigurasi_upload_produk($namafileseo);
				//get detail extension
				$pathDet = $_FILES['gambar' . $i]['name'];
				$ext = pathinfo($pathDet, PATHINFO_EXTENSION);
				//jika melakukan upload foto
				if ($this->gbr_produk->do_upload('gambar' . $i)) {
					$gbr = $this->gbr_produk->data();
					$this->konfigurasi_image_produk($gbr['file_name'], $namafileseo, $ext, $i);
					$arr_gambar[] = ['nama_gambar' => $namafileseo . "-" . $i . "." . $ext];

					//clear img lib after resize
					$this->image_lib->clear();

					//unlink file upload, just image processed file only saved in server
					$ifile = '/bookstore/assets/img/produk/' . $namafileseo . '.' . $ext;
					unlink($_SERVER['DOCUMENT_ROOT'] . $ifile); // use server document root
				} else {
					$arr_gambar[] = '';
				}
			} //end isset files
		} //end loop

		$data['id_kategori'] = $kategori;
		$data['id_satuan'] = $satuan;
		$data['nama'] = $nama;
		$data['keterangan'] = $keterangan;
		$data['dimensi_panjang'] = $panjang;
		$data['dimensi_lebar'] = $lebar;
		$data['jumlah_halaman'] = $jumlah_halaman;
		$data['penerbit'] = $penerbit;
		$data['tahun'] = $tahun;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['is_aktif'] = $aktif;
		$data['is_posting'] = $posting;

		for ($i = 0; $i <= 2; $i++) {
			if (isset($arr_gambar[$i])) {
				if ($arr_gambar[$i] != '') {
					$cok = $i + 1;
					$data["gambar_$cok"] = $arr_gambar[$i]['nama_gambar'];
				}
			}
		}

		//update data (PROSES PERTAMA)
		$this->m_prod->update_data_produk(array('id' => $id_produk), $data);

		$harga_potongan = (int) $harga * $potongan / 100;
		$data_harga = [
			'harga_satuan' => $harga,
			'created_at' => date('Y-m-d H:i:s'),
			'potongan' => $potongan,
			'harga_potongan' => $harga_potongan
		];

		//update harga
		$insert_harga = $this->m_prod->insert_data_harga(['id_produk' => $id_produk, 'is_aktif' => 1], $data_harga);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('feedback_failed', 'Gagal Update Master Produk.');
			$status = FALSE;
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('feedback_success', 'Berhasil Update Master Produk');
			$status = TRUE;
		}

		echo json_encode(array(
			"status" => $status
		));
	}

	public function list_data()
	{
		$list = $this->m_prod->get_datatable_produk();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $listProduk) {
			$no++;
			$link_detail = site_url('admin/master_produk_adm/detail/') . $listProduk->id;
			$link_edit = site_url('admin/master_produk_adm/edit/') . $listProduk->id;
			$row = array();
			//loop value tabel db
			$row[] = '<img src="' . base_url() . '/assets/img/produk/' . $listProduk->gambar_1 . '" alt="Gambar Produk" class="img_produk" width="80" height="80">';
			$row[] = $listProduk->id;
			$row[] = $listProduk->nama;
			$row[] = $listProduk->nama_kategori;
			$row[] = $listProduk->harga_satuan;
			$row[] = $listProduk->nama_satuan;
			//add html for action button
			if ($listProduk->is_aktif == '1') {
				$strVal = $this->template_view->returnGetDetailButton($link_detail);
				$strVal .= $this->template_view->returnGetEditButton($link_edit);
				$strVal .= '<a class="btn btn-sm btn-success btn_edit_status" href="javascript:void(0)" title="aktif" id="' . $listProduk->id . '"><i class="fa fa-check"></i> Aktif</a>';

				$row[] = $strVal;
			} else {
				$strVal = $this->template_view->returnGetDetailButton($link_detail);
				$strVal .= $this->template_view->returnGetEditButton($link_edit);
				$strVal .= '<a class="btn btn-sm btn-danger btn_edit_status" href="javascript:void(0)" title="nonaktif" id="' . $listProduk->id . '"><i class="fa fa-times"></i> Nonaktif</a>';

				$row[] = $strVal;
			}

			$data[] = $row;
		} //end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_prod->count_all_produk(),
			"recordsFiltered" => $this->m_prod->count_filtered_produk(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('nama') == '') {
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Wajib mengisi nama';
			$data['status'] = FALSE;
		}

		if ($this->input->post('kategori') == '') {
			$data['inputerror'][] = 'kategori';
			$data['error_string'][] = 'Wajib mengisi kategori';
			$data['status'] = FALSE;
		}

		if ($this->input->post('satuan') == null) {
			$data['inputerror'][] = 'satuan';
			$data['error_string'][] = 'Wajib mengisi satuan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('keterangan') == '') {
			$data['inputerror'][] = 'keterangan';
			$data['error_string'][] = 'Wajib mengisi keterangan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('panjang') == '') {
			$data['inputerror'][] = 'panjang';
			$data['error_string'][] = 'Wajib mengisi panjang';
			$data['status'] = FALSE;
		}

		if ($this->input->post('lebar') == '') {
			$data['inputerror'][] = 'lebar';
			$data['error_string'][] = 'Wajib mengisi lebar';
			$data['status'] = FALSE;
		}

		if ($this->input->post('jumlah_halaman') == '') {
			$data['inputerror'][] = 'jumlah_halaman';
			$data['error_string'][] = 'Wajib mengisi jumlah halaman';
			$data['status'] = FALSE;
		}

		if ($this->input->post('penerbit') == '') {
			$data['inputerror'][] = 'penerbit';
			$data['error_string'][] = 'Wajib mengisi penerbit';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tahun') == '') {
			$data['inputerror'][] = 'tahun';
			$data['error_string'][] = 'Wajib mengisi tahun';
			$data['status'] = FALSE;
		}

		return $data;
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



	// =========================================================================================================================


	public function get_master_kategori()
	{
		$data = $this->m_prod->get_data_kategori();
		foreach ($data as $row) {
			$kategori[] = array(
				'id' => $row->id_kategori,
				'text' => $row->nama_kategori,
			);
		}
		echo json_encode($kategori);
	}

	public function get_master_sub_kategori($idKategori)
	{
		$data = $this->m_prod->get_data_sub_kategori($idKategori);
		foreach ($data as $row) {
			$sub_kategori[] = array(
				'id' => $row->id_sub_kategori,
				'text' => $row->nama_sub_kategori,
			);
		}
		echo json_encode($sub_kategori);
	}

	public function get_satuan()
	{
		$data = $this->m_prod->get_data_satuan();
		foreach ($data as $row) {
			$satuan[] = array(
				'id' => $row->id_satuan,
				'text' => $row->nama_satuan,
			);
		}
		echo json_encode($satuan);
	}

	public function edit_status_produk($id)
	{
		$input_status = $this->input->post('status');
		// jika aktif maka di set ke nonaktif / "0"
		if ($input_status == " Aktif") {
			$status = '0';
			$psn_txt = "Produk dengan kode " . $id . " dinonaktifkan.";
		} elseif ($input_status == " Nonaktif") {
			$status = '1';
			$psn_txt = "Produk dengan kode " . $id . " diaktifkan.";
		}

		$input = array(
			'status' => $status
		);
		$this->m_prod->update_status_produk(array('id_produk' => $id), $input);
		$data = array(
			'status' => TRUE,
			'pesan' => $psn_txt,
		);

		echo json_encode($data);
	}

	
}//end of class Master_produk_admp.php
