   <style>
     .table td{
          border: black solid 1px !important;
      }

      .table th{
          border: black solid 1px !important;
      }
   </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Penjualan Agen
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Laporan Penjualan Agen</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="col-xs-12">
                  <h4 style="text-align: center;"><strong>Laporan Penjualan Agen</strong></h4>
                </div>
                <div class="col-xs-12">
                  <h4 style="text-align: center;">Periode : <?php echo $periode ?></h4>
                </div>
                <table id="tblAgenBatineDetail" class="table table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 10%; text-align: center;">Tgl Checkout</th>
                      <th style="width: 15%; text-align: center;">Nama Agen</th>
                      <th style="width: 15%; text-align: center;">Nilai</th>
                      <th style="width: 5%; text-align: center;">Kode Ref</th>
                      <th style="width: 7%; text-align: center;">Kode Ref Klaim</th>
                      <th style="width: 10%; text-align: center;">Tgl Klaim</th>
                      <th style="width: 15%; text-align: center;">Nilai Klaim</th>
                      <th style="width: 10%; text-align: center;">Tgl Dibayar</th>
                      <th style="width: 15%; text-align: center;">Nilai Transfer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($hasil_data) != 0) : ?>
                      <?php $no = 1; ?>
                      <?php foreach ($hasil_data as $val) : ?>
                        <tr>
                          <td><?php echo date('d-m-Y', strtotime($val->created_at)); ?></td>
                          <td><?php echo $val->nama_lengkap_user; ?></td>
                          <td>
                            <div>
                              <span class="pull-left">Rp. </span>
                              <span class="pull-right"><?= number_format($val->laba_agen_total, 2, ",", "."); ?></span>
                            </div>
                          </td>
                          <td><?php echo $val->kode_ref; ?></td>
                          <td><?php echo $val->kode_klaim; ?></td>
                          <td align="center">
                            <?php 
                              if ($val->tgl_klaim) {
                                echo date('d-m-Y', strtotime($val->tgl_klaim));
                              }else{
                                echo " - ";
                              }
                            ?>  
                          </td>
                          <td>
                            <div>
                              <span class="pull-left">Rp. </span>
                              <span class="pull-right"><?= number_format($val->jumlah_klaim, 2, ",", "."); ?></span>
                            </div>
                          </td>
                          <td align="center">
                            <?php
                              if ($val->tanggal_verify) {
                                echo date('d-m-Y', strtotime($val->tanggal_verify));
                              }else{
                                echo " - ";
                              }
                            ?>
                          </td>
                          <td>
                            <div>
                              <?php if ($val->tanggal_verify) { ?>
                                <span class="pull-left">Rp. </span>
                                <span class="pull-right"><?= number_format($val->nilai_transfer, 2, ",", "."); ?></span>
                              <?php }else{ ?>
                                <span> - </span>
                              <?php } ?>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
                <div style="padding-top: 30px; padding-bottom: 10px;">
                  <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                  <?php $link_print = site_url("admin/lap_penjualan_agen/cetak_report/" . $bulan . "/" . $tahun . ""); ?>
                  <?php echo '<a class="btn btn-sm btn-success" href="' . $link_print . '" target="_blank" title="Print Laporan BKU" id="btn_print_laporan_bku"><i class="glyphicon glyphicon-print"></i> Cetak</a>'; ?>
                  <?php $link_submit = site_url("lap_penjualan_agen/konfirmasi_lap/" . $bulan . "/" . $tahun . ""); ?>
                  <?php if ($this->session->userdata('id_level_user') !=  '4') { ?>
            <?php if ($cek_status_kunci == FALSE) { ?>
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Konfirmasi" onclick="konfirmBku(<?= $bulan.','.$tahun.','. $saldo_awal.','.$saldo_akhir; ?>)"><i class="glyphicon glyphicon-pencil"></i> Submit Data</a>
            <?php } ?>
          <?php } ?>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->