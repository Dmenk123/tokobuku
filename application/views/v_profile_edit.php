<main class="ps-main">
	<div class="test">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 "></div>
			</div>
			<div class="col-md-12">
				<div class="box" id="contact">
					<h2>Pengaturan Profil</h2>
					<hr>
					<div class="row">
						<form id="form_input">
							<?php foreach ($hasil_data as $value) { ?>
								<?php
								$arr_nama = explode(',', $value->nama_lengkap_user);
								if (count($arr_nama) > 1) {
									$nama_lengkap = $arr_nama[0] . ' ' . $arr_nama[1];
								} else {
									$nama_lengkap = $arr_nama[0];
								}
								?>
								<div class="form-group col-md-12">
									<label>Nama Lengkap User : </label>
									<input type="text" class="form-control" style="background-color: #e8f0fe;" id="namalengkap" name="namalengkap" value="<?php echo $nama_lengkap; ?>">
									<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $value->id_user; ?>">
									<span class="help-block"></span>
								</div>

								<div class="form-group col-md-12">
									<label>Password Lama: </label>
									<input type="password" class="form-control" style="background-color: #e8f0fe;" id="password" name="password" value="">
									<span class="help-block"></span>
								</div>

								<div class="form-group col-md-12">
									<label>Password Baru : </label>
									<input type="password" class="form-control" style="background-color: #e8f0fe;" id="passwordnew" name="passwordnew" value="">
									<span class="help-block"></span>
								</div>

								<div class="form-group col-md-12">
									<label>Ulangi Password Baru : </label>
									<input type="password" class="form-control" style="background-color: #e8f0fe;" id="repassword" name="repassword" value="">
									<span class="help-block"></span>
								</div>

								<div class="form-group col-md-12 checkbox">
									<label>
										<input type="checkbox" value="Y" name="ceklistpwd" id="ceklistpwd"> Centang Pilihan ini jika tidak mengganti password
									</label>
								</div>

								<div class="form-group col-md-12">
									<label>Nomor Telp / WA : </label>
									<input type="text" class="form-control numberinput" style="background-color: #e8f0fe;" id="telp" name="telp" value="<?php echo $value->no_telp_user; ?>">
									<span class="help-block"></span>
								</div>

								<div class="form-group col-md-12">
									<label>Email : </label>
									<input type="text" class="form-control" style="background-color: #e8f0fe;" id="email" name="email" value="<?php echo $value->email; ?>">
									<span class="help-block"></span>
								</div>

								<div class="form-group col-md-9">
									<label>Foto (Abaikan Jika Tidak Merubah Foto) : </label>
									<input type="file" id="gambar" class="gambar" name="gambar" ; />
								</div>

								<div class="form-group col-md-3">
									<img id="gambar-img" src="<?= base_url() . '/assets/img/foto_profil/' . $value->gambar_user; ?>" alt="Preview Gambar" height="75" width="75" class="pull-right" />
								</div>

								<div class="form-group col-md-12">
									<div class="pull-right">
										<button type="button" id="btnSave" class="btn btn-primary" onclick="update_profil()"><i class="fa fa-save"></i> Simpan</button>
									</div>
									<div class="pull-left">
										<a class="btn btn-md btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
									</div>
								</div>
							<?php } ?>
						</form>
					</div><!-- /.row -->
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

		$(".gambar").change(function() {
			//console.log(this);
			var id = this.id;
			readURL(this, id);
		});

		$('#ceklistpwd').change(function() {
			if (this.checked) {
				$('#password').attr('readonly', true).css('background-color', "#8a8991");
				$('#repassword').attr('readonly', true).css('background-color', "#8a8991");
				$('#passwordnew').attr('readonly', true).css('background-color', "#8a8991");
			} else {
				$('#password').attr('readonly', false).css('background-color', "#e8f0fe");
				$('#repassword').attr('readonly', false).css('background-color', "#e8f0fe");
				$('#passwordnew').attr('readonly', false).css('background-color', "#e8f0fe");

			}
		});
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

	function readURL(input, id) {
		var idImg = id + '-img';
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			console.log(reader);
			reader.onload = function(e) {
				$('#' + idImg).attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function update_profil() {
		$('#btnSave').text('saving...'); //change button text
		$('#btnSave').attr('disabled', true); //set button disable 
		
		var url;
		url = "<?php echo site_url('profil/update_profil') ?>";
		
		// Get form
		let form = $('#form_input')[0];
		let data = new FormData(form);

		// ajax adding data to database
		$.ajax({
			url: url,
			enctype: 'multipart/form-data',
			type: "POST",
			data: data,
			dataType: "JSON",
			processData: false,
			contentType: false,
			success: function(data) {
				if (data.status) {
					window.location.href = "<?= base_url('/profil'); ?>";
				} else {
					for (var i = 0; i < data.inputerror.length; i++) {
						if (data.inputerror[i] != 'jabatan') {
							$('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
							$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
						} else {
							$($('#jabatan').data('select2').$container).addClass('has-error');
						}
					}
				}

				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 


			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
				alert('Error adding / update data');
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 

			}
		});
	}
</script>
