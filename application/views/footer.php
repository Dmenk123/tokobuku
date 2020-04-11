 <div class="ps-footer bg--cover" data-background="images/background/Bawah.jpg">
 	<div class="ps-footer__content">
 		<div class="ps-container">
 			<div class="row">
 				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
 					<aside class="ps-widget--footer ps-widget--info">
 					    <div class="hide">
 						<header><a class="ps-logo" href="index.html"><img src="images/logo-white.png" alt=""></a>
 						</div>
 							<h3 class="ps-widget__title" style="color: black;">Address Office</h3>
 						</header>
 						<footer>
 							<p><strong>Pakuwon City, Surabaya</strong></p>
 							<p>Email: <a href='mailto:support@store.com'>Jhonny@store.com</a></p>
 							<p>Phone: +62 813 2434 5334</p>
 							<p>Fax: +62 31 434 53</p>
 						</footer>
 					</aside>
 				</div>
 				<!--<div class="hide">-->
 				<!--<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">-->
 				<!--	<aside class="ps-widget--footer ps-widget--info second">-->
 				<!--		<header>-->
 				<!--			<h3 class="ps-widget__title" style="color: black;">Address Office 2</h3>-->
 				<!--		</header>-->
 				<!--		<footer>-->
 				<!--			<p><strong>PO Box 16122 Collins Victoria 3000 Australia</strong></p>-->
 				<!--			<p>Email: <a href='mailto:support@store.com'>support@store.com</a></p>-->
 				<!--			<p>Phone: +323 32434 5334</p>-->
 				<!--			<p>Fax: ++323 32434 5333</p>-->
 				<!--		</footer>-->
 				<!--	</aside>-->
 				<!--</div>-->
 				<!--</div>-->
 				<!--<div class="hide">-->
 				<!--<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">-->
 				<!--	<aside class="ps-widget--footer ps-widget--link">-->
 				<!--		<header>-->
 				<!--			<h3 class="ps-widget__title">Find Our store</h3>-->
 				<!--		</header>-->
 				<!--		<footer>-->
 				<!--			<ul class="ps-list--link">-->
 				<!--				<li><a href="#">Coupon Code</a></li>-->
 				<!--				<li><a href="#">SignUp For Email</a></li>-->
 				<!--				<li><a href="#">Site Feedback</a></li>-->
 				<!--				<li><a href="#">Careers</a></li>-->
 				<!--			</ul>-->
 				<!--		</footer>-->
 				<!--	</aside>-->
 				<!--</div>-->
 				<!--</div>-->
 				<!--<div class="hide">-->
 				<!--<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">-->
 				<!--	<aside class="ps-widget--footer ps-widget--link">-->
 				<!--		<header>-->
 				<!--			<h3 class="ps-widget__title">Get Help</h3>-->
 				<!--		</header>-->
 				<!--		<footer>-->
 				<!--			<ul class="ps-list--line">-->
 				<!--				<li><a href="#">Order Status</a></li>-->
 				<!--				<li><a href="#">Shipping and Delivery</a></li>-->
 				<!--				<li><a href="#">Returns</a></li>-->
 				<!--				<li><a href="#">Payment Options</a></li>-->
 				<!--				<li><a href="#">Contact Us</a></li>-->
 				<!--			</ul>-->
 				<!--		</footer>-->
 				<!--	</aside>-->
 				<!--</div>-->
 				<!--</div>-->
 				<div>
 				<div class="col-lg-6 col-md-2 col-sm-4 col-xs-12 ">
 					<aside class="ps-widget--footer ps-widget--link">
 						<header>
 							<h3 class="ps-widget__title" style="color:black;">Social Media</h3>
 						</header>
 						<footer>
 							<ul class="ps-list--line">
 								<li><i class="fa fa-facebook"></i><a href="https://www.facebook.com/Cipto.Junaedy.Strategi/">Cipto Junaedy</a></li>
 								<li><i class="fa fa-instagram"></i><a href="https://www.instagram.com/ciptojunaedyofficial/">@ Ciptojunaedyofficial</a></li>
 								<li><i class="fa fa-youtube"></i><a href="https://www.youtube.com/channel/UCw4gihltQMLSsmDSDAsr5Hw">Cipto Junaedy</a></li>
 								<!--<li><a href="#">Football Boots</a></li>-->
 							</ul>
 						</footer>
 					</aside>
 				</div>
 			</div>
 			</div>
 		</div>
 	</div>
 	<div class="ps-footer__copyright">
 		<div class="ps-container">
 			<div class="row">
 				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
 					<p>&copy; <a href="#">Program Belajar Jadi Teladan Tanpa Utang</a>, Inc. All rights Resevered. Design by <a href="#"> Dwi Siswanto </a></p>
 				</div>
 				<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 ">
 					<ul class="ps-social">
 						<li><a href="https://www.facebook.com/Cipto.Junaedy.Strategi/" target="_blank"><i class="fa fa-facebook"></i></a></li>
 						<li><a href="https://www.youtube.com/channel/UCw4gihltQMLSsmDSDAsr5Hw" target="_blank"><i class="fa fa-youtube"></i></a></li>
 						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
 						<li><a href="https://www.instagram.com/ciptojunaedyofficial/" target="_blank"><i class="fa fa-instagram"></i></a></li>
 					</ul>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>
 </main>
 <!-- JS Library-->

 </body>

 <script>
 	var baseUrl = "<?= base_url(); ?>";
 	function logout() {
 		swal({
 			title: "Logout",
 			text: "Apakah Anda Yakin ingin Logout!",
 			icon: "warning",
 			buttons: [
 				'Tidak',
 				'Ya'
 			],
 			dangerMode: true,
 		}).then(function(isConfirm) {
 			if (isConfirm) {
 				$.ajax({
 					url: baseUrl + 'admin/login/logout_proc',
 					type: 'POST',
 					dataType: "JSON",
 					success: function(data) {
 						swal("Logout", 'Anda berhasil logout', "success").then(function() {
 							window.location.href = baseUrl + 'home';
 						});
 					}
 				});
 			} else {
 				swal("Batal", "Aksi dibatalkan", "error");
 			}
 		});
 	}
 </script>

 </html>
