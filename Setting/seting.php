<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>setting</title>
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <script src="../JavaScript/logout.js"></script>
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
        <!-- content -->
        <div class="content">
            <ul>
                <li><a href="editprofile.php">Edit Profile</a></li>
                <li><a href="#">Security</a></li>
                <li><a href="#">Notification Setting</a></li>
                <li><a href="#">Delete Acount</a></li>
            </ul>
        </div>
</div>
</body>
</html>