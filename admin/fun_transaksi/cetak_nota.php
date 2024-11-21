<?php
require_once("../../koneksi.php");
require_once("../../vendor/autoload.php"); // Autoload file Composer

use Mpdf\Mpdf;

if (isset($_GET['id_cart'])) {
    $id_cart = intval($_GET['id_cart']);

    // Query untuk mendapatkan data nota
    $sql = "SELECT cart.id_cart, users.username, books.title, cart_items.quantity, books.price
            FROM cart_items
            JOIN cart ON cart_items.id_cart = cart.id_cart
            JOIN users ON cart.id_user = users.id_user
            JOIN books ON cart_items.id_book = books.id_book
            WHERE cart.id_cart = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_cart);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Buffer untuk output HTML
        ob_start();
        echo "<h2 style='text-align: center;'>Nota Transaksi</h2>";
        echo "<hr>";
        echo "<p><strong>Tanggal:</strong> " . date('d/m/Y') . "</p>";

        $totalPrice = 0; // Variabel untuk menyimpan total harga

        if ($row = $result->fetch_assoc()) {
            $subtotal = $row['quantity'] * $row['price'];
            $totalPrice += $subtotal;

            echo "<p><strong>Nama Pengguna:</strong> " . htmlspecialchars($row['username']) . "</p>";
            echo "<p><strong>Judul Buku:</strong> " . htmlspecialchars($row['title']) . "</p>";
            echo "<p><strong>Harga:</strong> Rp " . number_format($row['price'], 0, ',', '.') . "</p>";
            echo "<p><strong>Jumlah:</strong> " . $row['quantity'] . "</p>";
            echo "<hr>";
        }

        echo "<p><strong>Total Harga:</strong> Rp " . number_format($totalPrice, 0, ',', '.') . "</p>";

        $html = ob_get_clean(); // Ambil output buffer

        // Buat instance MPDF dengan ukuran kertas custom
        $mpdf = new Mpdf([
            'format' => [120, 120], // Lebar: 58mm, Tinggi: 297mm
            'orientation' => 'P' // Portrait
        ]);

        // Tambahkan HTML ke MPDF
        $mpdf->WriteHTML($html);

        // Output file PDF
        $mpdf->Output("Nota_Transaksi_$id_cart.pdf", 'I'); // 'I' untuk inline view di browser
    } else {
        echo "<p>Data tidak ditemukan!</p>";
    }
    $stmt->close();
} else {
    echo "<p>ID Keranjang tidak valid.</p>";
}
