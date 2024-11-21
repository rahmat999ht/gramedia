<?php

session_start(); // Mulai session
require_once("../../koneksi.php");
error_reporting(0);

// Ambil data dari form
$id_user = $_POST['id_user'];
$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Pastikan semua data yang diperlukan ada
if (empty($name) || empty($email) || empty($password)) {
    echo '<script>alert("Semua field harus diisi."); window.history.back();</script>';
    exit();
}

// Jika password baru dimasukkan, hash password baru
if (!empty($password)) {
    $hashed_password = md5($password); // atau password_hash() jika Anda menggunakan hash yang lebih aman
} else {
    // Jika password tidak diubah, gunakan password lama
    $hashed_password = $user['password'];
}

// Update data pengguna ke database
$sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id_user = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("sssi", $name, $email, $hashed_password, $id_user);

// Cek jika query berhasil
if ($stmt->execute()) {
    // Jika berhasil, tampilkan alert dan redirect
    echo '<script>alert("Data pengguna berhasil diperbarui."); window.location.href="../tables-pengguna.php";</script>';
} else {
    // Jika gagal, tampilkan alert dan kembali ke halaman sebelumnya
    echo '<script>alert("Terjadi kesalahan, data gagal diperbarui."); window.history.back();</script>';
}

// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();
exit();
