<?php
session_start(); // Mulai sesi

function logout()
{
    // Hapus semua session yang terkait dengan login
    unset($_SESSION['user_id']);
    unset($_SESSION['user_username']);
    unset($_SESSION['user_email']);

    session_destroy(); // Menghancurkan sesi
    header("Location: ../index.php"); // Mengarahkan pengguna ke halaman utama
    exit();
}

// Memanggil fungsi logout
logout();
