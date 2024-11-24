<?php
$servername = "localhost";
$dbUsername = "root";
$password = "";
$dbname = "taskManager";

$conn = new mysqli($servername, $dbUsername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>