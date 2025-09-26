<?php
// Database connection parameters
$servername = "sql208.infinityfree.com";
$username = "if0_36734794";
$password = "attendance2024";
$dbname = "if0_36734794_Attendance_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>