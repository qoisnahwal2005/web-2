<?php
// File: koneksi.php

$host = "localhost";       // Nama host
$user = "root";            // Username database
$password = "";            // Password database
$database = "dbkegiatan_dosen"; // Nama database

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>