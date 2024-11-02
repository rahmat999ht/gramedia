<?php
$koneksi = mysqli_connect("localhost", "root", "3737", "gramedia");

if (mysqli_connect_errno()) {
	echo "koneksi gagal " . mysql_connect_error();
}
