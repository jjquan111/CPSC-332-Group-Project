<?php
require_once("../base.php");
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);

$inject = [
    "title" => "add reviwer",
    "body" => ""
];

if(!isset($_SESSION['userid'])) {
    header('Refresh: 1; url=' . $GLOBALS['rootpath'] . '/authentication');
    $inject['warning'] = '<span>Not logged in!</span>';
} else if(!empty($_POST['reviewerName']) &&
!empty($_POST['uniID']) &&
!empty($_POST['venID'])) {
    $reviewerName = $_POST['reviwerName'];
    $uniID = $_POST['uniID'];
    $venID = $_POST['venID'];
    $ReviewerID = 1;

    }if(!empty($_POST['reviewerID'])) {
        $reviewerID = $_POST['reviewerID'];
    }

    $reviewerID = $_SESSION['userid'];

    [$error,$success] = makeReviwer($reviwerName, $uniID, $venID, $reviewerID); 
    
    if($success) {
        header('Refresh: 3;url='. $GLOBALS['rootpath'] . '/reviewer');
        $inject['success']='<span>Successfully created post. Redirecting...</span>';
        $inject['body'] = 'success';
    } else {
        $inject['body'] = printReviewerForm($error);
    }
} else {
    $inject['body'] = printReviewerForm("wow error");
}

printMain($inject);

$conn->close();

function getTypeOpts() {
    return [NULL, array("opt1","opt2")];
}

function makeReviwer($reviwerName, $uniID, $venID, $reviewerID) {
    $reviewerinfo = [
        'reviwerName'=> $reviwerName,
        'uniID'=> $uniID,
        'venID'=> $venID,
        'reviewerid'=> $reviewerid
    ];
    [$error, $reviewerid] = createReviewer($reviewerinfo);
    if($error) {
        return [$error, FALSE];
    }

    return [NULL, TRUE];
}

function createReviewer($eventinfo) {
    try {
        $statement = $GLOBALS['conn']->prepare('INSERT INTO _reviewer (reviewerName, uniID, venID, reviwerID) VALUES (?, ?, ?, ?)');
        $statement->bind_param('ssssssssssss', $reviewerinfo['reviewerName'],$reviewerinfo['uniID'],$reviewerinfo['venID'], $reviewerinfo['reviewerID']);
        $statement->execute();
        $eventid = $statement->insert_id;
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
                <form action="create.php" method="post">
                    <div class="mb-3">
                        <class="form-label">* Required Field</label>
                    </div>
                    <div class="mb-3">
                        <label for="ReviewerName" class="form-label">Reviewer Name *</label>
                        <input type="text" class="form-control" id="ReviewerName" name="ReviewerName"' .
                            ifNotEmptyValueAttribute(issetor($_POST['ReviewerName'])) .
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
                        <label for="speakerID" class="form-label">Reviewer ID</label>
                        <input type="number" class="form-control" id="reviewerID" name="reviewerID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['reviewerID'])) .
                        '>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> ';
}

?>