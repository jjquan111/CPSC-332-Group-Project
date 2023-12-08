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

function printInitTableLink() {

    $body = '<div class="container text-center">
              <h4>DB not initialized yet</h4>
              <form action="' . $GLOBALS['rootpath'] . '/init.php" method="POST">
                <button type="submit" class="btn btn-primary">Create DB and populate with data</button>
              </form>
            </div>';
  
    $inject = [
      "body" => $body,
      "title" => "Schemers Job Search - Not created yet"
    ];
  
    return $inject;
  }

  function doesDBExist() {
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], '', $GLOBALS['port']);
    $s = 'SELECT COUNT(*) AS `exists` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME="' . $GLOBALS['database'] . '"';
    $query = $conn->query($s);
    $row = $query->fetch_object();
    $dbExists = (bool) $row->exists;
    $conn->close();
    return $dbExists;
  }

$inject= [
    "title"=> "Home Page", 
    "Body"=> ""
];
if(doesDBExist()) {
    $inject["body"]= "<html>
    <h1>Welcome!</h1>
    <h3>Check out the Events tab!</h3>
    </html>";
} else {
    $inject = printInitTableLink();
}
printMain($inject);

// Close the connection to the database
//$mysqli->close();
?>
