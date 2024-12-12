<?php
// Memanggil koneksi database
require(__DIR__ . '/../Function/function.php');

// Memastikan ID tugas diberikan melalui URL
if (!isset($_GET['task_id']) || empty($_GET['task_id'])) {
    echo "Invalid task ID.";
    exit;
}

$taskId = $_GET['task_id'];

// Mendapatkan data tugas berdasarkan ID
$query = $conn->prepare("SELECT * FROM task WHERE task_id = ?");
$query->bind_param("i", $taskId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    echo "Task not found.";
    exit;
}

$task = $result->fetch_assoc();

// Proses pengeditan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['due_date'];
    $priority = $_POST['priority'];

    $updateQuery = $conn->prepare("UPDATE task SET title = ?, description = ?, due_date = ?, priority = ? WHERE task_id = ?");
    $updateQuery->bind_param("ssssi", $title, $description, $dueDate, $priority, $taskId);

    if ($updateQuery->execute()) {
        echo "<script>
                alert('Task updated successfully!');
                window.location.href = '../Dashboard/home.php';
              </script>";
    } else {
        echo "<script>alert('Failed to update task. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../Dashboard/dash.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #4a90e2;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        }

        button {
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #4a90e2;
            color: #ffffff;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #357ab7;
        }

        button[type="button"] {
            background-color: #e0e0e0;
            color: #333;
        }

        button[type="button"]:hover {
            background-color: #c5c5c5;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        <form action="edit_task.php?task_id=<?php echo $taskId; ?>" method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($task['description']); ?></textarea>

            <label for="due_date">Due Date</label>
            <input type="datetime-local" id="due_date" name="due_date" value="<?php echo date('Y-m-d\TH:i', strtotime($task['due_date'])); ?>" required>

            <label for="priority">Priority</label>
            <select id="priority" name="priority" required>
                <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Low</option>
                <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
            </select>

            <div class="actions">
                <button type="submit">Update Task</button>
                <button type="button" onclick="window.location.href='../Dashboard/home.php'">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
