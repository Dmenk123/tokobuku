<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'email'));
        $this->load->helper(array('url', 'form', 'text', 'html', 'security', 'file', 'directory', 'number', 'date', 'download'));
        $this->load->model(['mod_global']);
        $this->load->library('cart');
	}

	public function index()
	{
		$this->load->view('v_navbar');
		$this->load->view('v_cart');
		$this->load->view('footer');
	}

	function add_to_cart($id_produk)
	{
		$where = ['m_produk.id' => $id_produk];
		$select = "m_produk.*, m_kategori.nama as nama_kategori, m_satuan.nama as nama_satuan, t_log_harga.harga_satuan, t_log_harga.potongan";
		$join = array(
			["table" => "m_kategori", "on" => "m_produk.id_kategori = m_kategori.id"],
			["table" => "m_satuan", "on"  => "m_produk.id_satuan = m_satuan.id"],
			["table" => "t_log_harga", "on" => "m_produk.id = t_log_harga.id_produk"]
		);

		$produk = $this->mod_global->get_data_single($select, 'm_produk', $where, $join);
		
        $nama_produk = $produk->nama; 
        $harga_produk = $produk->harga_satuan; 
        $qty_produk = 1;
        $gambar_produk = $produk->gambar_1;
        $id_satuan = $produk->id_satuan;
        $nama_satuan = $produk->nama_satuan;
        $id_kategori = $produk->id_kategori;
        $nama_kategori = $produk->nama_kategori;
        
        //store to array index with reserved word in cart library
        $data = array(
            'id' => $id_produk,
            'qty' => $qty_produk,
            'price' => $harga_produk,   
            'name' => $nama_produk, 
            'options' => array(
                            'Gambar_produk' => $gambar_produk,
                            'Id_satuan_produk' => $id_satuan,
                            'Nama_satuan_produk' => $nama_satuan,
                            'Id_kategori_produk' => $id_kategori,
                            'Nama_kategori_produk' => $nama_kategori
                        ) 
        );
        $this->cart->insert($data);
        
        echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Produk '.$nama_produk.' Ditambahkan pada keranjang belanja'
		));
    }

    function show_cart()
    {
        //deklarasi variabel
        $output = '';
        $beratTotal=0;
        //var_dump($this->cart->contents());exit;
        foreach ($this->cart->contents() as $items) {
        	$link_img = $items['options']['Gambar_produk'];
        	$subtotal = $items['price'] * (int)$items['qty'];
            $output .='
            	<tr>
                  <td>
                  	<a class="ps-product__preview" href="'.base_url('product_detail/index/'.$items['id'].'').'" target="_blank">
                  	<img width="100" height="100" class="mr-15" src="'.site_url("assets/img/produk/$link_img").'" alt=""> '.$items['name'].'
                  	</a>
                  </td>
                  <td>Rp. '.number_format($items['price'],0,",",".").'</td>
                  <td> 
            		<select style="width:40px;" id="'.$items['rowid'].'" class="cart_qty">';
            			for ($i=1; $i <= 10; $i++) {
            				if ($i == $items['qty']) {
            					$output .='<option value="'.$i.'" selected>'.$i.'</option>';
            				}else{
            					$output .='<option value="'.$i.'">'.$i.'</option>';	
            				}
                    	}	
                    $output .='</select>
                </td>
                  <td>Rp. '.number_format($subtotal,0,",",".").'</td>
                  <td><button type="button" id="'.$items['rowid'].'" class="btn ps-remove hapus_cart"></button></td>
                </tr>
            ';
        }

        /*//hitung berat total
        foreach($this->cart->contents() as $item)
        {
           $beratTotal += $item['options']['Berat_produk'] * $item['qty'];
        }

        //lanjutkan variabel output
        $output .= '
            <tr>
                <th colspan="5">Berat Total</th>
                <th colspan="3">'.number_format($beratTotal,0,",",".").' gram </th>
            </tr>
            <tr>
                <th colspan="6"><span style="font-size:20px;">Total Belanja</span></th>
                <th colspan="2" style="text-align:right;">
                    <span style="font-size:20px; text-decoration:underline;">
                        Rp. '.number_format($this->cart->total(),0,",",".").'
                    </span>
                </th>
            </tr>
        ';*/
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
            	<div class="ps-cart__promotion">
	    			<div class="form-group">
		      			<a class="ps-btn ps-btn--gray" href="'.base_url('product_listing').'">Lanjutkan Belanja</a>
		    		</div>
		  		</div>
				<div class="ps-cart__total">
				    <h3>Harga Total: <span> Rp. '.number_format($this->cart->total(),0,",",".").'</span></h3>
				    <a class="ps-btn" href="'.base_url('checkout').'">Proses Checkout<i class="ps-icon-next"></i></a>
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
 
    function hapus_cart(){ 
        $data = array(
            'rowid' => $this->input->post('row_id'), 
            'qty' => 0, 
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

     function update_cart(){ 
        $data = array(
            'rowid' => $this->input->post('row_id'), 
            'qty' => $this->input->post('qty'), 
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

}
