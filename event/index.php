<?php
require_once('../base.php');
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);
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
    if(isset($details) && $details['organizerID'] == issetor($_SESSION['userid'])) {
        $inject = getOrganizer($details);
    } else if(isset($_SESSION['userid']) && !$neures){
        $inject = getNeutral($details);
    } else {
        $inject['body'] = $neuerror;
    }

}

printMain($inject);
$conn->close();
?>