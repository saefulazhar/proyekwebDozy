<?php
// Konfigurasi database
require_once 'function.php';

// Menangani data yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
  
    
    // Menangani upload foto profil
   
    
    // Query untuk memperbarui data pengguna
    $sql = "UPDATE users SET username=?, email=? WHERE email=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $email);
    
    if ($stmt->execute()) {
        echo "Profil berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
