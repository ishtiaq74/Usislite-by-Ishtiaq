<?php
// Load DB config from config.php (create it by copying config.example.php)
if (!file_exists(__DIR__ . '/config.php')) {
    die("Missing config.php. Copy config.example.php to config.php and set your DB credentials.");
}
require_once __DIR__ . '/config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>
