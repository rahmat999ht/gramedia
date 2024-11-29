<?php
session_start();
require_once("../koneksi.php");
require_once("../vendor/autoload.php"); // Sesuaikan dengan lokasi file autoload.php dari mPDF

// Periksa apakah order_id tersedia di URL
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo '<script>alert("Order ID tidak ditemukan."); window.location.href = "../checkout.php";</script>';
    exit;
}

$order_id = $_GET['order_id'];

// Ambil data pesanan berdasarkan order_id
$queryOrder = "
    SELECT o.id_order, o.order_date, u.username AS user_name, i.invoice_date, i.total_amount, 
           od.name, od.phone, od.address, od.city, od.state, od.zip
    FROM orders o
    JOIN invoices i ON o.id_order = i.id_order
    JOIN users u ON o.id_user = u.id_user
    JOIN order_details od ON o.id_order = od.id_order
    WHERE o.id_order = ?";

$stmtOrder = $koneksi->prepare($queryOrder);

if (!$stmtOrder) {
    die("Gagal mempersiapkan query order: " . $koneksi->error);
}

$stmtOrder->bind_param("i", $order_id);
$stmtOrder->execute();
$orderResult = $stmtOrder->get_result();

if ($orderResult->num_rows === 0) {
    echo '<script>alert("Pesanan tidak ditemukan."); window.location.href = "../checkout.php";</script>';
    exit;
}

$orderData = $orderResult->fetch_assoc();

// Ambil detail pesanan
$queryOrderDetails = "
    SELECT od.id_book, b.title AS book_title, od.quantity, b.price, (od.quantity * b.price) AS total_price
    FROM order_details od
    JOIN books b ON od.id_book = b.id_book
    WHERE od.id_order = ?";
$stmtOrderDetails = $koneksi->prepare($queryOrderDetails);

if (!$stmtOrderDetails) {
    die("Gagal mempersiapkan query order details: " . $koneksi->error);
}

$stmtOrderDetails->bind_param("i", $order_id);
$stmtOrderDetails->execute();
$orderDetailsResult = $stmtOrderDetails->get_result();

$orderDetails = [];
while ($row = $orderDetailsResult->fetch_assoc()) {
    $orderDetails[] = $row;
}

// Inisialisasi mPDF
$mpdf = new \Mpdf\Mpdf();

// Buat HTML untuk PDF
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete</title>
</head>
<body>
    <div style="text-align: center;">
        <h1>Terima Kasih atas Pesanan Anda!</h1>
        <p>Order ID: <strong>' . htmlspecialchars($orderData['id_order']) . '</strong></p>
        <p>Nama Pemesan: <strong>' . htmlspecialchars($orderData['user_name']) . '</strong></p>
        <p>Tanggal Pesanan: <strong>' . htmlspecialchars($orderData['order_date']) . '</strong></p>

        <h2>Informasi Pengiriman</h2>
        <p>Nama: <strong>' . htmlspecialchars($orderData['name']) . '</strong></p>
        <p>Nomor Telepon: <strong>' . htmlspecialchars($orderData['phone']) . '</strong></p>
        <p>Alamat: <strong>' . htmlspecialchars($orderData['address']) . '</strong></p>
        <p>Kota: <strong>' . htmlspecialchars($orderData['city']) . '</strong></p>
        <p>Provinsi: <strong>' . htmlspecialchars($orderData['state']) . '</strong></p>
        <p>Kode Pos: <strong>' . htmlspecialchars($orderData['zip']) . '</strong></p>

        <h2>Detail Pesanan</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>';

foreach ($orderDetails as $detail) {
    $html .= '
        <tr>
            <td>' . htmlspecialchars($detail['book_title']) . '</td>
            <td>' . htmlspecialchars($detail['quantity']) . '</td>
            <td>Rp ' . number_format($detail['price'], 2, ',', '.') . '</td>
            <td>Rp ' . number_format($detail['total_price'], 2, ',', '.') . '</td>
        </tr>';
}

$html .= '
            </tbody>
        </table>
        <p>Total Pembayaran: <strong>Rp ' . number_format($orderData['total_amount'], 2, ',', '.') . '</strong></p>
    </div>
</body>
</html>';

$mpdf->WriteHTML($html);

// Output PDF ke browser
$mpdf->Output('order_complete.pdf', 'I');
exit;
?>
