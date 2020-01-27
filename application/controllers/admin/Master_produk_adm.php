<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_produk_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_master_produk_adm', 'm_prod');
		
		/* //pesan stok minimum
		$produk = $this->m_user->get_produk();
		$link_notif = site_url('laporan_stok');
		foreach ($produk as $val) {
			if ($val->stok_sisa <= $val->stok_minimum) {
				$this->session->set_flashdata('cek_stok', 'Terdapat Stok produk dibawah nilai minimum, Mohon di cek ulang <a href="'.$link_notif.'">disini</a>');
			}
		} */
	}

	public function index()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_user->get_detail_user($id_user);

		$data = array(
			'modal'=>'modalMasterProdukAdm',
			'js'=>'masterProdukAdmJs',
			'data_user' => $data_user,
		);

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_produk_adm',
			'modal' => false,
			'view'	=> 'adm_view/v_master_produk'
		];

		$this->template_view->load_view($content, $data);
	}

	private function konfigurasi_upload_produk($nmfile)
	{ 
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/produk/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000';//in KB (4MB)
		$config['max_width']  = '0';//zero for no limit 
		$config['max_height']  = '0';//zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'gbr_produk');
		$this->gbr_produk->initialize($config);
	}

	private function konfigurasi_image_produk($filename, $newname, $ext, $urut)
	{
		//konfigurasi image lib
	    $config['image_library'] = 'gd2';
	    $config['source_image'] = './assets/img/produk/'.$filename;
	    $config['create_thumb'] = FALSE;
	    $config['maintain_ratio'] = FALSE;
		$config['new_image'] = './assets/img/produk/' . $newname . "-" . $urut . "." . $ext;
	    $config['overwrite'] = TRUE;
	    $config['width'] = 450; //resize
	    $config['height'] = 500; //resize
	    $this->load->library('image_lib',$config); //load image library
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
			'view'	=> 'adm_view/v_add_master_produk'
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


		$namafileseo = $this->seoUrl($nama.' '.time());
		

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
			$path = $_FILES['gambar'.$i]['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			//jika melakukan upload foto
			if ($this->gbr_produk->do_upload('gambar'.$i)) {
				$gbr = $this->gbr_produk->data(); //get file upload data
				$this->konfigurasi_image_produk($gbr['file_name'], $namafileseo, $ext, $i);
				$arr_gambar[] = ['nama_gambar' => $namafileseo . "-" . $i . "." . $ext];

				//clear img lib after resize
				$this->image_lib->clear();

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
		
		$insert = $this->m_prod->insert_data_produk($data);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->session->set_flashdata('feedback_failed','Gagal Buat Master Produk.'); 
			$status = FALSE;
		}
		else {
			$this->db->trans_commit();
			$this->session->set_flashdata('feedback_success','Berhasil Buat Master Produk');
			$status = TRUE;
		}

		echo json_encode(array(
			"status" => $status
		));
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

	private function seoUrl($string) {
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

	public function list_produk()
	{
		$list = $this->m_prod->get_datatable_produk();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $listProduk) {
			$no++;
			$link_detail = site_url('master_produk_adm/master_produk_detail/').$listProduk->id_produk;
			$row = array();
			//loop value tabel db
			$row[] = '<img src="./assets/img/produk/'.$listProduk->nama_gambar.'" alt="Gambar Produk" class="img_produk">';
			$row[] = $listProduk->id_produk;
			$row[] = $listProduk->nama_produk;
			$row[] = $listProduk->nama_kategori;
			$row[] = $listProduk->nama_sub_kategori;
			$row[] = $listProduk->harga;
			$row[] = $listProduk->nama_satuan;
			$row[] = $listProduk->bahan_produk;
			//add html for action button
			if ($listProduk->status == '1') {
				$row[] =
				'<a class="btn btn-sm btn-default" href="'.$link_detail.'" title="Detail" id="btn_detail"><i class="glyphicon glyphicon-search"></i> Detail</a>
				 <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Balas" onclick="editProduk('."'".$listProduk->id_produk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-success btn_edit_status" href="javascript:void(0)" title="aktif" id="'.$listProduk->id_produk.'"><i class="fa fa-check"></i> Aktif</a>';
			}else{
				$row[] =
				'<a class="btn btn-sm btn-default" href="'.$link_detail.'" title="Detail" id="btn_detail"><i class="glyphicon glyphicon-search"></i> Detail</a>
				 <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Balas" onclick="editProduk('."'".$listProduk->id_produk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger btn_edit_status" href="javascript:void(0)" title="nonaktif" id="'.$listProduk->id_produk.'"><i class="fa fa-times"></i> Nonaktif</a>';
			}
			
			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_prod->count_all_produk(),
						"recordsFiltered" => $this->m_prod->count_filtered_produk(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function list_produk_detail($idProduk)
	{
		$list = $this->m_prod->get_datatable_produk_detail($idProduk);
		$data = array();
		$no = $_POST['start'];
		$nomor_urut = '1';
		foreach ($list as $listProduk) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $nomor_urut;
			$row[] = $listProduk->ukuran_produk;
			$row[] = $listProduk->berat_satuan;
			$row[] = $listProduk->stok_awal;
			$row[] = $listProduk->stok_sisa;
			$row[] = $listProduk->stok_minimum;
			//add html for action button
			if ($listProduk->status == '1') {
				$row[] =
				'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editDetail('."'".$listProduk->id_stok."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                 <a class="btn btn-sm btn-success btn_edit_status_det" href="javascript:void(0)" title="aktif" id="'.$listProduk->id_stok.'"><i class="fa fa-times"></i> Aktif</a>';
             }else{
             	$row[] =
				'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editDetail('."'".$listProduk->id_stok."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                 <a class="btn btn-sm btn-danger btn_edit_status_det" href="javascript:void(0)" title="nonaktif" id="'.$listProduk->id_stok.'"><i class="fa fa-check"></i> Nonaktif</a>';
             }
			$data[] = $row;
			$nomor_urut++;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_prod->count_all_produk_detail($idProduk),
						"recordsFiltered" => $this->m_prod->count_filtered_produk_detail($idProduk),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function master_produk_detail($id)
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_user->get_data_user($id_user);

		$jumlah_notif = $this->m_user->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_user->get_email_notif($id_user); //menampilkan isi email

		$query_header = $this->m_prod->get_detail_produk_header($id);

		$data = array(
			'content'=>'view_list_detail_produk',
			'modal'=>'modalDetailProdukAdm',
			'js'=>'MasterProdukAdmJs',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_header' => $query_header
		);
		$this->load->view('temp_adm',$data);
	}

	public function get_master_kategori()
	{
		$data = $this->m_prod->get_data_kategori();
		foreach ($data as $row) {
			$kategori[] = array(
						'id' => $row->id_kategori,
						'text' => $row->nama_kategori,
					);
		}
		echo json_encode ($kategori);
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
		echo json_encode ($sub_kategori);
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

	public function add_data_produk_detail()
	{
		$size = $this->input->post('ukuranProdukDet');
		$data = array(
			'id_produk' => $this->input->post('idProduk'),
			'ukuran_produk' => $size,
			'berat_satuan' => trim($this->input->post('beratSatuanDet')),
			'stok_awal' => trim($this->input->post('stokAwalDet')),
			'stok_sisa' => trim($this->input->post('stokAwalDet')),
			'stok_minimum' => trim($this->input->post('stokMinDet'))
		);
		//cek ukuran di db
		$cek_size = $this->m_prod->cek_size_produk($size, $this->input->post('idProduk'));
		if ($cek_size == $size) {
			echo json_encode(array(
				'status' => TRUE,
				'pesan' => "Maaf untuk produk ukuran \"".$size."\" sudah ada"
			));
		}else{
			$this->m_prod->insert_data_produk_detail($data);

			echo json_encode(array(
				'status' => TRUE,
				'pesan' => "Data produk detail berhasil disimpan"
			));
		}
	}

	public function update_produk_detail()
	{
		$size = $this->input->post('ukuranProdukDet');
		$data = array(
			'id_produk' => $this->input->post('idProduk'),
			'berat_satuan' => trim($this->input->post('beratSatuanDet')),
			'stok_awal' => trim($this->input->post('stokAwalDet')),
			'stok_minimum' => trim($this->input->post('stokMinDet'))
		);
		//cek ukuran di db
		$this->m_prod->update_data_produk_detail(array('id_stok' => $this->input->post('idProdukDet')), $data);

		echo json_encode(array(
			'status' => TRUE,
			'pesan' => "Data produk detail berhasil diupdate"
		));
	}

	public function edit_data_produk($id_produk)
	{
		$idGbr = array();
		$produk = $this->m_prod->get_data_produk($id_produk);
		$gbrDetail = $this->m_prod->get_data_gbr_detail($id_produk);
		//assign variable dari row result
		$id_prod = $produk->id_produk;
		$id_gambar = $produk->id_gambar;
		$id_kategori = $produk->id_kategori;
		$nama_kategori = $produk->nama_kategori;
		$id_sub_kategori = $produk->id_sub_kategori;
		$nama_sub_kategori = $produk->nama_sub_kategori;
		$nama_produk = $produk->nama_produk;
		$nama_gambar = $produk->nama_gambar;
		$keterangan_produk = $produk->keterangan_produk;
		$harga = $produk->harga;
		$id_satuan = $produk->id_satuan;
		$nama_satuan = $produk->nama_satuan;
		$bahan_produk = $produk->bahan_produk;
		
		//loop u/ cari id gambar dari model
		for ($i=0; $i < 3 ; $i++) { 
			if (isset($gbrDetail[$i]['id_gambar'])) {
				$idGbr[] = $gbrDetail[$i]['id_gambar'];
				$namaGbr[] = $gbrDetail[$i]['nama_gambar'];
			}
		}
		//set to "" bila data id_gambar belum di set
		if (!isset($idGbr[0])) { $idGbr[0] = ""; }
		if (!isset($idGbr[1])) { $idGbr[1] = ""; }
		if (!isset($idGbr[2])) { $idGbr[2] = ""; }
		//set to "" bila data nama_gambar belum di set
		if (!isset($namaGbr[0])) { $namaGbr[0] = ""; }
		if (!isset($namaGbr[1])) { $namaGbr[1] = ""; }
		if (!isset($namaGbr[2])) { $namaGbr[2] = ""; }
		//assign array untuk di parsing ke json
		$data['id_gambar'] = $id_gambar;
		$data['nama_gambar'] = $nama_gambar;
		$data['id_gambar_detail1'] = $idGbr[0];
		$data['id_gambar_detail2'] = $idGbr[1];
		$data['id_gambar_detail3'] = $idGbr[2];
		$data['nama_gambar_detail1'] = $namaGbr[0];
		$data['nama_gambar_detail2'] = $namaGbr[1];
		$data['nama_gambar_detail3'] = $namaGbr[2];
		$data['id_produk'] = $id_prod;
		$data['id_kategori'] = $id_kategori;
		$data['nama_kategori'] = $nama_kategori;
		$data['id_sub_kategori'] = $id_sub_kategori;
		$data['nama_sub_kategori'] = $nama_sub_kategori;
		$data['nama_produk'] = $nama_produk;
		$data['keterangan_produk'] = $keterangan_produk;
		$data['harga'] = $harga;
		$data['id_satuan'] = $id_satuan;
		$data['nama_satuan'] = $nama_satuan;
		$data['bahan_produk'] = $bahan_produk;

		echo json_encode($data);
	}

	public function edit_data_produk_detail($id_stok)
	{
		$data = $this->m_prod->get_data_produk_detail($id_stok);
		echo json_encode($data);
	}	

	public function update_produk()
	{
		$timestamp = date('Y-m-d H:i:s');
		$id_produk = $this->input->post('idProduk');
		//get extension
		$path = $_FILES['gambarDisplay']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		//replace space with dash
		$nmfile = str_replace(" ", "-", strtolower(trim($this->input->post('namaProduk'))));

		$data = array(
			'id_kategori' => $this->input->post('kategoriProduk'),
			'id_sub_kategori' => $this->input->post('subKategoriProduk'),
			'nama_produk' => trim($this->input->post('namaProduk')),
			'harga' => trim($this->input->post('hargaProduk')),
			'id_satuan' => $this->input->post('satuanProduk'),
			'keterangan_produk' => trim($this->input->post('keteranganProduk')),
			'bahan_produk' => trim($this->input->post('bahanProduk')),
			'modified' => $timestamp,
			'status' => '1'
		);
		//update data (PROSES PERTAMA)
		$this->m_prod->update_data_produk(array('id_produk' => $id_produk), $data);

		//update data tabel gambar
		//load konfig upload
		$this->konfigurasi_upload_produk($nmfile);
		//jika gbr display tdk kosong
		if(!empty($_FILES['gambarDisplay']['name']))
		{
			//jika melakukan upload foto
			if ($this->gbr_produk->do_upload('gambarDisplay')) 
			{
				//$this->gbr_produk->do_upload('gambarDisplay');
				$gbrDisplay = $this->gbr_produk->data();
				//inisiasi variabel u/ digunakan pada fungsi config img produk
				$nama_file_produk = $gbrDisplay['file_name'];
			    //load config img produk
			    $this->konfigurasi_image_produk($nama_file_produk);
		        //data input array
				$input_display = array(			
					'jenis_gambar' => 'display',
					'nama_gambar' => $gbrDisplay['file_name'],
				);
				//clear img lib after resize
				$this->image_lib->clear();
				//save data (PROSES KEDUA)
				$this->m_prod->update_data_gambar(array('id_gambar' => $this->input->post('idGbrDisplay')), $input_display);
			} //end 
		}			
		//insert data tabel gambar detail
		
		$this->konfigurasi_upload_produk_detail(); //load config image detail
		for ($i=1; $i<=3 ; $i++) 
		{
			if(!empty($_FILES['gambarDetail'.$i]['name']))
			{
				//get detail extension
				$pathDet = $_FILES['gambarDetail'.$i]['name'];
				$extDet = pathinfo($pathDet, PATHINFO_EXTENSION);

				if ($this->gbr_detail->do_upload('gambarDetail'.$i)) 
				{
			        $gbrDetail = $this->gbr_detail->data();//get file upload data
		            $config['image_library'] = 'gd2';
		            $config['source_image'] = './assets/img/produk/img_detail/'.$gbrDetail['file_name'];
		            $config['create_thumb'] = FALSE;
		            $config['overwrite'] = TRUE;
		            $config['maintain_ratio'] = FALSE;
		            $config['width'] = 450; //resize
		            $config['height'] = 500; //resize
		            $config['new_image'] = './assets/img/produk/img_detail/'.$nmfile."-det".$i.".".$extDet;
		            $this->load->library('image_lib',$config);
		            $this->image_lib->initialize($config);
		            $this->image_lib->resize();
		            $input_detail = array(			
						'jenis_gambar' => 'detail',
						'nama_gambar' => $nmfile."-det".$i.".".$extDet,
					);
					//save data (PROSES KETIGA)
					$this->m_prod->update_data_gambar(array('id_gambar' => $this->input->post('idGbrDet'.$i)), $input_detail);
	                $this->image_lib->clear();//clear img lib after resize
	                $ifile = '/e-commerce/assets/img/produk/img_detail/'.$gbrDetail['file_name']; 
					unlink($_SERVER['DOCUMENT_ROOT'] .$ifile); // use server document root
	            }
			} //end isset files
		}//end loop

		echo json_encode(array(
			'status' => TRUE,
			'pesan' => "Data Produk ".$id_produk." Berhasil diupdate" 
		));
	}

	public function edit_status_produk($id)
	{
		$input_status = $this->input->post('status');
		// jika aktif maka di set ke nonaktif / "0"
		if ($input_status == " Aktif") {
			$status = '0';
			$psn_txt = "Produk dengan kode ".$id." dinonaktifkan.";
		} elseif ($input_status == " Nonaktif") {
			$status = '1';
			$psn_txt = "Produk dengan kode ".$id." diaktifkan.";
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

	public function edit_status_produk_detail($id)
	{
		$input_status = $this->input->post('status');
		// jika aktif maka di set ke nonaktif / "0"
		if ($input_status == " Aktif") {
			$status = '0';
		} elseif ($input_status == " Nonaktif") {
			$status = '1';
		}
		
		$input = array(
			'status' => $status 
		);
		$this->m_prod->update_status_produk_detail(array('id_stok' => $id), $input);
		$data = array(
			'status' => TRUE,
			'pesan' => "Status Produk berhasil diperbaharui.",
		);

		echo json_encode($data);
	}

}//end of class Master_produk_admp.php
