<?php

include_once "koneksi.php";

function login($username, $password)
{
    global $koneksi;

    // Meng-hash password yang dimasukkan
    $hashedPassword = md5($password);

    // Menyiapkan query SQL menggunakan prepared statements
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $ketemu = mysqli_num_rows($result);
        $b = mysqli_fetch_array($result);

        if ($ketemu > 0) {
            if ($b['email_verified'] == 1) {
                session_start();
                $_SESSION['id_user'] = $b['id_user'];
                $_SESSION['username'] = $b['username'];
                $_SESSION['email'] = $b['email'];
                echo '<script>alert("Login successful!"); window.location.href="index.php";</script>';
            } else {
                echo '<script>alert("Akun belum diverifikasi. Silakan cek email Anda untuk verifikasi."); window.location.href="index.php";</script>';
            }
        } else {
            echo '<script>alert("Username/Password salah atau akun Anda belum aktif."); window.location.href="index.php";</script>';
        }
    } else {
        echo '<script>alert("Query Error: ' . mysqli_error($koneksi) . '"); window.location.href="index.php";</script>';
    }
}

// Memanggil fungsi login saat form login disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    login($username, $password);
}
