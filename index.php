<?php
require_once("base.php");
function connectToDatabase($host, $user, $pass, $dbname = '')
{
    $mysqli = new mysqli($host, $user, $pass, $dbname);

    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    return $mysqli;
}

function createDatabase($mysqli, $dbname)
{
    $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbname";

    if ($mysqli->query($createDbQuery)) {
        echo "Database $dbname created successfully";
    } else {
        die("Error creating database: " . $mysqli->error);
    }
}

function createTable($mysqli)
{
    $createTableQuery = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL
            )";

    if ($mysqli->query($createTableQuery)) {
        echo "Table 'users' created successfully";
    } else {
        die("Error creating table: " . $mysqli->error);
    }
}

// Connect to MySQL server and create or select the database

//$mysqli = connectToDatabase($dbhost, $dbuser, $dbpass);

// Check if the database exists and create if needed

//createDatabase($mysqli, $dbname);

// Create or select the database

//$mysqli = connectToDatabase($dbhost, $dbuser, $dbpass, $dbname);

// Create a sample table

//createTable($mysqli);

$inject= [
    "title"=> "Home Page", 
    "Body"=> ""
];
$inject["body"]= "<html>
<h1>hello world!</h1>
</html>";
printMain($inject);

// Close the connection to the database
//$mysqli->close();
?>
