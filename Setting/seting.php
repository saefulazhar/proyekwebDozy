<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Dozy</title>
    <link rel="stylesheet" href="../Sidebar/sidebar.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            display: flex;
        }

      

        /* Content Styles */
        .content {
            flex: 1;
            padding: 40px;
        }

        .content ul {
            list-style: none;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }

        .content ul li {
            background-color: white;
            margin: 15px 0;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .content ul li:hover {
            transform: translateY(-5px);
        }

        .content ul li a {
            text-decoration: none;
            color: #2c3e50;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .content ul li a:hover {
            color: #1abc9c;
        }
    </style>
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

    <!-- Content -->
    <div class="content">
        <ul>
            <li><a href="editprofile.php">Edit Profile</a></li>
            <li><a href="edit_pass.php">Security</a></li>
            <li><a href="#">Notification Setting</a></li>
            <li><a href="#">Delete Account</a></li>
        </ul>
    </div>
</div>
</body>
</html>