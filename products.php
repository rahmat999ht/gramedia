<?php
session_start(); // Mulai session
require_once("koneksi.php");
error_reporting(0);


// Query untuk mengambil data buku dari database
$query = "SELECT * FROM books"; // Sesuaikan nama tabel dan field sesuai dengan yang ada di database
$result = $koneksi->query($query);

// Ambil kategori buku dari database
$query_categories = "SELECT * FROM categories";
$result_categories = $koneksi->query($query_categories);

/// Menentukan kategori yang dipilih (jika ada)
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Query untuk mengambil buku berdasarkan kategori yang dipilih
$query_books = "SELECT * FROM books";
if ($category_id > 0) {
	$query_books .= " WHERE id_category = $category_id"; // Filter berdasarkan kategori
}
$result_books = $koneksi->query($query_books);
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
	<!-- Tambahkan CSS di dalam file CSS Anda -->
	<style>
		.button-default {
			background-color: #f0f0f0;
			color: black;
			border: 1px solid #ccc;
			padding: 10px 20px;
			cursor: pointer;
		}

		.button-selected {
			background-color: #FFB6C1;
			color: white;
			border: 1px solid #FFB6C1;
		}
	</style>

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

				<h2>Categories</h2>
				<div class="categories">
					<!-- Tombol All untuk menampilkan semua buku -->
					<button id="all-button" class="button-default" type="button" onclick="window.location.href='products.php?category_id=0'">All</button>

					<?php
					// Menampilkan kategori buku
					while ($row_category = $result_categories->fetch_assoc()) {
						$category_id = $row_category['id_category'];
					?>
						<button id="category-<?php echo $category_id; ?>" class="button-default" type="button" onclick="window.location.href='products.php?category_id=<?php echo $category_id; ?>'">
							<?php echo htmlspecialchars($row_category['name']); ?>
						</button>
					<?php
					}
					?>
				</div>

				<script>
					// Ambil parameter category_id dari URL
					const urlParams = new URLSearchParams(window.location.search);
					const categoryId = urlParams.get('category_id');

					// Jika category_id ditemukan, beri kelas 'button-selected' pada tombol yang sesuai
					if (categoryId) {
						if (categoryId == 0) {
							document.getElementById('all-button').classList.add('button-selected');
						} else {
							document.getElementById('category-' + categoryId).classList.add('button-selected');
						}
					}
				</script>

				<h2></h2>

				<!-- Produk Buku Berdasarkan Kategori -->
				<section class="tiles">
					<?php
					// Menampilkan buku yang sesuai dengan kategori yang dipilih
					while ($row_book = $result_books->fetch_assoc()) {
						$bookImage = !empty($row_book['image']) ? 'images/' . htmlspecialchars($row_book['image']) : 'images/product-6-720x480.jpg';
					?>
						<article class="style1">
							<span class="image">
								<img width="300px" height="260px" src="<?php echo $bookImage; ?>" alt="<?php echo htmlspecialchars($row_book['title']); ?>" />
							</span>
							<a href="product-details.php?id=<?php echo $row_book['id_book']; ?>">
								<h2><?php echo htmlspecialchars($row_book['title']); ?></h2>
								<p><del>$<?php echo number_format($row_book['price'], 2, '.', ','); ?></del> <strong>$<?php echo number_format($row_book['price'], 2, '.', ','); ?></strong></p>
								<p><?php echo htmlspecialchars($row_book['description']); ?></p>
							</a>
						</article>
					<?php
					}
					?>
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

	<!-- modal Login -->
	<div
		class="modal fade"
		id="loginModal"
		tabindex="-1"
		role="dialog"
		aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title" id="exampleModalLabel">Login</h1>
					<button type="button" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="function/login_user.php">
						<div class="form-group">
							<label for="username">Username</label>
							<input
								type="text"
								class="form-control"
								id="username"
								name="username"
								placeholder="Enter your username"
								required />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input
								type="password"
								class="form-control"
								id="password"
								name="password"
								placeholder="Enter your password"
								required />
						</div>
						<div class="modal-footer">
							<button type="button" data-dismiss="modal">Close</button>
							<button type="submit" class="primary">Login</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

	<!-- Modal Register -->
	<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title" id="registerModalLabel">Register</h1>
					<button type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="function/register_user.php"> <!-- Ganti dengan path ke script register Anda -->
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required />
						</div>
						<div class="form-group">
							<label for="confirmPassword">Verify Password</label>
							<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your password" required />
						</div>
						<div class="modal-footer">
							<button type="button" data-dismiss="modal">Close</button>
							<button type="submit" class="primary">Register</button> <!-- Tombol untuk mengirim data ke server -->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/main.js"></script>
</body>

</html>