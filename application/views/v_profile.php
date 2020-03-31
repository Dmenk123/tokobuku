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
							<?php 
								$arr_nama = explode(',', $value->nama_lengkap_user); 
								$nama_lengkap = $arr_nama[0].' '.$arr_nama[1];
							?>
							<div class="col-md-3">
								<span>
									<img src="<?php echo base_url(); ?>assets/img/foto_profil/<?php echo $value->gambar_user; ?>" style="border-radius: 50%; height: 50%; width: 50%;">
								</span>
							</div>
							<div class="col-md-9">
								<p><strong>Nama Lengkap :</strong> <?php echo $nama_lengkap; ?>
									<br><strong>Email :</strong> <?php echo $value->email; ?>
									<br><strong>Alamat :</strong> <?php echo $value->alamat_user; ?>
									<br><strong>Nomor Telp :</strong> <?php echo $value->no_telp_user; ?>
									<br><strong>Terakhir Login :</strong> <?php echo $value->last_login; ?>
									<hr>
								</p>
							</div>
						<?php } ?>
							<div class="col-md-5" style="text-align: right;">
								<?php $link = site_url('profil/edit_profil/') . $this->session->userdata('id_user'); ?>
								<a class="btn btn-sm btn-primary" href="<?php echo $link; ?>" title="Edit"> Edit Profil</a>
							</div>
					</div><!-- /.row -->
					<hr>
					<div class="row">
						<div class="col-md-12">
							<h3>Data Komisi</h3>
							<br><strong>Jumlah Komisi <span style="color:blue;">(Sudah Ditarik)</span> :</strong> <strong>Rp. <?php echo number_format($data_laba_agen['komisi_sudah'],2,",","."); ?></strong>
							<br><strong>Jumlah Komisi <span style="color:red;">(Belum Ditarik)</span> :</strong> <strong>Rp. <?php echo number_format($data_laba_agen['komisi_belum'],2,",","."); ?></strong>
							<br><br>
								<?php $links = $this->session->userdata('id_user'); ?>
								<button type="button" class="btn btn-sm btn-success"  onclick="tarikCuan('<?php echo $links; ?>')" title="Tarik Komisi"> Tarik Komisi</button>
						</div>
						
					</div>	
					<hr>
					<?php if ($this->session->userdata('id_level_user') == '2') { ?>
						<h2>Komisi Anda</h2>
						<p class="text-muted">Berikut merupakan rincian komisi affiliate yang belum anda ditarik.</p>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="tabelKomisiHistory" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th style="text-align: center; width:5%">No</th>
												<th style="text-align: center; width:15%">Tanggal</th>
												<th style="text-align: center; width:25%">Laba Agen</th>
												<th style="text-align: center; width:13%">Kode Ref</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($data_komisi as $keys => $vals) { ?>
												<tr>
													<td><?= $vals[0]; ?></td>
													<td><?= $vals[1]; ?></td>
													<td><?= $vals[2]; ?></td>
													<td><?= $vals[3]; ?></td>
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
	$(document).ready(function() {
		<?php if ($this->session->userdata('id_level_user') == '2') { ?>
			table = $('#tabelKomisiHistory').DataTable();
		<?php } ?>
	});

	function tarikCuan(id) {
		swal({
	      	title: "Tarik Komisi",
	      	text: "Anda Yakin Ingin Melakukan Penarikan Komisi ?? ",
	      	icon: "warning",
	      	buttons: [
	        	'Tidak',
	        	'Ya'
	      	],
	      	//dangerMode: true,
	    	}).then(function(isConfirm) {
	      		if (isConfirm) {
	        		$.ajax({
						url: baseUrl + 'profile/tarik_komisi/'+id,
						type: 'POST',
						dataType: "JSON",
						success: function (data) {
							if (data.status) {
								swal("Sukses", 'Anda berhasil Menarik Komisi. Lihat Rincian Penarikan', "success").then(function() {
								    location.reload(true);
								});
							}else{
								swal("Gagal", 'Gagal Menarik Komisi, Coba Lagi Nanti..', "error").then(function() {
								    location.reload(true);
								});
							}
						}
					});
	      		} else {
	        		swal("Batal", "Aksi dibatalkan", "error");
	     	 	}
			});
	}
</script>
