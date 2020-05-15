</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Powered by : adminLTE</b>
	</div>
	<strong>Copyright &copy; 2020 Cipto Junaedy </strong> All rights
	reserved.
</footer>

<!-- *** FOOTER END *** -->
</div>
<!-- ./wrapper -->

<?php
if (isset($modal)) {
	echo $modal;
} ?>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/'); ?>jQuery/jquery-2.2.3.min.js"></script>
<!-- jquery validation -->
<script src="<?php echo base_url('assets/'); ?>adminlte/js/jquery-validation.js"></script>
<!-- jQuery UI  -->
<script src="<?php echo base_url('assets/'); ?>jQueryUI/jquery-ui.min.js"></script>
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/'); ?>bootstrap/js/bootstrap.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/'); ?>sparkline/jquery.sparkline.min.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/'); ?>datepicker/bootstrap-datepicker.js"></script>
<!-- select2 -->
<script src="<?php echo base_url('assets/'); ?>select2/dist/js/select2.min.js"></script>
<!-- chartjs -->
<script src="<?php echo base_url('assets/'); ?>chartjs/Chart.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/'); ?>slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/'); ?>fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/'); ?>adminlte/app.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url('assets/') ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/') ?>js/sweetalert.min.js"></script>
<script src="<?php echo base_url('assets/') ?>js/jquery-maskmoney.min.js"></script>
<script src="<?php echo base_url('assets/') ?>js/jquery.rowspanizer.min.js"></script>
<!-- load js per modul -->
<?php
if (isset($js)) {
	echo $js;
} ?>

<span class="hidden" id="base_url"><?php echo base_url(); ?></span>
<!-- <script src="<?php echo base_url('assets'); ?>/jsModul/modal.js"></script> -->

<script>
	var baseUrl = "<?= base_url();?>";

	$(document).ready(function() {
		
		$(document).on('click', '.linkNotifKlaim', function() {
			var id = $(this).attr('id');
			$.ajax({
				url: baseUrl+"admin/dashboard/get_klaim_agen/"+id,
				type: "GET",
				dataType: "JSON",
				success: function(data) {
					location.href = baseUrl+"admin/verifikasi_klaim/verifikasi_detail/"+id+"/"+data.bulan+"/"+data.tahun;
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Terjadi Kesalahan Notifikasi Klaim Agen');
				}
			});
		});

		$(document).on('click', '.linkNotifPenjualan', function() {
			var id = $(this).attr('id');
			$.ajax({
				url: baseUrl+"admin/dashboard/get_penjualan/"+id,
				type: "GET",
				dataType: "JSON",
				success: function(data) {
					location.href = baseUrl+"admin/penjualan/penjualan_detail/"+id+"/1/"+data.bulan+"/"+data.tahun;
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Terjadi Kesalahan Notifikasi Penjualan');
				}
			});
		});
	});
	//end jquery

	// setInterval(function(){
	//   $("#load_row").load('<?= base_url() ?>inbox_adm/load_email_row_notif')
	// }, 10000); //menggunakan setinterval jumlah notifikasi akan selalu update setiap 10 detik diambil dari controller notifikasi fungsi load_row

	// setInterval(function(){
	//     $("#load_data").load('<?= base_url() ?>inbox_adm/load_email_data_notif')
	// }, 10000); //yang ini untuk selalu cek isi data notifikasinya sama setiap 10 detik diambil dari controller notifikasi fungsi load_data

	//fix to issue select2 on modal when opening in firefox, thanks to github
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	// $.fn.select2.defaults.set("theme", "bootstrap");
	$('.select2').select2({
		theme: "bootstrap"
	});

	//force integer input in textfield
    $('input.numberinput').bind('keypress', function(e) {
      return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    function logout_proc() {
		swal({
	      	title: "Logout",
	      	text: "Apakah Anda Yakin ingin Logout!",
	      	icon: "warning",
	      	buttons: [
	        	'Tidak',
	        	'Ya'
	      	],
	      	dangerMode: true,
	    	}).then(function(isConfirm) {
	      		if (isConfirm) {
	        		$.ajax({
						url: baseUrl + 'admin/login/logout_proc',
						type: 'POST',
						dataType: "JSON",
						success: function (data) {
							swal("Logout", 'Anda berhasil logout', "success").then(function() {
							    window.location.href = baseUrl + 'admin/dashboard';
							});
						}
					});
	      		} else {
	        		swal("Batal", "Aksi dibatalkan", "error");
	     	 	}
			});
	}
</script>

</body>

</html>
