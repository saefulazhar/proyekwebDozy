<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Schedule and Task</title>
    <link rel="stylesheet" href="schedule.css" />
    <!-- FullCalendar CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css"
      rel="stylesheet"
    />
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <!-- FullCalendar Interaction Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/interaction.min.js"></script>
  </head>
  <body>
    <div class="sidebar">
      <div class="logo">
        <h1>dozy.</h1>
      </div>
      <ul class="menu">
        <li><a href="../Dashboard/home.php" class="active">Home</a></li>
        <li><a href="../ScheduleTask/schedule.php">Schedule & Task</a></li>
        <li><a href="#">Progress</a></li>
        <li><a href="#">Setting</a></li>
        <li><a href="#" class="logout">Log out</a></li>
      </ul>
    </div>

    <div class="main-content">
      <header>
        <h2>Hello, Soffa!</h2>
        <p>This is your schedule and task's page</p>
      </header>

      <div class="task-controls">
        <button class="tab-btn active">Monthly</button>
        <button class="tab-btn">Week</button>
        <button class="tab-btn">Day</button>
      </div>
      <div class="calendar">
        <div id="calendar"></div>
        <div class="add-task">
            <button>+ add</button>
        </div>
    </div>     
      </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM Loaded!'); // Debugging log

        var calendarEl = document.getElementById('calendar'); // Ambil elemen kalender

        if (!calendarEl) {
            console.error('Element #calendar tidak ditemukan!'); // Error jika elemen tidak ditemukan
            return;
        }

        // Inisialisasi FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Tampilan default
            headerToolbar: {
                left: 'prev,next today', // Navigasi
                center: 'title', // Judul
                right: 'dayGridMonth,timeGridWeek,timeGridDay', // Opsi tampilan
            },
            editable: true, // Interaksi edit
            selectable: true, // Seleksi tanggal
            dateClick: function (info) {
                // Fungsi klik tanggal
                alert('Tanggal yang dipilih: ' + info.dateStr);
            },
            events: [
                // Acara statis
                {
                    title: 'Meeting',
                    start: '2025-01-02T10:00:00',
                    end: '2025-01-02T11:00:00',
                },
                {
                    title: 'Project Deadline',
                    start: '2025-01-08',
                },
                {
                    title: 'Work',
                    start: '2025-01-14T08:00:00',
                },
            ],
        });

        calendar.render(); // Tampilkan kalender
        console.log('Kalender berhasil dirender!'); // Debugging log
    });
</script>

    
  </body>
</html>
