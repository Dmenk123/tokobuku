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

}
