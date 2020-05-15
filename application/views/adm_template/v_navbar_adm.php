<header class="main-header">
	<!-- Logo -->
	<a href="<?php echo site_url('home'); ?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><img src="<?php echo base_url('assets/img/logo_thumb.png'); ?>"></span>
		<!-- logo for regular state and mobile devices -->
		<!-- <span class="logo-lg"><img src="<?php echo base_url('assets/img/logo-login-page.png'); ?>"></span> -->

		<span class="logo-lg" style="color:white;
                font-family:Charm;
                font-size: 20px;
                text-align: center;">
			<strong>Web Adminstrator</strong>
		</span>
	</a>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- custom menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php foreach ($data_user as $val) { ?>
							<span class="hidden-xs" style="padding: 30px;"><?php echo $val->nama_lengkap_user; ?></span>
						<?php } ?>
					</a>
					<ul class="dropdown-menu">

						<!-- User image -->
						<li class="user-header">
							<?php foreach ($data_user as $val) { ?>
								<img src="<?php echo config_item('assets'); ?>img/foto_profil/<?php echo $val->gambar_user; ?>" class="img-circle" alt="User Image">
								<p><?php echo $val->nama_lengkap_user; ?></p>
							<?php } ?>
						</li>

						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<?php $id_user = $this->session->userdata('id_user'); ?>
								<a href='<?php echo site_url("admin/master_user/edit_user/$id_user"); ?>' class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="javascript:void(0);" onclick="logout_proc()" class="btn btn-default btn-flat">Logout</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- notifikasi -->
		<div class="navbar-custom pull-right">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i>
						<?php if ($qty_notif > 0) { ?>
							<span class="badge badge-danger" id="load_row"><?php echo $qty_notif; ?></span>
						<?php } ?>
					</a>
					<?php $no = 0;
					if (count($isi_notif) > 0) { ?>
						<?php $link = site_url('inbox/index'); ?>
						<ul class="dropdown-menu" role="menu" id="load_data">
							<?php foreach ($isi_notif as $notif) {
								$no++;
								if ($no % 2 == 0) {
									$strip = 'strip1';
								} else {
									$strip = 'strip2';
								} ?>
								<li>
									<a href="#" class="<?php echo $strip; ?> linkNotifKlaim" id="<?php echo $notif->id; ?>">
										<?php echo "Kode Ref : ".$notif->kode_klaim; ?> <br>
										<small>
											<strong>Rp. <?php echo number_format($notif->jumlah_klaim , 0, ",", "."); ?></strong> (<?php echo timeAgo(strtotime($notif->datetime_klaim)); ?>)</small>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</li>
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i>
						<?php if ($qty_notif2 > 0) { ?>
							<span class="badge badge-danger" id="load_row2"><?php echo $qty_notif2; ?></span>
						<?php } ?>
					</a>
					<?php $no = 0;
					if (count($isi_notif2) > 0) { ?>
						<?php $link = site_url('inbox/index'); ?>
						<ul class="dropdown-menu" role="menu" id="load_data2">
							<?php foreach ($isi_notif2 as $notif) {
								$no++;
								if ($no % 2 == 0) {
									$strip = 'strip1';
								} else {
									$strip = 'strip2';
								} ?>
								<li>
									<a href="#" class="<?php echo $strip; ?> linkNotifPenjualan" id="<?php echo $notif->id; ?>">
										<?php echo 'Program belajar a/n '.$notif->nama_depan; ?> <br>
										<small>
											<strong>Rp. <?php echo number_format($notif->harga_total, 0, ",", "."); ?></strong> (<?php echo timeAgo(strtotime($notif->created_at)); ?>)</small>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</li>
			</ul>
		</div>
	</nav>
</header>
