<html><head>
  <title><?php echo $title; ?></title>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/css/bootstrap.min.css'); ?>">
  <style type="text/css">
    .main-area {
      margin-left: 50px;
      margin-right: 50px;
    }

    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 5px;
    }
    .short{
      width: 50px;
    }
    .normal{
      width: 150px;
    }
    .tbl-outer{
      color:#070707;
      margin-bottom: 10px;
    }

    .text-center{
      text-align:center;
    }

    .text-left{
      text-align:left;
    }

    .text-right{
      text-align:right;
    }
    
    .outer-left{
      padding: 2px;
      border: 0px solid white;
      border-color: white;
      margin: 0px;
      background: white;
    }
    .head-left{
      padding-top: 5px;
      padding-bottom: 0px;
      border: 0px solid white;
      border-color: white;
      margin: 0px;
      background: white;
    }
    .tbl-footer{
      width: 100%;
      color:#070707;
      border-top: 0px solid white;
      border-color: white;
      padding-top: 75px;
    }
    .head-right{
       padding-bottom: 0px;
       border: 0px solid white;
       border-color: white;
       margin: 0px;
    }
    .tbl-header{
      width: 100%;
      color:#070707;
      border-color: #070707;
      border-top: 2px solid #070707;
    }
    #tbl_content{
      padding-top: 10px;
      /*margin-left: -20px;*/
    } 
    .tbl-footer td{
      border-top: 0px;
      padding: 10px;
    }
    .tbl-footer tr{
      background: white;
    }
    .foot-center{
      padding-left: 70px;
    }
    .inner-head-left{
       padding-top: 20px;
       border: 0px solid white;
       border-color: white;
       margin: 0px;
       background: white;
    }
    .tbl-content-footer{
      width: 100%;
      color:#070707;
      padding-top: 0px;
    }
    table{
      border-collapse: collapse;
      font-family: arial;
      color:black;
      font-size: 12px;
    }

    thead th{
      text-align: center;
      padding: 10px;
      font-style: bold;
    }
    tbody td{
      padding: 10px;
    }
    /*tbody tr:nth-child(even){
      background: #F6F5FA;
    }
    tbody tr:hover{
      background: #EAE9F5
    }*/
    .clear{
        clear:both;
    }

  </style>
</head><body>
  <div class="main-area">   
    <h2 style="text-align: center;"><strong>Laporan Komisi Agen</strong></h2>
    
    <table class="tbl-header">
      <tr>
        <td align="center" class="head-center">
          <p style="text-align: center; font-size: 14px" class="head-left"><strong>Periode <?php echo $periode; ?></strong></p>
        </td>
      </tr> 
    </table>
    <div class="col-md-12">
      <p>Nama Agen : <?=$data_user_agen[0]->nama_lengkap_user;?> </p>
      <p>Email Agen : <?=$data_user_agen[0]->email;?> </p>
      <p>Rekening Agen : <?=$data_user_agen[0]->bank.' - '.$data_user_agen[0]->rekening;?> </p>
    </div>
    <table id="tbl_content" class="table table-bordered" cellspacing="0" width="100%" border="2">
      <thead>
        <tr>
          <th style="width: 10%; text-align: center;">Tgl Checkout</th>
          <th style="width: 15%; text-align: center;">Nama Agen</th>
          <th style="width: 15%; text-align: center;">Nilai</th>
          <th style="width: 5%; text-align: center;">Kode Ref</th>
          <th style="width: 7%; text-align: center;">Kode Ref Klaim</th>
          <th style="width: 10%; text-align: center;">Tgl Klaim</th>
          <th style="width: 15%; text-align: center;">Nilai Klaim</th>
          <th style="width: 10%; text-align: center;">Tgl Dibayar</th>
          <th style="width: 15%; text-align: center;">Nilai Transfer</th>
        </tr>
      </thead>
      <tbody>
        <?= $hasil_tabel; ?>
      </tbody>
    </table>
    <br><br><br>
    <div class="col-md-12" style="text-align: right;">
      Surabaya, <?= date('d-m-Y H:i').' WIB'; ?>
      <br><br><br><br><br><br>


      <span style="margin-right: 3%;"><?= $data_user[0]->nama_lengkap_user; ?></span>
    </div>
  </div>          
</body>
</html>