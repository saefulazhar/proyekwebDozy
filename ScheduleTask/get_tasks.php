<?php
// Koneksi ke database
require '../Function/function.php';

// Ambil bulan dan tahun dari query string (optional)
$month = isset($_GET['month']) ? $_GET['month'] : date('m'); // Default bulan saat ini
$year = isset($_GET['year']) ? $_GET['year'] : date('Y'); // Default tahun saat ini

// Query untuk mengambil tugas berdasarkan bulan dan tahun
$sql = "SELECT * FROM task WHERE MONTH(due_date) = ? AND YEAR(due_date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $month, $year);
$stmt->execute();
$result = $stmt->get_result();

// Membuat array untuk menyimpan data event
$events = [];

while ($row = $result->fetch_assoc()) {
    // Menambahkan event dengan format yang diterima oleh FullCalendar
    $events[] = [
        'title' => $row['task_title'], // Menggunakan task_title
        'start' => $row['due_date'] . 'T09:00:00', // Set waktu mulai (misal pukul 09:00)
        'end' => $row['due_date'] . 'T17:00:00',   // Set waktu selesai (misal pukul 17:00)
        'description' => $row['description'], // Menggunakan description
        'priority' => $row['priority'],  // Menggunakan priority
        'status' => $row['status']      // Menggunakan status
    ];
}

// Mengembalikan data dalam format JSON
echo json_encode($events);

// Menutup koneksi
$stmt->close();
$conn->close();
?>
