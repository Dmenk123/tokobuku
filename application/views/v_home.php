    <main class="ps-main">
      <div class="ps-section ps-section--top-sales ps-owl-root pt-80 pb-80">
        <div class="ps-container">
          <div class="ps-section__header mb-50">
            <div class="row">
                  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <h3 class="ps-section__title" data-mask="BEST SALE">Produk Unggulan Kami</h3>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <div class="ps-owl-actions"><a class="ps-prev" href="#"><i class="ps-icon-arrow-right"></i>Prev</a><a class="ps-next" href="#">Next<i class="ps-icon-arrow-left"></i></a></div>
                  </div>
            </div>
          </div>
          <div class="ps-section__content">
            <div class="ps-owl--colection owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="30" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
            <?php foreach ($produk as $key => $val): ?>
              <div class="ps-shoes--carousel">
                <div class="ps-shoe">
                  <div class="ps-shoe__thumbnail">
                    <div class="ps-badge"><span>New</span></div>
                    <div class="ps-badge ps-badge--sale ps-badge--2nd"><span>-35%</span></div>
                    <a class="ps-shoe__favorite" href="#">
                      <i class="ps-icon-heart"></i>
                    </a>
                    <img src="<?= base_url('assets/img/produk/').$val->gambar_1;?>" alt="">
                    <a class="ps-shoe__overlay" href="product-detail.html"></a>
                  </div>
                  <div class="ps-shoe__content">
                    <div class="ps-shoe__variants">
                      <div class="ps-shoe__variant normal">
                        <img src="<?= base_url('assets/img/produk/').$val->gambar_1;?>" alt="">
                        <img src="<?= base_url('assets/img/produk/').$val->gambar_2;?>" alt="">
                        <img src="<?= base_url('assets/img/produk/').$val->gambar_3;?>" alt="">
                      </div>
                    </div>
                    <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detail.html"><?= $val->nama;?></a>
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
          </div>
        </div>
      </div>
      <div class="ps-home-testimonial bg--parallax pb-80" data-background="images/background/parallax.jpg">
        <div class="container">
          <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-animate-in="fadeIn" data-owl-animate-out="fadeOut">
            <div class="ps-testimonial">
              <div class="ps-testimonial__thumbnail"><img src="images/testimonial/1.jpg" alt=""><i class="fa fa-quote-left"></i></div>
              <header>
                <select class="ps-rating">
                  <option value="1">1</option>
                  <option value="1">2</option>
                  <option value="1">3</option>
                  <option value="1">4</option>
                  <option value="5">5</option>
                </select>
                <p>Logan May - CEO & Founder Invision</p>
              </header>
              <footer>
                <p>“Dessert pudding dessert jelly beans cupcake sweet caramels gingerbread. Fruitcake biscuit cheesecake. Cookie topping sweet muffin pudding tart bear claw sugar plum croissant. “</p>
              </footer>
            </div>
            <div class="ps-testimonial">
              <div class="ps-testimonial__thumbnail"><img src="images/testimonial/2.jpg" alt=""><i class="fa fa-quote-left"></i></div>
              <header>
                <select class="ps-rating">
                  <option value="1">1</option>
                  <option value="1">2</option>
                  <option value="1">3</option>
                  <option value="1">4</option>
                  <option value="5">5</option>
                </select>
                <p>Logan May - CEO & Founder Invision</p>
              </header>
              <footer>
                <p>“Dessert pudding dessert jelly beans cupcake sweet caramels gingerbread. Fruitcake biscuit cheesecake. Cookie topping sweet muffin pudding tart bear claw sugar plum croissant. “</p>
              </footer>
            </div>
            <div class="ps-testimonial">
              <div class="ps-testimonial__thumbnail"><img src="images/testimonial/3.jpg" alt=""><i class="fa fa-quote-left"></i></div>
              <header>
                <select class="ps-rating">
                  <option value="1">1</option>
                  <option value="1">2</option>
                  <option value="1">3</option>
                  <option value="1">4</option>
                  <option value="5">5</option>
                </select>
                <p>Logan May - CEO & Founder Invision</p>
              </header>
              <footer>
                <p>“Dessert pudding dessert jelly beans cupcake sweet caramels gingerbread. Fruitcake biscuit cheesecake. Cookie topping sweet muffin pudding tart bear claw sugar plum croissant. “</p>
              </footer>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-section ps-home-blog pt-80 pb-80">
        <div class="ps-container">
          <div class="ps-section__header mb-50">
            <h2 class="ps-section__title" data-mask="News">- Our Story</h2>
            <div class="ps-section__action"><a class="ps-morelink text-uppercase" href="#">View all post<i class="fa fa-long-arrow-right"></i></a></div>
          </div>
          <div class="ps-section__content">
            <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                    <div class="ps-post">
                      <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="blog-detail.html"></a><img src="images/blog/1.jpg" alt=""></div>
                      <div class="ps-post__content"><a class="ps-post__title" href="blog-detail.html">An Inside Look at the Breaking2 Kit</a>
                        <p class="ps-post__meta"><span>By:<a class="mr-5" href="blog.html">Alena Studio</a></span> -<span class="ml-5">Jun 10, 2017</span></p>
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further…</p><a class="ps-morelink" href="blog-detail.html">Read more<i class="fa fa-long-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                    <div class="ps-post">
                      <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="blog-detail.html"></a><img src="images/blog/2.jpg" alt=""></div>
                      <div class="ps-post__content"><a class="ps-post__title" href="blog-detail.html">Unpacking the Breaking2 Race Strategy</a>
                        <p class="ps-post__meta"><span>By:<a class="mr-5" href="blog.html">Alena Studio</a></span> -<span class="ml-5">Jun 10, 2017</span></p>
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further…</p><a class="ps-morelink" href="blog-detail.html">Read more<i class="fa fa-long-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                    <div class="ps-post">
                      <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="blog-detail.html"></a><img src="images/blog/3.jpg" alt=""></div>
                      <div class="ps-post__content"><a class="ps-post__title" href="blog-detail.html">Nike’s Latest Football Cleat Breaks the Mold</a>
                        <p class="ps-post__meta"><span>By:<a class="mr-5" href="blog.html">Alena Studio</a></span> -<span class="ml-5">Jun 10, 2017</span></p>
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further…</p><a class="ps-morelink" href="blog-detail.html">Read more<i class="fa fa-long-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-home-contact">
        <div id="contact-map" data-address="New York, NY" data-title="BAKERY LOCATION!" data-zoom="17"></div>
        <div class="ps-home-contact__form">
          <header>
            <h3>Contact Us</h3>
            <p>Learn about our company profile, communityimpact, sustainable motivation, and more.</p>
          </header>
          <footer>
            <form action="product-listing.html" method="post">
              <div class="form-group">
                <label>Name<span>*</span></label>
                <input class="form-control" type="text">
              </div>
              <div class="form-group">
                <label>Email<span>*</span></label>
                <input class="form-control" type="email">
              </div>
              <div class="form-group">
                <label>Your message<span>*</span></label>
                <textarea class="form-control" rows="4"></textarea>
              </div>
              <div class="form-group text-center">
                <button class="ps-btn">Send Message<i class="fa fa-angle-right"></i></button>
              </div>
            </form>
          </footer>
        </div>
      </div>
      