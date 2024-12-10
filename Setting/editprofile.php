<?php
session_start(); // Memulai session untuk akses ID pengguna yang sedang login

// Memanggil function.php yang ada di folder Function
$host = 'localhost'; // Ganti dengan host Anda
$dbname = 'dozy_db'; // Nama database Anda
$username = 'root'; // Username database Anda
$password = ''; // Password database Anda (kosong jika localhost)

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah pengguna sudah login dan ID pengguna ada dalam session
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada session user_id, arahkan ke halaman login
    header("Location: ../Login/login.php");
    exit();
}

// Mendapatkan ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Mendapatkan data dari form
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    
    // Menyaring input untuk menghindari SQL Injection
    $new_username = $conn->real_escape_string($new_username);
    $new_email = $conn->real_escape_string($new_email);
    
    // Query untuk memperbarui data pengguna berdasarkan ID
    $sql = "UPDATE users SET username = '$new_username', email = '$new_email' WHERE user_id = '$user_id'";
    
    // Mengeksekusi querys
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>setting</title>
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <script src="../JavaScript/logout.js"></script>
</head>
<body>
<div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>dozy.</h1>
            <ul>
                <li><a class="menu" href="../Dashboard/home.php">Home</a></li>
                <li><a class="menu" href="../ScheduleTask/schedule.php">Schedule & Task</a></li>
                <li><a class="menu" href="../Progress/progres.php">Progress</a></li>
                <li><a class="menu" href="../Setting/seting.php">Setting</a></li>
                <li><a class="menu" href="#" onclick="confirmLogout()">Log out</a></li>
            </ul>
        </div>
        <!-- content -->
        <div class="content">
        <form action="editprofile.php" method="post">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <button type="submit" name="update">Save</button>
</form>

        </div>
</div>
</body>
</html>