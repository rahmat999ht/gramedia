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

  <title>Tables / Data - Gramedia Bootstrap Template</title>
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
      <h1>Data Buku</h1>
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

              <a href="forms-buku.php" class="btn btn-primary btn-custom my-3">
                Tambah
              </a>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th><b>N</b>o</th>
                    <th>Image</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query dengan JOIN untuk mendapatkan nama kategori
                  $sql = "SELECT * FROM `books` LEFT JOIN categories ON books.id_category = categories.id_category";
                  $query = mysqli_query($koneksi, $sql);
                  $no = 1;
                  while ($row = mysqli_fetch_array($query)) {
                    $bookId = htmlspecialchars($row['id_book']);
                    $bookTitle = htmlspecialchars($row['title']);
                    $bookAuthor = htmlspecialchars($row['author']);
                    $bookPrice = number_format($row['price'], 0, ',', '.');
                    $bookStock = htmlspecialchars($row['stock']);
                    $bookCategory = htmlspecialchars($row['name']);
                    $bookImage = !empty($row['image']) ? '../../images/' . htmlspecialchars($row['image']) : 'assets/img/logo.png';
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td>
                        <img src="<?php echo $bookImage; ?>" alt="<?php echo $bookTitle; ?>" style="width: auto; height: 40px;">
                      </td>
                      <td><?php echo $bookTitle; ?></td>
                      <td><?php echo $bookAuthor; ?></td>
                      <td><?php echo $bookPrice; ?></td>
                      <td><?php echo $bookStock; ?></td>
                      <td><?php echo $bookCategory; ?></td>
                      <td>
                        <button class="btn btn-info btn-view-book" data-id="<?php echo $bookId; ?>" data-bs-toggle="modal" data-bs-target="#modalDetailBook<?php echo $bookId; ?>" title="Lihat Detail">
                          <i class="bi bi-eye"></i>
                        </button>
                        <!-- Modal Detail Buku -->
                        <div class="modal fade" id="modalDetailBook<?php echo $bookId; ?>" tabindex="-1" aria-labelledby="modalDetailBookLabel<?php echo $bookId; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailBookLabel<?php echo $bookId; ?>">Detail Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="text-center">
                                  <img src="<?php echo $bookImage; ?>" alt="Book Image" style="width: 150px; height: auto; margin-bottom: 15px;">
                                </div>
                                <p><strong>Judul:</strong> <?php echo $bookTitle; ?></p>
                                <p><strong>Penulis:</strong> <?php echo $bookAuthor; ?></p>
                                <p><strong>Harga:</strong> <?php echo $bookPrice; ?></p>
                                <p><strong>Stok:</strong> <?php echo $bookStock; ?></p>
                                <p><strong>Kategori:</strong> <?php echo $bookCategory; ?></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button class="btn btn-warning btn-edit-book" data-id="<?php echo $bookId; ?>" title="Edit Buku">
                          <a href="forms-buku.php?id=<?php echo $bookId; ?>" class="text-decoration-none text-dark">
                            <i class="bi bi-pencil"></i>
                          </a>
                        </button>
                        <button
                          class="btn btn-danger btn-delete-book"
                          data-id="<?php echo $bookId; ?>"
                          title="Hapus Buku">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php $no++;
                  } ?>
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
    document.addEventListener('DOMContentLoaded', function() {
      const deleteButtons = document.querySelectorAll('.btn-delete-book');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const bookId = this.getAttribute('data-id'); // Ganti id_book ke data-id

          if (confirm('Yakin ingin menghapus buku ini?')) {
            fetch('fun_book/delete.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  action: 'delete',
                  id: bookId
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  alert(data.message);
                  location.reload(); // Reload halaman untuk memperbarui daftar buku
                } else {
                  alert(data.message);
                }
              })
              .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus buku.');
              });
          }
        });
      });
    });
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