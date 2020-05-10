<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_komisi_agen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_global', 'm_global');
		$this->load->model('adm_model/mod_user', 'm_user');
		$this->load->model('adm_model/mod_penjualan', 'm_jual');

		if (!$this->session->userdata('id_user')) {
			return redirect('admin/login','refresh');
		}
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
		$data_agen = $this->db->query("select m_user.*, m_user_detail.nama_lengkap_user from m_user join m_user_detail on m_user.id_user = m_user_detail.id_user where m_user.id_level_user = '2' order by nama_lengkap_user asc")->result();
		$data = array(
			'data_user' => $data_user,
			'data_agen' => $data_agen,
			'isi_notif' => $isi_notif,
			'arr_bulan' => $this->arr_bulan(),
			'cek_kunci' => FALSE
		);

		$content = [
			'css' => false,
			// 'modal' => 'adm_view/modal/modalSetRoleAdm',
			'js'	=> 'adm_view/js/js_lap_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/laporan/v_lap_komisi_agen'
		];

		$this->template_view->load_view($content, $data);
	}

	public function lap_detail()
	{
		$isi_notif = [];
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$arr_bulan = $this->arr_bulan();

		$bulan = clean_string($this->input->get('bulan'));
		$tahun = clean_string($this->input->get('tahun'));
		$id_user_agen = clean_string($this->input->get('kode_user_agen'));
		$data_user_agen = $this->m_user->get_detail_user($id_user_agen);

		$periode = $arr_bulan[$bulan].' '.$tahun;
		$saldo_awal = 0;
		$saldo_akhir = 0;
		$arr_data = [];

		$tanggal_awal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 00:00:00'));
		$tanggal_akhir = date('Y-m-t H:i:s', strtotime($tahun . '-' . $bulan . '-01 23:59:59'));

		$query_lap = $this->m_jual->get_detail_lap_agen($tanggal_awal, $tanggal_akhir, $id_user_agen);

		$rowspan = 0;
		$id_klaim = '';
		$str_table = '';
		@$id_klaim = $query_lap[0]->id_klaim;
		$laba_agen_total = 0;
		$klaim_agen_total = 0;
		$transfer_total = 0;

		if ($query_lap) {
           	foreach ($query_lap as $key => $val) {
           		$laba_agen_total += $val->laba_agen_total;
           		$rowspan = 0;
	           	$str_table .= "<tr>";
	            $str_table .= "<td>".date('d-m-Y', strtotime($val->created_at))."</td>";
	            $str_table .= "<td>".$val->nama_lengkap_user."</td>";
	            $str_table .= "<td>";
		            $str_table .= "<div>";
			            $str_table .= "<span class='pull-left'>Rp. </span>";
			            $str_table .= "<span class='pull-right'>".number_format($val->laba_agen_total, 2, ",", ".")."</span>";
		            $str_table .= "</div>";
	            $str_table .= "</td>";
	            $str_table .= "<td>".$val->kode_ref."</td>";
	           
            	for ($i=$key; $i < count($query_lap); $i++) 
            	{ 
	            	if ($query_lap[$i]->id_klaim == $id_klaim) {
            			$rowspan++;
	            	}else{
	            		//cek jika nilai sama dengan array sebelumnya, maka skip
	            		if ($query_lap[$i]->id_klaim == $query_lap[$i-1]->id_klaim) {
	            			break;
	            		}
	            		// jika tidak set flag id_klaim
	            		else{
	            			$id_klaim = $query_lap[$i]->id_klaim;
	            			break;
	            		}
	            	}
	            }

	            //cek jika rowspan lebih dari 0 maka tampilkan tabel, jika tidak skip
	            if ($rowspan > 0) {
	            	$klaim_agen_total += $val->jumlah_klaim;
	            	$transfer_total += $val->nilai_transfer;

	            	$str_table .= "<td rowspan='".$rowspan."'>".$val->kode_klaim."</td>";
		            $str_table .= "<td rowspan='".$rowspan."' align='center'>";
		            if ($val->tgl_klaim) {
		            	$str_table .= date('d-m-Y', strtotime($val->tgl_klaim));
					}else{
		            	$str_table .= " - ";
		            }
		            $str_table .= "</td>";
		            $str_table .= "<td rowspan='".$rowspan."'>";
	                $str_table .= "<div>";
	                $str_table .= "<span class='pull-left'>Rp. </span>";
	                $str_table .= "<span class='pull-right'>".number_format($val->jumlah_klaim, 2, ",", ".")."</span>";
	                $str_table .= "</div>";
		            $str_table .= "</td>";
		            $str_table .= "<td rowspan='".$rowspan."' align='center'>";    
	              	if ($val->tanggal_verify) {
	                	$str_table .= date('d-m-Y', strtotime($val->tanggal_verify));
	              	}else{
	                	" - ";
	              	}
		            $str_table .= "</td>";
		            $str_table .= "<td rowspan='".$rowspan."'>";
		            $str_table .= "<div>";
	                if ($val->tanggal_verify) { 
	                	$str_table .= "<span class='pull-left'>Rp. </span>";
	                	$str_table .= "<span class='pull-right'>".number_format($val->nilai_transfer, 2, ",", ".")."</span>";
	               	}else{ 
	                	$str_table .= "<span> - </span>";
	               	} 
		            $str_table .= "</div>";
		            $str_table .= "</td>";
	            }

	            $str_table .= "</tr>";
           	}//end foreach

           	$str_table .= "<tr>";
           	$str_table .= "<td colspan='2'><strong>Grand Total</strong></td>";
           	$str_table .= "<td>";
	           	$str_table .= "<div>";
		            $str_table .= "<span class='pull-left'>Rp. </span>";
		            $str_table .= "<span class='pull-right'><strong>".number_format($laba_agen_total, 2, ",", ".")."</strong></span>";
	            $str_table .= "</div>";
		    $str_table .= "</td>";
		    $str_table .= "<td colspan='3'></td>";
		    $str_table .= "<td>";
	           	$str_table .= "<div>";
		            $str_table .= "<span class='pull-left'>Rp. </span>";
		            $str_table .= "<span class='pull-right'><strong>".number_format($klaim_agen_total, 2, ",", ".")."</strong></span>";
	            $str_table .= "</div>";
		    $str_table .= "</td>";
		    $str_table .= "<td></td>";
		     $str_table .= "<td>";
	           	$str_table .= "<div>";
		            $str_table .= "<span class='pull-left'>Rp. </span>";
		            $str_table .= "<span class='pull-right'><strong>".number_format($transfer_total, 2, ",", ".")."</strong></span>";
	            $str_table .= "</div>";
		    $str_table .= "</td>";
           	$str_table .= "</tr>";
        }else{
    		$str_table .= "<tr>";
            $str_table .= "<td colspan='9' align='center'> <strong>Tidak Ada Data ...</strong> </td>";
            $str_table .= "</tr>";
        }

		$data = array(
			'data_user' => $data_user,
			'isi_notif' => $isi_notif,
			'arr_bulan' => $this->arr_bulan(),
			'cek_kunci' => FALSE,
			'periode' => $periode,
			'hasil_data' => $str_table,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'id_user_agen' => $id_user_agen,
			'data_user_agen' => $data_user_agen,
			'cek_status_kunci' => TRUE //sementara di set true, soalnya belum tau ada konsep kuncian atau tidak
		);

		$content = [
			'css' => false,
			'js'	=> 'adm_view/js/js_lap_penjualan',
			'modal' => false,
			'view'	=> 'adm_view/laporan/v_lap_komisi_agen_detail'
		];

		$this->template_view->load_view($content, $data);
	}

	public function cetak_report($bulan, $tahun, $kode_user_agen)
	{
		// $this->load->library('Pdf_gen');
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->m_user->get_detail_user($id_user);
		$arr_bulan = $this->arr_bulan();
		$periode = $arr_bulan[$bulan].' '.$tahun;
		$saldo_awal = 0;
		$saldo_akhir = 0;
		$arr_data = [];

		$tanggal_awal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 00:00:00'));
		$tanggal_akhir = date('Y-m-t H:i:s', strtotime($tahun . '-' . $bulan . '-01 23:59:59'));

		$query_lap = $this->m_jual->get_detail_lap_agen($tanggal_awal, $tanggal_akhir, $kode_user_agen);
		$data_user_agen = $this->m_user->get_detail_user($kode_user_agen);

		$rowspan = 0;
		$id_klaim = '';
		$str_table = '';
		@$id_klaim = $query_lap[0]->id_klaim;
		$laba_agen_total = 0;
		$klaim_agen_total = 0;
		$transfer_total = 0;

		if ($query_lap) {
           	foreach ($query_lap as $key => $val) {
           		$laba_agen_total += $val->laba_agen_total;
           		$rowspan = 0;
	           	$str_table .= "<tr>";
	            $str_table .= "<td>".date('d-m-Y', strtotime($val->created_at))."</td>";
	            $str_table .= "<td>".$val->nama_lengkap_user."</td>";
	            $str_table .= "<td>";
		            $str_table .= "<div>";
			            $str_table .= "<span class='pull-left'>Rp. </span>";
			            $str_table .= "<span class='pull-right'>".number_format($val->laba_agen_total, 2, ",", ".")."</span>";
		            $str_table .= "</div>";
	            $str_table .= "</td>";
	            $str_table .= "<td>".$val->kode_ref."</td>";
	           
            	for ($i=$key; $i < count($query_lap); $i++) 
            	{ 
	            	if ($query_lap[$i]->id_klaim == $id_klaim) {
            			$rowspan++;
	            	}else{
	            		//cek jika nilai sama dengan array sebelumnya, maka skip
	            		if ($query_lap[$i]->id_klaim == $query_lap[$i-1]->id_klaim) {
	            			break;
	            		}
	            		// jika tidak set flag id_klaim
	            		else{
	            			$id_klaim = $query_lap[$i]->id_klaim;
	            			break;
	            		}
	            	}
	            }

	            //cek jika rowspan lebih dari 0 maka tampilkan tabel, jika tidak skip
	            if ($rowspan > 0) {
	            	$klaim_agen_total += $val->jumlah_klaim;
	            	$transfer_total += $val->nilai_transfer;

	            	$str_table .= "<td rowspan='".$rowspan."'>".$val->kode_klaim."</td>";
		            $str_table .= "<td rowspan='".$rowspan."' align='center'>";
		            if ($val->tgl_klaim) {
		            	$str_table .= date('d-m-Y', strtotime($val->tgl_klaim));
					}else{
		            	$str_table .= " - ";
		            }
		            $str_table .= "</td>";
		            $str_table .= "<td rowspan='".$rowspan."'>";
	                $str_table .= "<div>";
	                $str_table .= "<span class='pull-left'>Rp. </span>";
	                $str_table .= "<span class='pull-right'>".number_format($val->jumlah_klaim, 2, ",", ".")."</span>";
	                $str_table .= "</div>";
		            $str_table .= "</td>";
		            $str_table .= "<td rowspan='".$rowspan."' align='center'>";    
	              	if ($val->tanggal_verify) {
	                	$str_table .= date('d-m-Y', strtotime($val->tanggal_verify));
	              	}else{
	                	" - ";
	              	}
		            $str_table .= "</td>";
		            $str_table .= "<td rowspan='".$rowspan."'>";
		            $str_table .= "<div>";
	                if ($val->tanggal_verify) { 
	                	$str_table .= "<span class='pull-left'>Rp. </span>";
	                	$str_table .= "<span class='pull-right'>".number_format($val->nilai_transfer, 2, ",", ".")."</span>";
	               	}else{ 
	                	$str_table .= "<span> - </span>";
	               	} 
		            $str_table .= "</div>";
		            $str_table .= "</td>";
	            }

	            $str_table .= "</tr>";
           	}//end foreach

           	$str_table .= "<tr>";
           	$str_table .= "<td colspan='2'><strong>Grand Total</strong></td>";
           	$str_table .= "<td>";
	           	$str_table .= "<div>";
		            $str_table .= "<span class='pull-left'>Rp. </span>";
		            $str_table .= "<span class='pull-right'><strong>".number_format($laba_agen_total, 2, ",", ".")."</strong></span>";
	            $str_table .= "</div>";
		    $str_table .= "</td>";
		    $str_table .= "<td colspan='3'></td>";
		    $str_table .= "<td>";
	           	$str_table .= "<div>";
		            $str_table .= "<span class='pull-left'>Rp. </span>";
		            $str_table .= "<span class='pull-right'><strong>".number_format($klaim_agen_total, 2, ",", ".")."</strong></span>";
	            $str_table .= "</div>";
		    $str_table .= "</td>";
		    $str_table .= "<td></td>";
		     $str_table .= "<td>";
	           	$str_table .= "<div>";
		            $str_table .= "<span class='pull-left'>Rp. </span>";
		            $str_table .= "<span class='pull-right'><strong>".number_format($transfer_total, 2, ",", ".")."</strong></span>";
	            $str_table .= "</div>";
		    $str_table .= "</td>";
           	$str_table .= "</tr>";
        }else{
    		$str_table .= "<tr>";
            $str_table .= "<td colspan='9'> <strong>Tidak Ada Data ...</strong> </td>";
            $str_table .= "</tr>";
        }      

		$data['hasil_tabel'] = $str_table;
		$data['periode'] = $periode;
		$data['title'] = 'Laporan Komisi Agen';
	    $data['data_user'] = $data_user;
	    $data['data_user_agen'] = $data_user_agen;
	    
	    $this->load->view('adm_view/laporan/v_lap_komisi_agen_cetak', $data);
	    
	    // $html = $this->load->view('adm_view/laporan/v_lap_penjualan_agen_cetak', $data, true);
	    // $filename = 'laporan_komisi_agen_'.time();
	    // $this->pdf_gen->generate($html, $filename, true, 'A4', 'landscape');
	}

}//end of class penjualan.php
