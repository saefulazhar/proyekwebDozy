<?php
session_start(); // Pastikan session diaktifkan untuk memeriksa login jika diperlukan
require_once '../function/function.php'; // Sesuaikan dengan lokasi file koneksi database Anda

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit; // Hentikan eksekusi jika pengguna belum login
}

// Ambil data bulan dan tahun dari parameter GET
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n'); // Bulan: 1-12
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');    // Tahun: YYYY

// Query untuk mengambil tugas pada bulan dan tahun tertentu berdasarkan user_id
$query = "SELECT task_id, title, due_date, status, progress, priority 
          FROM task
          WHERE MONTH(due_date) = ? AND YEAR(due_date) = ? AND user_id = ?"; // Filter berdasarkan user_id
$stmt = $conn->prepare($query);

// Bind parameter untuk query, pastikan user_id juga diteruskan
$user_id = $_SESSION['user_id']; // Ambil user_id dari session
$stmt->bind_param('iii', $month, $year, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row; // Simpan tugas dalam array
}

// Kirim data tugas dalam format JSON
header('Content-Type: application/json');
echo json_encode($tasks); // Tugas dikirim dalam format JSON

$stmt->close();
$conn->close();
?>
