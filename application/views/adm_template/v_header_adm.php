<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Web Admin Majang Dapat Uang Cash">
	<meta name="author" content="Web Admin Majang Dapat Uang Cash | Cipto Junaedy">
	<meta name="dmenk-toko-online-ecommerce" content="">

	<title>
		Web Admin Majang Dapat Uang
	</title>

	<meta name="dmenk-toko-online-ecommerce" content="">

	<link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="<?php echo base_url('assets/'); ?>img/logo.png" />

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/bootstrap.min.css">
	<!-- jquery-ui.css -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>jQueryUI/themes/base/jquery-ui.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/font-awesome.min.css">
	<!-- font google -->
	<link href='https://fonts.googleapis.com/css?family=Carter One' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Charm' rel='stylesheet'>
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/skins/skin-black.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>datepicker/datepicker3.css">
	<!-- select2 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>select2-bootstrap-theme-master/dist/select2-bootstrap.min.css">
	<!-- datatable -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>datatables/dataTables.bootstrap.css">
	<!-- css custom -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/custom.css">
	<!-- css notifikasi -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/notifikasi.css">

	<?php
	//load file css per modul
	if (isset($css)) {
		$this->load->view($css);
	} ?>

	<?php
	//load file css per modul
	if (isset($css_adm)) {
		echo $css_adm;
	} ?>
</head>
<!-- configure skin theme in body class -->

<body class="hold-transition skin-black sidebar-mini">
	<div class="wrapper">
		<!-- <div id="all"> -->
		<!-- Content Wrapper. Contains page content -->
		<!-- *** NAVBAR *** -->
		<!--  _________________________________________________________ -->

		<?php echo $navbar; ?>
		<!-- /#navbar -->

		<!-- *** SIDEBAR *** -->
		<!--_________________________________________________________ -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<?php echo $tampil_menu; ?>
			</section>
		</aside>
		<!-- /#sidebar -->
		<!-- Left side column. contains the logo and sidebar -->
		<!-- Content Wrapper. Contains page content -->


		<!-- content -->
		<!-- load content from controller -->
		<!-- cek id level to unset notif stok if true -->
		<div class="content-wrapper">
			<!-- loader -->
			<div id="CssLoader" class="hidden">
				<div class='spinftw'></div>
			</div>
			<!-- end loader -->
			<?php if ($this->session->flashdata('cek_stok')) { ?>
				<div class="alert alert-danger" style="height: 45px; margin: 0px;">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<strong>
						<p class="icon fa fa-warning" align="center"> Peringatan : <?php echo $this->session->flashdata('cek_stok'); ?></p>
					</strong>
				</div>
			<?php } ?>
