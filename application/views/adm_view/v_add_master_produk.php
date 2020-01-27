    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>Tambah
    		<?= $this->template_view->nama_menu('judul_menu'); ?>
    	</h1>

    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-dashboard"></i>Data Master</a></li>
    		<li class="active"><?= $this->template_view->nama_menu('judul_menu'); ?></li>
    	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-s12">
    			<div class="box">
    				<!-- /.box-header -->
    				<div class="box-body">
    					<form id="form">
    						<div class="form-group col-md-12">
    							<label>Nama : </label>
    							<input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($hasil_data)) {
																																													echo $hasil_data->nama;
																																												} ?>">
    							<input type="hidden" class="form-control" id="id" name="id" value="<?php if (isset($hasil_data)) {
																																												echo $hasil_data->id;
																																											} ?>">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-6">
    							<label>Kategori : </label>
    							<select class="form-control select2" id="kategori" name="kategori">
    								<?php foreach ($data_kategori as $key => $value) : ?>
    									<option value="<?= $value->id; ?>" <?php if (isset($hasil_data)) {
																														if ($hasil_data->id_kategori == $value->id) {
																															echo "selected";
																														}
																													} ?>><?= $value->nama ?>
    									</option>
    								<?php endforeach ?>
    							</select>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-6">
    							<label>Satuan : </label>
    							<select class="form-control select2" id="satuan" name="satuan">
    								<?php foreach ($data_satuan as $key => $value) : ?>
    									<option value="<?= $value->id; ?>" <?php if (isset($hasil_data)) {
																														if ($hasil_data->id_satuan == $value->id) {
																															echo "selected";
																														}
																													} ?>><?= $value->nama ?>
    									</option>
    								<?php endforeach ?>
    							</select>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-12">
    							<label>Keterangan : </label>
    							<textarea class="form-control" rows="3" placeholder="Keterangan ..." id="keterangan" name="keterangan"><?php if (isset($hasil_data)) {
																																																														echo $hasil_data->keterangan;
																																																													} ?></textarea>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Dimensi Panjang : </label>
    							<input type="text" class="form-control numberinput" id="panjang" name="panjang" value="<?php if (isset($hasil_data)) {
																																																						echo $hasil_data->panjang;
																																																					} ?>">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Dimensi Lebar : </label>
    							<input type="text" class="form-control numberinput" id="lebar" name="lebar" value="<?php if (isset($hasil_data)) {
																																																				echo $hasil_data->lebar;
																																																			} ?>">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Jumlah Halaman : </label>
    							<input type="text" class="form-control numberinput" id="jumlah_halaman" name="jumlah_halaman" value="<?php if (isset($hasil_data)) {
																																																													echo $hasil_data->jumlah_halaman;
																																																												} ?>">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-8">
    							<label>Penerbit : </label>
    							<input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php if (isset($hasil_data)) {
																																																	echo $hasil_data->penerbit;
																																																} ?>">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Tahun : </label>
    							<select class="form-control select2" id="tahun" name="tahun">
    								<option value="">Pilih Tahun</option>
    								<?php for ($i = 2019; $i <= date('Y') + 20; $i++) { ?>
    									<option value="<?= $i; ?>" <?php if (isset($hasil_data)) {
																										if ($i == $hasil_data->tahun) {
																											echo "selected";
																										}
																									} ?>><?= $i; ?>
    									</option>
    								<?php } ?>
    							</select>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-6">
    							<label>Aktif : </label>
    							<select class="form-control select2" id="aktif" name="aktif">
    								<option value="1">aktif</option>
    								<option value="0">Non aktif</option>
    							</select>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-6">
    							<label>Posting : </label>
    							<select class="form-control select2" id="posting" name="posting">
    								<option value="1">Ya</option>
    								<option value="0">Tidak</option>
    							</select>
    							<span class="help-block"></span>
    						</div>

    						<?php for ($i = 0; $i <= 2; $i++) { ?>
    							<div class="form-group col-md-9">

    								<?php if ($i == 0) : ?>
    									<label>Foto Utama : </label>
    								<?php else : ?>
    									<label>Foto : </label>
    								<?php endif ?>

    								<input type="file" id="gambar<?= $i; ?>" class="gambar" name="gambar<?=$i;?>" accept=".png, .jpg, .jpeg" />
    							</div>

    							<div class="form-group col-md-3">
    								<?php if (isset($hasil_data)) { ?>
    									<img id="gambar<?= $i; ?>-img" src="<?= base_url() . '/assets/img/produk/' . $hasil_data->foto; ?>" alt="Preview Gambar" height="75" width="75" class="pull-right" />
    								<?php } else { ?>
    									<img id="gambar<?= $i; ?>-img" src="#" alt="Preview Gambar" height="75" width="75" class="pull-right" />
    								<?php } ?>
    							</div>
    						<?php } ?>

    						<div class="form-group col-md-12">
    							<div class="pull-right">
    								<?php if (isset($hasil_data)) { ?>
    									<button type="button" id="btnSave" class="btn btn-primary" onclick="save('update')"><i class="fa fa-save"></i> Simpan</button>
    								<?php } else { ?>
    									<button type="button" id="btnSave" class="btn btn-primary" onclick="save('add')"><i class="fa fa-save"></i> Simpan</button>
    								<?php } ?>
    							</div>
    							<div class="pull-left">
    								<a class="btn btn-md btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
    							</div>
    						</div>
    					</form>
    				</div>
    				<!-- /.box-body -->
    			</div>
    			<!-- /.box -->
    		</div>
    	</div>
    </section>
    <!-- /.content -->
