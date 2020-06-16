 <?php if ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') { ?>
    <div class="ps-footer bg--cover" data-background="images/background/Bawah.jpg">
 	<div class="ps-footer__content">
 		<div class="ps-container">
 			<div class="row">
 				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
 					<aside class="ps-widget--footer ps-widget--info">
 					    <h3 class="ps-widget__title" style="color: black;">Admin Contact</h3>
 						</header>
 						<footer>
 							<!--<p><strong>Pakuwon City, Surabaya</strong></p>-->
 							<p>Email: <a href='mailto:admin@majangdapatuang.com'>admin@majangdapatuang.com</a></p>
 							<!--<p>Phone: +62 813 2434 5334</p>-->
 							<!--<p>Fax: +62 31 434 53</p>-->
 						</footer>
 					</aside>
 				</div>
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
     								<li><i class="fa fa-youtube"></i><a href="https://www.youtube.com/channel/UCw4gihltQMLSsmDSDAsr5Hw">Cipto Junaedy Official</a></li>
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
 					<p>&copy; <a href="#">Program Dalam 30 Hari Jago Menghasilkan Cash Banyak</a>, Inc. All rights Resevered. Design by <a href="#"> Cipto Junaedy </a></p>
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
 <?php } ?>
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
