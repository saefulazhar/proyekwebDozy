<?php
// Mulai sesi
session_start();

// Hancurkan semua data sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi

// Arahkan pengguna kembali ke halaman login
header("Location: ../Login/login.php");
exit(); // Pastikan tidak ada kode lain yang dieksekusi
?>
