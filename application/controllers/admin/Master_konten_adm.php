<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_konten_adm extends CI_Controller
{

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
        $konten = $this->m_global->getSelectedData('m_konten', null, null)->row();

		$data = array(
			'modal' => 'modalMasterProdukAdm',
			'js' => 'masterProdukAdmJs',
            'data_user' => $data_user,
            
 		);

		$data = array(
			'data_user' => $data_user,
            'isi_notif' => $isi_notif,
            'konten'    => $konten,
		);

		$content = [
			'css' => 'adm_view/css/css_summernote',
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
            'js'	=> 'adm_view/js/js_konten_adm',
            // 'js'	=> false,
			'modal' => false,
			'view'	=> 'adm_view/v_master_konten'
		];

		$this->template_view->load_view($content, $data);
    }
    
    public function add_konten(){
        $konten = $this->input->post('konten');
        $data['isi'] = $konten;
        $cek_konten = $this->m_global->getSelectedData('m_konten', null, null)->row();
        if (!empty($cek_konten)) {
            $data_where = array('id_konten' => $cek_konten->id_konten);
            $this->m_global->updateData('m_konten', $data_where, $data);
            $status['STATUS'] = 'berhasil';
            $status['MESSAGE'] = 'Konten berhasil diupdate !!';
        }else{
            $this->m_global->insert_data('m_konten', $data);
            $status['STATUS'] = 'berhasil';
            $status['MESSAGE'] = 'Konten berhasil dirubah !!';
        }
        
        echo json_encode($status);
        
    } 

	

	
}//end of class Master_produk_admp.php
