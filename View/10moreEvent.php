<?php
require_once('../base.php');
require_once('../View/db_connect.php'); // Adjust the path to your database connection file

function getUsersWithMoreThan10Events() {
    $query = "SELECT * FROM UsersWithMoreThan10Events";
    $result = $GLOBALS['conn']->query($query);

    if (!$result) {
        die("Query failed: " . $GLOBALS['conn']->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

$users = getUsersWithMoreThan10Events();
$inject['title'] = 'Users Who Created More Than 10 Events';

// Prepare HTML content
$inject['body'] = '<div class="container"><h4>Users with More Than 10 Events</h4><ul>';
foreach ($users as $user) {
    $inject['body'] .= "<li>{$user['Fname']} {$user['Lname']} - {$user['email']} - {$user['phoneNum']}</li>";
}
$inject['body'] .= '</ul></div>';

printMain($inject);
?>
