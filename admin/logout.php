<?php
session_start();

// Hapus semua session yang terkait dengan login
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);
unset($_SESSION['admin_role']);

// Menghancurkan session
session_destroy();

// Redirect ke halaman login setelah logout
echo '<script>alert("Berhasil logout!"); window.location="login.php";</script>';
?>
