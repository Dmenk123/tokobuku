<style>
    #wrapper{width:100%; height:400px; border:1px solid black;}
    button{height:35px; position:relative; margin: -20px -50px; width:150px; top:50%; left:50%;}
</style>
<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a>
         </li>
         <li>Affiliate</li>
      </ul>
   </div><!-- /.col -->

   <div class="col-md-12" >
      <div class="box" style="padding-bottom:50px; padding-top:50px;">
        <button class="btn btn-success" onclick="cek_link()">Tampilkan Link</button>
        <br>
        <div>
            <h4 id="text_link" class="text-center"></h4>
        </div>
      </div><!-- /.box -->
   </div><!-- /.col -->
</div>



<script>
  $(document).ready(function() {
    $('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'register/refresh_captcha'; ?>', function(data){
            $('#imgCaptcha').html(data);
        });
    });

    // var kode = <?php $this->session->userdata('kode_agen') ?>;

    $('#register').hide();

    $("#btnRegister").click(function (event) {
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
            success: function (data) {
                if (data.status) {
                    alert(data.pesan);
                    $("#btnRegister").prop("disabled", false);
                    window.location.href = "<?php echo site_url('home'); ?>";
                }else{
                  if (data.flag_captcha) {
                    alert(data.pesan);
                    $("#btnRegister").prop("disabled", false);
                  }else{
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
            error: function (e) {
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
        success: function (data) {
            if (data.status) {
                alert(data.pesan);
                $("#btnLogin").prop("disabled", false);
                window.location.href = "<?php echo site_url('affiliate'); ?>";
            }else{
              if (data.flag_alert) {
                alert(data.pesan);
              }else{
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
        error: function (e) {
            console.log("ERROR : ", e);
            $("#btnRegister").prop("disabled", false);
        }
    });
  }

  function cek_link() {
    var kode = "<?php echo $this->session->userdata['kode_agen']?>";
    $("#text_link").text('<?php echo base_url()?>'+'product_listing/list_produk/'+kode);
  }
</script>