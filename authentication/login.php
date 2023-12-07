<?php

function loginUser() {
    $inject = ['title'=>'Login', 'body'=>''];
    if(!empty($_POST['login_email']) && !empty($_POST['login_password'])) {
        [$error, $userid] = getUser($_POST['login_email'], $_POST['login_password']);
        if($userid) {
            $_SESSION['userid'] = $userid;
            $inject['redirect'] = 'profile.php';
            $inject['success'] = '<span>Logged in!</span>';
        } else {
            $inject['body'] = getLoginForm($error);
        }
    } else {
        $inject['body'] = getLoginForm();
    }
    return $inject;
}

function getUser($email,$password) {
    //in actual use case encryption is necessary, because of time limit we won't do
    $statement = $GLOBALS['conn']->prepare("SELECT userID FROM user AS u WHERE u.email = ? AND u.password = ?");
    $statement->bind_param('ss', $email, $password);
    $statement->execute();
    $res = $statement->get_result();
    $value = $res->fetch_assoc();
    if(isset($value['userID'])) {
        return [NULL, $value['userID']];
    } else {
        return ['No user found with those details.', NULL];
    }
}

function getLoginForm($error = '') {
    return '<div>
        <form action="" method="post">
            <div> 
                <label for="login_email">Email address</label>
                <input type="email" id="login_email" name="login_email" aria-describedby="emailHelp" required>
            </div>
            <div> 
                <label for="login_password">Password</label>
                <input type="password" id="login_password" name="login_password" required>
            </div>
            <button type="submit">Submit</button>
        </form>
        <div><p>'. $error .'</p></div>
    </div>';
}
?>