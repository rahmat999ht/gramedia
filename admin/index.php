<?php
session_start(); // Start session
require_once("../koneksi.php");
error_reporting(0);

if (!$_SESSION['admin_role']) {
  echo '<script>alert("Anda belum login atau session login berakhir"); window.location.href="login.php";</script>';
  exit;
}

// Query for sales data (e.g., total sales today)
$sales_query = "SELECT SUM(total_amount) AS total_sales_today FROM invoices WHERE DATE(invoice_date) = CURDATE()";
$sales_result = mysqli_query($koneksi, $sales_query);
$sales_data = mysqli_fetch_assoc($sales_result);
$total_sales_today = $sales_data['total_sales_today'] ?? 0;

// Query for total orders
$orders_query = "SELECT COUNT(*) AS total_orders FROM orders";
$orders_result = mysqli_query($koneksi, $orders_query);
$orders_data = mysqli_fetch_assoc($orders_result);
$total_orders = $orders_data['total_orders'] ?? 0;

// Query for total books in stock
$books_query = "SELECT SUM(stock) AS total_books_in_stock FROM books";
$books_result = mysqli_query($koneksi, $books_query);
$books_data = mysqli_fetch_assoc($books_result);
$total_books_in_stock = $books_data['total_books_in_stock'] ?? 0;


// Tangkap filter dari URL (default: Today)
$filter = $_GET['filter'] ?? 'today';

// Tentukan rentang waktu berdasarkan filter
$filter_condition = "DATE(order_date) = CURDATE()"; // Default: Today
if ($filter === 'this_month') {
  $filter_condition = "MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
} elseif ($filter === 'this_year') {
  $filter_condition = "YEAR(order_date) = YEAR(CURDATE())";
}

// Query total orders berdasarkan filter
$orders_query = "SELECT COUNT(*) AS total_orders FROM orders WHERE $filter_condition";
$orders_result = mysqli_query($koneksi, $orders_query);
$orders_data = mysqli_fetch_assoc($orders_result);
$total_orders = $orders_data['total_orders'] ?? 0;

// Query top selling products berdasarkan filter
$query_top_selling_today = "
    SELECT 
        b.image, 
        b.title AS product_name, 
        b.price, 
        SUM(od.quantity) AS sold,
        (b.price * SUM(od.quantity)) AS revenue,
        o.order_date
    FROM 
        books b
    JOIN 
        order_details od ON b.id_book = od.id_book
    JOIN 
        orders o ON od.id_order = o.id_order
    WHERE 
        $filter_condition
    GROUP BY 
        b.id_book, o.order_date
    ORDER BY 
        revenue DESC 
    LIMIT 5";

$result_top_selling_today = mysqli_query($koneksi, $query_top_selling_today);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Dashboard</title>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Sales <span>| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo "Rp " . number_format($total_sales_today, 0, ',', '.'); ?></h6>
                      <span class="text-success small pt-1 fw-bold">12%</span>
                      <span class="text-muted small pt-2 ps-1">increase</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Orders Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Orders <span>| Total</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-box"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_orders; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Books in Stock Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card books-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Books in Stock</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-book"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_books_in_stock; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Top Selling -->
          <div class="col-12">
            <div class="card top-selling overflow-auto">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="?filter=today">Today</a></li>
                  <li><a class="dropdown-item" href="?filter=this_month">This Month</a></li>
                  <li><a class="dropdown-item" href="?filter=this_year">This Year</a></li>
                </ul>
              </div>

              <div class="card-body pb-0">
                <h5 class="card-title">Transaksi Terlaris <span>| <?php echo ucfirst(str_replace('_', ' ', $filter)); ?></span></h5>

                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th scope="col">Preview</th>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                      <th scope="col">Sold</th>
                      <th scope="col">Revenue</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Menampilkan produk terlaris hari ini
                    if (mysqli_num_rows($result_top_selling_today) > 0) {
                      while ($row = mysqli_fetch_assoc($result_top_selling_today)) {
                        $bookImage = !empty($row['image']) ? '../../images/' . htmlspecialchars($row['image']) : 'assets/img/logo.png';
                        echo "<tr>
                          <th scope='row'>
                            <a href='#'><img src='{$bookImage}' alt='{$row['product_name']}' style='width: auto; height: 40px;'></a>
                          </th>
                          <td>
                            <a href='#'>{$row['product_name']}</a>
                          </td>
                          <td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>
                          <td>{$row['sold']}</td>
                          <td>Rp " . number_format($row['revenue'], 0, ',', '.') . "</td>
                          <td>" . date('d M Y', strtotime($row['order_date'])) . "</td>
                        </tr>";
                      }
                    } else {
                      // Jika tidak ada data
                      echo "<tr>
                        <td colspan='6' class='text-center'>
                          <div class='card'>
                            <div class='card-body'>
                              <h5 class='card-title'>Tidak ada data untuk ditampilkan</h5>
                            </div>
                          </div>
                        </td>
                      </tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>