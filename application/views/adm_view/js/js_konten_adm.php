<!-- DataTables -->
<script src="<?= config_item('assets') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= config_item('assets') ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/summernote/dist/summernote.js"></script>
<script src="<?php echo base_url('assets/plugins/pdfobject.min.js')?>"></script>


<script type="text/javascript">
	var save_method; //for save method string
	var table;
    var container = $("#preview");
    //PDFObject.embed("<?php echo base_url()?>home/", container);

	$(document).ready(function() {
		$('.mask-currency').maskMoney({
			precision: 0
		});

        
        $('.summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
            height: 300,
        });

        PDFObject.embed("<?php echo base_url()?>home/", container);
		//mask money edit
		if ($('#id').val() != "") {
			$('#harga').maskMoney('mask', parseInt($('#harga_raw').val()));
		}

		//datatables
		table = $('#tabelProduk').DataTable({

			"processing": true, //feature control the processing indicator
			"serverSide": true, //feature control DataTables server-side processing mode
			"order": [], //initial no order

			//load data for table content from ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/master_produk_adm/list_data') ?>",
				"type": "POST"
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

		$(".gambar").change(function() {
			//console.log(this);
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

	function save() {
		// $('#btnSave').text('saving...'); //change button text
		// $('#btnSave').attr('disabled', true); //set button disable 
		var url;
		// save_method = method;

		
		url = "<?php echo site_url('admin/master_konten_adm/add_konten') ?>";
			

		// Get form
		let form = $('#form')[0];
		let data = new FormData(form);

		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: "JSON",
			processData: false,
			contentType: false,
			success: function(data) {

				if(data.STATUS == 'berhasil'){
                    alert(data.MESSAGE);
                    window.location.href = "<?= base_url('/admin/master_konten_adm'); ?>";
                }else{
                    alert('gagal');
                }
					
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 

			}
		});
	}

	function delete_user(id) {
		if (confirm('Are you sure delete this data?')) {
			// ajax delete data to database
			$.ajax({
				url: "<?php echo site_url('pengguna/delete_pengguna') ?>/" + id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					//if success reload ajax table
					$('#modal_form').modal('hide');
					alert(data.pesan);
					reload_table();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				}
			});

		}
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
