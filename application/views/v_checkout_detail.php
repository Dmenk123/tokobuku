<main class="ps-main">
	<div class="test">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 "></div>
			</div>

			<div class="col-md-12">
				<div class="box" id="checkout_detail">
					<div class="box-body">
						<div class="table-responsive">
							<div class="col-xs-12">
								<h2 style="text-align: center;"><strong>Detail Transaksi</strong></h2>
							</div>
							<div class="col-xs-4">
								<h5 style="text-align: left;">Nama User : <?php $nm = explode(',', $data_checkout[0]->nama_lengkap_user);
																						echo $nm[0] . ' ' . $nm[1]; ?></h5>
								<h5 style="text-align: left;">Kode Ref : <?php echo $data_checkout[0]->kode_ref; ?></h5>
							</div>
							<div class="col-xs-4">
								<h4 style="text-align: center;">Tanggal Transaksi: <?php echo date("d-m-Y", strtotime($data_checkout[0]->created_at)); ?></h4>
							</div>
							<!-- <div class="col-xs-4">
								<?php if ($val->method_checkout == "COD") { ?>
									<h5 style="text-align: right;">Metode Pembayaran: Cash On Delivery</h5>
								<?php } else { ?>
									<h5 style="text-align: right;">Metode Pembayaran: Transfer</h5>
									<h5 style="text-align: right;">Kurir: <?php echo $val->jasa_ekspedisi . " - " . $val->pilihan_paket . " - " . $val->estimasi_datang; ?></h5>
								<?php } ?>
							</div> -->
							<div class="col-xs-12">
								<h5 style="text-align: left;">Email : <?php echo $data_checkout[0]->email; ?></h5>
							</div>
							<div class="col-xs-12" style="padding-top: 30px; padding-bottom: 10px;">
								<table id="tabelCheckoutDetail" class="table table-bordered table-hover" border="1" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th style="width: 30px; text-align: center;">No</th>
											<th style="width: 50px; text-align: center;">Kode</th>
											<th style="width: 200px; text-align: center;">Nama Produk</th>
											<th style="width: 60px; text-align: center;">Satuan</th>
											<!-- <th style="width: 50px; text-align: center;">Berat</th> -->
											<th style="width: 50px; text-align: center;">Harga Satuan</th>
											<th style="width: 30px; text-align: center;">Qty</th>
											<th style="width: 50px; text-align: center;">Harga Total</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										<?php foreach ($data_checkout as $val) : ?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td><?php echo $val->kode_produk; ?></td>
												<td><?php echo $val->nama_produk; ?></td>
												<td><?php echo $val->nama_satuan; ?></td>
												<!-- <td><?php echo $val->berat_satuan; ?> gram</td> -->
												<td><?php echo "Rp. " . number_format($val->harga_satuan, 0, ",", "."); ?></td>
												<td><?php echo $val->qty; ?></td>
												<td><?php echo "Rp. " . number_format($val->harga_subtotal, 0, ",", "."); ?></td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
							<div class="col-xs-12" style="padding-top: 30px; padding-bottom: 10px;">
								<!-- <p class="text-muted"><strong>Catatan :</strong> Mohon transaksi ini dikonfirmasi agar dapat kami tindak lanjuti, Terima Kasih.</p> -->
								<a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()">
									<i class="fa fa-arrow-left"></i> Kembali
								</a>

								<!-- <?php foreach ($hasil_header as $value) : ?>
									<?php $link = $value->id_checkout;  ?>
								<?php endforeach ?> -->

								<!-- <a class="btn btn-sm btn-primary" title="Konfirmasi" href="<?php echo site_url('profil/konfirmasi_checkout/' . $link); ?>"><i class="fa fa-check-square-o"></i> Konfirmasi</a> -->
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- /.col-md-9 -->

		</div>
	</div>
</main>

<script>
	$(document).ready(function() {
		//datatable
		table = $('#tabelCheckoutHistory').DataTable({
			"processing": true, //feature control the processing indicator
			"serverSide": true, //feature control DataTables server-side processing mode
			"order": [
				[0, 'desc']
			], //index for order, 0 is first column
			//load data for table content from ajax source
			"ajax": {
				"url": "<?php echo base_url('profile/list_checkout_history') ?>",
				"type": "POST"
			},
			//set column definition initialisation properties
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],
		});
	});
</script>
