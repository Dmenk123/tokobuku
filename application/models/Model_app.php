<?php
class Model_app extends CI_model {

	public function getSelectedData($table,$datawhere,$data_like=null, $datawhere_or = null, $datawhere1=null,$wherein=null,$where_in=null,$in=null,$where_sekda=null,$datalike_or=null,$not_in=null,$not_like=null)
    {
        $this->db->select('*');
        if ($datawhere != null) {
            $this->db->where($datawhere);
        }
        if ($data_like != null) {
           $this->db->like($data_like,false,'after');
        }
        if ($datawhere_or != null) {
            $this->db->or_where($datawhere_or);
        }
        if ($datawhere1 != null) {
            $this->db->where($datawhere1);
        }
     //SEMENTARA UNTUK MENAMPILKAN KATEGORI SURAT YANG HANYA SUDAH ADA FORMNYA
        if ($wherein != null) {
            $this->db->where_in('id_kategori',$wherein);
        }

        if ($where_in != null) {
            $this->db->where_in('id_laporan',$where_in);
        }

        if ($in != null) {
            $this->db->where_in('id_detail',$in);
        }

        if ($where_sekda != null) {
            $this->db->where_in('id_jabatan',$where_sekda);
        }

        if ($datalike_or != null) {
            $this->db->or_like($datalike_or);
        }

        if($not_in != null){
            $this->db->where_not_in($not_in);
        }

        if($not_like != null){
            $this->db->not_like($not_like);
        }

        return $this->db->get($table);
    }

    function updateDataIn($table, $column_in, $where_in, $data)
    {
        $this->db->where_in($column_in, $where_in);

        $this->db->update($table, $data);
    }

    function deleteData($table,$datawhere, $data_like = null)
    {
        if ($datawhere != null) {
            $this->db->where($datawhere);
        }
        if ($data_like != null) {
            $this->db->like($data_like);
        }
        $this->db->delete($table);
    }
    function insertData($table, $data, $data2=null)
    {
        //$this->db->trans_start();
        if ($data2!=null){
            foreach ($data2 as $key => $value) {
                $this->db->set($key, $value, FALSE);
            }
        }
        $this->db->insert($table,$data);
        // echo $this->db->last_query()." <br>";
        // $this->db->trans_complete();
        // if($this->db->trans_status() === false){
        //     return false;
        // }
    }

    function updateData($table,$data_where,$data, $data2=null)
    {
        if ($data2!=null){
            foreach ($data2 as $key => $value) {
                $this->db->set($key, $value, FALSE);
            }
        }
        $this->db->update($table,$data,$data_where);
        //return $this->db->affected_rows() > 0;

        // return $this->db->last_query();
    }

    function getMax(){
        $query = $this->db->query("
                    SELECT MAX(id_properti) as id, kode_listing FROM t_properti
            ");

        return $query;

    }

    function v_properti(){
        $query = $this->db->query("
                    SELECT * 
                    FROM t_properti p
                    LEFT JOIN m_user m ON m.level=p.id_agen
            ");

        return $query;
    }

    function v_properti_dan_user(){
        $query = $this->db->query("
                    SELECT 
                        t.id_properti,
                        t.kode_listing,
                        t.jenis_properti,
                        t.deskripsi,
                        t.alamat,
                        t.foto,
                        t.harga,
                        t.nama_properti as nama_listing,
                        k.nama_kecamatan,
                        k.kategori,
                        j.nama_properti,
                        m.nama as nama_agen,
                        m.photo,
                        m.telp
                    FROM t_properti t
                    LEFT JOIN m_user m ON m.id_user=t.id_agen
                    LEFT JOIN m_jenis_properti j ON j.id_jenis=t.jenis_properti
                    LEFT JOIN m_kecamatan k ON k.id_unit=t.id_unit
                    ORDER BY t.id_properti DESC
            ");

        return $query;
    }

     function v_properti_location($where){
        $query = $this->db->query("
                    SELECT 
                        t.id_properti,
                        t.kode_listing,
                        t.jenis_properti,
                        t.deskripsi,
                        t.alamat,
                        t.foto,
                        t.harga,
                        t.nama_properti as nama_listing,
                        k.nama_kecamatan,
                        k.kategori,
                        j.nama_properti,
                        m.nama as nama_agen
                    FROM t_properti t
                    LEFT JOIN m_user m ON m.id_user=t.id_agen
                    LEFT JOIN m_jenis_properti j ON j.id_jenis=t.jenis_properti
                    LEFT JOIN m_kecamatan k ON k.id_unit=t.id_unit
                    WHERE $where
                    ORDER BY t.id_properti DESC
            ");

        return $query;
    }
 
 
    public function v_penjualan_dan_properti(){
        $query = $this->db->query("
                    SELECT 
                        pj.id_penjualan,
                        pj.dari_user,
                        pj.tujuan_user,
                        pj.harga,
                        pj.qty,
                        p.kode_listing,
                        p.alamat,
                        mu.nama as nama_dari_user
                    FROM t_penjualan pj
                    LEFT JOIN t_properti p ON p.id_properti=pj.id_properti
                    LEFT JOIN m_user mu ON mu.id_user = pj.dari_user
                    WHERE pj.status = 0
            ");
        return $query;
    }

    public function v_history_penjualan_dan_properti($where){
        $query = $this->db->query("
                    SELECT 
                        pj.id_penjualan,
                        pj.dari_user,
                        pj.tujuan_user,
                        pj.harga,
                        pj.qty,
                        p.kode_listing,
                        p.alamat,
                        mu.nama as nama_dari_user,
                        pj.pendapatan_agen,
                        pj.pendapatan_properti,
                        pj.status,
                        pj.tanggal,
                        p.nama_properti,
                        k.nama_kecamatan,
                        k.kategori,
                        j.nama_properti as jenis_properti
                    FROM t_penjualan pj
                    LEFT JOIN t_properti p ON p.id_properti=pj.id_properti
                    LEFT JOIN m_kecamatan k ON k.id_unit=p.id_unit
                    LEFT JOIN m_user mu ON mu.id_user = pj.dari_user
                    LEFT JOIN m_jenis_properti j ON j.id_jenis=p.jenis_properti 
                    WHERE $where
                    ORDER BY pj.id_penjualan DESC
            ");
        return $query;
    }


     public function getLaporan($tahun=null, $bulan=null){
        if ($tahun != null) {
            $where = "pj.status = 1 AND DATE_FORMAT(pj.tanggal, '%Y-%m') = '$tahun-$bulan'";
        }else{
            $where = "pj.status = 1";
        }
        $query = $this->db->query("
                    SELECT 
                        pj.id_penjualan,
                        pj.dari_user,
                        pj.tujuan_user,
                        pj.harga,
                        pj.qty,
                        p.kode_listing,
                        p.alamat,
                        mu.nama as nama_dari_user,
                        pj.pendapatan_agen,
                        pj.pendapatan_properti,
                        pj.status,
                        pj.tanggal
                    FROM t_penjualan pj
                    LEFT JOIN t_properti p ON p.id_properti=pj.id_properti
                    LEFT JOIN m_user mu ON mu.id_user = pj.dari_user
                    WHERE $where
                    ORDER BY pj.id_penjualan DESC
            ");
        return $query;
    }

    public function monitoringAgen(){
        $query = $this->db->query("
                    SELECT 
                        mu.id_user,
                        mu.nama,
                        ifnull(tp.jumlah, 0) as jumlah
                    FROM m_user mu 
                    LEFT JOIN (SELECT COUNT(qty) AS jumlah, dari_user FROM t_penjualan WHERE status = 1 GROUP BY dari_user ) tp ON mu.id_user=tp.dari_user
                    WHERE mu.level = 3
                ");

        return $query->result_array();
    }

    public function monitoringProperti(){
        $query = $this->db->query("
                    SELECT 
                    j.nama_properti,
                     ifnull(p.jumlah, 0) as jumlah
                    FROM m_jenis_properti j 
                    LEFT JOIN (SELECT COUNT(*) as jumlah, jenis_properti FROM t_properti GROUP BY jenis_properti ) p ON j.id_jenis=p.jenis_properti
                ");

        return $query->result_array();
    }

    public function monitoringWilayah(){
        $query = $this->db->query("
                    SELECT 
                       DISTINCT(k.kategori) as nama_wilayah,
                       ifnull(pp.jumlah, 0) as jumlah
                    FROM m_kecamatan k
                    LEFT JOIN (SELECT COUNT(*) as jumlah, kc.kategori 
                                FROM t_properti p 
                                JOIN m_kecamatan kc ON kc.id_unit=p.id_unit
                                GROUP BY kc.kategori ) pp ON k.kategori=pp.kategori
                ");

        return $query->result_array();
    }

    public function kambing(){
        $query = $this->db->query("
                    SELECT * FROM t_properti
                    ORDER BY RAND()
                    LIMIT 3;
                ");
        return $query->result_array();
    }


}

