<?php
// Mengaktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../function/function.php'; // File koneksi database

$today = date('Y-m-d'); // Tanggal hari ini
$tomorrow = date('Y-m-d', strtotime('+1 day')); // Tanggal besok

// Ambil tugas yang deadline-nya besok
$stmt = $conn->prepare("SELECT title, due_date, email FROM tasks JOIN users ON tasks.user_id = users.id WHERE due_date = ?");
$stmt->bind_param('s', $tomorrow);
$stmt->execute();
$result = $stmt->get_result();

// Kirim notifikasi email
while ($task = $result->fetch_assoc()) {
    $to = $task['email'];
    $subject = "Task Reminder: " . $task['title'];
    $message = "Hai! Tugas Anda \"" . $task['title'] . "\" memiliki deadline pada " . $task['due_date'] . ". Jangan lupa diselesaikan ya!";
    $headers = "From: no-reply@dozy.com";

    mail($to, $subject, $message, $headers); // Fungsi bawaan PHP untuk kirim email
}

echo "Notifikasi terkirim!";
?>
