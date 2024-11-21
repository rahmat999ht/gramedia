<?php

session_start();
require_once("../../koneksi.php");

// Fungsi untuk memperbarui kolom isActive pengguna
function updateIsActive($id_user, $isActive)
{
    global $koneksi;  // Menggunakan koneksi database global

    // Query untuk memperbarui kolom isActive
    $query = "UPDATE users SET isActive = ? WHERE id_user = ?";

    // Menyiapkan statement
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        // Mengikat parameter
        mysqli_stmt_bind_param($stmt, "ii", $isActive, $id_user);

        // Menjalankan query
        if (mysqli_stmt_execute($stmt)) {
            return true;  // Pembaruan berhasil
        } else {
            return false; // Pembaruan gagal
        }
    } else {
        return false;  // Jika query gagal disiapkan
    }
}

if (!$_SESSION['admin_role']) {
    echo '<script>alert("Anda belum login atau session login berakhir."); window.location.href="login.php";</script>';
    exit;
}

// Mengambil data yang diterima dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $isActive = $_POST['isActive'];

    // Panggil fungsi untuk memperbarui kolom isActive
    if (updateIsActive($id_user, $isActive)) {
        echo '<script>alert("Status pengguna berhasil diperbarui."); window.location.href="../tables-pengguna.php";</script>';
    } else {
        echo '<script>alert("Gagal memperbarui status pengguna."); window.location.href="../tables-pengguna.php";</script>';
    }
}
