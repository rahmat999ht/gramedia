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
    <!-- Header -->
    <header id="header">
      <div class="inner">
        <!-- Logo -->
        <a href="index.html" class="logo">
          <span class="fa fa-book"></span> <span class="title">Gramedia</span>
        </a>

        <!-- Nav -->
        <nav>
          <ul>
            <?php if (isset($_SESSION['username'])): ?>
              <!-- Cek jika session username ada -->
              <li class="pe-3">
                <a href="#" class="akun">
                  <h3>Welcome,</h3>
                  <h3>
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                  </h3>
                  <!-- Tampilkan username -->
                </a>
              </li>
            <?php else: ?>
              <!-- Jika belum login -->
              <li>
                <a
                  href="#"
                  class="akun"
                  data-toggle="modal"
                  data-target="#registerModal"
                  data-whatever="@getbootstrap">
                  <h3>Register</h3>
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="akun"
                  data-toggle="modal"
                  data-target="#loginModal"
                  data-whatever="@getbootstrap">
                  <h3>Login</h3>
                </a>
              </li>
            <?php endif; ?>
            <li><a href="#menu">Menu</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Menu -->
    <nav id="menu">
      <h2>Menu</h2>
      <ul>
        <li><a href="index.html" class="active">Home</a></li>

        <li><a href="products.html">Products</a></li>

        <li><a href="checkout.html">Checkout</a></li>

        <li>
          <a href="#" class="dropdown-toggle">About</a>
          <ul>
            <li><a href="about.html">About Us</a></li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="testimonials.html">Testimonials</a></li>
            <li><a href="terms.html">Terms</a></li>
          </ul>
        </li>

        <li><a href="contact.html">Contact Us</a></li>
        <?php if (isset($_SESSION['username'])): ?>
          <li><a href="logout_user.php">Log-Out</a></li>
        <?php endif; ?>
      </ul>
    </nav>

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

        <h2 class="h2">Featured Products</h2>

        <!-- Products -->
        <section class="tiles">
          <article class="style1">
            <span class="image">
              <img src="images/product-1-720x480.jpg" alt="" />
            </span>
            <a href="product-details.html">
              <h2>Lorem ipsum dolor sit amet, consectetur</h2>

              <p><del>$19.00</del> <strong>$19.00</strong></p>

              <p>
                Vestibulum id est eu felis vulputate hendrerit uspendisse
                dapibus turpis in
              </p>
            </a>
          </article>
          <article class="style2">
            <span class="image">
              <img src="images/product-2-720x480.jpg" alt="" />
            </span>
            <a href="product-details.html">
              <h2>Lorem ipsum dolor sit amet, consectetur</h2>

              <p><del>$19.00</del> <strong>$19.00</strong></p>

              <p>
                Vestibulum id est eu felis vulputate hendrerit uspendisse
                dapibus turpis in
              </p>
            </a>
          </article>
          <article class="style3">
            <span class="image">
              <img src="images/product-3-720x480.jpg" alt="" />
            </span>
            <a href="product-details.html">
              <h2>Lorem ipsum dolor sit amet, consectetur</h2>

              <p><del>$19.00</del> <strong>$19.00</strong></p>

              <p>
                Vestibulum id est eu felis vulputate hendrerit uspendisse
                dapibus turpis in
              </p>
            </a>
          </article>

          <article class="style4">
            <span class="image">
              <img src="images/product-4-720x480.jpg" alt="" />
            </span>
            <a href="product-details.html">
              <h2>Lorem ipsum dolor sit amet, consectetur</h2>

              <p><del>$19.00</del> <strong>$19.00</strong></p>

              <p>
                Vestibulum id est eu felis vulputate hendrerit uspendisse
                dapibus turpis in
              </p>
            </a>
          </article>

          <article class="style5">
            <span class="image">
              <img src="images/product-5-720x480.jpg" alt="" />
            </span>
            <a href="product-details.html">
              <h2>Lorem ipsum dolor sit amet, consectetur</h2>

              <p><del>$19.00</del> <strong>$19.00</strong></p>

              <p>
                Vestibulum id est eu felis vulputate hendrerit uspendisse
                dapibus turpis in
              </p>
            </a>
          </article>

          <article class="style6">
            <span class="image">
              <img src="images/product-6-720x480.jpg" alt="" />
            </span>
            <a href="product-details.html">
              <h2>Lorem ipsum dolor sit amet, consectetur</h2>

              <p><del>$19.00</del> <strong>$19.00</strong></p>

              <p>
                Vestibulum id est eu felis vulputate hendrerit uspendisse
                dapibus turpis in
              </p>
            </a>
          </article>
        </section>

        <p class="text-center">
          <a href="products.html">More Books &nbsp;<i class="fa fa-long-arrow-right"></i></a>
        </p>

        <br />

        <h2 class="h2">Testimonials</h2>

        <div class="row">
          <div class="col-sm-6 text-center">
            <p class="m-n">
              <em>"Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Sunt delectus mollitia, debitis architecto recusandae? Quidem
                ipsa, quo, labore minima enim similique, delectus ullam non
                laboriosam laborum distinctio repellat quas deserunt voluptas
                reprehenderit dignissimos voluptatum deleniti saepe. Facere
                expedita autem quos."</em>
            </p>

            <p><strong> - John Doe</strong></p>
          </div>

          <div class="col-sm-6 text-center">
            <p class="m-n">
              <em>"Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Sunt delectus mollitia, debitis architecto recusandae? Quidem
                ipsa, quo, labore minima enim similique, delectus ullam non
                laboriosam laborum distinctio repellat quas deserunt voluptas
                reprehenderit dignissimos voluptatum deleniti saepe. Facere
                expedita autem quos."</em>
            </p>

            <p><strong>- John Doe</strong></p>
          </div>
        </div>

        <p class="text-center">
          <a href="testimonials.html">Read More &nbsp;<i class="fa fa-long-arrow-right"></i></a>
        </p>

        <br />

        <h2 class="h2">Blog</h2>

        <div class="row">
          <div class="col-sm-4 text-center">
            <img src="images/blog-1-720x480.jpg" class="img-fluid" alt="" />

            <h2 class="m-n">
              <a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
            </h2>

            <p>John Doe &nbsp;|&nbsp; 12/06/2020 10:30</p>
          </div>

          <div class="col-sm-4 text-center">
            <img src="images/blog-2-720x480.jpg" class="img-fluid" alt="" />

            <h2 class="m-n">
              <a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
            </h2>

            <p>John Doe &nbsp;|&nbsp; 12/06/2020 10:30</p>
          </div>

          <div class="col-sm-4 text-center">
            <img src="images/blog-3-720x480.jpg" class="img-fluid" alt="" />

            <h2 class="m-n">
              <a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
            </h2>

            <p>John Doe &nbsp;|&nbsp; 12/06/2020 10:30</p>
          </div>
        </div>

        <p class="text-center">
          <a href="blog.html">Read More &nbsp;<i class="fa fa-long-arrow-right"></i></a>
        </p>
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
          <form method="post" action="login_user.php">
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
          <form method="post" action="register_user.php"> <!-- Ganti dengan path ke script register Anda -->
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