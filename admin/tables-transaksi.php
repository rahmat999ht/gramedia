<?php
session_start(); // Mulai session
require_once("../koneksi.php");
error_reporting(0);

if (!$_SESSION['admin_role']) {
  echo '<script>alert("anda belum login atau session login berakhir"); window.location.href="login.php";</script>';
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Tables / Data - Gramedia </title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link
    href="assets/vendor/bootstrap/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
    rel="stylesheet" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

  <!-- =======================================================
  * Template Name: Gramedia
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <?php
  include 'header.php';
  include 'sidebar.php';
  ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Transaksi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th><b>N</b>o</th>
                    <th>Nama Pengguna</th>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Status Keranjang</th>
                    <th>Jumlah Checkout</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query untuk mendapatkan data keranjang dengan JOIN dan menghitung jumlah checkout
                  $sql = "SELECT cart.id_cart, users.username, books.title, cart_items.quantity, 
                  CASE WHEN cart.id_user IS NOT NULL THEN 'Di dalam keranjang' ELSE 'Keranjang kosong' 
                  END AS status, COUNT(DISTINCT orders.id_order) AS checkout_count
                  FROM cart_items JOIN cart ON cart_items.id_cart = cart.id_cart
                  JOIN users ON cart.id_user = users.id_user
                  JOIN books ON cart_items.id_book = books.id_book
                  LEFT JOIN orders ON orders.id_user = users.id_user 
                  AND EXISTS (
                  SELECT 1 FROM order_details 
                  WHERE order_details.id_order = orders.id_order 
                  AND order_details.id_book = cart_items.id_book
                  )
                  GROUP BY cart.id_cart, users.username, books.title, cart_items.quantity
                  LIMIT 0, 25";

                  $query = mysqli_query($koneksi, $sql);
                  $no = 1;
                  while ($row = mysqli_fetch_array($query)) {
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo htmlspecialchars($row['username']); ?></td>
                      <td><?php echo htmlspecialchars($row['title']); ?></td>
                      <td><?php echo $row['quantity']; ?></td>
                      <td><?php echo htmlspecialchars($row['status']); ?></td>
                      <td><?php echo $row['checkout_count']; ?></td>
                      <td>
                        <button
                          class="btn btn-success btn-print-receipt"
                          data-id="<?php echo $row['id_cart']; ?>"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Cetak Nota"
                          onclick="printNota(<?php echo $row['id_cart']; ?>)">
                          <i class="bi bi-printer"></i>
                        </button>
                      </td>

                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- End #main -->

  <?php
  include 'footer.php';
  ?>

  <a
    href="#"
    class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script>
    function printNota(idCart) {
      console.log("ID Cart:", idCart); // Debugging
      const printWindow = window.open(`fun_transaksi/cetak_nota.php?id_cart=${idCart}`, '_blank');
      printWindow.focus();
    }
  </script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>