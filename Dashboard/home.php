<?php
session_start(); // Mulai sesi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memanggil koneksi database
require(__DIR__ . '/../Function/function.php');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari sesi

// Cek pesan alert dari parameter GET
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    if ($message == 'TaskDeleted') {
        echo "<div class='alert success' id='alert'>
                <i class='icon success'></i>
                <span>Task successfully deleted.</span>
              </div>";
    } elseif ($message == 'DeleteFailed') {
        echo "<div class='alert error' id='alert'>
                <i class='icon error'></i>
                <span>Failed to delete task. Please try again.</span>
              </div>";
    } elseif ($message == 'InvalidID') {
        echo "<div class='alert warning' id='alert'>
                <i class='icon warning'></i>
                <span>Invalid task ID.</span>
              </div>";
    }
}

// Mendapatkan bulan dan tahun saat ini
$currentMonth = date('m');
$currentYear = date('Y');

// Query untuk menghitung jumlah tugas berdasarkan kategori milik user yang login
$high = $conn->query("SELECT COUNT(*) AS count FROM task WHERE priority = 'high' AND user_id = $user_id")->fetch_assoc()['count'];
$medium = $conn->query("SELECT COUNT(*) AS count FROM task WHERE priority = 'medium' AND user_id = $user_id")->fetch_assoc()['count'];
$low = $conn->query("SELECT COUNT(*) AS count FROM task WHERE priority = 'low' AND user_id = $user_id")->fetch_assoc()['count'];
$notYet = $conn->query("SELECT COUNT(*) AS count FROM task WHERE status = 'not_started' AND user_id = $user_id")->fetch_assoc()['count'];
$in_progress = $conn->query("SELECT COUNT(*) AS count FROM task WHERE status = 'in_progress' AND user_id = $user_id")->fetch_assoc()['count'];
$done = $conn->query("SELECT COUNT(*) AS count FROM task WHERE status = 'completed' AND user_id = $user_id")->fetch_assoc()['count'];

// Query untuk mengambil data tugas berdasarkan bulan saat ini dan user_id
$tasks = $conn->query("
    SELECT task_id, title, description, due_date, priority 
    FROM task 
    WHERE MONTH(due_date) = $currentMonth 
    AND YEAR(due_date) = $currentYear 
    AND user_id = $user_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <script src="../JavaScript/logout.js"></script>
    <style>
.alert {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    padding: 15px;
    margin: 10px 0;
    border-radius: 8px;
    font-size: 14px;
    justify-content: center;
    opacity: 1;
    visibility: visible;
    max-width: 80%;
    z-index: 1000; /* Menjaga alert di atas konten lainnya */
    animation: fadeOut 1s ease-in-out forwards;
}

.alert i {
    margin-right: 10px;
    font-size: 18px;
}

.alert span {
    flex-grow: 1;
    text-align: center;
}

.alert.success {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #45a049;
}

.alert.error {
    background-color: #f44336;
    color: white;
    border: 1px solid #e53935;
}

.alert.warning {
    background-color: #ff9800;
    color: white;
    border: 1px solid #f57c00;
}

/* Ikon sesuai jenis alert */
.icon.success::before {
    content: '✔'; /* Check icon for success */
}

.icon.error::before {
    content: '✘'; /* Cross icon for error */
}

.icon.warning::before {
    content: '⚠'; /* Warning icon */
}

/* Animasi untuk menghilangkan alert setelah 1 detik */
@keyframes fadeOut {
    0% {
        opacity: 1;
        visibility: visible;
    }
    90% {
        opacity: 1;
        visibility: visible;
    }
    100% {
        opacity: 0;
        visibility: hidden;
    }
}



        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #2a2a72;
            color: white;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #e6f7ff;
        }

        .tasks {
            margin-top: 30px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .tasks h3 {
            margin-bottom: 15px;
            color: #2a2a72;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-buttons .edit {
            background-color: #4caf50;
            color: white;
        }

        .action-buttons .edit:hover {
            background-color: #45a049;
        }

        .action-buttons .delete {
            background-color: #f44336;
            color: white;
        }

        .action-buttons .delete:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>dozy.</h1>
            <ul>
                <li><a class="menu" href="../Dashboard/home.php">Home</a></li>
                <li><a class="menu" href="../ScheduleTask/schedule.php">Schedule & Task</a></li>
                <li><a class="menu" href="../Setting/seting.php">Setting</a></li>
                <li><a class="menu" href="#" onclick="confirmLogout()">Log out</a></li>
            </ul>
        </div>
        <!-- Content -->
        <div class="content">
            <div class="header">
                <h2>Hello, <span id="username">Guest</span>! Welcome to Dozy.</h2>
            </div>
            <div class="stats">
                <div class="box high">High<br><strong><?php echo $high; ?></strong></div>
                <div class="box med">Medium<br><strong><?php echo $medium; ?></strong></div>
                <div class="box low">Low<br><strong><?php echo $low; ?></strong></div>
                <div class="box not-yet">Not Yet<br><strong><?php echo $notYet; ?></strong></div>
                <div class="box in-progress">In Progress<br><strong><?php echo $in_progress; ?></strong></div>
                <div class="box done">Done<br><strong><?php echo $done; ?></strong></div>
            </div>
            <div class="tasks">
                <h3>Tasks for <?php echo date('F Y'); ?>:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tasks->num_rows > 0): ?>
                            <?php while ($task = $tasks->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td><?php echo htmlspecialchars(date('d M Y H:i', strtotime($task['due_date']))); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($task['priority'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="edit" onclick="window.location.href='../ScheduleTask/edit_task.php?task_id=<?php echo $task['task_id']; ?>'">Edit</button>
                                            <button class="delete" onclick="if(confirm('Are you sure?')) window.location.href='../ScheduleTask/delete_task.php?task_id=<?php echo $task['task_id']; ?>'">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5">No tasks available for this month.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
