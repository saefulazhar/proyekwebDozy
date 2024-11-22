<?php

// Membuat koneksi
$conn = new mysqli("localhost","root", "", "dozy_db");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "";
}


function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $password2 = mysqli_real_escape_string($conn,$data["password2"]);

    $result = mysqli_query($conn,"SELECT username FROM users WHERE username ='$username'");

    $resemail = mysqli_query($conn,"SELECT email FROM users WHERE email ='$email'");


    if(mysqli_fetch_assoc($result)){
        echo "<script>
        alert('username telah digunakan')
        </script>";
        return false;
    }
    if(mysqli_fetch_assoc($resemail)){
        echo "<script>
        alert('email telah digunakan')
        </script>";
        return false;
    }

    if($password != $password2){
        echo "<script>
        alert('password tidak sesuai')
        </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
   
    mysqli_query($conn,"INSERT INTO users VALUES('','$username','$email','$password')");

    return 1;

}



?>