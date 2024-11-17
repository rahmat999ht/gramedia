<?php
include_once("../koneksi.php");

function login($username, $password, $role)
{
    global $koneksi;

    // Meng-hash password yang dimasukkan
    $hashedPassword = md5($password);

    // Menyiapkan query SQL menggunakan prepared statements
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username = ? AND password = ? AND role = ?");
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPassword, $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $ketemu = mysqli_num_rows($result);
        $b = mysqli_fetch_array($result);

        if ($ketemu > 0) {
            session_start();
            $_SESSION['admin_id'] = $b['id_admin'];
            $_SESSION['admin_username'] = $b['username'];
            $_SESSION['admin_role'] = $b['role'];

            // Redirect berdasarkan role
            if ($b['role'] == 'admin' || $b['role'] == 'kasir' || $b['role'] == 'atasan') {
                echo '<script>alert("Anda login sebagai ' . $b["role"] . '"); window.location.href="index.php";</script>';
            } else {
                echo '<script>alert("Role tidak dikenali!"); window.location.href="login.php";</script>';
            }
        } else {
            echo '<script>alert("Username/Password/Role salah atau akun Anda belum aktif."); window.location.href="login.php";</script>';
        }
    } else {
        echo '<script>alert("Query Error: ' . mysqli_error($koneksi) . '"); window.location.href="login.php";</script>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Panggil fungsi login
    login($username, $password, $role);
}
