<?php
// registration.php
session_start();

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password'); 
$retype = filter_input(INPUT_POST, 'retype');    
$role = 'Admin';

if (!empty($username) && !empty($password) && !empty($retype) && $password === $retype) {
    require_once 'db_connect.php';
    
    // Check if username already exists
    $check = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo '<script>alert("Username already exists!");</script>';
        echo '<script>window.location.href = "signUp.php";</script>';
        exit();
    }
    
    // Hash the raw password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    
    if ($stmt->execute()) {
        $_SESSION['Lusername'] = $username;
        echo '<script>alert("Registration successful!");</script>';
        echo '<script>window.location.href = "home.php";</script>';
    } else {
        echo '<script>alert("Error during registration!");</script>';
        echo '<script>window.location.href = "signUp.php";</script>';
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("Please fill all fields and make sure passwords match!");</script>';
    echo '<script>window.location.href = "signUp.php";</script>';
}
?>