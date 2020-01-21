   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Dashboard
         <small><strong>Selamat Datang : <?php foreach ($data_user as $val) {
            echo $val->nama_lengkap_user;
         } ?></strong></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">Dashboard</li>
      </ol>
   </section>

   <!-- Main content -->
   <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="box">
         <div class="box-body">
            <div class="row">
            </div>
            <!-- ./row -->
         </div>
      </div>       
   </section>
   <!-- /.content -->
