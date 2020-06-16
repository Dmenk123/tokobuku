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
    							<h4 style="text-align: left;">Customer :<?php echo $hasil_data->nama_lengkap; ?></h4>
    						</div>
    						<div class="col-xs-6">
    							<h4 style="text-align: right;">Tanggal Transaksi: <?php echo date('d-m-Y', strtotime($hasil_data->created_at)); ?></h4>
    						</div>
    						<hr>
    						<table id="tabelDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
    							<thead>
    								<tr>
    									<th style="width: 20%; text-align: center;">Harga Bruto</th>
    									<th style="width: 15%; text-align: center;">Diskon</th>
    									<th style="width: 10%; text-align: center;">User Agen</th>
    									<th style="width: 10%; text-align: center;">Nama Agen</th>
    									<th style="width: 15%; text-align: center;">Laba Agen</th>
    								</tr>
    							</thead>
    							<tbody>
    								<?php if ($hasil_data) : ?>
										<?php
										$no = 1;
										$nm = explode(',', $hasil_data->nama_lengkap_user);
										?>
										<tr>
                                            <td>
                                                <div>
                                                    <span class="pull-left">Rp. </span>
                                                    <span class="pull-right"><?= number_format((($hasil_data->harga_total + $hasil_data->diskon_total)), 2, ",", "."); ?></span>
                                                </div>
                                            </td>
											<td>
												<div>
													<span class="pull-left">Rp. </span>
													<span class="pull-right"><?= number_format($hasil_data->diskon_total, 2, ",", "."); ?></span>
												</div>
											</td>
										
											<td><?php echo $hasil_data->username_agen; ?></td>
											<?php if (count($nm) > 1) { ?>
												<td><?php echo $nm[0] . ' ' . $nm[1]; ?></td>
											<?php } else { ?>
												<td><?php echo $nm[0]; ?></td>
											<?php } ?>

											<td>
												<div>
													<span class="pull-left">Rp. </span>
													<span class="pull-right"><?= number_format($hasil_data->laba_agen_total, 2, ",", "."); ?></span>
												</div>
											</td>
										</tr>
    									<tr>
    										<td colspan="3" align="center"><strong>Harga Penjualan (Nett)</strong></td>
    										<td colspan="2">
    											<div>
    												<span class="pull-left">Rp. </span>
    												<span class="pull-right"><?= number_format($hasil_data->harga_total, 2, ",", "."); ?></span>
    											</div>
    										</td>
    									</tr>
    									<tr>
                                            <td colspan="3" align="center"><strong>Kode Referensi : </strong></td>
                                            <td colspan="2" align="center">
                                                <strong><?= $hasil_data->kode_ref; ?></strong>
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
    										<?php
                                                if ($hasil_data->jenis == 'affiliate') {
                                                    echo '<img src="' . base_url() . '/assets/img/bukti_transfer_aff/' . $hasil_data->bukti . '" width="400" height="400">';
                                                 }else{
                                                    echo '<img src="' . base_url() . '/assets/img/bukti_transfer/' . $hasil_data->bukti . '" width="400" height="400">';
                                                 } 
                                            ?>
    										<input type="hidden" name="bukti_upload" value="<?= $hasil_data->bukti; ?>">
    										<input type="hidden" name="kode_ref" value="<?= $hasil_data->kode_ref; ?>">
    									</th>
    								</tr>
    							</table>
                                
                                <?php if($hasil_data->is_konfirm == '0'){ ?>
                                    <div style="padding-top: 30px; padding-bottom: 10px;text-align:center;">
        								<button type="button" class="btn btn-sm btn-primary" title="Verifikasi" onclick="verify('<?=$hasil_data->id;?>')"> Verifikasi </button>
        							</div>
                                <?php } ?>
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
