<?php
// login.php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password'); // Don't sanitize password

if (!empty($username) && !empty($password)) {
    require_once 'db_connect.php';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Compare raw password with stored hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['Lusername'] = $username;
            header("Location: home.php");
            exit();
        } else {
            // For debugging only
            error_log("Password verification failed for user: $username");
            echo '<script>alert("Invalid password!");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        }
    } else {
        echo '<script>alert("User not found!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("Please fill all fields!");</script>';
    echo '<script>window.location.href = "index.php";</script>';
}
?>