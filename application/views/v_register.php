<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a>
         </li>
         <li><?php echo $this->uri->segment(1); ?></li>
      </ul>
   </div><!-- /.col -->

   <div class="col-md-6">
      <div class="box">
         <h1>Register</h1>
         <p class="lead">Anda apakah saat ini belum memiliki akun ?</p>
         <p>Silahkan daftar akun baru untuk memulai belanja, dan dapatkan keuntungan dengan mendapatkan diskon yang menarik</p>
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
            </div>
            <div class="text-center">
               <input type="submit" value="Register" id="btnRegister" class="btn btn-primary"/>
            </div>
         </form>
         
      </div><!-- /.box -->
   </div><!-- /.col -->

   <div class="col-md-6">
      <div class="box">
         <h1>Login</h1>
         <p class="lead">Sudah memiliki akun ?</p>
         <p class="text-muted">Silahkan mengisi email dan password anda pada form yang tersedia untuk mulai belanja.</p>
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
         </div>
      </div><!-- /.box -->
   </div><!-- /.col -->
</div><!-- /.container -->


<script>
  $(document).ready(function() {
    $('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'register/refresh_captcha'; ?>', function(data){
            $('#imgCaptcha').html(data);
        });
    });

    $("#btnRegister").click(function (event) {
        event.preventDefault();
        var form = $('#form_register')[0];
        var data = new FormData(form);
        $("#btnRegister").prop("disabled", true);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo site_url('register/add_register'); ?>",
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
                window.location.href = "<?php echo site_url('home'); ?>";
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
</script>