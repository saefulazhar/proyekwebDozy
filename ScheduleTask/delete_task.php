<?php
// Memanggil koneksi database
require(__DIR__ . '/../Function/function.php');

// Cek apakah parameter ID tersedia
if (isset($_GET['task_id'])) {
    $taskId = intval($_GET['task_id']); // Pastikan hanya angka yang diterima

    // Query untuk menghapus tugas berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM task WHERE task_id = ?");
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        // Redirect ke halaman dashboard dengan pesan sukses
        header("Location: ../Dashboard/home.php?message=TaskDeleted");
        exit();
    } else {
        // Redirect dengan pesan error jika penghapusan gagal
        header("Location: ../Dashboard/home.php?message=DeleteFailed");
        exit();
    }

    $stmt->close();
} else {
    // Redirect jika ID tidak valid
    header("Location: ../Dashboard/home.php?message=InvalidID");
    exit();
}
?>
