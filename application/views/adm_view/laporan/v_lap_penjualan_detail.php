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
                      <?php 
                        $no = 1; 
                        $total_penerimaan = 0;
                        $total_laba_agen = 0;
                        $saldo_akhir = 0;
                      ?>
                      <?php foreach ($hasil_data as $val) : ?>
                        <?php 
                          $total_penerimaan += $val['penerimaan_raw'];
                          $total_laba_agen += $val['laba_agen_raw']; 
                          $saldo_akhir = $val['saldo_akhir'];
                        ?>
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
                        <tr>
                          <td colspan="4" align="left" style="font-size: 18px;"><strong>Total Penerimaan : </strong></td>
                          <td colspan="2" align="center" style="font-size: 18px;">
                            <strong>
                              <div>
                                <span class="pull-left">Rp. </span>
                                <span class="pull-right"><?= number_format($total_penerimaan, 2, ",", "."); ?></span>
                              </div>
                            </strong>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" align="left" style="font-size: 18px;"><strong>Total Laba Agen : </strong></td>
                          <td colspan="2" align="center" style="font-size: 18px;"><strong>
                              <div>
                                <span class="pull-left">Rp. </span>
                                <span class="pull-right"><?= number_format($total_laba_agen, 2, ",", "."); ?></span>
                              </div>
                            </strong>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" align="left" style="font-size: 18px;"><strong>Saldo Akhir Hingga <?php echo $periode ?> : </strong></td>
                          <td colspan="2" align="center" style="font-size: 18px;"><strong>
                              <div>
                                <span class="pull-left">Rp. </span>
                                <span class="pull-right"><?= number_format($saldo_akhir, 2, ",", "."); ?></span>
                              </div>
                            </strong>
                          </td>
                        </tr>
                    <?php endif ?>
                  </tbody>
                </table>
                <div style="padding-top: 30px; padding-bottom: 10px;">
                  <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                  <?php $link_print = site_url("admin/lap_penjualan/cetak_report/" . $bulan . "/" . $tahun . ""); ?>
                  <?php echo '<a class="btn btn-sm btn-success" href="' . $link_print . '" target="_blank" title="Print Laporan" id="btn_print_laporan_bku"><i class="glyphicon glyphicon-print"></i> Cetak</a>'; ?>
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