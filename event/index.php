<?php
require_once('../base.php');
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);
require_once('getevent.php');

$inject = [
    'title' => 'View Events',
    'body' => ''
];
// check if url like localhost/cs332/post/?postid=12345
if (isset($_GET['eventid'])) {
    // look up post 12345 from url in sql
    // htmlspecialchars is a safety precaution
    [$error, $eventdetails] = getEventDetails(htmlspecialchars($_GET['eventid']));
    if (isset($eventdetails)) {
        $inject['body'] = printEventDetails($eventdetails);
    } else {
        $inject = [
            'body' => '<div class="alert-danger"><h6>' . $error . '</h6></div>',
            'title' => 'Event Error - ' . $error
        ];
    }
}

printMain($inject);
$conn->close();

?>