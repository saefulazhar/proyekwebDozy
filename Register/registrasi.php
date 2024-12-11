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
        background-color: #cfe6f5; /* Latar belakang biru muda */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Tinggi penuh layar */
      }

      .container {
        display: flex;
        align-items: center;
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        padding: 20px;
        max-width: 800px;
        width: 100%;
      }

      /* Logo Styles */
      .logo {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
      }

      .logo img {
        width: 200px;
        height: 200px;
        object-fit: cover; /* Memastikan gambar memenuhi lingkaran tanpa merusak proporsi */
        border-radius: 50%; /* Agar gambar berbentuk lingkaran */
      }

      /* Form Container */
      .form-container {
        flex: 2;
        text-align: center;
        padding: 20px;
      }

      .form-container .title {
        font-size: 28px;
        font-weight: bold;
        color: #2a2a72; /* Warna biru tua */
        margin-bottom: 20px;
      }

      .form-container form {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      /* Input Field Styles */
      .form-container input {
        width: 100%;
        padding: 10px 15px;
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
        padding: 10px 15px;
        font-size: 16px;
        color: black;
        background-color: #d9eafc; /* Warna biru tua */
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
      <!-- Logo -->
      <div class="logo">
        <img src="../LandingPage/logo dozy.jpeg" alt="logo" />
      </div>

      <!-- Form -->
      <div class="form-container">
        <h1 class="title">Register here!</h1>
        <form action="registrasi.php" method="POST">
          <input type="text" name="username" placeholder="Enter Username" required />
          <input type="email" name="email" placeholder="Enter Email" required />
          <input type="password" name="password" placeholder="Enter Password" required />
          <input type="password" name="password2" placeholder="Confirm Password" required />
          <button type="submit" name="register">Register</button>
        </form>
      </div>
    </div>
  </body>
</html>
