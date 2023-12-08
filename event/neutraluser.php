<?php
function getNeutral($details) {
    
    if(empty($_POST['eventName'])) {
        $_POST['eventName'] = $details['eventName'];
    }
    
    $inject = ['title'=>'Update event', 'body'=>''];
    if(isset($_POST['attend']) && $_POST['attend']) {

        $userID = $_SESSION['userid'];
        $eventID = $details['eventID'];

        [$error,$result] = makeAttendee($eventID, $userID);
        if(!$result) {
            $inject['body'] = getSignUpForm($error);
        } else {
            $inject['success'] = "<span>You are now attending!</span>";
            $inject['body'] = getSignUpForm();
        }
    } else {
        $inject['body'] = getSignUpForm();
    }
    return $inject;
}

function makeAttendee($eventID,$userID) {
    try {
        $statement = $GLOBALS['conn']->prepare("INSERT INTO attendee (userID,eventID) VALUES (?,?)");
        $statement->bind_param('ss', $userID, $eventID);
        $statement->execute();
        $res = $statement->get_result();
        if(!$res) {
            return [NULL, TRUE];
        } else {
            return ['No user found with those details.', FALSE];
        }
    } catch(Exception $e) {
        return ['error creating attendee: '. $e, FALSE];
    }
}

function getSignUpForm($error = '') {
    return '<div class="container">  
    <div class="alert-danger"><p>' . issetor($error) . '</p></div>  
    <form action="" method="post">
        <div class="mb-3">
        </div>
        <div class="mb-3">
            <label for="attend" class="form-label">Attending?</label>
            <input type="checkbox" id="attend" name="attend"' .
                ifNotEmptyValueAttribute(issetor($_POST['attend'])) .
            'required>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="'.$GLOBALS['rootpath'] .'/event/createAbstract.php">Create an Abstract</a>
    </form>
</div> ';
}

function isNeutralSigned($details) {
    try {
        $userID = $_SESSION['userid'];
        $userID = $details['eventID'];
        $statement = $GLOBALS['conn']->prepare("SELECT * FROM attendee WHERE userID=? AND eventID=?");
        $statement->bind_param('ss', $userID, $eventID);
        $statement->execute();
        $res = $statement->get_result();
        $post = $res->fetch_assoc();
        if(isset($post)) {
            return [NULL, TRUE];
        } else {
            return ['No user found with those details.', FALSE];
        }
    } catch(Exception $e) {
        return ['error creating attendee: '. $e, FALSE];
    }
}
?>