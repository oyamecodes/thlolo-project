<?php
// update_profile.php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['Lusername'])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
$repassword = filter_input(INPUT_POST, 'repassword', FILTER_UNSAFE_RAW);
$current_username = $_SESSION['Lusername'];

// Debug logging
error_log("Profile update attempt for user: $current_username");
error_log("New username: $username");
error_log("Password provided: " . (!empty($password) ? "Yes" : "No"));

try {
    // Input validation
    if (empty($username) || empty($password) || empty($repassword)) {
        throw new Exception("All fields are required.");
    }

    if ($password !== $repassword) {
        throw new Exception("Passwords do not match.");
    }

    // Start transaction
    $conn->begin_transaction();

    // Generate new password hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Debug logging
    error_log("New hash generated: " . substr($hashed_password, 0, 10) . "...");

    // Update the user record
    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
    $stmt->bind_param("sss", $username, $hashed_password, $current_username);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to update user record: " . $stmt->error);
    }
    
    if ($stmt->affected_rows === 0) {
        throw new Exception("No records were updated");
    }

    // Verify the update
    $verify = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $verify->bind_param("s", $username);
    $verify->execute();
    $result = $verify->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Failed to verify update");
    }
    
    $user_data = $result->fetch_assoc();
    
    // Test the new password
    if (!password_verify($password, $user_data['password'])) {
        throw new Exception("Password verification failed after update");
    }
    
    error_log("Password update verified successfully");
    
    // Commit the transaction
    $conn->commit();
    
    // Update session
    $_SESSION['Lusername'] = $username;
    $_SESSION['success'] = "Profile updated successfully!";
    
    header("Location: home.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    error_log("Profile update error: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    header("Location: profile.php");
    exit();
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($verify)) $verify->close();
    $conn->close();
}
?>