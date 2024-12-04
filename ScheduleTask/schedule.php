<?php
// Cek apakah ada parameter success atau error di URL
$success = isset($_GET['success']) ? $_GET['success'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule & Task</title>
    <link rel="stylesheet" href="schedule.css">
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <script src="../JavaScript/logout.js"></script>
    <script src="../JavaScript/addtask.js"></script>
    
   <!-- FullCalendar CSS -->
   <link
      href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css"
      rel="stylesheet"
    />

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <!-- Optional: FullCalendar plugins (eg. DayGrid, interaction) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>

   
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>dozy.</h1>
            <ul>
                <li><a class="menu" href="../Dashboard/home.php">Home</a></li>
                <li><a class="menu" href="../ScheduleTask/schedule.php">Schedule & Task</a></li>
                <li><a class="menu" href="../Progress/progres.php">Progress</a></li>
                <li><a class="menu" href="../Setting/seting.php">Setting</a></li>
                <li><a class="menu" href="#" onclick="confirmLogout()">Log out</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Header Section -->
            <div class="header">
                <h2>Hello, <span id="username">Soffa</span>!</h2>
                <p>This is your schedule and task's page</p>
                <div class="header-right">
                    <input type="text" placeholder="Search...">
                    <img src="https://via.placeholder.com/40" alt="Profile Picture" class="profile-pic">
                </div>
            </div>

            <!-- Notifikasi: Jika berhasil atau gagal menambahkan task -->
<?php if ($success): ?>
    <div class="notification success">
        Task berhasil ditambahkan!
        <button class="close-notification" onclick="closeNotification(this)">OK</button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="notification error">
        Gagal menambahkan task. Silakan coba lagi.
        <button class="close-notification" onclick="closeNotification(this)">OK</button>
    </div>
<?php endif; ?>


            <!-- Stats Section -->
            <div class="stats">
                <span class="priority high">High</span>
                <span class="priority med">Med</span>
                <span class="priority low">Low</span>
            </div>

            <!-- Calendar Section -->
            <div class="calendar">
                <div class="view-header">
                    <button class="add-btn" onclick="toggleAddTaskForm()">+ Add</button>
                </div>

                <!-- Form to add task -->
                <div id="add-task-form" style="display:none;">
                    <form action="add_task.php" method="POST">
                        <label for="task-title">Task Title:</label>
                        <input type="text" id="task-title" name="title" required><br>

                        <label for="description-task">Description:</label>
                        <input type="text" id="description-task" name="description" required><br>

                        <label for="due-date">Due Date:</label>
                        <input type="date" id="due-date" name="due_date" required><br>

                        <label for="priority">Priority:</label>
                        <select id="priority" name="priority" required>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select><br>

                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select><br>

                        <button type="submit">Add Task</button>
                        <button type="button" onclick="toggleAddTaskForm()">Cancel</button>
                    </form>
                </div>

                <!-- FullCalendar Container -->
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle the task form visibility
        function toggleAddTaskForm() {
            const form = document.getElementById('add-task-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale: "en",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,dayGridWeek,dayGridDay"
        },
        events: [] // Kosongkan dulu, akan diisi oleh loadTasks()
    });

    // Mendapatkan bulan dan tahun dari tanggal saat ini
    const currentMonth = new Date().getMonth() + 1; // Bulan saat ini (1-12)
    const currentYear = new Date().getFullYear();  // Tahun saat ini

    console.log("Tasks fetched for month:", currentMonth, "year:", currentYear);

    // Render kalender terlebih dahulu
    calendar.render();

    // Memuat tugas setelah kalender dirender
    loadTasks(currentMonth, currentYear, calendar); // Ganti month dan year di sini
});

// Fungsi loadTasks yang diperbarui untuk FullCalendar v5
function loadTasks(month, year, calendar) {
    fetch(`get_tasks.php?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(tasks => {
            const events = tasks.map(task => ({
                title: task.title,
                start: task.due_date, // Pastikan format tanggal sesuai dengan format yang diminta oleh FullCalendar
                description: task.description || '', // Pastikan field ini ada jika diperlukan
                color: getTaskColor(task.priority) // Gunakan warna berdasarkan prioritas
            }));
            calendar.addEventSource(events); // Menambahkan event ke kalender
        })
        .catch(error => {
            console.error('Error fetching tasks:', error);
        });
}

function getTaskColor(priority) {
    switch (priority) {
        case 'high':
            return 'red';
        case 'medium':
            return 'orange';
        case 'low':
            return 'green';
        default:
            return 'blue';
    }
}





        const menuItems = document.querySelectorAll('.sidebar .menu');

menuItems.forEach(item => {
    item.addEventListener('click', function() {
        menuItems.forEach(i => i.classList.remove('active')); // Menghapus kelas 'active' dari semua menu
        item.classList.add('active'); // Menambahkan kelas 'active' pada menu yang dipilih
    });
});

    </script>
</body>
</html>
