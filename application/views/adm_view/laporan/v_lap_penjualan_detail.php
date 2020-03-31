    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Penjualan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Laporan Penjualan</li>
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
                  <h4 style="text-align: center;"><strong>Laporan Penjualan</strong></h4>
                </div>
                <div class="col-xs-12">
                  <h4 style="text-align: center;">Periode : <?php echo $periode ?></h4>
                </div>
                <table id="tblLaporanMutasiDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 10%; text-align: center;">Tanggal</th>
                      <th style="width: 10%; text-align: center;">Kode Ref</th>
                      <th style="width: 20%; text-align: center;">Uraian</th>
                      <th style="width: 15%; text-align: center;">Penerimaan</th>
                      <th style="width: 15%; text-align: center;">Laba Agen</th>
                      <th style="width: 15%; text-align: center;">Saldo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($hasil_data) != 0) : ?>
                      <?php $no = 1; ?>
                      <?php foreach ($hasil_data as $val) : ?>
                        <tr>
                          <td><?php echo $val['tanggal']; ?></td>
                          <td><?php echo $val['kode_ref'] ?></td>
                          <td><?php echo $val['keterangan']; ?></td>
                          <td>
                            <div>
                              <span class="pull-left">Rp. </span>
                              <span class="pull-right"><?= $val['penerimaan']; ?></span>
                            </div>
                          </td>
                          <td>
                            <div>
                              <span class="pull-left">Rp. </span>
                              <span class="pull-right"><?= $val['laba_agen']; ?></span>
                            </div>
                          </td>
                          <td>
                            <div>
                              <span class="pull-left">Rp. </span>
                              <span class="pull-right"><?= number_format($val['saldo_akhir'], 2, ",", "."); ?></span>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
                <div style="padding-top: 30px; padding-bottom: 10px;">
                  <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                  <?php $link_print = site_url("lap_bku/cetak_report_bku/" . $bulan . "/" . $tahun . ""); ?>
                  <?php echo '<a class="btn btn-sm btn-success" href="' . $link_print . '" target="_blank" title="Print Laporan BKU" id="btn_print_laporan_bku"><i class="glyphicon glyphicon-print"></i> Cetak</a>'; ?>
                  <?php $link_submit = site_url("lap_bku/konfirmasi_lap_bku/" . $bulan . "/" . $tahun . ""); ?>
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