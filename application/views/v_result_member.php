<main class="ps-main">
	<div class="ps-checkout pt-80 pb-80">
		<div class="ps-container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-md-offset-3 text-center col-sm-12 col-xs-12">
					<!-- flashdata -->
					<?php if ($this->session->flashdata('feedback_success')) { ?>
						<?php $flag = TRUE; ?>
						<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
							<?php $kode_ref = $this->session->flashdata('feedback_success'); ?>
						</div>

					<?php } elseif ($this->session->flashdata('feedback_failed')) { ?>
						<?php $flag = FALSE; ?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-remove"></i> Gagal!</h4>
							<br>
							<?= $this->session->flashdata('feedback_failed') ?>
						</div>
					<?php } ?>
					<!-- end flashdata -->
					<div class="ps-checkout__order">
						<!-- <header></header> -->
						<footer>
							<?php if ($flag) { ?>
								<h3>Selamat, Selangkah lagi Program Belajar Anda akan dimulai</h3>
								<div class="form-group cheque">
									<div class="" style="text-align: left;">
										<h3>Kode Referensi : <?= $kode_ref; ?></h3>
										<br>
										<p>Selanjutnya transaksi anda akan kami verifikasi terlebih dahulu.</p>
										<p>Jika sudah terverifikasi, Tim kami akan menghubungi Anda ke Nomor Telpon</p>
										<p>Apabila hinga 1 hari kerja belum di verifikasi mohon menghubungi kontak kami pada halaman contact. Jangan lupa lampirkan bukti transfer dan kode Referensi anda.</p>
										<p>Terima Kasih</p>
									</div>
								</div>
							<?php } else { ?>
								<h3>Mohon Maaf Pendaftaran anda Gagal</h3>
								<div class="form-group cheque">
									<div class="" style="text-align: left;">
										<p>Jangan khawatir apabila anda terlanjur melakukan transfer. Mohon ikuti Langkah berikut ini : </p>
										<p>1. Silahkan coba kembali untuk melakukan pendaftaran dan upload bukti, kemungkinan tadi ada permasalahan teknis.</p>
										<p>2. Apabila setelah pendaftaran masih muncul pesan gagal, mohon buka menu contact dan hubungi kami via email. Jangan lupa sertakan bukti transfer anda.</p>
										<p>3. Kami akan melakukan proses verifikasi transaksi anda dan menghubungi melalui kontak yang tertera pada laporan anda</p>
										<p>Terima Kasih</p>
									</div>
								</div>
							<?php } ?>
							<div class="form-group paypal">
								<button class="ps-btn ps-btn--fullwidth" onclick="window.location.href='<?=base_url('/home');?>'"> Halaman Utama <i class="fa fa-reply"></i></button>
							</div>
						</footer>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
