    <main class="ps-main">
      <div class="ps-products-wrap pt-80 pb-80">
        <div class="ps-products" data-mh="product-listing">
          <div class="ps-product-action">
            
            <div class="ps-product__filter">
              <select class="ps-select selectpicker" id="sorting">
                <option value="">Urutkan</option>
                <option value="nama_asc" <?php if($this->input->get('sort') == 'nama_asc') { echo "selected"; } ?>>
                  Nama (A -> Z)
                </option>
                <option value="nama_desc" <?php if($this->input->get('sort') == 'nama_desc') { echo "selected"; } ?>>
                  Nama (Z -> A)
                </option>
                <option value="harga_asc" <?php if($this->input->get('sort') == 'harga_asc') { echo "selected"; } ?>>
                  Harga (Kecil ke Besar)
                </option>
                <option value="harga_desc" <?php if($this->input->get('sort') == 'harga_desc') { echo "selected"; } ?>>
                  Harga (Besar ke Kecil)
                </option>
              </select>
            </div>

            <div class="ps-pagination">
              <ul class="pagination">
              <?php foreach ($links as $link) {
                  echo "<li>". $link."</li>";
              } ?>
              </ul>
              <!-- <ul class="pagination">
                <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">...</a></li>
                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
              </ul> -->
            </div>
          </div>
          <div class="ps-product__columns">
            <?php foreach ($produk as $key => $val): ?>
              <div class="ps-product__column">
                <div class="ps-shoe mb-30">
                  <div class="ps-shoe__thumbnail">
                    <div class="ps-badge"><span>New</span></div>
                    <div class="ps-badge ps-badge--sale ps-badge--2nd"><span>-35%</span></div></a><img src="<?= base_url('assets/img/produk/').$val->gambar_1;?>" alt=""><a class="ps-shoe__overlay" href="<?=base_url('product_detail/detail/').$val->id; ?>"></a>
                  </div>
                  <div class="ps-shoe__content">
                    <div class="ps-shoe__variants">
                      <div class="ps-shoe__variant normal">
                        <img src="<?= base_url('assets/img/produk/').$val->gambar_1;?>" alt="">
                        <img src="<?= base_url('assets/img/produk/').$val->gambar_2;?>" alt="">
                        <img src="<?= base_url('assets/img/produk/').$val->gambar_3;?>" alt="">
                      </div>
                    </div>
                    <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#"><?= $val->nama;?></a>
                     <p class="ps-shoe__categories">
                        <a href="#"><?= $val->nama_kategori; ?></a>
                      </p>
                      <div>
                        <span>
                          <del><?= "Rp ".number_format(((int)$val->harga_satuan+(int)20000),0,',','.');?></del> 
                          <?= "Rp ".number_format($val->harga_satuan,0,',','.');?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>

          <div class="ps-product-action">
            <div class="ps-product__filter">
              <select class="ps-select selectpicker">
                <option value="1">Urutkan</option>
                <option value="2">Nama</option>
                <option value="3">Harga (Kecil ke Besar)</option>
                <option value="3">Harga (Besar ke Kecil)</option>
              </select>
            </div>

            <div class="ps-pagination">

              <ul class="pagination">
              <?php foreach ($links as $link) {
                  echo "<li>". $link."</li>";
              } ?>
              </ul>
              <!-- <ul class="pagination">
                <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">...</a></li>
                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
              </ul> -->
            </div>
          </div>
        </div>


        <div class="ps-sidebar" data-mh="product-listing">
          <aside class="ps-widget--sidebar ps-widget--filter">
            <div class="ps-widget__header">
              <h3>Filter Harga</h3>
            </div>
            <div class="ps-widget__content">
              <div class="ac-slider" data-default-min="10000" data-default-max="5000000" data-max="5000000" data-step="10000" data-unit="Rp"></div>
              <p class="ac-slider__meta">Harga :<span class="ac-slider__value ac-slider__min"></span>-<span class="ac-slider__value ac-slider__max"></span></p><a class="ac-slider__filter ps-btn" href="#">Filter</a>
            </div>
          </aside>
        </div>

      </div>
    </main>

    <script>
      $(document).ready(function() {
        $('#sorting').change(function(event) {
            window.location.href = "<?= base_url('product_listing/index/page/1?sort='); ?>"+$(this).val();
        });
      });
    </script>
     