<?php
// Memanggil function.php yang ada di folder Function
require(__DIR__ . '/../Function/function.php');

// Cek apakah form disubmit
if (isset($_POST['register'])) {
    // Panggil fungsi registrasi yang ada di function.php
    if (registrasi($_POST)) {
        echo "<script>
                alert('Registrasi berhasil!');
                window.location.replace('../Login/login.php'); // Redirect ke halaman login
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal! Pastikan semua data valid.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Here</title>
    <style>
      /* Reset Styles */
      body, h1, input, button {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      /* Body Styles */
      body {
        font-family: 'Arial', sans-serif;
        background-color: #d9eafc; /* Latar belakang biru muda */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Tinggi penuh layar */
      }

      .container {
        text-align: center;
        width: 100%;
        max-width: 400px;
      }

      /* Header */
      .title {
        font-size: 28px;
        font-weight: bold;
        color: #2a2a72; /* Warna biru tua */
        margin-bottom: 20px;
      }

      /* Form Container */
      .form-container {
        background-color: #8aa6d8; /* Warna biru medium */
        border-radius: 15px;
        padding: 30px 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
      }

      /* Input Field Styles */
      .form-container input {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 15px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        background-color: #d9eafc; /* Biru terang */
        color: #2a2a72; /* Teks biru tua */
      }

      .form-container input::placeholder {
        color: #6c6c6c; /* Warna placeholder abu-abu */
      }

      /* Button Styles */
      .form-container button {
        width: 100%;
        padding: 10px 15px;
        font-size: 16px;
        color: white;
        background-color: #2a2a72; /* Warna biru tua */
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .form-container button:hover {
        background-color: #1f204f; /* Warna biru lebih gelap saat hover */
      }
    </style>
  </head>
  <body>
    <div class="container">
      <!-- Header -->
      <h1 class="title">Register here!</h1>

      <!-- Form -->
      <div class="form-container">
        <form action="registrasi.php" method="POST">
          <input type="text" name="username" placeholder="Enter Username" required />
          <input type="email" name="email" placeholder="Enter Email" required />
          <input type="password" name="password" placeholder="Enter Password" required />
          <input
            type="password"
            name="password2"
            placeholder="Confirm Password"
            required
          />
          <button type="submit" name="register">Register</button>
        </form>
      </div>
    </div>
  </body>
</html>
