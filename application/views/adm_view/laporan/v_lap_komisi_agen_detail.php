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
        Laporan Komisi Agen
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Laporan Komisi Agen</li>
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
                  <h4 style="text-align: center;"><strong>Laporan Komisi Agen</strong></h4>
                  <div class="col-xs-12">
                  <h4 style="text-align: center;">Periode : <?php echo $periode ?></h4>
                </div>
                  <div class="col-md-12">
                    <p>Nama Agen : <?=$data_user_agen[0]->nama_lengkap_user;?> </p>
                    <p>Email Agen : <?=$data_user_agen[0]->email;?> </p>
                    <p>Rekening Agen : <?=$data_user_agen[0]->bank.' - '.$data_user_agen[0]->rekening;?> </p>
                  </div>
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
                    <?= $hasil_data; ?>
                  </tbody>
                </table>
                <div style="padding-top: 30px; padding-bottom: 10px;">
                  <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                  <?php $link_print = site_url("admin/lap_komisi_agen/cetak_report/" . $bulan . "/" . $tahun . "/". $id_user_agen. ""); ?>
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