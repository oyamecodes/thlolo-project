<?php
session_start();

// Check if user is logged in and task ID is provided
if (!isset($_SESSION['Lusername']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

// Handle form submission first
if (isset($_POST['update'])) {
    $pID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($pID === false) {
        die("Invalid task ID");
    }
    
    // Sanitize and validate input
    $title = filter_input(INPUT_POST, 'txttitle', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'txtDesc', FILTER_SANITIZE_STRING);
    $completion_date = filter_input(INPUT_POST, 'dtDate', FILTER_SANITIZE_STRING);
    $assigned_to = filter_input(INPUT_POST, 'txtassign', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    
    // Validate status
    $valid_statuses = ['pending', 'in-progress', 'completed'];
    if (!in_array($status, $valid_statuses)) {
        die("Invalid status");
    }
    
    // Update the task
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, completion_date = ?, assigned_to = ?, status = ? WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("sssssss", $title, $desc, $completion_date, $assigned_to, $status, $pID, $_SESSION['Lusername']);
    
    if ($stmt->execute()) {
        header("Location: home.php");
        exit();
    } else {
        die("Error updating task: " . $conn->error);
    }
}

// Fetch existing task data
$pID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($pID === false) {
    die("Invalid task ID");
}

$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND assigned_to = ?");
$stmt->bind_param("is", $pID, $_SESSION['Lusername']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: home.php");
    exit();
}

$task = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="main-back">
        <form action="EditTask.php?id=<?php echo htmlspecialchars($pID); ?>" method="POST">
            <div class="form">
                <label class="lbl" for="txttitle">Title:</label>
                <input class="txtInput" type="text" id="txttitle" name="txttitle" 
                       value="<?php echo htmlspecialchars($task['title']); ?>" required>
                
                <label class="lbl" for="txtDesc">Description:</label>
                <textarea class="txtInput" id="txtDesc" name="txtDesc" 
                          required><?php echo htmlspecialchars($task['description']); ?></textarea>
                
                <label class="lbl" for="dtDate">Completion Date:</label>
                <input class="txtInput" type="date" id="dtDate" name="dtDate" 
                       value="<?php echo htmlspecialchars($task['completion_date']); ?>" required>
                
                <label class="lbl" for="txtassign">Assigned To:</label>
                <input class="txtInput" type="text" id="txtassign" name="txtassign" 
                       value="<?php echo htmlspecialchars($task['assigned_to']); ?>" required>
                
                <label class="lbl" for="status">Status:</label>
                <select class="txtInput" id="status" name="status">
                    <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="in-progress" <?php echo ($task['status'] == 'in-progress') ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                </select>
                
                <div class="div-btn">
                    <a href="home.php" class="new-item">Cancel</a>
                    <input type="submit" name="update" value="Update" class="btnSubm">
                </div>
            </div>
        </form>
    </div>
</body>
</html>