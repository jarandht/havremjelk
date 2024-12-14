<?php
$servername = getenv('DB_HOST') ?: 'db';
$username = getenv('DB_USER') ?: 'php';
$password = getenv('DB_PASS') ?: 'php';
$database = getenv('DB_NAME') ?: 'php';    

$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
