<!-- DataTables -->
<script src="<?=base_url('assets/')?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
	var save_method; //for save method string
	var table;

$(document).ready(function() {
	//datatables
	table = $('#tabelUser').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('admin/master_user/list_user') ?>",
			"type": "POST" 
		},

		//set column definition initialisation properties
		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],
	});

	//set input/textarea/select event when change value, remove class error and remove text help block
	$("input").change(function() {
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});
    
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


    $('#resetpwd').change(function() {
        if (this.checked) {
            $('#password').attr('readonly', true).css('background-color', "#8a8991");
            $('#repassword').attr('readonly', true).css('background-color', "#8a8991");
            $('#passwordnew').attr('readonly', true).css('background-color', "#8a8991");
            $('#ceklistpwd').prop('checked', true);
        } else {
            $('#password').attr('readonly', false).css('background-color', "#e8f0fe");
            $('#repassword').attr('readonly', false).css('background-color', "#e8f0fe");
            $('#passwordnew').attr('readonly', false).css('background-color', "#e8f0fe");
            $('#ceklistpwd').prop('checked', false);
        }
    });

});	

function add_user() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    
    var url;
    url = "<?php echo site_url('admin/master_user/add_data') ?>";
    
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
                window.location.href = "<?= base_url('/admin/master_user'); ?>";
            } else {
                if(data.password_beda){
                    alert('Password tidak sama !!!');
                }else{
                    for (var i = 0; i < data.inputerror.length; i++) {
                        if (data.inputerror[i] != 'jabatan') {
                            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        } else {
                            $($('#jabatan').data('select2').$container).addClass('has-error');
                        }
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

function update_profil() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    
    var url;
    url = "<?php echo site_url('admin/master_user/update_data') ?>";
    
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
                window.location.href = "<?= base_url('/admin/master_user'); ?>";
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

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pengguna/add_pengguna')?>";
        tipe_simpan = 'tambah';
    } else {
        url = "<?php echo site_url('pengguna/update_pengguna')?>";
        tipe_simpan = 'update';
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                if (tipe_simpan == 'tambah') {
                  alert(data.pesan_tambah);
                } 
                else
                {
                  alert(data.pesan_update);
                }

                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

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
