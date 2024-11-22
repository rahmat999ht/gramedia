<?php
session_start(); // Mulai session
require_once("koneksi.php");
error_reporting(0);

// Menangkap ID dari URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;


// Query untuk mengambil detail produk
$sql = "SELECT * FROM books WHERE id_book = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $product_id); // Binding parameter
$stmt->execute();
$result = $stmt->get_result();

// Jika produk ditemukan
if ($result->num_rows > 0) {
	$product = $result->fetch_assoc();
} else {
	echo "Produk tidak ditemukan";
}

$stmt->close();
$koneksi->close()
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

		<!-- Header -->
		<header id="header">
			<div class="inner">

				<!-- Logo -->
				<a href="index.php" class="logo">
					<span class="fa fa-book"></span> <span class="title">Gramedia</span>
				</a>

				<!-- Nav -->
				<nav>
					<ul>
						<li><a href="#menu">Menu</a></li>
					</ul>
				</nav>

			</div>
		</header>

		<!-- Menu -->
		<nav id="menu">
			<h2>Menu</h2>
			<ul>
				<li><a href="index.php">Home</a></li>

				<li><a href="products.php" class="active">Products</a></li>

				<li><a href="checkout.php">Checkout</a></li>

				<li>
					<a href="#" class="dropdown-toggle">About</a>

					<ul>
						<li><a href="about.php">About Us</a></li>
						<li><a href="blog.php">Blog</a></li>
						<li><a href="testimonials.php">Testimonials</a></li>
						<li><a href="terms.php">Terms</a></li>
					</ul>
				</li>

				<li><a href="contact.php">Contact Us</a></li>
			</ul>
		</nav>

		<!-- Main -->
		<div id="main">
			<div class="inner">
				<?php if (isset($product)):
					// Tentukan gambar yang akan digunakan
					$bookImage = !empty($product['image']) ? 'images/' . htmlspecialchars($product['image']) : 'images/product-6-720x480.jpg';
				?>
					<h1><?php echo htmlspecialchars($product['title']); ?> <span class="pull-right"> $<?php echo number_format($product['price'], 2); ?></span></h1>

					<div class="container-fluid">
						<div class="row">
							<div class="col-md-5">
								<img src="<?php echo $bookImage; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['title']); ?>">
							</div>

							<div class="col-md-7">
								<p><?php echo htmlspecialchars($product['description']); ?></p>

								<div class="row">
									<div class="col-sm-4">
										<!-- Optional: Add additional content here if needed -->
									</div>

									<div class="col-sm-8">
										<label class="control-label">Quantity</label>
										<form action="function/add_to_cart.php" method="POST">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control">
													</div>
												</div>

												<div class="col-sm-6">
													<input type="hidden" name="product_id" value="<?php echo $product['id_book']; ?>">
													<input type="submit" class="primary" value="Add to Cart">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<br>
				<br>

				<div class="container-fluid">
					<h2 class="h2">Similar Products</h2>

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