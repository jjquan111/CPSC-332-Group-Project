<?php
require_once('../base.php');
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);


$inject = [
    "title" => "Create Abstract Page",
    "body" => "Create Abstract Page"
];

// if user is not logged in ... redirect to login page
if(!isset($_SESSION['userid'])) {
    header('Refresh: 2;url='. $GLOBALS['rootpath'] .'/authentication');
    $inject['warning'] = '<span>Must Be Logged in. Redirecting...<a href="/CPSC-332-Group-Project/authentication">Click Here if you dont redirect automatically</a></span>';
}
// otherwise, user is registered & logged in 
// create employer 
else if (isset($_SESSION['abstractID'])) {
    header('Refresh: 2;url='. $GLOBALS['rootpath'] .'event');
    $inject['warning'] = '<span>Already Abstract. Redirecting...<a href="/CPSC-332-Group-Project/event">Click Here if you dont redirect automatically</a></span>';
}
else {
    if(!empty($_POST['abstractType']) 
    && !empty($_POST['subject'])
    )
     {

        $abstractType = $_POST['abstractType'];
        $subject = $_POST['subject'];
        $accepted = NULL;
        $deadline = $_POST['deadline'];
        $eventID = $_POST['eventID'];
        $reviewerID = NULL;
        $presenterID = $_SESSION['userid'];
        $mentorID = NULL;  

        if(!empty($_POST['accepted']))
        {
            $accepted = $_POST['accepted'];
        }
        if(!empty($_POST['eventID']))
        {
            $eventID = $_POST['eventID'];
        }
        if(!empty($_POST['reviewerID']))
        {
            $reviewerID = $_POST['reviewerID'];
        }
        if(!empty($_POST['mentorID']))
        {
            $mentorID = $_POST['mentorID'];
        }

        [$error, $success] = makeAbstract($abstractType, $accepted, $subject, $deadline, $eventID, $reviewerID, $presenterID, $mentorID);
        
        if($success) {
            header('Refresh: 2;url=/CPSC-332-Group-Project/event');
            $inject['success'] = '<span>Successfully Created Abstract</span>';
            $inject['body'] = 'Success';
        }
        else { 
            $inject['body'] = printAbstractForm($error);
        }
    }
    else {
        $inject['body'] = printAbstractForm();
    }
}

printMain($inject);

$conn->close();



function makeAbstract($abstractType, $accepted, $subject, $deadline, $eventID, $reviewerID, $presenterID, $mentorID) {

    $absinfo= [
        'abstractType' => $abstractType,
        'accepted' => $accepted,
        'subject' => $subject,
        'deadline' => $deadline,
        'eventID' => $eventID,
        'reviewerID' => $reviewerID,
        'presenterID' => $presenterID,
        'mentorID' => $mentorID,
    ];

    [$error, $abstractid] = createAbstract($absinfo);
    if ($error) {
        return [$error, FALSE];
    }

   
    return [NULL, TRUE];
}



function createAbstract($abstractinfo) {
    try {
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO abstract (abstractType, accepted, subject, deadline, eventID, presenterID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $abstractinfo['abstractType'], $abstractinfo['accepted'], $abstractinfo['subject'], $abstractinfo['deadline'], $abstractinfo['eventID'], $abstractinfo['presenterID']);
        $stmt->execute();
        $abstractid = $stmt->insert_id;
        return [NULL, $abstractid];
    }
    catch (Exception $e) {
        return ['Failed to create employer. ' . $e, NULL];
    }
}



function printAbstractForm($error = "") {
    // set up create employer form
    return '<div class="container">  
                <div class="alert-danger"><p>' . issetor($error) . '</p></div>
                <h4>Create Abstract</h4>  
                <form action="createAbstract.php" method="post">
                    <div class="mb-3">
                        <class="form-label">* Required Field</label>
                    </div>
                    <div class="mb-3">
                        <label for="abstractType" class="form-label">Abstract Type *</label>
                        <input type="text" class="form-control" id="abstractType" name="abstractType" aria-describedby="abstractHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['abstractType'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="accepted" class="form-label">Accepted *</label>
                        <input type="text" class="form-control" id="accepted" name="accepted" aria-describedby="abstractHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['accepted'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" class="form-control" id="subject" name="subject" aria-describedby="abstractHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['subject'])) .
                        'required>
                    
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline *</label>
                        <input type="datetime-local" class="form-control" id="deadline" name="deadline"' .
                            ifNotEmptyValueAttribute(issetor($_POST['deadline'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="eventID" class="form-label">EventID *</label>
                        <input type="number" value="'. $_GET['eventid'].'" class="form-control" id="eventID" name="eventID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['eventID'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="reviewerID" class="form-label">ReviewerID</label>
                        <input type="number" class="form-control" id="reviewerID" name="reviewerID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['reviewerID'])) .
                        '>
                    </div>
                    <div class="mb-3">
                        <label for="mentorID" class="form-label">Mentor ID</label>
                        <input type="number" class="form-control" id="mentorID" name="mentorID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['mentorID'])) .
                        '>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> ';
}

?>