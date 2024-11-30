<?php
session_start();
require_once("../koneksi.php"); // Menghubungkan ke database

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT * FROM users WHERE verification_token = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $updateQuery = "UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = ?";
        $updateStmt = mysqli_prepare($koneksi, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "s", $token);

        if (mysqli_stmt_execute($updateStmt)) {
            echo '<script>alert("Email berhasil diverifikasi. Anda dapat login sekarang."); window.location.href="../index.php";</script>';
        } else {
            echo '<script>alert("Gagal memverifikasi email."); window.location.href="../index.php";</script>';
        }
    } else {
        echo '<script>alert("Token verifikasi tidak valid atau sudah digunakan."); window.location.href="../index.php";</script>';
    }
} else {
    echo '<script>alert("Token verifikasi tidak ditemukan."); window.location.href="../index.php";</script>';
}
