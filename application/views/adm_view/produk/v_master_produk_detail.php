    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail 
        <?= $this->template_view->nama_menu('judul_menu'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Produk</li>
        <li class="active">Detail <?= $this->template_view->nama_menu('judul_menu'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</button> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive"> 
             
                <div class="col-xs-10">
                  <h2 style="text-align: center;"><?php echo $data_produk->nama; ?></h2>
                  <h4 style="text-align: center;">Kode Produk : <?php echo $data_produk->kode; ?></h4>
                </div>
                <div class="col-xs-2">
                  <img src="<?php echo base_url('assets/img/produk/').$data_produk->gambar_1; ?>" style="height: 75%; width: 75%; border: 2px solid;">
                </div>
               
                <table id="tabelProdukDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th colspan="2">Detail Produk</th>
                    </tr>
                    <tr>
                      <td>Nama</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Satuan</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Harga Satuan</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Kategori</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Dimensi Panjang x Lebar</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Jumlah Halaman</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Penerbit</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Gambar Detail 1</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Gambar Detail 2</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
               </div>
               <!-- responsive --> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->
