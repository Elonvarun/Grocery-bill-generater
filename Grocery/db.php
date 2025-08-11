<?php
// db.php
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'grocery_db';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure proper charset to avoid charset-related injection issues and mojibake
if (!$conn->set_charset('utf8mb4')) {
    error_log('Error setting charset to utf8mb4: ' . $conn->error);
}
?>
