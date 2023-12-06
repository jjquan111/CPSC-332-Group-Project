<?php
require_once('../base.php');
$conn =  new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database'], $GLOBALS['port']);
$inject = [
    'title' => 'Log In or Register',
    'body' => ''
];
if(isset($_SESSION['userid'])) {
    [$error,$userinfo] = getUserInfo($_SESSION['userid']);
    if($error) {
        $inject['warning'] = $error;
    }
    $inject['body'] = printUserInfo($userinfo);
}else {
    header('Redirect: 2;url=' . $GLOBALS['rootpath'] . '/auth');
}
printMain($inject);
$conn->close();

function getUserInfo($id) {
    try {
        $statement = $GLOBALS['conn']->prepare('SELECT u.userID, u.email, u.Fname, u.Lname, u.phoneNum, u.institution FROM user as u WHERE u.userID = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result->fetch_assoc();
        if(isset($row['userID'])) {
            return [NULL, $row];
        } else {
            return ['User info not found. Try reloading or signing out and back in. ' . $statement->error, NULL];
        }
    } catch(Exception $e) {
        return ['Failed to find user' . $e, NULL];
    }
}

function printUserInfo($userinfo) {
    return '<div class="container justify-content-md-center">
    <h4>User Profile</h4>
        <p>Email: ' . issetor($userinfo['email']) . '
        <p>Name: ' . issetor($userinfo['Fname']) . ' ' . issetor($userinfo['Lname']) . '
        <p>User ID: ' . issetor($userinfo['userID']) . '
        <p>Phone Number: ' . issetor($userinfo['phoneNum']) . '
</div>';
}
?>