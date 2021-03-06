    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
    		Transaksi
    		<small>Penjualan</small>
    	</h1>

    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-dashboard"></i>Transaksi</a></li>
    		<li class="active">Penjualan</li>
    	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-s12">
    			<div class="box">

    				<div class="box-body">
    					<div class="">
    						<form class="form-horizontal" method="get">
    							<div class="form-group">

    								<label class="control-label col-sm-2">Bulan :</label>
    								<div class="col-sm-4">
    									<select id="bulan" class="form-control col-sm-4" style="margin-right: 5px;" name="bulan">
    										<option value="">Silahkan Pilih Bulan</option>
    										<?php $flagBlnAda = FALSE; ?>
    										<?php for ($i = 1; $i <= 12; $i++) {
													if ($i == (int) $this->input->get('bulan')) {
														echo '<option value="' . $i . '" selected>' . $arr_bulan[$i] . '</option>';
														$flagBlnAda = TRUE;
													} else {
														if ($i == (int) date('m') && $flagBlnAda == FALSE) {
															echo '<option value="' . $i . '" selected>' . $arr_bulan[$i] . '</option>';
														} else {
															echo '<option value="' . $i . '">' . $arr_bulan[$i] . '</option>';
														}
													}
												} ?>
    									</select>
    								</div>
    							</div>

    							<div class="form-group">
    								<label class="control-label col-sm-2">Tahun :</label>
    								<div class="col-sm-4">
    									<select id="tahun" class="form-control col-sm-3" style="margin-right: 5px;" name="tahun">
    										<option value="">Silahkan Pilih Tahun</option>
    										<?php for ($i = 2010; $i <= 2025; $i++) {
													if ($i == $this->input->get('tahun')) {
														echo '<option value="' . $i . '" selected>' . $i . '</option>';
													} else {
														if ($i == (int) date('Y')) {
															echo '<option value="' . $i . '" selected>' . $i . '</option>';
														} else {
															echo '<option value="' . $i . '">' . $i . '</option>';
														}
													}
												} ?>
    									</select>
    								</div>
    							</div>

    							<div class="form-group">
    								<label class="control-label col-sm-2"></label>
    								<div class="col-sm-6">
    									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Proses</button>
    								</div>
    							</div>

    						</form>
    					</div>
    				</div>

    				<?php if ($this->input->get('bulan') != "" && $this->input->get('tahun') != "") { ?>
    					<div class="nav-tabs-custom">
    						<ul class="nav nav-tabs">
    							<li class="active"><a href="#tab_progress" data-toggle="tab" aria-expanded="true">On Progress</a></li>
    							<li class=""><a href="#tab_finish" data-toggle="tab" aria-expanded="false">Transaksi Selesai</a></li>
    						</ul>
    						<div class="tab-content">
    							<div class="tab-pane active" id="tab_progress">
    								<div class="box-header">
    									<?php if ($cek_kunci == FALSE) { ?>
    										<?php $this->template_view->getAddButton() ?>
    									<?php } ?>
    									<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
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
    									<!-- end flashdata -->

    									<div class="table-responsive">
    										<table id="tabelPenjualan" class="table table-bordered" cellspacing="0" width="100%">
    											<thead>
    												<tr>
    													<th>Tanggal</th>
    													<th>Nama</th>
    													<th>Email</th>
    													<th>Harga (Nett)</th>
    													<th>Status</th>
    													<th>Aksi</th>
    												</tr>
    											</thead>
    											<tbody>

    											</tbody>
    										</table>
    									</div>
    								</div>
    								<!-- /.box-body -->
    							</div>

    							<!-- tab finish -->
    							<div class="tab-pane" id="tab_finish">
    								<div class="box-header">
    									<button class="btn btn-default" onclick="reload_table2()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
    								</div>
    								<!-- /.box-header -->
    								<div class="box-body">
    									<!-- flashdata -->
    									<?php if ($this->session->flashdata('feedback_success2')) { ?>
    										<div class="alert alert-success alert-dismissible">
    											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    											<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
    											<?= $this->session->flashdata('feedback_success') ?>
    										</div>

    									<?php } elseif ($this->session->flashdata('feedback_failed2')) { ?>
    										<div class="alert alert-danger alert-dismissible">
    											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    											<h4><i class="icon fa fa-remove"></i> Gagal!</h4>
    											<?= $this->session->flashdata('feedback_failed') ?>
    										</div>
    									<?php } ?>
    									<!-- end flashdata -->
    									<div class="table-responsive">
    										<table id="tabelVerifikasiFinish" class="table table-bordered" cellspacing="0" width="100%">
    											<thead>
    												<tr>
    													<th>Tanggal</th>
                                                        <th>Nama</th>
                                                        <th>Email</th>
                                                        <th>Harga (Nett)</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
    												</tr>
    											</thead>
    											<tbody>

    											</tbody>
    										</table>
    									</div>
    								</div>
    								<!-- /.box-body -->
    							</div>
    						</div>
    					</div>
    				<?php } ?>
    			</div>
    			<!-- /.box -->
    		</div>
    	</div>
    </section>
    <!-- /.content -->
