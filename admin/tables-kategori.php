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

  <title>Tables / Data - NiceAdmin Bootstrap Template</title>
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
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="" />
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->



    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">


        <li class="nav-item dropdown pe-3">
          <a
            class="nav-link nav-profile d-flex align-items-center pe-0"
            href="#"
            data-bs-toggle="dropdown">
            <img
              src="assets/img/profile-img.jpg"
              alt="Profile"
              class="rounded-circle" />
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span> </a><!-- End Profile Iamge Icon -->

          <ul
            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>


            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
          <!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->
      </ul>
    </nav>
    <!-- End Icons Navigation -->
  </header>
  <!-- End Header -->
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- Dashboard Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <!-- Buku Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="tables-buku.php">
          <i class="bi bi-book"></i>
          <span>Buku</span>
        </a>
      </li>
      <!-- End Buku Nav -->

      <!-- Kategori Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="tables-kategori.php">
          <i class="bi bi-tags"></i>
          <span>Kategori</span>
        </a>
      </li>
      <!-- End Kategori Nav -->

      <!-- Pesanan Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="tables-pesanan.php">
          <i class="bi bi-cart"></i>
          <span>Pesanan</span>
        </a>
      </li>
      <!-- End Pesanan Nav -->

      <!-- Transaksi Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="tables-transaksi.php">
          <i class="bi bi-credit-card"></i>
          <span>Transaksi</span>
        </a>
      </li>
      <!-- End Transaksi Nav -->

      <!-- Pengguna Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="tables-pengguna.php">
          <i class="bi bi-person-circle"></i>
          <span>Pengguna</span>
        </a>
      </li>
      <!-- End Pengguna Nav -->
    </ul>
  </aside>
  <!-- End Sidebar -->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Kategori</h1>
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
              <a href="forms-add-buku.php" class="btn btn-primary btn-custom my-3">
                Tambah
              </a>


              <!-- Table with stripped rows -->
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <?php
                // Query untuk mengambil data dari tabel categories
                $sql_categories = "SELECT * FROM categories";
                $query_categories = mysqli_query($koneksi, $sql_categories);
                $no = 1;
                while ($row = mysqli_fetch_array($query_categories)) {
                ?>
                  <tbody>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td>
                        <button class="btn btn-info btn-view-book" data-id="<?php echo $row['id_category']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                          <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-warning btn-edit-book" data-id="<?php echo $row['id_category']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Buku">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-delete-book" data-id="<?php echo $row['id_category']; ?>" onclick="return confirm('Yakin ingin menghapus buku ini?');" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Buku">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                <?php
                  $no++;
                }
                ?>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer>
  <!-- End Footer -->

  <a
    href="#"
    class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>


  <!-- DataTable Initialization Script -->
  <script>
    $(document).ready(function() {
      $('.datatable').DataTable({
        "paging": true, // Memungkinkan pagination
        "searching": true, // Memungkinkan pencarian
        "ordering": false, // Memungkinkan pengurutan
      });
    });
  </script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>