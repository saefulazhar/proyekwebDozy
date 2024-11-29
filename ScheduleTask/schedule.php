<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule & Task</title>
    <link rel="stylesheet" href="schedule.css">
    <script src="../JavaScript/calendar.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>dozy.</h1>
            <ul>
                <li><a href="#" class="active">Home</a></li>
                <li><a href="../ScheduleTask/schedule.php">Schedule & Task</a></li>
                <li><a href="#">Progress</a></li>
                <li><a href="#">Setting</a></li>
                <li><a href="#">Log out</a></li>
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

            <!-- Stats Section -->
            <div class="stats">
                <span class="priority high">High</span>
                <span class="priority med">Med</span>
                <span class="priority low">Low</span>
            </div>

            <!-- Calendar Section -->
            <div class="calendar">
                <div class="view-header">
                    <div class="view-buttons">
                        <button class="view-btn">Monthly</button>
                        <button class="view-btn">Week</button>
                        <button class="view-btn">Day</button>
                    </div>
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

                <!-- Calendar Table -->
                <table id="calendar-table">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Kalender akan diisi dengan script JavaScript -->
                    </tbody>
                </table>
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
            fetch(`../ScheduleTask/get_task.php?month=${month}&year=${year}`)
                .then(response => response.json())
                .then(tasks => {
                    populateCalendar(tasks);
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        }

        // Populate calendar with tasks
        function populateCalendar(tasks) {
            const calendarTable = document.getElementById('calendar-table').getElementsByTagName('tbody')[0];
            const rows = calendarTable.rows;
            const tasksByDate = {};

            // Organize tasks by date
            tasks.forEach(task => {
                const date = new Date(task.due_date);
                const day = date.getDate();
                if (!tasksByDate[day]) tasksByDate[day] = [];
                tasksByDate[day].push(task);
            });

            // Loop through all calendar days and assign task classes
            for (let i = 0; i < rows.length; i++) {
                for (let j = 0; j < rows.cells.length; j++) {
                    const cell = rows[i].cells[j];
                    const day = parseInt(cell.textContent);
                    if (tasksByDate[day]) {
                        tasksByDate[day].forEach(task => {
                            const taskDiv = document.createElement('div');
                            taskDiv.classList.add('task');
                            taskDiv.classList.add(task.priority);
                            taskDiv.textContent = task.title;
                            cell.appendChild(taskDiv);
                        });
                    }
                }
            }
        }

        // Call loadTasks when the page loads
        window.onload = function () {
            const month = new Date().getMonth() + 1; // Bulan saat ini
            const year = new Date().getFullYear();  // Tahun saat ini
            loadTasks(month, year);
        }
    </script>
</body>
</html>
