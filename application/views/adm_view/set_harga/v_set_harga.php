    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting Harga Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Set Harga Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
							<a href="<?= base_url('admin/master_produk_adm/add_data_produk'); ?>"></a>
							<?= $this->template_view->getAddButton(); ?>
              <!-- <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- flashdata -->
              <?php if ($this->session->flashdata('feedback_success')) { ?>
              <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
              <?= $this->session->flashdata('feedback_success') ?>
              </div>

              <?php } elseif ($this->session->flashdata('feedback_failed')) { ?>
              <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-remove"></i> Gagal!</h4>
              <?= $this->session->flashdata('feedback_failed') ?>
              </div>
              <?php } ?>
              
              <div class="table-responsive"> 
                <table id="tabelProduk" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Jenis</th>
                      <th>Harga Bruto</th>
                      <th>Disc Agen</th>
                      <th>Harga Agen</th>
                      <th>Disc Paket</th>
                      <th>Harga Nett</th>
                      <th>Tanggal</th>
                      <th style="text-align: center;">#</th>
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
