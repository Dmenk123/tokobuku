<!-- DataTables -->
<script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
	var save_method; //for save method string
	var table;
	var table2;
	var bulan;
	var tahun;


	$(document).ready(function() {
		//tabs
	    var hash = window.location.hash;
	    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

	    $('.nav-tabs a').click(function(e) {
	      $(this).tab('show');
	      var scrollmem = $('body').scrollTop();
	      window.location.hash = this.hash;
	      $('html,body').scrollTop(scrollmem);
	    });

		$('.mask-currency').maskMoney({
			precision: 0
		});

		<?php if ($this->input->get('bulan') != '' && $this->input->get('tahun') != '') { ?>
			bulan = <?= $this->input->get('bulan'); ?>;
			tahun = <?= $this->input->get('tahun'); ?>;
		<?php }else if(isset($bulan)){ ?>
			bulan = <?= $bulan; ?>;
			tahun = <?= $tahun; ?>;
		<?php } ?>

		//mask money edit
		if ($('#id').val() != "") {
			$('#harga').maskMoney('mask', parseInt($('#harga_raw').val()));
		}

		// tabel penjualan progress
		table = $('#tabelKlaim').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [
				[2, 'desc']
			],
			//load data for table content from ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/verifikasi_klaim/list_klaim/') ?>",
				"type": "POST",
				"data" : {status:null, bulan:bulan, tahun:tahun}
			},

			//set column definition initialisation properties
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],
		});

		// tabel penjualan finish
		table2 = $('#tabelKlaimFinish').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [
				[2, 'desc']
			],
			//load data for table content from ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/verifikasi_klaim/list_klaim/') ?>",
				"type": "POST",
				"data" : {status:'1', bulan:bulan, tahun:tahun}
			},

			//set column definition initialisation properties
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],
		});

		//set input/textarea/select event when change value, remove class error and remove text help block
		$("input").change(function() {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});

		//update dt_read after click
		/*$(document).on('click', '.linkNotif', function(){
		    var id = $(this).attr('id');
		    $.ajax({
		        url : "<?php echo site_url('inbox/update_read/') ?>/" + id,
		        type: "POST",
		        dataType: "JSON",
		        success: function(data)
		        {
		            location.href = "<?php echo site_url('inbox/index') ?>";
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		});*/

		$(".bukti").change(function() {
			var id = this.id;
			readURL(this, id);
		});
	});

	function hargaRaw() {
		var harga = $('#harga').maskMoney('unmasked')[0];
		$('#harga_raw').val(harga);
	}

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}

	function save(method) {
		$('#btnSave').text('saving...'); //change button text
		$('#btnSave').attr('disabled', true); //set button disable 
		var url;
		save_method = method;

		if (save_method == 'add') {
			url = "<?php echo site_url('admin/master_produk_adm/add_data') ?>";
			tipe_simpan = 'tambah';
		} else {
			url = "<?php echo site_url('admin/master_produk_adm/update_data') ?>";
			tipe_simpan = 'update';
		}

		// Get form
		let form = $('#form')[0];
		let data = new FormData(form);

		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			enctype: 'multipart/form-data',
			data: data,
			dataType: "JSON",
			processData: false,
			contentType: false,
			success: function(data) {

				if (data.status) {
					window.location.href = "<?= base_url('/admin/master_produk_adm'); ?>";
				} else {
					for (var i = 0; i < data.inputerror.length; i++) {
						if (data.inputerror[i] != 'jabatan') {
							$('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
							$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
						} else {
							$($('#jabatan').data('select2').$container).addClass('has-error');
						}
					}
				}

				$('#btnSave').text('save');
				$('#btnSave').attr('disabled', false);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 

			}
		});
	}

	function verify() {
		swal({
	      	title: "Konfirmasi Penjualan",
	      	text: "Apakah Anda Yakin ingin Konfirmasi Penjualan!",
	      	icon: "warning",
	      	buttons: [
	        	'Tidak',
	        	'Ya'
	      	],
	      	//dangerMode: true,
	    	}).then(function(isConfirm) {
	      		if (isConfirm) {
	      			 // Get form
				    let form = $('#formVerify')[0];
				    let data = new FormData(form);
	        		$.ajax({
						url: baseUrl + 'admin/verifikasi_klaim/konfirmasi/'+bulan+'/'+tahun,
				        enctype: 'multipart/form-data',
				        type: "POST",
				        data: data,
				        dataType: "JSON",
				        processData: false,
				        contentType: false,
						success: function (data) {
							
							if (data.status) {
								swal("Sukses", 'Anda berhasil konfirmasi Klaim Agen', "success").then(function() {
								    window.location.href = baseUrl + 'admin/verifikasi_klaim?bulan='+data.bulan+'&tahun='+data.tahun+'#tab_progress';
								});
							}else{
								swal("Gagal", 'Gagal Konfirmasi Klaim Agen, Coba Lagi Nanti..', "error").then(function() {
								    window.location.href = baseUrl + 'admin/verifikasi_klaim?bulan='+data.bulan+'&tahun='+data.tahun+'#tab_progress';
								});
							}
						}
					});
	      		} else {
	        		swal("Batal", "Aksi dibatalkan", "error");
	     	 	}
			});
	}

	function batalkanVerify(id) {
		swal({
	      	title: "Batalkan Verifikasi",
	      	text: "Ketika dibatalkan, dapat diverifikasi ulang nantinya",
	      	icon: "warning",
	      	buttons: [
	        	'Tidak',
	        	'Ya'
	      	],
	      	dangerMode: true,
	    	}).then(function(isConfirm) {
	      		if (isConfirm) {
	        		$.ajax({
						url: baseUrl + 'admin/penjualan/batal_verify/'+id+'/'+bulan+'/'+tahun,
						type: 'POST',
						dataType: "JSON",
						success: function (data) {
							if (data.status) {
								swal("Sukses", 'Anda berhasil Membatalkan Verifikasi', "success").then(function() {
								    location.reload(true);
								});
							}else{
								swal("Gagal", 'Gagal Membatalkan Penjualan, Coba Lagi Nanti..', "error").then(function() {
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
</script>
