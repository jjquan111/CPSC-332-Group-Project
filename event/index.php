<?php
require_once('../base.php');
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);
// <<<<<<< HEAD
// require_once('getevent.php');

// $inject = [
//     'title' => 'View Events',
//     'body' => ''
// ];
// // check if url like localhost/cs332/post/?postid=12345
// if (isset($_GET['eventid'])) {
//     // look up post 12345 from url in sql
//     // htmlspecialchars is a safety precaution
//     [$error, $eventdetails] = getEventDetails(htmlspecialchars($_GET['eventid']));
//     if (isset($eventdetails)) {
//         $inject['body'] = printEventDetails($eventdetails);
//     } else {
//         $inject = [
//             'body' => '<div class="alert-danger"><h6>' . $error . '</h6></div>',
//             'title' => 'Event Error - ' . $error
//         ];
//     }
// =======
require_once('organizer.php');
require_once('getevent.php');
require_once('neutraluser.php');
$inject = [
    'title'=>'whoa',
    'body'=>''
];

if(isset($_GET['eventid'])) {
    [$error,$details] = getEventDetails($_GET['eventid']);
    [$neuerror,$neures] = isNeutralSigned($details);
    if (isset($details)) {
                 $inject['body'] = printEventDetails($details);
             } else {
                 $inject = [
                     'body' => '<div class="alert-danger"><h6>' . $error . '</h6></div>',
                     'title' => 'Event Error - ' . $error
                 ];
             }
    $inject['body'] = printEventDetails($details);
    if(isset($details) && $details['organizerID'] == issetor($_SESSION['userid'])) {
        $thing = getOrganizer($details);
        $inject['body'] .= $thing['body']; 
    } else if(isset($_SESSION['userid']) && !$neures){
        $thing =  getNeutral($details);
    }


}

printMain($inject);
$conn->close();
?>