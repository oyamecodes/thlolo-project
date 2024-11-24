<?php
session_start();
if (isset($_SESSION['Lusername']) && isset($_GET['id'])) {
    $pID = intval($_GET['id']);
    
    require_once 'db_connect.php';
    
    // Add check to ensure user owns the task
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("is", $pID, $_SESSION['Lusername']);
    
    if ($stmt->execute()) {
        echo '<script>alert("Task deleted successfully");</script>';
        echo '<script>window.location.href = "home.php";</script>';
    } else {
        echo '<script>alert("Error deleting task");</script>';
        echo '<script>window.location.href = "home.php";</script>';
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>