<?php
$koneksi = mysqli_connect("localhost", "root", "3737", "gramedia");

if (mysqli_connect_errno()) {
	echo "koneksi gagal " . mysql_connect_error();
}

// <?php
// // Definisi variabel untuk koneksi database
// $host = "localhost";
// $username = "adip8555_gudang";
// $password = "gudang12345";
// $database = "adip8555_gramedia";

// // Membuat koneksi
// $koneksi = mysqli_connect($host, $username, $password, $database);

// // Mengecek apakah koneksi berhasil
// if (mysqli_connect_errno()) {
//     echo "Koneksi gagal: " . mysqli_connect_error();
// }
// ?>

