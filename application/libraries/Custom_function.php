<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Custom_function {

    /**
    * DIGUNAKAN UNTUK MENGAMBIL UNIT KERJA ATASAN MAUPUN BAWAHANNYA
    * @param next_level, MERUPAKAN ID LEVEL ATASAN YANG AKAN DICARI / YANG DIKETAHUI
    * @param unit_kerja, MERUPAKAN UNIT KERJA YANG AKAN DIGUNAKAN
    */

    function next_posisi($next_level, $unit_kerja, $mode=null,$level=null,$flag_ttd=null){
        // $level += 1;
        $dinas = substr($unit_kerja, 0, 3);
        $sekre = substr($unit_kerja, 0, 6);
        $dinas1 = substr($unit_kerja, 3, 3);
        $dinas2 = substr($unit_kerja, 6, 3);
        if ($next_level == 4 || $next_level == 100) {
            $unit_kerja = $unit_kerja;
        } elseif ($next_level == 3 || $next_level == 19 || $next_level == 9 ) {
            $unit_kerja = $dinas.$dinas1.$dinas2;
        } elseif ($next_level == 2 || $next_level == 17 || $next_level == 8) {
            $unit_kerja = $dinas.$dinas1;
        } elseif ($next_level == 5  || $next_level == 24 || $next_level == 27) {
            $unit_kerja = $dinas;
        } elseif($next_level == 1 || $next_level == 23 || $next_level == 7){
            $unit_kerja = $dinas;
        } elseif ($next_level == 6 && $level==17) {
            $unit_kerja = substr($unit_kerja, 0, 5);
        } elseif ($next_level == 6 && $flag_ttd == 6) {
            $unit_kerja = substr($unit_kerja, 0, 6);
        } elseif ($next_level == 6) {
            $unit_kerja = $dinas;
        } elseif ($next_level == 15 || $next_level == 13) {
            $unit_kerja = $sekre;
        }
        return $unit_kerja;
    }

    /**
     * DIGUNAKAN UNTUK MENGAMBIL UNIT KERJA BAWAHANNYA
     * @param  [number] $next_level [MERUPAKAN ID LEVEL BAWAHAN YANG AKAN DICARI / YANG DIKETAHUI]
     * @param  [number] $unit_kerja [MERUPAKAN UNIT KERJA YANG DIGUNAKAN]
     * @param  [number] $dari_level [MERUPAKAN ID LEVEL DARI PENCARI]
     * @return [number]             [description]
     */
    function next_disposisi($next_level, $unit_kerja, $dari_level=null){
        $dinas = substr($unit_kerja, 0, 3);
        $dinas1 = substr($unit_kerja, 3, 3);
        $dinas2 = substr($unit_kerja, 6, 3);
        $dinas3 = substr($unit_kerja, 0, 5);

        if ($next_level == 1 || $next_level == 7 || $next_level == 23) {
            $unit_kerja = $dinas;
        } elseif ($next_level == 2 || $next_level == 17 || $next_level == 25) {
            $unit_kerja = $dinas;
        } elseif ($next_level == 3 || $next_level == 19 || $next_level == 9 || $next_level == 10) {
            if ($dari_level == 1 || $dari_level == 7) {
              $unit_kerja = $dinas;
            } elseif ($dari_level == 8) {
              $unit_kerja = $dinas3;
            } else{
                $unit_kerja = $dinas.$dinas1;
            }
        } elseif ($next_level == 5 || $next_level == 8 || $next_level == 24 || $next_level == 27) {
            $unit_kerja = $dinas;
        } elseif ($next_level == 13) {
            $unit_kerja = 101000;
        } elseif ($next_level == 15) {
            $unit_kerja = 100000;
        } elseif ($next_level == 16) {
            $dinas = substr($unit_kerja, 0, 2);
            $unit_kerja = $dinas;
        } elseif ($next_level == 4 || $next_level == 6) {
            $unit_kerja = $dinas.$dinas1;
        }

        return $unit_kerja;
    }

    function kode_otorisasi(){
        $arr = array("A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z");
        $kode = $arr[mt_rand(0,23)].mt_rand(0,9).$arr[mt_rand(0,23)].mt_rand(0,100).$arr[mt_rand(0,23)].mt_rand(0,9);
        return $kode;
    }

    public function parse_tgl($value='')
    {
        if (empty($value)) {
            return "";
        }
        $nama_bulan = array(
            '01' => 'Januari',
            '02' => 'Febuari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
            );
        $v         = date('d-m-Y',strtotime($value));
        $part_date = explode("-",$v);
        $result    = $part_date[0].' '.$nama_bulan[$part_date[1]].' '.$part_date[2];
        return $result;
    }

    public function isNull($data, $find, $function=null){
        $hasil = array();
        if (empty($data)) {
            $hasil['BOOLEAN']       = true;
            $hasil['STATUS']        = "gagal";
            $hasil['MESSAGE']       = "Data User Yang Di Tuju Tidak Dapat Ditemukan !";
            $hasil['ERROR_MESSAGE'] = "$find Tidak Dapat Ditemukan pada function $function";
            $hasil['HASIL']         = $data;
        } else{
            $hasil['BOOLEAN']       = false;
            $hasil['STATUS']        = "berhasil";
            $hasil['MESSAGE']       = "Data yang Dicari Dapat Ditemukan !";
            $hasil['ERROR_MESSAGE'] = "$find Ada Datanya pada function $function !";
            $hasil['HASIL']         = $data;
        }
        return $hasil;
    }

    function count_surat_masuk($nip,$status,$flag){
        $tahun         = date('Y');
        if($flag==1){
            $url = 'https://dinsos.surabaya.go.id/api_esurat/api_count_sm_skpd.php';
        }else if($flag==2){
            $url = 'https://dinsos.surabaya.go.id/api_esurat/api_count_sm_umum.php';
        }
        $fields = array(
                   'nip'    => $nip,
                   'status' => $status,
                   'tahun'  => $tahun
               );

           $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,$url );

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // we are doing a POST request
            curl_setopt($ch, CURLOPT_POST, 1);
            // adding the post variables to the request
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $output = curl_exec($ch);

            if($output==false){
                 echo "cURL Error: " . curl_error($ch)."api tidak konek";
             }else{
                $datanya =  json_decode($output);
                $json          = array();
                 foreach ($datanya->data as $row) {
                     $data = array();
                     $data['jumlah']  = $row->jml;
                 }
             }
             curl_close($ch);
             return $data;
    }
    function count_surat_masuk_arsip($nip,$status,$flag){
        $tahun         = 2017;
        if($flag==1){
            $url = 'https://dinsos.surabaya.go.id/api_esurat/api_count_sm_skpd.php';
        }else if($flag==2){
            $url = 'https://dinsos.surabaya.go.id/api_esurat/api_count_sm_umum.php';
        }
        $fields = array(
                   'nip'    => $nip,
                   'status' => $status,
                   'tahun'  => $tahun
               );

           $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,$url );

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // we are doing a POST request
            curl_setopt($ch, CURLOPT_POST, 1);
            // adding the post variables to the request
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $output = curl_exec($ch);

            if($output==false){
                 echo "cURL Error: " . curl_error($ch)."api tidak konek";
             }else{
                $datanya =  json_decode($output);
                $json          = array();
                 foreach ($datanya->data as $row) {
                     $data = array();
                     $data['jumlah']  = $row->jml;
                 }
             }
             curl_close($ch);
             return $data;
    }
}
