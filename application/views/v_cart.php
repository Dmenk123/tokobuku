  <main class="ps-main">
      <div class="ps-content pt-80 pb-80">
        <div class="ps-container">
          <div class="ps-cart-listing">
            <table class="table ps-cart__table">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Harga Satuan</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="detail_cart">
              </tbody>
            </table>
            <div class="ps-cart__actions summary_cart">
            </div>
          </div>
        </div>
      </div>
    </main>

    <script>
      $(document).ready(function() {
        // Load shopping cart
        $('#detail_cart').load("<?php echo site_url('cart/load_cart'); ?>");
        // Load summary cart
        $('.summary_cart').load("<?php echo site_url('cart/load_summary'); ?>");

        $(document).on('click','.hapus_cart',function(){
            if(confirm('Yakin hapus item terpilih ?')){
                var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
                $.ajax({
                    url : "<?php echo site_url('cart/hapus_cart') ?>",
                    method : "POST",
                    data : {row_id : row_id},
                    success :function(data){
                        $('#detail_cart').html(data);
                        location.reload();
                    }
                });
            }
        });

        $(document).on('change','.cart_qty',function(){
            var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
            var qty = $(this).val(); //mengambil value
            $.ajax({
                url : "<?php echo site_url('cart/update_cart') ?>",
                method : "POST",
                data : {row_id : row_id, qty : qty},
                success :function(data){
                    $('#detail_cart').html(data);
                    location.reload();
                }
            });
        });
      });
    </script>