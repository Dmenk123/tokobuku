    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
    		Transaksi
    		<small>Penjualan</small>
    	</h1>
    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-dashboard"></i>Data Transaksi</a></li>
    		<li class="active">Penjualan Detail</li>
    	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-12">
    			<div class="box">
    				<!-- /.box-header -->
    				<div class="box-body">
    					<div class="table-responsive">
    						<div class="col-xs-12">
    							<h4 style="text-align: center;"><strong>Detail Penjualan</strong></h4>
    						</div>
    						<div class="col-xs-6">
    							<h4 style="text-align: left;">Customer :<?php $nm = explode(',', $hasil_header->nama_lengkap_user);
																		echo $nm[0] . ' ' . $nm[1]; ?></h4>
    						</div>
    						<div class="col-xs-6">
    							<h4 style="text-align: right;">Tanggal Transaksi: <?php echo date('d-m-Y', strtotime($hasil_header->created_at)); ?></h4>
    						</div>
    						<hr>
    						<table id="tabelDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
    							<thead>
    								<tr>
    									<th style="width: 5%; text-align: center;">Gambar</th>
    									<th style="width: 5%; text-align: center;">Kode</th>
    									<th style="width: 5%; text-align: center;">Jumlah</th>
    									<th style="width: 5%; text-align: center;">Satuan</th>
    									<th style="width: 15%; text-align: center;">Harga</th>
    									<th style="width: 20%; text-align: center;">Total</th>
    									<th style="width: 10%; text-align: center;">User Agen</th>
    									<th style="width: 10%; text-align: center;">Nama Agen</th>
    									<th style="width: 15%; text-align: center;">Laba Agen</th>
    								</tr>
    							</thead>
    							<tbody>
    								<?php if ($hasil_data) : ?>
    									<?php foreach ($hasil_data as $key => $val) { ?>
    										<?php
											$no = 1;
											$nm = explode(',', $val->fullname_agen);
											?>
    										<tr>
    											<td><?php echo '<img src="' . base_url() . '/assets/img/produk/' . $val->gambar_1 . '" width="50" height="50">'; ?></td>
    											<td><?php echo $val->kode_produk; ?></td>
    											<td><?php echo $val->qty; ?></td>
    											<td><?php echo $val->nama_satuan; ?></td>
    											<td>
    												<div>
    													<span class="pull-left">Rp. </span>
    													<span class="pull-right"><?= number_format($val->harga_satuan, 2, ",", "."); ?></span>
    												</div>
    											</td>
    											<td>
    												<div>
    													<span class="pull-left">Rp. </span>
    													<span class="pull-right"><?= number_format($val->harga_subtotal, 2, ",", "."); ?></span>
    												</div>
    											</td>
    											<td><?php echo $val->username_agen; ?></td>
    											<?php if (count($nm) > 1) { ?>
    												<td><?php echo $nm[0] . ' ' . $nm[1]; ?></td>
    											<?php } else { ?>
    												<td><?php echo $nm[0]; ?></td>
    											<?php } ?>
    											<td>
    												<div>
    													<span class="pull-left">Rp. </span>
    													<span class="pull-right"><?= number_format($val->harga_potongan, 2, ",", "."); ?></span>
    												</div>
    											</td>
    										</tr>
    									<?php } ?>
    									<tr>
    										<td colspan="7" align="center"><strong>Total Penjualan (Bruto) / Omzet</strong></td>
    										<td colspan="2">
    											<div>
    												<span class="pull-left">Rp. </span>
    												<span class="pull-right"><?= number_format(($val->harga_subtotal * $val->qty), 2, ",", "."); ?></span>
    											</div>
    										</td>
    									</tr>
    									<tr>
    										<td colspan="7" align="center"><strong>Total Laba Agen</strong></td>
    										<td colspan="2">
    											<div>
    												<span class="pull-left">Rp. </span>
    												<span class="pull-right"><?= number_format(($val->harga_potongan * $val->qty), 2, ",", "."); ?></span>
    											</div>
    										</td>
    									</tr>
    									<tr>
    										<td colspan="7" align="center"><strong>Total Penjualan (Nett)</strong></td>
    										<td colspan="2">
    											<div>
    												<span class="pull-left">Rp. </span>
    												<span class="pull-right"><?= number_format((($val->harga_subtotal * $val->qty) - ($val->harga_potongan * $val->qty)), 2, ",", "."); ?></span>
    											</div>
    										</td>
    									</tr>
    								<?php endif ?>
    							</tbody>
    						</table>

    						<hr>
    						<h3>Bukti Pembayaran</h3>
    						<form class="form-horizontal" id="formVerify">
    							<table id="tabelVerify" class="table table-bordered table-hover" cellspacing="0" width="100%">
    								<tr>
    									<th>
    										<?php echo '<img src="' . base_url() . '/assets/img/bukti_transfer/' . $val->bukti . '" width="400" height="400">'; ?>
    										<input type="hidden" name="bukti_upload" value="<?= $val->bukti; ?>">
    									</th>
    								</tr>
    								<tr>
    									<td>Tanggal Upload : </td>
    									<td>
    										<strong><?= date('d-m-Y H:i:s', strtotime($val->tgl_checkout)); ?></strong>
    										<input type="hidden" name="id_checkout" value="<?= $val->id_checkoutnya; ?>">
    									</td>
    								</tr>
    								<tr>
    									<td>Kode Referensi : </td>
    									<td>
    										<strong><?= $val->kode_ref; ?></strong>
    										<input type="hidden" name="kode_ref" value="<?= $val->kode_ref; ?>">
    									</td>
    								</tr>
    							</table>

    							<div style="padding-top: 30px; padding-bottom: 10px;text-align:center;">
    								<button type="button" class="btn btn-sm btn-primary" title="Verifikasi" onclick="verify()"> Verifikasi </button>
    							</div>
    						</form>
							<hr>
    						<div style="padding-top: 30px; padding-bottom: 10px;">
    							<a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
    							<?php $id = $this->uri->segment(3); ?>
    							<?php $link_print = site_url('penerimaan/cetak_nota_penerimaan/') . $id; ?>
    							<?php echo '<a class="btn btn-sm btn-success" href="' . $link_print . '" title="Print" id="btn_print_pengeluaran_detail" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>'; ?>
    						</div>
    					</div>
    				</div>
    				<!-- /.box-body -->
    			</div>
    			<!-- /.box -->
    		</div>
    	</div>
    </section>
    <!-- /.content -->
