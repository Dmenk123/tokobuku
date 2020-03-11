    <style>
        .pdfobject-container {
            max-width: 100%;
            height: 850px;
            border: 2px solid rgba(0,0,0,.2);
            margin: 0;
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Konten 
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           
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
              <div class="row">
                            <div class="col-lg-7">
                    <section class="panel panel-with-borders" >
                    <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <br />
                       
                        <!-- Horizontal Form -->
                        <form id="form">
                           
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-left">Isi Konten</label>
                                <div class="col-lg-9">
                                    <?php $value = (isset($konten->isi))?$konten->isi:""; ?>
                                    <textarea type="text" class="form-control datepicker input tanggal summernote" name="konten" ><?php echo $value; ?></textarea>
                                </div>
                            </div>
                           
                            <div class="row">
                                <label class="col-lg-3"></label>
                                <div class="col-lg-9">
                                    <div class="form-group form-button">
                                        <button type="button" id="btnSave" class="save_surat btn btn-fill btn-success" onClick="save()">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        <div id="kepada"></div>
                        </form>
                    </div>
                </div>
                </div>
                </section>
                </div>
                <div class="col-lg-5">
                <section class="panel panel-with-borders" >
                            <div class="panel-body" id="preview" style="margin-top:35px;">
                            coba
                            </div>
                </section>
                </div>
                </div>
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
  
