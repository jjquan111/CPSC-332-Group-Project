<?php
require_once('../base.php');
require_once('../View/db_connect.php'); // Adjust the path to your database connection file

function getEventsWithMoreThan100Abstracts() {
    $query = "SELECT * FROM EventsWithMoreThan100Abstracts";
    $result = $GLOBALS['conn']->query($query);

    if (!$result) {
        die("Query failed: " . $GLOBALS['conn']->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

$events = getEventsWithMoreThan100Abstracts();
$inject['title'] = 'Events With More Than 100 Abstracts';

// Prepare HTML content
$inject['body'] = '<div class="container"><h4>Events with More Than 100 Abstracts</h4><ul>';
foreach ($events as $event) {
    $inject['body'] .= "<li>Event ID: {$event['eventID']} - Event Name: {$event['eventName']} - Number of Abstracts: {$event['NumberOfAbstracts']}</li>";
}
$inject['body'] .= '</ul></div>';

printMain($inject);
?>
