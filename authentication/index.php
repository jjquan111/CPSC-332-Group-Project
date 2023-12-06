<?php
//Require base.php & any login/register modules
require_once('../base.php');
require_once('login.php');
require_once('register.php');
//establish databse connection
//$connection = new mysqli(params)

$inject = [
    'title' => 'Log In or Register'
];

if(isset($_SESSION['userid'])) {
    $error = '<span>Already logged in! Switching to profile';
    $inject['redirect'] = 'profile.php';
} else {
    //Grab login form & register form then inject them
    $loginform=loginUser();
    $registerform=registerUser();

    $inject['body'] = '<div class="row">
        <div class="col">' .
            issetor($loginform['body']) .
        '</div>
        <div class="col">' .
            issetor($registerform['body']) .
        '</div>
    </div>';
}

if(isset($inject['redirect'])) {
    header('Refresh:3;url=' . $inject['redirect']);
} else if(isset($loginform['redirect'])) {
    header('Refresh:3;url=' . $loginform['redirect']);
}else if (isset($registerform['redirect'])) {
    header('Refresh:3;url=' . $registerform['redirect']);
}
//If Register or Login are complete redirect to those

$inject['success'] = issetor($loginform['success']) . issetor($registerform['success']);
$inject['warning'] = issetor($errror);

printMain($inject)

?>