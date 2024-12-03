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
    
   <!-- FullCalendar CSS -->
   <link
      href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css"
      rel="stylesheet"
    />

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <!-- Optional: FullCalendar plugins (eg. DayGrid, interaction) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>

    <style>
      

      .calendar-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
      }

      #calendar {
        margin-top: 20px;
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
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="notification error">
                    Gagal menambahkan task. Silakan coba lagi.
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
                            <option value="not-started">Not Started</option>
                            <option value="in-progress">In Progress</option>
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

        // Ambil data tugas dari get_task.php
        function loadTasks(month, year) {
            fetch(`get_task.php?month=${month}&year=${year}`)
                .then(response => response.json())
                .then(tasks => {
                    initializeCalendar(tasks);
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        }

      document.addEventListener("DOMContentLoaded", function () {
        var calendarEl = document.getElementById("calendar");

        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: "dayGridMonth", // Set default view to monthly
          locale: "en", // Set locale to English
          events: [
            {
              title: "Sample Event 1",
              start: "2024-12-05",
              description: "This is a sample event.",
              color: "red",
            },
            {
              title: "Sample Event 2",
              start: "2024-12-12",
              description: "This is another sample event.",
              color: "green",
            },
            {
              title: "Sample Event 3",
              start: "2024-12-20",
              description: "Yet another event.",
              color: "blue",
            },
          ],
          eventClick: function (info) {
            alert(
              "Event: " +
                info.event.title +
                "\nDescription: " +
                info.event.extendedProps.description
            );
          },
          headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,dayGridWeek,dayGridDay",
          },
        });

        calendar.render();
      });

        // Set task color based on priority
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

        // Call loadTasks when the page loads
        window.onload = function () {
            const month = new Date().getMonth() + 1; // Bulan saat ini
            const year = new Date().getFullYear();  // Tahun saat ini
            loadTasks(month, year);
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
