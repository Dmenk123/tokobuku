    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Master User - Hanya Level User Admin
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="row">
                <form id="form_input">
                  <div class="form-group col-md-12">
                    <label>Nama Lengkap User : </label>
                    <input type="text" class="form-control" style="background-color: #e8f0fe;" id="namalengkap" name="namalengkap" value="">
                    <input type="hidden" class="form-control" id="id" name="id" value="">
                    <span class="help-block"></span>
                  </div>

                  <div class="form-group col-md-12">
                    <label>Username : </label>
                    <input type="text" class="form-control" style="background-color: #e8f0fe;" id="username" name="username" value="">
                    <input type="hidden" class="form-control" id="id" name="id" value="">
                    <span class="help-block"></span>
                  </div>

                  <div class="form-group col-md-12">
                    <label>Password: </label>
                    <input type="password" class="form-control" style="background-color: #e8f0fe;" id="password" name="password" value="">
                    <span class="help-block"></span>
                  </div>

                  <div class="form-group col-md-12">
                    <label>Ulangi Password : </label>
                    <input type="password" class="form-control" style="background-color: #e8f0fe;" id="repassword" name="repassword" value="">
                    <span class="help-block"></span>
                  </div>

                  <div class="form-group col-md-12">
                    <label>Status Aktif : </label>
                    <select class="form-control" id="status" name="status">
                        <option value="1"> Aktif </option>
                        <option value="0"> Nonaktif </option>
                    </select>
                    <span class="help-block"></span>
                  </div>

                  <div class="form-group col-md-9">
                    <label>Foto (Abaikan Jika Tidak Merubah Foto) : </label>
                    <input type="file" id="gambar" class="gambar" name="gambar" ; />
                  </div>
        
                  <div class="form-group col-md-3">
                    <label>Foto Profil User </label>
                    <br>
                    <img id="gambar-img" src="<?= base_url() . '/assets/img/foto_profil/user_default.png'; ?>" alt="Preview Gambar" height="100" width="100" class="pull-left" />
                  </div>

                  <div class="form-group col-md-12">
                    <div class="pull-right">
                      <button type="button" id="btnSave" class="btn btn-primary" onclick="add_user()"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                    <div class="pull-left">
                      <a class="btn btn-md btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                    </div>
                  </div>
                </form>
              </div><!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->
