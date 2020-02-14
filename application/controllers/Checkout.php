<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global']);
        $this->load->library('cart');

		if ($this->session->userdata('logged_in') != TRUE) {
		 	redirect('register','refresh');
		}
	}

	public function index()
	{
		$id_user = $this->session->userdata('id_user');
		$where = ['m_user.id_user' => $id_user];
		$select = "m_user.*, m_user_detail.nama_lengkap_user, m_user_detail.no_telp_user, m_user_detail.email";
		$join = array(
			["table" => "m_user_detail", "on" => "m_user.id_user = m_user_detail.id_user"]
		);

		$data['userdata'] = $this->mod_global->get_data_single($select, 'm_user', $where, $join);
		
		$arr_nama = explode(",", $data['userdata']->nama_lengkap_user);
		$data['nama_depan'] = $arr_nama[0];
		$data['nama_belakang'] = $arr_nama[1];

		$this->load->view('v_navbar');
		$this->load->view('v_checkout', $data);
		$this->load->view('footer');
	}

	 function show_cart()
    {
        //deklarasi variabel
        $output = '';
        $beratTotal=0;
        //var_dump($this->cart->contents());exit;
        foreach ($this->cart->contents() as $items) {
        	$subtotal = $items['price'] * (int)$items['qty'];
            $output .='
            	<tr>
                  <td>
                  	<a class="ps-product__preview" href="'.base_url('product_detail/index/'.$items['id'].'').'" target="_blank">
                  		'.$items['name'].'
                  	</a>
                  </td>
                  <td>'.$items['qty'].'</td>
                  <td>Rp. '.number_format($subtotal,0,",",".").'</td>
                </tr>
            ';
        }
        return $output;
    }
 
    function load_cart(){ //load data cart
        echo $this->show_cart();
    }

    function show_summary()
    { 
        foreach ($this->cart->contents() as $items) {
            $link_img = $items['options']['Gambar_produk'];

            $output = '
            	<div class="ps-cart__total" align="left">
				    <h3>Harga Total : <span class="pull-right"> Rp. '.number_format($this->cart->total(),0,",",".").'</span></h3>
				</div>
            ';
        }
        if (isset($output)) 
        {
            return $output;
        }
        else
        {
            $output = '<div class="ps-cart__promotion">
            				<p> Daftar Belanja Anda Kosong </p>
            				<hr>
			    			<div class="form-group">
				      			<a class="ps-btn ps-btn--gray" href="'.base_url('product_listing').'">Lanjutkan Belanja</a>
				    		</div>
				  		</div>';
            return $output;
        }
        
    }

    function load_summary(){ //load data cart
        echo $this->show_summary();
    }

    public function add_data()
    {
    	$arr_valid = $this->_validate();
    	$fname = clean_string($this->input->post('fname')); 
		$lname = clean_string($this->input->post('lname')); 
		$email = clean_string($this->input->post('email')); 
		$telepon = clean_string($this->input->post('telepon')); 
		$catatan = clean_string($this->input->post('catatan'));
		$namafileseo = $this->seoUrl($nama . ' ' . time());

		$this->db->trans_begin();
		$id = $this->m_global->gen_uuid();

		if ($arr_valid['status'] == FALSE) {
			// echo json_encode($arr_valid);
			// return;
			$this->session->set_flashdata('feedback_failed','Gagal menyimpan Data, pastikan telah mengisi semua inputan.'); 
			redirect('checkout');
		}

		//load konfig upload
		$this->konfigurasi_upload_bukti($namafileseo);
		$path = $_FILES['bukti']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		if ($this->bukti_tf->do_upload('bukti')) {
			$gbr = $this->bukti_tf->data(); //get file upload data
			$this->konfigurasi_image_bukti($gbr['file_name'], $namafileseo, $ext, $i);
			$arr_gambar = ['nama_gambar' => $namafileseo . "-" . $i . "." . $ext];

			//clear img lib after resize
			$this->image_lib->clear();

			//unlink file upload, just image processed file only saved in server
			$ifile = '/bookstore/assets/img/bukti_transfer/' . $namafileseo . '.' . $ext;
			unlink($_SERVER['DOCUMENT_ROOT'] . $ifile); // use server document root

		}else{
			$this->session->set_flashdata('feedback_failed','Gagal menyimpan Data, pastikan telah Upload Bukti Transfer.'); 
			redirect('checkout');
		}

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
    }

    private function konfigurasi_upload_bukti($nmfile)
	{
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/bukti_transfer/';
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

	private function konfigurasi_image_bukti($filename, $newname, $ext, $urut)
	{
		//konfigurasi image lib
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/bukti_transfer/' . $filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['new_image'] = './assets/img/bukti_transfer/' . $newname . "-" . $urut . "." . $ext;
		$config['overwrite'] = TRUE;
		$config['width'] = 450; //resize
		$config['height'] = 500; //resize
		$this->load->library('image_lib', $config); //load image library
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

    private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('fname') == '') {
			$data['inputerror'][] = 'fname';
			$data['error_string'][] = 'Wajib mengisi nama depan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Wajib mengisi email';
			$data['status'] = FALSE;
		}

		if ($this->input->post('telp') == '') {
			$data['inputerror'][] = 'telp';
			$data['error_string'][] = 'Wajib mengisi nomor telepon';
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

}
