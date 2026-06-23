<?php
// koneksi.php

$host     = "localhost";
$username = "root";
$password = "";
$database = "db_kepegawaian";

// Membuat koneksi menggunakan MySQLi
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Set karakter encoding ke UTF-8 (opsional, tapi disarankan)
$koneksi->set_charset("utf8");
?>