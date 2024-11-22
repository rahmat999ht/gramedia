<?php
session_start(); // Mulai session
require_once("../koneksi.php");
error_reporting(0);

// Periksa jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Silakan login terlebih dahulu."); window.location.href="../index.php";</script>';
    exit;
}

$user_id = $_SESSION['user_id']; // Ambil id_user dari session
$product_id = $_POST['product_id']; // Ambil id_product yang dikirim dari form
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Ambil jumlah produk

// Cek apakah pengguna sudah memiliki keranjang
$query = "SELECT id_cart FROM cart WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Jika belum ada keranjang, buat keranjang baru
if ($result->num_rows == 0) {
    $insert_cart = "INSERT INTO cart (id_user) VALUES (?)";
    $stmt_insert = $koneksi->prepare($insert_cart);
    $stmt_insert->bind_param('i', $user_id);
    $stmt_insert->execute();

    $cart_id = $stmt_insert->insert_id; // Ambil id_cart yang baru dibuat
    echo '<script>alert("Keranjang baru berhasil dibuat."); window.location.href="../index.php";</script>';
} else {
    $cart_id = $result->fetch_assoc()['id_cart']; // Ambil id_cart dari hasil query
}

// Cek apakah produk sudah ada di keranjang
$query_item = "SELECT id_item FROM cart_items WHERE id_cart = ? AND id_book = ?";
$stmt_item = $koneksi->prepare($query_item);
$stmt_item->bind_param('ii', $cart_id, $product_id);
$stmt_item->execute();
$item_result = $stmt_item->get_result();

if ($item_result->num_rows > 0) {
    // Jika item sudah ada, update jumlahnya
    $update_item = "UPDATE cart_items SET quantity = quantity + ? WHERE id_cart = ? AND id_book = ?";
    $stmt_update = $koneksi->prepare($update_item);
    $stmt_update->bind_param('iii', $quantity, $cart_id, $product_id);
    $stmt_update->execute();

    echo '<script>alert("Jumlah item berhasil diperbarui di keranjang."); window.location.href="../index.php";</script>';
} else {
    // Jika item belum ada, tambahkan item baru ke cart_items
    $insert_item = "INSERT INTO cart_items (id_cart, id_book, quantity) VALUES (?, ?, ?)";
    $stmt_insert_item = $koneksi->prepare($insert_item);
    $stmt_insert_item->bind_param('iii', $cart_id, $product_id, $quantity);
    $stmt_insert_item->execute();

    echo '<script>alert("Produk berhasil ditambahkan ke keranjang."); window.location.href="../index.php";</script>';
}
