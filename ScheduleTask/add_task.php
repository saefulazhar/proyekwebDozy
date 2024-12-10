<?php
session_start(); // Pastikan sesi sudah dimulai

// Cek apakah user_id ada di sesi
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in");
}

// Koneksi ke database
require_once '../function/function.php'; // Pastikan sudah ada file koneksi dengan database

// Ambil data dari form
$title = isset($_POST['title']) ? $_POST['title'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
$priority = isset($_POST['priority']) ? $_POST['priority'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Validasi input
if (!empty($title) && !empty($due_date) && !empty($priority) && !empty($status) && $user_id !== null) {
    // Pastikan format due_date benar
    $date_format = 'Y-m-d\TH:i'; // Format yang diharapkan oleh datetime-local
    $date = DateTime::createFromFormat($date_format, $due_date);
    if ($date && $date->format($date_format) === $due_date) {
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
        // Jika format due_date salah
        header('Location: schedule.php?error=invalid_date_format');
    }
} else {
    // Jika data tidak lengkap atau user_id kosong
    header('Location: schedule.php?error=1');
}

$conn->close();
?>
