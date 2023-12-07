<?php
require_once('../base.php');
require_once('../View/db_connect.php'); // Adjust the path to your database connection file

function getClosedOrWithdrawnAbstracts() {
    $query = "SELECT * FROM ClosedOrWithdrawnAbstracts";
    $result = $GLOBALS['conn']->query($query);

    if (!$result) {
        die("Query failed: " . $GLOBALS['conn']->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

$abstracts = getClosedOrWithdrawnAbstracts();
$inject['title'] = 'Closed or Withdrawn Abstracts';

// Prepare HTML content
$inject['body'] = '<div class="container"><h4>Closed or Withdrawn Abstracts</h4><ul>';
foreach ($abstracts as $abstract) {
    $inject['body'] .= "<li>Abstract ID: {$abstract['abstractID']} - Title: {$abstract['title']} - Status: {$abstract['status']}</li>";
}
$inject['body'] .= '</ul></div>';

printMain($inject);
?>
