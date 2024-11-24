<?php
session_start();
if (isset($_SESSION['Lusername'])) {
    $title = htmlspecialchars(Filter_input(INPUT_POST, 'txttitle'));
    $desc = htmlspecialchars(Filter_input(INPUT_POST, 'txtDesc'));
    $completion_date = htmlspecialchars(Filter_input(INPUT_POST, 'dtDate'));
    $assigned_to = htmlspecialchars(Filter_input(INPUT_POST, 'txtassign'));

    if (!empty($title) && !empty($desc) && !empty($completion_date) && !empty($assigned_to)) {
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "taskManager";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ')' . $conn->connect_error);
        } else {
            // First check if assigned user exists
            $check_user = $conn->prepare("SELECT username FROM users WHERE username = ?");
            $check_user->bind_param("s", $assigned_to);
            $check_user->execute();
            $result = $check_user->get_result();
            
            if ($result->num_rows === 0) {
                echo '<script>alert("Assigned user does not exist!")</script>';
                header("Refresh:2; url=NewTask.php", true, 0);
                exit();
            }
            $check_user->close();

            // If user exists, proceed with task insertion
            $stmt = $conn->prepare("INSERT INTO tasks (title, description, completion_date, assigned_to, status) VALUES (?, ?, ?, ?, 'pending')");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("ssss", $title, $desc, $completion_date, $assigned_to);

            if ($stmt->execute()) {
                echo '<script>alert("Task added successfully")</script>';
                header("Refresh:0; url=home.php", true, 0);
            } else {
                echo "Error: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "One of the fields is empty, Please provide the required information.";
        die();
    }
} else {
    header("Location: index.php");
}
?>