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
				<!-- <form method="post" action="#"> -->
				<div>
					<h1>Checkout</h1>
					<!-- Tampilkan daftar produk di keranjang -->
					<table class="table">
						<thead>
							<tr>
								<th>Product</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Total</th>
								<th><input type="checkbox" id="checkAll">Checklis</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ($item = $result_items->fetch_assoc()) {
								$item_total = $item['quantity'] * $item['price'];
								$total_price += $item_total;
								$id_item = $item['id_item'];
							?>
								<tr>
									<td><?php echo $item['title']; ?></td>
									<td class="quantity"><?php echo $item['quantity']; ?></td>
									<td class="price"><?php echo number_format($item['price'], 2); ?></td>
									<td><?php echo number_format($item_total, 2); ?></td>
									<td>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="<?php echo $id_item; ?>" id="flexCheckChecked_<?php echo $id_item; ?>" checked>
											<label for="flexCheckChecked_<?php echo $id_item; ?>">
											</label>
										</div>
									</td>
								</tr>
							<?php
							} ?>
						</tbody>
					</table>

					<!-- Tampilkan total harga -->
					<div class="field half text-right">
						<h3>Total: <span class="total-price"><?php echo number_format($total_price, 2); ?></span></h3>
					</div>
					<script>
						// Fungsi untuk menghitung ulang total harga berdasarkan checkbox yang dipilih
						function updateTotal() {
							let total = 0; // Inisialisasi total harga
							const rows = document.querySelectorAll('tbody tr'); // Ambil semua baris pada tabel

							rows.forEach(row => {
								const checkbox = row.querySelector('.form-check-input'); // Ambil checkbox di baris tersebut
								if (checkbox.checked) {
									const quantity = parseInt(row.querySelector('.quantity').textContent); // Ambil quantity
									const price = parseFloat(row.querySelector('.price').textContent.replace(/,/g, '')); // Ambil harga
									total += quantity * price; // Tambahkan ke total
								}
							});

							// Perbarui elemen total harga
							document.querySelector('.total-price').textContent = total.toLocaleString(undefined, {
								minimumFractionDigits: 2,
								maximumFractionDigits: 2
							});
						}

						// Tambahkan event listener untuk setiap checkbox
						document.querySelectorAll('.form-check-input').forEach(checkbox => {
							checkbox.addEventListener('change', updateTotal);
						});

						// Event listener untuk tombol "checkAll"
						document.querySelector('#checkAll').addEventListener('change', function() {
							const isChecked = this.checked;
							document.querySelectorAll('.form-check-input').forEach(checkbox => {
								checkbox.checked = isChecked;
							});
							updateTotal(); // Hitung ulang total
						});
					</script>
					<section>
						<form method="post" action="function/add_to_order.php">
							<div class="fields">
								<div class="field half">
									<input type="text" name="name" id="name" placeholder="Name" required>
								</div>

								<div class="field half">
									<input type="text" name="phone" id="phone" placeholder="Phone" required>
								</div>

								<div class="field half">
									<input type="text" name="address" id="address" placeholder="Address" required>
								</div>

								<div class="field half">
									<input type="text" name="city" id="city" placeholder="City" required>
								</div>

								<div class="field half">
									<input type="text" name="state" id="state" placeholder="State" required>
								</div>

								<div class="field half">
									<input type="text" name="zip" id="zip" placeholder="Zip" required>
								</div>

								<div class="field half">
									<input type="hidden" name="id_cart" id="idCart" value="<?php echo htmlspecialchars($cart_id); ?>">
								</div>

								<div class="field half">
									<input type="hidden" name="id_cart_item" id="selectedItems">
								</div>

								<div class="field half text-right">
									<ul class="actions">
										<li><input type="submit" value="Finish" class="primary"></li>
									</ul>
								</div>
							</div>
						</form>

						<script>
							// Fungsi untuk memperbarui input hidden dengan id_item yang dipilih
							function updateSelectedItems() {
								const selectedItems = []; // Array untuk menyimpan id_item yang dipilih
								document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
									selectedItems.push(checkbox.value); // Ambil nilai dari checkbox yang dipilih
								});

								// Set nilai input hidden
								document.getElementById('selectedItems').value = selectedItems.join(',');
							}

							// Tambahkan event listener pada setiap checkbox
							document.querySelectorAll('.form-check-input').forEach(checkbox => {
								checkbox.addEventListener('change', updateSelectedItems);
							});

							// Event listener untuk tombol "checkAll"
							document.querySelector('#checkAll').addEventListener('change', function() {
								const isChecked = this.checked;
								document.querySelectorAll('.form-check-input').forEach(checkbox => {
									checkbox.checked = isChecked; // Set semua checkbox sesuai dengan checkAll
								});
								updateSelectedItems(); // Perbarui input hidden
							});

							// Jalankan fungsi saat halaman pertama kali dimuat untuk memastikan input hidden terisi
							updateSelectedItems();
						</script>

					</section>
				</div>
				<!-- </form> -->
			</div>
		</div>


		<!-- Footer -->
		<footer id="footer">
			<div class="inner">
				<section>
					<h2>Contact Info</h2>
					<ul class="alt">
						<li><span class="fa fa-envelope-o"></span> <a href="#">contact@company.com</a></li>
						<li><span class="fa fa-phone"></span> +1 333 4040 5566 </li>
						<li><span class="fa fa-map-pin"></span> 212 Barrington Court New York, ABC 10001 United States of America</li>
					</ul>
				</section>
				<section>
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