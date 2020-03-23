<main class="ps-main">
	<div class="test">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 "></div>
			</div>
			<div class="col-md-12">
				<div class="box" id="contact">
					<h2>Pengaturan Profil</h2>
					<p class="text-muted">Berikut merupakan data profil anda, anda dapat mengatur profil anda dengan menekan tombol <strong>Edit</strong>.</p>
					<div class="row">
						<?php foreach ($data_user as $value) { ?>
							<div class="col-md-9">
								<p><strong>Nama Lengkap :</strong> <?php echo $value->nama_lengkap_user; ?>
									<br><strong>Email :</strong> <?php echo $value->email; ?>
									<br><strong>Alamat :</strong> <?php echo $value->alamat_user; ?>
									<br><strong>Nomor Telp :</strong> <?php echo $value->no_telp_user; ?>
									<br><strong>Terakhir Login :</strong> <?php echo $value->last_login; ?>
								</p>
							</div>
							<div class="col-md-3">
								<span>
									<img src="<?php echo base_url(); ?>assets/img/foto_profil/<?php echo $value->gambar_user; ?>" style="border-radius: 50%; height: 50%; width: 50%;">
								</span>
							</div>
						<?php } ?>
					</div><!-- /.row -->
					<div>
						<?php $link = site_url('profil/edit_profil/') . $this->session->userdata('id_user'); ?>
						<a class="btn btn-sm btn-primary" href="<?php echo $link; ?>" title="Edit"> Edit Profil</a>
						<?php if ($this->uri->segment(3) != '') { ?>
							<?php $link2 = site_url('profil/konfirmasi_kedatangan/') . $this->uri->segment(3); ?>
							<a class="btn btn-sm btn-success" href="<?php echo $link2; ?>" title="Edit"> Konfirmasi Kedatangan</a>
						<?php } ?>
					</div>
					<hr>
					<h2>Progress Transaksi Anda</h2>
					<p class="text-muted">Berikut merupakan tabel transaksi yang belum dikonfirmasi untuk pembelian. Transaksi anda akan dinyatakan valid apabila telah melakukan konfirmasi. anda dapat membatalkan transaksi dengan menekan tombol <strong>Nonaktif (Warna Merah)</strong> & menekan <strong>tombol detail (Warna hijau)</strong> untuk melihat detail serta melakukan konfirmasi</p>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="tabelCheckoutHistory" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th style="text-align: center;">Tanggal</th>
											<th style="text-align: center;">Harga Total</th>
											<th style="text-align: center;">Kode Ref</th>
											<th style="text-align: center;">Status</th>
											<th style="width: 10%; text-align: center;">Aksi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div><!-- responsive -->
						</div> <!-- /.col-md-12 -->
					</div><!-- /.row -->

					<hr>
					<?php if ($this->session->userdata('id_level_user') == '2') { ?>
						<h2>Komisi Anda (Agen)</h2>
						<p class="text-muted">Berikut merupakan Hasil Komisi anda sebagai Agen</p>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="tabelKomisiHistory" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th style="text-align: center; width:5%">No</th>
												<th style="text-align: center; width:15%">Tanggal</th>
												<th style="text-align: center; width:25%">Harga Subtotal</th>
												<th style="text-align: center; width:25%">Laba Agen</th>
												<th style="text-align: center; width:13%">Kode Ref</th>
												<th style="text-align: center; width:5%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($data_komisi as $keys => $vals) { ?>
												<tr>
													<td><?= $vals[0]; ?></td>
													<td><?= $vals[1]; ?></td>
													<td><?= $vals[2]; ?></td>
													<td><?= $vals[3]; ?></td>
													<td><?= $vals[4]; ?></td>
													<td><?= $vals[5]; ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div><!-- responsive -->
							</div> <!-- /.col-md-12 -->
						</div><!-- /.row -->
					<?php }  ?>
				</div><!-- /.box -->
			</div><!-- /.col-md-9 -->
		</div>
	</div>
</main>

<script>
	var table;
	var table2;
	$(document).ready(function() {
		//datatable
		table = $('#tabelCheckoutHistory').DataTable({
			"processing": true, //feature control the processing indicator
			"serverSide": true, //feature control DataTables server-side processing mode
			"responsive": true,
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

		<?php if ($this->session->userdata('id_level_user') == '2') { ?>
			table2 = $('#tabelKomisiHistory').DataTable();
		<?php } ?>
	});
</script>
