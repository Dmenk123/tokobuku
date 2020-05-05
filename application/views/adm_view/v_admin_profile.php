    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    		<li>Profile</li>
    		<li class="active">Edit Profile</li>
    	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-12">
				<form id="form_input">
					<?php foreach ($hasil_data as $value) { ?>
						<?php
						$arr_nama = explode(',', $value->nama_lengkap_user);
						if (count($arr_nama) > 1) {
							$nama_lengkap = $arr_nama[0] . ' ' . $arr_nama[1];
						} else {
							$nama_lengkap = $arr_nama[0];
						}
						?>
						<div class="form-group col-md-12">
							<label>Nama Lengkap User : </label>
							<input type="text" class="form-control" style="background-color: #e8f0fe;" id="namalengkap" name="namalengkap" value="<?php echo $nama_lengkap; ?>">
							<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $value->id_user; ?>">
							<span class="help-block"></span>
						</div>

						<div class="form-group col-md-12">
							<label>Password Lama: </label>
							<input type="password" class="form-control" style="background-color: #e8f0fe;" id="password" name="password" value="">
							<span class="help-block"></span>
						</div>

						<div class="form-group col-md-12">
							<label>Password Baru : </label>
							<input type="password" class="form-control" style="background-color: #e8f0fe;" id="passwordnew" name="passwordnew" value="">
							<span class="help-block"></span>
						</div>

						<div class="form-group col-md-12">
							<label>Ulangi Password Baru : </label>
							<input type="password" class="form-control" style="background-color: #e8f0fe;" id="repassword" name="repassword" value="">
							<span class="help-block"></span>
						</div>

						<div class="form-group col-md-12 checkbox">
							<label>
								<input type="checkbox" value="Y" name="ceklistpwd" id="ceklistpwd"> Centang Pilihan ini jika tidak mengganti password
							</label>
						</div>

						<div class="form-group col-md-9">
							<label>Foto (Abaikan Jika Tidak Merubah Foto) : </label>
							<input type="file" id="gambar" class="gambar" name="gambar" ; />
						</div>

						<div class="form-group col-md-3">
							<img id="gambar-img" src="<?= base_url() . '/assets/img/foto_profil/' . $value->gambar_user; ?>" alt="Preview Gambar" height="75" width="75" class="pull-right" />
						</div>

						<div class="form-group col-md-12">
							<div class="pull-right">
								<button type="button" id="btnSave" class="btn btn-primary" onclick="update_profil()"><i class="fa fa-save"></i> Simpan</button>
							</div>
							<div class="pull-left">
								<a class="btn btn-md btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
							</div>
						</div>
					<?php } ?>
				</form>
    		</div>
    	</div>
    </section>
    <!-- /.content -->
