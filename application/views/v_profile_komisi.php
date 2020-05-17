<main class="ps-main">
	<div class="test">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 "></div>
			</div>
			<div class="col-md-12">
				<div class="box" id="contact">
					<h2>Klaim Komisi Yang Belum Diklaim</h2>
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
										<?php foreach ($data_komisi_belum as $keys => $vals) { ?>
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
					<br>
					<hr>
					<h2>Klaim Komisi Dalam Tahap Verifikasi Oleh Admin</h2>
					<p class="text-muted">Berikut merupakan rincian komisi affiliate yang masuk dalam tahap verifikasi.</p>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="tabelPreKomisiHistory" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th style="text-align: center; width:5%">No</th>
											<th style="text-align: center; width:15%">Tanggal</th>
											<th style="text-align: center; width:25%">Laba Agen</th>
											<th style="text-align: center; width:13%">Kode Ref</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data_komisi_pre as $keys => $vals) { ?>
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
					<br>
					<hr>
					<h2>Klaim Komisi Sudah Ditarik</h2>
					<p class="text-muted">Berikut merupakan rincian komisi affiliate yang sudah anda ditarik.</p>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="tabelAfterKomisiHistory" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th style="text-align: center; width:5%">No</th>
											<th style="text-align: center; width:15%">Tanggal</th>
											<th style="text-align: center; width:25%">Laba Agen</th>
											<th style="text-align: center; width:13%">Kode Ref</th>
											<th style="text-align: center; width:13%">Bukti</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data_komisi_after as $keys => $vals) { ?>
											<tr>
												<td><?= $vals[0]; ?></td>
												<td><?= $vals[1]; ?></td>
												<td><?= $vals[2]; ?></td>
												<td><?= $vals[3]; ?></td>
												<td><button class="btn btn-primary" onclick="lihatBukti('<?=$vals[4]."'".','."'".$vals[3];?>')">Lihat Bukti</button></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div><!-- responsive -->
						</div> <!-- /.col-md-12 -->
					</div><!-- /.row -->
					<hr>
					<div class="row">
						<div class="col-md-12">
							<a class="btn btn-sm btn-default" title="Kembali" href="<?= base_url('profile'); ?>"> Kembali</a>
						</div>
					</div>
					<hr>
				</div><!-- /.box -->
			</div><!-- /.col-md-9 -->
		</div>
	</div>
</main>

<!-- Modal -->
<div id="modalBukti" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Bukti Transfer</h4>
      </div>
      <div class="modal-body">
        <!-- <iframe id='imageArea' src="" title="Bukti Transfer" width="500" height="400"></iframe> -->
        <span id="judul" style="text-align: center;font-size: 20px;font-weight: bold;"></span>
        <br>
        <img id='imageArea' src="" alt="imageArea" title="bukti transfer" width="400" height="400">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      ...
    </div>
  </div>
</div> -->

<script>
	var table;
	var table2;
	var table3;
	$(document).ready(function() {
		table = $('#tabelKomisiHistory').DataTable();
		table2 = $('#tabelPreKomisiHistory').DataTable();
		table2 = $('#tabelAfterKomisiHistory').DataTable();
	});

	function tarikCuan() {
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
					url: baseUrl + 'profile/tarik_komisi',
					type: 'POST',
					dataType: "JSON",
					success: function(data) {
						if (data.status) {
							swal("Sukses, Komisi kode : " + data.kode_klaim + "", 'Selengkapnya bisa diihat pada rincian Penarikan', "success").then(function() {
								location.reload(true);
							});
						} else {
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

	function lihatBukti(imgfile, koderef) {
		var urlBukti = baseUrl+'assets/img/bukti_verifikasi/'+imgfile;
		$('#modalBukti').modal('show');
		$('#imageArea').attr('src', urlBukti);
		$('#judul').text('Bukti Transfer Kode Ref : '+koderef);
	}
</script>
