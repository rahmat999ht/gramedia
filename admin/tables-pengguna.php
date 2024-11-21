<?php
session_start(); // Mulai session
require_once("../koneksi.php");
error_reporting(0);

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] != 'admin') {
  echo '<script>alert("Anda belum login atau session login berakhir"); window.location.href="login.php";</script>';
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
</head>

<body>
  <?php
  include 'header.php';
  include 'sidebar.php';
  ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Pengguna</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Email Terverifikasi</th>
                    <th>Status Akun</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query untuk mengambil data dari tabel users
                  $sql_users = "SELECT * FROM users";
                  $query_users = mysqli_query($koneksi, $sql_users);
                  $no = 1;
                  while ($row = mysqli_fetch_array($query_users)) {
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo htmlspecialchars($row['username']); ?></td>
                      <td><?php echo htmlspecialchars($row['email']); ?></td>
                      <td>
                        <!-- Menampilkan Status Email Verified dengan Badge -->
                        <?php
                        if ($row['email_verified'] == 1) {
                          echo '<span class="badge bg-success">Terverifikasi</span>';
                        } else {
                          echo '<span class="badge bg-warning text-dark">Belum Terverifikasi</span>';
                        }
                        ?>
                      </td>
                      <td>
                        <!-- Menampilkan Status isActive dengan Badge -->
                        <?php
                        if ($row['isActive'] == 1) {
                          echo '<span class="badge bg-success">Aktif</span>';
                        } else {
                          echo '<span class="badge bg-danger">Non-Aktif</span>';
                        }
                        ?>
                      </td>
                      <td>
                        <!-- View Detail Button (Triggers Modal) -->
                        <button class="btn btn-info btn-view-user" data-id="<?php echo $row['id_user']; ?>" data-bs-toggle="modal" data-bs-target="#modalDetailUser<?php echo $row['id_user']; ?>" title="Lihat Detail">
                          <i class="bi bi-eye"></i>
                        </button>

                        <!-- Modal Detail Pengguna -->
                        <div class="modal fade" id="modalDetailUser<?php echo $row['id_user']; ?>" tabindex="-1" aria-labelledby="modalDetailUserLabel<?php echo $row['id_user']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailUserLabel<?php echo $row['id_user']; ?>">Detail Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <!-- Displaying User Details in Modal -->
                                <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>

                                <!-- Status Email Verification with Badge -->
                                <p><strong>Status Email:</strong>
                                  <?php
                                  if ($row['email_verified'] == 1) {
                                    echo '<span class="badge bg-success">Terverifikasi</span>';
                                  } else {
                                    echo '<span class="badge bg-warning text-dark">Belum Terverifikasi</span>';
                                  }
                                  ?>
                                </p>

                                <!-- Status isActive with Badge -->
                                <p><strong>Status Akun:</strong>
                                  <?php
                                  if ($row['isActive'] == 1) {
                                    echo '<span class="badge bg-success">Aktif</span>';
                                  } else {
                                    echo '<span class="badge bg-danger">Non-Aktif</span>';
                                  }
                                  ?>
                                </p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateUser<?php echo $row['id_user']; ?>" title="Ubah Status Pengguna">
                          <i class="bi bi-pencil"></i>
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

  <?php
  include 'footer.php';
  ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
