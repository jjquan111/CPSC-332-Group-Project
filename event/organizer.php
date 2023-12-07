<?php
function getOrganizer($details) {
    
    if(empty($_POST['eventName'])) {
        $_POST['eventName'] = $details['eventName'];
    }
    if(empty($_POST['uniID'])) {
        $_POST['uniID'] = $details['uniID'];
    }
    if(empty($_POST['description'])) {
        $_POST['description'] = $details['description'];
    }
    if(empty($_POST['startTime'])) {
        $_POST['startTime'] = $details['startTime'];
    }
    if(empty($_POST['endTime'])) {
        $_POST['endTime'] = $details['endTime'];
    }
    if(empty($_POST['capacity'])) {
        $_POST['capacity'] = $details['capacity'];
    }
    if(empty($_POST['eventType'])) {
        $_POST['eventType'] = $details['eventType'];
    }
    if(empty($_POST['venID'])) {
        $_POST['venID'] = $details['venID'];
    }
    $inject = ['title'=>'Update event', 'body'=>''];
    if(issetor($_POST['eventName']) != $details['eventName'] ||
    issetor($_POST['uniID']) != $details['uniID'] ||
    issetor($_POST['description']) != $details['description'] ||
    issetor($_POST['startTime']) != $details['startTime'] ||
    issetor($_POST['endTime']) != $details['endTime'] ||
    issetor($_POST['capacity']) != $details['capacity'] ||
    issetor($_POST['eventType']) != $details['eventType'] ||
    issetor($_POST['venID']) != $details['venID']) {

        $eventName = $_POST['eventName'];
        $uniID = $_POST['uniID'];
        $description = $_POST['description'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $capacity = $_POST['capacity'];
        $eventType = $_POST['eventType'];
        $venID = $_POST['venID'];
        $eventID = $details['eventID'];

        [$error,$result] = makeEvent($eventID, $eventName, $description, $startTime, $endTime, $capacity, $eventType, $uniID, $venID);
        if(!$result) {
            $inject['body'] = getOrganizerForm($error);
        } else {
            $inject['success'] = "updated";
            $inject['body'] = getOrganizerForm();
        }
    } else {
        $inject['body'] = getOrganizerForm();
    }
    return $inject;
}

function makeEvent($eventID,$eventName, $description, $startTime, $endTime, $capacity, $eventType, $uniID, $venID) {
    $eventinfo = [
        'eventName'=> $eventName,
        'description'=> $description,
        'startTime'=> $startTime,
        'endTime'=> $endTime,
        'capacity'=> $capacity,
        'eventType'=> $eventType,
        'uniID'=> $uniID,
        'venID'=> $venID
    ];
    [$error, $eventid] = updateEvent($eventID,$eventinfo);
    if($error) {
        return [$error, FALSE];
    }

    return [NULL, TRUE];
}

function updateEvent($eventID,$eventInfo) {
    try {
        $sqlString = '';
        $ses = 's';
        foreach($eventInfo as $key => $value) {
            
            $sqlString .= ', '. $key .'=?';
            $ses .= 's';
            
        }
        $sqlString = substr($sqlString,2);
        $vals = array_values($eventInfo);
        $vals[] = $eventID;
        $statement = $GLOBALS['conn']->prepare("UPDATE _event SET ". $sqlString ." WHERE eventID=?");
        $statement->bind_param($ses, ...$vals);
        $statement->execute();
        $res = $statement->get_result();
        if(!$res) {
            return [NULL, $res];
        } else {
            return ['No user found with those details.', NULL];
        }
    } catch(Exception $e) {
        return ['error updating event: '. $e, NULL];
    }
}

function getOrganizerForm($error = '') {
    return '<div class="container">  
    <div class="alert-danger"><p>' . issetor($error) . '</p></div>
    <h4>Update Event</h4>  
    <form action="" method="post">
        <div class="mb-3">
        </div>
        <div class="mb-3">
            <label for="eventName" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="eventName" name="eventName"' .
                ifNotEmptyValueAttribute(issetor($_POST['eventName'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Event Discription</label>
            <input type="text" class="form-control" id="description" name="description"' .
                ifNotEmptyValueAttribute(issetor($_POST['description'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="startTime" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="startTime" name="startTime"' .
                ifNotEmptyValueAttribute(issetor($_POST['startTime'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="endTime" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="endTime" name="endTime"' .
                ifNotEmptyValueAttribute(issetor($_POST['endTime'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="uniID" class="form-label">University ID</label>
            <input type="number" class="form-control" id="uniID" name="uniID"' .
                ifNotEmptyValueAttribute(issetor($_POST['uniID'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="venID" class="form-label">Venue ID</label>
            <input type="number" class="form-control" id="venID" name="venID"' .
                ifNotEmptyValueAttribute(issetor($_POST['venID'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity"' .
                ifNotEmptyValueAttribute(issetor($_POST['capacity'])) .
            'required>
        </div>
        <div class="mb-3">
            <label for="eventType" class="form-label">Event Type</label>
            <input type="text" class="form-control" id="eventType" name="eventType"' .
                ifNotEmptyValueAttribute(issetor($_POST['eventType'])) .
            'required>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="'.$GLOBALS['rootpath'] .'/event/createReviewer.php?eventid='. $_GET['eventid'] .'">Add a reviewer</a>
    </form>
</div> ';
}
?>