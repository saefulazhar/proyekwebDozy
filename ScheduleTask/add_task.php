<?php
session_start(); // Pastikan sesi sudah dimulai

// Debugging: Cek apakah user_id ada di sesi
var_dump($_SESSION['user_id']); // Ini akan menampilkan nilai user_id jika ada di sesi

// Koneksi ke database
require_once '../function/function.php'; // Sesuaikan dengan lokasi file koneksi database Anda

// Ambil data dari form
$title = isset($_POST['title']) ? $_POST['title'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
$priority = isset($_POST['priority']) ? $_POST['priority'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Ambil user_id dari sesi
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Jika user_id tidak ada di sesi, hentikan eksekusi dan tampilkan pesan error
if ($user_id === null) {
    die("User is not logged in");
}

// Validasi input
if (!empty($title) && !empty($due_date) && $user_id !== null) {
    // Query untuk memasukkan tugas baru ke database
    $query = "INSERT INTO task (title, description, due_date, priority, status, progress, user_id) 
              VALUES (?, ?, ?, ?, ?, 0, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $title, $description, $due_date, $priority, $status, $user_id);
    
    if ($stmt->execute()) {
        // Redirect setelah berhasil
        header('Location: schedule.php?success=1');
    } else {
        // Jika gagal, tampilkan pesan error
        header('Location: schedule.php?error=1');
    }

    $stmt->close();
} else {
    // Jika data tidak lengkap atau user_id kosong
    header('Location: schedule.php?error=1');
}

$conn->close();
?>
