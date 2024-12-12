<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dozy Welcome Page</title>
    <style>
      body, p, h1, a, button {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: 'Arial', sans-serif;
        background-color: #d9eafc; 
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; 
      }

      .container {
        text-align: center;
      }

      .circle {
        width: 150px;
        height: 150px;
        background-color: white; 
        border-radius: 50%; 
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
        overflow: hidden; /* Menyembunyikan bagian gambar yang melampaui lingkaran */
      }

      .circle img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Memastikan gambar memenuhi lingkaran tanpa merusak proporsi */
        border-radius: 50%; /* Agar gambar juga berbentuk lingkaran */
      }

      .welcome-text {
        font-size: 20px;
        color: #2a2a72; 
        font-weight: bold;
        margin-top: 20px;
      }

      .subtitle {
        font-size: 14px;
        color: #6c6c6c; 
        margin-top: 5px;
      }

      .buttons {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 10px;
      }

      button {
        background-color: #678fc9; 
        color: white;
        border: none;
        border-radius: 10px; 
        padding: 10px 20px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); 
      }

      button:hover {
        background-color: #4a6fa8; 
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="circle">
        <img src="LandingPage/logo dozy.jpeg" alt="Dozy Logo" />
      </div>

      <!-- Teks Selamat Datang -->
      <p class="welcome-text">welcome to dozy!</p>
      <p class="subtitle">Simple Reminder and Schedule Manager</p>

      <!-- Tombol Register dan Login -->
      <div class="buttons">
        <a href="Register/registrasi.php"><button>Register</button></a>
        <a href="Login/login.php"><button>Login</button></a>
      </div>
    </div>
  </body>
</html>
