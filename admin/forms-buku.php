<?php
session_start(); // Mulai session
require_once("../koneksi.php");
error_reporting(0);

if (!$_SESSION['admin_role']) {
  echo '<script>alert("anda belum login atau session login berakhir"); window.location.href="login.php";</script>';
  exit;
}

$bookData = null;

// Periksa apakah ada parameter id di URL
if (isset($_GET['id'])) {
  $bookId = intval($_GET['id']); // Amankan input ID
  $query = "SELECT * FROM books WHERE id_book = $bookId";
  $result = mysqli_query($koneksi, $query);

  // Ambil data buku jika ditemukan
  if ($result && mysqli_num_rows($result) > 0) {
    $bookData = mysqli_fetch_assoc($result);
  } else {
    echo '<script>alert("Book not found!"); window.location.href="tables-buku.php";</script>';
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Forms Books</title>
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
      <h1>Form Layouts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Layouts</li>
        </ol>
      </nav>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-col-lg-auto">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Form Book</h5>

              <!-- Add Book Form -->
              <form action="fun_book/save.php" method="POST" enctype="multipart/form-data">
                <!-- Input hidden untuk ID buku -->
                <?php if ($bookData): ?>
                  <input type="hidden" name="id" value="<?php echo $bookData['id_book']; ?>">
                <?php endif; ?>

                <!-- Input gambar -->
                <div class="row mb-3">
                  <label for="bookImage" class="col-sm-2 col-form-label">Book Image</label>
                  <div class="col-sm-10">
                    <input
                      type="file"
                      class="form-control"
                      id="bookImage"
                      name="image"
                      accept="image/*"
                      <?php echo $bookData ? '' : 'required'; ?> />
                    <?php if ($bookData && $bookData['image']): ?>
                      <img src="../../images/<?php echo $bookData['image']; ?>" alt="Book Image" class="mt-2" width="100">
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Input judul -->
                <div class="row mb-3">
                  <label for="bookTitle" class="col-sm-2 col-form-label">Title</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="bookTitle"
                      name="title"
                      value="<?php echo $bookData['title'] ?? ''; ?>"
                      required />
                  </div>
                </div>

                <!-- Input pengarang -->
                <div class="row mb-3">
                  <label for="bookAuthor" class="col-sm-2 col-form-label">Author</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="bookAuthor"
                      name="author"
                      value="<?php echo $bookData['author'] ?? ''; ?>"
                      required />
                  </div>
                </div>

                <!-- Input harga -->
                <div class="row mb-3">
                  <label for="bookPrice" class="col-sm-2 col-form-label">Price</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-text">$</span>
                      <input
                        type="number"
                        step="0.01"
                        class="form-control"
                        id="bookPrice"
                        name="price"
                        value="<?php echo $bookData['price'] ?? ''; ?>"
                        required />
                    </div>
                  </div>
                </div>

                <!-- Input stok -->
                <div class="row mb-3">
                  <label for="bookStock" class="col-sm-2 col-form-label">Stock</label>
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="bookStock"
                      name="stock"
                      value="<?php echo $bookData['stock'] ?? ''; ?>"
                      required />
                  </div>
                </div>

                <!-- Input kategori -->
                <div class="row mb-3">
                  <label for="bookCategory" class="col-sm-2 col-form-label">Category</label>
                  <div class="col-sm-10">
                    <select class="form-select" id="bookCategory" name="id_category" required>
                      <option value="" disabled>Select a category</option>
                      <?php
                      $categoriesQuery = "SELECT * FROM categories";
                      $categoriesResult = mysqli_query($koneksi, $categoriesQuery);
                      while ($category = mysqli_fetch_assoc($categoriesResult)) {
                        // Periksa kecocokan id_category
                        $selected = (isset($bookData['id_category']) && $bookData['id_category'] == $category['id_category']) ? 'selected' : '';
                        echo '<option value="' . $category['id_category'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!-- Tombol -->
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save Book</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>
              <!-- End Add Book Form -->
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