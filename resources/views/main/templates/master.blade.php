@php
header("Access-Control-Allow-Origin: *");
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/logo/icon.ico" /> <!-- TITLE -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- SITE TITLE -->
	<title>Banyu Wana Amerta</title>
	<!-- Latest Bootstrap min CSS -->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/bootstrap/css/bootstrap.min.css">
	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- Icon CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/icofont/icofont.min.css')}}">
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/Pe-icon-7-stroke.css">
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/line-awesome.css">
	<!--- owl carousel Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/owlcarousel/css/owl.carousel.min.css">
	<link rel="stylesheet"
		href="https://getmasum.com/html-preview/ward/assets/owlcarousel/css/owl.theme.default.min.css">
	<!--slicknav Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/slicknav.css">
	<!--magnific-popup Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/magnific-popup.css">
	<!--YouTubePopUp Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/YouTubePopUp.css">
	<!--Slick Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/slick.css">
	<!--slick theme Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/slick-theme.css">
	<!--gijgo.min Css-->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/gijgo.min.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/style_master.css')}}">
	<!-- switcher CSS -->
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/switcher/switcher.css">
	<link rel="stylesheet" href="https://getmasum.com/html-preview/ward/assets/css/switcher/style1.css" id="colors">
	<meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body data-spy="scroll" data-offset="80">

	<!-- START PRELOADER  -->
	{{-- <div class="preloader">
		<div class="lds-roller">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div> --}}
	<!--  END PRELOADER -->

	<!-- START NAVBAR -->
	<div id="navigation" class="fixed-top navbar-light bg-faded site-navigation">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-3 col-sm-4">
					<div class="site-logo">
						<a href="/"><img src="assets/images/logo/icon.png"
								alt="logo"></a>
					</div>
				</div>
				<!--- END Col -->

				<div class="col-lg-10 col-md-9 col-sm-8 ">
					<div class="header_right ">
						<nav id="main-menu" class="ms-auto">
							<ul>
								@can('member')
								<li><a class="nav-link" href="{{route('main')}}">Home</a></li>
								<li><a class="nav-link" href="{{route('member.cart.index')}}">Cart</a></li>
								@auth
								<li><a class="nav-link" href="{{route('member.order.index')}}">Order Histori</a></li>
								<li>
									<a class="nav-link" href="{{route('logout')}}"
										onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
										Out</a>
								</li>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
								@endauth
								@endcan

								@auth
								@cannot('member')
								<li><a class="nav-link" href="{{route('admin.dashboard')}}">Dashboard</a></li>
								<li>
									<a class="nav-link" href="{{route('logout')}}"
										onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
										Out</a>
								</li>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
								@endcannot
								@endauth

								@guest
								<li><a class="nav-link" href="login">Login</a></li>
								@endguest
							</ul>
						</nav>
						<div id="mobile_menu"></div>
					</div>
				</div>
				<!--- END Col -->
			</div>
			<!--- END ROW -->
		</div>
		<!--- END CONTAINER -->
	</div>
	<!-- END NAVBAR -->

	<!-- START HOME -->
	<section id="home" class="home-slider">
		<div class="single_home_slide"
			style="background-image: url(assets/images/bg.jpg);  background-size:cover;">
			<div class="slide_overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="hero-text">
								<p>Welcome to</p>
								<h1>
									BANYU WANA AMERTA <br> Waterfall
								</h1>
								<div class="sl_btn_group">
									<a href="#why_choose" class="btn btn-default btn-home-bg">Discover Now</a>
									{{-- <a class="sl_vbtn" href="https://www.youtube.com/watch?v=OVMuvfxbT1o"><i
											class=" ti-control-play"></i> <span>Watch Intro</span></a> --}}
								</div>
							</div>
						</div>
						<!--- END COL -->
					</div>
					<!--- END ROW -->
				</div>
				<!--- END CONTAINER -->
			</div>
			<!--- END slide -->
		</div>
		<!--- END slide -->
	</section>
	<!-- END  HOME DESIGN -->

	@yield('content')

	<!-- START FOOTER -->
	<div id="footer" class="footer">
		<div class="container">
			<div class="footer-top">
				<div class="row">
					<div class="text-center">
						<h3 class="text-white">Location <br> BANYU WANA AMERTA</h3>
					</div>
					<div id="map" style="height: 400px"></div>
				</div>
			</div>

			<div class="footer-bottom text-center">
				<p class="copyright_text">
					Copyright @ 2022 <a href="/">Banyu Wana Amerta</a> all right reserved.
				</p>
				{{-- <ul class="foot_social_link">
					<li><a href="#"><i class="fab fa-facebook"></i></a></li>
					<li><a href="#"><i class="fab fa-twitter"></i></a></li>
					<li><a href="#"><i class="fab fa-pinterest"></i></a></li>
					<li><a href="#"><i class="fab fa-linkedin"></i></a></li>
					<li><a href="#"><i class="fab fa-youtube"></i></a></li>
				</ul> --}}
			</div>
		</div>
		<!--- END CONTAINER -->
	</div>
	<!-- END FOOTER -->

	@yield('modal')

	<!-- JS -->
	<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="https://getmasum.com/html-preview/ward/assets/js/jquery.min.js"></script>
	<!-- Latest compiled and minified Bootstrap -->
	<script src="https://getmasum.com/html-preview/ward/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- Fontawesome -->
	<script src="https://kit.fontawesome.com/43293d2a78.js" crossorigin="anonymous"></script>
	<!-- masonry.pkgd.min -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/masonry.pkgd.min.js"></script>
	<!-- imagesloaded.pkgd -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/imagesloaded.pkgd.min.js"></script>
	<!-- modernizer JS -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/modernizr-2.8.3.min.js"></script>
	<!-- gijgo.min JS -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/gijgo.min.js"></script>
	<!-- owl-carousel min js  -->
	<script src="https://getmasum.com/html-preview/ward/assets/owlcarousel/js/owl.carousel.min.js"></script>
	<!-- jquery.slicknav -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/jquery.slicknav.js"></script>
	<!-- countTo js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/jquery.inview.min.js"></script>
	<!-- magnific-popup js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/jquery.magnific-popup.js"></script>
	<!-- YouTubePopUp js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/YouTubePopUp.jquery.js"></script>
	{{-- <!-- scrolltopcontrol js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/scrolltopcontrol.js"></script> --}}
	<!-- slick js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/slick.js"></script>
	<!-- switcher js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/switcher.js"></script>
	<!-- scripts js -->
	<script src="https://getmasum.com/html-preview/ward/assets/js/scripts.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.1/dist/sweetalert2.all.min.js"></script>

	<script>
		function initMap() {
			const myLatLng = { lat: -8.199408663250226, lng: 115.11857313827554 };

			const map = new google.maps.Map(document.getElementById("map"), {
				zoom: 5,
				center: myLatLng,
			});
			new google.maps.Marker({
				position: myLatLng,
				map,
				title: "Hello Rajkot!",
			});
		}
		window.initMap = initMap;
	</script>
	<script type="text/javascript"
	src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap" ></script>

	@stack('scripts')
</body>

</html>


