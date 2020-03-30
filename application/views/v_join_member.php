<main class="ps-main">
	<div class="ps-checkout pt-80 pb-80">
		<div class="ps-container">
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
					<br>
					<?= $this->session->flashdata('feedback_failed') ?>
				</div>
			<?php } ?>
			<!-- end flashdata -->
			<form action="<?= base_url('join_member/proses_data'); ?>" id="form_proses" method="post" enctype="multipart/form-data" class="ps-checkout__form">
				<div class="row">
					<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
						<div class="ps-checkout__billing">
							<h3>Mohon Isi Data Diri Anda</h3>
							<div class="form-group form-group--inline">
								<label>Nama Depan<span>*</span>
								</label>
								<input class="form-control" style="background-color: #e8f0fe;" type="text" name="fname" id="fname">
								<span class="help-block"></span>
							</div>
							<div class="form-group form-group--inline">
								<label>Nama Belakang
								</label>
								<input class="form-control" style="background-color: #e8f0fe;" type="text" name="lname" id="lname">
								<span class="help-block"></span>
							</div>
							<div class="form-group form-group--inline">
								<label>Email<span>*</span>
								</label>
								<input class="form-control" style="background-color: #e8f0fe;" type="email" name="email" id="email" placeholder="anda@domain.com">
								<span class="help-block"></span>
							</div>
							<div class="form-group form-group--inline">
								<label>No. Telepon<span>*</span>
								</label>
								<input class="form-control" style="background-color: #e8f0fe;" type="text" name="telp" id="telp">
								<span class="help-block"></span>
							</div>
							<div class="form-group form-group--inline">
								<label>Password<span>*</span>
								</label>
								<input class="form-control" style="background-color: #e8f0fe;" type="password" name="password" id="password">
								<span class="help-block"></span>
							</div>
							<div class="form-group form-group--inline">
								<label>Konfirmasi Password<span>*</span>
								</label>
								<input class="form-control" style="background-color: #e8f0fe;" type="password" name="re_password" id="re_password">
								<span class="help-block"></span>
							</div>

							<h3 class="mt-40"> Upload Bukti Transfer</h3>
							<div class="form-group form-group--inline">
								<label>Upload Bukti</label><span>*</span>
								<input type="file" class="form-control-file" name="bukti" id="bukti" accept=".png, .jpg, .jpeg">
							</div>
							<div class="form-group">
								<img id="bukti-img" src="" alt="" height="360" width="300" class="pull-right" />
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
						<div class="ps-checkout__order">
							<!-- <header></header> -->
							<footer>
								<h3>Metode Pembayaran / Transfer</h3>
								<div class="form-group cheque">
									<div class="">
										<p>Dimohon Transfer Ke Rekening Dibawah Ini Serta Melampirkan Upload Bukti Transfer.</p>
										<p>BCA : BAPAK Cipto Junaedi - 014-1231212-12121</p>
										<p>MANDIRI : BAPAK Cipto Junaedi - 021-1231212-12121</p>
										<p>BANK OF INDIA : BAPAK Cipto Junaedi - 666-1231212-12121</p>
									</div>
								</div>
								<div class="form-group paypal">
									<button class="ps-btn ps-btn--fullwidth">Konfirmasi & Selesai<i class="ps-icon-next"></i></button>
								</div>
							</footer>
						</div>
						<div class="ps-shipping">
							<h3>PERLU ANDA KETAHUI</h3>
							<p>Ketika Anda Selesai Melakukan Proses Pendaftaran Member ini.<br> Proses pendaftaran anda akan kami verifikasi dan akan kami kirim pemberitahuan melalui WA/Email anda.</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</main>
<script src="https://www.google.com/recaptcha/api.js?render=6LcKN-MUAAAAADMou4FyEsJOONfj5940sKYIVFLt"></script>
<script>
	$(document).ready(function() {
		$("#bukti").change(function() {
			//console.log(this);
			var id = this.id;
			readURL(this, id);
		});
	});

	$('#form_proses').submit(function(event) {
		event.preventDefault();
		grecaptcha.ready(function() {
			grecaptcha.execute('6LcKN-MUAAAAADMou4FyEsJOONfj5940sKYIVFLt', {
				action: 'get_recaptcha'
			}).then(function(token) {
				$('#form_proses').prepend('<input type="hidden" name="token" value="' + token + '">');
				$('#form_proses').unbind('submit').submit();
			});
		});
	});

	function readURL(input, id) {
		var idImg = id + '-img';
		// console.log(idImg);
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			console.log(reader);
			reader.onload = function(e) {
				$('#' + idImg).attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
