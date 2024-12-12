<?php
session_start(); // Memulai session untuk akses ID pengguna yang sedang login

// Koneksi ke database
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

// Memeriksa apakah pengguna sudah login
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Mengecek password lama
    $sql = "SELECT password FROM users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password lama
        if (password_verify($current_password, $row['password'])) {
            // Memastikan password baru dan konfirmasi cocok
            if ($new_password === $confirm_password) {
                // Hash password baru
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update password di database
                $update_sql = "UPDATE users SET password = '$hashed_password' WHERE user_id = '$user_id'";
                if ($conn->query($update_sql) === TRUE) {
                    $message = "Password berhasil diperbarui.";
                    $message_type = "success";
                } else {
                    $message = "Terjadi kesalahan: " . $conn->error;
                    $message_type = "error";
                }
            } else {
                $message = "Password baru dan konfirmasi tidak cocok.";
                $message_type = "error";
            }
        } else {
            $message = "Password lama salah.";
            $message_type = "error";
        }
    } else {
        $message = "Pengguna tidak ditemukan.";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            height: 400px;
            max-width: 400px;
            position: relative;
            display: block;
        }

        .container h2 {
            
            
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
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
            width: 100%;
        }

        form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        form input:focus {
            border-color: #1abc9c;
            outline: none;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #1abc9c;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #16a085;
        }

        p {
            text-align: center;
            font-size: 14px;
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
    <?php if ($message): ?>
        <div class="alert <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <h2>Edit Password</h2>
    <form action="edit_pass.php" method="post">
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit" name="update_password">Update Password</button>
    </form>
</div>
</body>
</html>