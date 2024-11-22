<?php
// Memanggil function.php yang ada di folder Function
require(__DIR__ . '/../Function/function.php');


// Cek apakah form disubmit
if (isset($_POST['register'])) {
    // Panggil fungsi registrasi yang ada di function.php
    if (registrasi($_POST)) {
        echo "<script>
                alert('Registrasi berhasil!');
                window.location.replace ('../Login/login.php'); // Redirect ke halaman login
              </script>";
        
    }
}
?>

<form action="registrasi.php" method="POST">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <input type="password" name="password2" placeholder="Confirm Password" required>
    <button type="submit" name="register">Register</button>
</form>
