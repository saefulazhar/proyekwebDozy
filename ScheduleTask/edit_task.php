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
    <link rel="stylesheet" href="../Dashboard/dash.css">
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        <form action="edit_task.php?id=<?php echo $taskId; ?>" method="POST">
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

            <button type="submit">Update Task</button>
            <button type="button" onclick="window.location.href='../Dasboard/home.php'">Cancel</button>
        </form>
    </div>
</body>
</html>
