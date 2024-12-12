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

// Variabel untuk pesan feedback
$message = "";
$message_type = "";

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
    
    // Mengeksekusi query
    if ($conn->query($sql) === TRUE) {
        $message = "Profile updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        $message_type = "error";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <script src="../JavaScript/logout.js"></script>
    <style>
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .alert {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            box-sizing: border-box;
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #1abc9c;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const alertBox = document.querySelector(".alert");
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.opacity = "0";
                }, 1000);
            }
        });
    </script>
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
    <!-- Content -->
    <div class="content">
        <?php if ($message): ?>
            <div class="alert <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="editprofile.php" method="post">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <button type="submit" name="update">Save</button>
        </form>
    </div>
</div>
</body>
</html>
