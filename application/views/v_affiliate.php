<div class="container">
	<div class="col-md-12">
		<ul class="breadcrumb">
			<li><a href="#">Home</a>
			</li>
			<li><?php echo $this->uri->segment(1); ?></li>
		</ul>
	</div><!-- /.col -->

	<p style="font-size:14px; font-family: arial; color:black;" align="justify">Cara kerjanya sangat mudah, Mau ??</p>
	<p style="font-size:14px; font-family: arial; color:black;" align="center"><strong><span style="font-size:25px;color:blue;">Hanya majang brosur online</span> di medsos anda, Maka <span style="font-size:20px;color:red;">anda akan mendapatkan </span><span style="font-size:30px;color:yellow;">SUMBER UANG </span>yang bisa menjadi mesin uang bagi anda.</strong></p>
	<p style="font-size:14px; font-family: arial; color:black;" align="justify">Hanya dengan memajang brosur online kami, anda bisa mendapatkan Income puluhan juta, dengan ada orang yang ikut Program Belajar Jadi Teladan Tanpa Utang melalui website/brosur online yang anda pajang. Jika orang, sebut saja si A baca brosur online itu link anda, kemudian si A ikut Program Belajar Jadi teladan Tanpa Utang maka anda mendapat uang sebesar 45% dari harga penjualan.</p>
	<p style="font-size:14px; font-family: arial; color:black;" align="justify">Mau tunggu apa lagi, hanya mainan Hp dan copas saja bisa miliki sumber uang terus - menerus.</p>
	<p style="font-size:14px; font-family: arial; color:black;" align="center"><strong>Miliki<span style="font-size:25px;color:blue;">Mesin Uangmu </span>di atas yang bisa Menghasilkan Uang terus menerus setiap harinya, </strong></p>
	<p style="font-size:14px; font-family: arial; color:black;" align="center"><strong><span style="font-size:30px;color:yellow;">TANPA HARUS JUALAN, CUKUP HANYA MEMAJANG </span>& menjadi Affiliate Kami. </strong></p>
	<div class="col-md-6" id="register">
		<div class="box">
			<h1>Register</h1>
			<p class="lead">Anda apakah saat ini belum memiliki akun ?</p>
			<p>Jadilah bagian dari kami, silahkan daftar Affiliate dan nikmati keuntungannya !!</p>
			<hr>
			<form id="form_register" method="POST" name="formRegister" enctype="multipart/form-data">
				<div class="form-group">
					<label for="Nama Depan">Username*</label>
					<input typ e="text" class="form-control" id="regUsername" name="reg_username">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Nama Depan">Nama Depan*</label>
					<input type="text" class="form-control" id="regNama" name="reg_nama">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Nama Belakang">Nama Belakang</label>
					<input type="text" class="form-control" id="regNamaBlkg" name="reg_nama_blkg">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Nomor telepon">Nomor Telp*</label>
					<input type="text" class="form-control numberinput" id="regTelp" name="reg_telp" placeholder="contoh : 081234567890">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Email">Email*</label>
					<input type="email" class="form-control" id="regEmail" name="reg_email" placeholder="anda@domain.com">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Password">Password*</label>
					<input type="password" class="form-control" id="regPassword" name="reg_password">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Retype Password">Tulis Ulang Password*</label>
					<input type="password" class="form-control" id="regRePassword" name="reg_re_password">
					<span id='message'></span>
					<span class="help-block"></span>
				</div>

				<div class="form-group">
					<label for="Nama Belakang">Bank*</label>
					<select class="form-control" id="regBank" name="reg_bank">
						<option value="BCA">BCA</option>
						<option value="MANDIRI">MANDIRI</option>
						<option value="BNI">BNI</option>
						<option value="BRI">BRI</option>
						<option value="JATIM">BANK JATIM</option>
						<option value="JATENG">BANK JATENG</option>
						<option value="JABAR">BANK JABAR</option>
						<option value="DKI">BANK DKI</option>
					</select>
				</div>

				<div class="form-group">
					<label for="Nama Belakang">No Rekening*</label>
					<input type="text" class="form-control" id="regRekening" name="reg_rekening">
					<span class="help-block"></span>
				</div>

				<div class="form-group">
					<label for="Kode Pos">Captcha* (Case sensitive - Besar kecil huruf berpengaruh)</label>
					<p>
						<span id="imgCaptcha"><?php echo $img; ?></span>
						<a href="javascript:void(0);" class="refreshCaptcha">[Kode Tidak Jelas]</a>
					</p>
					<input type="text" class="form-control" id="regCaptcha" name="reg_captcha">
					<span class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="Wajib Diisi"><strong>Keterangan : (*) Wajib diisi.</strong></label>
					<br>
					<label for="">Mohon memasukkan nomor rekening anda dengan valid. Komisi anda akan kami transfer pada rekening yg anda daftarkan</label>
				</div>
				<div class="text-center">
					<input type="submit" value="Register" id="btnRegister" class="btn btn-primary" />
				</div>
			</form>

		</div><!-- /.box -->
	</div><!-- /.col -->

	<div class="col-md-6">
		<div class="box">
			<h1>Login</h1>
			<p class="lead">Sudah memiliki akun ?</p>
			<p class="text-muted">Silahkan mengisi email dan password anda pada form yang tersedia untuk mendapatkan link Affiliete Anda !.</p>
			<hr>
			<form id="form_login" action="#">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username_login" name="username_login" placeholder="username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password_login" name="password_login" placeholder="password">
				</div>
			</form>
			<div class="text-center">
				<button class="btn btn-primary" onclick="login_proc()"><i class="fa fa-sign-in" id="btnLogin"></i> Log in</button>
				<button class="btn btn-success" id="login_before" onclick="register_before()"><i class="fa fa-user"></i> Register</button>
			</div>
		</div><!-- /.box -->
	</div><!-- /.col -->

	<div class="col-md-6" style="padding-top:50px;" id="image">
		<div class="box">
			<img src="<?php echo base_url(); ?>images/affiliate.png" height="350" width="auto">
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.container -->





<script>
	$(document).ready(function() {
		$('.refreshCaptcha').on('click', function() {
			$.get('<?php echo base_url() . 'register/refresh_captcha'; ?>', function(data) {
				$('#imgCaptcha').html(data);
			});
		});

		$('#register').hide();

		$("#btnRegister").click(function(event) {
			event.preventDefault();
			var form = $('#form_register')[0];
			var data = new FormData(form);
			$("#btnRegister").prop("disabled", true);
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: "<?php echo site_url('affiliate/add_register'); ?>",
				data: data,
				dataType: "JSON",
				processData: false, // false, it prevent jQuery form transforming the data into a query string
				contentType: false,
				cache: false,
				timeout: 600000,
				success: function(data) {
					if (data.status) {
						alert(data.pesan);
						$("#btnRegister").prop("disabled", false);
						window.location.href = "<?php echo site_url('profile'); ?>";
					} else {
						if (data.flag_captcha) {
							alert(data.pesan);
							$("#btnRegister").prop("disabled", false);
						} else {
							$("#btnRegister").prop("disabled", false);
							for (var i = 0; i < data.inputerror.length; i++) {
								if (data.inputerror[i] != 'jabatan') {
									$('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
									$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
								} else {
									$($('#jabatan').data('select2').$container).addClass('has-error');
								}
							}
						}
					}
				},
				error: function(e) {
					console.log("ERROR : ", e);
					$("#btnRegister").prop("disabled", false);
				}
			});

		});
	});

	function login_proc() {
		$("#btnLogin").prop("disabled", true);
		var form = $('#form_login')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url: "<?php echo site_url('register/login'); ?>",
			data: data,
			dataType: "JSON",
			processData: false, // false, it prevent jQuery form transforming the data into a query string
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function(data) {
				if (data.status) {
					alert(data.pesan);
					$("#btnLogin").prop("disabled", false);
					window.location.href = "<?php echo site_url('profile'); ?>";
				} else {
					if (data.flag_alert) {
						alert(data.pesan);
					} else {
						$("#btnLogin").prop("disabled", false);
						for (var i = 0; i < data.inputerror.length; i++) {
							if (data.inputerror[i] != 'jabatan') {
								$('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
								$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
							} else {
								$($('#jabatan').data('select2').$container).addClass('has-error');
							}
						}
					}
				}
			},
			error: function(e) {
				console.log("ERROR : ", e);
				$("#btnRegister").prop("disabled", false);
			}
		});
	}

	function register_before() {
		$("#register").show();
		$("#image").hide();
		$("#login_before").hide();
	}
</script>
