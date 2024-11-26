<?php
session_start(); // Mulai session
require_once("koneksi.php");
error_reporting(0);
?>


<!DOCTYPE HTML>
<html>

<head>
	<title>Gramedia</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
</head>

<body class="is-preload">
	<!-- Wrapper -->
	<div id="wrapper">

		<?php
		include 'header.php';
		include 'sidebar.php';
		?>

		<!-- Main -->
		<div id="main">
			<div class="inner">
				<h1>Products</h1>

				<div class="image main">
					<img src="images/banner-image-6-1920x500.jpg" class="img-fluid" alt="" />
				</div>

				<!-- Products -->
				<section class="tiles">
					<article class="style1">
						<span class="image">
							<img src="images/product-1-720x480.jpg" alt="" />
						</span>
						<a href="product-details.php">
							<h2>Lorem ipsum dolor sit amet, consectetur</h2>

							<p><del>$19.00</del> <strong>$19.00</strong></p>

							<p>Vestibulum id est eu felis vulputate hendrerit uspendisse dapibus turpis in </p>
						</a>
					</article>
					<article class="style2">
						<span class="image">
							<img src="images/product-2-720x480.jpg" alt="" />
						</span>
						<a href="product-details.php">
							<h2>Lorem ipsum dolor sit amet, consectetur</h2>

							<p><del>$19.00</del> <strong>$19.00</strong></p>

							<p>Vestibulum id est eu felis vulputate hendrerit uspendisse dapibus turpis in </p>
						</a>
					</article>
					<article class="style3">
						<span class="image">
							<img src="images/product-3-720x480.jpg" alt="" />
						</span>
						<a href="product-details.php">
							<h2>Lorem ipsum dolor sit amet, consectetur</h2>

							<p><del>$19.00</del> <strong>$19.00</strong></p>

							<p>Vestibulum id est eu felis vulputate hendrerit uspendisse dapibus turpis in </p>
						</a>
					</article>

					<article class="style4">
						<span class="image">
							<img src="images/product-4-720x480.jpg" alt="" />
						</span>
						<a href="product-details.php">
							<h2>Lorem ipsum dolor sit amet, consectetur</h2>

							<p><del>$19.00</del> <strong>$19.00</strong></p>

							<p>Vestibulum id est eu felis vulputate hendrerit uspendisse dapibus turpis in </p>
						</a>
					</article>

					<article class="style5">
						<span class="image">
							<img src="images/product-5-720x480.jpg" alt="" />
						</span>
						<a href="product-details.php">
							<h2>Lorem ipsum dolor sit amet, consectetur</h2>

							<p><del>$19.00</del> <strong>$19.00</strong></p>

							<p>Vestibulum id est eu felis vulputate hendrerit uspendisse dapibus turpis in </p>
						</a>
					</article>

					<article class="style6">
						<span class="image">
							<img src="images/product-6-720x480.jpg" alt="" />
						</span>
						<a href="product-details.php">
							<h2>Lorem ipsum dolor sit amet, consectetur</h2>

							<p><del>$19.00</del> <strong>$19.00</strong></p>

							<p>Vestibulum id est eu felis vulputate hendrerit uspendisse dapibus turpis in </p>
						</a>
					</article>
				</section>
			</div>
		</div>

		<!-- Footer -->
		<footer id="footer">
			<div class="inner">
				<section>
					<ul class="icons">
						<li><a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon style2 fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon style2 fa-linkedin"><span class="label">LinkedIn</span></a></li>
					</ul>

					&nbsp;
				</section>

				<ul class="copyright">
					<li>Copyright © 2020 Company Name </li>
					<li>Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a></li>
				</ul>
			</div>
		</footer>

	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/main.js"></script>
</body>

</html>