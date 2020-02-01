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
    							<input type="text" class="form-control" id="nama" name="nama">
    							<input type="hidden" class="form-control" id="id" name="id" value="">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-6">
    							<label>Kategori : </label>
    							<select class="form-control select2" id="kategori" name="kategori">
    								<?php foreach ($data_kategori as $key => $value) : ?>
    									<option value="<?= $value->id; ?>"> <?= $value->nama; ?> </option>
    								<?php endforeach ?>
    							</select>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-6">
    							<label>Satuan : </label>
    							<select class="form-control select2" id="satuan" name="satuan">
    								<?php foreach ($data_satuan as $key => $value) : ?>
    									<option value="<?= $value->id; ?>"><?= $value->nama; ?></option>
    								<?php endforeach ?>
    							</select>
    							<span class="help-block"></span>
    						</div>
                
                <div class="form-group col-md-8">
                  <label>harga Satuan : </label>
                  <input type="text" class="form-control mask-currency" id="harga" name="harga" value="" data-thousands="." data-decimal="," data-prefix="Rp. " onKeyUp="hargaRaw();" />
                  <input type="hidden" class="form-control" id="harga_raw" name="harga_raw" value="" />
                </div>

                <div class="form-group col-md-4">
                  <label>Potongan Agen : </label>
                  <input type="text" class="form-control numberinput" id="potongan" name="potongan" value="">
                  <span class="help-block"></span>
                </div>

    						<div class="form-group col-md-12">
    							<label>Keterangan : </label>
    							<textarea class="form-control" rows="3" placeholder="Keterangan ..." id="keterangan" name="keterangan"></textarea>
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Dimensi Panjang : </label>
    							<input type="text" class="form-control numberinput" id="panjang" name="panjang" value="">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Dimensi Lebar : </label>
    							<input type="text" class="form-control numberinput" id="lebar" name="lebar" value="">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Jumlah Halaman : </label>
    							<input type="text" class="form-control numberinput" id="jumlah_halaman" name="jumlah_halaman" value="">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-8">
    							<label>Penerbit : </label>
    							<input type="text" class="form-control" id="penerbit" name="penerbit" value="">
    							<span class="help-block"></span>
    						</div>

    						<div class="form-group col-md-4">
    							<label>Tahun : </label>
    							<select class="form-control select2" id="tahun" name="tahun">
    								<option value="">Pilih Tahun</option>
    								<?php for ($i = 2019; $i <= date('Y') + 20; $i++) { ?>
    									<option value="<?= $i; ?>"> <?= $i; ?></option>
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
    								<img id="gambar<?= $i; ?>-img" src="#" alt="Preview Gambar" height="75" width="75" class="pull-right" />
    							</div>
    						<?php } ?>

    						<div class="form-group col-md-12">
    							<div class="pull-right">
    									<button type="button" id="btnSave" class="btn btn-primary" onclick="save('add')"><i class="fa fa-save"></i> Simpan</button>
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
