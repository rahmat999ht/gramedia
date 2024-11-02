<?php
session_start(); // Mulai sesi

function logout() {
    // Menghancurkan semua sesi
    session_unset(); // Menghapus semua variabel sesi
    session_destroy(); // Menghancurkan sesi
    header("Location: index.php"); // Mengarahkan pengguna ke halaman utama
    exit();
}

// Memanggil fungsi logout
logout();
?>
