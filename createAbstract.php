<?php
require_once('../base.php');
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);

require_once('getzip.php');


$inject = [
    "title" => "Create Abstract Page",
    "body" => "Create Abstract Page"
];

// if user is not logged in ... redirect to login page
if(!isset($_SESSION['userid'])) {
    header('Refresh: 2;url=/CPSC-332-Group-Project/authentication');
    $inject['warning'] = '<span>Must Be Logged in. Redirecting...<a href="/CPSC-332-Group-Project/authentication">Click Here if you dont redirect automatically</a></span>';
}
// otherwise, user is registered & logged in 
// create employer 
else if (isset($_SESSION['abstractID'])) {
    header('Refresh: 2;url=/CPSC-332-Group-Project/event');
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
        $deadline = NULL;
        $eventID = NULL;
        $reviewerID = NULL;
        $presenterID = NULL;
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
        if(!empty($_POST['presenterID']))
        {
            $presenterID = $_POST['presenterID'];
        }
        if(!empty($_POST['mentorID']))
        {
            $mentorID = $_POST['mentorID'];
        }

        [$error, $success] = makeAbstract($abstractType, $accepted, $subject, $deadline, $eventID, $reviewerID, $presenterID, $mentorID);
        $inject['body'] = $_SESSION['employerid'];
        
        if($success) {
            header('Refresh: 2;url=/CPSC-332-Group-Project/event');
            $inject['success'] = '<span>Successfully Created Abstract as: ' . issetor($_SESSION['abstractid']) . 
            ', redirecting...<a href="/CPSC-332-Group-Project/event">Click Here if you dont redirect automatically</a></span>';
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

    // $abstractrole = $_POST['abstractrole'];
    
    if (!filter_var($abstractType, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid Type";
        return [$error, FALSE];
    }

    if(!empty($_POST['eventID']) && !empty($_POST['reviewerID']) && !empty($_POST['presenterID']) && !empty($_POST['mentorID']))
    {
        $abstractIDs = [
            'eventID' => $eventID,
            'reviwerID' => $reviewerID,
            'presenterID' => $presenterID,
            'mentorID' => $mentorID,
        ];

        [$error, $abstractid] = createAbstract($abstractIDs);
        if ($error) {
            return [$error, FALSE];
        }
    } 
    else 
    {
        $abstractid = NULL;
    }
    
    $absinfo= [
        'abstractType' => $abstractType,
        'abstractid' => $abstractid,
        'accepted' => $accepted,
        'subject' => $subject,
        'deadline' => $deadline,
    ];

    [$error, $abstractid] = createAbstract($absinfo);
    if ($error) {
        return [$error, FALSE];
    }

   
    return [$error, FALSE];
}



function createAbstract($abstractinfo) {
    try {
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO abstract (abstractType, accepted, 'subject', deadline, eventID, reviewerID, presenterID, mentorID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssss', $abstractinfo['abstractType'], $abstractinfo['accepted'], $abstractinfo['subject'], $abstractinfo['deadline'], $abstractinfo['eventID'], $abstractinfo['reviewerID'], $abstractinfo['presenterID'], $abstractinfo['mentorID'] );
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
                <h4>Create Employer</h4>  
                <form action="create.php" method="post">
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
                        <input type="accepted" class="form-control" id="accepted" name="accepted" aria-describedby="abstractHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['accepted'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="phonenumber" class="form-label">Phone Number *</label>
                        <input type="phone" class="form-control" id="phonenumber" name="phonenumber" aria-describedby="abstractHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['subject'])) .
                        'required>
                    
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="text" class="form-control" id="deadline" name="deadline"' .
                            ifNotEmptyValueAttribute(issetor($_POST['deadline'])) .
                        '>
                    </div>
                    <div class="mb-3">
                        <label for="eventID" class="form-label">EventID</label>
                        <input type="text" class="form-control" id="eventID" name="eventID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['eventID'])) .
                            //should add an ajax event to query getzip and autofill city and state
                        '>
                    </div>
                    <div class="mb-3">
                        <label for="reviewerID" class="form-label">ReviewerID</label>
                        <input type="text" class="form-control" id="reviewerID" name="reviewerID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['reviewerID'])) .
                        '>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" name="presenterID"' .
                            ifNotEmptyValueAttribute(issetor($_POST['presenterID'])) .
                        '>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> ';
}

?>