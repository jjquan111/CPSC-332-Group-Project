<?php
// Database parameters
$servername = "your_server_name";  // e.g., "localhost"
$username = "your_database_username";  // e.g., "root"
$password = "your_database_password";
$database = "your_database_name";  // e.g., "cybermagicians"
$port = "your_database_port";  // Optional, default is 3306 for MySQL

// Create a MySQLi connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// The connection is now established and can be used in other scripts
?>