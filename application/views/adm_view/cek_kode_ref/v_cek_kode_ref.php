    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
    		Cek Kode Referal
    	</h1>

    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-dashboard"></i>Transaksi</a></li>
    		<li class="active">Cek Kode Referal</li>
    	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-s12">
    			<div class="box">

    				<div class="box-body">
    					<div class="">
    						<form class="form-horizontal" method="get" action="<?= base_url('admin/cek_kode_ref/detail')?>">
    							<div class="form-group">
    								<label class="control-label col-sm-4">Tipe Kode Ref :</label>
    								<div class="col-sm-6">
    									<select id="tipe" class="form-control col-sm-4" style="margin-right: 5px;" name="tipe">
    										<option value="">Silahkan Pilih Tipe Kode Ref</option>
    										<option value="TRANS" <?php if($this->input->get('tipe') == 'TRANS'){ echo "selected"; } ?>>Transaksi Member & Affiliate</option>
    										<option value="KLAIM" <?php if($this->input->get('tipe') == 'KLAIM'){ echo "selected"; } ?>>Klaim Agen</option>
    									</select>
    								</div>
    							</div>

    							<div class="form-group">
    								<label class="control-label col-sm-4">Input Kode Ref :</label>
    								<div class="col-sm-6">
    									<input type="text" class="form-control col-sm-4" style="margin-right: 5px;" id="koderef" name="koderef" value="<?= $this->input->get('koderef'); ?>">
    								</div>
    							</div>

    							<div class="form-group">
    								<label class="control-label col-sm-4"></label>
    								<div class="col-sm-6">
    									<button type="submit" class="btn btn-primary"> Proses</button>
    								</div>
    							</div>
    						</form>
    					</div>
    				</div>

    				<?php if ($this->input->get('tipe') != "" && $this->input->get('koderef') != "") { ?>
    					<div class="box-header">
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="tabelData" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kode Ref</th>
                                            <th>Nama Lengkap</th>
                                            <th>Telepon</th>
                                            <th>Transaksi</th>
                                            <th>Email</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hasil_data as $key => $value): ?>
                                        <tr>
                                            <td><?= $value['no']; ?></td>
                                            <td><?= $value['tanggal']; ?></td>
                                            <td><?= $value['kode_ref']; ?></td>
                                            <td><?= $value['nama_lengkap']; ?></td>
                                            <td><?= $value['telepon']; ?></td>
                                            <td><?= $value['nilai']; ?></td>
                                            <td><?= $value['email']; ?></td>
                                            <td><?= $value['keterangan']; ?></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
    				<?php } ?>
    			</div>
    			<!-- /.box -->
    		</div>
    	</div>
    </section>
    <!-- /.content -->
