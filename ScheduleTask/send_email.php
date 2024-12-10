<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Zona waktu
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/../Function/function.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';

// Koneksi ke database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Waktu saat ini
$current_time = date('Y-m-d H:i:s');

// Waktu pengingat 1 hari sebelum deadline
$reminder_time_1_day = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($current_time)));

// Waktu pengingat 1 jam sebelum deadline
$reminder_time_1_hour = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($current_time)));

// Query untuk mencari tugas yang deadline-nya 1 hari sebelum deadline
$sql_1_day = "SELECT t.title, t.due_date, t.priority, u.email 
              FROM task t
              JOIN users u ON t.user_id = u.user_id
              WHERE t.due_date <= '$reminder_time_1_day' AND t.due_date > '$current_time' AND (t.status = 'not_started' OR t.status = 'in_progress')";

// Menampilkan query untuk debugging
echo $sql_1_day;  // Debugging query 1 jam
echo "<br>";

$result_1_day = $conn->query($sql_1_day);

if ($result_1_day->num_rows > 0) {
    while($row = $result_1_day->fetch_assoc()) {
        // Kirim email notifikasi 1 hari sebelum deadline
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dozyassistant@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'fkwvulyqpxwjcvhe'; // Gunakan App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dozyassistant@gmail.com', 'Dozy Notifications');
            $mail->addAddress($row['email']);  // Pengguna yang menerima email

            $mail->isHTML(true);
            $mail->Subject = 'Reminder: Task Deadline in 1 Day';
            $mail->Body    = "Hello, your task '{$row['title']}' priority '{$row['priority']}' is approaching its deadline at {$row['due_date']}. Please make sure to complete it on time.";

            $mail->SMTPDebug = 2; // Enable debugging untuk melihat pesan error
            $mail->send();
            echo 'Email berhasil dikirim (1 hari sebelum deadline)!';
        } catch (Exception $e) {
            echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
        }
    }
} else {
    echo "Tidak ada tugas yang mendekati deadline 1 hari.";
}

// Query untuk mencari tugas yang deadline-nya 1 jam sebelum deadline
$sql_1_hour = "SELECT t.title, t.due_date, t.priority, u.email 
               FROM task t
               JOIN users u ON t.user_id = u.user_id
               WHERE t.due_date <= '$reminder_time_1_hour' AND t.due_date > '$current_time' AND (t.status = 'not_started' OR t.status = 'in_progress')";

// Menampilkan query untuk debugging
echo $sql_1_hour;  // Debugging query 1 jam
echo "<br>";

$result_1_hour = $conn->query($sql_1_hour);

if ($result_1_hour->num_rows > 0) {
    while($row = $result_1_hour->fetch_assoc()) {
        // Kirim email notifikasi 1 jam sebelum deadline
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dozyassistant@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'fkwvulyqpxwjcvhe'; // Gunakan App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dozyassistant@gmail.com', 'Dozy Notifications');
            $mail->addAddress($row['email']);  // Pengguna yang menerima email

            $mail->isHTML(true);
            $mail->Subject = 'Reminder: Task Deadline in 1 Hour';
            $mail->Body    = "Hello, your task '{$row['title']}' priority '{$row['priority']}'is approaching its deadline at {$row['due_date']}. Please complete it as soon as possible.";

            $mail->SMTPDebug = 2; // Enable debugging untuk melihat pesan error
            $mail->send();
            echo 'Email berhasil dikirim (1 jam sebelum deadline)!';
        } catch (Exception $e) {
            echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
        }
    }
} else {
    echo "Tidak ada tugas yang mendekati deadline 1 jam.";
}

$conn->close();
?>
