<?php
// Membuat koneksi ke database
$conn = new mysqli("localhost", "root", "", "dozy_db");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk registrasi pengguna
function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Validasi: apakah username atau email sudah terdaftar
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    $resemail = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username telah digunakan');</script>";
        return false;
    }

    if (mysqli_fetch_assoc($resemail)) {
        echo "<script>alert('Email telah digunakan');</script>";
        return false;
    }

    // Validasi: apakah password sesuai
    if ($password !== $password2) {
        echo "<script>alert('Password tidak sesuai');</script>";
        return false;
    }

    // Hash password sebelum disimpan ke database
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$email', '$password')");

    return true;
}

// Fungsi untuk login pengguna
function login($data) {
    global $conn;

    $email = mysqli_real_escape_string($conn, $data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Cek apakah email terdaftar
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Simpan session
            session_start();
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            return true;
        } else {
            echo "<script>alert('Password salah');</script>";
            return false;
        }
    } else {
        echo "<script>alert('Email tidak terdaftar');</script>";
        return false;
    }
}
?>