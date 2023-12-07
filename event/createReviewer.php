<?php
require_once("../base.php");
require_once("getevent.php");
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);

$inject = [
    "title" => "add reviwer",
    "body" => ""
];

if(!isset($_SESSION['userid'])) {
    header('Refresh: 2; url=' . $GLOBALS['rootpath'] . '/authentication');
    $inject['warning'] = '<span>Not logged in!</span>';
} else if(isset($_GET['eventid'])) {
    $details = getEventDetails($_GET['eventid']);
    if(!isset($details) && $details['organizerID'] != issetor($_SESSION['userid'])) {
        header('Refresh: 2; url=' . $GLOBALS['rootpath'] . '/events');
        $inject['warning'] = '<span>No permission!</span>';
    } else {
        if(!empty($_POST['reviewerID'])) {
            $reviewerID = $_POST['reviewerID'];
            $eventID = $_GET['eventid'];
            [$error,$success] = makeReviwer($eventID, $reviewerID); 
            
            if($success) {
                header('Refresh: 3;url='. $GLOBALS['rootpath'] . '/event?eventid='.$eventID);
                $inject['success']='<span>Successfully created post. Redirecting...</span>';
                $inject['body'] = 'success';
            } else {
                $inject['body'] = printReviewerForm($error);
            }
        } else {
            $inject['body'] = printReviewerForm();
        }
    }
} else {
    header('Refresh: 2; url=' . $GLOBALS['rootpath'] . '/events');
    $inject['warning'] = '<span>No event provided!</span>';
}

printMain($inject);

$conn->close();

function makeReviwer($eventID, $reviewerID) {
    $reviewerinfo = [
        'eventid'=> $eventID,
        'reviewerid'=> $reviewerID
    ];
    [$error, $reviewerid] = createReviewer($reviewerinfo);
    if($error) {
        return [$error, FALSE];
    }

    return [NULL, TRUE];
}

function createReviewer($eventinfo) {
    try {
        $statement = $GLOBALS['conn']->prepare('INSERT INTO reviewer (eventID, userID) VALUES (?, ?)');
        $statement->bind_param('ss', $eventinfo['eventid'], $eventinfo['reviewerid']);
        $statement->execute();
        $reviewerid = $statement->insert_id;
        return [NULL, $reviewerid];
    } catch(Exception $e) {
        return ['Failed to create reviewer. ' . $e, NULL];
    }
}

function printReviewerForm($error = "") {
    // set up create employer form
    return '<div class="container">  
                <div class="alert-danger"><p>' . issetor($error) . '</p></div>
                <h4>Create Employer</h4>  
                <form action="" method="post">
                    <div class="mb-3">
                        <class="form-label">* Required Field</label>
                    </div>
                    <div class="mb-3">
                        <label for="reviewerID" class="form-label">Reviewer ID</label>
                        <input type="number" class="form-control" id="reviewerID" name="reviewerID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['reviewerID'])) .
                        '>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> ';
}

?>