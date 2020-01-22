<script type="text/javascript">
	var save_method; //for save method string
	var table;

$(document).ready(function() {

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

	//datatables
	table = $('#tabelRole').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('admin/set_role_adm/list_role') ?>",
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

  

    //datepicker
    $("[name='userTgllhr']").datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_user')[0].reset();
    });

    //change user status
    $(document).on('click', '.btn_edit_status', function(){
        if(confirm('Apakah anda yakin ubah status Role ini ?'))
        {
            var id = $(this).attr('id');
            var status = $(this).text();
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('admin/set_role_adm/edit_status_role')?>/"+id,
                type: "POST",
                dataType: "JSON",
                data : {status : status},
                success: function(data)
                {
                    alert(data.pesan);
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error remove data');
                }
            });
        }   
    });

});	

function add_user()
{
    save_method = 'add';
	$('#modal_user_form').modal('show'); //show bootstrap modal
	$('.modal-title').text('Add User'); //set title modal
}


function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}
</script>	
