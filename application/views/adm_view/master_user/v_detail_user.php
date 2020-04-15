    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Master User
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
              <div class="table-responsive"> 
                <table id="" class="table table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="20%">Kode User</th>
                      <td width="55%"><?= $hasil_data->id_user; ?></td>
                      <th align="center">Foto Profil</th>
                    </tr>
                    <tr>
                      <th width="20%">Username</th>
                      <td><?= $hasil_data->username; ?></td>
                      <td rowspan="8"><img id="gambar-img" src="<?= base_url() . '/assets/img/foto_profil/' . $hasil_data->gambar_user; ?>" alt="Preview Gambar" height="300" width="300"/></td>
                    </tr>
                    <tr>
                      <th width="20%">Nama Lengkap User</th>
                      <td><?= $hasil_data->nama_lengkap_user; ?></td>
                    </tr>
                    <tr>
                      <th width="20%">Email</th>
                      <td><?= $hasil_data->email; ?></td>
                    </tr>
                    <tr>
                      <th width="20%">Telp / WA</th>
                      <td><?= $hasil_data->no_telp_user; ?></td>
                    </tr>
                    <tr>
                      <th width="20%">Level user</th>
                      <td><?= $hasil_data->nama_level_user; ?></td>
                    </tr>
                    <tr>
                      <th width="20%">Bank | No. Rekening</th>
                      <td><?= $hasil_data->bank.' | '.$hasil_data->rekening; ?></td>
                    </tr>
                    <tr>
                      <th width="20%">Status User</th>
                      <td><?= ($hasil_data->status == '1') ? 'Aktif' : 'Nonaktif'; ?></td>
                    </tr>
                     <tr>
                      <th width="20%">Terakhir Login Pada </th>
                      <td><?= $hasil_data->last_login; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <div class="form-group col-md-12">
                    <div class="pull-right">
                      <a class="btn btn-md btn-danger" title="Kembali" href="<?= base_url('admin/master_user'); ?>"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
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
