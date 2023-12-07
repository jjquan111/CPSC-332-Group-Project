<?php 
/*
Events
(view all events and has option to become reviewer and create abstract)
(if you submit a abstract you are a presenter)
(if you review a abstract you are a reviewer)
(sign up for events as a atendee(highlight events attending)) 
*/
require_once('../base.php'); // contains nav bar
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);
require_once('getevents.php'); // contains nav bar

$inject = [
    'title' => 'All Events',
    'body' => 'No events'
];
//$inject['warning'] = 'Failed to fetch job posts. ';

[$error, $events] = getAllEvents();

if (isset($events)) {
    $inject['body'] = printEvents($events);
} else {
    $inject['warning'] = 'Failed to fetch events. ' . $error;
}

printMain($inject);

?>