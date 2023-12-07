<?php
require_once("../base.php");
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);

$inject = [
    "title" => "create event",
    "body" => ""
];

if(!isset($_SESSION['userid'])) {
    header('Refresh: 1; url=' . $GLOBALS['rootpath'] . '/authentication');
    $inject['warning'] = '<span>Not logged in!</span>';
} else if(!empty($_POST['eventName']) &&
!empty($_POST['uniID']) &&
!empty($_POST['description']) &&
!empty($_POST['startTime']) &&
!empty($_POST['endTime']) &&
!empty($_POST['capacity']) &&
!empty($_POST['eventType']) &&
!empty($_POST['venID'])) {
    $eventName = $_POST['eventName'];
    $uniID = $_POST['uniID'];
    $description = $_POST['description'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $capacity = $_POST['capacity'];
    $eventType = $_POST['eventType'];
    $venID = $_POST['venID'];
    $published = "No";
    $speakerID = 1;
    $sponsorID = 1;

    if(!empty($_POST['published'])) {
        $published = $_POST['published'];
    }if(!empty($_POST['speakerID'])) {
        $speakerID = $_POST['speakerID'];
    }if(!empty($_POST['sponsorID'])) {
        $sponsorID = $_POST['sponsorID'];
    }

    $organizerID = $_SESSION['userid'];

    [$error,$success] = makeEvent($eventName, $published, $description, $startTime, $endTime, $capacity, $eventType, $uniID, $venID, $speakerID, $sponsorID, $organizerID);
    
    if($success) {
        header('Refresh: 3;url='. $GLOBALS['rootpath'] . '/organizer');
        $inject['success']='<span>Successfully created post. Redirecting...</span>';
        $inject['body'] = 'success';
    } else {
        $inject['body'] = printEventForm($error);
    }
} else {
    $inject['body'] = printEventForm("wow error");
}

printMain($inject);

$conn->close();

function getTypeOpts() {
    return [NULL, array("opt1","opt2")];
}

function makeEvent($eventName, $published, $description, $startTime, $endTime, $capacity, $eventType, $uniID, $venID, $speakerID, $sponsorID, $organizerID) {
    $eventinfo = [
        'eventName'=> $eventName,
        'published'=> $published,
        'description'=> $description,
        'startTime'=> $startTime,
        'endTime'=> $endTime,
        'capacity'=> $capacity,
        'eventType'=> $eventType,
        'uniID'=> $uniID,
        'venID'=> $venID,
        'speakerID'=> $speakerID,
        'sponsorID'=> $sponsorID,
        'organizerID'=> $organizerID
    ];
    [$error, $eventid] = createEvent($eventinfo);
    if($error) {
        return [$error, FALSE];
    }

    return [NULL, TRUE];
}

function createEvent($eventinfo) {
    try {
        $statement = $GLOBALS['conn']->prepare('INSERT INTO _event (eventName, published, description, startTime, endTime, capacity, eventType, uniID, venID, speakerID, sponsorID, organizerID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->bind_param('ssssssssssss', $eventinfo['eventName'],$eventinfo['published'],$eventinfo['description'],$eventinfo['startTime'],$eventinfo['endTime'],$eventinfo['capacity'],$eventinfo['eventType'],$eventinfo['uniID'],$eventinfo['venID'],$eventinfo['speakerID'],$eventinfo['sponsorID'],$eventinfo['organizerID']);
        $statement->execute();
        $eventid = $statement->insert_id;
        return [NULL, $eventid];
    } catch(Exception $e) {
        return ['Failed to create event. ' . $e, NULL];
    }
}

function printEventForm($error = "") {
    // set up create employer form
    return '<div class="container">  
                <div class="alert-danger"><p>' . issetor($error) . '</p></div>
                <h4>Create Employer</h4>  
                <form action="create.php" method="post">
                    <div class="mb-3">
                        <class="form-label">* Required Field</label>
                    </div>
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Event Name *</label>
                        <input type="text" class="form-control" id="eventName" name="eventName"' .
                            ifNotEmptyValueAttribute(issetor($_POST['eventName'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Event Discription *</label>
                        <input type="text" class="form-control" id="description" name="description"' .
                            ifNotEmptyValueAttribute(issetor($_POST['description'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Start Time *</label>
                        <input type="datetime-local" class="form-control" id="startTime" name="startTime"' .
                            ifNotEmptyValueAttribute(issetor($_POST['startTime'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label">End Time *</label>
                        <input type="datetime-local" class="form-control" id="endTime" name="endTime"' .
                            ifNotEmptyValueAttribute(issetor($_POST['endTime'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="uniID" class="form-label">University ID *</label>
                        <input type="number" class="form-control" id="uniID" name="uniID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['uniID'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="venID" class="form-label">Venue ID *</label>
                        <input type="number" class="form-control" id="venID" name="venID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['venID'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity *</label>
                        <input type="number" class="form-control" id="capacity" name="capacity"' .
                            ifNotEmptyValueAttribute(issetor($_POST['capacity'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="eventType" class="form-label">Event Type *</label>
                        <input type="text" class="form-control" id="eventType" name="eventType"' .
                            ifNotEmptyValueAttribute(issetor($_POST['eventType'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="published" class="form-label">Publish Status</label>
                        <input type="text" class="form-control" id="published" name="published"' .
                            ifNotEmptyValueAttribute(issetor($_POST['published'])) .
                        '>
                    </div>
                    <div class="mb-3">
                        <label for="speakerID" class="form-label">Speaker ID</label>
                        <input type="number" class="form-control" id="speakerID" name="speakerID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['speakerID'])) .
                        '>
                    </div>
                    <div class="mb-3">
                        <label for="sponsorID" class="form-label">Sponsor ID</label>
                        <input type="number" class="form-control" id="sponsorID" name="sponsorID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['sponsorID'])) .
                        '>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> ';
}

?>