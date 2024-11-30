<?php
session_start(); // Mulai session
require_once("koneksi.php");
error_reporting(0);

// Query untuk buku terlaris
$query_buku_terlaris = "SELECT 
        b.id_book, 
        b.image, 
        b.title, 
        b.price, 
        b.stock, 
        COALESCE(SUM(od.quantity), 0) AS total_sold
    FROM 
        books b
    LEFT JOIN 
        order_details od ON b.id_book = od.id_book
    GROUP BY 
        b.id_book
    ORDER BY 
        total_sold DESC
    LIMIT 6";

$result_buku_terlaris = mysqli_query($koneksi, $query_buku_terlaris);

if (!$result_buku_terlaris) {
  die("Error pada query: " . mysqli_error($koneksi));
}

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
      <div
        id="carouselExampleIndicators"
        class="carousel slide"
        data-ride="carousel">
        <ol class="carousel-indicators">
          <li
            data-target="#carouselExampleIndicators"
            data-slide-to="0"
            class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img
              class="d-block w-100"
              src="images/slider-image-1-1920x700.jpg"
              alt="First slide" />
          </div>
          <div class="carousel-item">
            <img
              class="d-block w-100"
              src="images/slider-image-2-1920x700.jpg"
              alt="Second slide" />
          </div>
          <div class="carousel-item">
            <img
              class="d-block w-100"
              src="images/slider-image-3-1920x700.jpg"
              alt="Third slide" />
          </div>
        </div>
        <a
          class="carousel-control-prev"
          href="#carouselExampleIndicators"
          role="button"
          data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a
          class="carousel-control-next"
          href="#carouselExampleIndicators"
          role="button"
          data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <br />
      <br />

      <div class="inner">
        <!-- About Us -->
        <header id="inner">
          <h1>Find your new book!</h1>
          <p>
            Etiam quis viverra lorem, in semper lorem. Sed nisl arcu euismod
            sit amet nisi euismod sed cursus arcu elementum ipsum arcu vivamus
            quis venenatis orci lorem ipsum et magna feugiat veroeros aliquam.
            Lorem ipsum dolor sit amet nullam dolore.
          </p>
        </header>

        <br />

        <!-- Buku Terlaris -->
        <h2 class="h2">Buku Terlaris</h2>
        <section class="tiles">
          <?php while ($row = mysqli_fetch_assoc($result_buku_terlaris)):
            // Tentukan gambar yang akan digunakan
            $bookImage = !empty($row['image']) ? 'images/' . htmlspecialchars($row['image']) : 'images/product-6-720x480.jpg';
          ?>
            <article class="style1">
              <span class="image">
                <img width="300px" height="260px" src="<?php echo $bookImage; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" />
              </span>
              <a href="product-details.php?id=<?php echo $row['id_book']; ?>">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><strong>Rp. <?php echo number_format($row['price'], 0, ',', '.'); ?></strong></p>
                <!-- Menampilkan total sold-out -->
                <p>Total Terjual: <?php echo $row['total_sold']; ?> Buku</p>
              </a>
            </article>
          <?php endwhile; ?>
        </section>

        <p class="text-center">
          <a href="products.php">More Books &nbsp;<i class="fa fa-long-arrow-right"></i></a>
        </p>

        <br />
      </div>
    </div>

    <!-- Footer -->
    <footer id="footer">
      <div class="inner">
        <section>
          <h2>Contact Us</h2>
          <form method="post" action="#">
            <div class="fields">
              <div class="field half">
                <input type="text" name="name" id="name" placeholder="Name" />
              </div>

              <div class="field half">
                <input
                  type="text"
                  name="email"
                  id="email"
                  placeholder="Email" />
              </div>

              <div class="field">
                <input
                  type="text"
                  name="subject"
                  id="subject"
                  placeholder="Subject" />
              </div>

              <div class="field">
                <textarea
                  name="message"
                  id="message"
                  rows="3"
                  placeholder="Notes"></textarea>
              </div>

              <div class="field text-right">
                <label>&nbsp;</label>

                <ul class="actions">
                  <li>
                    <input
                      type="submit"
                      value="Send Message"
                      class="primary" />
                  </li>
                </ul>
              </div>
            </div>
          </form>
        </section>
        <section>
          <h2>Contact Info</h2>

          <ul class="alt">
            <li>
              <span class="fa fa-envelope-o"></span>
              <a href="#">contact@company.com</a>
            </li>
            <li><span class="fa fa-phone"></span> +1 333 4040 5566</li>
            <li>
              <span class="fa fa-map-pin"></span> 212 Barrington Court New
              York, ABC 10001 United States of America
            </li>
          </ul>

          <h2>Follow Us</h2>

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