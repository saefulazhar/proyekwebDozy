<?php
// Memasukkan file PHPMailer yang diunduh secara manual
require_once '../src/PHPMailer.php';      // Ganti dengan path yang sesuai
require_once '../src/SMTP.php';           // Ganti dengan path yang sesuai
require_once '../src/Exception.php';      // Ganti dengan path yang sesuai

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);  // Buat objek PHPMailer

try {
    // Mengonfigurasi pengaturan SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // SMTP server untuk Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'dozyassistant@gmail.com';  // Ganti dengan alamat email Gmail Anda
    $mail->Password = 'fkwvulyqpxwjcvhe';     // Ganti dengan App Password yang baru Anda buat
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Menggunakan enkripsi TLS
    $mail->Port = 587;  // Port untuk TLS

    // Pengaturan pengirim dan penerima email
    $mail->setFrom('dozyassistant@gmail.com', 'Dozy Notifications');  // Ganti dengan email dan nama Anda
    $mail->addAddress('saefulazhar251203@gmail.com', 'Azhar');  // Ganti dengan email penerima

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from Dozy';
    $mail->Body    = 'This is a test email sent from Dozy using PHPMailer.';

    // Kirim email
    $mail->send();
    echo 'Email berhasil dikirim!';
} catch (Exception $e) {
    echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
}
?>
