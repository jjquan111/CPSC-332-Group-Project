<?php
function registerUser() {
    $inject = ['title' => 'Register', 'body'=>''];
    if (!empty($_POST['register_email'])
        && !empty($_POST['register_password']) 
        && !empty($_POST['register_firstname'])
        && !empty($_POST['register_lastname'])
        && !empty($_POST['register_number'])
        && !empty($_POST['register_inst'])) {

        [$error , $userid] = makeSession($_POST['register_email'], $_POST['register_password'], $_POST['register_firstname'], $_POST['register_lastname'], $_POST['register_number'], $_POST['register_inst']);
        if ($userid) {
            $inject['success'] = '<span>Successfully Registered</span>';
            $inject['redirect'] = '/CPSC-332-GROUP-PROJECT';
        }
        else {
            $inject['body'] = getRegisterForm($error);
        }
    }
    else {
        $inject['body'] = getRegisterForm(); 
    }
    return $inject;
}

function checkEmailInUse($email) {
    $statement = $GLOBALS['conn']->prepare("SELECT email FROM user AS u WHERE u.email = ?");
    $statement->bind_param('s', $email);
    $statement->execute();
    $res = $statement->get_result();
    $val = $res->fetch_assoc();
    return isset($val['Email']);
}

function isPassValid($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8)) {
        return ['Strong Password', TRUE];
    }
    else {
        return ['Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, one number, and one special character.', FALSE];
    }
}

function createUser($info) {
    $statement = $GLOBALS['conn']->prepare("INSERT INTO user (email, password, Fname, Lname, phoneNum, institution) VALUES (?, ?, ?, ?, ?, ?)");
    $statement->bind_param('ssssss', $info['email'], $info['password'],$info['fname'],$info['lname'],$info['number'], $info['institution']);
    $statement->execute();
    $userid = $statement->insert_id;
    if(isset($userid)) {
        return [NULL, $userid];
    }
    return ['Failed to create user', NULL];
}

function makeSession($email, $password, $fname, $lname, $phonenumber, $inst) {
    if(checkEmailInUse($email)) {
        return ["Email alreadt registered, <a href='login.php'>Login</a>", NULL];
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ["Bad email", NULL];
    }
    [$msg, $valid] = isPassValid($password);
    if(!$valid) {
        return [$msg, NULL];
    }
    $phonenumber = filter_var($phonenumber, FILTER_SANITIZE_NUMBER_INT);

    $userinfo = [
        'email'=> $email,
        'password' => $password,
        'fname' => $fname,
        'lname' => $lname,
        'number' => $phonenumber,
        'institution' => $inst
    ];

    [$error,$userid] = createUser($userinfo);
    if(isset($userid)) {
        $_SESSION['userid'] = $userid;
        return ['userid', TRUE];
    }
    return [$error, FALSE];
}

function getRegisterForm($error = "") {
    return '<div class="container">  
                <div class="danger"><p>' . $error . '</p></div>
                <h4>Create Account</h4>  
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="register_email"
                            name="register_email" aria-describedby="emailHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['register_email'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="register_firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="register_firstname"
                            name="register_firstname" aria-describedby="emailHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['register_firstname'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="register_lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="register_lastname"
                            name="register_lastname" aria-describedby="emailHelp"' .
                            ifNotEmptyValueAttribute(issetor($_POST['register_lastname'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="register_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="register_password"
                            name="register_password"' .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="register_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="register_number"
                            name="register_number"' . 
                            ifNotEmptyValueAttribute(issetor($_POST['register_number'])) .
                        'required>
                    </div>
                    <div class="mb-3">
                        <label for="register_number" class="form-label">Institution</label>
                        <input type="tel" class="form-control" id="register_inst"
                            name="register_inst"' . 
                            ifNotEmptyValueAttribute(issetor($_POST['register_inst'])) .
                        'required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> ';
}
?>