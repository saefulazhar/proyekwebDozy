<?php
session_start(); // Mulai sesi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mengimpor file koneksi database
require_once '../function/function.php'; // Pastikan path sudah benar

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User belum login']);
    exit();
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Memeriksa apakah ada parameter bulan dan tahun
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

try {
    // Query dengan filter tambahan berdasarkan user_id
    $stmt = $conn->prepare("
        SELECT title, due_date, priority
        FROM task 
        WHERE user_id = ? AND MONTH(due_date) = ? AND YEAR(due_date) = ?
    ");
    $stmt->bind_param('iii', $user_id, $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        // Konversi format due_date ke 'YYYY-MM-DD'
        $row['due_date'] = date('Y-m-d', strtotime($row['due_date']));
        $tasks[] = $row;
    }

    // Mengirimkan data tugas dalam format JSON
    echo json_encode($tasks);
} catch (Exception $e) {
    // Menangani error dan mengirimkan pesan error dalam format JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
