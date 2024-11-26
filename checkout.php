<?php
session_start(); // Mulai session
require_once("koneksi.php"); // Pastikan koneksi ke database sudah benar

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
	echo "Silakan login terlebih dahulu.";
	exit;
}

$user_id = $_SESSION['user_id']; // Ambil id_user dari session

// Ambil data keranjang pengguna
$query_cart = "SELECT id_cart FROM cart WHERE id_user = ?";
$stmt_cart = $koneksi->prepare($query_cart);
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows == 0) {
	echo "Keranjang Anda kosong.";
	exit;
}

// Ambil ID keranjang
$cart_id = $result_cart->fetch_assoc()['id_cart'];

// Ambil data item dalam keranjang
$query_items = "SELECT ci.id_item, ci.quantity, b.title, b.price 
                FROM cart_items ci
                JOIN books b ON ci.id_book = b.id_book
                WHERE ci.id_cart = ?";
$stmt_items = $koneksi->prepare($query_items);
$stmt_items->bind_param('i', $cart_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

// Hitung total harga
$total_price = 0;
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
				<h1>Checkout</h1>
				<!-- Tampilkan daftar produk di keranjang -->
				<table class="table">
					<thead>
						<tr>
							<th>Product</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($item = $result_items->fetch_assoc()) {
							$item_total = $item['quantity'] * $item['price'];
							$total_price += $item_total;
						?>
							<tr>
								<td><?php echo $item['title']; ?></td>
								<td><?php echo $item['quantity']; ?></td>
								<td><?php echo number_format($item['price'], 2); ?></td>
								<td><?php echo number_format($item_total, 2); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<!-- Tampilkan total harga -->
				<div class="field half text-right">
					<h3>Total: <?php echo number_format($total_price, 2); ?> </h3>
				</div>

			</div>
		</div>

		<!-- Footer -->
		<footer id="footer">
			<div class="inner">
				<section>
					<form method="post" action="#">
						<div class="fields">
							<div class="field half">
								<select>
									<option value="">-- Choose Title--</option>
									<option value="dr">Dr.</option>
									<option value="miss">Miss</option>
									<option value="mr">Mr.</option>
									<option value="mrs">Mrs.</option>
									<option value="ms">Ms.</option>
									<option value="other">Other</option>
									<option value="prof">Prof.</option>
									<option value="rev">Rev.</option>
								</select>
							</div>

							<div class="field half">
								<input type="text" name="field-2" id="field-2" placeholder="Name">
							</div>

							<div class="field half">
								<input type="text" name="field-3" id="field-3" placeholder="Email">
							</div>

							<div class="field half">
								<input type="text" name="field-4" id="field-4" placeholder="Phone">
							</div>

							<div class="field half">
								<input type="text" name="field-5" id="field-5" placeholder="Address 1">
							</div>

							<div class="field half">
								<input type="text" name="field-6" id="field-6" placeholder="Address 2">
							</div>

							<div class="field half">
								<input type="text" name="field-7" id="field-7" placeholder="City">
							</div>

							<div class="field half">
								<input type="text" name="field-8" id="field-8" placeholder="State">
							</div>

							<div class="field half">
								<input type="text" name="field-7" id="field-7" placeholder="Zip">
							</div>

							<div class="field half">
								<select>
									<option value="">-- Choose Country--</option>
									<option value="">-- Choose Country --</option>
									<option value="">-- Choose Country --</option>
									<option value="">-- Choose Country --</option>
								</select>
							</div>

							<div class="field half">

								<select>
									<option value="">-- Choose Payment Method--</option>
									<option value="">-- Choose Payment Method--</option>
									<option value="">-- Choose Payment Method--</option>
									<option value="">-- Choose Payment Method--</option>
								</select>
							</div>

							<div class="field half">
								<input type="text" name="field-9" id="field-9" placeholder="Captcha">
							</div>

							<div class="field">
								<div>
									<input type="checkbox" id="checkbox-4">

									<label for="checkbox-4">
										I agree with the <a href="terms.php" target="_blank">Terms &amp; Conditions</a>
									</label>
								</div>
							</div>


							<div class="field half text-right">
								<ul class="actions">
									<li><input type="submit" value="Finish" class="primary"></li>
								</ul>
							</div>
						</div>
					</form>
				</section>
				<section>
					<h2>Contact Info</h2>

					<ul class="alt">
						<li><span class="fa fa-envelope-o"></span> <a href="#">contact@company.com</a></li>
						<li><span class="fa fa-phone"></span> +1 333 4040 5566 </li>
						<li><span class="fa fa-map-pin"></span> 212 Barrington Court New York, ABC 10001 United States of America</li>
					</ul>

					<h2>Follow Us</h2>

					<ul class="icons">
						<li><a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon style2 fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon style2 fa-linkedin"><span class="label">LinkedIn</span></a></li>
					</ul>
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