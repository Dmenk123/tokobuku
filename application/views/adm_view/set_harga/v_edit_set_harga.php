    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>Edit
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
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $data_harga->id; ?>">
                            
    						<div class="form-group col-md-12">
    							<label>Jenis : </label>
    							<select class="form-control select2" id="kategori" name="kategori">
                                    <option value="paket" <?php if($data_harga->jenis == 'paket') { echo "selected"; } ?>> Paket </option>
                                    <option value="affiliate" <?php if($data_harga->jenis == 'affiliate') { echo "selected"; } ?>> Affiliate </option>
    							</select>
    							<span class="help-block"></span>
    						</div>
                            
    						<div class="form-group col-md-12">
    							<label>harga Satuan : </label>
    							<input type="text" class="form-control mask-currency" id="harga" name="harga" value="" data-thousands="." data-decimal="," data-prefix="Rp. " onKeyUp="hargaRaw();" />
    							<input type="hidden" class="form-control" id="harga_raw" name="harga_raw" value="<?= $data_harga->harga_satuan; ?>" />
    						</div>

                            <div class="form-group col-md-6">
                              <label>Diskon (%) : </label>
                              <input type="text" class="form-control numberinput" id="potongan" name="potongan" value="<?= $data_harga->diskon_paket; ?>">
                              <span class="help-block"></span>
                            </div>

                            <div class="form-group col-md-6">
                              <label>Diskon Agen (%) : </label>
                              <input type="text" class="form-control numberinput" id="potongan_agen" name="potongan_agen" value="<?= $data_harga->diskon_agen; ?>">
                              <span class="help-block"></span>
                            </div>

                            <div class="form-group col-md-12" id="tgl_aktif">
                                <label>Pilih tanggal aktif : </label>
                                <input type="text" class="form-control datepicker" id="tanggal_aktif" name="tanggal_aktif" value="<?= date('d-m-Y',strtotime($data_harga->tanggal_berlaku)); ?>">
                                <span class="help-block"></span>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Status Aktif : </label>
                                <select class="form-control select2" id="sts_aktif" name="sts_aktif">
                                    <option value="1" <?php if($data_harga->is_aktif == '1') { echo "selected"; } ?>> Aktif </option>
                                    <option value="0" <?php if($data_harga->is_aktif == '0') { echo "selected"; } ?>> Non Aktif </option>
                                </select>
                                <span class="help-block"></span>
                            </div>

    						<div class="form-group col-md-12">
    							<div class="pull-right">
    								<button type="button" id="btnSave" class="btn btn-primary" onclick="save('update')"><i class="fa fa-save"></i> Simpan</button>
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