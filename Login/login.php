<?php
session_start();
require('../Function/function.php'); // Pastikan file function.php berisi koneksi database Anda

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) === 1) {
        // Fetch data pengguna
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Login berhasil, menyimpan data sesi
            $_SESSION['user_id'] = $row['user_id']; // Menyimpan user_id dalam sesi
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            header("Location: ../Dashboard/home.php"); // Arahkan ke halaman dashboard
            exit;
        } else {
            // Password salah
            $error = "Password salah.";
        }
    } else {
        // Email tidak ditemukan
        $error = "Email tidak terdaftar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dozy Login Page</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <div class="login-container">
        <div class="login-box">
          <h1>Login to your Dozy account</h1>
          <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required /><br>
            <input type="password" name="password" placeholder="Enter your password" required />
            <button type="submit" name="login" class="login-button">Login</button>
          </form>
          
          <?php if (isset($error)) : ?>
            <p class="error-message"><?php echo $error; ?></p>
          <?php endif; ?>
        </div>
        <div class="illustration">
          <img src="../LandingPage/logo dozy.jpeg" alt="Illustration" />
        </div>
      </div>
    </div>
  </body>
</html>
