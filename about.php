<?php
session_start(); // Mulai session
require_once("koneksi.php");
error_reporting(0);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Gramedia</title>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, user-scalable=no" />
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
        <h1>About Us</h1>

        <div class="image main">
          <img
            src="images/gramedia.png"
            class="img-fluid"
            alt=""
            width="auto"
            height="200px" />
        </div>

        <p>
          Gramedia adalah jaringan toko buku terbesar di Indonesia yang
          berdiri sejak tahun 1970. Kami hadir untuk memenuhi kebutuhan
          masyarakat akan buku, alat tulis, dan perlengkapan edukasi lainnya.
          Dengan slogan "Membuka Jendela Dunia", Gramedia berkomitmen menjadi
          pusat literasi yang mendukung pembelajaran dan kreativitas.
        </p>
        <p>
          Di setiap cabang kami, termasuk di Makassar, pelanggan dapat
          menemukan berbagai koleksi buku, mulai dari buku lokal,
          internasional, hingga buku digital. Tidak hanya itu, kami juga
          menyediakan perlengkapan sekolah, alat tulis, hingga kebutuhan untuk
          profesional. Dengan layanan online yang tersedia, pengalaman belanja
          di Gramedia menjadi lebih mudah dan nyaman.
        </p>
        <p>
          Gramedia juga berperan aktif dalam mendukung perkembangan budaya
          membaca melalui berbagai kegiatan seperti diskusi buku, pelatihan
          menulis, hingga promosi literasi di kalangan anak-anak. Kami percaya
          bahwa membaca bukan hanya kebutuhan, tetapi juga jembatan menuju
          masa depan yang lebih baik.
        </p>
      </div>
    </div>

    <!-- Footer -->
    <footer id="footer">
      <div class="inner">
        <section>
          <ul class="icons">
            <li>
              <a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a>
            </li>
            <li>
              <a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a>
            </li>
            <li>
              <a href="#" class="icon style2 fa-instagram"><span class="label">Instagram</span></a>
            </li>
            <li>
              <a href="#" class="icon style2 fa-linkedin"><span class="label">LinkedIn</span></a>
            </li>
          </ul>

          &nbsp;
        </section>

        <ul class="copyright">
          <li>Copyright © 2020 Company Name</li>
          <li>
            Template by:
            <a href="https://www.phpjabbers.com/">PHPJabbers.com</a>
          </li>
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