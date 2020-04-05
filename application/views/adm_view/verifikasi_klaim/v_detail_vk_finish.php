    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
    		Transaksi
    		<small>Verifikasi Klaim Agen</small>
    	</h1>
    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-dashboard"></i>Data Transaksi</a></li>
    		<li class="active">Verifikasi Klaim Agen Detail</li>
    	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-12">
    			<div class="box">
    				<!-- /.box-header -->
    				<div class="box-body">
    					<div class="table-responsive">
    						<div class="col-xs-12">
    							<h4 style="text-align: center;"><strong>Detail Penjualan</strong></h4>
    						</div>
    						<div class="col-xs-6">
                                <?php 
                                    $arr_nama = explode(',', $hasil_data[0]->nama_lengkap_user);
                                    if (count($arr_nama) == 2) {
                                        $nama_lengkap = $arr_nama[0].' '.$arr_nama[1];
                                    }else if(count($arr_nama) == 3){
                                        $nama_lengkap = $arr_nama[0].' '.$arr_nama[1].' '.$arr_nama[2];
                                    }else if(count($arr_nama) == 4){
                                        $nama_lengkap = $arr_nama[0].' '.$arr_nama[1].' '.$arr_nama[2].' '.$arr_nama[3];
                                    }else{
                                        $nama_lengkap = $arr_nama[0];
                                    } 
                                ?>
    							<h4 style="text-align: left;">Agen : <?php echo $nama_lengkap; ?></h4>
    						</div>
    						<div class="col-xs-6">
    							<h4 style="text-align: right;">Tanggal Klaim: <?php echo date('d-m-Y', strtotime($hasil_data[0]->tgl_klaim)); ?></h4>
    						</div>
    						<hr>
    						<table id="tabelDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
    							<thead>
    								<tr>
                                        <th style="width: 5%; text-align: center;">No</th>
    									<th style="width: 20%; text-align: center;">Laba Agen</th>
    									<th style="width: 10%; text-align: center;">Kode Ref Trans</th>
    									<th style="width: 10%; text-align: center;">Kode Ref Klaim</th>
    									<th style="width: 20%; text-align: center;">Customer</th>
    								</tr>
    							</thead>
    							<tbody>
    								<?php if ($hasil_data) : ?>
										<?php
                                        $no = 1;
                                        $total_klaim = 0;
                                        foreach ($hasil_data as $key => $value) { 
                                            $total_klaim += $value->laba_agen_total; ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td>
                                                    <div>
                                                        <span class="pull-left">Rp. </span>
                                                        <span class="pull-right"><?= number_format((($value->laba_agen_total)), 2, ",", "."); ?></span>
                                                    </div>
                                                </td>
                                                <td align="center"><?php echo $value->kode_ref; ?></td>
                                                <td align="center"><?php echo $value->kode_klaim; ?></td>                                  
                                                <td align="center"><?php echo $value->nama_lengkap; ?></td>
                                            </tr>
                                        <?php 
                                            $no++;
                                        } 
                                        ?>
                                            <tr>
                                                <td colspan="4" align="center"><strong>Total Klaim</strong></td>
                                                <td colspan="1">
                                                    <div>
                                                        <span class="pull-left"><strong>Rp. </strong></span>
                                                        <span class="pull-right"><strong><?= number_format($total_klaim, 2, ",", "."); ?></strong></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="center">
                                                    <?php echo '<img src="' . base_url() . '/assets/img/bukti_verifikasi/' . $gambar . '" width="400" height="400">'; ?>
                                                </td>
                                            </tr>
    								<?php endif ?>
    							</tbody>
    						</table>

    						
							<hr>
    						<div style="padding-top: 30px; padding-bottom: 10px;">
    							<a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
    							<?php $id = $this->uri->segment(4); ?>
    							<?php $link_print = site_url('verifikasi_klaim/cetak/') . $id; ?>
    							<?php echo '<a class="btn btn-sm btn-success" href="' . $link_print . '" title="Print" id="btn_print_pengeluaran_detail" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>'; ?>
    						</div>
    					</div>
    				</div>
    				<!-- /.box-body -->
    			</div>
    			<!-- /.box -->
    		</div>
    	</div>
    </section>
    <!-- /.content -->
