<main class="ps-main">
      <div class="ps-checkout pt-80 pb-80">
        <div class="ps-container">
          <!-- flashdata -->
          <?php if ($this->session->flashdata('feedback_success')) { ?>
          <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <?= $this->session->flashdata('feedback_success') ?>
          </div>

          <?php } elseif ($this->session->flashdata('feedback_failed')) { ?>
          <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-remove"></i> Gagal!</h4>
          <?= $this->session->flashdata('feedback_failed') ?>
          </div>
          <?php } ?>
          <!-- end flashdata -->
          <form action="<?= base_url('checkout/add_data');?>" method="post" enctype="multipart/form-data" class="ps-checkout__form">
            <div class="row">
                  <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
                    <div class="ps-checkout__billing">
                      <h3>Detail Pembelian</h3>
                      <div class="form-group form-group--inline">
                        <label>Nama Depan<span>*</span>
                        </label>
                        <input class="form-control" type="text" name="fname" id="fname" value="<?= $nama_depan; ?>">
                      </div>
                      <div class="form-group form-group--inline">
                        <label>Nama Belakang
                        </label>
                        <input class="form-control" type="text" name="lname" id="lname" value="<?= $nama_belakang; ?>">
                      </div>
                      <div class="form-group form-group--inline">
                        <label>Email<span>*</span>
                        </label>
                        <input class="form-control" type="email" name="email" id="email" value="<?= $userdata->email; ?>">
                      </div>
                      <div class="form-group form-group--inline">
                        <label>No. Telepon<span>*</span>
                        </label>
                        <input class="form-control" type="text" name="telp" id="telp" value="<?= $userdata->no_telp_user; ?>">
                      </div>
                      <h3 class="mt-40"> Informasi Tambahan</h3>
                      <div class="form-group form-group--inline textarea">
                        <label>Catatan Pemesanan</label>
                        <textarea class="form-control" rows="5" name="catatan" id="catatan" placeholder="Misal: Hadiah dari Mas Bram kepada Dek Shinta (Kirim ke email shintacute@gmail.com)"></textarea>
                      </div>

                      <h3 class="mt-40"> Upload Bukti Transfer</h3>
                      <div class="form-group form-group--inline">
                        <label>Upload Bukti</label><span>*</span>
                        <input type="file" class="form-control-file" name="bukti" id="bukti" accept=".png, .jpg, .jpeg">
                      </div>
                      <div class="form-group">
                        <img id="bukti-img" src="" alt="" height="360" width="300" class="pull-right" />
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
                    <div class="ps-checkout__order">
                      <header>
                        <h3>Pesanan Anda</h3>
                      </header>
                      <div class="content">
                        <table class="table ps-checkout__products">
                          <thead>
                            <tr>
                              <th class="text-uppercase">Produk</th>
                              <th class="text-uppercase">Qty</th>
                              <th class="text-uppercase">Total</th>
                            </tr>
                          </thead>
                          <tbody id="detail_cart"></tbody>
                        </table>
                        <div class="ps-cart__actions summary_cart"></div>
                      </div>
                      <footer>
                        <h3>Metode Pembayaran / Transfer</h3>
                        <div class="form-group cheque">
                          <div class="">
                            <p>Dimohon Transfer Ke Rekening Dibawah Ini Serta Melampirkan Upload Bukti Transfer.</p>
                            <p>BCA : BAPAK WILLIAM - 014-1231212-12121</p>
                            <p>MANDIRI : BAPAK WILLIAM - 021-1231212-12121</p>
                            <p>BANK OF INDIA : BAPAK WILLIAM - 666-1231212-12121</p>
                          </div>
                        </div>
                        <div class="form-group paypal">
                          <button class="ps-btn ps-btn--fullwidth">Konfirmasi & Selesai<i class="ps-icon-next"></i></button>
                        </div>
                      </footer>
                    </div>
                    <div class="ps-shipping">
                      <h3>PERLU ANDA KETAHUI</h3>
                      <p>Ketika Anda Selesai Melakukan Proses Checkout ini.<br> <a href="#"> Klik Disini </a> Untuk Memantau Status Pemesanan Anda, Atau pada Menu Profile Anda.</p>
                    </div>
                  </div>
            </div>
          </form>
        </div>
      </div>
    </main>

     <script>
      $(document).ready(function() {
        // Load shopping cart
        $('#detail_cart').load("<?php echo site_url('checkout/load_cart'); ?>");
        // Load summary cart
        $('.summary_cart').load("<?php echo site_url('checkout/load_summary'); ?>");

        $("#bukti").change(function() {
          //console.log(this);
          var id = this.id;
          readURL(this, id);
        });
      });

      function readURL(input, id) {
        var idImg = id + '-img';
        // console.log(idImg);
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
